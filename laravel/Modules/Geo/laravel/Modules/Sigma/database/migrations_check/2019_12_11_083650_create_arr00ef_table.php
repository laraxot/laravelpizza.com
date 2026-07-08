<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateArr00efTable.
 */
class CreateArr00efTable extends XotBaseMigration
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
                $table->text('datarr')->nullable();
                $table->text('tiparr')->nullable();
                $table->text('dat2kr')->nullable();
                $table->text('arranp')->nullable();
                $table->text('arr001')->nullable();
                $table->text('arr002')->nullable();
                $table->text('arr003')->nullable();
                $table->text('arr004')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('arr00ef');
    }
}
