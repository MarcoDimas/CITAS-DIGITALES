<?php

namespace App\Http\Controllers;
use App\Models\Subtramite;
use App\Models\Horas;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HorasController extends Controller
{
    public function index(){
        return view('horas');        
     }

     public function mostrarforhor(){

        $subtramites = Subtramite::orderBy('descripcion')->get();
        $subtramites = Subtramite::all();
        return view('horas', compact('subtramites'));            
    }

    public function store(Request $request){
        Log::debug($request['id_subtramite']); 
        $horas = new Horas();
        $horas->id_subtramite = $request['id_subtramite'];
        $horas->horario_inicio = $request['horario_inicio'];
        $horas->horario_fin = $request['horario_fin'];
        $horas->duracion = $request['duracion'];
        $horas->holgura = $request['holgura'];
        $horas->personas = $request['personas'];
        $horas->estatus = 1;                
        $horas->save();
       //Log::debug($tramite);
        
        return response()->json($horas);
    }
    public function guardarDatoshoraa(Request $request)
{
    Log::debug($request['id_subtramite']); 
    $response = Http::post('http://localhost:80/citas-en-linea-mvc/public/api/horas', [
        'id_subtramite' => $request->input('id_subtramite'),
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
        return redirect()->back()->with('success', 'Datos guardados correctamente');
    } else {
        return redirect()->back()->with('error', 'Error al guardar datos');
        
    }
}
}
