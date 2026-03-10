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
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('config')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('themes')->nullOnDelete();
            $table->string('source_path')->nullable();
            $table->string('compiled_path')->nullable();
            $table->boolean('needs_compilation')->default(false);
            $table->timestamps();
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
            $table->softDeletes();
            $table->string('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
