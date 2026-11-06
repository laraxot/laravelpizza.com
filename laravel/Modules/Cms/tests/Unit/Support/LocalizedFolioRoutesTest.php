<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Support;

use PHPUnit\Framework\Assert;

use function Safe\parse_url;

/**
 * DCP-123: le rotte Folio hanno lo stesso nome in ogni lingua e vinceva l'ultima registrata (`it`),
 * quindi `route('container0.view')` rimandava a `/it/...` anche da `/en`, `/de`, `/es`.
 *
 * @return list<string>
 */
function localizedFolioLocales(): array
{
    $supported = config('laravellocalization.supportedLocales');
    Assert::assertIsArray($supported);

    return array_values(array_map(strval(...), array_keys($supported)));
}

describe('Localized Folio named routes', function (): void {
    test('container0.view usa il prefisso della lingua corrente', function (): void {
        $original = app()->getLocale();

        foreach (localizedFolioLocales() as $locale) {
            app()->setLocale($locale);

            $url = route('container0.view', ['container0' => 'tickets', 'slug0' => 'create'], false);

            Assert::assertSame('/'.$locale.'/tickets/create', $url, "locale {$locale}");
        }

        app()->setLocale($original);
    });

    test('container0.index usa il prefisso della lingua corrente', function (): void {
        $original = app()->getLocale();

        foreach (localizedFolioLocales() as $locale) {
            app()->setLocale($locale);

            Assert::assertSame('/'.$locale.'/tickets', route('container0.index', ['container0' => 'tickets'], false), "locale {$locale}");
        }

        app()->setLocale($original);
    });

    test('l\'URL assoluto mantiene host e cambia solo il prefisso lingua', function (): void {
        $original = app()->getLocale();
        app()->setLocale('de');

        $url = route('container0.view', ['container0' => 'tickets', 'slug0' => 'track']);

        Assert::assertSame('/de/tickets/track', parse_url($url, PHP_URL_PATH));
        Assert::assertSame(parse_url(url('/'), PHP_URL_HOST), parse_url($url, PHP_URL_HOST));

        app()->setLocale($original);
    });
});
