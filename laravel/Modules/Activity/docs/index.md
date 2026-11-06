---
title: "Indice documentazione — Modulo Activity"
type: index
status: draft
updated: 2026-10-23
tags: [docs, activity]
qmd: "indice documentazione   modulo activity activity"
---
# Indice documentazione — Modulo Activity

Indice organizzato per argomento. Copre tutti i file `.md` sotto `Modules/Activity/docs/`
(890 file al 2026-10-14, 755 al 2026-09-03, non 362 come indicato nel task originale — la cartella e'
cresciuta molto oltre le stime precedenti, vedi `docs/task-consolidare-documentazione.md`
e `docs/docs-health.md`).

## Key Features
- **Activity Logging**: Automatic logging of user and system activities
- **Audit Trails**: Complete history of changes and actions
- **Event Tracking**: Real-time monitoring of system events
- **Reporting**: Activity reports and analytics
- **Filtering**: Advanced filtering and search capabilities

## Architecture
The module follows the Laraxot architecture principles:
- Extends Xot base classes
- Uses Filament for admin interface
- Implements proper service providers
- Follows DRY/KISS principles

## Core Components

### Models
- `Activity` - Main activity model
- `ActivityLog` - Detailed activity logging

- [architecture.md](ARCHITECTURE.md) — architettura generale del modulo.
- [architecture/structure.md](architecture/structure.md) — organizzazione interna dettagliata.
- [structure.md](structure.md) — nota: contenuto quasi identico a `architecture/structure.md` (stesso titolo "Modulo Activity", 414 vs 413 righe); vedi Storico.
- [architecture-rules.md](architecture-rules.md) — puntatore alle regole architetturali generali.
- [architecture/dedicated-connection.md](architecture/dedicated-connection.md) — pattern corretto per la connessione DB dedicata.
- [contracts-naming.md](contracts-naming.md) — naming e posizionamento dei Contracts.
- [patterns.md](patterns.md) — pattern architetturali del modulo (PATTERNS.md e' un duplicato per sola maiuscola, vedi Storico).
- [accessor-delegation-pattern.md](accessor-delegation-pattern.md) — pattern "sacro" di delega degli accessor.
- [actions-convention.md](actions-convention.md) — convenzione Actions (Spatie QueueableAction).
- [queueable-actions.md](queueable-actions.md) — dottrina Queueable Actions nel modulo.
- [actions/list-log-activities-action.md](actions/list-log-activities-action.md) — documentazione completa di `ListLogActivitiesAction`.
- [model-classification.md](model-classification.md) — classificazione dei modelli del modulo.
- [model-factory-seeder-audit.md](model-factory-seeder-audit.md) — audit modelli/factory/seeder.
- [third-party-model-patterns.md](third-party-model-patterns.md) — pattern per modelli di terze parti.
- [business-logic-overview.md](business-logic-overview.md) — panoramica sintetica della business logic.
- [business-logic-analysis.md](business-logic-analysis.md) — analisi estesa (392 righe, versione piu' completa; varianti in Storico).
- [module.md](module.md) — "Modulo Activity - Logging e Event Sourcing" (vedi nota Storico su `module_analysis.md`).
- [module-analysis.md](module-analysis.md) — analisi comprensiva del modulo (contenuto diverso da `module.md`/`module_analysis.md` nonostante il nome simile — collisione di naming, non duplicato di contenuto).
- [module-root-hygiene.md](module-root-hygiene.md) — perche' la root del modulo resta pulita.
- [module-path-assets-resolution.md](module-path-assets-resolution.md) — risoluzione path/assets del modulo.
- [anti-pattern-model-env-hack.md](anti-pattern-model-env-hack.md) — anti-pattern: logica env-specifica nei model.
- [anti-pattern-redundant-property-override.md](anti-pattern-redundant-property-override.md) — anti-pattern: override ridondante di proprieta'.
- [concepts/xotbase-never-extend-filament.md](concepts/xotbase-never-extend-filament.md) — mai estendere `Filament\*` direttamente, sempre `XotBase*`.
- [_integration/filament.md](_integration/filament.md) — nota minima con link esterno di confronto pacchetti activity log.
- [domain-logic.md](domain-logic.md), [data-models.md](data-models.md), [validation.md](validation.md), [integration.md](integration.md), [workflows.md](workflows.md), [troubleshooting.md](troubleshooting.md) — placeholder vuoti (solo titolo, nessun contenuto); non cancellati, da popolare o rimuovere in un task dedicato.

### Services
- `ActivityService` - Core activity management logic
- `ActivityLogger` - Activity logging service

## Implementation Guide

### Basic Usage
```php
// Log an activity
activity()->log('User logged in');

- [filament.md](filament.md) — nota minima (2 righe).
- [filament-resources.md](filament-resources.md) — risorse Filament nel modulo (versione piu' estesa, 339 righe; `filament_resources.md` duplicato in Storico).
- [filament-resource-guidelines.md](filament-resource-guidelines.md) — linee guida risorse (versione piu' estesa, 221 righe; varianti in Storico).
- [filament-5-nested-resources-complete-guide.md](filament-5-nested-resources-complete-guide.md) — guida completa risorse annidate Filament 5.x.
- [filament-5-nested-resources.md](filament-5-nested-resources.md) — guida piu' breve, stesso argomento (da valutare fusione con la guida completa, non e' un duplicato letterale).
- [nested-resources.md](nested-resources.md) — guida implementazione risorse annidate.
- [filament-table-architecture.md](filament-table-architecture.md) — la tabella si configura nella classe Table, non nella Page.
- [filament-actions-usage.md](filament-actions-usage.md) — uso delle Filament Actions nel modulo.
- [filament5-pattern-migration.md](filament5-pattern-migration.md) — migrazione pattern verso Filament 5.
- [migration-filament.md](migration-filament.md) / [migration-filament-4.md](migration-filament.md) / [migrazione-filament.md](migrazione-filament.md) / [migrazione-filament-4.md](migrazione-filament.md) — stub quasi vuoti (6-7 righe) su migrazione Filament 4; contenuto reale nella guida `guida-migrazione-step-by-step.md`.
- [guida-migrazione-step-by-step.md](guida-migrazione-step-by-step.md) — guida step-by-step migrazione Filament 4.
- [filament-version.md](filament-version.md) — dichiarazione versione Filament del modulo.
- [filament-errors.md](filament-errors.md) — errori comuni Filament (versione piu' estesa, 330 righe; varianti in Storico).
- [filament/errors/label-usage-error.md](filament/errors/label-usage-error.md) — mai usare `->label()` nei componenti Filament.
- [filament/errors/static-instance-method-incompatibility.md](filament/errors/static-instance-method-incompatibility.md) — incompatibilita' metodi statici/istanza in Filament.
- [bugfix-filament-facade-namespace.md](bugfix-filament-facade-namespace.md) — bugfix namespace facade Filament.
- [bugfix-getTablePage-mixed-return.md](bugfix-gettablepage-mixed-return.md) — bugfix `getTablePage()` ritorna `mixed` (PHPStan).
- [bugfix-getUrl-signature-mismatch.md](bugfix-geturl-signature-mismatch.md) — bugfix signature `getUrl()` + drift enum/colonne.
- [filament/filament-v4-icon-size-fix.md](filament/filament-v4-icon-size-fix.md) — fix dimensione icone Filament v4 (versione piu' estesa 138 righe; varianti in Storico).
- [filament/filament-v4-upgrade-documentation.md](filament/filament-v4-upgrade-documentation.md) — upgrade Filament v4 (varianti in Storico).
- [filament/archive/filament-v4-icon-size-fix.md](filament/archive/filament-v4-icon-size-fix.md), [filament/archive/filament-v4-upgrade.md](filament/archive/filament-v4-upgrade.md) — copie archiviate degli stessi documenti (vedi Storico).
- [list-log-activities-improvements.md](list-log-activities-improvements.md) — miglioramenti UI/UX di `ListLogActivities` (2025-12-04).
- [activity-log-ui-improvements.md](activity-log-ui-improvements.md) — riepilogo miglioramenti UI/UX log attivita' (documento distinto dal precedente, sovrapposizione di argomento non di contenuto).
- [ui-ux/activity-log-enhancement.md](ui-ux/activity-log-enhancement.md) — enhancement UI/UX log attivita'.

## Report PDF e grafici (JpGraph / html2pdf / chart widget)

- [activity-pdf-reports.md](activity-pdf-reports.md) — report PDF del log attivita'.
- [html2pdf/index.md](html2pdf/index.md) — indice pacchetto html2pdf.
- [html2pdf/usage.md](html2pdf/usage.md), [html2pdf/advanced.md](html2pdf/advanced.md), [html2pdf/laravel.md](html2pdf/laravel.md), [html2pdf/security.md](html2pdf/security.md), [html2pdf/styling.md](html2pdf/styling.md) — guide specifiche html2pdf.
- [charts/README.md](charts/README.md) — integrazione widget Filament per i grafici.
- [dual-label-chart-widget-implementation.md](dual-label-chart-widget-implementation.md) — analisi qualita' `SimpleChartWidget` a doppia etichetta.
- [simplechartwidget-problems-analysis.md](simplechartwidget-problems-analysis.md) — analisi problemi/miglioramenti UI/UX `SimpleChartWidget`.
- [simplechartwidget-quality-analysis.md](simplechartwidget-quality-analysis.md) — stub puntatore a documentazione condivisa Themes (vedi sezione puntatori).
- [jpgraph-guide.md](jpgraph-guide.md) — guida JpGraph 4.4.2.
- [jpgraph-class-reference-comprehensive-analysis.md](jpgraph-class-reference-comprehensive-analysis.md) — riferimento classi JpGraph.
- [jpgraph.md](jpgraph.md) — stub puntatore a documentazione condivisa Themes.

## Event sourcing — teoria e pattern generali

- [module.md](module.md) — vedi sopra (logging + event sourcing).
- [event-sourcing-duplicate.md](event-sourcing-duplicate.md) — "Event Sourcing in Laravel" (nome storico "duplicate" ma e' l'unica versione con contenuto reale; `event-sourcing.md` e' uno stub puntatore, vedi Storico).
- [event_sourcing_examples.md](event_sourcing_examples.md) — esempi pratici di event sourcing per healthcare (`event-sourcing-examples-duplicate.md` identico, vedi Storico).
- [event_sourcing_introduction.md](event_sourcing_introduction.md) — introduzione event sourcing (`event-sourcing-introduction-duplicate.md` variante, vedi Storico).
- [advanced-event-sourcing-patterns.md](advanced-event-sourcing-patterns.md) — pattern avanzati per applicazioni healthcare (versione piu' estesa 224 righe; 4 varianti quasi identiche in Storico).
- [advanced-event-sourcings.md](advanced-event-sourcings.md) — variante con titolo identico ma nome file diverso (non intercettata dal raggruppamento automatico; contenuto da confrontare con `advanced-event-sourcing-patterns.md`).
- [guides/archive/event-sourcing.md](guides/archive/event-sourcing.md) — guida completa event sourcing, archiviata (`guides/event-sourcing.md` e `guides/event_sourcing.md` sono stub puntatori vuoti, vedi Storico).

## Casi d'uso Event Sourcing (approfondimenti didattici)

Tre alberi di documentazione paralleli e autoconclusivi, ciascuno con proprio indice.
Ogni albero ha una **doppia serie di file**: una numerata (`01-introduzione.md`,
`02-architettura.md`, ...) pensata come ordine di lettura, e una serie di alias senza
numero con contenuto quasi identico (`introduzione.md`, `architettura.md`, ...). La
serie numerata e' quella da considerare canonica per la lettura sequenziale; gli alias
sono elencati nello Storico.

- [use_cases/bank/README.md](use_cases/bank/README.md) e [use_cases/bank/index.md](use_cases/bank/index.md) — Larabank: caso d'uso bancario con event sourcing (aggregate, projectors, eventsauce).
- [use_cases/prediction_market/README.md](use_cases/prediction_market/README.md) e [use_cases/prediction_market/index.md](use_cases/prediction_market/index.md) — prediction market, LMSR, architettura a moduli vs domain.
- [use_cases/shop/README.md](use_cases/shop/README.md) e [use_cases/shop/index.md](use_cases/shop/index.md) — carrello della spesa event sourced, confronto `laravel-shop-main` vs `command-bus`.
- [use-cases/tracking-email-sent-schede.md](use-cases/tracking-email-sent-schede.md) — caso d'uso: tracking invio email per schede di valutazione (nota: cartella singolare `use-cases/`, distinta da `use_cases/`).

## Testing

- [testing.md](testing.md) — documentazione testing generale del modulo.
- [testing-guidelines.md](testing-guidelines.md) — linee guida testing.
- [testing-rules.md](testing-rules.md) — riepilogo regole di testing.
- [testing-coverage-policy.md](testing-coverage-policy.md) — policy di coverage.
- [testing-strategy-implementation.md](testing-strategy-implementation.md) — implementazione strategia di test.
- [testcase.md](testcase.md) — configurazione TestCase.
- [testing/no-refresh-database-policy.md](testing/no-refresh-database-policy.md) — policy: mai `RefreshDatabase` nei test.
- [testing/snapshot-testing-patterns.md](testing/snapshot-testing-patterns.md) — pattern di snapshot testing.
- [testing/testing-connection-hack.md](testing/testing-connection-hack.md) — hack di connessione nei test dei model Activity.
- [testing/test-naming-convention.md](testing/test-naming-convention.md) — convenzione di naming dei file di test.
- [architecture/testing-structure-login-analysis.md](architecture/testing-structure-login-analysis.md) — analisi struttura test di login (contenuto quasi identico a `testing-structure-login-analysis.md` in root, vedi Storico).
- [brainstorm-testcase-architecture.md](brainstorm-testcase-architecture.md) — brainstorm architettura TestCase per moduli Laravel (variante `-2026-06-10` in Storico).
- [testcase-sqlite-to-mysql-fix.md](testcase-sqlite-to-mysql-fix.md) — fix passaggio SQLite→MySQL nei test.
- [testing-testcase-database-connection-fix.md](testing-testcase-database-connection-fix.md) — fix configurazione connessione DB in TestCase.
- [aws-test-vs-database-connection.md](aws-test-vs-database-connection.md) — bugfix test AWS vs configurazione connessione DB.
- [snapshot-test-fix.md](snapshot-test-fix.md) — fix test di business logic su snapshot.
- [stored-event-test-fix.md](stored-event-test-fix.md) — fix test business logic su `StoredEvent`.
- [test-errors.md](test-errors.md) / [testing-errors-fixes.md](testing-errors-fixes.md) — errori di test e correzioni.
- [testing-phpstan-progress.md](testing-phpstan-progress.md) — avanzamento PHPStan lato test.
- [tests/phpstan-pest-fixes.md](tests/phpstan-pest-fixes.md) — risoluzione errori PHPStan nei test Pest.
- [factory-coverage-report.md](factory-coverage-report.md) — copertura delle factory.
- [coverage-analysis.md](coverage-analysis.md), [coverage-plan.md](coverage-plan.md), [coverage-status.md](coverage-status.md), [coverage-coordination-workflow.md](coverage-coordination-workflow.md) — analisi, piano e stato coverage.
- [coverage.md](coverage.md) — nota di sessione PHPStan 2026-09-02 (contiene anche un puntatore boilerplate a Themes; il contenuto rilevante e' la nota di sessione in fondo al file).
- [coverage-full.md](coverage-full.md) — output esteso (2930 righe) di una run di coverage/PHPStan; da trattare come log grezzo, non come guida.
- [coverage-clean.md](coverage-clean.md) / [coverage_clean.md](coverage_clean.md) — varianti dello stesso log ripulito (vedi Storico).
- [login-test-implementation-summary.md](login-test-implementation-summary.md) — login test implementation summary (versione piu' estesa 429 righe; 4 varianti in Storico).
- [testing-structure-login-analysis.md](testing-structure-login-analysis.md) — vedi sopra.

## Qualita' del codice, PHPStan, PHPMD

- [phpstan-compliance.md](phpstan-compliance.md) e [wiki/concepts/phpstan-compliance.md](wiki/concepts/phpstan-compliance.md) — stato compliance Level 10 (due documenti distinti, uno nel wiki con piu' dettaglio tipizzazione).
- [phpstan-compliance-status.md](phpstan-compliance-status.md) — stato compliance Level 10.
- [phpstan-quality-rules.md](phpstan-quality-rules.md) — regole di qualita' PHPStan.
- [phpstan-analysis.md](phpstan-analysis.md) — analisi PHPStan generale del modulo.
- [phpstan-analysis-activity.md](phpstan-analysis-activity.md) — analisi PHPStan specifica Activity.
- [phpstan-ignore-audit.md](phpstan-ignore-audit.md) — audit degli `@phpstan-ignore`.
- [phpstan-errors.md](phpstan-errors.md), [phpstan-findings.md](phpstan-findings.md) — errori e findings PHPStan.
- [phpstan-errors-activitylogger-analysis.md](phpstan-errors-activitylogger-analysis.md), [phpstan-errors-activitylogger.md](phpstan-errors-activitylogger.md), [phpstan-errors-activitylogger-reasoning.md](phpstan-errors-activitylogger-reasoning.md) — tre documenti distinti (analisi, sintesi, ragionamento) sugli stessi errori in `ActivityLogger.php`.
- [phpstan-syntax-fixes.md](phpstan-syntax-fixes.md), [phpstan-baseline-fixes.md](phpstan-baseline-fixes.md), [phpstan-complete-fixes.md](phpstan-complete-fixes.md), [phpstan-tests-corrections.md](phpstan-tests-corrections.md) — correzioni per area.
- [phpstan-override-fix-roadmap.md](phpstan-override-fix-roadmap.md), [phpstan-roadmap.md](phpstan-roadmap.md), [phpstan-stabilization.md](phpstan-stabilization.md) — roadmap di stabilizzazione.
- [wiki/concepts/phpstan-module-config-zero.md](wiki/concepts/phpstan-module-config-zero.md), [wiki/concepts/phpstan-pest-discipline.md](wiki/concepts/phpstan-pest-discipline.md) — regole PHPStan modulo/config e disciplina Pest.
- [wiki/concepts/pest-bootstrap-extend-ignore.md](wiki/concepts/pest-bootstrap-extend-ignore.md) — bootstrap Pest con `pest()->extend()` e ignore inline.
- Cronologia interventi PHPStan (snapshot puntuali, non duplicati tra loro): [phpstan-activity-fix.md](phpstan-activity-fix.md), [phpstan-analysis-november.md](phpstan-analysis-november.md), [phpstan-compliance-dec.md](phpstan-compliance-dec.md), [phpstan-corrections-january.md](phpstan-corrections-january.md), [phpstan-corrections.md](phpstan-corrections.md), [phpstan-fixes.md](phpstan-fixes.md), [phpstan-fixes-1.md](phpstan-fixes-correzioni-modulo-activity.md), [phpstan-fixes-activity.md](phpstan-fixes-activity.md), [phpstan-fixes-activity-1.md](phpstan-fixes-activity-correzioni-modulo.md).
- [phpmd-analysis.md](phpmd-analysis.md) — analisi e fix PHPMD (PHPMD-ANALYSIS.md duplicato maiuscolo, vedi Storico).
- [phpmd-fixes.md](phpmd-fixes.md), [phpmd-errors.md](phpmd-errors.md) — fix ed errori PHPMD.
- [phpinsights-errors.md](phpinsights-errors.md) — errori PHPInsights.
- [cyclomatic-complexity-report.md](cyclomatic-complexity-report.md) — report complessita' ciclomatica.
- [code-quality-analysis.md](code-quality-analysis.md) — analisi qualita' del codice (versione piu' estesa 818 righe; varianti in Storico).
- [code-quality-improvement-report.md](code-quality-improvement-report.md), [code-quality-report.md](code-quality-report.md) — report di miglioramento qualita'.
- [code-redundancy-audit.md](code-redundancy-audit.md) — audit ridondanza codice.
- [duplicate-methods-analysis.md](duplicate-methods-analysis.md) — analisi metodi duplicati (documento principale in inglese).
- [metodi-duplicati-analisi.md](metodi-duplicati-analisi.md) — "SUPER MUCCA EDITION", 1098 righe, versione piu' estesa dell'analisi in italiano (varianti in Storico).
- [duplicate_methods.md](duplicate_methods.md), [duplicate_methods_report.md](duplicate_methods_report.md) — report correlati su metodi con nome duplicato nei moduli/temi.
- [wiki/concepts/duplicate-method-bodies.md](wiki/concepts/duplicate-method-bodies.md), [wiki/concepts/method-name-homonyms.md](wiki/concepts/method-name-homonyms.md) — censimento corpi/metodi omonimi (wiki, piu' recenti).
- [redundancy-audit.md](redundancy-audit.md) — audit ridondanza 2026-05-21 (`redundancy-audit-activity.md` e' lo stesso contenuto con nome datato, vedi Storico).
- [copilot-redundancy-audit.md](copilot-redundancy-audit.md) — audit ridondanza (variante `-2026-05-25` identica, vedi Storico).
- [consolidation_analysis.md](consolidation_analysis.md) — analisi di consolidamento (CONSOLIDATION_ANALYSIS.md duplicato maiuscolo, vedi Storico).
- [dry-kiss-analysis.md](dry-kiss-analysis.md) — analisi DRY & KISS (varianti `-latest`/`-.md` identiche, vedi Storico).
- [dry-kiss.md](dry-kiss.md) — versione piu' corta, stesso argomento.
- [ottimizzazioni-dry-kiss.md](ottimizzazioni-dry-kiss.md) — ottimizzazioni DRY+KISS (documento distinto, piu' esteso).
- [optimization-analysis.md](optimization-analysis.md), [analisi-ottimizzazioni.md](analisi-ottimizzazioni.md), [ottimizzazioni-correzioni.md](ottimizzazioni-correzioni.md), [modules-optimization-analysis.md](modules-optimization-analysis.md) — quattro audit di ottimizzazione distinti nel tempo, forte sovrapposizione tematica ma non identici: candidati a consolidamento futuro (vedi `task-consolidare-documentazione.md`).
- [bottlenecks.md](bottlenecks.md) — colli di bottiglia e soluzioni.
- [query-optimization-analysis.md](query-optimization-analysis.md) — nota: file quasi vuoto (7 righe); il contenuto reale (316 righe) e' in `query_optimization_analysis.md` (vedi Storico).
- [logging-optimization.md](logging-optimization.md) — ottimizzazione logging (`logging_optimization.md` e' uno stub puntatore vuoto, vedi Storico).
- [quality-analysis/activity-module-quality-report.md](quality-analysis/activity-module-quality-report.md) — report qualita' modulo.
- [quality-audit.md](quality-audit.md) — audit di qualita'.
- [quality_report.md](quality_report.md) — quality report (QUALITY_REPORT.md duplicato maiuscolo, vedi Storico).
- [quality-status.md](quality-status.md) — stato qualita' novembre 2025 (`quality-status-.md` identico, `quality-status-activity-module-november.md` quasi identico, `quality-status-nov.md` e' stub puntatore vuoto; vedi Storico).
- [psr4-autoloading-fix.md](psr4-autoloading-fix.md) — fix compliance PSR-4.
- [case-variant-collisions.md](case-variant-collisions.md) — collisioni di nome file per sola differenza di maiuscole nel codice PHP del modulo (documento gemello di questo problema, ma sui sorgenti, non sui docs).
- [ponytail-audit-over-engineering.md](ponytail-audit-over-engineering.md) e [wiki/concepts/ponytail-audit.md](wiki/concepts/ponytail-audit.md) — audit over-engineering.

## Errori noti e troubleshooting

- [errors-and-fixes.md](errors-and-fixes.md) — errori rilevati e soluzioni.
- [errori/attributerawvalues-null-firstorcreate.md](errori/attributerawvalues-null-firstorcreate.md) — errore `attributeRawValues` null durante `firstOrCreate`.
- [errori/duplicate-entry-accessor-save.md](errori/duplicate-entry-accessor-save.md) — errore duplicate entry durante l'activity log.
- [errori/modulo-disabilitato.md](errori/modulo-disabilitato.md) — errore modulo Activity disabilitato.
- [errori/no-hint-path-defined.md](errori/no-hint-path-defined.md) — errore "No hint path defined for [activity]".
- [errori/route-method-does-not-exist.md](errori/route-method-does-not-exist.md) — errore `::route` non esiste.
- [troubleshooting/properties-vuote-activity-log.md](troubleshooting/properties-vuote-activity-log.md) — troubleshooting properties vuote nel log.
- [filament-errors.md](filament-errors.md) — vedi sezione Filament.
- [codex-error-fix.md](codex-error-fix.md) — stub puntatore a documentazione condivisa Themes.
- [wiki/troubleshooting/git-push-dual-remote.md](wiki/troubleshooting/git-push-dual-remote.md) — troubleshooting push su doppio remote.

## Roadmap e prodotto

- [roadmap/README.md](roadmap/README.md) — roadmap del modulo (entry point principale).
- [roadmap.md](roadmap.md) — "Roadmap Modulo Activity - Audit Trail & Intelligence" (documento distinto).
- [roadmap-vision.md](roadmap-vision.md) — roadmap completa 2026 (527 righe).
- [roadmap-miglioramenti.md](roadmap-miglioramenti.md), [cosa-migliorare.md](cosa-migliorare.md) — cosa migliorare (visione).
- [roadmap-and-issues.md](roadmap-and-issues.md) — roadmap e ottimizzazioni.
- [roadmap/index.md](roadmap/index.md) — indice della serie numerata `roadmap/01-current-state.md` … `roadmap/05-risks.md` (`roadmap/00-index.md` e' duplicato, vedi Storico). La serie numerata ha alias senza numero con contenuto identico (`roadmap/current-state.md`, `roadmap/goals.md`, `roadmap/workstreams.md`, `roadmap/milestones.md`, `roadmap/risks.md`, `roadmap/now.md`, `roadmap/next.md`, `roadmap/later.md`, `roadmap/overview.md`) — vedi Storico.
- [roadmap/legacy-roadmap.md](roadmap/legacy-roadmap.md) — roadmap legacy, gia' marcata come tale.
- [roadmap/acceptance-criteria.md](roadmap/acceptance-criteria.md), [roadmap/dependencies.md](roadmap/dependencies.md), [roadmap/metrics.md](roadmap/metrics.md), [roadmap/phases.md](roadmap/phases.md), [roadmap/quality.md](roadmap/quality.md), [roadmap/vision.md](roadmap/vision.md) — sezioni tematiche della roadmap.
- `roadmap/tasks/` (enhanced-activity-filtering, gdpr-compliance-enhancement, realtime-monitoring-dashboard): i tre file non esistono piu' (rimossi nel commit `7e00cedf` del 2026-10-08, verificato 2026-10-14); recuperabili con `git show 7e00cedf^:docs/roadmap/tasks/<nome>.md`.
- [development/roadmap.md](development/roadmap.md) — roadmap orientata allo sviluppo (documento distinto da `roadmap/README.md`).
- [stabilization-roadmap.md](stabilization-roadmap.md) — roadmap di stabilizzazione.
- [prd.md](prd.md) — PRD del modulo.
- [product-requirements.md](product-requirements.md) — product requirements document esteso.
- [product-roadmap.md](product-roadmap.md) — product roadmap (PRODUCT_ROADMAP.md/product_roadmap.md duplicati, vedi Storico).
- [product-strategy.md](product-strategy.md) — product strategy (varianti maiuscole/underscore in Storico).
- [product-launch-plan.md](product-launch-plan.md) — piano di lancio (varianti in Storico).
- [launch-plan.md](launch-plan.md) — piano di lancio sintetico (documento distinto, molto piu' corto).
- [tech_spec.md](tech_spec.md) — technical specification (TECH_SPEC.md duplicato maiuscolo, vedi Storico).
- [sprint-planning-meeting.md](sprint-planning-meeting.md) — verbale sprint planning.
- [sprint_planning.md](sprint_planning.md) — sprint planning esteso (SPRINT_PLANNING.md duplicato, `sprint-planning.md` e' una versione molto piu' corta dello stesso argomento, vedi Storico).
- [user-research.md](user-research.md) / [user_research.md](user_research.md) — user research (versione estesa in underscore, 101 righe; vedi Storico).
- [release-marketing-standard.md](release-marketing-standard.md) — standard release/README marketing.
- [readme-en.md](readme-en.md) — presentazione in inglese del modulo.
- [readme-update.md](readme-update.md) — aggiornamento README, sezione testing (readme_update.md duplicato, vedi Storico).

## BMAD — Epic e Story

- [epics/activity-epics-and-stories.md](epics/activity-epics-and-stories.md) — epic e user story del modulo.
- [stories/01.08.connection-property-safety.story.md](stories/01.08.connection-property-safety.story.md)
- [stories/16-3-restore-corrupted-var-docblocks.md](stories/16-3-restore-corrupted-var-docblocks.md)
- [stories/3.7.gdpr-export.story.md](stories/3.7.gdpr-export.story.md)
- [stories/3.10.activity-pest-extend-bootstrap.story.md](stories/3.10.activity-pest-extend-bootstrap.story.md)
- [stories/4.1.immutable-activity-log.story.md](stories/4.1.immutable-activity-log.story.md)
- [stories/4.2.activity-retention-archive.story.md](stories/4.2.activity-retention-archive.story.md)
- [stories/4.6.dpo-signoff-evidence.story.md](stories/4.6.dpo-signoff-evidence.story.md)
- [stories/6.4.cleanup-policy-archive-scheduling.story.md](stories/6.4.cleanup-policy-archive-scheduling.story.md)
- [stories/7.1.phpstan-activity-contracts.story.md](stories/7.1.phpstan-activity-contracts.story.md)
- [stories/7.2.phpstan-test-harness-contracts.story.md](stories/7.2.phpstan-test-harness-contracts.story.md)
- [stories/9.1.fix-connection-property-removed.story.md](stories/9.1.fix-connection-property-removed.story.md)
- [stories/docs-index-audit.story.md](stories/docs-index-audit.story.md) — questo task (audit indice docs).
- [stories/blade-i18n-no-hardcoded-text.story.md](stories/blade-i18n-no-hardcoded-text.story.md) — niente testi fissi nelle Blade: chiavi `activity::` in it, en, de, es.

## Task e backlog dettagliato

- `tasks/` (36 file: `tasks-index.md`, `001`..`005`, `activity-ai-detection`, `activity-filament-v5`, `cleanup-activity-docs`, `documentation/*`, `features/*`, `refactoring/*`, `testing/*`): la cartella non contiene piu' nessun `.md` (rimossa nel commit `7e00cedf` del 2026-10-08, verificato 2026-10-14; resta un solo file `.lock`). Ogni file e' recuperabile con `git show 7e00cedf^:docs/tasks/<percorso>`. I link a questi file sono stati tolti da questo elenco.
- [task-consolidare-documentazione.md](task-consolidare-documentazione.md) — task gemello nella root di `docs/` (30% completo secondo il file stesso).
- [task-migliorare-report-pdf.md](task-migliorare-report-pdf.md), [task-ridurre-phpstan-test.md](task-ridurre-phpstan-test.md) — altri task nella root di `docs/`.

Le voci `tasks/` rimosse sopra avevano lo stesso template ma contenuto distinto; i tre file `task-*.md` della radice di `docs/` esistono ancora.

## Wiki (second brain del modulo)

Il modulo mantiene un "second brain" strutturato sotto `wiki/`, con proprio indice
tematico gia' mantenuto: [wiki/index.md](wiki/index.md) (concetti, regole, memorie,
troubleshooting, integrazioni, fonti). Punti di rilievo:

- [wiki/README.md](wiki/README.md) — introduzione al wiki di modulo.
- [wiki/overview.md](wiki/overview.md), [wiki/overviews/completion-status.md](wiki/overviews/completion-status.md) — panoramica e stato di completamento.
- [wiki/concepts/index.md](wiki/concepts/index.md) — indice dei concetti (INDEX.md duplicato maiuscolo, vedi Storico).
- [wiki/concepts/xotbase-resource-zen-pattern.md](wiki/concepts/xotbase-resource-zen-pattern.md), [wiki/concepts/queueable-action-execute-entrypoint.md](wiki/concepts/queueable-action-execute-entrypoint.md), [wiki/concepts/queueable-action-trait-mandatory.md](wiki/concepts/queueable-action-trait-mandatory.md) — pattern architetturali chiave.
- [wiki/concepts/activity-domain-focus.md](wiki/concepts/activity-domain-focus.md), [wiki/concepts/activity-migration-ownership.md](wiki/concepts/activity-migration-ownership.md), [wiki/concepts/activity-log-attribute-changes-column.md](wiki/concepts/activity-log-attribute-changes-column.md), [wiki/concepts/activity-log-single-migration-contract.md](wiki/concepts/activity-log-single-migration-contract.md) — regole di dominio specifiche Activity.
- [wiki/concepts/spatie-activitylog-module-dependency.md](wiki/concepts/spatie-activitylog-module-dependency.md), [wiki/concepts/package-ownership-event-sourcing.md](wiki/concepts/package-ownership-event-sourcing.md) — ownership pacchetti.
- [wiki/concepts/testcase-hierarchy-architecture.md](wiki/concepts/testcase-hierarchy-architecture.md), [wiki/memories/testcase-hierarchy-decision.md](wiki/memories/testcase-hierarchy-decision.md) — decisione architetturale TestCase (variante datata `-2026-06-10` identica in Storico).
- [wiki/concepts/no-app-support-queueable-actions.md](wiki/concepts/no-app-support-queueable-actions.md), [wiki/concepts/no-services-no-support-queueable-actions.md](wiki/concepts/no-services-no-support-queueable-actions.md) — divieto `Services`/`Support`, solo Actions.
- [wiki/concepts/schemas-tables-pattern.md](wiki/concepts/schemas-tables-pattern.md), [wiki/concepts/model-migration-seeder-rule.md](wiki/concepts/model-migration-seeder-rule.md) — regola 1 modello = 1 migration + 1 seeder.
- [wiki/concepts/second-brain-local-discipline.md](wiki/concepts/second-brain-local-discipline.md), [wiki/concepts/context-mode-activity-discipline.md](wiki/concepts/context-mode-activity-discipline.md), [wiki/concepts/context-overflow-prevention.md](wiki/concepts/context-overflow-prevention.md) — disciplina agente e contesto.
- [wiki/concepts/claude-audit-static.md](wiki/concepts/claude-audit-static.md), [wiki/concepts/ponytail-audit.md](wiki/concepts/ponytail-audit.md) — audit statici.
- [wiki/concepts/composer-root-minimal-nwidart.md](wiki/concepts/composer-root-minimal-nwidart.md), [wiki/concepts/organizzativa-money.md](wiki/concepts/organizzativa-money.md), [wiki/concepts/jpgraph-guide.md](wiki/concepts/jpgraph-guide.md) (variante di `jpgraph-guide.md` in root), [wiki/concepts/duplicate-method-bodies.md](wiki/concepts/duplicate-method-bodies.md), [wiki/concepts/method-name-homonyms.md](wiki/concepts/method-name-homonyms.md), [wiki/concepts/phpstan-compliance.md](wiki/concepts/phpstan-compliance.md), [wiki/concepts/phpstan-module-config-zero.md](wiki/concepts/phpstan-module-config-zero.md), [wiki/concepts/phpstan-pest-discipline.md](wiki/concepts/phpstan-pest-discipline.md), [wiki/concepts/pest-bootstrap-extend-ignore.md](wiki/concepts/pest-bootstrap-extend-ignore.md), [wiki/concepts/testing.md](wiki/concepts/testing.md) — vari concetti puntuali.
- [wiki/rules/index.md](wiki/rules/index.md) (INDEX.md duplicato, Storico), [wiki/rules/best-practices.md](wiki/rules/best-practices.md), [wiki/rules/queueable-action-execute-entrypoint.md](wiki/rules/queueable-action-execute-entrypoint.md).
- [wiki/skills/index.md](wiki/skills/index.md), [wiki/commands/index.md](wiki/commands/index.md), [wiki/memories/index.md](wiki/memories/index.md) — indici delle rispettive sotto-sezioni (ognuno con gemello INDEX.md maiuscolo, vedi Storico).
- [wiki/sources/activity-core-sources.md](wiki/sources/activity-core-sources.md) — fonti primarie del modulo.
- [wiki/how-to/gitmodules-sync-session.md](wiki/how-to/gitmodules-sync-session.md), [wiki/troubleshooting/git-merge-conflict-inventory.md](wiki/troubleshooting/git-merge-conflict-inventory.md), [wiki/troubleshooting/git-push-dual-remote.md](wiki/troubleshooting/git-push-dual-remote.md), [wiki/integrations/integration.md](wiki/integrations/integration.md), [wiki/integrations/laravel-13-upgrade.md](wiki/integrations/laravel-13-upgrade.md).
- [wiki/schema.md](wiki/schema.md), [wiki/log.md](wiki/log.md), [wiki/agents.md](wiki/agents.md), [wiki/bmad-method.md](wiki/bmad-method.md) (stub puntatore), [wiki/project-roadmap.md](wiki/project-roadmap.md).
- [wiki/product/_da-riconciliare/product-strategy.md](wiki/product/_da-riconciliare/product-strategy.md) — gia' esplicitamente marcato "da riconciliare" dal path stesso.
- [wiki/_templates/concept.md](wiki/_templates/concept.md), [wiki/_templates/entity.md](wiki/_templates/entity.md), [wiki/_templates/source.md](wiki/_templates/source.md) — template per nuove pagine wiki, non contenuto.

`llm-wiki/` e' uno scaffold parallelo, in gran parte vuoto: [llm-wiki/index.md](llm-wiki/index.md)
dichiara esplicitamente "no concept/entity/source pages created yet". Contenuto reale
solo in [llm-wiki/agents.md](llm-wiki/agents.md) e [llm-wiki/log.md](llm-wiki/log.md)
(`llm-wiki/AGENTS.md` duplicato maiuscolo, vedi Storico). I template
`llm-wiki/_templates/*.md` sono stub identici a quelli di `wiki/_templates/`.

## Governance, regole del modulo e igiene della documentazione

- [rules-index.md](rules-index.md) — indice regole.
- [docs-health.md](docs-health.md) — stato di salute della documentazione (gia' segnalava 190 file "top-level" prima di questo audit; ora sono 755).
- `docs-archive-policy.md`: file rimosso nel commit `a871d44e` del 2026-10-08 (verificato 2026-10-14); non esiste piu' in `docs/`.
- [module-root-hygiene.md](module-root-hygiene.md), [root-file-policy.md](root-file-policy.md), [root-files-hygiene.md](root-files-hygiene.md) — igiene della root del modulo (tre documenti distinti ma tematicamente sovrapposti).
- [no-ai-tool-scaffold-dirs.md](no-ai-tool-scaffold-dirs.md) — perche' certe cartelle scaffold da tool AI non devono esistere qui.
- [no-git-lfs.md](no-git-lfs.md) — Git LFS non si usa in questo progetto.
- [case-variant-collisions.md](case-variant-collisions.md) — collisioni di nome per sola differenza di maiuscole (nel codice sorgente; vedi anche la sezione Storico di questo stesso indice per il fenomeno equivalente nei `.md`).
- [second-brain.md](second-brain.md) — nota sul second brain di modulo.
- [agent-confidence-discipline.md](agent-confidence-discipline.md), [agent-confidence-protocol.md](agent-confidence-protocol.md), [confidence_guidelines.md](confidence_guidelines.md) — tre documenti quasi gemelli sulla disciplina di confidenza dell'agente (contenuto simile ma non identico, candidati a fusione futura).
- [agent-edit-discipline.md](agent-edit-discipline.md) — puntatore a disciplina edit/qualita'.
- [architecture-rules.md](architecture-rules.md) — puntatore regole architetturali.
- [dependencies.md](dependencies.md), [dependency-intelligence.md](dependency-intelligence.md) — dipendenze del modulo.
- [gestionale-platform-activity-audit.md](gestionale-platform-activity-audit.md), [gestionale-platform-audit-mapping.md](gestionale-platform-audit-mapping.md) — mappatura Activity vs Platform.AuditLog.

## Traduzioni

- [translations.md](translations.md) — traduzioni del modulo.
- [lang-link.md](lang-link.md) — collegamento alle traduzioni (versione piu' estesa 121 righe; varianti in Storico).

## Sicurezza

- [security.md](security.md) — documentazione di sicurezza (SECURITY.md duplicato maiuscolo, vedi Storico).

## Ambiente, tooling, MCP e QMD

- [env-development-configuration.md](env-development-configuration.md) — configurazione ambiente di sviluppo.
- [mcp-configuration.md](mcp-configuration.md) — configurazione server MCP.
- [mcp-server-recommended.md](mcp-server-recommended.md) — MCP consigliati per il modulo (MCP-SERVER-RECOMMENDED.md duplicato maiuscolo; `mcp_server_recommended.md`/`MCP_SERVER_RECOMMENDED.md` sono invece stub puntatori a Themes, vedi Storico — attenzione: 4 file quasi omonimi con due ruoli diversi).
- [qmd-setup.md](qmd-setup.md) — setup QMD per il modulo (QMD-SETUP.md duplicato maiuscolo, vedi Storico).
- [boost-skill-fix-summary.md](boost-skill-fix-summary.md) — fix skill Boost (`boost_skill_fix_summary.md` e' invece uno stub puntatore Themes, vedi Storico).
- [laravel-13-upgrade.md](laravel-13-upgrade.md) — upgrade Laravel 13 (contenuto simile a `wiki/integrations/laravel-13-upgrade.md`, non identico).

## Git, conflitti e sync multi-organizzazione

- [git-conflicts-resolution-summary.md](git-conflicts-resolution-summary.md) — risoluzione conflitti Git (`git-conflicts-resolution-sumy.md` e' uno stub puntatore Themes con refuso nel nome, vedi Storico).
- [conflict-resolution.md](conflict-resolution.md) — nota generale di conflict resolution.
- [merge-conflicts-list.md](merge-conflicts-list.md) — elenco file con marker di conflitto (`merge-conflict-files-list.md` e' uno stub puntatore Themes, nome quasi omonimo, vedi Storico).
- [git-multi-org-sync-handoff.md](git-multi-org-sync-handoff.md) — handoff sync multi-org (STORY-003).
- [multi-org-sync-laraxot-provtv.md](multi-org-sync-laraxot-provtv.md) — sincronizzazione laraxot + provtv.
- [wiki/how-to/gitmodules-sync-session.md](wiki/how-to/gitmodules-sync-session.md) — sessione di sync `.gitmodules`.
- [wiki/troubleshooting/git-merge-conflict-inventory.md](wiki/troubleshooting/git-merge-conflict-inventory.md) — inventario conflitti (variante datata `-2026-04-28` identica in Storico).
- [wiki/troubleshooting/git-push-dual-remote.md](wiki/troubleshooting/git-push-dual-remote.md) — push su doppio remote.

## Prompt operativi

- [prompts/fix.md](prompts/fix.md), [prompts/fix01.md](prompts/fix01.md), [prompts/fix02.md](prompts/fix02.md), [prompts/fix03.md](prompts/fix03.md) — prompt di fix su connessione DB `activity`.
- [prompts/test01.md](prompts/test01.md) — prompt di test.

## Analisi storiche di dominio / modelli

- [modelli-factory-seeder-analisi.md](modelli-factory-seeder-analisi.md) — analisi modelli/factory/seeder multi-modulo (versione piu' estesa 373 righe; varianti in Storico).
- [models-analysis.md](models-analysis.md), [models-factory-seeder-analysis.md](models-factory-seeder-analysis.md) — analisi equivalenti in inglese, scope solo Activity.
- [folio-volt-best-practices.md](folio-volt-best-practices.md) — best practice Folio + Volt.
- [frameworks.md](frameworks.md) — note di integrazione framework (FRAMEWORKS.md duplicato maiuscolo, vedi Storico).
- [project-structure.md](project-structure.md) — struttura di progetto (PROJECT-STRUCTURE.md duplicato, vedi Storico).
- [quick-start.md](quick-start.md) — quick start (QUICK-START.md duplicato, vedi Storico).
- [on-demand-pattern.md](on-demand-pattern.md) — pattern on-demand del modulo (ON-DEMAND-PATTERN.md duplicato, vedi Storico).
- [performance-optimization.md](performance-optimization.md) — performance optimization (PERFORMANCE-OPTIMIZATION.md duplicato, vedi Storico).
- [performance/activity-log-optimization.md](performance/activity-log-optimization.md) — ottimizzazione log attivita' (versione piu' estesa 567 righe; 3 varianti + 3 copie in `performance/archive/` in Storico).
- [pandoc_guide.md](pandoc_guide.md) — generazione documentazione con Pandoc (PANDOC_GUIDE.md duplicato maiuscolo, vedi Storico).
- [tecnico/laraxot/module-activity.md](tecnico/laraxot/module-activity.md) — overview tecnica modulo (contiene anche un puntatore Themes in testa; `tecnico/laraxot/archive/module-activity.md` e' una versione archiviata piu' corta, vedi Storico).
- [changelog.md](changelog.md) — changelog del modulo (CHANGELOG.md e' un "documento unificato" diverso, non lo stesso changelog: verificarne il ruolo prima di consolidare).

## Storico / da consolidare

Questa sezione raccoglie i cluster di file quasi identici individuati con un confronto
automatico (nome normalizzato + conteggio righe) piu' alcuni duplicati trovati a mano.
**Nessuno di questi file e' stato toccato.** Per ciascun cluster e' indicato quale
variante e' collegata come riferimento primario nelle sezioni sopra.

### Varianti di sola maiuscola/minuscola o underscore/trattino (stesso contenuto)

`api.md`/`API.md` · `architecture.md`/`ARCHITECTURE.md` · `bad_practices.md`/`BAD_PRACTICES.md` ·
`best_practices.md`/`BEST_PRACTICES.md` · `business_logic_analysis.md`/`BUSINESS_LOGIC_ANALYSIS.md` ·
`code_quality_analysis.md`/`CODE_QUALITY_ANALYSIS.md` · `consolidation_analysis.md`/`CONSOLIDATION_ANALYSIS.md` ·
`critical_migration_constraints.md`/`CRITICAL_MIGRATION_CONSTRAINTS.md` · `database-schema.md`/`DATABASE-SCHEMA.md` ·
`frameworks.md`/`FRAMEWORKS.md` · `index.md`/`INDEX.md` · `migrations.md`/`MIGRATIONS.md` ·
`metodi_duplicati_analisi.md`/`METODI_DUPLICATI_ANALISI.md` · `on-demand-pattern.md`/`ON-DEMAND-PATTERN.md` ·
`pandoc_guide.md`/`PANDOC_GUIDE.md` · `patterns.md`/`PATTERNS.md` · `performance-optimization.md`/`PERFORMANCE-OPTIMIZATION.md` ·
`phpmd-analysis.md`/`PHPMD-ANALYSIS.md` (+ stub `phpmd_analysis.md`/`PHPMD_ANALYSIS.md`) ·
`product_launch_plan.md`/`PRODUCT_LAUNCH_PLAN.md` · `product_roadmap.md`/`PRODUCT_ROADMAP.md` ·
`product_strategy.md`/`PRODUCT_STRATEGY.md` · `project-structure.md`/`PROJECT-STRUCTURE.md` ·
`qmd-setup.md`/`QMD-SETUP.md` · `quality_report.md`/`QUALITY_REPORT.md` ·
`query_optimization_analysis.md`/`QUERY_OPTIMIZATION_ANALYSIS.md` (+ stub quasi vuoto `query-optimization-analysis.md`) ·
`quick-start.md`/`QUICK-START.md` · `security.md`/`SECURITY.md` · `sprint_planning.md`/`SPRINT_PLANNING.md` ·
`tech_spec.md`/`TECH_SPEC.md` · `user_research.md`/`USER_RESEARCH.md` · `readme-update.md`/`readme_update.md` ·
`redundancy_analysis.md`/`REDUNDANCY_ANALYSIS.md` (entrambi stub vuoti) ·
`filament/filament-v4-icon-size-fix.md` (+ `filament-v4-icon-size-fix-attribute.md`, ex `-2.md`, `FILAMENT_V4_ICON_SIZE_FIX.md`, `filament_v4_icon_size_fix.md`) ·
`filament/filament-v4-upgrade.md` (+ `filament-v4-upgrade-documentation.md`, ex `-2.md`, `FILAMENT_V4_UPGRADE.md`, `filament_v4_upgrade.md`) ·
`filament/archive/filament-v4-icon-size-fix.md` (+ maiuscolo/underscore) ·
`filament/archive/filament-v4-upgrade.md` (+ maiuscolo/underscore) ·
`guides/event-sourcing.md`/`guides/event_sourcing.md` (stub) ·
`guides/archive/event-sourcing.md`/`guides/archive/event_sourcing.md` ·
`llm-wiki/agents.md`/`llm-wiki/AGENTS.md` ·
`performance/activity-log-optimization.md` (+ `activity-log-optimization-module.md`, ex `-2.md`, `ACTIVITY_LOG_OPTIMIZATION.md`, `activity_log_optimization.md`) ·
`performance/archive/activity-log-optimization.md` (+ maiuscolo/underscore/`-renamed.md`) ·
`roadmap/00-index.md`/`roadmap/00-INDEX.md` · `wiki/AGENTS.md`/`wiki/agents.md` ·
`wiki/PROJECT-ROADMAP.md`/`wiki/project-roadmap.md` · `wiki/SCHEMA.md`/`wiki/schema.md` ·
`wiki/commands/INDEX.md`/`wiki/commands/index.md` · `wiki/concepts/INDEX.md`/`wiki/concepts/index.md` ·
`wiki/memories/INDEX.md`/`wiki/memories/index.md` · `wiki/rules/INDEX.md`/`wiki/rules/index.md` ·
`wiki/skills/INDEX.md`/`wiki/skills/index.md` · `tecnico/laraxot/archive/module-activity.md`/`module_activity.md` ·
`use_cases/shop/archive/console-commands.md`/`console_commands.md` (entrambi stub vuoti) ·
`00-index.md`/`00-INDEX.md` (+ `00-index-documentation.md` quasi vuoto).

**Nota**: `bad-practices.md`, `best-practices.md`, `code-quality.md`, `mcp_server_recommended.md`/`MCP_SERVER_RECOMMENDED.md`,
`boost_skill_fix_summary.md`, `phpmd_analysis.md`/`PHPMD_ANALYSIS.md` non sono duplicati del contenuto reale:
sono stub con frontmatter `canonical:` che puntano a `Themes/docs/shared-components/...` (vedi sezione dedicata
sotto). Coesistono per coincidenza di nome con le varianti che invece hanno contenuto reale — non vanno confusi.

### Numerazioni progressive (`-1`, `-2`, `-duplicate`, `-latest`) con contenuto quasi identico

`advanced-event-sourcing-patterns.md` (+ `-1.md`, `-duplicate.md`, `advanced_event_sourcing_patterns.md`, e imparentato `advanced-event-sourcings.md`) ·
`business-logic-analysis.md` (+ `-1.md`) · `dry-kiss-analysis.md` (+ `-latest.md`, `-.md`) ·
`errori-migrazione-activity-table-lezioni.md` (+ `-1.md`, `errori_migrazione_activity_table_lezioni.md`) ·
`filament-errors.md` (+ `-duplicate.md`, `filament_errors.md`) ·
`filament-resource-guidelines.md` (+ `-1.md`, maiuscolo, underscore) ·
`lang-link.md` (+ `-1.md`, `-duplicate.md`, `lang_link.md`) ·
`login-test-implementation-summary.md` (+ `-1.md`, underscore) ·
`login-test-implementation-sumy.md` (+ `-1.md`, refuso di "summary") ·
`metodi-duplicati-analisi.md` (+ maiuscolo/underscore) · `modelli-factory-seeder-analisi.md` (+ `-1.md`, underscore) ·
`phpstan-analysis-november.md`/`phpstan-analysis-november-2025.md` · `phpstan-fixes.md` (+ `-1.md`, stub underscore) ·
`phpstan-fixes-activity.md` (+ `-1.md`, underscore) · `quality-status.md` (+ `-.md`, `-2025-11.md`; `-nov.md` e' stub) ·
`roadmap-2025.md`/`roadmap-.md` (+ `roadmap-archive-1.md`, quasi identico con 2 righe di differenza) ·
`event-sourcing-examples-duplicate.md`/`event_sourcing_examples.md` (+ stub `event-sourcing-examples.md`) ·
`event-sourcing-introduction-duplicate.md`/`event_sourcing_introduction.md` (+ stub `event-sourcing-introduction.md`) ·
`test-archive-1.md`/`test-archive-2.md` (entrambi vuoti).

### Collisione di naming con contenuto diverso (attenzione, non fondere alla cieca)

- `module-analysis.md` (87 righe, "Comprehensive Analysis") vs `module_analysis.md` (319 righe, "Modulo Activity - Logging e Event Sourcing"): nomi quasi identici, contenuto diverso. `module_analysis.md` e' invece un quasi-duplicato di `module.md` (320 righe, stesso titolo).
- `structure.md` (root, 414 righe) vs `architecture/structure.md` (413 righe): stesso titolo "Modulo Activity", da verificare a mano se sono la stessa cosa copiata in due posti o se sono divergenti.
- `testing-structure-login-analysis.md` (root, 186 righe) vs `architecture/testing-structure-login-analysis.md` (174 righe): stesso titolo "Struttura Corretta dei Test di Login - Analisi Completa".
- `mcp-server-recommended.md`/`MCP-SERVER-RECOMMENDED.md` (contenuto reale, 23 righe) vs `mcp_server_recommended.md`/`MCP_SERVER_RECOMMENDED.md` (stub puntatore Themes, 7 righe): quattro file quasi omonimi, due ruoli diversi.
- `bad-practices.md`/`best-practices.md` (trattino, stub puntatore Themes) vs `bad_practices.md`/`best_practices.md` (underscore, contenuto reale locale): stesso schema del punto precedente.
- `git-conflicts-resolution-summary.md` (contenuto reale) vs `git-conflicts-resolution-sumy.md` (stub puntatore Themes, refuso "sumy" per "summary").
- `merge-conflicts-list.md` (contenuto reale) vs `merge-conflict-files-list.md` (stub puntatore Themes, nome simile ma non identico).

### Duplicazione sistemica: serie numerata + alias senza numero

Interessa `docs/roadmap/` e i tre alberi `docs/use_cases/{bank,prediction_market,shop}/`:
ogni sezione ha sia un file numerato (`01-introduzione.md`, `02-architettura.md`, ...) sia
un alias omonimo senza numero (`introduzione.md`, `architettura.md`, ...) con contenuto
quasi identico. La serie numerata e' quella collegata come riferimento di lettura nelle
sezioni sopra; gli alias non sono cancellati. Esempio verificabile:

```bash
find Modules/Activity/docs/use_cases Modules/Activity/docs/roadmap -regextype posix-extended \
  -regex '.*/[0-9]{2}-[a-z-]+\.md'
```

### Configuration
The module can be configured through the `config/activity.php` file:
- Log retention policies
- Activity types to track
- Database connection settings

63 file sotto `docs/` sono stub minimi (6-7 righe) con frontmatter `module: theme` +
`canonical: ../../../Themes/docs/shared-components/...` (pattern architetturale
intenzionale di "on-demand", non un incidente di duplicazione): `ai-methodologies.md`,
`aws_test_vs_database_connection.md`, `bad-practices.md`, `best-practices.md`,
`boost_skill_fix_summary.md`, `business-logic.md`, `code-quality.md`, `codex-error-fix.md`,
`event-sourcing-examples.md`, `event-sourcing-introduction.md`, `event-sourcing.md`,
`filament/filament-v4-upgrade.md`, `filaments.md`, `file-naming-rules.md`,
`git-conflicts-resolution-sumy.md`, `guides/event-sourcing.md`, `guides/event_sourcing.md`,
`jpgraph.md`, `logging_optimization.md`, `login-test-implementation.md`,
`mcp_server_recommended.md`, `MCP_SERVER_RECOMMENDED.md`, `merge-conflict-files-list.md`,
`metodiuplicati-analisi.md`, `migration-filament.md`, `migration-filament.md`,
`migrazione-filament.md`, `migrazione-filament.md`, `outputs/README.md`,
`performance/archive/activity_log_optimization-renamed.md`, `phpinsightss.md`,
`phpmd.md`, `phpmd.md`, `phpmd_analysis.md`, `PHPMD_ANALYSIS.md`, `phpmds.md`,
`phpstan.md`, `phpstan_fixes.md`, `quality-status-nov.md`, `query-optimization.md`,
`query-optimization-analysis.md`, `raw/README.md`, `redundancy_analysis.md`,
`REDUNDANCY_ANALYSIS.md`, `simplechartwidget-quality-analysis.md`,
`tecnico/laraxot/module_activity.md`, `wiki/bmad-method.md`, e le varianti "best-practice"/
"analysis"/"flusso-utente"/"console-commands" dentro `use_cases/bank/`,
`use_cases/prediction_market/` e `use_cases/shop/` (incluso `use_cases/shop/archive/`).
Non richiedono consolidamento: sono puntatori voluti, non copie accidentali.

## Related Modules
- [User Module](../User/docs/README.md) - User authentication and management
- [Notify Module](../Notify/docs/index.md) - Notification system
- [Xot Module](../Xot/docs/index.md) - Core base classes
- [User Module](../user/docs/readme.md) - User authentication and management
- [Notify Module](../notify/docs/index.md) - Notification system
- [Xot Module](../xot/docs/index.md) - Core base classes

Quattro copie parallele dello stesso lotto di file di test/placeholder, quasi tutte a
0-3 righe (`archived-note.md`, `documentation*.md`, `2024-03-27.md`, `test*.md`,
`import-placeholder*.md`, `filament*.md`, `changelog*.md`): presenti sia direttamente
in `docs/` (es. `test02.md`, `test-archive-1.md`, `archived-note.md`), sia in
`docs/root-md-files/`, `docs/root-txt-files/` e `docs/raw/root-import/`. Non collegati
individualmente in questo indice perche' privi di contenuto informativo; elencabili con:

```bash
find Modules/Activity/docs/root-md-files Modules/Activity/docs/root-txt-files \
  Modules/Activity/docs/raw/root-import -name '*.md'
```

Questi 4 gruppi restano come testimonianza storica di un import automatico mal riuscito
(vedi anche `docs/no-ai-tool-scaffold-dirs.md` per la policy su cartelle-scaffold).

### File placeholder vuoti (solo titolo H1, zero contenuto)

`domain-logic.md`, `data-models.md`, `validation.md`, `integration.md`, `workflows.md`,
`troubleshooting.md`, `2024-03-27.md`, `archived-note.md`, `documentation.md`,
`documentation-archive-1.md` e i loro equivalenti nelle
cartelle di import grezzo sopra citate (49 file a 0 righe in tutto il modulo).

## Numeri di questo audit

- File `.md` totali sotto `docs/`: 755.
- Cluster di duplicati quasi identici individuati (nome normalizzato + confronto righe): 92, per 227 file coinvolti.
- File completamente vuoti (0 righe): 49.
- File stub con puntatore `canonical:` verso `Themes/docs/shared-components/`: 73 (di cui 6 template `_templates/`, 4 ibridi con contenuto reale aggiuntivo, 63 stub puri).
- File indicizzati esplicitamente per argomento in questo documento: la quasi totalita' dei restanti file con contenuto reale; le eccezioni (import grezzo/placeholder vuoti) sono referenziate per gruppo con comando `find` riproducibile, non singolarmente.