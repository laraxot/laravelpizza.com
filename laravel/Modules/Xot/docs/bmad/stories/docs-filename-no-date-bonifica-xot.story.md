---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
issues: []
discussions: []
title: "Xot — bonifica .md con data/timestamp nel nome file"
type: story
module: Xot
status: backlog
track: docs-hygiene
qmd: "docs filename no date timestamp bonifica xot git-rewrite artifact"
related:
  - ../../../../../../docs/sprint-status.yaml
---

# Xot — .md senza data/timestamp nel nome (batch trovato 2026-09-22)

## Perche'

Direttiva utente questa sessione: nessun filename `.md` con data o timestamp.
`docs/sprint-status.yaml:257` referenzia una story `"5.29-docs-filename-no-date-bonifica"`
(status `review`) di cui **non esiste il file** in nessun modulo (puntatore
rotto — stesso bug tracciato in `5.25-second-brain-puntatori-rotti`,
in-progress). Quella campagna (2026-09-01) copriva User/Notify/Xot/Lang/
Activity/UI/Media/Job/Ptv/Tenant/Rating/Pdnd/Zero con debito residuo
dichiarato aperto su User (~37 file) — non e' chiaro se il batch sotto sia
gia' incluso in quel conteggio o e' nuovo (creato dopo).

## Scope — file trovati con `[0-9]{4}-[0-9]{2}-[0-9]{2}` o timestamp nel nome

`find Modules/Xot -iname "*.md" | grep -E '[0-9]{4}-[0-9]{2}-[0-9]{2}|[0-9]{8}'`
(esclusi `graphify-out/`, generato/gitignored):

- `docs/xot-git-push-resolution-2026-07-28.md`
- `docs/session-summary-2026-09-16-hasxottable-scheda-pdf.md`
- `docs/testing-progress-session-2025-01-22.md`
- `docs/lfs-resolution-2026-07-28.md`
- `docs/git-conflict-resolution-2026-07-31.md`
- `docs/BRAINSTORM-TestCase-Hierarchy-XotBase-2026-06-10.md`
- `docs/session-2026-09-15-lessons-learned.md`
- `docs/redundancy-audit-2026-05-21.md`
- `docs/phpstan-zero-2026-09-07.md`
- `docs/phpstan-fixes-summary-2025-08-18.md`
- `docs/phpstan-analysis-2025-08-18.md`
- `docs/logging-best-practices-2026-03-02.md`
- `docs/phpstan-fixes-2025-01-06.md`
- `docs/phpstan-analysis-report-2025-11-18.md`
- `docs/stato-qualita-progetto-2026-08-31.md`
- `docs/git-push-resolution-2026-07-28.md`
- `docs/REFACTOR-panelmixin-2026-07-07.md`
- `docs/lessons-learned-2025-08-25.md`
- `docs/ponytail-audit-2026-07-02.md`
- `docs/QA-VERIFICATION-2026-06-30.md`
- `docs/brainstorm-testcase-hierarchy-xotbase-2026-06-10.md`
- `docs/phpstan-progress-report-2025-10-13.md`
- `docs/quality-gates-2026-07-28.md`
- `docs/qa-verification-2026-06-30.md`
- `docs/refactor-panelmixin-2026-07-07.md`
- `docs/git-conflicts-resolution-2025-01-06.md`
- `docs/filament/hasxtable-visibility-fix-2026-01-27.md`
- `docs/historical/hasxtable-visibility-fix-2026-01-27.md` (duplicato del punto sopra — verificare se identico prima di unificare)
- `docs/consolidated/lessons-learned-2025-08-25.md` (duplicato di sopra)
- `docs/consolidated/git-conflicts-resolution-2025-01-06.md` (duplicato di sopra)
- `docs/wiki/redundancy-audit-2026-05-26.md`
- `docs/wiki/troubleshooting/git-merge-conflict-inventory-2026-04-28.md`
- `docs/wiki/quality-analysis/phpstan-2026-05-13.md`
- `docs/raw/notes/composer-root-skeleton-comparison-2026-06-30{,-dup}.md`
- `docs/raw/notes/composer-root-skeleton-fixcity-comparison-2026-06-30{,-dup}.md`
- `docs/wiki/raw/composer-root-skeleton-comparison-2026-06-30{,-dup}.md`
- `docs/wiki/raw/composer-root-skeleton-fixcity-comparison-2026-06-30{,-dup}.md`
- `docs/stories/*-2026-09-*.story.md` e `docs/stories/*-1788*.story.md` (timestamp
  Unix nel nome, non solo date ISO — stessa violazione)
- `docs/bmad/stories/cleanup-xot-2026-09-22.story.md`,
  `cleanup-all-modules-2026-09-22.story.md`,
  `subagent-A-parallel-tasks-2026-09-22.story.md` — **story BMAD stesse**, non
  solo doc storici: anche queste vanno rinominate (contenuto intatto).

## Trovato in aggiunta (fuori scope diretto, segnalare)

`Modules/Xot/.git-rewrite/t/docs/...` — directory intera che rispecchia
`docs/` con path `.git-rewrite/t/`: residuo di un `git filter-repo`/
`git-rewrite` mai ripulito. Non e' un problema di naming, e' un artefatto di
rewrite storico che non dovrebbe essere nel working tree tracciato. Verificare
`git log -- Modules/Xot/.git-rewrite` prima di rimuoverlo (memoria
`feedback-verify-authorship-before-fixing.md`): se tracciato e nessun
riferimento lo usa, e' un candidato a `git rm -r`.

## Acceptance

- [ ] Ogni file sopra: o rinominato senza data (collisione di nome con file
      gia' tracciato -> riconciliazione contenuto, non rename meccanico:
      memoria `feedback-two-runs-same-command-different-numbers.md`/
      pattern gia' noto dalla campagna 5.29), o giustificato come eccezione
      (story-id numerico + slug non e' una data, resta cosi')
- [ ] I 4 `.git-rewrite/t/docs/*` verificati e rimossi o giustificati
- [ ] Nessun link rotto residuo dopo i rename (`grep -rl` sul vecchio nome)
- [ ] `docs/sprint-status.yaml:257` corretto: o il file 5.29 viene ricreato,
      o il puntatore viene rimosso/ricollegato a questa story
- [ ] `qmd update`
