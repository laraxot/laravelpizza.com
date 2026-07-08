<?php

declare(strict_types=1);

namespace Modules\User\Tests\Traits;

use Filament\Actions\Action;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\User\Models\OauthClient;
use Modules\User\Models\Team;
use Modules\User\Models\TeamInvitation;
use Modules\User\Models\User;

use function Safe\json_encode;

/**
 * Team pivot, OAuth client fixtures, and Filament section helpers for User tests.
 */
trait InteractsWithTeamsAndOAuth
{
    public function skipUnlessTeamUsersRelationSupported(): void
    {
        if (! $this->userTableHasColumn('team_user', 'permissions')) {
            $this->skipTest('team_user.permissions column missing — Team::users() pivot not loadable.');
        }
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public static function createTestUser(array $attributes = []): User
    {
        /** @var User $user */
        $user = parent::createTestUser(array_merge([
            'email' => 'user-'.uniqid('', true).'@example.com',
        ], $attributes));

        return $user;
    }

    public function createMockSocialiteUser(?string $name, ?string $email): \Laravel\Socialite\Contracts\User
    {
        $mock = $this->createUnitMock(\Laravel\Socialite\Contracts\User::class);
        $mock->method('getName')->willReturn($name);
        $mock->method('getEmail')->willReturn($email);

        return $mock;
    }

    /**
     * @param array<string, mixed> $overrides
     */
    public function oauthClientTestPersistedClient(array $overrides = []): OauthClient
    {
        $clientId = (string) Str::uuid();
        $redirect = 'https://example.test/callback/'.uniqid('', true);

        $payload = array_merge([
            'id' => $clientId,
            'user_id' => null,
            'name' => 'Test OAuth Client '.uniqid('', true),
            'secret' => 'test-secret',
            'provider' => 'users',
            'redirect' => $redirect,
            'redirect_uris' => json_encode([$redirect]),
            'grant_types' => json_encode(['authorization_code', 'refresh_token']),
            'personal_access_client' => 0,
            'password_client' => 0,
            'revoked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ], $overrides);

        if (Schema::connection('user')->hasColumn('oauth_clients', 'owner_id')) {
            $payload['owner_id'] = $payload['owner_id'] ?? $payload['user_id'] ?? null;
            $payload['owner_type'] = $payload['owner_type'] ?? null;
        }

        DB::connection('user')->table('oauth_clients')->insert($payload);

        return OauthClient::query()->findOrFail($clientId);
    }

    /**
     * @param array<string, mixed> $pivot
     */
    public function attachTeamMember(Team $team, User $user, array $pivot = []): void
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

        if ($this->userTableHasColumn('team_user', 'permissions') && array_key_exists('permissions', $pivot)) {
            $permissions = $pivot['permissions'];
            $payload['permissions'] = is_array($permissions) ? json_encode($permissions) : $permissions;
        }

        if ($this->userTableHasColumn('team_user', 'joined_at') && array_key_exists('joined_at', $pivot)) {
            $payload['joined_at'] = $pivot['joined_at'];
        }

        DB::connection('user')->table('team_user')->insert($payload);
    }

    public function detachTeamMember(Team $team, User $user): void
    {
        DB::connection('user')->table('team_user')
            ->where('team_id', $team->id)
            ->where('user_id', $user->id)
            ->delete();
    }

    public function teamMemberExists(Team $team, User $user): bool
    {
        return DB::connection('user')->table('team_user')
            ->where('team_id', $team->id)
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * @return array<int, Component|Action|\Filament\Actions\ActionGroup>
     */
    public function filamentSectionChildComponents(Section $section): array
    {
        return array_values($section->getChildComponents());
    }

    public function teamUsesSoftDeletes(): bool
    {
        /** @var array<class-string, class-string> $traits */
        $traits = \class_uses_recursive(Team::class);

        return in_array(
            \Illuminate\Database\Eloquent\SoftDeletes::class,
            $traits,
            true
        );
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function createTeamInvitationRecord(Team $team, array $attributes = []): TeamInvitation
    {
        $payload = array_merge([
            'uuid' => (string) Str::uuid(),
            'team_id' => (string) $team->id,
            'email' => 'invite-'.uniqid().'@example.com',
            'role' => 'member',
        ], $attributes);

        $invitation = new TeamInvitation();
        $invitation->forceFill($payload);
        $invitation->save();

        return $invitation->fresh() ?? $invitation;
    }
}
