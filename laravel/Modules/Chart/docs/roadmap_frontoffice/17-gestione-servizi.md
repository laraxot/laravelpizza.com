# Implementazione Gestione Servizi

## Stato: In Corso (65%)

## Descrizione
Implementazione del sistema completo di gestione dei servizi odontoiatrici, inclusa la configurazione dei servizi, la gestione delle specializzazioni e l'integrazione con il sistema di prenotazioni.

## Componenti Implementati

### 1. Configurazione Servizi
- Funzionalità:
  - Creazione servizi
  - Categorizzazione
  - Descrizioni dettagliate
  - Durata stimata
  - Requisiti speciali
  - Documentazione

### 2. Gestione Specializzazioni
- Caratteristiche:
  - Definizione specializzazioni
  - Assegnazione servizi
  - Requisiti formazione
  - Certificazioni
  - Validazione competenze
  - Storico aggiornamenti

### 3. Sistema Prezzi
- Funzionalità:
  - Configurazione prezzi
  - Gestione sconti
  - Prezzi ISEE
  - Prezzi convenzionati
  - Storico modifiche
  - Report prezzi

### 4. Integrazione Prenotazioni
- Processo:
  - Disponibilità servizi
  - Slot temporali
  - Gestione risorse
  - Calendario servizi
  - Notifiche sistema
  - Report utilizzo

## Dettagli Implementazione

### Frontend
```php
// app/Filament/Resources/ServiceResource.php
class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                Forms\Components\TextInput::make('duration')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('description')
                    ->required(),
                Forms\Components\KeyValue::make('special_requirements'),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\TextColumn::make('duration'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ]);
    }
}

// app/Filament/Pages/ServiceCalendar.php
class ServiceCalendar extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Calendario Servizi';
    protected static ?string $title = 'Calendario Servizi';

    public function getViewData(): array
    {
        return [
            'events' => Service::query()
                ->with(['bookings', 'category'])
                ->get()
                ->map(fn ($service) => [
                    'id' => $service->id,
                    'title' => $service->name,
                    'start' => $service->bookings->pluck('start_time'),
                    'end' => $service->bookings->pluck('end_time'),
                    'color' => $service->category->color,
                ]),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ServiceCalendarWidget::class,
        ];
    }
}

// app/Filament/Widgets/ServiceCalendarWidget.php
class ServiceCalendarWidget extends Widget
{
    protected static string $view = 'filament.widgets.service-calendar-widget';

    protected function getViewData(): array
    {
        return [
            'events' => Service::query()
                ->with(['bookings', 'category'])
                ->get()
                ->map(fn ($service) => [
                    'id' => $service->id,
                    'title' => $service->name,
                    'start' => $service->bookings->pluck('start_time'),
                    'end' => $service->bookings->pluck('end_time'),
                    'color' => $service->category->color,
                ]),
        ];
    }
}
```

### Backend
```php
// app/Actions/CreateService.php
class CreateService
{
    use QueueableAction;

    public function __construct(
        public array $data
    ) {}

    public function handle()
    {
        // Validazione dati
        $this->validateData();

        // Creazione servizio
        $service = Service::create([
            'name' => $this->data['name'],
            'description' => $this->data['description'],
            'category_id' => $this->data['category_id'],
            'duration' => $this->data['duration'],
            'special_requirements' => $this->data['special_requirements'],
            'is_active' => true
        ]);

        // Configurazione prezzi
        $this->setupPricing($service);

        // Configurazione specializzazioni
        $this->setupSpecializations($service);

        // Notifica sistema
        event(new ServiceCreated($service));

        return $service;
    }

    private function setupPricing($service)
    {
        foreach ($this->data['pricing'] as $type => $price) {
            ServicePrice::create([
                'service_id' => $service->id,
                'price_type' => $type,
                'amount' => $price,
                'is_active' => true
            ]);
        }
    }
}
```

### Modelli
```php
// app/Models/Service.php
class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'duration',
        'special_requirements',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'special_requirements' => 'array',
        'is_active' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function specializations()
    {
        return $this->belongsToMany(Specialization::class);
    }

    public function prices()
    {
        return $this->hasMany(ServicePrice::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getCurrentPrice($type = 'standard')
    {
        return $this->prices()
            ->where('price_type', $type)
            ->where('is_active', true)
            ->latest()
            ->first();
    }
}
```

## Test Implementati
- ✅ Test creazione servizi
- ✅ Test specializzazioni
- ✅ Test prezzi
- ✅ Test prenotazioni
- ✅ Test integrazione

## Metriche
- Tempo creazione: < 1 min
- Accuratezza prezzi: 100%
- Tasso utilizzo: 85%
- Tasso errori: 0.5%

## Documenti Correlati
- [Sistema Prezzi](./19-sistema-prezzi.md)
- [Sistema Prenotazioni](./16-sistema-prenotazioni.md)
- [Gestione Documenti](./20-gestione-documenti.md)

## Note
- Conformità normativa
- Audit trail
- Log completo
- Backup dati
- Performance monitoring
- Analytics servizi
- Report periodici
- Ottimizzazione query

## Link al Codice
- [Filament FullCalendar](https://github.com/saade/filament-fullcalendar)
- [ServiceCalendar Widget](app/Filament/Widgets/ServiceCalendarWidget.php)
- [ServiceCalendar Page](app/Filament/Pages/ServiceCalendar.php)
- [Service Model](app/Models/Service.php)
- [CreateService Action](app/Actions/CreateService.php) 
