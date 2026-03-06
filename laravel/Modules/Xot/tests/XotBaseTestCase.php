<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
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
    use DatabaseTransactions;

    /**
     * Shared transactional connections for module tests.
     *
     * @var array<int, string>
     */
    protected array $connectionsToTransact = ['mysql', 'activity', 'user'];

    /**
     * Flag to ensure migrations run only once per test process.
     */
    protected static bool $migrated = false;

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

        $this->runModuleMigrations();

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
     * Run module-specific migrations.
     * Centralized to run ONCE per test execution to prepare .env.testing databases.
     */
    protected function runModuleMigrations(): void
    {
        if (! static::$migrated) {
            $this->artisan('migrate', ['--env' => 'testing', '--force' => true]);
            static::$migrated = true;
        }
    }

    protected function tearDown(): void
    {
        // Prevent connection accumulation across a long multi-connection suite.
        try {
            if (isset($this->app)) {
                /** @var \Illuminate\Database\DatabaseManager $db */
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
     * @return class-string<\Illuminate\Database\Eloquent\Model&UserContract>
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
}
