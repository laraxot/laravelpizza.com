<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Performance\Models\IndividualePesi as MyModel;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreatePesoPerformanceIndividualeTable extends XotBaseMigration
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
                // Schema::connection('performance')->create('peso_performance_individuale', function (Blueprint $table) {
                $table->increments('id');
                $table->string('lista_propro', 250)->nullable();
                $table->string('descr', 50)->nullable();
                $table->integer('peso_esperienza_acquisita')->nullable();
                $table->integer('peso_risultati_ottenuti')->nullable();
                $table->integer('peso_arricchimento_professionale')->nullable();
                $table->integer('peso_impegno')->nullable();
                $table->integer('peso_qualita_prestazione')->nullable();
                $table->integer('anno')->nullable();
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

                if (! $this->hasColumn('type')) {
                    $table->string('type', 50)->index();
                }
            });
    }
}
