---
title: "Media: cosa manca per completare"
type: status
module: Media
updated: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
related:
  - ../../Xot/docs/project-completion-status.md
---

# Media: cosa manca per completare

Fotografia misurata il 2026-10-28 (sola lettura). Si rigenera con gli stessi controlli: story nel frontmatter,
PHPStan livello 10, blade troncate, traduzioni, test. Riepilogo di progetto: `Modules/Xot/docs/project-completion-status.md`.

## Indicatori

| Indicatore | Valore |
|---|---|
| File PHP in `app/` | 121 |
| Errori PHPStan livello 10 | 0 |
| Blade (troncate in testa) | 9 (0) |
| File di test (`*Test.php`) | 41 |
| TODO/FIXME nel codice | 0 |
| Traduzioni it / en (solo in it) | 31 / 13 (18) |
| Story/epic BMAD (aperte) | 35 (18) |

## Problemi noti e prossimi passi

Nessun problema bloccante emerso dai controlli del 2026-10-28 oltre agli indicatori sopra e alle story aperte.

Problemi trasversali (valgono per tutto il progetto): vedi `project-completion-status.md` in Xot.

## Story aperte (per stato)

| Stato | Story |
|---|---|
| in_progress | [Fix PHPStan Level 10 Errors in Media Module](docs/bmad/stories/1.3-phpstan-media-fixes.story.md) |
| review | [Media: marker README + CHANGELOG in HEAD](docs/bmad/stories/readme-changelog-conflict-markers.story.md) |
| ready-for-dev | [Media: baseline BMAD e analisi completa](docs/bmad/stories/module-bmad-audit.story.md) |
| ready-for-dev | [Media Module BMAD Setup](docs/stories/media-module-bmad-setup.story.md) |
| ready-for-dev | [Media PHPStan swarm: ground truth stale, sorgenti gia' sane, nessun edit](docs/stories/media-phpstan-swarm-verifica-fonti.story.md) |
| ready-for-dev | [Media: test mai eseguiti e doppioni per sole maiuscole](docs/stories/media-test-mai-eseguiti-e-doppioni-maiuscole.story.md) |
| ready-for-dev | [Media: generatore Webm non registrato e componente Livewire Clip](docs/stories/media-webm-non-registrato-e-clip-livewire.story.md) |
| backlog | [Continuazione domani](docs/bmad/stories/continuazione-domani.story.md) |
| backlog | ['Git LFS: backfill 11 missing image objects'](docs/stories/5.3.git-lfs-backfill.story.md) |
| backlog | [LFS validation in CI](docs/stories/5.4.lfs-ci-validation.story.md) |
| backlog | [Diritti e accessibilità dei media editoriali](docs/stories/inbound-media-rights.story.md) |
| draft | [Media: epic 5.250: architettura e contratto API modulo](docs/bmad/epics/architecture-contract.epic.md) |
| draft | [Story: Cleanup Media Module](docs/bmad/stories/cleanup-media.story.md) |
| draft | [Riorganizzazione docs core Media](docs/bmad/stories/docs-reorg-core.story.md) |
| ready_for_dev | [Install and integrate spatie/laravel-medialibrary](docs/stories/16.5.spatie-medialibrary.story.md) |
| senza-status | [7.1.deprecated gettableactions migration.story](docs/stories/7.1.deprecated-gettableactions-migration.story.md) |
| senza-status | [Media Module: Table Audit and $model Property](docs/stories/continuation.story.md) |
| senza-status | [media docs conflict marker cleanup 2026 09 22.story](docs/stories/media-docs-conflict-marker-cleanup.story.md) |

3 story non hanno `status:` nel frontmatter: vanno classificate (done / backlog / superseded).
