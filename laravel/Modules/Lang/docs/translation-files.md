---
title: "File di traduzione: lettura, scrittura, sincronizzazione"
type: reference
module: Lang
updated: 2026-11-25
qmd: "ReadTranslationFileAction WriteTranslationFileAction SaveTransAction SyncTranslationsAction PublishTranslationAction MergeTranslationsAction GetTransPathAction GetAllTranslationAction TransArrayAction RecordMissingTranslationAction TranslatorAdapter backup permessi lang"
related:
  - ./translation-keys.md
  - ./translation-file-editor.md
  - ./adr/0007-missing-translations-written-only-in-local.md
---
# File di traduzione: lettura, scrittura, sincronizzazione

Le Action stanno in `Modules/Lang/app/Actions` (Spatie `QueueableAction`, metodo `execute()`). Qui la mappa, le garanzie e i limiti di quelle con effetti collaterali
(`SaveTransAction`, `WriteTranslationFileAction`, `GetAllTranslationAction`/`GetAllModuleTranslationAction`): le pagine `contracts/<action>.md` che li descrivevano sono state
assorbite in questa pagina; il formato dei contratti resta in [contracts/](contracts/README.md).

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
  Rifiuta una chiave senza nome file (`modulo::` o `modulo::.x`): segnala con `report()` e non scrive (`LANG-SAVETRANS-INV-6`). Era il difetto che creava `lang/it/.php` in 14 moduli: le azioni del
  menu utente (`profile`, `logout`) non sono classi `Modules\...`, quindi `GetTransKeyAction` risale al primo oggetto `Modules\...` nel backtrace, cioe' la pagina `Dashboard`, e il vecchio
  codice le toglieva il prefisso `dashboard` lasciando la chiave vuota (corretto in Xot, test `keeps dashboard as file key instead of emptying the slug`). La guardia resta come rete di sicurezza.
- **`WriteTranslationFileAction`**: copia il file in `storage/app/backups/translations/<Y-m-d_H-i-s>_<nome>.php`; scrive il sorgente in un temporaneo in `storage/framework/cache` e lo valida con
  `php -l`; crea la cartella della lingua se manca; scrive; poi **`Cache::flush()` dell'intera cache** e flush del loader delle traduzioni. Lancia `Exception` se la sintassi non e' valida o se non riesce a scrivere.
- **`SyncTranslationsAction`**: non sovrascrive mai un valore gia' presente nella lingua target (aggiunge solo le chiavi mancanti, ricorsivamente), crea le cartelle target e riscrive i file
  (senza `declare(strict_types=1)`: l'effetto e' visibile in `git status`). Restituisce `total_modules`, `total_files`, `total_translations` e il dettaglio per modulo (`status`: `completed` o `skipped`
  se manca `lang/` o la lingua sorgente). I test che la eseguono su `Modules/Lang/lang/en` salvano e ripristinano la cartella (vedi [testing.md](testing.md)).

## Garanzie e limiti per Action

- **`SaveTransAction`** (test: `tests/Feature/SaveTransActionDefaultTest.php`, `SaveTransActionRespectsSwitchTest.php`):
  - `execute($key, $data)` senza configurazione esplicita non scrive fuori da `APP_ENV=local` (ne' in produzione, ne' in staging, ne' sotto test); in `local` scrive la chiave con
    la struttura annidata del percorso; `lang.save_missing_translations` impostata (`true` o `false`) vince sempre sull'ambiente.
  - `persist($key, $data)` scrive anche con l'interruttore spento: il «Salva» del pannello funziona in produzione. Aggiungere una chiave conserva tutte le altre del file.
  - Un file di lingua esistente ma illeggibile non si riscrive: `report($e)` e la chiave si perde. Chiave senza percorso dopo il nome del file con `$data` non array: `\Exception('Error in SaveTransAction')`.
  - Effetto collaterale: scrive il file nell'albero dei sorgenti del modulo (in sviluppo compare in `git status`), solo per la lingua corrente.
  - Non decide quale chiave manca (lo fa `AutoLabelAction`, e solo per `label`: [filament-auto-labels.md](filament-auto-labels.md)); non registra le chiavi mancanti nel database
    (`RecordMissingTranslationAction`, vedi sotto); non fa backup, non controlla la sintassi e non svuota la cache.
- **`WriteTranslationFileAction`**: ritorna `true` o lancia (`Exception`) se la sintassi non e' valida, se il file temporaneo di controllo non si scrive o se il file di destinazione non si scrive
  (messaggio con il percorso). Crea la cartella di una lingua nuova prima di scrivere (`lang/de/` non esiste finche' nessuno scrive la prima traduzione tedesca). I punti di sostituzione per i test sono
  `putTranslationFile()` (`false` se la scrittura non riesce, quindi `execute()` lancia) e `writeLangTempContents()`. Non e' collegata al pannello: il salvataggio da editor usa `SaveTransAction::persist()`.
- **`GetAllTranslationAction` / `GetAllModuleTranslationAction`**: restituiscono `list<array{key, path}>` per la sola lingua corrente (o quella in sessione, se `it`/`en`) e non scrivono nulla.
  I corpi sono identici: l'unico chiamante di produzione e' `TranslationFileRowLoader` (riga Sushi di `TranslationFile`) tramite `GetAllTranslationAction`; `GetAllModuleTranslationAction` non ha chiamanti
  in `app/` ed e' coperta da `tests/Unit/LangHundredPercentCoverageTest.php`. Chi modifica una delle due deve modificare anche l'altra, oppure unificarle: il motivo storico della duplicazione non e' registrato in nessuna pagina.

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
