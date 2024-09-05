<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Dependencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AreasController extends Controller
{
    public function index()
    {
        // Obtener todas las áreas sin filtrar por dependencia
        $areas = Area::all();

        return view('area', compact('areas'));
    }

   public function store(Request $request)
    {
        // Crear un nuevo registro de área sin asignar ninguna dependencia específica
        $area = new Area;
        $area->descripcion = $request->descripcion;
        $area->estatus = 1;
        $area->save();

        return response()->json($area);
    }

    public function guardaDato(Request $request)
    {
        // Crear un nuevo registro de área asignando la dependencia especificada
        $area = new Area;
        $area->id_dependencia = $request->input('id_dependencia');
        $area->descripcion = $request->input('descripcion');
        $area->estatus = $request->input('estatus', 1); // Valor predeterminado si no se proporciona
    
        // Guardar el área en la base de datos
        if ($area->save()) {
            return redirect()->back()->with('success', 'Datos guardados correctamente')->with('reload', true);
        } else {
            return redirect()->back()->with('error', 'Error al guardar datos')->with('reload', true);
        }
    }
    

    public function mostrarFor()
    {
        if (Auth::check() && (Auth::user()->id_roles == 1 || Auth::user()->id_roles == 2)) {
            $user = Auth::user();

        $dependencias = Dependencia::orderBy('id')->get();
        $dependencias = Dependencia::all();
        return view('area', compact('dependencias'));
    } else {
        return redirect()->route('login');
    }
    }

}
