# Eloquent Properties: isset() vs property_exists() - Guida Completa

## 🚨 Regola Critica

**MAI usare `property_exists()` con i modelli Eloquent**. Utilizzare SEMPRE `isset()` perché gli attributi Eloquent sono magici.

## Perché property_exists() non funziona

I modelli Eloquent utilizzano il pattern delle proprietà magiche:
- I campi del database sono accessibili tramite `__get()` e `__set()`
- NON sono proprietà PHP reali della classe
- `property_exists()` controlla solo le proprietà reali della classe, NON gli attributi magici
- `property_exists()` restituisce sempre `false` per i campi del database

## Soluzione Corretta: isset()

`isset()` rispetta il magic method `__isset()` implementato da Eloquent, quindi funziona correttamente con gli attributi magici.

## Esempi Pratici

### ❌ SBAGLIATO
```php
// property_exists() non funziona con attributi magici
if (property_exists($model, 'email')) {
    $email = $model->email; // Questa condizione è SEMPRE false
}
```

### ✅ CORRETTO
```php
// isset() rispetta __isset() per attributi magici
if (isset($model->email)) {
    $email = $model->email; // Funziona correttamente
}

// Ancora meglio: usare getAttribute() per accesso diretto
$email = $model->getAttribute('email');
if ($email !== null) {
    // Usa $email
}
```

## Pattern nel Modulo UI

Nel modulo UI, questa regola è stata applicata in:

- `IconStateSplitColumn.php`: Uso di `isset($record->id)` invece di `property_exists()`
- `IconStateColumn.php`: Uso di `isset($record->state)` invece di `property_exists()`
- `UserCalendarWidget.php`: Type narrowing corretto per attributi magici

## Alternative Corrette

### 1. Verificare Attributi del Modello
```php
// ✅ Verificare se un attributo esiste nel modello
if ($model->hasAttribute('field_name')) {
    // logica corretta
}

// ✅ Verificare se un campo è fillable
if ($model->isFillable('field_name')) {
    // logica corretta per campi modificabili
}

// ✅ Verificare se un attributo è stato impostato
if (isset($model->field_name)) {
    // verifica se l'attributo ha un valore
}

// ✅ Verificare se un attributo non è null
if (!is_null($model->field_name)) {
    // verifica valore non null
}
```

### 2. Verificare Struttura Database
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

### 3. Verificare Cast e Configurazioni
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

## Pattern di Migrazione

### Prima (Codice Errato)
```php
foreach ($fields as $field => $value) {
    if (property_exists($model, $field)) {
        $model->$field = $value;
    }
}
```

### Dopo (Codice Corretto)
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

## Eccezione

`property_exists()` è OK **SOLO** per classi PHP normali (non Eloquent):

```php
// ✅ OK - DTO/Value Object
class UserData
{
    public function __construct(
        public string $name,
        public string $email
    ) {}
}

if (property_exists($data, 'email')) { // ✅ OK
    echo $data->email;
}

// ❌ MAI con Eloquent
if (property_exists($model, 'email')) { // ❌ NON funziona
    echo $model->email;
}
```

## Checklist Review

Prima di commit, verifica:

- [ ] Nessun `property_exists()` su Model
- [ ] Usa `isset()` per attributi Eloquent
- [ ] Usa `hasAttribute()` per check espliciti
- [ ] Usa `relationLoaded()` per relazioni
- [ ] PHPStan Level 10 passa senza errori

## Documentazione Completa

- **Guida Master**: [Xot: Eloquent Models Critical Rules](../../Xot/docs/eloquent-models-critical-rules.md)
- **Cast Actions**: [Xot: Cast Actions](../../Xot/docs/cast-actions.md)
- **Best Practices**: [Xot: Eloquent Properties Best Practices](../../Xot/docs/eloquent-properties-best-practices.md)

## Risorse

- [Laravel Eloquent](https://laravel.com/docs/eloquent)
- [PHP Magic Methods](https://www.php.net/manual/en/language.oop5.magic.php)
- [PHPStan](https://phpstan.org/)

## Mantra

> "Eloquent attributes are magic, not properties.
> isset() respects __isset(), property_exists() doesn't.
> Always isset(). Never property_exists()."

---

**Progetto**: base_<nome progetto>_fila4_mono
**PHPStan**: Level 10
**Status**: ✅ 0 Errors
**Ultimo aggiornamento**: [DATE]
