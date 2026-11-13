<?php

declare(strict_types=1);

namespace Modules\User\Tests;

use Illuminate\Database\DatabaseManager;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Facades\Filament;
use Filament\Panel;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema as FilamentSchema;
use Filament\Widgets\Widget;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\SoftDeletes;
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
 * @property User|null $user
 * @property User|null $owner
 * @property User|null $member
 * @property User|null $admin
 * @property User|null $baseUser
 * @property Team|null $team
 * @property Tenant|null $tenant1
 * @property Tenant|null $tenant2
 * @property Google2FA|null $google2fa
 * @property Command|null $command
 * @property ListUsers|null $listUsersPage
 * @property CreateUser|null $createUserPage
 * @property Device|null $device
 * @property Action|null $action
 * @property Widget|null $widget
 * @property Collection<int, User>|null $users
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions {
        beginDatabaseTransaction as openDatabaseTransactions;
    }

    /**
     * Le migration girano una volta per processo, come in `Tests\TestCase`.
     */
    public static bool $userSchemaMigrated = false;

    /**
     * Su MariaDB (CI e sviluppo) lo schema del database `*_test` non viene costruito da
     * `xot:build-test-sqlite`, che popola solo lo SQLite condiviso: senza questo passo i test
     * che girano prima del primo `Tests\TestCase` (che lancia `migrate`) muoiono con
     * "Table 'fixcity_user_test.users' doesn't exist". `migrate` e' additivo (mai `fresh`)
     * e la `TestDatabaseGuard` garantisce che ogni connessione punti a un database `_test`.
     * Va fatto prima di aprire le transazioni: in MySQL ogni DDL fa commit implicito.
     *
     * Nessun tipo di ritorno nativo: il metodo del trait non lo dichiara.
     *
     * @return void
     */
    public function beginDatabaseTransaction()
    {
        if (! static::$userSchemaMigrated) {
            static::$userSchemaMigrated = true;

            if (config('database.default') !== 'sqlite') {
                $this->app?->make(\Illuminate\Contracts\Console\Kernel::class)
                    ->call('migrate', ['--force' => true]);
            }
        }

        $this->openDatabaseTransactions();
    }

    protected function setUp(): void
    {
        // Ambiente locale senza MariaDB dedicato: redirige le connessioni
        // sqlite sulla fixture condivisa; le tabelle user assenti fanno
        // scattare gli skipUnless* già previsti da questa TestCase.
        $this->prepareSharedSqliteForTesting();

        if (config('database.default') === 'sqlite') {
            $this->connectionsToTransact = ['user'];
        }

        parent::setUp();
    }

    /**
     * @return array<int, class-string<ServiceProvider>>
     */
    protected function getPackageProviders(Application $app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
        ];
    }

    public static ?User $user = null;

    public static ?User $owner = null;

    public static ?User $member = null;

    public static ?User $admin = null;

    public static ?User $baseUser = null;

    public static ?Team $team = null;

    public static ?Tenant $tenant1 = null;

    public static ?Tenant $tenant2 = null;

    public static ?Device $device = null;

    public static ?Google2FA $google2fa = null;

    public static ?Command $command = null;

    public static ?CreateUser $createUserPage = null;

    public static ?ListUsers $listUsersPage = null;

    /** @var Collection<int, User>|null */
    public static ?Collection $users = null;

    /**
     * Come `Tests\TestCase`: anche `mariadb` (default in CI) e `fixcity` (Profile del progetto)
     * vanno in transazione, altrimenti le righe scritte dai test restano nel DB `_test`.
     *
     * @var list<string>
     */
    protected $connectionsToTransact = ['mysql', 'mariadb', 'user', 'fixcity'];

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

    public static function freshUser(User $user): User
    {
        $fresh = $user->fresh();
        if ($fresh === null) {
            Assert::fail('User model could not be refreshed.');
        }

        return $fresh;
    }

    public static function requireUser(): User
    {
        $user = self::$user;
        if ($user === null) {
            Assert::fail('User test property is not initialized.');
        }

        return $user;
    }

    public static function requireOwner(): User
    {
        $owner = self::$owner;
        if ($owner === null) {
            Assert::fail('Owner test property is not initialized.');
        }

        return $owner;
    }

    public static function requireMember(): User
    {
        $member = self::$member;
        if ($member === null) {
            Assert::fail('Member test property is not initialized.');
        }

        return $member;
    }

    public static function requireAdmin(): User
    {
        $admin = self::$admin;
        if ($admin === null) {
            Assert::fail('Admin test property is not initialized.');
        }

        return $admin;
    }

    public static function requireBaseUser(): User
    {
        $baseUser = self::$baseUser;
        if ($baseUser === null) {
            Assert::fail('BaseUser test property is not initialized.');
        }

        return $baseUser;
    }

    public static function requireTeam(): Team
    {
        $team = self::$team;
        if ($team === null) {
            Assert::fail('Team test property is not initialized.');
        }

        return $team;
    }

    public static function requireTenant1(): Tenant
    {
        $tenant1 = self::$tenant1;
        if ($tenant1 === null) {
            Assert::fail('Tenant1 test property is not initialized.');
        }

        return $tenant1;
    }

    public static function requireTenant2(): Tenant
    {
        $tenant2 = self::$tenant2;
        if ($tenant2 === null) {
            Assert::fail('Tenant2 test property is not initialized.');
        }

        return $tenant2;
    }

    public static function requireGoogle2fa(): Google2FA
    {
        $google2fa = self::$google2fa;
        if ($google2fa === null) {
            Assert::fail('Google2FA test property is not initialized.');
        }

        return $google2fa;
    }

    public static function requireDevice(): Device
    {
        $device = self::$device;
        if ($device === null) {
            Assert::fail('Device test property is not initialized.');
        }

        return $device;
    }

    public static function requireCommand(): Command
    {
        $command = self::$command;
        if ($command === null) {
            Assert::fail('Command test property is not initialized.');
        }

        return $command;
    }

    public function requireAction(): Action
    {
        $action = $this->action;
        if ($action === null) {
            $this->fail('Action test property is not initialized.');
        }

        return $action;
    }

    public function requireWidget(): Widget
    {
        if ($this->widget === null) {
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

    public static function requireCreateUserPage(): CreateUser
    {
        $createUserPage = self::$createUserPage;
        if ($createUserPage === null) {
            Assert::fail('CreateUser page test property is not initialized.');
        }

        return $createUserPage;
    }

    public static function requireListUsersPage(): ListUsers
    {
        $listUsersPage = self::$listUsersPage;
        if ($listUsersPage === null) {
            Assert::fail('ListUsers page test property is not initialized.');
        }

        return $listUsersPage;
    }

    /**
     * @return Collection<int, User>
     */
    public static function requireUsers(): Collection
    {
        $users = self::$users;
        if ($users === null) {
            Assert::fail('Users test property is not initialized.');
        }

        return $users;
    }

    public static function userTableHasColumn(string $table, string $column): bool
    {
        return Schema::connection('user')->hasColumn($table, $column);
    }

    public static function skipUnlessUserColumn(string $table, string $column, string $reason = ''): void
    {
        if (! self::userTableHasColumn($table, $column)) {
            Assert::markTestSkipped($reason !== '' ? $reason : "Column {$table}.{$column} missing on user connection.");
        }
    }

    public static function userTableExists(string $table): bool
    {
        return Schema::connection('user')->hasTable($table);
    }

    public static function skipUnlessUserTable(string $table, string $reason = ''): void
    {
        if (! self::userTableExists($table)) {
            Assert::markTestSkipped($reason !== '' ? $reason : "Table {$table} missing on user connection.");
        }
    }

    public static function skipUnlessTenantColumn(string $column, string $reason = ''): void
    {
        self::skipUnlessUserColumn('tenants', $column, $reason);
    }

    public static function skipUnlessUsersTableReady(string $reason = ''): void
    {
        self::skipUnlessUserTable('users', $reason !== '' ? $reason : 'users table missing on user connection.');
    }

    public static function skipUnlessRoleAssignmentSupported(string $reason = ''): void
    {
        $table = self::permissionRolePivotTable();
        self::skipUnlessUserTable($table, $reason !== '' ? $reason : "Role pivot table {$table} missing on user connection.");
    }

    public static function skipUnlessDirectPermissionSupported(string $reason = ''): void
    {
        $table = self::permissionPivotTable();
        self::skipUnlessUserTable($table, $reason !== '' ? $reason : "Permission pivot table {$table} missing on user connection.");
    }

    public static function skipUnlessUserSoftDeletes(string $reason = ''): void
    {
        if (! in_array(
            SoftDeletes::class,
            \class_uses_recursive(User::class),
            true
        )) {
            Assert::markTestSkipped($reason !== '' ? $reason : 'User model does not use SoftDeletes.');
        }
    }

    public static function skipUnlessTeamUsersRelationSupported(): void
    {
        if (! self::userTableHasColumn('team_user', 'permissions')) {
            Assert::markTestSkipped('team_user.permissions column missing — Team::users() pivot not loadable.');
        }
    }

    public static function skipLegacyRedirectPersistence(): void
    {
        if (
            Schema::connection('user')->hasColumn('oauth_clients', 'redirect')
            && Schema::connection('user')->hasColumn('oauth_clients', 'redirect_uris')
        ) {
            Assert::markTestSkipped('oauth_clients legacy redirect columns require redirect_uris sync not performed by Create*ClientAction.');
        }
    }

    public static function permissionRolePivotTable(): string
    {
        $value = config('permission.table_names.model_has_roles', 'model_has_role');

        return is_string($value) ? $value : 'model_has_role';
    }

    public static function permissionPivotTable(): string
    {
        $value = config('permission.table_names.model_has_permissions', 'model_has_permission');

        return is_string($value) ? $value : 'model_has_permission';
    }

    /**
     * @param  array<string, mixed>  $attributes
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
     * @param  array<string, mixed>  $overrides
     */
    public static function oauthClientTestPersistedClient(array $overrides = []): OauthClient
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
            $payload['owner_id'] = $payload['owner_id'] ?? $payload['user_id'];
            $payload['owner_type'] = $payload['owner_type'] ?? null;
        }

        DB::connection('user')->table('oauth_clients')->insert($payload);

        return OauthClient::query()->findOrFail($clientId);
    }

    /**
     * @param  array<string, mixed>  $pivot
     */
    public static function attachTeamMember(Team $team, User $user, array $pivot = []): void
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

        if (self::userTableHasColumn('team_user', 'permissions') && array_key_exists('permissions', $pivot)) {
            $permissions = $pivot['permissions'];
            $payload['permissions'] = is_array($permissions) ? json_encode($permissions) : $permissions;
        }

        if (self::userTableHasColumn('team_user', 'joined_at') && array_key_exists('joined_at', $pivot)) {
            $payload['joined_at'] = $pivot['joined_at'];
        }

        DB::connection('user')->table('team_user')->insert($payload);
    }

    public static function detachTeamMember(Team $team, User $user): void
    {
        DB::connection('user')->table('team_user')
            ->where('team_id', $team->id)
            ->where('user_id', $user->id)
            ->delete();
    }

    public static function teamMemberExists(Team $team, User $user): bool
    {
        return DB::connection('user')->table('team_user')
            ->where('team_id', $team->id)
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function assertDatabaseHasRow(string $table, array $data, ?string $connection = 'user'): void
    {
        $this->assertDatabaseHas($table, $data, $connection);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function assertDatabaseMissingRow(string $table, array $data, ?string $connection = 'user'): void
    {
        $query = DB::connection($connection)->table($table);

        foreach ($data as $column => $value) {
            $query->where((string) $column, $value);
        }

        Assert::assertFalse($query->exists());
    }

    public static function requireFreshUser(User $user): User
    {
        $fresh = $user->fresh();
        Assert::assertNotNull($fresh);

        return $fresh;
    }

    /**
     * @return array<int, Component|Action|ActionGroup>
     */
    public static function filamentSectionChildComponents(Section $section): array
    {
        // getChildComponents() costruisce lo schema figlio e richiede il container con il componente
        // Livewire (Filament 5): fuori da una pagina si leggono i componenti dichiarati nella Section.
        $declared = $section->getDefaultChildComponents();
        if ($declared instanceof FilamentSchema) {
            return [];
        }

        return array_values(array_filter(
            $declared,
            static fn (mixed $component): bool => $component instanceof Component
                || $component instanceof Action
                || $component instanceof ActionGroup,
        ));
    }

    public static function teamUsesSoftDeletes(): bool
    {
        /** @var array<class-string, class-string> $traits */
        $traits = \class_uses_recursive(Team::class);

        return in_array(
            SoftDeletes::class,
            $traits,
            true
        );
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public static function createTeamInvitationRecord(Team $team, array $attributes = []): TeamInvitation
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

        return $invitation->fresh() ?? $invitation;
    }

    /**
     * Una transazione di test per ogni ISTANZA di connessione, non per ogni nome.
     *
     * `TenantServiceProvider::aliasModuleConnectionsToDefault()` risolve le connessioni di modulo senza database proprio (`fixcity`,
     * `comment`, `media`, `blog`) sulla stessa istanza `Connection` della default. Con i cinque nomi il trait apriva quattro livelli
     * sulla stessa connessione: un'Action con `transaction()` committava al livello 4, mai a 1, e il DatabaseTransactionsManager di test
     * non eseguiva piu' i callback "dopo il commit" (observer `ShouldHandleEventsAfterCommit`, eventi `ShouldDispatchAfterCommit`).
     * Effetto in CI su MariaDB: nessuna notifica di approvazione, scarto o chiusura (TicketLifecycleNotificationTest, area personale).
     * Lo skip del manager conta i nomi restituiti qui, quindi ogni nome deve corrispondere a una sola transazione aperta.
     *
     * @return list<string>
     */
    protected function connectionsToTransact()
    {
        $database = $this->app?->make('db');
        if (! $database instanceof DatabaseManager) {
            return $this->connectionsToTransact;
        }

        $names = [];
        $seen = [];
        foreach ($this->connectionsToTransact as $name) {
            $id = spl_object_id($database->connection($name));
            if (isset($seen[$id])) {
                continue;
            }
            $seen[$id] = true;
            $names[] = $name;
        }

        return $names;
    }
}
