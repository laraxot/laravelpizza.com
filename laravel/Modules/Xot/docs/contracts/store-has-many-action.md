---
title: "HasManyAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Store\\HasManyAction"
qmd: "Store HasManyAction figlio creazione hasMany create chiave esterna"
---

# HasManyAction

Crea un figlio della relazione `hasMany`. Codice: `app/Actions/Model/Store/HasManyAction.php` (classe a riga 17, `execute()` a riga 17).

## Input

- `Model $_model`: non usato.
- `RelationDTO $relationDTO`: `rows` deve essere `HasMany`; `data` sono gli attributi di un figlio.

## Output

- `void`.

## Invarianti

- `STORE-HAS-MANY-INV-1` — Viene creato un solo figlio con `rows->create(data)`, che imposta la chiave esterna. Test: nessuno diretto (`tests/Unit/XotHasManyWidgetCoverageTest.php` cita la classe per nome: non verificato come test di questa Action).
- `STORE-HAS-MANY-INV-2` — Non modifica né cancella figli esistenti.

## Effetti collaterali

Un `INSERT` del figlio. Nessuna transazione, nessun evento proprio.

## Errori

- `InvalidArgumentException` se `rows` non è `HasMany`.
- Dati non in forma di attributo singolo (es. lista di figli) producono errore del `create`.

## Non fa

- Non crea più figli in una chiamata.
