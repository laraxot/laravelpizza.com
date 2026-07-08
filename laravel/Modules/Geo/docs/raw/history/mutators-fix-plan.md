# 📋 Mutators Fix Plan - Progetto Completo

> **Piano per correggere TUTTI i mutators con `mixed $value`**  
> **Aggiornato**: 2025-03-25  
> **Status**: IN PROGRESS

---

## 📊 Panoramica

**Totale mutators trovati**: 420  
**Mutators corretti (Livello 4)**: 15 ✅  
**Mutators da correggere (`mixed $value`)**: 27 ❌

---

## ✅ Già Corretti (15 mutators)

### 1. **Sigma - EnteMatrDateRangeMutator.php** ✅
- ✅ `getPercPTimeDaterangeAttribute`
- ✅ `getPercParttimeDalalAttribute`
- ✅ `getGgParttimevertDalalAttribute`
- ✅ `getGgPresenzaDalalAttribute`
- ✅ `getCategoriaEcoAttribute`

### 2. **Incentivi - StabiDirigente.php** ✅
- ✅ `getNomeStabiAttribute`
- ✅ `getStabiAttribute`
- ✅ `getReparAttribute`
- ✅ `getEnteAttribute`
- ✅ `getNomeDiriAttribute`

### 3. **IndennitaCondizioniLavoro - CondizioniLavoroIndennitaTipoDettaglioPivot.php** ✅
- ✅ `getTotAttribute`
- ✅ `getTotXPtimeAttribute`

### 4. **IndennitaResponsabilita - LettF.php** ✅
- ✅ `getTotAttribute`
- ✅ `getValoreEconomicoCalcolatoAttribute`
- ✅ `getValoreEconomicoAttribuitoAttribute`

---

## ❌ Da Correggere (27 mutators)

### Priorità 1: CRITICAL 🔴

#### **IndennitaCondizioniLavoro - CondizioniLavoro.php** (7 mutators)

| Riga | Mutator | Tipo | Note |
|------|---------|-----|------|
| 365 | `getDisci1Attribute(mixed $value): ?int` | ❌ | Usare `?int` |
| 377 | `getCodquaAttribute(mixed $value): int|string` | ❌ | Usare tipo specifico |
| 401 | `getAllIndennitaTipoAttribute(mixed $value): Collection` | ❌ | Relation - OK così |
| 456 | `getTotPresenzaPeriodoPlusNoTimbrAttribute(mixed $value): int` | ❌ | Usare `?int` |
| 466 | `getGgAssenzaAnnoAttribute(mixed $value): ?int` | ❌ | Usare `?int` |
| 489 | `getHhAssenzaAnnoAttribute(mixed $value): ?string` | ❌ | Usare `?string` |

**Azione**: Correggere con pattern Livello 4

#### **IndennitaCondizioniLavoro - ServizioEsterno.php** (1 mutator)

| Riga | Mutator | Tipo | Note |
|------|---------|-----|------|
| 335 | `getAllIndennitaTipoAttribute(mixed $value): Collection` | ❌ | Relation - OK così |

**Azione**: Probabilmente OK (è una relation)

---

### Priorità 2: HIGH 🟡

#### **Sigma - Asz00k1.php** (4 mutators)

| Riga | Mutator | Tipo | Note |
|------|---------|-----|------|
| 447 | `getAnnAttribute(mixed $value): string` | ❌ | Usare `?string` |
| 452 | `getAszdescrAttribute(mixed $value): string` | ❌ | Usare `?string` |
| 482 | `getProproAttribute(mixed $value): ?string` | ❌ | Usare `?string` |
| 518 | `getPosfunAttribute(mixed $value): ?string` | ❌ | Usare `?string` |

**Azione**: Correggere con pattern Livello 4

---

### Priorità 3: MEDIUM 🟢

#### **Sigma - Traits** (6 mutators)

| File | Riga | Mutator | Tipo |
|------|------|---------|-----|
| `EnteMatrMutator.php` | 295 | `getLastDataAssunzAttribute(mixed $_value): ?string` | ❌ |
| `EnteMatrAnnoMutator.php` | 16 | `getPercPTimeYearAttribute(mixed $_value): int|float` | ❌ |
| `EnteMatrAnnoMutator.php` | 154 | `getGgPTimeVertYearAttribute(mixed $_value): int|float` | ❌ |
| `SchedaExtraFieldTrait.php` | 1621 | `getAventiDirittoAttribute(mixed $_value): ?int` | ❌ |
| `SchedaExtraFieldTrait.php` | 1658 | `getAventiDirittoEffAttribute(mixed $_value): ?int` | ❌ |
| `SchedaTrait.php` | 1647 | `getAventiDirittoAttribute(mixed $_value): ?int` | ❌ |
| `SchedaTrait.php` | 1684 | `getAventiDirittoEffAttribute(mixed $_value): ?int` | ❌ |

**Azione**: Correggere con pattern Livello 4

---

#### **Sigma - Wmen00f.php** (6 mutators)

| Riga | Mutator | Tipo | Note |
|------|---------|-----|------|
| 140 | `getMndataAttribute(mixed $value): Carbon` | ❌ | Carbon - OK così |
| 160 | `getMnoratAttribute(mixed $value): Carbon` | ❌ | Carbon - OK così |
| 186 | `getMensaStartAttribute(mixed $value): mixed` | ❌ | Usare `?Carbon` |
| 201 | `getMensaEndAttribute(mixed $value): mixed` | ❌ | Usare `?Carbon` |
| 215 | `getDurataAttribute(mixed $value): int` | ❌ | Usare `?int` |
| 243 | `getPauseAttribute(mixed $value): Collection` | ❌ | Collection - OK così |

**Azione**: Alcuni sono OK (Carbon, Collection), correggere gli altri

---

#### **Sigma - Wstr02f.php** (2 mutators)

| Riga | Mutator | Tipo | Note |
|------|---------|-----|------|
| 258 | `getStdataAttribute(mixed $value): mixed` | ❌ | Usare tipo specifico |
| 291 | `getPauseAttribute(mixed $value): Collection` | ❌ | Collection - OK così |

---

#### **Sigma - Wgiu03f.php** (1 mutator)

| Riga | Mutator | Tipo | Note |
|------|---------|-----|------|
| 127 | `getStdataAttribute(mixed $value): mixed` | ❌ | Usare tipo specifico |

---

## 🧘 Pattern Livello 4

### Template da Applicare

```php
// ✅ CORRETTO - Livello 4
public function getAttribute(?float $value): ?float
{
    if (is_float($value)) {
        return $value;  // Cache DB
    }
    
    return $this->calculateAttribute();  // Delega
}

protected function calculateAttribute(): ?float
{
    // Calcolo complesso qui
}
```

### Eccezioni (NON correggere)

I seguenti mutators **NON** vanno corretti perché sono già corretti:

1. **Relations che ritornano Collection**:
   ```php
   public function getAllIndennitaTipoAttribute(mixed $value): Collection
   ```
   → OK così, è una relation

2. **Date/Carbon attributes**:
   ```php
   public function getMndataAttribute(mixed $value): Carbon
   ```
   → OK così, Laravel fa il casting automatico

3. **Attributes senza persistenza automatica**:
   ```php
   public function getAttribute(): float
   ```
   → OK se è solo calcolo, non serve persistenza

---

## 📅 Timeline

| Priorità | Moduli | Mutators | Deadline |
|----------|--------|----------|----------|
| **1 - CRITICAL** | IndennitaCondizioniLavoro | 8 | 2025-03-26 |
| **2 - HIGH** | Sigma (Asz00k1) | 4 | 2025-03-27 |
| **3 - MEDIUM** | Sigma (Traits, Models) | 15 | 2025-03-28 |

---

## ✅ Checklist

```markdown
## Mutators Fix Checklist

- [x] 1. IDENTIFICATI tutti i mutators con mixed
- [x] 2. CREATO piano di correzione
- [x] 3. CORRETTI 15 mutators (Livello 4)
- [ ] 4. CORREGGERE IndennitaCondizioniLavoro (8 mutators)
- [ ] 5. CORREGGERE Sigma/Asz00k1 (4 mutators)
- [ ] 6. CORREGGERE Sigma/Traits (6 mutators)
- [ ] 7. CORREGGERE Sigma/Wmen00f (6 mutators)
- [ ] 8. CORREGGERE Sigma/Wstr02f (2 mutators)
- [ ] 9. CORREGGERE Sigma/Wgiu03f (1 mutator)
- [ ] 10. ESEGUIRE PHPStan su tutti i file
- [ ] 11. ESEGUIRE Pest tests
- [ ] 12. AGGIORNARE documentazione
```

---

## 🔗 Riferimenti

- [docs/accessor-level-4-supreme.md](docs/accessor-level-4-supreme.md) - Pattern Livello 4
- [docs/accessor-enlightenment-complete.md](docs/accessor-enlightenment-complete.md) - Tutti i livelli
- [AGENTS.md](AGENTS.md) - Regole aggiornate

---

*Documento creato: 2025-03-25*  
*Ultimo aggiornamento: 2025-03-25*  
*Prossimo review: 2025-03-26*
