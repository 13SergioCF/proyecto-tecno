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
        // Filtro por estado (activo/inactivo) si se envía en la solicitud
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

        $foodTypes = FoodType::where('estado', 'activo')->get(); // Para los filtros en la vista

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
    // Obtener el alimento por su ID
    $aliment = Aliment::findOrFail($id);
    
    // Obtener los tipos de alimentos (suponiendo que tienes un modelo FoodType)
    $foodTypes = FoodType::pluck('nombre', 'id'); // Ajusta los nombres según tu modelo

    // Retornar la vista de edición pasando el alimento y los tipos de alimento
    return view('aliments.edit', compact('aliment', 'foodTypes'));
}

    

    

    // Actualizar alimento
    public function update(Request $request, Aliment $aliment)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:activo,inactivo',
            'food_type_id' => 'required|exists:food_types,id',
        ]);

        $aliment->update($request->all());
        return redirect()->route('aliments.index')->with('success', 'Alimento actualizado con éxito.');
    }

    // Eliminar alimento (cambiar el estado a inactivo)
    public function destroy(Aliment $aliment)
    {
        $aliment->update(['estado' => 'inactivo']);
        return redirect()->route('aliments.index')->with('success', 'Alimento eliminado correctamente.');
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
