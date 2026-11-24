---
title: "TranslateTenantKeyAction — contratto"
type: contract
owner: Tenant
status: accepted
updated: 2026-11-24
action: "Modules\\Tenant\\Actions\\Translations\\TranslateTenantKeyAction"
qmd: "TranslateTenantKeyAction traduzione tenant chiave lang file php locale fallback chiave"
---

# TranslateTenantKeyAction

Traduce una chiave `file.chiave` usando il file di lingua del tenant. Codice: `app/Actions/Translations/TranslateTenantKeyAction.php:14-45`.

## Input

- `string $key`: il primo segmento (prima del punto) è il nome del file in `lang/<locale>/`; il resto è la chiave annidata (righe 22-27).

## Output

- `string`: la traduzione, oppure la chiave originale se non si risolve (righe 31, 41, 43).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-TRANS-INV-1` | Se il file di lingua del tenant non esiste, si restituisce la chiave. | righe 29-32 | `tests/Unit/Actions/Translations/TranslateTenantKeyActionTest.php` |
| `TENANT-TRANS-INV-2` | Se la chiave non è una stringa, si restituisce la chiave. | righe 39-41 | `tests/Unit/Actions/Translations/TranslateTenantKeyActionTest.php` |
| `TENANT-TRANS-INV-3` | Se il file non restituisce un array, `Assert` lancia. | riga 35 | nessuno |

## Effetti collaterali

Esegue il file di lingua con `File::getRequire`. Nessuna scrittura.

## Errori

- `InvalidArgumentException` da `Assert::isArray` (riga 35).

## Non fa

- Non usa la lingua di default dell'app come fallback.
- Una chiave senza punto: `Str::after` restituisce la stringa intera come chiave annidata (comportamento da verificare).
