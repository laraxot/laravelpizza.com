# Sistema Notifiche Avanzato con Templates Personalizzabili

> [Torna alla Roadmap Principale](../roadmap.md#q3-2024-luglio-settembre)

## Stato Attuale

Il sistema di notifiche avanzato con templates personalizzabili è attualmente completato al 30%. Questo componente estende le funzionalità del sistema notifiche multi-canale base, implementando un'architettura flessibile per la gestione di tutte le comunicazioni generate dalla piattaforma il progetto.

## Obiettivi dell'Implementazione

L'implementazione del sistema notifiche avanzato mira a:

1. Fornire un framework completo per la comunicazione con utenti e pazienti
2. Centralizzare la gestione dei template di comunicazione
3. Supportare personalizzazioni avanzate basate su destinatario e contesto
4. Gestire comunicazioni multicanale in modo efficiente
5. Implementare statistiche e analisi delle comunicazioni inviate

## Componenti Implementati (30%)

- ✅ Architettura base per la gestione notifiche
- ✅ Supporto canali email e SMS
- ✅ Sistema template base con variabili
- ✅ Integrazione con eventi Laravel
- ✅ Tracciamento invii base
- ✅ Interfaccia di amministrazione Filament

## Componenti da Implementare (70%)

- 🚧 Template avanzati (40%)
  - 🚧 Editor visuale per template
  - 🚧 Gestione versioni template
  - 🚧 Supporto multilingua nei template
  - 🚧 Logica condizionale nei contenuti
- 🚧 Canali aggiuntivi (35%)
  - 🚧 App mobile (notifiche push)
  - 🚧 WhatsApp Business API
  - 🚧 Telegram
  - 📅 Integrazione PEC
- 🚧 Pianificazione e automazione (25%)
  - 🚧 Scheduler avanzato per notifiche ricorrenti
  - 🚧 Regole di invio basate su eventi e condizioni
  - 📅 Blackout periods configurabili
- 🚧 Analytics e reporting (20%)
  - 🚧 Dashboard di monitoraggio
  - 🚧 Tracciamento aperture e click
  - 📅 Ottimizzazione tempi di invio

## Architettura del Sistema

Il sistema notifiche avanzato è progettato secondo un'architettura a canali con gestione centralizzata dei template e routing intelligente:

```
┌───────────────────┐       ┌───────────────────┐       ┌───────────────────┐
│                   │       │                   │       │                   │
│  Eventi Sistema   │       │  Processor        │       │  Template         │
│  e Trigger        │─────►│  Notifiche        │◄─────►│  Manager          │
│                   │       │                   │       │                   │
└───────────────────┘       └─────────┬─────────┘       └───────────────────┘
                                      │
                                      │
                                      ▼
┌───────────────────┐       ┌───────────────────┐       ┌───────────────────┐
│                   │       │                   │       │                   │
│  Email            │       │  Router           │       │  Altri Canali     │
│  Channel          │◄─────►│  Multi-canale     │◄─────►│  (SMS, Push, etc.)│
│                   │       │                   │       │                   │
└───────────────────┘       └───────────────────┘       └───────────────────┘
                                      │
                                      │
                                      ▼
                            ┌───────────────────┐
                            │                   │
                            │  Analytics e      │
                            │  Reporting        │
                            │                   │
                            └───────────────────┘
```

## Modello dei Dati

```php
// Modules/Notify/Models/NotificationTemplate.php
namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationTemplate extends Model
{
    use SoftDeletes;
    
    /**
     * Attributi assegnabili.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'subject',
        'body_html',
        'body_text',
        'channels',
        'variables',
        'is_active',
        'category',
        'preview_data',
        'has_conditions',
        'conditions_logic',
        'version',
        'tenant_id',
    ];
    
    /**
     * Gli attributi da castare.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'channels' => 'array',
        'variables' => 'array',
        'preview_data' => 'array',
        'has_conditions' => 'boolean',
        'conditions_logic' => 'array',
        'is_active' => 'boolean',
    ];
    
    /**
     * Le versioni precedenti del template.
     */
    public function versions(): HasMany
    {
        return $this->hasMany(NotificationTemplateVersion::class)->orderBy('version', 'desc');
    }
    
    /**
     * Le notifiche inviate con questo template.
     */
    public function sentNotifications(): HasMany
    {
        return $this->hasMany(SentNotification::class, 'template_id');
    }
    
    /**
     * Crea una nuova versione del template.
     */
    public function createNewVersion(): self
    {
        // Salva la versione corrente nella tabella delle versioni
        $this->versions()->create([
            'subject' => $this->subject,
            'body_html' => $this->body_html,
            'body_text' => $this->body_text,
            'variables' => $this->variables,
            'channels' => $this->channels,
            'version' => $this->version,
            'conditions_logic' => $this->conditions_logic,
        ]);
        
        // Incrementa la versione
        $this->version++;
        $this->save();
        
        return $this;
    }
    
    /**
     * Compila il template con i dati forniti.
     */
    public function compile(array $data = []): array
    {
        return [
            'subject' => $this->renderTemplate($this->subject, $data),
            'body_html' => $this->renderTemplate($this->body_html, $data),
            'body_text' => $this->renderTemplate($this->body_text, $data),
        ];
    }
    
    /**
     * Renderizza un template applicando i dati di contesto.
     */
    protected function renderTemplate(string $template, array $data): string
    {
        // Implementazione del rendering con supporto per condizioni e loop
        // Utilizzo di una libreria come Blade o Twig per il template engine
    }
    
    /**
     * Valuta se il template deve essere inviato in base alle condizioni.
     */
    public function shouldSend(array $data = []): bool
    {
        if (!$this->has_conditions || empty($this->conditions_logic)) {
            return true;
        }
        
        // Valuta le condizioni logiche
        // Implementazione della valutazione condizioni
    }
}
```

## Implementazione con Action Pattern

Seguendo la regola di utilizzo di Spatie Laravel-Queueable-Action invece di Service Classes, implementiamo le funzionalità principali tramite Action Pattern:

```php
// Modules/Notify/Actions/SendNotificationAction.php
namespace Modules\Notify\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Models\SentNotification;
use Spatie\QueueableAction\QueueableAction;

class SendNotificationAction
{
    use QueueableAction;
    
    /**
     * Invia una notifica utilizzando un template.
     *
     * @param \Illuminate\Database\Eloquent\Model $recipient Destinatario della notifica
     * @param string $templateCode Codice del template da utilizzare
     * @param array $data Dati per compilare il template
     * @param array $channels Canali da utilizzare per l'invio
     * @param array $options Opzioni aggiuntive
     * 
     * @return \Modules\Notify\Models\SentNotification
     */
    public function execute(
        Model $recipient,
        string $templateCode,
        array $data = [],
        array $channels = [],
        array $options = []
    ): SentNotification {
        // Recupera il template
        $template = NotificationTemplate::where('code', $templateCode)
            ->where('is_active', true)
            ->first();
            
        if (!$template) {
            throw new \Exception("Template {$templateCode} non trovato o non attivo");
        }
        
        // Verifica condizioni di invio
        if (!$template->shouldSend($data)) {
            return $this->createSkippedNotification($recipient, $template, $data);
        }
        
        // Compila il template
        $compiled = $template->compile($data);
        
        // Determina i canali da utilizzare
        $effectiveChannels = $channels ?: $template->channels;
        
        // Crea il record della notifica
        $notification = SentNotification::create([
            'recipient_type' => get_class($recipient),
            'recipient_id' => $recipient->getKey(),
            'template_id' => $template->id,
            'subject' => $compiled['subject'],
            'channels' => $effectiveChannels,
            'data' => $data,
            'status' => SentNotification::STATUS_PROCESSING,
            'scheduled_at' => $options['scheduled_at'] ?? now(),
            'tenant_id' => $template->tenant_id,
        ]);
        
        // Processa i canali
        foreach ($effectiveChannels as $channel) {
            $this->dispatchChannelProcessor($notification, $channel, $compiled, $options);
        }
        
        return $notification;
    }
    
    /**
     * Dispatcha la notifica al processore del canale specifico.
     */
    protected function dispatchChannelProcessor(
        SentNotification $notification,
        string $channel,
        array $compiled,
        array $options
    ): void {
        // Implementazione del dispatch ai vari canali
        // Utilizzo di ProcessorFactory per istanziare il processore corretto
        
        // Esempio per email
        if ($channel === 'email') {
            app(SendEmailNotificationAction::class)->onQueue('notifications')
                ->execute($notification, $compiled, $options);
        }
        
        // Altri canali...
    }
    
    /**
     * Crea un record per una notifica saltata a causa di condizioni.
     */
    protected function createSkippedNotification(
        Model $recipient,
        NotificationTemplate $template,
        array $data
    ): SentNotification {
        return SentNotification::create([
            'recipient_type' => get_class($recipient),
            'recipient_id' => $recipient->getKey(),
            'template_id' => $template->id,
            'subject' => $template->subject,
            'channels' => [],
            'data' => $data,
            'status' => SentNotification::STATUS_SKIPPED,
            'status_message' => 'Saltata per condizioni non soddisfatte',
            'tenant_id' => $template->tenant_id,
        ]);
    }
}
```

## Processori Specifici dei Canali

```php
// Modules/Notify/Actions/SendEmailNotificationAction.php
namespace Modules\Notify\Actions;

use Illuminate\Support\Facades\Mail;
use Modules\Notify\Mail\TemplatedMail;
use Modules\Notify\Models\SentNotification;
use Spatie\QueueableAction\QueueableAction;

class SendEmailNotificationAction
{
    use QueueableAction;
    
    /**
     * Invia una notifica via email.
     *
     * @param \Modules\Notify\Models\SentNotification $notification Record notifica
     * @param array $compiled Template compilato
     * @param array $options Opzioni aggiuntive
     * 
     * @return bool
     */
    public function execute(
        SentNotification $notification,
        array $compiled,
        array $options = []
    ): bool {
        try {
            // Recupera destinatario
            $recipient = $notification->recipient;
            
            // Verifica che abbia una email
            if (!$recipient || !method_exists($recipient, 'getEmailForNotification')) {
                throw new \Exception('Destinatario non valido o senza email');
            }
            
            $email = $recipient->getEmailForNotification();
            
            if (!$email) {
                throw new \Exception('Email destinatario non disponibile');
            }
            
            // Invia la mail
            Mail::to($email)->send(new TemplatedMail(
                $compiled['subject'],
                $compiled['body_html'],
                $compiled['body_text'],
                $options['attachments'] ?? []
            ));
            
            // Aggiorna lo stato della notifica
            $notification->update([
                'status' => SentNotification::STATUS_SENT,
                'sent_at' => now(),
                'channel_response' => ['email' => 'success'],
            ]);
            
            return true;
        } catch (\Exception $e) {
            // Gestione errori
            $notification->update([
                'status' => SentNotification::STATUS_FAILED,
                'status_message' => $e->getMessage(),
                'channel_response' => ['email' => 'error: ' . $e->getMessage()],
            ]);
            
            return false;
        }
    }
}
```

## Implementazione in Filament

L'interfaccia di gestione dei template utilizza esclusivamente Filament, seguendo la regola fondamentale del progetto:

```php
// Modules/Notify/Filament/Resources/NotificationTemplateResource.php
namespace Modules\Notify\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Xot\Filament\Resources\XotBaseResource;

class NotificationTemplateResource extends XotBaseResource
{
    protected static ?string $model = NotificationTemplate::class;
    
    public static function getFormSchema(): array
    {
        return [
            'basic_info' => Forms\Components\Section::make('Informazioni Base')
                ->schema([
                    'name' => Forms\Components\TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->maxLength(100),
                    'code' => Forms\Components\TextInput::make('code')
                        ->label('Codice')
                        ->required()
                        ->alphaNum()
                        ->unique(ignoreRecord: true)
                        ->maxLength(50)
                        ->helperText('Codice univoco per identificare il template nel sistema'),
                    'description' => Forms\Components\Textarea::make('description')
                        ->label('Descrizione')
                        ->rows(3),
                    'category' => Forms\Components\Select::make('category')
                        ->label('Categoria')
                        ->options([
                            'appointment' => 'Appuntamenti',
                            'patient' => 'Pazienti',
                            'admin' => 'Amministrazione',
                            'system' => 'Sistema',
                            'marketing' => 'Marketing',
                        ])
                        ->required(),
                    'is_active' => Forms\Components\Toggle::make('is_active')
                        ->label('Attivo')
                        ->default(true),
                ])
                ->columns(2),
                
            'channels' => Forms\Components\Section::make('Canali')
                ->schema([
                    'channels' => Forms\Components\CheckboxList::make('channels')
                        ->label('Canali Disponibili')
                        ->options([
                            'email' => 'Email',
                            'sms' => 'SMS',
                            'push' => 'Notifica Push',
                            'whatsapp' => 'WhatsApp',
                        ])
                        ->required()
                        ->columns(2),
                ]),
                
            'content' => Forms\Components\Section::make('Contenuto')
                ->schema([
                    'subject' => Forms\Components\TextInput::make('subject')
                        ->label('Oggetto')
                        ->required()
                        ->maxLength(200),
                    'body_html' => Forms\Components\RichEditor::make('body_html')
                        ->label('Contenuto HTML')
                        ->required()
                        ->toolbarButtons([
                            'blockquote',
                            'bold',
                            'bulletList',
                            'codeBlock',
                            'h2',
                            'h3',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ]),
                    'body_text' => Forms\Components\Textarea::make('body_text')
                        ->label('Contenuto Testo')
                        ->required()
                        ->rows(6),
                ]),
                
            'variables' => Forms\Components\Section::make('Variabili e Anteprima')
                ->schema([
                    'variables' => Forms\Components\TagsInput::make('variables')
                        ->label('Variabili Disponibili')
                        ->helperText('Le variabili devono essere nel formato {nome_variabile}'),
                    'preview_data' => Forms\Components\KeyValue::make('preview_data')
                        ->label('Dati Anteprima')
                        ->helperText('Dati per testare il template'),
                ]),
                
            'conditions' => Forms\Components\Section::make('Condizioni')
                ->schema([
                    'has_conditions' => Forms\Components\Toggle::make('has_conditions')
                        ->label('Usa Condizioni')
                        ->default(false)
                        ->reactive(),
                    'conditions_logic' => Forms\Components\Repeater::make('conditions_logic')
                        ->label('Regole Condizionali')
                        ->schema([
                            'field' => Forms\Components\TextInput::make('field')
                                ->label('Campo')
                                ->required(),
                            'operator' => Forms\Components\Select::make('operator')
                                ->label('Operatore')
                                ->options([
                                    'eq' => 'Uguale a',
                                    'neq' => 'Diverso da',
                                    'gt' => 'Maggiore di',
                                    'lt' => 'Minore di',
                                    'contains' => 'Contiene',
                                    'not_contains' => 'Non contiene',
                                ])
                                ->required(),
                            'value' => Forms\Components\TextInput::make('value')
                                ->label('Valore')
                                ->required(),
                        ])
                        ->columns(3)
                        ->hidden(fn (Forms\Get $get) => !$get('has_conditions')),
                ]),
        ];
    }
    
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->label('Codice')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Categoria')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('channels')
                    ->label('Canali')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Attivo')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('version')
                    ->label('Versione')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Aggiornato')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'appointment' => 'Appuntamenti',
                        'patient' => 'Pazienti',
                        'admin' => 'Amministrazione',
                        'system' => 'Sistema',
                        'marketing' => 'Marketing',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Attivo'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('preview')
                    ->label('Anteprima')
                    ->icon('heroicon-o-eye')
                    ->action(fn (NotificationTemplate $record) => redirect()->route('notify.templates.preview', $record)),
                Tables\Actions\Action::make('new_version')
                    ->label('Nuova Versione')
                    ->icon('heroicon-o-document-duplicate')
                    ->requiresConfirmation()
                    ->action(fn (NotificationTemplate $record) => $record->createNewVersion()),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('activate')
                    ->label('Attiva')
                    ->icon('heroicon-o-check')
                    ->action(fn (mixed $records) => $records->each->update(['is_active' => true])),
                Tables\Actions\BulkAction::make('deactivate')
                    ->label('Disattiva')
                    ->icon('heroicon-o-x-mark')
                    ->action(fn (mixed $records) => $records->each->update(['is_active' => false])),
            ]);
    }
}
```

## Dashboard Analytics

```php
// Modules/Notify/Filament/Widgets/NotificationAnalyticsWidget.php
namespace Modules\Notify\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Notify\Models\SentNotification;
use Carbon\Carbon;

class NotificationAnalyticsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $sentToday = SentNotification::where('status', SentNotification::STATUS_SENT)
            ->whereDate('sent_at', Carbon::today())
            ->count();
            
        $failedToday = SentNotification::where('status', SentNotification::STATUS_FAILED)
            ->whereDate('created_at', Carbon::today())
            ->count();
            
        $totalDeliveryRate = SentNotification::where('status', SentNotification::STATUS_SENT)->count() / 
            max(1, SentNotification::whereIn('status', [SentNotification::STATUS_SENT, SentNotification::STATUS_FAILED])->count()) * 100;
        
        return [
            Stat::make('Notifiche Inviate Oggi', $sentToday)
                ->description('Attraverso tutti i canali')
                ->descriptionIcon('heroicon-m-paper-airplane')
                ->color('success'),
                
            Stat::make('Notifiche Fallite Oggi', $failedToday)
                ->description('Richiede attenzione')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('danger'),
                
            Stat::make('Tasso di Consegna', number_format($totalDeliveryRate, 1) . '%')
                ->description('Media complessiva')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('primary'),
        ];
    }
}
```

## Esempi di Utilizzo

### 1. Notifica Promemoria Appuntamento

```php
// Modules/Dental/Actions/SendAppointmentReminderAction.php
namespace Modules\Dental\Actions;

use Modules\Dental\Models\Appointment;
use Modules\Notify\Actions\SendNotificationAction;
use Spatie\QueueableAction\QueueableAction;

class SendAppointmentReminderAction
{
    use QueueableAction;
    
    /**
     * Invia un promemoria per un appuntamento.
     */
    public function execute(Appointment $appointment): void
    {
        $patient = $appointment->patient;
        
        if (!$patient) {
            return;
        }
        
        // Prepara i dati per il template
        $data = [
            'patient_name' => $patient->full_name,
            'doctor_name' => $appointment->dentist->full_name ?? 'il medico',
            'appointment_date' => $appointment->start_time->format('d/m/Y'),
            'appointment_time' => $appointment->start_time->format('H:i'),
            'clinic_name' => $appointment->clinic->name ?? 'la clinica',
            'clinic_address' => $appointment->clinic->address ?? '',
            'clinic_phone' => $appointment->clinic->phone ?? '',
            'appointment_link' => route('patient.appointments.show', $appointment->id),
        ];
        
        // Determina i canali in base alle preferenze del paziente
        $channels = $patient->notification_preferences['appointment_reminder'] ?? ['email', 'sms'];
        
        // Invia la notifica
        app(SendNotificationAction::class)->execute(
            $patient,
            'appointment_reminder_24h',
            $data,
            $channels
        );
    }
}
```

### 2. Integrazione con Scheduler per Notifiche Automatiche

```php
// Modules/Notify/Console/Commands/SendScheduledNotificationsCommand.php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Actions\ProcessScheduledNotificationsAction;

class SendScheduledNotificationsCommand extends Command
{
    protected $signature = 'notify:process-scheduled';
    
    protected $description = 'Elabora le notifiche programmate';
    
    public function handle(): int
    {
        $this->info('Elaborazione notifiche programmate...');
        
        $processed = app(ProcessScheduledNotificationsAction::class)->execute();
        
        $this->info("Elaborate {$processed} notifiche programmate");
        
        return 0;
    }
}

// Registrazione nel kernel
// App\Console\Kernel::schedule(function ($schedule) {
//     $schedule->command('notify:process-scheduled')->everyMinute();
// });
```

## Calendario di Completamento

| Funzionalità | Completamento Previsto | Priorità |
|--------------|------------------------|----------|
| Editor visuale template | Luglio 2024 | Alta |
| Gestione versioni | Luglio 2024 | Media |
| Supporto multilingua | Luglio 2024 | Alta |
| Integrazione push notifiche | Agosto 2024 | Alta |
| Integrazione WhatsApp | Agosto 2024 | Media |
| Scheduler avanzato | Agosto 2024 | Alta |
| Dashboard analytics | Settembre 2024 | Media |
| Tracciamento aperture | Settembre 2024 | Bassa |

## Metriche di Successo

- Tasso di consegna complessivo > 98%
- Tempo medio creazione template < 10 minuti
- Efficacia promemoria appuntamenti (riduzione no-show) > 40%
- Soddisfazione pazienti con le comunicazioni > 4.5/5
- Copertura comunicazioni multilingua 100%
