---
id: media-tests-bootstrap-dedupe
title: Dedupe test tree e bootstrap Pest nel modulo Media
type: refactor
priority: high
status: in_progress
module: Media
created: 2026-11-05
updated: 2026-11-05
owner: devin
tags: [tests, pest, phpstan, cleanup]
qmd: "story: media module tests pest.php dedupe duplicate lowercase uppercase test tree"
---

# Story: Dedupe test tree e bootstrap Pest nel modulo Media

## Context

Come in Lang (memoria `module-pest-php-never-loaded`), il `Modules/Media/tests/Pest.php`
non viene caricato dal bootstrap Pest attivo: gli helper globali erano dead code e le
copie lowercase dei test (`feature/`, `filament/`, `unit/`) erano varianti stale che
dipendevano da quegli helper e da vecchie API Filament.

## Lavoro svolto

- Helper ancora usati migrati in metodi statici di `Modules\Media\Tests\TestCase`
  (stesso pattern applicato in Lang).
- Call site aggiornati nei test canonici `Feature/`, `Unit/`, `Filament/`.
- Copie duplicate lowercase rimosse (`git rm`):
  - `tests/feature/MediaBusinessLogicTest.php`
  - `tests/filament/resources/{MediaConvertResourceTest,mediaconvertresourcetest}.php`
  - `tests/unit/actions/{MediaActionsCoverageTest,SaveAttachmentsActionTest}.php`
  - `tests/unit/models/MediaModelTest.php`
  - `tests/Filament/Resources/mediaconvertresourcetest.php`
- `tests/Pest.php` eliminato (ormai senza consumer).

## Debito residuo noto

`MediaBusinessLogicTest` fallisce su `temporary_uploads.id` (`Field 'id' doesn't have
a default value`, connessione `media`): la tabella base è creata da Livewire con PK
stringa uuid, mentre `TemporaryUpload extends BaseModel` assume id intero auto-increment.
Fallimento **preesistente** (i test non giravano comunque per helper mancanti); richiede
allineamento modello/factory o migrazione dedicata — non correlato al dedupe.

## Acceptance Criteria

- [x] Nessun test referenzia helper definiti solo in `tests/Pest.php`
- [x] Test canonici con `uses(TestCase::class)` continuano a girare
- [ ] `phpstan analyse Modules` → 0 errori (verifica globale in corso)
- [ ] Fix `temporary_uploads.id` (story separata se confermato come bug)

## Gate

- `php -l` sui file toccati: OK
- Pest `Modules/Media/tests/Feature` + `Unit/Actions/MediaActionsCoverageTest`:
  parziale — fallimenti `temporary_uploads.id` preesistenti documentati sopra.
