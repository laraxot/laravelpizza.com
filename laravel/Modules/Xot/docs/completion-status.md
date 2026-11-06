---
title: "Xot: cosa manca per completare"
type: status
module: Xot
updated: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
related:
  - ../../Xot/docs/project-completion-status.md
---

# Xot: cosa manca per completare

Fotografia misurata il 2026-10-28 (sola lettura). Si rigenera con gli stessi controlli: story nel frontmatter,
PHPStan livello 10, blade troncate, traduzioni, test. Riepilogo di progetto: `Modules/Xot/docs/project-completion-status.md`.

## Indicatori

| Indicatore | Valore |
|---|---|
| File PHP in `app/` | 578 |
| Errori PHPStan livello 10 | 1 |
| Blade (troncate in testa) | 55 (0) |
| File di test (`*Test.php`) | 194 |
| TODO/FIXME nel codice | 5 |
| Traduzioni it / en (solo in it) | 136 / 60 (76) |
| Story/epic BMAD (aperte) | 147 (107) |

## Problemi noti e prossimi passi

| Priorita' | Problema | Dove si lavora |
|---|---|---|
| ERRORE | Il tenant scrive `forcessl`, XotData legge `force_ssl`: impostazione ignorata. | `stories/force-ssl-key-mismatch.story.md` |
| AVVISO | `phpstan-bootstrap.php` richiesto da `phpstan.neon` ma cancellato nel commit 9bf7ec3fed: PHPStan non parte senza ricrearlo. | decisione utente (phpstan.neon non si tocca) |

Problemi trasversali (valgono per tutto il progetto): vedi `project-completion-status.md` in Xot.

## Story aperte (per stato)

| Stato | Story |
|---|---|
| in_progress | [Fix PHPStan Level 10 Errors in Xot Module](docs/bmad/stories/1.1-phpstan-xot-fixes.story.md) |
| in-progress | [Consolidate orphan docs across modules](docs/bmad/stories/10.01-docs-orphan-consolidation.story.md) |
| in-progress | [Story 5.249: BMAD docs fleet: documenti canonici mancanti in ogni modulo](docs/bmad/stories/5.249-bmad-docs-fleet-completion.story.md) |
| in-progress | [Story 5.256: Modulo User: cluster, widget, azioni, DRY/KISS/UI-UX/a11y](docs/bmad/stories/5.256-user-module-clusters-widgets-actions.story.md) |
| in-progress | [Story 5.258: Eseguire e poi migliorare tutti i prompt di bashscripts/docs/prompts (swarm,](docs/bmad/stories/5.258-prompts-execute-improve.story.md) |
| in-progress | [Story 5.260: PHPStan Modules: remediation del baseline corrente](docs/bmad/stories/5.260-phpstan-modules-current-remediation.story.md) |
| in-progress | [PHPStan analyse Modules: 480 errori su 68 file (Sigma 302, Tenant 177, Performance 1)](docs/bmad/stories/5.261-phpstan-modules-480-errors.story.md) |
| in-progress | [Story 5.300: Le base List per-modulo vuote in Resources/Pages/ sono un anti-pattern: la b](docs/bmad/stories/5.300-no-empty-list-base-classes.story.md) |
| in-progress | [Story 5.301: PSR-4 autoload compliance fleet + runtime smoke verde](docs/bmad/stories/5.301-psr-4-autoload-compliance-fleet.story.md) |
| in-progress | [Story 8.25: Docs Consolidation Audit: strategy per moduli e temi](docs/bmad/stories/8.25.docs-consolidation-audit-strategy.story.md) |
| in-progress | [Installazione setup automazioni per Codex](docs/bmad/stories/codex-project-setup.story.md) |
| in-progress | [Approfondimento "scheda" pattern (IndennitaResponsabilita vs Progressioni)](docs/bmad/stories/deep-dive-scheda-pattern.story.md) |
| in-progress | [Epic: Docs ≤100 .md ricorsivi via merge (fleet-wide, 2026-10-05)](docs/bmad/stories/docs-100-fleet-merge.story.md) |
| in-progress | [Docs consolidation: orphan files + structure normalization: 2026-10-06](docs/bmad/stories/docs-consolidation-orphan-files.story.md) |
| in-progress | [Riorganizzazione continua docs moduli e temi (lotto C, prima passata)](docs/bmad/stories/docs-modules-themes-continuous-reorg.story.md) |
| in-progress | [Riorganizzazione massiva docs moduli, temi e prompt](docs/bmad/stories/docs-prompts-reorganization.story.md) |
| in_progress | [STORY-492 (Xot/bmad/stories): `getTableColumns()`: che cosa usare al suo posto (guida + d](docs/bmad/stories/gettablecolumns-deprecation-guidance.story.md) |
| in_progress | [Eliminare Modules/*/app/Http/Livewire: canon Framework: Filament widget](docs/bmad/stories/lw2fw-01.livewire-to-filament.story.md) |
| in-progress | [Igiene della root dei moduli: cartelle, tooling, workspace, md](docs/bmad/stories/module-root-hygiene.story.md) |
| in-progress | [Approfondimento orientamento progetto (deep dive)](docs/bmad/stories/project-orientation-deep-dive.story.md) |
| in-progress | [Qualità progetto: verifica e correzioni prioritarie](docs/bmad/stories/project-quality-audit.story.md) |
| in-progress | [Fleet: Services to Queueable Actions](docs/bmad/stories/services-to-queueable-actions-fleet.story.md) |
| in_progress | [8.6 - PHPStan Type Safety: method.nonObject and assign.propertyType Fixes](docs/stories/8.6-phpstan-type-safety-method-nonobject-fixes.story.md) |
| in-progress | [DCP-184: getFormSchemaOld() diventa final in XotBaseResource, migrazione dei 9 override e ](docs/stories/dcp-184-getformschemaold-final-migrazione-e-consumatori-diretti.story.md) |
| in-progress | [Marker di merge committati nei docs dei moduli: risoluzione senza perdite e per scopo](docs/stories/docs-committed-merge-markers.story.md) |
| in-progress | [Copie numerate dei docs (-1.md, -2.md): consolidamento senza perdite](docs/stories/docs-numbered-copies-consolidation.story.md) |
| in-progress | [Xot: riordino della docs, numeri prima e dopo](docs/stories/docs-organization-xot.story.md) |
| in-progress | [Xot - fix-xot-convention-tests.story.md](docs/stories/fix-xot-convention-tests.story.md) |
| in-progress | [Xot - fix-xot-unit-misc-tests.story.md](docs/stories/fix-xot-unit-misc-tests.story.md) |
| in-progress | [Dossier di ripresa, verso zero PHPStan e sidebar admin](docs/stories/handoff-zero-phpstan-ripresa.story.md) |
| in_progress | [HasXotFactory count/state + Module registry Sushi](docs/stories/hasxotfactory-count-state-and-module-registry.story.md) |
| in-progress | [Vietare migrate --force nei test di Xot con un test di architettura](docs/stories/xot-no-destructive-migrate-in-tests.story.md) |
| review | [Fleet: git status + marker HEAD + quality per ogni modulo](docs/bmad/stories/cleanup-all-modules.story.md) |
| review | [Studio e configurazione ECC per Codex](docs/bmad/stories/ecc-codex-plugin-setup.story.md) |
| review | [Normalizzazione README root dei moduli](docs/bmad/stories/module-readmes-normalization.story.md) |
| review | [[STORY] Adeguamento test dopo rimozione ModuleService](docs/bmad/stories/module-service-test-decision.story.md) |
| review | [Generazione password: lunghezza e casualità crittografica](docs/bmad/stories/password-generation-quality.story.md) |
| review | [Esegui e migliora 03-quality-gates.md](docs/bmad/stories/quality-gates-prompt-exec.story.md) |
| review | [8.5-file-type-icons-heroicons-outline.story.md](docs/stories/8.5-file-type-icons-heroicons-outline.story.md) |
| review | [Datas, mai Data ne' DTOs: causa alla fonte e guardia a test](docs/stories/datas-folder-convention-guard.story.md) |
| review | [[STORY] Residui di debug in produzione: Xot, Cms, Lang, UI](docs/stories/debug-leftovers-cleanup-xot.story.md) |
| review | [Mai app/Jobs ne' app/Services: il perche' nella regola, eccezioni e guardie](docs/stories/no-jobs-no-services-rule-why.story.md) |
| ready-for-dev | [Correzione max 5 .md in root per tutti i moduli](docs/bmad/stories/5.128-module-root-md-max5-fix.story.md) |
| ready-for-dev | [Story 5.163: ExportXlsLazyAction perde i title rating](docs/bmad/stories/5.163-lazy-export-labelled-headings.story.md) |
| ready-for-dev | [TRIGGER_MAP: voce export ratings XLS / getXlsFields](docs/bmad/stories/5.175-trigger-map-export-ratings-xls.story.md) |
| ready-for-dev | [Export XLS/XLSX: sanitizzare formula injection (=, +, -, @)](docs/bmad/stories/5.176-export-xls-formula-injection-sanitize.story.md) |
| ready-for-dev | [Supersede Xot/5.161 export-xls-headings → collection-export intestazioni](docs/bmad/stories/5.177-export-xls-headings-supersede.story.md) |
| ready-for-dev | [Dedup story lazy export labels (5.163 + export-lazy-action-labels)](docs/bmad/stories/5.178-export-lazy-labels-dedup.story.md) |
| ready-for-dev | [Xot: pack export lazy + TRIGGER_MAP per domani](docs/bmad/stories/5.247-tomorrow-pack-export-lazy-and-trigger-map.story.md) |
| ready-for-dev | [Story 5.255: Doppi header actions in ogni List page (Create due volte)](docs/bmad/stories/5.255-doppi-header-actions-list-page.story.md) |
| ready | [Story: doppio tracking laravel/Modules: repo root + submoduli](docs/bmad/stories/double-tracking-modules-root.story.md) |
| ready | [Story: contratto getXlsEagerLoad su Resource](docs/bmad/stories/export-eager-load-contract.story.md) |
| ready | [Story: ExportXlsLazyAction: label degradate a path tecnico](docs/bmad/stories/export-lazy-action-labels.story.md) |
| ready-for-dev | [Migrare i custom Livewire UI a Filament Widgets](docs/bmad/stories/livewire-to-filament-widgets-fleet.story.md) |
| ready | [Story: bonifica marker merge residui fleet](docs/bmad/stories/merge-marker-fleet-residue.story.md) |
| ready-for-dev | [Xot: baseline BMAD e analisi completa](docs/bmad/stories/module-bmad-audit.story.md) |
| ready-for-dev | [Verifica e correzione max 5 .md in root modulo ($MODULO)](docs/bmad/stories/root-md-max5-verify.story.md) |
| ready | [Story: gap tooling quality: phpinsights assente, qmd embed backlog, graphify lento](docs/bmad/stories/tooling-quality-gaps.story.md) |
| ready-for-dev | [Rimozione delle icone statiche dalle XotBaseResource](docs/bmad/stories/xot-base-resource-navigation-icon-translation.story.md) |
| ready-for-dev | [Code quality: audit label hardcoded Filament](docs/stories/code-quality-filament-label-audit.story.md) |

... e altre 47 (cercare `status:` diverso da done in `docs/**/*.story.md`).

1 story non hanno `status:` nel frontmatter: vanno classificate (done / backlog / superseded).
