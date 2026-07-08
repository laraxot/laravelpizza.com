# 🧘 Accessor Delegation Pattern - Metodo Puro Vicino

> **"Il metodo puro vive VICINO all'accessor, non in Helper separati"**
> **Aggiornato**: 2026-04-01
> **Versione**: 1.0 (SACRO 🔴)

---

## 🎯 Panoramica

Questo documento definisce il **pattern corretto di delega** per gli accessor in Laravel, con enfasi sulla **prossimità del metodo puro**.

**Regola SACRA**: 
> Il metodo puro `get<Nome>()` deve vivere **VICINO** all'accessor `get<Nome>Attribute()`, idealmente nelle stesse 50 righe di codice.

---

## ❌ Il Problema: Delega a Helper Separati

### Pattern SBAGLIATO (Distanza Cognitiva)

```php
// 📁 SchedaTrait.php (riga 100)
protected function getGgIntegParamsAszAttribute(?float $value): ?float
{
    if (null != $value) {
        return $value;
    }
    if (null == $this->getKey()) {
        return null;
    }

    // ❌ Delega a file SEPARATO (SchedaHelper.php, riga 500)
    $value = $this->getGgIntegParamsAsz();

    $this->update(['gg_integ_params_asz' => $value]);
    return $value;
}

// 📁 SchedaHelper.php (500 righe DOPO)
protected function getGgIntegParamsAsz(): ?float
{
    // Calcolo complesso...
}
```

**Problemi**:
1. ❌ **Distanza cognitiva**: 500+ righe tra accessor e metodo puro
2. ❌ **Difficile manutenzione**: modificare il calcolo richiede saltare tra file
3. ❌ **Trait explosion**: troppi trait separati complicano la comprensione
4. ❌ **Context switching**: AI agent e umani perdono il contesto

---

## ✅ Pattern Corretto: Metodo Puro Vicino

### Pattern CORRETTO (Prossimità Cognitiva)

```php
// 📁 SchedaMutator.php (o SchedaTrait.php)

/**
 * Helper method: Calcola giorni integrazione parametri (calcolo puro).
 *
 * Business Rule: Estrae ultimi parametri integrati e calcola giorni.
 *
 * @return float|null Giorni integrazione, null se non disponibili
 */
protected function getGgIntegParamsAsz(): ?float
{
    // ✅ Calcolo puro qui (50 righe max)
    $last_integ = Integparam::where('ente', $this->ente)
        ->where('matr', $this->matr)
        ->latest('anv2ka')
        ->first();
    
    if (null === $last_integ) {
        return null;
    }

    $criteriOption = $this->getCriteriOptions();
    $data_presenza_al = $criteriOption->get('data_presenza_al');

    if (! ($last_integ->anv2kd instanceof \Carbon\Carbon)) {
        return null;
    }

    if (! ($data_presenza_al instanceof \DateTimeInterface) 
        && ! is_string($data_presenza_al)) {
        return null;
    }

    $days = $last_integ->anv2kd->diffInDays($data_presenza_al, true);

    return intval($days);
}

/**
 * Accessor per gg_integ_params_asz (giorni integrazione parametri).
 * Delega calcolo a getGgIntegParamsAsz().
 *
 * @param float|null $value Valore cached dal DB
 *
 * @return float|null Giorni integrazione calcolati
 */
protected function getGgIntegParamsAszAttribute(?float $value): ?float
{
    // ✅ Cache hit
    if (null != $value) {
        return $value;
    }

    // ✅ Guard: modello deve avere PK per salvare
    if (null == $this->getKey()) {
        return null;
    }

    // ✅ Delega al metodo puro (5 righe SOPRA!)
    $value = $this->getGgIntegParamsAsz();

    if (null === $value) {
        return null;
    }

    // ✅ Persist con update chirurgico
    $this->update(['gg_integ_params_asz' => $value]);

    return $value;
}
```

**Vantaggi**:
1. ✅ **Prossimità cognitiva**: metodo puro e accessor sono VICINI
2. ✅ **Facile manutenzione**: tutto il calcolo è in un posto
3. ✅ **Leggibilità**: scorri 50 righe e capisci tutto
4. ✅ **AI-friendly**: contesto compatto per gli AI agent

---

## 📋 Regole SACRE

### 1. **Regola delle 50 Righe**

> Il metodo puro `get<Nome>()` deve essere **entro 50 righe** dall'accessor `get<Nome>Attribute()`.

```php
// ✅ CORRETTO
protected function getFoo(): int { ... }     // Riga 100
protected function getFooAttribute(...) { ... }  // Riga 120 (20 righe dopo)

// ❌ SBAGLIATO
protected function getFooAttribute(...) { ... }  // Riga 100
// ... 500 righe di altro codice ...
protected function getFoo(): int { ... }         // Riga 600 (in SchedaHelper)
```

### 2. **Regola della Stessa Classe/Trait**

> Metodo puro e accessor devono vivere nello **stesso file**.

```php
// ✅ CORRETTO: Entrambi in SchedaMutator.php
trait SchedaMutator {
    protected function getFoo(): int { ... }
    protected function getFooAttribute(...): ?int { ... }
}

// ❌ SBAGLIATO: Separati in trait diversi
trait SchedaMutator {
    protected function getFooAttribute(...): ?int {
        return $this->getFoo();  // ❌ Chiama SchedaHelper!
    }
}

trait SchedaHelper {
    protected function getFoo(): int { ... }  // ❌ In altro file!
}
```

### 3. **Regola del Nome Coerente**

> Il metodo puro deve avere lo **stesso nome** dell'accessor, senza `Attribute`.

```php
// ✅ CORRETTO
protected function getGgIntegParamsAsz(): ?float          // Metodo puro
protected function getGgIntegParamsAszAttribute(...): ?float  // Accessor

// ❌ SBAGLIATO
protected function calculateGgIntegParamsAsz(): ?float    // Nome diverso!
protected function getGgIntegParamsAszAttribute(...): ?float
```

### 4. **Regola della Responsabilità Singola (SRP)**

> **Metodo puro**: solo calcolo, nessun side effect  
> **Accessor**: cache, guard, delega, persist

```php
// ✅ CORRETTO: SRP rispettato
protected function getGgIntegParamsAsz(): ?float
{
    // ✅ SOLO calcolo puro
    $last_integ = Integparam::where(...)->first();
    return $days;
}

protected function getGgIntegParamsAszAttribute(?float $value): ?float
{
    // ✅ SOLO orchestrazione
    if (null != $value) return $value;  // Cache
    if (null == $this->getKey()) return null;  // Guard
    
    $value = $this->getGgIntegParamsAsz();  // Delega
    
    $this->update([...]);  // Persist
    
    return $value;
}

// ❌ SBAGLIATO: Responsabilità mischiate
protected function getGgIntegParamsAszAttribute(?float $value): ?float
{
    // ❌ Calcolo E orchestrazione insieme (troppe righe!)
    if (null != $value) return $value;
    
    $last_integ = Integparam::where(...)->first();  // ❌ Calcolo qui!
    // ... 50 righe di calcolo ...
    
    $this->update([...]);
    return $value;
}
```

---

## 🧠 Perché la Prossimità è Importante

### 1. **Cognitive Load (Carico Cognitivo)**

```
❌ SEPARATO (Helper lontano):
1. Leggi accessor (riga 100)
2. Scorri 500 righe
3. Trovi metodo puro (riga 600)
4. Torni all'accessor
5. Capisci il flusso

✅ VICINO (stesso posto):
1. Leggi accessor (riga 100)
2. Scorri 20 righe
3. Trovi metodo puro (riga 80)
4. Capisci il flusso
```

**Riduzione carico cognitivo**: 500 righe → 20 righe = **25x meno scrolling**

### 2. **AI Agent Context Window**

Gli AI agent (Qwen, Gemini, Claude) hanno context window limitati:

```
❌ SEPARATO:
- Qwen legge SchedaTrait.php (2671 righe)
- Trova accessor che chiama getGgIntegParamsAsz()
- Deve aprire SchedaHelper.php (703 righe)
- Context: 2671 + 703 = 3374 righe (troppo!)

✅ VICINO:
- Qwen legge SchedaMutator.php (500 righe)
- Trova accessor + metodo puro insieme
- Context: 500 righe (perfetto!)
```

**Context efficiency**: 3374 righe → 500 righe = **6.7x più efficiente**

### 3. **Multi-Agent Collaboration**

Quando più AI agent lavorano sullo stesso codice:

```
❌ SEPARATO:
- Agent A modifica accessor in SchedaTrait
- Agent B modifica metodo puro in SchedaHelper
- Conflitti: chi coordina?
- Duplicazione: entrambi riscrivono logica

✅ VICINO:
- Agent A e B vedono stesso file
- Stesso contesto
- Stessa comprensione
- Meno conflitti
```

---

## 📊 Migration Plan: Da Helper a Vicino

### Step 1: Identifica Coppie

```bash
# Cerca tutti gli accessor che delegano a helper
grep -n "getGg.*Attribute" SchedaTrait.php
grep -n "function getGg" SchedaHelper.php
```

### Step 2: Sposta Metodo Puro

```php
// PRIMA: SchedaHelper.php
protected function getGgIntegParamsAsz(): ?float { ... }

// DOPO: SchedaMutator.php (vicino all'accessor)
protected function getGgIntegParamsAsz(): ?float { ... }

protected function getGgIntegParamsAszAttribute(?float $value): ?float {
    return $this->getGgIntegParamsAsz();
}
```

### Step 3: Rimuovi Duplicati

```php
// Dopo lo spostamento, rimuovi da SchedaHelper
// Mantieni solo metodi puri usati da PIÙ accessor
```

---

## 🧪 Esempi Reali (Sigma Module)

### ✅ ESEMPIO 1: `getGgAttribute`

```php
/**
 * Helper method: Calcola giorni totali di presenza (calcolo puro).
 *
 * Business Rule: Somma giorni in sede + giorni fuori sede = giorni totali.
 *
 * @return int Giorni totali di presenza
 */
protected function getGg(): int
{
    return $this->gg_in_sede + $this->gg_fuori_sede;
}

/**
 * Accessor per gg (giorni totali presenza).
 * Delega calcolo a getGg().
 *
 * @param int|null $_value Valore cached dal DB (ignorato, sempre ricalcolato)
 *
 * @return int Giorni totali calcolati
 */
protected function getGgAttribute(?int $_value): ?int
{
    // Guard: dipendenze devono esistere
    if (null == $this->getKey()) {
        return null;
    }
    if (null == $this->matr) {
        return null;
    }
    if (null == $this->qua2kd) {
        return null;
    }

    // Delega calcolo al metodo helper puro (VICINO!)
    $value = $this->getGg();

    // Persist con update chirurgico
    $this->update(['gg' => $value]);

    return $value;
}
```

### ✅ ESEMPIO 2: `getPosfunvalAttribute`

```php
/**
 * Helper method: Calcola valore posizione funzionale (calcolo puro).
 *
 * Business Rule: Estrae ultima cifra da codice posizione funzionale.
 * Es: posfun "D8" → posfunval 8
 *
 * @return int|null Valore posizione funzionale, null se posfun non disponibile
 */
protected function getPosfunval(): ?int
{
    if (null == $this->posfun) {
        return null;
    }

    return (int) substr((string) $this->posfun, -1);
}

/**
 * Accessor per posfunval (valore numerico posizione funzionale).
 * Delega calcolo a getPosfunval().
 *
 * @param int|null $value Valore cached dal DB
 *
 * @return int|null Valore posizione funzionale calcolato
 */
protected function getPosfunvalAttribute(?int $value): ?int
{
    // Cache hit
    if (null !== $value && ! request()->input('refresh', 0)) {
        return $value;
    }

    // Guard: record deve esistere
    if (null == $this->getKey()) {
        return null;
    }

    // Delega calcolo al metodo helper puro (VICINO!)
    $value = $this->getPosfunval();

    if (null === $value) {
        return null;
    }

    // Persist con update chirurgico
    $this->update(['posfunval' => $value]);

    return $value;
}
```

### ❌ CONTROESEMPIO: `getGgFuoriSedeNoAszAttribute` (DA CORREGGERE)

```php
// ❌ SBAGLIATO: Calcolo diretto, nessun metodo puro
protected function getGgFuoriSedeNoAszAttribute(?float $value): ?float
{
    if (null !== $value && ! request()->input('refresh', false)) {
        return $value;
    }
    if (null == $this->getKey()) {
        return null;
    }

    // ❌ CALCOLO DIRETTO QUI (violazione SRP)
    $value = $this->gg_fuori_sede - $this->gg_asz_fuori_sede - ($this->hh_asz_fuori_sede / 6);

    // Persist con update chirurgico
    $this->update(['gg_fuori_sede_no_asz' => $value]);

    return $value;
}
```

**Dovrebbe diventare**:

```php
/**
 * Helper method: Calcola giorni fuori sede senza assenze (calcolo puro).
 *
 * Business Rule: Giorni fuori sede - (giorni assenza + ore assenza / 6).
 *
 * @return float|null Giorni fuori sede netti, null se dati non disponibili
 */
protected function getGgFuoriSedeNoAsz(): ?float
{
    if (null == $this->gg_fuori_sede) {
        return null;
    }

    return $this->gg_fuori_sede 
        - $this->gg_asz_fuori_sede 
        - ($this->hh_asz_fuori_sede / 6);
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
    if (null !== $value && ! request()->input('refresh', false)) {
        return $value;
    }
    if (null == $this->getKey()) {
        return null;
    }

    // Delega calcolo al metodo puro (VICINO!)
    $value = $this->getGgFuoriSedeNoAsz();

    // Persist con update chirurgico
    $this->update(['gg_fuori_sede_no_asz' => $value]);

    return $value;
}
```

---

## 🚨 Multi-Agent Coordination

### Quando Lavori su Questo Pattern

1. **DICHIARA** l'intenzione su GitHub Issue
2. **LEGGI** questo documento prima di modificare
3. **LAVORA** in piccoli incrementi (5-10 accessor per volta)
4. **PUSHA** ogni 5-10 minuti
5. **DOCUMENTA** nel coordination log

### GitHub Issue Template

```markdown
## Refactoring Accessor Delegation

**Modulo**: Sigma
**File**: SchedaMutator.php
**Accessor da correggere**: 
- [ ] getGgFuoriSedeNoAszAttribute
- [ ] getValutatoreTxtAttribute
- [ ] getPosizioneAttribute

**Stato**: In Progress
**AI Agent**: @qwen
**Started**: 2026-04-01
```

---

## 📿 Il Mantra

```
Prima di scrivere un accessor, ripeti:

"Il metodo puro vive VICINO, non lontano"
"50 righe massimo, non 500"
"Stesso file, stesso trait"
"Nome coerente, SRP rispettato"

Respira. Scrivi. Contesto compatto.
```

---

## 🔗 Riferimenti

- [Accessor/Mutator Philosophy](accessor-mutator-philosophy.md)
- [SchedaTrait Accessor Pattern](scheda-trait-accessor-pattern.md)
- [Accessor Helper Audit Complete](accessor-helper-audit-complete.md)
- [Laravel Accessors](https://laravel.com/docs/eloquent-mutators)
- [SOLID Principles](https://en.wikipedia.org/wiki/SOLID)

---

*Documento SACRO per accessor delegation. Violazioni = Distanza cognitiva.*
*Ultimo aggiornamento: 2026-04-01*
*Stato: ✅ APPROVATO DALLO ZEN*
*Multi-Agent Safe: Contesto compatto per tutti gli AI*
