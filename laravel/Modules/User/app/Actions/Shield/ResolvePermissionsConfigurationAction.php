<?php

declare(strict_types=1);

namespace Modules\User\Actions\Shield;

use Modules\User\Contracts\HasShieldPermissions;
use Spatie\QueueableAction\QueueableAction;

use function Safe\class_implements;

/**
 * Action per risolvere la configurazione permissions e entities.
 *
 * Raggruppa: getGeneralResourcePermissionPrefixes, getPagePermissionPrefix,
 * getWidgetPermissionPrefix, isResourceEntityEnabled, isPageEntityEnabled,
 * isWidgetEntityEnabled, isCustomPermissionEntityEnabled, getGeneratorOption,
 * isRolePolicyRegistered, doesResourceHaveCustomPermissions,
 * getResourcePermissionPrefixes, getRoleModel, getPermissionModel, roleResourceExists
 */
class ResolvePermissionsConfigurationAction
{
    use QueueableAction;

    /**
     * Execute the action to resolve permissions and entities configuration.
     *
     * @return array{
     *     resource_permission_prefixes: list<string>,
     *     page_permission_prefix: string,
     *     widget_permission_prefix: string,
     *     resource_entity_enabled: bool,
     *     page_entity_enabled: bool,
     *     widget_entity_enabled: bool,
     *     custom_permission_entity_enabled: bool,
     *     generator_option: string,
     *     role_policy_registered: bool,
     *     role_model: string,
     *     permission_model: string,
     *     role_resource_exists: bool,
     * }
     */
    public function execute(): array
    {
        return [
            'resource_permission_prefixes' => $this->getGeneralResourcePermissionPrefixes(),
            'page_permission_prefix' => $this->getPagePermissionPrefix(),
            'widget_permission_prefix' => $this->getWidgetPermissionPrefix(),
            'resource_entity_enabled' => $this->isResourceEntityEnabled(),
            'page_entity_enabled' => $this->isPageEntityEnabled(),
            'widget_entity_enabled' => $this->isWidgetEntityEnabled(),
            'custom_permission_entity_enabled' => $this->isCustomPermissionEntityEnabled(),
            'generator_option' => $this->getGeneratorOption(),
            'role_policy_registered' => $this->isRolePolicyRegistered(),
            'role_model' => $this->getRoleModel(),
            'permission_model' => $this->getPermissionModel(),
            'role_resource_exists' => $this->roleResourceExists(),
        ];
    }

    /**
     * @return list<string>
     */
    private function getGeneralResourcePermissionPrefixes(): array
    {
        $res = config('filament-shield.permission_prefixes.resource', []);

        if (! is_array($res)) {
            return [];
        }

        return array_values(array_filter($res, is_string(...)));
    }

    private function getPagePermissionPrefix(): string
    {
        $res = config('filament-shield.permission_prefixes.page', 'page');

        return is_string($res) ? $res : 'page';
    }

    private function getWidgetPermissionPrefix(): string
    {
        $res = config('filament-shield.permission_prefixes.widget', 'widget');

        return is_string($res) ? $res : 'widget';
    }

    private function isResourceEntityEnabled(): bool
    {
        $res = config('filament-shield.entities.resources', true);

        return is_bool($res) ? $res : true;
    }

    private function isPageEntityEnabled(): bool
    {
        $res = config('filament-shield.entities.pages', true);

        return is_bool($res) ? $res : true;
    }

    private function isWidgetEntityEnabled(): bool
    {
        $res = config('filament-shield.entities.widgets', true);

        return is_bool($res) ? $res : true;
    }

    private function isCustomPermissionEntityEnabled(): bool
    {
        $res = config('filament-shield.entities.custom_permissions', false);

        return is_bool($res) ? $res : false;
    }

    private function getGeneratorOption(): string
    {
        $res = config('filament-shield.generator.option', 'policies_and_permissions');

        return is_string($res) ? $res : 'policies_and_permissions';
    }

    private function isRolePolicyRegistered(): bool
    {
        $res = config('filament-shield.register_role_policy', true);

        return is_bool($res) ? $res : true;
    }

    private function getRoleModel(): string
    {
        $res = config('permission.models.role', 'Spatie\Permission\Models\Role');

        return is_string($res) ? $res : 'Spatie\Permission\Models\Role';
    }

    private function getPermissionModel(): string
    {
        $res = config('permission.models.permission', 'Spatie\Permission\Models\Permission');

        return is_string($res) ? $res : 'Spatie\Permission\Models\Permission';
    }

    private function roleResourceExists(): bool
    {
        $roleResourcePath = base_path('Modules/User/app/Filament/Resources/RoleResource.php');

        return file_exists($roleResourcePath);
    }

    public function doesResourceHaveCustomPermissions(string $resourceClass): bool
    {
        if (! class_exists($resourceClass)) {
            return false;
        }

        $interfaces = class_implements($resourceClass);

        return \in_array(HasShieldPermissions::class, $interfaces, strict: true);
    }

    /**
     * @return list<string>
     */
    public function getResourcePermissionPrefixes(string $resourceFQCN): array
    {
        $res = $this->doesResourceHaveCustomPermissions($resourceFQCN)
            ? $resourceFQCN::getPermissionPrefixes()
            : $this->getGeneralResourcePermissionPrefixes();

        if (! is_array($res)) {
            return [];
        }

        return array_values(array_filter($res, is_string(...)));
    }
}
