<?php

namespace App\Http\Controllers;
use App\Models\Subtramite;
use App\Models\Area;
use App\Models\Tramite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SubtramitesController extends Controller
{
    public function index(){
        return view('subtramite');

        
     }
     public function mostrarFormularioss()
{
    if (Auth::check() && (Auth::user()->id_roles == 1 || Auth::user()->id_roles == 2)) {
        $user = Auth::user();

    $userRole = Auth::user()->id_roles;

    // Si el usuario tiene el rol 1, mostrar todos los trámites
    if ($userRole == 1) {
        $tramites = Tramite::orderBy('descripcion')->get();
    } else {
        // Obtener la dependencia asociada al usuario
        $userDependencia = Auth::user()->id_dependencia;
        
        // Obtener las áreas asociadas a la dependencia del usuario
        $areas = Area::where('id_dependencia', $userDependencia)->pluck('id');
     
        // Obtener los trámites asociados a las áreas obtenidas
        $tramites = Tramite::whereIn('id_area', $areas)->orderBy('descripcion')->get();
    }

    return view('subtramite', compact('tramites'));
} else {
    return redirect()->route('login');
}
}

     

    public function store(Request $request){
        Log::debug($request['id_subtramite']); 
        $subtramite = new subtramite;
        $subtramite->id_tramite = $request['id_tramite'];
        $subtramite->descripcion = $request['descripcion'];
        $subtramite->requisitos = $request['requisitos'];
        $subtramite->estatus = 1;                
        $subtramite->save();
       //Log::debug($tramite);
        
        return response()->json($subtramite);
    }

    public function guardarDatosub(Request $request)
{
    Log::debug($request['requisitos']); 
    // $response = Http::post('http://localhost:80/citas-en-linea-mvc/public/api/subtramites', [
        $apiUrl = url('/api/subtramites');
        $response = Http::post($apiUrl, [
        'id_tramite' => $request->input('id_tramite'),
        'descripcion' => $request->input('descripcion'),
        'requisitos' => $request->input('requisitos'),
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
