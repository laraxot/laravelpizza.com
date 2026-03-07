<?php

declare(strict_types=1);

namespace Modules\User\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for User module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped by TenantServiceProvider.
 * Migrations must be run ONCE externally: php artisan migrate --env=testing
 * DatabaseTransactions handles rollback between tests.
 *
 * NOTE: DatabaseTransactions trait is already included in XotBaseTestCase.
 * Do NOT add it again - it would be redundant.
 */
abstract class TestCase extends XotBaseTestCase
{
    protected static bool $userSchemaBootstrapped = false;

    /**
     * The database connections that should have transactions rolled back.
     *
     * @var array<int, string>
     */
    protected array $connectionsToTransact = ['mysql', 'activity', 'user'];

    protected function setUp(): void
    {
        parent::setUp();

        if (! self::$userSchemaBootstrapped) {
            $this->bootstrapUserTestingSchema();
            self::$userSchemaBootstrapped = true;
        }
    }

    private function bootstrapUserTestingSchema(): void
    {
        $schema = Schema::connection('user');

        if (! $schema->hasTable('users')) {
            $schema->create('users', function (Blueprint $table): void {
                $table->string('id', 36)->primary();
                $table->string('name')->nullable();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password')->nullable();
                $table->string('remember_token', 100)->nullable();
                $table->boolean('is_active')->default(true);
                $table->boolean('is_otp')->default(false);
                $table->string('lang', 5)->default('it');
                $table->string('type')->default('customer_user');
                $table->string('state')->default('active');
                $table->timestamps();
            });
        }

        if (! $schema->hasTable('socialite_users')) {
            $schema->create('socialite_users', function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('user_id', 36)->nullable();
                $table->string('provider');
                $table->string('provider_id');
                $table->string('token')->nullable();
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->string('avatar')->nullable();
                $table->timestamps();
            });
        }

        if (! $schema->hasTable('oauth_refresh_tokens')) {
            $schema->create('oauth_refresh_tokens', function (Blueprint $table): void {
                $table->string('id', 100)->primary();
                $table->string('access_token_id', 100)->index();
                $table->boolean('revoked')->default(false);
                $table->dateTime('expires_at')->nullable();
            });
        }

        if (! $schema->hasTable('device_user')) {
            $schema->create('device_user', function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('device_id', 36)->nullable();
                $table->string('user_id', 36)->index();
                $table->dateTime('logout_at')->nullable();
                $table->timestamps();
            });
        }

        if (! $schema->hasTable('roles')) {
            $schema->create('roles', function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('guard_name')->default('web');
                $table->unsignedBigInteger('team_id')->nullable();
                $table->timestamps();
            });
        }

        if (! $schema->hasTable('model_has_role')) {
            $schema->create('model_has_role', function (Blueprint $table): void {
                $table->unsignedBigInteger('role_id');
                $table->string('model_type');
                $table->string('model_id', 36);
                $table->unsignedBigInteger('team_id')->nullable();
                $table->index(['model_id', 'model_type'], 'model_has_role_model_id_model_type_index');
                $table->index(['role_id'], 'model_has_role_role_id_index');
            });
        }
    }
}
