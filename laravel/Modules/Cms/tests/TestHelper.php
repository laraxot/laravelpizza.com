<?php

declare(strict_types=1);

namespace Modules\Cms\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Cms\Models\Module;
use Modules\User\Models\User;
use Modules\Xot\Actions\Filament\GetModulesNavigationItems;
use Modules\Xot\Tests\CreatesApplication;

abstract class TestHelper extends BaseTestCase
{
    // use CreatesApplication;

    // in User
    public function getSuperAdminUser()
    {
        return User::role('super-admin')->first();
    }

    // in User
    public function getNoSuperAdminUser()
    {
        return User::all()
            ->map(function ($item) {
                if (! $item->hasRole('super-admin')) {
                    return $item;
                }
            })
            ->first();
    }

    // in Tenant o Cms
    public function getModuleNameLists()
    {
        return collect(app(Module::class)->getRows())->pluck('name')->all();
    }

    // in Tenant o Cms
    public function getMainAdminNavigationUrlItems()
    {
        return $item_navs = collect(app(GetModulesNavigationItems::class)->execute())
            ->map(fn ($item): ?string => $item->getUrl());
    }

    // in Tenant o Cms
    public function getUserNavigationItemUrlRoles($user)
    {
        return $role_names = $user
            ->getRoleNames()
            ->map(function ($item) {
                if ('super-admin' !== $item) {
                    return '/'.mb_substr($item, 0, -7).'/admin';
                }
            })
            ->filter(fn ($value): bool => ! is_null($value));
    }
}
