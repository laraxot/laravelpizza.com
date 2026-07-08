<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Performance\Models\MyLog as MyModel;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Migrazione per la tabella performance_mylog.
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
                $table->integer('id', true);
                $table->integer('id_tbl')->nullable();
                $table->string('tbl', 50)->nullable();
                $table->integer('id_approvaz')->nullable();
                $table->text('note')->nullable();
                $table->text('data')->nullable();
                $table->dateTime('datemod')->nullable();
                $table->string('handle', 150)->nullable();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
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
        Schema::connection('performance')->drop('mylog');
    }
};
