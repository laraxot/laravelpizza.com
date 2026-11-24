---
title: "ViewCopyAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Filament\\Actions\\ViewCopyAction"
qmd: "ViewCopyAction copia vista Filament TODO no-op conferma asset placeholder"
---

# ViewCopyAction

Azione Filament per copiare una vista. Il metodo `execute` è un segnaposto vuoto.

Codice: `app/Actions/Filament/Actions/ViewCopyAction.php:13-50`.

## Input

- `array $arguments`, `array $data`: filtrati alle chiavi stringa; non usati.

## Output

`void`.

## Invarianti

- `FIL-VIEWCOPY-INV-1`: `execute` non fa nulla: il corpo contiene solo un TODO (righe 45-49). Il bottone chiede conferma e chiude il modale senza effetto e senza errore. Test: Nessun test dedicato.

## Effetti collaterali

Nessuno.

## Errori

Nessuna: il fallimento è silenzioso.

## Non fa

- Non copia la vista né gli asset. Da implementare o da rimuovere dal bottone.
