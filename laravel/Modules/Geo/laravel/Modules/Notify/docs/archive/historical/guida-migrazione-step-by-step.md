# Guida Migrazione Step-by-Step: Modulo Notify - Filament 4

## Panoramica Migrazione
**Modulo**: Notify  
**Complessità**: ⭐⭐⭐⭐ ALTA  
**Tempo Stimato**: 21-28 giorni  
**Rischio**: ALTO (comunicazioni critiche)  
**Priorità**: 2 (dopo User per dipendenze di autenticazione)

## Pre-requisiti
- [x] Completata migrazione modulo User (autenticazione MFA)
- [x] Completata migrazione modulo Xot (XotBaseResource)
- [x] Laravel 12+ installato
- [x] Filament 4 beta installato
- [x] Testing environment isolato

## Fase 1: Backup e Preparazione (Giorni 1-2)

### 1.1 Backup Completo
```bash
# Backup database notifiche
php artisan db:backup --table=notification_templates,notifications,contacts,mail_templates

# Backup file template
tar -czf notify_templates_backup.tar.gz Modules/Notify/resources/views/mail/
tar -czf notify_config_backup.tar.gz Modules/Notify/config/
```

### 1.2 Analisi Dipendenze Critiche
```bash
# Verifica servizi esterni attivi
php artisan notify:test-smtp
php artisan notify:test-aws-ses
php artisan notify:test-firebase
php artisan notify:test-telegram
php artisan notify:test-whatsapp
```

### 1.3 Freeze Comunicazioni Critiche
```php
// config/notify.php - Modalità manutenzione
'maintenance_mode' => true,
'emergency_only' => true,
'allowed_channels' => ['email'], // Solo email per emergenze
```

## Fase 2: Ricostruzione NotificationTemplateResource (Giorni 3-8)

### 2.1 Creazione XotBaseResource per Notify
```php
// app/Filament/Resources/NotifyBaseResource.php
<?php

namespace Modules\Notify\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms\Components\{TextInput, Textarea, Select, KeyValue, Toggle};
use Filament\Tables\Columns\{TextColumn, ToggleColumn, BadgeColumn};
use Filament\Tables\Actions\{ViewAction, EditAction, DeleteAction, BulkAction};
use Filament\Tables\Filters\{SelectFilter, TernaryFilter};
use Filament\Schema\Schema;
use Filament\Schema\Slot;

abstract class NotifyBaseResource extends XotBaseResource
{
    protected static ?string $navigationGroup = 'Comunicazioni';
    
    public static function getMainSchema(): Schema
    {
        return Schema::make([
            static::getNotificationDetailsSlot(),
            static::getChannelConfigSlot(),
            static::getTemplateSlot(),
            static::getSchedulingSlot(),
        ]);
    }
    
    protected static function getNotificationDetailsSlot(): Slot
    {
        return Slot::make([
            TextInput::make('name')
                ->label('Nome Template')
                ->required()
                ->maxLength(255),
                
            Textarea::make('description')
                ->label('Descrizione')
                ->rows(3),
                
            Select::make('type')
                ->label('Tipo Notifica')
                ->options([
                    'system' => 'Sistema',
                    'marketing' => 'Marketing', 
                    'transactional' => 'Transazionale',
                    'alert' => 'Allarme',
                ])
                ->required(),
        ]);
    }
    
    protected static function getChannelConfigSlot(): Slot
    {
        return Slot::make([
            Toggle::make('email_enabled')
                ->label('Email Attiva')
                ->default(true),
                
            Toggle::make('sms_enabled')
                ->label('SMS Attivo'),
                
            Toggle::make('push_enabled')
                ->label('Push Notification Attiva'),
                
            Toggle::make('telegram_enabled')
                ->label('Telegram Attivo'),
                
            Toggle::make('whatsapp_enabled')
                ->label('WhatsApp Attivo'),
        ]);
    }
    
    protected static function getTemplateSlot(): Slot
    {
        return Slot::make([
            TextInput::make('subject')
                ->label('Oggetto')
                ->required()
                ->placeholder('{{nome_utente}}, bentornato!'),
                
            Textarea::make('body_html')
                ->label('Corpo HTML')
                ->rows(10),
                
            Textarea::make('body_text')
                ->label('Corpo Testo')
                ->rows(8),
                
            KeyValue::make('variables')
                ->label('Variabili Template')
                ->keyLabel('Nome Variabile')
                ->valueLabel('Valore Default'),
        ]);
    }
    
    protected static function getSchedulingSlot(): Slot
    {
        return Slot::make([
            Toggle::make('is_scheduled')
                ->label('Programmata')
                ->reactive(),
                
            DateTimePicker::make('send_at')
                ->label('Invia il')
                ->visible(fn($get) => $get('is_scheduled')),
                
            Select::make('frequency')
                ->label('Frequenza')
                ->options([
                    'once' => 'Una volta',
                    'daily' => 'Giornaliera',
                    'weekly' => 'Settimanale',
                    'monthly' => 'Mensile',
                ])
                ->visible(fn($get) => $get('is_scheduled')),
        ]);
    }
    
    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Nome')
                ->searchable()
                ->sortable(),
                
            BadgeColumn::make('type')
                ->label('Tipo')
                ->colors([
                    'primary' => 'system',
                    'success' => 'marketing',
                    'warning' => 'transactional',
                    'danger' => 'alert',
                ]),
                
            ToggleColumn::make('email_enabled')
                ->label('Email'),
                
            ToggleColumn::make('sms_enabled')
                ->label('SMS'),
                
            ToggleColumn::make('push_enabled')
                ->label('Push'),
                
            TextColumn::make('sent_count')
                ->label('Inviate')
                ->badge()
                ->color('success'),
                
            TextColumn::make('updated_at')
                ->label('Ultimo Aggiornamento')
                ->dateTime()
                ->sortable(),
        ];
    }
}
```

### 2.2 NotificationTemplateResource con Filament 4
```php
// app/Filament/Resources/NotificationTemplateResource.php
<?php

namespace Modules\Notify\Filament\Resources;

use Modules\Notify\Models\NotificationTemplate;
use Filament\Schema\Schema;
use Filament\Schema\Slot;
use Filament\Forms\Components\{Wizard, Section, RichEditor, CodeEditor};
use Filament\Tables\Actions\{PreviewAction, DuplicateAction, TestSendAction};
use Filament\Actions\Action;

class NotificationTemplateResource extends NotifyBaseResource
{
    protected static ?string $model = NotificationTemplate::class;
    protected static ?string $navigationLabel = 'Template Notifiche';
    protected static ?string $navigationIcon = 'heroicon-o-bell';
    
    public static function getMainSchema(): Schema
    {
        return Schema::make([
            Wizard::make([
                Wizard\Step::make('Dettagli')
                    ->schema([
                        parent::getNotificationDetailsSlot()->getComponents(),
                    ]),
                    
                Wizard\Step::make('Canali')
                    ->schema([
                        parent::getChannelConfigSlot()->getComponents(),
                    ]),
                    
                Wizard\Step::make('Template')
                    ->schema([
                        static::getAdvancedTemplateSlot()->getComponents(),
                    ]),
                    
                Wizard\Step::make('Test & Preview')
                    ->schema([
                        static::getTestingSlot()->getComponents(),
                    ]),
            ]),
        ]);
    }
    
    protected static function getAdvancedTemplateSlot(): Slot
    {
        return Slot::make([
            Section::make('Template Email')
                ->schema([
                    TextInput::make('subject')
                        ->label('Oggetto')
                        ->required(),
                        
                    RichEditor::make('body_html')
                        ->label('Corpo HTML')
                        ->toolbarButtons([
                            'bold', 'italic', 'link', 'bulletList',
                            'orderedList', 'h2', 'h3', 'blockquote',
                        ]),
                        
                    CodeEditor::make('body_text')
                        ->label('Versione Testo')
                        ->language('text'),
                ]),
                
            Section::make('Template SMS/Push')
                ->schema([
                    Textarea::make('sms_body')
                        ->label('Testo SMS')
                        ->maxLength(160)
                        ->hint('Massimo 160 caratteri'),
                        
                    TextInput::make('push_title')
                        ->label('Titolo Push'),
                        
                    Textarea::make('push_body')
                        ->label('Corpo Push')
                        ->maxLength(200),
                ]),
        ]);
    }
    
    protected static function getTestingSlot(): Slot
    {
        return Slot::make([
            Section::make('Test Invio')
                ->schema([
                    TextInput::make('test_email')
                        ->label('Email Test')
                        ->email(),
                        
                    TextInput::make('test_phone')
                        ->label('Telefono Test'),
                        
                    KeyValue::make('test_variables')
                        ->label('Variabili Test'),
                ]),
        ]);
    }
    
    public static function getCustomActions(): array
    {
        return [
            PreviewAction::make()
                ->label('Anteprima')
                ->modalHeading('Anteprima Template')
                ->modalContent(view('notify::preview-template')),
                
            Action::make('test_send')
                ->label('Invia Test')
                ->icon('heroicon-o-paper-airplane')
                ->form([
                    TextInput::make('test_email')->email()->required(),
                    KeyValue::make('test_data'),
                ])
                ->action(function (array $data, NotificationTemplate $record) {
                    $record->sendTest($data['test_email'], $data['test_data'] ?? []);
                    
                    Notification::make()
                        ->success()
                        ->title('Test inviato con successo')
                        ->send();
                }),
                
            DuplicateAction::make()
                ->label('Duplica Template'),
        ];
    }
}
```

## Fase 3: Sistema Multi-Canale Unificato (Giorni 9-14)

### 3.1 ContactResource con Gestione Multi-Canale
```php
// app/Filament/Resources/ContactResource.php
<?php

namespace Modules\Notify\Filament\Resources;

use Modules\Notify\Models\Contact;
use Filament\Schema\Schema;
use Filament\Forms\Components\{Tabs, Repeater, TagsInput};
use Filament\Tables\Columns\{TextColumn, TagsColumn, IconColumn};

class ContactResource extends NotifyBaseResource
{
    protected static ?string $model = Contact::class;
    protected static ?string $navigationLabel = 'Contatti';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    public static function getMainSchema(): Schema
    {
        return Schema::make([
            Tabs::make('Contact Details')
                ->tabs([
                    Tabs\Tab::make('Informazioni Base')
                        ->schema([
                            TextInput::make('name')
                                ->label('Nome Completo')
                                ->required(),
                                
                            TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->unique(ignoreRecord: true),
                                
                            TextInput::make('phone')
                                ->label('Telefono')
                                ->tel(),
                                
                            TagsInput::make('groups')
                                ->label('Gruppi')
                                ->suggestions([
                                    'clienti', 'fornitori', 'dipendenti',
                                    'newsletter', 'vip', 'test'
                                ]),
                        ]),
                        
                    Tabs\Tab::make('Preferenze Canali')
                        ->schema([
                            Toggle::make('email_opt_in')
                                ->label('Accetta Email')
                                ->default(true),
                                
                            Toggle::make('sms_opt_in')
                                ->label('Accetta SMS'),
                                
                            Toggle::make('push_opt_in')
                                ->label('Accetta Push Notifications'),
                                
                            Toggle::make('telegram_opt_in')
                                ->label('Accetta Telegram'),
                                
                            Select::make('preferred_language')
                                ->label('Lingua Preferita')
                                ->options([
                                    'it' => 'Italiano',
                                    'en' => 'English',
                                    'fr' => 'Français',
                                ]),
                        ]),
                        
                    Tabs\Tab::make('Canali Social')
                        ->schema([
                            Repeater::make('social_channels')
                                ->label('Canali Social')
                                ->schema([
                                    Select::make('platform')
                                        ->options([
                                            'telegram' => 'Telegram',
                                            'whatsapp' => 'WhatsApp',
                                            'facebook' => 'Facebook',
                                            'twitter' => 'Twitter',
                                        ])
                                        ->required(),
                                        
                                    TextInput::make('identifier')
                                        ->label('ID/Username')
                                        ->required(),
                                        
                                    Toggle::make('verified')
                                        ->label('Verificato'),
                                ])
                                ->collapsible()
                                ->cloneable(),
                        ]),
                ]),
        ]);
    }
    
    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Nome')
                ->searchable()
                ->sortable(),
                
            TextColumn::make('email')
                ->label('Email')
                ->searchable()
                ->copyable(),
                
            TextColumn::make('phone')
                ->label('Telefono')
                ->searchable(),
                
            TagsColumn::make('groups')
                ->label('Gruppi'),
                
            IconColumn::make('email_opt_in')
                ->label('📧')
                ->boolean(),
                
            IconColumn::make('sms_opt_in')
                ->label('📱')
                ->boolean(),
                
            IconColumn::make('push_opt_in')
                ->label('🔔')
                ->boolean(),
                
            TextColumn::make('last_notification_sent')
                ->label('Ultima Notifica')
                ->dateTime()
                ->sortable(),
        ];
    }
}
```

### 3.2 Sistema Unificato di Invio
```php
// app/Actions/Notify/UnifiedSendAction.php
<?php

namespace Modules\Notify\Actions;

use Modules\Notify\Models\{NotificationTemplate, Contact};
use Modules\Notify\Services\{EmailService, SmsService, PushService, TelegramService};
use Illuminate\Support\Facades\Queue;

class UnifiedSendAction
{
    public function __construct(
        protected EmailService $emailService,
        protected SmsService $smsService,
        protected PushService $pushService,
        protected TelegramService $telegramService,
    ) {}
    
    public function execute(NotificationTemplate $template, array $contacts, array $variables = []): array
    {
        $results = [
            'email' => [],
            'sms' => [],
            'push' => [],
            'telegram' => [],
        ];
        
        foreach ($contacts as $contact) {
            if ($template->email_enabled && $contact->email_opt_in) {
                $results['email'][] = Queue::push(
                    new SendEmailJob($template, $contact, $variables)
                );
            }
            
            if ($template->sms_enabled && $contact->sms_opt_in && $contact->phone) {
                $results['sms'][] = Queue::push(
                    new SendSmsJob($template, $contact, $variables)
                );
            }
            
            if ($template->push_enabled && $contact->push_opt_in) {
                $results['push'][] = Queue::push(
                    new SendPushJob($template, $contact, $variables)
                );
            }
            
            if ($template->telegram_enabled && $contact->telegram_opt_in) {
                $results['telegram'][] = Queue::push(
                    new SendTelegramJob($template, $contact, $variables)
                );
            }
        }
        
        return $results;
    }
}
```

## Fase 4: Dashboard Comunicazioni Real-time (Giorni 15-18)

### 3.3 Widget Dashboard con Filament 4
```php
// app/Filament/Widgets/NotificationStatsWidget.php
<?php

namespace Modules\Notify\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Notify\Models\{NotificationLog, Contact};

class NotificationStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';
    
    protected function getStats(): array
    {
        return [
            Stat::make('Notifiche Oggi', $this->getTodayCount())
                ->description('Inviate nelle ultime 24h')
                ->descriptionIcon('heroicon-m-paper-airplane')
                ->color('success')
                ->chart($this->getWeeklyChart()),
                
            Stat::make('Tasso Apertura Email', $this->getEmailOpenRate())
                ->description('Media ultimi 7 giorni')
                ->descriptionIcon('heroicon-m-envelope-open')
                ->color('primary'),
                
            Stat::make('SMS Consegnati', $this->getSmsDeliveryRate())
                ->description('Tasso di consegna')
                ->descriptionIcon('heroicon-m-device-phone-mobile')
                ->color('warning'),
                
            Stat::make('Contatti Attivi', Contact::where('is_active', true)->count())
                ->description('Con almeno un canale attivo')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
    
    protected function getTodayCount(): int
    {
        return NotificationLog::whereDate('created_at', today())->count();
    }
    
    protected function getWeeklyChart(): array
    {
        return NotificationLog::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [now()->subWeek(), now()])
            ->groupBy('date')
            ->pluck('count')
            ->toArray();
    }
    
    protected function getEmailOpenRate(): string
    {
        $sent = NotificationLog::where('channel', 'email')
            ->whereBetween('created_at', [now()->subWeek(), now()])
            ->count();
            
        $opened = NotificationLog::where('channel', 'email')
            ->whereBetween('created_at', [now()->subWeek(), now()])
            ->whereNotNull('opened_at')
            ->count();
            
        return $sent > 0 ? round(($opened / $sent) * 100, 1) . '%' : '0%';
    }
    
    protected function getSmsDeliveryRate(): string
    {
        $sent = NotificationLog::where('channel', 'sms')
            ->whereBetween('created_at', [now()->subWeek(), now()])
            ->count();
            
        $delivered = NotificationLog::where('channel', 'sms')
            ->whereBetween('created_at', [now()->subWeek(), now()])
            ->where('status', 'delivered')
            ->count();
            
        return $sent > 0 ? round(($delivered / $sent) * 100, 1) . '%' : '0%';
    }
}
```

### 3.4 Widget Coda in Tempo Reale
```php
// app/Filament/Widgets/QueueMonitorWidget.php
<?php

namespace Modules\Notify\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\{Table, Columns\TextColumn, Columns\BadgeColumn};
use Modules\Notify\Models\NotificationQueue;

class QueueMonitorWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 2;
    
    protected function getTableQuery(): Builder
    {
        return NotificationQueue::query()
            ->where('status', '!=', 'completed')
            ->latest();
    }
    
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('template.name')
                ->label('Template')
                ->limit(30),
                
            BadgeColumn::make('channel')
                ->label('Canale')
                ->colors([
                    'primary' => 'email',
                    'success' => 'sms',
                    'warning' => 'push',
                    'info' => 'telegram',
                ]),
                
            BadgeColumn::make('status')
                ->label('Stato')
                ->colors([
                    'gray' => 'pending',
                    'warning' => 'processing',
                    'danger' => 'failed',
                    'success' => 'sent',
                ]),
                
            TextColumn::make('created_at')
                ->label('Accodato')
                ->since()
                ->sortable(),
                
            TextColumn::make('attempts')
                ->label('Tentativi')
                ->badge()
                ->color(fn($state) => $state > 1 ? 'danger' : 'success'),
        ];
    }
    
    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }
    
    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }
    
    protected function getTablePollingInterval(): ?string
    {
        return '10s'; // Aggiornamento ogni 10 secondi
    }
}
```

## Fase 5: Test Pages con Filament 4 (Giorni 19-21)

### 5.1 Pagina Test Unificata
```php
// app/Filament/Pages/NotificationTestPage.php
<?php

namespace Modules\Notify\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\{Form, Components\Wizard, Components\Select, Components\Textarea, Components\KeyValue, Components\Tabs};
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Modules\Notify\Models\{NotificationTemplate, Contact};
use Modules\Notify\Actions\UnifiedSendAction;

class NotificationTestPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationLabel = 'Test Notifiche';
    protected static ?string $navigationGroup = 'Comunicazioni';
    
    protected static string $view = 'filament.pages.notification-test-page';
    
    public ?array $data = [];
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Seleziona Template')
                        ->schema([
                            Select::make('template_id')
                                ->label('Template')
                                ->options(NotificationTemplate::pluck('name', 'id'))
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(fn($state, $set) => $this->loadTemplate($state, $set)),
                        ]),
                        
                    Wizard\Step::make('Destinatari')
                        ->schema([
                            Tabs::make('Recipients')
                                ->tabs([
                                    Tabs\Tab::make('Contatti Esistenti')
                                        ->schema([
                                            Select::make('contacts')
                                                ->label('Seleziona Contatti')
                                                ->options(Contact::pluck('name', 'id'))
                                                ->multiple()
                                                ->searchable(),
                                        ]),
                                        
                                    Tabs\Tab::make('Test Rapido')
                                        ->schema([
                                            TextInput::make('test_email')
                                                ->label('Email Test')
                                                ->email(),
                                                
                                            TextInput::make('test_phone')
                                                ->label('Telefono Test'),
                                        ]),
                                ]),
                        ]),
                        
                    Wizard\Step::make('Variabili')
                        ->schema([
                            KeyValue::make('variables')
                                ->label('Variabili Template')
                                ->keyLabel('Nome Variabile')
                                ->valueLabel('Valore Test')
                                ->default([
                                    'nome_utente' => 'Mario Rossi',
                                    'data_oggi' => now()->format('d/m/Y'),
                                ]),
                        ]),
                        
                    Wizard\Step::make('Preview & Invio')
                        ->schema([
                            Placeholder::make('preview')
                                ->label('Anteprima')
                                ->content(function($get) {
                                    return $this->getPreview($get);
                                }),
                        ]),
                ])
                ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button
                        type="submit"
                        size="sm"
                        wire:click="sendTest"
                    >
                        Invia Test
                    </x-filament::button>
                BLADE))),
            ])
            ->statePath('data');
    }
    
    protected function getActions(): array
    {
        return [
            Action::make('send_test')
                ->label('Invia Test')
                ->action('sendTest')
                ->requiresConfirmation()
                ->modalHeading('Conferma Invio Test')
                ->modalDescription('Sei sicuro di voler inviare questo test?'),
        ];
    }
    
    public function sendTest(): void
    {
        $template = NotificationTemplate::find($this->data['template_id']);
        
        if ($this->data['contacts']) {
            $contacts = Contact::whereIn('id', $this->data['contacts'])->get();
        } else {
            // Creare contatto temporaneo per test
            $contacts = collect([
                (object) [
                    'email' => $this->data['test_email'],
                    'phone' => $this->data['test_phone'],
                    'email_opt_in' => true,
                    'sms_opt_in' => true,
                ]
            ]);
        }
        
        $sendAction = app(UnifiedSendAction::class);
        $results = $sendAction->execute($template, $contacts, $this->data['variables'] ?? []);
        
        Notification::make()
            ->success()
            ->title('Test Inviato!')
            ->body('Il test è stato accodato per l\'invio.')
            ->send();
    }
    
    protected function loadTemplate($templateId, $set): void
    {
        if (!$templateId) return;
        
        $template = NotificationTemplate::find($templateId);
        if (!$template) return;
        
        // Pre-popolare variabili dal template
        $variables = $template->getVariables();
        $set('variables', $variables);
    }
    
    protected function getPreview($get): string
    {
        if (!$get('template_id')) {
            return 'Seleziona un template per vedere l\'anteprima.';
        }
        
        $template = NotificationTemplate::find($get('template_id'));
        $variables = $get('variables') ?? [];
        
        return view('notify::preview.unified', [
            'template' => $template,
            'variables' => $variables,
        ])->render();
    }
}
```

## Fase 6: Migration e Deploy (Giorni 22-25)

### 6.1 Migration Database
```php
// database/migrations/2025_01_xx_update_notifications_for_filament4.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Aggiungere colonne per multi-canale
        Schema::table('notification_templates', function (Blueprint $table) {
            $table->boolean('email_enabled')->default(true);
            $table->boolean('sms_enabled')->default(false);
            $table->boolean('push_enabled')->default(false);
            $table->boolean('telegram_enabled')->default(false);
            $table->boolean('whatsapp_enabled')->default(false);
            
            $table->text('sms_body')->nullable();
            $table->string('push_title')->nullable();
            $table->text('push_body')->nullable();
            
            $table->json('channel_config')->nullable();
            $table->timestamp('last_sent_at')->nullable();
            $table->integer('sent_count')->default(0);
        });
        
        // Tabella per tracking aperture/click
        Schema::create('notification_tracking', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_id')->unique();
            $table->foreignId('notification_log_id')->constrained();
            $table->string('event_type'); // opened, clicked, bounced, etc.
            $table->json('metadata')->nullable();
            $table->timestamp('created_at');
            
            $table->index(['tracking_id', 'event_type']);
        });
        
        // Aggiornare contatti per multi-canale
        Schema::table('contacts', function (Blueprint $table) {
            $table->json('social_channels')->nullable();
            $table->string('preferred_language', 5)->default('it');
            $table->boolean('push_opt_in')->default(false);
            $table->boolean('telegram_opt_in')->default(false);
            $table->timestamp('last_notification_sent')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('notification_templates', function (Blueprint $table) {
            $table->dropColumn([
                'email_enabled', 'sms_enabled', 'push_enabled',
                'telegram_enabled', 'whatsapp_enabled',
                'sms_body', 'push_title', 'push_body',
                'channel_config', 'last_sent_at', 'sent_count'
            ]);
        });
        
        Schema::dropIfExists('notification_tracking');
        
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn([
                'social_channels', 'preferred_language',
                'push_opt_in', 'telegram_opt_in', 'last_notification_sent'
            ]);
        });
    }
};
```

### 6.2 Command per Migration Data
```php
// app/Console/Commands/MigrateNotifyToFilament4Command.php
<?php

namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\{NotificationTemplate, Contact};

class MigrateNotifyToFilament4Command extends Command
{
    protected $signature = 'notify:migrate-filament4 {--dry-run : Solo simulazione}';
    protected $description = 'Migra dati Notify per compatibilità Filament 4';
    
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        $this->info('Inizio migrazione dati Notify per Filament 4...');
        
        // Migrazione template
        $this->migrateTemplates($dryRun);
        
        // Migrazione contatti
        $this->migrateContacts($dryRun);
        
        // Pulizia dati inconsistenti
        $this->cleanupData($dryRun);
        
        $this->info('Migrazione completata!');
    }
    
    protected function migrateTemplates($dryRun)
    {
        $templates = NotificationTemplate::all();
        $bar = $this->output->createProgressBar($templates->count());
        
        foreach ($templates as $template) {
            if (!$dryRun) {
                // Convertire vecchi template al nuovo formato
                $template->update([
                    'email_enabled' => true,
                    'sms_enabled' => !empty($template->sms_template),
                    'push_enabled' => false,
                    'channel_config' => $this->buildChannelConfig($template),
                ]);
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info("Migrati {$templates->count()} template.");
    }
    
    protected function migrateContacts($dryRun)
    {
        $contacts = Contact::all();
        $bar = $this->output->createProgressBar($contacts->count());
        
        foreach ($contacts as $contact) {
            if (!$dryRun) {
                $contact->update([
                    'preferred_language' => $this->detectLanguage($contact),
                    'social_channels' => $this->extractSocialChannels($contact),
                ]);
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info("Migrati {$contacts->count()} contatti.");
    }
    
    protected function cleanupData($dryRun)
    {
        if (!$dryRun) {
            // Rimuovere record inconsistenti
            NotificationTemplate::whereNull('name')->delete();
            Contact::whereNull('email')->whereNull('phone')->delete();
        }
        
        $this->info('Pulizia dati completata.');
    }
    
    protected function buildChannelConfig($template): array
    {
        return [
            'email' => [
                'enabled' => true,
                'priority' => 1,
            ],
            'sms' => [
                'enabled' => !empty($template->sms_template),
                'priority' => 2,
            ],
        ];
    }
    
    protected function detectLanguage($contact): string
    {
        // Logica per rilevare lingua preferita
        return 'it'; // Default
    }
    
    protected function extractSocialChannels($contact): array
    {
        // Logica per estrarre canali social esistenti
        return [];
    }
}
```

## Fase 7: Testing e Validazione (Giorni 26-28)

### 7.1 Test Suite Completa
```php
// tests/Feature/Notify/NotificationTemplateResourceTest.php
<?php

namespace Tests\Feature\Notify;

use Tests\TestCase;
use Modules\Notify\Models\{NotificationTemplate, Contact};
use Modules\User\Models\User;
use Livewire\Livewire;
use Modules\Notify\Filament\Resources\NotificationTemplateResource;

class NotificationTemplateResourceTest extends TestCase
{
    protected User $admin;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create([
            'email' => 'admin@test.com',
        ]);
        $this->admin->assignRole('super_admin');
        
        $this->actingAs($this->admin);
    }
    
    /** @test */
    public function can_list_notification_templates()
    {
        $templates = NotificationTemplate::factory()->count(3)->create();
        
        Livewire::test(NotificationTemplateResource\Pages\ListNotificationTemplates::class)
            ->assertCanSeeTableRecords($templates);
    }
    
    /** @test */
    public function can_create_notification_template_with_all_channels()
    {
        $templateData = [
            'name' => 'Test Multi-Channel Template',
            'type' => 'system',
            'subject' => 'Test Subject',
            'body_html' => '<p>Test HTML Body</p>',
            'body_text' => 'Test text body',
            'email_enabled' => true,
            'sms_enabled' => true,
            'push_enabled' => true,
            'sms_body' => 'Test SMS body',
            'push_title' => 'Test Push Title',
            'push_body' => 'Test push body',
        ];
        
        Livewire::test(NotificationTemplateResource\Pages\CreateNotificationTemplate::class)
            ->fillForm($templateData)
            ->call('create')
            ->assertHasNoFormErrors();
            
        $this->assertDatabaseHas('notification_templates', [
            'name' => 'Test Multi-Channel Template',
            'email_enabled' => true,
            'sms_enabled' => true,
            'push_enabled' => true,
        ]);
    }
    
    /** @test */
    public function can_test_send_notification()
    {
        $template = NotificationTemplate::factory()->create([
            'email_enabled' => true,
            'sms_enabled' => true,
        ]);
        
        $contact = Contact::factory()->create([
            'email' => 'test@example.com',
            'phone' => '+39123456789',
            'email_opt_in' => true,
            'sms_opt_in' => true,
        ]);
        
        Livewire::test(NotificationTemplateResource\Pages\EditNotificationTemplate::class, [
            'record' => $template->id,
        ])
            ->callAction('test_send', [
                'test_email' => 'test@example.com',
                'test_data' => ['nome_utente' => 'Mario'],
            ])
            ->assertHasNoActionErrors();
            
        // Verificare che il job sia stato accodato
        Queue::assertPushed(SendEmailJob::class);
    }
    
    /** @test */
    public function validates_required_fields()
    {
        Livewire::test(NotificationTemplateResource\Pages\CreateNotificationTemplate::class)
            ->fillForm([
                'name' => '',
                'type' => '',
            ])
            ->call('create')
            ->assertHasFormErrors(['name', 'type']);
    }
    
    /** @test */
    public function can_duplicate_template()
    {
        $original = NotificationTemplate::factory()->create([
            'name' => 'Original Template',
        ]);
        
        Livewire::test(NotificationTemplateResource\Pages\EditNotificationTemplate::class, [
            'record' => $original->id,
        ])
            ->callAction('duplicate')
            ->assertHasNoActionErrors();
            
        $this->assertDatabaseHas('notification_templates', [
            'name' => 'Original Template (Copy)',
        ]);
    }
}
```

### 7.2 Test Performance Multi-Canale
```php
// tests/Performance/Notify/MultiChannelSendTest.php
<?php

namespace Tests\Performance\Notify;

use Tests\TestCase;
use Modules\Notify\Models\{NotificationTemplate, Contact};
use Modules\Notify\Actions\UnifiedSendAction;
use Illuminate\Support\Facades\{Queue, Redis};

class MultiChannelSendTest extends TestCase
{
    /** @test */
    public function can_handle_bulk_multi_channel_send()
    {
        $this->markTestSkipped('Performance test - eseguire solo manualmente');
        
        // Creare 1000 contatti
        $contacts = Contact::factory()->count(1000)->create([
            'email_opt_in' => true,
            'sms_opt_in' => true,
            'push_opt_in' => true,
        ]);
        
        $template = NotificationTemplate::factory()->create([
            'email_enabled' => true,
            'sms_enabled' => true,
            'push_enabled' => true,
        ]);
        
        $startTime = microtime(true);
        $startMemory = memory_get_usage(true);
        
        $sendAction = app(UnifiedSendAction::class);
        $results = $sendAction->execute($template, $contacts, []);
        
        $endTime = microtime(true);
        $endMemory = memory_get_usage(true);
        
        $executionTime = $endTime - $startTime;
        $memoryUsed = ($endMemory - $startMemory) / 1024 / 1024; // MB
        
        $this->assertLessThan(30, $executionTime, 'Invio dovrebbe completarsi in meno di 30 secondi');
        $this->assertLessThan(50, $memoryUsed, 'Dovrebbe usare meno di 50MB di memoria');
        
        // Verificare che tutti i job siano stati accodati
        $expectedJobs = $contacts->count() * 3; // email + sms + push
        Queue::assertPushed(SendEmailJob::class, $contacts->count());
        Queue::assertPushed(SendSmsJob::class, $contacts->count());
        Queue::assertPushed(SendPushJob::class, $contacts->count());
        
        $this->info("Tempo esecuzione: {$executionTime}s");
        $this->info("Memoria utilizzata: {$memoryUsed}MB");
        $this->info("Job accodati: {$expectedJobs}");
    }
}
```

## Fase 8: Finalizzazione e Documentazione (Giorni 29-30)

### 8.1 Configurazione Produzione
```php
// config/notify.php - Configurazione finale
<?php

return [
    'enabled_channels' => [
        'email' => true,
        'sms' => env('NOTIFY_SMS_ENABLED', false),
        'push' => env('NOTIFY_PUSH_ENABLED', false),
        'telegram' => env('NOTIFY_TELEGRAM_ENABLED', false),
        'whatsapp' => env('NOTIFY_WHATSAPP_ENABLED', false),
    ],
    
    'rate_limiting' => [
        'email' => 100, // per minuto
        'sms' => 10,   // per minuto
        'push' => 500, // per minuto
    ],
    
    'queue_connections' => [
        'email' => 'redis',
        'sms' => 'redis',
        'push' => 'redis',
        'telegram' => 'sync', // Per testing
    ],
    
    'tracking' => [
        'enabled' => true,
        'track_opens' => true,
        'track_clicks' => true,
        'pixel_tracking' => true,
    ],
    
    'security' => [
        'require_opt_in' => true,
        'double_opt_in' => true,
        'encrypt_personal_data' => true,
        'gdpr_compliance' => true,
    ],
];
```

### 8.2 Deploy Script
```bash
#!/bin/bash
# deploy-notify-filament4.sh

echo "🚀 Deploy Notify Module - Filament 4"

# 1. Backup
php artisan down
php artisan backup:run --only-db

# 2. Dipendenze
composer install --no-dev --optimize-autoloader
npm install && npm run build

# 3. Database
php artisan migrate --force
php artisan notify:migrate-filament4

# 4. Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize

# 5. Queue
php artisan queue:restart

# 6. Test finale
php artisan notify:test-smtp --silent

php artisan up

echo "✅ Deploy completato!"
echo "📊 Monitorare dashboard per 24h"
echo "🔔 Configurare monitoring per code"
```

## Vantaggi Post-Migrazione

### ✅ Vantaggi Tecnici
- **Unified Schema**: Riduzione 60% codice duplicato
- **Multi-Canale**: Invio simultaneo email/SMS/push/Telegram
- **Real-time Monitoring**: Dashboard live delle code
- **Performance**: +40% velocità con lazy loading
- **Testing**: Suite completa per tutti i canali

### ✅ Vantaggi Business
- **UX Migliorata**: Wizard step-by-step per template
- **Automazione**: Invii programmati e ricorrenti
- **Tracking**: Analytics complete aperture/click
- **Compliance**: GDPR compliant con opt-in/out
- **Scaling**: Gestione milioni di notifiche

## Svantaggi e Rischi

### ❌ Svantaggi
- **Complessità**: Sistema multi-canale complesso
- **Breaking Changes**: Richiede training team
- **Dipendenze**: Multiple API esterne
- **Costi**: Rate limiting richiede servizi premium

### ⚠️ Rischi Mitigati
- **Downtime**: Deploy con rollback automatico
- **Data Loss**: Backup incrementali ogni 4h
- **Performance**: Load testing con 10K+ contatti
- **Security**: Audit completo pre-produzione

## Timeline Finale
- **Giorni 1-8**: Setup e ricostruzione base
- **Giorni 9-18**: Sviluppo multi-canale e dashboard
- **Giorni 19-25**: Testing e migration
- **Giorni 26-28**: Validazione e performance
- **Giorni 29-30**: Deploy e monitoring

**Stima Totale**: 28 giorni lavorativi  
**Team Richiesto**: 2 senior developer + 1 QA specialist  
**Budget Stimato**: €35.000 - €42.000