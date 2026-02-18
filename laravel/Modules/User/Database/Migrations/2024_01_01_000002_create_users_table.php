<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Class CreateLiveuserUsersTable.
 */
return new class extends XotBaseMigration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            // $table->uuid('id')->primary();
            $table->string('id', 36)->primary();
            $table->string('name');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(); // se entra con sso
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->softDeletes();
        });
        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('first_name')) {
                $table->string('first_name')->after('name')->nullable();
            } else {
                $table->string('first_name')->nullable()->change();
            }

            if (! $this->hasColumn('last_name')) {
                $table->string('last_name')->after('name')->nullable();
            } else {
                $table->string('last_name')->nullable()->change();
            }

            if (! $this->hasColumn('current_team_id')) {
                $table->foreignId('current_team_id')->nullable();
            }

            if (! $this->hasColumn('profile_photo_path')) {
                $table->string('profile_photo_path', 2048)->nullable();
            }

            if (! $this->hasColumn('lang')) {
                $table->string('lang', 3)->nullable();
            }

            if (! $this->hasColumn('type')) {
                $table->string('type')->index()->nullable();
            }

            if (! $this->hasColumn('is_active')) {
                $table->boolean('is_active')->default(true);
            }

            if (! $this->hasColumn('is_otp')) {
                $table->boolean('is_otp')->default(false);
            }

            if (! $this->hasColumn('password_expires_at')) {
                $table->timestamp('password_expires_at')->nullable();
            }
            if ($this->hasColumn('password')) {
                $table->string('password')->nullable()->change();
            }

            if ('uuid' === $this->getColumnType('id')) {
                Schema::disableForeignKeyConstraints();

                $table->dropPrimary(['id']);
                $table->string('id', 36)->nullable()->change();
                $table->primary('id');

                Schema::enableForeignKeyConstraints();
            }
            // $this->updateUser($table);
            $this->updateTimestamps($table, true);
        });
    }
};
