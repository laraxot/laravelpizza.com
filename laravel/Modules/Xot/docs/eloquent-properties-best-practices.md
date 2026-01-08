# Best Practices per Proprietà Modelli Eloquent - Modulo Xot

## ✅ STATO: property_exists() ELIMINATO (Data: 2025-01-05)

**Nel modulo Xot, `property_exists()` è stato completamente eliminato dal codice eseguibile.**

### Correzioni Applicate
- ✅ `Console/Commands/SearchTextInDbCommand.php` - sostituito con `isset()`
- ✅ `Filament/Support/ColumnBuilder.php` - sostituito con `isset()` (3 occorrenze)
- ✅ PHPDoc generati automaticamente per tutti i modelli con `php artisan ide-helper:models`

## ⚠️ Regola Critica: property_exists() VIETATO

**Nel modulo Xot e in tutti i moduli che lo estendono, MAI utilizzare `property_exists()` con modelli Eloquent o oggetti che implementano `__get()`/`__set()`.**

## Problema Identificato e Risolto

### File Corretto: GenericNotification.php (Modulo Notify)

Il file `laravel/Modules/Notify/app/Notifications/GenericNotification.php` è stato corretto per seguire le best practices corrette, dimostrando l'approccio giusto per tutti i moduli.

## Perché property_exists() è Problematico

### 1. Proprietà Dinamiche
I modelli Eloquent creano proprietà dinamicamente quando si accede alle colonne del database:
```php
// Questa proprietà non "esiste" finché non viene accessa
$user = User::find(1);
property_exists($user, 'email'); // Può restituire false
isset($user->email); // Funziona correttamente
```

### 2. Lazy Loading
Le relazioni vengono caricate solo quando accesse:
```php
$user = User::find(1);
property_exists($user, 'profile'); // Può restituire false
isset($user->profile); // Funziona correttamente
```

### 3. Accessors/Mutators
Le proprietà calcolate possono non essere rilevate:
```php
$user = User::find(1);
property_exists($user, 'full_name'); // Può restituire false
isset($user->full_name); // Funziona correttamente
```

### 4. Metodi Magici
Laravel usa `__get()` e `__set()` per gestire l'accesso alle proprietà:
```php
// property_exists non rispetta la magia di Laravel
// isset funziona correttamente con __get() e __set()
```

## Soluzioni Corrette per Tutti i Moduli

### 1. Verifica Proprietà Magiche
```php
// ✅ CORRETTO
if (isset($model->property_name) && $model->property_name) {
    return $model->property_name;
}

// ❌ ERRATO
if (property_exists($model, 'property_name') && $model->property_name) {
    return $model->property_name;
}
```

### 2. Verifica Metodi
```php
// ✅ CORRETTO
if (method_exists($model, 'methodName')) {
    return $model->methodName();
}

// ❌ ERRATO
if (property_exists($model, 'methodName')) {
    return $model->methodName();
}
```

### 3. Verifica Accessors
```php
// ✅ CORRETTO
if ($model->hasGetMutator('property_name') && $model->property_name) {
    return $model->property_name;
}
```

### 4. Verifica Proprietà Database
```php
// ✅ CORRETTO
if ($model->hasAttribute('column_name') && $model->column_name) {
    return $model->column_name;
}
```

### 5. Verifica Relazioni
```php
// ✅ CORRETTO
if (isset($user->profile) && $user->profile) {
    return $user->profile->bio;
}

// ❌ ERRATO
if (property_exists($user, 'profile') && $user->profile) {
    return $user->profile->bio;
}
```

## Quando Usare property_exists

`property_exists()` può essere usato SOLO con:

1. **Classi standard PHP** (non modelli Eloquent)
2. **Oggetti senza metodi magici**
3. **Proprietà dichiarate esplicitamente**

```php
// ✅ CORRETTO - Classe standard PHP
class StandardClass {
    public $property;
}

$obj = new StandardClass();
if (property_exists($obj, 'property')) {
    // OK
}

// ❌ ERRATO - Modello Eloquent
$user = User::find(1);
if (property_exists($user, 'email')) {
    // MAI FARE QUESTO
}
```

## Esempi di Utilizzo nei Moduli

### Modulo User
```php
// ✅ CORRETTO
public function getDisplayName(): string
{
    if (isset($this->full_name) && $this->full_name) {
        return $this->full_name;
    }
    
    if (isset($this->first_name) && $this->first_name) {
        return $this->first_name;
    }
    
    return 'Utente';
}
```

### Modulo Performance
```php
// ✅ CORRETTO
public function getScore(): float
{
    if (isset($this->calculated_score) && $this->calculated_score) {
        return $this->calculated_score;
    }
    
    return 0.0;
}
```

### Modulo Ptv
```php
// ✅ CORRETTO
public function getStatus(): string
{
    if (isset($this->current_status) && $this->current_status) {
        return $this->current_status;
    }
    
    return 'pending';
}
```

## Validazione PHPStan

Tutti i file devono passare la validazione PHPStan livello 9+:

```bash
cd /var/www/html/ptvx/laravel
./vendor/bin/phpstan analyze Modules --level=9
```

## Checklist per Tutti i Moduli

Prima di ogni commit in qualsiasi modulo, verificare:

- [ ] Nessun uso di `property_exists()` con modelli Eloquent
- [ ] Nessun uso di `property_exists()` con oggetti che implementano `__get()`/`__set()`
- [ ] Uso di `isset()` per verificare proprietà magiche
- [ ] Uso di `method_exists()` per verificare metodi
- [ ] Uso di `hasAttribute()` per proprietà database
- [ ] Uso di `hasGetMutator()` per accessors
- [ ] PHPStan livello 9+ passa senza errori
- [ ] Test passano correttamente

## Riferimenti

- [Regola Cursor](../../.cursor/rules/eloquent-properties.md)
- [Memoria Cursor](../../.cursor/memories)
- [Linee Guida AI](../../.ai/guidelines/CORE.md)
- [Esempio Corretto](../../Notify/app/Notifications/GenericNotification.php)

## Esempi di Correzione

### Prima (ERRATO)
```php
if (is_object($notifiable) && property_exists($notifiable, 'full_name') && $notifiable->full_name) {
    return (string) ($notifiable->full_name ?? '');
}
```

### Dopo (CORRETTO)
```php
if (is_object($notifiable) && isset($notifiable->full_name) && $notifiable->full_name) {
    return (string) $notifiable->full_name;
}
```

## Impatto sui Moduli

Questa regola si applica a tutti i moduli che estendono Xot:

- **User**: Gestione utenti e autenticazione
- **Performance**: Gestione performance e valutazioni
- **Ptv**: Modulo specifico del progetto
- **UI**: Componenti UI condivisi
- **Notify**: Sistema di notifiche
- **Altri moduli**: Qualsiasi modulo che estende Xot

## Riferimenti Tecnici

- [Laravel Eloquent Properties](https://laravel.com/docs/11.x/eloquent#accessing-attributes)
- [PHP Magic Methods](https://www.php.net/manual/en/language.oop5.magic.php)
- [PHPStan Eloquent Analysis](https://phpstan.org/user-guide/rule-levels)

*Ultimo aggiornamento: Giugno 2025*
*Regola applicabile a tutti i moduli*
