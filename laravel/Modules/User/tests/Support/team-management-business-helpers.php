<?php

declare(strict_types=1);
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\User\Database\Factories\TeamFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Team;
use Modules\User\Models\TeamInvitation;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

function teamMgmtBizUserTableHasColumn(string $table, string $column): bool
{
    return Schema::connection('user')->hasColumn($table, $column);
}

function teamMgmtBizTeamUsersRelationSupported(): bool
{
    return teamMgmtBizUserTableHasColumn('team_user', 'permissions');
}

function teamMgmtBizTeamUsesSoftDeletes(): bool
{
    return in_array(SoftDeletes::class, \class_uses_recursive(Team::class), true);
}

/**
 * @param  array<string, mixed>  $attributes
 */
function teamMgmtBizCreateUser(array $attributes = []): User
{
    /** @var User $user */
    $user = UserFactory::new()->createOne(array_merge([
        'email' => 'team-biz-'.uniqid('', true).'@example.com',
    ], $attributes));

    return $user;
}

/**
 * @param  array<string, mixed>  $attributes
 */
function teamMgmtBizCreateTeam(array $attributes = []): Team
{
    return TeamFactory::new()->createOne(array_merge([
        'name' => 'Team-'.uniqid(),
        'personal_team' => false,
    ], $attributes));
}

/**
 * @param  array<string, mixed>  $where
 */
function teamMgmtBizAssertDatabaseHas(string $table, array $where): void
{
    $query = DB::connection('user')->table($table);
    foreach ($where as $column => $value) {
        $query->where($column, $value);
    }

    Assert::assertTrue($query->exists());
}

/**
 * @param  array<string, mixed>  $where
 */
function teamMgmtBizAssertDatabaseMissing(string $table, array $where): void
{
    $query = DB::connection('user')->table($table);
    foreach ($where as $column => $value) {
        $query->where($column, $value);
    }

    Assert::assertFalse($query->exists());
}

/**
 * @param  array<string, mixed>  $pivot
 */
function teamMgmtBizAttachMember(Team $team, User $user, array $pivot = []): void
{
    $payload = [
        'team_id' => $team->id,
        'user_id' => $user->id,
        'created_at' => now(),
        'updated_at' => now(),
    ];

    if (isset($pivot['role'])) {
        $payload['role'] = $pivot['role'];
    }

    if (teamMgmtBizUserTableHasColumn('team_user', 'permissions') && array_key_exists('permissions', $pivot)) {
        $permissions = $pivot['permissions'];
        $payload['permissions'] = is_array($permissions) ? json_encode($permissions) : $permissions;
    }

    DB::connection('user')->table('team_user')->insert($payload);
}

function teamMgmtBizDetachMember(Team $team, User $user): void
{
    DB::connection('user')->table('team_user')
        ->where('team_id', $team->id)
        ->where('user_id', $user->id)
        ->delete();
}

function teamMgmtBizMemberExists(Team $team, User $user): bool
{
    return DB::connection('user')->table('team_user')
        ->where('team_id', $team->id)
        ->where('user_id', $user->id)
        ->exists();
}

/**
 * @param  array<string, mixed>  $attributes
 */
function teamMgmtBizCreateInvitation(Team $team, array $attributes = []): TeamInvitation
{
    $payload = array_merge([
        'uuid' => (string) Str::uuid(),
        'team_id' => (string) $team->id,
        'email' => 'invite-'.uniqid().'@example.com',
        'role' => 'member',
    ], $attributes);

    $invitation = new TeamInvitation;
    $invitation->forceFill($payload);
    $invitation->save();
    $fresh = $invitation->fresh();

    return $fresh instanceof TeamInvitation ? $fresh : $invitation;
}
