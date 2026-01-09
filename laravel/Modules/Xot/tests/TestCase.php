<?php

declare(strict_types=1);

namespace Modules\Xot\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('app.env', 'testing');

        $sqliteConnection = [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ];

        $this->app['config']->set('database.default', 'testing');
        $this->app['config']->set('database.connections.testing', $sqliteConnection);
        $this->app['config']->set('database.connections.user', $sqliteConnection);
        $this->app['config']->set('database.connections.xot', $sqliteConnection);
        $this->app['config']->set('database.connections.activity', $sqliteConnection);
        $this->app['config']->set('database.connections.job', $sqliteConnection);

        $this->app['config']->set('cache.default', 'array');
        $this->app['config']->set('session.driver', 'array');
        $this->app['config']->set('queue.default', 'sync');
        $this->app['config']->set('mail.default', 'array');

        foreach (['testing', 'user', 'xot', 'activity', 'job'] as $connectionName) {
            try {
                $pdo = DB::connection($connectionName)->getPdo();
                if (method_exists($pdo, 'sqliteCreateFunction')) {
                    $pdo->sqliteCreateFunction('md5', static fn (?string $value): ?string => $value === null ? null : md5($value));
                    $pdo->sqliteCreateFunction('unhex', static fn (?string $value): ?string => $value);
                }
            } catch (\Throwable) {
                // ignore: connection may not be initialized yet in some test contexts
            }
        }

        if (! Schema::connection('user')->hasTable('users')) {
            Schema::connection('user')->create('users', function (Blueprint $table): void {
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
                $table->timestamp('deleted_at')->nullable();
            });
        }

        if (Schema::connection('user')->hasTable('users') && ! Schema::connection('user')->hasColumn('users', 'deleted_at')) {
            Schema::connection('user')->table('users', function (Blueprint $table): void {
                $table->timestamp('deleted_at')->nullable();
            });
        }

        if (! Schema::connection('user')->hasTable('devices')) {
            Schema::connection('user')->create('devices', function (Blueprint $table): void {
                $table->id('id');
                $table->string('uuid', 36)->nullable();
                $table->string('mobile_id')->nullable();
                $table->string('languages')->nullable();
                $table->string('device')->nullable();
                $table->string('platform')->nullable();
                $table->string('browser')->nullable();
                $table->string('version')->nullable();
                $table->boolean('is_robot')->nullable();
                $table->string('robot')->nullable();
                $table->boolean('is_desktop')->nullable();
                $table->boolean('is_mobile')->nullable();
                $table->boolean('is_tablet')->nullable();
                $table->boolean('is_phone')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::connection('user')->hasTable('device_user')) {
            Schema::connection('user')->create('device_user', function (Blueprint $table): void {
                $table->unsignedBigInteger('device_id');
                $table->uuid('user_id');
                $table->timestamp('login_at')->nullable();
                $table->timestamp('logout_at')->nullable();
                $table->timestamps();
                $table->primary(['device_id', 'user_id']);
            });
        }

        if (Schema::connection('user')->hasTable('device_user') && ! Schema::connection('user')->hasColumn('device_user', 'login_at')) {
            Schema::connection('user')->table('device_user', function (Blueprint $table): void {
                $table->timestamp('login_at')->nullable();
            });
        }

        if (Schema::connection('user')->hasTable('device_user') && ! Schema::connection('user')->hasColumn('device_user', 'logout_at')) {
            Schema::connection('user')->table('device_user', function (Blueprint $table): void {
                $table->timestamp('logout_at')->nullable();
            });
        }

        if (! \is_string(config('app.key')) || config('app.key') === '') {
            $key = 'base64:'.base64_encode(str_repeat('x', 32));
            $this->app['config']->set('app.key', $key);
            $_ENV['APP_KEY'] = $key;
        }
    }
}
