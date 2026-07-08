<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateWstr02cTable.
 */
class CreateWstr02cTable extends XotBaseMigration
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
                $table->integer('enteap');
                $table->integer('stdata');
                $table->integer('w2matr');
                $table->char('w2orar', 3);
                $table->char('w2turn', 3);
                $table->integer('w2pesg');
                $table->integer('w2mint');
                $table->integer('w2minp');
                $table->char('w2orae', 12);
                $table->char('w2orau', 12);
                $table->integer('w2minf');
                $table->integer('w2calc');
                $table->integer('w2flg2');
                $table->char('c2orac', 4);
                $table->char('c2orin', 1);
                $table->char('c2prev', 3);
                $table->integer('rimecp');
                $table->integer('rimecm');
                $table->integer('rimdip');
                $table->integer('rimdim');
                $table->integer('rimdis');
                $table->integer('rimlav');
                $table->integer('rimdif');
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('wstr02c');
    }
}
