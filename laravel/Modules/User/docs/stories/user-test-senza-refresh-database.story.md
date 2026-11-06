---
title: "Test User senza RefreshDatabase"
type: story
status: ready-for-dev
priority: P0
created: 2026-10-20
updated: 2026-10-20
module: User
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on: ["../../../Xot/docs/stories/test-database-guard.story.md (codice scritto, boot reale non verificato)", "verdetto Pest P0 dell'utente", "conferma dell'utente che i DB *_test sono usa-e-getta"]
related: ["../../../Xot/docs/stories/dcp-45-isolamento-db-test-pest-scratch.story.md", "phpstan-test-wave-user-b.story.md", "7.2.phpstan-test-harness-contracts.story.md"]
tags: [bmad, test, database, sicurezza, refresh-database]
---

# Test User senza RefreshDatabase

Fase BMAD: Dev (story pronta, esecuzione dei test bloccata fino alla guardia e al verdetto utente).

## Richiesta

Come maintainer del modulo User voglio che nessun test del modulo possa lanciare `migrate:fresh`, cosi' che un agente o un CI che esegue Pest non possa mai cancellare lo schema di un database.

Il 2026-10-20 un agente ha eseguito Pest su file User con `RefreshDatabase`. La regola di progetto lo vieta (`bashscripts/ai/wiki/rules/data-sacred-no-destructive-db.md`, sezione "Cosa fare invece / Test"): l'isolamento si ottiene con `DatabaseTransactions` nel `TestCase` del modulo.

## Scopo

I test dei model User (Device, Permission, Profile, Team, Tenant, BaseUser), dell'action `GetCurrentDeviceAction` e della logica utente/ruoli/permessi devono verificare il comportamento senza toccare lo schema. `RefreshDatabase` fa `migrate:fresh` sulla connessione di default (`quaeris_data_test` secondo `.env.testing`) e poi migra anche le altre connessioni (`user` su `quaeris_user_test`, `limesurvey` su `quaeris_survey_test`, `activity` su `quaeris_data_test`).

Errore osservato il 2026-10-20 tra le 12:26 e le 12:28 UTC in `Modules/User/tests/Unit/Models/BaseUserTest.php` (riga 12, `uses(TestCase::class, RefreshDatabase::class)`): `SQLSTATE[42000] 1061 Duplicate key name 'extras_model_id_index' (Connection: limesurvey, Database: quaeris_survey_test)`. Meccanismo probabile, non verificato (nessun accesso al database in questa story): `migrate:fresh` svuota solo il DB di default, dove sta anche il registro `migrations`, quindi le migration ripartono su `limesurvey` e `user` dove le tabelle esistono gia'.

## Stato misurato

Misure del 2026-10-20 13:43 UTC, dalla cartella `laravel`. Pattern dei casi reali (esclude commenti e stringhe di skip):

```
P='^\s*(use\s+(?:Illuminate\\Foundation\\Testing\\)?(?:RefreshDatabase|DatabaseMigrations|LazilyRefreshDatabase|DatabaseTruncation)\s*[;,]|.*uses\(.*(?:RefreshDatabase|DatabaseMigrations|LazilyRefreshDatabase)|.*(?:artisan|Artisan::call)\(\s*[\x27"]migrate)'
```

Valori (comandi nel blocco sotto):

- File User con uso reale: 8 (16 righe, import piu' uso) con `rg -l` e `rg -n`.
- Stessi file con il secondo metodo (`git grep -w`): 8, dopo aver scartato le due righe di `RoleTest.php` e `UserTest.php`, che nominano il termine solo dentro `->skip('...')`.
- File che nominano il termine anche solo in commenti o stringhe: 13.
- File User su `Tests\TestCase` radice (senza transazioni): 19.

```
rg -l -P -e "$P" Modules/User/tests --glob '*.php'
rg -n -P -e "$P" Modules/User/tests --glob '*.php' | wc -l
git -C Modules/User grep -n -w -E 'RefreshDatabase|DatabaseMigrations|LazilyRefreshDatabase|DatabaseTruncation' -- tests
rg -l -P -e "RefreshDatabase|DatabaseMigrations|migrate:fresh|artisan\('migrate" Modules/User/tests --glob '*.php'
rg -l -P -e '^use Tests\\TestCase;' Modules/User/tests
```

Riconciliazione dei conteggi: il coordinatore aveva 11 file, l'altra sessione 8. Il 8 e' il numero giusto. I 3 file in piu' sono falsi positivi: `Feature/MigrateDbTest.php` (solo `skipTest` con la stringa "migrate:fresh"), `Unit/Models/RoleTest.php` e `Unit/Models/UserTest.php` (un solo `it(...)->skip(...)` con la parola nel commento). Altri 2 file citano il termine solo nel commento: `Feature/TeamManagementBusinessLogicTest.php` e `Feature/Api/UserApiTest.php`. Per questo il pattern dell'AC non e' la ricerca banale della parola.

Controprova del pattern: `printf 'uses(TestCase::class, RefreshDatabase::class);\n' \| rg -c -P -e "$P"` stampa 1; `printf ' * RefreshDatabase vietato\n' \| rg -c -P -e "$P"` non stampa nulla (exit 1).

## Lavoro

Premessa che cambia il piano: i 7 file su `Tests\TestCase` radice (`laravel/tests/TestCase.php`, che ora ha solo la guardia in `createApplication()`) NON hanno `DatabaseTransactions`. Togliere il trait e basta farebbe passare da "cancella lo schema" a "lascia righe vere in `quaeris_user_test`" (le factory fanno commit). Tutti vanno spostati su `Modules\User\Tests\TestCase` (`tests/TestCase.php:65-67`, `use DatabaseTransactions`, `$connectionsToTransact = ['mysql', 'user']` a riga 124).

Seconda premessa: `assertDatabaseHas('devices', ...)` con una stringa legge la connessione di DEFAULT, non `user` (`vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/InteractsWithDatabase.php:339-346` e `:396-399`: `newModelFor` restituisce null per una stringa). Sono 30 chiamate (UserManagement 9, Team 5, Device 4, Permission 4, Profile 4, Tenant 4). Si passa la classe: `assertDatabaseHas(Device::class, [...])`, che usa la connessione del model.

Ordine di esecuzione (dal meno al piu' invasivo sul DB). Righe = import / uso del trait.

1. `Unit/Models/BaseUserTest.php` (righe 7 e 12, 2 test). Non tocca il DB: una sottoclasse anonima di `BaseUser` e due asserzioni su `getTable()` e `class_uses_recursive`. Fix: `uses(TestCase::class)->group('no-user-db');` (convenzione gia' presente in `Unit/Models/BaseTeamBehaviorTest.php:18`), rimuovere l'import. Rischio: nessuno.
2. `Unit/Actions/GetCurrentDeviceActionTest.php` (8 / 18, 12 test). Verifica il mapping Agent -> attributi del Device e l'eccezione per `mobile_id` vuoto. Il DB serve (l'action fa `firstOrCreate` e `update`, `app/Actions/GetCurrentDeviceAction.php:36,40,45,49`). Fix: `extends Modules\User\Tests\TestCase`, nessun trait. Alternativa senza DB (se si vuole): sottoclasse di `Device` che sovrascrive `firstOrCreate` e `update`. Raccomandato il primo: meno codice.
3. `Unit/Models/PermissionTest.php` (7 / 13, 21 test) e 4. `Unit/Models/DeviceTest.php` (7 / 13, 24 test). Sei test di Permission e due di Device sono gia' senza DB. 5 test di Permission e 1 di Device creano una riga solo per `method_exists`: usare `new Permission()` / `new Device()`. Il resto usa le factory: base module, `assertDatabaseHas(Model::class, ...)`.
5. `Unit/Models/ProfileTest.php` (7 / 13, 26 test): 8 test creano una riga solo per `method_exists`, usare `new Profile()`. Due test sono gia' senza DB.
6. `Unit/Models/TenantTest.php` (7 / 15, 20 test): 3 test `method_exists` senza riga. Attenzione: asserisce `$tenant->settings` come array (riga 53) mentre `test_can_find_tenants_by_settings_value` (riga 237) scrive il JSON a mano perche' il model non ha il cast. Prima la story `user-tenant-fillable-cast-e-colonne.story.md`, poi questo file.
7. `Unit/Models/TeamTest.php` (7 / 14, 14 test): tutto DB (Team + `User::factory()`), solo base module e 5 asserzioni sulla classe.
8. `Feature/UserManagementBusinessLogicTest.php` (10 / 20, 33 test, 6 skip): ruoli, permessi, soft delete, `forceDelete` (riga 354) e un `post('/register')` (riga 497). Tutto DB: base module e 9 asserzioni sulla classe.

Fuori ordine, nessuna modifica obbligatoria: `Feature/MigrateDbTest.php` (16 righe, solo skip, il titolo invita a implementare il vietato), `RoleTest.php`, `UserTest.php`: vedi decisioni.

## Acceptance criteria

- [ ] `rg -n -P -e "$P" Modules/User/tests --glob '*.php'` non stampa nulla (oggi 16 righe in 8 file). Controprova: la `printf` della sezione "Stato misurato" stampa 1.
- [ ] Nessuno dei 7 file di classe estende `Tests\TestCase`: `rg -l -P -e '^use Tests\\TestCase;' Modules/User/tests/Unit/Models/{Device,Permission,Profile,Team,Tenant}Test.php Modules/User/tests/Unit/Actions/GetCurrentDeviceActionTest.php Modules/User/tests/Feature/UserManagementBusinessLogicTest.php` non stampa nulla.
- [ ] Nessun `assertDatabase(Has|Missing|Count)('<stringa>'` nei 6 file con asserzioni: `rg -c -P -e "assertDatabase(Has|Missing|Count)\('" <6 file>` non stampa nulla (oggi 30).
- [ ] `php -l` pulito sugli 8 file; PHPStan (gate condiviso) sugli 8 file, exit 0.
- [ ] Prima esecuzione reale solo dopo le due condizioni (guardia + conferma utente) e solo con `bash bashscripts/tools/pest-scratch-db.sh <un file>`, un file alla volta nell'ordine sopra.

## Verifica

1. Prima di ogni edit: `bashscripts/lock/check.sh <file>`; a fine edit i comandi AC sopra.
2. `git -C Modules/User diff --stat -- tests` deve toccare solo gli 8 file (piu' `TenantTest` solo dopo la story Tenant).
3. Dopo il via libera: output atteso di `pest-scratch-db.sh` sul primo file = test verdi o skip, mai `migrate`/`1061` nel log; l'ultima riga dello script e' `scratch eliminato: 0 rimasti`. Controprova: se lo script esce prima (exit 3) nessun test e' partito e nessun DB va ripulito.

## Vincoli

- PHPStan: unica config `laravel/phpstan.neon`, la modifica solo l'utente; mai altri `.neon`, mai `-c`/`--level`, nessun baseline/ignore. Ogni invocazione passa dal gate condiviso: `cd laravel && flock -w 1500 /tmp/claude-1000/-mnt-nas07-var-www--bases-base-quaeris-fila5/aeabb365-8395-48f4-b7d4-9fbb17ad85d3/scratchpad/phpstan-gate.lock nice -n 10 ./vendor/bin/phpstan analyse <path...> --memory-limit=2G --no-progress --error-format=raw` (max ~8 file o un modulo; `analyse Modules` intero solo dopo il "run completo finito" dell'altra sessione).
- Pest e PHPUnit FERMI: il 2026-10-20 `RefreshDatabase` ha fatto `migrate:fresh` su `quaeris_data_test`. Si riprende solo quando la guardia DB e' dentro (story `laravel/Modules/Xot/docs/stories/test-database-guard.story.md`) e l'utente ha confermato che i DB `*_test` sono usa-e-getta. Fino ad allora la verifica e' PHPStan + `php -l` + lettura.
- Concorrenza: altre sessioni scrivono nello stesso repo. Prima di scrivere un file esistente: `bashscripts/lock/check.sh <f> && [ $(( $(date +%s) - $(stat -c %Y <f>) )) -gt 120 ] && bashscripts/lock/lock.sh <f>`; un solo agente PHP per modulo; niente commit, reset, checkout, stash.
- zsh non divide `$VAR` in argomenti: usa array (`A=(x y); cmd $A`) o `xargs -a`. Un pattern `rg` che inizia con `-` richiede `-e`. Un `0` va sempre controprovato (rg -P piu' un secondo metodo).
- Docs: artefatti BMAD solo in `laravel/Modules/<M>/docs/`; nomi senza date; nessun Service (`app/Services` vietata, logica in Spatie QueueableAction con `execute()`); Filament: solo basi `XotBase*`, logica nelle Actions, nessuna stringa UI hardcoded (chiavi in `lang/`).
- Specifici: test solo su MySQL, mai sqlite (memoria `tests-mysql-never-sqlite`); `.env.testing` e' tracciato in git con credenziali reali, non stamparlo mai (leggere solo i nomi `DB_DATABASE*`); non ripristinare `RefreshDatabase` nemmeno "solo per questo file".

## Decisioni aperte

1. Via libera a lanciare Pest solo tramite `pest-scratch-db.sh` (DB creato e eliminato a ogni run, prefisso `claude_scratch_pest_` accettato dalla guardia). Raccomandato: si. Il 2026-10-08 la memoria diceva che i `*_test` non esistevano; l'errore 1061 del 2026-10-20 prova che almeno `quaeris_survey_test` esiste. Stato dei tre `*_test` dopo l'incidente: non verificato (nessun accesso al DB).
2. Cancellare `Feature/MigrateDbTest.php` (solo skip, nome ingannevole). Raccomandato: si, dopo il primo run verde.
3. Il ramo sqlite di `tests/TestCase.php` (righe 74-78, `prepareSharedSqliteForTesting`) contraddice la regola "solo MySQL": rimuoverlo in una story a parte. Raccomandato: si, non in questa.
4. Le 12 classi restanti su `Tests\TestCase` radice (`Unit/{Permission,HasTeamsTrait,Tenant,AuthenticationBusinessLogic,User,UserModel}Test`, `Unit/Datas/PasswordDataTest`, `Feature/ChangeProfilePasswordTest`, `Feature/Filament/{Actions/ChangePasswordActionTest,Pages/CreateUserTest,Pages/ListUsersTest,Widgets/LoginWidgetTest}`) scrivono senza transazione se toccano il DB: spetta alla story di igiene test dell'altra sessione.

## Come ripartire

1. `cd /mnt/nas07/var/www/_bases/base_quaeris_fila5/laravel && rg -n -P -e "$P" Modules/User/tests --glob '*.php'` (definire `$P` come sopra): confermare le 16 righe e partire da `BaseUserTest.php`.
2. Applicare i passi 1-8 nell'ordine, con `php -l` dopo ogni file; saltare `TenantTest.php` finche' la story `user-tenant-fillable-cast-e-colonne.story.md` non e' chiusa.
3. Chiudere con gli AC statici (nessun test lanciato); aggiornare questo file con le cifre finali e scrivere nel report "Pest non eseguito, in attesa della guardia e del verdetto utente".
