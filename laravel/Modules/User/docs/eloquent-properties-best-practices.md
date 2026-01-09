# 🛡️ Best Practices per Proprietà Eloquent

## ⚠️ Regola Critica: property_exists() VIETATO

**Nel modulo User, MAI utilizzare `property_exists()` con modelli Eloquent o oggetti che implementano `__get()`/`__set()`.**

## ❌ Codice Problematico

```php
// ❌ SBAGLIATO - property_exists non funziona con proprietà magiche
if (property_exists($user, 'full_name') && $user->full_name) {
    // Questo può restituire false anche se la proprietà esiste
}

if (property_exists($user, 'first_name') && $user->first_name) {
    // Falso negativo per accessors
}

if (property_exists($user, 'name') && $user->name) {
    // Falso negativo per attributi di colonna
}
```

## ✅ Codice Corretto

```php
// ✅ CORRETTO - Usa isset() per proprietà magiche
if (isset($user->full_name) && $user->full_name) {
    // isset() funziona con __get()
}

// ✅ CORRETTO - Usa getAttribute() per accesso sicuro
$firstName = $user->getAttribute('first_name');
if ($firstName !== null) {
    // getAttribute() accede sia a colonne che a accessors
}

// ✅ CORRETTO - Usa hasAttribute() per verificare esistenza
if ($user->hasAttribute('name')) {
    $name = $user->getAttribute('name');
}

// ✅ CORRETTO - Usa array_key_exists() per array
if (array_key_exists('settings', $user->toArray())) {
    $settings = $user->settings;
}
```

## 🧠 Perché property_exists() è Problematico

### 1. **Proprietà Magiche di Eloquent**
```php
class User extends Model {
    // Questa proprietà non esiste realmente come proprietà PHP
    // È accessibile tramite __get() e __set()
    public function getFullNameAttribute(): string {
        return $this->first_name . ' ' . $this->last_name;
    }
}

property_exists($user, 'full_name'); // Può restituire false
isset($user->full_name); // Restituisce true se l'accessor esiste
```

### 2. **Relazioni Eloquent**
```php
class User extends Model {
    public function profile(): HasOne {
        return $this->hasOne(Profile::class);
    }
}

property_exists($user, 'profile'); // Può restituire false
isset($user->profile); // Restituisce true se la relazione è caricata
```

### 3. **Attributi di Colonna**
```php
// Anche le colonne del database sono accessibili tramite __get()
property_exists($user, 'email'); // Può restituire false
isset($user->email); // Restituisce true se la colonna esiste
```

## 🛠️ Alternative Sicure

### 1. **Per Verifica Esistenza**
```php
// ❌ SBAGLIATO
if (property_exists($notifiable, 'full_name') && $notifiable->full_name) {
    // Codice...
}

// ✅ CORRETTO
if (isset($notifiable->full_name) && $notifiable->full_name) {
    // Codice...
}

// ✅ ANCORA MEGLIO - Type safe
$fullName = $notifiable->getAttribute('full_name');
if (is_string($fullName) && $fullName !== '') {
    // Codice...
}
```

### 2. **Per Metodi**
```php
// ❌ SBAGLIATO
if (property_exists($notifiable, 'getFullName')) {
    // property_exists non funziona con metodi
}

// ✅ CORRETTO
if (method_exists($notifiable, 'getFullName')) {
    $fullName = $notifiable->getFullName();
}
```

### 3. **Per Array di Dati**
```php
// ✅ CORRETTO - Per array
$data = $notifiable->toArray();
if (array_key_exists('full_name', $data) && $data['full_name']) {
    // Codice...
}
```

## 🔧 Esempi Pratici

### Esempio 1: Activity Logger
```php
// ❌ VECCHIO
if (property_exists($user, 'id')) {
    $userId = $user->id;
}

// ✅ NUOVO
$userId = $user->getAttribute('id');
```

### Esempio 2: User Data Action
```php
// ❌ VECCHIO
$avatarValue = property_exists($user, 'avatar') ? $user->avatar : null;

// ✅ NUOVO
$avatarValue = $user->getAttribute('avatar');
```

### Esempio 3: Notifications
```php
// ❌ VECCHIO
if (property_exists($notifiable, 'email') && $notifiable->email) {
    $this->to[] = $notifiable->email;
}

// ✅ NUOVO
$email = $notifiable->getAttribute('email');
if (is_string($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $this->to[] = $email;
}
```

## 📋 Checklist di Verifica

- [ ] **Nessun uso di `property_exists()` con modelli Eloquent**
- [ ] **Utilizzo di `isset()` per proprietà magiche**
- [ ] **Utilizzo di `getAttribute()` per accesso sicuro**
- [ ] **Utilizzo di `hasAttribute()` per verificare esistenza**
- [ ] **Utilizzo di `method_exists()` per metodi**
- [ ] **Utilizzo di `array_key_exists()` per array**
- [ ] **Type hints appropriati per PHPStan**

## 🔗 Riferimenti

- [Laravel Eloquent: Accessors & Mutators](https://laravel.com/docs/eloquent-mutators)
- [PHP Magic Methods](https://www.php.net/manual/en/language.oop5.magic.php)
- [PHPStan Laravel Integration](https://github.com/larastan/larastan)

---

**Ultimo aggiornamento**: 2025-11-05
**Stato**: ✅ Best Practices Implementate
**Verificato con**: PHPStan Level 10
