<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAsp00fTable.
 */
class CreateAsp00fTable extends XotBaseMigration
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
                $table->string('ENTE', 250)->nullable();
                $table->string('MATR', 250)->nullable();
                $table->string('TIPASP', 250)->nullable();
                $table->string('ASPANN', 250)->nullable();
                $table->string('ASP2KI', 250)->nullable();
                $table->string('ASP2KF', 250)->nullable();
                $table->string('ASP2KC', 250)->nullable();
                $table->string('ASP2KP', 250)->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('asp00f');
    }
}
