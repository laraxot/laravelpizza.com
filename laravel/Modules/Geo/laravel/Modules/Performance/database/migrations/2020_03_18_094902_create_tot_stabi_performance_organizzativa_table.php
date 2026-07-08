<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Performance\Models\OrganizzativaTotStabi as MyModel;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateTotStabiPerformanceOrganizzativaTable extends XotBaseMigration
{
    protected ?string $model_class = MyModel::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                // Schema::connection('performance')->create('tot_stabi_performance_organizzativa', function (Blueprint $table) {
                $table->integer('id')->default(0);
                $table->integer('stabi')->nullable();
                $table->decimal('tot_budget_assegnato', 20, 5)->nullable();
                $table->decimal('tot_budget_assegnato_min_punteggio', 20, 5)->nullable();
                $table->decimal('tot_quota_effettiva', 20, 5)->nullable();
                $table->decimal('tot_quota_effettiva_min_punteggio', 20, 5)->nullable();
                $table->decimal('tot_resti', 20, 5)->nullable();
                $table->decimal('tot_resti_min_punteggio', 20, 5)->nullable();
                $table->decimal('delta', 20, 5)->nullable();
                $table->decimal('delta_min_punteggio', 20, 5)->nullable();
                $table->integer('anno')->nullable();
            });

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('updated_at')) {
                    $table->timestamps();
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::connection('performance')->drop('tot_stabi_performance_organizzativa');
    }
}
