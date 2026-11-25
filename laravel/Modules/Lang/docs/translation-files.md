---
title: "File di traduzione: lettura, scrittura, sincronizzazione"
type: reference
module: Lang
updated: 2026-11-25
qmd: "ReadTranslationFileAction WriteTranslationFileAction SaveTransAction SyncTranslationsAction PublishTranslationAction MergeTranslationsAction GetTransPathAction GetAllTranslationAction TransArrayAction RecordMissingTranslationAction TranslatorAdapter backup permessi lang"
related:
  - ./translation-keys.md
  - ./translation-file-editor.md
  - ./contracts/save-trans-action.md
  - ./contracts/write-translation-file-action.md
  - ./contracts/get-all-translation-action.md
---
# File di traduzione: lettura, scrittura, sincronizzazione

Le Action stanno in `Modules/Lang/app/Actions` (Spatie `QueueableAction`, metodo `execute()`). Le promesse di quelle con effetti collaterali sono
in [contracts/](contracts/README.md); qui la mappa e le note operative.

## Mappa delle Action

| Action | Cosa fa | Chi la usa oggi |
|---|---|---|
| `GetTransPathAction` | da `modulo::file.chiave` ricava `<cartella lang del modulo>/<locale corrente>/<file>.php` (cartella da `GetModulePathByGeneratorAction`, ripiego `Modules/<Modulo>/lang`) | `SaveTransAction` |
| `SaveTransAction` | `execute()`: scrive una chiave mancante, solo se `lang.save_missing_translations` lo permette (default: solo `local`); `persist()`: scrive sempre | `AutoLabelAction`; `persist()` da `EditTranslationFile` |
| `ReadTranslationFileAction` | `require` del file; lancia se manca, non e' leggibile o non ritorna un array; `toPhp()` serializza un array in sorgente PHP | `WriteTranslationFileAction` |
| `WriteTranslationFileAction` | backup, serializza, controlla la sintassi con `php -l`, scrive, svuota le cache | solo test |
| `SyncTranslationsAction` | copia le chiavi mancanti da una lingua sorgente (default `it`) alle lingue target (default `en`, `de`) per uno o tutti i moduli con cartella `lang` | solo test |
| `PublishTranslationAction` | imposta `item => value` nel file del gruppo descritto da `TranslationData`; scrive solo se qualcosa cambia | solo test |
| `MergeTranslationsAction` | `array_merge` di piu' array piatti: l'ultimo vince | solo test |
| `GetAllTranslationAction` / `GetAllModuleTranslationAction` | elenco `{key: modulo::file, path}` di `Modules/*/lang/<locale>/*.php`; **corpo identico** (duplicazione nota) | `TranslationFile` (Sushi) |
| `TransArrayAction` / `TransCollectionAction` | traducono una lista di voci con `<transKey>.<voce>.label`, poi `<transKey>.<voce con . => _>`, altrimenti la voce | esportazioni Xot (`XotBaseExporter`, `LazyCollectionExport`, `QueryExport`) |
| `RecordMissingTranslationAction` | registra una chiave mancante in `translations` (`firstOrCreate` su `lang`, `namespace`, `group`, `item`) | `TranslatorAdapter`, non attivo di default |
| `CleanPlaceholderTranslationsAction` | toglie dai file i testi uguali al nome del campo e i `.php` senza nome | comando `lang:clean-placeholders` |
| `GetTranslatableLocalesAction`, `GetDefaultTranslatableLocaleAction`, `ListLocaleOptionsAction` | lingue e opzioni dell'editor | editor e `SettingPage` ([translation-file-editor.md](translation-file-editor.md)) |

"Solo test": al momento della scrittura nessun `app/` di nessun modulo le richiama; sono API disponibili, coperte da test.

## Scrittura sicura

- **`SaveTransAction`**: legge il file con `File::getRequire`; se e' illeggibile segnala (`report()`) e **non** lo riscrive (altrimenti lo sostituirebbe con la sola chiave nuova);
  imposta il percorso con `Arr::set` sulla parte dopo `modulo::file`; crea il file se manca. Serializza con `SaveArrayAction` (formato `php`).
  Perche' solo in locale: in produzione un file riscritto a runtime puo' restare a meta e un file con errore di sintassi manda in 500 ogni pagina che lo carica;
  sotto test l'ambiente e' `testing`, quindi la suite non riscrive i file di lingua ([ADR 0007](adr/0007-missing-translations-written-only-in-local.md)).
  `lang.save_missing_translations` (true/false) vince sempre; `config/lang.php` del modulo dichiara `true` ma, come annotato nel codice, la config del modulo non e' caricata con quel nome: l'interruttore reale e' il default `local`.
- **`WriteTranslationFileAction`**: copia il file in `storage/app/backups/translations/<Y-m-d_H-i-s>_<nome>.php`; scrive il sorgente in un temporaneo in `storage/framework/cache` e lo valida con
  `php -l`; crea la cartella della lingua se manca; scrive; poi **`Cache::flush()` dell'intera cache** e flush del loader delle traduzioni. Lancia `Exception` se la sintassi non e' valida o se non riesce a scrivere.
- **`SyncTranslationsAction`**: non sovrascrive mai un valore gia' presente nella lingua target (aggiunge solo le chiavi mancanti, ricorsivamente), crea le cartelle target e riscrive i file
  (senza `declare(strict_types=1)`: l'effetto e' visibile in `git status`). Restituisce `total_modules`, `total_files`, `total_translations` e il dettaglio per modulo (`status`: `completed` o `skipped`
  se manca `lang/` o la lingua sorgente). I test che la eseguono su `Modules/Lang/lang/en` salvano e ripristinano la cartella (vedi [testing.md](testing.md)).

## Traduzioni mancanti nel database

`TranslatorAdapter` estende il translator di Laravel: quando `get()` restituisce la chiave stessa chiama `RecordMissingTranslationAction`; valori scalari (anche numeri in JSON) tornano come stringa, il resto
come chiave. Si attiva con `LangServiceProvider::registerTranslator()` o con il trait `Providers\Traits\TranslatorTrait` (`app->extend('translator', ...)`); in `boot()` la chiamata e' commentata.
La tabella `translations` e i modelli `Translation` e `LanguageLine`: vedi [migrations.md](migrations.md) e [model-translations.md](model-translations.md).

## Permessi del filesystem

I file di lingua devono essere scrivibili dall'utente PHP (tipicamente `www-data`). `Failed to open stream: Permission denied` in `SaveTransAction`/`WriteTranslationFileAction`
indica proprietario o permessi sbagliati sulla cartella `lang/<locale>` (file 664, cartelle 775, stesso proprietario dell'utente PHP). In sviluppo, con l'albero di lavoro di un altro utente, uniformare
proprieta' e permessi dopo modifiche manuali massive. Controllare anche che il filesystem non sia montato in sola lettura.

## Lingue sul filesystem

`Modules/Lang/lang/` ha `it`, `en`, `de`, `es`. `GetAllTranslationAction` legge la lingua della sessione (`locale`) se e' `it` o `en` (lista fissa) e imposta `app()->setLocale()`,
altrimenti usa la lingua corrente: l'elenco dei file e' quello di una sola lingua alla volta.
