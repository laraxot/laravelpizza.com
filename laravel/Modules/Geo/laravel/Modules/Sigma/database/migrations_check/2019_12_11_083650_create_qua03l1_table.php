<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateQua03l1Table.
 */
class CreateQua03l1Table extends XotBaseMigration
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
                $table->text('q3tipo')->nullable();
                $table->text('q3dal')->nullable();
                $table->text('q3al')->nullable();
                $table->text('q3desc')->nullable();
                $table->text('q3cont')->nullable();
                $table->text('q3pro')->nullable();
                $table->text('q3fun')->nullable();
                $table->text('q3voc1')->nullable();
                $table->text('q3anz1')->nullable();
                $table->text('q3imp1')->nullable();
                $table->text('q3voc2')->nullable();
                $table->text('q3anz2')->nullable();
                $table->text('q3imp2')->nullable();
                $table->text('q3voc3')->nullable();
                $table->text('q3anz3')->nullable();
                $table->text('q3imp3')->nullable();
                $table->text('q3voc4')->nullable();
                $table->text('q3anz4')->nullable();
                $table->text('q3imp4')->nullable();
                $table->text('q3voc5')->nullable();
                $table->text('q3anz5')->nullable();
                $table->text('q3imp5')->nullable();
                $table->text('q3tip')->nullable();
                $table->text('q3dat')->nullable();
                $table->text('q3num')->nullable();
                $table->text('q3ann')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('qua03l1');
    }
}
