<?php

// use Illuminate\Foundation\Application;
use App\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Le pagine Folio sono registrate una volta per lingua con lo stesso nome: route('login') punterebbe
        // all'ultima lingua registrata (es. /ru/auth/login). Gli ospiti vanno al login nella lingua corrente.
        $middleware->redirectGuestsTo(static fn (): string => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::localizeUrl('/auth/login'));

        // Laravel Localization middleware aliases for Laravel 11+
        // These are used in FolioVoltServiceProvider for route localization
        $middleware->alias([
            'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
