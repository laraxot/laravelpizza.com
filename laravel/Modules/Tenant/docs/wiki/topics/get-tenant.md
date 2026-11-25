---
title: "Topic get-tenant"
type: digest
status: active
qmd: "digest ceiling 100 get-tenant"
---

# Topic get-tenant

<<<<<<< HEAD
Sintesi automatica di 6 documenti (chiave `get-tenant`).
=======
Sintesi automatica di 9 documenti (chiave `get-tenant`).
>>>>>>> laraxot/dev

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

<<<<<<< HEAD
=======
## GetTenantConfigValueAction

_Fonte: `contracts/get-tenant-config-value-action.md`_

# GetTenantConfigValueAction

Risolve un valore di configurazione sovrapponendo la config del tenant a quella di base. Codice: `app/Actions/Config/GetTenantConfigValueAction.php:13-63`.

## Input

- `string $key`: chiave con notazione a punti. Il primo segmento è il gruppo (riga 33).
- `string|int|array|null $_default`: valore passato a `config()` se la chiave manca (riga 56).

## Output

- `float|int|string|array|null`: valore risolto (riga 58-60).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-RESOLVE-INV-1` | Chiave vuota o gruppo vuoto lancia `Exception`. | righe 33-36 | `tests/Unit/Actions/Config/GetTenantConfigValueActionTest.php` |
| `TENANT-RESOLVE-INV-2` | Il gruppo è fuso con `<tenant>.<gruppo>` e i valori del tenant prevalgono (`array_replace_recursive`). | righe 38-52 | `tests/Unit/Actions/Config/GetTenantConfigValueActionTest.php` |
| `TENANT-RESOLVE-INV-3` | Un valore non scalare né array (ad esempio bool o oggetto) lancia `Exception`. | righe 58-62 | nessuno |

## Effetti collaterali

- `Config::set($group, $mergeConf)` (riga 54) modifica la configurazione in memoria dell'intero gruppo per il resto del processo. Non scrive su disco.
- Legge la config di base e quella del tenant, e il nome tenant da `GetTenantNameAction`.

## Errori

- `Exception` generica con messaggio `[riga][classe]` in entrambi i casi di errore.

>>>>>>> laraxot/dev
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

<<<<<<< HEAD
=======
## GetTenantModelClassAction

_Fonte: `contracts/get-tenant-model-class-action.md`_

# GetTenantModelClassAction

Risolve il FQCN del model da un nome, usando la `morph_map` del tenant e, se manca, la scansione dei moduli abilitati. Codice: `app/Actions/Models/GetTenantModelClassAction.php:16-103`.

## Input

- `string $name`: nome del model, al singolare o al plurale. Viene normalizzato con `Str::snake(Str::singular(...))` (riga 22).

## Output

- `class-string` (`string`): FQCN del model.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `RES-MODEL-CLASS-INV-1` | Il nome è normalizzato al singolare snake_case prima della ricerca. | riga 22 | `tests/Unit/Actions/Models/GetTenantModelClassActionTest.php` |
| `RES-MODEL-CLASS-INV-2` | Se `morph_map.<name>` è in config, viene restituito senza scansionare i moduli. | righe 24-27 | `tests/Unit/Actions/Models/GetTenantModelClassActionTest.php` |
| `RES-MODEL-CLASS-INV-3` | Se il nome non è in `morph_map`, la scansione dei moduli abilitati trova la classe e la coppia viene persistita nella `morph_map` del tenant. | righe 37-47 | `tests/Unit/Actions/Models/GetTenantModelClassActionTest.php` |
| `RES-MODEL-CLASS-INV-4` | Un nome sconosciuto lancia `Exception` e non scrive nulla. | righe 40-42 | `tests/Unit/Actions/Models/GetTenantModelClassActionTest.php` |
| `RES-MODEL-CLASS-INV-5` | Un valore in `morph_map` non stringa lancia `Exception`. | righe 30-32 | nessuno |

## Effetti collaterali

Ordine: lettura config (`GetTenantConfigValueAction`), scansione moduli (`Module::allEnabl

## GetTenantModelInstanceAction

_Fonte: `contracts/get-tenant-model-instance-action.md`_

# GetTenantModelInstanceAction

Restituisce una istanza nuova del model risolto per nome. Codice: `app/Actions/Models/GetTenantModelInstanceAction.php:11-24`.

## Input

- `string $name`: come per `GetTenantModelClassAction`.

## Output

- `Model`: istanza nuova della classe risolta, creata con `app()` (righe 17-22).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `RES-MODEL-INST-INV-1` | La classe è quella di `GetTenantModelClassAction`, istanziata dal container. | righe 17-19 | `tests/Unit/Actions/Models/GetTenantModelInstanceActionTest.php` |
| `RES-MODEL-INST-INV-2` | Il risultato è un `Model`, altrimenti `Assert` lancia. | riga 20 | `tests/Unit/Actions/Models/GetTenantModelInstanceActionTest.php` |

## Effetti collaterali

Quelli di `GetTenantModelClassAction` (possibile scrittura di `morph_map`). Nessuna scrittura diretta, nessuna query.

## Errori

- Le eccezioni di `GetTenantModelClassAction` si propagano.
- `Assert::isInstanceOf` lancia se la classe non è un `Model`.

## Non fa

>>>>>>> laraxot/dev
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
