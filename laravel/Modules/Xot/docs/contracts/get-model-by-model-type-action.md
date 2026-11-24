---
title: "GetModelByModelTypeAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\GetModelByModelTypeAction"
qmd: "GetModelByModelTypeAction modello da tipo morph map id find nuovo modello"
---

# GetModelByModelTypeAction

Restituisce un modello dal suo tipo morph e, se dato, dal suo id. Codice: `app/Actions/GetModelByModelTypeAction.php` (classe a riga 18, `execute()` a riga 21).

## Input

- `string $model_type`: tipo morph.
- `?string $model_id`: id opzionale.

## Output

- `Model`: il modello trovato, oppure una nuova istanza se l'id è `null`.

## Invarianti

- `GET-MODEL-BY-TYPE-INV-1` — La classe è ricavata da `GetModelClassByModelTypeAction` e deve essere un sottotipo di `Model`. Test: `tests/Unit/Actions/GetModelActionsTest.php`.
- `GET-MODEL-BY-TYPE-INV-2` — Con id: `find(id)`; senza id: nuova istanza. Test: come sopra.
- `GET-MODEL-BY-TYPE-INV-3` — Id non trovato: `\Exception` con messaggio generico. Test: non verificato.

## Effetti collaterali

Una `SELECT` con id. Nessuna scrittura.

## Errori

- `Assert` per classe mancante o non modello; `\Exception` per id non trovato.

## Non fa

- Non usa `findOrFail`: il messaggio d'errore non nomina il tipo né l'id.
