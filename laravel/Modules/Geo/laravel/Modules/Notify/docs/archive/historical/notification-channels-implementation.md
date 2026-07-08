# Implementazione dei Canali di Notifica 

Questo documento descrive l'architettura e l'implementazione dei canali di notifica nel progetto , con particolare attenzione al pattern Factory utilizzato.
Questo documento descrive l'architettura e l'implementazione dei canali di notifica nel progetto <nome progetto>, con particolare attenzione al pattern Factory utilizzato.

## Architettura Generale

L'architettura dei canali di notifica segue un pattern coerente per tutti i tipi di comunicazione (SMS, WhatsApp, Telegram):

1. **Interfaccia comune**: Ogni tipo di comunicazione ha un'interfaccia dedicata
2. **DTO specifico**: Ogni tipo ha un DTO dedicato per i dati del messaggio
3. **Factory dedicata**: Ogni tipo ha una factory per la creazione delle azioni
4. **Canale di notifica**: Ogni tipo ha un canale per l'integrazione con Laravel
5. **Implementazioni per provider**: Ogni provider ha un'implementazione specifica

## Componenti per Tipo di Comunicazione

### SMS

- **Interfaccia**: `SmsActionInterface`
- **DTO**: `SmsData`
- **Factory**: `SmsActionFactory`
- **Canale**: `SmsChannel`
- **Azioni**: `SendSmsFactorSMSAction`, `SendTwilioSMSAction`, ecc.

### WhatsApp

- **Interfaccia**: `WhatsAppProviderActionInterface`
- **DTO**: `WhatsAppData`
- **Factory**: `WhatsAppActionFactory`
- **Canale**: `WhatsAppChannel`
- **Azioni**: `SendTwilioWhatsAppAction`, `SendFacebookWhatsAppAction`, ecc.

### Telegram

- **Interfaccia**: `TelegramProviderActionInterface`
- **DTO**: `TelegramData`
- **Factory**: `TelegramActionFactory`
- **Canale**: `TelegramChannel`
- **Azioni**: `SendOfficialTelegramAction`, `SendBotmanTelegramAction`, ecc.

## Pattern Factory

Il pattern Factory è stato implementato per centralizzare la logica di selezione del driver e la creazione delle azioni:

```php
// SmsActionFactory.php
public function create(?string $driver = null): SmsActionInterface
{
    $driver = $driver ?? Config::get('sms.default', 'smsfactor');
    
    return match ($driver) {
        'smsfactor' => app(SendSmsFactorSMSAction::class),
        'twilio' => app(SendTwilioSMSAction::class),
        // altri driver...
    };
}
```

Questo pattern offre diversi vantaggi:
- **Separazione delle responsabilità**: Ogni componente ha una responsabilità chiara
- **Riutilizzabilità**: La factory può essere utilizzata in qualsiasi punto dell'applicazione
- **Testabilità**: I componenti possono essere testati isolatamente
- **Flessibilità**: È possibile selezionare dinamicamente il driver
- **Estensibilità**: Nuovi driver possono essere aggiunti facilmente

## Utilizzo dei Canali di Notifica

### Definizione della Notifica

```php
use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\SmsChannel;
use Modules\Notify\Datas\SmsData;

class AppointmentReminder extends Notification
{
    public function via($notifiable)
    {
        return [SmsChannel::class];
    }
    
    public function toSms($notifiable)
    {
        return new SmsData(
            from: config('sms.from'),
            to: $notifiable->phone_number,
            body: "Promemoria: hai un appuntamento domani alle 15:00"
        );
    }
}
```

### Invio della Notifica

```php
$user->notify(new AppointmentReminder());
```

### Utilizzo Diretto delle Factory

```php
// In un controller
public function sendManualSms(SmsData $smsData, SmsActionFactory $factory)
{
    $action = $factory->create();
    return $action->execute($smsData);
}

// Con override del driver
public function sendEmergencySms(SmsData $smsData, SmsActionFactory $factory)
{
    $action = $factory->create('twilio'); // Usa sempre Twilio per messaggi urgenti
    return $action->execute($smsData);
}
```

## Principi di Design

L'implementazione segue i principi SOLID:

1. **Single Responsibility Principle**: Ogni classe ha una sola responsabilità
2. **Open/Closed Principle**: Il sistema è aperto all'estensione ma chiuso alla modifica
3. **Liskov Substitution Principle**: Le implementazioni sono intercambiabili
4. **Interface Segregation Principle**: Le interfacce sono specifiche per ogni tipo
5. **Dependency Inversion Principle**: Le dipendenze sono verso astrazioni, non implementazioni

## Considerazioni sulla Manutenibilità

L'architettura implementata facilita la manutenibilità:

1. **Coerenza**: Tutti i tipi di comunicazione seguono lo stesso pattern
2. **Modularità**: I componenti possono essere modificati indipendentemente
3. **Estensibilità**: Nuovi provider possono essere aggiunti facilmente
4. **Testabilità**: I componenti possono essere testati isolatamente

## Regole per Future Implementazioni

1. **Interfacce**: Posizionare le interfacce in `Modules/Notify/app/Contracts/`
2. **DTO**: Posizionare i DTO in `Modules/Notify/app/Datas/`
3. **Factory**: Posizionare le factory in `Modules/Notify/app/Factories/`
4. **Canali**: Posizionare i canali in `Modules/Notify/app/Channels/`
5. **Azioni**: Posizionare le azioni in `Modules/Notify/app/Actions/{Tipo}/`
6. **Configurazioni**: Posizionare le configurazioni in `Modules/Notify/config/`

## Conclusione

L'implementazione dei canali di notifica  segue un'architettura coerente e ben strutturata, basata sul pattern Factory. Questo approccio garantisce separazione delle responsabilità, riutilizzabilità, testabilità e manutenibilità, facilitando l'estensione del sistema con nuovi provider e tipi di comunicazione.


## Collegamenti a Documentazione Correlata
- [Modulo di Notifica](./index.md)
- [Panoramica dell'Architettura](./architecture.md)
- [Modelli di Email](./email_templates.md)
- [Implementazione SMS](./sms_implementation.md)
- [Risoluzione dei Problemi](./troubleshooting.md)

