---
issues: []
discussions: []
title: "Lang Services → Actions"
type: concept
tags: [lang, actions, queueable-action, translator, migration]
created: 2026-07-13
updated: 2026-07-13
qmd: "Lang module Services to QueueableAction translator missing-key mapping"
related:
  - queueable-action-trait-mandatory.md
  - translator-adapter-migration.md
  - no-app-support-queueable-actions.md
---

# Lang — `Services` → `Actions` (translator missing-key logic)

## Binding (non rotto)

Il singleton `translator` è definito in:

- `Modules\Lang\Providers\LangServiceProvider::registerTranslator()` (singleton → `Modules\Lang\Actions\TranslatorAction`)
- `Modules\Lang\Providers\Traits\TranslatorTrait::registerTranslator()` (extend → `Modules\Lang\Actions\TranslatorAction`)

`TranslatorAction` **deve** restare una sottoclasse di `Illuminate\Translation\Translator`
per soddisfare il contratto framework (eccezione documentata in
`no-app-support-queueable-actions.md`). Non è una QueueableAction di dominio: è un adapter.

## Mapping

| Sorgente (legacy `app/Services/TranslatorService.php`, ora `.bak`) | Destinazione | Pattern |
|---------------------------------------------------------------------|--------------|---------|
| custom `get()` (framework contract: chiama `parent::get()`)          | `Modules\Lang\Actions\TranslatorAction::get()` | mantenuto nell'adapter, serve `parent` |
| `notifyMissingKey()` (DB write: `Translation::firstOrCreate`)       | `Modules\Lang\Actions\Translation\RecordMissingTranslationAction::execute(string $key, string $locale)` | **QueueableAction** (`use QueueableAction;`, un solo `execute()`) |

`TranslatorAction::notifyMissingKey()` ora delega:

```php
protected function notifyMissingKey(string $key): void
{
    app(RecordMissingTranslationAction::class)->execute($key, (string) app()->getLocale());
}
```

La logica di parsing della chiave (`parseKey`) vive dentro la Action, così l'adapter
resta thin e la business logic è testabile in isolamento.

## Test

`Modules/Lang/tests/unit/actions/RecordMissingTranslationActionTest.php` (pest).
Prerequisito ambiente pre-esistente: il DB di test `database/database.sqlite`
deve esistere e avere la tabella `translations` (migrare il modulo Lang).
