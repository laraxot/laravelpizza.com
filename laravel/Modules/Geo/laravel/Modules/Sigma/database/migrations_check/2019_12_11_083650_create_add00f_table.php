<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAdd00fTable.
 */
class CreateAdd00fTable extends XotBaseMigration
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
                $table->text('anno')->nullable();
                $table->text('addtip')->nullable();
                $table->text('addist')->nullable();
                $table->text('provin')->nullable();
                $table->text('codreg')->nullable();
                $table->text('addnra')->nullable();
                $table->text('impdpa')->nullable();
                $table->text('imprif')->nullable();
                $table->text('imprit')->nullable();
                $table->text('addper')->nullable();
                $table->text('imp01l')->nullable();
                $table->text('imp02l')->nullable();
                $table->text('imp03l')->nullable();
                $table->text('imp04l')->nullable();
                $table->text('imp05l')->nullable();
                $table->text('imp06l')->nullable();
                $table->text('imp07l')->nullable();
                $table->text('imp08l')->nullable();
                $table->text('imp09l')->nullable();
                $table->text('imp10l')->nullable();
                $table->text('imp11l')->nullable();
                $table->text('imp12l')->nullable();
                $table->text('impdpe')->nullable();
                $table->text('imprfe')->nullable();
                $table->text('imprte')->nullable();
                $table->text('imp01e')->nullable();
                $table->text('imp02e')->nullable();
                $table->text('imp03e')->nullable();
                $table->text('imp04e')->nullable();
                $table->text('imp05e')->nullable();
                $table->text('imp06e')->nullable();
                $table->text('imp07e')->nullable();
                $table->text('imp08e')->nullable();
                $table->text('imp09e')->nullable();
                $table->text('imp10e')->nullable();
                $table->text('imp11e')->nullable();
                $table->text('imp12e')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('add00f');
    }
}
