<?php

declare(strict_types=1);

namespace Modules\Xot\Providers\Filament;

use Filament\Auth\Pages\Login;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Str;
use Illuminate\View\Middleware\ShareErrorsFromSession;
// Remove if not used elsewhere implicitly
use Modules\Xot\Actions\Filament\GetSidebarStateScriptAction;
use Modules\Xot\Actions\Panel\ApplyMetatagToPanelAction;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\AvatarProviders\InitialsAvatarProvider;
use Webmozart\Assert\Assert;

abstract class XotBasePanelProvider extends PanelProvider
{
    protected string $module;

    protected bool $topNavigation = false;

    protected bool $globalSearch = false;

    protected bool $navigation = true;

    /**
     * Id/path del panel. Di default derivano dal modulo ({modulo}::admin,
     * {modulo}/admin); i panel trasversali (operator, customer, supplier)
     * li sovrascrivono perché Filament vieta di ri-assegnare l'id dopo
     * la prima chiamata a ->id().
     */
    protected ?string $panelId = null;

    protected ?string $panelPath = null;

    /**
     * Scoperta automatica di resource, pagine, widget e cluster del modulo.
     *
     * I panel per utenti esterni (customer, supplier) la spengono: montano a mano
     * la manciata di schermate che quell'utente deve vedere, e non devono
     * ritrovarsi dentro le resource amministrative del modulo che li ospita solo
     * perche' stanno nella stessa cartella.
     */
    protected bool $discoverModuleComponents = true;

    /**
     * Sottocartella di `app/Filament` da cui scoprire i componenti.
     *
     * Null per il pannello admin del modulo (`app/Filament/Resources`, ...). Un pannello
     * trasversale ospitato dal modulo (es. 'Customer') scopre solo
     * `app/Filament/Customer/{Resources,Pages,Widgets,Clusters}`, cosi' non eredita le
     * resource amministrative e l'admin non eredita le sue.
     */
    protected ?string $componentsDirectory = null;

    /**
     * Tenancy Filament del pannello (https://filamentphp.com/docs/5.x/users/tenancy).
     *
     * Spenta per i pannelli di gestione; accesa per le aree in cui l'utente lavora
     * dentro un tenant (es. il cliente che vede solo i suoi dati). Il modello tenant
     * e' `XotData::getTenantClass()`, identificato nell'URL dallo slug.
     */
    protected bool $hasTenancy = false;

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
            // avatar predefinito generato in locale: il provider di Filament carica ui-avatars.com a ogni pagina (DCP-139)
            ->defaultAvatarProvider(InitialsAvatarProvider::class)
            ->sidebarFullyCollapsibleOnDesktop();

        $panel = app(ApplyMetatagToPanelAction::class)->execute(panel: $panel);
        // ---------------------
        $panel->maxContentWidth('full')
            ->topNavigation($this->topNavigation)
            ->globalSearch($this->globalSearch)
            ->readOnlyRelationManagersOnResourceViewPagesByDefault(false)
            ->navigation($this->navigation)
            ->id($this->panelId ?? $moduleLow.'::admin')
            ->path($this->panelPath ?? $moduleLow.'/admin')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            // Fix "This page has expired" (Livewire) sulla pagina di login:
            // riprodotto con evidenza che e' un vero 419 quando il browser
            // ripresenta (bfcache/"indietro") la pagina di login DOPO che la
            // sessione e' stata rigenerata altrove (es. login/logout riuscito
            // in un'altra tab) — il token CSRF/snapshot incorporato nella
            // pagina in cache non e' piu' valido. Cache-Control/Pragma sono
            // gia' corretti (Livewire::DisableBackButtonCacheMiddleware), ma
            // Chrome ripristina comunque le pagine dalla bfcache anche con
            // `no-store` dal 2021: qui forziamo un reload quando la pagina
            // viene ripristinata dalla bfcache, cosi' l'utente prende sempre
            // un token fresco invece di vedere il messaggio fuorviante.
            // Vedi Modules/Xot/docs/stories/login-page-expired-investigation-2026-09-11.story.md
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => <<<'HTML'
                    <script>
                        window.addEventListener('pageshow', function (event) {
                            if (event.persisted) {
                                window.location.reload();
                            }
                        });
                    </script>
                    HTML,
                scopes: Login::class,
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => app(GetSidebarStateScriptAction::class)->execute(),
            );

        if ($this->hasTenancy) {
            $panel->tenant(XotData::make()->getTenantClass(), slugAttribute: 'slug');
        }

        if ($this->discoverModuleComponents) {
            $path = base_path('Modules/'.$this->module.'/app/Filament');
            $namespace = $moduleNamespace.'\\Filament';
            if ($this->componentsDirectory !== null) {
                $path .= '/'.$this->componentsDirectory;
                $namespace .= '\\'.$this->componentsDirectory;
            }

            $panel
                ->discoverResources($path.'/Resources', $namespace.'\\Resources')
                ->discoverPages($path.'/Pages', $namespace.'\\Pages')
                ->discoverWidgets($path.'/Widgets', $namespace.'\\Widgets')
                ->discoverClusters($path.'/Clusters', $namespace.'\\Clusters');
        }

        return $panel;
    }

    protected function getModuleNamespace(): string
    {
        Assert::string($ns = config('modules.namespace'));

        return $ns.'\\'.$this->module;
    }
}
