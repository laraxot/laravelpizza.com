---
title: "Contratto — AutoLabelAction"
type: contract
<<<<<<< .merge_file_3gTbAL
<<<<<<< HEAD
=======
>>>>>>> .merge_file_KlZJQP
action: "Modules\Lang\Actions\Filament\AutoLabelAction"
tags: [contract, action, filament, translations, labels]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../adr/filament-labels-from-module-translation-files.md
  - ../../app/Actions/Filament/AutoLabelAction.php
  - ../../app/Providers/LangServiceProvider.php
  - ../../tests/Feature/AutoLabelActionContractTest.php
<<<<<<< .merge_file_3gTbAL
=======
owner: Lang
status: accepted
updated: 2026-11-24
action: "Modules\\Lang\\Actions\\Filament\\AutoLabelAction"
qmd: "AutoLabelAction etichetta automatica Filament componente chiave traduzione chiamante stack debug_backtrace label helperText icon LANG-AUTOLABEL"
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_KlZJQP
---

# AutoLabelAction

<<<<<<< .merge_file_3gTbAL
<<<<<<< HEAD
=======
>>>>>>> .merge_file_KlZJQP
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
<<<<<<< .merge_file_3gTbAL
=======
Applica al componente Filament l'etichetta (o helper text, placeholder, icona) presa dal file di lingua, con chiave derivata dalla classe chiamante. Codice: `app/Actions/Filament/AutoLabelAction.php:24-267`.

## Input

- `Field|Entry|BaseFilter|Column|Step|Action|Section $component`.
- `string $type = 'label'`: nome del metodo Filament da chiamare (`label`, `helperText`, `icon`, ...).

## Output

- Lo stesso `$component`, modificato o no.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `LANG-AUTOLABEL-INV-1` | La chiave base viene dalla prima classe `Modules\*` non astratta dello stack (`findCallerFrame`, righe 61-90) tramite `GetTransKeyAction`. Senza chiamante: `lang::txt`. Cambiare lo stack cambia i nomi dei file di lingua. | Fixture `tests/Fixtures/AutoLabelNullCallerStub.php`, `AutoLabelForcedKeyStub.php`, `AutoLabelStaticCaller.php`, `AutoLabelExecuteNestedCaller.php`; riferimenti in `LangCoverageGapsTest.php`, `LangFinalGapsTest.php`. |
| `LANG-AUTOLABEL-INV-2` | Componente senza padrone identificabile: restituito senza alcuna scrittura (righe 116-141). | Stessa fixture `AutoLabelNullCallerStub`. |
| `LANG-AUTOLABEL-INV-3` | Per `type` diverso da `label` e `icon` (testo d'aiuto, placeholder, descrizione) il valore di default e' vuoto e non viene persistito (righe 191-193, 200). | Test: nessuno dedicato. |
| `LANG-AUTOLABEL-INV-4` | Sezione senza titolo: segmento `sections.empty.label`, valore salvato vuoto (righe 160-167). | Test: nessuno dedicato. |

## Effetti collaterali

- Persiste la chiave mancante solo per `type = label`, tramite `SaveTransAction` (che scrive solo se il gate e' attivo).
- `SvgExistsAction` per le icone: lettura filesystem.
- `debug_backtrace()` ad ogni chiamata: costo runtime.

## Errori

- Nessun `try`. `new \ReflectionClass($class)` lancia se la classe non esiste (riga 80). `Assert::string` lancia su label di Step o nome non stringa.
- Un'etichetta non stringa diventa `label('FIX:<chiave>')` (riga 212).

## Non fa

- Non valida `$type`: il nome del metodo viene usato dinamicamente.
- Il numero `2` in `array_slice` (riga 64) e' magico: sostituirlo con un criterio cambia le chiavi, quindi i file su disco. Il docblock lo dice esplicitamente.
- Non traduce il valore di default: lo salva com'e'.
- Registrazione: `Providers/LangServiceProvider.php`.
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_KlZJQP
