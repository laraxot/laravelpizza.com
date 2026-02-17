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

        $this->tableCreate(function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->boolean('active')->default(true);
            $table->boolean('required')->default(true);
            $table->string('name')->unique();
            $table->text('description');
            $table->string('documentVersion')->nullable()->default(null);
            $table->string('documentUrl')->nullable()->default(null);
            $table->tinyInteger('weight');
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // if (! $this->hasColumn('email')) {
            //    $table->string('email')->nullable();
            // }
            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
