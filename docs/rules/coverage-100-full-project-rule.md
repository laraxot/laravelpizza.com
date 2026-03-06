# Coverage 100% Full-Project Rule

## Obiettivo

Portare Pest al 100% in modo verificabile e ripetibile:

- code coverage: `./vendor/bin/pest --coverage --min=100`
- type coverage: `./vendor/bin/pest --type-coverage --min=100`

## Regole non negoziabili

1. Niente metriche artificiali: il perimetro coverage deve restare coerente con il codice runtime reale.
2. I test failing si gestiscono solo in due modi:
   - fix immediato, oppure
   - rinomina file in `.old` quando fuori scope corrente, con motivazione documentata.
3. I test con skip legacy (`markTestSkipped`, `->skip`) sono candidati prioritari a `.old`.
4. Ogni run deve essere tracciabile con comando, esito e delta.
5. Ogni iterazione aggiorna sempre:
   - `docs/testing/coverage-100-plan.md`
   - `docs/memory/coverage-100-full-project-memory.md`
   - `docs/skills/coverage-100-full-project-skill.md`
6. Regola permanente "sempre ricordare":
   - il progetto e' multi-agent;
   - prima/dopo ogni batch va usato coordinamento su GitHub Issue + Discussion;
   - se GitHub CLI non e' autenticato, la prima azione e' ripristinare autenticazione o segnalare blocco operativo.

## Standard ufficiali da applicare

- Pest code coverage richiede Xdebug/PCOV/phpdbg attivi.
- Se si usa PCOV, `pcov.directory` deve includere l'intero progetto Laravel (`laravel/`) e non solo `laravel/app`, altrimenti i moduli `Modules/*` risultano sempre a `0.0%`.
- Soglie: usare `--min` per gate minimo e `--exactly` quando si vuole match esatto.
- Type coverage e separato dalla code coverage e richiede plugin dedicato.
- Con Laravel Modules, la struttura test standard resta `Modules/*/tests/...` (Unit/Feature/Integration/Performance).

## Guardrail operativi aggiuntivi

1. Non rinominare in massa i test `*.php` in `*.old`: genera `No tests found` e produce una coverage non valida.
2. Se si incontrano file vendor rinominati anomali (es. `Test.php.old`), ripristinare immediatamente prima di ogni run coverage.
3. Prima di perseguire il 100%, la baseline deve essere: test discovery corretta + suite green senza errori infrastrutturali.
4. Ambiente multi-agent obbligatorio:
   - prima di ogni edit, controllare sempre `git status --short` e il piano condiviso;
   - evitare batch in ordine strettamente sequenziale quando aumenta il rischio di collisione;
   - preferire micro-batch su file poco contesi e aggiornare subito `docs/coverage-plan.md` al termine;
   - se compaiono modifiche inattese in file target, sospendere il batch e riallocare su un gruppo non conteso.
5. Checklist pre-batch (sempre):
   - `git status --short`
   - conferma che i file target non sono gia' in modifica da altri agenti
   - verifica su GitHub (Issue/Discussion del task) che il batch non sia gia' preso in carico
   - scelta batch alternato/non lineare
   - update immediato del piano a fine batch.
6. Non cancellare file durante il programma coverage:
   - se un file va escluso dal flusso corrente, rinominarlo in `.old` con motivazione;
   - non usare rimozioni fisiche (`rm`) per file di test/codice coinvolti nel piano.
7. Coordinamento multi-agent via GitHub obbligatorio:
   - usare una Issue condivisa come registro operativo dei batch;
   - usare una Discussion condivisa per decisioni tecniche trasversali (policy, refactor, scelte test);
   - prima di iniziare un batch: commentare "taking ownership" con elenco file target;
   - a fine batch: commentare esito (pass/fail), comandi eseguiti, file aggiornati in `docs/coverage-plan.md`;
   - se un altro agente ha gia' coperto il batch, non duplicare: riallocare subito su batch non contiguo.

## Fonti

- https://pestphp.com/docs/test-coverage
- https://pestphp.com/docs/type-coverage
- https://laravelmodules.com/docs/12/advanced/tests
