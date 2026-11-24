---
title: "GetTenantFilePathAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Config\\GetTenantFilePathAction"
qmd: "GetTenantFilePathAction isolamento tenant path traversal config tenant database content"
---

# GetTenantFilePathAction

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
