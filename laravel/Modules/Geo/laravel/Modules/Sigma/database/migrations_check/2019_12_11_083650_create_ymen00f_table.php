<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateYmen00fTable.
 */
class CreateYmen00fTable extends XotBaseMigration
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
                $table->text('flanme')->nullable();
                $table->text('cdmnme')->nullable();
                $table->text('descme')->nullable();
                $table->text('sinfme')->nullable();
                $table->text('mnpgme')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('ymen00f');
    }
}
