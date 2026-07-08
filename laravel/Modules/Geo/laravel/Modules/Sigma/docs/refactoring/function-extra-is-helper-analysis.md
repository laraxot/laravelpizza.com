# FunctionExtra è un Helper Trait - Analisi

## 🎯 Scoperta: FunctionExtra = Helper Calculations

### Business Logic

**File**: `Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php`

**Contenuto**: Metodi di calcolo per giorni/ore presenza/assenza tramite query DB.

**Natura**: **Helper methods** (calcoli puri, anche se fanno query).

## 📋 Metodi in FunctionExtra

### Pattern dei Metodi

```php
// Tutti i metodi sono "calculators" (input → output, no state mutation)
public function ggInSedeTot(GgFilterData $data): ?int
public function ggFuoriSedeTot(array $params): ?int
public function ggAssenzaInSedeTot(GgFilterData $data): int
public function hhAssenzaInSedeTot(array $params): int
public function ggAssenzaFuoriSedeTot(array $params): int  // stub, return 0
public function hhAssenzaFuoriSedeTot(array $params): int  // stub, return 0
```

**Caratteristiche**:
- ✅ Input parametrizzato (GgFilterData o array)
- ✅ Output deterministico (dato stesso input)
- ✅ NO mutation dello stato ($this)
- ✅ NO persistenza (no save/update)
- ✅ Pure calculations (anche se fanno query DB)

## 🤔 FunctionExtra è Helper o Utility?

### Definizione Helper

**Helper** = Metodo che calcola valore derivato senza side effects.

**FunctionExtra methods**:
- ✅ Calcolano giorni/ore (valori derivati)
- ✅ Non mutano stato del modello
- ✅ Sono richiamabili più volte con stesso risultato (idempotenti)
- ✅ Usati DA accessor per calcolare valori

**Conclusione**: ✅ **FunctionExtra è un HELPER trait!**

## Incidente 2026-06-18: tipo vs relazione

`ggInSedeTot` passa `$this->qua00f()` (HasMany) ai helper privati. `applyQua00fCoalesceTotSelect` accettava già `Builder|Relation`; `applyQua00fProproFilters` no → TypeError su Trova esclusi.

**Fix corretto:** allineare la firma, non `getQuery()` (perderebbe FK `ente`+`matr`).

Dettaglio percorsi alternativi: [function-extra-relation-query-pattern](../wiki/concepts/function-extra-relation-query-pattern.md)

## lista_tipo_codice: array → stringa CSV

`getListaTipoCodiceAspettative()` restituisce `array<int, string>` (es. `['505-97']`). `GgFilterData::$lista_tipo_codice` è `?string` per `find_in_set(concat(asztip,"-",aszcod), ?)`.

Normalizzazione centralizzata in `GgFilterData::prepareForPipeline()` + `normalizeListaTipoCodice()`. Non passare array grezzo a `GgFilterData::from()` senza pipeline — la DTO lo gestisce.

### Dove Dovrebbe Stare?

**PRIMA (attuale)**:
```php
trait SchedaTrait {
    use FunctionExtra;  // ⚠️ Diretto in SchedaTrait
}
```

**DOPO (delegation)**:
```php
trait SchedaHelper {
    use FunctionExtra;  // ⚡ Delegato qui
}

trait SchedaTrait {
    use SchedaHelper;  // FunctionExtra incluso via SchedaHelper
}
```

## 🎯 Logica della Delegation

### Filosofia

**FunctionExtra contiene calcoli** → Deve stare con altri helper in SchedaHelper.

### Politica

**SchedaHelper = Aggregatore di TUTTI i calcoli puri**:
- Helper inline (34 metodi: getGgAnno, etc.)
- FunctionExtra (6 metodi: ggInSedeTot, etc.)

### Religione

**Separation of Concerns**: Tutti i calcoli in un posto, tutte le orchestrazioni in un altro.

## 📊 Struttura Finale Proposta

### SchedaHelper.php (HELPER AGGREGATOR)

```php
namespace Modules\Sigma\Models\Traits\Helpers;

use Modules\Sigma\Models\Traits\Extras\FunctionExtra;
use Modules\Sigma\Models\Traits\Extras\MassExtra;

trait SchedaHelper
{
    // ⚡ DELEGATION: Tutti i calcoli helper
    use FunctionExtra;  // gg*Tot, hh*Tot (6 metodi)
    use MassExtra;      // Massa calculations
    
    // Helper inline (34 metodi)
    protected function getGgAnno() { ... }
    public function getGgCatecoPosfunNoAsz() { ... }
    // ... altri 32
}
```

### SchedaTrait.php (ORCHESTRATOR FINALE)

```php
trait SchedaTrait
{
    // Domain-specific trait (delegation cascade)
    use Mutators\SchedaMutator;         // → Tutti mutator
    use Relationships\SchedaRelationship;  // → Tutte relazioni
    use Scopes\SchedaScope;              // → Tutti scope
    use Helpers\SchedaHelper;            // → FunctionExtra, MassExtra, helper inline
    
    // ⚠️ RIMUOVERE (delegati a SchedaHelper):
    // use FunctionExtra;  ← DA RIMUOVERE
    // use MassExtra;      ← DA RIMUOVERE
}
```

## 🎓 Benefici

### Consistency

**PRIMA**: Mix di helper inline + FunctionExtra diretto.

**DOPO**: Tutti helper aggregati in SchedaHelper.

### Discoverability

**Domanda**: "Dove trovo i calcoli giorni?"

**PRIMA**: "In SchedaHelper... o FunctionExtra... quale?"

**DOPO**: "In SchedaHelper (che include FunctionExtra)"

### Testability

**Test calcoli**:

**PRIMA**: Mock SchedaTrait → include tutto.

**DOPO**: Mock SchedaHelper → solo calcoli, focalizzato.

## 📚 Collegamenti

- [Delegation Cascade Pattern](./trait-delegation-cascade-pattern.md)
- [Phase 1 Success](./phase1-success-summary.md)
- [Performance N+1 Fix](../../performance/function-extra-n-plus-1-queries.md)

---

**Creato**: 29 Gennaio 2026  
**Insight**: FunctionExtra = Helper (non Utility)  
**Action**: Delegare FunctionExtra + MassExtra → SchedaHelper

