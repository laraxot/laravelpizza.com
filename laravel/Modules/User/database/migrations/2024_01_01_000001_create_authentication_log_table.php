<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\AuthenticationLog;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Owner migration for authentication_logs on connection `user`
 * (DB_DATABASE_USER / fixcity_user). Never create this table on fixcity_data.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = AuthenticationLog::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->uuidMorphs('authenticatable', 'k_auth_log_morph');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('login_at')->nullable();
            $table->boolean('login_successful')->default(false);
            $table->timestamp('logout_at')->nullable();
            $table->boolean('cleared_by_user')->default(false);
            $table->json('location')->nullable();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table);
        });
    }
};
