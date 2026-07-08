# Pattern Accessor + Helper Method - Separation of Concerns

## Filosofia e Business Logic

### Principio Fondamentale: Separation of Concerns (SoC)

**Ogni accessor che calcola un valore derivato DEVE delegare la logica di calcolo a un metodo helper puro.**

```
Accessor (getAttribute)  →  Delega a  →  Helper Method (get<Nome>)
     ↓                                          ↓
Orchestrazione                            Calcolo Puro
Cache, Guards, Save                       Solo Business Logic
```

## Perché Separare?

### 1. **Testabilità**

```php
// ✅ Metodo helper testabile in isolamento
public function test_calcolo_gg_cateco_posfun_no_asz(): void
{
    $scheda = new Scheda();
    $scheda->gg_cateco_posfun = 100;
    $scheda->gg_asz_cateco_posfun = 10;
    
    // Test SOLO la logica di calcolo
    $result = $scheda->getGgCatecoPosfunNoAsz();
    
    expect($result)->toBe(90);
}
```

**Senza separazione:** Impossibile testare il calcolo senza mock di database, cache, ecc.

### 2. **Riutilizzabilità**

```php
// Il metodo helper può essere chiamato da:
// - Accessor
// - Altri metodi del modello
// - Observer
// - Action/Service
// - Report/Export

public function calcolaStatistiche(): array
{
    return [
        'gg_no_asz' => $this->getGgCatecoPosfunNoAsz(), // ✅ Riuso
        'gg_totali' => $this->getGgCateco(),            // ✅ Riuso
        'percentuale' => $this->calcolaPercentuale(),
    ];
}
```

### 3. **Manutenibilità**

```php
// ❌ SENZA separazione: logica mista con orchestrazione
public function getGgCatecoPosfunNoAszAttribute(?int $value): ?int
{
    if (null != $value && ! request()->input('refresh', 0)) {
        return $value;
    }
    if (null == $this->getKey()) {
        return null;
    }
    
    // Logica di calcolo EMBEDDED (difficile da trovare/modificare)
    $value = intval($this->gg_cateco_posfun) - intval($this->gg_asz_cateco_posfun);
    
    $this->gg_cateco_posfun_no_asz = $value;
    $this->save();
    
    return $value;
}

// ✅ CON separazione: logica isolata e chiara
public function getGgCatecoPosfunNoAszAttribute(?int $value): ?int
{
    if (null != $value && ! request()->input('refresh', 0)) {
        return $value;
    }
    if (null == $this->getKey()) {
        return null;
    }
    
    // Delega al metodo helper
    $value = $this->getGgCatecoPosfunNoAsz();
    
    $this->gg_cateco_posfun_no_asz = $value;
    $this->save();
    
    return $value;
}

// Logica PURA, facile da trovare e modificare
public function getGgCatecoPosfunNoAsz(): ?int
{
    return intval($this->gg_cateco_posfun) - intval($this->gg_asz_cateco_posfun);
}
```

### 4. **Single Responsibility Principle (SRP)**

**Accessor:** Responsabile di orchestrazione
- Cache management
- Guard checks
- Persistenza
- Coordinamento

**Helper:** Responsabile di calcolo
- Solo business logic
- Nessun side effect
- Input → Output
- Funzione pura

## Pattern Standard

### Template Completo

```php
/**
 * Helper method: calcolo puro senza side effects.
 * 
 * @return int|null
 */
public function getGgCatecoPosfunNoAsz(): ?int
{
    // Guard checks per dipendenze
    if (null == $this->gg_cateco_posfun) {
        return null;
    }
    
    // SOLO logica di calcolo
    return intval($this->gg_cateco_posfun) - intval($this->gg_asz_cateco_posfun);
}

/**
 * Accessor: orchestrazione e persistenza.
 * 
 * @param int|null $value
 * @return int|null
 */
public function getGgCatecoPosfunNoAszAttribute(?int $value): ?int
{
    // 1. Cache check
    if (null != $value && ! request()->input('refresh', 0)) {
        return $value;
    }
    
    // 2. Guard: record must exist
    if (null == $this->getKey()) {
        return null;
    }
    
    // 3. Guard: dependencies must exist
    if (null == $this->matr) {
        return null;
    }
    if (null == $this->propro) {
        return null;
    }
    
    // 4. Delega calcolo al metodo helper
    $value = $this->getGgCatecoPosfunNoAsz();
    
    // 5. Persist
    $this->gg_cateco_posfun_no_asz = $value;
    $this->save();
    
    return $value;
}
```

## Esempi dal Codice Esistente

### ✅ Pattern Corretto (già implementato)

```php
// Helper method
public function getGgCateco(): ?int
{
    return $this->gg_cateco_in_sede + $this->gg_cateco_fuori_sede;
}

// Accessor che delega
public function getGgCatecoAttribute(?int $value): ?int
{
    if (null == $this->getKey()) {
        return null;
    }
    if (null !== $value && ! request()->input('refresh', false)) {
        return $value;
    }

    $this->gg_cateco = $this->getGgCateco(); // ✅ Delega
    $this->save();

    return $value;
}
```

### ❌ Anti-Pattern (da refactorare)

```php
// Accessor con logica embedded
public function getGgNoAszAttribute(?float $value): ?float
{
    if (null !== $value && 0.0 != $value && ! request()->input('refresh', false)) {
        return $value;
    }
    if (null == $this->getKey()) {
        return null;
    }

    // ❌ Logica di calcolo EMBEDDED
    $value = $this->gg_in_sede_no_asz + $this->gg_fuori_sede_no_asz;
    
    $this->gg_no_asz = $value;
    $this->save();

    return $value;
}

// ✅ DOVREBBE ESSERE:
public function getGgNoAsz(): ?float
{
    return $this->gg_in_sede_no_asz + $this->gg_fuori_sede_no_asz;
}

public function getGgNoAszAttribute(?float $value): ?float
{
    if (null !== $value && 0.0 != $value && ! request()->input('refresh', false)) {
        return $value;
    }
    if (null == $this->getKey()) {
        return null;
    }

    $value = $this->getGgNoAsz(); // ✅ Delega
    
    $this->gg_no_asz = $value;
    $this->save();

    return $value;
}
```

## Convenzioni di Naming

### Accessor (Laravel Magic Method)
```php
public function get{CampoInCamelCase}Attribute(?{Type} $value): ?{Type}
```

**Esempio:** `getGgCatecoPosfunNoAszAttribute(?int $value): ?int`

### Helper Method (Business Logic)
```php
public function get{CampoInCamelCase}(): ?{Type}
```

**Esempio:** `getGgCatecoPosfunNoAsz(): ?int`

**Differenza:** L'helper NON ha il suffisso `Attribute` e NON ha il parametro `$value`

## Benefici per PHPStan

### Tipizzazione Più Chiara

```php
// Helper: tipo di ritorno esplicito basato sul calcolo
public function getGgCateco(): ?int
{
    return $this->gg_cateco_in_sede + $this->gg_cateco_fuori_sede;
}

// Accessor: PHPStan sa che il valore viene dal metodo tipizzato
public function getGgCatecoAttribute(?int $value): ?int
{
    $value = $this->getGgCateco(); // PHPStan: ?int
    return $value; // ✅ Type safe
}
```

### Analisi Statica Migliore

PHPStan può:
- Verificare che il metodo helper esista
- Controllare la compatibilità dei tipi
- Rilevare chiamate a metodi inesistenti
- Validare il flusso dei dati

## Refactoring Checklist

Per ogni accessor che calcola un valore:

- [ ] Identificare la logica di calcolo nell'accessor
- [ ] Estrarre la logica in un metodo helper `get<Nome>()`
- [ ] L'helper deve essere PURO (no side effects)
- [ ] L'accessor delega al metodo helper
- [ ] Aggiungere PHPDoc completo ad entrambi
- [ ] Verificare che i tipi siano coerenti
- [ ] Test unitario per il metodo helper
- [ ] Test di integrazione per l'accessor

## Esempi di Refactoring

### Caso 1: Calcolo Semplice

**Prima:**
```php
public function getGgAszAttribute(?int $value): ?int
{
    // ... guards ...
    
    $value = $this->gg_asz_in_sede + $this->gg_asz_fuori_sede;
    
    $this->gg_asz = $value;
    $this->save();
    
    return $value;
}
```

**Dopo:**
```php
public function getGgAsz(): ?int
{
    return $this->gg_asz_in_sede + $this->gg_asz_fuori_sede;
}

public function getGgAszAttribute(?int $value): ?int
{
    // ... guards ...
    
    $value = $this->getGgAsz();
    
    $this->gg_asz = $value;
    $this->save();
    
    return $value;
}
```

### Caso 2: Calcolo Complesso

**Prima:**
```php
public function getGgCatecoInSedeAttribute(?int $value): ?int
{
    // ... guards ...
    
    $categoria = $this->categoriaPropro;
    if (null == $categoria) {
        return null;
    }
    
    $parz = [
        'lista_propro' => $categoria->lista_propro,
        'lista_propro_sup' => $categoria->lista_propro_sup,
        'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
        'date_max' => $this->criteriOptionsArr('data_presenza_al'),
    ];
    $data = GgFilterData::from($parz);
    $value = $this->anag?->ggInSedeTot($data);
    
    $this->gg_cateco_in_sede = $value;
    $this->save();
    
    return $value;
}
```

**Dopo:**
```php
public function getGgCatecoInSede(): ?int
{
    if (null == $this->matr) {
        return null;
    }
    if (null == $this->propro) {
        return null;
    }

    $categoria = $this->categoriaPropro;
    if (null == $categoria) {
        return null;
    }
    
    $parz = [
        'lista_propro' => $categoria->lista_propro,
        'lista_propro_sup' => $categoria->lista_propro_sup,
        'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
        'date_max' => $this->criteriOptionsArr('data_presenza_al'),
    ];
    $data = GgFilterData::from($parz);
    
    return $this->anag?->ggInSedeTot($data);
}

public function getGgCatecoInSedeAttribute(?int $value): ?int
{
    if (null !== $value && ! request()->input('refresh', false)) {
        return $value;
    }
    if (null == $this->getKey()) {
        return null;
    }

    $this->gg_cateco_in_sede = $this->getGgCatecoInSede();
    $this->save();

    return $value;
}
```

## Conclusione

**Questo pattern è una best practice fondamentale per:**

1. **Codice pulito** (Clean Code)
2. **Testabilità** (Unit Testing)
3. **Riutilizzabilità** (DRY)
4. **Manutenibilità** (KISS)
5. **Analisi statica** (PHPStan)

**Regola d'oro:** Se un accessor fa più di orchestrazione (cache, guards, save), la logica di calcolo VA in un metodo helper separato.

---

**Creato**: 2025-10-29  
**Autore**: Analisi Architetturale  
**Status**: ✅ PATTERN DOCUMENTATO
