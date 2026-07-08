<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateEnte3fTable.
 */
class CreateEnte3fTable extends XotBaseMigration
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
                $table->text('ente3')->nullable();
                $table->text('en3dtp')->nullable();
                $table->text('en3dti')->nullable();
                $table->text('en3tel')->nullable();
                $table->text('en3fax')->nullable();
                $table->text('en3ema')->nullable();
                $table->text('tipent')->nullable();
                $table->text('valuta')->nullable();
                $table->text('arroto')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('ente3f');
    }
}
