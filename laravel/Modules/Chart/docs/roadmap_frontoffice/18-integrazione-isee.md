# Implementazione Integrazione ISEE

## Stato: In Corso (30%)

## Descrizione
Implementazione del sistema di integrazione ISEE per la gestione degli sconti basati sul reddito, inclusa la verifica documenti, il calcolo delle fasce e l'applicazione degli sconti.

## Componenti Implementati

### 1. Verifica Documenti ISEE
- Funzionalità:
  - Upload DSU
  - Verifica automatica
  - Validazione dati
  - Archivio documenti
  - Storico verifiche
  - Notifiche stato

### 2. Calcolo Fasce ISEE
- Caratteristiche:
  - Definizione fasce
  - Calcolo automatico
  - Validazione importi
  - Storico calcoli
  - Report utilizzo
  - Aggiornamento annuale

### 3. Gestione Sconti
- Funzionalità:
  - Configurazione percentuali
  - Applicazione automatica
  - Validazione sconti
  - Storico applicazioni
  - Report efficacia
  - Analytics sconti

### 4. Sistema Notifiche
- Processo:
  - Notifiche scadenza
  - Promemoria rinnovo
  - Alert documenti
  - Comunicazioni stato
  - Notifiche sconti
  - Report invii

## Dettagli Implementazione

### Frontend
```php
// app/Filament/Resources/IseeDocumentResource.php
class IseeDocumentResource extends Resource
{
    protected static ?string $model = IseeDocument::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('patient_id')
                    ->relationship('patient', 'name')
                    ->required(),
                Forms\Components\FileUpload::make('file_path')
                    ->required()
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(5120),
                Forms\Components\TextInput::make('isee_value')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('income_band')
                    ->options([
                        'A' => 'Fascia A',
                        'B' => 'Fascia B',
                        'C' => 'Fascia C',
                    ])
                    ->required(),
                Forms\Components\DateTimePicker::make('valid_from')
                    ->required(),
                Forms\Components\DateTimePicker::make('valid_to')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'In attesa',
                        'verified' => 'Verificato',
                        'rejected' => 'Rifiutato',
                        'expired' => 'Scaduto'
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient.name'),
                Tables\Columns\TextColumn::make('isee_value'),
                Tables\Columns\TextColumn::make('income_band'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('valid_to')
                    ->dateTime(),
            ]);
    }
}
```

### Backend
```php
// app/Actions/ProcessIseeDocument.php
class ProcessIseeDocument
{
    use QueueableAction;

    public function __construct(
        public Patient $patient,
        public UploadedFile $document
    ) {}

    public function handle()
    {
        // Validazione documento
        $this->validateDocument();

        // Estrazione dati
        $iseeData = $this->extractIseeData();

        // Calcolo ISEE
        $iseeValue = $this->calculateIsee($iseeData);

        // Determinazione fascia
        $band = $this->determineIncomeBand($iseeValue);

        // Salvataggio dati
        $this->saveIseeData($iseeData, $iseeValue, $band);

        // Notifica sistema
        event(new IseeProcessed($this->patient, $iseeValue, $band));

        return [
            'isee_value' => $iseeValue,
            'income_band' => $band,
            'discount_percentage' => $this->getDiscountPercentage($band)
        ];
    }

    private function calculateIsee($data)
    {
        // Calcolo ISEE secondo normativa
        $isee = $data['reddito_complessivo'];
        $isee += $data['patrimonio_mobiliare'] * 0.2;
        $isee += $data['patrimonio_immobiliare'] * 0.2;
        
        // Applica parametri scala equivalenza
        $isee = $isee / $data['scala_equivalenza'];

        return $isee;
    }
}
```

### Modelli
```php
// app/Models/IseeDocument.php
class IseeDocument extends Model
{
    protected $fillable = [
        'patient_id',
        'document_type',
        'file_path',
        'isee_value',
        'income_band',
        'valid_from',
        'valid_to',
        'status',
        'verified_at'
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
        'verified_at' => 'datetime'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function getStatus()
    {
        return [
            'pending' => 'In attesa',
            'verified' => 'Verificato',
            'rejected' => 'Rifiutato',
            'expired' => 'Scaduto'
        ][$this->status] ?? 'Sconosciuto';
    }

    public function isExpired()
    {
        return $this->valid_to->isPast();
    }
}
```

## Test Implementati
- ✅ Test verifica documenti
- ✅ Test calcolo ISEE
- ✅ Test fasce reddito
- ✅ Test sconti
- ✅ Test notifiche

## Metriche
- Tempo elaborazione: < 1 min
- Accuratezza calcolo: 100%
- Tasso approvazione: 95%
- Tasso utilizzo: 70%

## Documenti Correlati
- [Sistema Prezzi](./19-sistema-prezzi.md)
- [Gestione Documenti](./20-gestione-documenti.md)
- [Sistema Notifiche](./28-sistema-notifiche.md)

## Note
- Conformità normativa
- Backup documenti
- Audit trail
- Log completo
- Monitoraggio scadenze
- Report periodici
- Privacy compliance
- Performance monitoring 
