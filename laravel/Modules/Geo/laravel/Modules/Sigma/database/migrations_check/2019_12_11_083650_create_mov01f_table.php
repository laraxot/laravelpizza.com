<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateMov01fTable.
 */
class CreateMov01fTable extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->increments('id');
                $table->integer('ente');
                $table->integer('matr');
                $table->integer('mo1tip');
                $table->integer('mo1cod');
                $table->integer('mo1aa');
                $table->integer('mo1mm');
                $table->integer('mo1gg');
                $table->integer('mo1qta');
                $table->char('mo1tmo', 1);
                $table->char('mo1all', 1);
                $table->decimal('mo1qtv', 7);
                $table->char('mo1um', 1);
                $table->decimal('mo1oi', 6);
                $table->decimal('mo1of', 6);
                $table->char('mo1ann', 1);
                $table->integer('mov2kn');
                $table->integer('mov2kz');
                $table->integer('mov001');
                $table->char('mov002', 1);
                $table->char('mov003', 15);
                $table->integer('mov004');
                $table->integer('mov005');
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('mov01f');
    }
}
