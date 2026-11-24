---
title: "GetTenantConfigPathAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Config\\GetTenantConfigPathAction"
qmd: "GetTenantConfigPathAction percorso configurazione tenant nome php delega GetTenantFilePathAction Tenant"
---

# GetTenantConfigPathAction

Restituisce il percorso del file di configurazione del tenant aggiungendo `.php` al nome e delegando a `Tenant`. Codice: `app/Actions/Config/GetTenantConfigPathAction.php:10-20`.

## Input

- `string $name`: nome della configurazione senza estensione (`execute`, riga 14).

## Output

- `string`: percorso restituito da `Modules\Tenant\Actions\Config\GetTenantFilePathAction` (riga 18).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `CONFIG-TENANT-PATH-INV-1` | Il nome passato a Tenant è `$name.'.php'`. | righe 16-18 | `tests/Unit/Actions/Config/GetTenantConfigArrayActionTest.php:9,22` (mock del path) |

## Effetti collaterali

Nessuno proprio. Il percorso dipende dalla risoluzione di `GetTenantFilePathAction`.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non verifica l'esistenza del file.
- Dipendenza cross-modulo: Xot dipende da `Modules/Tenant/app/Actions/Config/GetTenantFilePathAction.php`. Da tenere presente se Tenant viene disabilitato.
- Marker `@contract` aggiunto nel docblock della classe.
