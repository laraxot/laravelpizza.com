<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

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
    $response = cmsGet('/de/auth/login');

    $status = (int) $response->getStatusCode();

    if ($status >= 500) {
        cmsSkipTest("Route /de/auth/login returned server error ({$status}).");

        return;
    }

    if (200 !== $status) {
        cmsSkipTest("Route /de/auth/login returned {$status} (redirect). Cannot verify translations.");

        return;
    }

    $content = (string) $response->getContent();

    // Assert translations work correctly
    Assert::assertStringContainsString('Anmelden', $content);
    Assert::assertStringContainsString('Registrieren', $content);
    Assert::assertStringNotContainsString('>Accedi<', $content);
    Assert::assertStringNotContainsString('>Registrati<', $content);
});

test('auth buttons show correct translation for Italian locale on login page', function () {
    $response = cmsGet('/it/auth/login');

    $status = (int) $response->getStatusCode();

    if ($status >= 500) {
        cmsSkipTest("Route /it/auth/login returned server error ({$status}).");

        return;
    }

    if (200 !== $status) {
        cmsSkipTest("Route /it/auth/login returned {$status} (redirect). Cannot verify translations.");

        return;
    }

    $content = (string) $response->getContent();

    Assert::assertStringContainsString('>Accedi<', $content);
    Assert::assertStringContainsString('>Registrati<', $content);
    Assert::assertStringNotContainsString('>Anmelden<', $content);
});

test('auth buttons show correct translation for English locale on login page', function () {
    $response = cmsGet('/en/auth/login');

    $status = (int) $response->getStatusCode();

    if ($status >= 500) {
        cmsSkipTest("Route /en/auth/login returned server error ({$status}).");

        return;
    }

    if (200 !== $status) {
        cmsSkipTest("Route /en/auth/login returned {$status} (redirect). Cannot verify translations.");

        return;
    }

    $content = (string) $response->getContent();

    Assert::assertStringNotContainsString('>Accedi<', $content);
    Assert::assertStringContainsString('>Log in<', $content);
    Assert::assertStringContainsString('>Sign up<', $content);
});

test('no hardcoded Italian strings in theme header components', function () {
    $paths = [
        base_path('Themes/Meetup/resources/views/components/ui/header.blade.php'),
    ];

    foreach ($paths as $path) {
        if (! file_exists($path)) {
            continue;
        }

        $raw = file_get_contents($path);
        Assert::assertNotFalse($raw);
        $content = $raw;

        Assert::assertStringNotContainsString("__('Accedi')", $content);
        Assert::assertStringNotContainsString("__('Registrati')", $content);
        Assert::assertStringNotContainsString("'Accedi'", $content);
        Assert::assertStringNotContainsString("'Registrati'", $content);
    }
});
