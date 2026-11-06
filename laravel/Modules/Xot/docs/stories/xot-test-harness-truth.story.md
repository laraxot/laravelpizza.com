---
title: "Xot: il banco di prova dice la verita' (binding Pest, suffissi, test finti)"
type: story
status: ready-for-dev
priority: P1
created: 2026-10-20
updated: 2026-10-20
module: Xot
epic: ../bmad/epic-code-quality-ratchet.md
depends_on: [test-database-guard]
related: [dcp-222-strumenti-di-prova-che-non-girano-o-non-dicono-la-verita, phpstan-xot-tests-without-assertions, dcp-45-isolamento-db-test-pest-scratch]
tags: [test, pest, harness, suffisso, binding, sqlite, tautologie, ratchet-w2]
qmd: "xot test harness verita pest binding TestCaseAlreadyInUse suffisso Test.php maiuscole sqlite tautologie catch vuoti SimpleModelsTest"
---

# Xot: il banco di prova dice la verita'

Fase BMAD: Plan (scheda di lavoro per domani). Scritta senza eseguire Pest, PHPStan o artisan. Le cifre sono del 2026-10-20 13:50-14:00 UTC e volatili.

## Richiesta
Ordine permanente dell'utente: migliorare la qualita' del codice con BMAD + second brain + filament blueprint, andando alla sorgente e capendo lo scopo, non il messaggio d'errore. Qui: i test devono provare qualcosa, e devono girare dove si dice che girano.

## Scopo
Un test serve a far fallire il build quando il comportamento si rompe. Oggi (a) 23 file con test veri non vengono mai raccolti, (b) il TestCase di modulo e' legato in due modi che possono collidere, (c) molti test passano senza asserire, (d) alcuni toccano sqlite o lanciano `migrate` contro la regola "i test girano su MySQL `*_test`". Una suite verde che non guarda da' fiducia falsa: e' peggio di una rossa. Ricostruito da `phpunit.xml:10-12`, dal sorgente di Pest 5.3.1 e dagli stub PascalCase scritti dalle lane PHPStan al posto dei corpi originali (i corpi veri stanno nei file minuscoli).

## Stato misurato
| Fatto | Valore | Comando che lo riproduce (da `laravel/`) |
|---|---|---|
| Pest carica solo `tests/Pest.php` | `BootFiles.php:25-47`; `laravel/Pest.php` (23 righe) non e' caricato da nessuno | `sed -n 25,47p vendor/pestphp/pest/src/Bootstrappers/BootFiles.php`; `rg -n 'Pest\.php' composer.json phpunit.xml` (zero) |
| Doppio binding | `TestRepository.php:163-165` lancia `TestCaseAlreadyInUse`. File con `uses(...TestCase)` in cartelle legate dal `Pest.php` di modulo: Xot 176/196, User 139/159, Quaeris 38/40 (solo `Feature`), Cms 11/134, Chart 6/7, Limesurvey 3/3, Notify 2/131 | `rg -lUP '(?m)^\s*(uses\|pest\(\)->(use\|uses\|extend))\([^;]*TestCase' --glob '*Test.php' Modules/<M>/tests/Feature Modules/<M>/tests/Unit \| wc -l` |
| File con test mai raccolti (suffisso `Test.php` e' case-sensitive) | 23 | `rg -lP '^\s*(it\|test)\s*\(\|function\s+test[A-Za-z0-9_]*\s*\(\|#\[Test\]' --glob '*.php' Modules/*/tests tests \| rg -v 'Test\.php$' \| rg -v 'Modules/Xot/tests/(FilamentSchemaCoverage\|Module(Business\|Deep\|Execute\|Remaining)Coverage\|PestStubs)\.php$' \| wc -l` (controprova: lo stesso `rg` senza il filtro suffisso trova 192 file Xot che girano) |
| `assertGreaterThanOrEqual(0` nei test Xot | 31, tutti nei 5 harness `Xot/tests/{FilamentSchemaCoverage,ModuleBusiness...}.php` | `rg -nP 'assertGreaterThanOrEqual\(\s*0\s*,\|toBeGreaterThanOrEqual\(\s*0\s*\)' Modules/Xot/tests --glob '*.php' \| wc -l` |
| File di test che chiamano l'harness Xot | 31 (Job 4, Media 5, Notify 5, UI 5, User 5, Xot 7); 92 `catch (\Throwable)` nell'harness | `rg -lP '(ModuleDeepCoverage\|ModuleBusinessCoverage\|ModuleExecuteCoverage\|ModuleRemainingCoverage\|FilamentSchemaCoverage)::' --glob '*Test.php' Modules \| wc -l` |
| `catch` vuoti nei test Xot | 99 (58 in `Unit/XotExecuteCoverage50Test.php`) | `php <tokenizer read-only>`: stesso metodo del censimento, vedi Verifica |
| sqlite attivo | 9 test Xot con override inline; 9 `tests/TestCase.php` di modulo (Activity, Gdpr, Job, Lang, Media, Tenant, UI, User, Xot) | `rg -lP "database\.default'\s*,\s*'sqlite'\|:memory:\|prepareSharedSqliteForTesting\(" Modules/Xot/tests --glob '*Test.php'` |

## Lavoro
1. **Probe del binding, senza eseguire.** Se `Modules/Chart/tests/Pest.php:11` (`extend(TestCase)->in(Unit, Feature)`) e le 6 `uses()` nei file collidono, `pest --test-directory=Modules/Chart/tests --list-tests` lancia `TestCaseAlreadyInUse` in raccolta (`Shard.php:209` usa lo stesso flag). Perche': decide come si uniformano ~400 file. Fix: un solo meccanismo per modulo. Rischio medio (centinaia di file). Il probe NON si lancia ora: serve la guardia DB provata e il via dell'utente.
2. **23 file mai raccolti** (elenco col comando sopra: AI 1, Cms 11, Gdpr 1, Geo 3, Media 2, Notify 2, User 2, Xot 1). Perche': i corpi veri sono nei minuscoli, gli stub PascalCase rimandano a loro. Fix: per le coppie diff e corpo nel nome giusto (scala di `10-test.md` se il SUT manca); per i file senza controparte rinomina in `*Test.php`. In Xot: `Unit/metatagdatatest.php` contro `MetatagDataTest.php` (5 test ciascuno, 205 byte di scarto). Rischio medio. Cms e Geo hanno la loro story.
3. **`pest.php` e `laravel/Pest.php`.** `Modules/Xot/tests/pest.php` e' identico a `Pest.php` (`cmp`): rimuovere il minuscolo. `laravel/Pest.php` e' codice morto ma `../docs/project-documentation.md:119` lo descrive come attivo: correggere la riga o dare vita al file (decisione 2). Rischio basso.
4. **`Unit/SimpleModelsTest.php:23-25`**: `Artisan::call('migrate', ['--env'=>'testing','--force'=>true])` senza asserzione. Prova solo che non lancia, su un DB non controllato. Fix: togliere il test o asserire sullo stato delle tabelle in un DB `_test`. Rischio basso.
5. **sqlite** (9 test + 9 TestCase). Regola: MySQL `*_test`, mai sqlite (`data-sacred-no-destructive-db.md`). Fix: tabella temporanea MySQL (modello `Quaeris GetAnswersByQuestionChartTest`). Rischio alto: serve un DB `_test` o scratch (`pest-scratch-db.sh`). Dipende dalla decisione 3.
6. **Harness e tautologie** (`ModuleDeepCoverage.php:145,175,236` e gli altri 28): `catch (\Throwable)` + `>= 0` produce copertura, non verifica. Fix: asserire un conteggio reale o togliere il metodo; non contare l'harness come copertura. Rischio medio (la copertura percepita scende).
7. **99 `catch` vuoti nei test Xot**: un test che inghiotte l'eccezione non e' falsificabile. Fix: rilanciare o `expect(fn)->toThrow(...)`. Rischio basso.
8. **`laravel/tests/Unit/ExampleTest.php:8` (`expect(true)->toBeTrue()`) e `laravel/tests/Feature/SimpleTest.php` (`expect(1)->toBe(1)`)**: tautologie eseguite dalla suite, fuori dai moduli (regola `tests-in-modules-only`). Fix: cancellare, zero riferimenti da verificare. Rischio basso.

## Acceptance criteria
- [ ] Il comando dei file mai raccolti stampa 0 (oggi 23).
- [ ] `find Modules/Xot/tests -name pest.php` non stampa nulla.
- [ ] Il comando delle tautologie stampa 0 su `Modules/Xot/tests`.
- [ ] `rg -n "Artisan::call\('migrate" Modules/Xot/tests` non stampa nulla.
- [ ] Nessun file in `Modules/Xot/tests` contiene `sqlite`, `:memory:` o `prepareSharedSqliteForTesting` (tranne `TestDatabaseGuard.php`).
- [ ] Dopo il via: `pest --test-directory=Modules/Xot/tests --list-tests` e lo stesso per Chart escono 0 senza `TestCaseAlreadyInUse`.

## Verifica
Contatore dei `catch` vuoti (sola lettura): script `token_get_all` che segna ogni `T_CATCH` il cui corpo ha solo `T_WHITESPACE`, `T_COMMENT`, `T_DOC_COMMENT`; sul perimetro `Modules/Xot/tests` trova 99; sul perimetro `Modules/*/app` ne trova 25 (Xot 11), cioe' il metodo discrimina (non e' un falso zero). Per ogni zero, rilanciare il `rg` su un file noto che contiene il pattern. `cmp Modules/Xot/tests/pest.php Modules/Xot/tests/Pest.php` deve dire identici prima di cancellare.

## Vincoli
- Nessun Pest/PHPUnit finche' la guardia DB non e' dentro e l'utente non ha confermato che i DB `*_test` sono usa-e-getta (`test-database-guard.story.md`: scritta, non provata a runtime).
- PHPStan solo mirato e in coda `flock` di `11-phpstan.md`; un solo run completo a swarm fermo e a RAM libera. `laravel/phpstan.neon` immutabile.
- Un solo agente per modulo che edita PHP. Forward-only (niente checkout/reset/restore/stash). Pest resta Pest (non convertire a PHPUnit).
- Niente nuovi `*Service`; logica in Spatie QueueableAction con `execute()`. Niente `mixed`, `@var`, ignore di comodo.

## Decisioni aperte
1. Un solo meccanismo di binding: `uses()` nel file (funziona col run unico di `phpunit.xml`) oppure `Pest.php` di modulo (richiede `--test-directory`). Proposta: decidere dopo il probe.
2. `laravel/Pest.php`: farlo caricare da `tests/Pest.php` (un solo run con tutti i bind) o cancellarlo.
3. sqlite: spostare su MySQL `_test` (serve DB) o ammettere sqlite `:memory:` per i soli test di logica pura.
4. Account MySQL di test con grant solo su `*_test` (aperto nella story della guardia).

## Come ripartire
1. Apri `test-database-guard.story.md`, controlla `status` e chiedi all'utente il via ai test; senza via, resta sulle voci 2, 3, 4, 8 (solo rinomine e diff).
2. Rilancia i comandi di "Stato misurato" e annota le differenze con una nota datata in fondo a questa story.
3. Per ogni coppia della voce 2: `diff` dei due file, porta il corpo nel `*Test.php`, controlla `rg -w` dei riferimenti, solo dopo togli il minuscolo.

## Esecuzione 2026-10-26

Fase BMAD: Dev + verifica. Pest eseguito solo su DB scratch usa-e-getta (`pest-scratch-db.sh`), mai su DB reali.

### Cosa e' cambiato
- `tests/Pest.php`: tolta `pest()->extend(TestCase::class)->in('Feature', 'Unit')`, al suo posto un commento che spiega perche'. Un solo meccanismo: `uses()` nel file (decisione aperta 1 chiusa cosi', come in Activity e User).
- `tests/pest.php` (minuscolo) cancellato: `cmp` lo dava identico a `Pest.php` prima della modifica.
- `uses(TestCase::class)` aggiunto, dopo `namespace` e import, a 17 file `*Test.php` che non lo avevano. 4 file sono test a classe PHPUnit e non ne hanno bisogno: `Feature/Filament/Traits/HasXotTableReorderingTest.php`, `Unit/Actions/GetAllModelsActionTest.php`, `Unit/Binary/BinaryAssetsNotCrStrippedTest.php`, `Unit/Models/ModuleTest.php`. Cartella `Integration`: non esiste.
- `Unit/ModuleRootHygieneTest.php`: il dataset `module_roots` era vuoto (nessun `Modules/<Mod>/.git` in questo checkout) e un dataset vuoto blocca la raccolta di tutto il modulo. Ora ha una riga segnaposto che salta i 7 test per-repo con un motivo; il test 'ha dei moduli da controllare' resta e fallisce, e dice il vero.
- `Unit/XotBaseTransitionTest.php`, `Unit/Actions/Cast/SafeEloquentCastActionTest.php`: chiamavano funzioni globali di `tests/Support/helpers.php`, mai caricato. Ora usano `Fixtures\XotBaseTransitionFixture::make()` e `Fixtures\SafeEloquentCastFixture::make()` (13 test).
- `Unit/Actions/File/GetModulePathActionTest.php`: `allows(['metodo' => closure])` restituiva la closure; ora `andReturnUsing()`. La cartella `Modules/TestModule` si cancella in `finally`: prima, se il test falliva, restava in `laravel/Modules` e rompeva `ModulesDirContainsOnlyModulesTest`. La cartella vuota lasciata dal primo run e' stata rimossa.
- Pint sui file toccati, `php -l` pulito, PHPStan 0 errori su `Modules/Xot/tests`.

### Comando
Dalla root: `PEST_OUT=<file> bash bashscripts/tools/pest-scratch-db.sh --test-directory=Modules/Xot/tests Modules/Xot/tests`

### Numeri misurati
| Momento | Risultato |
|---|---|
| Prima | `TestCaseAlreadyInUse` in raccolta, 0 test eseguiti |
| Dopo il binding | 105 failed, 23 risky, 6 incomplete, 5 todos, 30 skipped, 698 passed (2884 asserzioni), 561 s |
| Dopo i fix nei test | 88 failed, 23 risky, 6 incomplete, 5 todos, 30 skipped, 715 passed (2916 asserzioni), 510 s |

Controllo `config/local/fixcity/database/content`: md5 di `git status --short` uguale prima e dopo (`8c3a1bb9...`), nessun file piu' recente dell'avvio del run.

### Acceptance criteria
- [x] `find Modules/Xot/tests -name pest.php` non stampa nulla.
- [x] `pest --test-directory=Modules/Xot/tests --list-tests` gira senza `TestCaseAlreadyInUse` (Chart non toccato).
- [ ] Tautologie: ancora 31. `Artisan::call('migrate'`: ancora 1. File con `sqlite`/`:memory:`: 18. File mai raccolti: non riverificato.

### Cosa resta (88 failed, per causa)
- Bug in `app/` (fuori perimetro): `GetAllModelsByModuleNameAction.php:31` cerca `<modulo>/Models`, i modelli stanno in `app/Models` (13 test: ModuleService*, GetAllModelsActionTest).
- Fixture rotte: `HasExtraTrait` deriva `Tests\Fixtures\Models\Extra`, che non esiste; il cast `SchemalessAttributes::class` di `ExtraModelTest` non costruisce (6 test).
- Stato del repo, non dei test: manca `docs/epics.md`, manca `bashscripts/tools/audit/case-collisions-baseline.txt`, manca `bashscripts/fix_structure.sh` (3), `config/local/ptvx/metatag.php` non tracciato, PNG con CR tolti in Activity e Barthelemy, story senza Owned Scope sopra soglia, nessun `Modules/<Mod>/.git`.
- Test contro codice cambiato: aspettative su messaggi e nomi (`GetPdfContentByRecordAction`, tabella `test_morph_pivots`, microsecondi delle date, `ConfigTest` null), `XotBasePest::assertArray` rifiuta l'array vuoto che il suo test accetta, `TransTrait` assente da `XotBaseManageRelatedRecords`.
- Schema/sqlite: tabella `tenants` assente nello scratch; 2 test su sqlite `:memory:` (colonna `slug`, database `model_type_actions_test`).
- Output completo: `/tmp/claude-1000/-var-www--bases-base-fixcity-fila5/9efa4a45-3f20-4d25-8480-17dd7f3717e8/scratchpad/xot-2.txt`.
