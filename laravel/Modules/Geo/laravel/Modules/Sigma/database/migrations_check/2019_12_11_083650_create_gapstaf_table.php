<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateGapstafTable.
 */
class CreateGapstafTable extends XotBaseMigration
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
                $table->text('qent1')->nullable();
                $table->text('qtip1')->nullable();
                $table->text('qstab')->nullable();
                $table->text('qrepa')->nullable();
                $table->text('qdes1')->nullable();
                $table->text('qabi1')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('gapstaf');
    }
}
