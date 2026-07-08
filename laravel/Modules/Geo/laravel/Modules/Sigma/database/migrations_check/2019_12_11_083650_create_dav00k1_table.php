<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateDav00k1Table.
 */
class CreateDav00k1Table extends XotBaseMigration
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
                $table->text('voce')->nullable();
                $table->text('davanz')->nullable();
                $table->text('davini')->nullable();
                $table->text('davfin')->nullable();
                $table->text('davann')->nullable();
                $table->text('dav2kz')->nullable();
                $table->text('dav2ki')->nullable();
                $table->text('dav2kf')->nullable();
                $table->text('dav001')->nullable();
                $table->text('dav002')->nullable();
                $table->text('dav003')->nullable();
                $table->text('dav004')->nullable();
                $table->text('dav005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('dav00k1');
    }
}
