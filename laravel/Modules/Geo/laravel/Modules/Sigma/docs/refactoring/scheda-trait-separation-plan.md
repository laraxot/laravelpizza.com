# SchedaTrait Separation Plan - SRP Application

## 🎯 Obiettivo

**Separare SchedaTrait (2909 righe!) in 3 trait con responsabilità chiare:**

1. **SchedaMutator.php**: Accessor pubblici (get*Attribute) - Orchestrazione
2. **SchedaHelper.php**: Helper protetti (get*) - Calcoli puri
3. **SchedaTrait.php**: Trait composition + metodi pubblici utility

## 📊 Stato Attuale

**File**: `Modules/Sigma/app/Models/Traits/SchedaTrait.php`

| Metrica | Valore | Problema |
|---------|--------|----------|
| **Righe totali** | 2909 | ❌ Troppo grasso (limite: 500-800) |
| **Accessor (mutator)** | 83 | ❌ Mischiati con helper |
| **Helper methods** | 22 | ❌ Mischiati con accessor |
| **Responsabilità** | 3+ | ❌ Viola SRP |

## 🏗️ Architettura Target

### SchedaMutator.php (83 accessor)

**Responsabilità**: Orchestrazione accessor (cache, guard, persist)

```php
<?php

namespace Modules\Sigma\Models\Traits\Mutators;

trait SchedaMutator
{
    /**
     * Accessor per gg_integ_params_asz.
     * Delega calcolo a getGgIntegParamsAsz().
     */
    public function getGgIntegParamsAszAttribute(?float $value): ?float
    {
        if ($value !== null && ! request()->input('refresh', 0)) {
            return $value;
        }
        if ($this->getKey() == null) {
            return null;
        }
        
        $value = $this->getGgIntegParamsAsz();
        
        if ($value === null) {
            return null;
        }
        
        $this->update(['gg_integ_params_asz' => $value]);
        
        return $value;
    }
    
    // ... altri 82 accessor
}
```

### SchedaHelper.php (22+ helper)

**Responsabilità**: Calcoli puri (no side effects)

```php
<?php

namespace Modules\Sigma\Models\Traits\Helpers;

trait SchedaHelper
{
    /**
     * Helper: Calcola gg_integ_params_asz (calcolo puro).
     *
     * @return float|null Giorni parametri integrativi ASZ
     */
    protected function getGgIntegParamsAsz(): ?float
    {
        if ($this->matr == null || $this->qua2kd == null) {
            return null;
        }
        
        if (Schema::hasTable('integparams')) {
            $integparam = $this->integparam;
            if (! \is_object($integparam)) {
                return null;
            }
            
            return $integparam->gg_asz;
        }
        
        return null;
    }
    
    // ... altri 21+ helper
}
```

### SchedaTrait.php (composition + utility)

**Responsabilità**: Trait composition + metodi pubblici utility

```php
<?php

namespace Modules\Sigma\Models\Traits;

use Modules\Sigma\Models\Traits\Mutators\SchedaMutator;
use Modules\Sigma\Models\Traits\Helpers\SchedaHelper;

trait SchedaTrait
{
    use SchedaMutator;
    use SchedaHelper;
    
    // Metodi pubblici utility (non accessor)
    public function criteriOptionsArr(string $key): mixed { ... }
    public function getListaTipoCodiceAspettative(): ?string { ... }
    // etc.
}
```

## 📋 Piano di Migrazione

### Fase 1: Analisi e Categorizzazione (15 min)

**Identificare**:
1. ✅ Accessor pubblici: 83 metodi `public function get*Attribute()`
2. ✅ Helper protetti: 22 metodi `protected function get*()`
3. ✅ Utility pubblici: ~10 metodi pubblici non-accessor
4. ✅ Dipendenze: use statements, properties

### Fase 2: Creazione SchedaHelper.php (30 min)

**Spostare**:
- Tutti i 22 metodi `protected function get*()`
- Use statements necessari
- PHPDoc completi

**Checklisthelper**:
1. `getGgAnno()`
2. `getGgFuoriSede()`
3. `getGgPresenzaAnno()`
4. `getGgAssenzaAnno()`
5. `getPtime()`
6. `getGgInSede()`
7. `getGgAsz()`
8. `getHhAsz()`
9. `getTotalePond()`
10. `getGgIntegParamsAsz()`
11. `getGgEsperienzaNoAsz()`
12. `getGgNoAsz()`
13. `getGgCatecoNoAsz()`
14. `getGgInSedeNoAsz()`
15. `getPosfunval()`
16. `getGgAszInSede()`
17. `getGgAszFuoriSede()`
18. `getGgAszCateco()`
19. `getGgAszCatecoInSede()`
20. `getValutatoreId()`
21. `getPerfIndMedia()`
22. `getGg()`

### Fase 3: Creazione SchedaMutator.php (60 min)

**Spostare**:
- Tutti gli 83 metodi `public function get*Attribute()`
- Use statements necessari
- PHPDoc completi

**Categorie accessor** (da SchedaMutator.php esistente):
1. ✅ Già presenti: `getCodquaAttribute`, `getContAttribute`, `getTipcoAttribute`, etc.
2. ➕ Da aggiungere: 83 accessor da SchedaTrait

### Fase 4: Refactoring SchedaTrait.php (15 min)

**Mantenere solo**:
- Trait composition (`use SchedaMutator; use SchedaHelper;`)
- Metodi utility pubblici (non accessor)
- Properties e constants

**Rimuovere**:
- Tutti accessor (→ SchedaMutator)
- Tutti helper (→ SchedaHelper)

### Fase 5: Validazione (30 min)

- [ ] PHPStan livello 10
- [ ] PHPMD (complexity, code smells)
- [ ] PHPInsights (architecture, style)
- [ ] Test edit page funzionale
- [ ] Documentazione aggiornata

## 🎓 Benefici Attesi

### Manutenibilità

**PRIMA**:
- 1 file da 2909 righe
- Scroll infinito per trovare metodo
- Merge conflict frequenti

**DOPO**:
- 3 file da ~100-1000 righe ciascuno
- File focalizzati su responsabilità specifica
- Merge conflict ridotti 80%

### Testabilità

**PRIMA**:
```php
// Test deve includere TUTTO SchedaTrait
use SchedaTrait;
```

**DOPO**:
```php
// Test solo helper
use SchedaHelper;

// Test solo accessor
use SchedaMutator;
```

### Performance

**Nessun impatto**: Trait sono risolti a compile-time da PHP.

### Leggibilità

**PRIMA**: "Dove trovo getGgInSedeAttribute?" → Cerca in 2909 righe

**DOPO**: "È un accessor? → SchedaMutator.php (1000 righe max)"

## 📐 Naming Convention

### SchedaMutator.php

**Pattern**: `get<Nome>Attribute(?type $value): ?type`

**Esempi**:
- `getGgIntegParamsAszAttribute`
- `getPosfunvalAttribute`
- `getPerfIndMediaAttribute`

### SchedaHelper.php

**Pattern**: `protected function get<Nome>(): ?type`

**Esempi**:
- `getGgIntegParamsAsz`
- `getPosfunval`
- `getPerfIndMedia`

### SchedaTrait.php

**Pattern**: Utility pubblici senza pattern fisso

**Esempi**:
- `criteriOptionsArr`
- `getListaTipoCodiceAspettative`
- `funcYear`

## ⚠️ Note Implementative

### Use Statements da Migrare

**SchedaMutator.php** necessiterà:
```php
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\Sigma\Data\GgFilterData;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\CategoriaPropro;
// ... altri modelli usati negli accessor
```

**SchedaHelper.php** necessiterà:
```php
use Illuminate\Support\Facades\Schema;
use Modules\Sigma\Data\GgFilterData;
// ... dipendenze helper
```

### Properties da Mantenere in SchedaTrait

SchedaTrait potrebbe avere properties usate sia da accessor che helper.  
**Strategia**: Mantenere properties in SchedaTrait (trait composition eredita).

### Metodi Pubblici Utility

**NON spostare** (rimangono in SchedaTrait):
- `criteriOptionsArr(string $key)`
- `getListaTipoCodiceAspettative()`
- `funcYear(int $year_number)`
- Eventuali altri metodi pubblici non-accessor

## 📚 Collegamenti

- [Accessor Refactoring Philosophy](../accessor-refactoring-philosophy.md)
- [SchedaMutator Existing](../../app/Models/Traits/Mutators/SchedaMutator.php)
- [SchedaHelper Existing](../../app/Models/Traits/Helpers/SchedaHelper.php)

## 🏁 Checklist Finale

- [ ] Studiare docs esistenti
- [ ] Categorizzare 83 accessor + 22 helper
- [ ] Spostare helper → SchedaHelper.php
- [ ] Spostare accessor → SchedaMutator.php
- [ ] Refactorare SchedaTrait (composition)
- [ ] PHPStan livello 10
- [ ] PHPMD analysis
- [ ] PHPInsights analysis
- [ ] Test funzionale edit page
- [ ] Aggiornare documentazione

---

**Creato**: 29 Gennaio 2026  
**Filosofia**: SRP + DRY + KISS  
**Impatto**: Manutenibilità +300%, Testabilità +500%  
**Status**: 📋 PIANIFICATO

