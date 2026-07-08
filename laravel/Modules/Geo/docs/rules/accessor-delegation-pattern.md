# 🔴 REGOLA SACRA: Accessor Delegation Pattern

> **Il metodo puro vive VICINO all'accessor, non in Helper separati**
> **Versione**: 1.0 (2026-04-01)
> **Stato**: ✅ VERIFICATO (22/22 accessor refactorizzati)

---

## La Regola

Quando scrivi un accessor Laravel `get<Nome>Attribute()`:

1. **Crea** un metodo puro `get<Nome>()` entro **50 righe** dall'accessor
2. **Metti** entrambi nello **stesso file** (MAI in Helper separati)
3. **Delega** il calcolo dall'accessor al metodo puro
4. **Documenta** con PHPDoc completo

---

## Pattern SACRO

```php
/**
 * Helper method: [Descrizione calcolo] (calcolo puro).
 *
 * Business Rule: [Spiegazione regola business]
 *
 * @return [Tipo]|[null] Risultato, null se [condizione]
 */
protected function get<Nome>(): [Tipo]|null
{
    // ✅ SOLO calcolo puro (max 50 righe)
    // Nessun update(), nessun save(), nessun side effect
}

/**
 * Accessor per <snake_case_nome> ([descrizione]).
 * Delega calcolo a get<Nome>().
 *
 * @param [Tipo]|null $value Valore cached dal DB
 *
 * @return [Tipo]|[null] Risultato calcolato
 */
protected function get<Nome>Attribute([Tipo]|null $value): [Tipo]|null
{
    // ✅ Cache hit
    if ([controllo tipo]) {
        return $value;
    }

    // ✅ Guard: modello deve avere PK
    if (null == $this->getKey()) {
        return null;
    }

    // ✅ Delega al metodo puro (VICINO!)
    $value = $this->get<Nome>();

    if (null === $value) {
        return null;
    }

    // ✅ Persist con update chirurgico
    $this->update(['<snake_case_nome>' => $value]);

    return $value;
}
```

---

## Perché VICINO?

### 1. Cognitive Load

```
❌ SEPARATO: 500+ righe tra accessor e metodo puro
✅ VICINO: 20-50 righe tra accessor e metodo puro

Risultato: 25x meno scrolling
```

### 2. AI Agent Context Window

```
❌ SEPARATO: 3700 righe di context (troppo!)
✅ VICINO: 50 righe di context (perfetto!)

Risultato: 74x più efficiente per AI agent
```

### 3. Multi-Agent Collaboration

```
❌ SEPARATO: Conflitti tra AI agent
✅ VICINO: Stesso contesto, meno conflitti

Risultato: Collaboration safe
```

---

## ❌ MAI FARE

```php
// MAI usare mixed come tipo
protected function getFooAttribute(mixed $value): mixed  // ❌

// MAI ignorare il parametro
protected function getFooAttribute(mixed $_value)  // ❌

// MAI ricalcolare SEMPRE
protected function getFooAttribute(?float $value): ?float
{
    return $this->complexCalculation();  // ❌ Ignora $value!
}

// MAI mettere il metodo puro in Helper separato
protected function getFooAttribute(?float $value): ?float
{
    return $this->getFoo();  // ❌ getFoo() è in SchedaHelper.php!
}
```

---

## ✅ SEMPRE FARE

```php
// SEMPRE usare tipo forte
protected function getFooAttribute(?float $value): ?float  // ✅

// SEMPRE controllare il valore
if (is_float($value)) {
    return $value;  // ✅
}

// SEMPRE mettere il metodo puro VICINO (entro 50 righe)
protected function getFoo(): ?float { ... }  // ✅ 20 righe PRIMA

// SEMPRE delegare dal metodo puro
$value = $this->getFoo();  // ✅

// SEMPRE documentare con PHPDoc
/**
 * Helper method: ...
 * @return ...
 */  // ✅
```

---

## Esempio Reale (Sigma Module)

```php
/**
 * Helper method: Calcola giorni fuori sede senza assenze (calcolo puro).
 *
 * Business Rule: Giorni fuori sede - (giorni assenza + ore assenza / 6).
 * Conversione ore in giorni: 6 ore = 1 giorno.
 *
 * @return float|null Giorni fuori sede netti, null se dati non disponibili
 */
protected function getGgFuoriSedeNoAsz(): ?float
{
    if (null == $this->gg_fuori_sede) {
        return null;
    }

    $gg_asz_fuori_sede = $this->gg_asz_fuori_sede ?? 0;
    $hh_asz_fuori_sede = $this->hh_asz_fuori_sede ?? 0;

    return (float) ($this->gg_fuori_sede - $gg_asz_fuori_sede - ($hh_asz_fuori_sede / 6));
}

/**
 * Accessor per gg_fuori_sede_no_asz (giorni fuori sede senza assenze).
 * Delega calcolo a getGgFuoriSedeNoAsz().
 *
 * @param float|null $value Valore cached dal DB
 *
 * @return float|null Giorni fuori sede netti calcolati
 */
protected function getGgFuoriSedeNoAszAttribute(?float $value): ?float
{
    // Cache hit
    if (null !== $value && ! request()->input('refresh', false)) {
        return $value;
    }

    // Guard: modello deve avere PK
    if (null == $this->getKey()) {
        return null;
    }

    // Delega calcolo al metodo puro (VICINO!)
    $value = $this->getGgFuoriSedeNoAsz();

    if (null === $value) {
        return null;
    }

    // Persist con update chirurgico
    $this->update(['gg_fuori_sede_no_asz' => $value]);

    return $value;
}
```

---

## Quality Gates

Dopo ogni refactoring:

- [ ] **PHPStan Level 10**: Nessun errore
- [ ] **PHPMD**: Nessun warning
- [ ] **PHPInsights**: Score > 90
- [ ] **Distanza**: Metodo puro entro 50 righe dall'accessor
- [ ] **Stesso File**: Entrambi nello stesso file
- [ ] **PHPDoc**: Completo per entrambi i metodi

---

## Riferimenti

- **Guida Completa**: `laravel/Modules/Sigma/docs/accessor-delegation-complete-guide.md`
- **Pattern**: `laravel/Modules/Sigma/docs/accessor-delegation-pattern.md`
- **Audit**: `laravel/Modules/Sigma/docs/accessor-delegation-audit.md`
- **Filosofia**: `laravel/Modules/Sigma/docs/accessor-mutator-philosophy.md`

---

*Regola creata: 2026-04-01*
*Ultimo aggiornamento: 2026-04-01*
*Stato: ✅ VERIFICATO (22/22 accessor refactorizzati)*
