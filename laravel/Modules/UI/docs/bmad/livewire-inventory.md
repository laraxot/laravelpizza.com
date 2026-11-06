---
title: "Inventario UI: Livewire HTTP → Filament widget"
type: inventory
module: UI
status: implemented
related:
  - ./livewire-widget-prd.md
  - ./livewire-widget-architecture.md
  - ./livewire-widget-tech-spec.md
  - ./livewire-widget-epics.md
  - ./livewire-widget-decision-log.md
  - ./livewire-widget-product-brief.md
  - ./livewire-widget-conversion.md
  - ../../Xot/docs/bmad/livewire-widget-project-context.md
  - ../../../User/docs/bmad/livewire-inventory.md
  - ../stories/12.1.retire-ui-http-livewire.story.md
  - ../../Xot/docs/bmad/livewire-to-filament-widgets-inventory.md
  - ../../Xot/docs/bmad/stories/livewire-to-filament-widgets-fleet.story.md
updated: 2026-10-20
tags: [docs, ui, bmad]
qmd: "inventario ui: livewire http → filament widget ui"
---

# Inventario UI: Livewire HTTP → Filament widget

Questo file è la SSoT per il modulo UI sul tema "conversione Livewire → widget Filament". Story **12.1 implementata**: ritirato l'HTTP `DarkModeSwitcher`; `Toast` resta. Allineamento fleet **W0 ✓** (2026-10-20): [inventario Xot](../../Xot/docs/bmad/livewire-to-filament-widgets-inventory.md) · [fleet story](../../Xot/docs/bmad/stories/livewire-to-filament-widgets-fleet.story.md): panel-first **REUSE**, niente HTTP orfani per il chrome tema. Gli altri documenti in `docs/bmad/` che trattano lo stesso argomento vanno letti come satelliti di questo, non come fonti alternative (vedi la sezione "Correzione" più sotto).

## Metodo

Dopo il ritiro 12.1, `app/Http/Livewire` contiene solo `Toast.php`; esiste però anche una classe Livewire **fuori** dal percorso `Http/`, sotto `app/Livewire/Components/Map/`:

```bash
find laravel/Modules/UI/app/Http/Livewire -name '*.php'
# Modules/UI/app/Http/Livewire/Toast.php
find laravel/Modules/UI/app/Livewire -name '*.php'
# Modules/UI/app/Livewire/Components/Map/InteractiveMap.php (+ .old)
grep -rn "InteractiveMap\|interactive-map" --include="*.php" --include="*.blade.php" .
```

Per ciascuna sono stati verificati, sul codice e non a memoria: il contenuto integrale della classe, il montaggio (alias `@livewire('...')`, tag `<livewire:.../>` o `Livewire::component()`), l'eventuale hook nel panel provider Filament del modulo, e l'esistenza di un gemello sotto `app/Filament/Widgets`.

```bash
cat laravel/Modules/UI/app/Providers/Filament/AdminPanelProvider.php
grep -rn "registerRenderHook\|RenderHook" laravel/Modules/UI/app
grep -rn "<livewire:toast\|<livewire:dark-mode\|@livewire('toast'\|@livewire('dark-mode" laravel --include="*.blade.php"
grep -rln "DarkModeSwitcherWidget" laravel --include="*.php" --include="*.blade.php"
```

Risultato: `Modules/UI/app/Providers/Filament/AdminPanelProvider.php` (righe 12-41) non registra nessun `registerRenderHook`; si limita a `return parent::panel($panel);` alla riga 19, col resto del metodo commentato. Il modulo UI **non ha alcun hook di chrome Filament attivo**: questo esclude a priori il Cluster A (nessuna classe montata via render hook nel panel provider).

## Le classi

### `Http\Livewire\Toast` (`Modules/UI/app/Http/Livewire/Toast.php`, 25 righe, letta per intero)

Componente minimo: nessuna property, nessun metodo di business, `render()` (righe 16-24) ritorna `view('ui::livewire.toast')` senza parametri utili. La sua vista dedicata è `Modules/UI/resources/views/livewire/toast.blade.php` (50 byte).

Il montaggio reale non è un hook di panel, ma un tag Blade diretto: `Modules/UI/resources/views/components/layouts/main.blade.php:28` contiene `<livewire:toast />`, dentro il `<body>` del layout HTML di base del modulo. Questo layout è la radice di tutta la catena dei layout front‑office di UI: `Modules/UI/resources/views/components/layouts/guest.blade.php:6`, `marketing.blade.php:6`, `auth-split.blade.php:6` e `app.blade.php:6` avvolgono tutti `<x-layouts.main>`, che Laravel risolve proprio su `Modules/UI/resources/views/components/layouts/main.blade.php`. La stessa risoluzione è condivisa fuori modulo: le pagine Folio di `Themes/Zero/resources/views/pages/home.blade.php:1` e `auth/login.blade.php:1`, e le pagine auth del modulo User (`Modules/User/resources/views/pages/auth/verify.blade.php:35`, `password/reset.blade.php:38`, `password/[token].blade.php:55`, `password/confirm.blade.php:29`) aprono tutte con `<x-layouts.main>`.

Secondo punto di montaggio verificato: `Modules/User/resources/views/components/layouts/main.blade.php:49` ha anch'esso `<livewire:toast />` (accanto a `@livewire('notifications')`, riga 50): l'alias `toast` risolve su `Modules\UI\Http\Livewire\Toast`, unica classe con quel nome registrata in tutto il repo (`Modules/UI/app/Http/Livewire/_components.json`).

In altre parole: `Toast` non è affatto orfano. È il contenitore delle notifiche toast lato front‑office, montato una volta sola nel layout HTML radice e quindi presente, per costruzione, su ogni pagina pubblica che usa i layout del modulo UI. Non è un caso isolato dimenticato: è infrastruttura di layout.

Il meccanismo che rende disponibile il tag `<livewire:toast />` senza una registrazione manuale per-modulo è `Modules/Xot/app/Actions/Livewire/RegisterLivewireComponentsAction.php:20` (`Livewire::component($comp->name, $comp->ns)`), che scopre e registra automaticamente ogni classe sotto `Http/Livewire` di ciascun modulo. La cache `_components.json` dopo 12.1 contiene solo `toast`.

### `Http\Livewire\DarkModeSwitcher`: **ritirato** (story 12.1)

Classe e vista rimosse: `app/Http/Livewire/DarkModeSwitcher.php` e `resources/views/livewire/dark-mode/switcher.blade.php`. La cache `app/Http/Livewire/_components.json` elenca solo `toast`. Il namespace originale era `Modules\Ui\Http\Livewire` (i minuscola): grep repo-wide su quel FQCN deve restare a zero.

**Il gemello esiste già ed è funzionalmente equivalente**, non va scritto da zero:

- `Modules/UI/app/Filament/Widgets/DarkModeSwitcherWidget.php` (namespace `Modules\UI\Filament\Widgets`, riga 5) estende `XotBaseSchemaWidget` (riga 12). Riproduce la stessa logica: `mount()` righe 20-23 legge lo stesso cookie `dark_mode`; `toggleDarkMode()` righe 25-34 la stessa inversione più `Cookie::queue()` (riga 30) e lo stesso evento `darkModeUpdated` (riga 33); `canView()` righe 49-52 la rende disattivabile via `config('ui.dark_mode_switcher.enabled', true)`: chiave che oggi non è definita in nessun file sotto `Modules/UI/config/`, quindi il widget è sempre visibile per default finché nessuno aggiunge quella config.
- `Modules/UI/app/View/Components/DarkModeSwitcher.php` (letta per intero) è un componente Blade che avvolge esplicitamente il widget: il docblock alla riga 14 lo dichiara ("Wrappa il DarkModeSwitcherWidget per l'uso nei temi tramite sintassi Blade"), il costruttore istanzia `new DarkModeSwitcherWidget()` (righe 28-29, con una duplicazione dell'istanziazione che è probabilmente un refuso ma non tocca la classificazione), e `render()` (righe 35-46) verifica `DarkModeSwitcherWidget::canView()` (riga 38) prima di restituire la vista condivisa `ui::filament.widgets.dark-mode-switcher` (riga 45).

**Nessuno dei due gemelli è oggi effettivamente montato**: nessun `<livewire:dark-mode` nel repo, `DarkModeSwitcherWidget::class` non compare in nessun `getWidgets()`/`getHeaderWidgets()`, nessun `<x-dark-mode-switcher` nei template. Il test `UiGapCloser100Test` ora istanzia `DarkModeSwitcherWidget` (`mount`/`toggleDarkMode`/`render`); `Toast` resta invariato. Collegare il widget a un punto di montaggio reale resta fuori da 12.1.

### `Livewire\Components\Map\InteractiveMap` (`Modules/UI/app/Livewire/Components/Map/InteractiveMap.php`, 380 righe, letta per intero)

Terza classe Livewire del modulo, ma **fuori da `Http/Livewire`**: namespace `Modules\UI\Livewire\Components\Map` (riga 5), `final class` (riga 20). È un componente di contenuto completo: mappa interattiva con marker, filtri, ricerca indirizzi, export csv/geojson/kml: non chrome.

Verifica di registrazione e montaggio, tutti i canali a zero:

- **Non auto-registrata**: `RegisterLivewireComponentsAction` scansiona solo `$module_dir/../Http/Livewire` (`Modules/Xot/app/Providers/XotBaseServiceProvider.php:143-144` → `RegisterLivewireComponentsAction.php:17`). `app/Livewire/` non è coperto e non ha un proprio `_components.json`.
- **Nessuna registrazione manuale**: zero `Livewire::component(...)` attivi in tutto il repo fuori dall'action di discovery.
- **Zero chiamanti**: `grep -rn "InteractiveMap\|interactive-map" --include="*.php" --include="*.blade.php" .` trova solo la classe stessa, la sua vista e l'artefatto IDE `.phpstorm.meta.php`. Nessun `<livewire:...>`, `@livewire(...)`, rotta o pagina Folio la raggiunge.
- **Vista esistente**: `Modules/UI/resources/views/livewire/components/map/interactive-map.blade.php` (454 righe): a differenza di Media `Clip`, qui la vista c'è; manca il montaggio, non la vista.
- **Dipendenze assenti**: importa `Modules\Geo\Services\GeocodingService` e `MapService` (righe 9-10, usati a righe 140, 169, 201, 249), ma `Modules/Geo/app` non ha alcuna directory `Services`: ogni `app(MapService::class)` è marcato `@phpstan-ignore-next-line class.notFound`. Se montata, `loadMarkers()` (righe 134-152) cadrebbe nel `catch` a runtime. La violazione di confine Geo è già documentata in `../stories/7.15-interactivemap-geo-boundary-violation.story.md`.
- **Artefatto `.old`**: `InteractiveMap.php.old` (382 righe, diverso dal `.php`) convive nella stessa cartella: ulteriore segno di codice sperimentale non consolidato.

È quindi un componente **non registrato e non montato**: orfano puro, stesso caso di Media `Clip`: con la complicazione ulteriore delle dipendenze mancanti.

## Classificazione

### Cluster A: montato via render hook nel chrome Filament

Nessuna classe. `Modules/UI/app/Providers/Filament/AdminPanelProvider.php` non registra alcun `registerRenderHook` (vedi Metodo, sopra); non c'è quindi nessun candidato reale a un nuovo `XotBaseWidget` per aggancio a un hook di panel.

### Cluster B: gemello Filament già esistente, si ritira solo l'HTTP orfano

| Classe | Gemello | Evidenza |
|---|---|---|
| `Http\Livewire\DarkModeSwitcher` | `Filament\Widgets\DarkModeSwitcherWidget` + `View\Components\DarkModeSwitcher` | **Ritirato** (12.1): PHP + vista HTTP cancellati; gemelli Filament/Blade invariati; test puntato al widget |

La storia collegata è `12.1.retire-ui-http-livewire.story.md` (implementata): HTTP ritirato, test sul widget, gemelli non toccati.

### Cluster C: componente strutturale, non candidato widget

| Classe | Perché è esclusa | Evidenza |
|---|---|---|
| `Http\Livewire\Toast` (`Modules/UI/app/Http/Livewire/Toast.php`) | Non è chrome di un panel Filament: è montata con `<livewire:toast />` dentro il layout HTML di base del front‑office (`Modules/UI/resources/views/components/layouts/main.blade.php:28`), ereditato da tutti i layout e da pagine Folio/altri moduli, e nel layout `main` del modulo User (`Modules/User/resources/views/components/layouts/main.blade.php:49`). Nessun panel provider la registra come hook, nessun widget la sostituisce | `main.blade.php:28`; catena `guest.blade.php:6`, `marketing.blade.php:6`, `auth-split.blade.php:6`, `app.blade.php:6`; `Themes/Zero/.../home.blade.php:1`, `.../auth/login.blade.php:1`; `Modules/User/resources/views/pages/auth/*.blade.php`; `Modules/User/.../layouts/main.blade.php:49` |
| `Livewire\Components\Map\InteractiveMap` (`Modules/UI/app/Livewire/Components/Map/InteractiveMap.php`) | Componente di contenuto (mappa full-feature con filtri/export/geocoding), non chrome di panel: e in più **non registrato** (fuori da `Http/Livewire`, nessun `Livewire::component`) e **non montato** (zero hit repo-wide). Dipendenze `Modules\Geo\Services\*` assenti: cadrebbe a runtime. Orfano puro, stesso caso di Media `Clip` | `XotBaseServiceProvider.php:143-144`; `RegisterLivewireComponentsAction.php:17`; grep `InteractiveMap` → solo self+vista+meta; `Modules/Geo/app` senza `Services/`; story 7.15 |

Ritirare `Toast` in questa campagna sarebbe un errore: toglierebbe il contenitore delle notifiche a tutte le pagine pubbliche che passano dai layout di UI. Non è nemmeno un candidato a `XotBaseWidget`, perché i widget Filament vivono dentro un panel, mentre questo componente serve il front‑office indipendentemente da Filament. Nessuna azione richiesta oltre a questa nota.

## Correzione rispetto ai documenti precedenti del modulo

Prima di scrivere, questo file (nella sua versione precedente) e diversi satelliti nella stessa cartella affermavano che `Toast` fosse orfano o "senza chiamanti", proponendo di cancellarlo insieme a `DarkModeSwitcher`. Il grep usato in quei documenti (`grep 'ui::livewire.toast'` in `livewire-widget-tech-spec.md`) verificava solo il nome della vista, non il tag di montaggio `<livewire:toast` nei layout: per questo l'uso reale in `main.blade.php:28` era sfuggito. Sono stati corretti in questa sessione, riportando il riferimento a questo file come SSoT invece di ripetere l'affermazione errata:

- `livewire-widget-architecture.md`: la riga `Toast HTTP → delete (orfano)` era falsa; corretta.
- `livewire-widget-tech-spec.md`: la condizione "se solo self, delete" non si verifica: esiste un chiamante reale; corretta.
- `livewire-widget-epics.md`: la riga dell'epic 12.1 citava "Toast orfano"; corretta.
- `livewire-widget-product-brief.md`: "Toast orfano escono" e la metrica "`app/Http/Livewire` vuoto" erano sbagliate (il file resta, la directory non sarà vuota); corretta.
- `livewire-widget-decision-log.md`: aggiunta una voce che registra la correzione con data.
- `../stories/12.1.retire-ui-http-livewire.story.md`: titolo e Acceptance Criteria includevano il ritiro di `Toast`; corretti per limitare lo scope a `DarkModeSwitcher`.

`livewire-widget-conversion.md` (rinominato da `LIVEWIRE-WIDGET-CONVERSION.md` da una sessione concorrente su questo stesso modulo) era già marcato `status: superseded-stale` con puntatore a questo file: non necessita ulteriori modifiche, ma la sua diagnosi di fondo (niente `ThemeToggleWidget`/`ToastNotificationWidget` nuovi, perché un gemello Filament di `DarkModeSwitcher` esiste già) resta corretta e concorde con quanto verificato qui.

`livewire-widget-prd.md` (FR-UI-002: "HTTP Toast assente se nessun chiamante") non necessita correzioni: è formulato come condizione, e la condizione ("nessun chiamante") qui risulta verificata come falsa, quindi il requisito semplicemente non si applica: non prescrive comunque il ritiro.

## Riepilogo

- 1 classe Livewire HTTP rimasta: `Toast` (Cluster C, chrome front-office, non ritirare: montata in `UI main.blade.php:28` e `User main.blade.php:49`).
- 1 classe Livewire fuori da `Http/` non registrata né montata: `InteractiveMap` (Cluster C / orfano puro; dipendenze `Geo\Services\*` assenti; esclusa, eventuale rimozione in story di pulizia separata).
- Cluster A: 0. Cluster B: `DarkModeSwitcher` HTTP **ritirato** (12.1); gemello `DarkModeSwitcherWidget` invariato.
- `UI/resources/views/filament/widgets/{group,row,test-widget}` montano già FQCN via `$widget['class']`: corretti, non toccare.
