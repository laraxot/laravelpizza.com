---
title: "bugfix larastan tenant model collision"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "bugfix larastan tenant model collision"
issues: []
discussions: []
---

# Bugfix: PHPStan `assign.propertyType` — TenantFactory duplicata confonde il tipo Tenant

## 🐛 Errore

**Data:** 2026-07-17
**Comando:** `./vendor/bin/phpstan analyse Modules` (root, `laravel/phpstan.neon`, invariata)

**File:** `Modules/Tenant/tests/Integration/Traits/SushiToJsonTraitIntegrationTest.php:23,325`

```
Property Modules\Tenant\Tests\TestCase::$tenant (Modules\Tenant\Models\Tenant|null)
does not accept Modules\User\Models\Tenant.
```

### Causa

Esistono **due classi factory distinte** con lo stesso nome breve `TenantFactory`,
per due modelli "Tenant" diversi:

- `Modules\Tenant\Database\Factories\TenantFactory` → `@extends Factory<Modules\Tenant\Models\Tenant>`
- `Modules\User\Database\Factories\TenantFactory` → `@extends Factory<Modules\User\Models\Tenant>`

Il test importa esplicitamente `use Modules\Tenant\Database\Factories\TenantFactory;`
(quindi a runtime `TenantFactory::new()->createOne()` usa correttamente la factory
del modulo Tenant), ma **Larastan risolve il generic della factory per nome breve
di classe**, e con due `TenantFactory` + due modelli con lo stesso basename `Tenant`
nello scope analizzato, l'inferenza statica sceglie il modello sbagliato
(`Modules\User\Models\Tenant`) nonostante l'import corretto — un falso positivo
del tool, non un bug del codice.

### Fix

Asserzione runtime esplicita con `PHPUnit\Framework\Assert::assertInstanceOf()`
(già importato nel file) prima dell'assegnazione, che PHPStan riconosce come
narrowing legittimo (non un `@var` che sovrascrive silenziosamente l'inferenza):

```php
$createdTenant = TenantFactory::new()->createOne([...]);
Assert::assertInstanceOf(Tenant::class, $createdTenant);
$this->tenant = $createdTenant;
```

**Nota**: un tentativo precedente aveva usato `/** @var Tenant $createdTenant */`
per silenziare l'errore — pattern esplicitamente vietato (sovrascrive
l'inferenza di PHPStan invece di dimostrarla a runtime). Sostituito con
un'asserzione reale.

## ✅ Verifica

```bash
cd laravel
./vendor/bin/phpstan clear-result-cache
./vendor/bin/phpstan analyse Modules/Tenant --memory-limit=-1   # 0 errori (solo baseline noise)
```

## Non è duplicazione da eliminare — sono due concetti di dominio distinti

- `Modules\Tenant\Models\Tenant extends BaseModel` — concetto di dominio SaaS
  (tenant/cliente), usato da questo modulo.
- `Modules\User\Models\Tenant extends BaseTenant` — tenant per la
  multi-tenancy Filament/team, modulo diverso.

Non serve rinominare o consolidare le classi: entrambe sono usate
deliberatamente per concetti diversi. Se in futuro Larastan segnala di nuovo
`assign.propertyType` con `Modules\User\Models\Tenant` altrove (altri test che
usano `TenantFactory::new()->createOne()`/`make()`), applicare lo stesso
narrowing esplicito con `Assert::assertInstanceOf()` nel punto di assegnazione
ambiguo — mai `@var` per silenziare.

## Riferimenti

- Regola correlata: `docs/wiki/rules/module-git-sync-after-fix.md` (root del progetto)
