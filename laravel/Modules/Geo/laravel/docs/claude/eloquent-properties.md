# 🏛️ Eloquent Properties - Gestione Proprietà Magiche

> **⚠️ CRITICO**: La gestione errata delle proprietà Eloquent causa bug silenziosi e comportamenti inaspettati.

## 🔥 Regola Fondamentale: MAI property_exists()

### Il Problema
Laravel Eloquent usa metodi magici (`__get()` e `__set()`) per gestire proprietà dinamiche come:
- Attributi database (colonne)
- Relazioni (hasmany, belongsTo, etc.)
- Accessor (proprietà calcolate)
- Mutator

`property_exists()` funziona **SOLO** per proprietà reali definite nella classe, non per proprietà magiche.

### ❌ USO SBAGLIATO CRITICO
```php
// ❌ MAI FARE - Restituisà SEMPRE false
if (property_exists($user, 'posts')) {
    return $user->posts; // Non verrà mai eseguito
}

// ❌ MAI FARE - Non funziona con accessor
if (property_exists($user, 'full_name')) {
    return $user->full_name; // full_name è un accessor
}

// ❌ MAI FARE - Non funziona con attributi database
if (property_exists($user, 'email')) {
    return $user->email; // email è un attributo database
}
```

### ✅ USO CORRETTO
```php
// ✅ SEMPRE usare isset() per proprietà magiche
if (isset($user->posts)) {
    return $user->posts;
}

// ✅ Per accessor e attributi
if (isset($user->full_name)) {
    return $user->full_name;
}

// ✅ Per verificare relazione caricata
if ($user->relationLoaded('posts')) {
    return $user->posts;
}

// ✅ Per verificare esistenza relazione
if ($user->posts()->exists()) {
    return $user->posts;
}
```

---

## 📋 Tipi di Proprietà Eloquent

### 1. **Attributi Database**
```php
class User extends Model
{
    protected $fillable = ['name', 'email', 'password'];
}

// ✅ Controllo corretto
if (isset($user->email)) {
    return $user->email;
}

// ❌ Controllo sbagliato
if (property_exists($user, 'email')) { // sempre false
    return $user->email;
}
```

### 2. **Relazioni**
```php
class User extends Model
{
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}

// ✅ Verifica relazione caricata
if ($user->relationLoaded('posts')) {
    return $user->posts; // Collection già caricata
}

// ✅ Verifica esistenza record in relazione
if ($user->posts()->exists()) {
    return $user->posts()->get(); // Esegue query
}

// ✅ Controllo generico
if (isset($user->posts)) {
    return $user->posts; // Lazy loading se necessario
}
```

### 3. **Accessor**
```php
class User extends Model
{
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}

// ✅ Controllo accessor
if (isset($user->full_name)) {
    return $user->full_name;
}

// ✅ Alternativa: verifica metodo accessor
if (method_exists($user, 'getFullNameAttribute')) {
    return $user->full_name;
}
```

### 4. **Proprietà Reali (unico caso per property_exists)**
```php
class User extends Model
{
    protected $table = 'users';
    protected $fillable = [];
    public $timestamps = true;
}

// ✅ SOLO per proprietà reali della classe
if (property_exists($user, 'fillable')) {
    return $user->fillable;
}

if (property_exists($user, 'table')) {
    return $user->table;
}

// ❌ MAI per attributi/accessor/relazioni
if (property_exists($user, 'email')) { // sbagliato
    return $user->email;
}
```

---

## 🧪 Testing Proprietà Eloquent

### Unit Tests Corretti
```php
class UserPropertyTest extends TestCase
{
    public function test_isset_works_for_magic_properties(): void
    {
        $user = User::factory()->create(['email' => 'test@example.com']);
        
        // Attributi database
        $this->assertTrue(isset($user->email));
        $this->assertEquals('test@example.com', $user->email);
        
        // Relazioni
        $this->assertFalse(isset($user->posts)); // Non caricata
        $user->load('posts');
        $this->assertTrue(isset($user->posts)); // Ora caricata
        
        // Accessor
        $this->assertTrue(isset($user->full_name));
    }
    
    public function test_property_exists_only_real_properties(): void
    {
        $user = new User();
        
        // Proprietà reali - TRUE
        $this->assertTrue(property_exists($user, 'fillable'));
        $this->assertTrue(property_exists($user, 'table'));
        
        // Proprietà magiche - FALSE
        $this->assertFalse(property_exists($user, 'email'));
        $this->assertFalse(property_exists($user, 'posts'));
        $this->assertFalse(property_exists($user, 'full_name'));
    }
}
```

---

## 🔧 PHPStan e Proprietà Magiche

### PHPDoc per Proprietà Magiche
```php
/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read string $full_name
 * @property string $email
 * @property \Carbon\Carbon $created_at
 */
class User extends Model
{
    // ...
}
```

### Suppress PHPStan Warnings
```php
// PHPStan potrebbe lamentarsi di proprietà non definite
if (isset($user->posts)) { // @phpstan-ignore-line
    return $user->posts;
}

// Meglio: aggiungere PHPDoc come sopra
```

---

## 🚨 Pattern Comuni Errati

### 1. **Verifica Esistenza Relazione**
```php
// ❌ Sbagliato
public function hasPosts(User $user): bool
{
    return property_exists($user, 'posts'); // sempre false
}

// ✅ Corretto
public function hasPosts(User $user): bool
{
    return isset($user->posts) && $user->posts->isNotEmpty();
}

// ✅ Oppure (più efficiente)
public function hasPosts(User $user): bool
{
    return $user->posts()->exists();
}
```

### 2. **Controllo Accessor**
```php
// ❌ Sbagliato
public function getDisplayName(User $user): ?string
{
    if (property_exists($user, 'display_name')) {
        return $user->display_name; // mai eseguito
    }
    return null;
}

// ✅ Corretto
public function getDisplayName(User $user): ?string
{
    if (isset($user->display_name)) {
        return $user->display_name;
    }
    return null;
}
```

### 3. **Verifica Attributo Modello**
```php
// ❌ Sbagliato
public function isEmailSet(User $user): bool
{
    return property_exists($user, 'email'); // sempre false
}

// ✅ Corretto
public function isEmailSet(User $user): bool
{
    return isset($user->email) && !empty($user->email);
}
```

---

## 📋 Quick Reference

| Scopo | ✅ Metodo Corretto | ❌ Metodo Sbagliato |
|-------|-------------------|-------------------|
| Attributi Database | `isset($model->attribute)` | `property_exists($model, 'attribute')` |
| Relazioni | `isset($model->relation)`<br>`$model->relationLoaded('relation')` | `property_exists($model, 'relation')` |
| Accessor | `isset($model->accessor)` | `property_exists($model, 'accessor')` |
| Proprietà Reali | `property_exists($model, 'property')` | `isset($model->property)` |
| Verifica Esistenza Relazione | `$model->relation()->exists()` | `property_exists($model, 'relation')` |

---

## 📚 Riferimenti Correlati

- [Common Pitfalls](common-pitfalls.md) - Errori comuni con proprietà
- [Architecture Rules](architecture-rules.md) - Pattern Eloquent corretti
- [Code Quality](code-quality.md) - PHPStan e static analysis

---

**Versione**: 3.0 (Refactor DRY + KISS)  
**Priorità**: 🔥 URGENTE - Bug critici silenziosi  
**Aggiornamento**: Dicembre 2025

> **⚠️ AVVISO**: `property_exists()` su proprietà Eloquent è uno degli errori più comuni e difficili da debuggare in Laravel!