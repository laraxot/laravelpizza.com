<?php

declare(strict_types=1);

/**
 * Base provider for the Xot main panel in Filament.
 *
 * This class is extended by AdminPanelProvider and other panel providers
 * specific to the Xot modules.
 */

namespace Modules\Xot\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;

abstract class XotBaseMainPanelProvider extends PanelProvider
{
    /**
     * Get the panels that this provider should register.
     *
     * @return array<int, Panel>
     */
    public function getPanels(): array
    {
        return [];
    }

    /**
     * Get the resources that this provider should register.
     *
     * @return array<string, class-string>
     */
    public function getResources(): array
    {
        return [];
    }

    /**
     * Get the Filament resources (icons, css, scripts) that this provider should register.
     *
     * */
    public function getResourcesPath(): string
    {
        return '';
    }

    /**
     * Get the URL key for the provider.
     */
    public function getUrlKey(): ?string
    {
        return null;
    }

    /**
     * Get the navigation groups for the panel.
     *
     * @return array<string, array<string, string>>
     */
    public function getNavigationGroups(): array
    {
        return [];
    }

    /**
     * Get the visible navigation items for the panel.
     *
     * @return array<string, array<string, string>>
     */
    public function getVisibleNavigationItems(): array
    {
        return [];
    }

    /**
     * Get the breadcrumbs for the panel.
     *
     * @return array<string, array<string, string>>
     */
    public function getBreadcrumbs(): array
    {
        return [];
    }

    /**
     * Get the logo for the panel.
     *
     * @return array<string, string>
     */
    public function getLogo(): array
    {
        return [];
    }

    /**
     * Get the title of the panel.
     */
    public function getTitle(): string
    {
        return 'Xot Panel';
    }

    /**
     * Get the icon of the panel.
     */
    public function getIcon(): ?string
    {
        return 'heroicon-m-rectangle-stack';
    }

    /**
     * Get the color of the panel.
     */
    public function getColor(): ?string
    {
        return 'primary';
    }
}
