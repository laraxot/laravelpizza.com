---
title: "Xot recursive relationships vendor direct"
type: rule
tags: [xot, recursive-relationships, adjacency-list, phpstan, laraxot]
module: Xot
created: 2026-06-11
updated: 2026-06-11
qmd: "xot recursive relationships vendor HasRecursiveRelationships contract PHPDoc typed wrapper removed"
story: STORY-346
issues:
  - "https://github.com/laraxot/module_xot_fila5/issues/39"
discussions:
  - "https://github.com/laraxot/module_xot_fila5/discussions/40"
related:
  - recursive-relationships-contract.md
  - contracts/has-recursive-relationships-contract.md
---

# Xot recursive relationships vendor direct

## Regola

`TypedHasRecursiveRelationships.php` non esiste piu e non va reintrodotto.

I modelli ad albero devono usare direttamente:

```php
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Menu extends BaseModel implements HasRecursiveRelationshipsContract
{
    use HasRecursiveRelationships;
}
```

## Contratto

`Modules\Xot\Contracts\HasRecursiveRelationshipsContract` resta il contratto di dominio per gli Action e per i type hint applicativi.

Le firme runtime seguono il trait vendor. I tipi precisi delle relazioni restano in PHPDoc sul contratto, cosi PHPStan e gli agenti hanno contesto senza forzare un wrapper Laraxot.

## Perche

- DRY: non copiare metodi vendor in un trait locale.
- KISS: una sola implementazione runtime, quella upstream.
- Manutenibilita: meno drift quando `staudenmeir/laravel-adjacency-list` cambia firma.
- Coordinamento agenti: cercare `TypedHasRecursiveRelationships` indica documentazione storica o codice da rimuovere.

## Verifica

```bash
rg -n -F "TypedHasRecursiveRelationships" Modules/*/app Modules/*/tests
php -l Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php
```
