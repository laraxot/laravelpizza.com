---
title: "[DEV] PHPStan cleanup — Activity"
type: dev
module: Activity
story: "./phpstan-cleanup-activity-wave.story.md"
status: done
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, cleanup, bmad, activity]
superseded_by: "./phpstan-cleanup-activity.dev.md"
updated: 2026-11-17
---

# [DEV] PHPStan cleanup — Activity

## Technical Plan

- Costanti: tipi nativi, nessun enum (configurazione e liste di opzioni)
- Per le classi anonime: riusare le fixture esistenti prima di crearne di nuove

## Files to Modify

- `app/Actions/Log/{ReadLogTail,ListLogFiles,FilterLogEntries,ParseLogEntries,BuildLogViewerState}Action.php`, `app/Actions/RedactModelAttributesAction.php`, `app/Filament/Pages/LogViewer.php`
- `tests/Feature/ActivityBusinessLogicTest.php`, `tests/PestStubs.php`
- `tests/Unit/CanPaginateTest.php`, `tests/Unit/Actions/RestoreActivityActionExecuteTest.php`, `tests/Unit/Filament/ListLogActivitiesPureMethodsTest.php`
- `tests/Fixtures/RestoreActivityRecordingModel.php`, `RestoreActivityFailingUpdateModel.php`, `RestoreActivityEmptyModel.php`, `ListLogActivitiesTranslationHarness.php` (nuovi)
- `docs/README.md` (write-back)

## Implementation Steps

- [x] Grep dei consumatori di `LEVELS`/`WINDOW_OPTIONS_KB`/`DEFAULT_*`
- [x] Tipizzate le costanti (regex per `/** @var X */ const` -> `const X`)
- [x] Rimossa l'assegnazione ridondante di `$modifiedAt`
- [x] Asserzioni su `customer_info`; parametri usati negli stub
- [x] Sostituite le classi anonime con fixture con nome (riuso di `CanPaginateHarness::exposeOptions()`)
- [x] PHPStan + `php -l`

## Testing

Test eseguiti: nessuno (Pest non lanciato: DB di test non garantito). I test modificati hanno la stessa semantica: stesse asserzioni, cambia solo il doppio di test (da classe anonima a fixture).

## Verification

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Tenant Modules/Activity Modules/Media Modules/AI Modules/UI Modules/Job Modules/Gdpr Modules/TechPlanner Modules/Seo --memory-limit=-1 --no-progress
php -l <file toccati>

```

Esito: 0 errori sui 9 moduli del gruppo (anche con run completo `./vendor/bin/phpstan analyse` senza argomenti).

## Lessons Learned

- PHPStan non risolve i docblock delle classi anonime in modo stabile: il cache dei name-scope e' indicizzato per file ma il nome della classe anonima contiene un percorso relativo alla radice dell'esecuzione (file singolo, sottoinsieme di moduli, run completo). Esecuzioni con radici diverse lasciano voci inconsistenti e compaiono falsi `missingType.iterableValue`/`missingType.generics` anche con docblock corretti. Fix deterministico: classi **con nome** in `tests/Fixtures/` (convenzione gia' usata nei moduli).
- Sintomo utile per riconoscerlo: l'errore e' attribuito alla riga di un *trait* ('in context of class@anonymous/...') e sparisce con `phpstan clear-result-cache` ma ricompare dopo run con path diversi.
- `@var` inline su valore `mixed` restituito da reflection non e' una soluzione: `Assert::string($result)` verifica davvero il tipo.
- Un test che estrae una variabile e non la usa spesso ha un'asserzione mancante: qui `customer_info`.
- Segnalazioni NON mie nel working tree (pre-esistenti, non toccate): `tests/Feature/Filament/LogViewerPageTest.php` ha perso due asserzioni `toBeInstanceOf(Action::class)`.

> Deprecated alias. Canonico: [./phpstan-cleanup-activity.dev.md](./phpstan-cleanup-activity.dev.md).
