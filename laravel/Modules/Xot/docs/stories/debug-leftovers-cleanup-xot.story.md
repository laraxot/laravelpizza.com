---
title: "[STORY] Residui di debug in produzione: Xot, Cms, Lang, UI"
type: story
status: review
priority: high
created: 2026-10-20
updated: 2026-10-20
module: Xot
tags: [debug, dddx, dd, file-action, helpers, getModuleModels, duplicate-commands, bmad]
related:
  - ../../../DbForge/docs/stories/debug-calls-removal-dbforge.story.md
  - ../../../Quaeris/docs/stories/debug-calls-removal-quaeris.story.md
  - ./services-parity-audit-xot.story.md
---

# [STORY] Residui di debug in produzione: Xot, Cms, Lang, UI

**Fase BMAD:** Dev (correzione per scopo) con verifica reale in coda.

## Perche'

`dddx()` (`Modules/Xot/helpers/Helper.php:97`) chiude con `dd($data)` senza condizioni: in produzione ferma la richiesta e stampa un dump con percorsi e dati. Un `catch { dddx(...) }` fa morire la pagina invece di segnalare l'errore. Misura con tokenizer PHP (`token_get_all`, ignora commenti, stringhe e metodi come `->dd()`), con controllo positivo su un file sintetico (`dddx`, `dd`, `dump`, `print_r` trovati; `->dd()`, commento e stringa ignorati).

## Numeri del tokenizer su `Modules/<M>/app`

| Modulo | Prima | Dopo | Resta |
|---|---|---|---|
| Xot | 40 | 3 | `print_r(..., true)` e due `var_export(..., true)`: restituiscono stringhe (scelta d) |
| Cms | 1 | 0 | |
| Lang | 1 | 0 | (`LangServiceProvider:117` e' dentro un blocco commento: il tokenizer non lo conta) |
| UI | 1 | 1 | `print_r($this->block, true)` in una stringa di messaggio (scelta d) |

`Xot/helpers/Helper.php:117` resta di proposito: e' il `dd()` dentro la definizione di `dddx`, utilita' di sviluppo non cancellata.

## Regola di scopo applicata

- a: `catch` con dump. `report($e)` piu' notifica tradotta (Filament Notification se il codice e' Filament, altrimenti log). Dove il valore di ritorno non puo' essere sostituito senza corrompere il chiamante, l'eccezione risale all'handler (variante dichiarata).
- b: dump prima di una chiamata o di un salvataggio. Rimosso; se nascondeva codice disattivato, non riattivato e riportato come decisione.
- c: stub WIP che stampa e basta. `throw new \LogicException('<X> not implemented')`, anche quando non ha chiamanti (stesso criterio della story DbForge): zero rischio e nessuna logica inventata.
- d: `print_r`/`var_export` con `true` che producono stringhe per output legittimo. Restano.

## Siti Xot

Righe riferite ai file prima della modifica.

| Sito | Scopo ricostruito (storia git) | Scelta | Esito |
|---|---|---|---|
| `Console/Commands/ViewDatabaseConfigCommand.php:47` | Comando che mostra la config DB; il `dddx` era l'output voluto, con mascheramento solo di `password` | d (output legittimo) | Corpo allineato al canonico DbForge (tabella, maschera password/secret/token/key/url/dsn). Eseguito: uscita 0, 27 righe `password`, tutte `********` |
| `Console/Commands/ParsePrintPageStringCommand.php:42` | Comando che espande `1-4,6`; il `dddx` era l'output | d (output legittimo) | Allineato al canonico DbForge (JSON, uscita 0; `abc` uscita 1 con messaggio) |
| `Actions/Query/StartQueryLogAction.php:30` | Log delle query: `print_r($bindings, true)` va in `Log::debug` | d | Resta |
| `Actions/Html/HtmlToPdfAction.php:59` | Porta 1:1 di `HtmlService::toPdf` (2026-01-20). Dopo il `dddx` c'erano `echo` del messaggio HTML e `return $filename`, mai eseguiti | a (variante: rilancio) | `clean()` poi `throw $e`. Un return di path mai scritto finirebbe come contenuto PDF in `Quaeris MakePdfAction` e come allegato inesistente in `Notify Attachment\Pdf`. Rimosso `ExceptionFormatter` e il return finale irraggiungibile |
| `Actions/HtmlAction.php:53` | Copia statica dello stesso codice. Zero chiamanti | a (variante: rilancio) | Come sopra |
| `Actions/Export/PdfByHtmlAction.php:29` | `catch (HtmlParsingException) { dddx($html); }`: senza dump si sarebbe scritto un PDF incompleto | a (variante: rilancio) | Tolto il try/catch, l'errore risale (chiamanti `PdfByViewAction`, `PdfByModelAction`) |
| `Actions/File/DownloadZipByPathsDiskAction.php:44` | Diagnostica nel ramo "file assente su disco". Zero chiamanti | b (variante: log) | `Log::warning` con disco e percorso, il file viene saltato. Un ramo `else` vuoto avrebbe perso la traccia |
| `Actions/Filament/Actions/ImportButton.php:20` | `->action(fn () => dddx('WIP'))`. Zero chiamanti | c | `LogicException('ImportButton action not implemented')` |
| `Actions/Filament/Actions/ExportButton.php:20` | Idem. Zero chiamanti | c | `LogicException('ExportButton action not implemented')` |
| `Actions/Model/GenerateModelByTableAction.php:19` | Stub WIP con link a `krlove/eloquent-model-generator`. Zero chiamanti. Identico al duplicato DbForge gia' corretto | c | `LogicException` (stesso testo del canonico) |
| `Datas/XotData.php:345` (`save()`) | Stub `dddx('wip')`; `update()` ha il `save()` commentato. Zero chiamanti | c | `LogicException('XotData::save() not implemented')` |
| `Actions/Model/Update/MorphedByManyAction.php:21` | Stub WIP. Raggiunto dinamicamente da `Update\RelationAction` (nome classe costruito da `class_basename` della relazione) | c | `LogicException` |
| `Actions/Model/Update/HasManyThroughAction.php:21` | Idem | c | `LogicException` |
| `Actions/Model/Update/HasManyDeepAction.php:18` | Idem | c | `LogicException` |
| `Actions/Model/Update/PivotAction.php:20` | Idem | c | `LogicException` |
| `Actions/Model/Update/CustomRelationAction.php:35` | Ramo `else`: riga del payload senza chiave primaria (creazione del correlato non implementata). Rimuovere il dump avrebbe scartato la riga in silenzio | c (nel ramo) | `LogicException` con nome relazione. Il test esistente copre solo il ramo con chiave |
| `Actions/Model/Update/MorphManyAction.php:53` | Stesso ramo `else` | c (nel ramo) | `LogicException` con nome relazione |
| `Actions/Model/Store/MorphedByManyAction.php:18` | Stub WIP. Raggiunto solo da `StoreAction`, che non ha chiamanti | c | `LogicException` |
| `Actions/Model/Store/HasManyThroughAction.php:18` | Idem | c | `LogicException` |
| `Actions/Model/Store/HasManyDeepAction.php:18` | Idem | c | `LogicException` |
| `Actions/Model/Store/PivotAction.php:18` | Idem | c | `LogicException` |
| `Actions/Model/Store/MorphManyAction.php:18` | Idem | c | `LogicException` |
| `Actions/Model/Store/MorphToManyAction.php:39,47` | Ramo "dati associativi con pivot" non implementato; due dump consecutivi (il primo eseguiva anche `rows->exists()`), poi un blocco commentato | c | Un solo `LogicException`; blocco commentato lasciato (vedi decisioni) |
| `Actions/Arr/SavePhpArrayAction.php:48,64` | `var_export(..., true)` genera sorgente PHP | d | Resta |
| `Actions/File/FileAction.php` x14 (`268,277,319,328,349,374,383,421,435,501,526,650,658,840`) | Vedi sezione FileAction | classe eliminata | 14 siti spariti |

Altri nomi indicati nel brief senza chiamate attive: `GenerateFormByFileAction::ddFile`, `GenerateTableColumnsByFileAction::ddFile` e `TransFuncTrait:53` hanno il `dd`/`dddx` dentro un commento (`/* ... */`), quindi inerti. Non toccati. I due `{{ dddx($column) }}` in `xot_base_table_component.blade.php` sono dentro un commento Blade `{{-- --}}`: inerti.

### Decisioni aperte (codice che il dump nascondeva)

1. `Store/PivotAction` e `Update/PivotAction`: blocco commentato con `$this->panel->getParent()` e `updateExistingPivot`. Usa l'API Panel che non esiste piu': riscrivere con le relazioni Eloquent o cancellare lo stub.
2. `Store/MorphToManyAction`: blocco commentato con `syncWithoutDetaching` e `pivot.user_id` per i dati associativi. Decidere se implementarlo.
3. `Update/MorphedByManyAction`: blocco commentato con `->touch()`.
4. `HtmlToPdfAction` e `HtmlAction`: l'`echo` del messaggio HTML di errore non e' mai stato eseguito (dopo il `dd` dal 2026-01-20). Non riattivato.
5. `CustomRelationAction` e `MorphManyAction`: righe senza chiave primaria non sono supportate. Decidere se creare il correlato.
6. Chiamanti: `StoreAction` non ha chiamanti, quindi tutto `Actions/Model/Store/` e' irraggiungibile. L'albero `UpdateAction` e' raggiunto solo da se stesso e da un test. `HtmlAction`, `ImportButton`, `ExportButton`, `GenerateModelByTableAction`, `XotData::save` e `DownloadZipByPathsDiskAction` non hanno chiamanti. Da valutare per la rimozione (non fatta).
7. Accoppiamento nei test: `ModuleExecuteCoverage::testActionsStaticMethods` salta le Action che contengono `dddx(` a inizio riga. Tolto il dump, `HtmlAction::toPdf` (statico pubblico) entra nello sweep `runFloor50`; le chiamate sono in `try/catch Throwable`, ma non ho potuto eseguire lo sweep (richiede DB).

## FileAction

Verifica dell'uso dinamico con controprova (rg con `-P`, confini di parola):

- Parola esatta `FileAction` in `laravel/Modules`, `Themes`, `app`, `routes`, `config`, `bootstrap`, `resources`, `database`, `lang`, anche in `.blade.php`, `.json`, `.neon`, `.yml`, `.xml`, `.js`, `.ts`: produzione zero (una sola occorrenza, la dichiarazione). 6 file di test.
- Falsi positivi scartati: `GenerateFormByFileAction`, `ReadTranslationFileAction`, `UploadFileAction`, `DownloadLogFileAction` e simili (stessa sottostringa, altra classe).
- `app(FileAction::class)` solo in `FileActionStaticsTest`; nessun `resolve(`, `class_alias`, alias `use ... as`, stringa `'FileAction'` o scansione di `Actions/File` in produzione. Le altre Action di `Actions/File/` sono importate per nome proprio, mai `FileAction`.
- Dopo l'eliminazione: stessa ricerca, zero risultati (exit 1 di `rg`). Resta solo una riga nel classmap generato `laravel/vendor/composer/autoload_classmap.php`: si ripulisce con `composer dump-autoload`, non toccato perche' in `vendor`.

### File eliminati (working tree, non committati)

Recupero: `git show 50e2d2073:<percorso>` (HEAD al momento; i file erano puliti rispetto a HEAD). Ultimo commit che li ha toccati tra parentesi.

- `laravel/Modules/Xot/app/Actions/File/FileAction.php` (1092 righe, 005b798d8)
- `laravel/Modules/Xot/tests/Unit/Actions/File/FileActionStaticsTest.php` (291 righe, 005b798d8)
- `laravel/Modules/Xot/tests/Unit/XotDeepFileActionCoverageTest.php` (43 righe, c6145c3e7)
- `laravel/Modules/Xot/tests/Unit/XotInProcessDeepCoverageTest.php` (33 righe, c6145c3e7)

### Test potati (FileAction usata come mezzo o in file con altri soggetti)

- `tests/Unit/XotHundredPercentCoverageTest.php`: tolto il test "FileAction rami asset theme module config vite copy getRealFile" e gli import `FileAction`, `View` (147 righe).
- `tests/Unit/XotExecuteCoverage50Test.php`: tolti due test dedicati e il blocco in coda a "CheckAccessorTwins SearchText middleware e navigation", piu' import `FileAction`, `View` (114 righe).
- `tests/ModuleExecuteCoverage.php`: tolti `testFileActionStatics()`, la sua chiamata in `runFloor50`, `$skipClasses` con il relativo `continue`, import `FileAction`, `XotData` (55 righe).

### Metodi senza Action propria (nessuna azione richiesta)

I 30 metodi statici (+ `execute(): void` vuoto). Hanno un'Action omologa per nome, senza aver confrontato il comportamento (10): `getModulePath`, `asset`, `createDirectoryForFilename`, `getViewNameSpacePath`, `assetPath`, `fixPath`, `viewPath`, `copy`, `viewCopy`, `getComponents`.

Senza Action propria (20 al conteggio per nome; il brief ne dava 19): `viewNamespaceToDir`, `getViewNameSpaceUrl`, `getViewNameSpaceUrl_nomodule`, `path2Url`, `viewThemeNamespaceToAsset`, `viewNamespaceToAsset`, `url`, `getFileUrl`, `viewNamespaceToUrl`, `getRealFile`, `allDirectories`, `config`, `configPath`, `getConfigKey`, `configCopy`, `getNiceFileSize`, `getFileNameByClassName`, `url2Path`, `vitePath`, `viteCopy`. Il debito `W5` in `services-parity-audit-xot.story.md:115` ("FileAction e' diviso per caso d'uso o ridotto a quel che serve davvero") e' superato dall'eliminazione.

## Helper duplicati

`dddx` e' definita due volte:

- `Modules/Xot/helpers/Helper.php:95-117`: `void`, termina con `dd($data)`. E' l'unica caricata: `Modules/Xot/composer.json` `autoload.files` = `["helpers/Helper.php"]`, `vendor/composer/autoload_files.php:177`, e `laravel/composer.json` la include col merge-plugin `Modules/*/composer.json`.
- `Modules/Xot/Helpers/Helper.php:163` (maiuscola): `string`, non caricata. La nomina solo `Modules/Activity/phpstan_activity.neon:36` come file da scandire. Su filesystem case sensitive sono due cartelle distinte.

Non cancellate. Il file maiuscolo definisce 48 funzioni che non esistono nel file caricato (confronto dei nomi `function` dei due file).

## getModuleModels (S1): no

- Definita solo in `Xot/Helpers/Helper.php:615` (non caricata). Unica occorrenza di chiamata nel codice: `Helpers/Helper.php:592`, dentro `getAllModulesModels()`, nello stesso file non caricato.
- `ModuleService` e `TenantService` non esistono piu'. `MorphMapConfigResolver` non esiste nel codice: compare solo in `docs/`, `coverage.xml` e nella storia git (`git log -S` ultimo tocco 7f9459a16).
- `getAllModulesModels` non ha chiamate di funzione: `Tenant\ResolveTenantModelClassAction` ne ha un metodo omonimo.
- Quindi nessuna chiamata viva a funzione non caricata per questo nome.
- Controllo allargato: delle 48 funzioni definite solo nel file maiuscolo, nel codice di produzione (`app`, Blade) ne e' chiamata una sola come funzione: **`cssInLine('notify::css/ark.css')` in `Modules/Notify/resources/views/layouts/ark.blade.php:11`**. Se quel layout viene renderizzato, fallisce con "Call to undefined function cssInLine()". Nessun riferimento statico al layout `ark` (puo' essere scelto per nome dal tema). Modulo Notify, non mio: riportato, non toccato. Le altre corrispondenze erano metodi di classe o built-in PHP (`str_contains`).

## Comandi duplicati

`xot:view-db-config` e `xot:parse-print-page` esistono in `Modules/Xot/app/Console/Commands/` e in `Modules/DbForge/app/Console/Commands/`, con la stessa signature.

- Canonico: DbForge. E' il modulo degli strumenti database e la versione corretta oggi dall'altra sessione (story DbForge).
- Chi li registra: entrambi tramite `XotBaseServiceProvider::registerCommands()` (scansione `Console/Commands` di ogni modulo) e le voci di `_components.json` di Xot e DbForge. Nessun chiamante nel codice: sono invocati solo da artisan.
- A runtime vinceva la copia Xot (verificato: `artisan list` mostrava la descrizione " esplode" e la classe risolta era `Modules\Xot\Console\Commands\...`), cioe' proprio quella con `dddx`.
- Azione: non cancellate. Le copie Xot ora sono mirror delle DbForge (stesso corpo, solo namespace e un commento "Mirror di ... (canonico)"). Dopo la correzione `artisan list` mostra le descrizioni nuove.
- Da decidere (proprietario): togliere le copie Xot e lasciare una sola registrazione, con rigenerazione di `_components.json`.

## Cms

`Filament/Fields/PageContentBuilder.php:53`, `catch (\Error)` sulla creazione di un blocco. Scopo: nell'editor pagine, un blocco che non si istanzia. In `testing` si saltava (`continue`); altrove `dddx` uccideva la pagina. Un blocco saltato in silenzio potrebbe sparire al salvataggio, quindi serve un avviso.

Scelta a: `report($e)` piu' `Filament\Notifications\Notification` danger con chiave tradotta `cms::page_content_builder.messages.block_unavailable.{title,body}` (aggiunte in `lang/it`, `lang/en`, `lang/de`), poi `continue`. In `testing` resta il solo `continue`. PHPStan ha segnalato `$blockInstance = null` come assegnazione mai letta (`assign.overwritten`): rimossa, ora il `catch` esce sempre.

## Lang

`Actions/SaveTransAction.php:48`, `catch (\Exception)` su `File::getRequire($filename)` del file di lingua. Scopo: scrivere la chiave mancante. Dopo il dump il codice avrebbe riscritto il file con la sola chiave nuova, perdendo le traduzioni esistenti. Scelta a: `report($e)` e `return` (nessuna riscrittura); niente notifica UI perche' l'Action gira anche da console e job. Verificato con spy (vedi Verifica).

## UI

`View/Components/Render/Block.php:47`: `print_r($this->block, true)` costruisce il messaggio "view not exists" per la vista `ui::alert`. Scelta d, resta. Nota: il contenuto del blocco finisce nel messaggio dentro un `<pre>`; se `ui::alert` non fa escape e i dati del blocco sono modificabili da utenti, e' una superficie XSS. Non verificato, non toccato.

## Verifica

- `php -l`: 30 file (24 app, 3 lang, 3 test), tutti puliti.
- PHPStan mirato sui 27 file PHP toccati (`phpstan.neon` unica, gate condiviso): prima esecuzione exit 1 con un solo errore (`PageContentBuilder.php:42`, corretto alla causa), seconda esecuzione exit 0.
- Tokenizer prima/dopo: vedi tabella; controllo positivo ancora a 4 su 4.
- Comportamento (script di sola lettura che avvia l'app, nessun DB): stub Xot sollevano `LogicException`; `SaveTransAction` con file illeggibile non solleva, fa `report` e non riscrive (una sola chiamata a `SaveArrayAction`, quella di creazione); `PageContentBuilder` con blocco rotto in ambiente `production` restituisce il builder, un report e una notifica con titolo "Blocco non disponibile"; `HtmlToPdfAction` con HTML malformato rilancia `Html2PdfException`.
- Comandi: `xot:parse-print-page 1-4,6,8-9` stampa `[1,2,3,4,6,8,9]` (0), `abc` uscita 1; `xot:view-db-config` uscita 0, nessuna riga `password` non mascherata.
- Pest non eseguito: `Xot\Tests\TestCase` usa `DatabaseTransactions` e i test Cms/Lang passano da TestCase con DB (regola: test su MySQL, mai sqlite). Da lanciare con DB di test: `Xot/tests/Unit/Actions/Model/Update/CustomRelationActionTest.php`, `Cms/tests/Unit/Filament/Fields/PageContentBuilderTest.php`, `Xot/tests/Unit/XotExecuteCoverage50Test.php`, `Xot/tests/Unit/XotHundredPercentCoverageTest.php`.
