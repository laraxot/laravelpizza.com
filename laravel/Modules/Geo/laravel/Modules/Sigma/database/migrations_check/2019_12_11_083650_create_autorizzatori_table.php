<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAutorizzatoriTable.
 */
class CreateAutorizzatoriTable extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->string('nome', 100)->default('');
                $table->string('autorizzatore', 100)->default('');
                $table->primary(['autorizzatore', 'nome']);
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('autorizzatori');
    }
}
