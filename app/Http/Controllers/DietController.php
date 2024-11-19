<?php

namespace App\Http\Controllers;

use App\Models\Diet;
use App\Models\Period;
use Illuminate\Http\Request;
use PDF;

class DietController extends Controller
{
    public function index()
    {
        // Obtiene todos los registros de dietas
        $diets = Diet::all();
        return view('diets.index', compact('diets')); // Pasar todos a la vista
    }

    public function create()
    {
        // Obtener todos los periodos para la selección en el formulario
        $periods = Period::all();
        return view('diets.create', compact('periods'));
    }

    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'id_periodo' => 'required|exists:periods,id_periodo', // Validar que el periodo exista
        ]);

        // Crear una nueva dieta en la base de datos
        Diet::create($request->all());

        return redirect()->route('diets.index')->with('success', 'Dieta creada con éxito.');
    }

    public function edit(Diet $diet)
    {
        // Obtener todos los periodos para la selección en el formulario
        $periods = Period::all();
        return view('diets.edit', compact('diet', 'periods'));
    }

    public function update(Request $request, Diet $diet)
    {
        // Validación de los datos del formulario
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'id_periodo' => 'required|exists:periods,id_periodo', // Validar que el periodo exista
        ]);

        // Actualizar los datos de la dieta
        $diet->update($request->all());

        return redirect()->route('diets.index')->with('success', 'Dieta actualizada con éxito.');
    }

    public function destroy(Diet $diet)
    {
        // Eliminar físicamente la dieta de la base de datos
        $diet->delete();

        return redirect()->route('diets.index')->with('success', 'Dieta eliminada correctamente.');
    }

    public function exportPdf()
    {
        $diets = Diet::all(); // O ajusta la consulta según tus necesidades
        $pdf = PDF::loadView('diets.pdf', compact('diets')); // Asegúrate de que la vista sea la correcta
        return $pdf->download('dietas.pdf'); // O `stream()` si prefieres abrir en vez de descargar
    }
    
    /*
    public function exportExcel()
    {
        return Excel::download(new DietsExport, 'dietas.xlsx'); // Asegúrate de crear este archivo de exportación
    }
    */
}
