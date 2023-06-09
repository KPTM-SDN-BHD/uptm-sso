<?php

namespace Uptm\Sso;

use Illuminate\Support\ServiceProvider;
use Uptm\Sso\Http\Controllers\AuthenticationController;
use Uptm\Sso\Providers\EventServiceProvider;

class SsoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/config/config.php' => config_path('socialite-passport.php'),
            ], 'config');
        }

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/config.php', 'socialite-passport');
        $this->mergeConfigFrom(__DIR__.'/config/services.php', 'services');

        $this->app->register(EventServiceProvider::class);

        $this->app->bind('AuthenticationController', function () {
            return new AuthenticationController();
        });
    }
}
