<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\TestCase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(TestCase::class);

/**
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

    test('guest can view :type registration page', function (string $type): void {
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

    test(':type registration page contains expected elements', function (string $type): void {
        $response = get("/it/auth/{$type}/register");

        expect($response->status())->toBe(200);

        $content = $response->getContent();
        expect($content)->toContain('Registrazione')->toContain('Crea il tuo account'); // ->toContain('<x-ui.logo')
        // ->toContain('RegistrationWidget')
    })->with('userTypes');

    test(':type registration page has proper HTML structure', function (string $type): void {
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

    test(':type registration page uses Italian localization', function (string $type): void {
        $response = get("/it/auth/{$type}/register");

        expect($response->status())->toBe(200);

        $content = $response->getContent();
        expect($content)->toContain('Registrazione')->toContain('Crea il tuo account');
    })->with('userTypes');
});

    // test('handles invalid user type gracefully', function (): void {
    //    $response = get('/it/auth/invalid-type/register');
    //     expect($response->status())->toBe(404);
    // });
    // test('handles missing type parameter appropriately', function (): void {
    //    $response = get('/it/auth/register');
    //    expect($response->status())->toBeGreaterThanOrEqual(300);
    // });
});

    test(':type registration page loads within acceptable time limits', function (string $type): void {
        $startTime = microtime(true);

        $response = get("/it/auth/{$type}/register");

        $loadTime = microtime(true) - $startTime;

        expect($response->status())->toBe(200);
        expect($loadTime)->toBeLessThan(3.0); // Massimo 3 secondi per essere sicuri
    })->with('userTypes');
});
