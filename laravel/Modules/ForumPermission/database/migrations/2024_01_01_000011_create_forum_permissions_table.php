<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forum_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('forum_id')->constrained('forums')->onDelete('cascade');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->boolean('can_create_post')->default(false);
            $table->boolean('can_edit_post')->default(false);
            $table->boolean('can_delete_post')->default(false);
            $table->boolean('can_create_thread')->default(false);
            $table->boolean('can_edit_thread')->default(false);
            $table->boolean('can_delete_thread')->default(false);
            $table->boolean('can_reply')->default(false);
            $table->boolean('can_edit_reply')->default(false);
            $table->boolean('can_delete_reply')->default(false);
            $table->boolean('can_moderate')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forum_permissions');
    }
};