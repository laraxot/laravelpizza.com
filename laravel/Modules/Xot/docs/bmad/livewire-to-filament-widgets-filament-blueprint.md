---
title: "Filament Blueprint: widget come sostituti dei custom Livewire"
type: blueprint
module: Xot
status: approved-for-execution
created: 2026-10-20
updated: 2026-10-20
related:
  - ./livewire-to-filament-widgets-architecture.md
  - ./livewire-to-filament-widgets-inventory.md
  - ./livewire-to-filament-widgets-brainstorming.md
  - ./filament-blueprint.md
  - ./stories/livewire-to-filament-widgets-fleet.story.md
tags: [docs, xot, bmad]
qmd: "blueprint filament xot"
---

# Blueprint Filament

## Religione (perche' Widget, non custom Livewire)

Nel **panel** Laraxot la superficie UI e' Filament. Un custom
`Livewire\Component` sotto `Http/Livewire` duplica stato, auth, tenancy e
traduzioni e resta fuori dalla discovery. Il sostituto e' sempre una base
`XotBase*` (mai `Filament\Widgets\Widget` diretto). La business logic sta in
Spatie QueueableAction (`execute()`), non nel widget. Il runtime Livewire di
Filament **non** e' un residuo da eliminare.

Contratto modulo Xot: [filament-blueprint.md](./filament-blueprint.md).

## Decision tree

| Scopo rilevato | Destinazione |
|---|---|
| KPI o contatori | `XotBaseStatsOverviewWidget` |
| Trend/distribuzione | `XotBaseChartWidget` |
| Lista con azioni/filtri | `XotBaseTableWidget` |
| Form o filtro | `XotBaseSchemaWidget` |
| dettaglio read-only | `XotBaseInfolistWidget` |
| wizard | `XotBaseWizardWidget` |
| UI composita senza schema standard | `XotBaseWidget` (es. `TermsOfServiceWidget`, `DarkModeSwitcherWidget`) |
| CRUD di record | Resource/Page/Action |
| auth FO pubblico | gemello Auth `*Widget` se montato in panel/theme; altrimenti Folio/Volt: non inventare secondo stack |
| pagina CMS / media card FO | `KEEP` Folio/Blade finche' lo scopo non e' card di panel |
| testo legale gia' con gemello | `REUSE` (`TermsOfServiceWidget` / `PrivacyPolicyWidget`) + ritiro HTTP |

## Contratto di ogni widget

1. proprietà pubbliche tipizzate e minimo stato serializzabile;
2. `mount()` limitato a inizializzazione e contesto;
3. schema in `*Form`/`*Schema` quando esiste un form;
4. authorization esplicita (`canView`, policy, tenant guard);
5. dominio invocato tramite Action, mai query/mutazione complessa inline;
6. view con loading, empty, error, responsive column span e semantica ARIA;
7. traduzioni risolte dalle convenzioni Lang/Xot, senza label duplicate;
8. test del contratto: mount, stato iniziale, autorizzazione, submit/azione,
   redirect o evento, empty/error.

## Registrazione

- panel: directory `Modules/<Module>/app/Filament/Widgets`, discovery del
  `XotBasePanelProvider`;
- widget embedded in una view: `@livewire(FQCN::class, [...])`, mai alias
  ambiguo;
- widget non autodiscovered ma usato da una Page: riferimento FQCN nella Page;
- ogni registrazione deve avere un caller e un test o una motivazione
  documentata.

## Blueprint di implementazione per lane

```text
caller → scopo → sostituto → contratto input → policy/tenant
       → Action invocata → view/layout → test → scan caller
```

La lane possiede solo i file assegnati. Prima del primo edit controlla mtime e
lock; non modifica indice docs o provider condivisi senza ownership esplicita.

## Qualità

- `php -l` sui file toccati;
- Pint mirato;
- PHPStan **solo** via `laravel/phpstan.neon` (immutabile, **solo umano**; mai
  altri `.neon`, mai `-c`): lane
  `analyse Modules/<M>/…` senza `-c` / neon temp; coordinatore
  `analyse Modules` a swarm fermo -
  [single-neon](../wiki/memories/phpstan-single-neon-config.md);
- Pest del modulo e test di autorizzazione/redirect;
- `git diff --check`;
- scan di `app/Http/Livewire`, alias, tag, route, config, test e docs;
- smoke UI del panel/partial che monta il widget.
