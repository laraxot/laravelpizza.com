---
title: "ADR — Le chiavi di traduzione mancanti si scrivono nei file solo in ambiente locale"
type: decision
status: accepted
module: Lang
tags: [adr, lang, translations, runtime-write, testing, production]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../../app/Actions/SaveTransAction.php
  - ../../app/Actions/Filament/AutoLabelAction.php
  - ../contracts/save-trans-action.md
  - ../../tests/Feature/SaveTransActionDefaultTest.php
---

# ADR: le chiavi di traduzione mancanti si scrivono nei file solo in ambiente locale

## Contesto

- `AutoLabelAction` gira su ogni componente Filament creato e, se l'etichetta manca, chiede a `SaveTransAction` di
  scriverla nel file PHP di lingua del modulo: comodo in sviluppo, la chiave compare pronta da tradurre.
- Il default era «acceso, tranne sotto test». In produzione un file di lingua riscritto a runtime può restare a metà o con
  una riga appesa dopo `return [];`: un errore di sintassi in un file di lingua manda in 500 ogni pagina che lo carica.
- Sotto test la suite passa su migliaia di etichette: per due volte ha riscritto i file di lingua dell'albero di lavoro,
  lasciando in `git status` modifiche che nessuno aveva fatto (commento in `tests/Feature/SaveTransActionRespectsSwitchTest.php`).
- Il pannello di traduzione deve invece poter salvare in produzione: lì la scrittura è voluta.

Domanda: quando un'etichetta mancante può diventare una scrittura su file?

## Decisione

- `SaveTransAction::execute()` scrive solo se `Config::get('lang.save_missing_translations', app()->isLocal())` è `true`:
  di default solo con `APP_ENV=local`; la chiave, se impostata a `true` o `false`, vince sempre.
- `SaveTransAction::persist()` scrive senza interruttore ed è il solo ingresso usato dal pannello
  (`TranslationFileResource/Pages/EditTranslationFile.php`).
- `AutoLabelAction` chiede di salvare solo le etichette (`label`), mai placeholder, testi d'aiuto o descrizioni: il loro
  «valore di comodo» era il nome del campo, finito a schermo in produzione. I residui si tolgono con
  `php artisan lang:clean-placeholders` (`CleanPlaceholderTranslationsAction`).

## Alternative scartate

- Default «acceso tranne sotto test» (`! app()->runningUnitTests()`): era la situazione dei 500 in produzione.
- Default nella config del modulo (`config/lang.php`): la config del modulo non è caricata con il nome `lang`, quindi un
  default preso solo da lì restava acceso proprio dove doveva essere spento.
- Chiavi mancanti solo nel DB (`RecordMissingTranslationAction` via `TranslatorAdapter`): nessun file toccato, ma il
  traduttore custom non è registrato (`registerTranslator()` commentato in `LangServiceProvider::boot()`) e le
  traduzioni del progetto vivono nei file, non nel DB.
- Nessuna scrittura automatica: in sviluppo ogni etichetta nuova va aggiunta a mano a quattro lingue, e si scopre tardi.

## Conseguenze

- Pro: produzione, staging e test non riscrivono mai i sorgenti; in locale chi sviluppa vede comparire le chiavi.
- Contro: in locale i file di lingua cambiano da soli: il diff va riletto prima del commit (le chiavi salvate hanno come
  valore il nome del campo, da tradurre).
- Debito: `config/lang.php` dichiara ancora `'save_missing_translations' => true` con un commento che cita il vecchio
  default (`! app()->runningUnitTests()`); non ha effetto, ma inganna chi lo legge.

## Verifica

- `cd laravel && vendor/bin/pest Modules/Lang/tests/Feature/SaveTransActionDefaultTest.php Modules/Lang/tests/Feature/SaveTransActionRespectsSwitchTest.php`:
  nessuna scrittura in produzione, staging e test senza configurazione; scrittura in locale; la configurazione vince;
  `persist()` scrive anche a interruttore spento (group `LANG-SAVETRANS-INV-1` … `-5`).
- `vendor/bin/pest Modules/Lang/tests/Feature/AutoLabelActionContractTest.php --group=LANG-AUTOLABEL-INV-2`: solo le
  etichette mancanti vengono proposte al salvataggio.
