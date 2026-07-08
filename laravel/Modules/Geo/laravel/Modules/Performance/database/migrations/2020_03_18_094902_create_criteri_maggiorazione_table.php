<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Performance\Models\CriteriMaggiorazione as MyModel;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateCriteriMaggiorazioneTable extends XotBaseMigration
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
                // Schema::connection('performance')->create('criteri_maggiorazione', function (Blueprint $table) {
                $table->integer('id', true);
                $table->integer('anno')->default(0);
                $table->integer('min_valutaz_perf_ind')->nullable();
                $table->integer('maggiorazione_perc')->nullable();
                $table->integer('aventi_diritto_perc')->nullable();
                $table->timestamps();
                $table->string('created_by', 50)->nullable();
                $table->string('updated_by', 50)->nullable();
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
        Schema::connection('performance')->drop('criteri_maggiorazione');
    }
}
