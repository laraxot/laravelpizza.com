<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theme_id')->constrained('themes')->cascadeOnDelete();
            $table->string('name');
            $table->string('type')->nullable();
            $table->text('config')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('version')->default('1.0.0');
            $table->json('dependencies')->nullable();
            $table->text('template')->nullable();
            $table->boolean('is_cacheable')->default(false);
            $table->integer('cache_ttl')->default(3600);
            $table->json('validation_rules')->nullable();
            $table->string('view_path')->nullable();
            $table->json('data_schema')->nullable();
            $table->json('responsive_breakpoints')->nullable();
            $table->boolean('supports_lazy_loading')->default(false);
            $table->float('lazy_loading_threshold')->nullable();
            $table->string('cache_strategy')->nullable();
            $table->integer('cache_duration')->nullable();
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
        Schema::dropIfExists('components');
    }
};
