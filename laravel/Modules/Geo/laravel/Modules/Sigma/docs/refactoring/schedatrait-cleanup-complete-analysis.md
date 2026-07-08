# SchedaTrait Cleanup: Analisi Completa dei Duplicati

## 🎯 Problema Identificato

**SchedaTrait ha ancora 2881 righe!**

**Atteso dopo delegation**: ~50-200 righe (solo composition + utility).

**Conclusione**: Ci sono **DUPLICATI** che devono essere rimossi.

## 🔍 Filosofia del Cleanup

### Religione

**"Un metodo, un posto"** - Se è in SchedaHelper, DEVE essere rimosso da SchedaTrait.

### Politica

**SchedaTrait = Zero Implementation** - Solo `use` statements + utility methods.

### Logica

**Trait composition risolve i metodi** - PHP include i metodi dai trait usati, quindi:
- Se SchedaTrait usa SchedaHelper
- E SchedaHelper ha getGgAnno()
- Allora SchedaTrait HA getGgAnno() (via trait)
- = Non serve duplicare in SchedaTrait!

### Scopo Business

**Manutenibilità** - Modifiche ai calcoli vanno fatte in UN SOLO posto (SchedaHelper).

## 📋 Cosa Rimuovere da SchedaTrait

### 1. Helper Protected (23) - DUPLICATI

Questi sono GIÀ in SchedaHelper → **DA RIMUOVERE completamente**:

```
protected function getGgAnno() { ... }           ← DUPLICATO, rimuovi
protected function getGgFuoriSede() { ... }      ← DUPLICATO, rimuovi
protected function getGgPresenzaAnno() { ... }   ← DUPLICATO, rimuovi
protected function getGgAssenzaAnno() { ... }    ← DUPLICATO, rimuovi
protected function getPtime() { ... }            ← DUPLICATO, rimuovi
protected function getGgInSede() { ... }         ← DUPLICATO, rimuovi
protected function getGgAsz() { ... }            ← DUPLICATO, rimuovi
protected function getHhAsz() { ... }            ← DUPLICATO, rimuovi
protected function getTotalePond() { ... }       ← DUPLICATO, rimuovi
protected function getGgIntegParamsAsz() { ... } ← DUPLICATO, rimuovi
protected function getGgEsperienzaNoAsz() { ... } ← DUPLICATO, rimuovi
protected function getGgNoAsz() { ... }          ← DUPLICATO, rimuovi
protected function getGgCatecoNoAsz() { ... }    ← DUPLICATO, rimuovi
protected function getGgInSedeNoAsz() { ... }    ← DUPLICATO, rimuovi
protected function getPosfunval() { ... }        ← DUPLICATO, rimuovi
protected function getGg() { ... }               ← DUPLICATO, rimuovi
protected function getGgAszInSede() { ... }      ← DUPLICATO, rimuovi
protected function getGgAszFuoriSede() { ... }   ← DUPLICATO, rimuovi
protected function getGgAszCateco() { ... }      ← DUPLICATO, rimuovi
protected function getGgAszCatecoInSede() { ... } ← DUPLICATO, rimuovi
protected function getValutatoreId() { ... }     ← DUPLICATO, rimuovi
protected function getPerfIndMedia() { ... }     ← DUPLICATO, rimuovi
protected function getGgCatecoSupInSede() { ... } ← DUPLICATO, rimuovi (se esiste)
```

### 2. Helper Public (12) - DUPLICATI

Questi sono GIÀ in SchedaHelper → **DA RIMUOVERE completamente**:

```
public function getGgCatecoPosfunNoAsz() { ... }  ← DUPLICATO, rimuovi
public function getGgAszCatecoPosfunInSede() { ... } ← DUPLICATO, rimuovi
public function getPropro() { ... }               ← DUPLICATO, rimuovi
public function getGgCatecoPosfun() { ... }       ← DUPLICATO, rimuovi
public function getGgCatecoInSede() { ... }       ← DUPLICATO, rimuovi
public function getGgCateco() { ... }             ← DUPLICATO, rimuovi
public function getGgCatecoPosfunInSede() { ... } ← DUPLICATO, rimuovi
public function getGgAszCatecoPosfunFuoriSede() { ... } ← DUPLICATO, rimuovi
public function getGgCatecoFuoriSede() { ... }    ← DUPLICATO, rimuovi
public function getGgCatecoPosfunFuoriSede() { ... } ← DUPLICATO, rimuovi
public function getCriteriOptions() { ... }       ← VERIFICARE se utility
public function getGgIntegParams() { ... }        ← DUPLICATO, rimuovi
```

### 3. Accessor (83) - DA SPOSTARE

Questi devono andare in SchedaMutator:

```
public function getGgIntegParamsAszAttribute() { ... } → SchedaMutator
public function getGgEsperienzaNoAszAttribute() { ... } → SchedaMutator
public function getGgCatecoPosfunNoAszAttribute() { ... } → SchedaMutator
// ... altri 80 accessor
```

### 4. Utility (6) - DA MANTENERE

Questi rimangono in SchedaTrait (non sono helper):

```
✅ public function puntProgressioneFinale(): float
✅ public function setPuntProgressioneFinaleAttribute(?float $value): void
✅ public function funcYear(string $func, ?float $value): ?float
✅ public function perfIndMedia(): ?float
✅ public function excellencesCountLast3years(): int
✅ public function criteriOptionsArr(string $name): mixed
```

## 📊 Target Post-Cleanup

**SchedaTrait dovrebbe avere**:
```php
trait SchedaTrait
{
    // 4 use statements (delegation)
    use Mutators\SchedaMutator;
    use Relationships\SchedaRelationship;
    use Scopes\SchedaScope;
    use Helpers\SchedaHelper;
    
    // 6 utility methods
    public function puntProgressioneFinale() { ... }
    public function setPuntProgressioneFinaleAttribute() { ... }
    public function funcYear() { ... }
    public function perfIndMedia() { ... }
    public function excellencesCountLast3years() { ... }
    public function criteriOptionsArr() { ... }
}
```

**Dimensione finale attesa**: ~150-250 righe (da 2881!)

## 🎯 Piano di Implementazione

### Step 1: Rimuovere Helper Duplicati (35 metodi)

**Strategia**: Rimozione sistematica con search_replace.

**Stima**: ~1500 righe rimosse.

### Step 2: Spostare Accessor in SchedaMutator (83 metodi)

**Strategia**: Estrazione sistematica + merge in SchedaMutator.

**Stima**: ~1200 righe spostate.

### Step 3: Cleanup Finale

**Mantenere**:
- 4 use statements
- 6 utility methods
- PHPDoc

**Stima finale**: ~200 righe.

## 📚 Collegamenti

- [Ultimate Success Report](./ultimate-success-report.md)
- [Phase 2 Roadmap](./phase2-accessor-migration-roadmap.md)

---

**Creato**: 29 Gennaio 2026  
**Status**: 📋 ANALISI COMPLETA  
**Next**: Rimozione sistematica duplicati

