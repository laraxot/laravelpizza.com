<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateRep00k4Table.
 */
class CreateRep00k4Table extends XotBaseMigration
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
                $table->integer('repdal');
                $table->integer('repal');
                $table->integer('repst1');
                $table->integer('repre1');
                $table->integer('repst2');
                $table->integer('repre2');
                $table->integer('repcla');
                $table->integer('repmar');
                $table->char('grppag', 3);
                $table->integer('numpag');
                $table->integer('repc1a');
                $table->integer('repc1b');
                $table->integer('repc1c');
                $table->integer('repc2a');
                $table->integer('repc2b');
                $table->integer('repc2c');
                $table->integer('repc3a');
                $table->integer('repc3b');
                $table->integer('repc3c');
                $table->decimal('perc1', 7);
                $table->decimal('perc2', 7);
                $table->decimal('perc3', 7);
                $table->integer('piaorg');
                $table->char('repann', 1);
                $table->integer('rep2kd');
                $table->integer('rep2ka');
                $table->integer('rep001');
                $table->char('rep002', 1);
                $table->char('rep003', 15);
                $table->integer('rep004');
                $table->integer('rep005');
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('rep00k4');
    }
}
