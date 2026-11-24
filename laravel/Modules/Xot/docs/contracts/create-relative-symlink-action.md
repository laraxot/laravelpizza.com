---
title: "CreateRelativeSymlinkAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\File\\CreateRelativeSymlinkAction"
qmd: "CreateRelativeSymlinkAction symlink relativo public_html themes assets percorso relativo realpath readlink"
---

# CreateRelativeSymlinkAction

Crea un symlink con destinazione relativa alla cartella del link, così il progetto resta valido se cambia percorso. Codice: `app/Actions/File/CreateRelativeSymlinkAction.php:23-93`.

Nota: la classe non usa il trait `QueueableAction`.

## Input

- `string $source`: cartella o file di destinazione, che deve esistere (`execute`, riga 28).
- `string $link`: percorso del link da creare (riga 28).

## Output

- `string`: la destinazione relativa scritta nel link (riga 33).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `FILE-SYMLINK-INV-1` | La destinazione scritta è relativa alla cartella del link ed è calcolata da `realpath` di entrambi. Non è mai assoluta. | righe 39-59 | `tests/Unit/Actions/File/CreateRelativeSymlinkActionTest.php:29` |
| `FILE-SYMLINK-INV-2` | Se la cartella del link o la sorgente non esistono: `Assert` lancia `\InvalidArgumentException`. | righe 41-44 | Test: nessuno |
| `FILE-SYMLINK-INV-3` | Il link è creato con `Safe\symlink`: se esiste già o fallisce, lancia eccezione. | righe 30-31 | `tests/Unit/Actions/File/CreateRelativeSymlinkActionTest.php:38` |
| `FILE-SYMLINK-INV-4` | `isRelativeLinkTo()` è `false` se il percorso non è un link, se `readlink` fallisce, se il target è assoluto, o se il target risolto non coincide con la sorgente. | righe 65-80 | `tests/Unit/Actions/File/CreateRelativeSymlinkActionTest.php:34` |

## Effetti collaterali

Creazione di un symlink nel filesystem. Non sovrascrive link esistenti.

## Errori

- `\InvalidArgumentException` (via `Assert`) per cartelle o sorgenti mancanti.
- Eccezioni `Safe\FilesystemException` per fallimento di `symlink` o `readlink`.

## Non fa

- Non crea la cartella del link.
- Non sostituisce un link esistente.
- Marker `@contract` aggiunto nel docblock della classe.
