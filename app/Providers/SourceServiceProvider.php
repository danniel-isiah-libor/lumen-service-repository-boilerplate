<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Sources\AuditTrail\ActivityLogSource;
use App\Sources\AuditTrail\Contracts\ActivityLogSourceInterface;

class SourceServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ActivityLogSourceInterface::class, ActivityLogSource::class);
    }
}
