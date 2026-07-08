<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAna03fTable.
 */
class CreateAna03fTable extends XotBaseMigration
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
                $table->char('telnum', 17);
                $table->char('celnum', 17);
                $table->char('cel2nu', 17);
                $table->char('faxnum', 17);
                $table->char('emaind', 100);
                $table->char('emaper', 100);
                $table->char('benefi', 40);
                $table->char('invced', 2);
                $table->char('cpaese', 2);
                $table->integer('chedig');
                $table->char('statoe', 35);
                $table->char('anacup', 15);
                $table->char('anacig', 20);
                $table->char('anaest', 50);
                $table->integer('ana031');
                $table->integer('ana032');
                $table->integer('ana033');
                $table->integer('ana034');
                $table->integer('ana035');
                $table->integer('ana036');
                $table->char('ana037', 1);
                $table->char('ana038', 15);
                $table->char('ana039', 40);
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('ana03f');
    }
}
