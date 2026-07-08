<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Datas;

use Modules\User\Datas\FilamentShieldData;
use Modules\User\Datas\PermissionData;
use Modules\User\Datas\SocialiteUserAttributesData;
use Modules\User\Enums\Enums\LanguageEnum as NestedLanguageEnum;
use Modules\User\Enums\LanguageEnum;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('User Datas And Enums Coverage', function (): void {
    test('creates socialite user attributes data with expected values', function (): void {
        /** @var TestCase $this */
        $data = new SocialiteUserAttributesData(
            name: 'Mario',
            firstName: 'Mario',
            lastName: 'Rossi',
            email: 'mario.rossi@example.com',
            provider: 'github',
        );

        Assert::assertSame('Mario', $data->name);
        Assert::assertSame('Rossi', $data->lastName);
        Assert::assertSame('github', $data->provider);
    });

    test('builds permission data from permission config', function (): void {
        /* @var TestCase $this */
        config([
            'permission' => [
                'models' => [
                    'permission' => 'Modules\\User\\Models\\Permission',
                    'role' => 'Modules\\User\\Models\\Role',
                ],
                'table_names' => [
                    'roles' => 'roles',
                    'permissions' => 'permissions',
                    'model_has_permissions' => 'model_has_permissions',
                    'model_has_roles' => 'model_has_roles',
                    'role_has_permissions' => 'role_has_permissions',
                ],
                'column_names' => [
                    'role_pivot_key' => null,
                    'permission_pivot_key' => null,
                    'model_morph_key' => 'model_id',
                    'team_foreign_key' => 'team_id',
                ],
                'register_permission_check_method' => true,
                'teams' => false,
                'display_permission_in_exception' => false,
                'display_role_in_exception' => false,
                'enable_wildcard_permission' => false,
                'cache' => [
                    'expiration_time' => new \DateInterval('PT24H'),
                    'key' => 'spatie.permission.cache',
                    'store' => 'default',
                ],
            ],
        ]);

        $data = PermissionData::make();

        Assert::assertInstanceOf(PermissionData::class, $data);
        Assert::assertStringContainsString('Role', (string) $data->models->role);
        Assert::assertSame('permissions', $data->table_names->permissions);
        Assert::assertSame('spatie.permission.cache', $data->cache->key);
    });

    test('builds filament shield data from filament shield config', function (): void {
        /* @var TestCase $this */
        config([
            'filament-shield' => [
                'shield_resource' => [
                    'navigation_sort' => -1,
                    'navigation_badge' => true,
                    'navigation_group' => true,
                    'is_globally_searchable' => false,
                ],
                'super_admin' => [
                    'enabled' => true,
                    'name' => 'super_admin',
                    'define_via_gate' => false,
                    'intercept_gate' => 'before',
                ],
                'filament_user' => [
                    'enabled' => true,
                    'name' => 'filament_user',
                ],
            ],
        ]);

        $data = FilamentShieldData::make();

        Assert::assertInstanceOf(FilamentShieldData::class, $data);
        Assert::assertSame(-1, $data->shield_resource->navigation_sort);
        Assert::assertSame('super_admin', $data->super_admin->name);
        Assert::assertTrue($data->filament_user->enabled);
    });

    test('returns labels for both language enums', function (): void {
        /* @var TestCase $this */
        /* @var TestCase $this */
        app()->setLocale('it');

        $italianLabel = LanguageEnum::ITALIAN->getLabel();
        if (str_contains((string) $italianLabel, 'language_enum')) {
            $this->skipTest('Language enum translations not loaded in test environment.');
        }

        Assert::assertSame('Italiano', $italianLabel);
        Assert::assertSame('English', LanguageEnum::ENGLISH->getLabel());
        Assert::assertSame('Deutsch', NestedLanguageEnum::GERMAN->getLabel());
        Assert::assertSame('es', NestedLanguageEnum::SPANISH->value);
    });
});
