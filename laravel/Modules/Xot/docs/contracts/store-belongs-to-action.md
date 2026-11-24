---
title: "BelongsToAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Store\\BelongsToAction"
qmd: "Store BelongsToAction relazione belongsTo create associate creazione correlato"
---

# BelongsToAction

Crea il modello correlato di una `belongsTo` e lo associa al padre in memoria. Codice: `app/Actions/Model/Store/BelongsToAction.php` (classe a riga 17, `execute()` a riga 17).

## Input

- `Model $_model`: non usato.
- `RelationDTO $relationDTO`: `rows` deve essere `BelongsTo`; `data` sono gli attributi del correlato.

## Output

- `void`.

## Invarianti

- `STORE-BELONGS-TO-INV-1` — Il correlato è creato con `rows->create(data)` e associato con `associate()`. Test: nessuno.
- `STORE-BELONGS-TO-INV-2` — Il padre non viene salvato da questa Action. Dubbio forte: `StoreAction` salva il padre prima di applicare le relazioni, quindi la chiave esterna impostata in memoria può non essere persistita. Non verificato a runtime.

## Effetti collaterali

Un `INSERT` del correlato. Il padre è modificato in memoria. Nessuna transazione.

## Errori

- `InvalidArgumentException` se `rows` non è `BelongsTo`.

## Non fa

- Non gestisce il caso in cui il correlato esiste già: crea sempre.
- Il codice contiene blocchi di debug commentati (`dddx`): non fanno parte del comportamento.
