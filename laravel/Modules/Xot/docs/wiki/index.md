---
title: "Xot Module Wiki Index"
type: index
module: Xot
tags: [xot, wiki, index, xotbase, migrations, phpstan]
created: 2026-10-28
updated: 2026-10-28
qmd: "xot module wiki index XotBase migrations phpstan filament actions pest domain ownership"
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/28"
discussions:
  - "https://github.com/laraxot/module_xot_fila5/discussions/29"
related:
  - ./concepts/migration-update-timestamps-only.md  # target mancante, verificato 2026-10-14
  - ./concepts/module-model-artifact-parity.md  # target mancante, verificato 2026-10-14
  - ./concepts/ai-harness-xot-discipline.md  # target mancante, verificato 2026-10-14
  - ./concepts/second-brain-local-discipline.md  # target mancante, verificato 2026-10-14
  - ./concepts/no-domain-actions-in-xot.md  # target mancante, verificato 2026-10-14
  - ./rules/module-testcase-xotbase-hierarchy.md  # target mancante, verificato 2026-10-14
  - ../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md
  - ../../../../../docs/wiki/rules/wiki-markdown-frontmatter-mandatory.md
  - ../../../../../docs/wiki/rules/domain-actions-belong-to-domain-module.md
status: active
---

# Xot Module LLM Wiki

## Boundaries (2026-10-28)

- [no-domain-actions-in-xot](./concepts/no-domain-actions-in-xot.md) _(target mancante, verificato 2026-10-14)_: niente `Actions/AI|Geo|…`
- Raw: [no-domain-logic-in-xot.md](../no-domain-logic-in-xot.md) _(target mancante, verificato 2026-10-14)_
- AI owner: [ollama-actions-ownership](../../../AI/docs/wiki/concepts/ollama-actions-ownership.md)

Indice operativo del wiki Xot (core framework).

## Struttura canonica (sacred)

- [no-docs-archive](../../../../../bashscripts/ai/wiki/concepts/no-docs-archive-rule.md): regola Second Brain cross-modulo: niente alberi `docs/archive/`; storia wiki in `docs/wiki/_archive/`.

- [module-directory-structure-rule.md](../module-directory-structure-rule.md) _(target mancante, verificato 2026-10-14)_: regola cartelle modulo (PHP solo in `app/`)
- [concepts/](./concepts/): Pattern architetturali e metodologie Xot/Laraxot.
- [entities/](./entities/): Modelli e componenti chiave.
- [architettura](./concepts/xot-module-architecture-overview.md): Panoramica architetturale del modulo Xot (sovrapponibile a `bmad/architecture.md`).
- [rules/](./rules/): Regole operative e contratti.
- [Accessor Eloquent e gemello nello stesso file](./rules/accessor-twin-method.md): firma pubblica tipizzata, delega, purezza e collocazione nei trait.
- [Accessor Eloquent + gemello nello stesso file](./rules/accessor-twin-method.md): firma pubblica tipizzata, delega e purezza del calcolo.
- [overviews/](./overviews/): Viste panoramiche.
- [sources/](./sources/): Dati di ricerca e link esterni.
- [comparisons/](./comparisons/): Implementazioni alternative.
- [decisions/](./decisions/): ADL (Architectural Decision Log).
- [troubleshooting/](./troubleshooting/): Problemi noti e soluzioni.
- [_archive/](./_archive/): Documentazione legacy.
- [_templates/](./_templates/): Template standard.

## Regole collegate

- [ai-harness-xot-discipline.md](./concepts/ai-harness-xot-discipline.md): harness agenti (canon moduli)
- [module-testcase-xotbase-hierarchy.md](./rules/module-testcase-xotbase-hierarchy.md): TestCase dei moduli estendono `XotBaseTestCase`; nWidart Tests e' dev-only nel package installato
- [composer-root-skeleton-modular.md](./concepts/composer-root-skeleton-modular.md): root Composer minimo, merge solo `Modules/*/composer.json`
- [pest-global-class-imports.md](./rules/pest-global-class-imports.md): nei test senza namespace rimuovere `use ReflectionClass;` e altre import globali inutili
- [second-brain-local-discipline.md](./concepts/second-brain-local-discipline.md)
- [hackernoon-ai-coding-tips-fixcity-map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md) (root)
- [forbidden-folders-rule](../../../../docs/wiki/concepts/forbidden-folders.md): Vincoli strutturali strict.
- [llm-wiki-standard](../../../../docs/project/karpathy-llm-wiki-adoption.md): Mapping repository e ciclo di vita conoscenza.
- [laraxot-core](../../../../docs/wiki/concepts/laraxot-core.md): Core XotBase classes rules.
- [xotbase-check](../../../../docs/wiki/concepts/xotbase-check.md): Verify XotBase usage.

## Scopo Xot Module

Core framework Laraxot: XotBase classes, Actions, PHPStan Level 10, Filament integration, migrations, translations.

## Completamento piattaforma

- [overviews/platform-completion-roadmap.md](./overviews/platform-completion-roadmap.md): **SSoT** roadmap 16 moduli + 4 temi (2026-06-13)
- [PHPStan troubleshooting](../troubleshooting/phpstan.md)

## Compiled Pages

| Pagina | Tipo | Argomento | Data |
|--------|------|-----------|------|
| [platform-completion-roadmap](./overviews/platform-completion-roadmap.md) | Overview | Hub completamento progetto Fixcity | 2026-06-13 |
| [PHPStan troubleshooting](../troubleshooting/phpstan.md) | Guideline | Pattern test PHPStan maximum | 2026-06-13 |
| [ridondanze-cross-cutting-codebase](./concepts/ridondanze-cross-cutting-codebase.md) | Concept | DRY codebase + doc duplicazioni cross-moduli | 2026-05-21 |
| [policy-inheritance-boundary](../User/docs/wiki/concepts/policy-inheritance-boundary.md) | Decision | Cross-module | 2026-04-27 |
| [redundancy-catalog](./concepts/redundancy-catalog.md) | Concept | Indice ridondanza e link report trasversale | 2026-05-21 |
| [unit-test-case-pattern](./concepts/unit-test-case-pattern.md) | Concept | Test patterns | 2026-04-21 |
| [phpstan-cluster-map-and-false-friends](./concepts/phpstan-cluster-map-and-false-friends.md) | Concept | PHPStan cluster | 2026-04-23 |
| [phpstan-pest-bridge-discipline](./concepts/phpstan-pest-bridge-discipline.md) | Concept | Pest bridge/helper discipline for PHPStan | 2026-06-10 |
| [xotbasefield-calculated-view-rule](./concepts/xotbasefield-calculated-view-rule.md) | Concept | XotBaseField | 2026-04-23 |
| [policy-base-strategy](./concepts/policy-base-strategy.md) | Concept | Policy strategy | 2026-04-27 |
| [policy-module-matrix](./concepts/policy-module-matrix.md) | Concept | Policy matrix | 2026-04-27 |
| [laravel13-modular-package-compatibility-matrix](./concepts/laravel13-modular-package-compatibility-matrix.md) | Concept | Compatibilita' pacchetti modulo | 2026-04-28 |
| [module-config-php-religion](./concepts/module-config-php-religion.md) | Concept | `config/config.php` obbligatorio per modulo | 2026-07-27 |
| [module-model-artifact-parity](./concepts/module-model-artifact-parity.md) | Concept | N modelli owner = N migrate + factory + seeder; audit cross-modulo | 2026-06-05 |
| [module-testcase-xotbase-hierarchy](./rules/module-testcase-xotbase-hierarchy.md) | Rule | TestCase modulo -> XotBaseTestCase -> Laravel; no nWidart dev-only base | 2026-06-10 |
| [pest-global-class-imports](./rules/pest-global-class-imports.md) | Rule | Pest: niente import inutili di classi globali (`ReflectionClass`) nei file senza namespace | 2026-06-12 |
| [composer-root-skeleton-modular](./concepts/composer-root-skeleton-modular.md) | Concept | Root Composer minimo con nWidart, moduli owner delle dipendenze | 2026-06-30 |

## Best Practices

- Ogni modulo Nwidart deve avere `config/config.php` (vedi [module-config-php-religion](./concepts/module-config-php-religion.md))
- Usare Actions non Services (vedi [actions-over-services-governance](https://github.com/laraxot/base_fixcity_fila5/blob/main/.opencode/skills/actions-over-services-governance/SKILL.md))
- Implementare `casts()` method non `$casts` property (vedi [custom-casts](../-integration/custom-casts.md))
- PHPStan enforcement (vedi [PHPStan troubleshooting](../troubleshooting/phpstan.md))
- Test PHPStan remediation: Pest resta Pest; bridge/helper condivisi solo quando riducono duplicazione cross-modulo.

## Bad Practices

- NON creare Service classes - usare Actions (vedi [actions-over-services-governance](https://github.com/laraxot/base_fixcity_fila5/blob/main/.opencode/skills/actions-over-services-governance/SKILL.md))
- NON usare `dehydrated(false)` nei trait - blocca salvataggio (vedi Geo CoordinatePicker fix)
- NON dichiarare `$view` statica in XotBaseField - si calcola via `GetViewByClassAction`

## False Friends

- `dehydrated(false)` sembra mantenere il campo nei dati ma blocca il salvataggio (vedi [coordinate-picker-filament5-save-pattern](../../Geo/docs/wiki/concepts/coordinate-picker-filament5-save-pattern.md))
- `live()` in Filament non rende il campo sempre live - serve `$applyStateBindingModifiers()` (vedi [coordinate-picker-state-binding-rule](../../Geo/docs/wiki/concepts/coordinate-picker-state-binding-rule.md))

## Troubleshooting

| Pagina | Tipo | Argomento |
|--------|------|-----------|
| [xotbasefield-calculated-view-rule](./concepts/xotbasefield-calculated-view-rule.md) | Concept | XotBaseField runtime |

Aggiornato: 2026-07-27

## Lezioni 2026-07-27 (hub)

| Argomento | Doc |
|-----------|-----|
| Doppia registrazione provider | [module-providers-dual-registration-mandatory.md](./concepts/module-providers-dual-registration-mandatory.md) |
| Trinità panel Filament (SSoT) | [module-filament-panel-triad.md](./concepts/module-filament-panel-triad.md) |
| `config/config.php` | [module-config-php-religion.md](./concepts/module-config-php-religion.md) |
| `AdminPanelProvider` + doppia registrazione | [module-admin-panel-provider-mandatory.md](./concepts/module-admin-panel-provider-mandatory.md) |
| `Dashboard.php` | [module-dashboard-page-mandatory.md](./concepts/module-dashboard-page-mandatory.md) |
| Hub runtime cross-modulo | [runtime-config-religion-hub](../../../../Themes/docs/shared-components/runtime-config-religion-hub.md) |
| Tenant `modules_statuses` | [tenant-module-status-registry](../../Tenant/docs/tenant-module-status-registry.md) |

## Lezioni 2026-10-06: PHPStan cleanup Xot/app

- [dev-story](../stories/phpstan-cleanup-xot-app.dev.md): scopo prima dell'errore: variabili orfane = logica tolta (`RelationX`, `RouteService`), costanti tipizzate vs `composer.json` `php ^8.2`, result-cache PHPStan stale tra agenti paralleli. Story: [story](../stories/phpstan-cleanup-xot-app.story.md).

## Lezioni 2026-10-06: PHPStan cleanup Xot (tests, helpers, stub Pest)

- [dev-story](../stories/phpstan-cleanup-xot-rest.dev.md): test segnaposto con variabile non letta = asserzione persa; stub `Pest\Laravel\*` risolti da `tests/PestStubs.php` prima del vendor (firme intoccabili, parametri resi utili con `xotPestStubFailure()`); classe anonima annidata = PHPDoc non risolto, serve una classe nominata. Story: [story](../stories/phpstan-cleanup-xot-rest.story.md).

## Decisioni in discussione: 2026-09-11

- [Owner e Resource correlata](concepts/manage-related-records-resource-delegation.md): riuso form/colonne, DRY/KISS e vincoli Filament; traccia vendor completa (`makeTable()`→`configureTable()`).
- Analisi indipendente parallela, stesso giorno, mappa completa in [../index.md#discussioni-architetturali--2026-09-11](../index.md#discussioni-architetturali--2026-09-11): censimento pagine, verifica dal vivo pannello/modulo, prova di precedenza classe/trait.

- [File proposto XotBaseManageRelatedRecords](../app/Filament/Resources/Pages/XotBaseManageRelatedRecords.php.md): PHP documentato, review e coordinamento multi-agente.

## Architettura Canonica (BMAD)

Vedere l'architettura BMAD ufficiale in [bmad/architecture.md](../bmad/architecture.md): questa è la fonte d'autore per la struttura del modulo Xot.
