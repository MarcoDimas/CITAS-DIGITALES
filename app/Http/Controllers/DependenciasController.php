<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Dependencia;
use Illuminate\Support\Facades\Auth;

class DependenciasController extends Controller
{
    public function index(){
        if (Auth::check() && Auth::user()->id_roles == 1) {
            $user = Auth::user();

        $dependencia = Dependencia::all();
        return view('dependencias', compact('dependencia'));
    } else {
        return redirect()->route('login');
    }
     }     

     public function store(Request $request){
        Log::debug($request['id']); 
        $dependencia = new dependencia;
        $dependencia->descripcion = $request['descripcion'];
        $dependencia->estatus = 1;
        $dependencia->save();
        Log::debug($dependencia);

        return response()->json($dependencia);
    }

    public function guardaDatos(Request $request)
    {
        // $response = Http::post('http://localhost:80/citas-en-linea-mvc/public/api/dependencias', [
            //$apiUrl = secure_url('/api/dependencias');
           $apiUrl = url('/api/dependencias');                       
            $response = Http::post($apiUrl, [
            'descripcion' => $request->input('descripcion'),
            'estatus' => $request->input('estatus'),
            // Agrega más campos según sea necesario
        ]);
        Log::debug($response); 

        // Puedes verificar la respuesta de la API y realizar acciones adicionales si es necesario
        if ($response->successful()) {

            return redirect()->back()->with('success', 'Datos guardados correctamente')->with('reload', true);
        } else {
            return redirect()->back()->with('error', 'Error al guardar datos')->with('reload', true);
        }
    }

    
}

