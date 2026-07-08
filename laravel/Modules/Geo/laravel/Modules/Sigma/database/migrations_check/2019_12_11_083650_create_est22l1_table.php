<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateEst22l1Table.
 */
class CreateEst22l1Table extends XotBaseMigration
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
                $table->text('dal')->nullable();
                $table->text('al')->nullable();
                $table->text('data22')->nullable();
                $table->text('dalora')->nullable();
                $table->text('alora')->nullable();
                $table->text('italia')->nullable();
                $table->text('estero')->nullable();
                $table->text('num1e')->nullable();
                $table->text('num2e')->nullable();
                $table->text('num3e')->nullable();
                $table->text('tar1e')->nullable();
                $table->text('tar2e')->nullable();
                $table->text('tar3e')->nullable();
                $table->text('imp1e')->nullable();
                $table->text('imp2e')->nullable();
                $table->text('imp3e')->nullable();
                $table->text('auto1e')->nullable();
                $table->text('auto2e')->nullable();
                $table->text('auto3e')->nullable();
                $table->text('voce1e')->nullable();
                $table->text('voce2e')->nullable();
                $table->text('voce3e')->nullable();
                $table->text('gg1e')->nullable();
                $table->text('dia1e')->nullable();
                $table->text('camb1e')->nullable();
                $table->text('imp4e')->nullable();
                $table->text('imp4ce')->nullable();
                $table->text('imp4de')->nullable();
                $table->text('voce5e')->nullable();
                $table->text('vocd5e')->nullable();
                $table->text('gg2e')->nullable();
                $table->text('dia2e')->nullable();
                $table->text('camb2e')->nullable();
                $table->text('imp5e')->nullable();
                $table->text('imp5ce')->nullable();
                $table->text('imp5de')->nullable();
                $table->text('voce6e')->nullable();
                $table->text('vocd6e')->nullable();
                $table->text('gg3e')->nullable();
                $table->text('dia3e')->nullable();
                $table->text('camb3e')->nullable();
                $table->text('imp6e')->nullable();
                $table->text('imp6ce')->nullable();
                $table->text('imp6de')->nullable();
                $table->text('voce7e')->nullable();
                $table->text('vocd7e')->nullable();
                $table->text('voce4e')->nullable();
                $table->text('voce8e')->nullable();
                $table->text('rimbe')->nullable();
                $table->text('rece')->nullable();
                $table->text('impfoe')->nullable();
                $table->text('vocfoe')->nullable();
                $table->text('num15i')->nullable();
                $table->text('num1i')->nullable();
                $table->text('num2i')->nullable();
                $table->text('num3i')->nullable();
                $table->text('tar1i')->nullable();
                $table->text('tar2i')->nullable();
                $table->text('tar3i')->nullable();
                $table->text('imp15i')->nullable();
                $table->text('imp1i')->nullable();
                $table->text('imp2i')->nullable();
                $table->text('imp3i')->nullable();
                $table->text('auto1i')->nullable();
                $table->text('auto2i')->nullable();
                $table->text('auto3i')->nullable();
                $table->text('voc15i')->nullable();
                $table->text('voce1i')->nullable();
                $table->text('voce2i')->nullable();
                $table->text('voce3i')->nullable();
                $table->text('voce4i')->nullable();
                $table->text('voce5i')->nullable();
                $table->text('rimbi')->nullable();
                $table->text('reci')->nullable();
                $table->text('impfoi')->nullable();
                $table->text('vocfoi')->nullable();
                $table->text('desc22')->nullable();
                $table->text('prof22')->nullable();
                $table->text('elab22')->nullable();
                $table->text('mese22')->nullable();
                $table->text('ann22')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('est22l1');
    }
}
