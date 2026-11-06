---
title: "Igiene dei test User: file non eseguiti, tautologie, stile PHPUnit"
type: story
status: ready-for-dev
priority: P2
created: 2026-10-20
updated: 2026-10-20
module: User
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on: ["guardia DB dentro", "verdetto Pest P0 dell'utente", "./user-test-senza-refresh-database.story.md", "run completo PHPStan finito"]
related: [./user-test-senza-refresh-database.story.md, ./7.3.test-mai-eseguiti-suffisso-mancante.story.md, ./7.2.phpstan-test-harness-contracts.story.md, ./phpstan-test-wave-user-b.story.md, ./8.2.phpstan-pest-void-chain-false-positives.story.md, ./user-livewire-auth-ritiro-con-widget-gemelli.story.md, ../../../Xot/docs/stories/test-database-guard.story.md]
tags: [bmad, test, pest, phpunit, tautologie, igiene]
---

# Igiene dei test User: file non eseguiti, tautologie, stile PHPUnit

Fase BMAD: Dev (story pronta; i test non si lanciano finche' la guardia DB non e' dentro).

## Richiesta
Come maintainer del modulo User voglio che ogni test scritto giri davvero e possa fallire, cosi' che il verde significhi qualcosa.
Oggi due file con test veri non sono mai caricati, 26 test non possono fallire e 7 classi sono in stile PHPUnit mentre il progetto usa Pest.

## Scopo
I test servono a proteggere il comportamento di User (auth, team, ruoli, OAuth). Un test dentro un `try` con `catch` vuoto, o in un file che `phpunit.xml` non vede, da' copertura apparente: la regola e' "riscritti o rimossi alla fonte" (`7.2.phpstan-test-harness-contracts.story.md`, criterio 3). Il lavoro sul database (`RefreshDatabase`, `Tests\TestCase` radice) e' della story gemella `user-test-senza-refresh-database`: qui non si ripete, si coordina.

## Stato misurato
Misure del 2026-10-20 alle 14:00 UTC, da `laravel/`, con `rg -P` e controprova `git grep -P` (stesso numero).
- File PHP sotto `Modules/User/tests`: 191 (`/usr/bin/find Modules/User/tests -name '*.php' | wc -l`); 159 finiscono in `Test.php`, 32 no (helper, fixture, `TestCase.php`, `Pest.php`).
- `phpunit.xml` righe 11-12: `<directory suffix="Test.php">tests</directory>` e `Modules/*/tests`; `Modules/User/phpunit.xml.dist` punta a `./Tests/Unit` con la T maiuscola (la cartella `Modules/User/Tests` non esiste: `ls` esce con errore) e a sqlite `:memory:`, contro la regola "solo MySQL": file non usato dal gate, da decidere.
- File con test veri che il runner non vede: **2**, il comando del brief non li trovava perche' filtrava solo `*test.php`. `/usr/bin/find Modules/User/tests -name '*.php' ! -name '*Test.php' -print0 | xargs -0 rg -P -l '^\s*(test|it|describe)\s*\('` stampa `Feature/Passport/ClientCredentials.php` (2 test) e `Feature/user-management-business-logic.php` (27 test). Controprova: la stessa `rg` su `Feature/Passport/ClientCredentialsTest.php` stampa il file.
- La story `7.3.test-mai-eseguiti-suffisso-mancante` e' `done` (2026-08-27) e dice che i due file erano stati rimossi/rinominati. In HEAD ci sono di nuovo, aggiunti da `35fe9567b` (2026-09-24, 4367 file). Il gate che 7.3 prometteva non c'e': `grep -c -i -e 'Test.php' -e 'mai eseguit' -e tests bashscripts/quality-gates/audit-module-theme-root-files.sh` = 0 (controprova sugli altri controlli, `-e MAIUSC -e code-workspace` = 5); lo script non e' in `git ls-files` del repo radice.
- `ClientCredentials.php` ha gli stessi 2 nomi di test di `ClientCredentialsTest.php` (66 contro 74 righe, differenza di 12 righe: cast con `SafeStringCastAction` contro controllo `Assert::fail`). `user-management-business-logic.php` (408 righe) e' la riscrittura Pest di `UserManagementBusinessLogicTest.php` (572 righe, PHPUnit con `RefreshDatabase`): 26 nomi in comune, 1 solo Pest ("can handle user info"), 7 solo PHPUnit (`is admin`, `is doctor`, `is patient`, `last login`, `password reset`, `preferences`, `password strength`).
- Classi PHPUnit: **7** (brief: 7). `rg -P -l '^\s*(final\s+|abstract\s+)?class\s+\w+\s+extends\s+[\w\\]*TestCase\b' Modules/User/tests | rg -v 'tests/TestCase.php'`: UserManagementBusinessLogicTest (33 metodi, 572 righe), GetCurrentDeviceActionTest (12, 431), DeviceTest (24, 350), PermissionTest (21, 244), ProfileTest (26, 324), TeamTest (14, 236), TenantTest (20, 254): 150 metodi, 2411 righe. Tutte con `use Tests\TestCase;` e `use RefreshDatabase;`.
- File con `use Tests\TestCase;` radice: **19**, non 22 (`rg -P -l '^use Tests\\TestCase;' Modules/User/tests`). Le 3 righe in piu' del brief sono commenti: `Unit/Models/RoleTest.php:10`, `Feature/TeamManagementBusinessLogicTest.php:10`, `Unit/Models/UserTest.php:10`. I 19 sono 7 classi PHPUnit piu' 12 file Pest con `uses(TestCase::class)`.
- Tautologie: **26** righe `assertTrue(true) removed` in 5 file (`rg -P -c 'assertTrue\(true\) removed' Modules/User/tests`): `Unit/Datas/AdditionalDatasTest.php` 11, `Unit/Actions/AdditionalActionsTest.php` 7, `Unit/Console/ConsoleCommandsTest.php` 5, `Unit/Rules/RulesTest.php` 2, `Unit/Facades/FacadesTest.php` 1. 25 sono un `catch (Exception $e)` con solo un commento (la tautologia fu tolta lasciando il blocco vuoto), 1 un `if` vuoto: il test non puo' fallire.
- `catch` con corpo vuoto o solo commento: **35 in 7 file** (`rg -U -P -c 'catch\s*\([^)]*\)\s*\{(?:\s|//[^\n]*)*\}' Modules/User/tests --glob '*Test.php'`; controprova: la stessa `rg` su un `catch` con commento stampa 1, su un `catch { log(1); }` esce con rc=1). Sono 25 nelle tautologie, 8 in `Unit/UserGapAttackCoverageTest.php`, 1 in `Feature/Filament/Widgets/SuperAdminWidgetTest.php:222` (legittimo: asserisce dopo) e 1 in `Unit/UserModelTest.php:51` (dentro `beforeAll`, non e' un test). In piu' `Unit/UserExecuteCoverage50Test.php` ha `catch` con solo `continue`/`return`.
- I due file "coverage boost" (`UserGapAttackCoverageTest`: 5 test; `UserExecuteCoverage50Test`: 2 test su 26) sono nel gruppo `no-user-db` e invocano per riflessione ogni metodo pubblico o protetto di widget, pagine e listener con argomenti finti (`UserGapAttackCoverageTest.php:115-137`, `:139-173`). Non verificato: possono eseguire metodi con effetti (per esempio logout o salvataggi dei widget).
- Placeholder con `->skip(` : 20 righe in 8 file (`rg -n -F -e '->skip(' Modules/User/tests`), per esempio `Unit/Models/RoleTest.php`; sono scelte di `phpstan-test-wave-user-b`, non rientrano qui.

## Lavoro
Ordine, dal meno rischioso. Nessun Pest: la verifica e' `php -l` + PHPStan sui file toccati.
1. `Feature/Passport/ClientCredentials.php`: duplicato a nomi uguali di `ClientCredentialsTest.php`. Rimuovere il file senza suffisso (policy di 7.3: duplicato senza righe proprie). Verifica prima `diff <(rg -o -P "^test\('[^']+'" ClientCredentials.php) <(rg -o -P "^test\('[^']+'" ClientCredentialsTest.php)` vuoto.
2. `Feature/user-management-business-logic.php`: va coordinato con il passo 8 della gemella. Raccomando di far sopravvivere la versione Pest: aggiungere ad essa i test PHPUnit rimasti (se ancora validi: `is doctor` e `is patient` sono di un dominio che User non ha), rinominarla `UserManagementBusinessLogicTest.php` e togliere la classe PHPUnit. Evita di sistemare due volte lo stesso file (572 righe PHPUnit).
3. Le 26 tautologie: ogni file diventa un test con dataset. Esempio per i Data: `test('is instantiable', fn (string $class) => expect($class::from([]))->toBeInstanceOf($class))->with([PermissionData::class, ...]);`; per i comandi `new $class`; per le Actions `app($class)`. Rischio: se un `from([])` oggi lancia, il test diventa rosso. E' l'informazione che mancava: si decide classe per classe (`toThrow(<eccezione>)` o fix). -300 righe circa.
4. `UserGapAttackCoverageTest` e `UserExecuteCoverage50Test`: non riscriverli alla cieca. Prima decisione (vedi sotto); fino ad allora escluderli dal primo run (un file per volta, mai l'intera suite).
5. 7 classi PHPUnit in stile Pest: solo dopo la gemella (che le porta su `Modules\User\Tests\TestCase` senza `RefreshDatabase`). Sono 2411 righe e 150 test che Pest esegue gia' cosi' come sono: il valore e' stilistico.
6. Gate: ripristinare il controllo di 7.3 (il comando del brief, filtrato su tutti i moduli) in `audit-module-theme-root-files.sh` o in un test di architettura.

## Acceptance criteria
- [ ] `/usr/bin/find Modules/User/tests -name '*.php' ! -name '*Test.php' -print0 | xargs -0 rg -P -l '^\s*(test|it|describe)\s*\('` non stampa nulla (oggi 2 file).
- [ ] `rg -P -c 'assertTrue\(true\) removed' Modules/User/tests` non stampa nulla (oggi 26).
- [ ] Nessun `catch` vuoto nei test eccetto i 2 giustificati: `rg -U -P -c 'catch\s*\([^)]*\)\s*\{(?:\s|//[^\n]*)*\}' Modules/User/tests --glob '*Test.php'` stampa solo `SuperAdminWidgetTest.php:1` e `UserModelTest.php:1` (oggi 35 in 7 file).
- [ ] Passo 5 (se approvato): `rg -P -l '^\s*class\s+\w+\s+extends\s+[\w\\]*TestCase' Modules/User/tests | rg -v 'tests/TestCase.php'` non stampa nulla.
- [ ] `php -l` pulito e PHPStan gated a zero sui file toccati.

## Verifica
- Prima e dopo: i quattro comandi di "Stato misurato"; ogni "0" ha la controprova (`rg` sul file `ClientCredentialsTest.php`, `git grep -P` per le tautologie).
- Dopo il via libera: `bash bashscripts/tools/pest-scratch-db.sh <file>` un file per volta (lo cita la gemella); atteso verde o skip esplicito, mai `migrate`.

## Vincoli
- PHPStan: unica config `laravel/phpstan.neon`, la modifica solo l'utente; mai altri `.neon`, mai `-c`/`--level`, nessun baseline/ignore. Ogni invocazione passa dal gate condiviso: `cd laravel && flock -w 1500 /tmp/claude-1000/-mnt-nas07-var-www--bases-base-quaeris-fila5/aeabb365-8395-48f4-b7d4-9fbb17ad85d3/scratchpad/phpstan-gate.lock nice -n 10 ./vendor/bin/phpstan analyse <path...> --memory-limit=2G --no-progress --error-format=raw` (max ~8 file o un modulo; `analyse Modules` intero solo dopo il "run completo finito" dell'altra sessione).
- Pest e PHPUnit FERMI: il 2026-10-20 `RefreshDatabase` ha fatto `migrate:fresh` su `quaeris_data_test`. Si riprende solo quando la guardia DB e' dentro (story `laravel/Modules/Xot/docs/stories/test-database-guard.story.md`) e l'utente ha confermato che i DB `*_test` sono usa-e-getta. Fino ad allora la verifica e' PHPStan + `php -l` + lettura.
- Concorrenza: altre sessioni scrivono nello stesso repo. Prima di scrivere un file esistente: `bashscripts/lock/check.sh <f> && [ $(( $(date +%s) - $(stat -c %Y <f>) )) -gt 120 ] && bashscripts/lock/lock.sh <f>`; un solo agente PHP per modulo; niente commit, reset, checkout, stash.
- zsh non divide `$VAR` in argomenti: usa array (`A=(x y); cmd $A`) o `xargs -a`. Un pattern `rg` che inizia con `-` richiede `-e`. Un `0` va sempre controprovato (rg -P piu' un secondo metodo).
- Docs: artefatti BMAD solo in `laravel/Modules/<M>/docs/`; nomi senza date; nessun Service (`app/Services` vietata, logica in Spatie QueueableAction con `execute()`); Filament: solo basi `XotBase*`, logica nelle Actions, nessuna stringa UI hardcoded (chiavi in `lang/`).
- Specifici: non toccare i file della gemella (stesse 7 classi) senza coordinarsi; mai ripristinare `RefreshDatabase`; test solo su MySQL.

## Decisioni aperte
1. Sopravvive il file Pest o la classe PHPUnit di `UserManagementBusinessLogic`? Raccomando il Pest (vedi passo 2); serve dirlo anche alla gemella.
2. I due file "coverage boost" si cancellano o si riscrivono? Raccomando cancellarli dopo aver verificato che nessun altro test copra quei rami: eseguono metodi a caso con argomenti finti e non verificano nulla.
3. Convertire le 7 classi a Pest o lasciarle in stile PHPUnit? Raccomando lasciarle: il costo e' 2411 righe e il beneficio solo di stile.
4. `Modules/User/phpunit.xml.dist` stantio (`./Tests`, sqlite): correggerlo o toglierlo? Raccomando toglierlo in una story a parte.

## Come ripartire
1. `cd /mnt/nas07/var/www/_bases/base_quaeris_fila5/laravel && /usr/bin/find Modules/User/tests -name '*.php' ! -name '*Test.php' -print0 | xargs -0 rg -P -l '^\s*(test|it|describe)\s*\('` e `rg -P -c 'assertTrue\(true\) removed' Modules/User/tests`: rimisurare 2 e 26.
2. Passo 1 (duplicato `ClientCredentials.php`) e passo 3 sul file piu' piccolo, `Unit/Facades/FacadesTest.php`, poi `php -l`.
3. Annotare qui le cifre finali e che Pest non e' stato eseguito.
