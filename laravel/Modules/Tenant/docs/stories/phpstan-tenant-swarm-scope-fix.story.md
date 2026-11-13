---
tags: [documentation, phpstan, swarm]
qmd: "phpstan tenant swarm scope fix"
issues: []
discussions: []
title: "PHPStan swarm — perimetro Tenant: scope, causa radice, fix"
type: story
module: Tenant
slug: phpstan-tenant-swarm-scope-fix
status: ready-for-dev
created: 2026-10-15
updated: 2026-10-15
owned_scope:
  - "laravel/Modules/Tenant/app/Models/Tenant.php"
  - "laravel/Modules/Tenant/app/Models/TenantSetting.php"
  - "laravel/Modules/Tenant/app/Models/TenantSubscription.php"
  - "laravel/Modules/Tenant/database/factories/BaseModelJsonsFactory.php"
  - "laravel/Modules/Tenant/tests/Pest.php"
  - "laravel/Modules/Tenant/tests/TestCase.php"
  - "laravel/Modules/Tenant/tests/Integration/Traits/SushiToJsonTraitIntegrationTest.php"
related:
  - "01.Tenant-phpstan-fix.story.md"
  - "tenant-mixed-type-reduction.story.md"
  - "7.2.phpstan-test-harness-contracts.story.md"
---

# PHPStan swarm — perimetro Tenant: scope, causa radice, fix

Agente swarm, scope disgiunto `laravel/Modules/Tenant/`.
Prompt: `bashscripts/docs/prompts/11-phpstan.md`, `46-multi-agent-module-swarm.md`,
`57-second-brain.md`, `15-bmad.md`.
Vincoli: mai `phpstan.neon`/baseline/ignore, mai `checkout/restore/reset` (forward-only),
test solo in `Modules/Tenant/tests/`. Nessun update QMD (lo fa il coordinatore).

## Ground truth

- `laravel/phpstan_tenant_errors.json`: 0 `errors`, 6 `file_errors` su 5 file.
- `laravel/phpstan_modules_initial.json`: 1 `phpstan.parse` FATAL in scope
  (`BaseModelJsonsFactory.php:146`, `Syntax error, unexpected EOF, expecting ')'`).
  Gli altri parse/internal-error del file iniziale sono fuori scope (Lang, Media,
  Notify, UI, config/database, TenantDomainFactory) — non toccati.

## Famiglia A — `return.type` su generics HasMany/BelongsTo (3 errori)

File: `app/Models/Tenant.php:104` (`users()`), `app/Models/TenantSetting.php:53`
(`tenant()`), `app/Models/TenantSubscription.php:75` (`tenant()`).
Messaggi: `should return HasMany|BelongsTo<...> but returns mixed`.

### Scopo ricostruito

Relazioni Eloquent tipizzate in modo che i chiamanti (`TenantModelsTest` fa
`$tenant->users()->save($user)` / `whereKey()->exists()`; le factory usano
`Tenant::factory()` per `tenant_id`) lavorino su tipi veri senza propagare `mixed`.

### Chiamanti e migrazioni (radice, non sintomo)

- `XotData::getUserClass()` restituisce `class-string<Model&UserContract>` (firma reale
  letta in `Modules/Xot/app/Datas/XotData.php`) — il `HasMany` di `Tenant::users()` e'
  dinamico per disegno, non un tipo perso per caso.
- `XotBaseModel` non fa override di `hasMany`/`belongsTo`: valgono i generics di
  `Illuminate\Database\Eloquent\Model` (`@template TRelatedModel`, `@return
  HasMany<TRelatedModel, $this>` / `BelongsTo<TRelatedModel, $this>`).
- Migrazioni `2026_07_24_000000` e `2026_07_24_000001`: `tenant_id` e' `string->nullable()`
  con solo indice (la tabella `tenants` condivisa vive nel modulo User). Quindi
  `@property-read Tenant|null $tenant` + `@return BelongsTo<Tenant, $this>` e' la
  tipizzazione onesta: relazione-oggetto non nulla, modello collegato nullable.
  Nessun `?->`/`??` da rimuovere o aggiungere in scope.

### Censimento doppio modello Tenant (canonico per contesto, non duplicato)

- `Modules\User\Models\Tenant` (via `BaseTenant`: `TenantContract`, `HasAvatar`,
  `HasMedia`, `users()`/`members()` come `BelongsToMany`, chiave stringa non
  incrementale) = registro centrale; `XotData::$tenant_class` punta qui.
- `Modules\Tenant\Models\Tenant` (via `Tenant\BaseModel`, `connection = 'tenant'`,
  `users()` come `HasMany` verso `getUserClass()`) = modello del contesto tenant.
- Regola: nei test e nel codice del modulo Tenant si usa
  `Modules\Tenant\Models\Tenant` (coerente in `TestCase`, `TenantContextSetter`,
  factory e integration test letti). Nessuna fusione: sono bounded context diversi.

### Fix (stato verificato nei file)

- `Tenant::users()`: `@return HasMany<Model&UserContract, $this>` +
  `@property-read Collection<int, Model&UserContract> $users`; il passaggio per
  `XotData::make()->getUserClass()` conserva il `class-string` fino a `hasMany()`.
  I due `@var` intermedi sono ridondanti rispetto all'inferenza ma innocui —
  **non rimossi**: senza run PHPStan eseguibile in questa sessione, semplificare
  alla cieca violerebbe "prima la verifica".
- `TenantSetting::tenant()` / `TenantSubscription::tenant()`:
  `/** @return BelongsTo<Tenant, $this> */` + `belongsTo(Tenant::class)` letterale.
  Prima/dopo: `return.type ... returns mixed` → docblock generics coerente con
  l'inferenza dal `class-string` letterale; `php -l`/PHPStan mirati da rieseguire
  (vedi Handoff).

## Famiglia B — mismatch `User\Models\Tenant` vs `Tenant\Models\Tenant` nei test (3 errori)

File: `tests/Integration/Traits/SushiToJsonTraitIntegrationTest.php:26,328`
(`TestCase::$tenant` / `$secondTenant` non accettano `User\Models\Tenant`) e
`tests/Pest.php:20` (`createTenant()` dichiara `Tenant` del modulo ma restituiva
quello di User).

### Scopo e causa radice

L'harness di modulo deve parlare il modello del proprio bounded context. La radice
era l'import/classe sbagliata (Tenant di User) nei test, non un problema di tipi
del framework.

### Fix (stato verificato nei file)

- `tests/TestCase.php`: `public static ?Tenant $tenant/$secondTenant` e
  `createTenant(): Tenant` su `Modules\Tenant\Models\Tenant`; narrowing onesto via
  `Assert::assertInstanceOf` / `WebmozartAssert::isInstanceOf` dopo `create()`, mai
  `@var` per silenziare. `tenantModel()`/`secondTenantModel()` con assert.
- `SushiToJsonTraitIntegrationTest.php`: importa `Modules\Tenant\Models\Tenant`,
  `Assert::assertInstanceOf(Tenant::class, $created)` prima di assegnare a
  `TestCase::$tenant` / `$secondTenant` (narrowing, non cast).
- `tests/Pest.php`: zero funzioni libere (regola di repo documentata nel file
  stesso); helper di dominio vive come `TestCase::createTenant()` statico.

## Famiglia C — parse FATAL `BaseModelJsonsFactory.php:146` (1 errore)

File intero letto (40 righe, sintassi integra): `declare(strict_types=1)`,
`@extends Factory<BaseModelJsons>`, `$model` come `class-string<BaseModelJsons>`,
`definition(): array<string, mixed>`. La factory e' preservata (stesso modello,
stesse chiavi `created_at/updated_at/created_by/updated_by`). Il vecchio EOF troncato
non esiste piu' nel working tree — nessun intervento necessario.

## Verifica

- Lettura statica completa dei 7 file + firme reali (`XotData`, `XotBaseModel`,
  `RelationX`, `BaseTenant`, migrazioni FK): tutti i 6+1 item del ground truth
  risultano gia' risolti nel working tree (anche i numeri di riga del JSON non
  corrispondono piu' ai file: i file sono cambiati in avanti dopo il report).
- `php -l`, `phpstan analyse Modules/Tenant`, Pest mirato **non eseguibili da questa
  sessione**: `default.bash`/Daytona richiede `DAYTONA_API_KEY` (assente), quindi
  niente shell, niente `rg` per i chiamanti oltre i file letti, niente lock script.
  Gate esecutivi affidati al coordinatore (vedi Handoff). Nessun file modificato in
  questa sessione — niente lock da rilasciare, niente commit (vietati nello swarm).

## Saltati (in scope, non toccati, motivazione)

- `tests/Support/helpers.php` (free function `tenantMockExpectation`): viola ADR-002
  (`Pest.php` vieta `tests/Support`), ma e' fuori ground truth e nessun chiamante e'
  stato censito tra i file letti (`TestCase::expectMockery()` copre il bisogno).
  Rimozione = rischio senza `rg`+Pest eseguibili. Handoff al coordinatore.
- `tests/Fixtures/Traits/*PhpstanProbe*`: fixture tipizzate legittime per i trait
  Sushi (story 7.1/7.2), non silenziatori — lasciate intatte.
- `TenantFactory` (valori faker in `array<string, mixed>`): `mixed` genuinamente
  polimorfico da framework, pattern gia' approvato nella story mixed-type-reduction.
- `@var` ridondanti in `Tenant::users()`: vedi Famiglia A.

## Handoff per il coordinatore

1. `cd laravel && ./vendor/bin/phpstan analyse Modules/Tenant --no-progress --error-format=json`
   (confronto atteso: 0 `file_errors` vs 6+1 del ground truth).
2. `./vendor/bin/pest Modules/Tenant/tests/Unit/TenantModelsTest.php --no-coverage`
   (caller diretto di `users()`; nota: `TestCase::tenantDbUnavailable()` forza skip
   su sqlite condiviso — esito atteso: skip, non fail).
3. Valutare rimozione `tests/Support/helpers.php` dopo `rg tenantMockExpectation` su
   tutti i moduli/temi e `md-filenames.py`/QMD update (non eseguiti qui per vincolo).
