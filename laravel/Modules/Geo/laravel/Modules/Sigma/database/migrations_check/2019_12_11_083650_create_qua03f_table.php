<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateQua03fTable.
 */
class CreateQua03fTable extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->increments('id');
                $table->integer('ente');
                $table->integer('matr');
                $table->integer('q3tipo');
                $table->integer('q3dal');
                $table->integer('q3al');
                $table->char('q3desc', 78);
                $table->char('q3des2', 78);
                $table->char('q3des3', 78);
                $table->integer('q3cont');
                $table->integer('q3pro');
                $table->integer('q3fun');
                $table->integer('q3man');
                $table->integer('q3dis');
                $table->integer('q3voc1');
                $table->integer('q3anz1');
                $table->integer('q3imp1');
                $table->decimal('q3eur1', 13);
                $table->integer('q3voc2');
                $table->integer('q3anz2');
                $table->integer('q3imp2');
                $table->decimal('q3eur2', 13);
                $table->integer('q3voc3');
                $table->integer('q3anz3');
                $table->integer('q3imp3');
                $table->decimal('q3eur3', 13);
                $table->integer('q3voc4');
                $table->integer('q3anz4');
                $table->integer('q3imp4');
                $table->decimal('q3eur4', 13);
                $table->integer('q3voc5');
                $table->integer('q3anz5');
                $table->integer('q3imp5');
                $table->decimal('q3eur5', 13);
                $table->integer('q3tip');
                $table->integer('q3dat');
                $table->char('q3num', 20);
                $table->char('q3ann', 1);
                $table->integer('q32kd');
                $table->integer('q32ka');
                $table->integer('q32ka1');
                $table->integer('q32ka2');
                $table->integer('q32ka3');
                $table->integer('q32ka4');
                $table->integer('q32ka5');
                $table->integer('q32k');
                $table->integer('q3001');
                $table->char('q3002', 1);
                $table->char('q3003', 15);
                $table->integer('q3004');
                $table->integer('q3005');
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('qua03f');
    }
}
