---
type: story
id: media-phpstan-swarm-verifica-fonti
slug: media-phpstan-swarm-verifica-fonti
title: "Media PHPStan swarm: ground truth stale, sorgenti gia' sane, nessun edit"
description: "Verifica scope-prima-errore sui file Media del brief swarm: il FATAL Media.php:458 e gli internal error non sono riproducibili, il codice usa gia' Safe/generics. Nessuna modifica al codice."
document_type: story
category: bmad
scope: module:Media
status: ready-for-dev
priority: high
created: 2026-10-15
updated: 2026-10-15
tags: [bmad, story, phpstan, quality-gate, media, swarm, second-brain]
related:
  - ./01.Media-phpstan-fix.story.md
  - ./media-quality-gate.story.md
  - ./media-mixed-type-reduction.story.md
---

# Media PHPStan swarm: verifica fonti, nessun edit necessario

## Fase BMAD: Analysis (Quick Flow, fix/probe)

## Richiesta

Brief swarm PHPStan, scope `laravel/Modules/Media/`: FATAL `Media.php:458`
Unterminated comment + internal error ambiente su `UploadFileAction`
(`is_readable`), `SaveAttachmentsAction` (`basename`), `MediaFactory`
(`random_int`), `TemporaryUpload` (`is_a`), `FileExtensionRule`
(`mb_strtolower`), `SubtitleService` (`SimpleXMLElement`); cercare altri
errori Media; story BMAD; no QMD; vincoli neon/baseline/ignore e git
intoccabili, forward-only.

## Scopo ricostruito per file (prima dell'errore)

| File | Scopo | Stato rilevato 2026-10-15 |
|---|---|---|
| `app/Models/Media.php` | Modello Spatie esteso: query per sessione, relazioni creator/temporaryUpload/mediaConverts, helper URL conversioni | Sano: ~240 righe, chiude con `}`. Riga 458 non esiste. Nessun commento unterminated, docblock property/method integri |
| `app/Actions/S3/UploadFileAction.php` | Upload file locale su S3 via ObjectUploader con logging | Sano: `Safe\fopen/fclose/filesize/mime_content_type`; `file_exists`/`is_readable` nativi (Safe non li wrappa, corretto non wrappare) |
| `app/Actions/SaveAttachmentsAction.php` | Salva allegati in media library via file temporaneo | Sano: `Safe\file_put_contents/tempnam/unlink`; `basename`/`file_exists` nativi (corretto) |
| `database/factories/MediaFactory.php` | Factory stati default/image/document + mime map | Sano: `@extends Factory<Media>`, `random_int` nativo (lancia ValueError nativo, nessun wrapper Safe richiesto) |
| `app/Models/TemporaryUpload.php` | Upload temporanei con session affinity, conversioni preview, move | Sano: nessun `is_a`; `\is_string` nativo in `getDiskName` (corretto) |
| `app/Rules/FileExtensionRule.php` | ValidationRule estensioni ammesse | Sano: `mb_strtolower` nativo (Safe non lo wrappa); closure tipizzata `lowercase-string` |
| `SubtitleService` | Non esiste nel modulo | Superato da `Actions/Subtitle/ParseSubtitleXmlAction.php` + `ExtractSubtitlePlainTextAction.php`, entrambi con `Safe\simplexml_load_string/realpath` e throw tipizzate |
| `app/Models/MediaConvert.php`, `BaseModel.php`, factories restanti, `AttachMediaAction`, `GenerateTemporaryUploadPathAction`, `GetAttachmentsSchemaAction`, subtitle actions restanti | Supporto conversioni/casts, path temporanei, schema allegati | Letti interi: sintassi sana, generics presenti (`BelongsTo<Media, $this>`, `list<string>`, `array<string, mixed>`) |

## Causa radice: ground truth stale, non codice rotto

1. `phpstan_modules_initial.json` e `phpstan_output.txt` **non esistono** nel
   repo (verificato listing root, `.tmp/`, `bmad-output/`). Il brief descrive
   uno stato superato: swarm/story precedenti (v. `01.Media-phpstan-fix`,
   `media-quality-gate`, `media-mixed-type-reduction`) hanno gia' portato
   Media a zero errori con esattamente le tipizzazioni richieste
   (`Safe\`, string, generics).
2. Gli "internal error ambiente" citati sono per natura **ambiente**
   (symbol discovery Larastan), non correggibili nel codice senza workaround
   vietati: correttamente **segnalati, non aggirati**.
3. Report esistenti a root confermano: `media_report.json` (internal error su
   `tests/Unit/Models/MediaTest.php`) e `media_report_2.json`
   (`function.notFound` Pest nella stessa fixture) riguardano solo `tests/`,
   che `phpstan.neon` **esclude dal gate** (`excludePaths:
   laravel/Modules/*/tests`). Fuori gate, nessuna azione.

## Modifiche

Nessuna. `phpstan.neon`, baseline, ignore, git: intoccati. Principio
ponytail: il diff piu' corto che risolve un problema gia' risolto e' nessun
diff.

## Verifica

- Lettura integrale dei file in tabella (scope-prima-errore); nessun marker
  `<<<<<<<`, nessun commento unterminated, docblock preservati.
- Gate canonico (`./vendor/bin/phpstan analyse Modules/Media`, `php -l`,
  Pest mirato) **non eseguibile in questa sessione**: tool bash legato a
  sandbox Daytona senza `DAYTONA_API_KEY`, quindi niente esecuzione. La
  verifica resta statica e va ripetuta dal coordinatore con env funzionante.
- Lock/unlock file: non applicabili (nessun edit, nessun comando eseguibile);
  nessun conflitto di ownership.
- QMD/second-brain update: omesso su istruzione del brief ("No QMD"); spetta
  al coordinatore a swarm fermo.

## Decisioni

- D1: nessun edit su codice sano: rifare tipizzazioni esistenti sarebbe churn.
- D2: internal error ambiente si segnalano, mai si workaroundano (coerente con
  divieto baseline/ignore).
- D3: report `media_report*.json` su `tests/` esclusi dal gate: nessuna azione.

## Aperto

- TODO(coordinatore): run canonico `cd laravel && ./vendor/bin/phpstan analyse
  Modules` con exit code + conteggi json a swarm fermo; questa verifica Media
  e' statica in attesa di env con shell.
- Claim: perimetro `laravel/Modules/Media/` verificato senza modifiche; file
  condivisi/base (Xot, vendor) non toccati.