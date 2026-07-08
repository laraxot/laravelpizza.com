<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAsz03fTable.
 */
class CreateAsz03fTable extends XotBaseMigration
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
                $table->text('as3con')->nullable();
                $table->text('as3nom')->nullable();
                $table->text('as3tip')->nullable();
                $table->text('as3cod')->nullable();
                $table->text('as3dal')->nullable();
                $table->text('as3al')->nullable();
                $table->text('as3qtv')->nullable();
                $table->text('as3umi')->nullable();
                $table->text('as3ri1')->nullable();
                $table->text('as3ri2')->nullable();
                $table->text('as3ri3')->nullable();
                $table->text('as3ri4')->nullable();
                $table->text('as3ri5')->nullable();
                $table->text('as3ri6')->nullable();
                $table->text('as3tim')->nullable();
                $table->text('as3pro')->nullable();
                $table->text('as3001')->nullable();
                $table->text('as3002')->nullable();
                $table->text('as3003')->nullable();
                $table->text('as3004')->nullable();
                $table->text('as3005')->nullable();
                $table->text('as3ann')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('asz03f');
    }
}
