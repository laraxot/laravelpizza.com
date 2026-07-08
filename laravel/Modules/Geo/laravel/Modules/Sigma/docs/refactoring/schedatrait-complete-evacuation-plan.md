# SchedaTrait Complete Evacuation Plan

## 🎯 Obiettivo Finale

**SchedaTrait = Pure Composition ONLY**

Nessun metodo inline, solo:
- 4 `use` statement (delegation)
- 0 metodi (tutti delegati)

## 📋 Filosofia

**Religione**: "Trait composition is orchestration, not implementation"  
**Politica**: "Zero methods in orchestrator, 100% delegation"  
**Logica**: "Ogni metodo nel suo sottotrait specifico"  
**Scopo Business**: "SchedaTrait diventa mappa navigazionale, non implementazione"

## 🎯 Decisione Finale

**TUTTI i metodi vanno spostati nei sottotrait**:

1. **Accessor** (get*Attribute) → `SchedaMutator`
2. **Helper** (get*) → `SchedaHelper` (già fatto per 34, verificare rimanenti)
3. **Utility** (puntProgressioneFinale, funcYear, etc.) → Dove?

### Decisione Utility Methods

**Opzione A**: Creare `SchedaUtility.php`
**Opzione B**: Spostare in SchedaMutator (sono comunque metodi del modello)
**Opzione C**: Mantenere in SchedaTrait (eccezione per utility)

**Raccomandazione**: **Opzione B** - Utility in SchedaMutator (è comunque logica del modello).

## 📐 Target Finale

```php
<?php

namespace Modules\Sigma\Models\Traits;

/**
 * SchedaTrait - Pure Orchestrator (Zero Implementation).
 */
trait SchedaTrait
{
    use Mutators\SchedaMutator;
    use Relationships\SchedaRelationship;
    use Scopes\SchedaScope;
    use Helpers\SchedaHelper;
}
```

**Dimensione**: ~30 righe (solo composition + PHPDoc)

## 📊 Migration Matrix

| Metodi Tipo | Count | Destinazione | Status |
|-------------|-------|--------------|--------|
| Accessor | 83 | SchedaMutator | 📋 Prepared |
| Helper Protected | 8 | SchedaHelper | ⚠️ Duplicati |
| Helper Public | 11 | SchedaHelper | ⚠️ Duplicati |
| Utility | 5-6 | SchedaMutator | 📋 To Move |
| Setter | 1 | SchedaMutator | 📋 To Move |

**Totale da spostare**: ~109 metodi

---

**Creato**: 29 Gennaio 2026  
**Status**: 📋 PLAN DEFINITO  
**Next**: Evacuazione completa

