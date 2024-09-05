<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Cita;
use App\Models\Dependencia;
use App\Models\Disponibilidad;
use App\Models\Fecha;
use App\Models\Horario;
use App\Models\Subtramite;
use App\Models\Tramite;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\CorreoCitaRegistrada;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Validator;

class CalendariosController extends Controller
{
    
    
    public function index(){
       $folio = rand(100000, 99999999);
        $data = [
         'folio' => $folio,
        ];

        $encryptedData = $this->encrypt_decrypt('encrypt', json_encode($data), "");
                return redirect('calendarios', ['solicitud'=> $encryptedData]);        
     } 

    public function obtenerDatosFiltradoss(Request $request)
    {
        $selectedValue = $request->input('selectedValue');

        // Realizar la consulta con el filtro where
        $datosFiltrados = Subtramite::all();
        //Log::debug($datosFiltrados);
        $datosFiltrados = Subtramite::where('id_tramite', $selectedValue)->get();

        // Devolver los datos en formato JSON
        return response()->json($datosFiltrados);
    }

    public function obtenerDatosFiltradosstr(Request $request)
    {
        $selectedValue = $request->input('selectedValue');

        // Realizar la consulta con el filtro where
        $datosFiltrados = Subtramite::all();
        //Log::debug($datosFiltrados);
        $datosFiltrados = Subtramite::where('id_tramite', $selectedValue)->get();

        // Devolver los datos en formato JSON
        return response()->json($datosFiltrados);
    }
    function encrypt_decrypt($action, $string, $concepto)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = "citasEnLinea";
        $secret_iv = "Citas_LineaService.2023";
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
    

    public function mostrarFormula($solicitud = null)
    {
        $data = [];
        $subtramites = [];
        $folio = null;
        $consultaCita = null;
    
        // Obtener el usuario actual, su dependencia y rol
        $usuario = auth()->user();
        $dependenciaUsuario = $usuario->id_dependencia;
        $rolUsuario = $usuario->id_roles;
    
        if ($solicitud != null) {
            $data = json_decode(base64_decode($solicitud), true); // Desencriptar usando base64_decode
            
            if ($data != null) {
                if (!isset($data['folio'])) {
                    return redirect()->route("calendarios")->with('error', 'Folio no disponible o incorrecto.');
                }
    
                $folio = $data['folio'];
    
                // Filtrar subtramites basados en el rol y la dependencia
                if ($rolUsuario == 1) { // Si el usuario tiene rol 1 (administrador)
                    $subtramites = Subtramite::where("id", $data['id_subtramite'])
                        ->where("id_tramite", $data['id_tramite'])
                        ->get();
                } else { // Filtrar subtramites asociados a la dependencia del usuario
                    $subtramites = Subtramite::where("id", $data['id_subtramite'])
                        ->where("id_tramite", $data['id_tramite'])
                        ->whereHas('tramite.dependencia', function($query) use ($dependenciaUsuario) {
                            $query->where('id', $dependenciaUsuario);
                        })
                        ->get();
                }
    
                if (count($subtramites) == 0) {
                    return redirect()->route("calendarios");
                }
    
                $consultaCita = Cita::where("id_subtramite", $data['id_subtramite'])
                    ->where("id_tramite", $data['id_tramite'])
                    ->where("folio", $folio)
                    ->first();
    
                if ($consultaCita != null) {
                    $consultaCita = $consultaCita->toArray();
                }
            } else {
                return redirect()->route("calendarios")->with('error', '⚠️ FOLIO NO DISPONIBLE O INCORRECTO ⚠️');
            }
        } else {
            // Si no hay solicitud, generar un folio aleatorio disponible
            $folio = $this->generarFolioDisponible();
        }
    
        $fechaInicial = date("Y-m-d");
        $horasEnRango = $this->obtenerHorasEnRangoFromFecha($fechaInicial, count($data) == 0 ? 4 : ($data['id_subtramite'] ?? 4));
    
        // Filtrar trámites basados en el rol y la dependencia
        if ($rolUsuario == 1) { // Si el usuario tiene rol 1 (administrador)
            $tramites = Tramite::all();
        } else { // Filtrar tramites asociados a la dependencia del usuario
            $tramites = Tramite::whereHas('dependencia', function($query) use ($dependenciaUsuario) {
                $query->where('id', $dependenciaUsuario);
            })->get();
        }
    
        $dependencias = Dependencia::orderBy('descripcion')->get();
        $horarios = Horario::orderBy('id')->get();
        $disponibilidades = Disponibilidad::all();
    
        return view('calendarios', compact('dependencias', 'tramites', 'horarios', 'disponibilidades', "horasEnRango", "data", "subtramites", "solicitud", "folio", "consultaCita"));
    }
    
    private function generarFolioDisponible()
    {
        do {
            $folio = rand(100000, 999999); // Generar un número aleatorio de 6 dígitos
            $exists = Cita::where('folio', $folio)->exists(); // Verificar si ya existe
        } while ($exists);
    
        return $folio; // Retorna el folio generado
    }
            public function getHoras(Request $request)
    {

        if ($request->ajax()) {
            return $this->obtenerHorasEnRangoFromFecha($request->fecha, $request->id_subtramite);
        }
    }

    public function obtenerHorasDisponibles(Request $request)
    {

        // Aquí debes implementar la lógica para obtener las horas disponibles

        $fechaSeleccionada = $request->input('fecha');

        // Simplemente como ejemplo, devuelvo un arreglo de horas disponibles
        $horasDisponibles = ['09:00', '10:00', '11:00', '14:00', '15:00'];

        return response()->json($horasDisponibles);
    }

    public function obtenerHorasEnRango($fechaInicial, $horaInicial, $fechaFinal, $horaFinal)
    {
        $horaActual = Carbon::parse("$fechaInicial $horaInicial");
        $horaFinal = Carbon::parse("$fechaFinal $horaFinal");

        $horasDisponibles = [];

        while ($horaActual <= $horaFinal) {
            $horasDisponibles[] = $horaActual->format('H:i');
            $horaActual->addMinutes(30);
        }

        return $horasDisponibles;
    }

    public function obtenerHorasEnRangoFromFecha($fechaEntrada, $subtramite)
    {
        $registrosEnRango = Disponibilidad::whereDate('fecha_inicio', '<=', $fechaEntrada)
            ->whereDate('fecha_fin', '>=', $fechaEntrada)
            ->where("id_subtramite", $subtramite)
            ->first();
          //  Log::debug($registrosEnRango);
        if ($registrosEnRango) {
    
            $fechaInicial = $fechaEntrada;
            $horaInicial = $registrosEnRango->horario_inicio;
            $fechaFinal = $fechaEntrada;
            $horaFinal = $registrosEnRango->horario_fin;
            $horaActual = Carbon::parse("$fechaInicial $horaInicial");
            $horaFinal = Carbon::parse("$fechaFinal $horaFinal");
    
            $horasDisponibles = [];
    
            while ($horaActual <= $horaFinal) {
                $hora= $horaActual->format('H:i');
                $horaActual->addMinutes($registrosEnRango->duracion);
            
                if (count($this->validateFecha($subtramite, $fechaEntrada, $hora)) == 0) {
                    $hoy = Carbon::now()->toDateString();
                    $fechaAComparar = Carbon::parse($fechaEntrada)->toDateString();
                
                    if ($fechaAComparar == $hoy) {
                        //$horaActualHoy = Carbon::now()->format('H:i');
                
                        // Obtén la hora que deseas comparar (puedes obtenerla de tu modelo, base de datos, etc.)
                      //  $horaAComparar = Carbon::parse($hora)->format('H:i');
                             $zonaHoraria = 'America/Mexico_City'; // Reemplaza con tu zona horaria deseada
                            $horaActualHoy = Carbon::now()->setTimezone($zonaHoraria)->format('H:i');
                            //dd($horaActual);
                                                //$horaActualHoy = Carbon::now()->format('H:i');
                            $horaAComparar = Carbon::parse($hora)->format('H:i');
                        if ($horaActualHoy <= $horaAComparar) {
                            $horasDisponibles[] = $hora;
                            // Log para verificar que se agregó correctamente
                           
                        } else {
                            // Log para verificar el flujo de control
                            Log::info("Fecha/hora actual hoy: " . Carbon::now()->format('Y-m-d H:i:s'));
Log::info("Fecha/hora a comparar: " . Carbon::parse($hora)->format('Y-m-d H:i:s'));
                            Log::debug("La hora no se agregó porque es anterior a la hora actual");
                            
                        }
                    } else {
                        // Si la fecha no es hoy, simplemente agrega la hora a las disponibles
                        $horasDisponibles[] = $hora;
                        // Log para verificar que se agregó correctamente
                        Log::info("Hora agregada: " . $hora);
                    }
                }               
            }
            return $horasDisponibles;
        } else {
            return ["error" => "No disponible"];
        }
    }
        private function validateFecha($subtramite,$fechaEntrada,$hora){
           DB::enableQueryLog();
                $cita = Cita::where("id_subtramite", $subtramite)
                    ->where("fecha", $fechaEntrada)
                    ->where("horario", $hora)
                    ->get(); 
         
          // Log::debug(DB::getQueryLog());
           return $cita;
        }
        private function citaExistente(){

        }
    public function store(Request $request)
    {
        try{
        $cita = new Cita;
        $cita->id_tramite = $request['id_tramite'];
        $cita->id_subtramite = $request['id_subtramite'];
        $cita->nombre = $request['nombre'];
        $cita->ape_paterno = $request['ape_paterno'];
        $cita->ape_materno = $request['ape_materno'];
        $cita->rfc = $request['rfc'];
        $cita->email = $request['email'];
        $cita->telefono = $request['telefono'];
        $cita->fecha = $request['fecha'];
        $cita->horario = $request['horario'];
        $cita->estatus = 1;
        $cita->save();
        //Log::debug($cita);       

        return response()->json($cita);
        }catch(Exception $e){
            Log::debug($e->getMessage());
        }
      
    }
    
    public function guardarDatoscit(Request $request)
    {

        $usuario = auth()->user();
        $rolUsuario = $usuario->id_roles;

        $validator = Validator::make($request->all(), [
            'horario' => 'nullable|date_format:H:i', // Asegura que 'horario' sea un formato de hora válido
            'telefono' => 'required|numeric|digits:10',
            'email' => 'required|email|regex:/^.+@.+\..+$/i',
            'nombre' => 'required|regex:/^[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]+$/u',
            'ape_paterno' => 'required|regex:/^[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]+$/u',
            'ape_materno' => 'required|regex:/^[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]+$/u',
            'rfc' => 'required',
            'id_tramite' => 'required',
            'id_subtramite' => 'required',
        ], [
            'horario.date_format' => 'Horario debe ser obligatorio.',
            'telefono.required' => ' El telefono es obligatorio.',
            'telefono.numeric' => 'El telefono debe ser un número.',
            'telefono.digits' => 'El telefono debe tener :digits dígitos.',
            'email.required' => 'Correo Electrónico es obligatorio.',
            'email.email' => 'Correo Electrónico debe ser una dirección de correo electrónico válida.',
            'email.regex' => 'Correo Electrónico no cumple con el formato esperado.',
            'nombre.required' => 'Nombre debe ser obligatorio.',
            'nombre.regex' => 'Nombre solo puede contener letras, números y espacios.',
            'ape_paterno.required' => 'Apellido Paterno debe ser obligatorio.',
            'ape_paterno.regex' => 'Apellido Paterno solo puede contener letras, números y espacios.',
            'ape_materno.required' => 'Apellido Materno debe ser obligatorio.',
            'ape_materno.regex' => 'Apellido Materno solo puede contener letras, números y espacios.',
            'rfc.required' => 'El RFC debe ser obligatorio.',
            'id_tramite.required' => 'Trámite debe ser obligatorio.',
            'id_subtramite.required' => 'Subtrámite debe ser obligatorio.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $datos = [
            '_token' => csrf_token(),
            'id_tramite' => $request->input('id_tramite'),
            'id_subtramite' => $request->input('id_subtramite'),
            'nombre' => $request->input('nombre'),
            'ape_paterno' => $request->input('ape_paterno'),
            'ape_materno' => $request->input('ape_materno'),
            'rfc' => $request->input('rfc'),
            'email' => $request->input('email'),
            'telefono' => $request->input('telefono'),
            'fecha' => $request->input('fecha'),
            'horario' => $request->input('horario'),
            'estatus' => $request->input('estatus') ?? 1,
        ];
        if ($request->exists('solicitud') && $request->solicitud != null) {
            $data = json_decode($this->encrypt_decrypt('decrypt', $request->solicitud, ''), true);
            if ($data != null) {
                // Asegúrate de asignar el folio desde los datos desencriptados
                $datos['folio'] = $data['folio'] ?? $this->generarFolioDisponible();
        
                $subtramites = Subtramite::where('id', $request->id_subtramite)
                    ->where('id_tramite', $data['id_tramite'])
                    ->get();
        
                if (count($subtramites) == 0) {
                    return redirect()->back()->withInput()->withErrors(['error' => 'Subtrámite no válido.']);
                }
            }
        }
        
        // Se mueve la asignación de folio según el rol fuera del bloque anterior
        if ($rolUsuario == 1) { // Si el usuario tiene rol 1 (administrador)
            $datos['folio'] = $this->generarFolioDisponible();
        } else {
            $datos['folio'] = $this->generarFolioDisponible();

        }
        
        // Verificar si la cita ya está registrada
        $citaExistente = Cita::where('id_subtramite', $request->input('id_subtramite'))
            ->where('fecha', $request->input('fecha'))
            ->where('horario', $request->input('horario'))
            ->exists();
    
        if ($citaExistente) {
            return redirect()->back()->with('error', 'La cita ya está registrada.');
        }
        log::debug('datos recibidos:', $datos); 
        // Guardar la nueva cita en la base de datos solo si no está registrada
        $nuevaCita = Cita::create($datos);

        if ($nuevaCita) {
            // Disparar el evento CitaRegistrada
            event(new \App\Events\CitaRegistrada($nuevaCita));
        
            $tramite = Tramite::find($request->input('id_tramite'));
            $subtramite = Subtramite::find($request->input('id_subtramite'));
        
            $datos['tramite_descripcion'] = $tramite ? $tramite->descripcion : 'No se encontró el trámite';
            $datos['subtramite_descripcion'] = $subtramite ? $subtramite->descripcion : 'No se encontró el subtrámite';
        
            // Obtener los requisitos antes de enviar el correo electrónico
            $subtramite = Subtramite::find($datos['id_subtramite']);
            $requisitos = $subtramite ? $subtramite->requisitos : [];
        
            // Envío de correo electrónico
            Mail::to($datos['email'])->send(new CorreoCitaRegistrada($nuevaCita, $datos, $requisitos));

            session(['cita_id' => $nuevaCita->id]);

        
            // Generar contenido PDF
        //     $pdfContent = view('Reservacionpdf', compact('datos', 'nuevaCita', 'requisitos'))->render();

        // // Configurar las opciones para Dompdf
        // $options = new Options();
        // $options->set('isHtml5ParserEnabled', true);
        // $options->set('isPhpEnabled', true); // Habilita el uso de PHP en las vistas
        // $options->set('isRemoteEnabled', true); // Habilita la carga de imágenes remotas
        
        // // Crear una instancia de Dompdf con las opciones
        // $dompdf = new Dompdf($options);

        // $dompdf->setBasePath(public_path());
        // // Cargar el contenido HTML al Dompdf
        // $dompdf->loadHtml($pdfContent);

        // // Renderizar el PDF
        // $dompdf->render();

        // // Nombre del archivo PDF
        // $nombreArchivo = 'cita_' . $nuevaCita->id . '.pdf';

        // // Guardar el PDF en la carpeta de almacenamiento
        // $dompdf->stream($nombreArchivo, ['Attachment' => true]);
        
        // Redirigir a la página anterior con un mensaje de éxito
        return redirect()->route('menuPrincipal')->with('success', 'Datos guardados con éxito.');
    } else {
        return redirect()->back()->with('error', 'Error al guardar datos');
    }

}
public function generarPdf()
{
    $citaId = session('cita_id');

    if (!$citaId) {
        return redirect()->route('menuPrincipal')->with('error', 'No se encontró la cita.');
    }

    $cita = Cita::find($citaId);

    if (!$cita) {
        return redirect()->route('menuPrincipal')->with('error', 'Cita no encontrada.');
    }

    $subtramite = Subtramite::find($cita->id_subtramite);
    $requisitos = $subtramite ? $subtramite->requisitos : '';

    if (is_string($requisitos)) {
        $requisitosDecoded = json_decode($requisitos, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($requisitosDecoded)) {
            $requisitos = $requisitosDecoded;
        } else {
            $requisitos = array_map('trim', explode(',', $requisitos));
        }
    }
    $datos = [
        'cita' => $cita,
        'tramite_descripcion' => $cita->tramite->descripcion ?? 'No se encontró el trámite',
        'subtramite_descripcion' => $cita->subtramite->descripcion ?? 'No se encontró el subtrámite',
        'requisitos' => $requisitos,
    ];

    try {
        $pdfContent = view('Reservacionpdf', compact('datos'))->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->setBasePath(public_path());
        $dompdf->loadHtml($pdfContent);
        $dompdf->render();

        $nombreArchivo = 'cita_' . $cita->id . '.pdf';

        // Solo retorna una vez con los headers correctos
        return $dompdf->stream($nombreArchivo, ['Attachment' => true]);
    } catch (\Exception $e) {
        Log::error('Error al generar el PDF: ' . $e->getMessage());
        return redirect()->route('menuPrincipal')->with('error', 'Error al generar el PDF.');
    }
}

}
