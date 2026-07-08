<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateQua03k1Table.
 */
class CreateQua03k1Table extends XotBaseMigration
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
                $table->integer('q3tipo')->nullable()->index('q3tipo');
                $table->integer('q3dal')->nullable()->index('q3dal');
                $table->integer('q3al')->nullable()->index('q3al');
                $table->string('q3desc', 78)->nullable();
                $table->string('q3des2', 78)->nullable();
                $table->string('q3des3', 78)->nullable();
                $table->integer('q3cont')->nullable();
                $table->integer('q3pro')->nullable();
                $table->integer('q3fun')->nullable();
                $table->integer('q3man')->nullable();
                $table->integer('q3dis')->nullable();
                $table->integer('q3voc1')->nullable();
                $table->integer('q3anz1')->nullable();
                $table->integer('q3imp1')->nullable();
                $table->decimal('q3eur1', 13)->nullable();
                $table->integer('q3voc2')->nullable();
                $table->integer('q3anz2')->nullable();
                $table->integer('q3imp2')->nullable();
                $table->decimal('q3eur2', 13)->nullable();
                $table->integer('q3voc3')->nullable();
                $table->integer('q3anz3')->nullable();
                $table->integer('q3imp3')->nullable();
                $table->decimal('q3eur3', 13)->nullable();
                $table->integer('q3voc4')->nullable();
                $table->integer('q3anz4')->nullable();
                $table->integer('q3imp4')->nullable();
                $table->decimal('q3eur4', 13)->nullable();
                $table->integer('q3voc5')->nullable();
                $table->integer('q3anz5')->nullable();
                $table->integer('q3imp5')->nullable();
                $table->decimal('q3eur5', 13)->nullable();
                $table->integer('q3tip')->nullable();
                $table->integer('q3dat')->nullable();
                $table->string('q3num', 20)->nullable();
                $table->string('q3ann', 1)->nullable();
                $table->integer('q32kd')->nullable();
                $table->integer('q32ka')->nullable();
                $table->integer('q32ka1')->nullable();
                $table->integer('q32ka2')->nullable();
                $table->integer('q32ka3')->nullable();
                $table->integer('q32ka4')->nullable();
                $table->integer('q32ka5')->nullable();
                $table->integer('q32k')->nullable();
                $table->integer('q3001')->nullable();
                $table->string('q3002', 1)->nullable();
                $table->string('q3003', 15)->nullable();
                $table->integer('q3004')->nullable();
                $table->integer('q3005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('qua03k1');
    }
}
