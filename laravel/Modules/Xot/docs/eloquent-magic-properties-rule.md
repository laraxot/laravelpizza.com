# Eloquent Magic Properties - Regola Assoluta

## 🔥 REGOLA FONDAMENTALE

**MAI usare `property_exists()` con modelli Eloquent**

**SEMPRE usare `isset()` per magic properties**

## Perché property_exists() NON Funziona

### Eloquent usa Magic Methods

```php
// Modello Eloquent
class User extends Model
{
    // Nessuna proprietà $name dichiarata!
}

$user = User::find(1);
$user->name; // "Mario" - funziona tramite __get()

property_exists($user, 'name'); // FALSE ❌
isset($user->name);              // TRUE ✅
```

### Come Funziona Eloquent

```php
class Model
{
    protected array $attributes = [];
    
    // Magic method per accesso attributi
    public function __get(string $key)
    {
        return $this->getAttribute($key);
    }
    
    // Magic method per isset()
    public function __isset(string $key): bool
    {
        return $this->offsetExists($key);
    }
}
```

**Gli attributi del database NON sono proprietà PHP**, sono array `$attributes` accessibili tramite magic methods.

## ❌ SBAGLIATO

```php
// NON FUNZIONA con Eloquent
if (property_exists($record, 'state')) {
    $state = $record->state; // Mai eseguito!
}

// NON FUNZIONA con attributi DB
if (property_exists($model, 'name')) {
    $name = $model->name; // Mai eseguito!
}

// NON FUNZIONA con relazioni
if (property_exists($user, 'posts')) {
    $posts = $user->posts; // Mai eseguito!
}
```

## ✅ CORRETTO

### 1. isset() - Metodo Raccomandato

```php
// Rispetta __isset() magic method
if (isset($record->state)) {
    $state = $record->state; // ✅ Funziona!
}

// Per oggetti complessi
if (isset($record->state) && is_object($record->state)) {
    if (method_exists($record->state, 'transitionTo')) {
        $record->state->transitionTo($newState);
    }
}
```

### 2. hasAttribute() - Metodo Eloquent

```php
// Metodo nativo Eloquent
if ($model->hasAttribute('name')) {
    $name = $model->name;
}

// Per attributi specifici
if ($user->hasAttribute('email')) {
    $email = $user->email;
}
```

### 3. getAttributes() - Check Diretto

```php
// Accesso diretto all'array
if (array_key_exists('state', $record->getAttributes())) {
    $state = $record->state;
}

// Per iterazione
foreach ($model->getAttributes() as $key => $value) {
    // ...
}
```

### 4. relationLoaded() - Per Relazioni

```php
// Check se relazione è caricata
if ($user->relationLoaded('posts')) {
    $posts = $user->posts;
}

// Con null check
if ($user->relationLoaded('posts') && $user->posts !== null) {
    foreach ($user->posts as $post) {
        // ...
    }
}
```

## Pattern Completi

### Attributo Semplice

```php
// ✅ Pattern corretto
if (isset($model->attribute)) {
    $value = $model->attribute;
} else {
    $value = 'default';
}
```

### Attributo Oggetto (es. State)

```php
// ✅ Pattern completo per state machine
if (isset($record->state) 
    && is_object($record->state) 
    && method_exists($record->state, 'transitionTo')) {
    $record->state->transitionTo($newState, $message);
}
```

### Relazione

```php
// ✅ Pattern per relazioni
if ($model->relationLoaded('relation') && $model->relation) {
    $related = $model->relation;
} else {
    // Carica relazione se necessario
    $model->load('relation');
    $related = $model->relation;
}
```

### Null-Safe Access

```php
// ✅ Null-safe con PHP 8
$value = $model->attribute ?? 'default';
$name = $user->profile?->name ?? 'N/A';
```

## PHPStan Level 10

`isset()` è perfetto per PHPStan:

```php
/** @var Model $record */
if (isset($record->state)) {
    // PHPStan sa che $record->state esiste qui
    $record->state->doSomething(); // ✅ Type-safe
}

// PHPStan con type narrowing
if (isset($record->state) && $record->state instanceof StateClass) {
    $record->state->specificMethod(); // ✅ Completamente type-safe
}
```

## Quando Usare property_exists()

**SOLO per classi PHP normali (NON Eloquent)**:

```php
// ✅ OK - Classe normale con proprietà dichiarate
class RegularClass
{
    public string $name;
    private int $age;
}

$obj = new RegularClass();
if (property_exists($obj, 'name')) { // ✅ Corretto
    echo $obj->name;
}

// ✅ OK - DTO/Value Object
class UserData
{
    public function __construct(
        public string $name,
        public string $email
    ) {}
}

$data = new UserData('Mario', 'mario@example.com');
if (property_exists($data, 'email')) { // ✅ Corretto
    echo $data->email;
}
```

## Errori Comuni

### Errore 1: Copia da StackOverflow

```php
// ❌ Codice trovato online - NON funziona con Eloquent
if (property_exists($model, 'attribute')) {
    // Mai eseguito!
}
```

**Fix**: 
```php
// ✅ Corretto
if (isset($model->attribute)) {
    // Funziona!
}
```

### Errore 2: Confusione con Reflection

```php
// ❌ Reflection API non vede magic properties
$reflection = new ReflectionClass($model);
if ($reflection->hasProperty('name')) {
    // FALSE per attributi Eloquent!
}
```

**Fix**:
```php
// ✅ Usa metodi Eloquent
if ($model->hasAttribute('name')) {
    // Funziona!
}
```

### Errore 3: isset() vs empty()

```php
// ⚠️ empty() considera 0, '', false come "empty"
if (!empty($model->count)) {
    // Non eseguito se count = 0!
}

// ✅ Usa isset() per check esistenza
if (isset($model->count)) {
    // Eseguito anche se count = 0
    $count = $model->count;
}
```

## Checklist Verifica

Quando scrivi codice con Eloquent:

- [ ] ✅ Uso `isset()` invece di `property_exists()`
- [ ] ✅ Uso `hasAttribute()` per check espliciti
- [ ] ✅ Uso `relationLoaded()` per relazioni
- [ ] ✅ Type narrowing con `is_object()` e `method_exists()`
- [ ] ✅ PHPStan Level 10 senza errori
- [ ] ✅ Nessun `property_exists()` su Model

## Quick Reference

| Scenario | ❌ Sbagliato | ✅ Corretto |
|----------|-------------|------------|
| Attributo DB | `property_exists($model, 'name')` | `isset($model->name)` |
| Relazione | `property_exists($user, 'posts')` | `$user->relationLoaded('posts')` |
| State object | `property_exists($record, 'state')` | `isset($record->state)` |
| Check attributo | `property_exists($model, 'attr')` | `$model->hasAttribute('attr')` |
| Classe normale | - | `property_exists($obj, 'prop')` ✅ |

## Risorse

- [Laravel Eloquent Docs](https://laravel.com/docs/eloquent)
- [PHP Magic Methods](https://www.php.net/manual/en/language.oop5.magic.php)
- [PHPStan Rules](https://phpstan.org/user-guide/rule-levels)
- `Modules/Xot/docs/eloquent-properties-best-practices.md`
- `Modules/Xot/docs/property-exists-replacement-guide.md`

---

## Summary

**3 Regole d'Oro**:

1. ❌ **MAI** `property_exists()` su Eloquent Model
2. ✅ **SEMPRE** `isset()` per magic properties
3. ✅ **SEMPRE** `hasAttribute()` / `relationLoaded()` per check espliciti

**Mantra**:
> "Gli attributi Eloquent sono magic, non PHP properties.
> isset() rispetta __isset(), property_exists() no.
> Always isset(). Never property_exists()."

---

**Ultimo aggiornamento**: 2025-01-06  
**PHPStan Level**: 10  
**Status**: ✅ 0 Errors
