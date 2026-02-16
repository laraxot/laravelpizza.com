<?php

declare(strict_types=1);

use Illuminate\Contracts\Cache\Factory;
use Illuminate\Database\Schema\Blueprint;
// ---- models ---
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Class CreatePermissionsTable.
 */
return new class extends XotBaseMigration
{
    /**
     * Nome della tabella gestita dalla migrazione.
     */
    protected string $table_name = 'permissions';

    /**
     * Esegue la migrazione.
     */
    public function up(): void
    {
        // -- CACHE --
        try {
            if (app()->bound(Factory::class)) {
                $cache = app(Factory::class);
                $cache_store = config('permission.cache.store');
                $cache_key = config('permission.cache.key');
                /** @var string|null $store */
                $store = $cache_store !== 'default' ? $cache_store : null;
                /** @var string $cache_key */
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
            // Usa Schema::hasColumn direttamente per verificare esistenza
            $tableName = 'permissions';
            if (! Illuminate\Support\Facades\Schema::connection('user')->hasColumn($tableName, 'created_at')
                && ! Illuminate\Support\Facades\Schema::connection('user')->hasColumn($tableName, 'updated_at')) {
                $this->updateTimestamps($table);
            } else {
                // Se i timestamp esistono già, aggiungi solo i campi user se mancanti
                $xot = Modules\Xot\Datas\XotData::make();
                $userClass = $xot->getUserClass();
                if (! Illuminate\Support\Facades\Schema::connection('user')->hasColumn($tableName, 'updated_by')) {
                    $table->foreignIdFor($userClass, 'updated_by')->nullable();
                }
                if (! Illuminate\Support\Facades\Schema::connection('user')->hasColumn($tableName, 'created_by')) {
                    $table->foreignIdFor($userClass, 'created_by')->nullable();
                }
            }
        });
    }
};
