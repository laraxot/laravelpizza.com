<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateWcon01l1Table.
 */
class CreateWcon01l1Table extends XotBaseMigration
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
                $table->text('wcdtda')->nullable();
                $table->text('wcdta')->nullable();
                $table->text('wcmatr')->nullable();
                $table->text('wccom1')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('wcon01l1');
    }
}
