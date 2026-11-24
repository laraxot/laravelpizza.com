---
title: "Contratto — ListLocaleOptionsAction"
type: contract
owner: Lang
status: accepted
updated: 2026-11-24
action: "Modules\\Lang\\Actions\\ListLocaleOptionsAction"
qmd: "ListLocaleOptionsAction etichette lingue bandiera nome nativo laravellocalization supportedLocales selettore LANG-LOCOPT"
---

# ListLocaleOptionsAction

Produce le etichette dei selettori di lingua: bandiera dal codice regionale e nome nativo. Codice: `app/Actions/ListLocaleOptionsAction.php:16-60`.

## Input

- `?array $codes`: codici da elencare, nell'ordine dato. `null`: tutte le lingue di `laravellocalization.supportedLocales`.

## Output

- `array<string, string>`: `codice => "<bandiera> <Nome nativo>"`, con il trim finale.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `LANG-LOCOPT-INV-1` | Le chiavi seguono l'ordine di `$codes`; con `null` l'ordine di `supportedLocales`. | `tests/Unit/Datas/LangConfigDataTest.php:93` («locale options show flag and native name, in the order asked»). |
| `LANG-LOCOPT-INV-2` | Un codice senza nome nativo (o assente da config) produce come etichetta il solo codice. | Test: nessuno. |
| `LANG-LOCOPT-INV-3` | La bandiera e' vuota se il regionale non ha un paese di due lettere alfabetiche (`it` senza `_IT`). | Test: nessuno. |

## Effetti collaterali

- Nessuno.

## Errori

- Nessuna eccezione. Config non array diventa lista vuota.

## Non fa

- Non valida i codici passati: un codice inesistente compare con la sola etichetta-codice.
- Chiamante verificato: `Filament/Pages/SettingPage.php`.
