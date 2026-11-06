<?php

declare(strict_types=1);
use Illuminate\Database\Schema\Blueprint;
// ----- bases ----
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateMailTemplatesTable.
 *
 * Consolidated migration for mail_templates table following "1 Table = 1 Migration File" rule.
 */
/**
 * Owner migration `Notify::mail_templates` (consolidamento 2026-09-01).
 * Colonne unione viste nei duplicati non presenti qui: nessuna.
 *
 * Evoluzione 2026-09-10 (story quaeris-send-invite-migrate-to-record-notification.md,
 * Difetto 9): aggiunta `sms_from` — mittente SMS per template, prima fisso a "Xot"
 * in `RecordNotification::toSms()`. Timestamp del filename bumpato come da
 * bashscripts/ai/wiki/memories/one-migration-per-model-bump-timestamp.md.
 */
return new class extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        if (! $this->tableExists()) {
            $this->getConn()->create($this->getTable(), function (Blueprint $table): void {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('mailable')->nullable();
                $table->string('slug')->unique()->nullable();
                $table->json('subject')->nullable();
                $table->json('html_template')->nullable();
                $table->json('text_template')->nullable();
                $table->string('version')->default('1.0.0');
            });
        }

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('name')) {
                $table->string('name')->nullable();
            }
            if (! $this->hasColumn('slug')) {
                $table->string('slug')->unique()->nullable();
            }
            if (! $this->hasColumn('params')) {
                $table->text('params')->nullable();
            }
            if (! $this->hasColumn('sms_template')) {
                $table->json('sms_template')->nullable();
            }
            if (! $this->hasColumn('sms_from')) {
                $table->string('sms_from')->nullable();
            }
            if (! $this->hasColumn('counter')) {
                $table->integer('counter')->default(0);
            }
            if (! $this->hasColumn('html_layout_path')) {
                $table->string('html_layout_path')->nullable();
            }
            if (! $this->hasColumn('version')) {
                $table->string('version')->default('1.0.0');
            }

            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
