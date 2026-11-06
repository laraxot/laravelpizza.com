---
title: "UI: cosa manca per completare"
type: status
module: UI
updated: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
related:
  - ../../Xot/docs/project-completion-status.md
---

# UI: cosa manca per completare

Fotografia misurata il 2026-10-28 (sola lettura). Si rigenera con gli stessi controlli: story nel frontmatter,
PHPStan livello 10, blade troncate, traduzioni, test. Riepilogo di progetto: `Modules/Xot/docs/project-completion-status.md`.

## Indicatori

| Indicatore | Valore |
|---|---|
| File PHP in `app/` | 120 |
| Errori PHPStan livello 10 | 0 |
| Blade (troncate in testa) | 295 (0) |
| File di test (`*Test.php`) | 49 |
| TODO/FIXME nel codice | 2 |
| Traduzioni it / en (solo in it) | 91 / 39 (52) |
| Story/epic BMAD (aperte) | 22 (13) |

## Problemi noti e prossimi passi

Nessun problema bloccante emerso dai controlli del 2026-10-28 oltre agli indicatori sopra e alle story aperte.

Problemi trasversali (valgono per tutto il progetto): vedi `project-completion-status.md` in Xot.

## Story aperte (per stato)

| Stato | Story |
|---|---|
| in_progress | [Fix PHPStan Level 10 Errors in UI Module](docs/bmad/stories/1.4-phpstan-ui-fixes.story.md) |
| in_progress | [Fix UiGroupColumnTypeEnum fixture for UI tests (add getLabel() method)](docs/bmad/stories/group-column-type-enum-getlabel-fix.story.md) |
| in-progress | [UI: resolve git conflict markers in the gap closer test](docs/stories/resolve-conflict-markers-ui.story.md) |
| review | [App header: crash per ospiti e UX di accesso](docs/bmad/stories/app-header-guest-ux.story.md) |
| review | [UI: README/contributing marker + md uppercase in root](docs/bmad/stories/root-hygiene-conflict-markers.story.md) |
| ready-for-dev | [UI: baseline BMAD e analisi completa](docs/bmad/stories/module-bmad-audit.story.md) |
| ready-for-dev | [UI: contratto Filament, ritiro del Toast Livewire e copie risorte](docs/stories/ui-filament-contract-and-livewire-retire.story.md) |
| ready-for-dev | [UI Module BMAD Setup](docs/stories/ui-module-bmad-setup.story.md) |
| todo | [Cookiebar visual audit and accessibility compliance](docs/stories/cookiebar-visual-audit.story.md) |
| backlog | [Continuazione domani](docs/bmad/stories/continuazione-domani.story.md) |
| backlog | [Componenti riusabili per card contenuti](docs/stories/inbound-content-cards.story.md) |
| active | [Story: componenti riutilizzabili schema.org](docs/bmad/stories/schema-org-reusable-components.story.md) |
| partial | [Riordino della docs del modulo UI](docs/stories/docs-organization-ui.story.md) |
