# RecordNotification: Analisi e Implementazione Ottimale

## Analisi del Sistema Attuale

`RecordNotification` è un componente fondamentale del sistema di notifiche multi-canale di <nome progetto>. La sua implementazione attuale, sebbene funzionale, presenta diverse aree di miglioramento per rispettare pienamente gli standard del progetto.

### Stato Attuale

La classe `RecordNotification` è progettata per inviare notifiche basate su record del database, con supporto per email e SMS. Tuttavia, l'implementazione presenta:

1. Codice di debug commentato
2. Implementazione incompleta per SMS
3. Mancanza di supporto per altri canali (Telegram, WhatsApp, ecc.)
4. Assenza di integrazione con il sistema di traduzioni

## Proposta di Implementazione Ottimizzata

### 1. Struttura Base Migliorata

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\SmsChannel;
use Modules\Notify\Channels\TelegramChannel;
use Modules\Notify\Channels\WhatsAppChannel;
use Modules\Notify\Datas\NotificationData;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Datas\TelegramData;
use Modules\Notify\Datas\WhatsAppData;
use Modules\Notify\Emails\SpatieEmail;
use Modules\Notify\Enums\NotificationChannel;
use Spatie\QueueableAction\QueueableAction;

class RecordNotification extends Notification
{
    use QueueableAction;

    public function __construct(
        protected readonly Model $record,
        protected readonly string $slug,
        protected readonly ?array $channels = null,
        protected readonly ?array $extraData = null
    ) {}

    public function via($notifiable): array
    {
        // Se sono specificati canali espliciti, usa quelli
        if (is_array($this->channels) && !empty($this->channels)) {
            return $this->mapChannelsToClasses($this->channels);
        }

        // Altrimenti determina i canali dalla configurazione del template
        $template = $this->getNotificationTemplate();
        if ($template && $template->channels) {
            return $this->mapChannelsToClasses($template->channels);
        }

        // Fallback a email
        return ['mail'];
    }

    protected function mapChannelsToClasses(array $channels): array
    {
        $mapping = [
            NotificationChannel::EMAIL->value => 'mail',
            NotificationChannel::SMS->value => SmsChannel::class,
            NotificationChannel::TELEGRAM->value => TelegramChannel::class,
            NotificationChannel::WHATSAPP->value => WhatsAppChannel::class,
            NotificationChannel::PUSH->value => 'database',
        ];

        return array_map(
            fn (string $channel) => $mapping[$channel] ?? $channel,
            $channels
        );
    }

    protected function getNotificationTemplate()
    {
        // Recupero del template dal database usando lo slug
        return NotificationTemplate::where('slug', $this->slug)->first();
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): SpatieEmail
    {
        $email = new SpatieEmail($this->record, $this->slug, $this->extraData);

        // Impostare esplicitamente il destinatario (regola OBBLIGATORIA)
        if (method_exists($notifiable, 'routeNotificationFor')) {
            $email->to($notifiable->routeNotificationFor('mail'));
        }

        return $email;
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms($notifiable): SmsData
    {
        // Recupera template e contenuto
        $template = $this->getNotificationTemplate();
        $content = $template->renderTemplate($this->record, $this->extraData, 'sms');

        // Determina il numero di destinazione
        $to = null;
        if (method_exists($notifiable, 'routeNotificationFor')) {
            $to = $notifiable->routeNotificationFor('sms');
        }

        if (!$to) {
            throw new \Exception('No destination phone number for SMS notification');
        }

        // Crea e restituisce l'oggetto SmsData
        return SmsData::from([
            'from' => config('notify.sms.default_sender', '<nome progetto>'),
            'to' => $to,
            'body' => $content,
        ]);
    }

    /**
     * Get the Telegram representation of the notification.
     */
    public function toTelegram($notifiable): TelegramData
    {
        // Recupera template e contenuto
        $template = $this->getNotificationTemplate();
        $content = $template->renderTemplate($this->record, $this->extraData, 'telegram');

        // Determina l'ID chat Telegram
        $chatId = null;
        if (method_exists($notifiable, 'routeNotificationFor')) {
            $chatId = $notifiable->routeNotificationFor('telegram');
        }

        if (!$chatId) {
            throw new \Exception('No destination chat ID for Telegram notification');
        }

        // Crea e restituisce l'oggetto TelegramData
        return TelegramData::from([
            'chat_id' => $chatId,
            'message' => $content,
            'parse_mode' => 'HTML',
        ]);
    }

    /**
     * Get the WhatsApp representation of the notification.
     */
    public function toWhatsApp($notifiable): WhatsAppData
    {
        // Recupera template e contenuto
        $template = $this->getNotificationTemplate();
        $content = $template->renderTemplate($this->record, $this->extraData, 'whatsapp');

        // Determina il numero di destinazione
        $to = null;
        if (method_exists($notifiable, 'routeNotificationFor')) {
            $to = $notifiable->routeNotificationFor('whatsapp');
        }

        if (!$to) {
            throw new \Exception('No destination phone number for WhatsApp notification');
        }

        // Crea e restituisce l'oggetto WhatsAppData
        return WhatsAppData::from([
            'to' => $to,
            'body' => $content,
        ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        // Recupera template e contenuto
        $template = $this->getNotificationTemplate();
        $content = $template->renderTemplate($this->record, $this->extraData, 'database');

        return [
            'title' => $template->name,
            'body' => $content,
            'record_type' => get_class($this->record),
            'record_id' => $this->record->getKey(),
            'extra_data' => $this->extraData,
        ];
    }
}
```

### 2. Enum per i Canali di Notifica

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Enums;

enum NotificationChannel: string
{
    case EMAIL = 'email';
    case SMS = 'sms';
    case TELEGRAM = 'telegram';
    case WHATSAPP = 'whatsapp';
    case PUSH = 'push';
    
    // Non utilizziamo label() ma lasciamo che le etichette vengano dai file di traduzione
}
```

### 3. File di Traduzione per le Notifiche

```php
// Modules/Notify/lang/it/notification.php
return [
    'channels' => [
        'email' => [
            'label' => 'Email',
            'description' => 'Notifiche via email',
        ],
        'sms' => [
            'label' => 'SMS',
            'description' => 'Notifiche via SMS',
        ],
        'telegram' => [
            'label' => 'Telegram',
            'description' => 'Notifiche via Telegram',
        ],
        'whatsapp' => [
            'label' => 'WhatsApp',
            'description' => 'Notifiche via WhatsApp',
        ],
        'push' => [
            'label' => 'Push',
            'description' => 'Notifiche push nel browser o app',
        ],
    ],
    'templates' => [
        'fields' => [
            'slug' => [
                'label' => 'Slug',
                'placeholder' => 'Identificativo univoco del template',
                'help' => 'Usato per riferirsi al template nel codice',
            ],
            'name' => [
                'label' => 'Nome',
                'placeholder' => 'Nome del template',
            ],
            'channels' => [
                'label' => 'Canali',
                'help' => 'Canali su cui inviare la notifica',
            ],
            // Altri campi...
        ],
    ],
];
```

### 4. Data Objects per Dati Strutturati

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class SmsData extends Data
{
    public function __construct(
        public readonly string $from,
        public readonly string $to,
        public readonly string $body,
    ) {}
}

class TelegramData extends Data
{
    public function __construct(
        public readonly string $chat_id,
        public readonly string $message,
        public readonly string $parse_mode = 'HTML',
        public readonly ?array $reply_markup = null,
    ) {}
}

class WhatsAppData extends Data
{
    public function __construct(
        public readonly string $to,
        public readonly string $body,
        public readonly ?array $media = null,
    ) {}
}

class NotificationData extends Data
{
    public function __construct(
        public readonly string $slug,
        public readonly array $data,
        public readonly array $channels = [],
    ) {}
}
```

### 5. Widget Filament per Invio Notifiche

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Widgets;

use Filament\Forms;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Actions\SendNotificationAction;
use Modules\Notify\Enums\NotificationChannel;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class SendNotificationWidget extends XotBaseWidget
{
    protected static string $view = 'notify::widgets.send-notification';
    
    // Il Model a cui verrà associata la notifica
    public ?Model $record = null;
    
    public function mount(?Model $record = null): void
    {
        $this->record = $record;
    }
    
    public function getFormSchema(): array
    {
        return [
            'template_slug' => Forms\Components\Select::make('template_slug')
                ->options(function () {
                    return NotificationTemplate::pluck('name', 'slug')->toArray();
                })
                ->required(),
                
            'channels' => Forms\Components\CheckboxList::make('channels')
                ->options(NotificationChannel::class)
                ->required(),
                
            'recipients' => Forms\Components\Repeater::make('recipients')
                ->schema([
                    'type' => Forms\Components\Select::make('type')
                        ->options([
                            'email' => 'Email',
                            'phone' => 'Telefono',
                            'user_id' => 'Utente',
                        ])
                        ->reactive()
                        ->required(),
                        
                    'value' => Forms\Components\TextInput::make('value')
                        ->required(),
                ]),
                
            'extra_data' => Forms\Components\KeyValue::make('extra_data')
                ->keyLabel('Chiave')
                ->valueLabel('Valore')
                ->keyPlaceholder('Inserisci chiave')
                ->valuePlaceholder('Inserisci valore'),
        ];
    }
    
    public function send(): void
    {
        $data = $this->form->getState();
        
        // Validare i dati
        $this->validate();
        
        // Preparare i destinatari
        $recipients = collect($data['recipients'])->map(function ($recipient) {
            return match ($recipient['type']) {
                'email' => ['mail' => $recipient['value']],
                'phone' => ['sms' => $recipient['value'], 'whatsapp' => $recipient['value']],
                'user_id' => app(\App\Models\User::class)->findOrFail($recipient['value']),
                default => null,
            };
        })->filter();
        
        // Inviare notifica per ogni destinatario
        $recipients->each(function ($recipient) use ($data) {
            app(SendNotificationAction::class)->handle(
                $this->record,
                $data['template_slug'],
                $recipient,
                $data['channels'],
                $data['extra_data'] ?? []
            );
        });
        
        // Mostrare notifica di successo
        $this->notify('success', 'Notifica inviata con successo');
    }
}
```

### 6. Interfaccia QueueableAction per Invio Notifiche

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Notifications\RecordNotification;
use Spatie\QueueableAction\QueueableAction;

class SendNotificationAction
{
    use QueueableAction;
    
    /**
     * Invia una notifica a un destinatario utilizzando il sistema RecordNotification.
     *
     * @param Model $record Il record a cui è associata la notifica
     * @param string $slug Lo slug del template di notifica
     * @param mixed $recipient Il destinatario (User, array con chiavi dei canali, ecc.)
     * @param array|null $channels Array di canali su cui inviare la notifica
     * @param array|null $extraData Dati aggiuntivi per il rendering del template
     * @return void
     */
    public function handle(
        Model $record,
        string $slug,
        mixed $recipient,
        ?array $channels = null,
        ?array $extraData = null
    ): void {
        // Se il destinatario è un array di route per canali (es. ['mail' => 'email@example.com'])
        if (is_array($recipient)) {
            $notifiable = new AnonymousNotifiable();
            
            foreach ($recipient as $channel => $route) {
                $notifiable->route($channel, $route);
            }
            
            Notification::send(
                $notifiable,
                new RecordNotification($record, $slug, $channels, $extraData)
            );
            
            return;
        }
        
        // Altrimenti invia direttamente all'oggetto notifiable
        $recipient->notify(new RecordNotification($record, $slug, $channels, $extraData));
    }
}
```

## Zen e Filosofia del Sistema di Notifiche

### 1. Principio di Univocità del Contenuto

Il sistema di notifiche RecordNotification segue il principio di "Write Once, Notify Everywhere": il contenuto delle notifiche è definito una sola volta nei template e può essere adattato automaticamente per ogni canale, mantenendo un'esperienza utente coerente attraverso tutti i touchpoint.

### 2. Minima Interferenza, Massima Espressività

Il design del sistema permette agli sviluppatori di inviare notifiche complesse con un codice minimo, nascondendo la complessità dell'implementazione multi-canale, ma offrendo allo stesso tempo la flessibilità di personalizzare ogni aspetto quando necessario.

### 3. Relazione Simbiotica tra Dati e Presentazione

Le notifiche nascono dal rapporto simbiotico tra un record del database (che fornisce il contesto) e un template (che fornisce la struttura). Questa dualità garantisce notifiche contestualmente rilevanti e strutturalmente coerenti.

## Politica di Implementazione

### 1. Rispetto delle Convenzioni <nome progetto>

- Utilizzo di file di traduzione invece di etichette hardcoded
- Impiego di enum per valori predefiniti
- Implementazione di Data Objects per dati strutturati
- Uso di QueueableAction per operazioni asincrone

### 2. Sicurezza e Affidabilità

- Validazione rigorosa dei destinatari prima dell'invio
- Gestione esplicita degli errori per ogni canale
- Logging completo di tutte le notifiche inviate
- Rate limiting per prevenire abusi

### 3. Manutenibilità e Estensibilità

- Separazione chiara tra logica di generazione contenuti e logica di invio
- Facilità di aggiunta di nuovi canali di notifica
- Tutti i testi completamente traducibili
- Test automatici per ogni componente

## Migliorie Future

### 1. Implementazione di Analytics Notifiche (Priorità: Media)

Aggiungere un sistema per tracciare aperture, clic e interazioni con le notifiche per ottimizzare l'efficacia della comunicazione.

### 2. Editor Visuale per Template (Priorità: Alta)

Implementare un editor drag-and-drop per i template di notifica che permetta anche a utenti non tecnici di creare e modificare i template.

### 3. Smart Channel Selection (Priorità: Bassa)

Sviluppare un algoritmo che scelga automaticamente il canale più appropriato per ogni utente basandosi su tassi di apertura storici e preferenze implicite.

### 4. Personalizzazione Avanzata per Tenant (Priorità: Media)

Permettere a ogni tenant di personalizzare l'aspetto visivo e il contenuto delle notifiche mantenendo l'integrità strutturale.

## Conclusione

Il sistema RecordNotification rappresenta un componente critico dell'infrastruttura di comunicazione di <nome progetto>. L'implementazione proposta non solo risolve le limitazioni dell'attuale versione, ma espande significativamente le capacità del sistema mantenendo aderenza alle best practices e alla filosofia del progetto.

Attraverso un'architettura ben strutturata e componenti fortemente tipizzati, RecordNotification può diventare uno degli strumenti più versatili e potenti dell'ecosistema <nome progetto>, garantendo comunicazioni efficaci e coerenti attraverso tutti i canali.
