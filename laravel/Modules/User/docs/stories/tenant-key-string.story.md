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

## Effetto collaterale su un figlio con chiave intera (trovato il 2026-11-10)

`HasUuids` in `BaseTenant` vale anche per `Modules\Quaeris\Models\Customer`, l'unico altro figlio, che
dichiara `$keyType = 'int'` e `$incrementing = true` su `customers.id` `int unsigned auto_increment`.
`HasUniqueStringIds` scavalca quelle proprieta': `uniqueIds() = ["id"]`, `getKeyType() = 'string'`,
`getIncrementing() = false` (verificato con tinker). Conseguenze:

- in inserimento Laravel (`Model::performInsert`, `setUniqueIds()`) scrive un UUID in `customers.id` e non
  legge l'id generato dal DB: "Nuovo cliente" fallisce in strict mode o, senza strict, tronca l'UUID in un
  intero (collisioni possibili);
- `whereKey($customer)` lega la chiave come stringa (`` `customers`.`id` = '10' ``): lo ha rilevato
  `Quaeris/tests/Feature/Filament/TenantSwitcherListsAllUserCustomersTest.php:52`.

Correzione proposta, in attesa di decisione: dettagli in
`laravel/Modules/Quaeris/docs/stories/quaeris-tenant-switcher-lists-all-user-customers.story.md`,
sezione "Seguito 2026-11-10".

Risolto lato Quaeris il 2026-11-10: `Customer::uniqueIds()` restituisce `[]` (estensione prevista da Laravel
per `HasUuids`), `BaseTenant` non toccata. Chi aggiunge un altro figlio di `BaseTenant` con chiave intera deve
fare lo stesso. Test: `laravel/Modules/Quaeris/tests/Unit/Models/CustomerIntegerKeyTest.php`.
