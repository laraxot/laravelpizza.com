---
type: note
created: 2026-09-26
updated: 2026-09-26
qmd: "media services to actions.story"
issues: []
discussions: []
id: story-media-services-to-actions
slug: media-services-to-actions
title: "Conversione app/Services in QueueableAction nel modulo Media"
description: "Retiro delle classi sotto app/Services/: la migrazione a QueueableAction era gia' stata eseguita da una sessione precedente, restava solo un residuo duplicato non convertito e i test che referenziavano ancora le classi Service."
document_type: story
category: bmad
scope: module:Media
status: done
priority: medium
created_at: '2026-09-04'
updated_at: '2026-09-04'
tags: [bmad, story, queueable-action, no-services-rule, media]
related:
  - ../../../../bashscripts/ai/wiki/rules/no-services-rule.md
  - ../../../Tenant/docs/concepts/tenant-service-to-actions-migration.md
---

# Conversione app/Services in QueueableAction nel modulo Media

## Contesto

Regola di progetto (RELIGION, no eccezioni): nessuna classe `app/Services/*Service`
per business logic, tutto sotto `app/Actions/` come `Spatie\QueueableAction\QueueableAction`
con un solo entrypoint `execute(...)`. Vedi
`bashscripts/ai/wiki/rules/no-services-rule.md`.

`Modules/Media/app/Services/` conteneva 2 file (piu' 2 `.bak` orfani, mai in
uso, cancellati insieme agli originali):

- `SubtitleService.php`
- `VideoStream.php`

## Scoperta iniziale — il lavoro pesante era gia' fatto

Prima di editare, `git status --short` + lettura del codice hanno mostrato che
**un'altra sessione concorrente aveva gia' completato la conversione Kind A**
per entrambi i file, con commit gia' presenti in `git log` (`d0d8a784 fix(phpstan):
analyse Modules a zero errori`, `0593e8c4 Reduce mixed type usage in Media module`,
`0407edcb .`):

- `VideoStream::__construct()` + `start()` → `Modules\Media\Actions\Stream\StreamVideoAction`
  (`execute(string $disk, string $path, ?Media $media = null): void`, `use QueueableAction`).
  Aggiunge anche un controllo di autorizzazione (`Auth::check()` + owner/`super-admin`)
  assente nell'originale — non toccato, fuori scope di questa story.
- `SubtitleService::getFromXml()`/`get()` → `Modules\Media\Actions\Subtitle\ParseSubtitleXmlAction::execute(string $filePath): array`
- `SubtitleService::getPlain()` → `Modules\Media\Actions\Subtitle\ExtractSubtitlePlainTextAction::execute(string $filePath): string`
- `SubtitleService::upateModel()` → `Modules\Media\Actions\Subtitle\UpdateModelSubtitleFieldAction::execute(Model $model, string $filePath, string $fieldName = 'txt'): Model`
  (compone `ExtractSubtitlePlainTextAction` via `app(...)->execute()`, come da regola)

Nessun call site di produzione usava piu' `Modules\Media\Services\SubtitleService`
o `Modules\Media\Services\VideoStream` — confermato con grep sull'intero albero
`Modules/` (nessun'altra modulo referenzia queste classi). Gli unici referenziatori
rimasti erano 3 blocchi di test dentro lo stesso modulo Media.

## Classificazione per file

| File originale | Kind | Metodo → Action | Stato trovato | Azione presa |
|---|---|---|---|---|
| `app/Services/VideoStream.php` | A (god-facade a 2 responsabilita': init + streaming) | `__construct`+`start()` → `Modules\Media\Actions\Stream\StreamVideoAction::execute()` | Gia' migrato da altra sessione, Service ancora presente e referenziato solo dai test | Cancellata la classe Service; aggiornati i 2 test che la istanziavano direttamente |
| `app/Services/SubtitleService.php` | A (god-facade, 6 metodi pubblici indipendenti) | `getFromXml`/`get` → `ParseSubtitleXmlAction`; `getPlain` → `ExtractSubtitlePlainTextAction`; `upateModel` → `UpdateModelSubtitleFieldAction`; `setFilePath`/`setModel`/`getModel`/`srtToVtt`/`getInstance`/`make` → non migrati (statici singleton/setter, non usati da nessun caller di produzione) | Gia' migrato da altra sessione | Cancellata la classe Service |
| `app/Actions/Stream/SubtitleService.php` | Scarto — duplicato residuo, non un Kind A/B valido | n/a | Copia letterale e non convertita di `app/Services/SubtitleService.php`, lasciata sotto `app/Actions/Stream/` senza `QueueableAction` ne' `execute()` (probabile file intermedio dimenticato dalla sessione che ha fatto la migrazione) | Cancellata: per la regola stessa ("una classe senza un vero execute() non vive in Actions/"), un duplicato statico del vecchio Service non ha nessun titolo per stare in `Actions/` |
| `app/Services/SubtitleService.php.bak`, `app/Services/VideoStream.php.bak` | Scarto — backup orfani | n/a | Copie `.bak` tracciate in git, mai referenziate da nessun autoload/require | Cancellate insieme agli originali |

Nessun file era Kind B (nessuno strategy/handler/adapter registrato in questo
gruppo).

## Cosa e' stato fatto in questa sessione

1. `git rm` di `app/Services/SubtitleService.php`, `app/Services/VideoStream.php`,
   `app/Actions/Stream/SubtitleService.php` e dei 2 `.bak`; rimossa la directory
   `app/Services/` (ora inesistente nel modulo).
2. Aggiornati i call site nei test (unici referenziatori rimasti, nessun altro
   modulo coinvolto):
   - `tests/Unit/MediaHighestMissCoverageTest.php`:
     - rimossi `use Modules\Media\Services\SubtitleService;` e
       `use Modules\Media\Services\VideoStream;`;
     - test `'SubtitleService parses xml and formats timestamps'` sostituito con
       `'ExtractSubtitlePlainTextAction concatenates every subtitle item'`
       (nuova copertura reale: prima non esisteva nessun test dedicato per
       `ExtractSubtitlePlainTextAction`);
     - test `'VideoStream rejects missing files and accepts faked disk files'`
       rimosso: il ramo "file mancante" era gia' duplicato in
       `MediaCoverage100RemainingTest.php` via `StreamVideoAction`; il ramo
       "successo" non e' riproducibile su `StreamVideoAction::execute()` senza
       isolare il processo (chiama `exit()` a fine streaming, a differenza del
       vecchio `VideoStream` che separava costruzione da `start()`) — nessuna
       perdita di garanzie comportamentali verificabili in test;
     - test `'stream SubtitleService parses xml like the domain service'`
       (che usava il duplicato residuo `Modules\Media\Actions\Stream\SubtitleService`)
       sostituito con `'UpdateModelSubtitleFieldAction extracts the plain text
       and stores it on the model field'` — nuova copertura reale per
       `UpdateModelSubtitleFieldAction`, prima non testata.
   - `tests/Unit/MediaCoverage100RemainingTest.php`: rimosso
     `use Modules\Media\Services\VideoStream;` e il ramo del test che
     istanziava `new VideoStream(...)`, mantenuto il ramo equivalente su
     `StreamVideoAction::execute()` (test rinominato
     `'StreamVideoAction rifiuta un path inesistente sul disco'`).
3. `secondsToHms()` — privato sia nel vecchio `SubtitleService` sia nel nuovo
   `ParseSubtitleXmlAction` — resta coperto indirettamente dal test
   `'timecodes carry hours, minutes and milliseconds'` gia' presente in
   `tests/Unit/Actions/Subtitle/ParseSubtitleXmlActionTest.php`: nessuna
   perdita di copertura nel passaggio dal test via Reflection rimosso.

## Verifica

- **PHPStan**: baseline vera (`clear-result-cache` + `analyse Modules/Media
  --no-progress --error-format=table`) → `[OK] No errors` prima e dopo.
- **PHPMD**: scoped sui 2 file di test toccati
  (`./tools/phpmd.sh Modules/Media/tests/Unit/MediaHighestMissCoverageTest.php text ../docs/phpmd.ruleset.xml`
  e l'analogo per `MediaCoverage100RemainingTest.php`) → nessun warning.
  Non rilanciato sull'intero modulo: crash noto e pre-esistente
  (`No node to visit provided for visitAnonymousClass`), vedi memoria
  `quality-tooling-real-commands`.
- **Pest**: `./vendor/bin/pest Modules/Media/tests -c Modules/Media/phpunit.xml
  --no-coverage` → 288 passed, 6 failed, 1 risky, 4 skipped. I 6 fallimenti
  sono su `Modules/Media/tests/Unit/Models/MediaModelTest.php`,
  `MediaTest.php` e `MediaFilamentAndActionsTest.php` — tutti relativi a cast
  del model `Media` (`id`/`uuid`/`user_id`) e a conteggi su query DB
  (`toHaveCount`), nessuno tocca `SubtitleService`, `VideoStream`,
  `StreamVideoAction` o le Actions `Subtitle/*`; nessuno di questi file e'
  stato toccato in questa story. Rilancio mirato dei soli file toccati
  (`MediaHighestMissCoverageTest.php`, `MediaCoverage100RemainingTest.php`,
  `Actions/Subtitle/ParseSubtitleXmlActionTest.php`,
  `MediaGapAttackCoverageTest.php`) → 24 passed, 0 failed.

## File toccati in questa sessione

- `app/Services/SubtitleService.php` — cancellato
- `app/Services/SubtitleService.php.bak` — cancellato
- `app/Services/VideoStream.php` — cancellato
- `app/Services/VideoStream.php.bak` — cancellato
- `app/Actions/Stream/SubtitleService.php` — cancellato (duplicato residuo)
- `tests/Unit/MediaHighestMissCoverageTest.php` — aggiornato
- `tests/Unit/MediaCoverage100RemainingTest.php` — aggiornato

Nessun altro modulo referenziava le classi Service di Media: nessun commit
cross-modulo necessario.
