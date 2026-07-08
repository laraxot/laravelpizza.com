<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCed03f190Table.
 */
class CreateCed03f190Table extends XotBaseMigration
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
                $table->text('smesli')->nullable();
                $table->text('sannli')->nullable();
                $table->text('sgiome')->nullable();
                $table->text('svocfi')->nullable();
                $table->text('perrid')->nullable();
                $table->text('totale')->nullable();
                $table->text('impoeu')->nullable();
                $table->text('totsav')->nullable();
                $table->text('impseu')->nullable();
                $table->text('qtaore')->nullable();
                $table->text('anno')->nullable();
                $table->text('mese')->nullable();
                $table->text('sruolo')->nullable();
                $table->text('impbil')->nullable();
                $table->text('clafun')->nullable();
                $table->text('flagcf')->nullable();
                $table->text('cedist')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('ced03f190');
    }
}
