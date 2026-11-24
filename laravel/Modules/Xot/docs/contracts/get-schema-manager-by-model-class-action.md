---
title: "GetSchemaManagerByModelClassAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\GetSchemaManagerByModelClassAction"
qmd: "GetSchemaManagerByModelClassAction doctrine schema manager getDoctrineSchemaManager RuntimeException deprecato"
---

# GetSchemaManagerByModelClassAction

Ottiene lo schema manager Doctrine per la connessione di un modello. Codice: `app/Actions/Model/GetSchemaManagerByModelClassAction.php`.

## Input

- `string $modelClass`: FQCN di un modello Eloquent (istanziato con `app()`).

## Output

- `AbstractSchemaManager` di Doctrine.

## Invarianti

- `GET-SCHEMA-MANAGER-INV-1` — La classe deve essere un Eloquent `Model`. Prova: `execute()`. Test: nessuno.
- `GET-SCHEMA-MANAGER-INV-2` — Se la connessione non espone `getDoctrineSchemaManager`, lancia `RuntimeException`. Prova: `execute()`. Test: nessuno.

## Effetti collaterali

Nessuno oltre l'istanziazione del modello.

## Errori

- `InvalidArgumentException` se non è un modello; `RuntimeException` se il metodo Doctrine non esiste.

## Non fa

- Verificato: nel vendor installato `Illuminate\Database\Connection` non definisce `getDoctrineSchemaManager`. Questo ramo quindi lancia sempre, e `GetTableIndexesByModelClassAction` non può funzionare. Il commento in `Model/DeleteTableIndexByModelClassIndexNameAction` conferma che il metodo non è più esposto.
