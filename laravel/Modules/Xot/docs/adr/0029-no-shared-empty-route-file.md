---
title: "ADR — no shared Modules/Xot/routes/empty.php"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-24
issues: []
qmd: "routes empty.php require base_path XotBaseRouteServiceProvider stub module"
---

# ADR: no shared `Modules/Xot/routes/empty.php`

## Contesto

`XotBaseRouteServiceProvider` carica sempre `routes/web.php` e `routes/api.php` del modulo (`Route::…->group($module_dir.'/../../routes/…')`). Alcuni moduli senza rotte tradizionali (UI, Lang, Cms api) avevano:

```php
require base_path('Modules/Xot/routes/empty.php');
```

spesso lasciato da un merge (`<<<<<<<` / `>>>>>>> laraxot/dev`). Il file `empty.php` **non esiste** in Xot: il `require` è coupling falso e, se risolto verso quel lato, fatale a boot.

## Decisione

1. **Vietato** `require` / `include` di un file rotte condiviso “vuoto” sotto Xot (o altro modulo).
2. Se il modulo non registra rotte: lasciare `routes/web.php` / `routes/api.php` **presenti e minimi** (`declare(strict_types=1);` + commento opzionale). `Route::group` su un file PHP senza `Route::` è già “vuoto”.
3. Non creare `Modules/Xot/routes/empty.php` per “sistemare” i require: sarebbe nascondere il sintomo.

## Alternative scartate

### File `empty.php` condiviso in Xot
- Pros: un solo stub.
- Cons: dipendenza cross-modulo per zero comportamento; path `base_path('Modules/Xot/…')` fragile fuori dal layout atteso; falsa sensazione di contratto.
- Why not: KISS — un file locale vuoto basta.

### Omettere `routes/web.php` / `api.php`
- Pros: meno file.
- Cons: `XotBaseRouteServiceProvider::mapWebRoutes` / `mapApiRoutes` falliscono se il path manca.
- Why not: il provider assume i file.

### Disabilitare map* per moduli Folio-only
- Pros: niente stub.
- Cons: eccezioni per-modulo, regressioni già viste quando map* erano commentati (rotte User/socialite mancanti).
- Why not: stub locale è più economico e uniforme.

## Conseguenze

- Pro: niente fatale su require fantasma; niente coupling Xot per il nulla; marker di conflitto rimossi nei route file toccati.
- Contro: ogni modulo tiene due stub anche se “vuoti” (già vero per Activity/Tenant/Rating).
- Misura: `rg "Xot/routes/empty" laravel/Modules` deve restare vuoto.

## Related

- Loader: `app/Providers/XotBaseRouteServiceProvider.php`
- Story: [`../bmad/stories/no-shared-empty-route-file.story.md`](../bmad/stories/0107-no-shared-empty-route-file.story.md)
