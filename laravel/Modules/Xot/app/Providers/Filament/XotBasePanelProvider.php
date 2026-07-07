<?php

declare(strict_types=1);

namespace Modules\Xot\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Str;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Modules\Xot\Actions\Panel\ApplyMetatagToPanelAction;
// Remove if not used elsewhere implicitly
use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;

abstract class XotBasePanelProvider extends PanelProvider
{
    protected string $module;

    protected bool $topNavigation = false;

    protected bool $globalSearch = false;

    protected bool $navigation = true;

    public function panel(Panel $panel): Panel
    {
        $moduleNamespace = $this->getModuleNamespace();
        $moduleLow = Str::lower($this->module);
        $mainModuleLow = Str::lower(XotData::make()->main_module); // Renamed to camelCase
        $default = $mainModuleLow === $moduleLow;

        $panel = $panel
            ->default($default)
            ->login() // UNCOMMENTED
            // ->registration()
            ->passwordReset()
            // ->emailVerification()
            // ->profile()
            ->sidebarFullyCollapsibleOnDesktop();

        $panel = app(ApplyMetatagToPanelAction::class)->execute(panel: $panel);
        // ---------------------
        $panel->maxContentWidth('full')
            ->topNavigation($this->topNavigation)
            ->globalSearch($this->globalSearch)
            ->readOnlyRelationManagersOnResourceViewPagesByDefault(false)
            ->navigation($this->navigation)
            // ->tenant($teamClass)
            // ->tenant($teamClass,ownershipRelationship:'users')
            // ->tenant($teamClass)
            ->id($moduleLow.'::admin')
            ->path($moduleLow.'/admin')
            // Configure Filament discovery for module components (unconditional; dirs are expected to exist)
            ->discoverResources(
                base_path('Modules/'.$this->module.'/app/Filament/Resources'),
                sprintf('%s\\Filament\\Resources', $moduleNamespace),
            )
            ->discoverPages(
                base_path('Modules/'.$this->module.'/app/Filament/Pages'),
                sprintf('%s\\Filament\\Pages', $moduleNamespace),
            )
            ->discoverWidgets(
                base_path('Modules/'.$this->module.'/app/Filament/Widgets'),
                sprintf('%s\\Filament\\Widgets', $moduleNamespace),
            )
            ->discoverClusters(
                base_path('Modules/'.$this->module.'/app/Filament/Clusters'),
                sprintf('%s\\Filament\\Clusters', $moduleNamespace),
            )
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);

        return $panel;
    }

    protected function getModuleNamespace(): string
    {
        Assert::string($ns = config('modules.namespace'));

        return $ns.'\\'.$this->module;
    }
}
