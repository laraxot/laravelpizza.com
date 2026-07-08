<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateRepa3l1Table.
 */
class CreateRepa3l1Table extends XotBaseMigration
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
                $table->text('stabi')->nullable();
                $table->text('repar')->nullable();
                $table->text('tipcod')->nullable();
                $table->text('clafun')->nullable();
                $table->text('claind')->nullable();
                $table->text('cc1')->nullable();
                $table->text('cc2')->nullable();
                $table->text('cc3')->nullable();
                $table->text('cs1')->nullable();
                $table->text('cs2')->nullable();
                $table->text('cs3')->nullable();
                $table->text('sr1')->nullable();
                $table->text('sr2')->nullable();
                $table->text('po1')->nullable();
                $table->text('po2')->nullable();
                $table->text('re1')->nullable();
                $table->text('re2')->nullable();
                $table->text('da1')->nullable();
                $table->text('da2')->nullable();
                $table->text('descom')->nullable();
                $table->text('pronta')->nullable();
                $table->text('strcod')->nullable();
                $table->text('sstcod')->nullable();
                $table->text('artcod')->nullable();
                $table->text('arttip')->nullable();
                $table->text('aggstr')->nullable();
                $table->text('aggser')->nullable();
                $table->text('aggtip')->nullable();
                $table->text('rdesc')->nullable();
                $table->text('rdatai')->nullable();
                $table->text('rdataf')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('repa3l1');
    }
}
