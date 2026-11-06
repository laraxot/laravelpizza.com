---
title: "Conversione servizi Notify a Spatie Queueable Actions"
type: note
status: draft
updated: 2026-10-20
tags: [docs, notify]
qmd: "conversione servizi notify a spatie queueable actions notify"
---
# Conversione servizi Notify a Spatie Queueable Actions

## Riepilogo

I servizi del modulo `Notify` ubicati in `laravel/Modules/Notify/app/Services/` sono stati convertiti ad
**Spatie Queueable Actions** (`spatie/laravel-queueable-action`), affinché ogni azione di invio
notifica/SMS/email sia eseguibile sia in modo **sincrono** che **asincrono su coda**.

Nessuna funzionalità esistente è stata rimossa: tutti i metodi originali (`send()`, `sendMultiple()`,
`getTemplate()`, `getTemplatesByCategory()`, `getTemplatesByChannel()`, `setLocalVars()`,
`mergeVars()`, `getInstance()`, `make()`, `try()` ecc.) restano intatti. Viene aggiunto un unico
punto di ingresso `execute()` per ogni servizio, che diventa il metodo invocabile dalla coda.

## File convertiti

| File | Namespace | Metodo principale `execute()` | Factory preservata |
|------|-----------|-------------------------------|--------------------|
| `app/Services/NotificationManager.php` | `Modules\Notify\Services` | `execute(Model $recipient, string $templateCode, array $data, array $channels, array $options): array` |: |
| `app/Services/SmsService.php` | `Modules\Notify\Services` | `execute(): self` | `getInstance()`, `make()` |
| `app/Services/MailEngines/MailtrapEngine.php` | `Modules\Notify\Services\MailEngines` | `execute(): void` | `getInstance()`, `make()` |

## Pattern applicato

Ogni servizio:

1. importa il trait `Spatie\QueueableAction\QueueableAction`;
2. dichiara `use QueueableAction;` all'interno della classe;
3. espone il metodo `execute()` contenente la logica principale (o delegando al metodo storico);
4. mantiene `declare(strict_types=1)`;
5. mantiene tutti i metodi pubblici originali, inclusi i factory `getInstance()` / `make()`.

```php
use Spatie\QueueableAction\QueueableAction;

class MioServizio
{
    use QueueableAction;

    // ... proprietà e metodi esistenti invariati ...

    public function execute(...): ... {
        return $this->send(...); // oppure la logica di invio diretta
    }
}
```

## Uso

### Sincrono (comportamento preesistente)

```php
$manager = app(NotificationManager::class);
$manager->send($recipient, 'template_code', $data, $channels, $options);

$sms = SmsService::make()->setLocalVars(['to' => '...', 'body' => '...'])->send();

$mail = MailtrapEngine::make()->setLocalVars(['from' => '...', 'to' => '...', 'body' => '...'])->try();
```

### Asincrono su coda (nuovo)

```php
// Dispatch sull'action queueable
app(NotificationManager::class)
    ->execute($recipient, 'template_code', $data, $channels, $options)
    ->dispatch(); // o ->dispatchSync(), ->dispatchAfterResponse(), ecc.

SmsService::make()->execute()->dispatch();
MailtrapEngine::make()->execute()->dispatch();
```

Il trait `QueueableAction` rende la classe istantaneabile come job Laravel: è sufficiente chiamare
`->dispatch()` sul risultato di `execute()` per accodare l'invio.

## Dettaglio per servizio

### NotificationManager (`send`, `sendMultiple`, `getTemplate`, `getTemplatesByCategory`, `getTemplatesByChannel`)

- **Scopo**: gestisce l'invio di notifiche multi-canale ai destinatari attraverso `SendNotificationAction`;
  recupera template attivi per codice, categoria e canale; espone stub di statistiche.
- **`execute()`**: replica la firma di `send()` e delega a quest'ultimo, preservando esattamente la
  logica di risoluzione template e invio.
- I metodi di lettura (`getTemplate`, `getTemplatesByCategory`, `getTemplatesByChannel`,
  `getTemplateStats`, `getRecipientStats`) restano invariati e sincroni.

### SmsService (`send`, `setLocalVars`, `mergeVars`, `getInstance`, `make`)

- **Scopo**: invia SMS tramite un driver configurabile (`netfun` di default), risolvendo dinamicamente
  la classe del motore SMS (`SmsEngines\{Driver}Engine`) e invocandone `setLocalVars` / `send` /
  `getVars` via reflection.
- **`execute()`**: delega a `send()` e restituisce `$this` per chaining.
- I factory `getInstance()` (singleton) e `make()` restano invariati.

### MailtrapEngine (`send`, `try`, `setLocalVars`, `mergeVars`, `getInstance`, `make`)

- **Scopo**: motore di invio email tramite Mailtrap. La logica di invio effettiva risiede in `try()`
  (validazione del destinatario e `Mail::raw()`); `send()` è marcato WIP (`dddx`).
- **`execute()`**: delega a `try()` (void).
- I factory `getInstance()` (singleton) e `make()` restano invariati.

## Requisito

Il pacchetto `spatie/laravel-queueable-action` deve essere installato e il trait
`Spatie\QueueableAction\QueueableAction` deve essere risolvibile dall'autoloader.

## Verifica

```bash
cd laravel
php -l Modules/Notify/app/Services/NotificationManager.php
php -l Modules/Notify/app/Services/SmsService.php
php -l Modules/Notify/app/Services/MailEngines/MailtrapEngine.php
vendor/bin/pint --dirty Modules/Notify
vendor/bin/phpstan analyse Modules/Notify
```
