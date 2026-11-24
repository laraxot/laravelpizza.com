---
title: "CopyAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\File\\CopyAction"
qmd: "CopyAction copia file non sovrascrive crea cartella destinazione console skip errore Log"
---

# CopyAction

Copia un file nella destinazione senza sovrascriverla, creando la cartella di destinazione se manca. Codice: `app/Actions/File/CopyAction.php:11-47`.

## Input

- `string $from`: file sorgente (`execute`, riga 15).
- `string $to`: file di destinazione (riga 15).

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `FILE-COPY-INV-1` | Se la cartella di `$to` manca, prova a crearla ricorsivamente. Un errore è solo loggato con `Log::error`. | righe 17-27 | Test: nessuno |
| `FILE-COPY-INV-2` | Se `$to` esiste, non fa nulla. Il file non viene sovrascritto. | righe 29-31 | Test: nessuno |
| `FILE-COPY-INV-3` | In console (`runningInConsole()`) ritorna senza copiare. | righe 33-35 | Test: nessuno |
| `FILE-COPY-INV-4` | Altrimenti `File::copy`. Un errore diventa `\Exception` con sorgente, destinazione e messaggio originale. | righe 37-45 | Test: nessuno |

## Effetti collaterali

Creazione di cartelle e copia di file. Nessuna transazione, nessun evento.

## Errori

- `\Exception` in caso di errore di copia. Gli errori di creazione cartella sono solo loggati.

## Non fa

- Non verifica che `$from` esista prima della copia.
- Dubbio: in console la copia è saltata senza messaggi. Il comportamento è sorprendente per chi chiama da un comando artisan (es. `ViewCopyAction`). Da confermare con i chiamanti.
- Marker `@contract` aggiunto nel docblock della classe.
