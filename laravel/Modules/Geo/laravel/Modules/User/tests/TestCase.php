<?php

declare(strict_types=1);

namespace Modules\User\Tests;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Panel;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Widgets\Widget;
use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Modules\User\Filament\Resources\UserResource\Pages\CreateUser;
use Modules\User\Filament\Resources\UserResource\Pages\ListUsers;
use Modules\User\Filament\Widgets\LoginWidget;
use Modules\User\Models\Device;
use Modules\User\Models\OauthClient;
use Modules\User\Models\Team;
use Modules\User\Models\TeamInvitation;
use Modules\User\Models\Tenant;
use Modules\User\Models\User;
use Modules\User\Providers\Filament\AdminPanelProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;
use PHPUnit\Framework\Assert;
use PragmaRX\Google2FA\Google2FA;

use function Safe\json_encode;

/**
 * Base test case for User module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped by TenantServiceProvider.
 * Migrations must be run ONCE externally: php artisan migrate --env=testing
 * DatabaseTransactions handles rollback between tests.
 *
 * @property User|null                  $user
 * @property User|null                  $owner
 * @property User|null                  $member
 * @property User|null                  $admin
 * @property User|null                  $baseUser
 * @property Team|null                  $team
 * @property Tenant|null                $tenant1
 * @property Tenant|null                $tenant2
 * @property Google2FA|null             $google2fa
 * @property Command|null               $command
 * @property ListUsers|null             $listUsersPage
 * @property CreateUser|null            $createUserPage
 * @property Device|null                $device
 * @property Action|null                $action
 * @property Widget|null                $widget
 * @property Collection<int, User>|null $users
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    /**
     * @return array<int, class-string<ServiceProvider>>
     */
    protected function getPackageProviders(mixed $app): array
    {
        if (! $app instanceof Application) {
            throw new \InvalidArgumentException('Expected Illuminate\Foundation\Application.');
        }

        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
        ];
    }

    public ?User $user = null;

    public ?User $owner = null;

    public ?User $member = null;

    public ?User $admin = null;

    public ?User $baseUser = null;

    public ?Team $team = null;

    public ?Tenant $tenant1 = null;

    public ?Tenant $tenant2 = null;

    public ?Device $device = null;

    public ?Google2FA $google2fa = null;

    public ?Command $command = null;

    public ?CreateUser $createUserPage = null;

    public ?ListUsers $listUsersPage = null;

    /** @var Collection<int, User>|null */
    public ?Collection $users = null;

    /** @var list<string> */
    protected $connectionsToTransact = ['sqlite', 'user'];

    protected function setUp(): void
    {
        parent::setUp();

        $database = database_path('fixcity_data.sqlite');

        /** @var array<string, array<string, mixed>> $connections */
        $connections = config('database.connections', []);

        foreach (array_keys($connections) as $connection) {
            if ('sqlite' !== config("database.connections.{$connection}.driver")) {
                continue;
            }

            $this->app['config']->set("database.connections.{$connection}.database", $database);
            DB::purge($connection);
        }
    }

    public function setupFilamentAdminPanel(): void
    {
        try {
            $panel = Filament::getPanel('user::admin');
        } catch (\Throwable) {
            $panelProvider = new AdminPanelProvider($this->app);
            $panel = $panelProvider->panel(Panel::make());
            Filament::registerPanel($panel);
        }

        Filament::setCurrentPanel($panel);
    }

    public function freshUser(User $user): User
    {
        $fresh = $user->fresh();
        if (null === $fresh) {
            $this->fail('User model could not be refreshed.');
        }

        return $fresh;
    }

    public function requireUser(): User
    {
        $user = $this->user;
        if (null === $user) {
            $this->fail('User test property is not initialized.');
        }

        return $user;
    }

    public function requireOwner(): User
    {
        $owner = $this->owner;
        if (null === $owner) {
            $this->fail('Owner test property is not initialized.');
        }

        return $owner;
    }

    public function requireMember(): User
    {
        $member = $this->member;
        if (null === $member) {
            $this->fail('Member test property is not initialized.');
        }

        return $member;
    }

    public function requireAdmin(): User
    {
        $admin = $this->admin;
        if (null === $admin) {
            $this->fail('Admin test property is not initialized.');
        }

        return $admin;
    }

    public function requireBaseUser(): User
    {
        $baseUser = $this->baseUser;
        if (null === $baseUser) {
            $this->fail('BaseUser test property is not initialized.');
        }

        return $baseUser;
    }

    public function requireTeam(): Team
    {
        $team = $this->team;
        if (null === $team) {
            $this->fail('Team test property is not initialized.');
        }

        return $team;
    }

    public function requireTenant1(): Tenant
    {
        $tenant1 = $this->tenant1;
        if (null === $tenant1) {
            $this->fail('Tenant1 test property is not initialized.');
        }

        return $tenant1;
    }

    public function requireTenant2(): Tenant
    {
        $tenant2 = $this->tenant2;
        if (null === $tenant2) {
            $this->fail('Tenant2 test property is not initialized.');
        }

        return $tenant2;
    }

    public function requireGoogle2fa(): Google2FA
    {
        $google2fa = $this->google2fa;
        if (null === $google2fa) {
            $this->fail('Google2FA test property is not initialized.');
        }

        return $google2fa;
    }

    public function requireDevice(): Device
    {
        $device = $this->device;
        if (null === $device) {
            $this->fail('Device test property is not initialized.');
        }

        return $device;
    }

    public function requireCommand(): Command
    {
        $command = $this->command;
        if (null === $command) {
            $this->fail('Command test property is not initialized.');
        }

        return $command;
    }

    public function requireAction(): Action
    {
        $action = $this->action;
        if (null === $action) {
            $this->fail('Action test property is not initialized.');
        }

        return $action;
    }

    public function requireWidget(): Widget
    {
        if (null === $this->widget) {
            $this->fail('Widget test property is not initialized.');
        }

        return $this->widget;
    }

    public function requireLoginWidget(): LoginWidget
    {
        $widget = $this->requireWidget();
        Assert::assertInstanceOf(LoginWidget::class, $widget);

        return $widget;
    }

    public function requireCreateUserPage(): CreateUser
    {
        $createUserPage = $this->createUserPage;
        if (null === $createUserPage) {
            $this->fail('CreateUser page test property is not initialized.');
        }

        return $createUserPage;
    }

    public function requireListUsersPage(): ListUsers
    {
        $listUsersPage = $this->listUsersPage;
        if (null === $listUsersPage) {
            $this->fail('ListUsers page test property is not initialized.');
        }

        return $listUsersPage;
    }

    /**
     * @return Collection<int, User>
     */
    public function requireUsers(): Collection
    {
        $users = $this->users;
        if (null === $users) {
            $this->fail('Users test property is not initialized.');
        }

        return $users;
    }

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

    public function skipUnlessTeamUsersRelationSupported(): void
    {
        if (! $this->userTableHasColumn('team_user', 'permissions')) {
            $this->skipTest('team_user.permissions column missing — Team::users() pivot not loadable.');
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

    public function requireFreshUser(User $user): User
    {
        $fresh = $user->fresh();
        Assert::assertNotNull($fresh);

        return $fresh;
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
