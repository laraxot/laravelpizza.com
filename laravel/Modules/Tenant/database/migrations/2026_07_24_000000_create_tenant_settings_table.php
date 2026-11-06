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
            // tenant_id references the shared `tenants` table (string id),
            // defined in the User module, not here.
            $table->string('tenant_id')->nullable();
            $table->string('key');
            $table->text('value')->nullable();
            $table->string('type')->nullable();

            $table->index('tenant_id', 'tenant_settings_tenant_id_idx');
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
