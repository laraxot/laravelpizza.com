<?php

declare(strict_types=1);
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /** @var string|null $cache_key */
        $cache_key = config('permission.cache.key');

        try {
            // Verifica se l'applicazione è completamente inizializzata
            if (app()->bound('cache') && is_string($cache_key)) {
                /** @var string|null $store */
                $store = config('permission.cache.store');
                app('cache')->store(is_string($store) ? $store : null)->forget($cache_key);
            }
        } catch (Exception $e) {
            // Silently ignore cache errors during package discovery
            // echo $e->getMessage();
        }
    }

    /* -- is in xotbasemigration
     * public function down(): void
     * {
     * $tableNames = config('permission.table_names');
     *
     * if (empty($tableNames)) {
     * throw new Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
     * }
     *
     * Schema::drop($tableNames['role_has_permissions']);
     * Schema::drop($tableNames['model_has_roles']);
     * Schema::drop($tableNames['model_has_permissions']);
     * Schema::drop($tableNames['roles']);
     * Schema::drop($tableNames['permissions']);
     * }
     */
};
