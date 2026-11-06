---
title: "Lang: cosa manca per completare"
type: status
module: Lang
updated: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
related:
  - ../../Xot/docs/project-completion-status.md
---

# Lang: cosa manca per completare

Fotografia misurata il 2026-10-28 (sola lettura). Si rigenera con gli stessi controlli: story nel frontmatter,
PHPStan livello 10, blade troncate, traduzioni, test. Riepilogo di progetto: `Modules/Xot/docs/project-completion-status.md`.

## Indicatori

| Indicatore | Valore |
|---|---|
| File PHP in `app/` | 59 |
| Errori PHPStan livello 10 | 0 |
| Blade (troncate in testa) | 10 (0) |
| File di test (`*Test.php`) | 25 |
| TODO/FIXME nel codice | 0 |
| Traduzioni it / en (solo in it) | 32 / 32 (0) |
| Story/epic BMAD (aperte) | 38 (24) |

## Problemi noti e prossimi passi

| Priorita' | Problema | Dove si lavora |
|---|---|---|
| AVVISO | Elenco lingue scritto a mano in 7 punti. | `stories/locales-single-source.story.md` |

Problemi trasversali (valgono per tutto il progetto): vedi `project-completion-status.md` in Xot.

## Story aperte (per stato)

| Stato | Story |
|---|---|
| in_progress | [Lang: PHPStan Level 10 fixes (2026-10-06)](docs/bmad/stories/lang-phpstan-l10.story.md) |
| in-progress | [Lang: contratti PHPStan traduzioni](docs/stories/7.1.phpstan-translation-contracts.story.md) |
| in-progress | [Story 8.10: PHPStan cluster 2 (Lang, Pdnd, UI): timeout + recovery](docs/stories/8.10.phpstan-cluster2-lang-pdnd-ui.story.md) |
| review | [Lang: sei helper di TestCase invocati e mai scritti](docs/stories/17.4.helper-testcase-dichiarati-mai-scritti.story.md) |
| review | [Lang: 781 chiavi duplicate in lang_service.php, tutte nella sezione fields](docs/stories/lang-duplicate-array-keys.story.md) |
| ready-for-dev | [Lang: baseline BMAD e analisi completa](docs/bmad/stories/module-bmad-audit.story.md) |
| ready-for-dev | [Ritiro Lang HTTP Switcher/Change su widget cablato nel tema](docs/stories/12.1.retire-lang-http-switchers.story.md) |
| ready-for-dev | [LANG-7.3: PHPStan: dichiarare i param type mancanti (gate typeCoverage 99 % full-tree)](docs/stories/7.3.phpstan-paramtype-coverage.story.md) |
| ready-for-dev | [Lang: AutoLabelAction hardening and type safety](docs/stories/lang-autolabelaction-hardening.story.md) |
| ready-for-dev | [Lang: fix array_replace_recursive TypeError in FileLoader](docs/stories/lang-translation-loading-fix.story.md) |
| ready-for-dev | [Lang: scritture di traduzione in produzione, sonde PHPStan e residui Livewire](docs/stories/lang-translation-writes-and-probes.story.md) |
| open | [Decidere il destino di docs/graphify e resources/lang tracciati in Lang](docs/stories/lang-docs-graphify-tracked.story.md) |
| backlog | [Continuazione domani](docs/bmad/stories/continuazione-domani.story.md) |
| backlog | [Localizzazione editoriale e URL canonici](docs/stories/inbound-content-localization.story.md) |
| backlog | [Lingue supportate in un solo posto](docs/stories/locales-single-source.story.md) |
| draft | [Lang: epic 5.252: infrastruttura traduzioni e file](docs/bmad/epics/translation-infrastructure.epic.md) |
| draft | [Riorganizzazione docs core Lang](docs/bmad/stories/docs-reorg-core.story.md) |
| analysis-complete-partial-fix | [Story 8.11: PHPStan L10 test fixtures and test files type fixes](docs/stories/8.11-phpstan-l10-test-types-fix.story.md) |
| partial | [Riordino della docs del modulo Lang](docs/stories/docs-organization-lang.story.md) |
| senza-status | [01.larastan isForwardedQueryBuilderMethod bug.story](docs/stories/01.larastan-isForwardedQueryBuilderMethod-bug.story.md) |
| senza-status | [changelog case duplicate and merge conflict.story](docs/stories/changelog-case-duplicate-and-merge-conflict.story.md) |
| senza-status | [Lang Module: Table Audit and $model Property](docs/stories/continuation.story.md) |
| senza-status | [lang docs conflict marker cleanup 2026 09 22.story](docs/stories/lang-docs-conflict-marker-cleanup-story.story.md) |
| senza-status | [lang docs conflict marker cleanup 2026 09 22.story](docs/stories/lang-docs-conflict-marker-cleanup.story.md) |

5 story non hanno `status:` nel frontmatter: vanno classificate (done / backlog / superseded).
