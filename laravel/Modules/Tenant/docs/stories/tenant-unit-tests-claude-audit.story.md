---
title: "Tenant: Unit Tests for claude-audit 100/100"
type: story
module: Tenant
epic: "claude-audit-perfection"
slug: tenant-unit-tests-claude-audit-100
status: ready-for-dev
priority: high
created: 2026-09-27
updated: 2026-09-27
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/XXXX"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/XXXX"
related:
  - "docs/stories/geo-unit-tests-claude-audit.story.md"
  - "docs/stories/notify-unit-tests-claude-audit.story.md"
  - "../../../docs/wiki/guidelines/claude-audit-static-free-tier.md"
---

# Tenant: Unit Tests for claude-audit 100/100

## Fase BMAD

Build + Measure. Questa story fa parte del batch per portare i moduli Geo, Notify, Tenant a 100/100 claude-audit.

## Problema

Il modulo Tenant ha score claude-audit 78-79/100 (Grade B). Il finding principale è "No tests found" nella struttura `laravel/tests/Unit/Modules/Tenant/` e `laravel/tests/Feature/Modules/Tenant/`. I test esistono in `Modules/Tenant/tests/` ma non sono rilevati da claude-audit.

## Obiettivo

Creare unit test nella struttura standard del progetto (`laravel/tests/Unit/Modules/Tenant/`) per la business logic critica del modulo Tenant, raggiungendo 100/100 claude-audit.

## Azioni

### 1. Test per Actions Configurazione Tenant

Creare test per le seguenti Actions in `laravel/tests/Unit/Modules/Tenant/Actions/Config/`:

- **GetTenantConfigArrayActionTest.php** - Caricamento array configurazione
- **GetTenantConfigNamesActionTest.php** - Lista nomi configurazioni
- **GetTenantConfigPathActionTest.php** - Path file configurazione
- **GetTenantFilePathActionTest.php** - Path file tenant-specific
- **ResolveTenantConfigValueActionTest.php** - Risoluzione valore config (merge global + tenant)
- **SaveTenantConfigActionTest.php** - Salvataggio configurazione
- **FilterConfigStringKeysActionTest.php** - Filtro chiavi stringa
- **MergeRecursiveStringKeyConfigActionTest.php** - Merge ricorsivo config

### 2. Test per Actions Modelli Tenant-Aware

Creare test in `laravel/tests/Unit/Modules/Tenant/Actions/Models/`:

- **ResolveTenantModelClassActionTest.php** - Risoluzione classe model
- **ResolveTenantModelInstanceActionTest.php** - Istanziazione model tenant-aware

### 3. Test per Actions Domini

Creare test in `laravel/tests/Unit/Modules/Tenant/Actions/Domains/`:

- **GetDomainsArrayActionTest.php** - Lista domini tenant
- **GetTenantModulesActionTest.php** - Moduli abilitati per tenant

### 4. Test per Actions Traduzioni

Creare test in `laravel/tests/Unit/Modules/Tenant/Actions/Translations/`:

- **TranslateTenantKeyActionTest.php** - Traduzione chiavi tenant-specific

### 5. Test per Actions Markdown

Creare test in `laravel/tests/Unit/Modules/Tenant/Actions/Markdown/`:

- **GetLocalizedMarkdownPathActionTest.php** - Path markdown localizzato

### 6. Test per Models

Creare test in `laravel/tests/Unit/Modules/Tenant/Models/`:

- **TenantTest.php** - Model Tenant (name, domain, settings, subscription)
- **DomainTest.php** - Model Domain (domain, tenant_id, is_primary, SSL)
- **TenantSettingTest.php** - Impostazioni tenant (key-value, JSON)
- **TenantSubscriptionTest.php** - Abbonamenti (plan, status, billing)
- **DatabaseConfigTest.php** - Config database per tenant
- **BaseModelTest.php** - Base model con trait SushiToJson/PhpArray/Csv

### 7. Test per Traits Sushi (Eloquent da array/CSV/JSON)

Creare test in `laravel/tests/Unit/Modules/Tenant/Traits/`:

- **SushiToJsonTest.php** - Trait JSON → Eloquent
- **SushiToPhpArrayTest.php** - Trait PHP Array → Eloquent
- **SushiToCsvTest.php** - Trait CSV → Eloquent
- **SushiToJsonsTest.php** - Trait multiple JSON → Eloquent

### 8. Test per Policies

Creare test in `laravel/tests/Unit/Modules/Tenant/Models/Policies/`:

- **TenantBasePolicyTest.php** - Policy base tenant
- **DomainPolicyTest.php** - Policy domini

### 9. Feature Tests

Creare test in `laravel/tests/Feature/Modules/Tenant/`:

- **TenantConfigIsolationTest.php** - Isolamento configurazione tra tenant
- **TenantDomainRoutingTest.php** - Routing per dominio
- **TenantModelResolutionTest.php** - Risoluzione modelli tenant-aware
- **MultiTenantScopeTest.php** - Scope multi-tenant (RLS, global scopes)

## Acceptance Criteria

1. ✅ Tutti i test passano: `./vendor/bin/pest laravel/tests/Unit/Modules/Tenant laravel/tests/Feature/Modules/Tenant`
2. ✅ PHPStan L10 pulito: `./vendor/bin/phpstan analyse Modules/Tenant --memory-limit=-1`
3. ✅ claude-audit score 100/100 per modulo Tenant
4. ✅ Test coverage ≥ 80% per Actions e Models critici
5. ✅ Nessun test flaky - isolamento tenant corretto

## Technical Notes

### Pattern Testing

Seguire il pattern di `laravel/tests/Unit/Modules/Chart/Actions/CreateChartActionTest.php`:
- Usa `uses(TestCase::class, RefreshDatabase::class, WithFaker::class)`
- `beforeEach` per setup action e factory
- `describe` / `it` per organizzazione
- `expect()` per assertions

### Tenant Context Testing

Il modulo Tenant richiede contesto tenant per i test:
- Usa `TenantContextSetter` da `Modules/Tenant/tests/Support/`
- Crea tenant fittizi con `Tenant::factory()` 
- Imposta contesto prima di ogni test: `$this->setTenantContext($tenant)`
- Verifica isolamento: dati tenant A non visibili a tenant B

### Sushi Testing

I trait Sushi (`SushiToJson`, `SushiToPhpArray`, `SushiToCsv`, `SushiToJsons`) convertono fonti dati non-SQL in modelli Eloquent:
- Testare `getRows()` restituisce collection corretta
- Testare schema definito correttamente (`getColumns()`)
- Testare query builder funziona (where, orderBy, limit)
- Testare relazioni e accessor/mutator
- Usare fixture in `laravel/tests/Fixtures/Tenant/`

### Config Resolution Testing

`ResolveTenantConfigValueAction` fa merge:
1. Config globale (`config('tenant.key')`)
2. Config tenant-specific (`tenant.config.key`)
3. Default se mancante
Testare precedenza e fallback.

### Multi-Tenant Database

Se il modulo usa database separati per tenant:
- Testare connection switching
- Testare migration per tenant
- Usare `DatabaseConfig` model per configurazione

### Dependencies

- Modulo Xot (TestCase base, BaseModel, Sushi traits)
- Modulo User (User factory per tenant admin)
- Laravel Config facade
- Laravel Database (per connection testing)

## Definition of Done

- [ ] Story creata e commitata
- [ ] Tutti i test Actions Config implementati
- [ ] Tutti i test Actions Models implementati
- [ ] Tutti i test Actions Domains implementati
- [ ] Tutti i test Actions Translations/Markdown implementati
- [ ] Tutti i test Models implementati
- [ ] Tutti i test Traits Sushi implementati
- [ ] Tutti i test Policies implementati
- [ ] Feature tests implementati
- [ ] Tutti i test passano
- [ ] PHPStan L10 OK
- [ ] claude-audit 100/100 verificato
- [ ] Story aggiornata con risultati

## Story Points Breakdown

- **Config Actions tests (8 actions × 3 test):** 5 punti
- **Model Actions tests (2 actions × 3 test):** 2 punti
- **Domain Actions tests (2 actions × 3 test):** 2 punti
- **Translation/Markdown Actions (2 actions × 3 test):** 1 punto
- **Models tests (6 models × 4 test):** 5 punti
- **Sushi Traits tests (4 traits × 4 test):** 4 punti
- **Policies tests (2 policies × 3 test):** 1 punto
- **Feature tests (4 areas × 3 test):** 3 punti
- **Tenant context setup + fixture creation:** 3 punti
- **Fix flaky + isolamento verification:** 2 punti
- **Verifica finale + docs:** 2 punti
- **Totale:** 30 punti

## Dev Agent Record

### Agent Model Used

Claude Sonnet 5 (kilo-auto/free)

### File List (da creare)

- `laravel/tests/Unit/Modules/Tenant/Actions/Config/GetTenantConfigArrayActionTest.php`
- `laravel/tests/Unit/Modules/Tenant/Actions/Config/GetTenantConfigNamesActionTest.php`
- `laravel/tests/Unit/Modules/Tenant/Actions/Config/GetTenantConfigPathActionTest.php`
- `laravel/tests/Unit/Modules/Tenant/Actions/Config/GetTenantFilePathActionTest.php`
- `laravel/tests/Unit/Modules/Tenant/Actions/Config/ResolveTenantConfigValueActionTest.php`
- `laravel/tests/Unit/Modules/Tenant/Actions/Config/SaveTenantConfigActionTest.php`
- `laravel/tests/Unit/Modules/Tenant/Actions/Config/FilterConfigStringKeysActionTest.php`
- `laravel/tests/Unit/Modules/Tenant/Actions/Config/MergeRecursiveStringKeyConfigActionTest.php`
- `laravel/tests/Unit/Modules/Tenant/Actions/Models/ResolveTenantModelClassActionTest.php`
- `laravel/tests/Unit/Modules/Tenant/Actions/Models/ResolveTenantModelInstanceActionTest.php`
- `laravel/tests/Unit/Modules/Tenant/Actions/Domains/GetDomainsArrayActionTest.php`
- `laravel/tests/Unit/Modules/Tenant/Actions/Modules/GetTenantModulesActionTest.php`
- `laravel/tests/Unit/Modules/Tenant/Actions/Translations/TranslateTenantKeyActionTest.php`
- `laravel/tests/Unit/Modules/Tenant/Actions/Markdown/GetLocalizedMarkdownPathActionTest.php`
- `laravel/tests/Unit/Modules/Tenant/Models/TenantTest.php`
- `laravel/tests/Unit/Modules/Tenant/Models/DomainTest.php`
- `laravel/tests/Unit/Modules/Tenant/Models/TenantSettingTest.php`
- `laravel/tests/Unit/Modules/Tenant/Models/TenantSubscriptionTest.php`
- `laravel/tests/Unit/Modules/Tenant/Models/DatabaseConfigTest.php`
- `laravel/tests/Unit/Modules/Tenant/Models/BaseModelTest.php`
- `laravel/tests/Unit/Modules/Tenant/Traits/SushiToJsonTest.php`
- `laravel/tests/Unit/Modules/Tenant/Traits/SushiToPhpArrayTest.php`
- `laravel/tests/Unit/Modules/Tenant/Traits/SushiToCsvTest.php`
- `laravel/tests/Unit/Modules/Tenant/Traits/SushiToJsonsTest.php`
- `laravel/tests/Unit/Modules/Tenant/Models/Policies/TenantBasePolicyTest.php`
- `laravel/tests/Unit/Modules/Tenant/Models/Policies/DomainPolicyTest.php`
- `laravel/tests/Feature/Modules/Tenant/TenantConfigIsolationTest.php`
- `laravel/tests/Feature/Modules/Tenant/TenantDomainRoutingTest.php`
- `laravel/tests/Feature/Modules/Tenant/TenantModelResolutionTest.php`
- `laravel/tests/Feature/Modules/Tenant/MultiTenantScopeTest.php`
- `laravel/tests/Fixtures/Tenant/*.json` (fixture per Sushi)

---

*This story was created using BMAD Method v6 - Phase 4 (Implementation Planning)*