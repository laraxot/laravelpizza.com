<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Notify\Models\NotificationLog;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Allinea `notification_logs` allo schema canonico nei DB creati dalla variante
 * legacy (`2025_03_31_000001`, schema `title/content/channels`) prima del rewrite
 * in place del 2026-07-22.
 *
 * `tableCreate()` salta le tabelle esistenti, quindi le tre create successive non
 * hanno mai aggiunto le colonne canoniche: model e factory (`template_id`,
 * `channel`, `metadata`, `tenant_id`, `delivered_at`…) scrivono colonne assenti.
 * Verdetto consolidato in `docs/wiki/decisions/notification-logs-migration-consolidation.md`:
 * lo schema del model vince.
 *
 * Strategia data-sacred: le colonne legacy (`title`, `content`, `channels`,
 * `error`) restano ma diventano nullable — i nuovi insert canonici non le
 * valorizzano e i dati esistenti non vengono toccati ne' droppati.
 * `notifiable_id` passa da bigint a string(36) come da morph canonico: i valori
 * legacy interi restano leggibili come stringhe, nessun cast distruttivo.
 *
 * @see Modules/Notify/docs/wiki/decisions/notification-logs-migration-consolidation.md
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = NotificationLog::class;

    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('template_id')) {
                $table->string('template_id')->nullable()->index();
            }

            if (! $this->hasColumn('channel')) {
                $table->string('channel')->nullable();
            }

            if (! $this->hasColumn('status_message')) {
                $table->string('status_message')->nullable();
            }

            if (! $this->hasColumn('metadata')) {
                $table->json('metadata')->nullable();
            }

            if (! $this->hasColumn('tenant_id')) {
                $table->string('tenant_id')->nullable();
            }

            foreach (['delivered_at', 'failed_at', 'opened_at', 'clicked_at'] as $timestamp) {
                if (! $this->hasColumn($timestamp)) {
                    $table->timestamp($timestamp)->nullable();
                }
            }

            // Colonne legacy NOT NULL: resesi nullable per non rompere gli insert
            // canonici che non le valorizzano (dati preservati, niente drop).
            // Tipi preservati: title resta varchar, channels resta longtext.
            if ($this->hasColumn('title')) {
                $table->string('title')->nullable()->change();
            }

            if ($this->hasColumn('content')) {
                $table->text('content')->nullable()->change();
            }

            if ($this->hasColumn('channels')) {
                $table->longText('channels')->nullable()->change();
            }

            if ($this->hasColumn('sent_at')) {
                $table->timestamp('sent_at')->nullable()->change();
            }

            if ($this->hasColumn('notifiable_id') && $this->getColumnType('notifiable_id') === 'bigint') {
                $table->string('notifiable_id', 36)->change();
            }

            if ($this->hasColumn('status')) {
                $table->string('status')->default('pending')->change();
            }
        });

        $this->ensureIndexes([
            'notification_logs' => [
                'notification_logs_channel_index' => ['channel'],
                'notification_logs_status_index' => ['status'],
                'notification_logs_sent_at_index' => ['sent_at'],
                'notification_logs_notifiable_index' => ['notifiable_type', 'notifiable_id'],
            ],
        ]);
    }
};
