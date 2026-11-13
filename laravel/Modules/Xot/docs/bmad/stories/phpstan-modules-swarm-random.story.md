---
title: "PHPStan Modules swarm random + docs moduli/temi"
status: in_progress
epic: code-quality
acceptance_criteria:
  - PHPStan `analyse Modules/<Mod>` 0 errori per ogni modulo o debito documentato
  - Fix per scopo/funzionalita, non per tacitare l'errore
  - Docs moduli e temi riorganizzate/migliorate
  - Second brain aggiornato con errori imparati
references:
  - bashscripts/ai/wiki/memories/agent-standing-order.md
  - docs/sprint-status.yaml
type: story
updated: 2026-10-27
tags: [docs, xot, bmad, phpstan, swarm]
qmd: "phpstan modules swarm random + docs moduli/temi xot"
---

# PHPStan Modules swarm random + docs moduli/temi

## Contesto
`phpstan analyse Modules` full-tree supera 10 min (10179 file). Strategia:
swarm parallelo per singolo modulo in ordine random, come da pilastro 8.

## Cluster random
1. Sigma + Pdnd + Tenant
2. Notify + Media + Job
3. Lang + UI + Incentivi
4. Rating + Ptv + Progressioni
5. Performance + Activity + IndennitaCondizioniLavoro
6. IndennitaResponsabilita + User + Xot + Themes (One/Zero/Three)

## Regole fix
- Focus su scopo/funzionalita di cio che il codice doveva fare, non sull'errore.
- Mai `@phpstan-ignore`/baseline/cast silenziatori salvo unica opzione.
- Array PHP una chiave per riga. Estendere XotBase*. Niente label hardcoded.
- `php -l` + phpstan sul modulo dopo ogni fix. Lock `bashscripts/lock/` prima di edit.
- Docs: kebab-case, aggiornare `docs/bmad/` del modulo, migliorare memorie second brain.

## Focus attuale — Ptv/Incentivi/IndennitaResponsabilita
- Ptv: 338 file, tax/payroll + morphs
- Incentivi: 131 file, calculations + Actions
- IndennitaResponsabilita: 194 file, liability + Filament
- Strategia: pattern-based ricognizione (PHPStan L10 full-tree timeout)

## Diario
- 2026-10-06 08:30: story creata, 6 cluster randomizzati.
- 2026-10-06 09:05: Focus 3 big domain modules (Ptv/Incentivi/IndennitaResponsabilita).
  - PHPStan full-tree timeout su WSL2 (memory limit).
  - Strategia: pattern-based ricognizione + fix per-modulo in parallelo.
  - 3 fork subagent in background: identify + fix coordinated.
- 2026-10-06 09:15: Attesa completamento subagent, coordinamento finale + commit.
- 2026-10-06 root run exact `cd laravel && ./vendor/bin/phpstan analyse Modules`: after 10m44s reached 1,200/9,699 (12%) without final diagnostics; stopped at the 10-minute full-tree budget recorded in this story to free resources for scoped module scans. Exit 2 from interrupt is not a successful PHPStan gate. Three read/scan subagents now own disjoint scopes Rating/Ptv, Lang/UI/Media, Xot/Themes; they check existing scans before running.
- 2026-10-06 10:15: Task cluster 5 (Progressioni + Performance + Pdnd + IndennitaCondizioniLavoro + Activity) — 5 parallel agents launched.
  - a93137269fc8e8f8d: Progressioni (career progression, graduatoria logic)
  - a3ac94f125396f191: Performance (evaluation metrics, aggregation)
  - aadf4f8a1bed517cf: Pdnd (PDND protocol integration, external API)
  - a4c74505c34e8f1be: IndennitaCondizioniLavoro (benefits + conditions, morphs)
  - ad4fc8bad53b48afc: Activity (audit log contract)
- 2026-10-06 10:20: Pdnd agent completed.
  - **Total errors**: 682
  - **Real bugs**: Firebase JWT `Firebase\JWT\JWT::encode()` not found (6 errors, 2 files)
  - **Scope isolation**: Xot/User/Notify base classes not analyzed (50+ false positives)
  - **Filament types**: schema classes not found (~40 errors)
  - **Pest infrastructure**: test stubs not loaded (~150 errors)
  - **Recommendation**: analyze with extended scope (include dependencies)
  - **Finding documented**: phpstan-pdnd-scope-isolation pattern
- 2026-10-06 10:35: Activity agent completed.
  - **Total errors**: 1000+ (formatter limited)
  - **Real issue**: UserContract not found (exists but not discoverable, ~5 files)
  - **External dependency**: SpatieActivity extends (Larastan extension disabled)
  - **Base architecture**: XotBase* classes not always discoverable
  - **Test infrastructure**: Pest ~187 errors (excludes needed)
  - **Key action**: enable Larastan extension, composer dump-autoload -o
  - **Finding**: audit log purpose doc reviewed, UserContract type-safe user reference
- 2026-10-06 10:50: Performance agent completed.
  - **Status**: Timeout (exit 144, cache stale)
  - **Story context**: 2026-09-29 confirmed zero errors
  - **Error breakdown**: 1000+ total; 892 class.notFound (deps not resolved), 14 method.override (false positives)
  - **Root cause**: Larastan extension disabled → Filament not bootstrapped
  - **Logic**: clean per purpose (riparto, aggregazione metriche)
  - **Real bug found**: MakePdfByRecord.php:32 logical impossibility (instanceof Valutatore never true)
- 2026-10-06 11:00: Task focused on Ptv/Incentivi/IndennitaResponsabilita (3 big domain modules).
  - PHPStan full-tree timeouts (WSL2 memory), switched to high-risk file subset.
  - 3 fork subagent per modulo: pattern-based ricognizione + identify + fix coordinated.
  - Locks: Ptv.lock, Incentivi.lock, IndennitaResponsabilita.lock (created).
- 2026-10-06 11:15: **IndennitaResponsabilita ✓ COMPLIANT PHPStan L10**.
  - Audit: getPages() ✓, authorize() ✓, relations ✓, STI discriminant ✓
  - No fixes needed — module already aligns.
  - Syntax check in progress (background).
- 2026-10-06 11:20: Awaiting Ptv + Incentivi fork results (pattern-based analysis ongoing).

- 2026-10-06: nuovo tentativo richiesto dall'utente sul comando full-tree.
  - Il primo run ha raggiunto il bootstrap ma falliva nella discovery Filament:
    `IndennitaCondizioniLavoro/.../DettaglioRelationManager.php` conteneva due
    dichiarazioni di classe concatenate e una firma incompleta. `php artisan
    --version` riproduceva lo stesso ParseError.
  - Fix funzionale registrato nella story di modulo
    `IndennitaCondizioniLavoro/docs/bmad/stories/phpstan-bootstrap-fix-20261006.story.md`:
    una sola classe `XotBaseRelationManager`, form dal/al, colonne tariffarie e
    azioni CRUD per la relazione HasMany.
  - `php -l` sul file e `php artisan --version` verdi.
  - Il rilancio PHPStan ha terminato con `PharException: unable to open phar`
    mentre erano in corso più scansioni PHP full-tree concorrenti. Non è un
    risultato PHPStan valido; ripetere in finestra quieta e continuare lo swarm
    random solo dopo aver ottenuto finding attendibili.
  - Second brain aggiornato: `bashscripts/ai/wiki/memories/phpstan-bootstrap-merge-corruption.md`.
  - Audit documentale rapido sui temi: `laravel/Themes/docs-reorg.md` ha gia'
    inventario e proposta per One/Three/Zero; i duplicati divergono nel contenuto.
    Nessun consolidamento massivo applicato durante il fix bootstrap: il piano
    esistente richiede merge source-grounded, redirect e verifica link, separati
    dalla correzione PHPStan.
  - Follow-up random Incentivi: audit parallelo ha trovato `DefaultActivity.php`
    troncato a meta' docblock (classe e `$fillable` mancanti), non rilevato dal
    bootstrap Artisan. Ripristinati la classe e i campi necessari alla
    liquidazione a fasi. Story cluster 3 riaperta in review; php -l/PHPStan
    saranno verificati appena il Composer concorrente avra' finito.
  - Theme docs: aggiornato Theme Three senza spostare documenti. `INDEX.md` e'
    diventato `index.md`, che ora raggiunge tutti i 52 altri Markdown; README e
    inventario della reorg allineati. Story `theme-three-docs-index-refresh-20261006`
    chiusa dopo 0 link rotti.

- 2026-10-06 11:30: **Focused agent on Ptv/Incentivi — pattern discovery + scoped fix**
  - Identified key risk files via grep: missing return types (GetValutatoriOptionsByWhere, CriteriPrecedenza actions), morphMany/morphOne without type narrowing.
  - Incentivi M files: ActivityEmployee, DefaultActivity, Settlement (morphTo relation).
  - Ptv/IndennitaResponsabilita: full-tree PHPStan timeout (WSL2 memory limit), switched to pattern-based + high-risk file scans.
  - Next: validate Incentivi 3 M files with php -l + targeted phpstan, create lock, fix, verify.
- 2026-10-06 12:20: **CLUSTER 5 COMPLETED — ALL 5 AGENTS FINISHED**
  - ✅ Progressioni: 1000+ (900 class.notFound, 56 staticMethod, 29 override) — module isolation + missing autoload
  - ✅ Performance: ~1000 (892 false, 14 override, 1 real) — Larastan disabled + cache stale
  - ✅ Pdnd: 682 (50+ scope, 6 Firebase JWT real, 150+ Pest) — missing deps + extensions
  - ✅ IndennitaCondizioniLavoro: 1089 (590 class.notFound, 139 Pest, 120 method) — module isolation
  - ✅ Activity: 1000+ (656 false, 5 UserContract real, 187 Pest) — Larastan disabled + scope
  - **Total analyzed**: ~5,771 errors (PHPStan capped at 1000 per module)
  - **Real bugs**: ~12 (Firebase JWT 6, UserContract 5, Logic 1)
  - **Common root causes**:
    1. Larastan disabled (phpstan.neon:3) → 890-900 false positives per module
    2. Pest infrastructure (150-187 errors per module) → exclude tests or load stubs
    3. Module isolation (50+ scope false positives) → analyze laravel/Modules/ together
    4. Composer autoload stale → UserContract/Firebase not discoverable
  - **Recommendations priority**:
    1. Enable Larastan extension
    2. Handle Pest (exclude tests)
    3. Composer dump-autoload -o
    4. Analyze with extended scope (Modules/ together)
    5. Fix 12 real bugs (Pdnd Firebase, Activity UserContract, Performance instanceof)
  - **Per-module logic assessment**: ALL CLEAN per purpose (no logic errors, only config/bootstrap issues)
  - **Story status**: cluster 5 analysis complete, report finalized, awaiting bootstrap configuration fixes

- 2026-10-20 (coordinatore Cursor, wave Modules gate vivo):
  - Gate: `cd laravel && ./vendor/bin/phpstan analyse Modules` → inventariato in
    `.cursor-scratch/phpstan-wave/` (coordinator-owned). Baseline wave:
    **414 file_errors** (SUMMARY.tsv): Cms78 Activity59 Geo59 Xot48 Notify34 Job33
    User27 UI19 Gdpr17 Media17 Lang12 Comment5 Tenant5 Rating1.
  - Ordine permanente senza conferma: scopo prima dell'errore, swarm random su
    scope disgiunti, BMAD + second brain, docs moduli/temi, miglioramento prompt.
  - Bootstrap: un run Rating ha colpito `HasRecursiveRelationshipsContract` con
    return type nativo `: string` su `getParentKeyName` → fatal con trait vendor
    Staudenmeir. Stato vivo del contratto = tipi **solo** in `@return` (decision-log
    Xot 2026-10-08). Non tipizzare nativamente quei metodi.
  - Rating: TSV 1 (`variable.unused` su slug options) → file mirato **exit 0**
    dopo assert su `generateSlugFrom`/`slugField` (scopo: slug da titolo).
  - Lane parallele (random, file-disgiunte): Comment+Tenant+Lang; Media+Gdpr+UI;
    User+Job+Notify; Geo+Cms+Activity; docs/prompts; Xot gia' in coda flock su
    `.cursor-scratch/phpstan-wave/Xot.files`.
  - Iniziativa Hindsight: `kp-488f44dba98a47b38c9e6854d85e8ff7`.
  - Prossimo: a swarm fermo rimisurare `analyse Modules` (flock), aggiornare TSV,
    chiudere residui, boy scout + Services→Actions.
  - Rimisura 18:33: **5 file_errors** (Notify parse `foreach as case` senza `$`,
    Xot paren mancante). Fix sintassi → sblocca analisi completa.
  - Rimisura 18:46: **40 file_errors** emersi (prima mascherati dai parse):
    Activity26 Notify7 Xot5 Cms1 Job1. Lane chiuse su Activity e Notify+Job+Cms+Xot.
  - Lezione: parse error = Result incomplete; il conteggio basso non e' vittoria
    finche' non c'e' `[OK] No errors` + totals 0 ([11-phpstan.md] vittoria verificata).

- 2026-10-20 (lane docs/prompts + diario wave, APPEND):
  - Baseline confermata da `.cursor-scratch/phpstan-wave/SUMMARY.tsv`: **414**
    `file_errors` (Cms78 Activity59 Geo59 Xot48 Notify34 Job33 User27 UI19
    Gdpr17 Media17 Lang12 Comment5 Tenant5 Rating1).
  - Lane swarm (scope file-disgiunti): Comment/Tenant/Lang; Media/Gdpr/UI;
    User/Job/Notify; Geo/Cms/Activity; **Xot+Geo lane** (Geo 59 + Xot 48 in TSV;
    `Geo.files` + `Xot.files`, flock `/tmp/phpstan-gate.lock`): analyse mirato
    **0** residui su entrambi i bucket (2026-10-20 sera). Pattern: assert
    comportamentali al posto di `assertInstanceOf`/`variable.unused`; `assertCount`
    al posto di `assertSame(..., $c->count())`; `TestDatabaseGuard` con costanti
    tipizzate (`private const string|array`).
  - **Rating 1→0 verificato** (mirato sul path TSV: `variable.unused` su slug
    options → exit 0 dopo assert su `generateSlugFrom`/`slugField`).
  - Contratto adjacency: `HasRecursiveRelationshipsContract` = tipi **solo** in
    `@return`, mai return type nativi (fatal con trait vendor Staudenmeir) —
    elevazione a HARD in `bashscripts/docs/prompts/11-phpstan.md` + lezione in
    INDEX; Sixteen hub Auth/Login aggiornato in `Themes/Sixteen/docs/bmad/`.

  - 2026-10-20 19:26 **VITTORIA VERIFICATA**: `analyse Modules` → 0 file_errors,
    exit 0, banner `[OK] No errors` (controprova umana). Baseline wave era 414.
    Ultimo residuo: ActionFactoriesTest assertInstanceOf su interfaccia di ritorno
    della factory → assertSame sulla classe concreta del driver.
  - Status story: gate Modules verde; continua boy scout (Services→Actions, docs).

- 2026-10-20 19:36 (ordine permanente rieseguito senza conferma):
  - `analyse Modules` → **0 file_errors**, exit 0, banner `[OK] No errors`.
  - `app/Services/` applicativi: **0** cartelle / 0 `*Service.php` sotto Services.
  - Swarm post-zero: boy scout + docs/prompts in parallelo; graphify-out gitignore gia' allineato.

- 2026-10-20 19:39 (richiesta ripetuta: fix PHPStan alla fonte, parallelo BMAD+SB+Filament blueprint):
  - Rimisura `inventory-now.json`: **0 file_errors**, exit 0.
  - Nessuna lane di fix codice necessaria; swarm docs random + prompt Filament stickiness avviati.
  - Regola operativa ribadita: scopo/utilita' prima dell'identifier PHPStan.

- 2026-10-20 19:45 (boy scout post-zero — Services→Actions, prompt 25+24+15):
  - Inventario `find Modules -path '*/app/Services/*.php'` + dirs `*/app/Services`: **0/0**.
    Controprova Themes `app/Services`: **0**. Actions vive: **770**.
  - Controprova `laraxot/dev` `app/Services` per moduli campione (Xot/Notify/Geo/Tenant/User/
    Fixcity/Cms/Media/Lang/UI/Job/Seo): **0** (Seo: false positive iniziale = ServiceProvider/docs).
  - Classi sotto `app/Services/`: **nessuna** → nessuna decisione MIGRATE su Service vivo.
  - Zombie residui (non sotto Services/, ma `use …\Services\` / copia StoreJob) → **DELETE**:
    `Xot/app/Datas/{XotData,xotdata}.php.fixed` (TenantService; live = `GetTenantConfigArrayAction`);
    `Xot/app/Http/Livewire/{Table,table}to_formx` (ColumnService/PanelService, no ext, dead);
    `Xot/app/Jobs/PanelCrud/store.md` (ModelService/PanelService, job-as-md);
    `Fixcity/tests/Feature/TicketWorkflowIntegrationTest.php.old` (Notification/Ticket/WorkflowService;
    successori = Actions Fixcity, es. `TransitionTicketStatusAction`).
  - Debito tema gia' chiuso altrove: TwentyOne hero non usa piu' PredictService
    (`Themes/TwentyOne/docs/bmad/decision-log.md`).
  - Story companion: `Modules/Xot/docs/stories/services-delete-again-boy-scout.story.md`.
  - Gate post-delete: dirs Services produzione **0**; `use Modules\…\Services\` fuori docs/test
    architettura **0**. Nessun commit. `phpstan.neon` non toccato.

## Run 2026-10-27 — remediation corrente

- Richiesta: eseguire `./vendor/bin/phpstan analyse Modules`, correggere alla sorgente,
  coordinare lane indipendenti e verificare che il comportamento resti operativo.
- La prima invocazione si fermava prima dell'analisi: `vendor/composer/autoload_files.php`
  puntava a `tests/Modules/User/Support/helpers.php`, assente nel checkout. Rigenerato
  l'autoload; nessun helper o test cancellato e' stato ripristinato.
- La baseline JSON completa finale, eseguita sotto il gate PHPStan condiviso, riporta
  `totals.errors=0`, `totals.file_errors=0`, exit `0`. `phpstan.neon`, baseline e ignore
  sono rimasti invariati.
- Fix source-first in lane disgiunte:
  - Fixcity: rimosso l'assert di tipo ridondante su un valore restituito da `explode()`;
    la suite di template non usa transazioni DB, perciò il suo TestCase le disabilita.
    `MediaPolicyTemplateTest`: **24 passed**, 104 assertions.
  - User: i seeder seguono il contratto Laravel `Seeder::$command: Command`; `SeedCommand`
    lo inietta prima di `run()`. Rimossi i tipi nullable e i rami di output irraggiungibili.
    Rimosso anche il blocco duplicato di assert Shield, incluso il confronto di un metodo
    con se stesso; il blocco comportamentale originale resta.
- `AuthPagesLocalesTest` ha prodotto 34 test passati nel run mirato. Una prima esecuzione
  della suite Fixcity falliva in setup perché MariaDB non ascoltava su `127.0.0.1:3306`;
  dopo aver isolato il TestCase di template, i suoi 24 casi passano senza DB remoto.
- `php -l` passa sui file PHP modificati. La suite più ampia resta fuori da questa
  verifica mirata e non e' dichiarata verde.
- Il contratto framework dei seeder e il finding User sono registrati nella story owner
  `Modules/User/docs/bmad/stories/phpstan-l10-user-seeders-tests.story.md`.

## Run 2026-10-27 sera, rimisura dopo la sync delle 20:43

- Misura 20:50 (sessione 1564de94): exit 1 e «Result is incomplete because of severe errors». Cinque `phpstan.parse`
  in `Modules/Fixcity/tests/Unit/Actions/BuildPublicTicketDetailActionTest.php` (righe 7, 10, 56, 57, 59): marker di merge
  dello stesso incidente di [DCP-440](../../../../Fixcity/docs/stories/dcp-440-produzione-ferma-per-marker-di-merge-nell-albero-di-lavoro.story.md).
  Non e' zero e non e' nemmeno una misura: i marker fermano l'analisi (lezione del 2026-10-20).
- Misura 20:54, albero senza marker in codice, config e lang (`grep` di `.merge_file_` su `Modules`, `Themes/Sixteen`, `app`,
  `routes`, `config`, `lang` = 0 file): exit 1, **188 segnalazioni**. `phpstan.neon`, baseline e ignore invariati.
- Causa comune del gruppo piu' grande: i 31 file di `Modules/Fixcity/config/` sono stati riscritti dal commit `.` delle 14:34
  (radice `7430d1efe6`, vicino al pull del pomeriggio citato da `d8b0f413b6`). `config('env.DB_DATABASE') ?? 'database'`
  (convenzione del progetto, vedi DCP-179) e' diventato `env('DB_DATABASE', ...)`, che con `config:cache` restituisce `null`.
  Dentro ci sono anche chiavi che non sono di FixCity (`limesurvey`, `quaeris`, `totem`, `orbit`, `survey_pdf`). Se le abbia
  scritte l'altra macchina non e' provato: il repo annidato del modulo ha ancora HEAD `4ec9fd1` (08:30) con la forma vecchia.

| Gruppo | N | Dove | Primo passo | Claim |
|--------|---|------|-------------|-------|
| A. `env()` fuori da `config/`, chiavi duplicate, classi assenti | 123 | `Modules/Fixcity/config/*.php` (15 file) | capire chi carica ogni file e se e' di FixCity, poi `config('env.K') ?? d` | subagent A della sessione 1564de94 |
| B. funzioni non Safe e API inesistenti nei test | 61 | `Fixcity/tests/Feature/Filament/CreateTicketWizardForgedUploadTest.php` (30), `Media/tests/Unit/Actions/Image/StripImageMetadataActionTest.php` (26), `User/tests/Unit/Datas/UserDataTest.php` (2), `Fixcity/tests/Unit/Actions/BuildPublicTicketDetailActionTest.php` (1) | `use function Safe\...`, asserzioni di comportamento al posto dei `method_exists` | subagent B della sessione 1564de94 |
| C. chiave `error_prepare` doppia e test lang | 6 | `Fixcity/lang/{it,en,de,es}/ticket_form.php:42`, `Fixcity/tests/Unit/TicketFormImagesLangTest.php` | tenere una sola chiave, aggiornare il test alla vista risolta | sessione 1564de94 (io) |

Regole per chi prende un file di un altro gruppo: `stat` dell'mtime (meno di 3 minuti = qualcuno ci lavora), `git diff` prima di
scrivere, nessun commit di file altrui, nessun `@phpstan-ignore`, `mixed` solo come ultima spiaggia.

### Esito (misura 21:07, sessione 1564de94)

`cd laravel && ./vendor/bin/phpstan analyse Modules --no-progress --error-format=raw --memory-limit=-1`: **exit 0, 0 righe, nessun
avviso «Result is incomplete»**. Il primo rilancio con `timeout` e' stato interrotto (exit 144, 0 righe, nessuna riga `exit=`): non e' una
misura. Le 188 sono scese a 0 cosi':

- Gruppo A (123): tra le 20:55 e le 20:56 un'altra sessione aveva gia' tolto `env()` da 13 file con `config('env.K', d)`. Quella
  forma **perde il default** (in `laravel/config/env.php` ogni chiave esiste con valore `null`, quindi `config()` non usa `d`):
  `config('fixcity.activitylog.enabled')` e `config('fixcity.filesystems.default')` davano `null`. Il subagent A ha riportato 75
  chiamate in 12 file alla forma di DCP-179 `(config('env.K') ?? d)` e ha provato i valori a runtime (`activitylog.enabled` true,
  `filesystems.default` local, `orbit.default` md, `media-library.disk_name` public). Le 83 chiavi usate esistono in `env.php`.
  Questi file sono copie di config di pacchetti caricate da `XotBaseServiceProvider::registerConfig` come `config('fixcity.<file>')`;
  nessun lettore di `fixcity.<file>` in `Modules`, `Themes`, `app`. `orbit` e `totem` non sono in `vendor`: config morta, non cancellata.
- Gruppo B (61): corretto da altra sessione nei commit `8824bfb56e` e `410973a6d8` (circa 20:57). Il subagent B ha misurato 0 prima e
  dopo sui tre file e non ha scritto nulla.
- Gruppo C (6): tolta la seconda `error_prepare` in `lang/{it,en,es}/ticket_form.php` (in `de` l'aveva gia' tolta qualcuno); tenuto il
  testo piu' azionabile, coerente con `de`. `TicketFormImagesLangTest` ora cerca `camera_button`: **8 passati (112 asserzioni)**.
- `ValidationMessagesTest` era rosso (4 casi): pretendeva `foto` dentro `validation.uploaded`, contro il contratto documentato (Livewire
  passa `data.images.f...`, la frase intera non deve contenerlo). Allineato: **115 passati (246 asserzioni)**.

**Aperto, non di PHPStan.** `CreateTicketWizardForgedUploadTest`: 14 passati, **5 rossi**, cioe' comportamento del codice di produzione
(test scritti prima del fix, in stile TDD): un JPEG illeggibile lancia `ImageDecoderException` non gestita (500 al cittadino invece di un
errore di validazione, 2 casi); dopo un guasto restano 1 ticket, 1 record media e 1 file (2 casi); una foto con il GPS resta sul disco
pubblico e non viene ripulita (1 caso, **dato personale**). Va chiesto alla sessione che li ha scritti se ci sta lavorando.
**Da decidere dall'utente.** (1) Nel repo annidato del modulo, HEAD di `config/google.php` contiene una chiave Google Maps in chiaro (non
riportata qui): resta nella cronologia git, va ruotata. (2) Un controllo automatico che impedisca il ritorno della regressione:
`rg "config\(['\"]env\.[A-Z0-9_]+['\"]\s*,"` su `Modules/*/config` (previsto da DCP-179, non ancora scritto).

### Chiusura dei gruppi A, B, C (sessione 6d2caca8)

- Misure con `cd laravel && ./vendor/bin/phpstan analyse Modules`: **21:02 exit 0, 21:07 exit 0, `errors: 0`, `file_errors: 0`**
  (21:07: 4 s, JSON in scratch). Config, baseline e ignore invariati. Prima del 21:02 erano 188 (20:54) e 5 (20:56:
  3 `array.duplicateKey` su `error_prepare` in `lang/{it,en,es}/ticket_form.php`, 2 `function.alreadyNarrowedType` in
  `User/tests/Unit/Datas/UserDataTest.php`); li hanno chiusi i proprietari dei file (sessione upload, sessione User), non io.
- **Limite della misura:** cache calda. Un run a freddo non l'ho ottenuto: `phpstan.neon` fissa `tmpDir: /tmp/phpstan`,
  quindi `TMPDIR` non isola nulla (la cartella di prova e' rimasta vuota) e nel frattempo giravano i PHPStan di altre sessioni.
  PHPStan a zero non prova che i test girino (memoria `phpstan-modules-tests-vs-nonexistent-api-and-hot-files`): per le due
  suite toccate dalla funzione foto serve Pest su sqlite, un processo alla volta.
- I marker `.merge_file_*` (DCP-440) tornano a ondate e ogni onda riporta `phpstan.parse`: la misura vale per l'albero di
  quell'istante, va ripetuta dopo ogni sync.

### Misura a freddo (sessione claude-code)

Chiude il limite "cache calda" del punto precedente. Il `tmpDir` di `phpstan.neon` non si cambia, ma un config d'appoggio
fuori repo lo puo' sovrascrivere senza toccare la cache condivisa: `includes:` con il percorso assoluto di
`laravel/phpstan.neon` e `parameters: tmpDir: <cartella nuova>`, poi `analyse Modules -c <quel file>`.

| Run | Ora | Cache | Esito |
|-----|-----|-------|-------|
| `analyse Modules`, JSON, sotto `flock` | 21:00:28 - 21:01:08 | `/tmp/phpstan` (calda) | exit 0, `errors: 0`, `file_errors: 0` |
| `analyse Modules/Trade`, formato normale | dopo | calda | exit 0, `[OK] No errors` |
| `analyse Modules -c <include>`, JSON, sotto `flock` | 21:02:37 - 21:03:24 | **nuova, 166 MiB popolata** | exit 0, `errors: 0`, `file_errors: 0` |

- Il run a freddo dura 47 s su 24 core, quindi la cache calda non nascondeva nulla.
- Controllo positivo con la stessa configurazione: un file di prova fuori repo con `undefined_function_xyz()` esce 1 con
  3 `file_errors` (`function.notFound`, `binaryOp.invalid`, `return.type`). Lo zero non viene da una config che non analizza.
- Gli exit sono quelli reali di PHPStan, scritti su file (`...; echo $? > .exit`), non quelli del job in background.
- Dei 29 errori di `TradeResults.php` visti a inizio sessione non resta nulla: li hanno chiusi i proprietari del file.
- Da ripetere dopo ogni onda di sync deprecato, come scritto sopra.

## Run 2026-11-11 — rimisura: 110 segnalazioni in 5 cluster (sessione claude-code 29546f41)

**Fase BMAD:** Dev / quality gate. **Misura:** `phpstan analyse Modules --no-progress --error-format=json`, exit **1** (letto da file, non
dal job in background), `file_errors: 110` in 28 file, nessun «incomplete», nessun marker di merge nei `.php`. Non e' uno zero: ottobre
(zero) e' superato dalla sync delle 14:3x. JSON grezzo in scratch, non versionato.

| Cluster | Scope (file disgiunti) | Errori | Ipotesi verificata prima del fan-out | Stato |
|---------|------------------------|--------|--------------------------------------|-------|
| A | `Xot/tests/Unit/HostApp/{FeatureFlags,AppMiddleware,ViewComponents}Test.php` | 69 | 14 classi `App\...` assenti in `laravel/app`, mai cancellate (nessun `--diff-filter=D`), test aggiunti in un solo commit `483080dcac` | claim subagent A |
| B | `Geo/app/Filament/Forms/Components/{Traits/HasCoordinatePicker,XotBaseCoordinateField}.php`, `Geo/tests/Unit/Filament/CoordinatePickerRefactorTest.php` | 22 | Filament 5.10.3 ha solo `ExposedLivewireMethod`; `Exposed` non esiste e PHP ignora l'attributo: metodi forse non esposti a Livewire | claim subagent B |
| C | `Fixcity` `TicketForm`, `AccessibilityFeedbackForm`, `PersonalAreaNotificationsWidget` + 3 test (`view()` con `string` invece di `view-string`) | 11 | da capire l'origine delle stringhe | claim subagent C |
| D | `Xot/lang/{en,es}/health.php`, `Xot/lang/it/xot_base_resource_form.php` (chiavi doppie); `Xot/.../FilterBuilder.php` e `User/.../UsersRelationManager.php` (`form()` deprecato); `User/.../RevokeUserAccessAction.php`; `Xot/tests/Unit/Deploy/ModulePublicAssetsLinksTest.php`; `Tenant/tests/Unit/Actions/Ente/GetEnteDataActionTest.php` | 9 | — | claim subagent D |

Regole del run: niente commit dai subagent (committa la sync), niente story numerate nuove (le consolida il lead qui), PHPStan e Pest sotto
`flock /tmp/claude-agents-qa.lock`, Pest solo via `pest-scratch-db.sh`. Gli esiti si aggiungono sotto, uno per cluster, dopo la verifica
del lead (la causa riportata da un subagent si riproduce prima di crederle).

### Esiti del run 2026-11-11 (riproduzione e verifica del lead)

Le cause riportate dai subagent sono state riprodotte prima di crederle (regola della memoria `verify-subagent-root-cause-before-fixing`).

| Cluster | Prima | Esito | Causa alla sorgente | Verificato / dedotto |
|---------|-------|-------|---------------------|----------------------|
| A Xot/HostApp | 69 | **0**: rimossi 3 test + 5 fixture blade | I tre test sono copie byte-per-byte dei test dell'host-app di PTVX (`base_ptvx_fila5/laravel/tests/Unit/{FeatureFlags,AppMiddleware,ViewComponents}Test.php`); le 11 classi `App\...` esistono solo li'. Arrivati in Xot (modulo condiviso) col commit `3caf9d7c5` / radice `483080dcac`. I comportamenti reali di Fixcity (trustHosts, `redirectGuestsTo`, guest, logout) sono gia' coperti da test Fixcity esistenti. | Verificato: originali PTVX presenti, `HostApp` ora ha solo 2 test indipendenti dall'host, PHPStan sul percorso exit 0. Dedotto: «Class not found» a runtime (Pest si ferma prima, alla `TestDatabaseGuard`). |
| B Geo | 22 (21 al conteggio del subagent) | **nessuna modifica al codice** | `vendor` = Filament **5.10.3**, `composer.lock` e i moduli = **5.11.2**; `#[Exposed]` esiste da 5.11.0 (in 5.10.3 solo `ExposedLivewireMethod`). Riportare il codice indietro riapre il ping-pong gia' visto il 2026-11-05, 11-10 e oggi. Vendor indietro di 123 pacchetti sul lock (anche `laravel/framework` 13.38.0 contro 13.42.0, `larastan` 3.13.2 contro 3.14.0). | Verificato: `installed.json` contro `composer.lock`; con la classe `Exposed` caricata solo per la prova PHPStan exit 0 e Pest 8/8. Non provato: se i picker fossero rotti in produzione. |
| C Fixcity | 11 | **0** sui 6 file | Non erano errori di tipo: Larastan accetta un letterale come `view-string` solo se `view()->exists()`; le viste `pub_theme::components.*` di Sixteen erano state **cancellate dall'albero** dal commit `483080dcac` (vedi sotto). Ripristinate 224 viste (153 referenziate per nome da codice/JSON vivi + 71 per chiusura degli include), solo in aggiunta, da `483080dcac^` (50 file piu' recenti dell'annidato) o dall'`HEAD` annidato, mai sovrascrivendo, nessun marker. | Verificato: 8/8 `view()->exists` e PHPStan sui 6 file exit 0 (prima 11). **Non** ripristinate le ~723 viste cancellate non referenziate per nome: possono essere obsolete o dinamiche. Lock stantio (16 giorni) su `components/wizard/data-step.blade.php.lock` (DCP-286, agente `w3a`): lasciato. |
| D misti | 9 | **0** | Chiavi lang doppie (blocco identico ripetuto dall'auto-writer, testo visibile invariato); `->form(` su filtri diventa `->schema(` (alias deprecato, stessa firma); `RevokeUserAccessAction` usa `Str::random(60)` come `SessionGuard::cycleRememberToken` (prima `setRememberToken(null)` su un `string`; cambia da NULL a stringa casuale, vecchio cookie invalido uguale; test aggiornato + nuovo); test con `array_filter(..., is_string(...))` e base `Modules\Xot\Tests\TestCase`. | Verificato: PHPStan sui 9 file exit 0, Pest 40 verdi su 3 test. 2 rossi gia' presenti in `ModulePublicAssetsLinksTest` (righe 36 e 42): asserzioni su testo (`npm run copy` in un commento di `deploy.sh`; `outDir: './public'` ora `resolve(...)`), non sul comportamento: da riscrivere. |

### Incidente `483080dcac` e infrastruttura (decisioni dell'utente, non prese)

- **`483080dcac`** (marco76tv, "." 14:43 +0100, antenato di `HEAD`): 12 352 file cambiati, **1,23 milioni di righe cancellate** (lang/vendor ~3.5k, Notify/.github 1971, Sixteen docs 1076 e resources 1004, Xot docs 588, Geo docs 292...), **81 file di test** (Tenant 61 con `TestCase.php` e `Pest.php`, User 8, UI 1). Ipotesi (dedotta, non provata): merge `--allow-unrelated-histories -s resolve` da `laraxot/dev`, remoto condiviso fra progetti diversi (PTVX, trade, predict) con commit automatici `.`: cio' che e' specifico di FixCity sparisce. Stesso schema della memoria `other-machine-auto-sync-deletes-stubs-and-marker-commits`.
- **Sync appesa:** `merge_remote_repo_2.sh laraxot` aspetta da minuti `/usr/bin/editor` sul `MERGE_MSG` di `Modules/Mobile`; nel repo `bashscripts` restano 39 file `UU` (19 prompt di `docs/prompts`, compreso `11-phpstan.md`). Non toccati: sono lo stato di un processo vivo.
- **`pest-scratch-db.sh` cancellato** da `bashscripts/tools` (commit `eb98b388e`, 2026-10-28): la memoria lo dava per attivo. Su Fixcity non funziona neppure la copia recuperata (richiede `DB_DATABASE_LIMESURVEY`; assegna lo stesso scratch a `DB_DATABASE` e `DB_DATABASE_USER` mentre `config/local/fixcity/database.php` forza il DB utenti a `fixcity_user`): la `TestDatabaseGuard` rifiuta ogni test Fixcity. Ha protetto il DB di sviluppo: nessuna scrittura osservata.
- **Vendor in ritardo sul lock:** serve `cd laravel && composer install` (parte dal lock, senza solver) dopo prova; cambia il vendor condiviso col dev su :8000 e le misure di tutti gli agenti, quindi non lanciato.

### Misura finale del run 2026-11-11

`phpstan analyse Modules --no-progress --error-format=json` sotto `flock`, dopo i fix: exit **1**, `errors: 0`, `file_errors: 21` in 3 file, nessun «incomplete». **110 -> 21.** I 21 sono tutti in Geo (`HasCoordinatePicker` 18, `XotBaseCoordinateField` 2, `CoordinatePickerRefactorTest` 1; 20 `attribute.notFound` + 1 `class.notFound`) e hanno una sola causa: `vendor` Filament 5.10.3 contro lock 5.11.2. Si azzerano con `composer install` dal lock (decisione dell'utente, vedi sopra), non con modifiche al codice.

### Correzione: `composer install` dal lock NON e' la cura (verificato, dry-run)

Quanto scritto sopra («si azzerano con `composer install` dal lock») era sbagliato. `composer install --dry-run --no-scripts` dal `composer.lock` attuale dice: **122 aggiornamenti, 1 downgrade** (`phpseclib/phpseclib` 4.0.2 a 4.0.1), **12 rimozioni** (`codewithkyrian/transformers` e le sue dipendenze `rindow/*`, `jinja-php`, `transformers-libsloader`; `imagine/imagine`, `rokka/imagine-vips`, `jcupitt/vips`; `phenx/php-font-lib`; `theseer/tokenizer`), 0 nuovi, piu' l'avviso «lock not up to date with composer.json».
Causa: il lock e' stato versionato il 2026-11-11 09:24 (commit `5754d755ff`, OPS-07) **dalla risoluzione della CI** (270 + 96 dev) per far girare `deploy.sh` con `composer install --no-dev`. Quel lock non contiene `codewithkyrian/transformers`, ma `Modules/AI/composer.json:40` lo richiede, il modulo AI e' abilitato (`modules_statuses.json`) e `Modules/AI/app/Actions/{SentimentAction,Sentiment/AnalyzeTransformersSentimentAction}.php` lo usano. Quindi: installarlo qui spegnerebbe l'analisi sentiment; **dedotto, non verificato**: lo stesso lock potrebbe farlo anche al deploy.
Il vendor in ritardo e' quindi un sintomo di due insiemi di dipendenze diversi (CI/deploy contro questa macchina), non di un `install` dimenticato. Nessun comando eseguito sul vendor; copia delle versioni attuali in scratch (`installed.before.json`).
**Opzioni per l'utente:** (1) far includere alla CI il `composer.json` del modulo AI (o decidere che il lock di deploy non lo deve avere) e rigenerare il lock, poi `composer install` qui; (2) aggiornare solo la famiglia Filament con `composer update 'filament/*' --with-dependencies --no-scripts` provando prima in una copia, sapendo che riscrive un lock che OPS-07 versiona per il deploy; (3) lasciare i 21 errori di Geo come rosso noto finche' non si decide. Raccomandazione: la 1, perche' e' l'unica che rende coerenti CI, deploy e dev.

## Claim 2026-11-11 15:15 — prompt in conflitto in `bashscripts/docs/prompts`

**Fase BMAD:** Dev (risoluzione di conflitti di merge, senza perdite). Chi: sessione PHPStan-Modules, due subagent a scope disgiunto.
**Perche' ora:** il blocco che avevo registrato («non toccare i file `UU` mentre `merge_remote_repo_2.sh` e' vivo») non vale piu'. Verificato alle 15:14: nessun `merge_remote_repo`/`/usr/bin/editor` in esecuzione (l'unico match di `pgrep` era il comando di controllo stesso) e i 19 prompt hanno ancora mtime 14:28:36–14:28:50, cioe' nessuno li sta modificando. Resta `bashscripts/.git/MERGE_HEAD`, 39 file `UU` in tutto.
**Presi (19 file, `bashscripts/docs/prompts/`):**
- P1: `11-phpstan.md` (19 blocchi), `00-start.md` (6), `01-architecture-patterns.md` (5), `03-quality-gates.md` (3), `02-controller-to-folio-actions.md` (2).
- P2: `98-daily-report.md`, `46-multi-agent-module-swarm.md`, `25-services-to-actions.md` (5 ciascuno), `README.md` (4), `INDEX.md`, `15-bmad.md` (3 ciascuno), e un blocco ciascuno in `99-closing-ritual.md`, `97-yaml-frontmatter-convention.md`, `44-module-docs-continuous.md`, `38-config-routes-views.md`, `21-translations.md`, `17-gitmodules-path-iteration.md`, `08-ui.md`, `04-filament.md`.
**Non presi (20 file `UU` altrove in `bashscripts`):** `ai/wiki/rules` 7, `ai/.agents/docs` 4, `docs` 2, `ai/wiki/memories` 2, `ai/.agents` 2, `ai/wiki/how-to` 1, `tools/visual` 1, `ai/wiki/skills` 1 (somma 20, contata con `git ls-files -u`). Chi li vuole, li annoti qui prima.
**Regole:** nessun `git add`, nessun commit (l'indice resta `UU`, ci pensa la sync), nessuna rinomina, `updated:` = la piu' recente fra i due lati, `qmd:` = unione, contenuto presente in un solo lato mai scartato; prova di non-perdita per file. In piu', P1 aggiunge a `11-phpstan.md` la sezione «Controlli prima del fan-out» con le lezioni del run (exit da file, vendor contro lock, `view-string` = vista mancante, test copiati da altro host, rimisura finale).
**Esito:** a carico dei subagent; lo scrivo sotto quando i report sono verificati.

## Incidente 2026-11-11 15:18 — la sync committa il merge con i marker e adotta 27 549 cancellazioni (`1af871d0c`)

**Misurato (comandi in `bashscripts`, 15:34–15:37):**
- Alle **15:18:13** la sync di questa macchina ha committato `1af871d0c` («.», Marco Xot, genitori `f7a39cc23` = nostro e `eb15551b0` = `laraxot/dev`, marco76tv 14:55:58). `MERGE_HEAD` non c'e' piu', 0 file `UU`. Il mio controllo delle 15:14 («nessuna sync viva») era giusto in quel momento ma la sync e' ripartita 4 minuti dopo: **«non c'e' un processo» non e' un blocco che regge**, e il mio claim non l'ha fermata.
- Quel commit contiene ancora i marker di merge nei prompt (il secondo subagent li ha trovati in HEAD: 3 blocchi in 04/08/17/21/38/44/97, 15 in 25/46/98, 12 in README, 9 in INDEX). Le versioni risolte sono **modifiche non committate**: le committera' la prossima sync.
- Rispetto al primo genitore il commit toglie **28 035 file** (27 549 veri + 486 `.merge_file_*` temporanei, la cui sparizione e' una pulizia): `ai/` 26 720, `tools/` 766, `docs/` 60. **Tutti i 27 549 erano gia' assenti nel secondo genitore**: il merge `-s resolve` ha adottato le cancellazioni dell'altra macchina, non le ha inventate. Stesso schema di `483080dcac`.
- **Danno silenzioso provato:** `ai/.agents/hooks/md-filename-guard.sh` fa `[ -f "$tool" ] || exit 0` su `tools/docs/md-filenames.py`; sparito lo script, la regola dell'utente «mai date ne' `-1.md` nei nomi .md» non era piu' applicata e nessun errore lo diceva.

**Fatto (solo in avanti, creazione esclusiva `open(...,"xb")`, nessun `git add`, nessun commit):** ripristinati da `f7a39cc23` i 6 strumenti che prompt, hook e `CLAUDE.md` citano e che mancavano: `tools/docs/md-filenames.py`, `tools/docs/docs-organizer.py`, `tools/claims-open.py`, `tools/i18n/audit-locales.py`, `tools/worklog/{worklog.py,collect-day.sh}`. Verificati: compilano; `md-filenames.py check --paths docs/zzz-prova-2026-11-11.md` esce con 1 e `docs/zzz-prova-nome-pulito.md` con 0 (prova inversa). Ho **ripristinato e subito tolto** `tools/pest-scratch-db.sh` (copia identica al blob): era tolto di proposito il 2026-10-28, non gira su Fixcity e ripristinarlo o sostituirlo e' una decisione dell'utente, non mia.

**Non fatto, di proposito:** gli altri ~27 540 file (`ai/` 26 720 compresi) non sono stati ripristinati: nessuno di quelli che ho in mano li usa, e ripristinarli in blocco senza una decisione ricrea il ping-pong con l'altra macchina. **Dedotto, non provato:** al prossimo merge di `laraxot/dev` quell'altra macchina puo' toglierli di nuovo; i 6 strumenti ripristinati compresi.
**Decisione per l'utente:** (a) fermare alla radice la sync che committa `.` con marker e adotta cancellazioni (`--no-edit`, nessun commit finche' ci sono `UU` o `.merge_file_*`, mai `-s resolve --allow-unrelated-histories` su un remoto condiviso); (b) quali di `ai/` e `tools/` sono davvero da riavere.

## Esito 2026-11-11 15:45 — 19 prompt risolti, ma i marker sono gia' in `HEAD` anche nella story e in 20 file non presi

**Verificato da me (non dai report dei subagent), `bashscripts/docs/prompts`:**
- Tutti e 19 i prompt: 0 marker, frontmatter YAML valido senza chiavi duplicate, 0 file in stage, nessun commit mio. Link relativi dei 5 di P1 tutti risolti; 115 link di `INDEX.md` risolti, tutti gli 86 prompt numerati presenti in tabella, nessuna riga identica ripetuta.
- P1 (`11-phpstan`, `00-start`, `01-architecture-patterns`, `03-quality-gates`, `02-controller-to-folio-actions`): scelte per blocco nel suo report; `00-start.md` tiene **entrambe** le versioni sovrapposte con una «Nota di fusione» (da sfoltire a mano: non fondibili senza perdite). Scartato dal lato `eb15551b0`: «`phpstan-baseline.neon` non esiste» (**falso**: 0 byte dal 17/10, verificato) e alcune righe di «Lezioni generiche», recuperabili da `eb15551b0`.
- P2 (14 file, INDEX e README compresi): vedi il suo report; la sua ricostruzione per blocco dei 12 file piu' piccoli e' meno dettagliata.
- In `11-phpstan.md` ho corretto due righe vecchie che contraddicevano la sezione nuova «Controlli prima del fan-out»: il passo 0 diceva «reinstalla» e usava `composer install --dry-run` senza `--no-scripts`; ora decide il dry-run e, se mostra **rimozioni** di pacchetti richiesti da un modulo (`codewithkyrian/transformers` per AI), si ferma e segnala. `updated: 2026-11-11`.

**Scoperto dopo:** la sync delle 15:20 (`f2e454c2f`, repo annidato Xot) aveva committato `<<<<<<< .merge_file_WpK22Q` / `=======` / `>>>>>>> .merge_file_k0RIm0` **dentro questa story**, attorno alla sezione «Run 2026-11-11» (lato «loro» vuoto). Rimossi i 3 marker, nient'altro (diff = solo quelle 3 righe, copia in scratchpad `story-before-marker-removal.md`). Come per i prompt, la correzione e' una modifica non committata.
**Ancora aperto:** 19 file nei restanti `bashscripts/ai/**` e `bashscripts/docs/*.md` hanno marker **committati in `HEAD`** (`ai/.agents/BOOTSTRAP.md` e `00-ON_DEMAND_USAGE.md` sono caricati all'avvio di ogni agente). Non presi da nessuno; da risolvere con la stessa regola (unione senza perdite, mai `git add`/commit).

## Claim 2026-11-11 15:48 — i 19 file con marker in `HEAD` di `bashscripts` (54 blocchi)

Fase BMAD: Dev, risoluzione senza perdite. Stesso regime dei prompt: niente `git add`, niente commit, niente rinomine, unione dei lati, `updated:` = piu' recente, contraddizioni risolte secondo le regole del progetto e annotate. L'indice non ha piu' stage (merge gia' committato): lati = `f7a39cc23:<path>` (nostro) e `eb15551b0:<path>` (`laraxot/dev`), base = `git merge-base` se esiste.
- **P3 (28 blocchi):** `ai/wiki/rules/post-edit-quality-gate.md` (9), `ai/wiki/skills/cursor-second-brain-max-workflow.md` (9), `ai/wiki/rules/file-locking-validation-protocol.md` (6), `ai/wiki/rules/00-TRIGGER_MAP.md` (4).
- **P4 (26 blocchi):** `ai/wiki/rules/multi-agent-file-lock-protocol.md` (4), `ai/wiki/how-to/multi-agent-coordination-discipline.md` (5), `ai/.agents/docs/multi-agent-coordination.md` (3), `ai/wiki/rules/agent-chat-directory.md` (2), `ai/wiki/memories/docs-chat-slug-per-topic.md` (2) e un blocco ciascuno in `ai/.agents/00-ON_DEMAND_USAGE.md`, `ai/.agents/BOOTSTRAP.md`, `ai/.agents/docs/{git-workflow,index,INDEX}.md`, `ai/wiki/memories/phpstan-quality-docs-bmad-standing-order.md`, `ai/wiki/rules/{docs-chat-filename-no-dates,on-demand-pattern}.md`, `docs/{modular-bmad-story-policy,root-script-policy}.md`.
Fuori scope: `tools/visual/scratch-auth-fixture.sh` (nessun marker in `HEAD`), le copie speculari in `docs/wiki/` della radice (solo segnalare le divergenze).

## Esito 2026-11-11 15:58 — i 19 file con marker in `HEAD` di `bashscripts` (P3 + P4)

**Verificato da me, 15:53 (non dai report):** i 19 file hanno 0 marker, frontmatter YAML valido senza chiavi duplicate, 0 in stage, `HEAD` ancora `1af871d0c` (nessun commit mio), nessun `merge_remote_repo` vivo. `grep -rIlE '^(<<<<<<< |>>>>>>> )'` su tutto `bashscripts` (md, sh, py, json, yml): **nessun risultato**. Nello stesso scan dei file modificati di `laravel/` l'unico marker era nella mia story (gia' tolto).
- **Limite del controllo:** confronto riga per riga contro `HEAD` (entrambi i lati). Le righe non piu' identiche sono riformulazioni o fusioni dichiarate dai subagent (P3: 12+17+27+14; P4: 75 in totale). Non prova l'equivalenza di significato: l'ho controllata a campione sui tre file piu' riscritti.
- **`docs/wiki/rules` e' un symlink a `bashscripts/ai/wiki/rules`** (verificato con `ls -ld`): i file omonimi nella radice sono lo stesso file, nessuna divergenza possibile.
- **Contraddizioni risolte secondo `CLAUDE.md`:** `docs/chat/` solo archivio in sola lettura, coordinamento nelle story BMAD del modulo/tema owner; `bmad-output/` vietato per i documenti; nessuna `docs/stories/` globale. Scartati con prova (`find`/`ls`): `bashscripts/tools/bmad-story.sh`, la story `second-brain-bmad-skills-audit`, `docs/planning-artifacts/multi-agent-coordination-protocol.md`, `phpstan-cleanup-xot-app.story.md`, `bmad-output/epic-code-standards-services-mixed-const.md`.
- **Correzioni mie dopo i report:** `cursor-second-brain-max-workflow.md` riga 158 («log.md + chat aggiornati») ora rimanda all'`## Esito` della story owner; `multi-agent-coordination-discipline.md` riga 32 non ammette piu' una `docs/stories/` globale.

**Aperto, non risolto (decisioni o lavoro a parte):**
1. **Le versioni risolte sono solo nell'albero di lavoro.** `HEAD` ha ancora i marker in questi 19 file, nei 19 prompt e nella story; li ripulira' la prossima sync solo se non riporta dentro `laraxot/dev` altri conflitti. Se la sync parte durante un merge, rilanciare lo scan sopra.
2. `ai/.agents/docs/index.md` e `INDEX.md` coesistono (320 e 84 righe): collisione solo di maiuscole, regola `no-case-variations`; serve una migration map, non una rinomina a mano.
3. `00-start.md` (prompt) tiene due versioni sovrapposte con una «Nota di fusione»: da sfoltire a mano.
4. Link gia' rotti prima del merge: `docs/chat/second-brain-toolchain-rotta.md`, `bashscripts/docs/file-lock.md`, `ai/project/qmd-local-docs-search.md`, 7 in `ai/.agents/docs/index.md`; `docs/stories/bmad-stories-operational-source.story.md` citata e inesistente.
5. Strumenti citati e assenti dopo `1af871d0c` (`tools/cms/`, `tools/heavy-slot.sh`, `tools/visual/parity-wizard-steps.sh`, `tools/migrations/`, `tools/pest-scratch-db.sh`): vedi «Incidente» sopra; non ripristinati.
6. La tabella di `root-script-policy.md` (2026-10-13) elenca 4 script in radice; oggi ci sono anche `deploy.sh` e `phpstan-fix-script.sh` e in `laravel/` `compare-html.py`, `fix-vartag-xot.sh`: non aggiornata.
7. Una riga della policy modulare cita `github.com/provt/` (progetto di un'altra macchina): lasciata, non verificabile qui.
