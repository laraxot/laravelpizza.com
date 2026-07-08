# Trait Delegation Cascade Pattern - DRY Architecture

## 🎯 Filosofia: Delegation in Depth

### Principio Fondamentale

**SchedaTrait = Pure Orchestrator (NO implementation diretta)**

Ogni responsabilità deve essere delegata al trait specifico:
- Mutator → SchedaMutator
- Relationship → SchedaRelationship  
- Scope → SchedaScope
- Helper → SchedaHelper

## 📐 Architettura Prima vs Dopo

### ❌ PRIMA (Flat Composition)

```php
trait SchedaTrait
{
    use CommonMutator;        // ❌ Diretto
    use CommonRelationship;   // ❌ Diretto
    use CommonScope;          // ❌ Diretto
    use SchedaMutator;        // Sub-trait
    use SchedaRelationship;   // Sub-trait (vuoto)
    use SchedaScope;          // Sub-trait (non esiste)
    use SchedaHelper;         // Sub-trait
}
```

**Problema**: Mix di trait comuni e specializzati allo stesso livello → confuso.

### ✅ DOPO (Delegated Composition)

```php
trait SchedaTrait
{
    // Domain-specific trait (questi includono i comuni)
    use SchedaMutator;        // Include CommonMutator
    use SchedaRelationship;   // Include CommonRelationship
    use SchedaScope;          // Include CommonScope
    use SchedaHelper;         // Include calcoli puri
    
    // Trait senza delegation (specifici di Scheda)
    use EnteMatrAnnoMutator;
    use EnteMatrDateRangeMutator;
    use FunctionExtra;
    use MassExtra;
    // etc.
}
```

**Benefici**: 
- ✅ Gerarchia chiara
- ✅ SchedaTrait più pulito
- ✅ Responsabilità delegate

## 🏗️ Implementazione Delegations

### 1. CommonMutator → SchedaMutator

**File**: `SchedaMutator.php`

```php
namespace Modules\Sigma\Models\Traits\Mutators;

use Modules\Sigma\Models\Traits\Helpers\SchedaHelper;
use Modules\Sigma\Models\Traits\Mutators\CommonMutator;

trait SchedaMutator
{
    use SchedaHelper;     // Helper puri
    use CommonMutator;    // ⚡ Mutator comuni (delegato qui)
    
    // Accessor specifici di Scheda
    public function getCodquaAttribute() { ... }
    // ... altri accessor
}
```

### 2. CommonRelationship → SchedaRelationship

**File**: `SchedaRelationship.php`

```php
namespace Modules\Sigma\Models\Traits\Relationships;

use Modules\Sigma\Models\Traits\Relationships\CommonRelationship;

trait SchedaRelationship
{
    use CommonRelationship;    // ⚡ Relazioni comuni (delegato qui)
    
    // Relazioni specifiche di Scheda (se necessarie)
}
```

### 3. CommonScope → SchedaScope

**File**: `SchedaScope.php` (da creare se non esiste)

```php
namespace Modules\Sigma\Models\Traits\Scopes;

use Modules\Sigma\Models\Traits\Scopes\CommonScope;

trait SchedaScope
{
    use CommonScope;    // ⚡ Scope comuni (delegato qui)
    
    // Scope specifici di Scheda (se necessari)
}
```

### 4. SchedaTrait Pulito (Final)

```php
trait SchedaTrait
{
    // ⚡ Domain-specific trait (delegation cascade)
    use SchedaMutator;        // → CommonMutator
    use SchedaRelationship;   // → CommonRelationship
    use SchedaScope;          // → CommonScope
    use SchedaHelper;         // → Pure calculations
    
    // Trait specifici (senza common da delegare)
    use EnteMatrAnnoMutator;
    use EnteMatrAnnoRelationship;
    use EnteMatrDateRangeMutator;
    use EnteMatrDateRangeRelationship;
    use EnteMatrMutator;
    use EnteMatrRelationship;
    use EnteStabiMutator;
    use EnteStabiRelationship;
    use FunctionExtra;
    use MassExtra;
    use TquRelationship;
    
    // Solo utility methods
    public function criteriOptionsArr() { ... }
    public function funcYear() { ... }
    // ... altri 4 utility
}
```

## 📊 Benefici della Delegation

### Chiarezza Architetturale

**Domanda**: "Dove sono i mutator comuni?"

**PRIMA**: "In SchedaTrait... o in CommonMutator... o dove?"

**DOPO**: "In SchedaMutator (che include CommonMutator)"

### Scalabilità

**Aggiungere nuovo mutator comune**:

**PRIMA**: Modificare SchedaTrait (rischio breaking changes).

**DOPO**: Modificare CommonMutator, SchedaMutator eredita automaticamente.

### Testing

**Test SchedaMutator**:

**PRIMA**: Mock SchedaTrait (include tutto, pesante).

**DOPO**: Mock solo SchedaMutator (include CommonMutator, focalizzato).

## ⚠️ Note Implementative

### Verificare Trait Esistenti

- [x] CommonMutator esiste ✅
- [x] CommonRelationship esiste ✅
- [x] CommonScope esiste ✅
- [x] SchedaMutator esiste ✅
- [x] SchedaRelationship esiste ✅
- [ ] SchedaScope esiste? (da verificare)

### Trait Resolution Conflicts

Se SchedaMutator include CommonMutator E SchedaTrait include ANCHE CommonMutator:

```php
// ⚠️ POSSIBILE CONFLICT
trait SchedaTrait {
    use CommonMutator;    // Primo livello
    use SchedaMutator {   // Include anche CommonMutator
        // Possibile conflict!
    }
}
```

**Soluzione**: Rimuovere da SchedaTrait (delegation completa).

## 📚 Collegamenti

- [Phase 1 Success Summary](./phase1-success-summary.md)
- [Professional Migration Strategy](./scheda-trait-professional-migration-strategy.md)

---

**Creato**: 29 Gennaio 2026  
**Pattern**: Trait Delegation Cascade  
**Status**: 📋 DESIGN DOCUMENTATO  
**Next**: Implementazione delegation

