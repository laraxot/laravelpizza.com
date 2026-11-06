<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Notify\Models\MailTemplate;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Update `Notify::mail_templates` (schema drift round 2,
 * story notify-missing-tables-columns).
 *
 * Aggiunge `whatsapp_template` (JSON nullable): presente in `$fillable` del
 * modello e in `MailTemplateInfolist`, mai migrata. Le create esistenti non
 * si toccano (regola one-migration-per-model-bump-timestamp).
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = MailTemplate::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('whatsapp_template')) {
                $table->json('whatsapp_template')->nullable();
            }
        });
    }
};
