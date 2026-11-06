<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Http\Volt;

use Illuminate\Http\Request;
use Modules\User\Http\Volt\LogoutAction;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\parse_url;

uses(TestCase::class)->group('no-user-db');

/*
 * I form di logout (menu utente, pagina di conferma) inviano `POST /logout` senza prefisso lingua: senza questo
 * test chi usciva da `/de` o `/es` atterrava sempre su `/it`. La lingua si legge dal percorso del Referer e si
 * accetta solo se e' una lingua supportata, quindi un Referer inventato o ostile non cambia la destinazione.
 */
function logoutRedirectPath(?string $referer): string
{
    $server = $referer === null ? [] : ['HTTP_REFERER' => $referer];
    app()->instance('request', Request::create('/logout', 'POST', [], [], [], $server));
    app()->setLocale('it');

    $path = parse_url((new LogoutAction)()->getTargetUrl(), PHP_URL_PATH);
    Assert::assertIsString($path);

    return $path;
}

it('goes back to the home of the language the user was browsing', function (string $referer, string $expected): void {
    Assert::assertSame($expected, logoutRedirectPath($referer));
})->with([
    'german' => ['http://fixcity.test/de/blog', '/de'],
    'spanish' => ['http://fixcity.test/es/area-personale/pratiche', '/es'],
    'english home' => ['http://fixcity.test/en', '/en'],
]);

it('keeps the application language when the referer says nothing usable', function (?string $referer): void {
    Assert::assertSame('/it', logoutRedirectPath($referer));
})->with([
    'invented language' => ['http://fixcity.test/xx/blog'],
    'no language prefix' => ['http://fixcity.test/blog'],
    'no referer' => [null],
    'host smuggled in the path' => ['http://fixcity.test//evil.com/de'],
]);
