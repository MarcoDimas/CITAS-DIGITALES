<?php

namespace App\Http\Controllers;
use App\Models\Horas;
use App\Models\Horario;
use App\Models\Fecha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class HorarioController extends Controller
{
    public function index(){
        return view('horario_desglose');        
     }

     public function mostrarhora(){

        $fechas = Fecha::orderBy('id')->get();
        $fechas = Fecha::all();


        return view('horario_desglose', compact('fechas'));
        //var_dump($municipios);
        
    }

    public function store(Request $request){
        Log::debug($request['id_hora']); 
        $horario = new horario;
        $horario->id_fecha = $request['id_fecha'];
        $horario->horario_inicio = $request['horario_inicio'];
        $horario->horario_fin = $request['horario_fin'];
        $horario->duracion = $request['duracion'];
        $horario->estatus = 1;                
        $horario->save();
       //Log::debug($tramite);
        
        return response()->json($horario);
    }

    public function guardarDatohorarios(Request $request)
    {
        Log::debug($request['id_hora']); 
        // $response = Http::post('http://localhost:80/citas-en-linea-mvc/public/api/horarios_desglose', [
            $apiUrl = url('/api/horarios_desglose');
            $response = Http::post($apiUrl, [
            'id_fecha' => $request->input('id_fecha'),
            'horario_inicio' => $request->input('horario_inicio'),
            'horario_fin' => $request->input('horario_fin'),
            'duracion' => $request->input('duracion'),
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
