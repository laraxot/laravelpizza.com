<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateStabiDirigenteTable extends XotBaseMigration
{
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->increments('id');
                $table->integer('stabi')->nullable();
                $table->integer('repar')->nullable();
                $table->string('nome_stabi')->nullable();
                $table->integer('ente')->nullable();
                $table->integer('matr')->nullable();
                $table->string('nome_diri')->nullable();
                $table->string('nome_diri_plus')->nullable();
                $table->decimal('budget', 10, 3)->nullable();
                $table->integer('valutatore_id')->nullable();
                $table->integer('anno')->nullable();
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
