<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateWorar01lTable.
 */
class CreateWorar01lTable extends XotBaseMigration
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
                $table->integer('ordal')->nullable();
                $table->integer('oral')->nullable();
                $table->string('wsc3b', 7200)->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('worar01l');
    }
}
