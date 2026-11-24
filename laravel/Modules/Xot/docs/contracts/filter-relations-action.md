---
title: "FilterRelationsAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\FilterRelationsAction"
qmd: "FilterRelationsAction filtra relazioni Eloquent basename chiave related model Assert Relation"
---

# FilterRelationsAction

Indicizza un elenco di relazioni Eloquent per nome breve del modello correlato. Codice: `app/Actions/Model/FilterRelationsAction.php`.

## Input

- `Model $_model`: non usato.
- `array<string, mixed> $relations`: ogni valore deve essere un'istanza di `Illuminate\Database\Eloquent\Relations\Relation`.

## Output

- `array<string, Relation>`: chiave = `class_basename()` del modello correlato, valore = la relazione.

## Invarianti

- `FILTER-RELATIONS-INV-1` — Ogni elemento deve essere una `Relation`, altrimenti l'Action lancia. Prova: `execute()`. Test: nessuno.
- `FILTER-RELATIONS-INV-2` — La chiave è il basename del modello correlato; due relazioni verso modelli con lo stesso basename si sovrascrivono senza errore (vince l'ultima). Prova: `execute()`. Test: nessuno.

## Effetti collaterali

Nessuno. Chiama `getRelated()` su ogni relazione, senza scritture.

## Errori

- `Webmozart\Assert\InvalidArgumentException` se un elemento non è una `Relation` o se `getRelated()` non è un `Model`.

## Non fa

- Non filtra per tipo di relazione e non usa `$_model`.
- Dubbio da verificare: `StoreAction` e `Update/RelationAction` passano a questo metodo l'intero array `$data` del form. Con valori scalari, come ci si aspetta da un form, l'`Assert` fallisce. Il caller reale deve quindi passare oggetti `Relation`: non verificato.
