# Convenzioni di Naming

## Regole Generali
1. **CamelCase per Classi e Metodi**
   - Usa PascalCase per i nomi delle classi
   - Usa camelCase per i nomi dei metodi
   - Evita abbreviazioni non standard

2. **Acronimi**
   - Gli acronimi devono essere trattati come parole singole
   - Esempio: `Sms` non `SMS`, `Http` non `HTTP`
   - Questo si applica sia a classi che a metodi

3. **Suffissi**
   - Le classi Page devono terminare con `Page`
   - Le classi Controller devono terminare con `Controller`
   - Le classi Service devono terminare con `Service`

## Esempi Corretti e Incorretti

### Classi
```php
// ✅ Corretto
class SendSmsPage extends XotBasePage
class HttpRequest
class SmsNotification

// ❌ Incorretto
class SendSMSPage extends XotBasePage
class HTTPRequest
class SMSNotification
```

### Metodi
```php
// ✅ Corretto
public function sendSms(): void
public function handleHttpRequest(): void

// ❌ Incorretto
public function sendSMS(): void
public function handleHTTPRequest(): void
```

## Motivazione
1. **Consistenza**: Mantenere uno stile coerente in tutto il codice
2. **Leggibilità**: Rendere il codice più facile da leggere e mantenere
3. **Standard**: Seguire le convenzioni PSR e le best practices di Laravel
4. **Prevenzione Errori**: Evitare confusione e potenziali bug

## Implementazione
- Verificare sempre i nomi delle classi e dei metodi
- Usare strumenti di analisi statica
- Seguire le convenzioni del framework
- Documentare eventuali eccezioni

# Convenzioni di Naming per le Azioni di Notifica

Questo documento definisce le convenzioni di naming standardizzate per le azioni di notifica nel sistema , supportando la risoluzione dinamica delle classi implementata nei factory.
Questo documento definisce le convenzioni di naming standardizzate per le azioni di notifica nel sistema <nome progetto>, supportando la risoluzione dinamica delle classi implementata nei factory.

## Pattern di Naming

### Azioni SMS

```
Send{Driver}SMSAction
```

Esempi:
- `SendSmsFactorSMSAction` (per il driver 'smsfactor')
- `SendTwilioSMSAction` (per il driver 'twilio')
- `SendNexmoSMSAction` (per il driver 'nexmo')

### Azioni WhatsApp

```
Send{Driver}WhatsAppAction
```

Esempi:
- `SendTwilioWhatsAppAction` (per il driver 'twilio')
- `SendFacebookWhatsAppAction` (per il driver 'facebook')
- `Send360dialogWhatsAppAction` (per il driver '360dialog')

### Azioni Telegram

```
Send{Driver}TelegramAction
```

Esempi:
- `SendOfficialTelegramAction` (per il driver 'official')
- `SendBotmanTelegramAction` (per il driver 'botman')
- `SendNutgramTelegramAction` (per il driver 'nutgram')

## Regole di Normalizzazione

1. **Prima lettera maiuscola**: La prima lettera del nome del driver viene convertita in maiuscolo
2. **Resto in minuscolo**: Il resto del nome del driver viene convertito in minuscolo
3. **Rimozione caratteri speciali**: Per driver con caratteri non alfanumerici (es. '360dialog'), i caratteri speciali vengono rimossi

## Namespace

Tutte le azioni devono essere posizionate nel namespace corretto:

- SMS: `Modules\Notify\Actions\SMS`
- WhatsApp: `Modules\Notify\Actions\WhatsApp`
- Telegram: `Modules\Notify\Actions\Telegram`

## Implementazione dell'Interfaccia

Ogni azione deve implementare l'interfaccia corrispondente:

- SMS: `Modules\Notify\Contracts\SmsActionInterface`
- WhatsApp: `Modules\Notify\Contracts\WhatsAppProviderActionInterface`
- Telegram: `Modules\Notify\Contracts\TelegramProviderActionInterface`

## Esempio di Implementazione

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Modules\Notify\Contracts\SmsActionInterface;
use Modules\Notify\Datas\SmsData;

final class SendNewProviderSMSAction implements SmsActionInterface
{
    public function execute(SmsData $smsData): array
    {
        // Implementazione...
        
        return [
            'success' => true,
            // Altri dati...
        ];
    }
}
```

## Vantaggi della Standardizzazione

1. **Coerenza**: Tutte le azioni seguono lo stesso pattern di naming
2. **Prevedibilità**: È facile prevedere il nome di una classe dato il nome del driver
3. **Automazione**: Supporta la risoluzione dinamica delle classi nei factory
4. **Documentazione**: Facilita la comprensione e la documentazione del codice

## Aggiunta di Nuovi Driver

Per aggiungere un nuovo driver:

1. Aggiungere il driver alla configurazione (es. `config/sms.php`)
2. Creare una nuova classe che segue la convenzione di naming
3. Implementare l'interfaccia corrispondente

Non è necessario modificare i factory, poiché utilizzano la risoluzione dinamica delle classi.

## Casi Speciali

### Driver con Caratteri Speciali

Per driver con caratteri speciali (es. '360dialog'), i caratteri non alfanumerici vengono rimossi:

```php
$normalizedDriver = preg_replace('/[^a-zA-Z0-9]/', '', ucfirst(strtolower($driver)));
```

Esempio: '360dialog' → 'Send360dialogWhatsAppAction'

### Driver con Nomi Composti

Per driver con nomi composti (es. 'sms_factor'), ogni parola deve iniziare con una lettera maiuscola:

```php
$normalizedDriver = str_replace(' ', '', ucwords(str_replace('_', ' ', $driver)));
```

Esempio: 'sms_factor' → 'SendSmsFactorSMSAction'
