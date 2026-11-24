---
title: "Contratto — GetAllTranslationAction"
type: contract
owner: Lang
status: accepted
updated: 2026-11-24
action: "Modules\\Lang\\Actions\\GetAllTranslationAction"
qmd: "GetAllTranslationAction elenco file traduzione moduli locale sessione seeder TranslationFileRowLoader LANG-ALLTRANS"
---

# GetAllTranslationAction

Elenca i file di traduzione di tutti i moduli per la lingua corrente. Codice: `app/Actions/GetAllTranslationAction.php:12-50`. Corpo identico a [get-all-module-translation-action](get-all-module-translation-action.md): duplicato. Il docblock («dato un key») e' un copia-incolla che non descrive il metodo.

## Input

- Nessun argomento. Stessa lettura di sessione e stesso `setLocale` di `get-all-module-translation-action` (righe 23-26).

## Output

- `list<array{key: string, path: string}>`, come sopra.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `LANG-ALLTRANS-INV-1` | Un elemento per file `Modules/*/lang/<locale>/*.php`. | `tests/Unit/Actions/GetAllTranslationActionTest.php:19-50` (ritorna lista, chiavi e percorsi, sessione valida/non valida, nessun file). |

## Effetti collaterali

- `app()->setLocale()` con sessione `it`/`en`.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non deduplica con l'Action gemella. Chiamanti verificati: `Models/Traits/TranslationFileRowLoader.php` e `database/seeders/TranslationFileSeeder.php`.
