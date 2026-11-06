<?php

declare(strict_types=1);

namespace Modules\Cms\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Cms\Models\Module;
use Modules\User\Models\User;
use Modules\Xot\Actions\Filament\GetModulesNavigationItems;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Tests\CreatesApplication;
use Spatie\Permission\Contracts\Role;

/**
 * @method mixed getAttribute(string $key)
 */
abstract class TestHelper extends BaseTestCase
{
    // use CreatesApplication;

    // in User
    public function getSuperAdminUser(): ?UserContract
    {
        return User::role('super-admin')->first();
    }

    // in User
    public function getNoSuperAdminUser(): ?UserContract
    {
        /** @var UserContract|null $user */
        $user = User::all()
            ->map(function (UserContract $item): ?UserContract {
                if (! $item->hasRole('super-admin')) {
                    return $item;
                }

                return null;
            })
            ->filter(fn ($value): bool => $value !== null)
            ->first();

        return $user;
    }

    // in Tenant o Cms
    /** @return array<int, string> */
    public function getModuleNameLists(): array
    {
        /** @var Module $module */
        $module = app(Module::class);

        /** @var array<int, array<string, mixed>> $rows */
        $rows = $module->getRows();

        $names = [];
        foreach ($rows as $row) {
            $name = $row['name'] ?? null;
            if (is_string($name)) {
                $names[] = $name;
            }
        }

        return $names;
    }

    // in Tenant o Cms
    /** @return array<int, string> */
    public function getMainAdminNavigationUrlItems(): array
    {
        $items = collect(app(GetModulesNavigationItems::class)->execute())
            ->map(function ($item): ?string {
                $url = $item->getUrl();
                if (is_string($url) && $url) {
                    return $url;
                }

                return null;
            })
            ->filter(fn ($url): bool => $url !== null)
            ->values()
            ->all();

        /** @var array<int, string> $result */
        $result = $items;

        return $result;
    }

    // in Tenant o Cms
    /** @return array<int, string> */
    public function getUserNavigationItemUrlRoles(UserContract $user): array
    {
        $result = [];
        foreach ($user->roles()->pluck('name') as $roleName) {
            if (is_string($roleName) && $roleName !== 'super-admin') {
                $result[] = '/'.mb_substr($roleName, 0, -7).'/admin';
            }
        }

        return $result;
    }
}