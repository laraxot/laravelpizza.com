<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCed08l4Table.
 */
class CreateCed08l4Table extends XotBaseMigration
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
                $table->integer('scont')->nullable()->index('scont');
                $table->integer('smatr')->nullable()->index('smatr');
                $table->integer('sannli')->nullable()->index('sannli');
                $table->integer('aarif')->nullable()->index('aarif');
                $table->integer('svocfi')->nullable();
                $table->integer('totale')->nullable();
                $table->decimal('impoeu', 13)->nullable();
                $table->decimal('orestr', 9)->nullable();
                $table->integer('congua')->nullable();
                $table->decimal('congeu', 13)->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('ced08l4');
    }
}
