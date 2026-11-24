---
title: "Contratto — WriteTranslationFileAction"
type: contract
owner: Lang
status: accepted
updated: 2026-11-24
action: "Modules\\Lang\\Actions\\WriteTranslationFileAction"
qmd: "WriteTranslationFileAction scrive file traduzione backup storage php -l validazione sintassi cache LANG-WRITE"
---

# WriteTranslationFileAction

Scrive un file di traduzione con backup e validazione sintattica preventiva. Codice: `app/Actions/WriteTranslationFileAction.php:17-199`.

## Input

- `string $filePath`: file di destinazione.
- `array $translations`: contenuto, con chiavi stringa.

## Output

- `bool`: sempre `true`. Ogni fallimento lancia.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `LANG-WRITE-INV-1` | Se il file esiste, ne crea una copia in `storage/app/backups/translations/<Y-m-d_H-i-s>_<nome>` **prima** di validare (righe 30-31, 120-136). Due scritture nello stesso secondo producono lo stesso nome di backup. | Riferimenti in `tests/Unit/LangHundredPercentCoverageTest.php` e `LangCoverageBoostTest.php` (contenuto non letto). |
| `LANG-WRITE-INV-2` | Il contenuto PHP passa `php -l` su un file temporaneo prima di toccare la destinazione; errore: `\Exception` «Sintassi PHP non valida». | Riferimenti in `LangFinalGapsTest.php`, `LangCoverageBoostTest.php`. |
| `LANG-WRITE-INV-3` | La cartella di destinazione viene creata se manca; se la scrittura fallisce, `\Exception` «Impossibile scrivere il file». | `tests/Fixtures/WriteTranslationFileActionWriteFailStub.php` (usata da `LangFinalGapsTest`). |

## Effetti collaterali

1. Backup (puo' creare la cartella backup).
2. Scrittura temporanea in `storage/framework/cache` e `exec("php -l ...")`, poi cancellazione del temporaneo.
3. `File::ensureDirectoryExists` e `File::put`.
4. `clearTranslationCache()`: chiama `flush()` su `app('cache')` e `translation.loader` solo se `method_exists` lo dichiara. `CacheManager` non dichiara `flush` (solo `__call`): il primo ramo e' probabilmente inerte. Da verificare a runtime.

## Errori

- `\Exception` per sintassi non valida, temporaneo non scrivibile, destinazione non scrivibile.
- Le funzioni `Safe\*` lanciano su errore I/O; in quel caso il file temporaneo non viene cancellato.

## Non fa

- Non ripristina il backup se la scrittura fallisce.
- Non cancella i backup vecchi: crescono senza limite.
- `php` viene risolto dal `PATH`, non da `PHP_BINARY`.
- Chiamanti non trovati fuori da Actions e test.
