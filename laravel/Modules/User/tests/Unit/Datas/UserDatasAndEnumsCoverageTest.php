<?php

declare(strict_types=1);

use Modules\User\Datas\FilamentShieldData;
use Modules\User\Datas\PermissionData;
use Modules\User\Datas\SocialiteUserAttributesData;
use Modules\User\Enums\Enums\LanguageEnum as NestedLanguageEnum;
use Modules\User\Enums\LanguageEnum;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('User datas and enums coverage', function (): void {
    it('creates SocialiteUserAttributesData with expected values', function (): void {
        $data = new SocialiteUserAttributesData(
            name: 'Mario',
            firstName: 'Mario',
            lastName: 'Rossi',
            email: 'mario.rossi@example.com',
            provider: 'github',
        );

        expect($data->name)->toBe('Mario')
            ->and($data->lastName)->toBe('Rossi')
            ->and($data->provider)->toBe('github');
    });

    it('builds PermissionData from permission config', function (): void {
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
                    'expiration_time' => new DateInterval('PT24H'),
                    'key' => 'spatie.permission.cache',
                    'store' => 'default',
                ],
            ],
        ]);

        $data = PermissionData::make();

        expect($data)->toBeInstanceOf(PermissionData::class)
            ->and($data->models->role)->toContain('Role')
            ->and($data->table_names->permissions)->toBe('permissions')
            ->and($data->cache->key)->toBe('spatie.permission.cache');
    });

    it('builds FilamentShieldData from filament-shield config', function (): void {
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

        expect($data)->toBeInstanceOf(FilamentShieldData::class)
            ->and($data->shield_resource->navigation_sort)->toBe(-1)
            ->and($data->super_admin->name)->toBe('super_admin')
            ->and($data->filament_user->enabled)->toBeTrue();
    });

    it('returns labels for both language enums', function (): void {
        expect(LanguageEnum::ITALIAN->getLabel())->toBe('Italiano')
            ->and(LanguageEnum::ENGLISH->getLabel())->toBe('English')
            ->and(NestedLanguageEnum::GERMAN->getLabel())->toBe('Deutsch')
            ->and(NestedLanguageEnum::SPANISH->value)->toBe('es');
    });
});
