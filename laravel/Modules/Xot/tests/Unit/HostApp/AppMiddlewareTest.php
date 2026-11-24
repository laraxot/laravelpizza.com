<?php

declare(strict_types=1);

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\TrustHosts;
use App\Livewire\Actions\Logout;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

/*
 * Middleware e action HTTP dell'applicazione host (App\), non dei moduli.
 *
 * Tutti i collaboratori che toccherebbero il database (guard di Auth, store di
 * sessione) sono sostituiti da mock sulla facade: il test descrive il contratto
 * del middleware, non la persistenza. Nessuna connessione aperta.
 *
 * Queste classi esistono solo negli host con lo scheletro completo (ptvx,
 * predict, ...). Gli host con app/ minimale (restaurant, techplanner, ...)
 * non le forniscono: ogni test salta se la classe mancante, invece di fallire.
<<<<<<< HEAD
 * Assert::assertIs* solo dove il tipo runtime non e' gia' noto a PHPStan
 * (es. elemento di array); mai su return gia' tipizzati (array / const string).
=======
 * Assert::assertIs* restringe i valori misti delle classi App\ opzionali
 * (`hosts()` senza return type, `HOME` costante host): mai cast/`@var` cosmetici.
>>>>>>> laraxot/dev
 */

uses(TestCase::class);

test('trust hosts trusts every subdomain of the application url', function (): void {
    if (! class_exists(TrustHosts::class)) {
        $this->markTestSkipped('Host app senza App\Http\Middleware\TrustHosts.');
    }

    $hostsRaw = (new TrustHosts(app()))->hosts();
<<<<<<< HEAD
    Assert::assertIsArray($hostsRaw);
    /** @var list<string> $hosts */
    $hosts = [];
    foreach ($hostsRaw as $host) {
        Assert::assertIsString($host);
=======
    if (! is_array($hostsRaw)) {
        Assert::fail('TrustHosts::hosts() deve restituire un array.');
    }

    $hosts = [];
    foreach ($hostsRaw as $host) {
        if (! is_string($host)) {
            Assert::fail('TrustHosts::hosts() deve restituire solo stringhe.');
        }
>>>>>>> laraxot/dev
        $hosts[] = $host;
    }

    $appHost = Str::of(Config::string('app.url'))->after('://')->before('/')->value();

    Assert::assertCount(1, $hosts);
<<<<<<< HEAD
    $pattern = $hosts[0];
=======
    $pattern = $hosts[0] ?? null;
    if (! is_string($pattern)) {
        Assert::fail('TrustHosts deve produrre esattamente un pattern stringa.');
    }
>>>>>>> laraxot/dev
    // Il pattern di Laravel e' `^(.+\.)?<host quotato>$`: verifichiamo che copra
    // sia il dominio nudo sia un suo sottodominio, senza replicarne la stringa.
    Assert::assertMatchesRegularExpression('#'.$pattern.'#', $appHost);
    Assert::assertMatchesRegularExpression('#'.$pattern.'#', 'admin.'.$appHost);
});

test('authenticate returns no redirect target for json requests', function (): void {
    if (! class_exists(Authenticate::class)) {
        $this->markTestSkipped('Host app senza App\Http\Middleware\Authenticate.');
    }

    $request = Request::create('/protected', 'GET', server: ['HTTP_ACCEPT' => 'application/json']);

    $redirectTo = (function (Request $request): mixed {
        return $this->redirectTo($request);
    })->call(new Authenticate(app('auth')), $request);

    Assert::assertNull($redirectTo);
});

test('redirect if authenticated lets a guest through untouched', function (): void {
    if (! class_exists(RedirectIfAuthenticated::class)) {
        $this->markTestSkipped('Host app senza App\Http\Middleware\RedirectIfAuthenticated.');
    }

    $guard = Mockery::mock();
    $guard->shouldReceive('check')->once()->andReturnFalse();
    Auth::shouldReceive('guard')->once()->with(null)->andReturn($guard);

    $request = Request::create('/login');
    $expected = new Response('form di login');

    $response = (new RedirectIfAuthenticated)->handle($request, fn (): Response => $expected);

    Assert::assertSame($expected, $response);
});

test('redirect if authenticated sends an authenticated user home', function (): void {
    if (! class_exists(RedirectIfAuthenticated::class)) {
        $this->markTestSkipped('Host app senza App\Http\Middleware\RedirectIfAuthenticated.');
    }

    // Laravel 11+ non ha piu' RouteServiceProvider: senza HOME non c'e' destinazione da verificare.
    if (! class_exists(RouteServiceProvider::class)) {
        $this->markTestSkipped('Host app senza App\Providers\RouteServiceProvider.');
    }

    $guard = Mockery::mock();
    $guard->shouldReceive('check')->once()->andReturnTrue();
    Auth::shouldReceive('guard')->once()->with('web')->andReturn($guard);

    $response = (new RedirectIfAuthenticated)->handle(
        Request::create('/login'),
        fn (): Response => new Response('non deve arrivarci'),
        'web',
    );

    Assert::assertInstanceOf(RedirectResponse::class, $response);
<<<<<<< HEAD
    // HOME e' una costante dell'app host: per PHPStan e' mixed finche' non si controlla che sia una stringa.
    $home = RouteServiceProvider::HOME;
    Assert::assertIsString($home);
=======
    $home = RouteServiceProvider::HOME;
    if (! is_string($home)) {
        Assert::fail('RouteServiceProvider::HOME deve essere una stringa.');
    }
>>>>>>> laraxot/dev
    Assert::assertSame(url($home), $response->getTargetUrl());
});

test('logout action clears the web guard and the session', function (): void {
    if (! class_exists(Logout::class)) {
        $this->markTestSkipped('Host app senza App\Livewire\Actions\Logout.');
    }

    $calls = [];

    $guard = Mockery::mock();
    $guard->shouldReceive('logout')->once()->andReturnUsing(function () use (&$calls): void {
        $calls[] = 'logout';
    });
    Auth::shouldReceive('guard')->once()->with('web')->andReturn($guard);

    Session::shouldReceive('invalidate')->once()->andReturnUsing(function () use (&$calls): bool {
        $calls[] = 'invalidate';

        return true;
    });
    Session::shouldReceive('regenerateToken')->once()->andReturnUsing(function () use (&$calls): void {
        $calls[] = 'regenerateToken';
    });

    (new Logout)();

    Assert::assertSame(['logout', 'invalidate', 'regenerateToken'], $calls);
});
