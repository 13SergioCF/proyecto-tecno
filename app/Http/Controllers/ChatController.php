<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Livewire\RecomendationComponent;

class ChatController extends Controller
{
    public function generate()
    {
        $user_id = auth()->id();
        $component = new \App\Livewire\RecomendationComponent();
        $component->generateRecommendations();

        return response()->json([
            'recommendations' => $component->recommendations,
        ]);
    }
}
