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
        Schema::create('individuale_tot_valutatore_id', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('valutatore_id');
            $table->integer('anno');
            $table->string('type', 16);
            $table->float('tot_budget_assegnato')->default(0);
            $table->float('tot_quota_effettiva')->default(0);
            $table->float('tot_resti')->default(0);
            $table->float('tot_importo_totale')->default(0);
            $table->float('tot_totale_punteggio')->default(0);
            $table->float('tot_budget_assegnato_min_punteggio')->default(0);
            $table->float('tot_quota_effettiva_min_punteggio')->default(0);
            $table->float('tot_resti_min_punteggio')->default(0);
            $table->float('tot_importo_totale_min_punteggio')->default(0);
            $table->float('tot_totale_punteggio_min_punteggio')->default(0);
            $table->float('delta')->default(0);
            $table->float('delta_min_punteggio')->default(0);
            $table->timestamps();
            $table->index(['valutatore_id', 'anno', 'type']);
        });
    }

    /**
     * Down method non implementato secondo regole XotBaseMigration.
     */
    public function down(): void
    {
        // Non implementare secondo le regole Windsurf/Laraxot.
    }
};
