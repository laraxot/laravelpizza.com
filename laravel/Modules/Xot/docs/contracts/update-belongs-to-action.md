---
title: "BelongsToAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Update\\BelongsToAction"
qmd: "Update BelongsToAction belongsTo associa salva id singolo firstOrCreate fillable update create"
---

# BelongsToAction

Aggiorna la relazione `belongsTo`: associa un correlato esistente per id, oppure aggiorna/crea il correlato con i dati del form. Codice: `app/Actions/Model/Update/BelongsToAction.php` (classe a riga 20, `execute()` a riga 20).

## Input

- `Model $model`: il padre.
- `RelationDTO $relationDTO`: `rows` deve essere `BelongsTo`; `data` è un id singolo oppure un array associativo di attributi.

## Output

- `void`.

## Invarianti

- `UPDATE-BELONGS-TO-INV-1` — `rows` deve essere `BelongsTo`. Test: nessuno.
- `UPDATE-BELONGS-TO-INV-2` — `data` lista di un elemento: si cerca il correlato per id, si associa e si salva il padre (`associate()` restituisce il padre, poi `save()`). Id `null` non fa nulla. Id non trovato lancia. Test: nessuno.
- `UPDATE-BELONGS-TO-INV-3` — `data` associativa: si ottiene `firstOrCreate()` sulla relazione e si applica ricorsivamente `Update/RelationAction` al sotto-modello. Il flusso prosegue poi con il punto 4. Test: nessuno.
- `UPDATE-BELONGS-TO-INV-4` — I dati sono filtrati su fillable e hidden del correlato. Se la relazione esiste, si chiama `update` sul correlato letto da `$model->{camel(name)}`; altrimenti si crea il correlato e lo si associa e salva. Test: nessuno.

## Effetti collaterali

Scritture: `save()` del padre, `UPDATE` o `INSERT` del correlato, eventuali scritture ricorsive. Nessuna transazione.

## Errori

- `\Exception` generici con messaggio che nomina riga e classe, se il correlato non è un modello o `firstOrCreate` non restituisce nulla.
- `InvalidArgumentException` se `rows` non è `BelongsTo`.

## Non fa

- Nel ramo di aggiornamento, se la relazione non risponde a `update`, ritorna senza errore e senza scrivere.
- Il ramo `firstOrCreate` prosegue fino al punto 4: il comportamento combinato va verificato su un caso reale.
