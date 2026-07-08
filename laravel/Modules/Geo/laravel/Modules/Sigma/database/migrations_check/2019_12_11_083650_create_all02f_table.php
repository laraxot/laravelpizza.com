<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAll02fTable.
 */
class CreateAll02fTable extends XotBaseMigration
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
                $table->text('ktipo')->nullable();
                $table->text('kcodic')->nullable();
                $table->text('kodreg')->nullable();
                $table->text('a01mm')->nullable();
                $table->text('a01aa')->nullable();
                $table->text('impmes')->nullable();
                $table->text('impneg')->nullable();
                $table->text('imppr1')->nullable();
                $table->text('imppr2')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('all02f');
    }
}
