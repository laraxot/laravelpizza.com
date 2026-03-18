<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Modules\Tenant\Models\Tenant;
use Modules\UI\Models\Asset;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Models\Module;
use Modules\Xot\Providers\XotServiceProvider;

/**
 * Class XotBaseTestCase.
 *
 * Base test case for all modules.
 * Note: DatabaseTransactions is already included here to be shared by all tests.
 */
abstract class XotBaseTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @return array<int, class-string<ServiceProvider>>
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
                return new Translator(
                    new ArrayLoader(),
                    'en'
                );
            });
        }
    }

    protected function tearDown(): void
    {
        // Prevent connection accumulation across a long multi-connection suite.
        try {
            if (isset($this->app)) {
                /** @var DatabaseManager $db */
                $db = $this->app->make('db');

                /** @var array<string, mixed> $connections */
                $connections = (array) config('database.connections', []);
                foreach (array_keys($connections) as $name) {
                    $db->disconnect((string) $name);
                }

                $db->disconnect();
                $db->purge();
            }
        } catch (\Throwable) {
            // Ignore teardown disconnection issues to avoid masking test failures.
        }

        parent::tearDown();
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
     * @return class-string<Model&UserContract>
     */
    protected static function getUserClass(): string
    {
        return XotData::make()->getUserClass();
    }

    /**
     * Create a test user with optional attributes.
     *
     * @param array<string, mixed> $attributes
     */
    protected static function createTestUser(array $attributes = []): UserContract
    {
        $userClass = static::getUserClass();

        return $userClass::factory()->create($attributes);
    }

    /**
     * Create a test tenant with optional attributes.
     *
     * @param array<string, mixed> $attributes
     */
    protected static function createTestTenant(array $attributes = []): Tenant
    {
        return Tenant::factory()->create($attributes);
    }

    /**
     * Create a test module with optional attributes.
     *
     * @param array<string, mixed> $attributes
     */
    protected static function createTestModule(array $attributes = []): Module
    {
        return Module::factory()->create($attributes);
    }

    /**
     * Create a test asset with optional attributes.
     *
     * @param array<string, mixed> $attributes
     */
    protected static function createTestAsset(array $attributes = []): Asset
    {
        return Asset::factory()->create($attributes);
    }
}
