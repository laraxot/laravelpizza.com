---
title: "Job: cosa manca per completare"
type: status
module: Job
updated: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
related:
  - ../../Xot/docs/project-completion-status.md
---

# Job: cosa manca per completare

Fotografia misurata il 2026-10-28 (sola lettura). Si rigenera con gli stessi controlli: story nel frontmatter,
PHPStan livello 10, blade troncate, traduzioni, test. Riepilogo di progetto: `Modules/Xot/docs/project-completion-status.md`.

## Indicatori

| Indicatore | Valore |
|---|---|
| File PHP in `app/` | 156 |
| Errori PHPStan livello 10 | 0 |
| Blade (troncate in testa) | 25 (0) |
| File di test (`*Test.php`) | 44 |
| TODO/FIXME nel codice | 1 |
| Traduzioni it / en (solo in it) | 51 / 31 (22) |
| Story/epic BMAD (aperte) | 32 (15) |

## Problemi noti e prossimi passi

Nessun problema bloccante emerso dai controlli del 2026-10-28 oltre agli indicatori sopra e alle story aperte.

Problemi trasversali (valgono per tutto il progetto): vedi `project-completion-status.md` in Xot.

## Story aperte (per stato)

| Stato | Story |
|---|---|
| review | [Story 4.26: PHPStan regression remediation: Job](docs/stories/4.26.phpstan-regression-remediation.story.md) |
| ready-for-dev | [JOB-4.27: PHPStan: dichiarare i param type mancanti (gate typeCoverage 99 % full-tree)](docs/stories/4.27.phpstan-paramtype-coverage.story.md) |
| ready-for-dev | [PHPStan L10: residui 4 errori (mixed, instanceof ridondante, RelationX not generic)](docs/stories/4.28.phpstan-mixed-cleanup.story.md) |
| ready-for-dev | [Job: config cache assente, azioni distruttive senza guardia, SQL su date](docs/stories/job-config-cache-assente-e-azioni-distruttive.story.md) |
| ready-for-dev | [Job: ritiro dei 4 componenti Livewire con i widget gemelli](docs/stories/job-livewire-ritiro-con-widget-gemelli.story.md) |
| ready-for-dev | [Job Module BMAD Setup](docs/stories/job-module-bmad-setup.story.md) |
| ready-for-dev | [Job: widget ClockWidget e QueueListenWidget, doppione con processo bloccante](docs/stories/job-widget-clock-queuelisten-e-processo-bloccante.story.md) |
| draft | [Riorganizzazione docs core Job](docs/bmad/stories/docs-reorg-core.story.md) |
| draft | [STORY-504: PHPInsights crash su charset iso-8859-1 in lang it](docs/stories/STORY-504-phpinsights-charset-fix.story.md) |
| pointer | [12.4 git hygiene residua (puntatore)](docs/stories/12.4.git-hygiene-queue-pid-graphify-out-aaa.story.md) |
| investigated | [Regressione: Modules/Job/Config (maiuscolo) ricomparso nella root del modulo](docs/stories/uppercase-root-dir-config-regression.story.md) |
| senza-status | [1.1.profile cast fix.story](docs/stories/1.1.profile-cast-fix.story.md) |
| senza-status | [1.2.job complete.story](docs/stories/1.2.job-complete.story.md) |
| senza-status | [Job Module: Table Audit and $model Property](docs/stories/continuation.story.md) |
| senza-status | [lang files pipe corruption job.story](docs/stories/lang-files-pipe-corruption-job.story.md) |

4 story non hanno `status:` nel frontmatter: vanno classificate (done / backlog / superseded).
