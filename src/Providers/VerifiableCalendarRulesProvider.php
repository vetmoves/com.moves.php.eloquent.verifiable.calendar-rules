<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Providers;

use Illuminate\Support\ServiceProvider;

class VerifiableCalendarRulesProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'verifiable_calendar_rules');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/moves/verifiable_calendar_rules')
        ]);
    }
}
