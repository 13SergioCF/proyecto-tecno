<?php

namespace App\Http\Controllers;

use App\Models\Nutrient;
use Illuminate\Http\Request;
use App\Exports\NutrientsExport; // Asegúrate de crear este archivo de exportación si necesitas exportar
use Maatwebsite\Excel\Facades\Excel;

use PDF;

class NutrientController extends Controller
{
    public function index()
    {
        // Obtiene todos los registros de nutrientes
        $nutrients = Nutrient::all();
        return view('nutrients.index', compact('nutrients')); // Pasar todos a la vista
    }

    public function create()
    {
        return view('nutrients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Nutrient::create($request->all());
        return redirect()->route('nutrients.index')->with('success', 'Nutriente creado con éxito.');
    }

    public function edit(Nutrient $nutrient)
    {
        return view('nutrients.edit', compact('nutrient'));
    }

    public function update(Request $request, Nutrient $nutrient)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $nutrient->update($request->all());
        return redirect()->route('nutrients.index')->with('success', 'Nutriente actualizado con éxito.');
    }

    public function destroy(Nutrient $nutrient)
    {
        // No elimina físicamente, solo cambia el estado
        $nutrient->update(['estado' => 'inactivo']);
        return redirect()->route('nutrients.index')->with('success', 'Nutriente eliminado correctamente.');
    }

    public function exportPdf()
    {
        $nutrients = Nutrient::all(); // O ajusta la consulta según tus necesidades
        $pdf = PDF::loadView('nutrients.pdf', compact('nutrients')); // Asegúrate de que la vista sea la correcta
        return $pdf->download('nutrientes.pdf'); // O `stream()` si prefieres abrir en vez de descargar
    }
    
    
   /*
public function exportExcel()
{
    return Excel::download(new NutrientsExport, 'nutrientes.xlsx'); // Asegúrate de crear este archivo de exportación
}
*/

}
