<?php

declare(strict_types=1);
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\Permission;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Datas\XotData;

/*
 * Class CreatePermissionsTable.
 */
/*
 * Owner migration `User::permissions` (consolidamento 2026-09-01).
 * Colonne unione viste nei duplicati non presenti qui: nessuna.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = Permission::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CACHE --
        try {
            if (app()->bound(Factory::class)) {
                $cache = app(Factory::class);
                $cache_store = config('permission.cache.store');
                $cache_key = config('permission.cache.key');
                $store = is_string($cache_store) && $cache_store !== 'default' ? $cache_store : null;
                if (is_string($cache_key)) {
                    $cache->store($store)->forget($cache_key);
                }
            }
        } catch (Exception $e) {
        }

        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->unique(['name', 'guard_name']);
        });
        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            if (
                ! $this->hasColumn('created_at')
                && ! $this->hasColumn('updated_at')
            ) {
                $this->updateTimestamps($table);
            } else {
                $xot = XotData::make();
                $userClass = $xot->getUserClass();
                if (! $this->hasColumn('updated_by')) {
                    $table->foreignIdFor($userClass, 'updated_by')->nullable();
                }
                if (! $this->hasColumn('created_by')) {
                    $table->foreignIdFor($userClass, 'created_by')->nullable();
                }
            }
        });
    }
};
