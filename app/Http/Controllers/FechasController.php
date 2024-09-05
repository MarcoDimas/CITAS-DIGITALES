<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Subtramite;
use App\Models\Fecha;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class FechasController extends Controller
{
    public function index(){
        return view('fechas');        
     }

     public function mostrarFormulariossa()
     {
        if (Auth::check() && (Auth::user()->id_roles == 1 || Auth::user()->id_roles == 2)) {
            $user = Auth::user();

        $userRole = Auth::user()->id_roles;
     
         // Si el usuario tiene el rol 1, mostrar todos los subtrámites
         if ($userRole == 1) {
             $subtramites = Subtramite::orderBy('descripcion')->get();
         } else {
             // Obtener los subtrámites asociados a la dependencia del usuario
             $subtramites = Subtramite::whereHas('tramite.area.dependencia.users', function ($query) {
                 $query->where('id', Auth::user()->id);
             })->orderBy('descripcion')->get();
         }
     
         return view('fechas', compact('subtramites'));    
        } else {
            return redirect()->route('login');
        }
     }
     

    public function store(Request $request){
        //Log::debug($request['id_subtramite']); 
        $fecha = new Fecha();
        $fecha->id_subtramite = $request['id_subtramite'];
        $fecha->fecha_inicio = $request['fecha_inicio'];
        $fecha->fecha_fin = $request['fecha_fin'];
        $fecha->horario_inicio = $request['horario_inicio'];
        $fecha->horario_fin = $request['horario_fin'];
        $fecha->duracion = $request['duracion'];
        $fecha->holgura = $request['holgura'];
        $fecha->personas = $request['personas'];
        $fecha->estatus = 1;                
        $fecha->save();
       //Log::debug($tramite);
        
        return response()->json($fecha);
    }
    public function guardarDatosfech(Request $request)
{
    $id_subtramite = $request->input('id_subtramite');
    $fecha_inicio = $request->input('fecha_inicio');
    $fecha_fin = $request->input('fecha_fin');

    // Verificar si ya existe un registro con los mismos valores
    $exists = Fecha::where('id_subtramite', $id_subtramite)
    ->where('fecha_inicio', $fecha_inicio)
    ->where('fecha_fin', $fecha_fin)
    ->exists();

    // Si ya existe un registro con las mismas fechas, manejar el error
    if ($exists) {
        return redirect()->back()->with('error', 'Error al guardar datos. Las fechas ya están registradas.');
    }


    $apiUrl = url('/api/fechas');
    $response = Http::post($apiUrl, [
        'id_subtramite' => $request->input('id_subtramite'),
        'fecha_inicio' => $request->input('fecha_inicio'),
        'fecha_fin' => $request->input('fecha_fin'),
        'horario_inicio' => $request->input('horario_inicio'),
        'horario_fin' => $request->input('horario_fin'),
        'duracion' => $request->input('duracion'),
        'holgura' => $request->input('holgura'),
        'personas' => $request->input('personas'),
        'estatus' => $request->input('estatus'),
        // Agrega más campos según sea necesario
    ]);

    // Puedes verificar la respuesta de la API y realizar acciones adicionales si es necesario
    if ($response->successful()) {
        return redirect()->back()->with('success', 'Datos guardados correctamente')->with('reload', true);
    } else {
        return redirect()->back()->with('error', 'Error al guardar datos')->with('reload', true);
    }  
}
}