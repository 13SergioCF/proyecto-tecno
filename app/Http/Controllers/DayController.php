<?php

namespace App\Http\Controllers;

use App\Models\Day;
use Illuminate\Http\Request;

class DayController extends Controller
{
    public function index(Request $request)
    {
        // Obtener los días filtrados por estado, si se ha seleccionado un filtro
        $filter = $request->get('filter', 'all');
        $days = $filter == 'all' ? Day::all() : Day::where('estado', $filter)->get();
    
        return view('days.index', compact('days')); // Asegúrate de pasar $days a la vista
    }
    

    public function create()
    {
        return view('days.create'); // Vista para crear un nuevo día
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        // Crear un nuevo día
        Day::create($request->all());

        return redirect()->route('days.index')->with('success', 'Día creado con éxito.');
    }

    public function edit(Day $day)
    {
        // Aquí se pasa el objeto $day a la vista 'days.edit'
        return view('days.edit', compact('day'));
    }
    
    public function update(Request $request, Day $day)
{
    // Validación de los datos
    $request->validate([
        'nombre' => 'required|string|max:255', // Validar solo el nombre
    ]);

    // Actualizar el día
    $day->update($request->all());

    return redirect()->route('days.index')->with('success', 'Día actualizado con éxito.');
}
    public function destroy(Day $day)
    {
        // Eliminar el día
        $day->delete();

        return redirect()->route('days.index')->with('success', 'Día eliminado correctamente.');
    }
}
