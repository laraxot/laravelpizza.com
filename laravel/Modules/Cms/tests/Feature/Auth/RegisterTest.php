<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

// Helper (createTestUser, generateUniqueEmail, getUserClass) su Modules\Cms\Tests\TestCase, legato da tests/Pest.php.
// Use $this->createTestUser()

describe('Register Page', function (): void {
    test('register page renders for guest', function (): void {
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/register');
        $response->assertStatus(200);
    });

    test('authenticated user is redirected away from register page', function (): void {
        $user = $this->createTestUser();
        actingAs($user);
        $locale = app()->getLocale();
        $response = get('/'.$locale.'/auth/register');
        $response->assertRedirect('/');
    });
});
