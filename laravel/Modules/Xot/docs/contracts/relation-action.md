---
title: "RelationAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Update\\RelationAction"
qmd: "Update RelationAction dispatcher relazioni tipo classe Action execute FilterRelationsAction"
---

# RelationAction

Dispatcher: per ogni relazione trovata nei dati, chiama la Action `Model/Update/<TipoRelazione>Action`. Codice: `app/Actions/Model/Update/RelationAction.php` (classe a riga 16, `execute()` a riga 21).

## Input

- `Model $model`: il padre.
- `array $data`: dati con eventuali oggetti `Relation`, filtrati da `FilterRelationsAction`.

## Output

- `void`.

## Invarianti

- `UPDATE-RELATION-INV-1` — Ogni relazione è passata alla Action con nome `<basename tipo>Action` nello stesso namespace. Test: indiretto (vedi `UpdateAction`).
- `UPDATE-RELATION-INV-2` — Se la Action non ha il metodo `execute`, la relazione è saltata senza errore. Test: nessuno.

## Effetti collaterali

Dipendono dalla Action invocata: scritture sul padre e sui correlati.

## Errori

- `InvalidArgumentException` da `FilterRelationsAction` per elementi che non sono `Relation`.
- Errori di `app()` se la classe di tipo non esiste.

## Non fa

- Non gestisce relazioni di tipo sconosciuto oltre al saltare la Action senza `execute`.
- Stesso dubbio di `StoreAction` sul passaggio dei dati scalari a `FilterRelationsAction`.
