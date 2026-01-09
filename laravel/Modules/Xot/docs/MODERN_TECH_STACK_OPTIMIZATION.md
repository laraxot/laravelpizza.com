# Modern Tech Stack Optimization Guide
## Filament 4 + Laravel 12 + PHP 8.3 Best Practices

## 🚀 Overview

Questa guida fornisce strategie specifiche per ottimizzare il codebase esistente sfruttando al massimo le features moderne di PHP 8.3, Laravel 12 e Filament 4.

## 📋 Current Tech Stack Analysis

### Current State
- **PHP**: 8.3.25 ✅
- **Laravel**: 12.31.1 ✅
- **Filament**: 4.0.20 ✅
- **Livewire**: 3.6.4 ✅
- **Volt**: 1.7.2 ✅

### Packages Status
- Laravel Passport: 12.4.2 ✅
- Laravel Pennant: 1.18.2 ✅
- Laravel Pulse: 1.4.3 ✅
- Laravel Socialite: 5.23.0 ✅
- Pest: 3.8.4 ✅
- PHPStan/Larastan: 3.7.2 ✅

## 🎯 PHP 8.3 Feature Integration

### 1. Readonly Properties & Classes
**Current Pattern**:
```php
class SurveyConfig
{
    public string $title;
    public array $questions;

    public function __construct(string $title, array $questions)
    {
        $this->title = $title;
        $this->questions = $questions;
    }
}
```

**Optimized Pattern**:
```php
readonly class SurveyConfig
{
    public function __construct(
        public string $title,
        public array $questions,
        public PdfStyle $style,
        public ?ContactList $recipients = null
    ) {}
}

// Usage
$config = new SurveyConfig(
    title: 'Customer Satisfaction Survey',
    questions: $questions,
    style: $pdfStyle
);
```

### 2. Enhanced Type System
**Current Pattern**:
```php
class Contact extends BaseModel
{
    protected $casts = [
        'metadata' => 'array',
        'preferences' => 'json'
    ];
}
```

**Optimized Pattern**:
```php
class Contact extends XotUniversalBaseModel
{
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'email' => 'string',
            'mobile_phone' => 'string',
            'metadata' => 'array<string, mixed>',
            'preferences' => ContactPreferences::class, // Custom cast
            'sms_sent_at' => 'datetime',
            'mail_sent_at' => 'datetime',
            'sms_count' => 'int',
            'mail_count' => 'int',
        ];
    }
}

// Custom Cast per type safety
class ContactPreferences implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): ContactPreferencesValue
    {
        return new ContactPreferencesValue(json_decode($value, true) ?? []);
    }

    public function set($model, string $key, $value, array $attributes): string
    {
        return json_encode($value instanceof ContactPreferencesValue ? $value->toArray() : $value);
    }
}
```

### 3. Match Expressions
**Current Pattern**:
```php
public function getNotificationMethod()
{
    switch ($this->contact_type) {
        case 'email':
            return new EmailNotification();
        case 'sms':
            return new SmsNotification();
        case 'push':
            return new PushNotification();
        default:
            throw new InvalidArgumentException("Unknown contact type: {$this->contact_type}");
    }
}
```

**Optimized Pattern**:
```php
public function getNotificationMethod(): NotificationMethodContract
{
    return match($this->contact_type) {
        'email' => new EmailNotification(),
        'sms' => new SmsNotification(),
        'push' => new PushNotification(),
        default => throw new InvalidContactTypeException($this->contact_type)
    };
}

public function getChannelClass(): string
{
    return match($this->contact_type) {
        'email' => MailChannel::class,
        'sms' => SmsChannel::class,
        'push' => PushNotificationChannel::class,
        default => throw new InvalidContactTypeException($this->contact_type)
    };
}
```

### 4. Attributes & Reflection
**New Pattern**:
```php
#[AsCommand(name: 'survey:generate-reports')]
class GenerateSurveyReportsCommand extends Command
{
    #[Autowire]
    public function __construct(
        private readonly SurveyReportService $reportService,
        private readonly PdfGeneratorService $pdfGenerator,
        private readonly CacheManagerService $cacheManager
    ) {
        parent::__construct();
    }
}

#[Route('/api/surveys/{survey}/export', methods: ['GET'])]
#[Middleware(['auth:api', 'throttle:60,1'])]
class SurveyExportController
{
    #[Inject]
    public function __invoke(
        SurveyPdf $survey,
        ExportFormatEnum $format = ExportFormatEnum::PDF
    ): Response {
        // Implementation
    }
}
```

## 🏗️ Laravel 12 Advanced Features

### 1. Enhanced Model Casting
**Current Pattern**:
```php
protected $casts = [
    'settings' => 'json',
    'created_at' => 'datetime'
];
```

**Optimized Pattern**:
```php
protected function casts(): array
{
    return [
        'settings' => 'encrypted:json', // Laravel 12 encrypted casting
        'sensitive_data' => 'encrypted:string',
        'created_at' => 'datetime',
        'metadata' => AsArrayObject::class, // More powerful array handling
        'preferences' => AsCollection::class,
    ];
}

// Custom encrypted cast for sensitive contact data
class EncryptedContactData implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): ?ContactDataValue
    {
        if ($value === null) {
            return null;
        }

        $decrypted = decrypt($value);
        return new ContactDataValue(json_decode($decrypted, true));
    }

    public function set($model, string $key, $value, array $attributes): ?string
    {
        if ($value === null) {
            return null;
        }

        return encrypt(json_encode($value instanceof ContactDataValue ? $value->toArray() : $value));
    }
}
```

### 2. Advanced Query Builder
**Current Pattern**:
```php
$contacts = Contact::where('active', true)
    ->where('email', 'like', '%@example.com')
    ->get();
```

**Optimized Pattern**:
```php
// Using Laravel 12 enhanced query builder
$contacts = Contact::query()
    ->whereActive()
    ->whereEmailDomain('example.com')
    ->with(['surveyPdf:id,title', 'questionCharts:id,survey_pdf_id,chart_type'])
    ->lazy() // Memory-efficient processing
    ->filter(fn($contact) => $contact->hasValidPhone())
    ->chunk(100)
    ->map(fn($chunk) => $this->processContactBatch($chunk))
    ->flatten();

// Custom query scopes
class Contact extends XotUniversalBaseModel
{
    public function scopeWhereActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function scopeWhereEmailDomain(Builder $query, string $domain): Builder
    {
        return $query->where('email', 'like', "%@{$domain}");
    }

    public function scopeWithSurveyData(Builder $query): Builder
    {
        return $query->with([
            'surveyPdf' => fn($q) => $q->select(['id', 'title', 'status']),
            'questionCharts' => fn($q) => $q->select(['id', 'survey_pdf_id', 'chart_type', 'config'])
        ]);
    }
}
```

### 3. Advanced Validation
**Current Pattern**:
```php
$request->validate([
    'email' => 'required|email|unique:contacts',
    'phone' => 'nullable|regex:/^[+]?[0-9\s\-\(\)]+$/'
]);
```

**Optimized Pattern**:
```php
// Custom Form Request with advanced validation
class ContactFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email:rfc,dns', // Enhanced email validation
                Rule::unique('contacts', 'email')->ignore($this->contact),
                new EmailDomainAllowed(), // Custom rule
            ],
            'mobile_phone' => [
                'nullable',
                'phone:AUTO,mobile', // Laravel phone validation
                new PhoneNumberValid(),
            ],
            'survey_pdf_id' => [
                'required',
                Rule::exists('survey_pdfs', 'id')->where('active', true),
            ],
            'preferences' => ['array'],
            'preferences.*.type' => ['required', 'string', Rule::in(['email', 'sms', 'push'])],
            'preferences.*.enabled' => ['required', 'boolean'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('manage', Contact::class);
    }

    protected function passedValidation(): void
    {
        // Additional processing after validation passes
        $this->merge([
            'processed_at' => now(),
            'processed_by' => auth()->id(),
        ]);
    }
}

// Custom validation rules
class EmailDomainAllowed implements Rule
{
    public function passes($attribute, $value): bool
    {
        $domain = substr(strrchr($value, "@"), 1);
        return !in_array($domain, config('contacts.blocked_domains', []));
    }

    public function message(): string
    {
        return 'The email domain is not allowed.';
    }
}
```

### 4. Modern Event System
**Current Pattern**:
```php
// Basic event handling
Event::listen(ContactCreated::class, SendWelcomeEmail::class);
```

**Optimized Pattern**:
```php
// Advanced event system with typed events
class ContactCreated
{
    public function __construct(
        public readonly Contact $contact,
        public readonly User $createdBy,
        public readonly array $metadata = []
    ) {}
}

class ContactEventSubscriber
{
    public function handleContactCreated(ContactCreated $event): void
    {
        // Multiple actions can be triggered
        dispatch(new SendWelcomeEmailJob($event->contact));
        dispatch(new UpdateContactStatsJob($event->contact));
        dispatch(new LogContactActivityJob($event->contact, 'created', $event->createdBy));
    }

    public function handleContactUpdated(ContactUpdated $event): void
    {
        if ($event->emailChanged()) {
            dispatch(new SendEmailChangeNotificationJob($event->contact, $event->oldEmail));
        }

        if ($event->phoneChanged()) {
            dispatch(new SendPhoneChangeNotificationJob($event->contact, $event->oldPhone));
        }
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            ContactCreated::class => 'handleContactCreated',
            ContactUpdated::class => 'handleContactUpdated',
        ];
    }
}
```

## 🎨 Filament 4 Optimization

### 1. Modern Resource Structure
**Current Pattern**:
```php
class ContactResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('email')->email()->required(),
            TextInput::make('phone'),
        ]);
    }
}
```

**Optimized Pattern**:
```php
class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Basic Information')
                        ->schema([
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('first_name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) =>
                                        $set('full_name', $state . ' ' . request()->get('last_name', ''))
                                    ),

                                Forms\Components\TextInput::make('last_name')
                                    ->required()
                                    ->maxLength(255),
                            ])->columns(2),

                            Forms\Components\TextInput::make('email')
                                ->email()
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($state) {
                                        $domain = substr(strrchr($state, "@"), 1);
                                        $set('email_domain', $domain);
                                    }
                                }),

                            Forms\Components\TextInput::make('mobile_phone')
                                ->tel()
                                ->live(onBlur: true)
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($state) {
                                        $formatted = phone($state)->format(PhoneNumberFormat::INTERNATIONAL);
                                        $set('mobile_phone', $formatted);
                                    }
                                }),
                        ]),

                    Forms\Components\Wizard\Step::make('Survey Assignment')
                        ->schema([
                            Forms\Components\Select::make('survey_pdf_id')
                                ->relationship('surveyPdf', 'title')
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($state) {
                                        $survey = SurveyPdf::find($state);
                                        $set('estimated_completion_time', $survey?->estimated_time);
                                    }
                                }),

                            Forms\Components\Repeater::make('customFields')
                                ->relationship()
                                ->schema([
                                    Forms\Components\TextInput::make('field_name')
                                        ->required(),
                                    Forms\Components\TextInput::make('field_value')
                                        ->required(),
                                ])
                                ->collapsible()
                                ->defaultItems(0),
                        ]),

                    Forms\Components\Wizard\Step::make('Preferences')
                        ->schema([
                            Forms\Components\CheckboxList::make('notification_preferences')
                                ->options([
                                    'email' => 'Email Notifications',
                                    'sms' => 'SMS Notifications',
                                    'push' => 'Push Notifications',
                                ])
                                ->default(['email'])
                                ->live(),

                            Forms\Components\Select::make('preferred_language')
                                ->options([
                                    'en' => 'English',
                                    'it' => 'Italiano',
                                    'es' => 'Español',
                                ])
                                ->default('en'),

                            Forms\Components\Textarea::make('notes')
                                ->rows(3)
                                ->columnSpanFull(),
                        ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->circular()
                    ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->full_name)),

                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable()
                    ->weight(FontWeight::Bold),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Email copied!')
                    ->icon('heroicon-o-envelope'),

                Tables\Columns\TextColumn::make('mobile_phone')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-phone'),

                Tables\Columns\BadgeColumn::make('status')
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'pending' => 'warning',
                        'inactive' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'active' => 'heroicon-o-check-circle',
                        'pending' => 'heroicon-o-clock',
                        'inactive' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-question-mark-circle',
                    }),

                Tables\Columns\TextColumn::make('surveyPdf.title')
                    ->label('Survey')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'pending' => 'Pending',
                        'inactive' => 'Inactive',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('survey')
                    ->relationship('surveyPdf', 'title')
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('has_phone')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('mobile_phone'))
                    ->label('Has Phone Number'),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('sendEmail')
                    ->icon('heroicon-o-envelope')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\Select::make('template')
                            ->options([
                                'welcome' => 'Welcome Email',
                                'survey_invitation' => 'Survey Invitation',
                                'reminder' => 'Reminder',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('custom_message')
                            ->rows(3),
                    ])
                    ->action(function (Contact $record, array $data): void {
                        dispatch(new SendEmailToContactJob($record, $data['template'], $data['custom_message'] ?? null));

                        Notification::make()
                            ->title('Email queued successfully')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('sendSms')
                    ->icon('heroicon-o-phone')
                    ->color('warning')
                    ->visible(fn (Contact $record): bool => !empty($record->mobile_phone))
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\Textarea::make('message')
                            ->required()
                            ->maxLength(160)
                            ->live()
                            ->afterStateUpdated(fn ($state, callable $set) =>
                                $set('character_count', strlen($state))
                            ),
                        Forms\Components\Placeholder::make('character_count')
                            ->content(fn ($get) => 'Characters: ' . strlen($get('message') ?? '') . '/160'),
                    ])
                    ->action(function (Contact $record, array $data): void {
                        dispatch(new SendSmsToContactJob($record, $data['message']));

                        Notification::make()
                            ->title('SMS queued successfully')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('sendBulkEmail')
                        ->icon('heroicon-o-envelope')
                        ->color('primary')
                        ->form([
                            Forms\Components\Select::make('template')
                                ->options([
                                    'newsletter' => 'Newsletter',
                                    'announcement' => 'Announcement',
                                    'survey_reminder' => 'Survey Reminder',
                                ])
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            foreach ($records as $contact) {
                                dispatch(new SendEmailToContactJob($contact, $data['template']));
                            }

                            Notification::make()
                                ->title('Bulk emails queued successfully')
                                ->body($records->count() . ' emails have been queued.')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\BulkAction::make('exportToCsv')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('gray')
                        ->action(function (Collection $records): void {
                            return response()->streamDownload(function () use ($records) {
                                echo "Name,Email,Phone,Status,Survey,Created At\n";
                                foreach ($records as $contact) {
                                    echo implode(',', [
                                        $contact->full_name,
                                        $contact->email,
                                        $contact->mobile_phone ?? '',
                                        $contact->status,
                                        $contact->surveyPdf?->title ?? '',
                                        $contact->created_at->format('Y-m-d H:i:s'),
                                    ]) . "\n";
                                }
                            }, 'contacts-export-' . now()->format('Y-m-d-H-i-s') . '.csv');
                        }),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus')
                    ->label('Create first contact'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            QuestionChartsRelationManager::class,
            NotificationLogsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'view' => Pages\ViewContact::route('/{record}'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $pendingCount = static::getModel()::where('status', 'pending')->count();
        return $pendingCount > 10 ? 'danger' : 'warning';
    }
}
```

### 2. Advanced Widget System
**New Pattern**:
```php
class ContactStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Contacts', Contact::count())
                ->description('All registered contacts')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Active Surveys', SurveyPdf::where('status', 'active')->count())
                ->description('Currently running surveys')
                ->descriptionIcon('heroicon-o-clipboard-document-list')
                ->color('success'),

            Stat::make('Pending Notifications', function () {
                return DB::table('jobs')->where('queue', 'notifications')->count();
            })
                ->description('Queued notifications')
                ->descriptionIcon('heroicon-o-bell')
                ->color('warning'),

            Stat::make('Completion Rate', function () {
                $total = Contact::count();
                $completed = Contact::whereHas('surveyResponses')->count();
                return $total > 0 ? round(($completed / $total) * 100, 1) . '%' : '0%';
            })
                ->description('Survey completion rate')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('info'),
        ];
    }
}

class RecentActivityWidget extends Widget
{
    protected static string $view = 'filament.widgets.recent-activity';

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        return [
            'activities' => Activity::with(['causer', 'subject'])
                ->latest()
                ->limit(10)
                ->get()
                ->map(function ($activity) {
                    return [
                        'description' => $activity->description,
                        'causer' => $activity->causer?->name ?? 'System',
                        'subject_type' => class_basename($activity->subject_type),
                        'created_at' => $activity->created_at->diffForHumans(),
                        'icon' => $this->getIconForActivity($activity),
                        'color' => $this->getColorForActivity($activity),
                    ];
                }),
        ];
    }

    private function getIconForActivity($activity): string
    {
        return match ($activity->description) {
            'created' => 'heroicon-o-plus-circle',
            'updated' => 'heroicon-o-pencil-square',
            'deleted' => 'heroicon-o-trash',
            'email_sent' => 'heroicon-o-envelope',
            'sms_sent' => 'heroicon-o-phone',
            default => 'heroicon-o-information-circle',
        };
    }

    private function getColorForActivity($activity): string
    {
        return match ($activity->description) {
            'created' => 'success',
            'updated' => 'warning',
            'deleted' => 'danger',
            'email_sent', 'sms_sent' => 'info',
            default => 'gray',
        };
    }
}
```

### 3. Modern Dashboard
**Complete Dashboard Structure**:
```php
class ContactDashboard extends Dashboard
{
    public function getWidgets(): array
    {
        return [
            ContactStatsWidget::class,
            ContactChartWidget::class,
            RecentActivityWidget::class,
            NotificationQueueWidget::class,
        ];
    }

    public function getTitle(): string
    {
        return 'Contact Management Dashboard';
    }

    public function getSubNavigation(): array
    {
        return [
            'overview' => [
                'label' => 'Overview',
                'url' => route('filament.quaeris.dashboard'),
                'isActive' => request()->routeIs('filament.quaeris.dashboard'),
            ],
            'analytics' => [
                'label' => 'Analytics',
                'url' => route('filament.quaeris.analytics'),
                'isActive' => request()->routeIs('filament.quaeris.analytics'),
            ],
            'reports' => [
                'label' => 'Reports',
                'url' => route('filament.quaeris.reports'),
                'isActive' => request()->routeIs('filament.quaeris.reports'),
            ],
        ];
    }
}
```

## 🔧 Implementation Priority Matrix

### High Priority (Week 1-2)
1. ✅ **PHP 8.3 Features**
   - Readonly classes per configuration objects
   - Match expressions per business logic
   - Enhanced type declarations

2. ✅ **Laravel 12 Core**
   - Advanced model casting
   - Enhanced validation
   - Modern query patterns

### Medium Priority (Week 3-4)
1. ✅ **Filament 4 Optimization**
   - Resource modernization
   - Widget enhancement
   - Advanced forms

2. ✅ **Performance Improvements**
   - Query optimization
   - Caching strategies
   - Memory management

### Low Priority (Week 5-6)
1. ✅ **Advanced Features**
   - Event system enhancement
   - Custom attributes
   - Advanced testing

## 📊 Performance Benchmarks

### Target Metrics
- **Dashboard Load**: <800ms
- **Form Submission**: <200ms
- **Data Export**: <5s per 1000 records
- **Memory Usage**: <128MB per request
- **Database Queries**: <25 per page load

### Monitoring Setup
```php
// Custom middleware for performance monitoring
class PerformanceMonitoringMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage(true);

        $response = $next($request);

        $endTime = microtime(true);
        $endMemory = memory_get_usage(true);

        $metrics = [
            'execution_time' => ($endTime - $startTime) * 1000, // ms
            'memory_usage' => ($endMemory - $startMemory) / 1024 / 1024, // MB
            'peak_memory' => memory_get_peak_usage(true) / 1024 / 1024, // MB
            'queries_count' => DB::getQueryLog() ? count(DB::getQueryLog()) : 0,
        ];

        // Log slow requests
        if ($metrics['execution_time'] > 1000) { // > 1 second
            Log::warning('Slow request detected', [
                'url' => $request->url(),
                'method' => $request->method(),
                'metrics' => $metrics,
            ]);
        }

        return $response;
    }
}
```

## 🎯 Success Criteria

### Technical Compliance
- [ ] 100% PHP 8.3 feature adoption
- [ ] Laravel 12 best practices implementation
- [ ] Filament 4 optimization complete
- [ ] Performance targets achieved
- [ ] Type safety at 95%+

### Code Quality
- [ ] PHPStan Level 9+ compliance
- [ ] Zero deprecated code usage
- [ ] Modern patterns consistently applied
- [ ] Documentation updated
- [ ] Tests comprehensive (85%+ coverage)

Questa guida fornisce una roadmap completa per modernizzare il tech stack e sfruttare al massimo le capacità delle versioni più recenti dei framework utilizzati.
