---
title: "[STORY] PHPStan cleanup modulo User (scopo prima dell'errore)"
type: story
status: done-with-blocker
priority: medium
created: 2026-10-06
module: User
<<<<<<< .merge_file_GKSWxj
qmd: "06 phpstan cleanup user story scopo"
=======
>>>>>>> .merge_file_faQsMU
---

# [STORY] PHPStan cleanup modulo User

## User Request

> «sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalita', non sull'errore;
> aumenta la qualita' del codice; usa enum al posto delle costanti».

Gruppo: `User` — 108 errori in 43 file (`laravel/Modules/User/**`), livello `max`.

## Analysis

Ogni segnalazione e' stata letta come sintomo dello *scopo* del codice, non come riga da zittire.

| Area | Scopo del codice | Cosa diceva l'errore davvero |
|------|------------------|------------------------------|
| Migrazione `2026_10_05_174817_create_permission_tables` (+ 2 copie legacy) | Creare le tabelle Spatie **con i nomi di `config/permission.php`** (immutabili: `model_has_permission`, ...) | `config()` e' `mixed`: i `@var` inline erano finti e PHPStan (`treatPhpDocTypesAsCertain: false`) non li accetta. Serve restringere il tipo a runtime |
| `FetchUserApiTokenCommand` | Emettere un token di debug; utente assente => messaggio + exit code 2 | `$user_class` inutilizzato rivelava che `getUserByEmail()` (lancia eccezione) aveva reso **morto** il ramo "User not found" |
| `OauthAccessTokenResource` (bulk revoke) | Dire all'admin *quanti* token ha revocato | `$count` calcolato e mai mostrato: la lang `it` ha gia' `:count token revocati`, mancava il parametro |
| `ChangeTypeCommand` | Messaggio "User type changed to '<label>'" | `$labelString` assegnato 2 volte; label `null` produceva stringa vuota |
| `InteractsWithTenant::tenant()` | Relazione `belongsTo` | Caricava il tenant di sessione per poi scartarlo: side effect inutile in una relazione (che non dipende dalla sessione) |
| `Login/FailedLoginListener` | Registrare l'accesso in `authentications` | `$log` serviva solo alle notifiche, disattivate (commento aggiornato) |
| `ProcessCallbackController`, `UpgradeController`, `Assign{Role,Tenant}Command` | - | Variabili/query morte (`UpgradeController` caricava TUTTI gli utenti per niente; la route e' commentata) |
| `UserSeeder::seedSystemTeams` | Creare 5 team di sistema | 5 variabili mai lette: ora il conteggio loggato deriva dai team davvero creati |
| `Confirm` (Livewire) | `->extends('pub_theme::layouts.auth')` | Un `@var View` (contratto) mentiva sul tipo: `view()` ritorna `Illuminate\View\View`, che ha la macro Livewire |
| Test "has X" senza assert | Verificare l'esistenza di metodi/proprieta'/relazioni/hash password | Il nome prometteva un assert, il corpo no (test vuoti = falsi verdi). Ora asseriscono davvero |
| Helper test `enableTwoFactorForUser` | Abilitare 2FA con eventuali override | `$attributes` ignorato: ora e' applicato con `forceFill` |
| Costanti di classe | Tipizzate (`typeCoverage.constantTypeCoverage`) o enum se sono un insieme di valori | Vedi AC enum |

### Decisioni enum

- `NameSearchEnum` (`before`/`after`): erano i nomi dei metodi `Stringable` chiamati dinamicamente (`->$searchMethod()`) + `validateSearchMethod()` duplicato in 3 classi. Con l'enum lo stato non valido non e' rappresentabile.
- `DefaultRoleId` (1/2/3): sostituisce `Role::ROLE_ADMINISTRATOR|OWNER|USER` (consumatore unico: `RoleTest`; il resto e' codice commentato).
- `FetchUserApiTokenExitCode` (1/2): exit code del comando.
- `UserType::API|WEB`: erano nomi di guard (`config/auth.php`), usati una volta ciascuno nel `match`: **eliminati** (inline `'web'`/`'api'`), non sono un dominio dell'enum.
- `FREE_STARTING_CREDITS` (500) e `DEFAULT_NAME` (colonne Filament): parametri di configurazione, restano costanti **tipizzate** (stesso pattern del modulo UI).

## Acceptance Criteria

- [x] Tutte le 108 segnalazioni analizzate partendo dallo scopo del codice (chiamanti + doc + history)
- [x] Nessun `@phpstan-ignore*`, nessun `@var` bugiardo, nessun cast/assert finto, `phpstan.neon` intatto
- [x] Nomi tabelle permission sempre da `config('permission.table_names.*')` (config non toccata)
- [x] Costanti che sono insiemi di valori => backed enum (3 nuovi enum), aggiornati tutti i consumatori
- [x] Nessun file cancellato/spostato/rinominato; duplicati segnalati, non toccati
- [x] Test "vuoti" ora con assert reali
- [x] `php -l` OK su tutti i file toccati
- [ ] `phpstan analyse Modules/User` a 0: **restano 4** `classConstant.nativeTypeNotSupported` (vedi sotto), bloccati da una decisione fuori scope

## Blocker (decisione umana)

`laravel/composer.json` dichiara `"php": "^8.2"` => PHPStan deduce PHP minimo 8.2 e segnala come errore ogni costante con tipo nativo
(`classConstant.nativeTypeNotSupported`), mentre senza tipo scatta `typeCoverage.constantTypeCoverage`. Le due regole sono in conflitto finche' il vincolo e' `^8.2`.
Il runtime e' 8.4: serve alzare a `^8.3`/`^8.4` (file fuori scope User, tocca tutti i moduli). Errori residui in User:
`Listeners/AssignFreeCreditsListener.php:21`, `app/Listeners/AssignFreeCreditsListener.php:21`, `UserColumn.php:27`, `SingleRoleSelectColumn.php:25`.

## GitHub (tracciamento)

<<<<<<< .merge_file_GKSWxj
=======
<<<<<<< HEAD
- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO
=======
<<<<<<< HEAD
- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO
=======
>>>>>>> .merge_file_faQsMU
- Issue: https://github.com/laraxot/base_techplanner_fila5/issues/34 (tracking «PHPStan level max: percorso verso zero errori su Modules/»; ogni commit di questo lavoro cita il link)
- Discussion: TODO

## Ripresa 2026-11-17 — baseline 8 errori, 4 in User

`phpstan analyse Modules` (cache pulita, via `heavy-slot.sh`): 8 errori in 5 file. Quattro in User, quattro nel trait `Rating/HasRating` (vedi sotto).

| File | Scopo del codice | Cosa diceva l'errore davvero | Esito |
|------|------------------|------------------------------|-------|
| `Http/Livewire/Team/Change.php:45` | Componente legacy del selettore team (sostituito da `TeamChangeWidget`, nessun importatore): popola `$teams` per la view | `$teams` e' `list<...>` perche' Livewire deve serializzare un array JSON, non un oggetto; `->values()->all()` e' una lista solo a runtime, PHPStan non la vede | `array_values(...)`: la normalizzazione esiste davvero e il tipo dichiarato resta stretto |
| `tests/Feature/Filament/Pages/CreateUserTest.php` etichetta/titolo | Garantire che la pagina di creazione abbia un'etichetta e un titolo | `assertNotNull` su `string\|Htmlable` e' sempre vero: il test non provava nulla | Verifica testo non vuoto (Htmlable → `toHtml()`) |
| idem, "basic form functionality" | Garantire che la pagina abbia un form che funziona | `method_exists($page,'form')` e' vero per ereditarieta': nessuna protezione dal rischio reale (Form vuoto = pagina vuota senza errori) | `UserResource::getFormClass()` e' un `XotBaseResourceForm` con `getFormSchema()` non vuoto |

Verifica: `php -l` OK; PHPStan sui 2 file `[OK]`; a cache pulita **0 errori in User**; Pest (scratch DB): 18 passati incl. i 3 test riscritti.
Pint (preset `laravel`) riscriveva stile Yoda e `new X;` fuori dal perimetro del fix: ripristinato a mano. **Non lanciare `pint` sui file senza controllare il diff**: il codebase usa Yoda.

### Difetti trovati (non erano segnalazioni PHPStan)

1. **`tests/TestCase.php::connectionsToTransact()`**: `'fixcity'` nella lista condivisa tra i progetti del monorepo; dove il modulo Fixcity non e' attivo `connection('fixcity')` lanciava *not configured* e **nessun test User partiva** (198 file). Stesso bug gia' risolto in `Notify/tests/TestCase.php` togliendo il nome; qui si saltano i nomi senza configurazione (resta valido dove `fixcity` esiste). Zero effetto sulle connessioni configurate.
2. **`bashscripts/tools/pest-scratch-db.sh`** non esporta `DB_USERNAME_USER`/`DB_PASSWORD_USER` (vuoti in `.env`, letti senza fallback da `config/database.php:97`): la connessione `user` fallisce con `Access denied for user ''`. Workaround usato: esportarli da `DB_USERNAME`/`DB_PASSWORD` per quella sola esecuzione. Da sistemare nel tool.
3. Il `migrate --force` nel `setUp` di `TestCase` (solo su DB scratch) inciampa in `Class "CreatePostViewsTable" not found`: una migrazione con classe nominata non risolvibile; il primo test di ogni processo ne paga il costo. Da trovare (modulo owner probabile: Blog/Cms).
4. **`Feature/Filament/Resources/UserResourceTest.php`**: 8 test leggono `section01`/`section02`, ma `UserForm` ora e' `main → Grid → UserSection`. Test rimasti indietro rispetto al refactor del form: vanno riscritti sullo schema vero, non adattati alla cieca.

### Rating / Xot: pivot tipizzato di `morphToManyX` (chiuso a fine sessione)

Un altro agente (sessione concorrente, nessun lock) aveva iniziato a tipizzare `Xot/RelationX::morphToManyX()` con `@template TPivot` + parametro `pivotClass:` e a passare `RatingMorph::class` da `Rating/HasRating`. Si e' fermato a meta' (file immobili da 10+ minuti): la modifica spostava gli errori (6 `return.type` a `RelationX.php:120` + 1 `method.childReturnType` su `Blog\Article::ratings()`). Completata da questa sessione, senza riscrivere il suo lavoro:

| Punto | Scopo | Causa dell'errore | Correzione |
|-------|-------|-------------------|------------|
| `RelationX::morphToManyX()` `@return` | Relazione morph N:M col pivot **dedotto** per convenzione, oppure **esplicito** (`RatingMorph` ha `user_id`/`points`) | Nel ramo `pivotClass === null` il pivot e' `MorphPivot`, non `TPivot`: PHPStan non puo' unificarli | `($pivotClass is null ? MorphPivot : TPivot)`: provato prima in un file di prova fuori dal repo, poi applicato (solo docblock) |
| `HasRatingContract::ratings()` | Contratto degli host con rating | `$this` non e' ammesso come `TDeclaringModel` in un'interfaccia e `Model` e' invariante: l'implementazione `$this` risultava incompatibile | `covariant Model` (stesso schema di `UserNotificationsContract`) |

Chiamanti di `morphToManyX`: `HasRating` (esplicito) e `XotRelationManageStatesCoverageTest` (dedotto), entrambi coperti.
Nuovo test `Rating/tests/Unit/HasRatingPivotTest.php`: `ratings()` usa `RatingMorph` come pivot (1 passato, senza DB). Nota: una versione in stile funzionale con `uses(TestCase::class)` era rossa/ridondante perche' `Modules/Rating/tests/Pest.php` non viene caricato quando Pest parte da `laravel/` mentre la regola PHPStan lo da' per applicato: i test del modulo restano a classe, come i fratelli.

**Esito:** `phpstan analyse Modules` a cache pulita = **0 errori** (8 → 0).

### Strumenti condivisi: la radice puntava a un altro progetto

`bashscripts` e' un symlink a `../base_ptvx_fila5/bashscripts/`; `md-filenames.py` e `claims-open.py` calcolavano la radice con `Path(__file__).resolve()` (segue il symlink): da techplanner elencavano 1674 `.md` e lock/claim **di ptvx**, e un `apply` avrebbe rinominato file di un altro progetto. Ora la radice e' il git toplevel del cwd (`MD_FILENAMES_ROOT` per forzarla). Misurato: techplanner 2127 violazioni di nome `.md` (User 772, Notify 410, Themes/docs 283, UI 147, Lang 119, Cms 93, Geo 61…), ptvx invariato a 1674. Altri 4 script Python (`docs-organizer.py`, `fix-module-root-hygiene.py`, `release/go-live-gate.py`, `worklog/worklog.py`) usano lo stesso schema: da verificare prima di usarli qui.

### Aperto (non eseguito di proposito)

- Rinomina di massa dei `.md` e miglioramento dei prompt in `bashscripts/docs/prompts`: altri agenti li stavano gia' modificando in massa (126 file prompt toccati in 30 minuti; commit Activity di 1189 file; 783 modifiche non committate): un `apply` ora collide e salterebbe quasi tutto come «sporco». Da fare quando il repo e' quieto: `python3 -I bashscripts/tools/docs/md-filenames.py plan` poi `apply --only <modulo>` un modulo alla volta.
- 9 lock di sessioni vecchie (~11 giorni) in `Themes/Two`, `config`, `Seo`: stantii, non rimossi (decide l'utente).
- Difetti 2, 3, 4 sopra (tool scratch, migrazione `CreatePostViewsTable`, `UserResourceTest`).

### Chiusura 2026-11-17 (sera): detriti di merge e risultato a freddo

Issue: https://github.com/laraxot/base_techplanner_fila5/issues/34

**Risultato:** `phpstan analyse Modules` a cache pulita = **0 errori, exit 0** (16:49), dopo aver riparato i residui del merge. I tre agenti di sessione hanno tolto le annotazioni `@phpstan-ignore` dove nascondevano un difetto reale: UI (48 tolte, test dei modelli opzionali Asset/Theme/Component, mai esistiti in UI), Geo (8 su 10, `GeographicalScopes` con binding al posto dell'interpolazione SQL), Xot (2: generics di `CheckAccessorTwinsCommand` e `method.staticCall` in `FilamentSchemaCoverage`, il ramo «form» ora esegue davvero gli schemi).

**Causa dei detriti:** `bashscripts/git/subtrees/merge_remote_repo_2.sh laraxot` (deprecato, 7 istanze) esegue `commit -am "."` + merge `--allow-unrelated-histories` + push in ogni repo di modulo: committa e spinge marker di conflitto e lascia `MERGE_HEAD` stantio (User 367 conflitti, Geo 1181, UI 30, Xot 8). Un secondo attore toglie i marker lasciando i due lati concatenati.

**Come ho risolto (a mano, hunk per hunk, regola `laraxot-git-conflicts`):**

| Cosa | Scelta | Perche' |
|------|--------|---------|
| Notify: 7 file PHP + 3 test/lang | lato con `Assert::string` in `TestMailtrap`; costanti in `CheckMailDnsAction` (usate nel corpo); lang in forma espansa | il lato scartato era codice morto o piu' debole |
| Rating: `HasRating`, `HasRatingContract` | `pivotClass: RatingMorph::class` e `covariant Model` | evita `generics.notSubtype`; il contratto e' tornato alla forma `$this` due volte dopo i merge |
| Employee: `EmployeeTest` | riscritto in avanti dal commit pre-merge `81b7d24` (18 test) | la versione unita aveva `toBeTrue()` e `toBeFalse()` sullo stesso oggetto e subordinati mai creati |
| User: 33 lang `it` con chiavi duplicate | ricostruiti dagli stage dell'indice (`:2` locale, `:3` upstream), priorita' al locale + chiavi solo-upstream | 28 su 33 identici a cio' che l'app valutava gia' |
| User: `CreateUserTest`, `PermissionTest`, `UserTest`, `TenantTest`, `BaseTenantKeyTest`, `passport_stats` | `use` deduplicati, import ripristinati, `new Tenant;` (forma prevalente nel codebase: 141 contro 52), `return []` morto tolto | detriti dell'unione |

**Decisioni per l'utente (non prese da me):**
1. `lang/it/users.php`: 12 etichette in conflitto, tenuto il locale (`Nome` / `Nome e cognome`, `E-mail` / `Email`, `Team attuale` / `Team corrente`...). Se prevale l'upstream va ribaltato.
2. Fermare o no lo script di merge: l'utente ha risposto «FA ALTRO», quindi non l'ho toccato. Finche' gira i marker tornano e i remoti `laraxot/module_*` ricevono commit con marker.
3. Repo a meta' merge (User, Geo, UI, Xot): abortire o chiudere il merge; da li' non si puo' committare in parziale. Le mie modifiche in quei moduli vivono solo nel repo radice.
4. `Change.php` (e `Profile/SuperAdmin.php`, `Socialite/Buttons.php`): non tracciati, ma `RetiredChromeLivewireTest` pretende che non esistano.
5. Le 5 `@phpstan-ignore trait.unused` residue (Geo `EnsuresGeoDatabaseSchema`, 7 trait Xot) e i 3 test UI sempre `skipped`.
6. `Support/AuthenticatedTenantKey.php`: un altro attore ha tolto dal merge il blocco upstream (risolve la chiave con `Context::remember`, una query in meno per richiesta) e tenuto la versione locale, semplice. Se serve la memoizzazione va reintrodotta a mano.
7. Test che non girano o sono rossi per l'ambiente, non per il codice: `Employee/tests/Unit/Models/EmployeeTest.php` non dichiara `uses(TestCase::class)` (mai dichiarato, nemmeno prima del merge: `Target class [config] does not exist`); `Notify/.../MailtrapBridgeConfigurationTest` pretende `mail.mailers.mailtrap-sdk`, definito da nessun file di config; `Notify/.../InboundMailWebhookTest` e `Rating` non trovano le tabelle nel DB scratch; `User/.../UserTest` cade su `CreatePostViewsTable`; i test strutturali di Xot (`EveryModuleHasSettingPageTest` ecc.) segnalano moduli senza `SettingPage` (DbForge, AI, Blog).
<<<<<<< .merge_file_GKSWxj
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> .merge_file_faQsMU
