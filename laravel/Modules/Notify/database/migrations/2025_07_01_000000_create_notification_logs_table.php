<?php

declare(strict_types=1);


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('notification_logs')) {
            Schema::create('notification_logs', function (Blueprint $table) {
                $table->id();
                $table->string('notifiable_type');
                $table->unsignedBigInteger('notifiable_id');
                $table->string('type');
                $table->string('channel');
                $table->string('recipient');
                $table->string('subject')->nullable();
                $table->text('message')->nullable();
                $table->string('status')->default('pending');
                $table->timestamp('sent_at')->nullable();
                $table->timestamp('read_at')->nullable();
                $table->text('error_message')->nullable();
                $table->json('metadata')->nullable();
                $table->timestamps();

                $table->index(['notifiable_type', 'notifiable_id']);
                $table->index('channel');
                $table->index('status');
                $table->index('sent_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
    }
};
