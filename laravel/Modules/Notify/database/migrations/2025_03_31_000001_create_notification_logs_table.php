<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Esegue la migrazione.
     */
    public function up(): void
    {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->string('notifiable_type');
            $table->unsignedBigInteger('notifiable_id');
            $table->string('title');
            $table->text('content');
            $table->json('channels');
            $table->json('data')->nullable();
            $table->timestamp('sent_at');
            $table->string('status'); // sent, failed, pending
            $table->text('error')->nullable();
            $table->timestamps();

            $table->index(['notifiable_type', 'notifiable_id']);
            $table->index('status');
            $table->index('sent_at');
        });
    }

    /**
     * Annulla la migrazione.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
    }
};
