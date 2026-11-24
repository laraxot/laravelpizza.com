---
title: "Contratto — GetTenantFilePathAction"
type: contract
action: "Modules\Tenant\Actions\Config\GetTenantFilePathAction"
tags: [contract, action, tenant, filesystem]
created: 2026-11-24
updated: 2026-11-24
---

# GetTenantFilePathAction

Sorgente: `app/Actions/Config/GetTenantFilePathAction.php`. Perché: [ADR tenant](../adr/tenant-name-from-reversed-host.md),
[ADR contenuti nei test](../adr/tenant-json-content-isolated-in-tests.md).

## Input

- `$filename`: percorso relativo alla cartella del tenant (`database.php`, `database/content/pages.json`).

## Output

- Percorso assoluto con i separatori del sistema operativo.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-FILE-PATH-INV-1 | Fuori dai test il percorso è `base_path('config/<tenant>/<filename>')`, tenant da `GetTenantNameAction`. | `TENANT-FILE-PATH-INV-1` |
| TENANT-FILE-PATH-INV-2 | Percorso assoluto, segmento `..` o byte NUL = `InvalidArgumentException`, prima di leggere il tenant. | `TENANT-FILE-PATH-INV-2` |
| TENANT-FILE-PATH-INV-3 | Nei test un nome sotto `database/content/` punta a `storage/framework/testing/tenant-content/<tenant>/...`, mai a `config/`. | `TENANT-FILE-PATH-INV-3` |

## Effetti collaterali

- Solo nei test e solo per `database/content/`: la prima volta per processo cancella e ricopia
  `storage/framework/testing/tenant-content/<tenant>/database/content` dai JSON versionati; poi copia il file o la cartella
  richiesta se manca.
- Fuori dai test: nessuno.

## Errori

- `InvalidArgumentException('Tenant filename must be a relative path without traversal segments.')`.

## Non fa

- Non controlla che il file esista e non lo crea.
- Non normalizza i symlink: lo fa `GetTenantNameAction` sul nome del tenant.
