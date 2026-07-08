<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAgg01fTable.
 */
class CreateAgg01fTable extends XotBaseMigration
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
                $table->text('aggaa')->nullable();
                $table->text('aggtc')->nullable();
                $table->text('aid01')->nullable();
                $table->text('aid02')->nullable();
                $table->text('aid03')->nullable();
                $table->text('aid04')->nullable();
                $table->text('aid05')->nullable();
                $table->text('aid06')->nullable();
                $table->text('aid07')->nullable();
                $table->text('aid08')->nullable();
                $table->text('aid09')->nullable();
                $table->text('aid10')->nullable();
                $table->text('aid11')->nullable();
                $table->text('aid12')->nullable();
                $table->text('aie01')->nullable();
                $table->text('aie02')->nullable();
                $table->text('aie03')->nullable();
                $table->text('aie04')->nullable();
                $table->text('aie05')->nullable();
                $table->text('aie06')->nullable();
                $table->text('aie07')->nullable();
                $table->text('aie08')->nullable();
                $table->text('aie09')->nullable();
                $table->text('aie10')->nullable();
                $table->text('aie11')->nullable();
                $table->text('aie12')->nullable();
                $table->text('aid')->nullable();
                $table->text('aie')->nullable();
                $table->text('aideu')->nullable();
                $table->text('aieeu')->nullable();
                $table->text('ald01')->nullable();
                $table->text('ald02')->nullable();
                $table->text('ald03')->nullable();
                $table->text('ald04')->nullable();
                $table->text('ald05')->nullable();
                $table->text('ald06')->nullable();
                $table->text('ald07')->nullable();
                $table->text('ald08')->nullable();
                $table->text('ald09')->nullable();
                $table->text('ald10')->nullable();
                $table->text('ald11')->nullable();
                $table->text('ald12')->nullable();
                $table->text('ald')->nullable();
                $table->text('aldeu')->nullable();
                $table->text('amm')->nullable();
                $table->text('ale')->nullable();
                $table->text('aleeu')->nullable();
                $table->text('aed')->nullable();
                $table->text('aee')->nullable();
                $table->text('aedeu')->nullable();
                $table->text('aeeeu')->nullable();
                $table->text('acd')->nullable();
                $table->text('ace')->nullable();
                $table->text('acdeu')->nullable();
                $table->text('aceeu')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('agg01f');
    }
}
