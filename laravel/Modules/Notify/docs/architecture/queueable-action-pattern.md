# QueueableAction Pattern Guide

## 📖 **Introduzione**

Il pattern QueueableAction è una parte fondamentale dell'architettura del progetto Laraxot. Questo pattern permette di incapsulare la logica di business in classi riutilizzabili che possono essere eseguite sia sincronamente che asincronamente.

## 🏗️ **Struttura Base**

### Implementazione Standard
```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use Modules\Notify\Models\Notification as NotificationModel;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Notifications\GenericNotification;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per l'invio di notifiche multi-canale.
 */
class SendNotificationAction
{
    use QueueableAction;

    /**
     * @param array<string, mixed> $data
     * @param array<int, string> $channels
     * @param array<string, mixed> $options
     *
     * @return NotificationModel|null
     *
     * @throws Exception
     */
    public function handle(
        Model $recipient,
        string $templateCode,
        array $data = [],
        array $channels = [],
        array $options = [],
    ): ?NotificationModel {
        // Implementazione della logica di business
    }
}
```

## 🔧 **Metodi Principali**

### `handle()` - Metodo Principale
Il metodo `handle()` è il cuore dell'azione. È il metodo che viene chiamato quando l'azione viene eseguita.

```php
public function handle(
    Model $recipient,
    string $templateCode,
    array $data = [],
    array $channels = [],
    array $options = [],
): ?NotificationModel {
    // Logica di business qui
}
```

### `queue()` - Metodo per Code Quality
Il metodo `queue()` permette di accodare l'azione per l'esecuzione asincrona.

```php
public function queue(
    Model $recipient,
    string $templateCode,
    array $data = [],
    array $channels = [],
    array $options = [],
): self {
    // Implementazione per accodamento
}
```

## 🎯 **Best Practices**

### 1. **Type Safety**
- Utilizzare sempre tipi di ritorno espliciti
- Tipizzare tutti i parametri con union types
- Usare PHPDoc per documentare i tipi

```php
/**
 * @param array<string, mixed> $data
 * @param array<int, string> $channels
 * @param array<string, mixed> $options
 *
 * @return NotificationModel|null
 */
public function handle(
    Model $recipient,
    string $templateCode,
    array $data = [],
    array $channels = [],
    array $options = [],
): ?NotificationModel
```

### 2. **Exception Handling**
- Usare Exception per errori gestiti
- Lanciare eccezioni con messaggi significativi
- Non catturare eccezioni senza motivo

```php
if (! $template instanceof NotificationTemplate) {
    throw new Exception("Template {$templateCode} non trovato o non attivo");
}
```

### 3. **Logging**
- Usare Log::info() per operazioni di business significative
- Usare Log::warning() per condizioni che richiedono attenzione
- Non usare Log::info() per operazioni routine

```php
Log::info('Invio notifica', [
    'recipient_id' => $recipient->id,
    'template_code' => $templateCode,
]);
```

## 🔄 **Utilizzo Sincrono vs Asincrono**

### Sincrono
```php
$notificationAction = app(SendNotificationAction::class);
$notification = $notificationAction->handle(
    $recipient,
    'welcome_email',
    ['name' => $recipient->name],
    ['mail'],
    []
);
```

### Asincrono
```php
$notificationAction = app(SendNotificationAction::class);
$notificationAction
    ->queue($recipient, 'welcome_email', ['name' => $recipient->name])
    ->onQueue('notifications');
```

## 📋 **Convenzioni del Progetto**

### 1. **Nomenclatura**
- I nomi delle classi devono essere in PascalCase
- I nomi dei metodi devono essere in camelCase
- I nomi delle variabili devono essere descrittivi

### 2. **Directory Structure**
```
Modules/ModuleName/
├── app/
│   ├── Actions/
│   │   └── SendNotificationAction.php
│   ├── Jobs/
│   │   └── SendNotificationJob.php
│   └── Services/
│       └── NotificationManager.php
```

### 3. **Test Coverage**
- Ogni QueueableAction deve avere test unitari
- I test devono coprire i diversi scenari di successo/errore
- I test devono essere eseguiti con `php artisan test`

## 🔍 **Debugging**

### 1. **Logging**
```php
Log::debug('Debug info', [
    'recipient' => $recipient->toArray(),
    'template' => $templateCode,
    'data' => $data,
]);
```

### 2. **Testing**
```php
it('invia notifica correttamente', function () {
    $recipient = User::factory()->create();
    
    $notification = app(SendNotificationAction::class)->handle(
        $recipient,
        'welcome_email',
        ['name' => $recipient->name]
    );
    
    expect($notification)->toBeInstanceOf(NotificationModel::class);
});
```

## 📚 **Riferimenti**

- [Spatie QueueableAction Documentation](https://docs.spatie.be/laravel-queueable-action/)
- [Laraxot Architecture Patterns](../../docs/architecture-patterns.md)
- [PHPStan Level 10 Guide](../phpstan-level10-guide.md)

---
*Ultimo aggiornamento: Marzo 2026*
*Versione: 1.0.0*