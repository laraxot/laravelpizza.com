---
title: "Architettura — Lang"
type: architecture
status: review
updated: 2026-11-16
module: Lang
qmd: "architettura Lang AutoLabelAction configureUsing SaveTransAction TranslationFile Sushi TranslatorAdapter LangBasePolicy flussi autorizzazione verificata sul codice"
related:
  - ./purpose.md
  - ./audits/lang-audit.md
  - ./decision-log.md
  - ../purpose.md
<<<<<<< HEAD
<<<<<<< HEAD
  - ../italian-text-refined-audit-report.md
=======
<<<<<<< .merge_file_DANC9m
=======
  - ../italian-text-refined-audit-report.md
>>>>>>> .merge_file_cU7Cza
>>>>>>> laraxot/dev
=======
  - ../italian-text-refined-audit-report.md
>>>>>>> laraxot/dev
---

# Architettura — Lang

Verificata sul codice il 2026-11-16 (72 PHP in `app/`, 0 Services). Sostituisce la versione precedente, che citava `ValidateTranslationsAction`, `LangResource` e `lang_table`: **nessuno dei tre esiste** ([audit P1-2](./audits/lang-audit.md#p1-2--documentazione-che-contraddice-il-codice)). Scopo: [purpose.md](./purpose.md).

## Componenti reali

| Strato | Elementi |
|---|---|
| Provider | `LangServiceProvider` (`boot` → `translatableComponents()`, `registerFilamentLabel()`), `EventServiceProvider` (`$listen` vuoto), `RouteServiceProvider`; `TranslatorTraitPhpstanProbe` (solo per PHPStan) |
| Risoluzione etichette | `Actions/Filament/AutoLabelAction` applicata da `configureUsing` a Field, Entry, Section, Column, BaseFilter, Step, Action |
| Lettura/scrittura file di lingua | `GetTransPathAction`, `SaveTransAction` (`execute` filtrato, `persist` diretto), `SaveArrayAction` (Xot); morte: `WriteTranslationFileAction`, `ReadTranslationFileAction` |
| Pannello | `TranslationFileResource` (modello Sushi `TranslationFile`), `LocaleSwitcherRefresh`, `LanguageSwitcherWidget`, `View/Components/LanguageSwitcher` |
| Locale | `ResolveTranslatableLocalesAction`, `ResolveDefaultTranslatableLocaleAction`, `ListLocaleOptionsAction`, `Datas/LangConfigData` |
| DB | `Translation`, `LanguageLine`, `Post` (11 migration, 3 generazioni) — non scritte in produzione dal modulo (vedi P1-1) |
| Tracker DB (non cablato) | `Adapters/TranslatorAdapter` → `Actions/Translation/RecordMissingTranslationAction` |

## Flussi

1. **Etichetta.** Componente Filament creato → `configureUsing` → `AutoLabelAction::execute($component, 'label'|'placeholder'|…)`: costruisce `<modulo>::<risorsa>.fields.<campo>.<tipo>`, `trans()`; se manca, per la sola `label` chiama `SaveTransAction::execute` (scrive solo in `local`); se la traduzione non è stringa imposta `'FIX:'.$key` (`AutoLabelAction.php:139`) per rendere visibile il buco.
2. **Modifica da pannello.** `EditTranslationFile::mutateFormDataBeforeSave` → `SaveTransAction::persist($key, $content)` → `GetTransPathAction` (`<lang-path>/<locale>/<file>.php`, locale da `app()->getLocale()`) → `SaveArrayAction`. Scrittura voluta anche in produzione.
3. **Cambio lingua.** `LocaleSwitcherRefresh` → `applyLocale()`: `session('locale')` + `App::setLocale`.

<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< .merge_file_DANC9m
**Models:** `BaseModelLang`, `LanguageLine`, `Translation`.
**Actions:** `SyncTranslationsAction`, `ValidateTranslationsAction`.
**Filament Resources:** `LangResource` — main admin resource.

**Database Schema:** `lang_table` — tabella primaria con colonne standard Laravel (id, timestamps).
=======
>>>>>>> .merge_file_cU7Cza
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
## Autorizzazione

`LangBasePolicy::before()` → `true` per `super-admin` e `lang::admin` (bypass voluto, ADR Xot module-admin-role-policy-bypass); `TranslationFilePolicy`, `TranslationPolicy`, `PostPolicy` ereditano e decidono per permesso (es. `translation_file.viewAny` in `TranslationFilePolicy`; deny-by-default). Nessun `return true` fuori da `before()`.

## Confini e dipendenze

- Dipende da Xot. Usato (file con `use Modules\Lang\`, no test) da Xot 7, Notify 5, Performance 3, IndennitaResponsabilita 1, UI 1. **Non da Activity.**
- Config: `config/config.php` è letta; `config/lang.php` è caricata come `lang.lang.*` e non letta da nessuno ([P2](./audits/lang-audit.md#p2)).

## Pattern

Logica in Spatie Queueable Action (16 + `AutoLabelAction`), nessun Service, estensione di `XotBaseResource`, `strict_types` ovunque.

## Decisioni collegate

[decision-log.md](./decision-log.md): D-1 (config morta), D-2 (tracker DB), D-3 (`Post`).
