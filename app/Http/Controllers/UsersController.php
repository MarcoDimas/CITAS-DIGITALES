<?php

namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Models\Dependencia;
use App\Models\Area;
use App\Models\Roles;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index()
    {    
        $usuarios = Usuario::all();
        return view('usuarios',  compact('usuarios'));
    }

    public function mostrarForma(){

        if (Auth::check() && (Auth::user()->id_roles == 1 || Auth::user()->id_roles == 2)) {
            $user = Auth::user();

        $dependencias = Dependencia::orderBy('id')->get();

        $roles = Roles::orderBy('id')->get();

        return view('usuarios', compact('dependencias', 'roles'));
    } else {
        return redirect()->route('login');
    }    
} 
public function obtenerDatosFiltrados(Request $request) {
    $selectedValue = $request->input('selectedValue');

    // Realizar la consulta con el filtro where
    $datosFiltrados = Area::all();
    //Log::debug($datosFiltrados); 
    $datosFiltrados = Area::where('id_dependencia', $selectedValue)->get();

    // Devolver los datos en formato JSON
    return response()->json($datosFiltrados);
}
public function store(Request $request){

    
    
  //  Log::debug($request['id_dependencia']); 
  $usuario = new Usuario;
  $usuario->name = $request['name'];
  $usuario->email = $request['email'];
  $usuario->password = Hash::make($request->input('password'));
  $usuario->id_dependencia = $request['id_dependencia'];
  $usuario->id_roles = $request['id_roles'];
  $usuario->estatus = 1;
  $usuario->save();
  // dd($save);
    //$usuario->save();
   Log::debug($usuario);
    
    return response()->json($usuario);
}
public function guarDatos(Request $request)
{
    
    //dd($request->all());
    Log::debug($request['id_dependencia']); 
    //$response = Http::post('http://localhost:80/citas-en-linea-mvc/public/api/usuarios', [
        $apiUrl = url('/api/usuarios');
        $response = Http::post($apiUrl, [
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => $request->input('password'),
        'id_dependencia' => $request->input('id_dependencia'),
        'estatus' => $request->input('estatus'),
        'id_roles' => $request->input('id_roles'),
    ]);

    // Puedes verificar la respuesta de la API y realizar acciones adicionales si es necesario
    if ($response->successful()) {
        return redirect()->back()->with('success', 'Datos guardados correctamente')->with('reload', true);
    } else {
        return redirect()->back()->with('error', 'Error al guardar datos')->with('reload', true);
        
    }
}
}
