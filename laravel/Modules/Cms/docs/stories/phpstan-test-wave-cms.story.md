---
title: PHPStan lane cms, regressione da test riespansi dopo il pull
type: story
module: Cms
phase: implementazione, quality gate
status: done
created: 2026-10-20
updated: 2026-10-20
related:
  - ../../../Xot/docs/stories/phpstan-test-wave-regression.story.md
  - ./phpstan-cms-swarm-wave.story.md
  - ./phpstan-cms-zero.story.md
  - ../00-INDEX.md
---

# PHPStan lane cms: test riespansi dopo il pull

Lane `cms` del run del 2026-10-20. Coordinamento e regole: [phpstan-test-wave-regression](../../../Xot/docs/stories/phpstan-test-wave-regression.story.md). Bucket: 69 file (66 test, 3 sorgenti), 742 errori nella baseline delle 09:00, 596 alla rimisura delle 09:24 (altre lane avevano gia' sistemato dipendenze).

Nello stesso bucket hanno lavorato in parallelo due agenti `lane-cms` (stesso `TASK_ID`/`AGENT_ID` nei lock). Questa story copre il lavoro di entrambi, divisi per file (vedi "Chi ha toccato cosa").

## Scopo capito

Il merge `c0a06773` del repo `Modules/Cms` (2026-10-20 09:03) ha riportato in `tests/` i corpi del lato `bed01e6d`: specifiche generiche scritte per un Cms con tabelle SQL (`pages.status`, `meta_title`, `page_contents`, `sections`, `Page::factory()`) e per un progetto con homepage `<nome progetto>`. Il Cms reale e' un altro:

- `Models\Page`, `PageContent`, `Section`, `Menu` leggono file JSON per tenant (trait `SushiToJsons` del modulo Tenant). Nessuna tabella `pages`, nessuna colonna `status`/`template`/`published_at`, nessuna relazione `contents()`/`sections()`.
- In Quaeris non esiste una homepage JSON in `config/local/<tenant>/database/content/pages/` e il path di alcuni test conteneva il segnaposto letterale `<nome progetto>`.
- Il `TestCase` di modulo era stato svuotato dal merge (14 righe): sparivano `createPHPUnitMock`, `pestGenerateUniqueEmail`, `pestCreateTestUser`, `$currentTest`, da cui dipende `tests/PestHelpers.php` (autoload-dev), usato da quasi tutti i test.

Il run del 2026-10-08 (commit `9b709db8`, `d93863bd` di `Modules/Cms`) aveva gia' allineato quei test al Cms reale. Dove il corpo del merge e' una specifica fantasma si e' riusata quella forma (regola 3, "forma neutralizzata gia' usata dal repo"). Il corpo del merge resta in git: `git -C Modules/Cms show c0a06773:<path>`.

## Cause corrette (conteggi alla rimisura delle 09:24)

| Causa | Errori | Correzione alla sorgente |
|---|---|---|
| `uses(Modules\Cms\Tests\TestCase::class)` ridondante (gia' in `tests/Pest.php`) | 39 | tolto dai file (`FolioRoutes/*` 29 file, `Auth/*`, `Feature/*`) |
| `@phpstan-ignore` che non ignoravano piu' nulla (`ignore.unmatchedLine`) | 25 | tolti da `Auth/LoginTest.php`, `Auth/RegisterTest.php`; nessun ignore nuovo |
| `static::generateUniqueEmail()`, `static::createTestUser()`, `static::getUserClass()`, `static::mockXotData()` in closure Pest (`outOfClass.static`) | 25 | `$this->...` (Pest lega la closure al TestCase) e helper `cmsGenerateUniqueEmail()` |
| Test Auth: `getUserClass()::factory()->create()` e utente su `mixed` (`property.nonObject`, `method.nonObject`, `staticMethod.notFound`) | 56 | `$this->createTestUser()`, `cmsCreateUnverifiedUser()`, `cmsActingAsGet()` |
| Test su `Page`/`PageContent`/`Section` come se fossero tabelle SQL | 184 | riallineati al modello JSON: `PageTest`, `BaseModelTest`, `PageManagementBusinessLogicTest`, `CmsContentManagementTest`, `DashboardTest`/`dashboardtest`, `ExampleTest`/`exampletest` |
| `assertViewIs('...')` con `string` al posto di `view-string` | 8 | `GetViewByClassAction::execute(RegistrationWidget::class)` |
| `LoginWidget::getView()` inesistente | 1 | la vista del widget si risolve con `GetViewByClassAction` (come `XotBaseWidget`) |
| `Variable $user is never read` | 15 | assegnazione tolta quando l'utente serve solo per l'effetto |
| Placeholder `expect(true)->toBeTrue()` | 4 | `->skip('...')` con rimando al file che ha i test veri (`LoginVoltTest`, `PasswordConfirmationTest`) |

### Sorgenti di produzione

- `Actions/ResolvePageAction`: il merge aveva introdotto `use Modules\Blog\...` per `blog` ed `events`, ma il modulo Blog non esiste in Quaeris (6 errori `class.notFound`). Ora le classi si risolvono per nome e si usano solo se `class_exists`; senza Blog si ripiega sulla convenzione `Modules\<Container>\Models\<Singolare>`. Dove il Blog c'e' il comportamento e' identico. Docs corrette: `README.md` e `actions/page-resolution-pipeline.md` descrivevano ancora la mappa `$knownMappings` -> `Meetup\Event`, che il merge aveva gia' tolto.
- `Datas/BlockData`: `substr($name, 0, strrpos(...))` con `int|false` sostituito da `Str::beforeLast($name, '.')` (stesso risultato, nessun `false`).
- `Models/Page::findUniqueBySlug`: rilanciava `MultipleRecordsFoundException` passando una stringa dove il costruttore vuole `int $count`, quindi il messaggio finale sarebbe stato "<testo> records were found.". Ora lancia `\RuntimeException` con messaggio, conteggio vero (`getCount()`) e `previous`. I chiamanti (`ThemeComposer`, `Livewire\Page\Show`, `PageSlugMiddleware`) non catturano il tipo vecchio.

## Chi ha toccato cosa

- Agente A (questa story): 3 sorgenti; `tests/Feature/Auth/*` (17 file del bucket), `tests/Feature/Frontoffice/FolioRoutes/*` (30 file), `Unit/Models/PageTest`, `Unit/Models/BaseModelTest`, `Unit/DashboardTest`+`dashboardtest`, `Unit/ExampleTest`+`exampletest`, `Feature/PageManagementBusinessLogicTest`, `Feature/CmsContentManagementTest`.
- Agente B (lock del 2026-10-20 09:49, stesso task): `tests/TestCase.php` (helper `createPHPUnitMock`, `pestGenerateUniqueEmail`, `pestCreateTestUser`, `skipTest`, loader tipizzato `homepageJsonForBlocksArchitecture()` che salta il test se il tenant non ha la homepage), `tests/PestHelpers.php`, `tests/TestHelper.php`, `Feature/FilamentBuilderBlocksTest`, `FilamentBlocksIntegrationTest`, `HomepageContentManagementTest`, `HomepageFilamentBlocksArchitectureTest`, `IndividualFolioRoutesTest`, `Frontoffice/FolioRoutesTest`, `Unit/Filament/ResourceExtensionTest` (riallineato a `XotBaseResource`: `getFormSchema()` e' final e vuoto, lo schema vive nella classe `Schemas\...Form`).

## Duplicati per maiuscole (decisione aperta)

`tests/Feature/Auth` e `tests/Unit` hanno coppie di file che differiscono solo per le maiuscole (`LoginTest.php`/`logintest.php`, `AuthenticationTest.php`/`authenticationtest.php`, `RegisterTypeTest.php`/`registertypetest.php`, `RegisterTypeWidgetTest.php`/`registertypewidgettest.php`, `PasswordConfirmationTest.php`/`passwordconfirmationtest.php`, `LoginWidgetTest.php`/`loginwidgettest.php`, `DashboardTest.php`/`dashboardtest.php`, `ExampleTest.php`/`exampletest.php`; `LoginVoltTest.php` e `PasswordConfirmationTest.php` sono stub `->skip(...)` che rimandano ai gemelli minuscoli, che hanno i test veri; `registertest.php` non e' nel bucket). Su filesystem insensibili alle maiuscole collidono. Non cancellati: dove erano gemelli sono stati portati allo stesso contenuto. Proposta: tenere solo la variante PascalCase (vedi [case-variant-collisions](../case-variant-collisions.md)).

## Verifica

PHPStan mirato su batch da 8 file (`--memory-limit=2G --no-progress --error-format=raw`) e `php -l` sui file toccati. Pest non eseguito: il DB di test `quaeris_data_test` non esiste.

Gate swarm wave successivo: [phpstan-cms-swarm-wave.story.md](./phpstan-cms-swarm-wave.story.md) — `Cms.files` intero a **0** errori (`.cursor-scratch/phpstan-wave/Cms.verify.txt`).

## Residui e decisioni aperte

- Base class dei test: `Modules\Cms\Tests\TestCase` estende `Tests\TestCase` dal merge; fino al 2026-10-08 estendeva `XotBaseTestCase` (carica `.env.testing`). Se i test Cms devono girare su MySQL con `.env.testing`, serve tornare a `XotBaseTestCase`. Doc `wiki/concepts/env-testing-cms-tests.md` annotata.
- `Feature/HomepageContentManagementTest` e `Feature/FilamentBlocksIntegrationTest` asseriscono testi di un altro progetto (`<nome progetto>`, `<slogan>`, `INIZIA ORA`): passano PHPStan ma non possono passare a runtime in Quaeris. Forma di neutralizzazione del repo: `beforeEach` con `cmsSkipTest(...)`.
- Nessun nuovo `@phpstan-ignore`, nessuna baseline, `phpstan.neon` non toccato.

## Ripresa dopo il merge del 12:14 e gate di memoria

- **Merge con conflitti nel working tree.** Alle 12:14 il repo `Modules/Cms` ha unito `laraxot/dev` (due commit di Malebestia sulla stessa lane: `3f3e8bdb`, `cb46df7a`) con un commit automatico locale. Conflitti: `app/Actions/ResolvePageAction.php`, `docs/00-INDEX.md`, `docs/00-index.md`, `docs/scopo.md`, `docs/wiki/scopo.md` e questa story (add/add). Nei file con marcatori (`<<<<<<<`) e' stata tenuta la versione locale (HEAD), che contiene sia il lavoro di questa lane sia il consolidamento della seconda sessione; `ResolvePageAction.php` era gia' senza marcatori e differiva da HEAD solo per una riga vuota finale, tolta. Nessun commit, reset o checkout da parte della lane: il merge e' stato chiuso dal sync automatico (`b11a406a`) e nel commit non restano marcatori (`git grep` su `app tests docs`).
- **Misura dopo il merge.** `phpstan analyse` sui 69 file del bucket, a batch da 8 e senza `-c`/`--level`/baseline: output vuoto alle 10:16 e alle 12:29 (exit 0). Il `ResourceExtensionTest` segnalato a 6 errori dal run intero delle 10:10 e' pulito nella versione delle 10:08:56 (`getFormClass()` ha `@return class-string<XotBaseResourceForm>`, quindi `new $formClass` e' tipizzato); l'errore e' del run precedente alla modifica o a una cache di dipendenze di quel momento. Rimisura finale gated: vedi report.
- **Gate di memoria.** Dalle 12:27 ogni run PHPStan passa da `flock` sul lock condiviso con `nice -n 10`, 8 file per volta. Una invocazione per errore senza lista di file (variabile vuota in zsh: `mapfile` non esiste) ha analizzato i `paths` della config, e' andata in `Allowed memory size of 2147483648 bytes exhausted` (exit 255) dopo 7 minuti; era sotto il gate, quindi non ha convissuto con altri run. Lezione: in zsh costruire le liste con `$(cat file)` o usare uno script `bash`, e controllare sempre che l'elenco non sia vuoto prima di lanciare PHPStan.

## Consolidamento del loader homepage e verifica finale

Fase BMAD: implementazione e quality gate. Seconda sessione sulla lane cms, avviata alle 09:43, quando la prima lavorava gia' sugli stessi file dalle 09:20. Le due sessioni hanno scritto per circa dieci minuti sugli stessi test (09:51-09:59) nonostante i lock `phpstan-wave-cms` presi alle 09:49. Questa sessione ha sostituito la versione intermedia di `tests/TestCase.php` (80 righe, con `createPHPUnitMock()` statico e il loader che restituiva `[]`) e ha lavorato sul resto solo dopo le 10:00, quando nessun `.php` del modulo cambiava da piu' di due minuti. E' il caso che il gate con mtime deve evitare (vedi [46-multi-agent-module-swarm](../../../../../bashscripts/docs/prompts/46-multi-agent-module-swarm.md)).

### Misura

| Momento | Errori |
|---|---|
| Baseline delle 09:00 sui 17 file del bucket (test `Feature/*`, `Unit/*`, `TestCase`, `TestHelper`) | 359 |
| 10:02, `phpstan analyse Modules/Cms/tests`, dopo la prima passata | 0 (exit 0) |
| 10:12, `phpstan analyse Modules/Cms` dopo il consolidamento (app e tests) | 0 (exit 0, output vuoto a parte la riga della config) |

### Cosa e' stato corretto in questa passata

- **Un solo loader per la homepage, senza path di progetto.** Cinque punti in tre file di test e `cmsHomepageBlocks()` leggevano `config_path('local/<nome progetto>/database/content/pages/home.json')`: un segnaposto letterale, un file che non esiste in nessun tenant di questo repo. Ora `TestCase::homepageJsonForBlocksArchitecture()` risolve la cartella con `GetTenantFilePathAction`, sceglie il JSON con slug `home` (il nome del file cambia: `home.json` nei test, `1.json` nelle docs), ne valida la forma (`id`, `content_blocks` per lingua, ogni blocco con `type` stringa e `data` oggetto) e **salta il test** se il tenant non ha la homepage. Il tipo di ritorno e' una array shape vera: spariscono alla radice i `offsetAccess.nonOffsetAccessible` su `mixed`, i `foreach.nonIterable` e le asserzioni `toBeArray()`/`toBeString()` ridondanti, che nei test sono state tolte perche' la forma la garantisce il loader. `TestCase::homepageBlocksForLocale()` restituisce i blocchi di una lingua e `cmsHomepageBlocks()` (PestHelpers) delega li': una sola sorgente.
- **`TestCase::createPHPUnitMock()`** era un metodo statico con `@phpstan-ignore method.staticCall` (`createMock()` e' un metodo d'istanza `final protected`). Ora e' un metodo d'istanza che chiama `$this->createMock()`, come `XotBaseTestCase::createUnitMock()`; nessun chiamante lo usa staticamente (`cmsCreateMock()`, `XotComposerTest`).
- **`TestCase::skipTest()`** faceva *fallire* il test (`fail('SKIP: ...')`). Ora e' `never` e chiama `markTestSkipped()`, come `XotBaseTestCase::skipTest()`; i chiamanti (`ResolvePageActionTest`) si aspettano uno skip.
- **`FilamentBuilderBlocksTest`, test di performance:** nel passaggio precedente era sparita la lettura del JSON tra i due `microtime()`: misurava il nulla. Ripristinata con il loader.
- **`Blocks` va costruito con una vista:** `new Blocks($blocks)` passava l'array al parametro `string $view` (`TypeError` a runtime). I test usano `'ui::components.render.blocks.v1'`, la stessa vista di `ThemeComposer`.
- **`ResourceExtensionTest`** passava PHPStan ma contraddiceva il prodotto: `XotBaseResource::getFormSchema()` e' `final`, di istanza e vuoto; lo schema vive in `{Resource}\Schemas\{Model}Form` (`XotBaseResourceForm`, commento della classe), per cui `assertNotEmpty((new PageResource)->getFormSchema())` e `isStatic()` non potevano passare. Allineato al comportamento documentato (regola 4): `getFormClass()`, `getResource()` per il legame form-Resource, schema letto dalla classe form; "non implementano `getPages()`..." ora verifica che il metodo non sia *dichiarato* dalla Resource (esiste ereditato).
- Docs: `testing.md` e `phpstan-compliance.md` descrivono il loader tenant-aware e i metodi d'istanza.

### Decisioni aperte per l'utente

- **Quaeris non ha il JSON della homepage** (`config/local/quaeris/database/` non esiste): i test di architettura dei blocchi si saltano con un messaggio. Se per questo progetto la homepage deve esserci, cambiare in `TestCase::homepageJsonForBlocksArchitecture()` `markTestSkipped` in `fail`. Restano i test che asseriscono testi di un altro progetto (`HomepageContentManagementTest`, `FilamentBlocksIntegrationTest`).
- **23 docblock `/** @var` e 3 cast `(string) $response->getContent()`** introdotti nella prima passata restano: `PageManagementBusinessLogicTest` 10, `TestHelper` 4, `CmsContentManagementTest` 3, `Auth/registertypetest` 3, `Unit/Models/PageTest` 2, `PestHelpers` 1 (`cmsJsonDecodeFile`, gia' in HEAD). La radice e' `@property array<array-key, mixed>` su `Page`, `PageContent`, `Section`: tipizzare li' la forma tradotta (lingua => lista di blocchi) e togliere i `@var` nei test. Serve decidere la forma, quindi non e' stato fatto in silenzio.
- **Docs del modulo:** la radice di `docs/` ha ancora centinaia di `.md` fuori posto (DOC-004/006 aperti in `docs/00-INDEX.md`), con guide stantie che descrivono `getFormSchema()` statico sulla Resource (`filament_forms.md`, `FILAMENT-RESOURCE-GUIDELINES.md`, `filament-resource-guidelines.md`). Non spostate ne' rinumerate.
