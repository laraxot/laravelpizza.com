<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateIrp21l1Table.
 */
class CreateIrp21l1Table extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->integer('id', true);
                $table->text('ente')->nullable();
                $table->text('matr')->nullable();
                $table->text('irpdal')->nullable();
                $table->text('irpal')->nullable();
                $table->text('irpcog')->nullable();
                $table->text('irpnom')->nullable();
                $table->text('irpnas')->nullable();
                $table->text('irpseq')->nullable();
                $table->text('irpcdf')->nullable();
                $table->text('irpper')->nullable();
                $table->text('irpinv')->nullable();
                $table->text('irptip')->nullable();
                $table->text('iann21')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('irp21l1');
    }
}
