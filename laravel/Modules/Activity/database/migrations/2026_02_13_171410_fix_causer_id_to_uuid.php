<?php

declare(strict_types=1);

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
        Schema::connection('activity')->table('activity_log', function (Blueprint $table): void {
            $table->string('causer_id', 36)->nullable()->change();
            $table->string('subject_id', 36)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('activity')->table('activity_log', function (Blueprint $table): void {
            $table->unsignedBigInteger('causer_id')->nullable()->change();
            $table->unsignedBigInteger('subject_id')->nullable()->change();
        });
    }
};
