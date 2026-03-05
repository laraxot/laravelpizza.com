<?php

declare(strict_types=1);

namespace Modules\User\Tests\Support;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait EnsuresUserSocialiteSchema
{
    protected function ensureUserSocialiteSchema(): void
    {
        if (! Schema::connection('user')->hasTable('users')) {
            Schema::connection('user')->create('users', function (Blueprint $table): void {
                $table->string('id')->primary();
                $table->string('name')->nullable();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password')->nullable();
                $table->string('remember_token', 100)->nullable();
                $table->boolean('is_active')->default(true);
                $table->boolean('is_otp')->default(false);
                $table->string('lang')->nullable();
                $table->string('type')->nullable();
                $table->string('state')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::connection('user')->hasTable('socialite_users')) {
            Schema::connection('user')->create('socialite_users', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('user_id');
                $table->string('provider');
                $table->string('provider_id');
                $table->string('token')->nullable();
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->string('avatar')->nullable();
                $table->timestamps();
            });
        }
    }
}
