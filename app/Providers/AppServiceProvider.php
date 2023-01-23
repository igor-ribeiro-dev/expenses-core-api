<?php

namespace App\Providers;

use App\Services\External\ExpenseFeederService;
use Illuminate\Support\ServiceProvider;

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
        $this->bootExpenseFeeder();
    }

    private function bootExpenseFeeder() {

        $default = config('amqp.default');

        $configKey  = "amqp.connections.$default";

        $this->app->when(ExpenseFeederService::class)
            ->needs('$config')
            ->giveConfig($configKey);
    }
}
