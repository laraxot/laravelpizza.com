<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateRep02fTable.
 */
class CreateRep02fTable extends XotBaseMigration
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
                $table->text('re2dal')->nullable();
                $table->text('re2al')->nullable();
                $table->text('cdcseq')->nullable();
                $table->text('cdccod')->nullable();
                $table->text('cdcper')->nullable();
                $table->text('re2not')->nullable();
                $table->text('re2001')->nullable();
                $table->text('re2002')->nullable();
                $table->text('re2003')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('rep02f');
    }
}
