<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateSchedaCriteriTable.
 */
return new class extends XotBaseMigration
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
                $table->text('criterio')->nullable();
                $table->integer('peso')->nullable();
                $table->text('descr')->nullable();
                $table->boolean('is_editable')->nullable();
                $table->string('field_name', 50)->nullable();
                $table->integer('anno')->nullable();
                $table->integer('pos')->nullable();
                $table->integer('converted_in')->nullable();
                $table->string('created_by', 50)->nullable();
                $table->string('updated_by', 50)->nullable();
                $table->timestamps();
            }
        );
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                $this->updateTimestamps($table);
            }
        );
    }
};
