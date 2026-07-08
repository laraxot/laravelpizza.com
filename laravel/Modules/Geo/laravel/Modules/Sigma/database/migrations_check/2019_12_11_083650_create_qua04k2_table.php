<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateQua04k2Table.
 */
class CreateQua04k2Table extends XotBaseMigration
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
                $table->text('q4tipo')->nullable();
                $table->text('q4dal')->nullable();
                $table->text('q4al')->nullable();
                $table->text('q4seq')->nullable();
                $table->text('q4desc')->nullable();
                $table->text('q4des2')->nullable();
                $table->text('q4des3')->nullable();
                $table->text('q4cont')->nullable();
                $table->text('q4pro')->nullable();
                $table->text('q4fun')->nullable();
                $table->text('q4man')->nullable();
                $table->text('q4dis')->nullable();
                $table->text('q4scad')->nullable();
                $table->text('q4tip')->nullable();
                $table->text('q4dat')->nullable();
                $table->text('q4num')->nullable();
                $table->text('q4tia')->nullable();
                $table->text('q4sta')->nullable();
                $table->text('q4cm01')->nullable();
                $table->text('q4cm02')->nullable();
                $table->text('q4cm03')->nullable();
                $table->text('q4cm04')->nullable();
                $table->text('q4cm05')->nullable();
                $table->text('q4cm06')->nullable();
                $table->text('q4cm07')->nullable();
                $table->text('q4cm08')->nullable();
                $table->text('q4cm09')->nullable();
                $table->text('q4cm10')->nullable();
                $table->text('q4cm11')->nullable();
                $table->text('q4cm12')->nullable();
                $table->text('q4cm13')->nullable();
                $table->text('q4cm14')->nullable();
                $table->text('q4cm15')->nullable();
                $table->text('q4cm16')->nullable();
                $table->text('q4cm17')->nullable();
                $table->text('q4cm18')->nullable();
                $table->text('q4cm19')->nullable();
                $table->text('q4cm20')->nullable();
                $table->text('q4ann')->nullable();
                $table->text('q4001')->nullable();
                $table->text('q4002')->nullable();
                $table->text('q4003')->nullable();
                $table->text('q4004')->nullable();
                $table->text('q4005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('qua04k2');
    }
}
