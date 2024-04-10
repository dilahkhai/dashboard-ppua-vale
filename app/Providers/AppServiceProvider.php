<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades;
use Illuminate\View\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Facades\View::composer('*', function (View $view) {
            $notifications = Notification::query()
                ->where('receiver_id', auth()->user()?->id)
                ->latest()
                ->limit(10)
                ->get();

            $view->with('notifications', $notifications);
        });

        Str::macro('initials', fn ($value, $sep = ' ', $glue = ' ') => trim(collect(explode($sep, $value))->map(function ($segment) {
            return $segment[0] ?? '';
        })));
    }
}
