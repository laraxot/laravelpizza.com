# Best Practices per Proprietà Modelli Eloquent - Modulo Notify

## ⚠️ Regola Critica: property_exists() VIETATO

**Nel modulo Notify, MAI utilizzare `property_exists()` con modelli Eloquent o oggetti che implementano `__get()`/`__set()`.**

## Problema Identificato e Risolto

### File Corretto: GenericNotification.php

Il file `laravel/Modules/Notify/app/Notifications/GenericNotification.php` è stato corretto per seguire le best practices corrette.

#### ❌ Codice Precedente (ERRATO)
```php
protected function getRecipientName($notifiable): string
{
    // Tenta di ottenere il nome dal destinatario in vari modi
    if (is_object($notifiable) && method_exists($notifiable, 'getFullName')) {
        return $notifiable->getFullName();
    }
    
    if (is_object($notifiable) && property_exists($notifiable, 'full_name') && $notifiable->full_name) {
        return (string) ($notifiable->full_name ?? '');
    }
    
    if (is_object($notifiable) && property_exists($notifiable, 'first_name') && $notifiable->first_name) {
        return (string) ($notifiable->first_name ?? '');
    }
    
    if (is_object($notifiable) && property_exists($notifiable, 'name') && $notifiable->name) {
        return (string) ($notifiable->name ?? '');
    }
    
    return 'Utente';
}
```

#### ✅ Codice Corretto (AGGIORNATO)
```php
protected function getRecipientName($notifiable): string
{
    // Tenta di ottenere il nome dal destinatario in vari modi
    if (is_object($notifiable) && method_exists($notifiable, 'getFullName')) {
        return $notifiable->getFullName();
    }
    
    // Usa isset invece di property_exists per proprietà magiche dei modelli
    if (is_object($notifiable) && isset($notifiable->full_name) && $notifiable->full_name) {
        return (string) $notifiable->full_name;
    }
    
    if (is_object($notifiable) && isset($notifiable->first_name) && $notifiable->first_name) {
        return (string) $notifiable->first_name;
    }
    
    if (is_object($notifiable) && isset($notifiable->name) && $notifiable->name) {
        return (string) $notifiable->name;
    }
    
    return 'Utente';
}
```

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

## Soluzioni Corrette per il Modulo Notify

### 1. Verifica Proprietà Magiche
```php
// ✅ CORRETTO
if (isset($notifiable->full_name) && $notifiable->full_name) {
    return (string) $notifiable->full_name;
}

// ❌ ERRATO
if (property_exists($notifiable, 'full_name') && $notifiable->full_name) {
    return (string) $notifiable->full_name;
}
```

### 2. Verifica Metodi
```php
// ✅ CORRETTO
if (method_exists($notifiable, 'getFullName')) {
    return $notifiable->getFullName();
}

// ❌ ERRATO
if (property_exists($notifiable, 'getFullName')) {
    return $notifiable->getFullName();
}
```

### 3. Verifica Accessors
```php
// ✅ CORRETTO
if ($notifiable->hasGetMutator('full_name') && $notifiable->full_name) {
    return (string) $notifiable->full_name;
}
```

### 4. Verifica Proprietà Database
```php
// ✅ CORRETTO
if ($notifiable->hasAttribute('email') && $notifiable->email) {
    return (string) $notifiable->email;
}
```

## Validazione PHPStan

Il file corretto passa la validazione PHPStan livello 9+:

```bash
cd /var/www/html/ptvx/laravel
./vendor/bin/phpstan analyze Modules/Notify/app/Notifications/GenericNotification.php --level=9
```

**Risultato**: ✅ Nessun errore rilevato

## Checklist per il Modulo Notify

Prima di ogni commit nel modulo Notify, verificare:

- [ ] Nessun uso di `property_exists()` con modelli Eloquent
- [ ] Uso di `isset()` per verificare proprietà magiche
- [ ] Uso di `method_exists()` per verificare metodi
- [ ] Uso di `hasAttribute()` per proprietà database
- [ ] Uso di `hasGetMutator()` per accessors
- [ ] PHPStan livello 9+ passa senza errori
- [ ] Test passano correttamente

## Riferimenti

- [Regola Cursor](../.cursor/rules/eloquent-properties.md)
- [Memoria Cursor](../.cursor/memories)
- [Linee Guida AI](../../.ai/guidelines/CORE.md)
- [File Corretto](../app/Notifications/GenericNotification.php)

## Esempi di Utilizzo nel Modulo

### Notifiche Email
```php
public function toMail($notifiable): MailMessage
{
    $recipientName = $this->getRecipientName($notifiable);
    
    return (new MailMessage())
        ->subject($this->title)
        ->greeting('Gentile ' . $recipientName)
        ->line($this->message);
}
```

### Notifiche SMS
```php
public function toTwilio($notifiable): array
{
    $to = '';
    if (is_object($notifiable) && method_exists($notifiable, 'routeNotificationForTwilio')) {
        $routeResult = $notifiable->routeNotificationForTwilio($this);
        $to = (string) ($routeResult ?? '');
    }
    
    return [
        'content' => $this->message,
        'to' => $to,
    ];
}
```

### Notifiche Database
```php
public function toDatabase($notifiable): array
{
    return [
        'title' => $this->title,
        'message' => $this->message,
        'data' => $this->data,
        'created_at' => now()->toIso8601String(),
    ];
}
```

*Ultimo aggiornamento: Giugno 2025*
*File corretto: GenericNotification.php*
