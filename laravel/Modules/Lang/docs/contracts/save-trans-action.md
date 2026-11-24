---
title: "Contratto — SaveTransAction"
type: contract
<<<<<<< HEAD
action: "Modules\Lang\Actions\SaveTransAction"
tags: [contract, action, translations, lang-files]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../adr/missing-translations-written-only-in-local.md
  - ../../app/Actions/SaveTransAction.php
  - ../../tests/Feature/SaveTransActionDefaultTest.php
  - ../../tests/Feature/SaveTransActionRespectsSwitchTest.php
=======
owner: Lang
status: accepted
updated: 2026-11-24
action: "Modules\\Lang\\Actions\\SaveTransAction"
qmd: "SaveTransAction salva chiave traduzione file lingua save_missing_translations isLocal persist pannello Lang LANG-SAVE"
>>>>>>> laraxot/dev
---

# SaveTransAction

<<<<<<< HEAD
Scrive una chiave di traduzione nel file PHP di lingua del modulo. Due ingressi con regole diverse:

- `execute()`: la chiamano `AutoLabelAction` quando un'etichetta manca; scrive solo se l'interruttore lo permette.
- `persist()`: la chiama il pannello di traduzione (`TranslationFileResource/Pages/EditTranslationFile.php`) quando il
  traduttore preme «Salva»; scrive sempre.

Perché l'interruttore: [ADR chiavi mancanti scritte solo in locale](../adr/missing-translations-written-only-in-local.md).
Sorgente: `app/Actions/SaveTransAction.php`.

Test: `cd laravel && vendor/bin/pest Modules/Lang/tests/Feature/SaveTransActionDefaultTest.php Modules/Lang/tests/Feature/SaveTransActionRespectsSwitchTest.php`.

## Input

| Parametro | Tipo | Note |
|---|---|---|
| `$key` | `string` | chiave completa `modulo::file.percorso.nel.file` (es. `blog::article.fields.title.label`) |
| `$data` | `array\|int\|string\|Htmlable\|null` | valore da scrivere in quel punto |

Il file è risolto da `GetTransPathAction`: `<cartella lang del modulo>/<locale corrente>/<file>.php`.
Interruttore: `Config::get('lang.save_missing_translations', app()->isLocal())`.
=======
Scrive una chiave di traduzione nel file di lingua del modulo. Codice: `app/Actions/SaveTransAction.php:14-93`. Due ingressi: `execute` (filtrato) e `persist` (pubblico, non filtrato).

## Input

- `string $key`: `<modulo>::<gruppo>.<voce>...`.
- `int|string|array|Htmlable|null $data`: valore da scrivere.
>>>>>>> laraxot/dev

## Output

- `void`.

## Invarianti

<<<<<<< HEAD
| ID | Regola | Group Pest |
|---|---|---|
| LANG-SAVETRANS-INV-1 | Senza configurazione esplicita `execute()` non scrive fuori da `APP_ENV=local`: né in produzione, né in staging, né sotto test. | `LANG-SAVETRANS-INV-1` |
| LANG-SAVETRANS-INV-2 | Senza configurazione esplicita, in `local` `execute()` scrive la chiave nel file, con la struttura annidata del percorso. | `LANG-SAVETRANS-INV-2` |
| LANG-SAVETRANS-INV-3 | `lang.save_missing_translations` impostata (`true` o `false`) vince sempre sull'ambiente. | `LANG-SAVETRANS-INV-3` |
| LANG-SAVETRANS-INV-4 | `persist()` scrive anche con l'interruttore spento: il salvataggio dal pannello funziona in produzione. | `LANG-SAVETRANS-INV-4` |
| LANG-SAVETRANS-INV-5 | Aggiungere una chiave conserva tutte le altre del file (lettura, `Arr::set`, riscrittura). | `LANG-SAVETRANS-INV-5` |
| LANG-SAVETRANS-INV-6 | Un file di lingua esistente ma illeggibile (`getRequire` lancia) non viene riscritto: l'errore va a `report()` e la chiave si perde. | — |

## Effetti collaterali

- Scrive (o crea vuoto e poi scrive) il file PHP di lingua tramite Xot `SaveArrayAction`, nell'albero dei sorgenti del
  modulo: in sviluppo il file compare in `git status`.

## Errori

- File illeggibile: `report($e)` e ritorno senza scrivere.
- Chiave senza percorso dopo il nome del file con `$data` non array: `\Exception('Error in SaveTransAction')`.
- Errori di scrittura di `SaveArrayAction` arrivano al chiamante.

## Non fa

- Non decide quale chiave manca: lo fa `AutoLabelAction` (solo per le etichette).
- Non registra le chiavi mancanti nel DB (`RecordMissingTranslationAction`, usata solo dal `TranslatorAdapter`, oggi non
  registrato: `registerTranslator()` è commentato in `LangServiceProvider::boot()`).
- Non fa backup, non valida la sintassi PHP e non svuota la cache delle traduzioni.
- Non scrive nei file di altre lingue: solo quella corrente (`app()->getLocale()`).
=======
| ID | Regola | Test |
|---|---|---|
| `LANG-SAVE-INV-1` | `execute` non scrive se `Config::get('lang.save_missing_translations', app()->isLocal())` non e' `true`. Default: solo ambiente `local`. | `tests/Feature/SaveTransActionDefaultTest.php:57-99`; `tests/Feature/SaveTransActionRespectsSwitchTest.php:20,33`. |
| `LANG-SAVE-INV-2` | `persist` scrive sempre, senza il filtro: e' il percorso del pannello «Salva». | Test: nessuno dedicato. |
| `LANG-SAVE-INV-3` | Se il file esistente non si carica (`\Exception`), `persist` segnala con `report()` e non scrive, per non sostituire il file con la sola chiave nuova. | Test: nessuno dedicato. |
| `LANG-SAVE-INV-4` | Il percorso di scrittura e' il primo segmento del gruppo; la chiave scritta e' tutto cio' che segue il primo segmento della chiave. Una chiave senza `.` sostituisce l'intero file con `$data`, e se `$data` non e' array lancia `Exception('Error in SaveTransAction')`. | Test: nessuno. |

Nota su INV-1: `Modules/Lang/config/lang.php:211` contiene `save_missing_translations => true`, ma `XotBaseServiceProvider::registerConfig()` (righe 181-195) registra i file di config come `lang.<nome file>`, cioe' `lang.lang`, non `lang.save_missing_translations`. Quindi il default letto e' `isLocal()`. Da verificare con `config('lang.save_missing_translations')` a runtime.

## Effetti collaterali

- Se il file non esiste: scrittura di un array vuoto via `SaveArrayAction`, poi lettura, poi scrittura del contenuto aggiornato (due scritture).
- Nessun backup, nessuna pulizia cache.

## Errori

- `\Exception('Error in SaveTransAction')` se il contenuto finale non e' array.
- `report()` su file illeggibile (silenzioso per il chiamante).
- Eccezioni di `SaveArrayAction` si propagano.

## Non fa

- Non valida la chiave.
- Chiamanti verificati: `Filament/Resources/TranslationFileResource/Pages/EditTranslationFile.php`, `Xot/app/Filament/Traits/TransFuncTrait.php`, `Xot/app/Filament/Traits/NavigationLabelTrait.php`, `Ptv/app/Filament/Resources/BaseSchedaResource.php`, `Performance/app/Filament/Resources/IndividualeResource.php`, e `Actions/Filament/AutoLabelAction.php`.
>>>>>>> laraxot/dev
