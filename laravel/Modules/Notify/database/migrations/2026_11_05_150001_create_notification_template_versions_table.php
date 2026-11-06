<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Notify\Models\NotificationTemplateVersion;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Owner migration `Notify::notification_template_versions` (schema drift
 * round 2, story notify-missing-tables-columns).
 *
 * Storico versioni di NotificationTemplate: `template_id` e' `uuid` perche'
 * `notification_templates.id` e' UUID (`$incrementing = false`). Le colonne
 * `channels`/`variables`/`conditions` sono JSON come nel modello (casts
 * `array`). Modello, factory, seeder e test esistevano gia'; mancava lo schema.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = NotificationTemplateVersion::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->uuid('template_id')->nullable()->index();
            $table->text('subject')->nullable();
            $table->text('body_html')->nullable();
            $table->text('body_text')->nullable();
            $table->json('channels')->nullable();
            $table->json('variables')->nullable();
            $table->json('conditions')->nullable();
            $table->integer('version')->nullable();
            $table->text('change_notes')->nullable();

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
