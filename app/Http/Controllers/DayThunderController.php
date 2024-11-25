<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Thunder;
use App\Models\DayThunder;
use Illuminate\Http\Request;

class DayThunderController extends Controller
{
    public function index()
    {
        $dayThunders = DayThunder::with(['day', 'thunder'])->get();
        return view('daythunders.index', compact('dayThunders'));
    }

    public function create()
    {
        $days = Day::all();
        $thunders = Thunder::all();
        return view('daythunders.create', compact('days', 'thunders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_dia' => 'required|exists:days,id_dia',
            'id_turno' => 'required|exists:thunders,id_turno',
        ]);

        DayThunder::create($request->all());
        return redirect()->route('daythunders.index')->with('success', 'Relación creada con éxito.');
    }

    public function edit($id_dia, $id_turno)
    {
        $dayThunder = DayThunder::where('id_dia', $id_dia)->where('id_turno', $id_turno)->firstOrFail();
        $days = Day::all();
        $thunders = Thunder::all();
    
        return view('daythunders.edit', compact('dayThunder', 'days', 'thunders'));
    }
    
    

    public function update(Request $request, $id_dia, $id_turno)
    {
        $request->validate([
            'id_dia' => 'required|exists:days,id_dia',
            'id_turno' => 'required|exists:thunders,id_turno',
        ]);
    
        // Verifica si la nueva combinación ya existe
        $exists = DayThunder::where('id_dia', $request->id_dia)
            ->where('id_turno', $request->id_turno)
            ->exists();
    
        if ($exists) {
            return redirect()->back()->withErrors('La combinación de Día y Turno ya existe.');
        }
    
        // Elimina el registro existente
        DayThunder::where('id_dia', $id_dia)->where('id_turno', $id_turno)->delete();
    
        // Crea un nuevo registro con los valores actualizados
        DayThunder::create([
            'id_dia' => $request->id_dia,
            'id_turno' => $request->id_turno,
        ]);
    
        return redirect()->route('daythunders.index')->with('success', 'Relación actualizada con éxito.');
    }
    

    
    
    

    public function destroy($id_dia, $id_turno)
    {
        // Elimina el registro directamente con una consulta
        DayThunder::where('id_dia', $id_dia)->where('id_turno', $id_turno)->delete();
    
        return redirect()->route('daythunders.index')->with('success', 'Relación eliminada correctamente.');
    }
    
    
    
    
    
}
