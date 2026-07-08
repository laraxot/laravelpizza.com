<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateSto00fTable.
 */
class CreateSto00fTable extends XotBaseMigration
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
                $table->integer('ente')->index();
                $table->integer('matr')->index();
                $table->integer('stass');
                $table->integer('stdim');
                $table->integer('stupd');
                $table->integer('tipass');
                $table->integer('tipdim');
                $table->char('stann', 1)->index();
                $table->integer('stotia');
                $table->integer('stotil');
                $table->integer('stodaa');
                $table->integer('stodal');
                $table->char('stonua', 20);
                $table->char('stonul', 20);
                $table->integer('st2kas')->index();
                $table->integer('st2kdi')->index();
                $table->integer('st2ku');
                $table->integer('sto2ka');
                $table->integer('sto2kd');
                $table->integer('matina');
                $table->integer('sto001');
                $table->char('sto002', 1);
                $table->char('sto003', 15);
                $table->integer('sto004');
                $table->integer('sto005');
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('sto00f');
    }
}
