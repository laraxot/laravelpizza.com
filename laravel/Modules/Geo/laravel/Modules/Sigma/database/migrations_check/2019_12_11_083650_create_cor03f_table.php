<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCor03fTable.
 */
class CreateCor03fTable extends XotBaseMigration
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
                $table->text('ente')->nullable();
                $table->text('tabe')->nullable();
                $table->text('desc1')->nullable();
                $table->text('desc2')->nullable();
                $table->text('fondo')->nullable();
                $table->text('sauto')->nullable();
                $table->text('satte')->nullable();
                $table->text('sregr')->nullable();
                $table->text('seq')->nullable();
                $table->text('form')->nullable();
                $table->text('vocep')->nullable();
                $table->text('vocen')->nullable();
                $table->text('ist')->nullable();
                $table->text('qtasn')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('cor03f');
    }
}
