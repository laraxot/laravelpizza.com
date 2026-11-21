<?php

declare(strict_types=1);

namespace Modules\Activity\Providers;

use Modules\Activity\Actions\Config\ApplyActivityConfigAction;
use Modules\Xot\Providers\XotBaseServiceProvider;
use Override;

/**
 * Service Provider per il modulo Activity.
 *
 * Gestisce la registrazione e il boot del modulo per il tracciamento delle attività utente.
 *
 * NON monta Folio: `Modules\Cms\Providers\FolioVoltServiceProvider` registra già
 * `resources/views/pages` (e `pages/api` → `/api`) per ogni modulo abilitato.
 * Montare qui le pagine con Folio è ridondante, anti-DRY e rischia l'ordine delle catch-all.
 *
 * @phpstan-type ModuleConfig array{name: string, alias: string, description: string, keywords: array<int, string>, priority: int, providers: array<int, class-string>}
 */
class ActivityServiceProvider extends XotBaseServiceProvider
{
    /**
     * Nome del modulo.
     */
    public string $name = 'Activity';

    /**
     * Directory del modulo.
     */
    protected string $module_dir = __DIR__;

    /**
     * Namespace del modulo.
     */
    protected string $module_ns = __NAMESPACE__;

    /**
     * Boot del service provider.
     *
     * Configura il modulo Activity e registra le configurazioni specifiche.
     */
    #[Override]
    public function boot(): void
    {
        parent::boot();

        // Registro solo le configurazioni specifiche del modulo
        $this->registerConfig();

        // Registra i componenti Blade personalizzati
        $this->registerBladeComponents();

        // ANTI-PATTERN: non registrare qui il mount Folio delle pagine del modulo.
        // Activity possiede i FILE pages/*; il mount Folio e' cross-cutting (Cms/FolioVolt
        // nei sibling FO). In PTVX Cms e' assente: non inventare un mini-FolioVolt nel dominio.
        // Vedi docs/bmad/stories/folio-routing-centralization.story.md

        // Le impostazioni salvate dal tenant (SettingPage) arrivano al pacchetto activitylog.
        app(ApplyActivityConfigAction::class)->execute();
    }

    /**
     * Registra le configurazioni del modulo.
     */
    #[Override]
    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->name, 'config/config.php') => config_path('activity.php'),
        ], 'config');

        $this->mergeConfigFrom(module_path($this->name, 'config/config.php'), 'activity');
    }
}
