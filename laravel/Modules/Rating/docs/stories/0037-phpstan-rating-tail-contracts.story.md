---
tags: [documentation]
qmd: "2.3.phpstan rating tail contracts.story"
issues: []
discussions: []
title: "Rating: contratti statici della coda test"
type: story
module: Rating
epic: 2
story_id: "RATING-2.3"
slug: phpstan-rating-tail-contracts
status: review
created: 2026-08-24
updated: 2026-11-19
repository: "https://github.com/laraxot/module_rating_fila5"
github_issue: ""
github_discussion: ""
estimated_effort: "2-4h"
blocked_by: ["RATING-2.2"]
blocks: ["XOT-5.23"]
related: ["RATING-2.2", "XOT-5.23"]
owned_scope:
  - laravel/Modules/Rating/tests/Unit/BaseRatingModelTest.php
  - laravel/Modules/Rating/tests/Unit/RatingFilamentExtendedTest.php
  - laravel/Modules/Rating/tests/Unit/RatingPolicyRolesTest.php
  - laravel/Modules/Rating/tests/Unit/RatingPolicyTest.php
  - laravel/Modules/Rating/tests/Unit/StatsOverviewWidgetTest.php
---
# Story RATING-2.3: contratti statici della coda test

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Story

Come owner del modulo Rating, voglio eliminare gli ultimi undici findings statici nei test
modellando generics, risultati riflessivi e identità di profilo con i contratti reali, così
che Rating possa consegnare a XOT-5.23 un modulo verificabile senza scorciatoie.

## Baseline e cause radice

La cold analysis consegnata da RATING-2.2 conta **11 findings in 5 file**, tutti compresi
nello scope esclusivo di questa story:

| File | Findings | Cause radice |
|---|---:|---|
| `BaseRatingModelTest.php` | 3 | `Builder` mock senza modello generico |
| `RatingFilamentExtendedTest.php` | 3 | risultati Reflection trattati come `mixed`; chiamata a API Filament deprecata |
| `RatingPolicyRolesTest.php` | 1 | fixture assegna stringa a `ProfileContract::$matr` (`int|null`) |
| `RatingPolicyTest.php` | 2 | stessa divergenza di identità matricola in due scenari owner |
| `StatsOverviewWidgetTest.php` | 2 | `Collection` e `MorphToMany` mock senza generics |

I cluster sono piccoli e condividono un unico obiettivo di chiusura del modulo; uno shard
ulteriore aumenterebbe il costo di coordinamento senza creare parallelismo utile.

## Acceptance Criteria

<!-- LOCKED. External dev tools must not edit Acceptance Criteria. -->

1. I builder e le relazioni mock dichiarano modelli, declaring model, pivot e accessor
   coerenti con le firme Eloquent effettivamente esercitate; nessun generic resta grezzo.
2. I risultati ottenuti tramite Reflection sono validati e ristretti prima dell'uso con
   verifiche semanticamente rilevanti; nessun cast di comodo o assert tautologico.
3. I test Filament verificano l'API corrente di configurazione tabella e non invocano
   direttamente `getTableColumns()` deprecato per placare o aggirare PHPStan.
4. Le fixture policy usano `int|null` per `ProfileContract::$matr` e preservano i rami
   comportamentali di ownership: coincidenza, divergenza, profilo assente e `user_id`.
5. `phpstan analyse Modules/Rating` termina con zero findings e i cinque test mirati
   restano verdi, senza modifiche a sorgenti production o file fuori `owned_scope`.
6. Non vengono introdotti `@phpstan-ignore`, baseline, `ignoreErrors`, nuovi `.neon`,
   `mixed` evitabili, Service/Action proxy, test spenti o test staticamente tautologici.

## Tasks / Subtasks

<!-- LOCKED. External dev tools must not edit Tasks / Subtasks. -->

- [ ] Tipizzare i tre `Builder<Rating>` usati dagli scope test e preservare le aspettative
  sulle clausole `extra_attributes`. (AC: #1, #5)
- [ ] Sostituire il percorso Filament deprecato con un'osservazione dell'API tabella
  supportata e restringere i valori riflessivi prima delle assertion. (AC: #2, #3)
- [ ] Allineare le matricole dei mock `ProfileContract` e degli host valutati al dominio
  `int|null`, mantenendo distinti tutti i rami owner/non-owner. (AC: #4)
- [ ] Tipizzare collection e `MorphToMany` dello stats host con `Rating`, host, pivot e
  accessor reali; mantenere verifiche su stat e totali osservabili. (AC: #1, #2)
- [ ] Eseguire i gate definiti nella sezione Testing, inventariare eventuali residui e
  compilare il Dev Agent Record prima del passaggio a review. (AC: #5, #6)

## Dev Notes

<!-- LOCKED. External dev tools must not edit Dev Notes. -->

- [Source: Modules/Rating/docs/bmad/prd.md#Goals--Success-Metrics] Il risultato di dominio è
  PHPStan L10 al 100% con integrazione XotBase coerente.
- [Source: bmad-output/architecture.md#ADR-001] Usare esclusivamente
  `laravel/phpstan.neon`; vietati baseline, exclude e configurazioni alternative nel repo.
- [Source: bmad-output/architecture.md#ADR-011] Preferire tipo nativo, union e generic;
  `mixed` è ammesso solo quando non restringibile e con motivazione esplicita.
- [Source: bmad-output/architecture.md#ADR-016] Pest 5 e i relativi contratti sono forniti
  dal modulo Xot; non cambiare dipendenze o bootstrap per risolvere questa coda.
- [Source: bmad-output/architecture.md#ADR-018] La chiusura richiede PHPStan modulo,
  quality gate disponibili e prova documentata; il gate globale resta di XOT-5.23.
- [Source: Modules/Rating/docs/stories/2.2.phpstan-rating-test-contracts.story.md#Verifiche-e-residui]
  La baseline cold è 11 e i cinque file qui posseduti sono esattamente lo shard residuo.
- La deprecazione Filament è un segnale di contratto: non sopprimerla e non duplicare
  l'implementazione della resource nel test. Verificare un effetto pubblico/supportato.
- Non ampliare lo scope a policy, widget o resource production senza un nuovo amendment
  BMAD autorizzato; se l'API supportata richiede una modifica production, fermarsi e
  registrare il blocker anziché decidere unilateralmente.

## Testing

<!-- LOCKED. External dev tools must not edit Testing. -->

- Sintassi: `php -l` sui cinque file in `owned_scope`.
- Static mirato sui cinque file durante lo sviluppo, poi cold canonicale:
  `cd laravel && ./vendor/bin/phpstan analyse Modules/Rating --no-progress`.
- Pest mirato sui cinque file con `Modules/Rating/phpunit.xml`, senza coverage e senza
  migrazioni distruttive; mantenere assertion sui filtri scope, schema Filament, policy
  ownership e quattro stat widget.
- PHPMD e PHP Insights secondo ADR-018 se disponibili; un failure del toolchain vendor va
  riportato testualmente nel Dev Agent Record, non aggirato con config o dipendenze.
- Verifica negativa finale su scope per suppression, baseline, test skipped e tautologie.
- Il PHPStan globale `Modules` è responsabilità della meta-story XOT-5.23 e non blocca il
  passaggio a review quando il cold module Rating è zero.

## Dependencies

- **Blocked by:** RATING-2.2, che ha corretto i contratti trait e prodotto la baseline cold
  riconciliata.
- **Blocks:** XOT-5.23, che integra i moduli e possiede il gate PHPStan globale finale.

## Owned File/Module Scope

Solo i cinque file elencati in `owned_scope` possono essere modificati dal dev agent.
Story e documentazione Rating possono essere aggiornate esclusivamente per Dev Agent Record,
stato e learnings. Nessun sorgente `app/`, configurazione, fixture condivisa o altro modulo.

## Learnings from Previous Stories

- RATING-2.2 ha dimostrato che molti findings erano cascata da identità PSR-4 errate; qui
  restano invece cinque contratti locali indipendenti e già misurati.
- I generics dei test devono descrivere davvero il modello correlato: annotare soltanto la
  classe contenitore non basta con template invarianti Eloquent.
- Le deprecazioni non sono rumore statico: segnalano un test ancorato a una superficie
  legacy e richiedono una verifica comportamentale sulla API corrente.
- Le proprietà dei contratti Xot sono dominio condiviso: `matr` è `int|null`; usare valori
  stringa nei mock falsifica sia PHPStan sia il ramo di ownership che si intende provare.

## Dev Agent Record

### Implementazione

- Tipizzati i mock degli scope come `Builder<BaseRating>`: il primo tentativo con
  `Builder<Rating>` ha evidenziato correttamente l'invarianza del template e il fatto che
  `scopeWithExtraAttributes()` appartiene alla base astratta.
- Tipizzati collection e relazione stats con `Rating`, declaring model, `MorphPivot` e
  accessor `pivot` senza cambiare il comportamento dei mock.
- Sostituita la chiamata diretta a `ListRatingMorphs::getTableColumns()` deprecata con la
  configurazione pubblica `table(Table::make($page))` e l'ispezione delle colonne risultanti.
- I risultati Reflection vengono prima verificati come array, poi usati per le assertion
  su chiavi e cardinalità.
- Allineate le matricole delle fixture policy a `int`, preservando i casi coincidente,
  divergente, profilo assente e ownership via `user_id`.

### Verifiche

- `php -l`: **5/5** file senza errori di sintassi.
- PHPStan cold `Modules/Rating`: **0 findings**.
- Pest mirato: **48 passed, 119 assertions**.
- Ricerca negativa: nessuna suppression PHPStan, baseline, skip o tautologia nei file.
- PHPMD non avviabile per incompatibilità vendor tra `PdependExtension::load()` e il tipo
  `void` richiesto da Symfony; PHP Insights non è installato.
- Graphify non eseguito per istruzione esplicita dell'orchestratore.

### File modificati

- `tests/Unit/BaseRatingModelTest.php`
- `tests/Unit/RatingFilamentExtendedTest.php`
- `tests/Unit/RatingPolicyRolesTest.php`
- `tests/Unit/RatingPolicyTest.php`
- `tests/Unit/StatsOverviewWidgetTest.php`

### Handoff

- RATING-2.3 è pronta per review: il cold module Rating è a zero. Il gate globale
  `Modules` resta responsabilità di XOT-5.23.

## Ripresa 2026-11-19: PHPStan di nuovo a 71 dopo la sync del mattino

### Cosa era successo

La sync automatica del 19 novembre (commit root `4a268e3c78`, "riparata" da `efeec2ebd3`) ha
copiato nel root una **generazione vecchia** del modulo, quella del repo `module_rating_fila5`
(commit `48b9866` del 17 novembre, che aveva tolto `RatingContract` da `BaseRating`). Il modulo
si e' trovato con due generazioni mescolate: `RatingData`, `HasRatingsTrait`, i test e le doc
della generazione nuova; `BaseRating`, `Rating`, `RatingMorph`, `HasRating`, `RuleEnum`, le
Resource Filament e la factory della generazione vecchia. Da qui 71 errori PHPStan su Rating e 1
su Blog.

Lo stato di riferimento e' il root prima della sync, `79104ed867`.

### Decisioni, una per una (con la prova)

| Sintomo | Decisione | Perche' |
|---|---|---|
| `Rating` non e' un `RatingContract` (`formFieldLabel`, `ratingFieldName`, `ratingValuePath`, `criteriaToXlsFields`, `decorateRatingField`, closure `reject`) | ripristinato `BaseRating` di `79104ed867` | li' `BaseRating implements HasMedia, RatingContract, Sortable`, con `getLabel()`; la regola `wiki/rules/rating-contract-over-baserating.md` e la story 5.233 lo danno per acquisito. Il test aveva ragione, il codice era regredito. |
| `Builder::ordered()` / `MorphToMany::ordered()` non esiste | ripristinato (stesso file) | `ordered()` e' lo scope di `SortableTrait` (spatie/eloquent-sortable), che la sync aveva tolto. |
| `getValueHtml()`, `getNoteHtml()`, `getTxtHtml()`, `resolveSelectedChild()`, `$xls_export_value`, `$pivot` | ripristinati (stesso file) | metodi del criterio a scelta multipla (`docs/criteri-a-scelta-multipla.md`) usati dal PDF della scheda e dall'export XLS: comportamento voluto, documentato dai test. |
| `RuleEnum::ZeroFour` / `ZeroSix` | ripristinati da `79104ed867` | sono i tetti dell'art. 17 c. 6 del CCI 2026-2028 (story `IndennitaResponsabilita` 8.22); la sync li aveva tolti. |
| `morphToManyX(pivotClass: ...)` in `HasRating` | `HasRating` ripristinato; **test aggiornato** | `RelationX::morphToManyX()` non ha mai avuto `pivotClass` (`git log -S'pivotClass'` su Xot: nessuna firma, solo variabili locali omonime). Il pivot `RatingMorph` arriva gia' da `guessMorphPivot()`. `HasRatingPivotTest` (arrivato con la sync) tiene la sola guardia "il pivot e' `RatingMorph`", riscritta in Pest; il caso `pivotClass` e' tolto. `RelationX` non e' stato toccato. |
| `$this->id` su host anonimo in `HasRating` | `$this->getKey()` | il trait e' `@phpstan-require-extends Model`: la chiave si chiede al model, non a una proprieta' magica che l'host puo' non dichiarare. |
| `ArticleData:135` (Blog) `array<int\|string, ...>` | nessuna modifica a Blog | l'errore nasceva dal `getArrayRatingsWithImage()` della generazione vecchia (`array<int\|string, ...>`); col `HasRating` ripristinato torna `array<int, ...>`. |
| `RatingMorph extends BaseMorphPivot`, `RatingResource`/`RatingMorphResource`/`RatingForm`/`RatingInfolist`/`RatingFactory` senza le basi `Base*` | ripristinati da `79104ed867` | la generazione nuova mette forma e comportamento nelle basi `Base*` del modulo owner e lascia alle concrete solo il model/la connection. |
| `GetRatingOptsByModelAction`, `HasRatingContract`, migrazioni `create_ratings_table` (`json` al posto di `schemalessAttributes`) | ripristinati da `79104ed867` | stesse ragioni: versione vecchia arrivata con la sync. |
| test `RatingApiTest`, `RatingTest`, `ListRatingsPageTest`, `TestCase` in stile PHPUnit a classi, `tests/Support/Ensure.php` + `ratingEnsure()` in `tests/Pest.php` | ripristinati da `79104ed867`; `Ensure` tolto | il progetto e' solo Pest con `uses(TestCase::class)` per file; `tests/Pest.php` non viene eseguito dal runner root (resta il solo commento). |

### Probe PHPStan tolti

Regola `bashscripts/ai/wiki/rules/phpstan.md`: niente classi che esistono solo
perche' PHPStan analizzi un trait.

- `app/Models/RatingPhpstanTraitProbe.php` — tolto (HasRating e' gia' usato da Blog, Fixcity e dal test).
- `app/Filament/Concerns/DecoratesRatingFormFieldsPhpstanProbe.php` — tolto (il trait e' usato da `DecoratesRatingFormFieldsTest`).
- `app/Models/RateableHost.php` — arrivato con la sync, stesso scopo dichiarato: tolto.
- `app/Models/Traits/RatingTrait.php` — tolto: zero consumer in tutti i `_bases`, chiamava
  `morphRelated()` che non esiste, e reggeva solo grazie a `@phpstan-ignore trait.unused`.
- `AbstractRatingsHost` resta: non e' un probe nominale, lo usano `RatingsHostStub` e la sua factory.

### Ignore tolti

- `BaseRating::linkedTo()` — `@phpstan-ignore return.type` sostituito da `@return MorphTo<Model, $this>`.
- `HasRating` — `@phpstan-ignore trait.unused` (falso: il trait ha consumer).
- `RatingFilamentSchemaTest` — tre `@phpstan-ignore-next-line` coprivano chiamate statiche a metodi
  d'istanza (`getFormSchema`, `getFormColumns`, `getSteps`, `getInfolistSchema`): ora si istanzia.

### Test aggiornati perche' stantii (non regressioni del codice)

- `RatingFilamentSchemaTest`: `RatingForm` ha `parent_id` (albero dei criteri); `RatingMorphForm`
  non e' piu' uno stub vuoto (`rating_id`, `value`, `percentage`, `note`) e passa nel controllo
  degli schema indicizzati, come chiedeva il commento del test stesso.
- `RatingFilamentExtendedTest`: `BaseRatingsTable` non mostra `order_column` di proposito
  (commento nella tabella, story 5.96).
- `RatingTest`: la tabella del pivot e' `rating_morph` (singolare, vedi `RatingMorphModelTest`);
  ora il test la chiede al model invece di scriverla a mano.

### Verifica

- `./vendor/bin/phpstan analyse Modules/Rating Modules/Blog` → **0 errori** (da 71 + 1).
- Pest (scratch DB, `bashscripts/tools/pest-scratch-db.sh`): 169 passati, 5 saltati, **10 falliti**.

### Aperto (preesistente, non dovuto alla sync)

I 10 rossi stanno in file identici a `79104ed867` e dipendono dall'harness, non dal dominio:

- `HasRatingsTraitAccessorsTest` (4): `Rating::getClassName()` risolve il chiamante con
  `debug_backtrace` cercando `Models\` nel nome della classe; `RatingsHostStub` vive in
  `Tests\Fixtures` e non viene trovato. Lo stub lo aggira gia' per `ratings()` e
  `ratingMorphs()`, non per `myRatings()`/`syncRatingsWhere()`/`ratingObjectives()`.
- `RatingFilamentExtendedTest` (2): `BaseRatingsTableStub` fuori da un namespace di Resource
  (`XotBaseResourceTable::getResource()`); `ListRatingMorphs` istanziata fuori da Livewire non
  ha colonne e il test si aspetta colonne `ratingable_*` che il model non ha.
- `ListRatingsPageTest` (2), `RatingFilamentRelationManagerTest` (2): pagine/relation manager
  Filament istanziati senza `ownerRecord`/contesto Livewire.

Da fare in una story dedicata: test Filament via `Livewire::test()` invece di `new Page`.

### Nota sul mirror

Il repo `module_rating_fila5` (branch `dev`, `48b9866`) contiene ancora la generazione vecchia:
finche' non viene portata li' questa versione, il prossimo "mirror al root" la riporta indietro.

## Seguito 2026-11-19: i 10 rossi chiusi

Pest Rating: 169 passati / 5 saltati / **10 falliti** → 179 passati / 5 saltati / **0 falliti**.
Nove su dieci erano test sbagliati; uno ha trovato un difetto reale nel codice.

| Test | Causa | Decisione |
|---|---|---|
| `HasRatingsTraitAccessorsTest` (4: `myRatings`, `ratingObjectives`, `syncRatingsWhere` x2) | `Rating::getClassName()` cerca nel backtrace una classe con `Models\` e lancia se non la trova: voluto (story 5.90, 18.55 caveat 2). `RatingsHostStub` vive in `Tests\Fixtures`. | **test**: nuove fixture `tests/Fixtures/Models/{RatingsHost,Rating,RatingMorph}` (host in un namespace `Models\`, con il proprio `Rating`/`RatingMorph` come ogni modulo reale; stesso schema della fixture `Extra` di Xot). In piu' `syncRatingsWhere` aspettava `sync()`: il codice usa `syncWithoutDetaching()` di proposito (commento nel trait), e dopo la sync ricarica `ratings`. |
| `RatingFilamentExtendedTest` «BaseRatingsTable…» | `BaseRatingsTableStub` fuori da `{Resource}\Tables\`; poi chiedeva il gruppo `bulk`, tolto da `BaseRatingsTable` il 2026-10-15 (Rating `feed303`). | **test**: lo stub dichiara `getResource()` = `RatingResource`; atteso `delete` (hook di `HasXotTable`). |
| `RatingFilamentExtendedTest` «ListRatingMorphs…» | `ListRecords::table()` restituisce la Table intatta: la costruisce la Resource. Il test si aspettava inoltre `rating`, `ratingable_type`, `ratingable_id`. | **test e codice**: il test costruisce la tabella via `ListRatingMorphs::getResource()::table()`. `RatingMorphsTable` (la Table class davvero usata) aveva tre colonne inesistenti in `rating_morph`; `rating` era `searchable()` → `WHERE rating LIKE` su colonna inesistente. Ora le colonne sono quelle dello schema, il criterio da `rating.title`. |
| `ListRatingsPageTest` (2) | Gli hook `getTable*()` di `XotBaseListRecords` restituiscono `[]` per contratto; la tabella vive in `RatingsTable`. | **test**: filtri/azioni verificati su `RatingsTable` (con guardia `RatingResource::getTableClass() === RatingsTable::class`). |
| `RatingFilamentRelationManagerTest` (2) | Relation manager senza `ownerRecord` (Livewire lo assegna al mount). | **test**: `ownerRecord = new RatingsHost` prima di `table()`; nessun `Livewire::test()`: lo schema della tabella non richiede rendering ne' DB. |

File: `app/Filament/Resources/RatingMorphResource/Tables/RatingMorphsTable.php`; `tests/Fixtures/BaseRatingsTableStub.php`,
`tests/Fixtures/Models/{RatingsHost,Rating,RatingMorph}.php` (nuovi); `tests/Unit/{HasRatingsTraitAccessorsTest,RatingFilamentExtendedTest,ListRatingsPageTest,RatingFilamentRelationManagerTest}.php`;
`docs/testing-and-coverage.md`, `docs/filament-table-architecture.md`. Pint ha anche riformattato (solo stile) `RatingsHostStub`,
`BaseEditRatingStub`, `RatingsHostStiChildStub`, `LikeableStub`.

Resta: `RatingMorphTable` (singolare) non e' scelta da `getTableClass()` (vince il plurale dal model): duplicato da decidere.
PHPStan `Modules/Rating Modules/Lang Modules/AI`: 0 errori.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

- `./vendor/bin/phpstan analyse Modules/Rating Modules/Blog` → **0 errori** (da 71 + 1).
- Pest (scratch DB, `bashscripts/tools/pest-scratch-db.sh`): 169 passati, 5 saltati, **10 falliti**.
