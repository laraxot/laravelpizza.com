# SchedaTrait: Categorizzazione Completa Metodi

## 📊 Analisi Completa (124 metodi totali)

### 1. Accessor Pubblici (83) → SchedaMutator.php

**Pattern**: `public function get*Attribute(?type $value): ?type`

**Responsabilità**: Orchestrazione (cache, guard, delega, persist)

**Esempi**:
- `getGgIntegParamsAszAttribute()`
- `getPosfunvalAttribute()`
- `getGgAttribute()`
- ... altri 80

### 2. Helper Protetti (23) → SchedaHelper.php

**Pattern**: `protected function get*(): ?type`

**Responsabilità**: Calcoli puri (no side effects)

**Lista Completa**:
1. `getGgAnno()` - linea 82
2. `getGgFuoriSede()` - linea 99
3. `getGgPresenzaAnno()` - linea 124
4. `getGgAssenzaAnno()` - linea 158
5. `getPtime()` - linea 193
6. `getGgInSede()` - linea 252
7. `getGgAsz()` - linea 283
8. `getHhAsz()` - linea 304
9. `getTotalePond()` - linea 328
10. `getGgIntegParamsAsz()` - linea 372
11. `getGgEsperienzaNoAsz()` - linea 403
12. `getGgNoAsz()` - linea 425
13. `getGgCatecoNoAsz()` - linea 441
14. `getGgInSedeNoAsz()` - linea 457
15. `getPosfunval()` - linea 624
16. `getGg()` - linea 691
17. `getGgAszInSede()` - linea 938
18. `getGgAszFuoriSede()` - linea 1007
19. `getGgAszCateco()` - linea 1075
20. `getGgAszCatecoInSede()` - linea 1123
21. `getValutatoreId()` - linea 2172
22. `getPerfIndMedia()` - linea 2747
23. (+ 1 da trovare nella lista grep)

### 3. Helper Pubblici (12) → SchedaHelper.php

**Pattern**: `public function get*(): ?type` (NO Attribute)

**Responsabilità**: Helper riusabili pubblicamente

**Lista Completa**:
1. `getGgCatecoPosfunNoAsz()` - linea 64
2. `getGgAszCatecoPosfunInSede()` - linea 1186
3. `getPropro()` - linea 1263
4. `getGgCatecoPosfun()` - linea 1349
5. `getGgCatecoInSede()` - linea 1499
6. `getGgCateco()` - linea 1546
7. `getGgCatecoPosfunInSede()` - linea 1570
8. `getGgAszCatecoPosfunFuoriSede()` - linea 1640
9. `getGgCatecoFuoriSede()` - linea 1707
10. `getGgCatecoPosfunFuoriSede()` - linea 1753
11. `getGgIntegParams()` - linea 2876 (utility o helper?)
12. (+ altri da trovare)

### 4. Utility Pubblici (6) → SchedaTrait.php

**Pattern**: `public function <nome>()` (NO get*)

**Responsabilità**: Metodi utility generali

**Lista Completa**:
1. `puntProgressioneFinale()` - linea 2081
2. `setPuntProgressioneFinaleAttribute()` - linea 2117 (setter mutator)
3. `funcYear()` - linea 2577
4. `perfIndMedia()` - linea 2705
5. `excellencesCountLast3years()` - linea 2829
6. `criteriOptionsArr()` - linea 2900

## 🤔 Decisioni Architetturali

### Helper Pubblici vs Protetti

**Domanda**: I 12 helper pubblici (getGgCatecoPosfunNoAsz, etc.) devono essere public o protected?

**Analisi**:
- Alcuni sono chiamati da **accessor** (devono essere accessibili)
- Alcuni sono chiamati da **codice esterno** (Resource, Widget)
- Alcuni sono **intermedi** (chiamati da altri helper)

**Decisione**: 
- Se chiamati SOLO da accessor → `protected` in SchedaHelper
- Se chiamati anche da esterno → `public` in SchedaHelper

**Verificare**: Cercare chiamate esterne a questi metodi.

### Setter Mutator

`setPuntProgressioneFinaleAttribute()` è un **setter mutator**, non accessor getter.

**Decisione**: Va in **SchedaMutator.php** (insieme ad altri mutator).

### Metodi che Chiamano Helper

`puntProgressioneFinale()`, `perfIndMedia()`, `excellencesCountLast3years()` potrebbero essere **wrapper pubblici** per helper.

**Verificare**: Se sono duplicati di helper, unificare.

## 📋 Piano di Migrazione Dettagliato

### Step 1: Preparazione SchedaHelper.php

```php
<?php

namespace Modules\Sigma\Models\Traits\Helpers;

use Illuminate\Support\Facades\Schema;
use Modules\Sigma\Data\GgFilterData;

trait SchedaHelper
{
    // 23 helper protected
    protected function getGgAnno(): ?int { ... }
    protected function getGgFuoriSede(): ?int { ... }
    // ... altri 21
    
    // 12 helper public
    public function getGgCatecoPosfunNoAsz(): ?int { ... }
    public function getPropro(): ?int { ... }
    // ... altri 10
}
```

### Step 2: Aggiornamento SchedaMutator.php

**Merge con esistente** (già ha ~30 accessor):

```php
<?php

namespace Modules\Sigma\Models\Traits\Mutators;

use Modules\Sigma\Models\Traits\Helpers\SchedaHelper;

trait SchedaMutator
{
    use SchedaHelper;  // ⚡ IMPORTANTE: accessor usano helper
    
    // Accessor esistenti (già presenti)
    public function getCodquaAttribute() { ... }
    public function getContAttribute() { ... }
    // ... altri 28
    
    // Accessor da SchedaTrait (83 nuovi)
    public function getGgIntegParamsAszAttribute() { ... }
    public function getPosfunvalAttribute() { ... }
    // ... altri 81
    
    // Setter mutator
    public function setPuntProgressioneFinaleAttribute() { ... }
}
```

### Step 3: Semplificazione SchedaTrait.php

```php
<?php

namespace Modules\Sigma\Models\Traits;

use Modules\Sigma\Models\Traits\Mutators\SchedaMutator;
use Modules\Sigma\Models\Traits\Helpers\SchedaHelper;

trait SchedaTrait
{
    use SchedaMutator;  // Accessor + setter
    use SchedaHelper;   // Helper methods
    
    // Solo 6 utility methods
    public function puntProgressioneFinale(): float { ... }
    public function funcYear(string $func, ?float $value): ?float { ... }
    public function perfIndMedia(): ?float { ... }
    public function excellencesCountLast3years(): int { ... }
    public function criteriOptionsArr(string $name): mixed { ... }
    public function getCriteriOptions(): ?Collection { ... }
}
```

## 🔍 Verifica Dipendenze

**Prima di spostare**, devo verificare:

1. **Use statements** necessari in ogni file
2. **Properties** usate (devono rimanere in SchedaTrait)
3. **Chiamate esterne** a metodi pubblici
4. **Dipendenze circolari** tra helper

## 📚 Collegamenti

- [Separation Plan](./scheda-trait-separation-plan.md)
- [Accessor Pattern](../accessor-refactoring-philosophy.md)

---

**Creato**: 29 Gennaio 2026  
**Status**: 📋 ANALISI COMPLETATA  
**Next**: Implementazione migrazione

