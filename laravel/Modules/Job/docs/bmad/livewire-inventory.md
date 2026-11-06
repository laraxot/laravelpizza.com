---
title: "Inventario Http/Livewire → Filament widget: Job"
type: inventory
module: Job
status: verified
updated: 2026-09-22
track: campaign
related:
  - ./livewire-widget-conversion.md
  - ./livewire-widget-prd.md
  - ./livewire-widget-project-context.md
  - ./livewire-widget-decision-log.md
  - ./livewire-widget-epics.md
  - ../stories/12.1.retire-job-http-livewire.story.md
  - ../../../Cms/docs/bmad/livewire-inventory.md
  - ../../Xot/docs/bmad/livewire-inventory.md
tags: [docs, job, bmad]
qmd: "inventario: livewire http → filament   modulo job job"
---

# Inventario: Livewire HTTP → Filament: modulo Job

**Solo documentazione. Nessun PHP toccato in questo audit.**

Questo file è la SSoT del modulo Job per la campagna di conversione Livewire → Filament widget. Formato e metodo sono ripresi da [Modules/Cms/docs/bmad/livewire-inventory.md](../../../Cms/docs/bmad/livewire-inventory.md) e [Modules/Xot/docs/bmad/livewire-inventory.md](../../Xot/docs/bmad/livewire-inventory.md).

Differenza rispetto a Cms/Xot: in Job **esistono mount reali** (`<livewire:...>` in viste Blade), quindi la classificazione non è "tutto orfano": un componente è montato dentro una pagina del panel `job::admin`, gli altri solo in viste legacy `adm_theme` prive di renderer.

## Metodo (codice, non assunzione)

```bash
find Modules/Job/app/Http/Livewire -type f -name '*.php'
cat Modules/Job/app/Http/Livewire/_components.json
grep -rn "livewire:(job|schedule|broad)" laravel/ --include='*.blade.php'   # esclusi vendor/node_modules
grep -rn "@livewire" Modules/Job --include='*.blade.php' --include='*.php'
grep -rn "Modules\\\\Job\\\\Http\\\\Livewire" laravel/ --include='*.php'
grep -rn "registerRenderHook\|->renderHook(" Modules app --include='*.php'  # escluso vendor
find Modules/Job/app/Filament/Widgets -type f
find Modules/Job/app/Providers -type f -name '*.php'
ls Modules/Job/resources/views/pages                                       # Folio
cat Modules/Job/routes/web.php Modules/Job/routes/api.php
git status --short -- laravel/Modules/Job/app/Http/Livewire                # stato worktree vs HEAD
```

## Registro alias: piatto, globale, senza prefisso modulo

`Modules/Xot/app/Providers/XotBaseServiceProvider.php:140-145` chiama `registerLivewireComponents()` con `$prefix = ''` per ogni modulo. `RegisterLivewireComponentsAction.php:15-22` delega a `GetComponentsAction`, che calcola il nome con `Str::slug(Str::snake(...))` su path relativo + classe (`GetComponentsAction.php:83-95`) e lo registra via `Livewire::component($comp->name, $comp->ns)`: **registro globale piatto**, nessun namespace `job::`. La cache su disco è `Modules/Job/app/Http/Livewire/_components.json`.

Stato verificato di `_components.json` (2026-09-22): **3 alias**: `job.status` → `Modules\Job\Http\Livewire\Job\Status`, `schedule.crud` → `...\Schedule\Crud`, `schedule.status` → `...\Schedule\Status`. Nessun alias `broad`.

## Classi trovate (3 su disco; Broad ritirato)

### `Modules\Job\Http\Livewire\Broad`: ritirato

**Verificato 2026-09-22:** `app/Http/Livewire/Broad.php` assente; `resources/views/livewire/broad.blade.php` assente; `_components.json` elenca solo `job.status`, `schedule.crud`, `schedule.status`. `rg 'dd\\(' app/Http/Livewire` = zero. Story [12.1](../stories/12.1.retire-job-http-livewire.story.md) resta `done`.

Un audit del 21/09 aveva visto i tre artefatti tornare sul disco (restore vs HEAD). Lo stato attuale **non** li contiene.

### `Modules\Job\Http\Livewire\Job\Status`

File: `app/Http/Livewire/Job/Status.php` (189 righe), vista `resources/views/livewire/job/status.blade.php` (60 righe).

- `mount()` (righe 34-56) esegue `Artisan::call('queue:monitor')` e `worker:check`, conta `Job`/`FailedJob`/`JobBatch`, legge `QUEUE_CONNECTION` (Exception se `false`, riga 46).
- `render()` (righe 58-143) → `job::livewire.job.status`, passa `$acts` = lista di comandi `queue:*` (righe 62-135).
- `saveEnv()` (righe 154-171) **riscrive fisicamente `.env`**: `File::get`/`Str::replace`/`File::put` su `QUEUE_CONNECTION` + `putenv`: side effect distruttivo da HTTP.
- `artisan(string $cmd)` (righe 173-179) esegue `queue:{cmd}` arbitrario da una chiamata Livewire.
- `dummyAction()` (righe 181-188) accoda 1000 `DummyAction`.
- La vista espone il selettore connessione `wire:model.lazy="form_data.conn"` (riga 41) e i bottoni acts (righe 53-58).

Alias `job.status`. **Montato in una pagina Filament reale**: `resources/views/filament/pages/job-monitor.blade.php:7` (`<livewire:job.status>` dentro `<x-filament::page>`), vista della page `Modules\Job\Filament\Pages\JobMonitor` (`app/Filament/Pages/JobMonitor.php:11`), auto-scoperta dal panel `job::admin` via `discoverPages` (`XotBasePanelProvider.php:130-133`). Secondo mount nella vista legacy `admin/home.blade.php:9` (vedi tabella sotto: non raggiungibile).

### `Modules\Job\Http\Livewire\Schedule\Status`

File: `app/Http/Livewire/Schedule/Status.php` (101 righe), vista `resources/views/livewire/schedule/status.blade.php` (21 righe, usa `<x-filament::section>`: markup pensato per contesto Filament).

- `render()` (righe 26-71) → `job::livewire.schedule.status`; acts = `job:schedule-list`, `schedule:clear-cache|list|run|test|work`, `schedule-monitor:sync|list` (righe 30-63).
- `artisan(string $cmd)` (righe 73-79) esegue **qualsiasi** comando Artisan da HTTP: nessun whitelist a runtime oltre la lista `$acts` renderizzata.
- `getScheduledJobs()` (righe 84-100) legge `Schedule::events()`.

Alias `schedule.status`. Montato solo in viste legacy `adm_theme`: `admin/home.blade.php:12`, `admin/acts/schedule_status.blade.php:9`, `admin/acts/schedule_manager.blade.php:9`. Test: `tests/Unit/JobExecuteCoverage50Test.php:400` istanzia la classe e chiama `getScheduledJobs()`.

### `Modules\Job\Http\Livewire\Schedule\Crud`

File: `app/Http/Livewire/Schedule/Crud.php` (118 righe), vista `resources/views/livewire/schedule/crud.blade.php` (89 righe).

- `getFrequencies()` (righe 30-46) legge `config('totem.frequencies')`.
- `render()` (righe 48-63) → `job::livewire.schedule.crud` con `Task::paginate(20)` (riga 51).
- `taskCreate()` (righe 65-68) dispatch `modal.open` verso l'alias `modal.schedule.create`: **alias inesistente**: nessuna classe `Modal\Schedule\Create` sotto `Http/Livewire`, le 4 entry di `_components.json` non la coprono. Il bottone "New Task" della vista (riga 75) fallirebbe a runtime.
- La vista contiene markup rotto: `wire:click="executeTask('{{ $task-> }}')"` (riga 55): espressione Blade incompleta.
- `executeTask()` (righe 112-117) via `ExecuteTaskAction`; `getCommands()` (righe 75-110) enumera tutti i comandi Artisan.

Alias `schedule.crud`. Montato solo in `admin/home/acts/task.blade.php:8`: raggiungibile solo tramite la riscrittura `::panels.actions.*-action` → `::admin.home.acts.*` di `GetViewAction.php:67-71`, che richiede una classe `*Action` sotto `app/Filament/Panels/Actions/`: **in Job questa directory non esiste** (`find Modules/Job -type d -iname '*panel*'` = vuoto). Unico riferimento "panels" nel modulo è la stringa vista `filament-panels::resources.pages.list-records` in `ScheduleResource/Pages/ViewSchedule.php:33`, non correlata. Referenza documentale (non codice): `docs/components/schedule-crud-component.md:50`.

## Verifica del montaggio: tabella repo-wide

| Meccanismo | Dove si cerca | Esito |
|---|---|---|
| `<livewire:job.status>` | grep `livewire:(job|schedule|broad)` su tutto `laravel/` | 2 hit: `resources/views/filament/pages/job-monitor.blade.php:7` (**vivo**: è il body della Filament Page `JobMonitor` nel panel `job::admin`, path `job/admin`) e `resources/views/admin/home.blade.php:9` (legacy, vedi sotto) |
| `<livewire:schedule.status>` | idem | 3 hit, tutte viste legacy `adm_theme`: `admin/home.blade.php:12`, `admin/acts/schedule_status.blade.php:9`, `admin/acts/schedule_manager.blade.php:9` |
| `<livewire:schedule.crud>` | idem | 1 hit: `admin/home/acts/task.blade.php:8` (legacy, rewrite-only, irraggiungibile: vedi sopra) |
| `broad` (tag o `@livewire`) | idem + grep `broad` | **zero mount** in tutto il repo (solo falsi positivi vendor). Alias registrato ma mai montato |
| `@livewire(...)` | `grep -rn "@livewire" Modules/Job` | zero hit nel modulo (i chiamanti usano solo tag `<livewire:...>`) |
| FQCN | `grep "Modules\\Job\\Http\\Livewire"` | solo self-namespace, il test `JobExecuteCoverage50Test.php` (righe 35, 303, 400), la doc `docs/components/schedule-crud-component.md:50` e `coverage.xml` autogenerato |
| Render hook nel chrome Filament | `grep registerRenderHook/->renderHook( Modules app` (vendor escluso) | Unico hook: `XotBasePanelProvider.php:110-122`: script JS anti-bfcache scoped alla pagina Login, non monta componenti. Nessun altro provider Filament di Job esiste: `app/Providers/Filament/AdminPanelProvider.php` è 12 righe (solo `$module = 'Job'`, riga 11) |
| Rotta esplicita | `Modules/Job/routes/web.php`, `api.php` | `web.php` vuota (solo `declare(strict_types=1)`); `api.php` solo commenti. Nessuna rotta verso componenti Livewire |
| Folio/Volt | `Modules/Job/resources/views/pages` | **directory inesistente**. `FolioVoltServiceProvider` (Cms, righe 141-169) registra `<module>/resources/views/pages` per ogni modulo che ce l'ha: Job non contribuisce rotte Folio |
| Viste `admin/**` legacy | grep renderer di `job::admin.home` / `job::admin.acts.*` | **Nessun controller/rotta/provider le renderizza**: il modulo non ha controller (`app/Http/Controllers/` vuoto), l'unico `home.acts` del repo è la regola di riscrittura di `GetViewAction.php:68` (che copre solo `admin.home.acts.*`, non `admin.acts.*`, e solo da classi `panels.actions.*-action` assenti in Job). Inoltre estendono `adm_theme::layouts.app` e `register_adm_theme` è `false` in `Modules/Tenant/config/xra.php:16` |

Conclusione: **un solo mount vivo in tutto il modulo**: `job.status` dentro `JobMonitor`. Tutti gli altri tag `<livewire:...>` vivono in viste `admin/**` prive di qualsiasi punto di ingresso (stessa situazione documentata per `admin/acts/` nell'inventario Xot).

## Widget/pagine Filament esistenti nel modulo Job

`find Modules/Job/app/Filament/Widgets -type f` → 2 file:

| Classe | File | Contenuto | Montaggio |
|---|---|---|---|
| `ClockWidget` | `app/Filament/Widgets/ClockWidget.php` (112 righe) | `XotBaseWidget`, vista `job::filament.widgets.clock-widget` (riga 25), `beginProcess()` lancia `php artisan queue:listen --timeout=0` via `Process` (riga 37) | Auto-scoperto: `discoverWidgets` su `app/Filament/Widgets` (`XotBasePanelProvider.php:134-137`); referenziato anche da `JobStatus::getHeaderWidgets()` (`app/Filament/Pages/JobStatus.php:17-22`) |
| `QueueListenWidget` | `app/Filament/Widgets/QueueListenWidget.php` (112 righe) | Gemello strutturale di ClockWidget: `Process::start('php artisan queue:listen')` (riga 37), streaming via `$this->stream` | Auto-scoperto idem |

**Gemello funzionale rilevante: `Filament\Pages\JobStatus`** (`app/Filament/Pages/JobStatus.php`, 126 righe). È una `XotBasePage` nativa che replica il contratto di `Job\Status` Livewire: stesso metodo `artisan($cmd)` (righe 24-29), stessa tabella acts `queue:*` (righe 41-125, specchio di `Status.php:62-135`), header widget `ClockWidget` (righe 17-22). Differenze: non copre il selettore `QUEUE_CONNECTION`/`saveEnv` (scrittura `.env`) né `dummyAction()`; aggiunge `worker:check` e `route:list` (righe 116-123). È quindi un **gemello parziale: pagina, non widget**.

`ScheduleResource` (`app/Filament/Resources/ScheduleResource.php:37`, model `Schedule`) copre il CRUD delle schedule lato Filament ma **non** è un gemello di `Schedule\Crud` (che pagina `Modules\Job\Models\Task`, modello diverso) né di `Schedule\Status` (che è un Artisan-runner, non un CRUD).

## Classificazione

| Classe | Alias | Mount vivi | Gemello Filament | Cluster | Nota |
|---|---|---|---|---|---|
| `Http\Livewire\Broad` | `broad` | nessuno | nessuno | **C** | Orfano registrato con `dd('fine')` (riga 39). Ritiro già prescritto da story 12.1 ma **regredito su disco**: riaprire/verificare |
| `Http\Livewire\Job\Status` | `job.status` | `job-monitor.blade.php:7` (panel `job::admin`) | `Filament\Pages\JobStatus` (pagina, gemello parziale) | **B** | Duplicato da una Filament Page nativa: il componente HTTP va ritirato insieme a `JobMonitor`/`job-monitor.blade.php`, che senza di esso diventano ridondanti. La forma full-page e il rischio Artisan/.env escludono comunque la conversione in widget |
| `Http\Livewire\Schedule\Status` | `schedule.status` | nessuno (3 tag in viste legacy irraggiungibili) | nessuno | **C** | Artisan-runner `schedule:*`; mount solo in `admin/**` morte. Coperto dal test coverage, non da UI |
| `Http\Livewire\Schedule\Crud` | `schedule.crud` | nessuno (1 tag in vista rewrite-only irraggiungibile) | `ScheduleResource` = overlap parziale, modello diverso | **C** | Vista con Blade rotto (riga 55) e dispatch verso alias modale inesistente: di fatto dead code |

**Cluster A: zero candidati.** Nessun componente Job è montato in posizione chrome-widget (render hook, dashboard, header/footer widget). L'unico mount vivo (`job.status` in `JobMonitor`) occupa il **body intero di una pagina**, non uno slot widget: e il PRD vieta esplicitamente un Artisan-runner con `queue:clear`/`saveEnv` in un widget auto-scoperto (FR-J003, FR-J004 in [livewire-widget-prd.md](./livewire-widget-prd.md)).

**Cluster B: 1 candidato al ritiro.** `Job\Status` è duplicato dalla pagina Filament `JobStatus` (gemello funzionale parziale: manca il selettore connessione e `dummyAction`, entrambi valutabili come feature da portare o da abbandonare consapevolmente). La conversione non è "verso widget" ma "verso la pagina nativa già esistente": ritirare `Job\Status` + `JobMonitor` + `job-monitor.blade.php` quando il gap residuo è stato deciso.

**Cluster C: 3 componenti, esclusi.** `Broad` (orfano, P0 `dd`), `Schedule\Status` e `Schedule\Crud` (mount solo in viste legacy `adm_theme` senza renderer; shape = admin tool a tutto schermo, non frammento di chrome). Nessuno è un widget candidato.

## Verdetto

- **Zero story di conversione** (nessun candidato Cluster A reale), coerente col verdetto di Cms.
- **Una story di ritiro da riaprire**: 12.1 è `done` su carta ma il worktree è tornato allo stato pre-ritiro: `Broad.php`, `broad.blade.php`, alias `broad` in `_components.json` e il test originale sono tutti presenti e git-clean (ripristino del 21/09 ore 16:15). Il `dd('fine')` è di nuovo un P0 latente: alias registrato globalmente, trigger via evento Echo pubblico.
- **Candidato Cluster B documentato**: `Job\Status`/`JobMonitor` → `JobStatus` (pagina nativa). Gate: decidere il destino di `saveEnv` (scrittura `.env` da UI: probabilmente da non portare) e `dummyAction`.
- Follow-up igienico (non bloccante): le 5 viste `admin/**` con tag `<livewire:...>` sono irraggiungibili; `Schedule\Crud` ha vista rotta e dispatch verso alias inesistente.

## Riferimenti correlati (non SSoT, coerenti col verdetto)

- [livewire-widget-conversion.md](./livewire-widget-conversion.md): puntatore al canone
- [livewire-widget-architecture.md](./livewire-widget-architecture.md)
- [livewire-widget-brainstorming.md](./livewire-widget-brainstorming.md)
- [livewire-widget-decision-log.md](./livewire-widget-decision-log.md)
- [livewire-widget-epics.md](./livewire-widget-epics.md)
- [livewire-widget-prd.md](./livewire-widget-prd.md)
- [livewire-widget-product-brief.md](./livewire-widget-product-brief.md)
- [livewire-widget-project-context.md](./livewire-widget-project-context.md)
- [livewire-widget-tech-spec.md](./livewire-widget-tech-spec.md)
- [livewire-widget-ux.md](./livewire-widget-ux.md)
- [12.1.retire-job-http-livewire.story.md](../stories/12.1.retire-job-http-livewire.story.md): story di ritiro (stato da verificare, vedi regressione sopra)

## Successo

- [x] Inventario completo del modulo (4 classi, verificate riga per riga)
- [x] Verifica montaggio in tutto il repo: tag Blade, `@livewire`, FQCN, render hook, rotte, Folio/Volt
- [x] Alias derivati dal codice di registrazione reale (`_components.json` + `GetComponentsAction`), non assunti
- [x] Gemelli Filament verificati (`Widgets/` = `ClockWidget`, `QueueListenWidget`; pagina `JobStatus` = gemello parziale di `Job\Status`)
- [x] Nessuna story di conversione creata (zero candidati Cluster A); regressione story 12.1 segnalata invece di coperta
