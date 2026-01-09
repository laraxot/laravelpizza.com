<?php

declare(strict_types=1);

use Illuminate\Support\Facades\View;
use Modules\User\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(Modules\User\Tests\TestCase::class);

describe('Auth Components Tests', function (): void {
    test('auth components exist and work correctly', function (): void {
        // Test existing auth components
        expect(View::exists('components.auth-session-status'))->toBeTrue();
        expect(View::exists('components.auth-header'))->toBeTrue();
        expect(View::exists('user::components.auth-session-status'))->toBeTrue();
    });

    test('auth layout components exist and work correctly', function (): void {
        // Test auth layout components that actually exist
        expect(View::exists('components.layouts.auth'))->toBeTrue();
        expect(View::exists('user::layouts.auth'))->toBeTrue();
    });

    test('login page loads correctly', function (): void {
        // Test that login page loads correctly
        $response = get('/it/auth/login');
        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertStatus(200);
    });

    test('register page loads correctly', function (): void {
        // Test that register page loads correctly
        $response = get('/it/auth/register');
        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertStatus(200);
    });

    test('auth-session-status component renders correctly', function (): void {
        // Test the existing auth-session-status component rendering
        $html = view('components.auth-session-status', ['status' => 'Test status'])->render();

        expect($html)->toBeString();
        expect($html)->not->toBeEmpty();
    });

    test('auth header component exists and renders', function (): void {
        // Test the auth header component that exists
        expect(View::exists('components.auth-header'))->toBeTrue();

        $html = view('components.auth-header', [
            'title' => 'Login Test',
            'description' => 'Test description',
        ])->render();

        expect($html)->toContain('Login Test');
        expect($html)->toContain('Test description');
    });
});

describe('Authentication Flow with Reorganized Components', function (): void {
    test('login form components work after reorganization', function (): void {
        // Visit login page and ensure all reorganized components render
        $response = get('/it/auth/login');

        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertStatus(200);
        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertSee('Login');
    });

    test('password confirmation uses reorganized components', function (): void {
        /** @var User */
        $user = User/* @phpstan-ignore-line */ ::factory()->create();

        actingAs($user)
            ->get('/it/auth/password/confirm')
            ->assertStatus(200);
    });
});

describe('User Profile Components Tests', function (): void {
    test('profile pages use reorganized components correctly', function (): void {
        /** @var User */
        $user = User/* @phpstan-ignore-line */ ::factory()->create();

        $response = actingAs($user)->get('/it/profile/edit');

        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertStatus(200);
    });
});
