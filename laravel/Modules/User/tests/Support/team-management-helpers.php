<?php

declare(strict_types=1);
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\User\Database\Factories\TeamFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Team;
use Modules\User\Models\TeamInvitation;
use Modules\User\Models\User;

use function Safe\json_encode;

function teamMgmtUserTableHasColumn(string $table, string $column): bool
{
    return Schema::connection('user')->hasColumn($table, $column);
}

function teamMgmtUserTableExists(string $table): bool
{
    return Schema::connection('user')->hasTable($table);
}

function teamMgmtTeamUsersRelationSupported(): bool
{
    return teamMgmtUserTableHasColumn('team_user', 'permissions');
}

/**
 * @param  array<string, mixed>  $attributes
 */
function teamMgmtCreateUser(array $attributes = []): User
{
    /** @var User $user */
    $user = UserFactory::new()->createOne(array_merge([
        'email' => 'team-mgmt-'.uniqid('', true).'@example.com',
    ], $attributes));

    return $user;
}

/**
 * @param  array<string, mixed>  $attributes
 */
function teamMgmtCreateTeam(User $owner, array $attributes = []): Team
{
    return TeamFactory::new()->createOne(array_merge([
        'user_id' => $owner->id,
        'name' => 'Test Team '.uniqid(),
    ], $attributes));
}

/**
 * @return array{owner: User, member: User, team: Team}
 */
function teamMgmtBootstrap(): array
{
    $owner = teamMgmtCreateUser();
    $member = teamMgmtCreateUser();
    $team = teamMgmtCreateTeam($owner);

    return compact('owner', 'member', 'team');
}

/**
 * @param  array<string, mixed>  $pivot
 */
function teamMgmtAttachMember(Team $team, User $user, array $pivot = []): void
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

    if (teamMgmtUserTableHasColumn('team_user', 'permissions') && array_key_exists('permissions', $pivot)) {
        $permissions = $pivot['permissions'];
        $payload['permissions'] = is_array($permissions) ? json_encode($permissions) : $permissions;
    }

    if (teamMgmtUserTableHasColumn('team_user', 'joined_at') && array_key_exists('joined_at', $pivot)) {
        $payload['joined_at'] = $pivot['joined_at'];
    }

    DB::connection('user')->table('team_user')->insert($payload);
}

function teamMgmtDetachMember(Team $team, User $user): void
{
    DB::connection('user')->table('team_user')
        ->where('team_id', $team->id)
        ->where('user_id', $user->id)
        ->delete();
}

function teamMgmtMemberExists(Team $team, User $user): bool
{
    return DB::connection('user')->table('team_user')
        ->where('team_id', $team->id)
        ->where('user_id', $user->id)
        ->exists();
}

/**
 * @param  array<string, mixed>  $attributes
 */
function teamMgmtCreateInvitation(Team $team, array $attributes = []): TeamInvitation
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
