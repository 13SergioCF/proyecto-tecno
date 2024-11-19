<?php

namespace App\Http\Controllers;

use App\Models\DetailsDaysThunder;
use App\Models\DayThunder;
use App\Models\DietsAliment;
use Illuminate\Http\Request;

class DetailsDaysThunderController extends Controller
{
    public function index()
    {
        // Obtener todos los registros de detalles de días y turnos con sus relaciones
        $detailsDaysThunders = DetailsDaysThunder::with(['dayThunder', 'dietAliment'])->get();
        return view('details_days_thunders.index', compact('detailsDaysThunders'));
    }

    public function create()
    {
        // Obtener los registros necesarios para las relaciones
        $daysThunders = DayThunder::all();
        $dietsAliments = DietsAliment::all();
        return view('details_days_thunders.create', compact('daysThunders', 'dietsAliments'));
    }

    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'id_day_thunder' => 'required|exists:days_thunders,id',
            'id_diet_aliment' => 'required|exists:diets_aliments,id',
        ]);

        // Crear un nuevo detalle de día y turno
        DetailsDaysThunder::create($request->all());

        return redirect()->route('details_days_thunders.index')->with('success', 'Detalle de día y turno creado con éxito.');
    }

    public function destroy(DetailsDaysThunder $detailsDaysThunder)
    {
        // Eliminar el detalle de día y turno
        $detailsDaysThunder->delete();

        return redirect()->route('details_days_thunders.index')->with('success', 'Detalle de día y turno eliminado correctamente.');
    }
}
