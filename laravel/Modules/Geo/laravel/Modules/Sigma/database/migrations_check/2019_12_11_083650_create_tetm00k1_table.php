<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateTetm00k1Table.
 */
class CreateTetm00k1Table extends XotBaseMigration
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
                $table->text('temrec')->nullable();
                $table->text('temdal')->nullable();
                $table->text('temal')->nullable();
                $table->text('temdur')->nullable();
                $table->text('t18dal')->nullable();
                $table->text('t18al')->nullable();
                $table->text('t18dur')->nullable();
                $table->text('temann')->nullable();
                $table->text('tem2kd')->nullable();
                $table->text('tem2ka')->nullable();
                $table->text('t182kd')->nullable();
                $table->text('t182ka')->nullable();
                $table->text('asz001')->nullable();
                $table->text('asz002')->nullable();
                $table->text('asz003')->nullable();
                $table->text('asz004')->nullable();
                $table->text('asz005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('tetm00k1');
    }
}
