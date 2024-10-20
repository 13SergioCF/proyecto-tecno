<?php

namespace App\Http\Controllers;

use App\Models\FoodType;
use Illuminate\Http\Request;
use App\Exports\FoodTypesExport; 
use PDF;

class FoodTypeController extends Controller
{
    public function index()
{
    // Obtiene todos los registros de tipos de alimento
    $foodTypes = FoodType::all();
    return view('foodTypes.index', compact('foodTypes')); // Pasar todos a la vista
}


    public function create()
    {
        return view('foodTypes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        FoodType::create($request->all());
        return redirect()->route('food-types.index')->with('success', 'Tipo de alimento creado con éxito.'); // Correcto
    }

    public function edit(FoodType $foodType)
    {
        return view('foodTypes.edit', compact('foodType'));
    }

    public function update(Request $request, FoodType $foodType)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $foodType->update($request->all());
        return redirect()->route('food-types.index')->with('success', 'Tipo de alimento actualizado con éxito.'); // Cambiado aquí
    }

    public function destroy(FoodType $foodType)
    {
        // No elimina físicamente, solo cambia el estado
        $foodType->update(['estado' => 'inactivo']);
        return redirect()->route('food-types.index')->with('success', 'Tipo de alimento eliminado correctamente.'); // Correcto
    }



    public function exportPDF()
    {
        $foodTypes = FoodType::all(); // Obtener todos los tipos de alimento
        $pdf = PDF::loadView('foodTypes.pdf', compact('foodTypes')); // Asegúrate de que la vista 'foodTypes.pdf' exista
        return $pdf->download('tipos_de_alimento.pdf');
    }
    
    public function exportExcel()
    {
        return Excel::download(new FoodTypesExport, 'tipos_de_alimento.xlsx');
    }
}
