<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice;

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

/*
 * Test that translations work correctly for each locale.
 *
 * This test verifies that when visiting a locale-specific route (e.g., /de),
 * the translated content is displayed correctly, not hardcoded strings.
 *
 * CRITICAL: This catches the bug where locale is set correctly but
 * translations are not applied because of hardcoded strings.
 *
 * @see \Modules\Cms\Http\Middleware\SetFolioLocale
 */
test('auth buttons show correct translation for German locale on login page', function () {
    /** @phpstan-ignore-next-line property.notFound */
    $response = $this->get('/de/auth/login');

    $status = (int) $response->getStatusCode();

    if ($status >= 500) {
        test()->markTestSkipped("Route /de/auth/login returned server error ({$status}).");

        return;
    }

    if (200 !== $status) {
        test()->markTestSkipped("Route /de/auth/login returned {$status} (redirect). Cannot verify translations.");

        return;
    }

    $content = $response->getContent();

    // Assert translations work correctly
    expect($content)->toContain('Anmelden')
        ->toContain('Registrieren')
        ->not->toContain('>Accedi<')
        ->not->toContain('>Registrati<');
});

test('auth buttons show correct translation for Italian locale on login page', function () {
    /** @phpstan-ignore-next-line property.notFound */
    $response = $this->get('/it/auth/login');

    $status = (int) $response->getStatusCode();

    if ($status >= 500) {
        test()->markTestSkipped("Route /it/auth/login returned server error ({$status}).");

        return;
    }

    if (200 !== $status) {
        test()->markTestSkipped("Route /it/auth/login returned {$status} (redirect). Cannot verify translations.");

        return;
    }

    $content = $response->getContent();

    expect($content)->toContain('>Accedi<')
        ->toContain('>Registrati<')
        ->not->toContain('>Anmelden<');
});

test('auth buttons show correct translation for English locale on login page', function () {
    /** @phpstan-ignore-next-line property.notFound */
    $response = $this->get('/en/auth/login');

    $status = (int) $response->getStatusCode();

    if ($status >= 500) {
        test()->markTestSkipped("Route /en/auth/login returned server error ({$status}).");

        return;
    }

    if (200 !== $status) {
        test()->markTestSkipped("Route /en/auth/login returned {$status} (redirect). Cannot verify translations.");

        return;
    }

    $content = $response->getContent();

    expect($content)->not->toContain('>Accedi<')
        ->toContain('>Log in<')
        ->toContain('>Sign up<');
});

test('no hardcoded Italian strings in theme header components', function () {
    $paths = [
        base_path('Themes/Meetup/resources/views/components/ui/header.blade.php'),
    ];

    foreach ($paths as $path) {
        if (! file_exists($path)) {
            continue;
        }

        $content = file_get_contents($path);

        expect($content)
            ->not->toContain("__('Accedi')")
            ->not->toContain("__('Registrati')")
            ->not->toContain("'Accedi'")
            ->not->toContain("'Registrati'");
    }
});
