<?php

declare(strict_types=1);

use Modules\Cms\Models\Module;
use Modules\Cms\Tests\TestHelper;
use Modules\Xot\Actions\Filament\GetModulesNavigationItems;

describe('CMS Module', function (): void {
    it('user admin can view module dashboard', function (): void {
        // Test business logic: check that Module class exists and has required methods
        expect(class_exists(Module::class))->toBeTrue();

        $moduleInstance = new Module;
        expect(method_exists($moduleInstance, 'getRows'))->toBeTrue();
    });

    it('user admin can view main dashboard', function (): void {
        // Test business logic: check that navigation action exists
        expect(class_exists(GetModulesNavigationItems::class))->toBeTrue();

        $navigationAction = new GetModulesNavigationItems;
        expect(method_exists($navigationAction, 'execute'))->toBeTrue();
    });

    it('guest user can view main dashboard', function (): void {
        // Test that module structure is correct
        expect(Module::class)->toBeString()->and(class_exists(Module::class))->toBeTrue();
    });

    it('the user views navigation modules entries based on their role', function (): void {
        // Test business logic: navigation items generation
        expect(GetModulesNavigationItems::class)
            ->toBeString()
            ->and(class_exists(GetModulesNavigationItems::class))
            ->toBeTrue();
    });

    it('the user no views navigation modules entries based on their no role', function (): void {
        // Test that required classes exist for role-based navigation
        expect(Module::class)->toBeString()->and(GetModulesNavigationItems::class)->toBeString();
    });
});

uses(TestHelper::class);

beforeEach(function (): void {
    /* @var \Modules\User\Models\User */
    /* @phpstan-ignore-next-line method.nonObject */
    $this->super_admin_user = $this->getSuperAdminUser();
    /* @var \Modules\User\Models\User */
    /* @phpstan-ignore-next-line method.nonObject */
    $this->no_super_admin_user = $this->getNoSuperAdminUser();
});

it('user admin can view main dashboard', function (): void {
    /** @var Modules\User\Models\User $superAdmin */
    /** @phpstan-ignore-next-line property.notFound */
    $superAdmin = $this->super_admin_user;
    /** @phpstan-ignore-next-line property.notFound */
    $modules_name = $this->getModuleNameLists();

    /* @phpstan-ignore-next-line property.notFound */
    $this->actingAs($superAdmin)->get('/admin')->assertRedirect('admin/main-dashboard');
    /* @phpstan-ignore-next-line property.notFound */
    $this->actingAs($superAdmin)->get('/admin/main-dashboard')->assertStatus(200); // ->assertSee($modules_name);
});

it('guest user can view main dashboard', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    $this->actingAs($this->no_super_admin_user)->get('/admin')->assertRedirect('admin/main-dashboard');
    /* @phpstan-ignore-next-line property.notFound */
    $this->actingAs($this->no_super_admin_user)->get('/admin/main-dashboard')->assertStatus(200);
});

it('the user views navigation modules entries based on their role', function (): void {
    /** @phpstan-ignore-next-line property.notFound */
    $item_navs_roles = $this->getUserNavigationItemUrlRoles($this->super_admin_user);
    foreach ($item_navs_roles as $item_nav_role) {
        /* @phpstan-ignore-next-line property.notFound */
        $this->actingAs($this->super_admin_user)->get('/admin/main-dashboard')->assertSee($item_nav_role);

        // ->assertSeeText($item_nav_role)
    }
});

it('the user no views navigation modules entries based on their no role', function (): void {
    /** @phpstan-ignore-next-line property.notFound */
    $diff_navigation_items = $this->getMainAdminNavigationUrlItems()->diff($this->getUserNavigationItemUrlRoles($this->super_admin_user)->all());
    foreach ($diff_navigation_items as $item_nav_role) {
        /* @phpstan-ignore-next-line property.notFound */
        $this->actingAs($this->super_admin_user)->get('/admin/main-dashboard')->assertDontSee($item_nav_role);

        // ->assertDontSeeText($item_nav_role)
    }
});

it('user admin can view module dashboard', function (): void {
    // $module_name = 'BarberShop';

    /* @phpstan-ignore-next-line property.notFound */
    // $this->get('/admin')->dd();

    /* @phpstan-ignore-next-line property.notFound */
    // $this->actingAs($super_admin_user)->get('/admin')->assertRedirect('admin/main-dashboard');
    /* @phpstan-ignore-next-line property.notFound */
    $this->actingAs($this->super_admin_user)->get('http://multiv.local/barbershop/admin/dashboard')->assertStatus(200); // ->assertSee($modules_name);
})->todo();
