<?php

declare(strict_types=1);

namespace Modules\User\Tests\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

/**
 * Schema guards and assertions on the user DB connection in module tests.
 */
trait InteractsWithUserDatabase
{
    public function userTableHasColumn(string $table, string $column): bool
    {
        return Schema::connection('user')->hasColumn($table, $column);
    }

    public function skipUnlessUserColumn(string $table, string $column, string $reason = ''): void
    {
        if (! $this->userTableHasColumn($table, $column)) {
            $this->skipTest('' !== $reason ? $reason : "Column {$table}.{$column} missing on user connection.");
        }
    }

    public function userTableExists(string $table): bool
    {
        return Schema::connection('user')->hasTable($table);
    }

    public function skipUnlessUserTable(string $table, string $reason = ''): void
    {
        if (! $this->userTableExists($table)) {
            $this->skipTest('' !== $reason ? $reason : "Table {$table} missing on user connection.");
        }
    }

    public function skipUnlessTenantColumn(string $column, string $reason = ''): void
    {
        $this->skipUnlessUserColumn('tenants', $column, $reason);
    }

    public function skipUnlessUsersTableReady(string $reason = ''): void
    {
        $this->skipUnlessUserTable('users', '' !== $reason ? $reason : 'users table missing on user connection.');
    }

    public function skipUnlessRoleAssignmentSupported(string $reason = ''): void
    {
        $table = $this->permissionRolePivotTable();
        $this->skipUnlessUserTable($table, '' !== $reason ? $reason : "Role pivot table {$table} missing on user connection.");
    }

    public function skipUnlessDirectPermissionSupported(string $reason = ''): void
    {
        $table = $this->permissionPivotTable();
        $this->skipUnlessUserTable($table, '' !== $reason ? $reason : "Permission pivot table {$table} missing on user connection.");
    }

    public function skipUnlessUserSoftDeletes(string $reason = ''): void
    {
        if (! in_array(
            \Illuminate\Database\Eloquent\SoftDeletes::class,
            \class_uses_recursive(User::class),
            true
        )) {
            $this->skipTest('' !== $reason ? $reason : 'User model does not use SoftDeletes.');
        }
    }

    public function skipLegacyRedirectPersistence(): void
    {
        if (
            Schema::connection('user')->hasColumn('oauth_clients', 'redirect')
            && Schema::connection('user')->hasColumn('oauth_clients', 'redirect_uris')
        ) {
            $this->skipTest('oauth_clients legacy redirect columns require redirect_uris sync not performed by Create*ClientAction.');
        }
    }

    public function permissionRolePivotTable(): string
    {
        return (string) config('permission.table_names.model_has_roles', 'model_has_role');
    }

    public function permissionPivotTable(): string
    {
        return (string) config('permission.table_names.model_has_permissions', 'model_has_permission');
    }

    /**
     * @param array<string, mixed> $data
     */
    public function assertDatabaseHasRow(string $table, array $data, ?string $connection = 'user'): void
    {
        $this->assertDatabaseHas($table, $data, $connection);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function assertDatabaseMissingRow(string $table, array $data, ?string $connection = 'user'): void
    {
        $query = DB::connection($connection)->table($table);

        foreach ($data as $column => $value) {
            $query->where((string) $column, $value);
        }

        Assert::assertFalse($query->exists());
    }
}
