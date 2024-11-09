<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;


class PeriodController extends Controller
{
    public function index()
    {
        $periods = Period::all();
        return view('periods.index', compact('periods'));
    }

    public function create()
    {
        return view('periods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        Period::create($request->all());
        return redirect()->route('periods.index')->with('success', 'Periodo creado con éxito.');
    }

    public function edit(Period $period)
    {
        return view('periods.edit', compact('period'));
    }

    public function update(Request $request, Period $period)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $period->update($request->all());
        return redirect()->route('periods.index')->with('success', 'Periodo actualizado con éxito.');
    }
    public function destroy($id)
    {
        $period = Period::find($id);
        if ($period) {
            $period->delete();
            return response()->json(['message' => 'Periodo elimanado satisfactoriamente.']);
        } else {
            return response()->json(['message' => 'Periodo no encontrado.'], 404);
        }
    }

    

}
