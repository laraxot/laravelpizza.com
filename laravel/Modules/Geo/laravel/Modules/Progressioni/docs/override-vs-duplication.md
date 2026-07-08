# Override vs Duplicazione - Lesson Learned

## Errore di Analisi Iniziale

### Cosa È Successo

Durante il refactoring di `Progressioni.php`, ho erroneamente identificato `getActivitylogOptions()` come **duplicazione** del metodo presente in `BaseScheda`.

### Perché Ho Sbagliato

**Analisi Superficiale**:
```php
// BaseScheda
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logAll()  // ← Non ho notato che era ATTIVO
        ->logOnlyDirty();
}

// Progressioni
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        //->logAll()  // ← Non ho notato che era COMMENTATO
        ->logOnlyDirty();
}
```

**Errore**: Ho visto "stesso metodo, stessa struttura" → Conclusione errata: "duplicazione"

**Realtà**: Implementazioni **DIVERSE**:
- BaseScheda: `->logAll()` **ATTIVO**
- Progressioni: `->logAll()` **COMMENTATO**

## Differenza Critica: Override vs Duplicazione

### Duplicazione (Violazione DRY)

**Definizione**: Stesso codice, stessa logica, stesso comportamento in più posti.

**Indicatori**:
- ✓ Metodi/classi identici
- ✓ Stessa implementazione riga per riga
- ✓ Stesso output per stesso input
- ✓ Nessuna business logic che giustifica la differenza

**Esempio**:
```php
// File A
use SchedaTrait, SigmaModelTrait {
    SchedaTrait::ggInSedeTot insteadof SigmaModelTrait;
}

// File B (estende A)
use SchedaTrait, SigmaModelTrait {  // ❌ DUPLICAZIONE!
    SchedaTrait::ggInSedeTot insteadof SigmaModelTrait;  // Identico!
}
```

### Override (Polymorphism)

**Definizione**: Stesso metodo signature, **comportamento diverso** per business logic specifica.

**Indicatori**:
- ✓ Stessa firma metodo (nome, parametri, return type)
- ✓ Implementazione **DIVERSA**
- ✓ Output/comportamento **DIVERSO**
- ✓ Business logic che giustifica la differenza

**Esempio**:
```php
// Base
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()->logAll();  // Traccia tutto
}

// Derived
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()->logOnlyDirty();  // ✅ OVERRIDE! Solo dirty
}
```

## Checklist per Distinguere

### Prima di Rimuovere un Metodo, Verificare:

1. **Le implementazioni sono IDENTICHE?**
   - Se SÌ → Probabile duplicazione
   - Se NO → Probabile override

2. **C'è business logic che giustifica la differenza?**
   - Se SÌ → Override legittimo
   - Se NO → Duplicazione

3. **Il comportamento è DIVERSO?**
   - Se SÌ → Override legittimo
   - Se NO → Duplicazione

4. **C'è documentazione/commenti che spiegano la differenza?**
   - Se SÌ → Override intenzionale
   - Se NO → Possibile duplicazione accidentale

### Caso Progressioni.getActivitylogOptions()

1. **Implementazioni IDENTICHE?** → **NO** (`logAll()` attivo vs commentato)
2. **Business logic?** → **SÌ** (ottimizzazione performance per volume dati)
3. **Comportamento DIVERSO?** → **SÌ** (traccia tutti vs solo dirty)
4. **Documentato?** → **SÌ** (commenti spiegano la differenza)

**Conclusione**: ✅ **Override legittimo**, NON duplicazione!

## Pattern per Evitare Confusione

### Documentare Override Esplicitamente

```php
/**
 * Override Activity Log configuration for Progressioni.
 * 
 * OVERRIDE RATIONALE:
 * - BaseScheda uses ->logAll() for comprehensive tracking
 * - Progressioni disables ->logAll() for performance (thousands of records)
 * - Only logs dirty fields to minimize Activity Log overhead
 * 
 * @return LogOptions
 */
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        //->logAll()  // Disabled for performance optimization
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
}
```

### Usare Commenti Esplicativi

```php
// ✅ OVERRIDE: Disabilito logAll() per performance
//->logAll()

// vs

// ❌ Ambiguo
//->logAll()
```

## Lesson Learned

### ❌ Errore Commesso

1. **Analisi superficiale**: Non ho letto attentamente il codice
2. **Assunzione sbagliata**: "Stesso metodo = duplicazione"
3. **Mancata verifica**: Non ho confrontato riga per riga
4. **Ignorato il contesto**: Non ho considerato business logic (performance)

### ✅ Approccio Corretto

1. **Lettura attenta**: Confrontare implementazioni riga per riga
2. **Verifica differenze**: Cercare anche piccole differenze (commenti, logica)
3. **Capire business logic**: Perché questo override esiste?
4. **Chiedere conferma**: Se incerto, chiedere all'utente

## Regola per il Futuro

### Prima di Rimuovere un Metodo Override:

```
1. Leggi ENTRAMBE le implementazioni completamente
2. Confronta riga per riga
3. Identifica TUTTE le differenze (anche commenti)
4. Capisce il PERCHÉ delle differenze
5. Verifica la business logic
6. Se NON sei sicuro al 100% → CHIEDI!
```

### Red Flags per Override Legittimi

- Commenti che spiegano "perché diverso"
- Performance optimization notes
- Volume dati diverso
- Use case specifico
- Behavior customization

## Collegamenti

- [Activity Log Override Rationale](./activity-log-override-rationale.md)
- [BaseScheda Activity Log](../../Ptv/docs/models/base-scheda-activity-log.md)
- [DRY vs YAGNI Balance](../../Xot/docs/philosophy/dry-vs-yagni.md)

---

**Creato**: Gennaio 2026  
**Lezione**: **Leggere attentamente prima di rifattorizzare**  
**Principio**: **Quando in dubbio, CHIEDI all'utente!**

