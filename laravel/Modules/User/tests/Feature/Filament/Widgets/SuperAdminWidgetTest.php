<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\WidgetConfiguration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Filament\Widgets\Profile\SuperAdminWidget;
use Modules\User\Models\Role;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use PHPUnit\Framework\Assert;

use function Pest\Laravel\actingAs;

uses(TestCase::class);

/**
 * Connessione su cui vive il model Profile del progetto corrente: il main_module
 * lo decide XotData (via getProfileClass()), non il test. Stesso motivo/pattern
 * di Modules/User/tests/Feature/UserBusinessLogicTest.php::profileConnectionName() —
 * duplicato qui invece di importato per restare nell'Owned File/Module Scope di
 * questa story (nessuna dipendenza da un altro file di test non elencato).
 */
function superAdminWidgetProfileConnectionName(): string
{
    $profileClass = XotData::make()->getProfileClass();
    $connection = (new $profileClass)->getConnectionName();

    if (is_string($connection) && $connection !== '') {
        return $connection;
    }

    $default = config('database.default');

    return is_string($default) ? $default : 'sqlite';
}

/**
 * Crea entrambi i ruoli gestiti da IsProfileTrait::toggleSuperAdmin() (super-admin e
 * negate-super-admin, team_id null, guard web — coerente con la RoleFactory di questo
 * modulo) e assegna all'utente solo quello di partenza. Creare entrambi i ruoli replica
 * lo scenario reale (ruoli seedati a priori) descritto nella business logic e fa
 * percorrere a toggleSuperAdmin() il ramo try assignRole()/removeRole(); il ramo di
 * fallback catch (RoleDoesNotExist) esiste solo per un ruolo mai seedato ed e' fuori
 * dallo scope di questa story (test del solo widget, non di IsProfileTrait).
 */
function grantSuperAdminWidgetRole(User $user, string $roleName): void
{
    /** @var Role $superAdminRole */
    $superAdminRole = Role::query()->firstOrCreate(
        ['name' => 'super-admin', 'guard_name' => 'web'],
        ['team_id' => null],
    );

    /** @var Role $negateSuperAdminRole */
    $negateSuperAdminRole = Role::query()->firstOrCreate(
        ['name' => 'negate-super-admin', 'guard_name' => 'web'],
        ['team_id' => null],
    );

    $role = $roleName === 'super-admin' ? $superAdminRole : $negateSuperAdminRole;

    $user->assignRole($role);
}

beforeEach(function (): void {
    /* @var TestCase $this */
    TestCase::skipUnlessUsersTableReady();
    TestCase::skipUnlessRoleAssignmentSupported();

    // Il connettore di cache di default in questo ambiente di test risolve su 'database'
    // (CACHE_STORE non impostato in .env.testing/phpunit.xml, solo il legacy CACHE_DRIVER,
    // ignorato da Laravel 11+), puntando alla tabella `cache` sulla connessione `mysql`
    // (quaeris_data_test), dove quella tabella non esiste. Spatie Permission invalida
    // questa cache ad ogni assignRole()/removeRole() (config('permission.cache.store') = 'default').
    // Scope locale a questo processo di test, nessun file condiviso toccato: stesso sintomo
    // riprodotto anche su Modules/User/tests/Feature/UserBusinessLogicTest.php (pre-esistente,
    // non causato da questa story).
    config(['cache.default' => 'array']);

    // XotData::make() e' un singleton su proprieta' statica (Modules/Xot/app/Datas/XotData.php,
    // `private static ?self $instance`) che sopravvive fra i test dello stesso processo Pest;
    // il suo `getProfileModel()` mette in cache `$this->profile` alla prima chiamata. Senza
    // reset, il secondo test di questo file riceverebbe il Profile (e quindi lo user_id/ruolo)
    // del primo. Reset qui, scoped a questo file di test, senza toccare Modules/Xot (fuori
    // dall'Owned File/Module Scope di questa story).
    $xotDataReflection = new \ReflectionClass(XotData::class);
    $xotDataInstanceProperty = $xotDataReflection->getProperty('instance');
    $xotDataInstanceProperty->setAccessible(true);
    $xotDataInstanceProperty->setValue(null, null);

    if (! Schema::connection(superAdminWidgetProfileConnectionName())->hasTable('profiles')) {
        Assert::markTestSkipped('profiles table missing on the profile connection.');
    }

    $this->setupFilamentAdminPanel();

    Assert::assertNotNull(Filament::getPanel('user::admin'));
});

describe('SuperAdminWidget visibility', function (): void {
    test('super-admin user sees the active hero emblem toggle', function (): void {
        /** @var TestCase $this */
        $user = UserFactory::new()->createOne();
        grantSuperAdminWidgetRole($user, 'super-admin');
        actingAs($user);

        Livewire::test(SuperAdminWidget::class)
            ->assertSuccessful()
            ->assertSee(__('user::super_admin_widget.tooltip.active'))
            ->assertDontSee(__('user::super_admin_widget.tooltip.negated'))
            ->assertSeeHtml('data-super-admin-state="active"')
            ->assertDontSeeHtml('data-super-admin-state="negated"')
            ->assertSeeHtml('fi-icon-btn')
            ->assertSeeHtml('u-sm-cape')
            ->assertSeeHtml('u-sm-curl');
    });

    test('negate-super-admin user sees the barred hero emblem toggle', function (): void {
        /** @var TestCase $this */
        $user = UserFactory::new()->createOne();
        grantSuperAdminWidgetRole($user, 'negate-super-admin');
        actingAs($user);

        Livewire::test(SuperAdminWidget::class)
            ->assertSuccessful()
            ->assertSee(__('user::super_admin_widget.tooltip.negated'))
            ->assertSeeHtml('data-super-admin-state="negated"')
            ->assertDontSeeHtml('data-super-admin-state="active"')
            ->assertSeeHtml('fi-icon-btn')
            ->assertSeeHtml('u-ck-lens')
            ->assertSeeHtml('u-ck-tie');

        // Nota: non si puo' usare assertDontSee(tooltip.active) qui — in locale it
        // "Super Admin" e' una sottostringa letterale di "Nega Super Admin", quindi
        // sarebbe sempre presente. Il marcatore distintivo e' data-super-admin-state.
    });

    test('user without either role sees no toggle button at all', function (): void {
        /** @var TestCase $this */
        $user = UserFactory::new()->createOne();
        actingAs($user);

        Livewire::test(SuperAdminWidget::class)
            ->assertSuccessful()
            ->assertDontSee(__('user::super_admin_widget.tooltip.active'))
            ->assertDontSee(__('user::super_admin_widget.tooltip.negated'))
            ->assertDontSeeHtml('toggleSuperAdmin');
    });
});

describe('SuperAdminWidget toggle', function (): void {
    test('toggleSuperAdmin flips super-admin into negate-super-admin', function (): void {
        /** @var TestCase $this */
        $user = UserFactory::new()->createOne();
        grantSuperAdminWidgetRole($user, 'super-admin');
        actingAs($user);

        Assert::assertTrue((bool) $user->fresh()?->hasRole('super-admin'));

        Livewire::test(SuperAdminWidget::class)
            ->call('toggleSuperAdmin')
            ->assertRedirect();

        $fresh = $user->fresh();
        Assert::assertInstanceOf(UserContract::class, $fresh);
        Assert::assertFalse($fresh->hasRole('super-admin'));
        Assert::assertTrue($fresh->hasRole('negate-super-admin'));
    });

    test('toggleSuperAdmin flips negate-super-admin back into super-admin', function (): void {
        /** @var TestCase $this */
        $user = UserFactory::new()->createOne();
        grantSuperAdminWidgetRole($user, 'negate-super-admin');
        actingAs($user);

        Livewire::test(SuperAdminWidget::class)
            ->call('toggleSuperAdmin')
            ->assertRedirect();

        $fresh = $user->fresh();
        Assert::assertInstanceOf(UserContract::class, $fresh);
        Assert::assertTrue($fresh->hasRole('super-admin'));
        Assert::assertFalse($fresh->hasRole('negate-super-admin'));
    });

    test('toggleSuperAdmin returns a real 303 redirect response, not just a Livewire effect', function (): void {
        /** @var TestCase $this */
        $user = UserFactory::new()->createOne();
        grantSuperAdminWidgetRole($user, 'super-admin');
        actingAs($user);

        $widget = new SuperAdminWidget;
        $widget->mount();
        // Dal controllo di DCP-181 il profilo deve vedere il ruolo: l'utente del profilo e' `Modules\Fixcity\Models\User`, quello della factory
        // `Modules\User\Models\User`, e i ruoli Spatie sono legati alla classe del modello. Si collega il profilo all'utente che ha il ruolo.
        XotData::make()->getProfileModel()->setRelation('user', $user);

        $response = $widget->toggleSuperAdmin();

        Assert::assertInstanceOf(RedirectResponse::class, $response);
        Assert::assertSame(303, $response->getStatusCode());
    });
});

describe('SuperAdminWidget authorization (DCP-181, audit A-3)', function (): void {
    test('a user with neither role cannot make himself super-admin by calling the Livewire action', function (): void {
        /** @var TestCase $this */
        $user = UserFactory::new()->createOne();
        // i due ruoli esistono (come nel sistema reale); l'utente non ha ne' l'uno ne' l'altro
        grantSuperAdminWidgetRole(UserFactory::new()->createOne(), 'super-admin');
        actingAs($user);

        try {
            Livewire::test(SuperAdminWidget::class)->call('toggleSuperAdmin');
        } catch (\Throwable) {
            // un rifiuto con eccezione (403 / AuthorizationException) e' un esito valido: conta solo che il ruolo non sia stato dato
        }

        $fresh = $user->fresh();
        Assert::assertInstanceOf(UserContract::class, $fresh);
        Assert::assertFalse($fresh->hasRole('super-admin'));
        Assert::assertFalse($fresh->hasRole('negate-super-admin'));
    });
});

describe('SuperAdminWidget dashboard discovery', function (): void {
    test('dashboard widget list has no SuperAdminWidget card', function (): void {
        $panel = Filament::getPanel('user::admin');
        if ($panel === null) {
            Assert::fail('The User admin panel was not registered by the test bootstrap.');
        }

        $widgetClasses = array_map(
            static fn (string|WidgetConfiguration $widget): string => is_string($widget) ? $widget : $widget::class,
            $panel->getWidgets(),
        );

        Assert::assertNotContains(SuperAdminWidget::class, $widgetClasses);
    });
});
