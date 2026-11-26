---
title: "Indice documentazione — Modulo Activity"
type: index
status: active
updated: 2026-11-25
tags: [docs, activity]
qmd: "indice documentazione modulo activity architecture naming debt kebab-case"
---

# Indice documentazione — Modulo Activity

Indice per argomento di tutti i `.md` sotto `Modules/Activity/docs/`: 99 file al 2026-11-25 (erano 755 al 2026-09-03, poi la cartella e' stata ridotta al tetto di 100 `.md`). Nomi: kebab-case, senza date nel filename.

Nessun file e' stato rinominato o cancellato per produrre questo indice. Dove esistono duplicati palesi (stesso argomento con e senza prefisso numerico), la variante numerata e' quella canonica e quella senza prefisso e' elencata come legacy.

## Come leggere questo modulo

1. [README.md](README.md) — panoramica del modulo, quick start.
2. [wiki/index.md](wiki/index.md) — "second brain" del modulo (concetti, regole, memorie, troubleshooting); [wiki/README.md](wiki/README.md) ne descrive le cartelle.
3. [adr/README.md](adr/README.md) — perche' il modulo ha le forme che ha (decisioni architetturali).
4. [contracts/README.md](contracts/README.md) — contratti comportamentali delle operazioni.
5. [roadmap/README.md](roadmap/README.md) — roadmap del modulo.
6. [manuals/manuale-utente.md](manuals/manuale-utente.md) — manuale utente del pannello Activity.
7. [CHANGELOG.md](CHANGELOG.md) — rimando al changelog del modulo.

## Decisioni (ADR)

- [adr/README.md](adr/README.md) — metodo e formato degli ADR del modulo; [adr/index.md](adr/index.md) — elenco con stato.
- [adr/0001-activity-audit-is-append-oriented.md](adr/0001-activity-audit-is-append-oriented.md) — la cronologia di audit non si riscrive.
- [adr/0002-activity-models-on-dedicated-connection.md](adr/0002-activity-models-on-dedicated-connection.md) — i modelli usano la connessione `activity`.
- [adr/0003-log-viewer-single-path-resolver.md](adr/0003-log-viewer-single-path-resolver.md) — un solo risolutore di percorsi per il visualizzatore dei log.
- [adr/0000-template.md](adr/0000-template.md) — template.
- Legacy, stessi tre ADR senza prefisso numerico (da consolidare): [adr/activity-audit-is-append-oriented.md](adr/activity-audit-is-append-oriented.md), [adr/activity-models-on-dedicated-connection.md](adr/activity-models-on-dedicated-connection.md), [adr/log-viewer-single-path-resolver.md](adr/log-viewer-single-path-resolver.md).

## Contratti

- [contracts/README.md](contracts/README.md) — contratti del modulo Activity.
- [contracts/index.md](contracts/index.md) — indice dei contratti: operazione, classe, invarianti.

## Wiki (second brain del modulo)

- [wiki/index.md](wiki/index.md) — indice della wiki (catalogo fermo al 2026-06-10).
- [wiki/log.md](wiki/log.md) — registro datato di cio' che e' cambiato nel modulo e nei docs.
- [wiki/agents.md](wiki/agents.md) — istruzioni per gli agenti sulla wiki; [wiki/ai-methodologies.md](wiki/ai-methodologies.md) e [wiki/bmad-method.md](wiki/bmad-method.md) — stub puntatori.
- [wiki/topics/00-index.md](wiki/topics/00-index.md) — sintesi tematiche di `wiki/topics/` (29 file, indice incluso).
- [wiki/concepts/index.md](wiki/concepts/index.md), [wiki/concepts/log-viewer-sicurezza.md](wiki/concepts/log-viewer-sicurezza.md) — concetti; il secondo spiega la catena Action che porta un file di `storage/logs` nel pannello e cosa impedisce di leggere altri file.
- [wiki/rules/index.md](wiki/rules/index.md), [wiki/skills/index.md](wiki/skills/index.md), [wiki/commands/index.md](wiki/commands/index.md) — indici delle sotto-sezioni.
- [wiki/memories/index.md](wiki/memories/index.md), [wiki/memories/testcase-hierarchy-decision.md](wiki/memories/testcase-hierarchy-decision.md), [wiki/memories/phpstan-bootstrap-marker-blocker.md](wiki/memories/phpstan-bootstrap-marker-blocker.md) — memorie.
- [wiki/troubleshooting/git-merge-conflict-inventory.md](wiki/troubleshooting/git-merge-conflict-inventory.md), [wiki/troubleshooting/git-merge-conflict-inventory-april.md](wiki/troubleshooting/git-merge-conflict-inventory-april.md) — inventari dei conflitti di merge.
- [wiki/_templates/concept.md](wiki/_templates/concept.md), [wiki/_templates/entity.md](wiki/_templates/entity.md), [wiki/_templates/source.md](wiki/_templates/source.md) — template per nuove pagine wiki, non contenuto.
- [llm-wiki/index.md](llm-wiki/index.md), [llm-wiki/agents.md](llm-wiki/agents.md) — scaffold parallelo, in gran parte vuoto.

## BMAD, story e audit

- [bmad/README.md](bmad/README.md), [bmad/index.md](bmad/index.md) — integrazione BMAD del modulo e suo indice.
- Story in `bmad/stories/` (la variante numerata e' canonica, quella senza prefisso e' legacy):
  - [0005-module-bmad-audit.story.md](bmad/stories/0005-module-bmad-audit.story.md) / [module-bmad-audit.story.md](bmad/stories/module-bmad-audit.story.md) — audit BMAD profondo del modulo.
  - [0007-php-conflict-markers.story.md](bmad/stories/0007-php-conflict-markers.story.md) — risoluzione dei marker di conflitto PHP.
  - [0011-phpstan-resurrected-duplicate-tests.story.md](bmad/stories/0011-phpstan-resurrected-duplicate-tests.story.md) — test duplicati resuscitati dalla sync.
  - [0015-phpstan-swarm-cluster5-4.story.md](bmad/stories/0015-phpstan-swarm-cluster5-4.story.md) / [phpstan-swarm-cluster5.story.md](bmad/stories/phpstan-swarm-cluster5.story.md) — PHPStan swarm cluster 5.
  - [0019-quality-gates-phpstan-fix-4.story.md](bmad/stories/0019-quality-gates-phpstan-fix-4.story.md) / [quality-gates-phpstan-fix.story.md](bmad/stories/quality-gates-phpstan-fix.story.md) — remediation PHPStan della flotta di moduli.
  - [quality-gates-phpstan-swarm.story.md](bmad/stories/quality-gates-phpstan-swarm.story.md) — PHPStan quality gate swarm.
  - [folio-routing-centralization.story.md](bmad/stories/folio-routing-centralization.story.md) — il routing Folio e' centralizzato, Activity non monta Folio.
  - [0000-template.story.md](bmad/stories/0000-template.story.md) — template.
- Story in `stories/`:
  - [0002-activity-admin-log-viewer-page.story.md](stories/0002-activity-admin-log-viewer-page.story.md) / [activity-admin-log-viewer-page.story.md](stories/activity-admin-log-viewer-page.story.md) — pagina Log nel pannello Activity.
  - [audit-qualita.story.md](stories/audit-qualita.story.md) — audit qualita' del modulo.
  - [phpstan-cleanup-activity-wave.story.md](stories/phpstan-cleanup-activity-wave.story.md) — PHPStan cleanup.
  - [0000-template.story.md](stories/0000-template.story.md) — template.
- [ecc/00-index.md](ecc/00-index.md) — indice operativo ECC: stato dei controlli (PHPStan, Pest, security) con evidenze.

## Roadmap e prodotto

- [roadmap/README.md](roadmap/README.md) — roadmap del modulo (entry point principale); [roadmap/index.md](roadmap/index.md) — indice della roadmap.

## Casi d'uso Event Sourcing (approfondimenti didattici)

- [use_cases/bank/README.md](use_cases/bank/README.md) e [use_cases/bank/index.md](use_cases/bank/index.md) — Larabank: caso d'uso bancario con event sourcing.
- [use_cases/prediction_market/README.md](use_cases/prediction_market/README.md) e [use_cases/prediction_market/index.md](use_cases/prediction_market/index.md) — prediction market con event sourcing.
- [use_cases/shop/README.md](use_cases/shop/README.md) e [use_cases/shop/index.md](use_cases/shop/index.md) — carrello della spesa con event sourcing e console commands.

## Report PDF e grafici

- [charts/README.md](charts/README.md) — integrazione dei widget Filament per i grafici.
- [html2pdf/index.md](html2pdf/index.md) — stub puntatore alla documentazione canonica nel modulo Media.

## Digest e output

- [digests/overflow-history.md](digests/overflow-history.md) — sezioni condensate dei file oltre il tetto di 100 `.md` (una sezione per file, intitolata col percorso originale).
- [digests/archive-archive.md](digests/archive-archive.md), [digests/archive-raw.md](digests/archive-raw.md), [digests/aliases-removed.md](digests/aliases-removed.md) — elenchi delle sorgenti fuse e degli alias rimossi.
- [outputs/README.md](outputs/README.md) — cartella degli output generati.

## Rimossi e recuperabili da git

- `tasks/` (36 file: `tasks-index.md`, `001`..`005`, `activity-ai-detection`, `activity-filament-v5`, `cleanup-activity-docs`, `documentation/*`, `features/*`, `refactoring/*`, `testing/*`): rimossa nel commit `7e00cedf` del 2026-10-08. Ogni file e' recuperabile con `git show 7e00cedf^:docs/tasks/<percorso>`.
- `roadmap/tasks/` (enhanced-activity-filtering, gdpr-compliance-enhancement, realtime-monitoring-dashboard): rimossa nello stesso commit `7e00cedf`; recuperabile con `git show 7e00cedf^:docs/roadmap/tasks/<nome>.md`.
- `docs-archive-policy.md`: rimosso nel commit `a871d44e` del 2026-10-08.
- `00-index.md` della radice di `docs/`: rimosso il 2026-10-22 (commit `7e2a1509`, insieme a `index.md` e a `wiki/index.md`, poi ricreati); l'indice di tutta la cartella docs e' questo file.
- Le versioni precedenti di questo indice elencavano molti altri file (architettura, Filament, PHPStan, testing, event sourcing, migrazioni) che oggi non esistono piu' in `docs/`: la cronologia git e' l'unica fonte.
