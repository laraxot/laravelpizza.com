<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Performance\Models\OrganizzativaCatCoeff as MyModel;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Migrazione per la tabella organizzativa_cat_coeffs.
 *
 * @see docs/valutatore-distribution-implementation.md
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = MyModel::class;

    /**
     * Esegui la migrazione.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->increments('id');
                $table->string('lista_propro', 250)->nullable();
                $table->decimal('coeff', 10, 3)->nullable();
                $table->text('descr')->nullable();
                $table->decimal('tot_giorni', 20, 5)->nullable();
                $table->decimal('tot_giorni_pt', 20, 5)->nullable();
                $table->decimal('tot_giorni_pt_coeff', 20, 5)->nullable();
                $table->decimal('quota_teorica', 20, 5)->nullable();
                $table->integer('anno')->nullable();
                $table->string('created_by', 50)->nullable();
                $table->string('updated_by', 50)->nullable();
                $table->timestamps();
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('updated_at')) {
                    $table->timestamps();
                }
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::connection('performance')->drop('organizzativa_cat_coeffs');
    }
};
