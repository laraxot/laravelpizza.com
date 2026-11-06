<?php

declare(strict_types=1);
use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('template_id')->nullable()->index();
            $table->string('notifiable_type');
            $table->string('notifiable_id');
            $table->string('channel');
            $table->string('status')->default('pending');
            $table->string('status_message')->nullable();
            $table->json('data')->nullable();
            $table->json('metadata')->nullable();
            $table->string('tenant_id')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('clicked_at')->nullable();

            $table->index(['notifiable_type', 'notifiable_id']);
            $table->index('channel');
            $table->index('status');
            $table->index('sent_at');
        });

        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table, false);
        });
    }
};
