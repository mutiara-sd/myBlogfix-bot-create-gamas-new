<?php

namespace App\Providers;

use App\Livewire\Assurance\Bot\BotCreateGamasLivewire;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

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
    public function boot(): void
    {
        //Model::preventLazyLoading();
        Model::preventLazyLoading(!app()->isProduction());
        Livewire::component('assurance.bot.bot-create-gamas', BotCreateGamasLivewire::class);
    }
}
