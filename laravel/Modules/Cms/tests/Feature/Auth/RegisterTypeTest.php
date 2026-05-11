<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\TestCase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(TestCase::class);

/*
 * Tests for dynamic registration pages rendered by Themes/One
 * Route pattern: /{locale}/auth/{type}/register
 *
 * This test suite verifies that:
 * 1. Registration pages render correctly for each user type
 * 2. Authentication rules are enforced (guests can access, authenticated users are redirected)
 * 3. Dynamic content is correctly displayed based on user type
 * 4. Required components (Livewire widget) are present
 *
 * The Cms module must remain independent from <main module>; all user operations
 * go through XotData to obtain the correct User class.
 */

// NOTE: Helper functions moved to Modules\Xot\Tests\TestCase for DRY pattern
// Use $this->createTestUser()

// Dataset statico per tipi utente comuni
dataset('userTypes', [
    'doctor' => ['doctor'],
    'patient' => ['patient'],
]);

describe('Registration Page Access', function () {
    test('guest can view :type registration page', static function (string $type): void {
        $response = get("/it/auth/{$type}/register");
        expect($response->status())->toBe(200);
    })->with('userTypes');

    test('authenticated user is redirected from :type registration page', function (string $type): void {
        $user = $this->createTestUser();
        actingAs($user);

        $response = get("/it/auth/{$type}/register");
        expect($response->status())->toBe(302);
    })->with('userTypes');
});

describe('Registration Page Content', static function () {
    test(':type registration page contains expected elements', static function (string $type): void {
        $response = get("/it/auth/{$type}/register");

        expect($response->status())->toBe(200);

        $content = $response->getContent();
        expect($content)->toContain('Registrazione')->toContain('Crea il tuo account');
    })->with('userTypes');

    test(':type registration page has proper HTML structure', static function (string $type): void {
        $response = get("/it/auth/{$type}/register");

        $content = $response->getContent();
        expect($content)
            ->toContain('<!DOCTYPE html>')
            ->toContain('<html')
            ->toContain('</html>')
            ->toContain('<meta name="viewport"')
            ->toContain('width=device-width');
    })->with('userTypes');
});

describe('Registration Page Localization', static function () {
    test(':type registration page uses Italian localization', static function (string $type): void {
        $response = get("/it/auth/{$type}/register");

        expect($response->status())->toBe(200);

        $content = $response->getContent();
        expect($content)->toContain('Registrazione')->toContain('Crea il tuo account');
    })->with('userTypes');
});

describe('Registration Page Performance', static function () {
    test(':type registration page loads within acceptable time limits', static function (string $type): void {
        $startTime = microtime(true);

        $response = get("/it/auth/{$type}/register");

        $loadTime = microtime(true) - $startTime;

        expect($response->status())->toBe(200);
        expect($loadTime)->toBeLessThan(3.0);
    })->with('userTypes');
});
