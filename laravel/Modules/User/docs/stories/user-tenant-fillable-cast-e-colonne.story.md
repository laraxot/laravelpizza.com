---
title: "Tenant User: fillable, cast e colonne allineati alla migration"
type: story
status: ready-for-dev
priority: P1
created: 2026-10-20
updated: 2026-10-20
module: User
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on: []
related: ["../../../Tenant/docs/stories/tenant-modello-cast-e-colonne-inesistenti.story.md (scritta da un'altra sessione, assente al 2026-10-20 13:50 UTC)", "14.2.team-vs-tenant-boundary-doc.story.md", "xotbaseresourcetable-model-audit-user-module-batch.story.md", "11.5-guard-privileged-fields-createuserdata.story.md", "user-test-senza-refresh-database.story.md"]
tags: [bmad, tenant, model, cast, fillable, migration]
---

# Tenant User: fillable, cast e colonne allineati alla migration

Fase BMAD: Dev (verifica dei fatti fatta, pronta per l'implementazione senza DB).

## Richiesta

Come maintainer del modulo User voglio che `Modules\User\Models\Tenant` dichiari `$fillable`, `casts()` e `@property` coerenti con le colonne che la migration crea davvero, cosi' che form, tabelle e test leggano e scrivano `domain`, `is_active`, `trial_ends_at` e `settings` con il tipo giusto.

Oggi il model non casta nulla: `is_active` torna come intero, `trial_ends_at` come stringa e `settings` come JSON grezzo. I test lo aggirano a mano.

## Scopo

La tabella `tenants` (connessione `user`) descrive i clienti multi-tenant: nome, slug, dominio, database dedicato, attivo si/no, fine prova e impostazioni. Chi la usa sono la `TenantResource` di Filament e chi legge le impostazioni del tenant. Il model deve essere l'unico posto dove il tipo di ogni colonna e' dichiarato.

## Stato misurato

Misure del 2026-10-20 tra le 13:44 e le 13:48 UTC, dalla cartella `laravel`.

- Fonte di verita' delle colonne: tre migration dichiarano la stessa tabella con helper idempotenti (`tableCreate` crea solo se manca, `tableUpdate` aggiunge solo cio' che manca). `2023_01_01_000008_create_tenants_table.php` crea id, name, slug, domain, database, is_active e (in `Schema::hasColumn`) email_address, phone, mobile, address, primary_color, secondary_color. `2026_01_01_000001_create_tenants_table.php` aggiunge `trial_ends_at` (dateTime) e `settings` (json) e le colonne di soft delete. `2026_09_01_150110_create_tenants_table.php` e' il consolidamento e contiene l'unione di tutto. Lo schema reale e' quindi l'unione. Schema vivo del DB: non verificato (nessun accesso al DB).
- `BaseTenant.php:46-56`: `$fillable` = id, name, slug, email_address, phone, mobile, address, primary_color, secondary_color. Nessun `casts()` (`rg -n -P -e 'function casts' Modules/User/app/Models/BaseTenant.php` non stampa nulla; controprova: lo stesso comando su `BaseModel.php` stampa la riga 18).
- `Tenant.php:82` e' `class Tenant extends BaseTenant {}`; docblock: `@property int $is_active` (riga 37), `@property string|null $settings` (62), `@property string|null $trial_ends_at` (76).
- Colonne senza `$fillable`: domain, database, is_active, trial_ends_at, settings. Il solo scrittore reale e' `TenantResource/Schemas/TenantForm.php:48` (`TextInput::make('domain')`, obbligatorio in creazione): per Eloquent verrebbe scartato in silenzio. Atteso dal codice, non provato (nessun test lanciato).
- Lettori: `TenantsTable.php:28-30` (`domain`, `is_active` come `IconColumn->boolean()`, `trial_ends_at` come `dateTime()`) e `TenantInfolist.php:32-35`. Nessun altro codice legge `$tenant->settings|is_active|trial_ends_at|domain|database`: `rg -n -P -e '(?i)tenant\w*(?:\(\))?->(settings|is_active|trial_ends_at|domain|database)\b' Modules/*/app app --glob '*.php'` e `git grep -n -i -E 'tenant[a-z_]*(\(\))?->(settings|is_active|trial_ends_at|domain|database)\b' -- 'Modules/*/app/*' app` danno 0 entrambi; controprova: lo stesso pattern con `(name|slug|id)` trova 1 file.
- Modello efficace nei siti: `config/**/xra.php` imposta `tenant_class => Customer::class` in 7 file; il default del codice e' `Modules\User\Models\Tenant` (`XotData.php:71`). `TenantResource::getModel()` (righe 27-31) restituisce `XotData::getTenantClass()`: sui siti configurati la Resource lavora su `Modules\Quaeris\Models\Customer` (tabella `customers`). `Customer extends BaseTenant` (`Customer.php:66`) ma ridefinisce `$fillable` (riga 78: id, email, mobile_phone, name, slug) e `casts()` (riga 119) senza chiamare il parent: modifiche a `BaseTenant` non lo raggiungono.
- Tenant del modulo Tenant: `last_activity_at` compare in `Modules/Tenant/app/Models/Tenant.php` righe 27 (docblock), 71 (`$fillable`), 157 (cast). Nelle migration: 0 con `rg -n -P -e 'last_activity_at' Modules/*/database/migrations database/migrations --glob '*.php'` e 0 con `git grep -n -w last_activity_at -- 'Modules/*/database/*' 'database/*'` (attenzione: senza il `/*` finale il pathspec non entra nelle cartelle e da' uno zero falso); controprova: `trial_ends_at` con gli stessi due comandi trova 4 righe. Il modulo Tenant ha solo le migration `tenant_settings`, `tenant_subscriptions`, `database_configs`: nessuna crea `tenants`. Chiamanti di `Modules\Tenant\Models\Tenant` in `Modules/*/app`, `app`, `config`, `routes`: 0 con `rg -P -e 'Modules\\Tenant\\Models\\Tenant\b'` e 0 con `git grep -n -F 'Modules\Tenant\Models\Tenant' -- 'Modules/*/app/*' 'app/*' 'config/*' 'routes/*'` (controprova: lo stesso `git grep` per `Modules\User\Models\Tenant` trova 19 righe); compaiono in 17 file tra test, factory e seeder. Usi dinamici (`ResolveTenantModelClassAction`, morph map) non esclusi. Il test `Tenant/tests/Feature/TenantBusinessLogicTest.php:414-428` scrive `last_activity_at` ma cattura `QueryException` e fa `markTestSkipped`, cioe' nasconde l'assenza.
- Test con ipotesi opposte: `tests/Unit/Models/TenantTest.php:36` passa `settings` come array e la riga 53 lo asserisce array (serve il cast), mentre le righe 237-253 scrivono `json_encode(...)` a mano perche' "il model non ha il cast" (serve l'assenza del cast).

## Lavoro

1. `Modules/User/app/Models/Tenant.php` (classe vuota alla riga 82): aggiungere `casts()` che estende il parent e dichiara `is_active => boolean`, `trial_ends_at => datetime`, `settings => array`; usare `array_merge(parent::casts(), [...])` perche' `BaseModel::casts()` (riga 18) porta uuid e le date. Perche' qui e non in `BaseTenant`: `Customer` condivide la base ma non ha queste colonne.
2. Stesso file: `$fillable` esplicito. Aggiungere `domain` (serve a `TenantForm.php:48`). `is_active` solo se la form espone un toggle. NON aggiungere `database` e meglio non `settings`/`trial_ends_at`: sono campi privilegiati (il nome del DB del tenant decide a quale database si connette) e vanno scritti da una Action con `forceFill`, come nella story 11.5.
3. Stesso file, docblock: `@property bool $is_active`, `@property array<array-key, mixed>|null $settings`, `@property Carbon|null $trial_ends_at` (`Carbon` e' gia' importato alla riga 10).
4. `tests/Unit/Models/TenantTest.php:237-253`: passare array a `settings` (nessun `json_encode`), togliere il commento obsoleto alle righe 239-240 e l'import `Safe\json_encode` (riga 13). Rischio: aggiungere il cast senza questa modifica fa codificare due volte la stringa e `whereJsonContains('settings->theme', ...)` non trova nulla. Il file e' anche nella story `user-test-senza-refresh-database.story.md`: questa viene prima.
5. Non toccare `last_activity_at`, `Customer.php`, `BaseTenant.php` ne' le tre migration (regola forward-only, il consolidamento e' un'altra story).

## Acceptance criteria

- [ ] `rg -n -P -e "'(is_active|trial_ends_at|settings)'\s*=>" Modules/User/app/Models/Tenant.php` stampa 3 righe (oggi 0).
- [ ] `rg -n -P -e "'domain'" Modules/User/app/Models/Tenant.php` trova la voce in `$fillable`; `rg -n -P -e "'database'" Modules/User/app/Models/Tenant.php` non stampa righe di `$fillable`.
- [ ] `rg -n -P -e '@property (bool \$is_active|Carbon\|null \$trial_ends_at)' Modules/User/app/Models/Tenant.php` stampa 2 righe.
- [ ] `rg -n json_encode Modules/User/tests/Unit/Models/TenantTest.php` non stampa nulla (oggi righe 13, 242, 246).
- [ ] `git -C Modules/User diff --stat -- app/Models/BaseTenant.php` e `git -C Modules/Quaeris diff --stat -- app/Models/Customer.php` vuoti (queste due prove non devono dipendere da altre sessioni: se non sono vuoti per cause altrui, annotarlo).
- [ ] `rg -c -P -e 'last_activity_at' Modules/*/database/migrations --glob '*.php'` resta senza risultati.
- [ ] PHPStan (gate condiviso) su `Tenant.php`, `TenantsTable.php`, `TenantInfolist.php`, `TenantForm.php`: exit 0.

## Verifica

1. Statica: i comandi AC sopra, piu' `php -l Modules/User/app/Models/Tenant.php` e `php -l Modules/User/tests/Unit/Models/TenantTest.php`.
2. Dinamica, solo dopo guardia e verdetto utente (vedi vincoli): `bash bashscripts/tools/pest-scratch-db.sh Modules/User/tests/Unit/Models/TenantTest.php`. Atteso: nessun errore su `settings`, `is_active` e `trial_ends_at` con `assertSame` su tipi (array, bool, `Carbon`). Controprova: ripristinando temporaneamente `json_encode` alla riga 242 il test sulle impostazioni deve fallire.
3. Schema vivo: leggere le colonne di `tenants` sulla connessione `user` dello scratch (l'unione attesa e' quella sopra) e annotare qui il risultato.

## Vincoli

- PHPStan: unica config `laravel/phpstan.neon`, la modifica solo l'utente; mai altri `.neon`, mai `-c`/`--level`, nessun baseline/ignore. Ogni invocazione passa dal gate condiviso: `cd laravel && flock -w 1500 /tmp/claude-1000/-mnt-nas07-var-www--bases-base-quaeris-fila5/aeabb365-8395-48f4-b7d4-9fbb17ad85d3/scratchpad/phpstan-gate.lock nice -n 10 ./vendor/bin/phpstan analyse <path...> --memory-limit=2G --no-progress --error-format=raw` (max ~8 file o un modulo; `analyse Modules` intero solo dopo il "run completo finito" dell'altra sessione).
- Pest e PHPUnit FERMI: il 2026-10-20 `RefreshDatabase` ha fatto `migrate:fresh` su `quaeris_data_test`. Si riprende solo quando la guardia DB e' dentro (story `laravel/Modules/Xot/docs/stories/test-database-guard.story.md`) e l'utente ha confermato che i DB `*_test` sono usa-e-getta. Fino ad allora la verifica e' PHPStan + `php -l` + lettura.
- Concorrenza: altre sessioni scrivono nello stesso repo. Prima di scrivere un file esistente: `bashscripts/lock/check.sh <f> && [ $(( $(date +%s) - $(stat -c %Y <f>) )) -gt 120 ] && bashscripts/lock/lock.sh <f>`; un solo agente PHP per modulo; niente commit, reset, checkout, stash.
- zsh non divide `$VAR` in argomenti: usa array (`A=(x y); cmd $A`) o `xargs -a`. Un pattern `rg` che inizia con `-` richiede `-e`. Un `0` va sempre controprovato (rg -P piu' un secondo metodo).
- Docs: artefatti BMAD solo in `laravel/Modules/<M>/docs/`; nomi senza date; nessun Service (`app/Services` vietata, logica in Spatie QueueableAction con `execute()`); Filament: solo basi `XotBase*`, logica nelle Actions, nessuna stringa UI hardcoded (chiavi in `lang/`).
- Specifici: nessuna nuova migration (forward-only, si modifica l'esistente in modo idempotente); nessuna colonna nuova senza chiedere (regola schema del progetto); `database` e `is_active` mai mass-assignable da input di form non validato.

## Decisioni aperte

1. Quali campi in `$fillable`. Raccomandato: solo `domain` ora; `database`, `settings`, `trial_ends_at` e `is_active` via Action con `forceFill`.
2. Tenere `Modules\User\Models\Tenant` come default o ritirarlo, visto che tutti i 7 `xra.php` puntano a `Customer`. Raccomandato: tenerlo, tracciare la domanda nella story 14.2.
3. Chi consolida le tre migration `create_tenants_table` e il file `2023_01_01_000008_create_tenants_table.php.LARAXOT_CORRECT`. Raccomandato: story a parte, non toccare ora.
4. `last_activity_at`: aggiungere la colonna o togliere il campo dal model Tenant. Spetta alla story lato Tenant; qui nessuna azione.

## Come ripartire

1. `cd /mnt/nas07/var/www/_bases/base_quaeris_fila5/laravel && sed -n 1,20p Modules/User/app/Models/BaseModel.php && sed -n 76,82p Modules/User/app/Models/Tenant.php`: confermare che `casts()` e la classe vuota siano ancora quelle.
2. Applicare i passi 1-4 di "Lavoro" (lock sui due file prima di scrivere), poi `php -l` e PHPStan sui 4 file.
3. Eseguire gli AC statici e scrivere nella sezione "Stato misurato" i nuovi conteggi; lasciare la verifica dinamica segnata "in attesa della guardia".
