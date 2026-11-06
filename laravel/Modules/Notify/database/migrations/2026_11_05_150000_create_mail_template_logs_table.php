<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Notify\Models\MailTemplateLog;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Owner migration `Notify::mail_template_logs` (schema drift round 2,
 * story notify-missing-tables-columns).
 *
 * Tabella di audit per ogni invio di MailTemplate: stato, destinatario morph
 * (`mailable_type`/`mailable_id`, tipo `string` come in `notification_logs`
 * per coprire id interi e UUID) e timestamp di delivery. Modello, factory,
 * seeder e test esistevano gia'; mancava solo lo schema.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = MailTemplateLog::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('template_id')->nullable()->index();
            $table->string('mailable_type')->nullable();
            $table->string('mailable_id')->nullable();
            $table->string('status')->default('pending');
            $table->string('status_message')->nullable();
            $table->json('data')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('clicked_at')->nullable();

            // created_by/updated_by come stringa (convenzione mail_template_versions):
            // i test scrivono identificativi testuali, non FK rigid.
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->index(['mailable_type', 'mailable_id']);
            $table->index('status');
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table, false);
        });
    }
};
