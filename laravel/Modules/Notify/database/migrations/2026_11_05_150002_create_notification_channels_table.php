<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Notify\Models\NotificationChannel;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Owner migration `Notify::notification_channels` (schema drift round 2,
 * story notify-missing-tables-columns).
 *
 * Canali di consegna notifiche (email, sms, push, ...): `config` e' JSON
 * (cast `array` sul modello), `is_enabled` boolean, `priority` intero.
 * Modello, factory, seeder e test esistevano gia'; mancava solo lo schema.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = NotificationChannel::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('driver')->nullable();
            $table->json('config')->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->integer('priority')->default(0);

            // created_by/updated_by come stringa (convenzione mail_template_versions).
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table, false);
        });
    }
};
