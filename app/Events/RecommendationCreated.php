<?php

namespace App\Events;

use App\Models\Recommendation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecommendationCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $recommendation;

    public function __construct(Recommendation $recommendation)
    {
        $this->recommendation = $recommendation;
    }
}
