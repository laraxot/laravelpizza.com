<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateWstr0fTable.
 */
class CreateWstr0fTable extends XotBaseMigration
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
                $table->integer('ente')->nullable()->index('ente');
                $table->integer('matr')->nullable()->index('matr');
                $table->integer('repst2')->nullable()->index('repst2');
                $table->integer('repre2')->nullable()->index('repre2');
                $table->string('wcat', 1)->nullable();
                $table->integer('wcod1')->nullable();
                $table->integer('wcod2')->nullable();
                $table->integer('wvoce')->nullable();
                $table->decimal('wqta', 7)->nullable();
                $table->integer('wimp')->nullable();
                $table->integer('waa')->nullable();
                $table->integer('wmm')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('wstr0f');
    }
}
