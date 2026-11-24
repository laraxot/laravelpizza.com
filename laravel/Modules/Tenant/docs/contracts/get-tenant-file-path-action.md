---
<<<<<<< .merge_file_JjkmVr
title: "GetTenantFilePathAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Config\\GetTenantFilePathAction"
qmd: "GetTenantFilePathAction isolamento tenant path traversal config tenant database content"
=======
title: "Contratto — GetTenantFilePathAction"
type: contract
action: "Modules\Tenant\Actions\Config\GetTenantFilePathAction"
tags: [contract, action, tenant, filesystem]
created: 2026-11-24
updated: 2026-11-24
>>>>>>> .merge_file_Bi4LlV
---

# GetTenantFilePathAction

<<<<<<< .merge_file_JjkmVr
Calcola il percorso di un file di configurazione o contenuto del tenant corrente. È il punto di isolamento dei file tra tenant. Codice: `app/Actions/Config/GetTenantFilePathAction.php:12-68`.

## Input

- `string $filename`: percorso relativo al tenant (ad esempio `xra.php` o `database/content/pages.json`).

## Output

- `string`: percorso assoluto `base_path('config/<tenant>/<filename>')` con separatori di directory della piattaforma (riga 44).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-PATH-INV-1` | Un nome assoluto, con byte NUL o con un segmento `..` (anche con `\`) è rifiutato con `InvalidArgumentException`. | righe 18-21 | `tests/Unit/Actions/Config/GetTenantFilePathActionTest.php`, `tests/Feature/TenantConfigIsolationTest.php` |
| `TENANT-PATH-INV-2` | Il percorso sta sempre sotto `config/<nome tenant corrente>/`. | riga 24 | `tests/Feature/TenantConfigIsolationTest.php` |
| `TENANT-PATH-INV-3` | Solo in test unitari, i file `database/content/` sono rediretti su una copia usa-e-getta in `storage/framework/testing/tenant-content/<tenant>/`; le altre config restano reali. | righe 29-41 | `tests/Unit/Actions/Config/GetTenantFilePathActionTest.php` |

## Effetti collaterali

Normalmente nessuno (calcolo di stringa). Solo con `runningUnitTests()` e prefisso `database/content/`: la prima volta per processo `prepareTestingContent` cancella e ricrea la copia di test (righe 55-68) e copia il file o la directory richiesta. Nessun evento, coda o servizio esterno.

## Errori

- `InvalidArgumentException('Tenant filename must be a relative path without traversal segments.')` (riga 20).

## Non fa

- Non verifica che il file esista né lo legge o scrive (fuori dalla copia di test).
- Non valida il nome tenant: lo riceve da `GetTenantNameAction`.
=======
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
>>>>>>> .merge_file_Bi4LlV
