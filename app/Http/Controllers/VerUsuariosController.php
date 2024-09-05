<?php

namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class VerUsuariosController extends Controller
{
    public function index()
    {    
        if (Auth::check() && (Auth::user()->id_roles == 1 || Auth::user()->id_roles == 2)) {
            $user = Auth::user();
    
            // Obtener el rol del usuario actual
            $userRole = Auth::user()->id_roles;
    
            // Si el usuario tiene rol igual a 1, mostrar todos los usuarios sin filtrar
            if ($userRole == 1) {
                $usersWithDependencias = DB::table('users')
                    ->join('dependencia', 'users.id_dependencia', '=', 'dependencia.id')
                    ->join('roles', 'users.id_roles', '=', 'roles.id')
                    ->select(
                        'users.*', 
                        'dependencia.descripcion as dependencia_descripcion',
                        'roles.nombre as roles_descripcion' 
                    )
                    ->get();
            } else {
                // Obtener la dependencia asociada al usuario actual
                $userDependencia = Auth::user()->id_dependencia;
    
                // Filtrar los usuarios por la dependencia del usuario
                $usersWithDependencias = DB::table('users')
                    ->join('dependencia', 'users.id_dependencia', '=', 'dependencia.id')
                    ->join('roles', 'users.id_roles', '=', 'roles.id')
                    ->select(
                        'users.*', 
                        'dependencia.descripcion as dependencia_descripcion',
                        'roles.nombre as roles_descripcion' 
                    )
                    ->where('users.id_dependencia', $userDependencia)
                    ->get();
            }
    
            return view('vusuarios', compact('usersWithDependencias'));
        } else {
            return redirect()->route('login');
        } 
    }
    
public function actualizarPassword(Request $request, $id)
{
    $vusuario = Usuario::findOrFail($id);
    $vusuario->password = bcrypt($request->password);
    $vusuario->save();

    return redirect()->back()->with('success', 'Contraseña actualizada exitosamente.')->with('reload', true);
}
public function desactivar($id)
{
    $vusuario = Usuario::findOrFail($id);
    $vusuario->estatus = false; // Establecer estatus a false para desactivar el usuario
    $vusuario->save();

    return redirect()->back()->with('success', 'Usuario desactivado exitosamente.')->with('reload', true);
}
}
