---
title: "CreateTableIndexByModelClassColumnsAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Query\\CreateTableIndexByModelClassColumnsAction"
qmd: "CreateTableIndexByModelClassColumnsAction crea indice tabella colonne modello information_schema idempotente"
---

# CreateTableIndexByModelClassColumnsAction

Crea un indice su una tabella di modello, saltandolo se esiste già per nome. Codice: `app/Actions/Query/CreateTableIndexByModelClassColumnsAction.php` (classe a riga 20, `execute()` a riga 30).

## Input

- `string $modelClass`: FQCN di un sottotipo di `Model`.
- `array<string> $columns`: colonne dell'indice.

## Output

- `bool`: `true` se l'indice è stato creato, `false` se esisteva già.

## Invarianti

- `CREATE-INDEX-INV-1` — La classe deve essere un sottotipo di `Model`. Test: `tests/Unit/Actions/Query/CreateTableIndexByModelClassColumnsActionTest.php`.
- `CREATE-INDEX-INV-2` — La tabella deve esistere sulla connessione del modello, altrimenti `RuntimeException`. Test: come sopra.
- `CREATE-INDEX-INV-3` — Ogni colonna deve esistere, altrimenti `RuntimeException`. Test: come sopra.
- `CREATE-INDEX-INV-4` — Il nome è `<tabella>_<colonne>_index`; se esiste già (controllo su `information_schema.statistics`) non si modifica nulla e si ritorna `false`. Test: come sopra.
- `CREATE-INDEX-INV-5` — Altrimenti l'indice è aggiunto con `Blueprint::index`. Test: come sopra.

## Effetti collaterali

Lettura di `information_schema` e di schema; `ALTER TABLE ... ADD INDEX` sulla tabella. Nessuna transazione. Il DDL non è atomico con altro lavoro.

## Errori

- `InvalidArgumentException` se la classe non è un `Model`.
- `RuntimeException` se tabella o colonna mancano.

## Non fa

- Non verifica che un indice con lo stesso nome abbia le stesse colonne: basta il nome.
- Non gestisce il limite di lunghezza dei nomi indice del database.
