<?php

namespace App\Http\Controllers;

use App\Models\Aliment;
use App\Models\FoodType;
use Illuminate\Http\Request;

use PDF;

class AlimentController extends Controller
{
    // Mostrar la lista de alimentos
    public function index(Request $request)
{
    $estado = $request->input('estado', 'all'); // Recibir filtro de estado
    $foodType = $request->input('food_type', null);

    $aliments = Aliment::query();

    if ($estado !== 'all') {
        $aliments->where('estado', $estado);
    }

    if ($foodType) {
        $aliments->where('food_type_id', $foodType);
    }

    $aliments = $aliments->with('foodType')->get();

    $foodTypes = FoodType::where('estado', 'activo')->get();

    return view('aliments.index', compact('aliments', 'foodTypes', 'estado', 'foodType'));
}


    

    // Crear un nuevo alimento
    public function create()
    {
        // Obtener todos los tipos de alimento
        $foodTypes = FoodType::pluck('nombre', 'id'); // Cambia esto si usas otro modelo o método
    
        return view('aliments.create', compact('foodTypes'));
    }
    

    // Almacenar un nuevo alimento
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'food_type_id' => 'required|exists:food_types,id',
        ]);
    
        try {
            $aliment = new Aliment();
            $aliment->nombre = $request->nombre;
            $aliment->descripcion = $request->descripcion;
            $aliment->food_type_id = $request->food_type_id;
            $aliment->estado = 'activo'; // Puedes establecer un estado por defecto
            $aliment->save();
    
            return redirect()->route('aliments.index')->with('success', 'Alimento agregado exitosamente.');
        } catch (\Exception $e) {
            // Manejo de errores
            return redirect()->back()->with('error', 'Error al agregar el alimento: ' . $e->getMessage());
        }
    }
    

    // Editar alimento
    public function edit($id)
    {
        try {
            // Buscar el alimento por ID o lanzar una excepción si no existe
            $aliment = Aliment::findOrFail($id);
    
            // Obtener los tipos de alimentos
            $foodTypes = FoodType::pluck('nombre', 'id');
    
            return view('aliments.edit', compact('aliment', 'foodTypes'));
        } catch (\Exception $e) {
            // Redirigir con un mensaje de error si no se encuentra el alimento
            return redirect()->route('aliments.index')->with('error', 'El alimento no fue encontrado.');
        }
    }
    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:activo,inactivo',
            'food_type_id' => 'required|exists:food_types,id',
        ]);
    
        try {
            $aliment = Aliment::findOrFail($id); // Buscar el alimento por ID
            $aliment->update($validated);
    
            return redirect()->route('aliments.index')->with('success', 'Alimento actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el alimento: ' . $e->getMessage());
        }
    }
    






    public function destroy($id)
    {
        $aliment = Aliment::find($id);
    
        if (!$aliment) {
            return response()->json(['message' => 'Alimento no encontrado.'], 404);
        }
    
        try {
            // Cambiar el estado a "inactivo" en lugar de eliminarlo
            $aliment->update(['estado' => 'inactivo']);
            return response()->json(['message' => 'El estado del alimento se actualizó a inactivo.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el estado: ' . $e->getMessage()], 500);
        }
    }
    
    
    




    // Exportar a PDF
    public function exportPdf(Request $request)
    {
        $estado = $request->input('estado', null);
        $foodType = $request->input('food_type', null);
        
        $aliments = Aliment::query();

        if ($estado) {
            $aliments = $aliments->where('estado', $estado);
        }

        if ($foodType) {
            $aliments = $aliments->where('food_type_id', $foodType);
        }

        // Cargar relaciones
        $aliments = $aliments->with('foodType')->get();

        $pdf = PDF::loadView('aliments.pdf', compact('aliments'));
        return $pdf->download('alimentos.pdf');
    }
}
