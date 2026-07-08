<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateWmen00l1Table.
 */
class CreateWmen00l1Table extends XotBaseMigration
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
                $table->string('mnannu', 1)->nullable();
                $table->integer('mnbadg')->nullable();
                $table->integer('mnmatr')->nullable()->index('mnmatr');
                $table->string('mncogn', 25)->nullable();
                $table->string('mnnome', 25)->nullable();
                $table->integer('mncaus')->nullable();
                $table->integer('mnp1')->nullable();
                $table->integer('mnp2')->nullable();
                $table->integer('mnp3')->nullable();
                $table->integer('mnp4')->nullable();
                $table->integer('mndata')->nullable();
                $table->integer('mnorat')->nullable();
                $table->string('mnflg1', 1)->nullable();
                $table->string('mnflg2', 1)->nullable();
                $table->integer('mnflg3')->nullable();
                $table->string('mnflg4', 1)->nullable();
                $table->integer('mntmen')->nullable();
                $table->string('mncom2', 10)->nullable();
                $table->integer('mncom3')->nullable();
                $table->string('ixterm', 5)->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('wmen00l1');
    }
}
