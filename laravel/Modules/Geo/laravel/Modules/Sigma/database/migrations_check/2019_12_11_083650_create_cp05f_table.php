<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCp05fTable.
 */
class CreateCp05fTable extends XotBaseMigration
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
                $table->text('field0')->nullable();
                $table->text('field1')->nullable();
                $table->text('field2')->nullable();
                $table->text('field3')->nullable();
                $table->text('field4')->nullable();
                $table->text('field5')->nullable();
                $table->text('field6')->nullable();
                $table->text('field7')->nullable();
                $table->text('field8')->nullable();
                $table->text('field9')->nullable();
                $table->text('field10')->nullable();
                $table->text('field11')->nullable();
                $table->text('field12')->nullable();
                $table->text('field13')->nullable();
                $table->text('field14')->nullable();
                $table->text('field15')->nullable();
                $table->text('field16')->nullable();
                $table->text('field17')->nullable();
                $table->text('field18')->nullable();
                $table->text('field19')->nullable();
                $table->text('field20')->nullable();
                $table->text('field21')->nullable();
                $table->text('field22')->nullable();
                $table->text('field23')->nullable();
                $table->text('field24')->nullable();
                $table->text('field25')->nullable();
                $table->text('field26')->nullable();
                $table->text('field27')->nullable();
                $table->text('field28')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('cp05f');
    }
}
