<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateMod00k1Table.
 */
class CreateMod00k1Table extends XotBaseMigration
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
                $table->text('moddal')->nullable();
                $table->text('modal')->nullable();
                $table->text('orario')->nullable();
                $table->text('oraeff')->nullable();
                $table->text('oraann')->nullable();
                $table->text('mod2kd')->nullable();
                $table->text('mod2ka')->nullable();
                $table->text('mod001')->nullable();
                $table->text('mod002')->nullable();
                $table->text('mod003')->nullable();
                $table->text('mod004')->nullable();
                $table->text('mod005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('mod00k1');
    }
}
