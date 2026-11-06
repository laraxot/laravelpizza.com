---
title: "Activity: cosa manca per completare"
type: status
module: Activity
updated: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
related:
  - ../../Xot/docs/project-completion-status.md
---

# Activity: cosa manca per completare

Fotografia misurata il 2026-10-28 (sola lettura). Si rigenera con gli stessi controlli: story nel frontmatter,
PHPStan livello 10, blade troncate, traduzioni, test. Riepilogo di progetto: `Modules/Xot/docs/project-completion-status.md`.

## Indicatori

| Indicatore | Valore |
|---|---|
| File PHP in `app/` | 88 |
| Errori PHPStan livello 10 | 6 |
| Blade (troncate in testa) | 9 (0) |
| File di test (`*Test.php`) | 100 |
| TODO/FIXME nel codice | 0 |
| Traduzioni it / en (solo in it) | 24 / 22 (2) |
| Story/epic BMAD (aperte) | 39 (32) |

## Problemi noti e prossimi passi

Nessun problema bloccante emerso dai controlli del 2026-10-28 oltre agli indicatori sopra e alle story aperte.

Problemi trasversali (valgono per tutto il progetto): vedi `project-completion-status.md` in Xot.

## Story aperte (per stato)

| Stato | Story |
|---|---|
| in-progress | [Activity: contratti PHPStan azioni e test](docs/stories/7.1.phpstan-activity-contracts.story.md) |
| review | [PHPStan Modules: remediation BMAD 2026-09-28](docs/bmad/stories/quality-gates-phpstan-fix.story.md) |
| review | [Activity: contratti PHPStan dei test harness](docs/stories/7.2.phpstan-test-harness-contracts.story.md) |
| review | [STORY: Pagina Log nel pannello Activity: consultare i file di storage/logs senza SSH/FTP](docs/stories/activity-admin-log-viewer-page.story.md) |
| ready-for-dev | [Activity: baseline BMAD e analisi completa](docs/bmad/stories/module-bmad-audit.story.md) |
| ready-for-dev | [Risolvi merge conflicts Activity tests + PHPStan L10 fixes](docs/stories/18-1-merge-conflicts-phpstan-fixes.story.md) |
| ready-for-dev | [Activity: pest()->extend(TestCase) al posto di require_once PestStubs](docs/stories/3.10.activity-pest-extend-bootstrap.story.md) |
| ready-for-dev | [Fix PHPStan L10 generics.notGeneric errors in Activity module](docs/stories/4.1.phpstan-activity-generics-fix.story.md) |
| ready-for-dev | [Activity: test che non girano o non provano e contratto del modulo](docs/stories/activity-tests-and-contract.story.md) |
| backlog | [Continuazione domani](docs/bmad/stories/continuazione-domani.story.md) |
| backlog | ['GDPR export: personal data (JSON/CSV, <30 days)'](docs/stories/3.7.gdpr-export.story.md) |
| backlog | ['Activity log: immutable event stream (creation, edit, approval, email sent)'](docs/stories/4.1.immutable-activity-log.story.md) |
| backlog | ['Activity retention: auto-archive >7 years'](docs/stories/4.2.activity-retention-archive.story.md) |
| backlog | ['GDPR DPO sign-off: impact assessment + evidence'](docs/stories/4.6.dpo-signoff-evidence.story.md) |
| backlog | ['Cleanup policy: soft-delete + archive scheduling'](docs/stories/6.4.cleanup-policy-archive-scheduling.story.md) |
| draft | [Riorganizzazione docs core Activity](docs/bmad/stories/docs-reorg-core.story.md) |
| draft | [Activity module connection property safety](docs/stories/01.08.connection-property-safety.story.md) |
| blocked-external | [PHPStan quality gate swarm: Activity (2026-09-23)](docs/bmad/stories/quality-gates-phpstan-swarm-gate-activity.story.md) |
| pending | [Fix PHPStan Activity module - 71 errors](docs/stories/3.2.phpstan-activity-71-errors.story.md) |
| senza-status | [01.activity-generics-fix.story.md](docs/stories/01.activity-generics-fix.story.md) |
| senza-status | [5.1.fix-phpstan-redactmodel-coverage.story.md](docs/stories/5.1.fix-phpstan-redactmodel-coverage.story.md) |
| senza-status | [5.61.phpstan-activity-fix.story.md](docs/stories/5.61.phpstan-activity-fix.story.md) |
| senza-status | [activity-constant-type-coverage-fix.story.md](docs/stories/activity-constant-type-coverage-fix.story.md) |
| senza-status | [activity-docs-conflict-marker-cleanup.story.md](docs/stories/activity-docs-conflict-marker-cleanup.story.md) |
| senza-status | [activity-mixed-type-reduction.story.md](docs/stories/activity-mixed-type-reduction.story.md) |
| senza-status | [activity-quality-gate-03-execution.story.md](docs/stories/activity-quality-gate-03-execution.story.md) |
| senza-status | [activity-quality-gate-phpmd-pest.story.md](docs/stories/activity-quality-gate-phpmd-pest.story.md) |
| senza-status | [bmad-activity-phpstan.story.md](docs/stories/bmad-activity-phpstan.story.md) |
| senza-status | [Consolidation activity docs 2026 10 06.story](docs/stories/consolidation-activity-docs-story.story.md) |
| senza-status | [Consolidation activity docs 2026 10 06.story](docs/stories/consolidation-activity-docs.story.md) |
| senza-status | [docs-index-audit.story.md](docs/stories/docs-index-audit.story.md) |
| senza-status | [lang-files-pipe-corruption.story.md](docs/stories/lang-files-pipe-corruption.story.md) |

13 story non hanno `status:` nel frontmatter: vanno classificate (done / backlog / superseded).
