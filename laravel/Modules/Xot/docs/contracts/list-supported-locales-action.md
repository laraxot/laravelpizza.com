---
title: "ListSupportedLocalesAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\ListSupportedLocalesAction"
qmd: "ListSupportedLocalesAction lingue supportate laravellocalization codice nome nativo"
---

# ListSupportedLocalesAction

Elenca le lingue supportate con il nome nativo. Codice: `app/Actions/ListSupportedLocalesAction.php` (classe a riga 17, `execute()` a riga 22).

## Input

- Nessuno.

## Output

- `array<string, string>`: codice => nome nativo.

## Invarianti

- `SUPPORTED-LOCALES-INV-1` — Le lingue sono quelle di `LaravelLocalization::getSupportedLocales()`. Test: `tests/Unit/Datas/XotConfigDataTest.php` (menzione).
- `SUPPORTED-LOCALES-INV-2` — Se manca `native`, il codice è usato come nome. Test: come sopra.

## Effetti collaterali

Nessuno.

## Errori

- `Webmozart` se le proprietà di una lingua non sono array.

## Non fa

- Non verifica che i file di traduzione esistano per ogni lingua.
