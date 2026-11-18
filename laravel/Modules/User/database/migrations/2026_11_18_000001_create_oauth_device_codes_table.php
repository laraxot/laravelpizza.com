<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\OauthDeviceCode;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Codici del device authorization grant di Passport 13 (stessa struttura di
 * vendor/laravel/passport/database/migrations/2024_06_01_000001_create_oauth_device_codes_table.php),
 * sul database utenti come le altre tabelle OAuth. Mancava: /user/admin/passport/oauth-device-codes dava 500.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = OauthDeviceCode::class;

    public function up(): void
    {
        $this->tableCreate(static function (Blueprint $table): void {
            $table->char('id', 80)->primary();
            $table->string('user_id', 36)->nullable()->index();
            $table->uuid('client_id')->index();
            $table->char('user_code', 8)->unique();
            $table->text('scopes');
            $table->boolean('revoked');
            $table->dateTime('user_approved_at')->nullable();
            $table->dateTime('last_polled_at')->nullable();
            $table->dateTime('expires_at')->nullable();
        });
    }
};
