<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Performance\Models\IndividualeAssenze as MyModel;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Migrazione per la tabella codici_assenze_individuale.
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
                $table->integer('tipo')->nullable();
                $table->integer('codice')->nullable();
                $table->text('descr')->nullable();
                $table->integer('anno')->nullable();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->softDeletes();
                $table->string('deleted_by')->nullable();
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
};
