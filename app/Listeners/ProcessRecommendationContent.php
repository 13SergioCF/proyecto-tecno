<?php

namespace App\Listeners;

use App\Events\RecommendationCreated;
use App\Models\RecommendationJson;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use OpenAI;

class ProcessRecommendationContent implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(RecommendationCreated $event)
    {
        $recommendation = $event->recommendation;
        $content = $recommendation->content;
        $jsonContent = $this->fetchAIRecommendations($content);
        RecommendationJson::create([
            'recommendation_id' => $recommendation->id,
            'content_json' => $jsonContent,
        ]);
    }

    private function fetchAIRecommendations($prompt)
    {
        $client = OpenAI::client(env('OPENIA_API_KEY'));
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        return $response['choices'][0]['message']['content'] ?? 'No se pudo generar una recomendación.';
    }
}
