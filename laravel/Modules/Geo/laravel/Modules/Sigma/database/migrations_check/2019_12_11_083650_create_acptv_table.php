<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAcptvTable.
 */
class CreateAcptvTable extends XotBaseMigration
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
                $table->text('acpmat')->nullable();
                $table->text('acpcpd')->nullable();
                $table->text('acpina')->nullable();
                $table->text('acpann')->nullable();
                $table->text('acpmes')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('acptv');
    }
}
