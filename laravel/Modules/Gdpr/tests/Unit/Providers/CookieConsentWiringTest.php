<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View;
use Modules\Gdpr\Http\Middleware\InjectCookieBanner;
use Modules\Gdpr\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

// Pest legge solo `laravel/tests/Pest.php`: il `pest()->extend()` di `Modules/Gdpr/tests/Pest.php` non viene mai eseguito, quindi
// senza `uses()` il test gira su un container vuoto (nessun translator, nessun router) e fallisce per un motivo che non e' il cablaggio.
uses(TestCase::class);

/**
 * Il 2026-11-11 un mirror (commit "." del repo Gdpr) ha riportato `GdprServiceProvider` a una versione vecchia: via `app->booted`
 * con `addLines`, via `prependNamespace` della vista, via `InjectCookieBanner` dal gruppo `web`. Risultato in produzione e nei test
 * verdi: `/cookie-policy` con 20 chiavi grezze (`cookie-consent::texts.policy_title`) e nessun banner su nessuna pagina, con le terze
 * parti (tile OSM, Gravatar) caricate prima di qualunque scelta. Qui si prova il cablaggio, non il codice del provider.
 */
test('cookie-consent texts resolve to the module lines in every served locale, not to the raw key', function (): void {
    $langPath = dirname(__DIR__, 3).'/lang/cookie-consent';
    $checked = 0;
    $problems = [];

    foreach (['it', 'en', 'de', 'es'] as $locale) {
        $lines = require $langPath.'/'.$locale.'/texts.php';
        Assert::assertIsArray($lines);
        foreach ($lines as $key => $expected) {
            $checked++;
            $actual = trans('cookie-consent::texts.'.$key, [], $locale);
            if ($actual !== $expected) {
                $problems[] = $locale.' texts.'.$key.': '.json_encode($actual);
            }
        }
    }

    Assert::assertGreaterThan(100, $checked, 'troppe poche righe controllate: la guardia passerebbe a vuoto');
    Assert::assertSame([], $problems, "\n".implode("\n", array_slice($problems, 0, 10)));
});

test('the banner view of the module takes precedence over the package one', function (): void {
    $path = View::getFinder()->find('cookie-consent::index');

    Assert::assertStringContainsString('/Modules/Gdpr/resources/views/cookie-consent/', $path);
});

test('the banner injector is registered in the web middleware group', function (): void {
    $web = app(Router::class)->getMiddlewareGroups()['web'] ?? [];

    Assert::assertIsArray($web);
    Assert::assertContains(InjectCookieBanner::class, $web);
});
