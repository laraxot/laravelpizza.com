<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAppfasTable.
 */
class CreateAppfasTable extends XotBaseMigration
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
                $table->text('yonome')->nullable();
                $table->text('yome')->nullable();
                $table->text('decorr')->nullable();
                $table->text('tiptas')->nullable();
                $table->text('flagch')->nullable();
                $table->text('cath')->nullable();
                $table->text('fash')->nullable();
                $table->text('proh')->nullable();
                $table->text('posh')->nullable();
                $table->text('catn')->nullable();
                $table->text('fasn')->nullable();
                $table->text('pron')->nullable();
                $table->text('posn')->nullable();
                $table->text('note')->nullable();
                $table->text('nomeap')->nullable();
                $table->text('dataap')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('appfas');
    }
}
