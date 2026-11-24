---
title: "FilterConfigStringKeysAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Config\\FilterConfigStringKeysAction"
qmd: "FilterConfigStringKeysAction chiavi stringa config tenant filtro array"
---

# FilterConfigStringKeysAction

Tiene solo le voci con chiave stringa di un array di configurazione. Codice: `app/Actions/Config/FilterConfigStringKeysAction.php:9-30`.

## Input

- `array<mixed, mixed> $config`: array con chiavi di qualunque tipo (riga 17).

## Output

- `array<string, mixed>`: stesse voci di `$config` con chiave stringa, nello stesso ordine (righe 19-28).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-FILTER-INV-1` | Il risultato contiene solo chiavi stringa; le chiavi intere sono scartate. | righe 22-25 | `tests/Unit/TenantGapsCoverageTest.php` (riferimento alla classe, non per l'invariante) |
| `TENANT-FILTER-INV-2` | Il filtro è solo di primo livello: le chiavi intere annidate restano. | righe 22-25 (nessuna ricorsione) | nessuno |
| `TENANT-FILTER-INV-3` | L'input non viene modificato. | variabile locale `$result` | nessuno |

## Effetti collaterali

Nessuno: calcolo puro, nessuna lettura o scrittura.

## Errori

- Nessuna eccezione.

## Non fa

- Non ricorre nei sottoarray.
- Non riordina e non valida i valori.
