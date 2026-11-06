# Story: correzione dei test Pest unit delle Action Xot

Stato: parziale. Verifica finale bloccata da un fatal di boot in Ptv (vedi sezione Blocchi).

## Obiettivo

Far passare i test Pest in `Modules/Xot/tests/Unit/Actions` assegnati al gruppo: Cast, Config, File, ModelClass, ModelType, Module, GetAllModels, ArrayArrActions e Binary. Le cartelle `Arr`, `Array` e `Arrays` e le relative Action sono escluse: le consolida un altro agente.

## Metodo

Per ogni test: lettura dello scopo della funzione (docblock, fixture, uso nel codebase), analisi della causa del fallimento, decisione (correzione del test o del codice) basata sul contratto dichiarato, ri-esecuzione.

Regole applicate: nessun `@phpstan-ignore`, nessuna baseline, nessuno spegnimento dei test.

## Esito per test

### GetAllModelsActionTest

- Scopo: elencare i model delle app per tooling.
- Causa del fallimento: `GetAllModelsByModuleNameAction` cercava `Modules/<Mod>/Models` anche per moduli senza quella cartella (Activity), con `DirectoryNotFoundException`.
- Decisione: codice. La correzione (lettura da `app/Models` con guardia `File::isDirectory`) e' stata applicata da un altro agente alle 10:09, durante la sessione.
- Esito verificato: verde, 5 test, 937 asserzioni.

### ArrayArrActionsTest

- Scopo: `DiffAssocRecursiveAction` (cartella `Actions/Arr`, fuori perimetro) e le Action di range e salvataggio.
- Causa: il test era stato riscritto da un altro agente alle 10:06 per allinearsi al contratto di `fixType` (che normalizza le stringhe numeriche in int e float).
- Esito verificato: verde, 5 test passati, 2 risky.
- Residuo: i due test "throws" usano `try/catch (Exception)` senza asserzioni e risultano risky. Non modificato per non sovrapporsi al lavoro dell'altro agente sullo stesso file. Da correggere con `expect(...)->toThrow(...)`.

### BinaryAssetsNotCrStrippedTest

- Scopo: impedire che il filtro git `eol=lf` cancelli il byte CR dalla firma PNG.
- Causa: `.gitattributes` e' gia' corretto (nessun `eol=lf`). Restano PNG committati corrotti (firma `89504e470a1a0a`): repo-wide, circa 60 file tra moduli (UI, Notify, Lang, Job, Media, Tenant, Xot/packages, User, Activity, Rating).
- Decisione: dati, non codice. Il test segnala un difetto reale. La riparazione richiede, per ogni file, la scelta della versione integra in storia e un commit nei repo dei moduli: fuori dal perimetro del gruppo e da fare solo con conferma.
- Azione svolta: ripristinati sul disco i due file con versione integra identica per dimensioni (780x493): `laravel/Modules/Activity/docs/screenshots/event-detail-page.png` (blob `aa808968`) e `laravel/Modules/User/resources/img/screenshots/event-detail-page.png` (blob `109bfdcf`). Non sono stati messi in index ne' committati.
- Esito: `git filters do not alter binaries` verde. `png signature on disk` e `png signature in git index` rossi per i restanti file.

### SafeArrayByModelCastActionTest

- Scopo: fallback su `attributesToArray` quando il model lancia un errore PHP. Il contratto dell'Action intercetta `\ValueError|\Error`, e la fixture `BrokenAttributesModelForSafeArrayCast` lancia `ValueError`.
- Causa: il test simulava l'errore con `\Exception`, fuori dal contratto.
- Decisione: test. Il mock ora lancia `\ValueError`.
- Esito: in attesa di verifica (boot bloccato).

### SafeCastActionsTest (safe int)

- Scopo: `SafeIntCastAction::executeAsId` e' documentata come "ID positivo (sempre >= 1)".
- Causa: l'asserzione attesa `executeAsId(0) === 0` contraddice il contratto.
- Decisione: test. Atteso `1`.
- Esito: in attesa di verifica.

### GetTenantConfigActionsTest

- Scopo: leggere un file di configurazione tenant restituendo l'array.
- Causa: il fixture scriveva `return [...];` senza `<?php`, quindi `require` stampava il sorgente e restituiva `1`.
- Decisione: test. Il fixture ora ha `<?php`.
- Esito: in attesa di verifica.

### CreateDirectoryForFilenameActionTest

- Scopo: creare la directory del file, senza errore se esiste.
- Causa: il test "root level file" creava di nuovo la directory gia' creata da `beforeEach`, con `mkdir(): File exists`.
- Decisione: test. Rimossa la chiamata duplicata.
- Esito: in attesa di verifica.

### FileActionsTest (asset path)

- Scopo: `AssetPathAction` compone il path `<module>/resources/<file>`.
- Causa: il mock usava `allows(['getModulePath' => closure])`, che restituisce la closure come valore e non come callable.
- Decisione: test. Ora `andReturnUsing`.
- Esito: in attesa di verifica.

### ViewPathActionTest

- Scopo: `ViewPathAction` risolve il namespace `Xot::...`.
- Causa: il mock era atteso per `test_ns` mentre l'input usa `Xot`.
- Decisione: test. Il mock e' atteso per `Xot`.
- Esito: in attesa di verifica.

### CountActionsTest

- Scopo: `CountAction` e `UpdateCountAction` su un model concreto.
- Causa: il test passava `XotBaseModel` (abstract) e accettava qualsiasi eccezione contenente "table". Dopo il cambio su un fixture concreto, `InformationSchemaTable` scriveva nel file JSON del tenant reale (`config/<tenant>/database/content/`), che contiene dati veri e in un caso un `id` stringa.
- Decisione: test. Ora il fixture concreto usa una tabella temporanea, e `GetTenantFilePathAction` punta a una directory temporanea, cosi' il test non tocca i dati del tenant.
- Esito: in attesa di verifica.

### ModelTypeActionsTest

- Scopo: `GetModelTypeByModelAction` restituisce lo snake del nome di classe.
- Causa: l'anonymous class che estende `Log` (usa Sushi) tentava di creare una tabella con nome di classe anonima.
- Decisione: test. L'anonymous class ora estende il model Eloquent base, che implementa il contratto marker `ModelContract`.
- Esito: verde nella run del 2026-10-28 (sezione ModelClass e ModelType).

### GetModuleConfigActionTest (non array)

- Scopo: `GetModuleConfigAction` deve lanciare se il file non restituisce un array.
- Causa: il test non intercettava l'eccezione attesa.
- Decisione: test. Ora usa `expect(...)->toThrow(...)`.
- Esito: in attesa di verifica.

### ModuleActionsTest

- Scopo: caricare la config di un modulo.
- Causa: il fixture era `"return ['a' => 1]);"`, senza `<?php` e con parentesi errata.
- Decisione: test. Ora `"<?php\nreturn ['a' => 1];\n"`.
- Esito: in attesa di verifica.

## Blocchi

- Boot dell'applicazione di test in fatal dal 10:16: `laravel/Modules/Ptv/app/Filament/Resources/AnagResource/RelationManagers/AszEffRelationManager.php` estende `XotBaseRelationManager` e ridefinisce `form()`, che e' `final`. Il file e' in modifica da un altro agente; va risolto dal suo owner. Finche' non e' risolto, nessun test Xot gira.
- Repo-wide: PNG corrotti nei commit (vedi BinaryAssetsNotCrStrippedTest). Decisione richiesta sul ripristino e sul commit.

## Prossimi passi

1. Risolvere il fatal in Ptv (owner del modulo).
2. Rieseguire i file del gruppo e verificare gli esiti "in attesa".
3. Correggere i due test risky di ArrayArrActionsTest, d'accordo con l'altro agente.
4. Decidere con l'utente ripristino e commit dei PNG corrotti.
5. PHPStan livello max su `Modules/Xot`.
