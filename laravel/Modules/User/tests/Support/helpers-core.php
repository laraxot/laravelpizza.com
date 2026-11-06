<?php

declare(strict_types=1);
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Schema;
use Modules\User\Database\Factories\TeamFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

/**
 * @param  array<string, mixed>  $attributes
 */
function createUser(array $attributes = []): User
{
    $factory = User::factory();
    \assert($factory instanceof Factory);

    $user = $factory->create($attributes);
    \assert($user instanceof User);

    return $user;
}

/**
 * @param  array<string, mixed>  $attributes
 */
function makeUser(array $attributes = []): User
{
    $factory = User::factory();
    \assert($factory instanceof Factory);

    $user = $factory->make($attributes);
    \assert($user instanceof User);

    return $user;
}

/**
 * @param  array<string, mixed>  $attributes
 */
function createTeam(array $attributes = []): Team
{
    return TeamFactory::new()->createOne(array_merge([
        'name' => 'team-'.uniqid(),
    ], $attributes));
}

/**
 * @param  array<string, mixed>  $attributes
 */
function createTestUser(array $attributes = []): User
{
    return UserFactory::new()->createOne(array_merge([
        'email' => 'test-'.uniqid('', true).'@example.com',
    ], $attributes));
}

function plainTestPassword(): string
{
    static $password = null;

    if (! is_string($password)) {
        $password = fake()->password(12).'Aa1!';
    }

    return $password;
}

/**
 * @return array{user: User, team: Team, personalTeam: Team}
 */
function bootstrapHasTeamsFixture(): array
{
    $user = createTestUser();
    $team = TeamFactory::new()->createOne(['name' => 'shared-'.uniqid()]);
    $personalTeam = TeamFactory::new()->createOne([
        'user_id' => $user->id,
        'name' => 'personal-'.uniqid(),
        'personal_team' => true,
    ]);

    return [
        'user' => $user,
        'team' => $team,
        'personalTeam' => $personalTeam,
    ];
}

function userTableHasColumn(string $table, string $column): bool
{
    return Schema::connection('user')->hasColumn($table, $column);
}

function pestSkip(string $message): never
{
    Assert::markTestSkipped($message);
}

function skipUnlessUserColumn(string $table, string $column, string $reason = ''): void
{
    if (! userTableHasColumn($table, $column)) {
        pestSkip($reason !== '' ? $reason : "Column {$table}.{$column} missing on user connection.");
    }
}

function userTableExists(string $table): bool
{
    return Schema::connection('user')->hasTable($table);
}

function skipUnlessUserTable(string $table, string $reason = ''): void
{
    if (! userTableExists($table)) {
        pestSkip($reason !== '' ? $reason : "Table {$table} missing on user connection.");
    }
}

function permissionRolePivotTable(): string
{
    $value = config('permission.table_names.model_has_roles', 'model_has_role');

    return is_string($value) ? $value : 'model_has_role';
}

function permissionPivotTable(): string
{
    $value = config('permission.table_names.model_has_permissions', 'model_has_permission');

    return is_string($value) ? $value : 'model_has_permission';
}

function skipUnlessUsersTableReady(string $reason = ''): void
{
    skipUnlessUserTable('users', $reason !== '' ? $reason : 'users table missing on user connection.');
}

function skipUnlessRoleAssignmentSupported(string $reason = ''): void
{
    $table = permissionRolePivotTable();
    skipUnlessUserTable($table, $reason !== '' ? $reason : "Role pivot table {$table} missing on user connection.");
}

function skipUnlessDirectPermissionSupported(string $reason = ''): void
{
    $table = permissionPivotTable();
    skipUnlessUserTable($table, $reason !== '' ? $reason : "Permission pivot table {$table} missing on user connection.");
}

function skipUnlessTeamUsersRelationSupported(): void
{
    if (! userTableHasColumn('team_user', 'permissions')) {
        pestSkip('team_user.permissions column missing — Team::users() pivot not loadable.');
    }
}
