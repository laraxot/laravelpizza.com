---
title: "[STORY] Services -> Actions nel modulo Lang (TranslatorService)"
type: story
status: done
priority: medium
created: 2026-10-08
updated: 2026-10-08
module: Lang
tags: [bmad, services, queueable-actions, no-services-rule, translator, adapter, cleanup]
qmd: "lang TranslatorService residuo TranslatorAdapter RecordMissingTranslationAction translator singleton"
related:
  - ./lang-services-to-actions.story.md
  - ../../../../bmad-output/epic-code-standards-services-mixed-const.md
  - ../../../../bashscripts/ai/wiki/rules/no-services-rule.md
---

# Services -> Actions nel modulo Lang

## Richiesta

Ordine permanente (2026-10-08): nessun `app/Services` ne' classe `*Service`; ogni use case e' una Queueable Action con
tutti i chiamanti aggiornati.

## Analisi (lo scopo, non il messaggio)

`Services/TranslatorService` (commit `f80d2ee6`, 2026-10-07) estendeva `Illuminate\Translation\Translator`: quando una
chiave manca registra la riga in `Translation` (pattern barryvdh/translation-manager) e riprova col fallback. Aveva un
`use QueueableAction` e un `execute(): void {}` vuoto solo per sembrare un'Action.

Lo scopo e' gia' coperto da due pezzi:

- `Adapters/TranslatorAdapter`: estensione del Translator Laravel legata al container (`translator`) da
  `LangServiceProvider::registerTranslator()` e da `Providers/Traits/TranslatorTrait`. Un Translator non puo' essere una
  Action (e' il servizio del framework), per questo vive in `Adapters/` con l'eccezione documentata nel file.
- `Actions/Translation/RecordMissingTranslationAction`: la business logic di `notifyMissingKey()`.

Chiamanti di `TranslatorService`: nessuno nel codice. Il suo test (`tests/Unit/Services/TranslatorServiceTest.php`)
non lo istanziava: chiede `app('translator')` e verifica che una chiave mancante torni se stessa, quindi in realta'
copre `TranslatorAdapter`.

## Modifiche

- Eliminato (recuperabile da `HEAD` di `Modules/Lang`): `app/Services/TranslatorService.php`; directory
  `app/Services/` rimossa.
- Nessun chiamante da aggiornare; nessuna `const` nel perimetro. Il test resta: verifica il translator vero.

## Verifica

- `rg TranslatorService` / `Modules\Lang\Services` su `laravel/Modules`, `Themes`, `app`, `config`, `routes`,
  `resources`, `tests` (esclusi docs/vendor): resta solo l'etichetta del `describe()` nel test e una riga di
  CHANGELOG storico.
- PHPStan (`phpstan.neon`, da `laravel/`) su `Modules/Lang/app/Adapters`: `[OK] No errors` (esecuzione unica per i cinque moduli, dettaglio nella story Media).

## Aperto

- `app/Actions/TranslatorAction.php` estende anch'essa `Illuminate\Translation\Translator` (terza copia dello stesso
  codice, nominata "Action"). Fuori perimetro: da confrontare con `TranslatorAdapter` e consolidare.
- `tests/Unit/Services/TranslatorServiceTest.php` andrebbe rinominato in `TranslatorAdapterTest` (non fatto per
  non toccare file fuori perimetro).
