<?php

namespace FortifyBootstrap;

use Illuminate\Support\ServiceProvider;
use FortifyBootstrap\Console\InstallCommand;

class FortifyBootstrapServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            InstallCommand::class
        ]);
    }

    public function register()
    {
        //
    }
}
