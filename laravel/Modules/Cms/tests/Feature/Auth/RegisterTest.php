<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Modules\Xot\Tests\TestCase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(TestCase::class);

// NOTE: Helper functions moved to Modules\Xot\Tests\TestCase for DRY pattern
/* @phpstan-ignore-next-line property.notFound, method.nonObject */
// Use $this->createTestUser()

describe('Register Page', function (): void {
    test('register page renders for guest', function (): void {
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/register');
        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertStatus(200);
    });

    test('authenticated user is redirected away from register page', function (): void {
        /** @phpstan-ignore-next-line property.notFound */
        $user = $this->createTestUser();
        actingAs($user);
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/register');
        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertRedirect('/');
    });
});
