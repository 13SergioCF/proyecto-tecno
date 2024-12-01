<?php

namespace App\Livewire;

use App\Models\Muscle;
use Livewire\Component;

class MuscleBody extends Component
{
    public function render()
    {
        $muscles = Muscle::where('estado', 'activo')->get();
        return view('livewire.muscle-body', compact('muscles'));
    }
}
