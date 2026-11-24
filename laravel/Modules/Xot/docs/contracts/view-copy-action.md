---
title: "ViewCopyAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\File\\ViewCopyAction"
qmd: "ViewCopyAction copia vista da nome a nome risolve percorsi blade delega CopyAction"
---

# ViewCopyAction

Copia il file Blade di una vista in un'altra vista, risolvendo entrambi i nomi in percorsi. Codice: `app/Actions/File/ViewCopyAction.php:9-18`.

## Input

- `string $from`: nome della vista sorgente, es. `xot::acts.x` (`execute`, riga 13).
- `string $to`: nome della vista di destinazione (riga 13).

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `FILE-VIEWCOPY-INV-1` | Entrambi i nomi sono risolti con `File\ViewPathAction`, poi la copia è delegata a `CopyAction`. | righe 15-17 | Test: nessuno |

## Effetti collaterali

Quelli di `CopyAction`: creazione della cartella di destinazione, copia del file se la destinazione non esiste, nessuna copia in console.

## Errori

- Quelli di `CopyAction` e `ViewPathAction`.

## Non fa

- Non sovrascrive una vista di destinazione esistente.
- Marker `@contract` aggiunto nel docblock della classe.
