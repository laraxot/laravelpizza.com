<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;
use Modules\Gdpr\Providers\GdprServiceProvider;
use Modules\User\Models\User;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Gdpr module tests.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Configure SQLite in memory for testing
        $this->app['config']->set('database.default', 'testing');
        $this->app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Configure the 'user' connection for the User model
        $this->app['config']->set('database.connections.user', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Configure the 'gdpr' connection for GDPR models
        $this->app['config']->set('database.connections.gdpr', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Run the GDPR module migrations on the gdpr connection
        $this->artisan('migrate', [
            '--database' => 'gdpr',
            '--path' => realpath(__DIR__.'/../database/migrations'),
        ]);

        // Run Laravel's default migrations (including users table) on the 'user' connection
        $this->artisan('migrate', [
            '--database' => 'user',
            '--path' => database_path('migrations'),
        ]);

        // If the users table still doesn't exist on 'user' connection, create it manually
        if (!Schema::connection('user')->hasTable('users')) {
            Schema::connection('user')->create('users', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->boolean('is_otp')->default(false);
                $table->boolean('is_active')->default(true);
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('name')->nullable();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('remember_token')->nullable();
                $table->string('lang')->nullable();
                $table->timestamp('password_expires_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Get package providers.
     *
     * @param  Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            GdprServiceProvider::class,
            UserServiceProvider::class,
            XotServiceProvider::class,
        ];
    }
}