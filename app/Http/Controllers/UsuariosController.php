<?php

namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Models\Tramite;
use App\Models\Subtramite;
use App\Models\Cita;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller
        {
            public function index()
            {    
                // Obtener el rol del usuario actual
                $userRole = Auth::user()->id_roles;
            
                // Si el usuario tiene rol igual a 1, mostrar todos los registros sin filtrar
                if ($userRole == 1) {
                    $citas = Cita::all();
                } else {
                    // Obtener la dependencia asociada al usuario actual
                    $userDependencia = Auth::user()->id_dependencia;
            
                    // Filtrar los datos de la tabla de citas por la dependencia del usuario
                    $citas = Cita::whereHas('tramite.area.dependencia', function ($query) use ($userDependencia) {
                        $query->where('id', $userDependencia);
                    })->with('tramite.area', 'subtramite')->get();
                    
                }
                // Obtener las demás relaciones necesarias
                $usersWithProfilesAndOrders = DB::table('cita')
                    ->join('tramite', 'cita.id_tramite', '=', 'tramite.id')
                    ->join('subtramite', 'cita.id_subtramite', '=', 'subtramite.id')
                    ->join('area', 'tramite.id_area', '=', 'area.id')  // Nuevo join con la tabla 'areas'
                    ->select(
                        'cita.*',
                        'tramite.descripcion as tramite_descripcion',
                        'subtramite.descripcion as subtramite_descripcion',
                        'area.descripcion as area_nombre'  // Selecciona el nombre del área
                    )
                    ->get();
            
                return view('users', compact('citas', 'usersWithProfilesAndOrders'));
            }
        public function actualizarEstatus(Request $request, $id)
        {
            $cita = Cita::find($id);
        
            if (!$cita) {
                return redirect()->back()->with('error', 'Registro no encontrado');
            }
        
            // Guarda el estado actual de la cita
            $estadoAnterior = $cita->estatus;
        
            // Actualiza el estado de la cita
            $cita->estatus = !$cita->estatus;
        
            $cita->save();
        
            $correoUsuario = $cita->email;
        
            // Construye el mensaje de correo dependiendo del cambio de estado de la cita
            $mensaje = $estadoAnterior ? 'Su cita ha sido atendida.' : 'Su cita no ha sido atendida.';
        
            // Obtiene la fecha actual en el huso horario local
            $fechaActual = Carbon::now()->format('Y-m-d');
        
            // Envía el correo con la vista de detalle_cita
            Mail::send('detalle_cita', [
                'cita' => $cita,
                'mensaje' => $mensaje,
                'estadoAnterior' => $estadoAnterior,
                'fechaActual' => $fechaActual,
            ], function ($message) use ($correoUsuario) {
                $message->to($correoUsuario)->subject('Estado de su cita');
            });
        
            return redirect()->back()->with('success', 'Estatus cambiado correctamente y correo enviado')->with('reload', true);    
        }
/*public function eliminar($id)
{
    $cita = Cita::find($id);

    if ($cita) {
        $cita->delete();
        return redirect()->route('users')->with('success', 'Registro eliminado correctamente');
    } else {
        return redirect()->route('users')->with('error', 'La cita no existe o ya ha sido eliminada');
    }
}*/
public function cancelarCita($id) {
    $cita = Cita::findOrFail($id);
    $cita->cancelada = true; // Establece el campo cancelada en true
    $cita->save();

    return redirect()->back()->with('success', 'La cita ha sido cancelada correctamente.')->with('reload', true);
}


    
}