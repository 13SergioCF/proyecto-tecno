<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function getRecommendationJson($recommendationId)
    {
        try {
            $recommendation = Recommendation::findOrFail($recommendationId);

            // Procesar el texto de la recomendación en JSON
            $recommendationJson = $this->processRecommendationToJson($recommendation->content);

            // Retornar como JSON
            return response()->json([
                'status' => 'success',
                'data' => $recommendationJson,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function showRecommendation($recommendationId)
    {
        try {
            $recommendation = Recommendation::findOrFail($recommendationId);

            // Procesar la recomendación en JSON
            $recommendationJson = $this->processRecommendationToJson($recommendation->content);

            // Retornar la vista con los datos
            return view('recommendations.show', [
                'recommendationJson' => $recommendationJson,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al procesar la recomendación.');
        }
    }
}
