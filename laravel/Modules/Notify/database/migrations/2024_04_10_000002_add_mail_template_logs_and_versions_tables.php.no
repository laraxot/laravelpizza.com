<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class () extends XotBaseMigration {
    public function up(): void
    {
        // Tabella per le versioni dei template
        $this->tableCreate(
            'mail_template_versions',
            function (Blueprint $table): void {
                $table->id();
                $table->foreignId('template_id')->constrained('mail_templates')->cascadeOnDelete();
                $table->string('mailable');
                $table->text('subject')->nullable();
                $table->longText('html_template');
                $table->longText('text_template')->nullable();
                $table->unsignedInteger('version');
                $table->string('created_by');
                $table->text('change_notes')->nullable();
                $table->timestamps();

                $table->unique(['template_id', 'version']);
            }
        );

        // Tabella per i log dei template
        $this->tableCreate(
            'mail_template_logs',
            function (Blueprint $table): void {
                $table->id();
                $table->foreignId('template_id')->nullable()->constrained('mail_templates');
                $table->morphs('mailable');
                $table->string('status');
                $table->text('status_message')->nullable();
                $table->json('data')->nullable();
                $table->json('metadata')->nullable();
                $table->timestamp('sent_at')->nullable();
                $table->timestamp('delivered_at')->nullable();
                $table->timestamp('failed_at')->nullable();
                $table->timestamp('opened_at')->nullable();
                $table->timestamp('clicked_at')->nullable();
                $table->timestamps();

                $table->index(['status']);
                $table->index(['mailable_type', 'mailable_id']);
            }
        );

        // Aggiungo la colonna version alla tabella mail_templates
        $this->tableUpdate(
            'mail_templates',
            function (Blueprint $table): void {
                $table->unsignedInteger('version')->default(1)->after('text_template');
            }
        );
    }
};
