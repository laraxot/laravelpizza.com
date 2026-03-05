<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    /**
     * Nome della tabella.
     */
    protected string $table_name = 'tenants';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->string('id')->primary();
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->string('domain')->nullable();
            $table->string('database')->nullable();
            $table->boolean('is_active')->default(true);
            $table->dateTime('trial_ends_at')->nullable();
            $table->json('settings')->nullable();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('settings')) {
                $table->json('settings')->nullable();
            }
            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
