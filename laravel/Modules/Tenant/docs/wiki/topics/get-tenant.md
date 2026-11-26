---
title: "Topic get-tenant"
type: digest
status: active
qmd: "digest ceiling 100 get-tenant"
---

# Topic get-tenant

Sintesi automatica di 7 documenti (chiave `get-tenant`).

## GetTenantConfigArrayAction

_Fonte: `contracts/get-tenant-config-array-action.md`_

# GetTenantConfigArrayAction

Legge il file `config/<tenant>/<name>.php` e restituisce il suo array. Codice: `app/Actions/Config/GetTenantConfigArrayAction.php:11-40`.

## Input

- `string $name`: nome del file senza estensione (riga 18). Il percorso passa da `GetTenantFilePathAction`.

## Output

- `array<string, mixed>`: contenuto del file, con chiavi intere convertite in stringa (righe 32-38).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-CFG-ARR-INV-1` | File mancante, errore di esecuzione o valore non array producono `[]` senza errore. | righe 22-30 (`catch Throwable`) | `tests/Unit/Actions/Config/GetTenantConfigArrayActionTest.php` |
| `TENANT-CFG-ARR-INV-2` | Le chiavi intere diventano stringhe. | righe 34-36 | `tests/Unit/Actions/Config/GetTenantConfigArrayActionTest.php` |
| `TENANT-CFG-ARR-INV-3` | Un nome con traversal o assoluto lancia `InvalidArgumentException` e non viene inghiottito, perché la chiamata a `GetTenantFilePathAction` è fuori dal `try`. | riga 20 | `tests/Unit/Actions/Config/GetTenantFilePathActionTest.php` (copertura via dipendenza) |

## Effetti collaterali

Legge il file con `File::getRequire`, quindi esegue il PHP del file di configurazione. Nessuna scrittura, nessun evento, nessuna cache.

## Errori

- `InvalidArgumentException` dal percorso (riga 20): propagata.
- Qualunque `Throwable` durante la lettura del file: inghiottito e trasformato in `[]` (riga 24). Il chiamante non può distinguere "fi

## GetTenantConfigNamesAction

_Fonte: `contracts/get-tenant-config-names-action.md`_

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

## GetTenantConfigPathAction

_Fonte: `contracts/get-tenant-config-path-action.md`_

# GetTenantConfigPathAction

Costruisce la chiave di configurazione Laravel che punta a una voce del tenant corrente. Codice: `app/Actions/Config/GetTenantConfigPathAction.php:10-19`.

## Input

- `string $key`: chiave relativa, ad esempio `app.name`.

## Output

- `string`: `<tenant con '.' al posto di '/'>.<key>` (riga 18). Esempio: tenant `local/ptvx` e chiave `app.name` producono `local.ptvx.app.name`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-CFG-PATH-INV-1` | Ogni `/` del nome tenant diventa `.`. | riga 18 | `tests/Unit/Actions/Config/GetTenantConfigPathActionTest.php` |
| `TENANT-CFG-PATH-INV-2` | `$key` non viene validato né normalizzato. | riga 18 | nessuno |

## Effetti collaterali

Nessuno: legge solo il nome tenant da `GetTenantNameAction`, che a sua volta legge la richiesta corrente.

## Errori

- Nessuna eccezione propria.

## Non fa

## GetTenantFilePathAction

_Fonte: `contracts/get-tenant-file-path-action.md`_

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

Normalmente nessuno (calcolo di stringa). Solo con `runningUnitTests()` e prefisso `database/content/`: la prima volta per processo `prepareTestingContent` cancella e ricrea la copia di test (righe 55-68) e copia il file o 

## GetTenantModulesAction

_Fonte: `contracts/get-tenant-modules-action.md`_

# GetTenantModulesAction

Elenca i moduli abilitati per il tenant corrente. Codice: `app/Actions/Modules/GetTenantModulesAction.php:15-62`.

## Input

- Nessun parametro. Legge `modules_statuses.json` del tenant tramite `GetTenantFilePathAction` (riga 24).

## Output

- `array<int, string>`: nomi dei moduli con valore `true` nel file e con cartella `Modules/<nome>` presente (righe 45-61).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-MODULES-INV-1` | Un modulo è incluso solo se il suo valore è vero e la cartella esiste. | righe 49-59 | `tests/Unit/Actions/TenantAdditionalActionsTest.php` (riferimento alla classe) |
| `TENANT-MODULES-INV-2` | Se il JSON non è un array, il risultato è `[]`. | righe 33-35 | nessuno |

## Effetti collaterali

Solo lettura del file e del filesystem. Nessuna scrittura.

## Errori

- File mancante: `File::get` lancia, fuori dal `try`, quindi l'eccezione si propaga.
- JSON non valido: `Exception` con messaggio, percorso del file e riga (righe 27-31).

## Non fa

## GetTenantNameAction

_Fonte: `contracts/get-tenant-name-action.md`_

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
| `TENANT-NAME-INV-5` | `SERVER_NAME` vuoto o loopback (`127.0.0.1`, `::1`, `localhost`) è ignorato a favore dell'header `Host` (fuori dalla console), poi di `app.url`. | righe 114-134 | `tests/Feature/TenantConf

## Topic get-tenant

_Fonte: `wiki/topics/get-tenant.md`_

# Topic get-tenant

Sintesi automatica di 9 documenti (chiave `get-tenant`).

## GetTenantConfigArrayAction

_Fonte: `contracts/get-tenant-config-array-action.md`_

# GetTenantConfigArrayAction

Legge il file `config/<tenant>/<name>.php` e restituisce il suo array. Codice: `app/Actions/Config/GetTenantConfigArrayAction.php:11-40`.

## Input

- `string $name`: nome del file senza estensione (riga 18). Il percorso passa da `GetTenantFilePathAction`.

## Output

- `array<string, mixed>`: contenuto del file, con chiavi intere convertite in stringa (righe 32-38).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-CFG-ARR-INV-1` | File mancante, errore di esecuzione o valore non array producono `[]` senza errore. | righe 22-30 (`catch Throwable`) | `tests/Unit/Actions/Config/GetTenantConfigArrayActionTest.php` |
| `TENANT-CFG-ARR-INV-2` | Le chiavi intere diventano stringhe. | righe 34-36 | `tests/Unit/Actions/Config/GetTenantConfigArrayActionTest.php` |
| `TENANT-CFG-ARR-INV-3` | Un nome con traversal o assoluto lancia `InvalidArgumentException` e non viene inghiottito, perché la chiamata a `GetTenantFilePathAction` è fuori dal `try`. | riga 20 | `tests/Unit/Actions/Config/GetTenantFilePathActionTest.php` (copertura via dipendenza) |

## Effetti collaterali
