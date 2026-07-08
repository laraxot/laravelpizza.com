# Handoff: fix `Scheda::peso()` ArgumentCountError su CompilaScheda

**Stato:** risolto in codice (2026-06-15)  
**Route:** `GET /progressioni/admin/schedas/{id}/compila`  
**Repo:** `git@github.com:provtv/base_ptv_fila5_mono.git` (monorepo PTVX)

## Sintomo

```
ArgumentCountError: Too few arguments to function Scheda::peso(), 0 passed … exactly 1 expected
```

Stack: `CompilaScheda::fillForm()` → `attributesToArray()` → `getPesoEsperienzaAcquisitaAttribute()` → `$this->peso`.

## Causa

Omonimia su `Scheda`:

- Relazione attesa (Sigma/Performance): `peso()` → `HasOne` verso tabella `peso`.
- Metodo business Progressioni: `peso(array $params)` → calcolo su `coeff`.

Laravel preferisce il metodo sul modello concreto e lo tratta come relazione.

## Fix

| File | Modifica |
|------|----------|
| `Modules/Progressioni/.../ProgressioniRelationshipTrait.php` | Aggiunto `peso(): HasOne` (alias di `pesi()`) |
| `Modules/Progressioni/.../Scheda.php` | Rinominato `peso(array)` → `resolveCoeffPesoFromParams(array)` |

## Doc permanente

- [laravel/Modules/Progressioni/docs/scheda-peso-relationship-homonym.md](../../laravel/Modules/Progressioni/docs/scheda-peso-relationship-homonym.md)

## Issue / discussion GitHub (bozza)

**Titolo issue:** `fix(Progressioni): Scheda peso() homonym breaks CompilaScheda attributesToArray`

**Body suggerito:**

> `Scheda::peso(array $params)` collided with Eloquent relation resolution used by `SchedaTrait::$this->peso`. Renamed business method to `resolveCoeffPesoFromParams`; added `peso(): HasOne` alias aligned with Performance.  
> Regression: open compila page for any scheda with propro set.

## QA per agente successivo

- [ ] Smoke test URL compila (es. scheda 10920)
- [ ] PHPStan `Modules/Progressioni` (da `laravel/`)
- [ ] Nessun caller di `->peso([` nel monorepo
