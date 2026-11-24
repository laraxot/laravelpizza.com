---
title: "Contratto — ReadLogTailAction"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\Log\\ReadLogTailAction"
qmd: "contract ReadLogTailAction activity log lettura coda file byte limite 4 MiB UTF-8 riga parziale ACT-LOGTAIL"
---

# ReadLogTailAction

Legge solo gli ultimi N byte di un file di log, senza caricarlo intero in memoria.

## Input

- `string $absolutePath`: percorso assoluto già risolto da `ResolveLogFilePathAction`.
- `int $maxBytes = 262144` (256 KiB): richiesta; il valore effettivo è limitato tra 1024 byte e 4 MiB.

## Output

- `LogTailData`: `content` (UTF-8 valido), `size` (dimensione del file), `bytesRead`, `truncated` (true se la coda è solo una parte del file).

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-LOGTAIL-INV-1` | Non si legge mai più di `min(max(maxBytes, 1024), 4 MiB)` byte, anche se richiesto di più. | `ReadLogTailActionTest.php` («never reads more than the hard limit…») |
| `ACT-LOGTAIL-INV-2` | Se il file è più grande della finestra si legge la coda; se il blocco contiene un a capo, la prima riga parziale è scartata. | `ReadLogTailActionTest.php` («reads only the tail of a large file…») |
| `ACT-LOGTAIL-INV-3` | File vuoto: `content=''`, `size=0`, `truncated=false`, nessuna lettura. | `ReadLogTailActionTest.php` («returns an empty result for an empty file») |
| `ACT-LOGTAIL-INV-4` | I byte non UTF-8 sono ripuliti con `mb_scrub`. | `ReadLogTailActionTest.php` («cleans invalid UTF-8 bytes…») |
| `ACT-LOGTAIL-INV-5` | File inesistente o non leggibile: `RuntimeException` con messaggio generico, prima di qualsiasi lettura. | `ReadLogTailActionTest.php` («throws a clear error when the file cannot be read») |

## Effetti collaterali

- Lettura del file (`filesize`, `fopen` in `rb`, `fseek`, `stream_get_contents`); handle chiuso in `finally`.
- Nessuna scrittura.

## Errori

- `RuntimeException` per file mancante, non leggibile o non posizionabile. Il messaggio non contiene il percorso.

## Non fa

- Non cerca nel file intero: ricerca e filtri valgono solo sulla finestra letta.
- Se il blocco letto non contiene alcun a capo, la prima riga resta parziale (il codice tiene il blocco così com'è).
- `bytesRead` è la lunghezza del contenuto dopo il taglio della prima riga, non dei byte letti dal disco.

