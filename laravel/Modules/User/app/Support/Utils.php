<?php

declare(strict_types=1);

namespace Modules\User\Support;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\User\Contracts\HasShieldPermissions;
use Modules\User\Datas\FilamentShieldData;

use function Safe\class_implements;
use function Safe\class_uses;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Webmozart\Assert\Assert;

/**
 * ---.
 */
class Utils
{
    public static function getFilamentAuthGuard(): string
    {
        return 'web';

        // Assert::string($res = config('filament.auth.guard'), 'wip');
        // return $res;
    }

    public static function isResourcePublished(): bool
    {
        $roleResourcePath = app_path((string) Str::of('Filament\\Resources\\Shield\\RoleResource.php')->replace(
            '\\',
            '/',
        ));

        $filesystem = new Filesystem();

        return $filesystem->exists($roleResourcePath);
    }

    public static function getResourceSlug(): string
    {
        Assert::string($res = config('filament-shield.shield_resource.slug'), 'wip');

        return $res;
    }

    public static function isResourceNavigationRegistered(): bool
    {
        Assert::boolean($res = config('filament-shield.shield_resource.should_register_navigation', true));

        return $res;
    }

    public static function getResourceNavigationSort(): int
    {
        // return config('filament-shield.shield_resource.navigation_sort');
        return FilamentShieldData::make()->shield_resource->navigation_sort;
    }

    public static function isResourceNavigationBadgeEnabled(): bool
    {
        // return config('filament-shield.shield_resource.navigation_badge', true);
        return FilamentShieldData::make()->shield_resource->navigation_badge;
    }

    public static function isResourceNavigationGroupEnabled(): bool
    {
        // return config('filament-shield.shield_resource.navigation_group', true);
        return FilamentShieldData::make()->shield_resource->navigation_group;
    }

    public static function isResourceGloballySearchable(): bool
    {
        // return config('filament-shield.shield_resource.is_globally_searchable', false);
        return FilamentShieldData::make()->shield_resource->is_globally_searchable;
    }

    public static function getAuthProviderFQCN(): string
    {
        Assert::string($res = config('filament-shield.auth_provider_model.fqcn'));

        return $res;
    }

    public static function isAuthProviderConfigured(): bool
    {
        return in_array(
            "BezhanSalleh\FilamentShield\Traits\HasFilamentShield",
            class_uses(static::getAuthProviderFQCN()),
            strict: true
        ) || in_array(HasRoles::class, class_uses(static::getAuthProviderFQCN()), strict: true);
    }

    public static function isSuperAdminEnabled(): bool
    {
        // return (bool) config('filament-shield.super_admin.enabled', true);
        return FilamentShieldData::make()->super_admin->enabled;
    }

    public static function getSuperAdminName(): string
    {
        // return (string) config('filament-shield.super_admin.name');
        return FilamentShieldData::make()->super_admin->name;
    }

    public static function isSuperAdminDefinedViaGate(): bool
    {
        // return (bool) static::isSuperAdminEnabled() && config('filament-shield.super_admin.define_via_gate', false);
        return FilamentShieldData::make()->super_admin->define_via_gate;
    }

    public static function getSuperAdminGateInterceptionStatus(): string
    {
        // return (string) config('filament-shield.super_admin.intercept_gate');
        return FilamentShieldData::make()->super_admin->intercept_gate;
    }

    public static function isFilamentUserRoleEnabled(): bool
    {
        // return (bool) config('filament-shield.filament_user.enabled', true);
        return FilamentShieldData::make()->filament_user->enabled;
    }

    public static function getFilamentUserRoleName(): string
    {
        // return (string) config('filament-shield.filament_user.name');
        return FilamentShieldData::make()->filament_user->name;
    }

    public static function getGeneralResourcePermissionPrefixes(): array
    {
        Assert::isArray($res = config('filament-shield.permission_prefixes.resource'), 'wip');

        return $res;
    }

    public static function getPagePermissionPrefix(): string
    {
        Assert::string($res = config('filament-shield.permission_prefixes.page'));

        return $res;
    }

    public static function getWidgetPermissionPrefix(): string
    {
        Assert::string($res = config('filament-shield.permission_prefixes.widget'));

        return $res;
    }

    public static function isResourceEntityEnabled(): bool
    {
        Assert::boolean($res = config('filament-shield.entities.resources', true));

        return $res;
    }

    public static function isPageEntityEnabled(): bool
    {
        Assert::boolean($res = config('filament-shield.entities.pages', true));

        return $res;
    }

    /**
     * Widget Entity Status.
     */
    public static function isWidgetEntityEnabled(): bool
    {
        Assert::boolean($res = config('filament-shield.entities.widgets', true));

        return $res;
    }

    public static function isCustomPermissionEntityEnabled(): bool
    {
        Assert::boolean($res = config('filament-shield.entities.custom_permissions', false));

        return $res;
    }

    public static function getGeneratorOption(): string
    {
        Assert::string($res = config('filament-shield.generator.option', 'policies_and_permissions'));

        return $res;
    }

    public static function isGeneralExcludeEnabled(): bool
    {
        Assert::boolean($res = config('filament-shield.exclude.enabled', true));

        return $res;
    }

    public static function enableGeneralExclude(): void
    {
        config(['filament-shield.exclude.enabled' => true]);
    }

    public static function disableGeneralExclude(): void
    {
        config(['filament-shield.exclude.enabled' => false]);
    }

    public static function getExcludedResouces(): array
    {
        Assert::isArray($res = config('filament-shield.exclude.resources'));

        return $res;
    }

    public static function getExcludedPages(): array
    {
        Assert::isArray($res = config('filament-shield.exclude.pages'));

        return $res;
    }

    public static function getExcludedWidgets(): array
    {
        Assert::isArray($res = config('filament-shield.exclude.widgets'));

        return $res;
    }

    public static function isRolePolicyRegistered(): bool
    {
        Assert::boolean($res = config('filament-shield.register_role_policy', true));

        return $res;
    }

    public static function doesResourceHaveCustomPermissions(string $resourceClass): bool
    {
        return in_array(HasShieldPermissions::class, class_implements($resourceClass), strict: true);
    }

    /**
     * @return class-string|string
     *
     * @psalm-return ''|class-string
     */
    public static function showModelPath(string $resourceFQCN): string
    {
        return config('filament-shield.shield_resource.show_model_path', true)
            ? (new ($resourceFQCN::getModel())())::class
            : '';
    }

    public static function getResourcePermissionPrefixes(string $resourceFQCN): array
    {
        $res = static::doesResourceHaveCustomPermissions($resourceFQCN)
            ? $resourceFQCN::getPermissionPrefixes()
            : static::getGeneralResourcePermissionPrefixes();
        Assert::isArray($res);

        return $res;
    }

    public static function getRoleModel(): string
    {
        Assert::string($res = config('permission.models.role', Role::class));

        return $res;
    }

    public static function getPermissionModel(): string
    {
        Assert::string($res = config('permission.models.permission', Permission::class));

        return $res;
    }

    /**
     * Check if the role resource exists.
     */
    public static function roleResourceExists(): bool
    {
        $roleResourcePath = base_path('Modules/User/app/Filament/Resources/RoleResource.php');

        return File::exists($roleResourcePath);
    }
}
