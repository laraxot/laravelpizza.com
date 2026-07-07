<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Livewire\Component;
use Livewire\Features\SupportTesting\Testable;

// This file provides stubs for Pest Laravel and Livewire global functions for PHPStan analysis.
// It is intended to resolve 'function.notFound' errors without modifying phpstan.neon.

if (! function_exists('actingAs')) { // Changed from Pest\Laravel\actingAs
    /**
     * Authenticate as a given user.
     *
     * @return TestResponse<Response>
     */
    function actingAs(Authenticatable $user, ?string $driver = null): TestResponse
    {
        throw new RuntimeException('Stub not intended for runtime use');
    }
}

if (! function_exists('livewire')) { // Changed from Pest\Laravel\livewire
    /**
     * Create a new Livewire test helper instance.
     *
     * @param  array<string, mixed>  $params
     * @return Testable<Component>
     */
    function livewire(string $component, array $params = []): Testable
    {
        throw new RuntimeException('Stub not intended for runtime use');
    }
}

// Add other Pest Laravel/Livewire global functions as needed
