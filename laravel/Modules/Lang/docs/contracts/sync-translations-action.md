---
title: "Contratto — SyncTranslationsAction"
type: contract
owner: Lang
status: accepted
updated: 2026-11-24
action: "Modules\\Lang\\Actions\\SyncTranslationsAction"
qmd: "SyncTranslationsAction sincronizza traduzioni lingua sorgente lingue target moduli merge file lang LANG-SYNC"
---

# SyncTranslationsAction

Copia nelle lingue target le chiavi mancanti della lingua sorgente, file per file, modulo per modulo. Codice: `app/Actions/SyncTranslationsAction.php:11-273`.

## Input

- `string $sourceLang = 'it'`.
- `array $targetLangs = ['en', 'de']`.
- `?string $specificModule = null`: se dato, sincronizza solo quel modulo.

## Output

- `array`: `total_modules` (tutti i moduli esaminati, anche saltati), `total_files`, `total_translations`, e `modules` con l'esito per modulo (`completed` o `skipped` con motivo).

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `LANG-SYNC-INV-1` | Un valore gia' presente nel target non viene mai sovrascritto. La sorgente riempie solo le chiavi mancanti o `null` (`mergeTranslations`, righe 211-230). | Solo firma: `tests/Unit/Actions/LangActionsCoverageTest.php:19-35`. Comportamento: riferimenti in `LangCoverageGapsTest`, `LangFinalGapsTest`, `LangHundredPercentCoverageTest` (contenuto non letto). |
| `LANG-SYNC-INV-2` | Modulo senza `lang/` o senza cartella della lingua sorgente: `skipped`, nessuna scrittura. | Test: nessuno dedicato. |
| `LANG-SYNC-INV-3` | Ogni file target viene riscritto sempre, anche se il contenuto non cambia. | Test: nessuno. |
| `LANG-SYNC-INV-4` | `translations_added` conta solo le differenze di numero di chiavi di primo livello (riga 119), non le chiavi annidate. | Test: nessuno. |

## Effetti collaterali

- Crea le cartelle della lingua target se mancano (righe 106-108).
- Riscrive ogni file target con `File::put` (riga 244). Nessun backup, nessuna pulizia cache, nessuna transazione. Il valore di ritorno di `File::put` non viene controllato.
- Ordine: moduli in ordine di cartella (`File::directories`), file sorgente in ordine di glob, poi lingue target.

## Errori

- `loadTranslations` ingoia ogni `\Exception` e restituisce `[]` (righe 181-183). Conseguenza: un file target che non si carica viene **sovrascritto** con i soli dati sorgente. Rischio di perdita dati. Un `ParseError` (che estende `\Error`) non viene catturato.

## Non fa

- Non fa backup dei file target.
- `$specificModule` entra nel percorso `base_path("Modules/{$module}/lang")` senza validazione: un valore con `../` uscirebbe da `Modules/`. Chiamanti esterni non verificati; nessun chiamante trovato fuori da test.
- Non traduce: copia la sorgente nelle lingue target come valore provvisorio.
