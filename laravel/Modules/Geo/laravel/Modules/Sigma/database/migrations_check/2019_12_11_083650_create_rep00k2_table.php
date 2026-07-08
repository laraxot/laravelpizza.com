<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateRep00k2Table.
 */
class CreateRep00k2Table extends XotBaseMigration
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
                $table->text('repdal')->nullable();
                $table->text('repal')->nullable();
                $table->text('repst1')->nullable();
                $table->text('repre1')->nullable();
                $table->text('repst2')->nullable();
                $table->text('repre2')->nullable();
                $table->text('repcla')->nullable();
                $table->text('repmar')->nullable();
                $table->text('grppag')->nullable();
                $table->text('numpag')->nullable();
                $table->text('repc1a')->nullable();
                $table->text('repc1b')->nullable();
                $table->text('repc1c')->nullable();
                $table->text('repc2a')->nullable();
                $table->text('repc2b')->nullable();
                $table->text('repc2c')->nullable();
                $table->text('repc3a')->nullable();
                $table->text('repc3b')->nullable();
                $table->text('repc3c')->nullable();
                $table->text('perc1')->nullable();
                $table->text('perc2')->nullable();
                $table->text('perc3')->nullable();
                $table->text('piaorg')->nullable();
                $table->text('repann')->nullable();
                $table->text('rep2kd')->nullable();
                $table->text('rep2ka')->nullable();
                $table->text('rep001')->nullable();
                $table->text('rep002')->nullable();
                $table->text('rep003')->nullable();
                $table->text('rep004')->nullable();
                $table->text('rep005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('rep00k2');
    }
}
