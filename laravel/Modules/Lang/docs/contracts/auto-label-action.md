---
title: "Contratto — AutoLabelAction"
type: contract
action: "Modules\Lang\Actions\Filament\AutoLabelAction"
tags: [contract, action, filament, translations, labels]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../adr/filament-labels-from-module-translation-files.md
  - ../../app/Actions/Filament/AutoLabelAction.php
  - ../../app/Providers/LangServiceProvider.php
  - ../../tests/Feature/AutoLabelActionContractTest.php
---

# AutoLabelAction

Dà a ogni componente Filament (campo, colonna, filtro, entry, step, sezione, azione) l'etichetta e i testi presi dal
file di lingua del modulo che lo usa. È applicata a **tutti** i componenti da `LangServiceProvider::registerFilamentLabel()`
con `configureUsing()`. Perché: [ADR etichette dai file di lingua](../adr/filament-labels-from-module-translation-files.md).
Sorgente: `app/Actions/Filament/AutoLabelAction.php`.

Test: `cd laravel && vendor/bin/pest Modules/Lang/tests/Feature/AutoLabelActionContractTest.php`.

## Input

| Parametro | Tipo | Note |
|---|---|---|
| `$component` | `Field\|Entry\|BaseFilter\|Column\|Step\|Action\|Section` | il componente appena creato |
| `$type` | `string` | `label` (default), `placeholder`, `helperText`, `description`, `heading`, `icon` |

La chiave nasce dalla classe chiamante: il primo frame del backtrace (saltati i primi due) di una classe `Modules\…`
concreta, tradotto da Xot `GetTransKeyAction` (es. `blog::article`); senza classe, `lang::txt`. Poi
`<chiave>.fields.<nome>.<tipo>` (`sections.<titolo>`, `steps.<etichetta>`, `actions.<nome>`), tipo in snake_case.

## Output

- Lo stesso componente, modificato sul posto.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| LANG-AUTOLABEL-INV-1 | Se la chiave esiste nel file di lingua del modulo chiamante, il suo valore diventa l'etichetta (o il testo del tipo chiesto). | `LANG-AUTOLABEL-INV-1` |
| LANG-AUTOLABEL-INV-2 | Una chiave mancante si chiede di salvarla (`SaveTransAction::execute`) solo per `label`: mai per placeholder, testo d'aiuto, descrizione; e quei testi restano vuoti. | `LANG-AUTOLABEL-INV-2` |
| LANG-AUTOLABEL-INV-3 | Un testo ausiliario (placeholder, helperText, …) uguale al nome del campo non si applica. | `LANG-AUTOLABEL-INV-3` |
| LANG-AUTOLABEL-INV-4 | Una sezione senza titolo usa il segmento `empty` ma salva il valore vuoto, mai la parola «empty». | — |
| LANG-AUTOLABEL-INV-5 | Un'azione la cui traduzione è uguale al nome (`edit`, `delete`) tiene l'etichetta già tradotta di Filament. | — |
| LANG-AUTOLABEL-INV-6 | Una traduzione che è un array, non una stringa, produce l'etichetta `FIX:<chiave>`, visibile, invece di un errore. | — |

## Effetti collaterali

- Chiama `SaveTransAction::execute()` per le etichette mancanti: scrive nel file di lingua solo dove l'interruttore lo
  permette (vedi il suo contratto).
- `debug_backtrace()` a ogni componente creato: costo misurabile nelle pagine con molte colonne.

## Errori

- Frame chiamante trovato ma senza classe: `\Exception('No object class found')`.
- Un `Step` o un campo senza nome stringa fa fallire `Webmozart\Assert`.

## Non fa

- Non traduce i testi passati esplicitamente con `->label('…')`: il `configureUsing` gira alla creazione, una
  `->label()` successiva vince. Per questo nelle Resource non si scrivono etichette a mano: si aggiunge la chiave al file.
- Non crea le chiavi di placeholder, helper text o descrizione: vanno scritte a mano nel file di lingua.
- Non pulisce i segnaposto salvati in passato: lo fa `CleanPlaceholderTranslationsAction`.
- Non è la classe omonima `Modules\Xot\Actions\Filament\AutoLabelAction`: quella non è registrata in `configureUsing`.
