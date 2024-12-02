<?php

namespace App\Providers;

use App\Events\RecommendationCreated;
use App\Listeners\ProcessRecommendationContent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RecommendationCreated::class => [
            ProcessRecommendationContent::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
