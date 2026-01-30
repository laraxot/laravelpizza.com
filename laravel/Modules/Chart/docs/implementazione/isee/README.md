# Integrazione ISEE il progetto

## Panoramica
L'integrazione ISEE gestisce la verifica, importazione e calcolo delle fasce ISEE per determinare tariffe e agevolazioni per i pazienti.

## Configurazione

```php
// config/isee.php
return [
    'fasce' => [
        ['min' => 0, 'max' => 10000, 'sconto' => 80],
        ['min' => 10001, 'max' => 20000, 'sconto' => 60],
        ['min' => 20001, 'max' => 30000, 'sconto' => 40],
        ['min' => 30001, 'max' => 40000, 'sconto' => 20],
        ['min' => 40001, 'max' => null, 'sconto' => 0],
    ],
    'documenti_richiesti' => [
        'dsu',
        'certificato_isee',
        'documento_identita',
    ],
    'validita_giorni' => 365,
    'notifica_scadenza_giorni' => 30,
];
```

## Modello Dati

```php
namespace Modules\Patient\Models;

use Modules\Xot\Models\BaseModel;
use Modules\Tenant\Traits\BelongsToTenant;
use Modules\Media\Models\Media;

class PatientIsee extends BaseModel
{
    use BelongsToTenant;
    
    protected $fillable = [
        'patient_id',
        'value',
        'document_id',
        'valid_from',
        'valid_until',
        'certificate_number',
        'verification_status',
        'notes',
    ];
    
    protected $casts = [
        'value' => 'decimal:2',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'verification_status' => IseeVerificationStatus::class,
    ];
    
    // Relazioni
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    
    public function document()
    {
        return $this->belongsTo(Media::class);
    }
    
    // Metodi
    public function getDiscountPercentageAttribute()
    {
        return app(IseeService::class)->calculateDiscountPercentage($this->value);
    }
    
    public function getIsValidAttribute()
    {
        return $this->valid_until->isFuture() && 
               $this->verification_status === IseeVerificationStatus::VERIFIED;
    }
}
```

## Servizi

```php
namespace Modules\Patient\Services;

use Modules\Patient\Models\PatientIsee;
use Modules\Patient\Enums\IseeVerificationStatus;
use Illuminate\Support\Carbon;
use Illuminate\Http\UploadedFile;

class IseeService
{
    /**
     * Calcola la percentuale di sconto in base al valore ISEE
     */
    public function calculateDiscountPercentage(?float $iseeValue): int
    {
        if ($iseeValue === null) {
            return 0;
        }
        
        $fasce = config('isee.fasce', []);
        
        foreach ($fasce as $fascia) {
            $min = $fascia['min'];
            $max = $fascia['max'];
            
            if (
                $iseeValue >= $min && 
                ($max === null || $iseeValue <= $max)
            ) {
                return $fascia['sconto'];
            }
        }
        
        return 0;
    }
    
    /**
     * Calcola il prezzo finale dopo lo sconto ISEE
     */
    public function calculateDiscountedPrice(float $originalPrice, ?float $iseeValue): float
    {
        $discountPercentage = $this->calculateDiscountPercentage($iseeValue);
        $discountAmount = $originalPrice * ($discountPercentage / 100);
        
        return $originalPrice - $discountAmount;
    }
    
    /**
     * Registra un nuovo certificato ISEE
     */
    public function registerIsee(
        int $patientId, 
        float $value, 
        ?string $certificateNumber, 
        UploadedFile $document,
        ?Carbon $validFrom = null,
        ?Carbon $validUntil = null,
        ?string $notes = null
    ): PatientIsee {
        $validFrom = $validFrom ?? Carbon::now();
        $validUntil = $validUntil ?? $validFrom->copy()->addDays(config('isee.validita_giorni', 365));
        
        $isee = new PatientIsee([
            'patient_id' => $patientId,
            'value' => $value,
            'certificate_number' => $certificateNumber,
            'valid_from' => $validFrom,
            'valid_until' => $validUntil,
            'verification_status' => IseeVerificationStatus::PENDING,
            'notes' => $notes,
        ]);
        
        $isee->save();
        
        // Upload documento
        // ...
        
        return $isee;
    }
    
    /**
     * Verifica un certificato ISEE
     */
    public function verifyIsee(
        PatientIsee $isee, 
        IseeVerificationStatus $status,
        ?string $notes = null
    ): PatientIsee {
        $isee->verification_status = $status;
        
        if ($notes) {
            $isee->notes = $notes;
        }
        
        $isee->save();
        
        return $isee;
    }
    
    /**
     * Controlla i certificati ISEE in scadenza
     */
    public function checkExpiringIsee(): array
    {
        $expirationThreshold = Carbon::now()->addDays(config('isee.notifica_scadenza_giorni', 30));
        
        return PatientIsee::query()
            ->where('valid_until', '<=', $expirationThreshold)
            ->where('valid_until', '>', Carbon::now())
            ->where('verification_status', IseeVerificationStatus::VERIFIED)
            ->with('patient')
            ->get()
            ->toArray();
    }
}
```

## Filament Components

```php
namespace Modules\Patient\Filament\Resources\PatientResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Patient\Models\PatientIsee;
use Modules\Patient\Enums\IseeVerificationStatus;

class IseeRelationManager extends RelationManager
{
    protected static string $relationship = 'isee';
    protected static ?string $recordTitleAttribute = 'certificate_number';
    
    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('value')
                    ->label('Valore ISEE')
                    ->required()
                    ->numeric()
                    ->prefix('€'),
                    
                Forms\Components\TextInput::make('certificate_number')
                    ->label('Numero Certificato')
                    ->required(),
                    
                Forms\Components\DatePicker::make('valid_from')
                    ->label('Valido dal')
                    ->required(),
                    
                Forms\Components\DatePicker::make('valid_until')
                    ->label('Valido fino al')
                    ->required()
                    ->after('valid_from'),
                    
                Forms\Components\FileUpload::make('document')
                    ->label('Documento ISEE')
                    ->disk('public')
                    ->directory('isee')
                    ->acceptedFileTypes(['application/pdf']),
                    
                Forms\Components\Select::make('verification_status')
                    ->label('Stato Verifica')
                    ->options(IseeVerificationStatus::class)
                    ->required(),
                    
                Forms\Components\Textarea::make('notes')
                    ->label('Note')
                    ->rows(3),
            ]);
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('value')
                    ->label('Valore ISEE')
                    ->money('EUR')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('valid_from')
                    ->label('Valido dal')
                    ->date()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('valid_until')
                    ->label('Valido fino al')
                    ->date()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('discount_percentage')
                    ->label('Sconto')
                    ->suffix('%')
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('is_valid')
                    ->label('Validità')
                    ->boolean(),
                    
                Tables\Columns\TextColumn::make('verification_status')
                    ->label('Stato Verifica')
                    ->badge()
                    ->color(fn (IseeVerificationStatus $state): string => match ($state) {
                        IseeVerificationStatus::VERIFIED => 'success',
                        IseeVerificationStatus::PENDING => 'warning',
                        IseeVerificationStatus::REJECTED => 'danger',
                    }),
            ])
            ->filters([
                // ...
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('verify')
                    ->label('Verifica')
                    ->icon('heroicon-o-check-circle')
                    ->action(function (PatientIsee $record) {
                        app(IseeService::class)->verifyIsee(
                            $record, 
                            IseeVerificationStatus::VERIFIED
                        );
                    })
                    ->requiresConfirmation()
                    ->visible(fn (PatientIsee $record): bool => 
                        $record->verification_status === IseeVerificationStatus::PENDING
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
```

## API

### IseeController
```php
namespace Modules\Patient\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Xot\Http\Controllers\BaseController;
use Modules\Patient\Models\Patient;
use Modules\Patient\Models\PatientIsee;
use Modules\Patient\Services\IseeService;
use Modules\Patient\Http\Requests\StoreIseeRequest;
use Modules\Patient\Http\Resources\IseeResource;

class IseeController extends BaseController
{
    /**
     * Calcola lo sconto in base all'ISEE
     */
    public function calculateDiscount(Request $request)
    {
        $value = $request->input('isee_value');
        $price = $request->input('price');
        
        $service = app(IseeService::class);
        $discountPercentage = $service->calculateDiscountPercentage($value);
        $discountedPrice = $service->calculateDiscountedPrice($price, $value);
        
        return response()->json([
            'data' => [
                'original_price' => $price,
                'isee_value' => $value,
                'discount_percentage' => $discountPercentage,
                'discount_amount' => $price - $discountedPrice,
                'final_price' => $discountedPrice,
            ]
        ]);
    }
    
    /**
     * Restituisce lo storico ISEE di un paziente
     */
    public function index(Patient $patient)
    {
        $iseeRecords = $patient->isee()
            ->orderByDesc('valid_from')
            ->paginate();
            
        return IseeResource::collection($iseeRecords);
    }
    
    /**
     * Registra un nuovo ISEE
     */
    public function store(StoreIseeRequest $request, Patient $patient)
    {
        $service = app(IseeService::class);
        
        $isee = $service->registerIsee(
            patientId: $patient->id,
            value: $request->input('value'),
            certificateNumber: $request->input('certificate_number'),
            document: $request->file('document'),
            validFrom: $request->input('valid_from') ? now()->parse($request->input('valid_from')) : null,
            validUntil: $request->input('valid_until') ? now()->parse($request->input('valid_until')) : null,
            notes: $request->input('notes')
        );
        
        return new IseeResource($isee);
    }
}
```

## Comandi CLI

```php
namespace Modules\Patient\Console\Commands;

use Illuminate\Console\Command;
use Modules\Patient\Services\IseeService;
use Modules\Patient\Notifications\IseeExpiringNotification;

class NotifyExpiringIsee extends Command
{
    protected $signature = 'isee:notify-expiring';
    protected $description = 'Invia notifiche per ISEE in scadenza';
    
    public function handle()
    {
        $service = app(IseeService::class);
        $expiringRecords = $service->checkExpiringIsee();
        
        $this->info("Trovati {count($expiringRecords)} certificati ISEE in scadenza.");
        
        foreach ($expiringRecords as $record) {
            $patient = $record['patient'];
            
            // Invia notifica
            $patient->notify(new IseeExpiringNotification($record));
            
            $this->info("Notifica inviata a {$patient['full_name']} per ISEE in scadenza il {$record['valid_until']}");
        }
        
        return Command::SUCCESS;
    }
}
``` 
## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](laravel/Modules/Chart/docs/README.md)
* [README.md](laravel/Modules/Reporting/docs/README.md)
* [README.md](laravel/Modules/Gdpr/docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/docs/README.md)
* [README.md](laravel/Modules/Notify/docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/filament/README.md)
* [README.md](laravel/Modules/Xot/docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/standards/README.md)
* [README.md](laravel/Modules/Xot/docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/docs/development/README.md)
* [README.md](laravel/Modules/Dental/docs/README.md)
* [README.md](laravel/Modules/User/docs/phpstan/README.md)
* [README.md](laravel/Modules/User/docs/README.md)
* [README.md](laravel/Modules/User/resources/views/docs/README.md)
* [README.md](laravel/Modules/UI/docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/docs/README.md)
* [README.md](laravel/Modules/UI/docs/standards/README.md)
* [README.md](laravel/Modules/UI/docs/themes/README.md)
* [README.md](laravel/Modules/UI/docs/components/README.md)
* [README.md](laravel/Modules/Lang/docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/docs/README.md)
* [README.md](laravel/Modules/Job/docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/docs/README.md)
* [README.md](laravel/Modules/Media/docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/docs/README.md)
* [README.md](laravel/Modules/Tenant/docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/docs/README.md)
* [README.md](laravel/Modules/Activity/docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/standards/README.md)
* [README.md](laravel/Modules/Patient/docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/docs/README.md)
* [README.md](laravel/Modules/Cms/docs/standards/README.md)
* [README.md](laravel/Modules/Cms/docs/content/README.md)
* [README.md](laravel/Modules/Cms/docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/docs/components/README.md)
* [README.md](laravel/Themes/Two/docs/README.md)
* [README.md](laravel/Themes/One/docs/README.md)

