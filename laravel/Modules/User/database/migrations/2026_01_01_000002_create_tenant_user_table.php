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
            // $table->uuid('id')->primary();
            $table->id();
            // tenants.id è una stringa (uuid o slug): un foreignId intero non la può contenere
            $table->string('tenant_id', 36)->index();
            $table->uuid('user_id')->nullable()->index();

            // $table->foreignIdFor(\Modules\Xot\Datas\XotData::make()->getUserClass());
            // $table->string('role')->nullable();
            // $table->unique(['team_id', 'user_id']);
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            if (\in_array($this->getColumnType('tenant_id'), ['bigint', 'integer', 'int'], true)) {
                $table->string('tenant_id', 36)->change();
            }

            $this->updateTimestamps(table: $table, hasSoftDeletes: true);
        });
    }
};