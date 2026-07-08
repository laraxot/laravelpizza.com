<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAna01k1Table.
 */
class CreateAna01k1Table extends XotBaseMigration
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
                $table->text('anvdal')->nullable();
                $table->text('anval')->nullable();
                $table->text('codvo')->nullable();
                $table->text('imp')->nullable();
                $table->text('impoeu')->nullable();
                $table->text('codimp')->nullable();
                $table->text('tipm')->nullable();
                $table->text('anvann')->nullable();
                $table->text('seq')->nullable();
                $table->text('anv2kd')->nullable();
                $table->text('anv2ka')->nullable();
                $table->text('an1001')->nullable();
                $table->text('an2002')->nullable();
                $table->text('an3003')->nullable();
                $table->text('an4004')->nullable();
                $table->text('an5005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('ana01k1');
    }
}
