<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCed08l3Table.
 */
class CreateCed08l3Table extends XotBaseMigration
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
                $table->text('scont')->nullable();
                $table->text('smatr')->nullable();
                $table->text('sannli')->nullable();
                $table->text('aarif')->nullable();
                $table->text('svocfi')->nullable();
                $table->text('totale')->nullable();
                $table->text('impoeu')->nullable();
                $table->text('orestr')->nullable();
                $table->text('congua')->nullable();
                $table->text('congeu')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('ced08l3');
    }
}
