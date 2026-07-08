<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateOrar00lxTable.
 */
class CreateOrar00lxTable extends XotBaseMigration
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
                $table->integer('enteap')->nullable()->index('enteap');
                $table->string('orannu', 1)->nullable();
                $table->string('orcodi', 3)->nullable();
                $table->integer('orent1')->nullable()->index('orent1');
                $table->integer('orusc1')->nullable()->index('orusc1');
                $table->integer('orent2')->nullable();
                $table->integer('orusc2')->nullable();
                $table->integer('orent3')->nullable();
                $table->integer('orusc3')->nullable();
                $table->integer('orent4')->nullable();
                $table->integer('orusc4')->nullable();
                $table->string('oriniz', 1)->nullable();
                $table->string('orattr', 1)->nullable();
                $table->integer('ortea1')->nullable();
                $table->integer('ortua1')->nullable();
                $table->integer('ortea2')->nullable();
                $table->integer('ortua2')->nullable();
                $table->integer('ortea3')->nullable();
                $table->integer('ortua3')->nullable();
                $table->integer('ortea4')->nullable();
                $table->integer('ortua4')->nullable();
                $table->integer('orter1')->nullable();
                $table->integer('ortur1')->nullable();
                $table->integer('orter2')->nullable();
                $table->integer('ortur2')->nullable();
                $table->integer('orter3')->nullable();
                $table->integer('ortur3')->nullable();
                $table->integer('orter4')->nullable();
                $table->integer('ortur4')->nullable();
                $table->integer('oraea1')->nullable();
                $table->integer('oraer1')->nullable();
                $table->integer('oraua1')->nullable();
                $table->integer('oraur1')->nullable();
                $table->integer('oraea2')->nullable();
                $table->integer('oraer2')->nullable();
                $table->integer('oraua2')->nullable();
                $table->integer('oraur2')->nullable();
                $table->integer('oraea3')->nullable();
                $table->integer('oraer3')->nullable();
                $table->integer('oraua3')->nullable();
                $table->integer('oraur3')->nullable();
                $table->integer('oraea4')->nullable();
                $table->integer('oraer4')->nullable();
                $table->integer('oraua4')->nullable();
                $table->integer('oraur4')->nullable();
                $table->integer('orinte')->nullable();
                $table->integer('ortobb')->nullable();
                $table->integer('orttot')->nullable();
                $table->integer('ordife')->nullable();
                $table->integer('ordifu')->nullable();
                $table->integer('ormrit')->nullable();
                $table->integer('ornoti')->nullable();
                $table->integer('ornotf')->nullable();
                $table->integer('orpaus')->nullable();
                $table->string('ormanu', 1)->nullable();
                $table->string('ornega', 1)->nullable();
                $table->integer('ordal')->nullable();
                $table->integer('oral')->nullable();
                $table->string('orfaco', 4)->nullable();
                $table->integer('orfaa1')->nullable();
                $table->integer('orfaa2')->nullable();
                $table->integer('orfaa3')->nullable();
                $table->integer('orfaa4')->nullable();
                $table->integer('orfaa5')->nullable();
                $table->integer('orfaa6')->nullable();
                $table->integer('orfaa7')->nullable();
                $table->integer('orfaa8')->nullable();
                $table->string('orcom1', 1)->nullable();
                $table->string('orcom2', 10)->nullable();
                $table->string('orcom3', 15)->nullable();
                $table->integer('orcom4')->nullable();
                $table->integer('orcom5')->nullable();
                $table->integer('orcom6')->nullable();
                $table->integer('orcom7')->nullable();
                $table->integer('oxent1')->nullable();
                $table->integer('oxusc1')->nullable();
                $table->integer('oxent2')->nullable();
                $table->integer('oxusc2')->nullable();
                $table->integer('oxent3')->nullable();
                $table->integer('oxusc3')->nullable();
                $table->integer('oxent4')->nullable();
                $table->integer('oxusc4')->nullable();
                $table->integer('oxtea1')->nullable();
                $table->integer('oxtua1')->nullable();
                $table->integer('oxtea2')->nullable();
                $table->integer('oxtua2')->nullable();
                $table->integer('oxtea3')->nullable();
                $table->integer('oxtua3')->nullable();
                $table->integer('oxtea4')->nullable();
                $table->integer('oxtua4')->nullable();
                $table->integer('oxter1')->nullable();
                $table->integer('oxtur1')->nullable();
                $table->integer('oxter2')->nullable();
                $table->integer('oxtur2')->nullable();
                $table->integer('oxter3')->nullable();
                $table->integer('oxtur3')->nullable();
                $table->integer('oxter4')->nullable();
                $table->integer('oxtur4')->nullable();
                $table->integer('oxttot')->nullable();
                $table->integer('oxdife')->nullable();
                $table->integer('oxdifu')->nullable();
                $table->integer('oxnoti')->nullable();
                $table->integer('oxnotf')->nullable();
                $table->integer('oxpaus')->nullable();
                $table->integer('oxinte')->nullable();
                $table->integer('oxmrit')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('orar00lx');
    }
}
