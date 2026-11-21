---
title: "Translator — Adapter invece di Service"
type: concept
tags: [lang, translation, adapter, migration]
created: 2026-07-13
updated: 2026-07-13
qmd: "Lang TranslatorService TranslatorAction adapter not QueueableAction"
issues:
  - "https://github.com/laraxot/base_ptvx_fila5/issues/372"
discussions:
  - "https://github.com/laraxot/base_ptvx_fila5/discussions/273"
related:
  - ../../../../docs/wiki/rules/no-services-rule.md
  - lang-services-to-actions.md
---

# Lang — `TranslatorService` → `TranslatorAction`

> **2026-10-08 (superata).** `app/Actions/TranslatorAction.php` e' stata eliminata: era la terza copia di
> `Adapters/TranslatorAdapter` (stesso `get()`, nessun chiamante di produzione, solo tre test che la istanziavano e che ora
> usano l'adapter). L'implementazione e' `Modules\Lang\Adapters\TranslatorAdapter` (delega a
> `Actions/Translation/RecordMissingTranslationAction`); i riferimenti a `TranslatorAction` qui sotto sono storici.
> Attenzione: in `LangServiceProvider::boot()` la riga `$this->registerTranslator();` e' commentata, quindi nel runtime
> `app('translator')` e' oggi il `Illuminate\Translation\Translator` di serie e l'adapter non e' attivo.
> Story: [2026-10-08-dead-code-sweep-lang](../../stories/2026-10-08-dead-code-sweep-lang.story.md).

## Perché non è una QueueableAction di dominio

`TranslatorAction` **estende** `Illuminate\Translation\Translator`. È un adapter framework registrato come singleton `translator` — non ha un singolo `execute()` di dominio, ha `get()` per soddisfare il contratto del translator di Laravel.

## Path

`app/Actions/TranslatorAction.php`

Binding: `LangServiceProvider::registerTranslator()` e `Providers\Traits\TranslatorTrait::registerTranslator()`.

## Comportamento

Su chiave mancante: `notifyMissingKey()` delega a `Modules\Lang\Actions\Translation\RecordMissingTranslationAction::execute()`, che fa `Translation::firstOrCreate()` per tracciamento in DB (pattern translation-manager). Vedi [lang-services-to-actions.md](lang-services-to-actions.md) per il mapping completo.

## Nota storica

Due varianti sperimentali (`app/Adapters/TranslatorAdapter.php`, `app/Adapters/Translation/DatabaseAwareTranslator.php`) erano rimaste come dead code da un run interrotto precedente, mai bindate da nessun provider: rimosse. L'unica implementazione attiva è `Modules\Lang\Actions\TranslatorAction`.
