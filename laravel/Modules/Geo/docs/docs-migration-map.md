---
title: "Mappa di migrazione della radice di docs"
type: migration-map
status: proposed
updated: 2026-10-25
tags: [docs, migration-map, geo, p4-docs-geo]
qmd: "geo docs migration map root cleanup"
---

# Mappa di migrazione della radice di `docs/`

Fase BMAD: documentazione/qualita. Questa mappa e una **proposta**: nessun file e stato spostato, rinominato o cancellato. Ogni riga ha stato `proposto` finche una persona non decide (vedi sezione "Decisioni richieste").

File lungo per costruzione (una riga per ognuno dei 622 file della radice): e una tabella di dati, non prosa.

Punto d ingresso: [INDEX.md](./index.md). Registro decisioni: [decision-log.md](./decision-log.md).

## Stato reale al 2026-10-25 (riconciliazione)

Le tabelle sotto sono lo **snapshot del 2026-10-14**: le coppie case-twin che elencano sono state chiuse. Stato misurato il 2026-10-25:

- `docs/` radice: **0 gruppi** case-twin. Canonico = nome minuscolo, gemello archiviato come `*.old` (eccezione ammessa: `LICENSE` senza estensione).
- `docs/raw/` (archivio storico, non indicizzato): **16 gruppi** invariati — `raw/history` 15, `raw/errors` 1.
- `docs/wiki`, `docs/schema`, `docs/llm-wiki`: `AGENTS.md`/`agents.md` (3 gruppi, aperti).

Nomi finali delle coppie di radice:

| Coppia | Canonico | Archiviato / rinominato |
|---|---|---|
| `DOCS-MIGRATION-MAP.md` / `docs-migration-map.md` | `docs-migration-map.md` | `DOCS-MIGRATION-MAP.md.old` |
| `PHILOSOPHY.md` / `philosophy.md` (stub) | `philosophy.md` (corpo pieno v2.0, puntatore al tema integrato) | `philosophy.md.old` |
| `PRD.md` / `prd.md` (PRD free-OSM) | `prd.md` (PRD completo) | `prd-geo-maps.md` |
| `ROADMAP.md` / `roadmap.md` (indice di `roadmap/`) | `roadmap.md` (roadmap piena) | `roadmap-indice.md` |
| `LICENSE` / `license` | `LICENSE` | `license.old` |
| `CHANGELOG.md` / `changelog.md` | `changelog.md` | `CHANGELOG.md.old` |
| `LICENSE.md` / `license.md` | `license.md` | `LICENSE.md.old` |

## Misura di partenza

- File nella radice di `docs/` (misurati prima di creare questo file): **622**, di cui **575** `.md` e **47** non documentazione (configurazione, tooling, file senza estensione).
- Copie byte-identiche (stesso md5) di un altro file della radice: **62** (in **62** gruppi). Per ciascun gruppo e indicato un canonico; le altre copie sono proposte per `wiki/_archive/duplicates/`.
- Destinazioni gia occupate da un file con lo stesso nome: **78** (**59** identici, **19** diversi). Per i diversi lo spostamento sovrascriverebbe contenuto: la nota della riga lo segnala e serve un confronto.
- Indici concorrenti nella radice: `index.md`, `00-index.md`, `00-index.md`, `index.md` (indice PTVX generico, non di Geo), `indice-documentazione.md`, `indice-documentazione.md`, `indiceocumentazione.md`, `documentation-index.md`, `rules-index.md`, `start-here.md`, `modules-optimization-index.md`, `testing-supreme-index.md`.
- Link relativi (strumento `bashscripts/tools/docs/docs-organizer.py links`, escluse `raw/` e `stories/`): vedi `docs/decision-log.md`, voce del 2026-10-14, per i numeri prima e dopo.
- Il filesystem di sviluppo distingue le maiuscole ma Windows/macOS no: molte coppie (`prd.md`/`prd.md`, `bad-practices.md`/`bad-practices.md`) collidono su un clone case-insensitive. Il file `case-conflicts.md` ne parla.

## Riepilogo per gruppo

| Gruppo | Descrizione | File | Destinazione proposta |
|---|---|---|---|
| R | Resta in radice (punto d ingresso) | 4 | `(radice)` |
| A | Indici e navigazione | 12 | `wiki/_archive/indexes/` |
| B | Contratti, regole e policy | 42 | `rules/` |
| C | Piani di prodotto, roadmap e sprint | 31 | `roadmap/` |
| D | Report PHPStan e qualita del codice | 82 | `phpstan/` |
| E | Conflitti git e merge | 19 | `merge-conflicts/` |
| F | Audit ridondanza e duplicati | 64 | `analysis/` |
| G | Provider geocoding e integrazioni | 23 | `integrations/` |
| H | Strumenti AI, MCP e agenti | 18 | `ai/` |
| I | Azioni e logica applicativa | 10 | `actions/` |
| J | Modello indirizzo, comuni, Sushi e JSON | 127 | `models/` |
| K | Componenti Filament, indirizzo e mappa | 65 | `filament/` |
| L | Testing | 13 | `testing/` |
| M | Architettura, filosofia e guide | 48 | `architecture/` |
| N | Report di sessione e riepiloghi | 8 | `wiki/_archive/reports/` |
| Z | File di configurazione e tooling copiati nella radice | 50 | `config/` |
| Y | Da classificare (revisione umana) | 6 | varie, riga per riga |

Le destinazioni sono cartelle **gia esistenti** in `docs/` (`rules/`, `phpstan/`, `roadmap/`, `merge-conflicts/`, `analysis/`, `integrations/`, `ai/`, `mcp/`, `actions/`, `models/`, `filament/`, `testing/`, `architecture/`, `config/`, `_integration/`, `wiki/_archive/`) tranne le sottocartelle `wiki/_archive/{indexes,duplicates,reports,unclassified}/`. Nessuna cartella nuova di primo livello.

## Decisioni richieste prima di eseguire

1. **Duplicati**: approvare `wiki/_archive/duplicates/` come destinazione delle 62 copie byte-identiche (oppure marcarle `status: superseded` con `docs-organizer.py dups --fix` e lasciarle dove sono).
2. **Configurazione nella radice**: i 50 file del gruppo Z non sono documentazione. 7 esistono anche nella radice del modulo ma con contenuto diverso (`.gitattributes`, `.gitignore`, `composer.json`, `module.json`, `package.json`, `vite.config.js`, `webpack.mix.js`); gli altri 43 non esistono nel modulo. Decidere se sono copie obsolete (archivio) o se vanno ripristinati nel modulo.
3. **Riscrittura dei link**: ogni spostamento rompe i link relativi verso e dal file. Procedura: spostare per gruppo con `git mv`, poi `python3 bashscripts/tools/docs/docs-organizer.py links laravel/Modules/Geo/docs --fix` e rimisurare fino a zero link correggibili.
4. **Gruppo Y**: sei file senza bersaglio certo (quattro scratch di test e due file dal nome malformato) richiedono una decisione umana.
5. **Destinazioni occupate**: le 19 righe con "DESTINAZIONE GIA OCCUPATA" non vanno spostate con `git mv` senza prima confrontare i due file (rinominare, fondere o archiviare); le 59 con file identico si risolvono archiviando la copia in radice.
6. **Nomi corrotti**: i file con la nota "nome corrotto o sospetto" derivano da una sostituzione di massa (lettere perse, suffisso `-sumy`, trattino finale). Se hanno un omonimo con nome corretto e contenuto uguale vanno archiviati; se il contenuto e unico, serve un nome corretto deciso da una persona.

## Come leggere le tabelle

`Vecchio` e il percorso attuale rispetto a `docs/`; `Nuovo proposto` il percorso di destinazione; `Scopo` e il titolo `#` del file (o il campo `title`); `Nota` riporta le prove misurate (md5, link in ingresso dai `.md` di `docs/`, dimensione). Percorsi in `code` e non link, cosi la mappa non genera link rotti.

## Gruppo R: Resta in radice (punto d ingresso) (4)

Motivo del gruppo: punti d ingresso e registri da tenere in radice. Stato: `proposto` (nessun cambiamento).

| Vecchio | Nuovo proposto | Scopo | Nota | Stato |
|---|---|---|---|---|
| `changelog.md` | `changelog.md` | Changelog | omonimo con contenuto diverso: `changelog.md`; link in ingresso: 0 | proposto |
| `decision-log.md` | `decision-log.md` | Decision Log - Geo | link in ingresso: 2 | proposto |
| `index.md` | `index.md` | Geo Module Documentation Index | omonimo con contenuto diverso: `index.md`; link in ingresso: 5 | proposto |
| `README.md` | `README.md` | Modulo Geo | link in ingresso: 43 | proposto |

## Gruppo A: Indici e navigazione (12)

Motivo del gruppo: indice doppio: il punto d ingresso unico e INDEX.md. Stato di tutte le righe: `proposto`.

| Vecchio | Nuovo proposto | Scopo | Nota | Stato |
|---|---|---|---|---|
| `00-index.md` | `wiki/_archive/indexes/00-INDEX.md` | Geo Module - Documentation Index | omonimo con contenuto diverso: `00-index.md`; collisione di maiuscole nella destinazione; link in ingresso: 1 | proposto |
| `00-index.md` | `wiki/_archive/indexes/00-index.md` | Indice Documentazione Modulo Geo | omonimo con contenuto diverso: `00-index.md`; collisione di maiuscole nella destinazione; link in ingresso: 5 | proposto |
| `docs-health.md` | `wiki/_archive/indexes/docs-health.md` | Docs Health - Geo | link in ingresso: 0 | proposto |
| `documentation-index.md` | `wiki/_archive/indexes/documentation-index.md` | Indice della Documentazione del Modulo Geo | link in ingresso: 0 | proposto |
| `index.md` | `wiki/_archive/indexes/index.md` | PTVX - Documentazione Completa | omonimo con contenuto diverso: `index.md`; link in ingresso: 1 | proposto |
| `indice-documentazione.md` | `wiki/_archive/indexes/indice-documentazione.md` | Indice della Documentazione del Modulo Geo | canonico delle copie byte-identiche; link in ingresso: 0 | proposto |
| `indice-documentazione.md` | `wiki/_archive/duplicates/indice_documentazione.md` | Indice della Documentazione del Modulo Geo | copia byte-identica di `indice-documentazione.md`; link in ingresso: 0 | proposto |
| `indiceocumentazione.md` | `wiki/_archive/indexes/indiceocumentazione.md` | indiceocumentazione | stub (<200 caratteri); nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `modules-optimization-index.md` | `wiki/_archive/indexes/modules-optimization-index.md` | Indice Completo - Analisi e Ottimizzazioni Moduli | link in ingresso: 0 | proposto |
| `rules-index.md` | `wiki/_archive/indexes/rules-index.md` | rules index | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `start-here.md` | `wiki/_archive/indexes/start-here.md` | START HERE - PTVX Project Documentation | link in ingresso: 0 | proposto |
| `testing-supreme-index.md` | `wiki/_archive/indexes/testing-supreme-index.md` | INDICE SUPREMO: Testing Business Behavior Rules | identico anche a `testing/testing-supreme-index.md`; link in ingresso: 0 | proposto |

## Gruppo B: Contratti, regole e policy (42)

Motivo del gruppo: regola o convenzione normativa: casa naturale rules/. Stato di tutte le righe: `proposto`.

| Vecchio | Nuovo proposto | Scopo | Nota | Stato |
|---|---|---|---|---|
| `anti-patterns.md` | `rules/anti-patterns.md` | Anti-Pattern Comuni in Laraxot | link in ingresso: 1 | proposto |
| `bad-practices.md` | `rules/bad-practices.md` | Bad Practices - Geo Module | canonico delle copie byte-identiche; link in ingresso: 0 | proposto |
| `bad-practices.md` | `rules/BAD_PRACTICES.md` | Bad Practices - Geo Module | omonimo con contenuto diverso: `bad-practices.md`; link in ingresso: 0 | proposto |
| `bad-practices.md` | `wiki/_archive/duplicates/bad_practices.md` | Bad Practices - Geo Module | copia byte-identica di `bad-practices.md`; link in ingresso: 0 | proposto |
| `best-practices.md` | `rules/best-practices.md` | Best Practices - Geo Module | canonico delle copie byte-identiche; link in ingresso: 9 | proposto |
| `best-practices.md` | `rules/BEST_PRACTICES.md` | Best Practices - Geo Module | omonimo con contenuto diverso: `best-practices.md`; link in ingresso: 0 | proposto |
| `best-practices.md` | `wiki/_archive/duplicates/best_practices.md` | Best Practices - Geo Module | copia byte-identica di `best-practices.md`; link in ingresso: 0 | proposto |
| `boy-scout-rule.md` | `rules/boy-scout-rule.md` | Regola del Buon Boy Scout - Progetto nome progetto | link in ingresso: 0 | proposto |
| `contracts-naming.md` | `rules/contracts-naming.md` | Contracts Naming & Placement in Geo | link in ingresso: 0 | proposto |
| `dependabot-security-policy.md` | `rules/dependabot-security-policy.md` | Dependabot & Security Policy | link in ingresso: 0 | proposto |
| `factory-best-practices.md` | `rules/factory-best-practices.md` | Factory Best Practices - Laraxot nome progetto | link in ingresso: 1 | proposto |
| `factory-email-rule.md` | `rules/factory-email-rule.md` | Regola Critica: Email nelle Factory - Progetto nome progetto | link in ingresso: 0 | proposto |
| `false-friends.md` | `rules/false-friends.md` | False Friends - Geo Module | canonico delle copie byte-identiche; link in ingresso: 0 | proposto |
| `false-friends.md` | `rules/FALSE_FRIENDS.md` | False Friends - Geo Module | omonimo con contenuto diverso: `false-friends.md`; link in ingresso: 0 | proposto |
| `false-friends.md` | `wiki/_archive/duplicates/false_friends.md` | False Friends - Geo Module | copia byte-identica di `false-friends.md`; link in ingresso: 0 | proposto |
| `filament-extension-rules.md` | `rules/filament-extension-rules.md` | Filament Class Extension Rules | omonimo con contenuto diverso: `filament-extension-rules.md`; link in ingresso: 0 | proposto |
| `filament-extension-rules.md` | `rules/filament_extension_rules.md` | filament extension rules | stub (<200 caratteri); omonimo con contenuto diverso: `filament-extension-rules.md`; link in ingresso: 4 | proposto |
| `file-naming-rules.md` | `rules/file-naming-rules.md` | file naming rules | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `folio-volt-best-practices.md` | `rules/folio-volt-best-practices.md` | folio volt best practices | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `forbidden-docs-directories-rule.md` | `rules/forbidden-docs-directories-rule.md` | Forbidden Documentation Directories Rule | link in ingresso: 1 | proposto |
| `inheritance-analysis-rule.md` | `rules/inheritance-analysis-rule.md` | Inheritance Analysis Rule - Critical Requirement | link in ingresso: 0 | proposto |
| `laraxot-architecture-principles.md` | `rules/laraxot-architecture-principles.md` | Principi Architetturali Laraxot: DRY + KISS + SOLID + ROBUST + INTELLIGENT | link in ingresso: 1 | proposto |
| `laraxot-migration-principles-uuid-polymorphism.md` | `rules/laraxot-migration-principles-uuid-polymorphism.md` | Principi Migrazioni Laraxot: UUID e Polimorfismo Context-Aware | link in ingresso: 0 | proposto |
| `migration-naming-pattern-1.md` | `rules/migration-naming-pattern-1.md` | Convenzione di Naming e Gestione delle Migrazioni | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `migration-naming-pattern.md` | `rules/migration-naming-pattern.md` | migration naming pattern | stub (<200 caratteri); omonimo con contenuto diverso: `migration-naming-pattern.md`; link in ingresso: 0 | proposto |
| `migration-naming.md` | `rules/migration-naming.md` | migration naming | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `migration-naming-pattern.md` | `rules/migration_naming_pattern.md` | Convenzione di Naming e Gestione delle Migrazioni | omonimo con contenuto diverso: `migration-naming-pattern.md`; link in ingresso: 0 | proposto |
| `naming-conventions.md` | `rules/naming-conventions.md` | Convenzioni di Naming nel Modulo Geo | canonico delle copie byte-identiche; link in ingresso: 0 | proposto |
| `naming-conventions.md` | `wiki/_archive/duplicates/naming_conventions.md` | Convenzioni di Naming nel Modulo Geo | copia byte-identica di `naming-conventions.md`; link in ingresso: 0 | proposto |
| `nestedset-migration-best-practices.md` | `rules/nestedset-migration-best-practices.md` | NestedSet Migration Best Practices - Geo Module | link in ingresso: 0 | proposto |
| `no-ai-tool-scaffold-dirs.md` | `rules/no-ai-tool-scaffold-dirs.md` | Perché queste cartelle non devono esistere qui | link in ingresso: 0 | proposto |
| `no-phpstan-probe-policy.md` | `rules/no-phpstan-probe-policy.md` | No PHPStan probe files in Geo | link in ingresso: 1 | proposto |
| `rules-testing-no-migrate-fresh.md` | `rules/rules-testing-no-migrate-fresh.md` | rules testing no migrate fresh | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `script-organization.md` | `rules/script-organization.md` | Organizzazione Script - Regole Fondamentali | link in ingresso: 0 | proposto |
| `scripts-location-convention.md` | `rules/scripts-location-convention.md` | Convenzione Posizione Script | canonico delle copie byte-identiche; link in ingresso: 0 | proposto |
| `scripts-location-convention.md` | `wiki/_archive/duplicates/scripts_location_convention.md` | Convenzione Posizione Script | copia byte-identica di `scripts-location-convention.md`; link in ingresso: 0 | proposto |
| `testing-best-practices.md` | `rules/testing-best-practices.md` | Best Practices Testing Globali - nome progetto | link in ingresso: 1 | proposto |
| `testing-business-behavior-supreme-rule.md` | `rules/testing-business-behavior-supreme-rule.md` | REGOLA SUPREMA: TESTING BUSINESS BEHAVIOR ONLY | identico anche a `testing/testing-business-behavior-supreme-rule.md`; link in ingresso: 1 | proposto |
| `testing-principles.md` | `rules/testing-principles.md` | Principi di Testing | identico anche a `testing/testing-principles.md`; link in ingresso: 0 | proposto |
| `testing-priority-rule.md` | `rules/testing-priority-rule.md` | REGOLA ASSOLUTA: Priorità dei Test in Laraxot | link in ingresso: 4 | proposto |
| `testing-rules.md` | `rules/testing-rules.md` | testing rules | identico anche a `testing/testing-rules.md`; stub (<200 caratteri); link in ingresso: 1 | proposto |
| `windsurf-rules-update.md` | `rules/windsurf-rules-update.md` | Windsurf Rules Update - Forbidden Documentation Directories | link in ingresso: 0 | proposto |

## Gruppo C: Piani di prodotto, roadmap e sprint (31)

Motivo del gruppo: piano/roadmap/sprint: casa naturale roadmap/ (prodotto in project/). Stato di tutte le righe: `proposto`.

| Vecchio | Nuovo proposto | Scopo | Nota | Stato |
|---|---|---|---|---|
| `launch.md` | `roadmap/launch.md` | Product Launch Plan - Geo Module | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `prd.md` | `roadmap/PRD.md` | Product Requirements Document (PRD) - Geo Module | omonimo con contenuto diverso: `prd.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `prd.md` | `roadmap/prd.md` | Geo - Product Requirements Document (PRD) | omonimo con contenuto diverso: `prd.md`; collisione di maiuscole nella destinazione; link in ingresso: 1 | proposto |
| `product-launch-plan.md` | `roadmap/product-launch-plan.md` | product launch plan | stub (<200 caratteri); omonimo con contenuto diverso: `product-launch-plan.md`; link in ingresso: 0 | proposto |
| `product-roadmap.md` | `roadmap/product-roadmap.md` | product roadmap | stub (<200 caratteri); omonimo con contenuto diverso: `product-roadmap.md`; link in ingresso: 1 | proposto |
| `product-strategy.md` | `roadmap/product-strategy.md` | Geo - Product Strategy | omonimo con contenuto diverso: `product-strategy.md`; link in ingresso: 0 | proposto |
| `product-launch-plan.md` | `roadmap/PRODUCT_LAUNCH_PLAN.md` | Geo Module - Product Launch Plan | omonimo con contenuto diverso: `product-launch-plan.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `product-launch-plan.md` | `roadmap/product_launch_plan.md` | product launch plan | stub (<200 caratteri); omonimo con contenuto diverso: `product-launch-plan.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `product-roadmap.md` | `roadmap/PRODUCT_ROADMAP.md` | Geo Module - Product Roadmap | omonimo con contenuto diverso: `product-roadmap.md`; collisione di maiuscole nella destinazione; link in ingresso: 1 | proposto |
| `product-roadmap.md` | `roadmap/product_roadmap.md` | product roadmap | stub (<200 caratteri); omonimo con contenuto diverso: `product-roadmap.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `product-strategy.md` | `roadmap/PRODUCT_STRATEGY.md` | Geo Module - Product Strategy | omonimo con contenuto diverso: `product-strategy.md`; collisione di maiuscole nella destinazione; link in ingresso: 1 | proposto |
| `product-strategy.md` | `roadmap/product_strategy.md` | product strategy | stub (<200 caratteri); omonimo con contenuto diverso: `product-strategy.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `project-backup.md` | `roadmap/project-backup.md` | project backup | stub (<200 caratteri); omonimo con contenuto diverso: `project-backup.md`; link in ingresso: 0 | proposto |
| `project.md` | `roadmap/PROJECT.md` | PROJECT | omonimo con contenuto diverso: `project.md`; collisione di maiuscole nella destinazione; link in ingresso: 1 | proposto |
| `project.md` | `roadmap/project.md` | project | stub (<200 caratteri); omonimo con contenuto diverso: `project.md`; collisione di maiuscole nella destinazione; link in ingresso: 359 | proposto |
| `project-backup.md` | `roadmap/project_backup.md` | project backup | omonimo con contenuto diverso: `project-backup.md`; link in ingresso: 0 | proposto |
| `research.md` | `roadmap/research.md` | User Research - Geo Module | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `roadmap-and-issues.md` | `roadmap/roadmap-and-issues.md` | Geo Module - Roadmap, Issues & Optimization | link in ingresso: 0 | proposto |
| `roadmap-vision.md` | `roadmap/roadmap-vision.md` | Geo Module Roadmap 2026 | link in ingresso: 0 | proposto |
| `roadmap.md` | `roadmap/ROADMAP.md` | ROADMAP - Modulo Geo | omonimo con contenuto diverso: `roadmap.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `roadmap.md` | `roadmap/roadmap.md` | Roadmap (Module Geo) | omonimo con contenuto diverso: `roadmap.md`; collisione di maiuscole nella destinazione; link in ingresso: 370 | proposto |
| `sprint-planning.md` | `roadmap/sprint-planning.md` | sprint planning | stub (<200 caratteri); omonimo con contenuto diverso: `sprint-planning.md`; link in ingresso: 0 | proposto |
| `sprint.md` | `roadmap/sprint.md` | Sprint Planning Meeting - Geo Module | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `sprint-planning.md` | `roadmap/SPRINT_PLANNING.md` | Geo Module - Sprint Planning | omonimo con contenuto diverso: `sprint-planning.md`; collisione di maiuscole nella destinazione; link in ingresso: 1 | proposto |
| `sprint-planning.md` | `roadmap/sprint_planning.md` | sprint planning | stub (<200 caratteri); omonimo con contenuto diverso: `sprint-planning.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `stabilization-roadmap.md` | `roadmap/stabilization-roadmap.md` | Stabilization Roadmap - Geo Module | link in ingresso: 1 | proposto |
| `strategy.md` | `roadmap/strategy.md` | Product Strategy Doc - Geo Module | link in ingresso: 0 | proposto |
| `todo.md` | `roadmap/todo.md` | Geo Module - PHPStan Error Resolution Roadmap | link in ingresso: 0 | proposto |
| `user-research.md` | `roadmap/user-research.md` | user research | stub (<200 caratteri); omonimo con contenuto diverso: `user-research.md`; link in ingresso: 0 | proposto |
| `user-research.md` | `roadmap/USER_RESEARCH.md` | Geo Module - User Research | omonimo con contenuto diverso: `user-research.md`; collisione di maiuscole nella destinazione; link in ingresso: 2 | proposto |
| `user-research.md` | `roadmap/user_research.md` | user research | stub (<200 caratteri); omonimo con contenuto diverso: `user-research.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |

## Gruppo D: Report PHPStan e qualita del codice (82)

Motivo del gruppo: report puntuale di una sessione di correzione: obsoleto, storico. Stato di tutte le righe: `proposto`.

| Vecchio | Nuovo proposto | Scopo | Nota | Stato |
|---|---|---|---|---|
| `class-not-found-errors.md` | `phpstan/class-not-found-errors.md` | PHPStan Class Not Found Errors - Legacy Module References | omonimo con contenuto diverso: `class-not-found-errors.md`; link in ingresso: 0 | proposto |
| `class-not-founds.md` | `phpstan/class-not-founds.md` | class not founds | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `class-not-found-errors.md` | `phpstan/class_not_found_errors.md` | PHPStan Class Not Found Errors - Legacy Module References | omonimo con contenuto diverso: `class-not-found-errors.md`; link in ingresso: 2 | proposto |
| `code-quality-analysis.md` | `phpstan/code-quality-analysis.md` | Geo Module - Code Quality Analysis Report | link in ingresso: 0 | proposto |
| `code-quality-improvement-report.md` | `phpstan/code-quality-improvement-report.md` | Code Quality Improvement Report - Geo | link in ingresso: 0 | proposto |
| `code-quality-report.md` | `phpstan/code-quality-report.md` | Code quality - modulo Geo | link in ingresso: 0 | proposto |
| `code-quality.md` | `phpstan/code-quality.md` | Geo Module - Code Quality Analysis Report | link in ingresso: 0 | proposto |
| `codex-error-fix.md` | `phpstan/codex-error-fix.md` | codex error fix | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `complexity-refactoring-plan.md` | `phpstan/complexity-refactoring-plan.md` | Geo Module - Complexity Refactoring Plan | link in ingresso: 0 | proposto |
| `correzioni-phpstan-multiple-completate.md` | `phpstan/correzioni-phpstan-multiple-completate.md` | correzioni phpstan multiple completate | stub (<200 caratteri); omonimo con contenuto diverso: `correzioni-phpstan-multiple-completate.md`; link in ingresso: 0 | proposto |
| `correzioni-phpstan-multiple-completate.md` | `phpstan/CORREZIONI_PHPSTAN_MULTIPLE_COMPLETATE.md` | CORREZIONI PHPStan MULTIPLE COMPLETATE | omonimo con contenuto diverso: `correzioni-phpstan-multiple-completate.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `correzioni-phpstan-multiple-completate.md` | `phpstan/correzioni_phpstan_multiple_completate.md` | CORREZIONI PHPStan MULTIPLE COMPLETATE | omonimo con contenuto diverso: `correzioni-phpstan-multiple-completate.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `coverage-full.md` | `phpstan/coverage-full.md` | coverage full | omonimo con contenuto diverso: `coverage-full.md`; link in ingresso: 0 | proposto |
| `coverage.md` | `phpstan/coverage.md` | Code Coverage: Geo | link in ingresso: 0 | proposto |
| `coverage-clean.md` | `phpstan/coverage_clean.md` | Coverage Clean | link in ingresso: 0 | proposto |
| `coverage-full.md` | `phpstan/coverage_full.md` | Coverage Full | omonimo con contenuto diverso: `coverage-full.md`; link in ingresso: 0 | proposto |
| `cyclomatic-complexity-report.md` | `phpstan/cyclomatic-complexity-report.md` | Cyclomatic Complexity Report - Module: Geo | link in ingresso: 1 | proposto |
| `deprecated-form-method-upgrade.md` | `phpstan/deprecated-form-method-upgrade.md` | Deprecated Form Method Upgrade | link in ingresso: 0 | proposto |
| `dry-kiss-analysis.md` | `phpstan/dry-kiss-analysis.md` | DRY & KISS Analysis - Geo | link in ingresso: 0 | proposto |
| `dry-kiss-improvements.md` | `phpstan/dry-kiss-improvements.md` | Geo Module - DRY + KISS Improvements | link in ingresso: 0 | proposto |
| `factory-phpstan-fixes.md` | `phpstan/factory-phpstan-fixes.md` | Factory PHPStan Fixes - Geo Module | link in ingresso: 0 | proposto |
| `google-maps-service-provider-error.md` | `phpstan/google-maps-service-provider-error.md` | Errore FilamentGoogleMapsServiceProvider - Risoluzione | link in ingresso: 0 | proposto |
| `inheritance-violations-fixed.md` | `phpstan/inheritance-violations-fixed.md` | Violazioni Ereditarietà Corrette - Modulo Geo | canonico delle copie byte-identiche; link in ingresso: 0 | proposto |
| `inheritance-violationsed.md` | `phpstan/inheritance-violationsed.md` | inheritance violationsed | stub (<200 caratteri); nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `inheritance-violations-fixed.md` | `wiki/_archive/duplicates/inheritance_violations_fixed.md` | Violazioni Ereditarietà Corrette - Modulo Geo | copia byte-identica di `inheritance-violations-fixed.md`; link in ingresso: 0 | proposto |
| `model-casting-fix.md` | `phpstan/model-casting-fix.md` | Correzione Model Casting - Modulo Geo | identico anche a `models/model-casting-fix.md`; link in ingresso: 0 | proposto |
| `phpstan-activity-fixes-complete.md` | `phpstan/phpstan-activity-fixes-complete.md` | Correzioni PHPStan Modulo Activity Completate | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-activity-fixes-complete.md`; link in ingresso: 0 | proposto |
| `phpstan-activity-fixes-completed.md` | `phpstan/phpstan-activity-fixes-completed.md` | Correzioni PHPStan Modulo Activity Completate | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; canonico delle copie byte-identiche; identico anche a `phpstan/phpstan-activity-fixes-completed.md`; link in ingresso: 0 | proposto |
| `phpstan-activityesd.md` | `phpstan/phpstan-activityesd.md` | phpstan activityesd | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-activityesd.md`; stub (<200 caratteri); nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `phpstan-analysis-business-logic.md` | `phpstan/phpstan-analysis-business-logic.md` | PHPStan Analysis - Business Logic & Factory Issues | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; link in ingresso: 0 | proposto |
| `phpstan-analysis-geo.md` | `phpstan/phpstan-analysis-geo.md` | PHPStan Analysis - Geo Module | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-analysis-geo.md`; link in ingresso: 0 | proposto |
| `phpstan-analysis-pattern.md` | `phpstan/phpstan-analysis-pattern.md` | PHPStan Analysis Pattern - Lock & Dispatch | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-analysis-pattern.md`; link in ingresso: 0 | proposto |
| `phpstan-bing-maps-action-fix-completion.md` | `phpstan/phpstan-bing-maps-action-fix-completion.md` | PHPStan Fix Completion - GetAddressFromBingMapsAction - Gennaio 2026 | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; link in ingresso: 0 | proposto |
| `phpstan-bing-maps-action-fix-roadmap.md` | `phpstan/phpstan-bing-maps-action-fix-roadmap.md` | PHPStan Fix Roadmap - GetAddressFromBingMapsAction - Gennaio 2026 | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; link in ingresso: 3 | proposto |
| `phpstan-class-references-fix.md` | `phpstan/phpstan-class-references-fix.md` | PHPStan Class References Fix - Geo Module | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-class-references-fix.md`; link in ingresso: 0 | proposto |
| `phpstan-compliance-status.md` | `phpstan/phpstan-compliance-status.md` | PHPStan Level 10 Compliance Status | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-compliance-status.md`; link in ingresso: 3 | proposto |
| `phpstan-compliance.md` | `phpstan/phpstan-compliance.md` | PHPStan Compliance - Geo Module | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-compliance.md`; link in ingresso: 0 | proposto |
| `phpstan-corrections.md` | `phpstan/phpstan-corrections.md` | PHPStan Corrections - Geo Module | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-corrections.md`; link in ingresso: 0 | proposto |
| `phpstan-critical-rule.md` | `phpstan/phpstan-critical-rule.md` | Regola Critica PHPStan - NON Modificare phpstan.neon | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-critical-rule.md`; link in ingresso: 0 | proposto |
| `phpstan-error-resolution-roadmap.md` | `phpstan/phpstan-error-resolution-roadmap.md` | PHPStan Error Resolution Roadmap - Modulo Geo - Gennaio 2026 | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-error-resolution-roadmap.md`; link in ingresso: 2 | proposto |
| `phpstan-error-resolution.md` | `phpstan/phpstan-error-resolution.md` | Risoluzione Errori PHPStan - 8 Gennaio 2025 | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-error-resolution.md`; link in ingresso: 0 | proposto |
| `phpstan-errors-resolution-roadmap.md` | `phpstan/phpstan-errors-resolution-roadmap.md` | Geo Module - PHPStan Level 10 Errors Resolution Roadmap | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-errors-resolution-roadmap.md`; link in ingresso: 1 | proposto |
| `phpstan-errors-roadmap.md` | `phpstan/phpstan-errors-roadmap-.md` | PHPStan Level Max Errors Roadmap - Geo Module | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-errors-roadmap-.md`; omonimo con contenuto diverso: `phpstan-errors-roadmap.md`; link in ingresso: 0 | proposto |
| `phpstan-errors-roadmap-2026-01-12.md` | `phpstan/phpstan-errors-roadmap-2026-01-12.md` | PHPStan Level Max Errors Roadmap - Geo Module | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-errors-roadmap-2026-01-12.md`; link in ingresso: 1 | proposto |
| `phpstan-errors-roadmap.md` | `phpstan/phpstan-errors-roadmap.md` | PHPStan Level Max Errors Roadmap - Geo Module | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-errors-roadmap.md`; omonimo con contenuto diverso: `phpstan-errors-roadmap.md`; link in ingresso: 1 | proposto |
| `phpstan-errors.md` | `phpstan/phpstan-errors.md` | PHPStan Errors - Geo Module | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-errors.md`; link in ingresso: 0 | proposto |
| `phpstan-fixes.md` | `phpstan/phpstan-fixes-.md` | Correzioni PHPStan Modulo Geo - 2025-01-27 | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-fixes-.md`; omonimo con contenuto diverso: `phpstan-fixes.md`; link in ingresso: 0 | proposto |
| `phpstan-fixes.md` | `phpstan/phpstan-fixes.md` | PHPStan Fixes for Geo Module | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-fixes.md`; link in ingresso: 0 | proposto |
| `phpstan-fixes-early.md` | `phpstan/phpstan-fixes-early.md` | Correzioni PHPStan Modulo Geo - (DATE) | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-fixes-early.md`; link in ingresso: 0 | proposto |
| `phpstan-fixes-gennaio-2025.md` | `phpstan/phpstan-fixes-gennaio-2025.md` | PHPStan Fixes - Modulo Geo - Gennaio 2025 | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-fixes-gennaio-2025.md`; link in ingresso: 1 | proposto |
| `phpstan-fixes-gennaio.md` | `phpstan/phpstan-fixes-gennaio.md` | PHPStan Fixes - Modulo Geo - Gennaio 2025 | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; link in ingresso: 0 | proposto |
| `phpstan-fixes-january.md` | `phpstan/phpstan-fixes-january.md` | PHPStan Fixes - Modulo Geo - Gennaio 2025 | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-fixes-january.md`; link in ingresso: 0 | proposto |
| `phpstan-fixes-notify-module.md` | `phpstan/phpstan-fixes-notify-module.md` | PHPStan Fixes for Notify Module | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-fixes-notify-module.md`; link in ingresso: 0 | proposto |
| `phpstan-fixes-renamed.md` | `phpstan/phpstan-fixes-renamed.md` | PHPStan Fixes - Modulo Geo - Gennaio 2025 | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-fixes-renamed.md`; link in ingresso: 0 | proposto |
| `phpstan-fixes-roadmap.md` | `phpstan/phpstan-fixes-roadmap.md` | PHPStan Level 10 Fixes Roadmap - Modulo Geo | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-fixes-roadmap.md`; link in ingresso: 1 | proposto |
| `phpstan-fixes-saluteora.md` | `phpstan/phpstan-fixes-saluteora.md` | Correzioni PHPStan nome progetto - Uso Azioni Cast Xot | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-fixes-saluteora.md`; link in ingresso: 0 | proposto |
| `phpstan-fixes-uppercase.md` | `phpstan/phpstan-fixes-uppercase.md` | phpstan fixes uppercase | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-fixes-uppercase.md`; stub (<200 caratteri); omonimo con contenuto diverso: `phpstan-fixes-uppercase.md`; link in ingresso: 0 | proposto |
| `phpstan-fixes.md` | `phpstan/phpstan-fixes.md` | Correzioni PHPStan Modulo Geo - 2025-01-27 | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-fixes.md`; omonimo con contenuto diverso: `phpstan-fixes.md`; link in ingresso: 0 | proposto |
| `phpstan-immediate-fixes.md` | `phpstan/phpstan-immediate-fixes.md` | Geo Module - Immediate PHPStan Fixes | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-immediate-fixes.md`; link in ingresso: 0 | proposto |
| `phpstan-multiple-corrections-complete.md` | `phpstan/phpstan-multiple-corrections-complete.md` | CORREZIONI PHPStan MULTIPLE COMPLETATE | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-multiple-corrections-complete.md`; link in ingresso: 0 | proposto |
| `phpstan-return-type-errors.md` | `phpstan/phpstan-return-type-errors.md` | PHPStan Return Type Mismatch Errors | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; canonico delle copie byte-identiche; identico anche a `phpstan/phpstan-return-type-errors.md`; link in ingresso: 0 | proposto |
| `phpstan-return-types.md` | `phpstan/phpstan-return-types.md` | phpstan return types | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-return-types.md`; stub (<200 caratteri); link in ingresso: 0 | proposto |
| `phpstan-roadmap-geo.md` | `phpstan/phpstan-roadmap-geo.md` | PHPStan Level 10 - Roadmap Modulo Geo | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-roadmap-geo.md`; link in ingresso: 2 | proposto |
| `phpstan-roadmap.md` | `phpstan/phpstan-roadmap.md` | PHPStan Roadmap - Geo Module | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-roadmap.md`; link in ingresso: 1 | proposto |
| `phpstan-session-4-5-fixes-complete.md` | `phpstan/phpstan-session-4-5-fixes-complete.md` | Geo Module - PHPStan Session 4 & 5 Fixes Complete | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-session-4-5-fixes-complete.md`; link in ingresso: 0 | proposto |
| `phpstan-stabilization.md` | `phpstan/phpstan-stabilization.md` | PHPStan Stabilization - Geo Module | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-stabilization.md`; link in ingresso: 0 | proposto |
| `phpstan-standards.md` | `phpstan/phpstan-standards.md` | PHPStan Level 10 Standards - Geo Module | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan-standards.md`; link in ingresso: 0 | proposto |
| `phpstan-sushitojson-contract.md` | `phpstan/phpstan-sushitojson-contract.md` | PHPStan: SushiToJsonContract per Comune | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; link in ingresso: 0 | proposto |
| `phpstan.md` | `phpstan/phpstan.md` | PHPStan Level 10 Roadmap - Geo Module | link in ingresso: 0 | proposto |
| `phpstan-activity-fixes-completed.md` | `wiki/_archive/duplicates/phpstan_activity_fixes_completed.md` | Correzioni PHPStan Modulo Activity Completate | copia byte-identica di `phpstan-activity-fixes-completed.md`; identico anche a `phpstan/phpstan-activity-fixes-completed.md`; link in ingresso: 0 | proposto |
| `phpstan-fixes.md` | `phpstan/PHPSTAN_FIXES.md` | PHPStan Fixes for Geo Module | omonimo con contenuto diverso: `phpstan-fixes.md`; collisione di maiuscole nella destinazione; link in ingresso: 2 | proposto |
| `phpstan-fixes.md` | `phpstan/phpstan_fixes.md` | PHPStan Fixes for Geo Module | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan_fixes.md`; omonimo con contenuto diverso: `phpstan-fixes.md`; collisione di maiuscole nella destinazione; link in ingresso: 2 | proposto |
| `phpstan-fixes-uppercase.md` | `phpstan/phpstan_fixes_uppercase.md` | PHPStan Fixes for Geo Module | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstan_fixes_uppercase.md`; omonimo con contenuto diverso: `phpstan-fixes-uppercase.md`; link in ingresso: 0 | proposto |
| `phpstan-return-type-errors.md` | `wiki/_archive/duplicates/phpstan_return_type_errors.md` | PHPStan Return Type Mismatch Errors | copia byte-identica di `phpstan-return-type-errors.md`; identico anche a `phpstan/phpstan-return-type-errors.md`; link in ingresso: 0 | proposto |
| `phpstanes-uppercase.md` | `phpstan/phpstanes-uppercase.md` | phpstanes uppercase | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstanes-uppercase.md`; stub (<200 caratteri); nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `phpstanes.md` | `phpstan/phpstanes.md` | PHPStan Fixes for Geo Module | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `phpstan/phpstanes.md`; nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `quality-improvements.md` | `phpstan/quality-improvements.md` | Quality Improvements - Geo Module | link in ingresso: 0 | proposto |
| `sintassi-array-correzione.md` | `phpstan/sintassi-array-correzione-.md` | Correzione Sintassi Obsoleta Array() - Modulo Geo | omonimo con contenuto diverso: `sintassi-array-correzione.md`; link in ingresso: 0 | proposto |
| `sintassi-array-correzione.md` | `phpstan/sintassi-array-correzione.md` | Correzione Sintassi Obsoleta Array() - Modulo Geo | omonimo con contenuto diverso: `sintassi-array-correzione.md`; link in ingresso: 0 | proposto |
| `syntax-array-correction.md` | `phpstan/syntax-array-correction.md` | Correzione Sintassi Obsoleta Array() - Modulo Geo | link in ingresso: 0 | proposto |
| `verification-report.md` | `phpstan/verification-report.md` | Verification Report - Compliance and XotBase Refactoring | omonimo con contenuto diverso: `verification-report.md`; link in ingresso: 0 | proposto |
| `verification-report.md` | `phpstan/verification_report.md` | Verification Report - Compliance and XotBase Refactoring | omonimo con contenuto diverso: `verification-report.md`; link in ingresso: 0 | proposto |

## Gruppo E: Conflitti git e merge (19)

Motivo del gruppo: report di risoluzione conflitti: casa naturale merge-conflicts/. Stato di tutte le righe: `proposto`.

| Vecchio | Nuovo proposto | Scopo | Nota | Stato |
|---|---|---|---|---|
| `case-conflicts.md` | `merge-conflicts/case-conflicts.md` | Case-Insensitive File Conflicts | link in ingresso: 0 | proposto |
| `conflict-resolution-1.md` | `merge-conflicts/conflict-resolution-1.md` | Risoluzione Conflitti Git - Modulo Geo | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `conflict-resolution-fixes.md` | `merge-conflicts/conflict-resolution-fixes.md` | Risoluzione Conflitti Git - Modulo Geo | canonico delle copie byte-identiche; link in ingresso: 0 | proposto |
| `conflict-resolution.md` | `merge-conflicts/conflict-resolution.md` | Risoluzione Conflitti Git - Modulo Geo | omonimo con contenuto diverso: `conflict-resolution.md`; link in ingresso: 0 | proposto |
| `conflict-resolutiones.md` | `merge-conflicts/conflict-resolutiones.md` | Risoluzione Conflitti Git - Modulo Geo | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `conflict-resolution.md` | `merge-conflicts/conflict_resolution.md` | Risoluzione Conflitti Git - Modulo Geo | omonimo con contenuto diverso: `conflict-resolution.md`; link in ingresso: 1 | proposto |
| `conflict-resolution-fixes.md` | `wiki/_archive/duplicates/conflict_resolution_fixes.md` | Risoluzione Conflitti Git - Modulo Geo | copia byte-identica di `conflict-resolution-fixes.md`; link in ingresso: 0 | proposto |
| `git-conflict-resolution.md` | `merge-conflicts/git-conflict-resolution.md` | Audit collisioni Git committate in bashscripts | link in ingresso: 1 | proposto |
| `git-conflicts-report.md` | `merge-conflicts/git-conflicts-report.md` | Global Git Conflict Report | identico anche a `git/git-conflicts-report.md`; link in ingresso: 0 | proposto |
| `git-conflicts-resolution-guide.md` | `merge-conflicts/git-conflicts-resolution-guide.md` | Guida alla Risoluzione Conflitti Git - nome progetto | link in ingresso: 1 | proposto |
| `merge-conflict-files-list.md` | `merge-conflicts/merge-conflict-files-list.md` | merge conflict files list | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `merge-conflicts/merge-conflict-files-list.md`; stub (<200 caratteri); link in ingresso: 0 | proposto |
| `merge-conflict-marker-cleanup.md` | `merge-conflicts/merge-conflict-marker-cleanup.md` | Merge Conflict Marker Cleanup | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `merge-conflicts/merge-conflict-marker-cleanup.md`; link in ingresso: 0 | proposto |
| `merge-conflicts-analysis.md` | `merge-conflicts/merge-conflicts-analysis.md` | Analisi Conflitti di Merge - Modulo Geo | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; canonico delle copie byte-identiche; identico anche a `merge-conflicts/merge_conflicts_analysis.md`; link in ingresso: 0 | proposto |
| `merge-conflicts-list.md` | `merge-conflicts/merge-conflicts-list.md` | merge conflicts list | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `merge-conflicts/merge-conflicts-list.md`; stub (<200 caratteri); link in ingresso: 0 | proposto |
| `merge-conflicts-resolution.md` | `merge-conflicts/merge-conflicts-resolution.md` | Risoluzione Conflitti di Merge - Modulo Geo | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; omonimo con contenuto diverso: `merge-conflicts-resolution.md`; link in ingresso: 0 | proposto |
| `merge-conflicts-analysis.md` | `wiki/_archive/duplicates/merge_conflicts_analysis.md` | Analisi Conflitti di Merge - Modulo Geo | copia byte-identica di `merge-conflicts-analysis.md`; identico anche a `merge-conflicts/merge_conflicts_analysis.md`; link in ingresso: 0 | proposto |
| `merge-conflicts-resolution.md` | `merge-conflicts/merge_conflicts_resolution.md` | Risoluzione Conflitti di Merge - Modulo Geo | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; omonimo con contenuto diverso: `merge-conflicts-resolution.md`; link in ingresso: 0 | proposto |
| `merges-resolution.md` | `merge-conflicts/merges-resolution.md` | merges resolution | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `merge-conflicts/merges-resolution.md`; stub (<200 caratteri); link in ingresso: 0 | proposto |
| `merges.md` | `merge-conflicts/merges.md` | merges | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `merge-conflicts/merges.md`; stub (<200 caratteri); link in ingresso: 0 | proposto |

## Gruppo F: Audit ridondanza e duplicati (64)

Motivo del gruppo: analisi di duplicati e ridondanza: casa naturale analysis/. Stato di tutte le righe: `proposto`.

| Vecchio | Nuovo proposto | Scopo | Nota | Stato |
|---|---|---|---|---|
| `analisi-completa-modelli-factory-seeder.md` | `analysis/analisi-completa-modelli-factory-seeder.md` | Analisi Completa Modelli, Factory e Seeder - Sistema nome progetto | link in ingresso: 0 | proposto |
| `analisi-modelli-doppi.md` | `analysis/analisi-modelli-doppi.md` | Analisi Modelli Doppi nel Geo Module | link in ingresso: 2 | proposto |
| `analisi-moduli-completata.md` | `analysis/analisi-moduli-completata.md` | ANALISI MODULI COMPLETATA - Report Finale | link in ingresso: 0 | proposto |
| `analisi-moduli-ottimizzazioni.md` | `analysis/analisi-moduli-ottimizzazioni.md` | Analisi Completa Moduli - Ottimizzazioni e Miglioramenti | link in ingresso: 1 | proposto |
| `audit-relazioni-duplicate-sigma.md` | `analysis/audit-relazioni-duplicate-sigma.md` | Audit Metodi Relazioni Duplicate - Modulo Sigma | link in ingresso: 0 | proposto |
| `business-logic-analysis.md` | `analysis/business-logic-analysis.md` | Business Logic Analysis - Progetto nome progetto | link in ingresso: 0 | proposto |
| `business-logic-consolidated.md` | `analysis/business-logic-consolidated.md` | Business Logic Consolidata - Progetto nome progetto | link in ingresso: 0 | proposto |
| `business-logic-factory-seeder-audit.md` | `analysis/business-logic-factory-seeder-audit.md` | Business Logic Factory & Seeder Audit Completo | link in ingresso: 1 | proposto |
| `business-logic-overview.md` | `analysis/business-logic-overview.md` | Geo Module - Business Logic Overview | link in ingresso: 0 | proposto |
| `copilot-redundancy-audit.md` | `analysis/copilot-redundancy-audit-2026-05-25.md` | copilot redundancy audit 2026 05 25 | link in ingresso: 0 | proposto |
| `copilot-redundancy-audit.md` | `analysis/copilot-redundancy-audit.md` | copilot redundancy audit | link in ingresso: 0 | proposto |
| `data-consolidation-geo-module-classes-completed.md` | `analysis/DATA-CONSOLIDATION-geo-module-classes-completed.md` | Geo Module - Data Consolidation Report | link in ingresso: 0 | proposto |
| `data-consolidation.md` | `analysis/DATA-CONSOLIDATION.md` | Geo Module - Data Consolidation Report | omonimo con contenuto diverso: `data-consolidation.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `data-consolidation.md` | `analysis/data-consolidation.md` | Geo Module - Data Consolidation Report | omonimo con contenuto diverso: `data-consolidation.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `duplicate-analysis.md` | `analysis/duplicate-analysis.md` | Geo Models Duplicate Analysis | link in ingresso: 0 | proposto |
| `duplicate-methods-analysis.md` | `analysis/duplicate-methods-analysis.md` | ANALISI METODI DUPLICATI - SUPER MUCCA EDITION | link in ingresso: 0 | proposto |
| `duplicate-relationship-methods.md` | `analysis/duplicate-relationship-methods.md` | Censimento Metodi Relazione Duplicati | link in ingresso: 0 | proposto |
| `duplicate-methods-report.md` | `analysis/duplicate_methods_report.md` | Report: Metodi con nome duplicato nei moduli e nei temi | link in ingresso: 0 | proposto |
| `elenco-relazioni-metodi-duplicate.md` | `analysis/elenco-relazioni-metodi-duplicate.md` | Elenco metodi che restituiscono relazioni duplicate | link in ingresso: 0 | proposto |
| `geo-models-domain-analysis.md` | `analysis/geo-models-domain-analysis.md` | Analisi dominio modelli Geo (app/Models) | link in ingresso: 3 | proposto |
| `metodi-duplicati-analisi.md` | `analysis/metodi-duplicati-analisi.md` | metodi duplicati analisi | stub (<200 caratteri); omonimo con contenuto diverso: `metodi-duplicati-analisi.md`; link in ingresso: 0 | proposto |
| `metodi-duplicati-report.md` | `analysis/metodi-duplicati-report.md` | Analisi Metodi Duplicati | link in ingresso: 0 | proposto |
| `metodi-relazione-duplicati.md` | `analysis/metodi-relazione-duplicati.md` | Metodi Relazione Duplicati | link in ingresso: 0 | proposto |
| `metodi-duplicati-analisi.md` | `analysis/METODI_DUPLICATI_ANALISI.md` | METODI DUPLICATI ANALISI | stub (<200 caratteri); omonimo con contenuto diverso: `metodi-duplicati-analisi.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `metodi-duplicati-analisi.md` | `analysis/metodi_duplicati_analisi.md` | ANALISI METODI DUPLICATI - SUPER MUCCA EDITION | omonimo con contenuto diverso: `metodi-duplicati-analisi.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `metodiuplicati-analisi.md` | `analysis/metodiuplicati-analisi.md` | metodiuplicati analisi | stub (<200 caratteri); nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `model-analysis.md` | `analysis/model-analysis.md` | Geo Models Analysis: Address vs Place | identico anche a `models/model-analysis.md`; link in ingresso: 0 | proposto |
| `models-analysis.md` | `analysis/models-analysis.md` | Models Analysis - Geo Module | identico anche a `models/models-analysis.md`; link in ingresso: 0 | proposto |
| `modularity-audit-summary.md` | `analysis/modularity-audit-summary.md` | Audit di Modularità - Riepilogo Completo | link in ingresso: 0 | proposto |
| `modularity-audit-sumy.md` | `analysis/modularity-audit-sumy.md` | Audit di Modularità - Riepilogo Completo | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `modularity-hardcoded-names.md` | `analysis/modularity-hardcoded-names.md` | Regola Critica: Mai Hardcodare Nomi di Progetto nei Moduli Riutilizzabili | link in ingresso: 4 | proposto |
| `module-analysis-and-optimization-plan.md` | `analysis/module-analysis-and-optimization-plan.md` | Module Analysis and Optimization Plan | link in ingresso: 1 | proposto |
| `module-analysis-complete.md` | `analysis/module-analysis-complete.md` | Analisi Completa Modulo Geo - Factory, Seeder e Test | link in ingresso: 1 | proposto |
| `module-analysis.md` | `analysis/module-analysis.md` | Modulo Geo - Geolocalizzazione e Mappe | omonimo con contenuto diverso: `module-analysis.md`; link in ingresso: 0 | proposto |
| `module-analysis.md` | `analysis/module_analysis.md` | Modulo Geo - Geolocalizzazione e Mappe | omonimo con contenuto diverso: `module-analysis.md`; link in ingresso: 0 | proposto |
| `modules-analysis-and-optimization.md` | `analysis/modules-analysis-and-optimization.md` | Analisi e Ottimizzazioni Moduli Laraxot - nome progetto | link in ingresso: 0 | proposto |
| `modules-optimization-summary.md` | `analysis/modules-optimization-summary.md` | Riepilogo Analisi Ottimizzazione - Tutti i Moduli nome progetto | link in ingresso: 0 | proposto |
| `modules-optimization-sumy.md` | `analysis/modules-optimization-sumy.md` | Riepilogo Analisi Ottimizzazione - Tutti i Moduli nome progetto | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `optimization-analysis.md` | `analysis/optimization-analysis.md` | Analisi di Ottimizzazione - Modulo Geo | link in ingresso: 2 | proposto |
| `optimization-recommendations.md` | `wiki/_archive/duplicates/optimization-recommendations.md` | Raccomandazioni di Ottimizzazione - Modulo Geo | copia byte-identica di `optimization-recommendations.md`; link in ingresso: 0 | proposto |
| `optimization-summary-report.md` | `analysis/optimization-summary-report.md` | Report di Sintesi - Analisi e Ottimizzazioni Moduli | link in ingresso: 0 | proposto |
| `optimization-sumy-report.md` | `analysis/optimization-sumy-report.md` | Report di Sintesi - Analisi e Ottimizzazioni Moduli | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `optimization-recommendations.md` | `analysis/optimization_recommendations.md` | Raccomandazioni di Ottimizzazione - Modulo Geo | canonico delle copie byte-identiche; link in ingresso: 1 | proposto |
| `performance-optimization.md` | `analysis/PERFORMANCE-OPTIMIZATION.md` | Performance Optimization - Module Geo | omonimo con contenuto diverso: `performance-optimization.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `performance-optimization.md` | `analysis/performance-optimization.md` | Performance Optimization - Module Geo | omonimo con contenuto diverso: `performance-optimization.md`; collisione di maiuscole nella destinazione; link in ingresso: 3 | proposto |
| `ponytail-audit-user-module-findings.md` | `analysis/ponytail-audit-user-module-findings.md` | Ponytail-audit 2026-07-02: Geo module findings | link in ingresso: 0 | proposto |
| `ponytail-audit-over-engineering.md` | `analysis/ponytail-audit-over-engineering.md` | Ponytail audit - Geo (over-engineering) | link in ingresso: 2 | proposto |
| `ponytail-audit-plan.md` | `analysis/ponytail-audit-plan.md` | Ponytail audit - planning | link in ingresso: 4 | proposto |
| `ponytail-audit-report.md` | `analysis/ponytail-audit-report.md` | Ponytail audit - report | link in ingresso: 2 | proposto |
| `ponytail-audit.md` | `analysis/ponytail-audit.md` | Ponytail-audit 2026-07-02: Geo module findings | link in ingresso: 0 | proposto |
| `redundancy-analysis.md` | `analysis/redundancy-analysis.md` | redundancy analysis | canonico delle copie byte-identiche; stub (<200 caratteri); link in ingresso: 0 | proposto |
| `redundancy-audit-geo.md` | `analysis/redundancy-audit-2026-05-21.md` | Geo redundancy audit 2026-05-21 | link in ingresso: 0 | proposto |
| `redundancy-audit.md` | `analysis/redundancy-audit.md` | Geo redundancy audit 2026-05-21 | link in ingresso: 0 | proposto |
| `redundancy-report.md` | `analysis/redundancy-report.md` | Redundancy Report - Geo Module | omonimo con contenuto diverso: `redundancy-report.md`; link in ingresso: 0 | proposto |
| `redundancy-analysis.md` | `analysis/REDUNDANCY_ANALYSIS.md` | REDUNDANCY ANALYSIS | stub (<200 caratteri); omonimo con contenuto diverso: `redundancy-analysis.md`; link in ingresso: 0 | proposto |
| `redundancy-analysis.md` | `wiki/_archive/duplicates/redundancy_analysis.md` | redundancy analysis | copia byte-identica di `redundancy-analysis.md`; stub (<200 caratteri); link in ingresso: 0 | proposto |
| `redundancy-report.md` | `analysis/redundancy_report.md` | Analisi di Codice Ridondante | omonimo con contenuto diverso: `redundancy-report.md`; link in ingresso: 0 | proposto |
| `relationship-methods-duplicate-list.md` | `analysis/relationship-methods-duplicate-list.md` | Elenco metodi relazione duplicate | canonico delle copie byte-identiche; link in ingresso: 0 | proposto |
| `relationship-methods-duplicate-list.md` | `analysis/RELATIONSHIP_METHODS_DUPLICATE_LIST.md` | Elenco metodi relazione duplicate | omonimo con contenuto diverso: `relationship-methods-duplicate-list.md`; link in ingresso: 0 | proposto |
| `relationship-methods-duplicate-list.md` | `wiki/_archive/duplicates/relationship_methods_duplicate_list.md` | Elenco metodi relazione duplicate | copia byte-identica di `relationship-methods-duplicate-list.md`; link in ingresso: 0 | proposto |
| `relazioni-duplicati.md` | `analysis/relazioni-duplicati.md` | Elenco Metodi di Relazione Duplicati | link in ingresso: 0 | proposto |
| `unified-comune-model-analysis.md` | `analysis/unified-comune-model-analysis.md` | Analisi: Unificazione Modelli Geografici in Comune | canonico delle copie byte-identiche; link in ingresso: 3 | proposto |
| `unified-comune-model.md` | `analysis/unified-comune-model.md` | unified comune model | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `unified-comune-model-analysis.md` | `wiki/_archive/duplicates/unified_comune_model_analysis.md` | Analisi: Unificazione Modelli Geografici in Comune | copia byte-identica di `unified-comune-model-analysis.md`; link in ingresso: 0 | proposto |

## Gruppo G: Provider geocoding e integrazioni (23)

Motivo del gruppo: integrazione con servizio esterno: casa naturale integrations/. Stato di tutte le righe: `proposto`.

| Vecchio | Nuovo proposto | Scopo | Nota | Stato |
|---|---|---|---|---|
| `farmshops-analysis.md` | `integrations/farmshops-analysis.md` | ANALISI PROGETTO FARMSHOPS.EU | link in ingresso: 0 | proposto |
| `farmshops-integration-analysis.md` | `integrations/farmshops-integration-analysis.md` | Farmshops.eu Integration Analysis | link in ingresso: 1 | proposto |
| `farmshops-integration.md` | `integrations/farmshops-integration.md` | FARMSHOPS.EU - INTEGRATION GUIDE | link in ingresso: 1 | proposto |
| `here-com-integration.md` | `integrations/here-com-integration.md` | here_com | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `here-com.md` | `wiki/_archive/duplicates/here-com.md` | here com | copia byte-identica di `here-com.md`; stub (<200 caratteri); link in ingresso: 0 | proposto |
| `here-integration.md` | `integrations/here-integration.md` | here | link in ingresso: 0 | proposto |
| `here.md` | `integrations/here.md` | here | link in ingresso: 3 | proposto |
| `here-com.md` | `integrations/here_com.md` | here com | canonico delle copie byte-identiche; stub (<200 caratteri); link in ingresso: 3 | proposto |
| `link2-integration.md` | `integrations/link2-integration.md` | link2 | link in ingresso: 0 | proposto |
| `link2.md` | `integrations/link2.md` | link2 | stub (<200 caratteri); link in ingresso: 3 | proposto |
| `link3-integration.md` | `integrations/link3-integration.md` | link3 | link in ingresso: 0 | proposto |
| `link3.md` | `integrations/link3.md` | link3 | stub (<200 caratteri); link in ingresso: 3 | proposto |
| `mappe-integrazione.md` | `integrations/mappe-integrazione.md` | Integrazione Mappe - Geo Module | link in ingresso: 0 | proposto |
| `mappe-solo-gratuite.md` | `integrations/mappe-solo-gratuite.md` | Regola Critica: Solo Servizi Mappe Gratuiti | link in ingresso: 0 | proposto |
| `research-farmshops-architecture.md` | `integrations/research-farmshops-architecture.md` | Research: farmshops.eu Architecture Study | link in ingresso: 0 | proposto |
| `squire-integration-1.md` | `integrations/squire-integration-1.md` | Integrazione con Squire per dati geografici | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `squire-integration.md` | `integrations/squire-integration.md` | Integrazione con Squire per dati geografici | canonico delle copie byte-identiche; link in ingresso: 12 | proposto |
| `squire-integration.md` | `wiki/_archive/duplicates/squire_integration.md` | Integrazione con Squire per dati geografici | copia byte-identica di `squire-integration.md`; link in ingresso: 0 | proposto |
| `tips-and-links-integration.md` | `integrations/tips-and-links-integration.md` | tips_and_links | link in ingresso: 0 | proposto |
| `tips-and-links.md` | `integrations/tips-and-links.md` | tips and links | stub (<200 caratteri); omonimo con contenuto diverso: `tips-and-links.md`; link in ingresso: 0 | proposto |
| `tips-and-links.md` | `integrations/tips_and_links.md` | tips and links | omonimo con contenuto diverso: `tips-and-links.md`; link in ingresso: 3 | proposto |
| `tomtom-com.md` | `integrations/tomtom-com.md` | tomtom com | stub (<200 caratteri); omonimo con contenuto diverso: `tomtom-com.md`; link in ingresso: 0 | proposto |
| `tomtom-com.md` | `integrations/tomtom_com.md` | tomtom com | stub (<200 caratteri); omonimo con contenuto diverso: `tomtom-com.md`; link in ingresso: 3 | proposto |

## Gruppo H: Strumenti AI, MCP e agenti (18)

Motivo del gruppo: strumenti agente: casa naturale ai/ (mcp/ per MCP). Stato di tutte le righe: `proposto`.

| Vecchio | Nuovo proposto | Scopo | Nota | Stato |
|---|---|---|---|---|
| `agent-guide.md` | `ai/AGENT_GUIDE.md` | AGENT GUIDE | stub (<200 caratteri); omonimo con contenuto diverso: `agent-guide.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `agent-guide.md` | `ai/agent_guide.md` | agent guide | identico anche a `raw/root-import/agent-guide.md`; stub (<200 caratteri); omonimo con contenuto diverso: `agent-guide.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `ai-methodologies.md` | `ai/ai-methodologies.md` | ai methodologies | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `mcp-server-recommended-uppercase.md` | `ai/mcp-server-recommended-uppercase.md` | mcp server recommended uppercase | stub (<200 caratteri); omonimo con contenuto diverso: `mcp-server-recommended-uppercase.md`; link in ingresso: 0 | proposto |
| `mcp-server-recommended.md` | `ai/mcp-server-recommended.md` | mcp server recommended | stub (<200 caratteri); omonimo con contenuto diverso: `mcp-server-recommended.md`; link in ingresso: 0 | proposto |
| `mcp-tools-integration.md` | `ai/mcp-tools-integration.md` | MCP Tools Integration - Geo Module | canonico delle copie byte-identiche; link in ingresso: 0 | proposto |
| `mcp-server-recommended.md` | `ai/MCP_SERVER_RECOMMENDED.md` | MCP Server Consigliati per il Modulo Geo | omonimo con contenuto diverso: `mcp-server-recommended.md`; collisione di maiuscole nella destinazione; link in ingresso: 1 | proposto |
| `mcp-server-recommended.md` | `ai/mcp_server_recommended.md` | MCP Server Consigliati per il Modulo Geo | omonimo con contenuto diverso: `mcp-server-recommended.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `mcp-server-recommended-uppercase.md` | `ai/mcp_server_recommended_uppercase.md` | MCP Server Consigliati per il Modulo Geo | omonimo con contenuto diverso: `mcp-server-recommended-uppercase.md`; link in ingresso: 0 | proposto |
| `mcp-tools-integration.md` | `ai/MCP_TOOLS_INTEGRATION.md` | MCP Tools Integration - Geo Module | omonimo con contenuto diverso: `mcp-tools-integration.md`; link in ingresso: 0 | proposto |
| `mcp-tools-integration.md` | `wiki/_archive/duplicates/mcp_tools_integration.md` | MCP Tools Integration - Geo Module | copia byte-identica di `mcp-tools-integration.md`; link in ingresso: 0 | proposto |
| `on-demand-pattern.md` | `ai/ON-DEMAND-PATTERN.md` | On-Demand Pattern - Module Geo | omonimo con contenuto diverso: `on-demand-pattern.md`; collisione di maiuscole nella destinazione; link in ingresso: 2 | proposto |
| `on-demand-pattern.md` | `ai/on-demand-pattern.md` | On-Demand Pattern - Module Geo | omonimo con contenuto diverso: `on-demand-pattern.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `qmd-setup.md` | `ai/QMD-SETUP.md` | QMD SETUP | stub (<200 caratteri); omonimo con contenuto diverso: `qmd-setup.md`; collisione di maiuscole nella destinazione; link in ingresso: 2 | proposto |
| `qmd-setup.md` | `ai/qmd-setup.md` | qmd setup | stub (<200 caratteri); omonimo con contenuto diverso: `qmd-setup.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `visual-tools.md` | `ai/visual-tools.md` | Visual Regression & Documentation Tool (Playwright) | link in ingresso: 0 | proposto |
| `windsurf-enums.md` | `ai/windsurf-enums.md` | Regole per gli Enum nel Modulo Geo (Windsurf) | link in ingresso: 0 | proposto |
| `windsurf.md` | `ai/windsurf.md` | Entità Geografiche - Windsurf | link in ingresso: 0 | proposto |

## Gruppo I: Azioni e logica applicativa (10)

Motivo del gruppo: Actions/cast: casa naturale actions/. Stato di tutte le righe: `proposto`.

| Vecchio | Nuovo proposto | Scopo | Nota | Stato |
|---|---|---|---|---|
| `bulk-coordinate-updates.md` | `actions/bulk-coordinate-updates.md` | Bulk Coordinate Updates | link in ingresso: 1 | proposto |
| `cast-actions-centralized.md` | `actions/cast-actions-centralized.md` | Azioni Cast Centralizzate - Regola di Progetto | link in ingresso: 0 | proposto |
| `casting-actions-usage.md` | `actions/casting-actions-usage.md` | Uso delle Azioni di Cast Xot | link in ingresso: 1 | proposto |
| `geo-actions-summary.md` | `actions/geo-actions-summary.md` | Geo Actions Summary | link in ingresso: 0 | proposto |
| `geo-actions-sumy.md` | `actions/geo-actions-sumy.md` | Geo Actions Summary | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `geo-actions.md` | `actions/geo-actions.md` | Geo Actions Architecture | link in ingresso: 0 | proposto |
| `queueable-action-testing.md` | `actions/queueable-action-testing.md` | Testare le QueueableAction: convenzione di chiamata | link in ingresso: 0 | proposto |
| `queueable-actions.md` | `actions/queueable-actions.md` | Queueable Actions - Geo Module Doctrine | link in ingresso: 0 | proposto |
| `update-coordinates-bulk-action.md` | `actions/update-coordinates-bulk-action.md` | UpdateCoordinatesBulkAction - Azione Riutilizzabile per Aggiornamento Coord | link in ingresso: 0 | proposto |
| `update-coordinates-refactoring-completed.md` | `actions/update-coordinates-refactoring-completed.md` | Refactoring Update Coordinates Bulk Action | link in ingresso: 0 | proposto |

## Gruppo J: Modello indirizzo, comuni, Sushi e JSON (127)

Motivo del gruppo: modello dati geografico: casa naturale models/. Stato di tutte le righe: `proposto`.

| Vecchio | Nuovo proposto | Scopo | Nota | Stato |
|---|---|---|---|---|
| `address-column-implementation-complete.md` | `models/address-column-implementation-complete.md` | AddressColumn Implementation Complete | link in ingresso: 0 | proposto |
| `address-column-implementation.md` | `models/address-column-implementation.md` | AddressColumn Implementation Plan | link in ingresso: 1 | proposto |
| `address-implementation.md` | `models/address-implementation.md` | Implementazione del Modello Address | canonico delle copie byte-identiche; link in ingresso: 14 | proposto |
| `address-item-enum-guide.md` | `models/address-item-enum-guide.md` | AddressItemEnum - Comprehensive Guide | link in ingresso: 0 | proposto |
| `address-migration-guide.md` | `wiki/_archive/duplicates/address-migration-guide.md` | Guida alla Migrazione del Modello Address | copia byte-identica di `address-migration-guide.md`; link in ingresso: 0 | proposto |
| `address-migration.md` | `models/address-migration.md` | address migration | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `address-model-italian.md` | `models/address-model-italian.md` | Modello Address per Indirizzi Italiani | canonico delle copie byte-identiche; link in ingresso: 3 | proposto |
| `address-relationships.md` | `models/address-relationships.md` | Relazioni del Modello Address | canonico delle copie byte-identiche; link in ingresso: 0 | proposto |
| `address-translation-fixes.md` | `models/address-translation-fixes-.md` | Correzioni Traduzioni Address - Gennaio 2025 | omonimo con contenuto diverso: `address-translation-fixes.md`; link in ingresso: 0 | proposto |
| `address-translation-fixes-1.md` | `models/address-translation-fixes-1.md` | Correzioni Traduzioni Address - Gennaio 2025 | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `address-translation-fixes.md` | `models/address-translation-fixes.md` | Correzioni Traduzioni Address - Gennaio 2025 | omonimo con contenuto diverso: `address-translation-fixes.md`; link in ingresso: 1 | proposto |
| `address-translationes.md` | `models/address-translationes.md` | Correzioni Traduzioni Address - Gennaio 2025 | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `address-implementation.md` | `wiki/_archive/duplicates/address_implementation.md` | Implementazione del Modello Address | copia byte-identica di `address-implementation.md`; link in ingresso: 0 | proposto |
| `address-migration-guide.md` | `models/address_migration_guide.md` | Guida alla Migrazione del Modello Address | canonico delle copie byte-identiche; link in ingresso: 1 | proposto |
| `address-model-italian.md` | `wiki/_archive/duplicates/address_model_italian.md` | Modello Address per Indirizzi Italiani | copia byte-identica di `address-model-italian.md`; link in ingresso: 0 | proposto |
| `address-relationships.md` | `wiki/_archive/duplicates/address_relationships.md` | Relazioni del Modello Address | copia byte-identica di `address-relationships.md`; link in ingresso: 0 | proposto |
| `addressitemenum-translations-complete.md` | `models/addressitemenum-translations-complete.md` | AddressItemEnum Translations - Complete Implementation | link in ingresso: 0 | proposto |
| `complete-models-factory-seeder.md` | `models/complete-models-factory-seeder.md` | complete models factory seeder | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `comune-implementation.md` | `models/comune-implementation.md` | Implementazione del Modello Comune | canonico delle copie byte-identiche; link in ingresso: 0 | proposto |
| `comune-model.md` | `models/comune-model.md` | Modello Comune | canonico delle copie byte-identiche; link in ingresso: 14 | proposto |
| `comune-sushi-analisi.md` | `models/comune-sushi-analisi.md` | Analisi: Comune.php come modello Laravel Sushi | canonico delle copie byte-identiche; link in ingresso: 11 | proposto |
| `comune-sushi-analysis.md` | `models/comune-sushi-analysis.md` | Analisi: Comune.php come modello Laravel Sushi | link in ingresso: 1 | proposto |
| `comune-sushi-conversion.md` | `models/comune-sushi-conversion.md` | Analisi: Conversione del Modello Comune a Laravel Sushi | canonico delle copie byte-identiche; link in ingresso: 9 | proposto |
| `comune-sushi-implementation-1.md` | `models/comune-sushi-implementation-1.md` | Implementazione Sushi per il Modello Comune | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `comune-sushi-implementation.md` | `models/comune-sushi-implementation.md` | comune sushi implementation | stub (<200 caratteri); omonimo con contenuto diverso: `comune-sushi-implementation.md`; link in ingresso: 3 | proposto |
| `comune-sushi-implementazione.md` | `models/comune-sushi-implementazione.md` | Implementazione di Comune.php con Laravel Sushi | canonico delle copie byte-identiche; link in ingresso: 12 | proposto |
| `comune-unification-analysis.md` | `models/comune-unification-analysis.md` | Analisi: Unificazione dei modelli geografici in Comune.php | link in ingresso: 0 | proposto |
| `comune-unificazione-analisi.md` | `models/comune-unificazione-analisi.md` | Analisi: Unificazione dei modelli geografici in Comune.php | canonico delle copie byte-identiche; link in ingresso: 14 | proposto |
| `comune-unificazione-analysis.md` | `models/comune-unificazione-analysis.md` | comune unificazione analysis | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `comune-implementation.md` | `wiki/_archive/duplicates/comune_implementation.md` | Implementazione del Modello Comune | copia byte-identica di `comune-implementation.md`; link in ingresso: 0 | proposto |
| `comune-model.md` | `wiki/_archive/duplicates/comune_model.md` | Modello Comune | copia byte-identica di `comune-model.md`; link in ingresso: 0 | proposto |
| `comune-sushi-analisi.md` | `wiki/_archive/duplicates/comune_sushi_analisi.md` | Analisi: Comune.php come modello Laravel Sushi | copia byte-identica di `comune-sushi-analisi.md`; link in ingresso: 0 | proposto |
| `comune-sushi-conversion.md` | `wiki/_archive/duplicates/comune_sushi_conversion.md` | Analisi: Conversione del Modello Comune a Laravel Sushi | copia byte-identica di `comune-sushi-conversion.md`; link in ingresso: 0 | proposto |
| `comune-sushi-implementation.md` | `models/comune_sushi_implementation.md` | Implementazione Sushi per il Modello Comune | omonimo con contenuto diverso: `comune-sushi-implementation.md`; link in ingresso: 0 | proposto |
| `comune-sushi-implementazione.md` | `wiki/_archive/duplicates/comune_sushi_implementazione.md` | Implementazione di Comune.php con Laravel Sushi | copia byte-identica di `comune-sushi-implementazione.md`; link in ingresso: 0 | proposto |
| `comune-unificazione-analisi.md` | `wiki/_archive/duplicates/comune_unificazione_analisi.md` | Analisi: Unificazione dei modelli geografici in Comune.php | copia byte-identica di `comune-unificazione-analisi.md`; link in ingresso: 3 | proposto |
| `comuni-json-usage.md` | `models/comuni-json-usage.md` | Using comuni.json for Location Data | canonico delle copie byte-identiche; link in ingresso: 6 | proposto |
| `comuni-json-usage.md` | `wiki/_archive/duplicates/comuni_json_usage.md` | Using comuni.json for Location Data | copia byte-identica di `comuni-json-usage.md`; link in ingresso: 0 | proposto |
| `consolidamento-modelli-geografici.md` | `models/consolidamento-modelli-geografici.md` | Analisi del Consolidamento dei Modelli Geografici | canonico delle copie byte-identiche; link in ingresso: 12 | proposto |
| `consolidamento-modelli-geografici.md` | `wiki/_archive/duplicates/consolidamento_modelli_geografici.md` | Analisi del Consolidamento dei Modelli Geografici | copia byte-identica di `consolidamento-modelli-geografici.md`; link in ingresso: 3 | proposto |
| `database-population-guide.md` | `models/database-population-guide.md` | Guida al Popolamento Database - Laraxot nome progetto | link in ingresso: 0 | proposto |
| `database-seeding.md` | `models/database-seeding.md` | Database Seeding - Moduli nome modulo e nome progetto | link in ingresso: 1 | proposto |
| `databases.md` | `models/databases.md` | databases | stub (<200 caratteri); link in ingresso: 3 | proposto |
| `enums-implementation.md` | `models/enums-implementation.md` | Implementazione degli Enum nel Modulo Geo | canonico delle copie byte-identiche; link in ingresso: 1 | proposto |
| `enums.md` | `models/enums.md` | Regole per gli Enum nel Modulo Geo | link in ingresso: 0 | proposto |
| `enums-implementation.md` | `wiki/_archive/duplicates/enums_implementation.md` | Implementazione degli Enum nel Modulo Geo | copia byte-identica di `enums-implementation.md`; link in ingresso: 0 | proposto |
| `factory-creation-geo-module.md` | `models/factory-creation-geo-module.md` | Factory Creation - Geo Module | link in ingresso: 1 | proposto |
| `factory-seeder-consolidated.md` | `models/factory-seeder-consolidated.md` | Factory e Seeder Consolidati - Progetto nome progetto | link in ingresso: 0 | proposto |
| `geo-entities.md` | `wiki/_archive/duplicates/geo-entities.md` | Entità Geografiche | copia byte-identica di `geo-entities.md`; link in ingresso: 2 | proposto |
| `geo-json-model-1.md` | `models/geo-json-model-1.md` | Modello GeoJsonModel (ispirato a Squire) per Laravel | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `geo-json-model.md` | `models/geo-json-model.md` | geo json model | stub (<200 caratteri); omonimo con contenuto diverso: `geo-json-model.md`; link in ingresso: 33 | proposto |
| `geo-json-vs-sushi-comparison.md` | `models/geo-json-vs-sushi-comparison.md` | GeoJsonModel vs Laravel Sushi: Analisi e Confronto | canonico delle copie byte-identiche; link in ingresso: 9 | proposto |
| `geo-sushi-comparison-1.md` | `models/geo-sushi-comparison-1.md` | Confronto: GeoJsonModel (readonly JSON) vs Laravel Sushi | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `geo-sushi-comparison.md` | `models/geo-sushi-comparison.md` | Confronto: GeoJsonModel (readonly JSON) vs Laravel Sushi | canonico delle copie byte-identiche; link in ingresso: 19 | proposto |
| `geo-entities.md` | `models/geo_entities.md` | Entità Geografiche | canonico delle copie byte-identiche; link in ingresso: 16 | proposto |
| `geo-json-model.md` | `models/geo_json_model.md` | Modello GeoJsonModel (ispirato a Squire) per Laravel | omonimo con contenuto diverso: `geo-json-model.md`; link in ingresso: 3 | proposto |
| `geo-json-vs-sushi-comparison.md` | `wiki/_archive/duplicates/geo_json_vs_sushi_comparison.md` | GeoJsonModel vs Laravel Sushi: Analisi e Confronto | copia byte-identica di `geo-json-vs-sushi-comparison.md`; link in ingresso: 0 | proposto |
| `geo-sushi-comparison.md` | `wiki/_archive/duplicates/geo_sushi_comparison.md` | Confronto: GeoJsonModel (readonly JSON) vs Laravel Sushi | copia byte-identica di `geo-sushi-comparison.md`; link in ingresso: 0 | proposto |
| `geographic-data-management-compendium.md` | `models/geographic-data-management-compendium.md` | Compendio sulla Gestione dei Dati Geografici in main module | link in ingresso: 0 | proposto |
| `geographic-models-consolidation.md` | `models/geographic-models-consolidation.md` | Analisi del Consolidamento dei Modelli Geografici | link in ingresso: 0 | proposto |
| `geojson-model-vs-sushi.md` | `models/geojson-model-vs-sushi.md` | Analisi Comparativa: GeoJsonModel vs Laravel Sushi | omonimo con contenuto diverso: `geojsonmodel-vs-sushi.md`; link in ingresso: 0 | proposto |
| `geojson-vs-sushi-comparison.md` | `models/geojson-vs-sushi-comparison.md` | GeoJsonModel vs Laravel Sushi: Analisi e Confronto | omonimo con contenuto diverso: `geo-json-vs-sushi-comparison.md`; link in ingresso: 0 | proposto |
| `geojsonmodel-vs-sushi.md` | `models/geojsonmodel-vs-sushi.md` | Analisi Comparativa: GeoJsonModel vs Laravel Sushi | canonico delle copie byte-identiche; link in ingresso: 9 | proposto |
| `geojsonmodel-vs-sushi.md` | `wiki/_archive/duplicates/geojsonmodel_vs_sushi.md` | Analisi Comparativa: GeoJsonModel vs Laravel Sushi | copia byte-identica di `geojsonmodel-vs-sushi.md`; link in ingresso: 0 | proposto |
| `gestione-dati-geografici-compendio.md` | `models/gestione-dati-geografici-compendio.md` | Compendio sulla Gestione dei Dati Geografici in main module | canonico delle copie byte-identiche; link in ingresso: 3 | proposto |
| `gestione-dati-geografici-compendio.md` | `wiki/_archive/duplicates/gestione_dati_geografici_compendio.md` | Compendio sulla Gestione dei Dati Geografici in main module | copia byte-identica di `gestione-dati-geografici-compendio.md`; link in ingresso: 0 | proposto |
| `gestioneati-geografici-compendio.md` | `models/gestioneati-geografici-compendio.md` | gestioneati geografici compendio | stub (<200 caratteri); nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `has-address-trait.md` | `models/has-address-trait.md` | Trait HasAddress | canonico delle copie byte-identiche; link in ingresso: 3 | proposto |
| `has-address-trait.md` | `wiki/_archive/duplicates/has_address_trait.md` | Trait HasAddress | copia byte-identica di `has-address-trait.md`; link in ingresso: 0 | proposto |
| `json-database.md` | `models/json-database.md` | JSON come Database per Dati Geografici | canonico delle copie byte-identiche; link in ingresso: 11 | proposto |
| `json-usage-1.md` | `models/json-usage-1.md` | Utilizzo del file JSON dei comuni | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `json-usage.md` | `models/json-usage.md` | Utilizzo del file JSON dei comuni | canonico delle copie byte-identiche; link in ingresso: 3 | proposto |
| `json-database.md` | `wiki/_archive/duplicates/json_database.md` | JSON come Database per Dati Geografici | copia byte-identica di `json-database.md`; link in ingresso: 0 | proposto |
| `json-usage.md` | `wiki/_archive/duplicates/json_usage.md` | Utilizzo del file JSON dei comuni | copia byte-identica di `json-usage.md`; link in ingresso: 0 | proposto |
| `jsonatabase.md` | `models/jsonatabase.md` | jsonatabase | stub (<200 caratteri); nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `laravel-sushi-analysis.md` | `models/laravel-sushi-analysis.md` | Laravel Sushi: Analisi Approfondita | canonico delle copie byte-identiche; link in ingresso: 11 | proposto |
| `laravel-sushi-guide.md` | `models/laravel-sushi-guide.md` | Laravel Sushi: Guida Completa | canonico delle copie byte-identiche; link in ingresso: 0 | proposto |
| `laravel-sushi.md` | `models/laravel-sushi.md` | laravel sushi | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `laravel-sushi-analysis.md` | `wiki/_archive/duplicates/laravel_sushi_analysis.md` | Laravel Sushi: Analisi Approfondita | copia byte-identica di `laravel-sushi-analysis.md`; link in ingresso: 0 | proposto |
| `laravel-sushi-guide.md` | `wiki/_archive/duplicates/laravel_sushi_guide.md` | Laravel Sushi: Guida Completa | copia byte-identica di `laravel-sushi-guide.md`; link in ingresso: 0 | proposto |
| `migration-guide.md` | `models/migration-guide.md` | Migration Guide: Moving from main module to Geo Module | canonico delle copie byte-identiche; link in ingresso: 7 | proposto |
| `migration-morphs-strategy.md` | `models/migration-morphs-strategy.md` | Strategia Migrazioni e Morphs Polymorphic - nome progetto | link in ingresso: 0 | proposto |
| `migration.md` | `models/migration.md` | migration | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `migration-guide.md` | `wiki/_archive/duplicates/migration_guide.md` | Migration Guide: Moving from main module to Geo Module | copia byte-identica di `migration-guide.md`; link in ingresso: 0 | proposto |
| `missing-factories-audit.md` | `models/missing-factories-audit.md` | Factory Mancanti - Modulo Geo | link in ingresso: 0 | proposto |
| `model-classification.md` | `models/model-classification.md` | Geo Module - Model Classification | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `models/model-classification.md`; link in ingresso: 0 | proposto |
| `model-factory-seeder-audit.md` | `models/model-factory-seeder-audit.md` | Model/Factory/Seeder Audit | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `models/model-factory-seeder-audit.md`; link in ingresso: 0 | proposto |
| `model-inheritance-pattern.md` | `models/model-inheritance-pattern.md` | Principio di Ereditarietà nei Modelli | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; canonico delle copie byte-identiche; identico anche a `models/model_inheritance_pattern.md`; link in ingresso: 0 | proposto |
| `model-inheritance.md` | `models/model-inheritance.md` | model inheritance | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `models/model-inheritance.md`; stub (<200 caratteri); link in ingresso: 0 | proposto |
| `model-testing-philosophy.md` | `models/model-testing-philosophy.md` | Filosofia dei Test: Modelli "Slim" - NO Test Inutili | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `models/model-testing-philosophy.md`; link in ingresso: 3 | proposto |
| `model-inheritance-pattern.md` | `wiki/_archive/duplicates/model_inheritance_pattern.md` | Principio di Ereditarietà nei Modelli | copia byte-identica di `model-inheritance-pattern.md`; identico anche a `models/model_inheritance_pattern.md`; link in ingresso: 0 | proposto |
| `modelli-factory-seeder-analisi.md` | `wiki/_archive/duplicates/modelli-factory-seeder-analisi.md` | Analisi Modelli, Factory e Seeder - Modulo Geo | copia byte-identica di `modelli-factory-seeder-analisi.md`; link in ingresso: 0 | proposto |
| `modelli-factory-seeder-analisi.md` | `models/modelli_factory_seeder_analisi.md` | Analisi Modelli, Factory e Seeder - Modulo Geo | canonico delle copie byte-identiche; link in ingresso: 1 | proposto |
| `models-factory-seeder-analysis.md` | `models/models-factory-seeder-analysis.md` | Analisi Modelli, Factory e Seeder - Modulo Geo | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; link in ingresso: 0 | proposto |
| `models-migrations-status.md` | `models/models-migrations-status.md` | Geo - Stato Modelli / Migration / Seeder / Factory | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `models/models-migrations-status.md`; link in ingresso: 0 | proposto |
| `modules-factory-seeder-analysis.md` | `models/modules-factory-seeder-analysis.md` | Complete Modules Factory & Seeder Analysis | link in ingresso: 0 | proposto |
| `modules-factory-seeder.md` | `models/modules-factory-seeder.md` | Analisi Completa Modelli, Factory e Seeder - Sistema nome progetto | link in ingresso: 0 | proposto |
| `morphs-relationship-patterns.md` | `models/morphs-relationship-patterns.md` | Pattern di Relazioni Polimorfiche nell'Ecosistema main module | canonico delle copie byte-identiche; link in ingresso: 5 | proposto |
| `morphs-relationships.md` | `models/morphs-relationships.md` | morphs relationships | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `morphs-relationship-patterns.md` | `wiki/_archive/duplicates/morphs_relationship_patterns.md` | Pattern di Relazioni Polimorfiche nell'Ecosistema main module | copia byte-identica di `morphs-relationship-patterns.md`; link in ingresso: 0 | proposto |
| `place-address-schemaorg.md` | `models/place-address-schemaorg.md` | Place, Address e la separazione Regione/Provincia negli indirizzi italiani | canonico delle copie byte-identiche; link in ingresso: 3 | proposto |
| `place-address-schemaorg.md` | `wiki/_archive/duplicates/place_address_schemaorg.md` | Place, Address e la separazione Regione/Provincia negli indirizzi italiani | copia byte-identica di `place-address-schemaorg.md`; link in ingresso: 0 | proposto |
| `poligon.md` | `models/poligon.md` | poligon | stub (<200 caratteri); link in ingresso: 3 | proposto |
| `polygon-integration.md` | `models/polygon-integration.md` | poligon | link in ingresso: 1 | proposto |
| `polygon-mysql-integration.md` | `models/polygon-mysql-integration.md` | polygon_mysql | link in ingresso: 0 | proposto |
| `polygon-mysql.md` | `models/polygon-mysql.md` | polygon mysql | stub (<200 caratteri); omonimo con contenuto diverso: `polygon-mysql.md`; link in ingresso: 0 | proposto |
| `polygon.md` | `models/polygon.md` | polygon | link in ingresso: 0 | proposto |
| `polygon-mysql.md` | `models/polygon_mysql.md` | polygon mysql | omonimo con contenuto diverso: `polygon-mysql.md`; link in ingresso: 3 | proposto |
| `principi-migrazioni-laraxot-uuid-polimorfismo.md` | `models/principi-migrazioni-laraxot-uuid-polimorfismo.md` | principi migrazioni laraxot uuid polimorfismo | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `refactoring-bashscriptsatabase-seeding.md` | `models/refactoring-bashscriptsatabase-seeding.md` | Refactoring Bashscripts Database Seeding - Rimozione Riferimenti Specifici | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `structure.md` | `models/structure.md` | Modulo Geo | link in ingresso: 9 | proposto |
| `sushi-command.md` | `models/sushi-command.md` | sushi command | canonico delle copie byte-identiche; stub (<200 caratteri); link in ingresso: 4 | proposto |
| `sushi-configuration.md` | `models/sushi-configuration.md` | Configurazione Sushi | canonico delle copie byte-identiche; link in ingresso: 2 | proposto |
| `sushi-implementation-analysis.md` | `models/sushi-implementation-analysis.md` | Analisi Implementazione Comune con Laravel Sushi | canonico delle copie byte-identiche; link in ingresso: 6 | proposto |
| `sushi-implementation-guide.md` | `models/sushi-implementation-guide.md` | Sushi Implementation for Comune Model | canonico delle copie byte-identiche; link in ingresso: 0 | proposto |
| `sushi-implementation.md` | `models/sushi-implementation.md` | sushi implementation | stub (<200 caratteri); omonimo con contenuto diverso: `sushi-implementation.md`; link in ingresso: 1 | proposto |
| `sushi-models-dependency-cycle-fix.md` | `models/sushi-models-dependency-cycle-fix.md` | Sushi Models - Dependency Cycle Fix | canonico delle copie byte-identiche; link in ingresso: 0 | proposto |
| `sushi-modelsependency-cycle.md` | `models/sushi-modelsependency-cycle.md` | sushi modelsependency cycle | stub (<200 caratteri); nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `sushi-to-jsons-analysis.md` | `models/sushi-to-jsons-analysis.md` | Analisi di SushiToJsons per il Modello Comune | canonico delle copie byte-identiche; link in ingresso: 14 | proposto |
| `sushi-to-jsons.md` | `models/sushi-to-jsons.md` | sushi to jsons | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `sushi-command.md` | `wiki/_archive/duplicates/sushi_command.md` | sushi command | copia byte-identica di `sushi-command.md`; stub (<200 caratteri); link in ingresso: 0 | proposto |
| `sushi-configuration.md` | `wiki/_archive/duplicates/sushi_configuration.md` | Configurazione Sushi | copia byte-identica di `sushi-configuration.md`; link in ingresso: 0 | proposto |
| `sushi-implementation.md` | `models/sushi_implementation.md` | Implementazione di Sushi nel Modulo Geo | omonimo con contenuto diverso: `sushi-implementation.md`; link in ingresso: 0 | proposto |
| `sushi-implementation-analysis.md` | `wiki/_archive/duplicates/sushi_implementation_analysis.md` | Analisi Implementazione Comune con Laravel Sushi | copia byte-identica di `sushi-implementation-analysis.md`; link in ingresso: 0 | proposto |
| `sushi-implementation-guide.md` | `wiki/_archive/duplicates/sushi_implementation_guide.md` | Sushi Implementation for Comune Model | copia byte-identica di `sushi-implementation-guide.md`; link in ingresso: 0 | proposto |
| `sushi-models-dependency-cycle-fix.md` | `wiki/_archive/duplicates/sushi_models_dependency_cycle_fix.md` | Sushi Models - Dependency Cycle Fix | copia byte-identica di `sushi-models-dependency-cycle-fix.md`; link in ingresso: 0 | proposto |
| `sushi-to-jsons-analysis.md` | `wiki/_archive/duplicates/sushi_to_jsons_analysis.md` | Analisi di SushiToJsons per il Modello Comune | copia byte-identica di `sushi-to-jsons-analysis.md`; link in ingresso: 0 | proposto |

## Gruppo K: Componenti Filament, indirizzo e mappa (65)

Motivo del gruppo: componente/risorsa Filament, picker, mappa: casa naturale filament/. Stato di tutte le righe: `proposto`.

| Vecchio | Nuovo proposto | Scopo | Nota | Stato |
|---|---|---|---|---|
| `address-autocomplete-integration.md` | `filament/address-autocomplete-integration.md` | address_autocomplete | link in ingresso: 0 | proposto |
| `address-autocomplete.md` | `wiki/_archive/duplicates/address-autocomplete.md` | address autocomplete | copia byte-identica di `address-autocomplete.md`; link in ingresso: 1 | proposto |
| `address-field-component.md` | `filament/address-field-component.md` | Geo Module - AddressInput Component | link in ingresso: 2 | proposto |
| `address-field.md` | `filament/address-field.md` | Address Field Component - Geolocalizzazione con Reverse Geocoding | link in ingresso: 1 | proposto |
| `address-input-component.md` | `filament/address-input-component.md` | AddressInput Component - Filament Field con Geolocalizzazione | link in ingresso: 3 | proposto |
| `address-input-implementation-summary.md` | `filament/address-input-implementation-summary.md` | AddressInput Component Implementation Summary | link in ingresso: 0 | proposto |
| `address-resource-1.md` | `filament/address-resource-1.md` | Risorsa Filament per il Modello Address | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `address-resource-analysis.md` | `filament/address-resource-analysis.md` | Analisi AddressResource.php | omonimo con contenuto diverso: `addressresource-analysis.md`; link in ingresso: 0 | proposto |
| `address-resource-improvements.md` | `filament/address-resource-improvements.md` | Suggerimenti di Miglioramento per AddressResource.php | omonimo con contenuto diverso: `addressresource-improvements.md`; link in ingresso: 0 | proposto |
| `address-resource-summary.md` | `filament/address-resource-summary.md` | Sintesi Analisi AddressResource - Modulo Geo | omonimo con contenuto diverso: `addressresource-summary.md`; link in ingresso: 0 | proposto |
| `address-resource-sumy.md` | `filament/address-resource-sumy.md` | Sintesi Analisi AddressResource - Modulo Geo | nome corrotto o sospetto; omonimo con contenuto diverso: `addressresource-sumy.md`; link in ingresso: 0 | proposto |
| `address-resource.md` | `filament/address-resource.md` | address resource | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; stub (<200 caratteri); omonimo con contenuto diverso: `address-resource.md`; link in ingresso: 4 | proposto |
| `address-autocomplete.md` | `filament/address_autocomplete.md` | address autocomplete | canonico delle copie byte-identiche; link in ingresso: 3 | proposto |
| `address-resource.md` | `filament/address_resource.md` | Risorsa Filament per il Modello Address | omonimo con contenuto diverso: `address-resource.md`; link in ingresso: 0 | proposto |
| `addressresource-analysis.md` | `filament/addressresource-analysis.md` | Analisi AddressResource.php | omonimo con contenuto diverso: `address-resource-analysis.md`; link in ingresso: 0 | proposto |
| `addressresource-improvements.md` | `filament/addressresource-improvements.md` | Suggerimenti di Miglioramento per AddressResource.php | omonimo con contenuto diverso: `address-resource-improvements.md`; link in ingresso: 0 | proposto |
| `addressresource-summary.md` | `filament/addressresource-summary.md` | addressresource summary | stub (<200 caratteri); omonimo con contenuto diverso: `address-resource-summary.md`; link in ingresso: 0 | proposto |
| `addressresource-sumy.md` | `filament/addressresource-sumy.md` | Sintesi Analisi AddressResource - Modulo Geo | nome corrotto o sospetto; omonimo con contenuto diverso: `address-resource-sumy.md`; link in ingresso: 0 | proposto |
| `addressresource.md` | `filament/addressresource.md` | addressresource | stub (<200 caratteri); omonimo con contenuto diverso: `address-resource.md`; link in ingresso: 0 | proposto |
| `addressresource-analysis.md` | `filament/addressresource_analysis.md` | Analisi AddressResource.php | omonimo con contenuto diverso: `address-resource-analysis.md`; link in ingresso: 3 | proposto |
| `addressresource-improvements.md` | `filament/addressresource_improvements.md` | Suggerimenti di Miglioramento per AddressResource.php | omonimo con contenuto diverso: `address-resource-improvements.md`; link in ingresso: 3 | proposto |
| `addressresource-summary.md` | `filament/addressresource_summary.md` | Sintesi Analisi AddressResource - Modulo Geo | omonimo con contenuto diverso: `address-resource-summary.md`; link in ingresso: 3 | proposto |
| `addresssection-philosophy.md` | `filament/addresssection-philosophy.md` | AddressSection - Filosofia del Componente Riutilizzabile | link in ingresso: 0 | proposto |
| `autocomplete-integration.md` | `filament/autocomplete-integration.md` | autocomplete | link in ingresso: 0 | proposto |
| `autocomplete.md` | `filament/autocomplete.md` | autocomplete | link in ingresso: 3 | proposto |
| `coordinate-picker-blade-fix.md` | `filament/coordinate-picker-blade-fix.md` | Coordinate Picker Blade Template Fix | link in ingresso: 0 | proposto |
| `coordinate-picker-purpose.md` | `filament/coordinate-picker-purpose.md` | Scopo e Utilità del Coordinate Picker nella Creazione Ticket | link in ingresso: 3 | proposto |
| `daisyui.md` | `filament/DAISYUI.md` | Geo Module - daisyUI Documentation | omonimo con contenuto diverso: `daisyui.md`; collisione di maiuscole nella destinazione; link in ingresso: 1 | proposto |
| `daisyui.md` | `filament/daisyui.md` | Geo Module - daisyUI Documentation | omonimo con contenuto diverso: `daisyui.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `filament-4x-compatibility.md` | `filament/filament-4x-compatibility.md` | Compatibilità Filament 4.x - Modulo Geo | omonimo con contenuto diverso: `filament-4x-compatibility.md`; link in ingresso: 0 | proposto |
| `filament-5x-compatibility.md` | `filament/filament-5x-compatibility.md` | Filament 5.x compatibility - modulo Geo | link in ingresso: 0 | proposto |
| `filament-forms-components.md` | `filament/filament-forms-components.md` | Geo Module - Filament Forms Components | link in ingresso: 3 | proposto |
| `filament-geo-pickers-philosophy.md` | `filament/filament-geo-pickers-philosophy.md` | Geo Filament Pickers - Filosofia, Visione e Regole | link in ingresso: 1 | proposto |
| `filament-integration.md` | `filament/filament-integration.md` | Integrazione con Filament | canonico delle copie byte-identiche; link in ingresso: 12 | proposto |
| `filament-v4-upgrade-notes.md` | `filament/filament-v4-upgrade-notes.md` | Geo Module - Filament v4 Upgrade Notes | link in ingresso: 0 | proposto |
| `filament-view-record-implementation.md` | `filament/filament-view-record-implementation.md` | Filament ViewRecord Implementation - Geo Module | link in ingresso: 0 | proposto |
| `filament.md` | `filament/filament.md` | filament | link in ingresso: 9 | proposto |
| `filament-4x-compatibility.md` | `filament/filament_4x_compatibility.md` | Compatibilità Filament 4.x - Modulo Geo | omonimo con contenuto diverso: `filament-4x-compatibility.md`; link in ingresso: 3 | proposto |
| `filament-integration.md` | `wiki/_archive/duplicates/filament_integration.md` | Integrazione con Filament | copia byte-identica di `filament-integration.md`; link in ingresso: 0 | proposto |
| `form-schema-reuse.md` | `filament/form-schema-reuse.md` | Riutilizzo degli Schemi Form tra Moduli | canonico delle copie byte-identiche; link in ingresso: 6 | proposto |
| `form-schema-reuse.md` | `wiki/_archive/duplicates/form_schema_reuse.md` | Riutilizzo degli Schemi Form tra Moduli | copia byte-identica di `form-schema-reuse.md`; link in ingresso: 0 | proposto |
| `geo-map-widget.md` | `filament/geo-map-widget.md` | GeoMapWidget | link in ingresso: 0 | proposto |
| `helper-text-normalization-fix.md` | `filament/helper-text-normalization-fix-.md` | Helper Text Normalization Fix - Modulo Geo | omonimo con contenuto diverso: `helper-text-normalization-fix.md`; link in ingresso: 0 | proposto |
| `helper-text-normalization-fix.md` | `filament/helper-text-normalization-fix.md` | Helper Text Normalization Fix - Modulo Geo | omonimo con contenuto diverso: `helper-text-normalization-fix.md`; link in ingresso: 0 | proposto |
| `helper-text-normalization.md` | `filament/helper-text-normalization.md` | Helper Text Normalization Fix - Modulo Geo | link in ingresso: 0 | proposto |
| `homepage-architecture-overview.md` | `filament/homepage-architecture-overview.md` | Architettura Homepage - Panoramica Sistema | link in ingresso: 0 | proposto |
| `icon-design.md` | `filament/icon-design.md` | Geo Module - Icon Design | link in ingresso: 0 | proposto |
| `leaflet-marker-map-input.md` | `filament/leaflet-marker-map-input.md` | LeafletMarkerMapInput Componente Filament | link in ingresso: 1 | proposto |
| `location-select.md` | `filament/location-select.md` | Location Select Component | canonico delle copie byte-identiche; link in ingresso: 10 | proposto |
| `location-spinner-ux.md` | `filament/location-spinner-ux.md` | Location Spinner UX Pattern | link in ingresso: 1 | proposto |
| `location-select.md` | `wiki/_archive/duplicates/location_select.md` | Location Select Component | copia byte-identica di `location-select.md`; link in ingresso: 0 | proposto |
| `map-lit-lessons-learned.md` | `filament/map-lit-lessons-learned.md` | Map-Lit: Lessons Learned & Error Resolution | link in ingresso: 1 | proposto |
| `map-picker-lit.md` | `filament/map-picker-lit.md` | CoordinatePickerLit Component Implementation | link in ingresso: 0 | proposto |
| `map-positioner.md` | `filament/map-positioner.md` | MapPositioner (Filament v5) | link in ingresso: 0 | proposto |
| `map-test-integration.md` | `filament/map-test-integration.md` | map_test | link in ingresso: 0 | proposto |
| `map-test.md` | `filament/map-test.md` | map test | stub (<200 caratteri); omonimo con contenuto diverso: `map-test.md`; link in ingresso: 0 | proposto |
| `map-vista-di-default-e-posizione-non-disponibile.md` | `filament/map-vista-di-default-e-posizione-non-disponibile.md` | Mappa del picker: vista di default e posizione non disponibile | link in ingresso: 0 | proposto |
| `map-test.md` | `filament/map_test.md` | map test | stub (<200 caratteri); omonimo con contenuto diverso: `map-test.md`; link in ingresso: 3 | proposto |
| `navigation-translations-fixes.md` | `filament/navigation-translations-fixes.md` | Correzioni Traduzioni Navigation - Modulo Geo | link in ingresso: 0 | proposto |
| `nested-resources.md` | `filament/nested-resources.md` | Geo Module - Nested Resource Implementation Guide | link in ingresso: 0 | proposto |
| `static-map-clickable-implementation.md` | `filament/static-map-clickable-implementation.md` | Mappa Statica Cliccabile - Implementazione | link in ingresso: 1 | proposto |
| `story-map-component-analysis.md` | `filament/story-map-component-analysis.md` | Analisi del Componente Mappa per Ticket Wizard | link in ingresso: 4 | proposto |
| `translation-structure-expanded.md` | `filament/translation-structure-expanded.md` | translation structure expanded | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `translation.md` | `filament/translation.md` | Translation Audit Report - (DATE) | link in ingresso: 0 | proposto |
| `wizard-location-data-flow.md` | `filament/wizard-location-data-flow.md` | Wizard Location Data Flow - Fix Documentation | link in ingresso: 0 | proposto |

## Gruppo L: Testing (13)

Motivo del gruppo: documentazione di test: casa naturale testing/. Stato di tutte le righe: `proposto`.

| Vecchio | Nuovo proposto | Scopo | Nota | Stato |
|---|---|---|---|---|
| `architecture-testing-env.md` | `testing/architecture-testing-env.md` | Testing Environment | link in ingresso: 0 | proposto |
| `basemodel-testing-lessons-learned.md` | `testing/basemodel-testing-lessons-learned.md` | BaseModel Testing - Lessons Learned (Gennaio 2025) | link in ingresso: 0 | proposto |
| `module-testing-analysis.md` | `testing/module-testing-analysis.md` | Analisi Completa Testing e Factory Moduli - nome progetto | link in ingresso: 0 | proposto |
| `testatabase-elimination-strategy.md` | `testing/testatabase-elimination-strategy.md` | Strategia di Eliminazione Database dai Test - nome progetto | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `testing-architecture-overview.md` | `testing/testing-architecture-overview.md` | Architettura di Testing - nome progetto | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `testing/testing-architecture-overview.md`; link in ingresso: 3 | proposto |
| `testing-guide.md` | `testing/testing-guide.md` | nome progetto Testing Guide | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `testing/testing-guide.md`; link in ingresso: 0 | proposto |
| `testing-guidelines.md` | `testing/testing-guidelines.md` | Geo Module - Testing Guidelines | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `testing/testing-guidelines.md`; link in ingresso: 5 | proposto |
| `testing-implementation-complete.md` | `testing/testing-implementation-complete.md` | Implementazione Completa Test Pest per Moduli nome progetto | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; link in ingresso: 0 | proposto |
| `testing-psr4-standards.md` | `testing/testing-psr4-standards.md` | Standard PSR-4 per i Test in Laraxot nome progetto | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `testing/testing-psr4-standards.md`; link in ingresso: 0 | proposto |
| `testing-resolution.md` | `testing/testing-resolution.md` | Testing Error Resolution Guide - nome progetto Project | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `testing/testing-resolution.md`; link in ingresso: 0 | proposto |
| `testing-strategy-modules.md` | `testing/testing-strategy-modules.md` | Strategia di Testing per i Moduli nome progetto | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; link in ingresso: 1 | proposto |
| `testing-testcase-database-connection-fix.md` | `testing/testing-testcase-database-connection-fix.md` | Fix: Geo TestCase - Database Connection Configuration | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; link in ingresso: 0 | proposto |
| `testing.md` | `testing/testing.md` | Testing in the Geo Module | destinazione gia occupata da un file IDENTICO: la copia in radice e superflua; identico anche a `testing/testing.md`; link in ingresso: 4 | proposto |

## Gruppo M: Architettura, filosofia e guide (48)

Motivo del gruppo: architettura/guida concettuale: casa naturale architecture/. Stato di tutte le righe: `proposto`.

| Vecchio | Nuovo proposto | Scopo | Nota | Stato |
|---|---|---|---|---|
| `about.md` | `architecture/about.md` | BashScripts Fila3 | link in ingresso: 0 | proposto |
| `advanced-features-backup.md` | `architecture/advanced-features-backup.md` | advanced features backup | stub (<200 caratteri); omonimo con contenuto diverso: `advanced-features-backup.md`; link in ingresso: 0 | proposto |
| `advanced-features.md` | `architecture/advanced-features.md` | advanced features | stub (<200 caratteri); omonimo con contenuto diverso: `advanced-features.md`; link in ingresso: 0 | proposto |
| `advanced-features.md` | `architecture/ADVANCED_FEATURES.md` | Funzionalità Avanzate del Modulo Geo | omonimo con contenuto diverso: `advanced-features.md`; collisione di maiuscole nella destinazione; link in ingresso: 1 | proposto |
| `advanced-features.md` | `architecture/advanced_features.md` | Funzionalità Avanzate del Modulo Geo | omonimo con contenuto diverso: `advanced-features.md`; collisione di maiuscole nella destinazione; link in ingresso: 3 | proposto |
| `advanced-features-backup.md` | `architecture/advanced_features_backup.md` | Funzionalità Avanzate del Modulo Geo | omonimo con contenuto diverso: `advanced-features-backup.md`; link in ingresso: 0 | proposto |
| `app-integration.md` | `architecture/app-integration.md` | app | link in ingresso: 3 | proposto |
| `app.md` | `architecture/app.md` | app | stub (<200 caratteri); link in ingresso: 3 | proposto |
| `architectural-philosophy.md` | `architecture/architectural-philosophy.md` | Architectural Philosophy - Geo Module | link in ingresso: 1 | proposto |
| `architectural-violation-fix-plan.md` | `architecture/architectural-violation-fix-plan.md` | PIANO DI CORREZIONE: Violazione Architetturale Critica | link in ingresso: 0 | proposto |
| `architecture.md` | `architecture/architecture.md` | Geo Module Architecture | link in ingresso: 29 | proposto |
| `comprehensive-backup.md` | `architecture/comprehensive-backup.md` | comprehensive backup | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `comprehensive-guide-backup.md` | `architecture/comprehensive-guide-backup.md` | comprehensive guide backup | stub (<200 caratteri); omonimo con contenuto diverso: `comprehensive-guide-backup.md`; link in ingresso: 0 | proposto |
| `comprehensive-guide.md` | `architecture/comprehensive-guide.md` | comprehensive guide | stub (<200 caratteri); omonimo con contenuto diverso: `comprehensive-guide.md`; link in ingresso: 0 | proposto |
| `comprehensive.md` | `architecture/comprehensive.md` | comprehensive | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `comprehensive-guide.md` | `architecture/COMPREHENSIVE_GUIDE.md` | Comprehensive Guide for Geo Module | omonimo con contenuto diverso: `comprehensive-guide.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `comprehensive-guide.md` | `architecture/comprehensive_guide.md` | Comprehensive Guide for Geo Module | omonimo con contenuto diverso: `comprehensive-guide.md`; collisione di maiuscole nella destinazione; link in ingresso: 3 | proposto |
| `comprehensive-guide-backup.md` | `architecture/comprehensive_guide_backup.md` | Comprehensive Guide for Geo Module | omonimo con contenuto diverso: `comprehensive-guide-backup.md`; link in ingresso: 0 | proposto |
| `dependencies.md` | `architecture/dependencies.md` | Dependencies (Module Geo) | link in ingresso: 1 | proposto |
| `dependency-intelligence.md` | `architecture/dependency-intelligence.md` | Dependency Intelligence - Module Geo | link in ingresso: 1 | proposto |
| `eloquent-integration.md` | `architecture/eloquent-integration.md` | __eloquent | link in ingresso: 0 | proposto |
| `eloquent.md` | `architecture/eloquent.md` | eloquent | stub (<200 caratteri); omonimo con contenuto diverso: `eloquent.md`; link in ingresso: 0 | proposto |
| `implementation-summary.md` | `architecture/implementation-summary.md` | Riepilogo Implementazione AddressesField | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `implementation-summary.md` | `architecture/implementation-summary.md` | Riepilogo Implementazione AddressesField | omonimo con contenuto diverso: `implementation-summary.md`; link in ingresso: 0 | proposto |
| `implementation-sumy.md` | `architecture/implementation-sumy.md` | Riepilogo Implementazione AddressesField | canonico delle copie byte-identiche; nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `implementation.md` | `architecture/implementation.md` | implementation | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `implementation-summary.md` | `architecture/implementation_summary.md` | Riepilogo Implementazione AddressesField | omonimo con contenuto diverso: `implementation-summary.md`; link in ingresso: 0 | proposto |
| `implementation-sumy.md` | `wiki/_archive/duplicates/implementation_sumy.md` | Riepilogo Implementazione AddressesField | copia byte-identica di `implementation-sumy.md`; nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `laravel-packages-integration.md` | `architecture/laravel-packages-integration.md` | laravel_packages | link in ingresso: 0 | proposto |
| `laravel-packages.md` | `wiki/_archive/duplicates/laravel-packages.md` | laravel packages | copia byte-identica di `laravel-packages.md`; link in ingresso: 0 | proposto |
| `laravel-packages.md` | `architecture/laravel_packages.md` | laravel packages | canonico delle copie byte-identiche; link in ingresso: 3 | proposto |
| `logging-performance.md` | `architecture/logging-performance.md` | Logging Performance Optimization | link in ingresso: 0 | proposto |
| `module-geo-1.md` | `architecture/module-geo-1.md` | Modulo Geo | nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `module-geo.md` | `wiki/_archive/duplicates/module-geo.md` | Modulo Geo | copia byte-identica di `module-geo.md`; link in ingresso: 0 | proposto |
| `module-reusability-guidelines.md` | `architecture/module-reusability-guidelines.md` | Linee Guida per la Riusabilità dei Moduli Laraxot | link in ingresso: 0 | proposto |
| `module-reusability-implementation-plan.md` | `architecture/module-reusability-implementation-plan.md` | Piano di Implementazione Riusabilità Moduli | link in ingresso: 0 | proposto |
| `module.md` | `architecture/module.md` | module | stub (<200 caratteri); link in ingresso: 0 | proposto |
| `module-geo.md` | `architecture/module_geo.md` | Modulo Geo | canonico delle copie byte-identiche; link in ingresso: 16 | proposto |
| `philosophy.md` | `architecture/PHILOSOPHY.md` | Geo Module Philosophy | omonimo con contenuto diverso: `philosophy.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `philosophy.md` | `architecture/philosophy.md` | philosophy | stub (<200 caratteri); omonimo con contenuto diverso: `philosophy.md`; collisione di maiuscole nella destinazione; link in ingresso: 1 | proposto |
| `project-structure.md` | `architecture/PROJECT-STRUCTURE.md` | Project Structure - Module Geo | omonimo con contenuto diverso: `project-structure.md`; collisione di maiuscole nella destinazione; link in ingresso: 0 | proposto |
| `project-structure.md` | `architecture/project-structure.md` | Project Structure - Module Geo | omonimo con contenuto diverso: `project-structure.md`; collisione di maiuscole nella destinazione; link in ingresso: 1 | proposto |
| `readme-en.md` | `architecture/readme-en.md` | Geo - English presentation | link in ingresso: 0 | proposto |
| `reusable-components-philosophy.md` | `architecture/reusable-components-philosophy.md` | Filosofia dei Componenti Riutilizzabili | link in ingresso: 1 | proposto |
| `technical.md` | `architecture/TECHNICAL.md` | Documentazione Tecnica Modulo Geo | omonimo con contenuto diverso: `technical.md`; collisione di maiuscole nella destinazione; link in ingresso: 4 | proposto |
| `technical.md` | `architecture/technical.md` | technical | stub (<200 caratteri); omonimo con contenuto diverso: `technical.md`; collisione di maiuscole nella destinazione; link in ingresso: 3 | proposto |
| `tutorial.md` | `architecture/tutorial.md` | tutorial | link in ingresso: 3 | proposto |
| `vite-build-configuration.md` | `architecture/vite-build-configuration.md` | Geo Module Vite Build Configuration | link in ingresso: 1 | proposto |

## Gruppo N: Report di sessione e riepiloghi (8)

Motivo del gruppo: riepilogo di lavoro passato: storico, da archiviare. Stato di tutte le righe: `proposto`.

| Vecchio | Nuovo proposto | Scopo | Nota | Stato |
|---|---|---|---|---|
| `changelog.md` | `wiki/_archive/reports/changelog.md` | Changelog | identico anche a `raw/root-import/changelog.md`; stub (<200 caratteri); omonimo con contenuto diverso: `changelog.md`; link in ingresso: 0 | proposto |
| `github-actions-setup.md` | `wiki/_archive/reports/github-actions-setup.md` | GitHub Actions Setup - Semantic Versioning & Auto-Release | link in ingresso: 0 | proposto |
| `github-interaction-log.md` | `wiki/_archive/reports/github-interaction-log.md` | GitHub Interaction Log - Module Geo | canonico delle copie byte-identiche; link in ingresso: 0 | proposto |
| `github-interaction-log.md` | `wiki/_archive/reports/GITHUB_INTERACTION_LOG.md` | GitHub Interaction Log - Module Geo | omonimo con contenuto diverso: `github-interaction-log.md`; link in ingresso: 0 | proposto |
| `github-interaction-log.md` | `wiki/_archive/duplicates/github_interaction_log.md` | GitHub Interaction Log - Module Geo | copia byte-identica di `github-interaction-log.md`; link in ingresso: 0 | proposto |
| `session-summary-refactoring.md` | `wiki/_archive/reports/session-summary-refactoring.md` | SESSION SUMMARY - Refactoring Module Inheritance | canonico delle copie byte-identiche; link in ingresso: 0 | proposto |
| `session-summary-refactoring.md` | `wiki/_archive/reports/SESSION_SUMMARY_REFACTORING.md` | SESSION SUMMARY - Refactoring Module Inheritance | omonimo con contenuto diverso: `session-summary-refactoring.md`; link in ingresso: 0 | proposto |
| `session-summary-refactoring.md` | `wiki/_archive/duplicates/session_summary_refactoring.md` | SESSION SUMMARY - Refactoring Module Inheritance | copia byte-identica di `session-summary-refactoring.md`; link in ingresso: 0 | proposto |

## Gruppo Z: File di configurazione e tooling copiati nella radice (50)

Motivo del gruppo: non e documentazione: copia di tooling del modulo. Stato di tutte le righe: `proposto`.

| Vecchio | Nuovo proposto | Scopo | Nota | Stato |
|---|---|---|---|---|
| `.dockerignore` | `config/.dockerignore` | (senza titolo, 30 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `.env.example` | `config/.env.example` | (senza titolo, 31 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `.gitattributes` | `config/.gitattributes` | CSS, SCSS, JS files are vendored | diverso dal file di pari nome nella radice del modulo; link in ingresso: 0 | proposto |
| `.gitignore` | `config/.gitignore` | (senza titolo, 27 byte) | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; diverso dal file di pari nome nella radice del modulo; link in ingresso: 0 | proposto |
| `.gitkeep` | `config/.gitkeep` | (vuoto, 0 byte) | identico anche a `workbench/app/Models/.gitkeep`; assente nella radice del modulo; link in ingresso: 0 | proposto |
| `.md` | `config/.md` | (senza titolo, 298 byte) | nome corrotto o sospetto; assente nella radice del modulo; link in ingresso: 0 | proposto |
| `.php_cs` | `config/.php_cs` | (senza titolo, 938 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `.windsurfrules` | `config/.windsurfrules` | Regole per i Trait del Modulo User | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `.wslconfig` | `config/.wslconfig` | Ollama Optimization for i5-8400, 30GB RAM system | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `a.git` | `config/a.git` | (senza titolo, 66 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `bmm-workflow-status.yaml` | `config/bmm-workflow-status.yaml` | BMAD Method Workflow Status | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `composer.json` | `config/composer.json` | (vuoto, 0 byte) | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; identico anche a `workbench/app/Models/.gitkeep`; diverso dal file di pari nome nella radice del modulo; link in ingresso: 0 | proposto |
| `composer_6x.json` | `config/composer_6x.json` | (senza titolo, 2529 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `cursor.mdc` | `config/cursor.mdc` | Cursor - Regole, Best Practice e Integrazione MCP | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `enums.mdc` | `config/enums.mdc` | (senza titolo, 172 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `index.html` | `config/index.html` | (senza titolo, 126 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `LICENSE` | `config/LICENSE` | (senza titolo, 1063 byte) | omonimo con contenuto diverso: `license.md`; collisione di maiuscole nella destinazione; assente nella radice del modulo; link in ingresso: 4 | proposto |
| `license` | `config/license` | (senza titolo, 1063 byte) | omonimo con contenuto diverso: `license.md`; collisione di maiuscole nella destinazione; assente nella radice del modulo; link in ingresso: 0 | proposto |
| `license.md` | `config/LICENSE.md` | LICENSE | omonimo con contenuto diverso: `license.md`; collisione di maiuscole nella destinazione; assente nella radice del modulo; link in ingresso: 0 | proposto |
| `license.md` | `config/license.md` | license | identico anche a `raw/history/license.md`; omonimo con contenuto diverso: `license.md`; collisione di maiuscole nella destinazione; assente nella radice del modulo; link in ingresso: 0 | proposto |
| `location-select.mdc` | `config/location-select.mdc` | Regola: Path LocationForm | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `mcp-config.json` | `config/mcp-config.json` | (senza titolo, 943 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `module.json` | `config/module.json` | (senza titolo, 6629 byte) | diverso dal file di pari nome nella radice del modulo; link in ingresso: 0 | proposto |
| `package.json` | `config/package.json` | (senza titolo, 432 byte) | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; diverso dal file di pari nome nella radice del modulo; link in ingresso: 0 | proposto |
| `phpmd.ruleset.xml` | `config/phpmd.ruleset.xml` | (senza titolo, 2376 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `phpstan-baseline.neon` | `config/phpstan-baseline.neon` | (vuoto, 0 byte) | identico anche a `workbench/app/Models/.gitkeep`; assente nella radice del modulo; link in ingresso: 0 | proposto |
| `phpstan-sigma-ignore.neon` | `config/phpstan-sigma-ignore.neon` | Specifico per i problemi di covarianza nei modelli Eloquent | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `phpstan-sigma-test.neon` | `config/phpstan-sigma-test.neon` | (senza titolo, 1275 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `phpstan-single.neon` | `config/phpstan-single.neon` | (senza titolo, 862 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `phpstan-temp.neon` | `config/phpstan-temp.neon` | (senza titolo, 2285 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `phpstan.neon` | `config/phpstan.neon` | (senza titolo, 920 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `phpstan.neon.dist` | `config/phpstan.neon.dist` | Template PHPStan per pacchetti sotto docs/ (adatta paths / includes a | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `phpstan.neon.test` | `config/phpstan.neon.test` | (senza titolo, 1624 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `phpunit.xml` | `config/phpunit.xml` | (senza titolo, 2544 byte) | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; assente nella radice del modulo; link in ingresso: 0 | proposto |
| `phpunit.xml.dist` | `config/phpunit.xml.dist` | (senza titolo, 1011 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `pint.json` | `config/pint.json` | (senza titolo, 1938 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `postcss.config.js` | `config/postcss.config.js` | (vuoto, 0 byte) | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; identico anche a `workbench/app/Models/.gitkeep`; assente nella radice del modulo; link in ingresso: 0 | proposto |
| `prd.json` | `config/prd.json` | (senza titolo, 1124 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `psalm.xml` | `config/psalm.xml` | (senza titolo, 735 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `ptvx.local.conf` | `config/ptvx.local.conf` | Deprecato - SSOT: laravel/config/vhost/ptvx.local.conf | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `README.md.cleaned` | `config/README.md.cleaned` | Geo Module - Gestione Avanzata Dati Geografici | omonimo con contenuto diverso: `readme.md.cleaned`; collisione di maiuscole nella destinazione; assente nella radice del modulo; link in ingresso: 0 | proposto |
| `readme.md.cleaned` | `config/readme.md.cleaned` | Geo Module - Gestione Avanzata Dati Geografici | omonimo con contenuto diverso: `README.md.cleaned`; collisione di maiuscole nella destinazione; assente nella radice del modulo; link in ingresso: 0 | proposto |
| `sedhkvjre` | `config/sedhkvjre` | (senza titolo, 3730 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `sprint-status.yaml` | `config/sprint-status.yaml` | BMAD Method Sprint Status (Claude layer) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `tailwind.config.js` | `config/tailwind.config.js` | (vuoto, 0 byte) | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; identico anche a `workbench/app/Models/.gitkeep`; assente nella radice del modulo; link in ingresso: 0 | proposto |
| `testbench.yaml` | `config/testbench.yaml` | (senza titolo, 11 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `vite.config.js` | `config/vite.config.js` | (vuoto, 0 byte) | identico anche a `workbench/app/Models/.gitkeep`; diverso dal file di pari nome nella radice del modulo; link in ingresso: 0 | proposto |
| `webpack.mix.js` | `config/webpack.mix.js` | (vuoto, 0 byte) | identico anche a `workbench/app/Models/.gitkeep`; diverso dal file di pari nome nella radice del modulo; link in ingresso: 0 | proposto |
| `windsurf-enums.mdc` | `config/windsurf-enums.mdc` | (senza titolo, 199 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |
| `windsurf.mdc` | `config/windsurf.mdc` | (senza titolo, 181 byte) | assente nella radice del modulo; link in ingresso: 0 | proposto |

## Gruppo Y: Da classificare (revisione umana) (6)

Motivo del gruppo: scratch di prova (file di test vuoti o quasi) o nome malformato: nessun bersaglio certo, serve una decisione umana. Stato di tutte le righe: `proposto`.

| Vecchio | Nuovo proposto | Scopo | Nota | Stato |
|---|---|---|---|---|
| `eloquent.md` | `wiki/_archive/duplicates/--eloquent.md` | eloquent | copia byte-identica di `eloquent.md`; nome corrotto o sospetto; link in ingresso: 0 | proposto |
| `eloquent.md` | `_integration/__eloquent.md` | eloquent | DESTINAZIONE GIA OCCUPATA da un file diverso: confrontare prima di spostare; canonico delle copie byte-identiche; nome corrotto o sospetto; link in ingresso: 3 | proposto |
| `test-27-02.md` | `wiki/_archive/unclassified/test-27-02.md` | test 27 02 2024 | identico anche a `raw/root-import/test-27-02.md`; stub (<200 caratteri); link in ingresso: 0 | proposto |
| `test.md` | `wiki/_archive/unclassified/test.md` | test | identico anche a `raw/root-import/test.md`; stub (<200 caratteri); link in ingresso: 0 | proposto |
| `test1.md` | `wiki/_archive/unclassified/test1.md` | test1 | identico anche a `raw/root-import/test1.md`; stub (<200 caratteri); link in ingresso: 0 | proposto |
| `test-27-02-2024.md` | `wiki/_archive/unclassified/test_27_02_2024.md` | Test 27 02 2024 | stub (<200 caratteri); link in ingresso: 0 | proposto |

## Come eseguire (dopo la decisione)

1. Una persona approva i gruppi uno alla volta e cambia lo stato in `approvato` nella riga o nel `decision-log.md`.
2. Per ogni gruppo approvato: `git mv` file per file (nessun comando che cancelli), poi `docs-organizer.py links ... --fix`.
3. Rimisurare: `docs-organizer.py links laravel/Modules/Geo/docs` deve restituire zero eventi `fixed`; gli `unresolved` residui puntano a file inesistenti e vanno annotati (`--annotate`) o riscritti, mai inventando bersagli.
4. Aggiornare `index.md` e `wiki/log.md` con la voce dello spostamento.
