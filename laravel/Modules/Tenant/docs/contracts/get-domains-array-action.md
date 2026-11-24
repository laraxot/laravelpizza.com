---
title: "GetDomainsArrayAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Domains\\GetDomainsArrayAction"
qmd: "GetDomainsArrayAction domini tenant cartelle config host invertito lista foglie lang"
---

# GetDomainsArrayAction

Ricostruisce i domini dei tenant dalla struttura delle cartelle sotto `config/`. Codice: `app/Actions/Domains/GetDomainsArrayAction.php:13-81`.

## Input

- Nessun parametro. Scansiona `config_path()`.

## Output

- `array<int, array{id: string, name: string}>`: per ogni cartella foglia (vuota), `id` e `name` sono il dominio ricostruito invertendo il percorso (`eu/fixcity` diventa `fixcity.eu`) (righe 26-33, 63-81).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-DOMAINS-INV-1` | Le cartelle chiamate `lang` sono escluse a ogni livello. | riga 50 | `tests/Unit/Actions/Domains/GetDomainsArrayActionTest.php` |
| `TENANT-DOMAINS-INV-2` | Solo le cartelle foglia (senza sottocartelle) producono un dominio. | righe 68-70 | `tests/Unit/Actions/Domains/GetDomainsArrayActionTest.php` |
| `TENANT-DOMAINS-INV-3` | Il nome è il percorso invertito con `.` (`a/b/c` diventa `c.b.a`). | riga 67 | `tests/Unit/DomainTest.php` (riferimento) |

## Effetti collaterali

Solo lettura del filesystem. Nessuna scrittura, evento o cache.

## Errori

- Nessuna gestione esplicita: gli errori del filesystem si propagano.

## Non fa

- Non legge il contenuto dei file di configurazione.
- Non restituisce le cartelle intermedie che hanno figli.
- Non verifica che il tenant abbia una riga nel database.
