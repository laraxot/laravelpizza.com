---
title: "GetViewsSiblingsAndSelfAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\View\\GetViewsSiblingsAndSelfAction"
qmd: "GetViewsSiblingsAndSelfAction viste fratelli stessa cartella blade.php elenco vista corrente"
---

# GetViewsSiblingsAndSelfAction

Elenca le viste `.blade.php` che stanno nella stessa cartella della vista indicata, inclusa la vista stessa. Codice: `app/Actions/View/GetViewsSiblingsAndSelfAction.php:14-41`.

## Input

- `string $view`: nome vista (`execute`, riga 23).

## Output

- `array<string,string>`: nome senza estensione => nome senza estensione (chiave e valore uguali) (righe 29-39).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `VIEW-SIBLINGS-INV-1` | La cartella è quella del file risolto da `View\GetViewPathAction`. | righe 25-27 | Test: nessuno |
| `VIEW-SIBLINGS-INV-2` | Sono considerati solo i file che terminano con `.blade.php`; la scansione non è ricorsiva. | righe 28-37 | Test: nessuno |
| `VIEW-SIBLINGS-INV-3` | La vista stessa è inclusa, perché sta nella cartella. | righe 28-37 | Test: nessuno |

## Effetti collaterali

Nessuno. Sola lettura della cartella.

## Errori

- Nessuna eccezione propria. Dubbio: `File::files` su cartella inesistente può sollevare un'eccezione. Non verificato.

## Non fa

- Non restituisce i percorsi, solo i nomi.
- Il docblock sopra il `namespace` ("All the parent's children") non descrive il comportamento reale: da allineare.
- Marker `@contract` aggiunto nel docblock della classe.
