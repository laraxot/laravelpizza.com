---
title: "PHPStan BelongsToMany covarianza — HasTeams / UserContract"
type: memory
module: User
created: 2026-07-06
updated: 2026-07-06
tags: [phpstan, belongstomany, generics, covariance, hasteams, usercontract]
qmd: "phpstan belongstomany covariance this declaringmodel hasteams membershipteams usercontract return type mismatch"
---

# PHPStan: BelongsToMany covarianza — HasTeams / UserContract

## Problema

`HasTeams::teams()` (aliasato come `membershipTeams()` in `BaseUser`) chiama
`$this->belongsToManyX($teamClass)` che ha `@return BelongsToMany<TRelated, $this, Pivot>`.

Il parametro `TDeclaringModel` di `BelongsToMany` **non è covariante** — PHPStan
non accetta `$this(BaseUser)` quando il contratto dichiara `Model` come owner.

**Errore PHPStan:**
```
Method BaseUser::membershipTeams() should return
  BelongsToMany<Model&TeamContract, Model, Pivot, 'pivot'>
but returns
  BelongsToMany<Model&TeamContract, $this(BaseUser), Pivot, 'pivot'>
```

## Soluzione applicata

In `Modules/User/app/Models/Traits/HasTeams.php`:

```php
/** @var BelongsToMany<Model&TeamContract, Model, Pivot, 'pivot'> $relation */
$relation = $this->belongsToManyX($teamClass);

/** @phpstan-ignore return.type */
return $relation;
```

Note:
- Il `/** @var ... $relation */` (doppio asterisco) forza il tipo della variabile
- Il `/** @phpstan-ignore return.type */` sopprime il mismatch residuo sulla return
- Il `/* @var ... */` (singolo asterisco) è IGNORATO da PHPStan — non usarlo

## Contratto UserContract

In `Modules/Xot/app/Contracts/UserContract.php`:

```php
/**
 * @return BelongsToMany<Model&TeamContract, Model, \Illuminate\Database\Eloquent\Relations\Pivot, 'pivot'>
 */
public function membershipTeams(): BelongsToMany;
```

`TeamContract` è già importato. `Pivot` si usa con FQCN perché non è importato nel file.

## MockUserWithTeams — test fixtures

`Modules/User/tests/Unit/Models/Traits/MockUserWithTeams.php` e
`Modules/User/tests/Unit/Models/Traits/Fixtures/MockUserWithTeams.php`
estendono `Model` e usano `HasTeams`, ma `HasTeams::teams()` chiama
`$this->belongsToManyX()` che è definito in `RelationX` trait.

**Fix:** Aggiungere `use Modules\Xot\Models\Traits\RelationX;` alle fixture.
