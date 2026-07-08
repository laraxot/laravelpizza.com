<?php

declare(strict_types=1);

namespace Modules\UI\Providers;

use Modules\Xot\Actions\Module\GetModulePathByGeneratorAction;
use Modules\Xot\Providers\XotBaseServiceProvider;

/**
 * Service Provider per il modulo UI.
 *
 * Nota: la registrazione dei Blade components modulari avviene tramite GetModulePathByGeneratorAction
 * per garantire la corretta risoluzione dei path secondo la struttura dei moduli.
 *
 * @phpstan-type ModuleConfig array{name: string, alias: string, description: string, keywords: array<int, string>, priority: int, providers: array<int, class-string>}
 */
class UIServiceProvider extends XotBaseServiceProvider
{
    /**
     * Nome del modulo.
     */
    public string $name = 'UI';

    /**
     * Directory del modulo.
     */
    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    /**
     * Registra i servizi del provider.
     *
     * Lega i contratti mappa/geocoding ai fallback Null di default. Quando il
     * modulo Geo sarà installato, sostituire il binding qui senza toccare
     * InteractiveMap (vedi docs/wiki/concepts/block-rendering-and-optional-services.md).
     */
    public function register(): void
    {
        parent::register();

        $this->app->singleton(
            \Modules\UI\Contracts\MapServiceContract::class,
            \Modules\UI\Services\Map\NullMapService::class,
        );
        $this->app->singleton(
            \Modules\UI\Contracts\GeocodingServiceContract::class,
            \Modules\UI\Services\Map\NullGeocodingService::class,
        );
    }

    /**
     * Boot del service provider.
     *
     * Configura i componenti Blade e altre funzionalità del modulo UI.
     *
     * @return void
     */

    /**
     * Restituisce il percorso delle viste dei componenti UI.
     */
    public function getComponentViewPath(): string
    {
        return app(GetModulePathByGeneratorAction::class)->execute($this->name, 'component-view');
    }
}
