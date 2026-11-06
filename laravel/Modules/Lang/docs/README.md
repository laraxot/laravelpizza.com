---
title: "Lang: README"
type: note
tags: [documentation, lang, translations, filament, autolabel]
created: 2026-09-26
updated: 2026-10-14
qmd: "lang module readme autolabel savetransaction save_missing_translations translator adapter"
issues: []
discussions: []
status: active
---

# Lang

Modulo Laraxot `Modules\Lang` (alias `lang`, priorita' 4 in `module.json`). Verificato sul codice il 2026-10-14. Il testo precedente di questo README (Services/TranslationService, trait `HasTranslator`, chiamate statiche `Action::execute([...])`, config in `laravel/config/local/lang/config.php`, `trans_has()`) descriveva classi e file che non esistono ed e' stato sostituito.

## Cosa fa davvero

1. **Etichette automatiche per Filament.** `Providers\LangServiceProvider::registerFilamentLabel()` registra `configureUsing` su `Select`, `Field`, `Entry`, `Section`, `BaseFilter`, `Column`, `Step` e `Action`. Ognuno passa da `Actions\Filament\AutoLabelAction`, che ricava dalla classe chiamante la chiave `<modulo>::<file>.fields|sections|steps|actions.<nome>.<label|placeholder|helper_text|description|icon|tooltip>`, chiama `trans()` e, se la chiave non esiste, la scrive. Per questo nel codice non si usa `->label()` (vedi [filament-label.md](./filament-label.md)).
2. **Scrittura dei file di lingua.** `Actions\SaveTransAction` aggiunge la chiave a `Modules/<Modulo>/lang/<locale>/<file>.php` (percorso da `GetTransPathAction`), con il nome del componente come valore. La chiamano `AutoLabelAction`, `Xot\Filament\Traits\NavigationLabelTrait`, `Xot\Filament\Traits\TransFuncTrait` e la pagina Filament `EditTranslationFile`.
3. **Editor delle traduzioni nel pannello.** `Filament\Resources\TranslationFileResource` (modello Sushi `Models\TranslationFile`), campi `TranslationEditor` e `NationalFlagSelect`, widget `LanguageSwitcherWidget`, componenti Blade `Flag` e `LanguageSwitcher`, `View\Composers\ThemeComposer`.
4. **Action di servizio sui file**: `ReadTranslationFileAction(string $filePath)`, `WriteTranslationFileAction(string $filePath, array $translations): bool` (fa un backup prima), `SyncTranslationsAction($sourceLang = 'it', $targetLangs = ['en','de'], $specificModule = null)`, `MergeTranslationsAction`, `PublishTranslationAction`, `GetAllTranslationAction`, `GetAllModuleTranslationAction`, `TransArrayAction`, `TransCollectionAction`. Sono `QueueableAction`: si istanziano con `app(...)->execute(...)`, non sono statiche.
5. **Modelli**: `Translation`, `LanguageLine`, `Post` (con tabella `translations`), `TranslationFile` (Sushi, nessuna tabella). Migration: `language_lines`, `posts` e `translations` (le ultime due compaiono due volte, con date 2026-01-21 e 2026-08-06: da verificare prima di migrare).

## Attenzione: chi scrive i file di lingua

- Il trigger e' la catena Filament sopra, **non** `__()` o `trans()` da soli. A runtime `app('translator')` e' `Illuminate\Translation\Translator` (tinker, 2026-10-14): `Adapters\TranslatorAdapter` (che registrerebbe le chiavi mancanti nel DB con `RecordMissingTranslationAction`) non e' agganciato, perche' in `LangServiceProvider::boot()` la riga `registerTranslator()` e' commentata e il trait `TranslatorTrait` non e' usato da nessun provider. Quindi oggi una chiave mancante letta con `__()` non crea righe nel DB.
- Interruttore: `SaveTransAction` scrive solo se `Config::get('lang.save_missing_translations', ! app()->runningUnitTests())` e' `true`. `config/lang.php` lo imposta a `true`, ma `config('lang.save_missing_translations')` restituisce `NULL` a runtime (tinker, 2026-10-14): vale il valore di ripiego, cioe' **acceso fuori dai test**. Per spegnerlo in un processo: `config(['lang.save_missing_translations' => false])` (lo fa `Modules/Fixcity/tests/Unit/DcFieldViewsTest.php`).
- Effetto da conoscere: una pagina del front office con campi Filament privi di chiave aggiunge voci segnaposto e puo' creare file vuoti per altre lingue; dopo le prove nel browser controllare `git status` e fare `php -l` sui file di lingua toccati. Un file `return [];` puo' ricevere la riga fuori dall'array (parse error): memoria `lang-autowriter-corrupts-empty-lang-files`.
- Con una chiave presente solo in `it` il ripiego su `it` nasconde la traduzione mancante nelle altre lingue.

## Lingue

Il modulo dichiara `it`, `en`, `de` (`config/lang.php`: `default_locale`, `fallback_locale = 'en'`, `available_locales`). Le lingue pubblicate dal sito vengono da `laravel/config/laravellocalization.php`: a runtime `de,en,es,it`, con `app.locale` e `app.fallback_locale` entrambi `it` (tinker, 2026-10-14). Il modulo ha i file `lang/de|en|it`, non `es`.

## Cosa NON c'e' (verificato 2026-10-14)

- Nessuna rotta (`routes/web.php` e `routes/api.php` vuoti) e nessun comando Artisan del modulo (`lang:publish` e' del framework).
- Nessun `app/Services`, nessun `app/Traits`, nessuna cartella `resources/lang`.
- Nessuna traduzione automatica con motori esterni: la chiave `auto_translate` esiste in `config/lang.php`, nessun file in `Modules/*/app`, `Themes/*/app`, `app/` o `config/` la legge (grep 2026-10-14).

## Test

26 file PHP in `tests/` (Unit: Actions, Adapters, Filament, Models, Providers, View; Feature: `SaveTransActionRespectsSwitchTest`, `LangBusinessLogicTest`). Non eseguiti in questa verifica: `SaveTransAction` scrive nei file di lingua dell'albero di lavoro. Per lanciarli: `bash bashscripts/tools/pest-scratch-db.sh Modules/Lang/tests/Unit/Actions` dalla root del repo, con `APP_CONFIG_CACHE=/nonexistent/config.php` e `DB_DATABASE_LIMESURVEY=` (vedi la nota `pest-scratch-db-needs-config-cache-bypass`), poi `git status` sui lang.

## Dove leggere

Indice: [00-INDEX.md](./00-INDEX.md). Wiki: [wiki/index.md](./wiki/index.md). Story: [stories/](./stories/). Cronologia: [wiki/log.md](./wiki/log.md).

## Dipendenze / Moduli Correlati

- [Xot - Framework Base](../../Xot/docs/README.md): Always dependency
- [User - Authentication](../../User/docs/README.md): For user-facing strings
- [Cms - Content](../../Cms/docs/README.md): For content translations
- [Notify - Notifications](../../Notify/docs/README.md): For email translations

## Documenti Correlati

- [PHPStan Configuration](../../../phpstan.neon)

## Regole Critiche

1. **Always extend Xot base classes**: Never extend Laravel/Filament directly
2. **Use namespace `Modules\Lang`**: Never `app\Lang`
3. **Strict typing**: `declare(strict_types=1);` in all files
4. **One source of truth**: Store translations centrally, not scattered
5. **Cache translations**: Use Laravel cache for performance
6. **Publish before deploy**: Publish translations to resources/lang/
7. **No Log statements**: Let Laravel handle exceptions

## Standard Rules & Workflow

- [[BMAD Method](../../../../bashscripts/ai/wiki/concepts/bmad-method.md)]
- [[Context Engineering](../../../../bashscripts/ai/wiki/concepts/context-engineering.md)]
- [[LLM Wiki Governance](../../../../bashscripts/ai/wiki/concepts/llm-wiki-governance.md)]

---
**Status**: ✅ Production  
**Last Updated**: 2026-07-14  
**Requirements**: PHP 8.3+, Laravel 13  
**PHPStan Level**: 10 (Compliant)
**Ultima verifica**: 2026-10-14 (Laravel 13.35.0, PHP 8.4.26). Il livello PHPStan non e' stato rimisurato in questa verifica.
---
Documentation should be:
- Clear and concise
- Example-driven
- Updated with code changes
- Use Markdown format (.md)
