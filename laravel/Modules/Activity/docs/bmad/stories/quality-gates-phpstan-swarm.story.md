---
id: quality-gates-phpstan-swarm-2026-09-29
title: PHPStan quality gate swarm: Activity (2026-09-29)
type: module-fix
status: done
scope: Activity
created: 2026-09-29
updated: 2026-09-29
epic: quality-gates-phpstan-fleet-2026-09-29
assignee: ai-agent
related:
  - ./quality-gates-phpstan-swarm-gate-activity.story.md
  - ./conflict-markers-cleanup.story.md
references:
  - sprint-status: "Activity: swarm phpstan Activity+Progressioni+Sigma, 2026-09-29"
tags: [docs, activity, bmad]
qmd: "activity   phpstan quality gate swarm (2026-09-29) activity"
---

# Activity: PHPStan quality gate swarm (2026-09-29)

## Contesto

Uno di 3 moduli assegnati a questo agente in uno swarm parallelo (altri 3
agenti nella stessa sessione lavorano in contemporanea su Job/Lang/Media/Ptv/
UI/User, conversione Livewire→Filament Widget: fuori scope). Scope stretto:
solo `laravel/Modules/Activity`, ordine random fra i 3 moduli assegnati.

Prima di agire: `git status`/`git diff --stat` sul modulo hanno confermato che
un'altra sessione ha in corso una pulizia radicale della root del modulo
(rimozione cartelle IDE/tooling duplicate, consolidamento `.code-workspace`,
potatura `.md`). Non toccato nulla di quello (nessun file `.code-workspace`,
`.gitignore`, `.md` di root, cartelle root): lavoro limitato a `app/`.

Lock acquisito: `laravel/Modules/Activity.lock` (nessun conflitto, libero
all'ingresso). Rilasciato a fine sessione.

## Comando PHPStan e risultato

```
cd laravel && php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/Activity --no-progress
```

**Prima**: 1 errore reale (a differenza del run del 2026-09-23, bloccato da un
fatal error di bootstrap causato da `Modules/Incentivi`: questa volta il
bootstrap Laravel/Filament è andato a buon fine, nessun modulo terzo rompeva
l'autoload):

```
tests/fixtures/CanPaginateHarness.php:57
Method Modules\Activity\Tests\Fixtures\CanPaginateHarness::exposeOptions()
should return list<int|string> but returns array<int|string>.
(array<int|string, int|string> might not be a list.)
```

## Causa e fix

`exposeOptions()` (nella harness di test) dichiara
`@return list<int|string>` e delega a
`CanPaginate::getRecordsPerPageSelectOptions()`, il cui docblock dichiarava
`@return array<int|string>`: tipo più largo, non garantito essere una
`list`. Il valore reale ritornato (`[10, 25, 50]`) **è** una list letterale:
il docblock del trait era impreciso, non il chiamante.

**Fix** (1 riga, `app/Filament/Pages/Concerns/CanPaginate.php:116`):

```diff
-     * @return array<int|string>
+     * @return list<int|string>
```

Nessun cast, nessun `@phpstan-ignore`, nessun allargamento di tipo nel
chiamante: corretta l'annotazione alla fonte.

## Verifica

```
cd laravel && php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/Activity --no-progress
[OK] No errors
```

**Dopo**: 0 errori.

## Pest: esito e limiti riscontrati (non causati da questo fix)

Ambiente non su `10.100.200.15` (host `NOLWA004`), quindi Pest consentito.

- Test mirati (`CanPaginateCoverageTest`, `CanPaginateUnitTest`,
  `CanPaginatePaginateQueryTest`): 4 passed, 7 failed. I 7 fallimenti sono
  **preesistenti e non collegati al fix** (il fix è una sola riga di
  PHPDoc, zero effetto runtime):
  - `Target class [session] does not exist`: nessun binding Laravel/
    container per i test in `tests/Unit/` di questo modulo (il root
    `tests/Pest.php` applica `uses(TestCase::class)` solo a `Feature`, non ai
    moduli); i test che chiamano `session()` girano senza app bootstrap.
  - `Call to undefined function ...\mockeryExpect()`: funzione definita
    solo in `Modules/User/tests/Helpers.php`, non autoloaded globalmente
    (nessuna sezione `autoload-dev.files` in `composer.json`). Stesso
    identico difetto già documentato in
    `Modules/User/docs/stories/10.3.retire-auth-livewire-twins.story.md`
    (confermato lì con `git stash`, preesistente, fuori scope di quella
    story). Non ri-verificato qui via `git stash` per evitare contese su
    `.git/index.lock` con altre sessioni concorrenti attive in questo
    istante (osservato un lock reale durante il lavoro); la non-relazione
    causale è comunque certa: un cambio di solo docblock non può alterare
    binding container o autoload di funzioni a runtime.
- Suite `tests/Feature/`: bootstrap completo del panel Filament
  (`Coolsam\FilamentModules\CoolModulesServiceProvider`): instabile in
  questa finestra, verosimilmente per le conversioni Livewire→Filament Widget
  in corso in altri moduli (User/UI/Job) da altri 3 agenti della stessa
  sessione. Non approfondito: fuori scope, causa esterna ad Activity.
  Interrotto oltre il timeout senza un riepilogo utile.
- Suite `tests/Unit/` completa (senza filtro): baseline con un numero
  consistente di fallimenti preesistenti in `Actions/ActivityLoggerTest.php`
  e `Actions/CoverageHundredActionsTest.php` (persistenza reale su DB
  condiviso, run singoli 6-11s ciascuno: verosimile contesa I/O con altre
  sessioni concorrenti sullo stesso DB). Non nell'area toccata da questo fix
  (`CanPaginate*`), non approfondito oltre: esula dallo scope "fix PHPStan"
  di questo task.

**Esito Pest**: skip motivato per il gate complessivo del modulo (baseline
preesistente rosso, non causato da questa modifica, non riproducibile in
isolamento per contese di risorsa condivisa); verificato invece che il fix
specifico non introduce alcuna nuova regressione (impossibile per un
cambio di sola annotazione PHPDoc) e che i test dell'area toccata
(`CanPaginate`) falliscono/passano identicamente prima e dopo per cause
ambientali indipendenti.

## Second brain

Nessuna nuova memoria creata: i pattern osservati sono già documentati.
Solo un rimando/aggiornamento di contesto:

1. **Duplicato case-variant `tests/fixtures/` vs `tests/Fixtures/`** in
   questo modulo: entrambe le cartelle sono tracciate da git e contengono
   una classe omonima `Modules\Activity\Tests\Fixtures\CanPaginateHarness`
   con docblock divergenti (`list` vs `array` su `exposeOptions()`). Pattern
   già coperto da
   `bashscripts/ai/wiki/memories/psr4-test-filename-pascalcase.md` (STORY-485/
   488): cartelle duplicate case-insensitive rompono PSR-4. **Non risolto in
   questa sessione**: è dentro `tests/`, fuori dal mio scope dichiarato
   (`app/`, `database/`, `routes/`, `config/`) e la cartella è oggetto della
   pulizia radicale in corso da un'altra sessione in questo stesso momento -
   toccarla ora rischierebbe una collisione di edit. Segnalato qui per
   follow-up.
2. Nota tooling: lo script `bashscripts/tools/audit-pest-bootstrap-naming.sh`
   citato dalla memoria PSR-4 sopra **non esiste più al path indicato**
   (verificato con `ls`, exit 2). Puntatore stale nella memoria: non
   corretto qui (fuori scope di questo task), segnalato per chi cura quel
   file.

## Note per l'aggiornamento centrale di sprint-status.yaml

Non toccato (istruzione esplicita del coordinatore). Riepilogo per chi
aggiorna centralmente: Activity: 1 errore PHPStan trovato e risolto, 0
errori residui, nessun conflitto di lock, Pest skip motivato (baseline
preesistente rosso non causato da questo fix).

## Addendum: root cause dei fallimenti Pest (verificato dopo, non ri-eseguito)

I due fallimenti ambientali sopra (`session()` non risolvibile, `mockeryExpect()`
non definita) hanno una causa comune già documentata come ADR in
`Modules/Xot/docs/wiki/concepts/pest4-bootstrap-composer.md` (ADR-014,
parzialmente superseded da `pest5-configuring-tests.md`): **Pest carica
`Pest.php`/`Helpers.php` da un solo percorso per run, quello della root** -
il `tests/Pest.php` di un modulo con `require_once __DIR__.'/PestHelpers.php'`
non viene mai eseguito quando quel modulo gira isolato (pattern confermato
anche dal commento esplicito in `Modules/Progressioni/tests/Pest.php`, che
adotta invece la soluzione canonica: ogni test dichiara
`uses(TestCase::class)` in testa, zero funzioni libere nel `Pest.php` locale).
Conseguenza: in Activity, `PestHelpers.php` (con `activityCreateUser()` e
`activityCreateActivity()`) è probabilmente **codice morto** per qualunque
test eseguito isolando il modulo: non verificato oltre perché fuori scope
di questo task (fix è a livello di test bootstrap, non PHPStan; richiede una
story dedicata che applichi la migrazione ADR-014→Pest5 già fatta altrove).
Non serve una nuova memoria: il pattern è già coperto da
`Modules/Xot/docs/stories/5.19.pest-helpers-bootfiles-and-typecoverage.story.md`
e da `pest4-bootstrap-composer.md`/`pest5-configuring-tests.md`.
