<?php

declare(strict_types=1);

namespace Modules\User\Actions\Shield;

use Illuminate\Support\Str;
use Modules\User\Datas\FilamentShieldData;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per risolvere la configurazione Filament Shield del resource.
 *
 * Raggruppa: getResourceSlug, isResourcePublished, isResourceNavigationRegistered,
 * getResourceNavigationSort, isResourceNavigationBadgeEnabled,
 * isResourceNavigationGroupEnabled, isResourceGloballySearchable
 */
class ResolveShieldResourceConfigurationAction
{
    use QueueableAction;

    /**
     * Execute the action to resolve shield resource configuration.
     *
     * @return array{
     *     slug: string,
     *     published: bool,
     *     navigation_registered: bool,
     *     navigation_sort: int,
     *     navigation_badge: bool,
     *     navigation_group: bool,
     *     globally_searchable: bool,
     * }
     */
    public function execute(): array
    {
        $shieldData = FilamentShieldData::make();
        $slug = config('filament-shield.shield_resource.slug');
        $navRegistered = config('filament-shield.shield_resource.should_register_navigation', true);

        return [
            'slug' => is_string($slug) ? $slug : 'shield',
            'published' => $this->isResourcePublished(),
            'navigation_registered' => is_bool($navRegistered) ? $navRegistered : true,
            'navigation_sort' => $shieldData->shield_resource->navigation_sort,
            'navigation_badge' => $shieldData->shield_resource->navigation_badge,
            'navigation_group' => $shieldData->shield_resource->navigation_group,
            'globally_searchable' => $shieldData->shield_resource->is_globally_searchable,
        ];
    }

    private function isResourcePublished(): bool
    {
        $roleResourcePath = app_path((string) Str::of('Filament\\Resources\\Shield\\RoleResource.php')->replace(
            '\\',
            '/',
        ));

        return file_exists($roleResourcePath);
    }
}
