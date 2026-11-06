---
title: "User: i dati del cliente restano nel suo tenant (chiave stringa, scope qualificato)"
type: story
status: in-progress
priority: P1
created: 2026-11-05
updated: 2026-11-05
module: User
depends_on: []
related:
  - ../tenancy.md
  - ../../../Xot/docs/stories/tenancy-pannelli.story.md
owned_scope: [app/Models/Traits/InteractsWithTenant.php, app/Models/Scopes/TenantScope.php, app/Models/Traits/HasTenants.php, tests/Unit/Models/InteractsWithTenantTest.php, docs/tenancy.md]
tags: [tenancy, filament, cliente, sicurezza]
qmd: "InteractsWithTenant TenantScope tenant_id stringa uuid scope qualificato area cliente"
---

# User: i dati del cliente restano nel suo tenant

Fase BMAD: Dev, poi Verify. Prerequisito dell'area cliente di Roosko (cantieri), che usa
`$hasTenancy` della story Xot `tenancy-pannelli`.

## Story

Come **cliente** che entra nella sua area
voglio **che ogni record che creo resti legato al mio tenant e che le liste mostrino solo i miei**
cosi' da **non vedere ne' disperdere dati di altri clienti**.

## Problema trovato

- `BaseTenant` ha chiave stringa (`tenants.id` e' `string`, `$keyType = 'string'`), ma
  `InteractsWithTenant` aveva `setTenantIdAttribute(?int $value)` e `is_int($tenantId)`:
  assegnare l'id del tenant andava in `TypeError`, e l'assegnazione automatica saltava.
  Risultato: record del cliente senza `tenant_id`, quindi fuori dal suo perimetro.
- `TenantScope` filtrava su `tenant_id` non qualificato: con una join verso un'altra tabella
  con `tenant_id` la query diventava ambigua.
- La relazione `tenant()` leggeva `config('tenant.tenant_model')`, mentre utente, pannello e
  `HasTenants` usano `XotData::getTenantClass()`: due fonti di verita'.
- Codice morto: `currentTenant`, `getTenant()`, `loadTenantFromSession()`, `applyTenantScope()`
  (nessun chiamante); in Xot `ApplyTenancyToPanelAction` (nessun chiamante, apriva la
  registrazione dei tenant ai clienti e usava `tenants` come relazione di ownership).

## Acceptance criteria

1. Con un tenant corrente a chiave stringa, un modello con `InteractsWithTenant` riceve
   `tenant_id` in creazione; un `tenant_id` esplicito non viene sovrascritto.
2. `TenantScope` filtra su `tabella.tenant_id`; senza tenant corrente non filtra (pannelli di gestione).
3. `tenant()` punta a `XotData::getTenantClass()`.
4. Test Pest in `tests/Unit/Models/InteractsWithTenantTest.php` (gruppo `no-user-db`).
5. Guida in `docs/tenancy.md`.
6. Il fixture Pest ha un tipo concreto, così PHPStan verifica `tenant()` sul
   contratto Eloquent fornito dal trait e non su `Model` generico.

## Dev agent record

- 2026-11-05 — Claude: implementati i punti 1-5, rimossa `ApplyTenancyToPanelAction` in Xot e
  aggiornati i due docs che la citavano. `php -l` ok sui file toccati. **Da verificare
  nell'installazione con vendor (PHP 8.4)**: `pest Modules/User/tests/Unit/Models/InteractsWithTenantTest.php`
  e PHPStan livello max.
- 2026-11-05 — Follow-up PHPStan: il fixture helper restituiva `Model`, nascondendo
  la relazione `tenant()` fornita dal trait. Ora restituisce il fixture concreto;
  nessuna modifica al modello o al comportamento runtime.
- Verifica: PHPStan sul file di test passa. Pest non riesce ancora a caricare
  `BaseTenant`: i trait `HasSlug` e `HasUuids` dichiarano entrambi
  `resolveRouteBindingQuery`; finding registrato nella story
  `tenant-key-string.story.md` prima di chiudere il gate Pest.

## Seguiti proposti

- Impersonate del cliente dal pannello di gestione (idea da tomatophp/filament-tenancy).
- Nel pannello cliente: `scopedUnique()`/`scopedExists()` sui campi univoci, policy sui modelli.
