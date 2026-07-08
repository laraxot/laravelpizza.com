<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAsz00k2Table.
 */
class CreateAsz00k2Table extends XotBaseMigration
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
                $table->integer('cont');
                $table->integer('matr');
                $table->integer('asztip');
                $table->integer('aszcod');
                $table->integer('aszdal');
                $table->integer('aszal');
                $table->decimal('aszini', 6);
                $table->decimal('aszfin', 6);
                $table->integer('aszcom');
                $table->integer('asztpr');
                $table->integer('aszdpr');
                $table->char('asznpr', 20);
                $table->char('aszumi', 1);
                $table->char('aszpes', 1);
                $table->decimal('aszdur', 9);
                $table->integer('asz01');
                $table->integer('asz02');
                $table->integer('asz03');
                $table->integer('asz04');
                $table->integer('asz05');
                $table->char('aszcm', 3);
                $table->char('aszcms', 1);
                $table->integer('asztim');
                $table->char('aszpro', 10);
                $table->integer('aszprv');
                $table->char('aszann', 1);
                $table->integer('asz2kd');
                $table->integer('asz2ka');
                $table->integer('asz2kc');
                $table->integer('asz2kp');
                $table->integer('asz2kz');
                $table->decimal('aszeup', 11, 3);
                $table->integer('asztin');
                $table->integer('asz001');
                $table->char('asz002', 1);
                $table->char('asz003', 15);
                $table->integer('asz004');
                $table->integer('asz005');
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('asz00k2');
    }
}
