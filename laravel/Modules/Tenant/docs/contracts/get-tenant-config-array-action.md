---
title: "GetTenantConfigArrayAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Config\\GetTenantConfigArrayAction"
qmd: "GetTenantConfigArrayAction config tenant file php array silenzioso require fallback vuoto"
---

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
- Qualunque `Throwable` durante la lettura del file: inghiottito e trasformato in `[]` (riga 24). Il chiamante non può distinguere "file assente" da "file rotto". È un silent failure da trattare come debito.

## Non fa

- Non fonde con la configurazione Laravel caricata.
- Non memorizza in cache.
