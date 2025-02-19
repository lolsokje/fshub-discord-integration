<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Carbon::macro('createFromFsHubTimestamp', function (string $timestamp): Carbon {
            return Carbon::createFromFormat('Y-m-d\TH:i:s.uT', $timestamp);
        });
    }
}
