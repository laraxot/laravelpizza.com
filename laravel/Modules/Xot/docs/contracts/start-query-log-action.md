---
title: "StartQueryLogAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Query\\StartQueryLogAction"
qmd: "StartQueryLogAction log query QueryExecuted listener daily querylog bindings debug duplicati"
---

# StartQueryLogAction

Registra un listener che scrive ogni query SQL su un file di log dedicato. Codice: `app/Actions/Query/StartQueryLogAction.php` (classe a riga 16, `execute()` a riga 16).

## Input

- Nessuno.

## Output

- `void`.

## Invarianti

- `START-QUERY-LOG-INV-1` — Ogni chiamata aggiunge un listener a `QueryExecuted`, senza verificare se ne esiste già uno. Test: `tests/Unit/Actions/Query/QueryActionsTest.php` (menzione), non verificato sul comportamento di duplicazione.
- `START-QUERY-LOG-INV-2` — Per ogni query eseguita si scrivono nel canale `daily` (`storage/logs/querylog.log`) sql, tempo, connessione e bindings, al livello `debug`. Test: come sopra.

## Effetti collaterali

Registrazione nel dispatcher eventi del processo. Ogni query produce scritture su file. Il canale è creato a ogni query con `Log::build`.

## Errori

- Nessuno gestito: un errore di scrittura del log si propaga nella query.

## Non fa

- Non rimuove il listener.
- Chiamate ripetute moltiplicano le righe di log per ogni query.
- Scrive i bindings: possono contenere dati personali. Da valutare prima di usarla in produzione.
