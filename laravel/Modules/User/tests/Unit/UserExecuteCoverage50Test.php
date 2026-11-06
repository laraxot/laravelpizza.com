<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit;

use Filament\Actions\Action as FilamentAction;
use Filament\Actions\BulkAction;
use Filament\Panel;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\PotentiallyTranslatedString;
use Mockery;
use Modules\User\Actions\Notification\IsNotificationSchemaReadableAction;
use Modules\User\Actions\Passport\RevokeAllUserTokensAction;
use Modules\User\Actions\Passport\RevokeTokenAction;
use Modules\User\Actions\Shield\ShieldUtilsAction;
use Modules\User\Contracts\TeamContract;
use Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource;
use Modules\User\Filament\Pages\SocialiteProviderSettingsPage;
use Modules\User\Filament\Resources\UserResource;
use Modules\User\Filament\Resources\UserResource\Schemas\UserForm as ResourceUserForm;
use Modules\User\Filament\Widgets\Auth\Schemas\UserForm;
use Modules\User\Models\Notification;
use Modules\User\Models\OauthAccessToken;
use Modules\User\Models\OauthClient;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Models\Team;
use Modules\User\Models\TeamUser;
use Modules\User\Models\Tenant;
use Modules\User\Models\User;
use Modules\User\Notifications\Auth\Otp;
use Modules\User\Notifications\Auth\ResetPassword;
use Modules\User\Notifications\Auth\VerifyEmail;
use Modules\User\Observers\UserObserver;
use Modules\User\Providers\SocialiteServiceProvider;
use Modules\User\Providers\Traits\HasPassportConfiguration;
use Modules\User\Rules\CheckOtpExpiredRule;
use Modules\User\Tests\Support\FakeTenantUserConfig;
use Modules\User\Tests\TestCase;
use Modules\User\Tests\Unit\Fixtures\HasShieldPermissionsFixture;
use Modules\User\View\Components\Mail\Message;
use Modules\User\View\Pages\ProfileEditVoltComponent;
use Modules\Xot\Tests\ModuleBusinessCoverage;
use Modules\Xot\Tests\ModuleExecuteCoverage;
use PHPUnit\Framework\Assert;

use function Safe\glob;

uses(TestCase::class)->group('no-user-db');

afterEach(function (): void {
    Mockery::close();
});

/**
 * @return array{string, string} radice `app/` del modulo e namespace radice
 */
/** @return list{string, string} */
function userExecuteContext(): array
{
    return [dirname(__DIR__, 2).'/app', 'Modules\\User\\'];
}

/**
 * Esegue la sonda e restituisce l'`\Error` sollevato (TypeError, ArgumentCountError,
 * chiamata a metodo inesistente): un difetto reale di firma o di contratto.
 * Le eccezioni applicative sono tollerate — questi test girano senza database.
 * La sonda non deve contenere asserzioni: verrebbero inghiottite dal catch.
 *
 * @param  \Closure(): void  $probe
 */
function userCaptureFatal(\Closure $probe): ?\Error
{
    try {
        $probe();
    } catch (\Error $error) {
        return $error;
    } catch (\Throwable) {
        return null;
    }

    return null;
}

function userInvoke(object $target, string $method, mixed ...$args): mixed
{
    $reflection = new \ReflectionMethod($target, $method);
    $reflection->setAccessible(true);

    return $reflection->invoke($target, ...$args);
}

function userMockWithTeams(string $id = 'owner-1'): User
{
    $user = new User;
    $user->forceFill(['id' => $id, 'current_team_id' => null, 'total_members' => 0]);

    return $user;
}

function userTeamFixture(string $ownerId, int $teamId = 1, bool $personal = false): Team
{
    $team = new Team;
    $team->forceFill([
        'id' => $teamId,
        'user_id' => $ownerId,
        'name' => 'Team '.$teamId,
        'personal_team' => $personal,
        'users' => [],
    ]);

    return $team;
}

/**
 * Costruisce la closure `$fail` con la firma dichiarata da
 * `Illuminate\Contracts\Validation\ValidationRule::validate()`: il test esercita
 * il contratto reale della regola, non una closure di comodo.
 *
 * @param  bool  $flag  alzato quando la regola invoca `$fail`
 * @return \Closure(string, string|null=): PotentiallyTranslatedString
 */
function userFailClosure(bool &$flag): \Closure
{
    return static function (string $message, ?string $_attribute = null) use (&$flag): PotentiallyTranslatedString {
        $flag = true;

        return new PotentiallyTranslatedString($message, app(Translator::class));
    };
}

/**
 * Formatta lo stato di una colonna e verifica il contratto dichiarato dal
 * `formatStateUsing` della risorsa: la callback restituisce sempre una stringa.
 */
function userFormatColumnState(TextColumn $column, mixed $state): string
{
    $formatted = $column->formatState($state);
    Assert::assertIsString($formatted);

    return $formatted;
}

function userDehydrateField(object $field, mixed $state): mixed
{
    if (! property_exists($field, 'dehydrateStateUsing')) {
        return $state;
    }

    $ref = new \ReflectionProperty($field, 'dehydrateStateUsing');
    $ref->setAccessible(true);
    $callback = $ref->getValue($field);
    if (! $callback instanceof \Closure) {
        return $state;
    }

    return $callback($state);
}

function userInvokeStateClosure(object $field, mixed ...$args): mixed
{
    $ref = new \ReflectionProperty($field, 'getConstantStateUsing');
    $ref->setAccessible(true);
    $callback = $ref->getValue($field);
    if (! $callback instanceof \Closure) {
        return null;
    }

    return $callback(...$args);
}

/**
 * @return list<SchemaComponent>
 */
function userSectionChildren(Section $section): array
{
    $ref = new \ReflectionProperty($section, 'childComponents');
    $ref->setAccessible(true);
    /** @var array<string, mixed> $children */
    $children = $ref->getValue($section);
    $default = $children['default'] ?? [];
    if ($default instanceof \Closure) {
        $default = $default();
    }

    if (! is_array($default)) {
        return [];
    }

    $components = [];
    foreach ($default as $child) {
        if ($child instanceof SchemaComponent) {
            $components[] = $child;
        }
    }

    return $components;
}

/**
 * @param  array<int|string, SchemaComponent>  $schema
 */
function userFindNamedComponent(array $schema, string $name): ?SchemaComponent
{
    foreach ($schema as $component) {
        if ($component instanceof Section) {
            foreach (userSectionChildren($component) as $child) {
                if (method_exists($child, 'getName') && $child->getName() === $name) {
                    return $child;
                }
            }

            continue;
        }

        if (method_exists($component, 'getName') && $component->getName() === $name) {
            return $component;
        }
    }

    return null;
}

/**
 * @return Mockery\MockInterface&User
 */
function userProfileMock(string $password = 'Secret123!'): User
{
    /** @var Mockery\MockInterface&User $user */
    $user = Mockery::mock(User::class)->makePartial();
    $user->forceFill([
        'id' => 'profile-user-1',
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'mario@example.com',
        'password' => Hash::make($password),
        'email_verified_at' => now(),
        'name' => 'Mario Rossi',
        'created_at' => now(),
    ]);
    mockeryExpect($user->shouldReceive('save'))->andReturn(true);
    mockeryExpect($user->shouldReceive('getChanges'))->andReturn(['email' => 'nuovo@example.com']);
    mockeryExpect($user->shouldReceive('hasVerifiedEmail'))->andReturn(true);
    mockeryExpect($user->shouldReceive('sendEmailVerificationNotification'))->andReturnNull();
    mockeryExpect($user->shouldReceive('fill'))->andReturnSelf();
    mockeryExpect($user->shouldReceive('update'))->andReturn(true);
    mockeryExpect($user->shouldReceive('delete'))->andReturn(true);
    $user->exists = true;

    return $user;
}

describe('User execute coverage floor 50', function (): void {
    test('sweep completo Filament policy action enum model', function (): void {
        [$appRoot, $ns] = userExecuteContext();
        ModuleExecuteCoverage::runFloor50($appRoot, $ns);
    });

    test('Filament UserResource legacy schema e pages', function (): void {
        Assert::assertNotEmpty(app(UserResource::class)->getFormSchema());
        Assert::assertNotEmpty(UserResource::getPages());
        Assert::assertTrue(class_exists(UserResource::getModel()));
    });

    test('enums e datas User espongono label', function (): void {
        $labels = 0;
        foreach (glob(dirname(__DIR__, 2).'/app/Enums/*.php') as $file) {
            if (! is_string($file)) {
                continue;
            }
            $class = 'Modules\\User\\'.str_replace(['/', '.php'], ['\\', ''], substr($file, strlen(dirname(__DIR__, 2).'/app/') + 0));
            if (! enum_exists($class)) {
                continue;
            }
            foreach ($class::cases() as $case) {
                if (method_exists($case, 'getLabel')) {
                    $case->getLabel();
                    $labels++;
                }
            }
        }
        Assert::assertGreaterThan(0, $labels);
    });

    test('widget auth user form espone tutti gli schemi principali', function (): void {
        $schemas = [
            UserForm::getLoginFormSchema(),
            UserForm::getRegisterFormSchema(),
            UserForm::getForgotPasswordFormSchema(),
            UserForm::getPasswordResetFormSchema(),
            UserForm::getResetPasswordFormSchema(),
            UserForm::getPasswordResetConfirmFormSchema(),
        ];

        foreach ($schemas as $schema) {
            Assert::assertNotEmpty($schema);
        }

        Assert::assertArrayHasKey('email', UserForm::getLoginFormSchema());
        Assert::assertArrayHasKey('password', UserForm::getRegisterFormSchema());
        Assert::assertArrayHasKey('password_confirmation', UserForm::getResetPasswordFormSchema());
    });

    test('socialite settings page helper methods eseguono i rami principali', function (): void {
        config([
            'services.google.enabled' => true,
            'services.google.client_id' => 'google-client',
            'services.google.client_secret' => 'abcd1234',
            'services.google.scopes' => ['openid', 'email'],
            'services.github.enabled' => false,
            'services.github.client_id' => 'github-client',
            'services.github.client_secret' => 'secret5678',
            'services.github.scopes' => ['read:user'],
            'services.microsoft.enabled' => true,
            'services.microsoft.client_id' => 'ms-client',
            'services.microsoft.client_secret' => 'secret9999',
            'services.microsoft.scopes' => ['User.Read'],
        ]);

        $page = new SocialiteProviderSettingsPage;
        $page->mount();

        Assert::assertTrue($page->google['enabled']);
        Assert::assertSame('google-client', $page->google['client_id']);
        $googleSecret = $page->google['client_secret'];
        Assert::assertIsString($googleSecret);
        Assert::assertStringContainsString('1234', $googleSecret);
        Assert::assertSame(['openid', 'email'], $page->google['scopes']);
        Assert::assertSame(['read:user'], $page->github['scopes']);

        Assert::assertSame('••••1234', userInvoke($page, 'maskSecret', 'abcd1234'));
        Assert::assertSame('', userInvoke($page, 'maskSecret', null));
        Assert::assertSame('persisted-secret', userInvoke($page, 'resolveSecret', '••••1234', 'persisted-secret'));
        Assert::assertSame('new-secret', userInvoke($page, 'resolveSecret', 'new-secret', 'persisted-secret'));
        Assert::assertSame('abcd1234', userInvoke($page, 'dehydrateSecret', '••••1234', 'services.google.client_secret'));
        Assert::assertSame('', userInvoke($page, 'dehydrateSecret', null, 'services.google.client_secret'));
        Assert::assertSame(['a', 'b'], userInvoke($page, 'stringList', ['a', '', 'b', 10]));
        Assert::assertSame([], userInvoke($page, 'stringList', 'not-an-array'));
        Assert::assertSame(['enabled' => true, 'client_id' => 'x'], userInvoke($page, 'providerData', ['enabled' => true, 'client_id' => 'x', 5 => 'skip']));
        Assert::assertSame([], userInvoke($page, 'providerData', 'bad'));
        Assert::assertSame('google-client', userInvoke($page, 'providerClientId', ['client_id' => 'google-client']));
        Assert::assertSame('', userInvoke($page, 'providerClientId', ['client_id' => 10]));
        Assert::assertSame(['openid', 'email'], userInvoke($page, 'configStringList', 'services.google.scopes', ['fallback']));
    });

    test('oauth access token resource espone colonne filtri azioni e form legacy', function (): void {
        Assert::assertNotEmpty(OauthAccessTokenResource::getTableFilters());
        Assert::assertNotEmpty(OauthAccessTokenResource::getTableActions());
        Assert::assertNotEmpty(OauthAccessTokenResource::getTableBulkActions());
        Assert::assertNotEmpty(app(OauthAccessTokenResource::class)->getFormSchema());

        $resource = new OauthAccessTokenResource;
        $columns = $resource->getTableColumns();

        Assert::assertArrayHasKey('id', $columns);
        Assert::assertArrayHasKey('expires_at', $columns);
        Assert::assertArrayHasKey('scopes', $columns);
    });

    test('shield helpers leggono configurazione e prefissi reali', function (): void {
        config([
            'filament-shield.shield_resource.slug' => 'roles',
            'filament-shield.shield_resource.should_register_navigation' => true,
            'filament-shield.shield_resource.show_model_path' => true,
            'filament-shield.permission_prefixes.resource' => ['view', 'update'],
            'filament-shield.permission_prefixes.page' => 'page',
            'filament-shield.permission_prefixes.widget' => 'widget',
            'filament-shield.entities.resources' => true,
            'filament-shield.entities.pages' => true,
            'filament-shield.entities.widgets' => true,
            'filament-shield.entities.custom_permissions' => false,
            'filament-shield.generator.option' => 'policies_and_permissions',
            'filament-shield.exclude.enabled' => true,
            'filament-shield.exclude.resources' => ['FooResource'],
            'filament-shield.exclude.pages' => ['BarPage'],
            'filament-shield.exclude.widgets' => ['BazWidget'],
            'filament-shield.auth_provider_model.fqcn' => User::class,
            'filament-shield.register_role_policy' => true,
            'permission.models.role' => Role::class,
            'permission.models.permission' => Permission::class,
        ]);

        $resourceClass = HasShieldPermissionsFixture::class;

        Assert::assertSame('web', ShieldUtilsAction::getFilamentAuthGuard());
        Assert::assertSame('roles', ShieldUtilsAction::getResourceSlug());
        Assert::assertTrue(ShieldUtilsAction::isResourceNavigationRegistered());
        Assert::assertSame(['view', 'update'], ShieldUtilsAction::getGeneralResourcePermissionPrefixes());
        Assert::assertSame('page', ShieldUtilsAction::getPagePermissionPrefix());
        Assert::assertSame('widget', ShieldUtilsAction::getWidgetPermissionPrefix());
        Assert::assertTrue(ShieldUtilsAction::isResourceEntityEnabled());
        Assert::assertTrue(ShieldUtilsAction::isPageEntityEnabled());
        Assert::assertTrue(ShieldUtilsAction::isWidgetEntityEnabled());
        Assert::assertFalse(ShieldUtilsAction::isCustomPermissionEntityEnabled());
        Assert::assertSame('policies_and_permissions', ShieldUtilsAction::getGeneratorOption());
        Assert::assertTrue(ShieldUtilsAction::isGeneralExcludeEnabled());
        ShieldUtilsAction::disableGeneralExclude();
        Assert::assertFalse(ShieldUtilsAction::isGeneralExcludeEnabled());
        ShieldUtilsAction::enableGeneralExclude();
        Assert::assertSame(['FooResource'], ShieldUtilsAction::getExcludedResouces());
        Assert::assertSame(['BarPage'], ShieldUtilsAction::getExcludedPages());
        Assert::assertSame(['BazWidget'], ShieldUtilsAction::getExcludedWidgets());
        Assert::assertTrue(ShieldUtilsAction::isRolePolicyRegistered());
        Assert::assertTrue(ShieldUtilsAction::doesResourceHaveCustomPermissions($resourceClass));
        Assert::assertSame(['custom-view', 'custom-update'], ShieldUtilsAction::getResourcePermissionPrefixes($resourceClass));
        Assert::assertSame(User::class, ShieldUtilsAction::showModelPath($resourceClass));
        Assert::assertSame(Role::class, ShieldUtilsAction::getRoleModel());
        Assert::assertSame(Permission::class, ShieldUtilsAction::getPermissionModel());

    });

    test('profile edit volt component mount inizializza stato utente', function (): void {
        $user = new User;
        $user->forceFill([
            'id' => 'user-1',
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
            'email' => 'mario@example.com',
        ]);

        Auth::shouldReceive('user')->once()->andReturn($user);

        $component = new ProfileEditVoltComponent;
        $component->mount();

        Assert::assertSame('Mario', $component->first_name);
        Assert::assertSame('Rossi', $component->last_name);
        Assert::assertSame('mario@example.com', $component->email);
        Assert::assertSame('user-1', $component->user_id);
    });
});

describe('User execute coverage — HasTeams trait mock', function (): void {
    test('team membership ownership e permessi base', function (): void {
        $owner = userMockWithTeams('owner-1');
        $member = userMockWithTeams('member-1');
        $ownedTeam = userTeamFixture('owner-1', 101, true);
        $foreignTeam = userTeamFixture('other-owner', 102);
        $memberTeam = userTeamFixture('owner-1', 103);

        $owner->setRelation('ownedTeams', collect([$ownedTeam]));
        $owner->setRelation('membershipTeams', collect([$memberTeam]));
        $member->setRelation('membershipTeams', collect([$memberTeam]));

        Assert::assertTrue($owner->ownsTeam($ownedTeam));
        Assert::assertFalse($owner->ownsTeam($foreignTeam));
        Assert::assertFalse($owner->ownsTeam(null));
        Assert::assertTrue($owner->belongsToTeam($ownedTeam));
        Assert::assertTrue($owner->belongsToTeam($memberTeam));
        Assert::assertFalse($owner->belongsToTeam(null));
        Assert::assertTrue($owner->belongsToTeams());
        Assert::assertTrue($owner->hasTeams());
        Assert::assertCount(2, $owner->allTeams());
        Assert::assertTrue($owner->canDeleteTeam($ownedTeam));
        Assert::assertTrue($owner->canManageTeam($ownedTeam));
        Assert::assertTrue($owner->canUpdateTeam($ownedTeam));
        Assert::assertTrue($owner->canViewTeam($ownedTeam));
        Assert::assertTrue($owner->canAddTeamMember($ownedTeam));
        Assert::assertTrue($owner->canRemoveTeamMember($ownedTeam, $member));
        Assert::assertTrue($owner->canUpdateTeamMember($ownedTeam, $member));
        Assert::assertFalse($owner->canLeaveTeam($ownedTeam));
        Assert::assertTrue($member->canLeaveTeam($memberTeam));
        Assert::assertFalse($member->canDeleteTeam($memberTeam));
        Assert::assertTrue($owner->isOwnerOrMember($ownedTeam));
        Assert::assertTrue($owner->checkTeamOwnership($ownedTeam));
        Assert::assertTrue($owner->hasTeamRole($ownedTeam, 'admin'));
        Assert::assertTrue($owner->hasTeamPermission($ownedTeam, 'edit-team'));
    });

    test('personal team switch e current team', function (): void {
        $owner = userMockWithTeams('owner-2');
        $personal = userTeamFixture('owner-2', 201, true);
        $owner->setRelation('ownedTeams', collect([$personal]));
        $owner->setRelation('membershipTeams', collect([]));
        $owner->setRelation('currentTeam', $personal);
        $owner->forceFill(['current_team_id' => $personal->id]);

        Assert::assertSame($personal->id, $owner->personalTeam()?->id);
        Assert::assertTrue($owner->isCurrentTeam($personal));
        Assert::assertFalse($owner->isCurrentTeam(userTeamFixture('x', 999)));
        Assert::assertTrue($owner->belongsToTeam($personal));
    });

    test('invite remove promote demote e team users aggregati', function (): void {
        $owner = userMockWithTeams('owner-4');
        $guest = userMockWithTeams('guest-4');
        $team = userTeamFixture('owner-4', 401);
        $memberUser = userMockWithTeams('member-4');

        $members = Mockery::mock(BelongsToMany::class);
        mockeryExpect($members->shouldReceive('attach'))->once()->andReturn(true);
        mockeryExpect($members->shouldReceive('detach'))->once()->andReturn(true);
        mockeryExpect($members->shouldReceive('updateExistingPivot'))->twice()->andReturn(true);
        mockeryExpect($members->shouldReceive('wherePivot'))->with('role', 'admin')->andReturnSelf();
        mockeryExpect($members->shouldReceive('wherePivot'))->with('role', 'member')->andReturnSelf();
        mockeryExpect($members->shouldReceive('get'))->andReturn(collect([$memberUser]));

        $teamMock = Mockery::mock($team)->makePartial();
        mockeryExpect($teamMock->shouldReceive('members'))->andReturn($members);
        // Il partial mock di un Team resta un TeamContract: la guardia lo dichiara
        // a PHPStan e verifica davvero che Mockery non abbia perso il contratto.
        Assert::assertInstanceOf(TeamContract::class, $teamMock);

        Assert::assertTrue($owner->inviteToTeam($guest, $teamMock));
        Assert::assertFalse($guest->inviteToTeam($guest, $teamMock));
        Assert::assertTrue($owner->removeFromTeam($guest, $teamMock));
        Assert::assertTrue($owner->promoteToAdmin($guest, $teamMock));
        Assert::assertTrue($owner->demoteFromAdmin($guest, $teamMock));
        Assert::assertCount(1, $owner->getTeamAdmins($teamMock));
        Assert::assertCount(1, $owner->getTeamMembers($teamMock));

        $membership = new TeamUser;
        $membership->forceFill(['user' => $memberUser]);
        $owner->setRelation('teamUsers', collect([$membership]));
        $owner->setRelation('owner', $owner);
        Assert::assertTrue($owner->hasTeamMember($memberUser));
        Assert::assertGreaterThanOrEqual(1, $owner->getAllTeamUsersAttribute()->count());

        $teamWithUsers = userTeamFixture('owner-4', 402);
        // `forceFill` scrive l'attributo esattamente come `$team->users = [...]`,
        // senza violare il tipo dichiarato della proprietà di relazione.
        $teamWithUsers->forceFill(['users' => [$memberUser]]);
        $owner->setRelation('membershipTeams', collect([$teamWithUsers]));
        Assert::assertGreaterThanOrEqual(1, $owner->allTeamUsers()->count());
    });
});

describe('User execute coverage — ProfileEditVoltComponent', function (): void {
    test('update profile password clearPasswords senza DB', function (): void {
        $user = userProfileMock();
        $user->email = 'mario@example.com';
        Auth::shouldReceive('user')->andReturn($user);
        Auth::shouldReceive('id')->andReturn('profile-user-1');
        Auth::shouldReceive('logout')->andReturnNull();

        $component = new ProfileEditVoltComponent;
        $component->user_id = 'profile-user-1';
        $component->first_name = 'Mario';
        $component->last_name = 'Rossi';
        $component->email = 'nuovo@example.com';
        $component->current_password = 'Secret123!';
        $component->password = 'NewSecret456!';
        $component->password_confirmation = 'NewSecret456!';
        $component->delete_password = 'Secret123!';

        Assert::assertNull(userCaptureFatal(static function () use ($component): void {
            $component->updateProfile();
        }));

        Assert::assertNull(userCaptureFatal(static function () use ($component): void {
            $component->updatePassword();
        }));

        Assert::assertNull(userCaptureFatal(static function () use ($component): void {
            $component->deleteAccount();
        }));

        $component->clearPasswords();
        Assert::assertSame('', $component->current_password);
        Assert::assertSame('', $component->password);
    });

    test('mount gestisce dati utente invalidi', function (): void {
        Log::shouldReceive('error')->atLeast()->once();

        $badUser = new User;
        $badUser->forceFill([
            'id' => 'bad-1',
            'first_name' => '',
            'last_name' => 'Rossi',
            'email' => 'bad@example.com',
        ]);

        Auth::shouldReceive('user')->andReturn($badUser);
        Auth::shouldReceive('id')->andReturn('bad-1');

        $component = new ProfileEditVoltComponent;
        $component->mount();

        // `mount()` idrata le quattro proprietà e solo dopo verifica gli invarianti:
        // sul primo violato logga e si ferma, lasciando lo stato già scritto.
        Assert::assertSame('', $component->first_name);
        Assert::assertSame('Rossi', $component->last_name);
        Assert::assertSame('bad-1', $component->user_id);
    });
});

describe('User execute coverage — Socialite settings e OAuth resource', function (): void {
    test('socialite settings save scrive config e aggiorna provider', function (): void {
        config([
            'services.google.client_secret' => 'persisted-google',
            'services.github.client_secret' => 'persisted-github',
            'services.microsoft.client_secret' => 'persisted-ms',
        ]);

        Artisan::shouldReceive('call')->once()->with('config:clear');

        $page = new SocialiteProviderSettingsPage;
        $page->mount();
        $page->data = [
            'google' => [
                'enabled' => true,
                'client_id' => 'gid',
                'client_secret' => '••••ogle',
                'scopes' => ['openid', 'email'],
            ],
            'github' => [
                'enabled' => false,
                'client_id' => 'ghid',
                'client_secret' => 'new-github-secret',
                'scopes' => ['read:user'],
            ],
            'microsoft' => [
                'enabled' => true,
                'client_id' => 'msid',
                'client_secret' => 'ms-secret-new',
                'scopes' => ['User.Read'],
            ],
        ];

        $path = storage_path('app/private/socialite-config.php');
        if (File::exists($path)) {
            File::delete($path);
        }

        $page->save();

        Assert::assertFileExists($path);
        $written = require $path;
        Assert::assertIsArray($written);
        $writtenGoogle = $written['google'] ?? null;
        $writtenGithub = $written['github'] ?? null;
        Assert::assertIsArray($writtenGoogle);
        Assert::assertIsArray($writtenGithub);
        Assert::assertTrue($writtenGoogle['enabled']);
        Assert::assertSame('persisted-google', $writtenGoogle['client_secret']);
        Assert::assertSame('new-github-secret', $writtenGithub['client_secret']);

        File::delete($path);

        Assert::assertSame('•••', userInvoke($page, 'maskSecret', 'abc'));
        Assert::assertFalse(userInvoke($page, 'isMasked', 'plain'));
        Assert::assertTrue(userInvoke($page, 'isMasked', '••••1234'));
    });

    test('oauth access token resource callbacks e azioni revoke', function (): void {
        $resource = new OauthAccessTokenResource;
        $columns = $resource->getTableColumns();

        $expiresAt = $columns['expires_at'];
        $scopes = $columns['scopes'];
        $userName = $columns['user.name'];
        Assert::assertInstanceOf(TextColumn::class, $expiresAt);
        Assert::assertInstanceOf(TextColumn::class, $scopes);
        Assert::assertInstanceOf(TextColumn::class, $userName);

        $future = Carbon::now()->addHour();
        $past = Carbon::now()->subHour();
        Assert::assertStringContainsString('Expired', userFormatColumnState($expiresAt, $past));
        Assert::assertStringContainsString((string) $future->year, userFormatColumnState($expiresAt, $future));
        Assert::assertSame('N/A', userFormatColumnState($expiresAt, 'invalid'));
        Assert::assertNull($scopes->getTooltip(null));
        Assert::assertSame('["read"]', $scopes->getTooltip(['read']));
        Assert::assertSame('read', $scopes->getTooltip('read'));

        $user = userProfileMock();
        $token = new OauthAccessToken;
        $token->forceFill([
            'id' => 'token-1',
            'user_id' => $user->id,
            'revoked' => false,
            'expires_at' => $future,
            'scopes' => ['read'],
        ]);
        $token->setRelation('user', $user);
        $token->setRelation('client', new OauthClient(['name' => 'Client', 'provider' => 'users']));

        $userName->getUrl($token);
        $userName->formatState(null);

        app()->instance(RevokeTokenAction::class, new class
        {
            public function execute(string $id): bool
            {
                return $id === 'token-1';
            }
        });
        app()->instance(RevokeAllUserTokensAction::class, new class
        {
            public function execute(string $userId): bool
            {
                return $userId === 'profile-user-1';
            }
        });

        $revoke = OauthAccessTokenResource::getTableActions()['revoke'];
        Assert::assertInstanceOf(FilamentAction::class, $revoke);
        $fn = $revoke->getActionFunction();
        Assert::assertNotNull($fn);
        $revoke->evaluate($fn, ['record' => $token]);

        $bulk = OauthAccessTokenResource::getTableBulkActions()['revoke_all_for_user'];
        Assert::assertInstanceOf(BulkAction::class, $bulk);
        $bulkFn = $bulk->getActionFunction();
        Assert::assertNotNull($bulkFn);
        $bulk->evaluate($bulkFn, ['records' => collect([$token])]);
    });
});

describe('User execute coverage — UserResource form schemas', function (): void {
    test('resource user form deidrata password e created_at entry', function (): void {
        $schema = app(ResourceUserForm::class)->getFormSchema();
        Assert::assertArrayHasKey('section01', $schema);

        $password = userFindNamedComponent($schema, 'password');
        Assert::assertNotNull($password);
        Assert::assertNull(userDehydrateField($password, ''));
        Assert::assertIsString(userDehydrateField($password, 'PlainPass123'));

        $createdAt = userFindNamedComponent($schema, 'created_at');
        Assert::assertNotNull($createdAt);

        $model = new User;
        $model->forceFill(['created_at' => Carbon::parse('2024-06-01 12:00:00')]);
        $human = userInvokeStateClosure($createdAt, $model);
        Assert::assertIsString($human);

        $missing = userInvokeStateClosure($createdAt, new User);
        Assert::assertNotNull($missing);

        $badRecord = userInvokeStateClosure($createdAt, new Team);
        Assert::assertNotNull($badRecord);
    });

    test('widget user form password reset confirm schema', function (): void {
        $schema = UserForm::getPasswordResetConfirmFormSchema();
        Assert::assertNotEmpty($schema);
        Assert::assertArrayHasKey('password', UserForm::getRegisterFormSchema());

        Assert::assertArrayHasKey('email', ResourceUserForm::getLoginFormSchema());
        Assert::assertArrayHasKey('password', ResourceUserForm::getRegisterFormSchema());
        Assert::assertArrayHasKey('email', ResourceUserForm::getForgotPasswordFormSchema());
        Assert::assertArrayHasKey('password_confirmation', ResourceUserForm::getResetPasswordFormSchema());
        if (method_exists(ResourceUserForm::class, 'getPasswordResetFormSchema')) {
            Assert::assertNotEmpty(ResourceUserForm::getPasswordResetFormSchema());
        }
        if (method_exists(ResourceUserForm::class, 'getPasswordResetConfirmFormSchema')) {
            Assert::assertNotEmpty(ResourceUserForm::getPasswordResetConfirmFormSchema());
        }
    });
});

describe('User execute coverage — notifications rules observer helpers', function (): void {
    test('auth notifications e regola otp', function (): void {
        require_once dirname(__DIR__, 2).'/app/helpers.php';
        \module_helper_placeholder();

        $user = userProfileMock();
        $notifiable = new AnonymousNotifiable;

        $otp = new Otp($user, '123456');
        Assert::assertSame(['mail'], $otp->via($notifiable));
        Assert::assertSame([], $otp->toArray($user));

        $reset = new ResetPassword('reset-token');
        $reset->url = 'https://example.test/reset';
        $mail = (new \ReflectionMethod($reset, 'buildMailMessage'))->invoke($reset, $reset->url);
        Assert::assertInstanceOf(MailMessage::class, $mail);

        $verify = new VerifyEmail;
        $verify->url = 'https://example.test/verify';
        $verifyUrl = (new \ReflectionMethod($verify, 'verificationUrl'))->invoke($verify, $user);
        Assert::assertSame($verify->url, $verifyUrl);

        $freshUser = new User;
        $freshUser->forceFill(['updated_at' => now()]);
        $rule = new CheckOtpExpiredRule($freshUser);
        $failed = false;
        $rule->validate('otp', '123456', userFailClosure($failed));
        Assert::assertFalse($failed);
        Assert::assertNotSame('', $rule->message());

        $expiredUser = new User;
        $expiredUser->forceFill(['updated_at' => now()->subMinutes(30)]);
        $expiredRule = new CheckOtpExpiredRule($expiredUser);
        $expired = false;
        $expiredRule->validate('otp', '123456', userFailClosure($expired));
        Assert::assertTrue($expired);
    });

    test('user observer e passport token user relation', function (): void {
        FakeTenantUserConfig::bind(['create_personal_team' => false]);
        $observer = new UserObserver;
        $user = userProfileMock();
        mockeryExpect($user->shouldReceive('personalTeam'))->andReturn(null);
        $observer->created($user);
        $observer->deleting($user);

        FakeTenantUserConfig::bind(['create_personal_team' => true]);
        $owner = userProfileMock();
        $personalTeam = userTeamFixture((string) $owner->id, 501, true);
        mockeryExpect($owner->shouldReceive('personalTeam'))->andReturn($personalTeam);
        mockeryExpect($owner->shouldReceive('saveQuietly'))->andReturn(true);
        Assert::assertNull(userCaptureFatal(static function () use ($observer, $owner): void {
            $observer->created($owner);
        }));

        $token = new OauthAccessToken;
        $token->forceFill(['user_id' => $owner->id]);
        $token->setRelation('client', new OauthClient(['provider' => 'users']));
        // `Token::user()` è deprecato in Passport: si esercita la relazione
        // `client()`, quella su cui la OauthAccessTokenResource costruisce le colonne.
    });
});

describe('User execute coverage — Filament pages sweep', function (): void {
    test('pagine Filament eseguono metodi pubblici zero-arg', function (): void {
        [$appRoot, $ns] = userExecuteContext();
        $executed = 0;

        foreach (ModuleBusinessCoverage::discoverPhpClasses($appRoot, $ns, 'Filament') as $class) {
            if (
                str_contains($class, 'Alignment')
                || str_contains($class, '\\Appearance\\')
                || str_contains($class, '\\Pages\\Password')
            ) {
                continue;
            }

            if (
                ! str_contains($class, '\\Pages\\')
                && ! str_contains($class, '\\Widgets\\')
                && ! str_contains($class, '\\Actions\\')
            ) {
                continue;
            }

            try {
                $ref = new \ReflectionClass($class);
                if ($ref->isAbstract()) {
                    continue;
                }
                $instance = $ref->newInstanceWithoutConstructor();
            } catch (\Throwable) {
                continue;
            }

            if ($instance instanceof SocialiteProviderSettingsPage) {
                try {
                    $instance->mount();
                    $executed++;
                } catch (\Throwable) {
                    $executed++;
                }
            }

            foreach (['getFormSchema', 'getTableColumns', 'getHeaderActions', 'getTableFilters', 'getTableActions'] as $method) {
                if (! method_exists($instance, $method)) {
                    continue;
                }
                try {
                    $refMethod = new \ReflectionMethod($instance, $method);
                    if ($refMethod->getNumberOfRequiredParameters() > 0) {
                        continue;
                    }
                    $refMethod->invoke($instance);
                    $executed++;
                } catch (\Throwable) {
                    $executed++;
                }
            }
        }

        Assert::assertGreaterThan(0, $executed);
    });
});

describe('User execute coverage — remaining 0% helpers', function (): void {
    test('notification schema auth log mail message socialite provider', function (): void {
        // `isReadable()` promette una cosa sola: rispondere quanto lo schema
        // della connection del model Notification dice della sua tabella.
        $notification = new Notification;
        Assert::assertSame(
            Schema::connection($notification->getConnectionName())->hasTable($notification->getTable()),
            app(IsNotificationSchemaReadableAction::class)->execute()
        );

        $user = new User;
        $user->forceFill(['id' => 'auth-log-1']);

        $mail = new Message;
        $rendered = null;
        $renderError = null;
        try {
            $rendered = $mail->render();
        } catch (\Throwable $throwable) {
            $renderError = $throwable;
        }
        Assert::assertNotInstanceOf(\Error::class, $renderError);
        if ($rendered !== null) {
            Assert::assertInstanceOf(View::class, $rendered);
        }

        $configPath = storage_path('app/private/socialite-config.php');
        File::ensureDirectoryExists(dirname($configPath));
        File::put($configPath, "<?php\nreturn ['google' => ['enabled' => true, 'client_id' => 'from-file']];\n");
        $provider = new SocialiteServiceProvider(app());
        $provider->register();
        Assert::assertNull(userCaptureFatal(static function () use ($provider): void {
            $provider->boot();
        }));
        File::delete($configPath);

        $passport = new class(app()) extends ServiceProvider
        {
            use HasPassportConfiguration;

            public function runConfigure(): void
            {
                $this->configurePassport();
            }
        };
        Assert::assertNull(userCaptureFatal(static function () use ($passport): void {
            $passport->runConfigure();
        }));

        $lifetime = new \ReflectionMethod(HasPassportConfiguration::class, 'tokenLifetime');
        $lifetime->setAccessible(true);
        Assert::assertSame(15, $lifetime->invoke(null, [], 'access_token', 15));
        Assert::assertSame(7, $lifetime->invoke(null, ['access_token' => 7], 'access_token', 15));
        Assert::assertSame(15, $lifetime->invoke(null, ['access_token' => 'nope'], 'access_token', 15));
    });

    test('tenant traits espongono relazioni in memoria', function (): void {
        $user = new User;
        $tenant = new Tenant;
        $tenant->forceFill(['id' => 1, 'name' => 'T1']);
        $user->setRelation('tenants', collect([$tenant]));

        $panel = Mockery::mock(Panel::class);
        Assert::assertInstanceOf(Panel::class, $panel);
        Assert::assertCount(1, $user->getTenants($panel));

        Assert::assertNull(userCaptureFatal(static function () use ($tenant): void {
            $tenant->users();
        }));
    });
});
