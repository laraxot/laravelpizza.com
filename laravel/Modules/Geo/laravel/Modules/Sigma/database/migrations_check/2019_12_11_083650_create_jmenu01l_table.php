<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateJmenu01lTable.
 */
class CreateJmenu01lTable extends XotBaseMigration
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
                $table->text('flanab')->nullable();
                $table->text('cdmnab')->nullable();
                $table->text('dsmnab')->nullable();
                $table->text('sinfab')->nullable();
                $table->text('mnpgab')->nullable();
                $table->text('nmlhab')->nullable();
                $table->text('nmfhab')->nullable();
                $table->text('nmmhab')->nullable();
                $table->text('tpohab')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('jmenu01l');
    }
}
