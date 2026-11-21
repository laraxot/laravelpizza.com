---
qmd: "activity stories phpstan cleanup activity story md"
title: "[STORY] PHPStan cleanup — Activity"
type: story
module: Activity
status: done
priority: medium
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, cleanup, bmad, activity]
---

# [STORY] PHPStan cleanup — Activity

## User Request

«sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalità, non sull'errore; aumenta la qualità del codice; usa enum al posto delle costanti».

Perimetro: segnalazioni PHPStan (level max) del modulo Activity. Errori di partenza: 11 `constantTypeCoverage` (visualizzatore log), 1 `assign.redundant`, 1 `variable.unused`, 4 `function.unusedParameter` (PestStubs), ~12 `missingType.*` generati da classi anonime nei test (CanPaginate, Restore, ListLogActivities).

## Analysis

**Scopo del codice.** Il modulo registra e mostra l'activity log (Spatie ActivityLog) e include la pagina **Log Viewer**: elenco e albero di `storage/logs`,
lettura della *coda* del file (finestra da 128 KB a 4 MB), parsing delle voci, filtro per livello/testo (`Actions/Log/*`, `Datas/LogViewerStateData`).
La pagina resta sottile: passa la scelta dell'utente a `BuildLogViewerStateAction`.

- **Costanti** (`DEFAULT_BYTES/MIN_BYTES/MAX_BYTES`, `DEFAULT_LIMIT`, `HEADER_PATTERN`, `SENSITIVE_KEYS`, `DOWNLOAD_PATH`, `LEVELS`, `WINDOW_OPTIONS_KB`, `DEFAULT_WINDOW_KB`):
  limiti, regex, percorso e liste di opzioni => configurazione, restano costanti e diventano `const string|int|array`. I docblock `@var` di un passaggio precedente sono stati sostituiti dai tipi nativi
  (`list<string>`/`list<int>` per `LEVELS`/`WINDOW_OPTIONS_KB`, che alimentano `LogViewerStateData`).
  *Decisione:* `LEVELS` (livelli Monolog) potrebbe essere un enum, ma e' una lista di opzioni di filtro consumata come `list<string>` da `LogViewerStateData` e dai test: lasciata costante; da rivalutare se i livelli ottengono comportamento (colore, severita').
- **`BuildLogViewerStateAction`**: nel `catch` `$modifiedAt = null` era ridondante (`filemtime()` e' l'ultima istruzione del `try` e lancia *prima* di assegnare); rimosso con commento. Tutti gli altri reset (`$entries`, `$total`, `$tail`) sono necessari perche' assegnati prima.
- **`ActivityBusinessLogicTest`**: `$customerInfo` veniva estratto ma non verificato; il test "attivita' con proprieta' complesse" ora asserisce anche `name`/`email` del cliente.
- **`PestStubs.php`**: stub di `actingAs()`/`livewire()` per l'analisi statica; firma invariata (contratto), i parametri ora compaiono nel messaggio dell'eccezione dello stub.
- **Classi anonime nei test** (`CanPaginateTest`, `RestoreActivityActionExecuteTest`, `ListLogActivitiesPureMethodsTest`): i falsi `missingType` nascono dal comportamento di PHPStan con le classi anonime (vedi Lessons).
  Sostituite da fixture con nome in `tests/Fixtures/` (riuso di `CanPaginateHarness`, nuove `RestoreActivity{Recording,FailingUpdate,Empty}Model` e `ListLogActivitiesTranslationHarness`),
  secondo la convenzione gia' presente (`TestBaseModel`: "senza classi anonime, piena conformita' PSR-4").

## Acceptance Criteria

- [x] Costanti del Log Viewer tipizzate nativamente, senza `@var` residui
- [x] Nessuna assegnazione ridondante in `BuildLogViewerStateAction`
- [x] Nessuna variabile inutilizzata nei test; stub con parametri usati
- [x] I test segnalati non usano classi anonime con docblock iterabili/generici
- [x] PHPStan: 0 errori sul modulo Activity (run per path e run completo)

## GitHub (tracciamento)

- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO

Dev story: [2026-10-06-phpstan-cleanup-activity.dev.md](./phpstan-cleanup-activity.dev.md)
