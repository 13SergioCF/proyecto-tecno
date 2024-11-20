<?php

namespace App\Http\Controllers;

use App\Models\NutritionalsDetail;
use App\Models\Aliment;
use App\Models\Nutrient;
use Illuminate\Http\Request;

class NutritionalsDetailController extends Controller
{
    public function index()
    {
        // Obtener todos los detalles nutricionales (nutritionals_details) y sus relaciones
        $nutritionalsDetails = NutritionalsDetail::with(['aliment', 'nutrient'])->get();
        return view('nutritionals_details.index', compact('nutritionalsDetails'));
    }

    public function create()
    {
        $aliments = Aliment::all(); // Obtener todos los alimentos
        $nutrients = Nutrient::all(); // Obtener todos los nutrientes
        return view('nutritionals_details.create', compact('aliments', 'nutrients'));
    }

    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'id_alimento' => 'required|exists:aliments,id',
            'id_nutriente' => 'required|exists:nutrients,id',
            'cantidad_calorias' => 'required|numeric',
        ]);

        // Crear un nuevo detalle nutricional
        NutritionalsDetail::create($request->all());

        return redirect()->route('nutritionals_details.index')->with('success', 'Detalle nutricional creado con éxito.');
    }

    public function edit(NutritionalsDetail $nutritionalsDetail)
    {
        $aliments = Aliment::all();
        $nutrients = Nutrient::all();
        return view('nutritionals_details.edit', compact('nutritionalsDetail', 'aliments', 'nutrients'));
    }

    public function update(Request $request, NutritionalsDetail $nutritionalsDetail)
    {
        // Validación de los datos del formulario
        $request->validate([
            'id_alimento' => 'required|exists:aliments,id',
            'id_nutriente' => 'required|exists:nutrients,id',
            'cantidad_calorias' => 'required|numeric',
        ]);

        // Actualizar el detalle nutricional
        $nutritionalsDetail->update($request->all());

        return redirect()->route('nutritionals_details.index')->with('success', 'Detalle nutricional actualizado con éxito.');
    }

    public function destroy(NutritionalsDetail $nutritionalsDetail)
    {
        // Eliminar el detalle nutricional
        $nutritionalsDetail->delete();

        return redirect()->route('nutritionals_details.index')->with('success', 'Detalle nutricional eliminado correctamente.');
    }
}
