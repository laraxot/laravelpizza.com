---
title: "Ptv Scheda Contract Aggregation"
type: rule
module: Ptv
tags: [contract, aggregation, dry, pndscheda, bassecheda]
created: 2026-06-15
updated: 2026-06-15
qmd: "Ptv SchedaContract LettF LettI contract aggregation pndscheda"
---

# Ptv Scheda — Contract Aggregation

## Regola

**Ptv `BaseScheda` e `Scheda` seguono lo stesso pattern di Progressioni**: implementano un unico contratto custom (`SchedaContract`) che a sua volta aggrega i contratti Sigma.

### Schema

```
Modules\Xot\Models\XotBaseModel
      ↑
Modules\Progressioni\Models\BaseModel (SigmaEnteMatrFields + SigmaDateRangeFields)
      ↑
Modules\Ptv\Models\BaseScheda implements SchedaContract
      ↑
Modules\Ptv\Models\Scheda
```

### Implementazione

```php
// modules/Ptv/app/Models/Contracts/SchedaContract.php
namespace Modules\Ptv\Models\Contracts;

interface SchedaContract
    extends \Modules\Sigma\Models\Contracts\SigmaEnteMatrFields,
    \Modules\Sigma\Models\Contracts\SigmaDateRangeFields
{
    // Eventuali metodi Ptv specifici qui
}
```

```php
// modules/Ptv/app/Models/BaseScheda.php
abstract class BaseScheda extends \Modules\Progressioni\Models\BaseScheda
    implements \Modules\Ptv\Models\Contracts\SchedaContract
{
}
```

## Eccezioni

| Modello | Motivo |
|---------|--------|
| `LettF` / `LettI` | Non hanno `SchedaTrait` né i contratti; si usano `hasMany` espliciti |

## Verifica

```bash
# Controllo: Tutti i model Scheda devono implementare SchedaContract
rg 'implements.*SchedaContract' laravel/Modules/Ptv/app/Models/*.php
```

---

**Pattern:** Contract Aggregation (Ptv variant)  
**Compliance:** ✅ BaseScheda, Scheda  
**Issue di riferimento:** https://github.com/provtv/module_ptvx_fila5/issues/1