<?php

namespace App\Http\Controllers;
use App\Models\Tramite;
use App\Models\Dependencia;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use PHPUnit\Metadata\Api\Dependencies;
use Illuminate\Support\Facades\Auth;

class TramitesController extends Controller
{
    public function index(){
        return view('tramites');
     }

    public function store(Request $request){
    Log::debug($request['id']); 
    $tramite = new tramite;    
    $tramite->id_dependencia = $request['id_dependencia'];
    $tramite->id_area = $request['id_area'];
    $tramite->descripcion = $request['descripcion'];
    $tramite->domicilio = $request['domicilio'];
    $tramite->estatus = 1;        
    $tramite->save();
   //Log::debug($tramite);
    
    return response()->json($tramite);
}
public function guardarDatos(Request $request)
{
    Log::debug($request['id_oficina']); 
    // $response = Http::post('http://localhost:80/citas-en-linea-mvc/public/api/tramites', [
        $apiUrl = url('/api/tramites');
        $response = Http::post($apiUrl, [
        'id_dependencia' => $request->input('id_dependencia'),
        'id_area' => $request->input('id_area'),
        'descripcion' => $request->input('descripcion'),
        'domicilio' => $request->input('domicilio'),
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
public function mostrarFormu()
{
    if (Auth::check() && (Auth::user()->id_roles == 1 || Auth::user()->id_roles == 2)) {
        $user = Auth::user();
        
    $userRole = Auth::user()->rol_id;
    if ($userRole == 1) {
        $dependencias = Dependencia::all();
        $areas = Area::all();
    } else {
        $userDependencia = Auth::user()->id_dependencia;
        $dependencias = Dependencia::all();
        $areas = Area::where('id_dependencia', $userDependencia)->get();
    }

    return view('tramites', compact('dependencias', 'areas'));   
} else {
    return redirect()->route('login');
} 
}


public function obtenerAreasPorDependencia(Request $request) {
    $selectedValue = $request->input('selectedValue');
    $userRole = Auth::user()->id_roles;

    // Si el usuario tiene el rol 1, traer todas las áreas
    if ($userRole == 1) {
        $areas = Area::where('id_dependencia', $selectedValue)->get();
    } else {
        // Si el usuario no tiene el rol 1, traer solo las áreas asociadas a su dependencia
        $userDependencia = Auth::user()->id_dependencia;
        $areas = Area::where('id_dependencia', $userDependencia)->get();
    }

    return response()->json($areas);
}


    public function obtenerTodos() {
        
        $datos = Dependencia::all();
        Log::debug($datos); 
        return response()->json($datos);
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
}
