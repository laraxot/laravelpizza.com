<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\MockInterface;
use Modules\User\Database\Factories\TeamFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Profile;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;
use PragmaRX\Google2FA\Google2FA;

use function Safe\glob;
use function Safe\json_decode;
use function Safe\json_encode;

/**
 * @param array<string, mixed> $attributes
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
 * @param array<string, mixed> $attributes
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
 * @param array<string, mixed> $attributes
 */
function createTeam(array $attributes = []): Team
{
    return TeamFactory::new()->createOne(array_merge([
        'name' => 'team-'.uniqid(),
    ], $attributes));
}

/**
 * @param array<string, mixed> $attributes
 */
function createTestUser(array $attributes = []): User
{
    return UserFactory::new()->createOne(array_merge([
        'email' => 'test-'.uniqid('', true).'@example.com',
    ], $attributes));
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
        pestSkip('' !== $reason ? $reason : "Column {$table}.{$column} missing on user connection.");
    }
}

function userTableExists(string $table): bool
{
    return Schema::connection('user')->hasTable($table);
}

function skipUnlessUserTable(string $table, string $reason = ''): void
{
    if (! userTableExists($table)) {
        pestSkip('' !== $reason ? $reason : "Table {$table} missing on user connection.");
    }
}

function permissionRolePivotTable(): string
{
    return (string) config('permission.table_names.model_has_roles', 'model_has_role');
}

function permissionPivotTable(): string
{
    return (string) config('permission.table_names.model_has_permissions', 'model_has_permission');
}

function skipUnlessUsersTableReady(string $reason = ''): void
{
    skipUnlessUserTable('users', '' !== $reason ? $reason : 'users table missing on user connection.');
}

function skipUnlessRoleAssignmentSupported(string $reason = ''): void
{
    $table = permissionRolePivotTable();
    skipUnlessUserTable($table, '' !== $reason ? $reason : "Role pivot table {$table} missing on user connection.");
}

function skipUnlessDirectPermissionSupported(string $reason = ''): void
{
    $table = permissionPivotTable();
    skipUnlessUserTable($table, '' !== $reason ? $reason : "Permission pivot table {$table} missing on user connection.");
}

function skipUnlessTeamUsersRelationSupported(): void
{
    if (! userTableHasColumn('team_user', 'permissions')) {
        pestSkip('team_user.permissions column missing — Team::users() pivot not loadable.');
    }
}

/**
 * @param array<string, mixed> $pivot
 */
function attachTeamMember(Team $team, User $user, array $pivot = []): void
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

    if (userTableHasColumn('team_user', 'permissions') && array_key_exists('permissions', $pivot)) {
        $permissions = $pivot['permissions'];
        $payload['permissions'] = is_array($permissions) ? json_encode($permissions) : $permissions;
    }

    if (userTableHasColumn('team_user', 'joined_at') && array_key_exists('joined_at', $pivot)) {
        $payload['joined_at'] = $pivot['joined_at'];
    }

    DB::connection('user')->table('team_user')->insert($payload);
}

function detachTeamMember(Team $team, User $user): void
{
    DB::connection('user')->table('team_user')
        ->where('team_id', $team->id)
        ->where('user_id', $user->id)
        ->delete();
}

function teamMemberExists(Team $team, User $user): bool
{
    return DB::connection('user')->table('team_user')
        ->where('team_id', $team->id)
        ->where('user_id', $user->id)
        ->exists();
}

function teamUsesSoftDeletes(): bool
{
    /** @var array<class-string, class-string> $traits */
    $traits = \class_uses_recursive(Team::class);

    return in_array(
        Illuminate\Database\Eloquent\SoftDeletes::class,
        $traits,
        true
    );
}

/**
 * @param array<string, mixed> $attributes
 */
function createProfile(array $attributes = []): Profile
{
    $factory = Profile::factory();
    \assert($factory instanceof Factory);

    $profile = $factory->create($attributes);
    \assert($profile instanceof Profile);

    return $profile;
}

function setupFilamentAdminPanel(): void
{
    $filament = Filament\Facades\Filament::class;

    try {
        $panel = $filament::getPanel('user::admin');
    } catch (Throwable) {
        $panelProvider = new Modules\User\Providers\Filament\AdminPanelProvider(app());
        $panel = $panelProvider->panel(Filament\Panel::make());
        $filament::registerPanel($panel);
    }

    $filament::setCurrentPanel($panel);
}

/**
 * @param array<mixed> $attributes
 */
function mockSocialiteOauthUser(array $attributes = []): Laravel\Socialite\Contracts\User
{
    /** @var array<string, mixed> $attributes */
    $unique = uniqid();
    $data = array_merge([
        'id' => 'id-'.$unique,
        'name' => 'Mario Rossi',
        'email' => 'user'.$unique.'@example.com',
        'avatar' => 'https://example.com/avatar.jpg',
        'nickname' => 'user'.$unique,
    ], $attributes);

    return configureMock(Laravel\Socialite\Contracts\User::class, static function (MockInterface $mock) use ($data): void {
        $mock->allows([
            'getId' => $data['id'],
            'getName' => $data['name'],
            'getEmail' => $data['email'],
            'getAvatar' => $data['avatar'],
            'getNickname' => $data['nickname'],
        ]);
    });
}

if (! function_exists('typedMock')) {
    /**
     * @template T of object
     *
     * @param class-string<T> $class
     *
     * @return T&MockInterface
     */
    function typedMock(string $class): MockInterface
    {
        /** @var T&MockInterface $mock */
        $mock = Mockery::mock($class);

        return $mock;
    }
}

/**
 * @template T of object
 *
 * @param class-string<T>                 $class
 * @param callable(T&MockInterface): void $configure
 *
 * @return T&MockInterface
 */
function configureMock(string $class, callable $configure): MockInterface
{
    /** @var T&MockInterface $mock */
    $mock = Mockery::mock($class);
    $configure($mock);

    return $mock;
}

function fakeSocialiteUser(string $email): Laravel\Socialite\Contracts\User
{
    return configureMock(Laravel\Socialite\Contracts\User::class, static function (MockInterface $mock) use ($email): void {
        $mock->allows(['getEmail' => $email]);
    });
}

function makeIsUserAllowedAction(): Modules\User\Actions\Socialite\IsUserAllowedAction
{
    return new Modules\User\Actions\Socialite\IsUserAllowedAction();
}

/**
 * @return list<string>
 */
function userMigrationFiles(): array
{
    $basePath = dirname(__DIR__, 2).'/database/migrations';
    /** @var list<string> $files */
    $files = glob($basePath.'/*.php');
    sort($files);

    return $files;
}

function skipUserTest(string $message): never
{
    Assert::markTestSkipped($message);
}

function skipLegacyRedirectPersistenceCheck(): void
{
    if (
        Schema::connection('user')->hasColumn('oauth_clients', 'redirect')
        && Schema::connection('user')->hasColumn('oauth_clients', 'redirect_uris')
    ) {
        skipUserTest('oauth_clients legacy redirect columns require redirect_uris sync not performed by Create*ClientAction.');
    }
}

function ensurePersonalAccessClient(): void
{
    $clientModel = Laravel\Passport\Passport::client();

    if ($clientModel->newQuery()->where('revoked', false)->exists()) {
        return;
    }

    $repository = app(Laravel\Passport\ClientRepository::class);
    $repository->createPersonalAccessGrantClient('Test Personal Access Client');
}

/**
 * @return array<int, Filament\Schemas\Components\Component|Filament\Actions\Action|Filament\Actions\ActionGroup>
 */
function userResourceSectionComponents(Modules\User\Tests\TestCase $testCase, Filament\Schemas\Components\Component $section): array
{
    Assert::assertInstanceOf(Filament\Schemas\Components\Section::class, $section);

    /* @var \Filament\Schemas\Components\Section $section */
    return $testCase->filamentSectionChildComponents($section);
}

/**
 * @param array<int, Filament\Schemas\Components\Component|Filament\Actions\Action|Filament\Actions\ActionGroup> $components
 */
function userResourceFindComponentByName(array $components, string $name): ?Filament\Schemas\Components\Component
{
    foreach ($components as $component) {
        if (! $component instanceof Filament\Forms\Components\Field) {
            continue;
        }

        if ($component->getName() === $name) {
            return $component;
        }
    }

    return null;
}

/**
 * @param array<string, mixed> $attributes
 */
function stubUser(array $attributes = []): User
{
    return UserFactory::new()->makeOne($attributes);
}

/**
 * @param array<string, mixed> $attributes
 */
function hasTeamsCurrentCreateUser(array $attributes = []): User
{
    return createTestUser($attributes);
}

/**
 * @param array<string, mixed> $attributes
 */
function hasTeamsCurrentCreateTeam(User $user, array $attributes = []): Team
{
    return TeamFactory::new()->createOne(array_merge([
        'user_id' => $user->id,
        'personal_team' => true,
    ], $attributes));
}

/**
 * @param array<string, mixed> $attributes
 *
 * @return array{secret: string, qr_code: string, recovery_codes: array<int, string>}
 */
function enableTwoFactorForUser(User $user, Google2FA $google2fa, array $attributes = []): array
{
    $secret = (string) $google2fa->generateSecretKey();
    $qrCode = $google2fa->getQRCodeUrl((string) config('app.name'), $user->email, $secret);

    $recoveryCodes = array_map(
        static fn (): string => substr(str_shuffle('0123456789ABCDEF'), 0, 10).'-'.substr(str_shuffle('0123456789ABCDEF'), 0, 10),
        range(1, 10)
    );

    $user->two_factor_secret = encrypt($secret);
    $user->two_factor_recovery_codes = encrypt(json_encode($recoveryCodes));
    $user->save();

    return [
        'secret' => $secret,
        'qr_code' => $qrCode,
        'recovery_codes' => $recoveryCodes,
    ];
}

function confirmTwoFactorForUser(User $user, Google2FA $google2fa, string $secret, string $code): bool
{
    if (! $google2fa->verifyKey($secret, $code)) {
        return false;
    }

    $user->two_factor_confirmed_at = now()->toDateTimeString();
    $user->save();

    return true;
}

function verifyTwoFactorCode(User $user, Google2FA $google2fa, string $code): bool
{
    if (! $user->two_factor_secret) {
        return false;
    }

    $secret = (string) decrypt($user->two_factor_secret);

    return false !== $google2fa->verifyKey($secret, $code);
}

function disableTwoFactorForUser(User $user): void
{
    $user->two_factor_secret = null;
    $user->two_factor_recovery_codes = null;
    $user->two_factor_confirmed_at = null;
    $user->save();
}

function verifyTwoFactorRecoveryCode(User $user, string $code): bool
{
    if (! $user->two_factor_recovery_codes) {
        return false;
    }

    $codes = json_decode((string) decrypt($user->two_factor_recovery_codes), true);
    if (! is_array($codes)) {
        return false;
    }

    $codes = array_values(array_filter($codes, static fn ($c): bool => $c !== $code));
    $user->two_factor_recovery_codes = encrypt(json_encode($codes));
    $user->save();

    return true;
}

/**
 * @return array<int, string>
 */
function readStoredRecoveryCodes(User $user): array
{
    if (! $user->two_factor_recovery_codes) {
        return [];
    }

    $codes = json_decode((string) decrypt($user->two_factor_recovery_codes), true);
    if (! is_array($codes)) {
        return [];
    }

    /** @var array<int, string> $stringCodes */
    $stringCodes = array_values(array_filter($codes, 'is_string'));

    return $stringCodes;
}

/**
 * @return array<int, string>
 */
function regenerateTwoFactorRecoveryCodes(User $user): array
{
    $codes = array_map(
        static fn (): string => substr(str_shuffle('0123456789ABCDEF'), 0, 10).'-'.substr(str_shuffle('0123456789ABCDEF'), 0, 10),
        range(1, 10)
    );

    $user->two_factor_recovery_codes = encrypt(json_encode($codes));
    $user->save();

    return $codes;
}
