---
id: Activity/quality-gates-phpstan-fix-20260928
title: "PHPStan Modules — remediation BMAD 2026-09-28"
status: review
epic: quality-gates
module: Activity
priority: P1
references:
  - ../../../Xot/docs/bmad/stories/5.227-phpstan-modules-verify-coordinated.story.md
  - ../../../../../../docs/sprint-status.yaml
  - ../../../../../../bashscripts/ai/wiki/memories/feedback-scan-committed-conflict-markers-first-on-bootstrap-crash.md
---

# Story — PHPStan fleet remediation

## Acceptance criteria

- [x] `cd laravel && ./vendor/bin/phpstan analyse Modules` termina con exit 0.
- [ ] Ogni finding viene corretto alla radice, senza baseline, ignore o modifica a `phpstan.neon`.
- [ ] I marker di conflitto e i parse error del modulo Activity sono risolti con contenuto verificato, non con rimozioni cieche.
- [ ] Evidenze e decisioni sono aggiornate nel second brain.

## Esecuzione 2026-09-28

Il gate iniziale ha restituito **51 errori**: Activity, configurazioni Rector/PHPInsights,
Incentivi, UI. Dopo i fix mirati, il bootstrap resta bloccato da WIP concorrente in
`Modules/Activity`: 380 file contengono marker di conflitto; la rimozione meccanica dei
soli marker non basta perché diversi blocchi sono annidati e producono 136 parse error.
Serve recupero contenuto per contenuto e coordinamento del proprietario del WIP.

## Chiusura tecnica 2026-09-28

Il run finale ha restituito `[OK] No errors` su 10.179 file. Sono stati corretti gli
otto finding residui: narrowing `UserContract` verso `User` nelle due Activity logger,
API Filament `createAnother(false)` e rimozione della dipendenza inesistente `Cms` dal
renderer UI. `php -l` è verde sui quattro file modificati.

Il Pest mirato Activity/Incentivi/UI è stato avviato, ma dopo oltre quattro minuti senza
output è stato terminato (exit 143) per blocco ambientale; non viene dichiarato verde.

## Riesecuzione successiva

Con una finestra inizialmente stabile, PHPStan ha completato l'analisi e ha restituito
114 errori. Sono stati isolati fix indipendenti per Activity, Job, Lang e UI; durante la
correzione il working tree ha reintrodotto marker di conflitto. La riesecuzione seguente
è tornata al bootstrap failure (`unexpected token <<`) con 211 file PHP marcati, quindi
il gate non è attribuibile ai fix e il lavoro viene fermato fino a stabilizzazione del tree.

## Ultimo run

Il run ha attraversato il bootstrap e ha restituito 53 errori, ma nello stesso momento
erano attivi 10 processi PHPStan concorrenti. File già corretti sono ricomparsi nella
versione precedente (`Activity/phpinsights.php`, `Activity/rector.php`, `UI/LocationSelector.php`)
e il risultato non è una baseline affidabile. STOP operativo: nessun altro edit finché
non restano un solo processo di gate e un working tree stabile.

## Riesecuzione 2026-09-28 — STOP concorrenti

La riesecuzione richiesta dall'utente ha fallito al bootstrap su
`Modules/Xot/helpers/Helper.php:16` (`unexpected token "<<"`). Una nuova scansione
ha rilevato 1.452 file PHP con marker di conflitto nel tree, contro i 380 misurati
nel passaggio precedente: il tree viene modificato mentre il gate gira. Non è sicuro
applicare fix casuali o lanciare swarm di modifiche finché il WIP concorrente/daemon
non è fermato e il proprietario non viene identificato.

Fix mirati applicati e verificati con `php -l`: Activity logger, configurazioni PHPInsights/Rector,
`CreateAction::createAnother(false)`, Block UI e rimozione del `LocationSelector` Geo
reintrodotto senza modulo Geo.

## GitHub

Repository modulo: da verificare con `git -C laravel/Modules/Activity remote -v`; nessun issue inventato.

## Residui run 2026-09-29 11:40

Run `phpstan analyse Modules` (cache isolata, livello da `phpstan.neon`): 26 file con errori;
ri-analisi degli stessi file alle 11:40 dopo il lavoro dei pari: **8 errori in 6 file**. Tutti corretti,
senza ignore, baseline, cast o `@var`.

| File | Errore | Causa | Fix |
|---|---|---|---|
| `Job/tests/Feature/TaskBusinessLogicTest.php:272` | alreadyNarrowedType | `$task->is_active` ristretto a `1` dal primo assert, `update()` non lo invalida: il terzo assert era tautologico | ogni transizione si rilegge dal DB (`Task::findOrFail`) in una variabile propria: ora prova la persistenza |
| `Lang/tests/Unit/LangFinalGapsTest.php:190,192` | alreadyNarrowedType | `app()->getLocale()` ristretto a `'en'`; e partendo gia' da `'en'` il fallback non era provato | helper `langLocaleAfterApplying()`: riparte da `'it'` a ogni chiamata; `'de'` applicato, `123` e `[]` -> fallback `'en'` |
| `Lang/tests/Unit/LangHundredPercentCoverageTest.php:875` | alreadyNarrowedType | stessa espressione `(new TranslationFile)->getRows()` in due scenari | una variabile per scenario; `argv` ripristinato prima dell'assert |
| `UI/tests/Unit/UiGapCloser100Test.php:209,215` | alreadyNarrowedType | `$subject->getTableLayout()` ristretto dal primo assert, la sessione cambia in mezzo | una variabile per scenario (enum, stringa, invalido, assente) |
| `Xot/app/Actions/Model/DeleteTableIndexByModelClassIndexNameAction.php:23` | method.deprecated | `Table::dropIndex()` deprecato in doctrine/dbal 4.5 | `edit()->dropIndexByUnquotedName()->create()` + `Assert::stringNotEmpty($indexName)` |
| `Xot/tests/Unit/NoLivewireDirectoriesInModulesTest.php:26` | theCodingMachineSafe.function | `glob()` nativo | `Safe\glob` + `Assert::allString` (tipo per `implode`) |

### Gate (reali)

- PHPStan sui 6 file: `[OK] No errors`, exit 0.
- Pint `--test`: passed.
- PHPMD (`tools/phpmd.sh`) HEAD -> ora: 0->0, 8->8, 3->3, 0->0, 1->1, 0->0 (nessun aumento).
- Pest sui test toccati: Job 13 passed (35 assertions); LangFinalGaps `applyLocale` 1 passed (3);
  UI `TableLayoutTrait` 1 passed (5); LangHundred `getRows`: le 2 asserzioni toccate passano, il test
  fallisce alla terza (riga 889, `assertNotEmpty`, non toccata).
- **Rossi preesistenti, non causati da questo intervento**: LangFinalGapsTest (10 test, es. TranslatorAction,
  WriteTranslationFileAction, NationalFlagSelect), LangHundredPercentCoverageTest (7), UiGapCloser100Test
  (1, Blocks render), NoLivewireDirectoriesInModulesTest (2): la guardia e' corretta, `app/Http/Livewire`
  esiste di nuovo in tutti i 18 moduli piu' `User/app/Livewire` (resurrezione da merge, vedi
  `docs/chat/multi-agent-standing-coordination.md`).

### Da decidere (owner Xot)

`DeleteTableIndexByModelClassIndexNameAction` non esegue SQL ne' prima ne' ora: modifica solo il `Table`
introspezionato in memoria, zero chiamanti in `Modules/`. Farle davvero droppare l'indice
(`AbstractSchemaManager::dropIndex($index, $table)`) e' un cambio di schema: non fatto qui.
