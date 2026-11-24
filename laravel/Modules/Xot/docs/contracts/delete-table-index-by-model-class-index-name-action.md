---
title: "DeleteTableIndexByModelClassIndexNameAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Model\\DeleteTableIndexByModelClassIndexNameAction"
qmd: "DeleteTableIndexByModelClassIndexNameAction elimina indice tabella modello dropIndex Schema Blueprint connessione"
---

# DeleteTableIndexByModelClassIndexNameAction

Elimina un indice dalla tabella di un modello, sulla connessione del modello. Codice: `app/Actions/Model/DeleteTableIndexByModelClassIndexNameAction.php` (classe a riga 17, `execute()` a riga 23).

## Input

- `string $modelClass`: FQCN di un modello Eloquent (istanziato con `app()`).
- `string $indexName`: nome dell'indice, non vuoto.

## Output

- `void`.

## Invarianti

- `DELETE-INDEX-INV-1` — Il nome tabella è `getTable()` e non è vuoto. Test: nessuno.
- `DELETE-INDEX-INV-2` — L'operazione usa `Schema::connection(connessione del modello)` e `Blueprint::dropIndex($indexName)`, senza quotare manualmente. Test: nessuno.

## Effetti collaterali

Un DDL `DROP INDEX` sulla tabella. Nessuna transazione: su MySQL il DDL non è transazionale.

## Errori

- `Webmozart\Assert\InvalidArgumentException` se la classe non è un modello o i nomi sono vuoti.
- Errori del database propagati, per esempio indice inesistente.

## Non fa

- Non verifica che l'indice esista prima di eliminarlo.
- Il docblock dice che `getDoctrineSchemaManager()` non è più disponibile: questa Action evita quel percorso, ma la sua scelta di quoting dipende dal driver.
