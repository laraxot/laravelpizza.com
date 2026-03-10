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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theme_id')->constrained('themes')->cascadeOnDelete();
            $table->string('name');
            $table->string('path');
            $table->string('type')->nullable();
            $table->string('disk')->default('public');
            $table->string('extension')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->boolean('is_minified')->default(false);
            $table->boolean('is_compressed')->default(false);
            $table->integer('order')->default(0);
            $table->boolean('should_bundle')->default(false);
            $table->timestamps();
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
