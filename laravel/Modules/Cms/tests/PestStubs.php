<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Livewire\Component;
use Livewire\Features\SupportTesting\Testable;

// Stubs Pest/Livewire per PHPStan — non usati a runtime.
if (! function_exists('actingAs')) {
    /**
     * @return TestResponse<Response>
     */
    function actingAs(Authenticatable $user, ?string $driver = null): TestResponse
    {
        throw new RuntimeException(sprintf('Stub actingAs(%s, %s) not intended for runtime use', $user::class, $driver ?? 'default'));
    }
}

if (! function_exists('livewire')) {
    /**
     * @param array<string, mixed> $params
     *
     * @return Testable<Component>
     */
    function livewire(string $component, array $params = []): Testable
    {
        throw new RuntimeException(sprintf('Stub livewire(%s, [%s]) not intended for runtime use', $component, implode(', ', array_keys($params))));
    }
}
