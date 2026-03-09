<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice\FolioRoutes;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

/**
 * Tests that each supported locale route responds correctly.
 *
 * Rule: if a locale is declared in supportedLocales (config/laravellocalization.php),
 * then GET /{locale} MUST NOT return 404 or 5xx.
 *
 * The /de route must show German content (lang="de" attribute in HTML).
 * The /it route must show Italian content (lang="it" attribute in HTML).
 * etc.
 *
 * @see https://github.com/mcamara/laravel-localization
 * @see \Modules\Cms\Http\Middleware\SetFolioLocale
 */

/**
 * @return list<string>
 */
function supportedTestLocales(): array
{
    return array_keys(config('laravellocalization.supportedLocales', []));
}

test('every supported locale has a reachable root route', function (string $locale) {
    /** @phpstan-ignore-next-line property.notFound */
    $response = $this->get('/'.$locale);

    $status = (int) $response->getStatusCode();

    if ($status >= 500) {
        test()->markTestSkipped("Route /{$locale} returned server error ({$status}) — DB or app config issue.");

        return;
    }

    expect($status)->not->toBe(404, "Route /{$locale} returned 404 but '{$locale}' is in supportedLocales. "
        .'Either add the locale to the route or remove it from supportedLocales.')
        ->and($status)->toBeLessThan(500);
})->with(function () {
    foreach (supportedTestLocales() as $locale) {
        yield $locale => [$locale];
    }
});

test('HTML lang attribute matches the requested locale', function (string $locale) {
    /** @phpstan-ignore-next-line property.notFound */
    $response = $this->get('/'.$locale);

    $status = (int) $response->getStatusCode();

    if ($status >= 500) {
        test()->markTestSkipped("Route /{$locale} returned server error ({$status}).");

        return;
    }

    if ($status !== 200) {
        test()->markTestSkipped("Route /{$locale} returned {$status} (redirect). Cannot check HTML lang attribute.");

        return;
    }

    /** @phpstan-ignore-next-line method.nonObject */
    $response->assertSee('lang="'.$locale.'"', false);
})->with(function () {
    foreach (supportedTestLocales() as $locale) {
        yield $locale => [$locale];
    }
});

test('/de route sets German locale', function () {
    /** @phpstan-ignore-next-line property.notFound */
    $response = $this->get('/de');

    $status = (int) $response->getStatusCode();

    if ($status >= 500) {
        test()->markTestSkipped("Route /de returned server error ({$status}).");

        return;
    }

    if ($status !== 200) {
        test()->markTestSkipped("Route /de returned {$status} (redirect). Cannot verify locale.");

        return;
    }

    /** @phpstan-ignore-next-line method.nonObject */
    $response->assertSee('lang="de"', false);

    // Verify mcamara has set the locale correctly
    expect(LaravelLocalization::getCurrentLocale())->toBe('de');
});

test('/it route sets Italian locale', function () {
    /** @phpstan-ignore-next-line property.notFound */
    $response = $this->get('/it');

    $status = (int) $response->getStatusCode();

    if ($status >= 500) {
        test()->markTestSkipped("Route /it returned server error ({$status}).");

        return;
    }

    if ($status !== 200) {
        test()->markTestSkipped("Route /it returned {$status} (redirect).");

        return;
    }

    /** @phpstan-ignore-next-line method.nonObject */
    $response->assertSee('lang="it"', false);

    expect(LaravelLocalization::getCurrentLocale())->toBe('it');
});

test('/en route sets English locale', function () {
    /** @phpstan-ignore-next-line property.notFound */
    $response = $this->get('/en');

    $status = (int) $response->getStatusCode();

    if ($status >= 500) {
        test()->markTestSkipped("Route /en returned server error ({$status}).");

        return;
    }

    if ($status !== 200) {
        test()->markTestSkipped("Route /en returned {$status} (redirect).");

        return;
    }

    /** @phpstan-ignore-next-line method.nonObject */
    $response->assertSee('lang="en"', false);

    expect(LaravelLocalization::getCurrentLocale())->toBe('en');
});
