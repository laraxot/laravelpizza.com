<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Providers\XotServiceProvider;

/**
 * Class XotBaseTestCase.
 *
 * Base test case for all Laraxot modules.
 * Centralizes application bootstrapping, common bindings, and test helpers.
 * DRY + KISS + Laraxot: un solo posto per setup, mai estendere Illuminate\Foundation\Testing\TestCase.
 */
abstract class XotBaseTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Package providers for module tests (Orchestra Testbench compatibility).
     * I moduli che usano parent::getPackageProviders() ricevono XotServiceProvider.
     *
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            XotServiceProvider::class,
        ];
    }

    /**
     * Setup the test environment.
     * Binds common dependencies required by tests.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Bind translator only if not already resolved (needed for some Filament tests).
        // This ensures the application is in a consistent state for unit tests.
        if (! $this->app->bound('translator')) {
            $this->app->singleton('translator', function ($app) {
                return new \Illuminate\Translation\Translator(
                    new \Illuminate\Translation\ArrayLoader(),
                    'en'
                );
            });
        }
    }

    /**
     * Generate a unique email for tests.
     */
    protected static function generateUniqueEmail(): string
    {
        return 'test-'.uniqid((string) mt_rand(), true).'@example.com';
    }

    /**
     * Get the user class from XotData.
     *
     * @return class-string<\Illuminate\Database\Eloquent\Model&\Modules\Xot\Contracts\UserContract>
     */
    protected static function getUserClass(): string
    {
        return XotData::make()->getUserClass();
    }

    /**
     * Create a test user with optional attributes.
     *
     * @param  array<string, mixed>  $attributes
     */
    protected static function createTestUser(array $attributes = []): UserContract
    {
        $userClass = static::getUserClass();

        return $userClass::factory()->create($attributes);
    }
}
