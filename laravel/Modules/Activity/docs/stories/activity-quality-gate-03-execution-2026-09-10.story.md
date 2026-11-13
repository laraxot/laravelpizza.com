# Story: Quality gate 03 — esecuzione, fix e blocco repo-wide — Activity

**Modulo**: Activity
**Tipo**: quality-gate (Build+Measure)
**Data**: 2026-09-10
**Agente**: claude-sonnet5-qgates

## Contesto

Richiesta utente: eseguire `bashscripts/docs/prompts/03-quality-gates.md` su questo
repo. Scope scelto: `Modules/Activity` (35 file `M` in git status, coerenti con lo
snapshot iniziale) + 1 doc `Modules/UI/docs/test.md`. `Modules/Xot` (598 file `M`) era
WIP di un'altra sessione — non toccato.

Lock presi/rilasciati per ogni file editato via `bashscripts/lock/{check,lock,unlock}.sh`
(3 lock stale >65h riacquisiti per età, nessuno rubato a sessioni vive).

## Cosa ho trovato e corretto

### 1. Pint — 9 file rossi → verdi
Import inutilizzati, whitespace, spaziatura attributi su Resource/Schemas/test. Fix
meccanico, riverificato con `pint --test`.

### 2. Blocco repo-wide (non colpa Activity): `getFormSchema()` static/non-static
`php artisan list`, PHPStan e Pest fatalizzavano ovunque:
```
Cannot make non static method XotBaseResourceForm::getFormSchema() static in class <X>Form
```
`XotBaseResourceForm::getFormSchema()` reso `abstract public` (non static) da un
refactor Xot in corso, ma 173 Form concrete in 13 moduli lo dichiaravano ancora
`static` — terza regressione della stessa regola di story 18.19/18.21 (`Modules/Xot/docs/stories/`).
Segnalato in `docs/chat/quality-gates-esecuzione-e-correzioni.md`, non corretto (fuori
scope, WIP di un'altra sessione). Risolto dall'altra sessione durante questa stessa
finestra di lavoro (residuo sceso da 173 a 1 file, poi a 0).

### 3. Fix reale — `ActivityFilamentExtendedTest.php` senza `uses(TestCase::class)`
Unico file su 30+ della cartella `tests/**` di Activity senza il binding. Causava
`BindingResolutionException: Target class [translator] does not exist` sul test che
chiama `DeleteAction::make()`. Aggiunto import + `uses(TestCase::class)`, allineato ai
gemelli.

### 4. Fix reale — `TestActivityModel.php`: `insteadof` su metodo inesistente
```php
use HasFactory, HasXotFactory {
    HasXotFactory::newFactory insteadof HasFactory; // <- newFactory() non esiste più su HasXotFactory
    HasXotFactory::factory insteadof HasFactory;
}
```
`HasXotFactory` (Xot) fornisce solo `factory()` da tempo (vedi commento nel trait
stesso: "DO NOT drop newFactory()" si riferisce al metodo `factory()`, il nome
`newFactory` nella docblock è residuo). La regola PHP: un `insteadof` su un metodo che
il trait non dichiara è fatal **all'autoload della classe**, non a runtime — bloccava
ogni test che referenziava `TestActivityModel`, inclusi quelli che non chiamano mai
`factory()`. Rimossa la riga, tenuta solo `HasXotFactory::factory insteadof HasFactory`.

## Trovato ma NON risolto — richiede decisione

### `TestActivityModel::factory()` non funziona per limite architetturale di `GetFactoryAction`
Test `'can use factory'` in `BaseModelBusinessLogicPestTest.php` fallisce con
`Call to a member function getPath() on null` (in `module_path()`, chiamato da
`Modules/Xot/app/Actions/Factory/GetFactoryAction::getFactoryPath()`).

Causa: `GetFactoryAction` estrae il nome del modulo con
`Str::of($model_class)->between('Modules\\', '\Models\\')` — richiede che il FQCN del
model contenga **esattamente** un segmento `\Models\`. `TestActivityModel` vive in
`Modules\Activity\Tests\Feature\TestActivityModel` (namespace `Tests\Feature`, per
design — la sua docblock dice esplicitamente "per testare BaseModel senza classi
anonime"), quindi `between()` non trova il delimitatore e ritorna l'intera stringa;
`module_path('Activity\Tests\Feature\TestActivityModel', ...)` cerca un modulo con
quel nome letterale, che non esiste → `find()` ritorna null → fatal.

Non è un bug isolato di Activity: `GetFactoryAction` è condivisa da tutto il monorepo e
il suo contratto (`\Models\` obbligatorio nel namespace) è incompatibile *by design*
con qualunque model-fixture di test tenuto fuori da `app/Models/`. Tre strade, nessuna
a rischio zero:

1. **Spostare `TestActivityModel` sotto un `\Models\` namespace/path reale** — ma il
   file è deliberatamente in `tests/Feature/` per non diventare un model di produzione.
2. **Estendere `GetFactoryAction`** per accettare anche path senza `\Models\` — tocca
   codice condiviso Xot, blast radius su tutti i moduli, non decidibile da questa
   sessione.
3. **Rimuovere l'asserzione `'can use factory'`** — perde un pezzo di copertura reale
   (verifica che `HasFactory`+`HasXotFactory` coesistano senza collisione), il resto
   della classe (18 test) passa.

Lasciato **non toccato**, riportato qui per decisione utente/prossima sessione.

## Pest — risultato pieno modulo (dopo risoluzione blocco #2)

```
Tests:    110 failed, 6 risky, 322 passed (5627 assertions)
Duration: 295.93s
```
Non ancora triagato riga per riga (Activity ha 90 file di test, alto rumore da carico
multi-agente sul DB MySQL `*_test` condiviso — 5 processi `pest` concorrenti osservati
durante la corsa).

### 5. Fix reale #3 — `XotBasePestActivityTest.php` senza `uses(TestCase::class)`
Ultimo failure visibile in coda alla corsa full-suite: `assertInstanceOf(TestCase::class,
$this)` falliva — **non era rumore da contesa**, riprodotto identico in isolamento
(`pest Modules/Activity/tests/Unit/XotBasePestActivityTest.php` da solo). Stessa causa
dei fix #3: file senza `uses(TestCase::class)`, `$this` era l'istanza di default Pest
(`P\...\XotBasePestActivityTest`), non `Modules\Activity\Tests\TestCase`. Aggiunto il
binding, 5/5 verdi dopo.

### Pattern confermato, non ancora chiuso: altri 15 file senza `uses(...)`
```
find Modules/Activity/tests -name "*.php" -not -path "*/Fixtures/*" \
  -not -name "TestCase.php" -not -name "Pest.php" -not -name "PestHelpers.php" \
  | xargs grep -L "^uses("
```
→ 18 file, di cui 2 non pertinenti (`PestStubs.php` è un helper non-test,
`TestActivityModel.php` è il model-fixture del fix #4, non un test). Restano **16 file
candidati**. Campione ispezionato (`CanPaginateUnitTest.php`,
`ActivityLoggerPartialMockTest.php`, `ListLogActivitiesPureMethodsTest.php`): sembrano
unit test deliberatamente "senza database" (uno lo dichiara nel nome del test stesso),
quindi **non tutti vanno corretti allo stesso modo** — aggiungere `uses(TestCase::class)`
a un file che non ne ha bisogno introduce `DatabaseTransactions` e rallenta/rischia di
rompere test che oggi passano senza DB. Ogni file va giudicato singolarmente: serve solo
se referenzia `TestCase` nella propria docblock/asserzioni (come i 3 già corretti) o
tocca funzionalità che richiedono il container pieno (`trans()`, facade non ancora
bootate). Lista completa dei 16 candidati, non ancora processati:

```
Modules/Activity/tests/Unit/ListLogActivitiesPageTest.php
Modules/Activity/tests/Unit/CanPaginateUnitTest.php
Modules/Activity/tests/Unit/CanPaginatePaginateQueryTest.php
Modules/Activity/tests/Unit/PestExtendBootstrapTest.php
Modules/Activity/tests/Unit/Filament/ListLogActivitiesPureMethodsTest.php
Modules/Activity/tests/Unit/Filament/ListLogActivitiesRemainingCoverageTest.php
Modules/Activity/tests/Unit/Filament/ListLogActivitiesDeepCoverageTest.php
Modules/Activity/tests/Unit/Actions/QueryAndValidationTest.php
Modules/Activity/tests/Unit/Actions/CoverageHundredActionsTest.php
Modules/Activity/tests/Unit/Actions/RestoreActivityActionExecuteTest.php
Modules/Activity/tests/Unit/Actions/LogActivityActionConstructorTest.php
Modules/Activity/tests/Unit/Actions/LogActivityActionExecuteValidationTest.php
Modules/Activity/tests/Unit/Actions/ActivityActionsUnitTest.php
Modules/Activity/tests/Unit/Actions/ActivityLoggerPartialMockTest.php
Modules/Activity/tests/Unit/Adapters/AdapterActivityLoggerDelegationTest.php
Modules/Activity/tests/Unit/Adapters/AdapterActivityRecorderTest.php
```

**Prossimo passo consigliato**: per ciascuno, `pest <file>` isolato; se rosso e
l'errore è da container mancante (translator/facade/DB), aggiungere
`uses(TestCase::class)`; se verde così com'è, lasciare stare (unit test puro, più
veloce senza boot Laravel). Questo copre solo una parte dei 110 failure iniziali — il
resto va comunque triagato file per file, rerun fuori da orario di picco multi-agente
per escludere contesa DB.

## Documentazione aggiornata

- `bashscripts/docs/prompts/03-quality-gates.md` → v3.25.0 (path PHPMD, PHPInsights
  assente, gotcha getFormSchema, gotcha parser PDepend/PHP 8.4). Bug residuo trovato da
  un'altra sessione (riga 499 del blocco bash, stesso `../phpmd.xml` non corretto) —
  lock occupato al momento della scoperta, non ancora applicato.
- `docs/chat/quality-gates-esecuzione-e-correzioni.md` — coordinamento multi-agente.

## Definition of Done

- [x] Pint verde su scope Activity
- [x] PHPStan verde su `Modules/Activity` (dopo sblocco repo-wide)
- [x] 3 fatal reali trovati e corretti (2× uses(TestCase) mancante, 1× insteadof stale)
- [ ] Pest full-module: 110 failed, 16 file candidati per pattern "uses() mancante"
      identificati e non ancora processati uno per uno (vedi sopra)
- [ ] `TestActivityModel::factory()` — decisione architetturale in sospeso
- [ ] Riga 499 di `03-quality-gates.md` — path PHPMD da correggere (lock occupato)
