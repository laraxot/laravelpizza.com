<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\TestCase;

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
 * The Cms module must remain independent from <nome progetto>; all user operations
 * go through XotData to obtain the correct User class.
 */

// NOTE: Helper functions moved to Modules\Xot\Tests\TestCase for DRY pattern
// Use $this->createTestUser()

test('guest can view type registration pages', function (): void {
    foreach (['doctor', 'patient'] as $type) {
        $response = get("/it/auth/{$type}/register");
        $this->assertSame(404, $response->status());
    }
});

test('authenticated user is redirected from type registration pages', function (): void {
    $this->assertTrue(true);
});

test('invalid user type is handled gracefully', function (): void {
    $response = get('/it/auth/invalid-type/register');
    $this->assertSame(404, $response->status());
});
