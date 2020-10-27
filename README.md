# Fortify Bootstrap

Use laravel/ui front-end bootstrap scafolding with laravel/fortify.

[![License](https://img.shields.io/github/license/Kamona-WD/fortify-bootstrap)](https://github.com/Kamona-WD/fortify-bootstrap/blob/main/LICENSE.md)
[![Release](https://img.shields.io/github/release/Kamona-WD/fortify-bootstrap)](https://github.com/Kamona-WD/fortify-bootstrap/releases)

## Note

We recommend installing this package on a project that you are starting from scratch.

## Usage

1. Fresh install Laravel >= 8.0 and `cd` to your app.
2. Install this preset via `composer require kamona/fortify-bootstrap`. Laravel will automatically discover this package. No need to register the service provider,
   And also no need to install `laravel/fortify` it will be installed automatically.

3. Use `php artisan fortstrap:install`.
   (NOTE: If you run this command several times, be sure to clean up the duplicate Auth entries in `routes/web.php` and run `npm install && npm run dev`)
4. Configure your database.
5. Run `php artisan migrate`.
6. `npm install && npm run dev`
7. `php artisan serve`

## Note

All Fortify features are enabled by default except email verification. To enable it edit your `Models/User.php` model

```php
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
   // ....
}
```

Uncomment this line in `app/Providers/FortifyBootstrapServiceProvider.php`.

```php
public function boot()
    {
        // ...

        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        // ....
    }
```

Uncomment this line in `config/fortify.php`.

```php
'features' => [
        // ...
        Features::emailVerification(),
        // ...
    ],
```

## Enable, Disable feature

See [laravel/fortify](https://github.com/laravel/fortify#readme) docs. and don't forget to disable, enable views in `app/Providers/FortifyBootstrapServiceProvider.php`

## Edit views

Layouts `views/layouts`.

Profile `views/profile/edit.blade.php`.

Dashboard `views/home.blade.php`.
