<?php

declare(strict_types=1);
use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\Tenant;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Owner migration `User::tenants` (consolidamento 2026-09-01).
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = Tenant::class;

    /**
     * Esegue la migrazione.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
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
            if (! $this->hasColumn('email_address')) {
                $table->string('email_address')->nullable();
            }
            if (! $this->hasColumn('phone')) {
                $table->string('phone')->nullable();
            }
            if (! $this->hasColumn('mobile')) {
                $table->string('mobile')->nullable();
            }
            if (! $this->hasColumn('address')) {
                $table->text('address')->nullable();
            }
            if (! $this->hasColumn('primary_color')) {
                $table->string('primary_color')->nullable();
            }
            if (! $this->hasColumn('secondary_color')) {
                $table->string('secondary_color')->nullable();
            }
            if (! $this->hasColumn('trial_ends_at')) {
                $table->dateTime('trial_ends_at')->nullable();
            }
            if (! $this->hasColumn('settings')) {
                $table->json('settings')->nullable();
            }

            $this->updateTimestamps($table, true);
        });
    }
};
