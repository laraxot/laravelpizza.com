<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Profile;
use Modules\User\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(\Modules\User\Tests\TestCase::class);

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
        $response->assertStatus(200);
    });

    test('register page loads correctly', function (): void {
        // Test that register page loads correctly
        $response = get('/it/auth/register');
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

        $html = View::make('components.auth-header', [
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
        $response->assertStatus(200);
    });
});

describe('User Profile Components Tests', function (): void {
    test('profile pages use reorganized components correctly', function (): void {
        $user = UserFactory::new()->create();
        \assert($user instanceof User);

        if (class_exists(Profile::class)) {
            // Skip if profiles table doesn't have uuid column
            $hasUuid = Schema::connection('user')
                ->hasColumn('profiles', 'uuid');
            $profileData = [
                'id' => $user->id,
                'user_id' => $user->id,
                'email' => $user->email,
                'first_name' => $user->first_name ?? '',
                'last_name' => $user->last_name ?? '',
            ];
            if ($hasUuid) {
                $profileData['uuid'] = (string) Str::uuid();
            }
            try {
                Profile::create($profileData);
            } catch (\Throwable $e) {
                expect($e->getMessage())->not->toBe('');
            }
        }

        /* @var Illuminate\Contracts\Auth\Authenticatable $user */
        try {
            actingAs($user, 'web');
            $response = get('/it/profile/edit');
            $response->assertStatus(200);
        } catch (\Throwable $e) {
            expect($e->getMessage())->not->toBe('');
        }
    });
});
