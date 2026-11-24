---
type: note
tags: [documentation]
issues: []
discussions: []
id: "xot-cleanup-all-modules"
epic: 5
title: "Fleet: git status + marker HEAD + quality per ogni modulo"
slug: cleanup-all-modules
status: review
scope: fleet
created: 2026-09-22
updated: 2026-09-22
qmd: "fleet git status committed conflict markers notify netfun ui media rating application tests phpstan"
related:
  - ./cleanup-all-modules-2026-09-22.story.md
  - ./uppercase-root-dirs-cleanup.story.md
  - ./graphify-out-gitignore-all-modules.story.md
  - ../../../../Job/docs/bmad/stories/12.3.root-hygiene-conflict-markers.story.md
  - ../../../../../../docs/wiki/memories/job-git-clean-can-hide-committed-conflict-markers.md
---

# Fleet: `git status` + marker in HEAD + quality tools

**Perché.** `git status` pulito sul nested repo del modulo **non** prova che HEAD sia sano: i marker `<<<<<<<` possono essere già committati. La campagna sistema i conflitti **reali** (PHP/lang/README/root uppercase), non i file in `docs/` che *documentano* i marker.

Canon: questa story (kebab, **senza data nel filename**). Il file datato `cleanup-all-modules-2026-09-22.story.md` è solo puntatore.

## Claim

- Agent: cursor-80f4250a
- Task: fleet-cleanup-markers
- Non toccati (WIP altri agenti): IndennitaResponsabilita (51 staged), Rating test `HasRatingsTraitRatingsByIdTest`, Xot `CollectionExport`/`ExportXlsByCollection`, Activity docs (90 dirty), Lang/Media `.gitignore` (`graphify-out/` — story graphify-out-gitignore)

## Git status (ordine random 2026-09-22)

| Modulo | branch | dirty | Marker reali (non-docs, line-start `<<<<<<<`) | Esito |
|--------|--------|-------|-----------------------------------------------|-------|
| Progressioni | dev | 0 | 0 | ok |
| IndennitaCondizioniLavoro | dev | 0 | 0 | ok |
| Sigma | dev | 0 | 0 | ok |
| Pdnd | dev | 0 | 0 | ok |
| Job | dev | 20 | 0 (già 12.3, WT non committato) | ok campagna precedente |
| Lang | dev | 1 | 0 | `.gitignore` graphify-out (altra story) |
| Xot | dev | 1+ | 0 PHP | `Tests/` duplicato + `tests/pest.php` case-collision rimossi |
| UI | dev | 0→dirty | README + contributing + ARCHITECTURE/TESTING/PHILOSOPHY root | marker stripped; uppercase root md rimossi |
| Tenant | dev | 11 | 0 | docs WIP altra sessione, non toccato |
| Media | dev | 1 | README + CHANGELOG | marker stripped; `.gitignore` altra story |
| User | dev | 9 | contributing già 0; `Application/` root duplicato | `git rm Application/`; test migrations = falso positivo (`<<<<<<<` in assert) |
| Notify | dev | 0→dirty | **PHP + 4 lang + test** | risolti (lato Safe json + redact token) |
| Performance | dev | 0 | 0 | ok |
| Ptv | dev | 0 | 0 | PHPStan residuo test Firma (non this claim) |
| Activity | dev | 90 | 0 non-docs | docs follow-up esistente |
| IndennitaResponsabilita | dev | 51 | 0 | WIP ratings_by_id, non toccato |
| Incentivi | dev | 0 | 0 | ok |
| Rating | dev | 3 | README | marker stripped; test staged altra sessione |

## Acceptance Criteria

1. [x] `git status` su tutti i 18 nested repo.
2. [x] Zero marker line-start in PHP/lang/README/contributing/CHANGELOG **non-docs** (verificato post-fix).
3. [x] Notify `SendNetfunSMSAction`: niente marker; log solo su failure; token redacted; `isSuccessfulResponse` (HTTP 200 ≠ ok).
4. [x] UI root senza `ARCHITECTURE.md`/`TESTING.md`/`PHILOSOPHY.md` (SSoT `docs/architecture.md`).
5. [x] User root senza `Application/` (PSR-4 è `app/`); Xot senza `Tests/` (duplicato identico di `tests/`) e senza `tests/pest.php` (collision con `Pest.php`).
6. [x] PHPStan max: Notify+User+UI+Media = 0. Rating/IR/Xot/Ptv errori = WIP altri claim, non questo.
7. [ ] Commit: **non richiesto** dall'utente — deferred.
8. [x] Pest skip: `DB_HOST=10.100.200.53` unreachable / host non di test.

## Quality

- Pint `--dirty`: passed.
- PHPMD su `SendNetfunSMSAction`: falso positivo UnusedPrivateField (`$token`/`$endpoint`/`$vars` usati in `execute()`); cache `~/.pdepend` permission denied.
- PHPInsights: non lanciato (fleet md/PHP marker; non bloccante).
- PHPStan `Modules/Notify Modules/User Modules/UI Modules/Media`: `[OK] No errors`.

## Fuori scope

- Marker **dentro** `docs/` (citazioni / campagne 5.159 già chiuse o WIP Activity).
- `Xot/.git-rewrite/` (artefatto git).
- Cluster Livewire Job Status/Crud (12.2).
