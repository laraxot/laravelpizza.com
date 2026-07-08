---
title: connessione database progressione
module: Progressioni
type: rule
status: approved
tags: [database, connection, basemodel, cross-module, ptv]
updated: "2026-06-15"
related:
  - ./wiki/rules/contract-aggregation-pattern.md
  - ../Ptv/docs/wiki/concepts/scheda-contract-inheritance.md
  - ../Activity/docs/basemodel-connection-why-activity-not-null.md
  - ../Xot/docs/install/database.md
  - ../../../../docs/patterns/database.md
  - ../../../../docs/development/testing.md
  - ../../../Themes/One/docs/common-errors.md
---

# Connessione database `progressione`

## Scopo

Il modulo Progressioni persiste su database dedicato (`progressione`), registrato a runtime da `TenantServiceProvider`. Ogni modello Eloquent del modulo deve usare quella connessione, non quella default (`mysql`) né quella del modulo padre Ptv (`ptv`).

## Regola base

```php
// Modules/Progressioni/Models/BaseModel.php
protected $connection = 'progressione';
```

**Mai** `protected $connection = null`: fa cadere il modello sulla connessione default e rompe coerenza, test con `DatabaseTransactions` e override `.env` (`DB_DATABASE_PROGRESSIONE`).

Pattern analogo: [basemodel-connection-why-activity-not-null](../Activity/docs/basemodel-connection-why-activity-not-null.md).

## Eccezione: ereditarietà da Ptv

`Scheda`, `Valutatore` e `StabiDirigente` **estendono** modelli Ptv (`BaseScheda`, `PtvValutatore`, `PtvStabiDirigente`). La catena Ptv porta `protected $connection = 'ptv'` su `Ptv\Models\BaseModel`.

Il consumer Progressioni **deve** ridefinire esplicitamente:

```php
class Scheda extends BaseScheda
{
    protected $connection = 'progressione';
}
```

Stesso pattern per:

| Modello Progressioni | Estende (Ptv) | Connessione |
| :--- | :--- | :--- |
| `Scheda` | `BaseScheda` | `progressione` |
| `Valutatore` | `PtvValutatore` | `progressione` |
| `StabiDirigente` | `PtvStabiDirigente` | `progressione` |

Modelli che estendono solo `Progressioni\Models\BaseModel` ereditano già `progressione` (es. `CriteriEsclusione`, `SchedaCriteri`, `MyLog`).

## Perché (business)

- Tabella `schede` e dati progressione vivono sul DB `progressione`, non su `ptv`.
- Filament, action e relazioni (`Valutatore::schede()`) devono interrogare lo stesso schema.
- I test registrano la connessione `progressione` per rollback transazionale ([testing](../../docs/development/testing.md)).

## Anti-pattern

```php
// ❌ Manca override: Scheda usa connessione ptv ereditata
class Scheda extends BaseScheda
{
    protected $table = 'schede';
}

// ❌ Connessione null sul BaseModel del modulo
protected $connection = null;
```

## Binding Resource/Page → connessione (Filament)

La connessione effettiva usata da un pannello Filament dipende dal **model risolto dalla Page**, non solo dall'`$connection` del model Progressioni.

Le Resource Rating (`RatingResource`, `RatingMorphResource`) estendono basi astratte del **modulo Rating** (`BaseRatingResource`, `BaseRatingMorphResource`). Se la base override `getPages()` con le Page del modulo Rating, il pannello `progressioni::admin` finisce a usare `Rating\Rating` / `Rating\RatingMorph` (connessione `rating` → `ptv_lara`) invece dei model Progressioni.

Regola:

1. Le basi Rating **non** devono override `getPages()` (auto-resolve via `static::class\Pages\`).
2. Progressioni deve avere le proprie Page (`RatingResource/Pages/...`, `RatingMorphResource/Pages/...`) con `protected static string $resource = Modules\Progressioni\...\<Resource>::class`.
3. Il model Progressioni override `protected $connection = 'progressione';`.

Così il pannello Progressioni risolve `Progressioni\RatingMorph` (conn `progressione`, tabella `rating_morphs`).

Dettaglio e anti-pattern: [Xot — getPages cross-module](../Xot/docs/filament/getpages-redundancy-rule.md).

## Verifica rapida

```bash
cd laravel
php artisan tinker --execute="echo (new \\Modules\\Progressioni\\Models\\Scheda)->getConnectionName();"
# atteso: progressione

# Resource Filament → model/connessione effettivi del pannello
php artisan tinker --execute="\$m=\\Modules\\Progressioni\\Filament\\Resources\\RatingMorphResource::getModel(); echo \$m.' '.(new \$m)->getConnectionName();"
# atteso: Modules\Progressioni\Models\RatingMorph progressione
```

## Collegamenti

- [contract aggregation pattern](./wiki/rules/contract-aggregation-pattern.md)
- [scheda contract inheritance (Ptv)](../Ptv/docs/wiki/concepts/scheda-contract-inheritance.md)
- [database patterns (root)](../../docs/patterns/database.md)
- [schema modulo](./schema.md)
