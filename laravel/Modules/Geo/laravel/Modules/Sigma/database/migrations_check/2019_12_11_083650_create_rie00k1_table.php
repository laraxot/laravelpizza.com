<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateRie00k1Table.
 */
class CreateRie00k1Table extends XotBaseMigration
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
                $table->text('matr')->nullable();
                $table->text('rieaa')->nullable();
                $table->text('rietip')->nullable();
                $table->text('rieann')->nullable();
                $table->text('rie2kn')->nullable();
                $table->text('rie001')->nullable();
                $table->text('rie002')->nullable();
                $table->text('rie003')->nullable();
                $table->text('rie004')->nullable();
                $table->text('rie005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('rie00k1');
    }
}
