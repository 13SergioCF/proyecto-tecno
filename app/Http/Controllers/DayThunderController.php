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
        $dayThunder = DayThunder::where('id_dia', $id_dia)->where('id_turno', $id_turno)->firstOrFail();
    
        $request->validate([
            'id_dia' => 'required|exists:days,id_dia',
            'id_turno' => 'required|exists:thunders,id_turno',
        ]);
    
        $dayThunder->update($request->all());
        return redirect()->route('daythunders.index')->with('success', 'Relación actualizada con éxito.');
    }
    

    public function destroy($id_dia, $id_turno)
    {
        // Busca y elimina el registro usando las claves compuestas
        $dayThunder = DayThunder::where('id_dia', $id_dia)->where('id_turno', $id_turno)->firstOrFail();
    
        // Elimina el registro
        $dayThunder->delete();
    
        return redirect()->route('daythunders.index')->with('success', 'Relación eliminada correctamente.');
    }
    
    
    
    
}
