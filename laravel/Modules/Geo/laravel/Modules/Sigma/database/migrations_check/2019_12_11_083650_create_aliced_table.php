<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAlicedTable.
 */
class CreateAlicedTable extends XotBaseMigration
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
                $table->string('conome', 25)->nullable();
                $table->string('nome', 25)->nullable();
                $table->integer('propro')->nullable()->index('propro');
                $table->integer('posfun')->nullable()->index('posfun');
                $table->integer('scont')->nullable();
                $table->integer('smatr')->nullable();
                $table->integer('smesli')->nullable();
                $table->integer('sannli')->nullable();
                $table->integer('sgiome')->nullable();
                $table->integer('svocfi')->nullable();
                $table->decimal('perrid', 7)->nullable();
                $table->integer('totale')->nullable();
                $table->decimal('impoeu', 13)->nullable();
                $table->integer('totsav')->nullable();
                $table->decimal('impseu', 13)->nullable();
                $table->decimal('qtaore', 7)->nullable();
                $table->integer('anno')->nullable();
                $table->integer('mese')->nullable();
                $table->integer('sruolo')->nullable();
                $table->integer('impbil')->nullable();
                $table->integer('clafun')->nullable();
                $table->integer('flagcf')->nullable();
                $table->integer('cedist')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('aliced');
    }
}
