<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateQua02k1Table.
 */
class CreateQua02k1Table extends XotBaseMigration
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
                $table->text('matr')->nullable();
                $table->text('qudal')->nullable();
                $table->text('qual')->nullable();
                $table->text('ruo')->nullable();
                $table->text('pro')->nullable();
                $table->text('fun')->nullable();
                $table->text('anz')->nullable();
                $table->text('imp')->nullable();
                $table->text('impeur')->nullable();
                $table->text('s01')->nullable();
                $table->text('s02')->nullable();
                $table->text('s05')->nullable();
                $table->text('flga')->nullable();
                $table->text('qua2kd')->nullable();
                $table->text('qua2ka')->nullable();
                $table->text('anz2k')->nullable();
                $table->text('k01')->nullable();
                $table->text('k05')->nullable();
                $table->text('e02')->nullable();
                $table->text('e05')->nullable();
                $table->text('qua001')->nullable();
                $table->text('qua002')->nullable();
                $table->text('qua003')->nullable();
                $table->text('qua004')->nullable();
                $table->text('qua005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('qua02k1');
    }
}
