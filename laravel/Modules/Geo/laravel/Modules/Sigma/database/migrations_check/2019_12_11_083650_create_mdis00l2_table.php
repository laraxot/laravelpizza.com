<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateMdis00l2Table.
 */
class CreateMdis00l2Table extends XotBaseMigration
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
                $table->text('enteap')->nullable();
                $table->text('mdannu')->nullable();
                $table->text('mdmatr')->nullable();
                $table->text('mddalg')->nullable();
                $table->text('mdalg')->nullable();
                $table->text('mddall')->nullable();
                $table->text('mdalle')->nullable();
                $table->text('mdflg1')->nullable();
                $table->text('mdcom1')->nullable();
                $table->text('mdflag')->nullable();
                $table->text('mdindi')->nullable();
                $table->text('mdcom2')->nullable();
                $table->text('mdcom3')->nullable();
                $table->text('mdcom4')->nullable();
                $table->text('mdcom5')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('mdis00l2');
    }
}
