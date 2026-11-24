---
title: "GetTenantNameAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\GetTenantNameAction"
qmd: "GetTenantNameAction risoluzione tenant host dominio invertito symlink config localhost"
---

# GetTenantNameAction

Risolve il nome del tenant corrente dall'host. Tutto l'isolamento dei file tenant dipende da questo valore. Codice: `app/Actions/GetTenantNameAction.php:22-170`.

## Input

- Nessun parametro. Usa `SERVER_NAME`, l'header `Host` (fuori dalla console) e `config('app.url')`.

## Output

- `string`: percorso del tenant sotto `config/` con separatore `/` (ad esempio `local/ptvx`), oppure `localhost`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-NAME-INV-1` | Il risultato non è mai vuoto: l'ultimo ripiego è `localhost` (riga 46). | righe 44-46 | `tests/Unit/Actions/GetTenantNameActionTest.php` |
| `TENANT-NAME-INV-2` | L'host perde `www.`, è spezzato sui punti, ogni parte è slugata e l'ordine è invertito (`foo.example.com` diventa `com/example/foo`). | righe 36-42 | `tests/Unit/Actions/GetTenantNameActionTest.php` |
| `TENANT-NAME-INV-3` | Si prova il percorso completo; con più di due parti si prova anche quello senza l'ultima parte; poi l'host di `app.url`. | righe 44-45, 52-83 | `tests/Unit/Actions/GetTenantNameActionTest.php` |
| `TENANT-NAME-INV-4` | Se l'host è un symlink verso un'altra config, il nome è il percorso reale sotto `config_path()`, non l'alias. | righe 90-104 | nessuno individuato |
| `TENANT-NAME-INV-5` | `SERVER_NAME` vuoto o loopback (`127.0.0.1`, `::1`, `localhost`) è ignorato a favore dell'header `Host` (fuori dalla console), poi di `app.url`. | righe 114-134 | `tests/Feature/TenantConfigIsolationTest.php` (host malevolo) |

## Effetti collaterali

Nessuna scrittura. Legge il filesystem (`file_exists`, `realpath`) e la richiesta corrente. Nessun evento, coda o cache.

## Errori

- `FilesystemException` da `realpath` ripiega sul nome logico (righe 92-97).
- Errore nel leggere la richiesta: ignorato, si passa al default (righe 143-148).
- `parse_url` in `hostFromUrl` non ha un `try` (da verificare se la funzione Safe può lanciare).

## Non fa

- Non crea cartelle o config per un tenant assente: cade su `localhost`.
- Non autentica né autorizza l'host; non usa il database.
- Debito: `resolveFromDefaultHost` usa `base_path('config/...')` (riga 77), mentre il resto usa `config_path()`.
