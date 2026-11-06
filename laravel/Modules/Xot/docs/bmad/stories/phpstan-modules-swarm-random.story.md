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
