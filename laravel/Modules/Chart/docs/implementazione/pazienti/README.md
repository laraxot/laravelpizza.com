# Modulo Pazienti il progetto

## Panoramica
Il modulo Pazienti gestisce le anagrafiche dei pazienti, i documenti ISEE e la storia clinica.

## Configurazione

### Installazione
```bash

# Creazione del modulo
php artisan module:make Patient

# Pubblicazione configurazione
php artisan vendor:publish --tag=patient-config
```

### Dipendenze
- module_xot_fila3
- module_tenant_fila3
- module_user_fila3
- module_media_fila3

## Modello Dati

### Tabelle
- `patients` - Dati anagrafici pazienti
- `patient_documents` - Documenti allegati
- `patient_isee` - Storico ISEE
- `patient_medical_records` - Storia clinica
- `patient_notes` - Note e appunti

### Modello Patient
```php
namespace Modules\Patient\Models;

use Modules\Xot\Models\BaseModel;
use Modules\Tenant\Traits\BelongsToTenant;
use Modules\Media\Traits\HasMedia;

class Patient extends BaseModel
{
    use BelongsToTenant;
    use HasMedia;
    
    protected $fillable = [
        'first_name',
        'last_name',
        'fiscal_code',
        'email',
        'phone',
        'birth_date',
        'birth_place',
        'address',
        'city',
        'postal_code',
        'region',
        'gender',
        'notes',
        'status',
    ];
    
    protected $casts = [
        'birth_date' => 'date',
        'status' => PatientStatus::class,
    ];
    
    // Relazioni
    public function isee()
    {
        return $this->hasMany(PatientIsee::class);
    }
    
    public function documents()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
    
    public function medicalRecords()
    {
        return $this->hasMany(PatientMedicalRecord::class);
    }
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    
    // Metodi
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    
    public function getCurrentIseeAttribute()
    {
        return $this->isee()
            ->where('valid_until', '>=', now())
            ->orderByDesc('valid_until')
            ->first();
    }
    
    public function getIseeValueAttribute()
    {
        return $this->currentIsee?->value ?? null;
    }
}
```

### Enum PatientStatus
```php
namespace Modules\Patient\Enums;

enum PatientStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case ARCHIVED = 'archived';
    
    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Attivo',
            self::INACTIVE => 'Inattivo',
            self::ARCHIVED => 'Archiviato',
        };
    }
    
    public function color(): string
    {
        return match($this) {
            self::ACTIVE => 'success',
            self::INACTIVE => 'warning',
            self::ARCHIVED => 'danger',
        };
    }
}
```

## API

### Endpoints
| Metodo | URI                               | Azione                              |
|--------|-----------------------------------|-------------------------------------|
| GET    | `/api/patients`                   | Lista pazienti                      |
| GET    | `/api/patients/{patient}`         | Dettaglio paziente                  |
| POST   | `/api/patients`                   | Creazione paziente                  |
| PUT    | `/api/patients/{patient}`         | Aggiornamento paziente              |
| DELETE | `/api/patients/{patient}`         | Eliminazione paziente               |
| GET    | `/api/patients/{patient}/isee`    | Storia ISEE paziente                |
| POST   | `/api/patients/{patient}/isee`    | Aggiunta ISEE                       |
| GET    | `/api/patients/{patient}/documents`| Documenti paziente                 |
| POST   | `/api/patients/{patient}/documents`| Upload documento                   |

### Esempio Risposta
```json
{
  "data": {
    "id": 1,
    "tenant_id": 1,
    "first_name": "Mario",
    "last_name": "Rossi",
    "fiscal_code": "RSSMRA80A01H501U",
    "email": "mario.rossi@example.com",
    "phone": "3471234567",
    "birth_date": "1980-01-01",
    "birth_place": "Roma",
    "address": "Via Roma 1",
    "city": "Roma",
    "postal_code": "00100",
    "region": "Lazio",
    "gender": "M",
    "status": "active",
    "created_at": "2024-03-01T10:00:00.000000Z",
    "updated_at": "2024-03-01T10:00:00.000000Z",
    "full_name": "Mario Rossi",
    "current_isee": {
      "id": 1,
      "value": 15000.00,
      "valid_from": "2024-01-01",
      "valid_until": "2024-12-31",
      "certificate_number": "ISEE2024-12345",
      "document_id": 1
    }
  }
}
```

## Filament Resources

### PatientResource
```php
namespace Modules\Patient\Filament\Resources;

use Filament\Resources\Resource;
use Modules\Patient\Models\Patient;
use Modules\Patient\Filament\Resources\PatientResource\Pages;
use Modules\Patient\Enums\PatientStatus;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $recordTitleAttribute = 'full_name';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dati Anagrafici')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->label('Nome')
                            ->required(),
                        Forms\Components\TextInput::make('last_name')
                            ->label('Cognome')
                            ->required(),
                        Forms\Components\TextInput::make('fiscal_code')
                            ->label('Codice Fiscale')
                            ->required(),
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('Data di Nascita')
                            ->required(),
                        Forms\Components\TextInput::make('birth_place')
                            ->label('Luogo di Nascita')
                            ->required(),
                        Forms\Components\Select::make('gender')
                            ->label('Genere')
                            ->options([
                                'M' => 'Maschile',
                                'F' => 'Femminile',
                                'O' => 'Altro',
                            ])
                            ->required(),
                    ])->columns(2),
                
                Forms\Components\Section::make('Contatti')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email(),
                        Forms\Components\TextInput::make('phone')
                            ->label('Telefono'),
                        Forms\Components\TextInput::make('address')
                            ->label('Indirizzo'),
                        Forms\Components\TextInput::make('city')
                            ->label('Città'),
                        Forms\Components\TextInput::make('postal_code')
                            ->label('CAP'),
                        Forms\Components\TextInput::make('region')
                            ->label('Regione'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Stato')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Stato')
                            ->options(PatientStatus::class)
                            ->enum(PatientStatus::class)
                            ->required(),
                        Forms\Components\Textarea::make('notes')
                            ->label('Note')
                            ->rows(3),
                    ]),
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Nome Completo')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('fiscal_code')
                    ->label('Codice Fiscale')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Data di Nascita')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefono')
                    ->searchable(),
                Tables\Columns\TextColumn::make('current_isee.value')
                    ->label('ISEE Attuale')
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Stato')
                    ->icon(fn (PatientStatus $state): string => match ($state) {
                        PatientStatus::ACTIVE => 'heroicon-o-check-circle',
                        PatientStatus::INACTIVE => 'heroicon-o-clock',
                        PatientStatus::ARCHIVED => 'heroicon-o-archive-box',
                    })
                    ->color(fn (PatientStatus $state): string => $state->color()),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Stato')
                    ->options(PatientStatus::class),
                Tables\Filters\Filter::make('birth_date')
                    ->form([
                        Forms\Components\DatePicker::make('birth_date_from')
                            ->label('Nato dal'),
                        Forms\Components\DatePicker::make('birth_date_until')
                            ->label('Nato fino al'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['birth_date_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('birth_date', '>=', $date),
                            )
                            ->when(
                                $data['birth_date_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('birth_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            PatientResource\RelationManagers\IseeRelationManager::make(),
            PatientResource\RelationManagers\DocumentsRelationManager::make(),
            PatientResource\RelationManagers\MedicalRecordsRelationManager::make(),
            PatientResource\RelationManagers\AppointmentsRelationManager::make(),
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'view' => Pages\ViewPatient::route('/{record}'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
```

## Validazione ISEE

### Regole di Validazione
- Il valore ISEE deve essere numerico e positivo
- La data di validità deve essere futura
- Il certificato ISEE deve essere un documento PDF
- Il numero di certificato deve essere unico

### Process ISEE
```php
namespace Modules\Patient\Actions;

use Modules\Patient\Models\Patient;
use Modules\Patient\Models\PatientIsee;
use Modules\Patient\DTOs\IseeData;
use Modules\Media\Models\Media;

class ProcessIseeDocument
{
    public function handle(Patient $patient, IseeData $data): PatientIsee
    {
        // Validazione ISEE già effettuata dal form request
        
        // Salvare documento ISEE
        $media = null;
        if ($data->document) {
            $media = $patient->addMedia($data->document)
                ->toMediaCollection('isee_documents');
        }
        
        // Creare record ISEE
        $isee = new PatientIsee([
            'value' => $data->value,
            'valid_from' => $data->validFrom,
            'valid_until' => $data->validUntil,
            'certificate_number' => $data->certificateNumber,
            'notes' => $data->notes,
        ]);
        
        if ($media) {
            $isee->document_id = $media->id;
        }
        
        $patient->isee()->save($isee);
        
        return $isee;
    }
}
```

## Notifiche

### Configurazione Eventi
```php
namespace Modules\Patient\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Patient\Events\PatientCreated;
use Modules\Patient\Events\PatientUpdated;
use Modules\Patient\Events\IseeCreated;
use Modules\Patient\Events\IseeExpiring;
use Modules\Patient\Listeners\SendPatientWelcomeNotification;
use Modules\Patient\Listeners\SendPatientUpdatedNotification;
use Modules\Patient\Listeners\SendIseeConfirmationNotification;
use Modules\Patient\Listeners\SendIseeExpirationReminder;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PatientCreated::class => [
            SendPatientWelcomeNotification::class,
        ],
        PatientUpdated::class => [
            SendPatientUpdatedNotification::class,
        ],
        IseeCreated::class => [
            SendIseeConfirmationNotification::class,
        ],
        IseeExpiring::class => [
            SendIseeExpirationReminder::class,
        ],
    ];
}
```

### Esempio Notifica ISEE in Scadenza
```php
namespace Modules\Patient\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Patient\Models\PatientIsee;

class IseeExpiringNotification extends Notification
{
    protected PatientIsee $isee;
    
    public function __construct(PatientIsee $isee)
    {
        $this->isee = $isee;
    }
    
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }
    
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Certificato ISEE in scadenza')
            ->greeting("Gentile {$notifiable->full_name},")
            ->line("Il suo certificato ISEE scadrà il {$this->isee->valid_until->format('d/m/Y')}.")
            ->line("Per continuare a usufruire delle agevolazioni, la invitiamo a rinnovare il certificato.")
            ->action('Rinnova ISEE', route('filament.tenant.resources.patients.isee.create', $notifiable))
            ->line('Grazie per aver scelto il progetto.');
    }
    
    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Certificato ISEE in scadenza',
            'body' => "Il certificato ISEE scadrà il {$this->isee->valid_until->format('d/m/Y')}.",
            'action_url' => route('filament.tenant.resources.patients.isee.create', $notifiable),
            'icon' => 'heroicon-o-document',
            'color' => 'warning',
        ];
    }
}
```

## Commands

### Check ISEE Expiration
```php
namespace Modules\Patient\Console\Commands;

use Illuminate\Console\Command;
use Modules\Patient\Models\PatientIsee;
use Modules\Patient\Events\IseeExpiring;
use Carbon\Carbon;

class CheckExpiringIsee extends Command
{
    protected $signature = 'patients:check-isee-expiration';
    protected $description = 'Check for ISEE certificates expiring soon and send notifications';
    
    public function handle()
    {
        $expirationDate = Carbon::now()->addDays(30);
        
        $expiringIsee = PatientIsee::query()
            ->where('valid_until', '<=', $expirationDate)
            ->where('valid_until', '>', Carbon::now())
            ->whereDoesntHave('notifications', function ($query) {
                $query->where('type', 'isee_expiring')
                    ->where('created_at', '>', Carbon::now()->subDays(15));
            })
            ->with('patient')
            ->get();
            
        foreach ($expiringIsee as $isee) {
            event(new IseeExpiring($isee));
            
            $this->info("Notifica inviata per certificato ISEE {$isee->certificate_number} del paziente {$isee->patient->full_name}");
        }
        
        $this->info("Controllo completato. {$expiringIsee->count()} notifiche inviate.");
        
        return Command::SUCCESS;
    }
}
```

## Test

### Unit Tests
```php
namespace Modules\Patient\Tests\Unit;

use Tests\TestCase;
use Modules\Patient\Models\Patient;
use Modules\Patient\Models\PatientIsee;
use Modules\Patient\Actions\ProcessIseeDocument;
use Modules\Patient\DTOs\IseeData;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

class ProcessIseeDocumentTest extends TestCase
{
    public function test_creates_isee_record()
    {
        // Setup
        $patient = Patient::factory()->create();
        $file = UploadedFile::fake()->create('isee.pdf', 100);
        
        $data = new IseeData(
            value: 15000.00,
            validFrom: Carbon::now(),
            validUntil: Carbon::now()->addYear(),
            certificateNumber: 'ISEE2024-12345',
            notes: 'Test ISEE',
            document: $file
        );
        
        // Azione
        $action = new ProcessIseeDocument();
        $isee = $action->handle($patient, $data);
        
        // Verifica
        $this->assertInstanceOf(PatientIsee::class, $isee);
        $this->assertEquals(15000.00, $isee->value);
        $this->assertEquals('ISEE2024-12345', $isee->certificate_number);
        $this->assertNotNull($isee->document_id);
        $this->assertTrue($patient->isee->contains($isee));
    }
}
```

### Feature Tests
```php
namespace Modules\Patient\Tests\Feature;

use Tests\TestCase;
use Modules\Patient\Models\Patient;
use Modules\Tenant\Models\Tenant;
use Modules\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PatientApiTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_authenticated_user_can_fetch_patients()
    {
        // Setup
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);
        $patients = Patient::factory()->count(3)->create(['tenant_id' => $tenant->id]);
        
        // Azione
        $response = $this->actingAs($user)
            ->getJson('/api/patients');
            
        // Verifica
        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'first_name',
                        'last_name',
                        'full_name',
                        'fiscal_code',
                        'email',
                        'phone',
                        'status',
                    ]
                ]
            ]);
    }
    
    public function test_tenant_isolation_works()
    {
        // Setup
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();
        
        $user1 = User::factory()->create(['tenant_id' => $tenant1->id]);
        $user2 = User::factory()->create(['tenant_id' => $tenant2->id]);
        
        $patientsT1 = Patient::factory()->count(3)->create(['tenant_id' => $tenant1->id]);
        $patientsT2 = Patient::factory()->count(2)->create(['tenant_id' => $tenant2->id]);
        
        // Azione e Verifica - Tenant 1
        $this->actingAs($user1)
            ->getJson('/api/patients')
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
            
        // Azione e Verifica - Tenant 2
        $this->actingAs($user2)
            ->getJson('/api/patients')
            ->assertStatus(200)
            ->assertJsonCount(2, 'data');
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

