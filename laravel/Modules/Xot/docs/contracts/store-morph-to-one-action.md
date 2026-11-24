---
title: "MorphToOneAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Store\\MorphToOneAction"
qmd: "Store MorphToOneAction morphToOne lang locale create delega CreateMorphToOneRelatedModelAction"
---

# MorphToOneAction

Crea il modello correlato di una `morphToOne`, delegando a `CreateMorphToOneRelatedModelAction`. Codice: `app/Actions/Model/Store/MorphToOneAction.php` (classe a riga 17, `execute()` a riga 17).

## Input

- `Model $_model`: non usato.
- `RelationDTO $relationDTO`: `rows` è la relazione, `data` gli attributi.

## Output

- `void`.

## Invarianti

- `STORE-MORPH-TO-ONE-INV-1` — Se `data` non ha `lang`, lo imposta alla locale corrente. Il valore è scritto anche sull'oggetto DTO. Test: nessuno.
- `STORE-MORPH-TO-ONE-INV-2` — Il correlato è sempre creato con `create()` tramite `CreateMorphToOneRelatedModelAction`. Test: nessuno.

## Effetti collaterali

Un `INSERT` del correlato. Nessuna transazione.

## Errori

- Eccezioni di `CreateMorphToOneRelatedModelAction` e del database.

## Non fa

- Non aggiorna un correlato esistente: a ogni salvataggio ne crea uno nuovo.
