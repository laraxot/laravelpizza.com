<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateEst00fTable.
 */
class CreateEst00fTable extends XotBaseMigration
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
                $table->text('dal')->nullable();
                $table->text('al')->nullable();
                $table->text('matr')->nullable();
                $table->text('ora')->nullable();
                $table->text('impfis')->nullable();
                $table->text('impfi2')->nullable();
                $table->text('impfi3')->nullable();
                $table->text('vo01')->nullable();
                $table->text('vo02')->nullable();
                $table->text('vo03')->nullable();
                $table->text('impeur')->nullable();
                $table->text('impeu2')->nullable();
                $table->text('impeu3')->nullable();
                $table->text('impora')->nullable();
                $table->text('impore')->nullable();
                $table->text('perrif')->nullable();
                $table->text('campo1')->nullable();
                $table->text('campo2')->nullable();
                $table->text('des')->nullable();
                $table->text('estan')->nullable();
                $table->text('impegn')->nullable();
                $table->text('cdr')->nullable();
                $table->text('impe01')->nullable();
                $table->text('impe02')->nullable();
                $table->text('impe03')->nullable();
                $table->text('impe04')->nullable();
                $table->text('cdr01')->nullable();
                $table->text('dafa')->nullable();
                $table->text('dafa2')->nullable();
                $table->text('tiprap')->nullable();
                $table->text('codatt')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('est00f');
    }
}
