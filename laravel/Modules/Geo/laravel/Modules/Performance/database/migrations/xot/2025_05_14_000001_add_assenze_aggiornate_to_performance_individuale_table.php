<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migrazione Xot: aggiunge il campo assenze_aggiornate alla tabella performance_individuale.
 * Campo booleano per tracking pipeline assenze.
 *
 * @see /docs/database_migrations.md
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('performance')->table('performance_individuale', function (Blueprint $table) {
            $table->boolean('assenze_aggiornate')->default(false)->after('updated_at')->comment('Flag pipeline assenze aggiornata');
        });
    }

    public function down(): void
    {
        Schema::connection('performance')->table('performance_individuale', function (Blueprint $table) {
            $table->dropColumn('assenze_aggiornate');
        });
    }
};
