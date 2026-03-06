# Coverage 100% Full-Project Memory

Snapshot: 2026-03-04

## Stato operativo

- Obiettivo utente: 100% Pest coverage full-project.
- Policy utente: test failing -> fix oppure rename `.old`.
- Azione eseguita: batch di file test legacy rinominati in `.old` per ridurre skip/warning strutturali.
- Warning residui: da eliminare iterativamente con `--stop-on-warning`.

## GitHub integrazione

- Stato operativo corrente: integrazione GitHub funzionante per commenti su issue/discussion.
- Thread di coordinamento attivi:
  - Issue: https://github.com/laraxot/laravelpizza.com/issues/206
  - Discussion: https://github.com/laraxot/laravelpizza.com/discussions/207
- Ultimi update pubblicati:
  - https://github.com/laraxot/laravelpizza.com/issues/206#issuecomment-4006117614
  - https://github.com/laraxot/laravelpizza.com/discussions/207#discussioncomment-16012616
- Verifica 2026-03-05: CLI GitHub operativa per issue/discussion nel repository.

## Lezioni dalle fonti ufficiali

- Pest coverage:
  - richiede driver coverage attivo (Xdebug/PCOV/phpdbg);
  - usare `--min` per gate progressivi;
  - usare `--exactly` solo a chiusura target.
- Pest type coverage:
  - controllo separato dalla code coverage;
  - necessita plugin type-coverage dedicato.
- Laravel Modules testing:
  - mantenere struttura `Modules/*/tests/*` e separazione Unit/Feature/Integration/Performance.

## Vincoli per le prossime iterazioni

1. Nessun skip nuovo nei test `.php` attivi.
2. Ogni test non sistemabile nel ciclo corrente va in `.old` con nota nel changelog.
3. Ogni incremento coverage deve essere tracciato nel piano docs.

## Incidenti operativi osservati (2026-03-05)

- Errore `Interface "PHPUnit\\Framework\\Test" not found` dovuto a file vendor rinominato:
  - `vendor/phpunit/phpunit/src/Framework/Test.php.old` al posto di `Test.php`.
  - Ripristino eseguito rinominando a `Test.php`.
- Errore `No tests found` dovuto a rinomina massiva dei test in `.old`:
  - trovati 255 file `*.php.old` sotto `tests/` e `Modules/*/tests/`;
  - con tutti i test in `.old`, Pest non esegue suite e la coverage risulta `0.0%`.
- Coverage globale ancora `0.0%` nonostante test passanti:
  - root cause: `pcov.directory` globale puntato a `laravel/app`;
  - impatto: codice in `Modules/*/app` escluso dalla strumentazione PCOV;
  - azione richiesta: allineare `pcov.directory` alla root `laravel/` in configurazione stabile di test coverage.
- Backlog condiviso creato in `docs/coverage-plan.md`:
  - sorgente automatica da `/tmp/pest_cov.xml`;
  - 1599 file sotto 100% da gestire a micro-batch tra agenti.
- Bug bloccanti emersi durante i test auth:
  - `LoginWidget::login()` aggiungeva errore anche su login riuscito (mancava `return` nel ramo di successo);
  - `RegisterWidget` usava `type = standard` non compatibile con mappa classi utente del progetto.
- Batch corrente pianificato (Activity):
  - target rapido su file infrastrutturali a bassa complessita (`Listeners`, `Policies`, `Providers`, `Models` base, `EditActivity`);
  - criterio: chiudere prima i file con poche linee/branch per ridurre backlog condiviso in `docs/coverage-plan.md` senza introdurre test fragili su Filament pages complesse.
- Batch successivo pianificato (User Events):
  - target su `Modules/User/app/Events/*` con molti file a copertura minima (1-4 statement);
  - approccio: test consolidato di istanziazione/proprieta e metodi specifici (`broadcastOn`) per ridurre rapidamente il backlog in `coverage-plan.md`.
- Regola operativa rafforzata dall'utente (multi-agent harmony):
  - controllo collisioni obbligatorio ad ogni iterazione (`git status` + verifica backlog condiviso);
  - coordinamento obbligatorio su GitHub Issue/Discussion per evitare lavoro duplicato;
  - pianificazione non lineare consentita e consigliata per ridurre conflitti tra agenti;
  - aggiornamento continuo di `docs/coverage-plan.md` dopo ogni batch.
- Checklist applicata in questo ciclo:
  - verifica stato condiviso prima di edit;
  - esclusione file toccati da altri agenti;
  - batch quick-win su file User/Socialite non contesi.
- Regola permanente aggiunta (2026-03-05):
  - non cancellare file nel flusso coverage; usare rinomina con suffisso `.old` quando necessario;
  - in presenza di piu agenti, evitare aree ad alta contesa e scegliere micro-batch indipendenti.
- Regola permanente aggiunta (2026-03-05, coordinamento GitHub):
  - HARD RULE: assumere sempre ambiente multi-agent; non dare per scontato di essere il primo sul batch;
  - prima di un batch coverage, verificare in Issue/Discussion condivisa se il lavoro e' gia' in corso o concluso;
  - pubblicare "claim" batch (file target) prima di edit sostanziali;
  - pubblicare "release" batch con esito test + aggiornamenti a `docs/coverage-plan.md`;
  - usare Discussion per allineare scelte cross-modulo e ridurre collisioni tra agenti.
- Regola permanente ribadita (SEMPRE):
  - assumere sempre collaborazione con altri agenti AI;
  - non considerare mai implicito il coordinamento: deve essere esplicito su GitHub;
  - in assenza di auth GitHub valida, lo stato e' "coordinamento bloccato" finche non risolto.
- Micro-batch in corso (2026-03-05, User Passport actions):
  - claim pubblicato su issue #206: https://github.com/laraxot/laravelpizza.com/issues/206#issuecomment-4006300252
  - claim pubblicato su discussion #207: https://github.com/laraxot/laravelpizza.com/discussions/207#discussioncomment-16012876
  - target: `CreateClientAction`, `CreateGenericClientAction`, `RegenerateClientSecretAction`, `RevokeClientAction`, `RevokeRefreshTokenAction`, `RevokeTokenAction`.
- Quick-win completato (2026-03-05): copertura `GetNewPasswordAction` con test unit dedicato (`2 passed`) e checkbox aggiornato in `docs/coverage-plan.md`.
- Failure pattern consolidato (2026-03-05, full run):
  - i test Feature UI possono fallire in cascata su `Table not found` (`themes`, `components`, `assets`) quando la suite non prepara schema sulla connessione `xot`;
  - mitigazione: bootstrap schema nel `Modules/UI/tests/TestCase.php` (o trait dedicato) prima di eseguire `UIBusinessLogicTest`;
  - non affidarsi a migrazioni globali di altri moduli per il setup UI.
- Compatibilita helper Laravel (2026-03-05):
  - nei test non usare helper legacy `str_after()`/`str_before()` non piu disponibili;
  - usare `Illuminate\Support\Str::after()` e `Str::before()`.
- Failure pattern consolidato (2026-03-05, run successivo):
  - su suite condivisa con DB popolato, i test UI che assumono cardinalita fissa (`toHaveCount(1/2/3)`) diventano flaky;
  - preferire assert su condizioni di business (`>=`, subset, coerenza relazioni) o su delta rispetto al baseline locale del test;
  - su Geo alcune factory dipendono da formatter Faker non sempre disponibili nel contesto corrente: usare dataset statici/`array_rand` per stabilizzare.
