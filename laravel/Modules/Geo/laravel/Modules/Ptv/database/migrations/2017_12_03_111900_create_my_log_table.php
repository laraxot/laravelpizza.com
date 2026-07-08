<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateMyLogTable extends XotBaseMigration
{
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->increments('id');
                $table->integer('id_tbl')->nullable();
                $table->string('tbl')->nullable();
                $table->integer('id_approvaz')->nullable();
                $table->text('note')->nullable();
                $table->text('obj')->nullable();
                $table->string('act')->nullable();
                $table->text('data')->nullable();
                $table->dateTime('datemod')->nullable();
                $table->string('handle')->nullable();
                $table->nullableMorphs('post');
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            static function (Blueprint $table): void {
                // if (! $this->hasColumn('post_id')) {
                //    $table->integer('post_id')->nullable();
                // }
            }
        );
    }
}
