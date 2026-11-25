---
title: "Scopo e confini del modulo UI"
type: reference
module: UI
status: active
updated: 2026-11-25
qmd: "ui module purpose scope dependency rules Geo boundary Xot User InteractiveMap LocationSelector Null adapters"
---

# Scopo e confini del modulo UI

## Cosa e' UI

Libreria condivisa di componenti di interfaccia: campi form, colonne tabella, widget, blocchi del page builder,
componenti Blade/Livewire, icone SVG, layout. Non conosce il dominio applicativo di nessun altro modulo. Alias `ui`,
namespace `Modules\UI\` -> `app/`, provider `UIServiceProvider` (minimo, solo `getComponentViewPath()`) e
`Filament\AdminPanelProvider`. `module.json` richiede `Xot` e `User`.

Filosofia e regole di sviluppo: [philosophy.md](philosophy.md). Architettura e convenzioni:
[architecture.md](architecture.md), [conventions.md](conventions.md).

## Direzione delle dipendenze

```
Xot  <-  UI  <-  (Geo, User, Tenant, Activity, Cms, Notify, ... e i temi)
```

`X <- Y` significa "Y dipende da X". Stato verificato sul codice (`use Modules\...` in `app/`): 103 riferimenti a
`Modules\Xot`, 34 a `Modules\UI`, **1** a `Modules\User` (`UserData`, vedi sotto), **0** a `Geo`, `Tenant`, `Cms`.

| Modulo | puo' usare UI | UI puo' usare |
|---|---|---|
| Xot | si | si (classi base `XotBase*`, Actions) |
| User | si | solo `UserData` |
| Cms | si | no: la delega e' a runtime e opzionale ([blocks-and-cms.md](blocks-and-cms.md)) |
| Geo, Tenant, Activity, Notify, Media | si | no |

Regola operativa: se un componente ha bisogno di un modello o di un servizio di un modulo di dominio, **appartiene a
quel modulo** (che puo' usare le primitive di UI), non a UI. Niente `class_exists()` ne' stub per aggirare l'import.

## Confine con Geo

- `LocationSelector` (cascata regione/provincia/CAP via `Modules\Geo\Models\Comune`) e' stato rimosso da UI con le sue
  lingue; `tests/AuditCoverage/` (74 stub `assertTrue`) idem. Se serve, vive in Geo.
- `InteractiveMap` (mappa Livewire con marker, filtri, export, geocoding) importava cinque Action Geo mai
  implementate e nessuno lo montava: resta solo come `app/Livewire/Components/Map/InteractiveMap.php.old` (non
  autoloadato). Una mappa interattiva futura si costruisce in `Modules/Geo` con Action reali; i temi la consumano, UI
  al massimo da' le primitive visuali. Mai il contrario.
- `app/Contracts/{MapServiceContract,GeocodingServiceContract}` con gli adapter `app/Adapters/Map/Null*Adapter`
  sono astratti e non dipendono da Geo, ma **nessun provider li lega al container**: `UIServiceProvider` non ha
  binding (lo dichiara nel commento). `app(MapServiceContract::class)` solleva errore di risoluzione, non restituisce
  un fallback; chi vuole il null object deve aggiungere il binding. (Una vecchia pagina sosteneva il contrario ed e'
  stata corretta il 2026-11-20.)

## Residui on-disk (nessuna cancellazione senza autorizzazione)

Rientrati dai merge del remoto, marcati `SUPERSEDED`/`@deprecated`, senza caller:

- `app/Services/{ComponentService,ThemeService,UIService}.php` e `app/Services/Map/Null*Service.php`: classi vuote;
  i canonici sono `Xot\Actions\File\AssetAction` e `Adapters/Map/Null*ServiceAdapter`. Mappatura Services -> Actions:
  [wiki/concepts/ui-services-support-to-actions.md](wiki/concepts/ui-services-support-to-actions.md).
- `app/Data/UserData.php`: duplicato di `app/Datas/UserData.php` (la cartella `Data/` e' vietata da
  `DatasFolderConventionTest`; `GetUserDataAction` usa la versione in `Datas/`).
- `app/Http/Livewire/DarkModeSwitcher.php` (gemello: `DarkModeSwitcherWidget`, vedi [widgets.md](widgets.md)),
  `app/Actions/Panel/ApplyCalendarToPanelAction.php.disabled`, `app/Http/Kernel.php.no`.

## Dove vive il resto

| Argomento | Casa |
|---|---|
| Frontoffice, temi, compilazione asset | Cms e `Themes/<Tema>` ([themes-and-layouts.md](themes-and-layouts.md)) |
| Traduzioni | Lang ([translations.md](translations.md)) |
| Mappe, geocoding, GIS | Geo |
| Stati di dominio (`spatie/laravel-model-states`) | Xot/modulo di dominio; UI ha solo `SelectState`/`SelectStateColumn` |
