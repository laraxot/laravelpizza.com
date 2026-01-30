<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->tableUpdate(
            function (Blueprint $table): void {
                // Indici per ottimizzare le query sui grafici
                $table->index(['type', 'status'], 'idx_chart_type_status');
                $table->index(['user_id', 'created_at'], 'idx_chart_user_created');
                
                // Indici per le relazioni e aggregazioni
                $table->index(['dataset_id'], 'idx_chart_dataset');
                $table->index(['aggregation_type', 'interval'], 'idx_chart_aggregation');
                
                // Indice per ricerche temporali
                $table->index(['created_at', 'updated_at'], 'idx_chart_timestamps');
                
                // Indice per filtri comuni
                $table->index(['visibility', 'status'], 'idx_chart_visibility');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->tableUpdate(
            function (Blueprint $table): void {
                $table->dropIndex('idx_chart_type_status');
                $table->dropIndex('idx_chart_user_created');
                $table->dropIndex('idx_chart_dataset');
                $table->dropIndex('idx_chart_aggregation');
                $table->dropIndex('idx_chart_timestamps');
                $table->dropIndex('idx_chart_visibility');
            }
        );
    }
}; 