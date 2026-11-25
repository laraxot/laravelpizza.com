---
title: "Struttura minima dei ServiceProvider di modulo"
type: rule
status: active
module: Xot
qmd: "service provider minimal XotBaseServiceProvider module_dir module_ns boot register Override RouteServiceProvider EventServiceProvider panel provider module.json"
updated: 2026-11-25
---

# Struttura minima dei ServiceProvider di modulo

**Un provider di modulo dichiara solo identita' e posizione; il resto lo fa la base.** Aggiungere `boot()` o `register()` e' ammesso solo se c'e' logica propria.

## Il provider principale

```php
namespace Modules\Meetup\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class MeetupServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Meetup';            // PascalCase, obbligatorio (vuoto => eccezione)
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}
```

Cosa fa gia' `XotBaseServiceProvider` (`app/Providers/XotBaseServiceProvider.php`):

- `boot()`: traduzioni (`registerTranslations`), config (`registerConfig`), view (`registerViews`), migrazioni (`database/migrations` del modulo),
  componenti Blade (`registerBladeComponents`), comandi console (`registerCommands`), asset pubblici (`registerPublicAssets`);
- `register()`: calcola `nameLower`, registra `<Modulo>\Providers\RouteServiceProvider` e `<Modulo>\Providers\EventServiceProvider`, registra le icone Blade
  (`registerBladeIcons`: l'icon set del modulo, i file SVG vivono in `resources/svg/`).

Quindi: **non** ridefinire `registerViews`, `registerTranslations`, `registerConfig`, `registerCommands` nel modulo, e non scrivere un `boot()` che chiama solo
`parent::boot()`.

## Quando si fa override

```php
#[\Override]
public function register(): void
{
    parent::register();                 // sempre per primo
    $this->app->tag([ListEventSitemapPathsAction::class], SitemapPathsContract::TAG);   // esempio reale del modulo Meetup
}
```

Regole: `parent::boot()`/`parent::register()` come prima istruzione, attributo `#[\Override]`, nessuna logica di dominio che appartiene a un'Action.

## Provider collegati

| Classe | Base | Proprieta' richieste |
|---|---|---|
| `RouteServiceProvider` | `XotBaseRouteServiceProvider` | `$name`, `$moduleNamespace` (`Modules\<M>\Http\Controllers`), `$module_dir`, `$module_ns`. La base carica `routes/web.php` (middleware `web`) e `routes/api.php` (prefisso `api`); con `$name` vuoto notifica/lancia errore. |
| `EventServiceProvider` | `XotBaseEventServiceProvider` | `$listen = []` e `static $shouldDiscoverEvents = true` (gia' i default della base: basta la classe vuota). |
| `Filament\AdminPanelProvider` | `XotBasePanelProvider` | `protected string $module = '<Modulo>'`; `panel(Panel $panel)` chiama `parent::panel($panel)`. |
| `XotBaseThemeServiceProvider` | per i temi | `$name`, `$module_dir`, `$module_ns`. |

## Doppia registrazione

Ogni modulo elenca i provider **sia in `module.json` sia in `composer.json`** (`extra.laravel.providers`), almeno il provider principale e l'`AdminPanelProvider`
(Meetup: `MeetupServiceProvider`, `EventServiceProvider`, `Filament\AdminPanelProvider`; Xot: `XotServiceProvider`, `Filament\AdminPanelProvider`). Le due liste devono
coincidere: nwidart legge `module.json`, l'autodiscovery di Composer legge `composer.json`.

## Guardie

- Provider senza metodi inutili: revisione di codice (`grep -n "parent::boot();" -B3` dentro un metodo che non aggiunge altro).
- `tests/Arch/ArchitectureTest.php` (famiglie XotBase) e le guardie sulla struttura del modulo in [module-structure.md](module-structure.md).

## Vedi anche

- [xotbase-extension-rules.md](xotbase-extension-rules.md)
- [adr/0009-laravel-bootstrap-provider-registry.md](adr/0009-laravel-bootstrap-provider-registry.md): bootstrap Laravel minimale e discovery dei moduli
