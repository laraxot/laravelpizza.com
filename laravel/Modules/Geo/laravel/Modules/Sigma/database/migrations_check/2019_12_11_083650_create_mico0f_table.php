<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateMico0fTable.
 */
class CreateMico0fTable extends XotBaseMigration
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
                $table->text('contm')->nullable();
                $table->text('tipoco')->nullable();
                $table->text('livm')->nullable();
                $table->text('imp')->nullable();
                $table->text('impoeu')->nullable();
                $table->text('dal')->nullable();
                $table->text('al')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('mico0f');
    }
}
