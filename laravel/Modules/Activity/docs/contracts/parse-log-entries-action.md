---
title: "Contratto — ParseLogEntriesAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\Log\\ParseLogEntriesAction"
qmd: "contract ParseLogEntriesAction activity log parsing voci Monolog formato data livello stack trace ACT-LOGPARSE"
---

# ParseLogEntriesAction

Divide il testo di un log nel formato Monolog di Laravel in voci. Funzione pura.

## Input

- `string $text`: testo grezzo, per esempio la coda letta da `ReadLogTailAction`.

## Output

- `list<LogEntryData>`: per ogni voce `timestamp`, `environment`, `level`, `message`, `body` (corpo con `rtrim`).

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-LOGPARSE-INV-1` | Ogni riga `[data ora] ambiente.LIVELLO:` apre una voce; le righe successive (stack trace, contesto) restano nella stessa voce. | `ParseAndFilterLogEntriesActionTest.php` («splits a Monolog file…») |
| `ACT-LOGPARSE-INV-2` | Le righe iniziali senza intestazione formano una voce grezza con `timestamp`, `environment`, `level` null. | `ParseAndFilterLogEntriesActionTest.php` («keeps unrecognized leading lines…») |
| `ACT-LOGPARSE-INV-3` | Testo vuoto o solo righe vuote iniziali: nessuna voce vuota; righe finali vuote rimosse. | `ParseAndFilterLogEntriesActionTest.php` («returns no entries for empty or blank text…») |
| `ACT-LOGPARSE-INV-4` | `\r\n` e `\r` sono normalizzati a `\n`. | `ParseAndFilterLogEntriesActionTest.php` («understands Windows and old Mac line endings») |
| `ACT-LOGPARSE-INV-5` | Il livello è salvato in maiuscolo. | `ParseAndFilterLogEntriesActionTest.php` («normalizes the level to uppercase») |

## Effetti collaterali

Nessuno.

## Errori

- Nessuno dichiarato. `Safe\preg_match` lancerebbe in caso di errore della regex (non atteso con il pattern fisso).

## Non fa

- Non decodifica il JSON del contesto.
- Non valida la data né distingue gli ambienti.

