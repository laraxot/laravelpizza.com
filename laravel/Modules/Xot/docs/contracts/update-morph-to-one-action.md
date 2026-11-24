---
title: "MorphToOneAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\Update\\MorphToOneAction"
qmd: "Update MorphToOneAction morphToOne crea sempre nuovo duplicato lang CreateMorphToOneRelatedModelAction"
---

# MorphToOneAction

Gestisce una `morphToOne` nel flusso di aggiornamento. Codice: `app/Actions/Model/Update/MorphToOneAction.php` (classe a riga 22, `execute()` a riga 32).

## Input

- `Model $model`: il padre.
- `RelationDTO $relationDTO`: `name` è il nome della relazione, `data` gli attributi.

## Output

- `void`.

## Invarianti

- `UPDATE-MORPH-TO-ONE-INV-1` — Se `$model->{name}()` non è un oggetto, lancia `InvalidArgumentException`. Test: nessuno.
- `UPDATE-MORPH-TO-ONE-INV-2` — `lang` mancante è impostato alla locale; i `null` sono rimossi. Test: nessuno.
- `UPDATE-MORPH-TO-ONE-INV-3` — Il correlato è sempre creato con `CreateMorphToOneRelatedModelAction`, cioè con `create()`. Test: nessuno.

## Effetti collaterali

Un `INSERT` del correlato a ogni chiamata. Nessuna transazione.

## Errori

- `InvalidArgumentException` se la relazione non è un oggetto; eccezioni di `CreateMorphToOneRelatedModelAction` e del database.

## Non fa

- Non aggiorna il correlato esistente. Ogni salvataggio del form crea un nuovo record: è un difetto probabile, da verificare con un caso reale, perché il nome dell'Action suggerisce un aggiornamento.
