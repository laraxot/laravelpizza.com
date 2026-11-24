---
title: "GetTenantConfigNamesAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Config\\GetTenantConfigNamesAction"
qmd: "GetTenantConfigNamesAction elenco file php config tenant nomi id sequenziale"
---

# GetTenantConfigNamesAction

Elenca i file di configurazione PHP della cartella del tenant corrente. Codice: `app/Actions/Config/GetTenantConfigNamesAction.php:13-37`.

## Input

- Nessun parametro. Il tenant viene da `GetTenantNameAction` (riga 22) e la cartella da `config_path()` (riga 24).

## Output

- `array<int, array{id:int,name:string}>`: per ogni file `.php` della cartella, `name` è il nome senza estensione e `id` è la posizione 1-based (righe 29-36).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-CFG-NAMES-INV-1` | Sono elencati solo file con estensione `php`; la ricerca non è ricorsiva. | riga 30 e `File::files` (riga 27) | `tests/Unit/Actions/Config/GetTenantConfigNamesActionTest.php` |
| `TENANT-CFG-NAMES-INV-2` | `id` è sequenziale da 1 nell'ordine restituito da `File::files`, che non è ordinato esplicitamente. | righe 31-32 | nessuno (l'ordine non è fissato dai test) |

## Effetti collaterali

Legge la cartella. Nessuna scrittura.

## Errori

- Nessuna gestione esplicita. Se la cartella non esiste, l'errore di `File::files` si propaga (da verificare sul comportamento del framework).

## Non fa

- Non legge il contenuto dei file.
- Non ordina per nome: l'`id` può cambiare tra filesystem diversi.
- Non passa da `GetTenantFilePathAction`, quindi non applica il controllo anti-traversal: il nome tenant è considerato fidato.
