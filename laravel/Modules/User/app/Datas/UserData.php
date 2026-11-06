<?php

declare(strict_types=1);

namespace Modules\User\Datas;

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Spatie\LaravelData\Data;

/**
 * Schema di `users`.
 *
 * `createColumns` nasce con la tabella. `updateColumns` aggiunge le stesse
 * colonne solo se mancano, così una installazione già in vita resta integra.
 * `type` distingue il cittadino (`customer_user`) dagli altri profili.
 */
class UserData extends Data
{
    public static function createColumns(Blueprint $table, XotBaseMigration $migration): void
    {
        $table->uuid('id')->primary();
        $table->string('name')->nullable();
        $table->string('first_name')->nullable();
        $table->string('last_name')->nullable();
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password')->nullable();
        $table->text('two_factor_secret')->nullable();
        $table->text('two_factor_recovery_codes')->nullable();
        $table->timestamp('two_factor_confirmed_at')->nullable();
        $table->rememberToken();
        $table->unsignedBigInteger('current_team_id')->nullable();
        $table->string('profile_photo_path')->nullable();
        $table->string('lang')->nullable();
        $table->string('type')->nullable()->index();
        $table->string('state')->nullable();
        $table->boolean('is_active')->default(true);
        $table->boolean('is_otp')->default(false);
        $table->timestamp('password_expires_at')->nullable();
        $migration->updateTimestamps($table, true);
    }

    public static function updateColumns(Blueprint $table, XotBaseMigration $migration): void
    {
        if (! $migration->hasColumn('id')) {
            $table->uuid('id')->primary();
        }
        if (! $migration->hasColumn('name')) {
            $table->string('name')->nullable();
        }
        if (! $migration->hasColumn('first_name')) {
            $table->string('first_name')->nullable();
        }
        if (! $migration->hasColumn('last_name')) {
            $table->string('last_name')->nullable();
        }
        if (! $migration->hasColumn('email')) {
            $table->string('email')->unique();
        }
        if (! $migration->hasColumn('email_verified_at')) {
            $table->timestamp('email_verified_at')->nullable();
        }
        if (! $migration->hasColumn('password')) {
            $table->string('password')->nullable();
        }
        if (! $migration->hasColumn('two_factor_secret')) {
            $table->text('two_factor_secret')->nullable();
        }
        if (! $migration->hasColumn('two_factor_recovery_codes')) {
            $table->text('two_factor_recovery_codes')->nullable();
        }
        if (! $migration->hasColumn('two_factor_confirmed_at')) {
            $table->timestamp('two_factor_confirmed_at')->nullable();
        }
        if (! $migration->hasColumn('remember_token')) {
            $table->rememberToken();
        }
        if (! $migration->hasColumn('current_team_id')) {
            $table->unsignedBigInteger('current_team_id')->nullable();
        }
        if (! $migration->hasColumn('profile_photo_path')) {
            $table->string('profile_photo_path')->nullable();
        }
        if (! $migration->hasColumn('lang')) {
            $table->string('lang')->nullable();
        }
        if (! $migration->hasColumn('type')) {
            $table->string('type')->nullable()->index();
        }
        if (! $migration->hasColumn('state')) {
            $table->string('state')->nullable();
        }
        if (! $migration->hasColumn('is_active')) {
            $table->boolean('is_active')->default(true);
        }
        if (! $migration->hasColumn('is_otp')) {
            $table->boolean('is_otp')->default(false);
        }
        if (! $migration->hasColumn('password_expires_at')) {
            $table->timestamp('password_expires_at')->nullable();
        }

        $migration->updateTimestamps($table, true);
    }
}
