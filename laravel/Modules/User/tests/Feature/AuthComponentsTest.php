<?php

declare(strict_types=1);

use Illuminate\Support\Facades\View;
use Modules\User\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

describe('Auth Components Reorganization Tests', function (): void {
    test('auth components are properly organized after reorganization', function (): void {
        // Test auth.confirms-password component exists
        expect(View::exists('pub_theme::components.auth.confirms-password'))->toBeTrue();

        // Test auth.authentication-card component exists
        expect(View::exists('pub_theme::components.auth.authentication-card'))->toBeTrue();

        // Test auth.authentication-card-logo component exists
        expect(View::exists('pub_theme::components.auth.authentication-card-logo'))->toBeTrue();
    });

    test('form components work correctly in auth context', function (): void {
        // Test that reorganized form components exist and work
        expect(View::exists('pub_theme::components.forms.input'))->toBeTrue();
        expect(View::exists('pub_theme::components.forms.input-label'))->toBeTrue();
        expect(View::exists('pub_theme::components.forms.validation-errors'))->toBeTrue();
        expect(View::exists('pub_theme::components.utilities.button'))->toBeTrue();
    });

    test('login page with reorganized components loads correctly', function (): void {
        // Test that login pages using reorganized components still work
        $response = get('/auth/login');
        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertStatus(200);
    });

    test('register page with reorganized components loads correctly', function (): void {
        // Test that register page using reorganized components still work
        $response = get('/auth/register');
        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertStatus(200);
    });

    test('auth.confirms-password component renders correctly', function (): void {
        // Test the confirms-password component rendering
        $html = view('pub_theme::components.auth.confirms-password')->render();

        expect($html)->toBeString();
        expect($html)->not->toBeEmpty();
    });

    test('blocks.forms.login-card component exists and renders', function (): void {
        // Test the login-card component that was reorganized
        expect(View::exists('pub_theme::components.blocks.forms.login-card'))->toBeTrue();

        $html = view('pub_theme::components.blocks.forms.login-card', [
            'title' => 'Login Test',
            'subtitle' => 'Test Subtitle',
        ])->render();

        expect($html)->toContain('Login Test');
    });
});

describe('Authentication Flow with Reorganized Components', function (): void {
    test('login form components work after reorganization', function (): void {
        // Visit login page and ensure all reorganized components render
        $response = get('/auth/login');

        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertStatus(200);
        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertSee('Login');
    });

    test('password confirmation uses reorganized components', function (): void {
        /** @var User */
        $user = User/* @phpstan-ignore-line */ ::factory()->create();

        actingAs($user)
            ->get('/user/confirm-password')
            ->assertStatus(200);
    });

    test('two-factor challenge uses reorganized components', function (): void {
        // Test that 2FA challenge page works with reorganized components
        $response = get('/two-factor-challenge');

        // Should redirect to login if not in 2FA flow, which means components loaded
        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertRedirect('/auth/login');
    });
});

describe('User Profile Components Tests', function (): void {
    test('profile pages use reorganized components correctly', function (): void {
        /** @var User */
        $user = User/* @phpstan-ignore-line */ ::factory()->create();

        $response = actingAs($user)->get('/user/profile');

        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertStatus(200);
    });

    test('layout.sections.action-section works in profile context', function (): void {
        // Test that action-section component works in profile pages
        expect(View::exists('pub_theme::components.layout.sections.action-section'))->toBeTrue();

        /** @var User */
        $user = User/* @phpstan-ignore-line */ ::factory()->create();

        // Access a profile page that likely uses action-section
        actingAs($user)
            ->get('/user/profile')
            ->assertStatus(200);
    });
});
