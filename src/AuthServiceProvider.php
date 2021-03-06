<?php


namespace Cblink\AuthServer;


use Cblink\AuthServer\Commands\CreateAuthApp;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->publishes([__DIR__ . '/database/' => database_path()]);
        $this->publishes([__DIR__ . '/config/' => config_path()]);
        $this->commands(CreateAuthApp::class);
    }
}