<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateQua04k1Table.
 */
class CreateQua04k1Table extends XotBaseMigration
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
                $table->integer('ente')->nullable()->index('ente');
                $table->integer('matr')->nullable()->index('matr');
                $table->integer('q4tipo')->nullable()->index('q4tipo');
                $table->integer('q4dal')->nullable();
                $table->integer('q4al')->nullable();
                $table->integer('q4seq')->nullable();
                $table->string('q4desc', 78)->nullable();
                $table->string('q4des2', 78)->nullable();
                $table->string('q4des3', 78)->nullable();
                $table->integer('q4cont')->nullable();
                $table->integer('q4pro')->nullable();
                $table->integer('q4fun')->nullable();
                $table->integer('q4man')->nullable();
                $table->integer('q4dis')->nullable();
                $table->integer('q4scad')->nullable();
                $table->integer('q4tip')->nullable();
                $table->integer('q4dat')->nullable();
                $table->string('q4num', 20)->nullable();
                $table->integer('q4tia')->nullable();
                $table->string('q4sta', 1)->nullable();
                $table->string('q4cm01', 20)->nullable();
                $table->string('q4cm02', 20)->nullable();
                $table->string('q4cm03', 20)->nullable();
                $table->string('q4cm04', 20)->nullable();
                $table->string('q4cm05', 20)->nullable();
                $table->string('q4cm06', 20)->nullable();
                $table->string('q4cm07', 20)->nullable();
                $table->string('q4cm08', 20)->nullable();
                $table->string('q4cm09', 20)->nullable();
                $table->string('q4cm10', 20)->nullable();
                $table->decimal('q4cm11', 13)->nullable();
                $table->decimal('q4cm12', 13)->nullable();
                $table->decimal('q4cm13', 13)->nullable();
                $table->decimal('q4cm14', 13)->nullable();
                $table->decimal('q4cm15', 13)->nullable();
                $table->decimal('q4cm16', 13)->nullable();
                $table->decimal('q4cm17', 13)->nullable();
                $table->decimal('q4cm18', 13)->nullable();
                $table->decimal('q4cm19', 13)->nullable();
                $table->decimal('q4cm20', 13)->nullable();
                $table->string('q4ann', 1)->nullable();
                $table->integer('q4001')->nullable();
                $table->string('q4002', 1)->nullable();
                $table->string('q4003', 15)->nullable();
                $table->integer('q4004')->nullable();
                $table->integer('q4005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('qua04k1');
    }
}
