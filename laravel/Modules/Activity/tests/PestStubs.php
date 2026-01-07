<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\TestResponse;
use Livewire\Features\SupportTesting\Testable;

// This file provides stubs for Pest Laravel and Livewire global functions for PHPStan analysis.
// It is intended to resolve 'function.notFound' errors without modifying phpstan.neon.

if (! function_exists('actingAs')) { // Changed from Pest\Laravel\actingAs
    /**
     * Authenticate as a given user.
     *
     * @param  Authenticatable|Model  $user
     */
    function actingAs(Authenticatable $user, ?string $driver = null): TestResponse
    {
        return test()->actingAs($user, $driver);
    }
}

if (! function_exists('livewire')) { // Changed from Pest\Laravel\livewire
    /**
     * Create a new Livewire test helper instance.
     */
    function livewire(string $component, array $params = []): Testable
    {
        return test()->livewire($component, $params);
    }
}

// Add other Pest Laravel/Livewire global functions as needed
