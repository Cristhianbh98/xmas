<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Language;

use App\Models\User;
use App\Observers\UserObserver;
use App\Models\Attendee;
use App\Observers\AttendeeObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        User::observe(UserObserver::class);
        Attendee::observe(AttendeeObserver::class);
    }
}
