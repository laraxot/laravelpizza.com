# Audit Completo Accessor + Helper Methods - SchedaTrait

## Status

🔄 **IN CORSO** - Gennaio 2026  
✅ **Helper Creati**: 30/83 (36%)  
🎯 **Obiettivo**: 100% accessor con helper method corrispondente

## Filosofia e Business Logic

### Principio Fondamentale

> **Per ogni `get<Nome>Attribute()` DEVE esistere `protected function get<Nome>()`**

**Perché?**
- **Testabilità**: Logica isolata, testabile senza DB
- **Riusabilità**: Helper chiamabile da altri contesti
- **Manutenibilità**: Separazione responsabilità chiara
- **KISS**: Accessor template-based, logica nel helper

### Pattern Applicato

```php
// 1. Helper = SOLO calcolo
protected function get<Nome>(): ?type
{
    // Guard clauses
    // Pure calculation
    return $result;
}

// 2. Accessor = Orchestrazione
public function get<Nome>Attribute(?type $value): ?type
{
    // Cache check
    // getKey() guard
    // Delega a helper
    // update() chirurgico
    return $value;
}
```

## Analisi Accessor (83 totali)

### ✅ Con Helper Method (30)

**Già completati**:
1. `getGgIntegParamsAsz()` → `getGgIntegParamsAszAttribute()`
2. `getGgEsperienzaNoAsz()` → `getGgEsperienzaNoAszAttribute()`
3. `getGgCatecoPosfunNoAsz()` → `getGgCatecoPosfunNoAszAttribute()`
4. `getPosfunval()` → `getPosfunvalAttribute()`
5. `getGgAsz()` → `getGgAszAttribute()`
6. `getGgNoAsz()` → `getGgNoAszAttribute()`
7. `getGgFuoriSedeNoAsz()` → `getGgFuoriSedeNoAszAttribute()`
8. `getHhAsz()` → `getHhAszAttribute()`
9. `getHhAszInSede()` → `getHhAszInSedeAttribute()`
10. `getHhAszFuoriSede()` → `getHhAszFuoriSedeAttribute()`
11. `getGgCatecoNoAsz()` → `getGgCatecoNoAszAttribute()`
12. `getPropro()` → `getProproAttribute()`
13. `getGgCatecoSupInSede()` → `getGgCatecoSupInSedeAttribute()`
14. `getGgCatecoNoPosfunNoAsz()` → `getGgCatecoNoPosfunNoAszAttribute()`
15. `getGgCatecoInSede()` → `getGgCatecoInSedeAttribute()`
16. `getGgCateco()` → `getGgCatecoAttribute()`
17. `getGgCatecoPosfunInSede()` → `getGgCatecoPosfunInSedeAttribute()`
18. `getGgAszCatecoPosfunFuoriSede()` → `getGgAszCatecoPosfunFuoriSedeAttribute()`
19. `getGgCatecoSupFuoriSede()` → `getGgCatecoSupFuoriSedeAttribute()`
20. `getGgCatecoFuoriSede()` → `getGgCatecoFuoriSedeAttribute()`
21. `getGgCatecoPosfunFuoriSede()` → `getGgCatecoPosfunFuoriSedeAttribute()`
22. `getGgAssenzaAnno()` → `getGgAssenzaAnnoAttribute()`
23. `getTotalePond()` → `getTotalePondAttribute()`
24. `getValutatoreId()` → `getValutatoreIdAttribute()`
25. `getPtime()` → `getPtimeAttribute()`
26. `getGgInSede()` → `getGgInSedeAttribute()`
27. `getGgInSedeNoAsz()` → `getGgInSedeNoAszAttribute()`
28. `getGgPresenzaAnno()` → `getGgPresenzaAnnoAttribute()`
29. `getGgAnno()` → `getGgAnnoAttribute()`
30. `getGgFuoriSede()` → `getGgFuoriSedeAttribute()`
31. `getGgPosiz1InSede()` → `getGgPosiz1InSedeAttribute()`
32. `getPerfIndMedia()` → `getPerfIndMediaAttribute()`
33. `getPerfIndCountLast3Years()` → `getPerfIndCountLast3YearsAttribute()`
34. `getGgCatecoPosfun()` → `getGgCatecoPosfunAttribute()`

**Nuovi Gennaio 2026**:
35. `getGgAszInSede()` → `getGgAszInSedeAttribute()` ⚡
36. `getGgAszFuoriSede()` → `getGgAszFuoriSedeAttribute()` ⚡
37. `getGgAszCateco()` → `getGgAszCatecoAttribute()` ⚡
38. `getGgAszCatecoInSede()` → `getGgAszCatecoInSedeAttribute()` ⚡

### ❌ Senza Helper Method (45)

**Accessor Complessi da Refactorare (32)**:
1. `getGgAszCatecoFuoriSedeAttribute` - COMPLEXITY:5, UPDATE:1
2. `getGgCatecoPosfunInSedeNoAszAttribute` - COMPLEXITY:5, UPDATE:0
3. `getGgAspettativePondInsedeAttribute` - COMPLEXITY:1, UPDATE:1
4. `getGgAszCatecoPosfunAttribute` - COMPLEXITY:2, UPDATE:1
5. `getCategoriaEcoAttribute` - COMPLEXITY:4, UPDATE:1 (commentato)
6. `getPosizAttribute` - COMPLEXITY:5, UPDATE:1 (moved to SchedaMutator)
7. `getPosizTxtAttribute` - COMPLEXITY:6, UPDATE:2 (commentato)
8. `getGgAttribute` - COMPLEXITY:5, UPDATE:1 (inline semplice: gg_in_sede + gg_fuori_sede)
9. `getPostTypeAttribute` - COMPLEXITY:6, UPDATE:0 (logica tipo scheda, inline OK)
10. `getValutatoreTxtAttribute` - COMPLEXITY:6, UPDATE:0 (semplice getter da relazione)
11. `getPosizioneAttribute` - COMPLEXITY:6, UPDATE:0 (count query, inline OK)
12. ... altri 21 accessor

**Accessor Semplici (Getter) - NON necessitano helper (13)**:
1. `getListaProproAttribute` - `return optional($this->categoriaPropro)->lista_propro;`
2. `getListaProproSupAttribute` - `return optional($this->categoriaPropro)->lista_propro_sup;`
3. `getImportoStipendioAnnuoAttribute` - Getter da relazione
4. `getAventiDirittoAttribute` - Computed property semplice
5. `getAventiDirittoEffAttribute` - Computed property semplice
6. ... altri 8 accessor getter

## Classificazione per Priorità

### P0 - CRITICI (Con update() e logica complessa) - 10 accessor

**Già Completati (4)**:
- ✅ `getGgAszInSedeAttribute` → `getGgAszInSede()`
- ✅ `getGgAszFuoriSedeAttribute` → `getGgAszFuoriSede()`
- ✅ `getGgAszCatecoAttribute` → `getGgAszCateco()`
- ✅ `getGgAszCatecoInSedeAttribute` → `getGgAszCatecoInSede()`

**Da Completare (6)**:
- ❌ `getGgAszCatecoFuoriSedeAttribute` → Necessita `getGgAszCatecoFuoriSede()`
- ❌ `getGgAspettativePondInsedeAttribute` → Necessita `getGgAspettativePondInsede()`
- ❌ `getGgAszCatecoPosfunAttribute` → Necessita `getGgAszCatecoPosfun()`
- ❌ `getGgCatecoPosfunInSedeNoAszAttribute` → Necessita `getGgCatecoPosfunInSedeNoAsz()`  
- ❌ `getDisci1Attribute` → Necessita `getDisci1()` (se non moved to SchedaMutator)
- ❌ `getCategoriaEcovalAttribute` → Necessita `getCategoriaEcoval()`

### P1 - MEDI (Logica inline media) - 15 accessor

**Con calcolo inline che potrebbe beneficiare di helper**:
- `getGgAttribute` - Somma semplice ma ripetuta
- `getExcellencesCountLast3yearsAttribute` - Query count
- ... altri 13

### P2 - BASSI (Getter semplici) - 13 accessor

**NON necessitano helper** (sono getter puri da relazioni/proprietà):
- `getListaProproAttribute`
- `getListaProproSupAttribute`
- `getImportoStipendioAnnuoAttribute`
- ... altri 10

## Metriche Refactoring

**Stato Attuale**:
- Accessor totali: 83
- Helper creati: 38 (46%)
- Con update(): 48 (tutti convertiti da save())
- Rimanenti da refactorare: 45 (54%)

**Obiettivo Finale**:
- Helper necessari: ~70 (escludendo 13 getter semplici)
- Progresso verso obiettivo: 38/70 = 54%

## Collegamenti

- [Accessor Refactoring Philosophy](./accessor-refactoring-philosophy.md)
- [save() vs update() Pattern](./save-vs-update-in-accessors.md)
- [getKey() Check Pattern](./accessor-getkey-check-pattern.md)

---

**Creato**: Gennaio 2026  
**Status**: 🔄 IN CORSO  
**Prossimo**: Completare P0 (6 accessor critici rimanenti)

