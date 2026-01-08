# Eloquent Models - Regole Critiche per Laraxot PTVX

## DIVIETO ASSOLUTO: property_exists() con Modelli Eloquent

### Errore Gravissimo Identificato
L'uso di `property_exists()` sui modelli Eloquent è categoricamente vietato e rappresenta un errore architetturale grave.

### Motivazione Tecnica
I modelli Eloquent utilizzano il pattern delle proprietà magiche:
- I campi del database sono accessibili tramite `__get()` e `__set()`
- NON sono proprietà PHP reali della classe
- `property_exists()` restituisce sempre `false` per i campi del database
- Causa logica di validazione completamente errata

### Alternative Corrette per Laraxot PTVX

**REGOLA CRITICA**: Per i modelli Eloquent, utilizzare SEMPRE `isset()` invece di `property_exists()` perché gli attributi sono magici (gestiti tramite `__get()`, `__set()`, `__isset()`).

#### 1. Verificare Attributi del Modello
```php
// ❌ SBAGLIATO - property_exists() non funziona con attributi magici
if (property_exists($model, 'field_name')) {
    // Questa condizione è SEMPRE false per campi database
}

// ✅ CORRETTO - isset() rispetta __isset() per attributi magici
if (isset($model->field_name)) {
    // verifica se l'attributo ha un valore
}

// ✅ CORRETTO - Verificare se un attributo esiste nel modello
if ($model->hasAttribute('field_name')) {
    // logica corretta
}

// ✅ CORRETTO - Verificare se un campo è fillable
if ($model->isFillable('field_name')) {
    // logica corretta per campi modificabili
}

// ✅ CORRETTO - Verificare se un attributo non è null
if (!is_null($model->field_name)) {
    // verifica valore non null
}

// ✅ CORRETTO - Usare getAttribute() per accesso diretto
$value = $model->getAttribute('field_name');
if ($value !== null) {
    // Usa $value
}
```

#### 2. Verificare Struttura Database
```php
use Illuminate\Support\Facades\Schema;

// ✅ Verificare se una colonna esiste nella tabella
if (Schema::hasColumn($model->getTable(), 'field_name')) {
    // verifica struttura database
}

// ✅ Ottenere tutte le colonne di una tabella
$columns = Schema::getColumnListing($model->getTable());
if (in_array('field_name', $columns)) {
    // verifica presenza colonna
}
```

#### 3. Verificare Cast e Configurazioni
```php
// ✅ Verificare se un attributo è nel cast
if (array_key_exists('field_name', $model->getCasts())) {
    // verifica configurazione cast
}

// ✅ Verificare se una relazione esiste
if (method_exists($model, 'relationshipName')) {
    // verifica esistenza relazione
}
```

### Esempi di Codice VIETATO

```php
// ❌ GRAVEMENTE ERRATO - MAI USARE
if (property_exists($model, 'email')) {
    // Questa condizione è SEMPRE false per campi database
    $model->email = $value;
}

// ❌ GRAVEMENTE ERRATO - MAI USARE
$hasField = property_exists($user, 'name'); // Sempre false!

// ❌ GRAVEMENTE ERRATO - MAI USARE
if (property_exists($model, 'created_at')) {
    // Non funzionerà mai come previsto
}
```

### Pattern di Migrazione

#### Prima (Codice Errato)
```php
foreach ($fields as $field => $value) {
    if (property_exists($model, $field)) {
        $model->$field = $value;
    }
}
```

#### Dopo (Codice Corretto)
```php
foreach ($fields as $field => $value) {
    if ($model->isFillable($field)) {
        $model->$field = $value;
    }
}
// OPPURE per verifiche più rigorose
foreach ($fields as $field => $value) {
    if (Schema::hasColumn($model->getTable(), $field)) {
        $model->$field = $value;
    }
}
```

### Impatto nell'Architettura Laraxot

#### Problemi Causati
- Rottura della logica di validazione nei BaseModel
- Comportamenti imprevedibili nei trait modulari
- Errori silenti difficili da tracciare
- Violazione dei principi di isolamento modulare

#### Aree Critiche da Verificare
1. **BaseModel di ogni modulo**: Verificare metodi di validazione
2. **Trait condivisi**: Controllare logiche di verifica attributi
3. **Action e Data Objects**: Verificare mapping dei campi
4. **Filament Resources**: Controllare schema form e validazioni

### Regole di Controllo Qualità

#### Checklist Pre-Commit
- [ ] Nessun uso di `property_exists()` sui modelli
- [ ] Uso corretto di `hasAttribute()` per verifiche
- [ ] Uso corretto di `isFillable()` per campi modificabili
- [ ] Uso corretto di `Schema::hasColumn()` per struttura DB
- [ ] Test di regressione per logiche modificate

#### PHPStan Integration
Aggiungere regola personalizzata per rilevare `property_exists()` sui modelli:
```php
// phpstan.neon
rules:
    - App\PHPStan\Rules\NoPropertyExistsOnEloquentModelsRule
```

### Testing Considerations

#### Test Corretti
```php
// ✅ Test assertions corrette
$this->assertTrue($model->hasAttribute('field_name'));
$this->assertTrue($model->isFillable('field_name'));
$this->assertTrue(isset($model->field_name));

// ❌ Test assertions errate
$this->assertTrue(property_exists($model, 'field_name')); // Sempre false
```

### Documentazione Correlata
- [Root Docs: Eloquent Models Property Verification](../../../docs/eloquent-models-property-verification.md)
- [.cursor/rules/property_exists_eloquent_models.mdc](../../../.cursor/rules/property_exists_eloquent_models.mdc)
- [.windsurf/rules/property_exists_eloquent_models.mdc](../../../.windsurf/rules/property_exists_eloquent_models.mdc)
- [Laravel AI Guidelines](../../.ai/guidelines/eloquent_models_property_verification.md)

### Azioni Immediate Richieste
1. Audit completo del codebase per `property_exists()`
2. Sostituzione immediata con alternative corrette
3. Aggiornamento di tutti i test dipendenti
4. Verifica di logiche correlate nei trait e BaseModel
5. Aggiornamento documentazione moduli specifici

*Ultimo aggiornamento: agosto 2025 - Regola critica per architettura Laraxot PTVX*