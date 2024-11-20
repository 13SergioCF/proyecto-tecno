<?php

namespace App\Http\Controllers;

use App\Models\Thunder;
use Illuminate\Http\Request;

class ThunderController extends Controller
{
    public function index()
    {
        // Obtiene todos los registros de turnos (thunders)
        $thunders = Thunder::all();
        return view('thunders.index', compact('thunders')); // Pasar todos a la vista
    }

    public function create()
    {
        return view('thunders.create'); // Vista para crear un nuevo turno
    }

    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        // Crear un nuevo turno
        Thunder::create($request->all());

        return redirect()->route('thunders.index')->with('success', 'Turno creado con éxito.');
    }

    public function edit(Thunder $thunder)
    {
        return view('thunders.edit', compact('thunder')); // Vista para editar el turno
    }

    public function update(Request $request, Thunder $thunder)
    {
        // Validación de los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        // Actualizar el turno
        $thunder->update($request->all());

        return redirect()->route('thunders.index')->with('success', 'Turno actualizado con éxito.');
    }

    public function destroy(Thunder $thunder)
    {
        // Eliminar el turno de la base de datos
        $thunder->delete();

        return redirect()->route('thunders.index')->with('success', 'Turno eliminado correctamente.');
    }
}
