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
            $table->string('plan_name')->nullable();
            $table->string('status')->nullable();
            $table->integer('max_users')->nullable();
            $table->integer('current_users')->nullable();
            $table->decimal('max_storage_gb', 12, 2)->nullable();
            $table->decimal('current_storage_gb', 12, 2)->nullable();
            $table->string('billing_cycle')->nullable();
            $table->decimal('billing_amount', 12, 2)->nullable();
            $table->dateTime('next_billing_date')->nullable();
            $table->dateTime('expires_at')->nullable();

            $table->index('tenant_id', 'tenant_subscriptions_tenant_id_idx');
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
