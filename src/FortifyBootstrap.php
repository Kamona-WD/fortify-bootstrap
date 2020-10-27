<?php

namespace FortifyBootstrap;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class FortifyBootstrap
{
    public function install()
    {
        $this->updatePackages();
        $this->removeNodeModules();
        $this->updateStyles();
        $this->updateJS();
        $this->updateBootstrapping();
        $this->updateWelcomePage();
        $this->scaffoldAuthAndLayouts();
        $this->installFortifyServiceProvider();
        $this->updateUserModel();
        $this->updateRoutes();
    }


    protected function updateStyles()
    {
        tap(new Filesystem, function ($filesystem) {
            $filesystem->deleteDirectory(resource_path('css'));
            $filesystem->delete(public_path('css/app.css'));

            if (!$filesystem->isDirectory($directory = resource_path('sass'))) {
                $filesystem->makeDirectory($directory, 0755, true);
            }

            copy(__DIR__ . '/../resources/sass/app.scss', resource_path('sass/app.scss'));
            copy(__DIR__ . '/../resources/sass/_variables.scss', resource_path('sass/_variables.scss'));
        });
    }

    protected function updateJS()
    {
        tap(new Filesystem, function ($filesystem) {
            $filesystem->delete(public_path('js/app.js'));

            if (!$filesystem->isDirectory($directory = resource_path('js'))) {
                $filesystem->makeDirectory($directory, 0755, true);
            }

            if (!$filesystem->isDirectory($directory = resource_path('js/components'))) {
                $filesystem->makeDirectory($directory, 0755, true);
            }

            copy(__DIR__ . '/../resources/js/bootstrap.js', resource_path('js/bootstrap.js'));

            copy(__DIR__ . '/../resources/js/app.js', resource_path('js/app.js'));

            copy(__DIR__ . '/../resources/js/ExampleComponent.vue', resource_path('js/components/ExampleComponent.vue'));
        });
    }

    protected function updateBootstrapping()
    {
        copy(__DIR__ . '/../webpack.mix.js', base_path('webpack.mix.js'));
    }

    protected function updateWelcomePage()
    {
        (new Filesystem)->delete($this->getViewPath('welcome.blade.php'));

        copy(__DIR__ . '/../resources/views/welcome.blade.php', $this->getViewPath('welcome.blade.php'));
    }

    protected function scaffoldAuthAndLayouts()
    {
        tap(new Filesystem, function ($filesystem) {
            $filesystem->copyDirectory(__DIR__ . '/../resources/views/layouts', $this->getViewPath('layouts'));
            $filesystem->copyDirectory(__DIR__ . '/../resources/views/auth', $this->getViewPath('auth'));
            $filesystem->copyDirectory(__DIR__ . '/../resources/views/profile', $this->getViewPath('profile'));
            copy(__DIR__ . '/../resources/views/home.blade.php', $this->getViewPath('home.blade.php'));
        });
    }

    protected function getViewPath($path)
    {
        return implode(DIRECTORY_SEPARATOR, [
            config('view.paths')[0] ?? resource_path('views'), $path,
        ]);
    }

    protected function removeNodeModules()
    {
        tap(new Filesystem, function ($files) {
            $files->deleteDirectory(base_path('node_modules'));

            $files->delete(base_path('yarn.lock'));
        });
    }

    protected function updatePackages($dev = true)
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $this->updatePackageArray(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    protected function updateUserModel()
    {
        copy(__DIR__ . '/../app/Models/User.php', app_path('Models/User.php'));
    }

    protected function installFortifyServiceProvider()
    {
        copy(__DIR__ . '/../app/Providers/FortifyBootstrapServiceProvider.php', app_path('Providers/FortifyBootstrapServiceProvider.php'));
        copy(__DIR__ . '/../app/Actions/Fortify/UpdateUserPassword.php', app_path('Actions/Fortify/UpdateUserPassword.php'));
        copy(__DIR__ . '/../app/Actions/Fortify/UpdateUserProfileInformation.php', app_path('Actions/Fortify/UpdateUserProfileInformation.php'));
        if (!Str::contains($appConfig = file_get_contents(config_path('app.php')), 'App\\Providers\\FortifyServiceProvider::class')) {
            file_put_contents(config_path('app.php'), str_replace(
                "App\\Providers\RouteServiceProvider::class,",
                "App\\Providers\RouteServiceProvider::class," . PHP_EOL . "        App\Providers\FortifyServiceProvider::class," . PHP_EOL . "        App\\Providers\\FortifyBootstrapServiceProvider::class,",
                $appConfig
            ));
        }
    }

    protected function updateRoutes()
    {
        file_put_contents(
            base_path('routes/web.php'),
            "\nRoute::view('home', 'home')\n\t->name('home')\n\t->middleware(['auth']);\n\nRoute::view('profile', 'profile.edit')\n\t->name('profile.edit')\n\t->middleware(['auth']);\n",
            FILE_APPEND
        );
    }

    protected function updatePackageArray(array $packages)
    {
        return [
            'bootstrap' => '^4.0.0',
            'jquery' => '^3.2',
            'popper.js' => '^1.12',
            'sass' => '^1.20.1',
            'sass-loader' => '^8.0.0',
            'resolve-url-loader' => '^2.3.1',
            'vue' => '^2.5.17',
            'vue-template-compiler' => '^2.6.10',
        ] + $packages;
    }
}
