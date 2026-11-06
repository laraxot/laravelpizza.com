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
        $teams = config()->boolean('permission.teams', false);

        if (config()->array('permission.table_names', []) === []) {
            throw new Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        $teamForeignKey = config('permission.column_names.team_foreign_key');
        if ($teams && (! is_string($teamForeignKey) || $teamForeignKey === '')) {
            throw new Exception('Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        try {
            // Verifica se l'applicazione è completamente inizializzata
            if (app()->bound('cache')) {
                $cacheStore = config()->string('permission.cache.store', 'default');
                app('cache')
                    ->store($cacheStore === 'default' ? null : $cacheStore)
                    ->forget(config()->string('permission.cache.key'));
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
