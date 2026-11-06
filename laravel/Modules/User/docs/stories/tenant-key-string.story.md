---
title: "User: chiave stringa del tenant coerente fra tenants e tenant_user"
type: story
status: in-progress
priority: P1
created: 2026-11-05
updated: 2026-11-05
module: User
depends_on: []
related:
  - tenancy-pannelli
  - area-cliente-cantieri
  - tenancy-chiave-stringa-scope-qualificato.story.md
owned_scope: [app/Models/BaseTenant.php, database/migrations/2023_01_01_000003_create_tenant_user_table.php, database/migrations/2026_01_01_000002_create_tenant_user_table.php]
tags: [tenancy, tenant, migration, uuid]
qmd: "user tenant tenant_user tenant_id stringa uuid HasUuids HasSlug resolveRouteBindingQuery BaseTenant"
---

# User: chiave stringa del tenant coerente fra tenants e tenant_user

## Story

Come **sviluppatore che usa la tenancy di Filament con `Modules\User\Models\Tenant`**
voglio **che un tenant creato senza id abbia una chiave valida e che la tabella ponte la possa contenere**
così da **poter associare gli utenti ai tenant (`$user->tenants()`) e far funzionare `getTenants()` e `canAccessTenant()`**.

## Perché

- `tenants.id` è `string` (`BaseTenant`: `$incrementing = false`, `$keyType = 'string'`), ma nessuno la generava: senza un id esplicito l'insert falliva.
- `tenant_user.tenant_id` era `foreignId` (intero): un id stringa non ci stava, quindi l'appartenenza utente-tenant non si poteva salvare.

## Acceptance criteria

1. `BaseTenant` usa `HasUuids`: un tenant creato senza id riceve un UUID; un id esplicito resta com'è.
2. `tenant_user.tenant_id` è `string(36)` con indice nelle nuove installazioni.
3. Sulle installazioni esistenti con `tenant_id` intero la migrazione lo converte in `string(36)`.
4. `BaseTenant` si carica senza conflitti tra `HasUuids` e `HasSlug`; la risoluzione
   mantiene la validazione dell'UUID per chiavi univoche e il comportamento slug.
5. I test verificano il caricamento del model e i contratti di key/slug pertinenti.

## Dev agent record

- 2026-11-05 — Claude: `HasUuids` in `BaseTenant`; `tenant_id` stringa in entrambe le migrazioni di `tenant_user` con conversione in `tableUpdate` quando il tipo è intero. `php -l` ok; Pest/PHPStan da eseguire con vendor.
- 2026-11-05 — Il Pest del trait tenancy ha rilevato un fatal in fase di autoload:
  `HasSlug` e `HasUuids` dichiarano entrambi `resolveRouteBindingQuery`. La correzione
  deve mantenere la generazione slug, la validazione UUID e il route binding Filament
  configurato con `slugAttribute: 'slug'`; implementazione in corso, il file model è
  temporaneamente lockato dalla story `user-model-relationships-to-traits`.
- 2026-11-05 (sera) — Claude: chiusa la regressione lasciata dalla pulizia dei marcatori, che aveva tolto `HasUuids`
  da `BaseTenant` (AC 1 e 4 tornati aperti). Ripristinato `use HasUuids;` accanto a `use HasSlug;`.
  **Correzione della premessa:** la "collisione su `resolveRouteBindingQuery`" scritta sopra non c'è nelle versioni
  installate. `HasSlug` (spatie/laravel-sluggable 4.0.3 in vendor, 4.0.4 nel lock) definisce solo `resolveRouteBinding`;
  `resolveRouteBindingQuery` sta in `HasUniqueStringIds` (usato da `HasUuids`) e, per Spatie, solo in `HasTranslatableSlug`.
  Lo stesso vale in tutti e 9 i `vendor` dei progetti `_bases` (laravel 13.33-13.40). Il tentativo con
  `use HasSlug { HasSlug::resolveRouteBindingQuery as ... }` e il metodo ponte dava invece un fatal in autoload
  ("An alias was defined for ... but this method does not exist"), quindi alias e override sono stati tolti.
  **Se una versione futura di Spatie aggiungesse `resolveRouteBindingQuery` a `HasSlug`**, PHP andrebbe in fatal al
  caricamento della classe: la guardia e' `tests/Unit/Models/BaseTenantKeyTest.php` (primo caso), poi si torna ad
  alias + ponte come nel commit `bd6a68733`.
  Verifica: `php -l`, Pint, PHPStan su `BaseTenant`, `Tenant` e sul test: 0 errori. Caricamento della classe e UUID
  generato provati con `php -r` sul bootstrap reale (uniqueIds `["id"]`, `newUniqueId()` e' un UUID, slug da `name`).
  **Pest non parte qui** (`DB_USERNAME` vuoto in `.env.testing`: `TestCase` fallisce prima delle asserzioni, vale per
  tutti i test del modulo); da eseguire dove il DB di test e' configurato. `status` resta `in-progress` per questo motivo.
