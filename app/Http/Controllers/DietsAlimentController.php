<?php

namespace App\Http\Controllers;

use App\Models\DietsAliment;
use App\Models\Diet;
use App\Models\Aliment;
use Illuminate\Http\Request;

class DietsAlimentController extends Controller
{
    public function index()
    {
        // Obtener todos los registros de la tabla intermedia
        $dietsAliments = DietsAliment::with(['diet', 'aliment'])->get();
        return view('diets_aliments.index', compact('dietsAliments'));
    }

    public function create()
    {
        // Obtener todas las dietas y los alimentos para poder asociarlos
        $diets = Diet::all();
        $aliments = Aliment::all();
        return view('diets_aliments.create', compact('diets', 'aliments'));
    }

    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'id_dieta' => 'required|exists:diets,id',
            'id_alimento' => 'required|exists:aliments,id',
        ]);

        // Crear una nueva relación en la tabla intermedia
        DietsAliment::create($request->all());

        return redirect()->route('diets_aliments.index')->with('success', 'Alimento agregado a la dieta con éxito.');
    }

    public function destroy(DietsAliment $dietsAliment)
    {
        // Eliminar la relación de la tabla intermedia
        $dietsAliment->delete();

        return redirect()->route('diets_aliments.index')->with('success', 'Alimento eliminado de la dieta correctamente.');
    }
}
