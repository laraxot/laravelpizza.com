# SchedaTrait Professional Migration Strategy

## 🎯 Approccio Professionale: Zero-Downtime Refactoring

### Filosofia

**Professionale** = Sicuro, Incrementale, Validato, Documentato

**Intelligente** = Minimizzare rischio, Massimizzare qualità, Automatizzare verifiche

### Scoperta Importante

✅ **SchedaTrait GIÀ usa `use SchedaMutator`** (linea 52)!

**Implicazione**: Non partiamo da zero, c'è già una base.

## 📊 Audit Situazione Attuale

### File Esistenti

1. **SchedaTrait.php** (2909 righe)
   - ✅ Già usa `use SchedaMutator`
   - ❌ Contiene ancora 83 accessor inline
   - ❌ Contiene 35 helper (23 protected + 12 public)
   - ✅ Contiene 6 utility methods

2. **SchedaMutator.php** (491 righe)
   - ✅ Già contiene ~8 accessor base
   - ❌ Mancano ~75 accessor da SchedaTrait

3. **SchedaHelper.php** (11 righe)
   - ❌ Vuoto (solo scheletro)
   - ❌ Deve ricevere 35 helper

### Strategia di Migrazione

**Approccio a Cascata Controllata**:

```
Step 1: Creare SchedaHelper completo (35 helper)
  ↓ Validazione: PHPStan
  
Step 2: SchedaTrait usa SchedaHelper
  ↓ Validazione: PHPStan (accessor devono trovare helper)
  
Step 3: Spostare accessor batch 1 (20) → SchedaMutator
  ↓ Validazione: PHPStan
  
Step 4: Spostare accessor batch 2 (20) → SchedaMutator
  ↓ Validazione: PHPStan
  
Step 5: Spostare accessor batch 3 (20) → SchedaMutator
  ↓ Validazione: PHPStan
  
Step 6: Spostare accessor batch 4 (15) → SchedaMutator
  ↓ Validazione: PHPStan
  
Step 7: Cleanup SchedaTrait (rimuovere accessor, mantenere utility)
  ↓ Validazione: PHPStan + PHPMD + PHPInsights
  
Step 8: Test funzionale edit page
  ↓ Validazione: Performance, no regressioni
```

## 🛡️ Safety Checks

### Pre-Migration

- [x] Backup SchedaTrait.php (git status clean)
- [x] Identificati tutti i metodi (124 totali)
- [x] Categorizzati per tipo (accessor, helper, utility)
- [x] Verificato uso esistente di SchedaMutator
- [ ] Verificare modelli che usano SchedaTrait
- [ ] Identificare use statements necessari

### Durante Migration

- [ ] PHPStan livello 10 dopo OGNI step
- [ ] Git commit dopo ogni batch validato
- [ ] Mantener PHPDoc completi
- [ ] Test sintassi PHP (php -l file.php)

### Post-Migration

- [ ] PHPStan livello 10 su tutti i 3 file
- [ ] PHPMD complexity analysis
- [ ] PHPInsights quality score
- [ ] Test regressione completo
- [ ] Performance test edit page
- [ ] Documentazione finale aggiornata

## 📋 Extraction Lists

### Helper Protetti (23) → SchedaHelper.php

```
getGgAnno
getGgFuoriSede
getGgPresenzaAnno
getGgAssenzaAnno
getPtime
getGgInSede
getGgAsz
getHhAsz
getTotalePond
getGgIntegParamsAsz
getGgEsperienzaNoAsz
getGgNoAsz
getGgCatecoNoAsz
getGgInSedeNoAsz
getPosfunval
getGg
getGgAszInSede
getGgAszFuoriSede
getGgAszCateco
getGgAszCatecoInSede
getValutatoreId
getPerfIndMedia
getGgCatecoSupInSede
```

### Helper Pubblici (12) → SchedaHelper.php

```
getGgCatecoPosfunNoAsz
getGgAszCatecoPosfunInSede
getPropro
getGgCatecoPosfun
getGgCatecoInSede
getGgCateco
getGgCatecoPosfunInSede
getGgAszCatecoPosfunFuoriSede
getGgCatecoFuoriSede
getGgCatecoPosfunFuoriSede
getCriteriOptions
getGgIntegParams
```

### Utility (6) → Rimangono in SchedaTrait

```
puntProgressioneFinale
setPuntProgressioneFinaleAttribute (setter)
funcYear
perfIndMedia
excellencesCountLast3years
criteriOptionsArr
```

## 🔧 Use Statements Necessari

### SchedaHelper.php necessita

```php
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\Sigma\Datas\GgFilterData;
use Modules\Sigma\Models\Integparam;
use Modules\Sigma\Models\Qua00f;
```

### SchedaMutator.php GIÀ ha

```php
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Schema;
use Log;
use Modules\Sigma\Models\Codici;
```

### SchedaMutator.php necessiterà ANCHE

```php
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Sigma\Datas\GgFilterData;
use Modules\Sigma\Models\Integparam;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Traits\Helpers\SchedaHelper;  // ⚡ CRITICO
```

## ⚡ Critical Decision: SchedaMutator DEVE usare SchedaHelper

```php
// SchedaMutator.php
namespace Modules\Sigma\Models\Traits\Mutators;

use Modules\Sigma\Models\Traits\Helpers\SchedaHelper;

trait SchedaMutator
{
    use SchedaHelper;  // ⚡ ESSENZIALE: accessor chiamano helper
    
    // Accessor possono chiamare $this->getGgIntegParamsAsz()
}
```

## 📚 Collegamenti

- [Categorization](./scheda-trait-method-categorization.md)
- [Separation Plan](./scheda-trait-separation-plan.md)

---

**Creato**: 29 Gennaio 2026  
**Approccio**: Professionale e Sicuro  
**Status**: 📋 STRATEGIA DEFINITA  
**Next**: Implementazione Step 1

