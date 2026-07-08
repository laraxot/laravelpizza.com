<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateVarp00l2Table.
 */
class CreateVarp00l2Table extends XotBaseMigration
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
                $table->text('proann')->nullable();
                $table->text('promat')->nullable();
                $table->text('prodat')->nullable();
                $table->text('progiu')->nullable();
                $table->text('prolet')->nullable();
                $table->text('proora')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('varp00l2');
    }
}
