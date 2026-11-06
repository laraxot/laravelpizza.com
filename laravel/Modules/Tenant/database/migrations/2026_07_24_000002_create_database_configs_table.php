<?php

declare(strict_types=1);
use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            $table->id();
            $table->string('host')->nullable();
            $table->integer('port')->nullable();
            $table->string('database')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('charset')->nullable();
            $table->string('collation')->nullable();
            $table->string('prefix')->nullable();
            $table->boolean('prefix_indexes')->nullable();
            $table->boolean('strict')->nullable();
            $table->string('engine')->nullable();
            $table->json('options')->nullable();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
