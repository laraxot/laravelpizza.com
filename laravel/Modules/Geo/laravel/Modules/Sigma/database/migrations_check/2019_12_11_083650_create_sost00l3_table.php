<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateSost00l3Table.
 */
class CreateSost00l3Table extends XotBaseMigration
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
                $table->text('ssanno')->nullable();
                $table->text('ssdal')->nullable();
                $table->text('ssal')->nullable();
                $table->text('ssesp')->nullable();
                $table->text('sscla')->nullable();
                $table->text('ssmatr')->nullable();
                $table->text('sssta')->nullable();
                $table->text('ssrep')->nullable();
                $table->text('sspro')->nullable();
                $table->text('sspos')->nullable();
                $table->text('sosann')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('sost00l3');
    }
}
