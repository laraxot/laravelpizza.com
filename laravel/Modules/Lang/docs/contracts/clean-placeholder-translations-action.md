---
title: "Contratto — CleanPlaceholderTranslationsAction"
type: contract
<<<<<<< .merge_file_rAFkqa
<<<<<<< HEAD
=======
>>>>>>> .merge_file_t1H45M
action: "Modules\Lang\Actions\CleanPlaceholderTranslationsAction"
tags: [contract, action, translations, lang-files, cleanup]
created: 2026-11-24
updated: 2026-11-24
related:
  - auto-label-action.md
  - ../../app/Actions/CleanPlaceholderTranslationsAction.php
  - ../../app/Console/Commands/CleanPlaceholderTranslationsCommand.php
  - ../../tests/Feature/CleanPlaceholderTranslationsActionTest.php
<<<<<<< .merge_file_rAFkqa
=======
owner: Lang
status: accepted
updated: 2026-11-24
action: "Modules\\Lang\\Actions\\CleanPlaceholderTranslationsAction"
qmd: "CleanPlaceholderTranslationsAction segnaposto helper_text placeholder label uguale al nome campo file lingua pulizia LANG-CLEAN"
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_t1H45M
---

# CleanPlaceholderTranslationsAction

<<<<<<< .merge_file_rAFkqa
<<<<<<< HEAD
=======
>>>>>>> .merge_file_t1H45M
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
<<<<<<< .merge_file_rAFkqa
=======
Toglie dai file di lingua le traduzioni segnaposto (uguali al nome del campo che le contiene). Codice: `app/Actions/CleanPlaceholderTranslationsAction.php:24-147`.

## Input

- `string $directory`: radice da scandire ricorsivamente. Se non e' una directory, nessun effetto.
- `bool $dryRun = false`: se vero, calcola senza scrivere ne' cancellare.

## Output

- `array{files: list<string>, removed: int}`: percorsi dei file toccati (o da toccare) e numero di voci rimosse. Le voci svuotate dalla pulizia contano anche loro.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `LANG-CLEAN-INV-1` | Un file che non e' solo dati (`isPureData()` falso: variabili, funzioni, `new`, `use`, operatori, stringhe interpolate) non viene mai riscritto (righe 57-59). | `tests/Feature/CleanPlaceholderTranslationsActionTest.php:15` (titolo: «toglie i segnaposto uguali al nome del campo e lascia le traduzioni vere»). |
| `LANG-CLEAN-INV-2` | Rimuove solo chiavi in `PLACEHOLDER_TYPES` (`helper_text`, `placeholder`, `description`, `tooltip`, `label`, `heading`, `hint`) il cui valore stringa e' uguale alla chiave padre stringa. Le chiavi della radice del file non vengono mai ripulite (`parent` nullo). | Stesso test, :15. |
| `LANG-CLEAN-INV-3` | Con `dryRun` non scrive ne' cancella; i conteggi restituiti sono quelli che la run reale produrrebbe. | Test: nessuno. |
| `LANG-CLEAN-INV-4` | Directory inesistente: `['files' => [], 'removed' => 0]`. | Test: nessuno. |

## Effetti collaterali

- Per ogni `.php` valido: riscrittura del file con `file_put_contents` in forma `<?php\n\ndeclare(strict_types=1);\n\nreturn [...];\n` (riga 72). Commenti e formattazione originali si perdono.
- File chiamato esattamente `.php` (senza nome): cancellato con `unlink` (riga 51), senza dryRun.
- Nessun backup, nessuna transazione, nessuna cache toccata.

## Errori

- Le funzioni `Safe\file_get_contents`, `Safe\file_put_contents`, `Safe\unlink` lanciano `Safe\Exception` su errore I/O: nessuna gestione locale.
- `include` di un file di soli dati non e' protetto da `try`.

## Non fa

- Non crea backup prima di riscrivere.
- Non tocca file che contengono codice, anche se contengono traduzioni.
- Chiamante verificato: `Console/Commands/CleanPlaceholderTranslationsCommand.php`.
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_t1H45M
