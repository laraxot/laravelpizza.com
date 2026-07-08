<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migrazione Xot: crea la tabella individuale_tot_valutatore_ids per aggregazione valutatore pipeline Individuale.
 * Struttura e naming coerenti con OrganizzativaTotValutatoreId.
 *
 * @see /docs/database_migrations.md
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('performance')->create('individuale_tot_valutatore_ids', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('valutatore_id')->nullable()->index();
            $table->unsignedInteger('anno')->nullable()->index();
            $table->string('type', 16)->nullable()->index();
            $table->decimal('tot_budget_assegnato', 12, 2)->default(0);
            $table->decimal('tot_quota_effettiva', 12, 2)->default(0);
            $table->decimal('tot_resti', 12, 2)->default(0);
            $table->decimal('tot_importo_totale', 12, 2)->default(0);
            $table->decimal('totale_punteggio', 8, 2)->default(0);
            $table->decimal('tot_budget_assegnato_min_punteggio', 12, 2)->default(0);
            $table->decimal('tot_quota_effettiva_min_punteggio', 12, 2)->default(0);
            $table->decimal('tot_resti_min_punteggio', 12, 2)->default(0);
            $table->decimal('tot_importo_totale_min_punteggio', 12, 2)->default(0);
            $table->decimal('delta', 8, 4)->default(0);
            $table->decimal('delta_min_punteggio', 8, 4)->default(0);
            $table->timestamps();
            $table->comment('Aggregazione valutatore pipeline Individuale');
        });
    }

    public function down(): void
    {
        Schema::connection('performance')->dropIfExists('individuale_tot_valutatore_ids');
    }
};
