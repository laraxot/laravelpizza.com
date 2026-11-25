---
title: "Widget, Livewire e grafici"
type: reference
module: UI
status: active
updated: 2026-11-25
qmd: "ui widget Filament XotBaseSchemaWidget DarkModeSwitcherWidget RedirectWidget Toast Livewire chartjs datalabels RawJs"
---

# Widget, Livewire e grafici

## Widget Filament (`app/Filament/Widgets/`, 12 file)

Tutti estendono basi `XotBase*` (`XotBaseSchemaWidget`, `XotBaseStatsOverviewWidget`, `XotBaseChartWidget`); gli audit
che segnalavano `StatsOverviewWidget`/`TestWidget` come estensioni dirette di Filament sono stati chiusi.

| Widget | Scopo |
|---|---|
| `DarkModeSwitcherWidget` | toggle chiaro/scuro: legge il cookie `dark_mode`, `toggleDarkMode()` lo riscrive (30 giorni) ed emette l'evento `darkModeUpdated`; `canView()` segue `UIConfigData::dark_mode_switcher_enabled` |
| `RedirectWidget` | bottone/link verso `$to` (con `$label`, `$icon`); pensato per i blocchi JSON dei contenuti (`"widget": "Modules\\UI\\Filament\\Widgets\\RedirectWidget"`, `"to": "/admin"`) |
| `UserCalendarWidget` | calendario utente: il form degli eventi arriva da Action convenzionali `Modules\<M>\Actions\...\Calendar\<Nome>Action` (`getActionName()`); dipende da `saade/filament-fullcalendar`, non compatibile con Filament 5: `ApplyCalendarToPanelAction` e' disabilitata (`.disabled`) |
| `StatsOverviewWidget`, `HeroWidget` | statistiche (`XotBaseStatsOverviewWidget`) |
| `StatWithIconWidget`, `OverlookWidget`, `GroupWidget`, `RowWidget` (astratto) | layout e riquadri (`ui::filament.widgets.*`) |
| `ToastWidget` | contenitore toast (vista `ui::filament.widgets.toast`), eredita il ruolo del vecchio `Http\Livewire\Toast` |
| `TestWidget`, `TestChartWidget` | fixture di prova |

Le impostazioni di UI per tenant (`config/{tenant}/ui.php`) sono il DTO `Datas\UIConfigData`, modificabile dalla
`Filament\Pages\SettingPage` (solo super-admin; oggi un solo toggle, `dark_mode_switcher_enabled`). I default sono i
valori che prima stavano nel codice: nulla cambia finche' nessuno salva.

## Livewire HTTP: stato e decisioni

- Regola emersa dall'inventario "Livewire -> widget Filament" (story 12.1): **un gemello gia' esistente batte una classe
  nuova**. Il toggle tema ha il gemello `DarkModeSwitcherWidget`; `ThemeToggleWidget` e `ToastNotificationWidget` non
  vanno creati (toast del pannello = Filament Notifications).
- `Toast` e' montato come `<livewire:toast />` nel layout principale del modulo User
  (`Modules/User/resources/views/components/layouts/main.blade.php`) e nello stub `layouts/main.blade.php.stub` di UI:
  non e' orfano. I componenti Livewire dei moduli sono scoperti da `Xot\Actions\File\GetComponentsAction`, che
  produce i `_components.json`.
- Osservato oggi: sotto `app/Http/Livewire/` sono rientrati `DarkModeSwitcher.php` e `Toast.php` (il primo era stato
  ritirato dalla 12.1 e riappare dal merge del remoto); `_components.json` li elenca entrambi. Da ritirare di nuovo
  `DarkModeSwitcher` quando si autorizza la cancellazione.
- `InteractiveMap` non e' un widget UI: vedi [scope-and-boundaries.md](scope-and-boundaries.md) (resta come
  `InteractiveMap.php.old`).
- I form si costruiscono solo con componenti Filament; i widget non contengono logica di business (Actions).

## Grafici (Chart.js in Filament 5)

Nel modulo c'e' solo `TestChartWidget` (`XotBaseChartWidget`); non esistono classi di export dei grafici in `app/`.
Regole raccolte dalle guide, valide per chi scrive un `ChartWidget`:

- **plugin Chart.js**: Filament non li include. Si installano nel bundle che costruisce gli asset, si registrano in
  `resources/js/filament-chart-js-plugins.js` con `window.filamentChartJsPlugins ??= []` e `push(Plugin)` (mai
  sovrascrivere l'array), il file va nell'`input` di Vite e l'asset si registra con `FilamentAsset::register()`
  **una sola volta** nel provider del pannello. Il progetto centralizza `chartjs-plugin-datalabels` nel modulo `Chart`
  (non presente in questo tree): UI e gli altri moduli non duplicano la registrazione.
- **datalabels**: i default stanno in `options.plugins.datalabels.*`; piu' etichette per punto in
  `options.plugins.datalabels.labels.*` oppure `datasets[n].datalabels.labels.*`; `labels` nel posto sbagliato non
  rende nulla.
- **callback JavaScript** (`formatter`, ecc.): solo con `RawJs::make('...')` restituito da `getOptions()`; un callable
  PHP viene serializzato come stringa o perso.
- **export PNG**: lato client via `canvas.toDataURL('image/png')` e bottone nella vista del widget; lato server serve un
  browser headless (`spatie/browsershot` + puppeteer) in una Queueable Action; su shared hosting senza Node l'unica via
  e' un servizio remoto tipo QuickChart (i dati lasciano il server: mai per dati personali o riservati, oppure
  self-host).
- sintomo "nessuna etichetta": plugin non installato nel bundle giusto, file non costruito da Vite, asset non registrato
  dal pannello.
