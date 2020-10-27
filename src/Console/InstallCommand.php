<?php

namespace FortifyBootstrap\Console;

use FortifyBootstrap\FortifyBootstrap;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    public $signature = 'fortstrap:install';

    public $description = 'Setup FortifyBootdtrap routes, service providers and views';

    public function handle()
    {
        $this->callSilent('vendor:publish', ['--provider' => 'Laravel\Fortify\FortifyServiceProvider']);
        (new FortifyBootstrap)->install();
        $this->info('All fortify-bootstrap stuff installed successfully');
        $this->comment('Please run npm install && npm run dev');
    }
}
