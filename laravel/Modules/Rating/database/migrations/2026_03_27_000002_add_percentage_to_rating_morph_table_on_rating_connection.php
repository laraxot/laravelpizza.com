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
        if (! Schema::connection('rating')->hasTable('rating_morph')) {
            return;
        }

        Schema::connection('rating')->table('rating_morph', function (Blueprint $table) {
            if (! Schema::connection('rating')->hasColumn('rating_morph', 'percentage')) {
                $table->decimal('percentage', 10, 3)->nullable()->after('value')->comment('Percentuale calcolata per il rating');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('rating')->table('rating_morph', function (Blueprint $table) {
            if (Schema::connection('rating')->hasColumn('rating_morph', 'percentage')) {
                $table->dropColumn('percentage');
            }
        });
    }
};
