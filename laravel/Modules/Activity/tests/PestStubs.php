<?php

declare(strict_types=1);

// This file provides stubs for Pest Laravel and Livewire global functions for PHPStan analysis.
// It is intended to resolve 'function.notFound' errors without modifying phpstan.neon.

if (! function_exists('actingAs')) { // Changed from Pest\Laravel\actingAs
    /**
     * Authenticate as a given user.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Database\Eloquent\Model $user
     * @param string|null $driver
     * @return \Illuminate\Testing\TestResponse
     */
    function actingAs(\Illuminate\Contracts\Auth\Authenticatable $user, string $driver = null): \Illuminate\Testing\TestResponse
    {
        return test()->actingAs($user, $driver);
    }
}

if (! function_exists('livewire')) { // Changed from Pest\Laravel\livewire
    /**
     * Create a new Livewire test helper instance.
     *
     * @param string $component
     * @param array $params
     * @return \Livewire\Features\SupportTesting\Testable
     */
    function livewire(string $component, array $params = []): \Livewire\Features\SupportTesting\Testable
    {
        return test()->livewire($component, $params);
    }
}

// Add other Pest Laravel/Livewire global functions as needed
