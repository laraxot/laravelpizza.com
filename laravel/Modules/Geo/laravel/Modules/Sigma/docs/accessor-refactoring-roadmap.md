# Accessor Refactoring Roadmap - SchedaTrait

## Executive Summary

**Obiettivo**: Refactorare 73 accessor per implementare il pattern "Accessor → Metodo Puro"

**Rationale**:
- Separazione responsabilità (SRP)
- Testabilità migliorata
- Riusabilità logica di calcolo
- Manutenibilità a lungo termine

**Approccio**: Incrementale, prioritizzato, testato

## Statistiche Attuali

### Stato Corrente
- **Accessor totali**: 83
- **Metodi puri esistenti**: 12 (14%)
- **Accessor da refactorare**: 71 (86%)

### Metodi Puri Già Implementati ✅

1. `getGgCatecoPosfunNoAsz()` (linea 55)
2. `getGgAszCatecoPosfunInSede()` (linea 629)
3. `getPropro()` (linea 702)
4. `getGgCatecoPosfun()` (linea 784)
5. `getGgCatecoInSede()` (linea 935)
6. `getGgCateco()` (linea 980)
7. `getGgCatecoPosfunInSede()` (linea 1002)
8. `getGgAszCatecoPosfunFuoriSede()` (linea 1069)
9. `getGgCatecoFuoriSede()` (linea 1133)
10. `getGgCatecoPosfunFuoriSede()` (linea 1177)
11. `getCriteriOptions()` (linea 2238)
12. `getGgIntegParams()` (linea 2258)

**Nota**: Questi accessor HANNO GIÀ il pattern corretto! Sono da usare come template.

## Lista Accessor da Refactorare

### 🔴 Priorità CRITICA (10 accessor)

Questi causano o possono causare errori "Duplicate Entry":

1. **getPerfIndMediaAttribute** (linea ~1990)
   - Calcola: Media performance ultimi 3 anni
   - Complessità: ALTA (aggregazione multi-anno)
   - Impatto: Valutazioni dipendenti
   - **Azione**: Estrarre → `getPerfIndMedia()`

2. **getGgAnnoAttribute** (linea ~1776)
   - Calcola: Giorni effettivi annui
   - Formula: `gg_presenza_anno - gg_assenza_anno`
   - **Azione**: Estrarre → `getGgAnno()`

3. **getGgPresenzaAnnoAttribute** (linea ~1760)
   - Calcola: Giorni presenza annuale
   - Usa: Query aggregata su timbrature
   - **Azione**: Estrarre → `getGgPresenzaAnno()`

4. **getGgAssenzaAnnoAttribute** (linea ~1223)
   - Calcola: Giorni assenza annuale
   - Usa: Query aggregata su assenze
   - **Azione**: Estrarre → `getGgAssenzaAnno()`

5. **getGgInSedeAttribute** (linea ~1697)
   - Calcola: Giorni presenza in sede
   - **Azione**: Refactorare per usare `getGgInSede()` (già esiste? Verificare)

6. **getGgFuoriSedeAttribute** (linea ~1800)
   - Calcola: Giorni presenza fuori sede
   - **Azione**: Estrarre → `getGgFuoriSede()`

7. **getGgAszAttribute** (linea ~271)
   - Calcola: Totale giorni assenza
   - Formula: `gg_asz_in_sede + gg_asz_fuori_sede`
   - **Azione**: Estrarre → `getGgAsz()`

8. **getHhAszAttribute** (linea ~352)
   - Calcola: Totale ore assenza
   - **Azione**: Estrarre → `getHhAsz()`

9. **getTotalePondAttribute** (linea ~1560)
   - Calcola: Totale ponderato valutazione
   - Complessità: ALTA (formula complessa)
   - **Azione**: Estrarre → `getTotalePond()`

10. **getValutatoreIdAttribute** (linea ~1636)
    - Calcola: ID valutatore competente
    - Logica: Lookup gerarchico
    - **Azione**: Estrarre → `getValutatoreId()`

### 🟠 Priorità ALTA (15 accessor)

Calcoli frequenti, logica media-complessa:

11. **getGgIntegParamsAszAttribute** (linea 65) → `getGgIntegParamsAsz()`
12. **getGgEsperienzaNoAszAttribute** (linea 93) → `getGgEsperienzaNoAsz()`
13. **getGgCatecoNoAszAttribute** (linea 676) → `getGgCatecoNoAsz()`
14. **getGgCatecoPosfunNoAszAttribute** (linea 119) → Usa già `getGgCatecoPosfunNoAsz()` ✅
15. **getGgNoAszAttribute** (linea 302) → `getGgNoAsz()`
16. **getGgAszInSedeAttribute** (linea 472) → `getGgAszInSede()`
17. **getGgAszFuoriSedeAttribute** (linea 516) → `getGgAszFuoriSede()`
18. **getGgAszCatecoAttribute** (linea 559) → `getGgAszCateco()`
19. **getGgAszCatecoInSedeAttribute** (linea 585) → `getGgAszCatecoInSede()`
20. **getGgAszCatecoPosfunInSedeAttribute** (linea 661) → Usa già `getGgAszCatecoPosfunInSede()` ✅
21. **getGgCatecoNoPosfunNoAszAttribute** (linea ~850) → `getGgCatecoNoPosfunNoAsz()`
22. **getGgInSedeNoAszAttribute** (linea ~1734) → `getGgInSedeNoAsz()`
23. **getGgPosiz1InSedeAttribute** (linea ~1814) → `getGgPosiz1InSede()`
24. **getHhAszInSedeAttribute** (linea 383) → `getHhAszInSede()`
25. **getHhAszFuoriSedeAttribute** (linea 427) → `getHhAszFuoriSede()`

### 🟡 Priorità MEDIA (25 accessor)

Calcoli specifici categoria economica/posizione:

26-35. **Accessor Categoria Economica**:
   - getGgCatecoSupAttribute → `getGgCatecoSup()`
   - getGgCatecoSupInSedeAttribute → `getGgCatecoSupInSede()`
   - getGgCatecoSupFuoriSedeAttribute → `getGgCatecoSupFuoriSede()`
   - getCategoriaEcoAttribute → `getCategoriaEco()`
   - getCategoriaEcovalAttribute → `getCategoriaEcoval()`
   - ... (altri 5 accessor categoria)

36-45. **Accessor Posizione Funzionale**:
   - getPosfunvalAttribute → `getPosfunval()`
   - getPosizAttribute → `getPosiz()`
   - getPosizTxtAttribute → `getPosizTxt()`
   - getPosizioneAttribute → `getPosizione()`
   - ... (altri 6 accessor posizione)

46-50. **Accessor Performance Anni Specifici**:
   - getPerfInd2023Attribute → `getPerfInd2023()`
   - getPerfInd2024Attribute → `getPerfInd2024()`
   - getPerfInd2025Attribute → `getPerfInd2025()`
   - ... (altri accessor anni)

### 🟢 Priorità BASSA (23 accessor)

Logica semplice o deprecata:

51-73. **Accessor Vari**:
   - getGgFuoriSedeNoAszAttribute
   - getGgAszTipCodEsclusoSubitoAttribute
   - getCostoFasciaUpAttribute
   - getPtimeAttribute
   - getValoreDifferenzialeRapportatoPtAttribute
   - ... (altri 18 accessor)

## Template Refactoring

### Step-by-Step per Ogni Accessor

```php
// STEP 1: Analizza l'accessor corrente
public function getGgInSedeAttribute(?int $value): ?int
{
    if (null !== $value && ! request()->input('refresh', 0)) {
        return $value;
    }
    if (null == $this->getKey()) return null;
    
    // QUESTA È LA LOGICA DA ESTRARRE ↓
    if (null == $this->matr) return null;
    if (null == $this->qua2kd) return null;
    
    $parz = [
        'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
        'date_max' => $this->criteriOptionsArr('data_presenza_al'),
    ];
    $data = GgFilterData::from($parz);
    $value = $this->anag?->ggInSedeTot($data);
    // LOGICA DA ESTRARRE ↑
    
    $this->gg_in_sede = $value;
    $this->save();
    return $value;
}

// STEP 2: Estrai la logica in metodo protected
/**
 * Calcola giorni presenza in sede.
 * 
 * @return int|null
 */
protected function getGgInSede(): ?int
{
    // Guard clauses
    if (null == $this->matr) {
        return null;
    }
    
    if (null == $this->qua2kd) {
        return null;
    }
    
    // Pure calculation
    $parz = [
        'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
        'date_max' => $this->criteriOptionsArr('data_presenza_al'),
    ];
    $data = GgFilterData::from($parz);
    
    return $this->anag?->ggInSedeTot($data);
}

// STEP 3: Semplifica l'accessor
/**
 * Accessor per gg_in_sede.
 * Delega calcolo a getGgInSede().
 * 
 * @param int|null $value
 * @return int|null
 */
public function getGgInSedeAttribute(?int $value): ?int
{
    // Cache hit
    if (null !== $value && ! request()->input('refresh', 0)) {
        return $value;
    }
    
    // Guard PK
    if (null == $this->getKey()) {
        return null;
    }
    
    // Delegate
    $value = $this->getGgInSede();
    
    if (null === $value) {
        return null;
    }
    
    // Persist
    $this->gg_in_sede = $value;
    $this->save();
    
    return $value;
}

// STEP 4: Test metodo puro
test('calcola gg in sede correttamente', function () {
    $scheda = Scheda::factory()->make([
        'matr' => 123,
        'qua2kd' => '2025-01-01',
    ]);
    
    $giorni = $scheda->getGgInSede();
    
    expect($giorni)->toBeInt();
});
```

## Piano di Implementazione

### Settimana 1: Critici + Template

**Giorni 1-2** (Lunedì-Martedì):
- [x] Documentazione filosofia pattern
- [x] Analisi stato attuale
- [ ] Refactoring accessor critici (1-5)
- [ ] Test per ogni refactoring
- [ ] Code review interno

**Giorni 3-4** (Mercoledì-Giovedì):
- [ ] Refactoring accessor critici (6-10)
- [ ] Integration testing
- [ ] Monitoring produzione
- [ ] Fix eventuali regression

**Giorno 5** (Venerdì):
- [ ] Retrospettiva settimana 1
- [ ] Aggiornamento documentazione
- [ ] Planning settimana 2

### Settimana 2-3: Priorità Alta

**Obiettivo**: 15 accessor priorità alta

**Approccio**:
- 5 accessor/giorno
- Test automatizzati per ognuno
- Review ogni batch di 5

### Settimana 4-5: Priorità Media

**Obiettivo**: 25 accessor priorità media

**Approccio**:
- 5 accessor/giorno
- Pattern ormai consolidato
- Automazione parziale possibile

### Settimana 6: Priorità Bassa + Cleanup

**Obiettivo**: 23 accessor priorità bassa

**Approccio**:
- Batch refactoring
- Cleanup codice commentato
- Documentazione finale

## Automation Strategy

### Script di Generazione Stub

```php
// Command: php artisan sigma:generate-pure-methods

foreach ($accessorList as $accessor) {
    $methodName = str_replace('Attribute', '', $accessor);
    $logic = $this->extractLogicFromAccessor($accessor);
    
    $stub = <<<PHP
    /**
     * Calcola {$this->humanize($methodName)}.
     * 
     * @return mixed
     */
    protected function {$methodName}(): mixed
    {
        {$logic}
    }
    PHP;
    
    $this->generatedStubs[] = $stub;
}

// Output per review manuale prima dell'applicazione
```

### Validation Script

```bash
#!/bin/bash
# Verifica che ogni accessor abbia il metodo puro corrispondente

for accessor in $(grep "public function get.*Attribute(" SchedaTrait.php | \
                   sed 's/.*function \(get.*\)Attribute.*/\1/'); do
    
    # Cerca metodo puro
    if ! grep -q "function ${accessor}():" SchedaTrait.php; then
        echo "❌ Missing pure method for: ${accessor}"
    else
        echo "✅ ${accessor} has pure method"
    fi
done
```

## Metriche di Successo

### KPI Tecnici

| Metrica | Prima | Target | Attuale |
|---------|-------|--------|---------|
| Accessor con metodo puro | 12 (14%) | 83 (100%) | 12 (14%) |
| Cyclomatic complexity avg | 8-12 | 3-5 | 8-12 |
| Test coverage calcoli | ~30% | >80% | ~30% |
| Metodi riutilizzabili | 12 | 83 | 12 |
| Linee codice duplicate | ~2000 | <500 | ~2000 |

### KPI Qualitativi

- **Leggibilità**: Da "Confuso" a "Cristallino"
- **Manutenibilità**: Da "Difficile" a "Facile"
- **Testabilità**: Da "Complesso" a "Semplice"
- **Onboarding**: Da "3 giorni" a "3 ore"

## Checklist per Ogni Refactoring

### Prima di Iniziare
- [ ] Leggere accessor attuale completamente
- [ ] Comprendere business logic
- [ ] Identificare dipendenze (altri accessor chiamati)
- [ ] Verificare test esistenti

### Durante Refactoring
- [ ] Estrarre logica in metodo protected
- [ ] Semplificare accessor a template
- [ ] Aggiungere PHPDoc completo
- [ ] Gestire edge cases

### Dopo Refactoring
- [ ] Scrivere test metodo puro
- [ ] Verificare test accessor esistenti passano
- [ ] Code review
- [ ] Update documentazione
- [ ] Commit con messaggio descrittivo

### Validation
- [ ] PHPStan livello 10 passa
- [ ] Tutti i test passano
- [ ] No regression in produzione
- [ ] Performance non degradate

## Esempi Completi

### Esempio 1: getGgAnnoAttribute (Semplice)

**PRIMA**:
```php
public function getGgAnnoAttribute(?int $value): ?int
{
    if (null !== $value && ! request()->input('refresh', false)) {
        return $value;
    }

    $value = $this->gg_presenza_anno - $this->gg_assenza_anno;
    $this->gg_anno = $value;

    if (null == $this->getKey()) {
        return $value;
    }

    $this->save();

    return $value;
}
```

**DOPO**:
```php
/**
 * Calcola giorni effettivi annui.
 * 
 * Business Rule: Giorni anno = giorni presenza - giorni assenza
 * 
 * @return int|null
 */
protected function getGgAnno(): ?int
{
    if (null === $this->gg_presenza_anno || null === $this->gg_assenza_anno) {
        return null;
    }
    
    return $this->gg_presenza_anno - $this->gg_assenza_anno;
}

/**
 * Accessor per gg_anno.
 * Delega calcolo a getGgAnno().
 * 
 * @param int|null $value
 * @return int|null
 */
public function getGgAnnoAttribute(?int $value): ?int
{
    // Cache
    if (null !== $value && ! request()->input('refresh', false)) {
        return $value;
    }
    
    // Guard PK
    if (null == $this->getKey()) {
        return null;
    }
    
    // Delegate
    $value = $this->getGgAnno();
    
    if (null === $value) {
        return null;
    }
    
    // Persist
    $this->gg_anno = $value;
    $this->save();
    
    return $value;
}
```

### Esempio 2: getPerfIndMediaAttribute (Complesso)

**PRIMA**:
```php
public function getPerfIndMediaAttribute(?float $value): ?float
{
    if (null !== $value && ! request()->input('refresh', 0)) {
        return round($value, 2);
    }

    if (null == $this->getKey()) {
        return null;
    }

    // ❌ LOGICA INLINE (complessa!)
    $value = $this->perfIndMedia(); // Chiama altro metodo esistente
    
    $this->perf_ind_media = $value;
    $this->save();

    return $value;
}
```

**DOPO**:
```php
/**
 * Calcola media performance individuale ultimi 3 anni.
 * 
 * Business Rule: Media aritmetica performance anni -3, -2, -1 rispetto anno scheda.
 * CCNL Art. 19: Progressione basata su media triennale performance.
 * 
 * @return float|null Media performance, null se dati insufficienti
 */
protected function getPerfIndMedia(): ?float
{
    // Delega a metodo esistente
    return $this->perfIndMedia();
}

/**
 * Accessor per perf_ind_media.
 * Delega calcolo a getPerfIndMedia().
 * 
 * @param float|null $value
 * @return float|null
 */
public function getPerfIndMediaAttribute(?float $value): ?float
{
    // Cache (con round per consistenza)
    if (null !== $value && ! request()->input('refresh', 0)) {
        return round($value, 2);
    }
    
    // Guard PK
    if (null == $this->getKey()) {
        return null;
    }
    
    // Delegate
    $value = $this->getPerfIndMedia();
    
    if (null === $value) {
        return null;
    }
    
    // Persist
    $this->perf_ind_media = $value;
    $this->save();
    
    return round($value, 2);
}
```

## Risk Management

### Rischi Identificati

**1. Breaking Changes**
- **Rischio**: Cambio signature metodi
- **Mitigazione**: Mantenere backward compatibility, solo aggiungere metodi

**2. Performance Degradation**
- **Rischio**: Overhead chiamate metodi addizionali
- **Mitigazione**: PHP opcode cache, benchmark prima/dopo

**3. Regression Bugs**
- **Rischio**: Logica estratta incorrettamente
- **Mitigazione**: Test coverage >80%, review manuale

**4. Team Confusion**
- **Rischio**: Pattern nuovo non compreso
- **Mitigazione**: Documentazione estesa, esempi chiari

## Success Criteria

### Definizione di "Done"

Un accessor è considerato completamente refactorato quando:

- ✅ Ha metodo puro protected corrispondente
- ✅ Accessor usa template pattern standard
- ✅ PHPDoc completo su entrambi i metodi
- ✅ Test unitario per metodo puro
- ✅ Test integrazione per accessor
- ✅ PHPStan livello 10 passa
- ✅ Performance equivalente o migliore
- ✅ Documentato in commit message

## Collegamenti

### Documentazione
- [Filosofia Refactoring](./accessor-refactoring-philosophy.md)
- [Pattern Accessor](./scheda-trait-accessor-pattern.md)
- [Business Logic](./business-logic-analysis.md)

### Code Reference
- [SchedaTrait.php](../app/Models/Traits/SchedaTrait.php)
- [Scheda.php](../app/Models/Scheda.php)

### Testing
- [Test Strategy](./testing-strategy.md)
- [SchedaTest.php](../tests/Feature/Models/SchedaTest.php)

---

**Creato**: 2025-01-29  
**Status**: 📋 Piano Operativo Completo  
**Prossimo Step**: Iniziare refactoring accessor critici (1-5)  
**Estimated Time**: 6 settimane (5 accessor/settimana)

