---
title: "Contratto — CleanPlaceholderTranslationsAction"
type: contract
action: "Modules\Lang\Actions\CleanPlaceholderTranslationsAction"
tags: [contract, action, translations, lang-files, cleanup]
created: 2026-11-24
updated: 2026-11-24
related:
  - auto-label-action.md
  - ../../app/Actions/CleanPlaceholderTranslationsAction.php
  - ../../app/Console/Commands/CleanPlaceholderTranslationsCommand.php
  - ../../tests/Feature/CleanPlaceholderTranslationsActionTest.php
---

# CleanPlaceholderTranslationsAction

Toglie dai file di lingua le «traduzioni segnaposto» che `AutoLabelAction` scriveva in passato: `helper_text`,
`placeholder`, `description`, `tooltip`, `label`, `heading`, `hint` uguali al nome del campo che li contiene (comparivano
in produzione come «route», «postal_code» sotto i campi). Chiamante: `php artisan lang:clean-placeholders {moduli?*}
{--dry-run}`. Sorgente: `app/Actions/CleanPlaceholderTranslationsAction.php`.

Test: `cd laravel && vendor/bin/pest Modules/Lang/tests/Feature/CleanPlaceholderTranslationsActionTest.php`.

## Input

- `string $directory`: cartella da visitare ricorsivamente (di solito `lang/` di un modulo).
- `bool $dryRun = false`: solo elenco, nessuna scrittura.

## Output

- `array{files: list<string>, removed: int}`: file toccati (o da toccare) e numero di voci tolte, compresi i gruppi
  rimasti vuoti. Cartella inesistente = `['files' => [], 'removed' => 0]`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| LANG-CLEAN-INV-1 | Si toglie solo una voce di tipo segnaposto il cui valore è uguale alla chiave del gruppo che la contiene; le traduzioni vere restano; un gruppo rimasto vuoto si toglie. | `LANG-CLEAN-INV-1` |
| LANG-CLEAN-INV-2 | Un file che non è «solo dati» (variabili, funzioni, `new`, `::`, `use`, include, operatori) non si riscrive. | `LANG-CLEAN-INV-2` |
| LANG-CLEAN-INV-3 | I file chiamati solo `.php` (senza nome) si cancellano. | `LANG-CLEAN-INV-3` |
| LANG-CLEAN-INV-4 | Con `$dryRun` nessun file viene scritto o cancellato; il risultato è lo stesso. | — |

## Effetti collaterali

- Riscrive i file di lingua «solo dati» con `<?php declare(strict_types=1); return [...]` (formattazione propria:
  commenti e allineamenti originali si perdono).
- Cancella i file `.php` senza nome.
- `include` di ogni file `.php` della cartella che passa il controllo «solo dati».

## Errori

- Errori di lettura, scrittura o cancellazione (funzioni `Safe\`) escono come eccezioni: un file a metà non viene
  ripristinato.

## Non fa

- Non tocca i file con logica: restano da pulire a mano.
- Non conosce le lingue né i moduli: lavora sulla cartella che riceve (il comando sceglie i moduli).
- Non impedisce che i segnaposto tornino: lo garantisce `AutoLabelAction` (LANG-AUTOLABEL-INV-2).
- Non fa backup: usarla su un albero sotto git e controllare il diff.
