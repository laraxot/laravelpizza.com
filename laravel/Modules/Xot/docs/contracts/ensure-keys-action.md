---
title: "EnsureKeysAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Arr\\EnsureKeysAction"
qmd: "EnsureKeysAction allinea righe schema chiavi mancanti null JSON coerente modello riga incompleta"
---

# EnsureKeysAction

Allinea ogni riga di un dataset alle chiavi attese dallo schema: le chiavi mancanti diventano `null`, quelle presenti sono conservate. Codice: `app/Actions/Arr/EnsureKeysAction.php:14-40`.

## Input

- `array<int|string, array<string, mixed>|mixed> $data`: righe da allineare (`execute`, riga 23).
- `array<int|string, string|int> $keys`: chiavi attese dallo schema (riga 23).

## Output

- `array<int|string, array<string, mixed>>`: righe array allineate, con le chiavi originali di `$data` (righe 29-38).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `ARR-ENSURE-INV-1` | Ogni riga restituita contiene tutte le chiavi di `$keys` (convertite con `strval`); le mancanti valgono `null`. | righe 27, 33 | Test: nessuno |
| `ARR-ENSURE-INV-2` | I valori già presenti nella riga vincono sul template (`array_replace`). | riga 33 | Test: nessuno |
| `ARR-ENSURE-INV-3` | Le chiavi della riga non presenti nello schema sono conservate. | riga 33 | Test: nessuno |
| `ARR-ENSURE-INV-4` | Le righe che non sono array sono scartate senza errore. | righe 30-36 | Test: nessuno |

## Effetti collaterali

Nessuno. Calcolo in memoria.

## Errori

- Nessuna eccezione. Gli elementi non validi vengono scartati silenziosamente.

## Non fa

- Non valida i tipi dei valori.
- Non rimuove le chiavi extra: lo schema non è una whitelist.
- Marker `@contract` aggiunto nel docblock della classe.
