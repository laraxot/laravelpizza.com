---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire inventory"
issues: []
discussions: []
title: "Inventario Http/Livewire → Filament widget — Cms"
type: inventory
module: Cms
status: approved
track: campaign
related:
  - ./livewire-widget-conversion.md
  - ./livewire-widget-project-context.md
  - ./livewire-widget-decision-log.md
  - ./livewire-widget-epics.md
  - ../stories/12.1.cms-page-show-not-widget.story.md
  - ../../../User/docs/bmad/livewire-inventory.md
---

# Inventario: Livewire HTTP → Filament — modulo Cms

**Solo documentazione. Nessun PHP toccato in questo audit.**

Questo file è la SSoT del modulo Cms per la campagna di conversione Livewire → Filament widget. Formato e metodo sono ripresi da [Modules/User/docs/bmad/livewire-inventory.md](../../../User/docs/bmad/livewire-inventory.md), adattati al fatto che qui, a differenza di User, non esiste alcun candidato reale.

## Metodo (codice, non assunzione)

```bash
find Modules/Cms/app/Http/Livewire -type f -name '*.php'
grep -rniE "livewire[:.]page\.show|Page\\\\Show|page-show" --include="*.php" --include="*.blade.php" .
grep -rn "@livewire" Modules/Cms --include="*.blade.php"
grep -rln "<livewire:" Modules/Cms --include="*.blade.php"
find Modules/Cms/app/Filament/Widgets -type f
find Modules/Cms/resources/views/pages -maxdepth 1
```

## Classe trovata (1 su tutto il modulo)

### `Modules\Cms\Http\Livewire\Page\Show`

File: `Modules/Cms/app/Http/Livewire/Page/Show.php` (113 righe).

È un componente Livewire classico (`extends \Livewire\Component`, riga 14) che mostra il contenuto di una pagina CMS identificata da slug:

- Proprietà pubbliche `slug`, `cache`, `theme`, `debug`, `pageContent` (righe 16-25).
- `mount()` (righe 27-30) chiama `loadPageContent()`.
- `render()` (righe 32-40) ritorna `view('cms::livewire.page.show', ['pageContent' => ..., 'theme' => ...])`: il nome vista `cms::livewire.page.show` è **l'unico** posto nel repo in cui questa stringa compare come riferimento applicativo (l'altro hit, in `.phpstorm.meta.php`, è autogenerato dall'IDE e non è codice eseguito).
- `rules()` (righe 45-53) impone `slug` obbligatorio.
- `fetchPageContent()` (righe 78-111) risolve la pagina con `Page::findUniqueBySlug($this->slug)` (riga 81) e costruisce un array `title/subtitle/content/meta/blocks/layout` per la vista, con gestione errore che espone file/riga solo se `debug` è vero (righe 101-110).

La vista associata è `Modules/Cms/resources/views/livewire/page/show.blade.php` (64 righe): rende titolo, sottotitolo, corpo HTML e un ciclo su `pageContent['blocks']` che include dinamicamente `cms::components.blocks.{$blockType}` quando la vista esiste (righe 32-59).

Nel codice il componente è quindi ben formato e coerente con l'uso previsto (mostrare una pagina CMS pubblica per slug), ma questo non basta a decidere la categoria: la classificazione BMAD dipende da *chi lo monta*, verificato di seguito.

## Verifica del montaggio: zero hit in tutto il repo

Il grep `grep -rniE "livewire[:.]page\.show|Page\\\\Show|page-show" --include="*.php" --include="*.blade.php" .` (esclusi vendor/node_modules) restituisce **un solo risultato in tutto il monorepo**, ed è l'auto-riferimento del componente stesso a `Show.php:34`. Nessun file lo monta. In dettaglio, per ciascun meccanismo di montaggio possibile in questo stack:

| Meccanismo | Dove si cerca | Esito |
|---|---|---|
| `@livewire('page.show')` (alias) | `grep -rn "@livewire" Modules/Cms --include="*.blade.php"` | Unico hit reale: `Modules/Cms/resources/views/components/blocks/calendar.blade.php:25`, che monta `$widgetClass` (FQCN dinamica tipo `App\Filament\Widgets\PatientCalendarWidget`, vedi nota sotto) — **non** `Page\Show` |
| `<livewire:page.show ... />` (tag) | `grep -rln "<livewire:" Modules/Cms --include="*.blade.php"` | 6 file la usano (`components/blocks/headernav/simple.blade.php`, `components/headernav/simple.blade.php`, `admin/dashboard/item.blade.php`, `admin/index/acts/sort.blade.php`, `admin/index/acts/sort-rows-group.blade.php`, `admin/home/acts/menu_builder.blade.php`), ma per componenti diversi (menu, dashboard, ordinamento) — nessuno referenzia `page.show` o `Page\Show` |
| Render hook nel chrome Filament | Lettura integrale di `Modules/Cms/app/Providers/Filament/AdminPanelProvider.php` (24 righe) e `Modules/Cms/app/Providers/Filament/FrontPanelProvider.php` (67 righe) | `AdminPanelProvider` non registra hook, widget o vista: unico contenuto è `$panel->plugins([...])` (riga 18, Spatie Translatable commentato) e `parent::panel($panel)`. `FrontPanelProvider` registra `pages([Themes::class, EditProfile::class])` e `widgets([])` vuoto (righe 39-52); `discoverPages`/`discoverWidgets` puntano a `app_path('Filament/Front/...')`, cioè l'app root, non al modulo Cms. Nessun riferimento a `Show` in nessuno dei due provider |
| Rotta esplicita (`Route::get(..., Show::class)`) | Lettura integrale di `Modules/Cms/routes/web.php` (18 righe) e `Modules/Cms/routes/api.php` (3 righe) | `web.php` ha una sola rotta reale (righe 14-17): redirect di `/` a `/'.app()->getLocale()`. Il `PageController` è commentato (riga 7) e mai riattivato. `api.php` è vuoto |
| Pagina Folio/Volt a tutto schermo | Lettura di `Modules/Cms/app/Providers/Filament/../../Providers/FolioVoltServiceProvider.php` (righe 140-166) + `find Modules/Cms/resources/views/pages` | `FolioVoltServiceProvider::registerFolioPaths()` registra come rotta Folio la cartella `<module>/resources/views/pages` di ogni modulo attivo, se esiste (controllo `File::exists($path)`, riga 142). Per Cms quella cartella **non esiste** (`ls Modules/Cms/resources/views/` mostra solo `admin, blocks, components, components_old3, composers, filament, index.blade.php, layouts, livewire, sections, tests`, nessuna `pages/`). Cms quindi non contribuisce nessuna rotta Folio/Volt oggi |

Conclusione verificata: `Page\Show` **non è montato da nessuna parte nel codice attuale**. Non è un frammento di chrome `/admin` o `/front`, non è dietro una rotta pubblica, non è incluso da nessuna vista Blade del repo. È un componente scritto e funzionalmente corretto, ma orfano: nessun punto di ingresso lo raggiunge oggi.

### Nota collaterale: `calendar.blade.php` non è un "gemello" di `Show`

`Modules/Cms/resources/views/components/blocks/calendar.blade.php:16-25` monta dinamicamente, via `@livewire($widgetClass)`, una classe risolta da `config('cms.calendar_widget_namespace', 'App\Filament\Widgets')` + suffisso (`PatientCalendarWidget`, `DoctorCalendarWidget`, `AdminCalendarWidget`). È un buon esempio di montaggio per FQCN invece che per alias stringa, citato come riferimento di buona pratica in `livewire-widget-prd.md` (FR-C002), ma la classe puntata vive fuori dal modulo Cms (`App\Filament\Widgets\*`, non `Modules\Cms\...`) e non ha nulla a che fare con `Page\Show`: non va letta come un widget "gemello" già pronto per questo componente.

## Widget Filament esistenti nel modulo Cms: nessuno

`find Modules/Cms/app/Filament/Widgets -type f` non restituisce nulla: la cartella `Widgets` non esiste sotto `Modules/Cms/app/Filament/` (che contiene solo `Blocks, Clusters, Fields, Forms, Front, Infolists, Pages, Resources`). Il punto in cui `XotBasePanelProvider` cerca automaticamente i widget di un modulo è `Modules/Xot/app/Providers/Filament/XotBasePanelProvider.php:134-135` (`discoverWidgets(base_path('Modules/'.$this->module.'/app/Filament/Widgets'), ...)`): per Cms quel path è assente. Non esiste quindi nessun gemello Filament Widget per `Page\Show`, né per nessun altro componente del modulo.

## Classificazione

| Classe | Alias/hook | Gemello widget | Cluster | Nota |
|---|---|---|---|---|
| `Http\Livewire\Page\Show` | nessuno (zero hit repo-wide, vedi tabella sopra) | nessuno (`Filament/Widgets` assente) | **C** | Componente per pagina CMS a slug, pensato per il front-office; oggi non è instradato da nessuna parte. Non è chrome `/admin`, quindi non è candidato **A**. Non esiste un widget gemello da cui ritirarlo, quindi non è **B** |

**Cluster A: zero candidati.** Nessun componente Livewire di Cms è montato oggi nel chrome di un panel Filament.

**Cluster B: zero candidati.** Il modulo non ha alcun Filament Widget esistente, quindi non c'è nulla da cui "ritirare" `Show` per duplicazione.

**Cluster C: 1 componente, escluso.** `Page\Show` è strutturalmente una pagina (title/subtitle/body/blocks, contratto `slug` obbligatorio), non un frammento di chrome: anche se venisse rimesso in uso, il pattern corretto sarebbe una pagina Folio/Volt o una Filament Page a tutto schermo, mai un `XotBaseWidget`. In più, a differenza del caso tipico di Cluster C (pagina instradata ma esclusa perché è "tutto schermo"), qui la ragione dell'esclusione è doppia: (1) per forma non è un widget di chrome, e (2) di fatto oggi non è nemmeno raggiungibile da nessuna rotta o vista — è codice orfano verificato, non solo "fuori scope".

## Superamento del documento precedente

Il documento originale del 2026-08-25 (ora rinominato in `livewire-widget-conversion.md`, vedi quel file) ipotizzava una conversione in `CmsPageWidget` sotto `Cms/Filament/Widgets/Pages/`. Quell'ipotesi è superata dalla verifica di montaggio sopra: convertire `Show` in un `XotBaseWidget` non avrebbe senso, perché non c'è nessun punto del chrome Filament che lo richiami, e la sua forma (pagina intera con titolo/corpo/blocchi) non è quella di un widget. Il canone per questo argomento è questo file.

## Verdetto

Nessuna story di implementazione: zero candidati reali nei Cluster A/B. Resta valida come gate anti-scope-creep la story [12.1](../stories/12.1.cms-page-show-not-widget.story.md), aggiornata in questo audit con le citazioni file:riga raccolte qui.

## Riferimenti correlati (non SSoT, coerenti col verdetto)

Questi file, scritti nella stessa campagna, non vanno duplicati né usati come fonte primaria: puntano tutti qui.

- [livewire-widget-conversion.md](./livewire-widget-conversion.md) — puntatore al canone
- [livewire-widget-architecture.md](./livewire-widget-architecture.md)
- [livewire-widget-brainstorming.md](./livewire-widget-brainstorming.md)
- [livewire-widget-decision-log.md](./livewire-widget-decision-log.md)
- [livewire-widget-epics.md](./livewire-widget-epics.md)
- [livewire-widget-prd.md](./livewire-widget-prd.md)
- [livewire-widget-product-brief.md](./livewire-widget-product-brief.md)
- [livewire-widget-project-context.md](./livewire-widget-project-context.md)
- [livewire-widget-tech-spec.md](./livewire-widget-tech-spec.md)
- [livewire-widget-ux.md](./livewire-widget-ux.md)

## Successo

- [x] Inventario completo del modulo (1 classe trovata, verificata riga per riga)
- [x] Verifica montaggio in tutto il repo, non solo nel modulo (provider, blade, rotte, Folio/Volt)
- [x] Nessun widget nuovo proposto senza prima verificare l'esistenza di un gemello
- [x] Nessuna story di conversione creata (zero candidati reali)
