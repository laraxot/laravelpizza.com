---
title: "Xot - fix-xot-unit-misc-tests.story.md"
module: Xot
bmad: true
status: in-progress
---
# Fix test unitari Xot misc

**Ambito:** undici file di test unitari Xot (`laravel/Modules/Xot/tests/Unit/`).
**Obiettivo:** portare il gruppo a verde correggendo la causa reale, senza spegnere test
e senza rimuovere asserzioni.

## Esito per file

| File | Esito | Causa | Decisione |
|------|-------|-------|-----------|
| `Filament/Actions/Header/ExportPdfActionTest.php` | verde | Il test chiede `getLabel() === ''` per l'azione icon-only; l'azione aveva solo `hiddenLabel(true)`, che non svuota la label. | Aggiunto `label('')`, stesso pattern di `ExportXlsLazyAction` (gia' verde). |
| `Filament/Actions/Header/ExportXlsActionTest.php` | verde | `translateLabel()` produceva "Export xls" invece di stringa vuota. | Sostituito con `label('')`. Il test Lazy resta verde. |
| `HasExtraTraitTest.php` | verde (12/12) | (1) il fixture `Models\Extra` mancava: `HasExtraTrait::extra()` risolve `<Namespace>\Models\Extra`. (2) `ExtraModelTest` usava la classe valore `SchemalessAttributes` come cast invece del caster `Casts\SchemalessAttributes`. (3) `getExtra()` scartava le chiavi intere delle liste, perdendo dati in silenzio. (4) l'asserzione `getRelationName() === 'extra'` chiedeva un nome che Laravel imposta solo con `ofMany`. | Aggiunto fixture `tests/Fixtures/Models/Extra.php`; corretto il cast; `getExtra()` restituisce l'array intero (tipo `array<array-key, mixed>`); asserzione sostituita con tipo `MorphOne` e modello collegato `Extra`. |
| `ModelsTest.php` | rosso (ambiente) | `can create a test tenant`: tabella `tenants` assente nel DB di test `ptv_lara_test` (10.100.200.53). Le migrazioni di test risultano 99 pending. | Non risolto nel codice. Richiede una decisione: eseguire `php artisan migrate --env=testing` una volta, come da `tests/TestCase.php`. Non eseguito in autonomia (DB condiviso). |
| `ModuleServiceTest.php` | verde | `GetAllModelsByModuleNameAction` cercava `<Modulo>/Models`, che non esiste: i model stanno in `app/Models`. `File::files()` lanciava `DirectoryNotFoundException` per ogni modulo, anche nei chiamanti di produzione (`GetAllModelsAction`, `ResolveTenantModelClassAction`). | Percorso corretto su `app/Models`, guard `File::isDirectory()`. |
| `SimpleModelsTest.php` | verde su "legge i moduli" | (1) `ModuleFactory` tenta di creare righe in `Module`, che e' un registro Sushi di sola lettura costruito da nwidart: lo schema non ha `slug`/`version`/`is_active`. (2) "can run migrations" esegue `migrate --force` sul DB di test condiviso: viola la regola "no --force" e la regola data-sacred. | (1) Test riscritto sul contratto del registro ("legge i moduli nwidart dal registry Sushi"). (2) NON modificato: vedi sotto. |
| `XotBaseManageRelatedRecordsRegressionTest.php` | verde | Il test chiedeva `TransTrait`; la pagina usa `transFunc()` tramite `NavigationLabelTrait` -> `TransFuncTrait`, come da design della classe (settima direzione). | Asserzione allineata a `TransFuncTrait`. Nessuna modifica alla classe. |
| `XotBasePestNarrowingTest.php` | verde | `XotBasePest::assertArray()` usava `assertNotEmpty`, in contraddizione con la propria docblock che dice di accettare array vuoti. | Narrowing con `is_array` + `Assert::fail` e normalizzazione delle chiavi intere in stringhe (il tipo di ritorno e' `array<string, mixed>`, come richiesto da PHPStan). Rimosso paragrafo duplicato nella docblock. |
| `XotBaseResourceTableConfigureTest.php` | verde | Il fixture Table non stava sotto `{Resource}\Tables\`, quindi `getResource()` non lo risolveva. Il Resource di prova `ProbeResource` non ha un model esistente. | Aggiunto `tests/Fixtures/Filament/Resources/ExtraResource.php` (model `Models\Extra`) e spostato il fixture Table sotto `ExtraResource\Tables\`. |
| `XotExecuteCoverage50Test.php` | verde (3 risky preesistenti) | `getColumnDefinitions()` vale `[]` di default in `EnumTrait`, e questi enum non sono legati a colonne DB. `getRelations()` e' vuoto per una Resource senza `RelationManagers`. Asserzioni `assertNotEmpty` impossibili da soddisfare. | Sostituite con `assertIsArray` sul contratto reale. |
| `XotHundredPercentCoverageTest.php` | verde | Stessa causa dell'enum sopra. | `getColumnDefinitions` in `assertIsArray`. |

## Problemi fuori perimetro emersi durante la verifica

- Una modifica concorrente non committata in `Modules/Ptv/.../AszEffRelationManager.php` (override di
  `form()`, `final` in `XotBaseRelationManager`) causava `FatalException` al bootstrap di tutta la suite Xot.
  Il file e' stato corretto dall'altro agente durante la sessione. Non toccato da questo lavoro.
- `SimpleModelsTest::can run migrations` esegue `migrate --force` sul DB di test condiviso. Ogni run della suite
  applica migrazioni reali. Nel corso del lavoro le pending sono scese da 110 a 99. Non e' stato fatto rollback
  (regola data-sacred). Il test va riportato al rispetto delle regole: rimuovere `--force` e spostare
  l'esecuzione delle migrazioni fuori dalla suite, oppure eliminarlo. Decisione dell'owner.
- Un'errore in una migrazione Incentivi (`employee_project`, FK "incorrectly formed" su `ptv_lara_test`)
  e' emerso dalla run di `migrate`. Va verificato dopo che le migrazioni del DB di test sono allineate.

## Verifica

- Run gruppo 8 file: 29 passati, 1 rosso (`ModelsTest` tenant, ambiente).
- `SimpleModelsTest` filtro "legge i moduli": verde.
- `XotExecuteCoverage50Test` + `XotHundredPercentCoverageTest`: 24 passati, 3 risky preesistenti.
- PHPStan `Modules/Xot` (livello max, `--error-format=table`): 2 errori residui, entrambi in `tests/Feature/` (fuori perimetro del gruppo): `GetPdfContentByRecordActionTest.php:75` (binaryOp.invalid) e `ListRecordsPagesDeclareColumnsTest.php:57` (preg_match non Safe). Nessun errore nei file di codice toccati.

## Prossimi passi

1. Decidere sul DB di test: eseguire `migrate --env=testing` una volta, poi rilanciare `ModelsTest`.
2. Decidere sul test `can run migrations` (`--force` vietato): rimuovere, o isolare fuori dalla suite.
3. Aggiornare la second brain (`qmd update`) a fine lavoro.
