# 06. Gestione Dati Sensibili

## Obiettivi
- Implementazione di sistemi sicuri per la gestione dei dati clinici e sensibili
- Implementazione di meccanismi di crittografia per dati personali e sanitari
- Sviluppo di un sistema di pseudonimizzazione per reportistica anonima

## 1. Crittografia dei Dati Sensibili

### 1.1 Setup della Crittografia a Livello di Campo
1. Creare trait per la gestione dei campi crittografati:
   ```php
   namespace Modules\Xot\Traits;

   trait HasEncryptedAttributes
   {
       protected function getEncryptedAttributes(): array
       {
           return $this->encryptedAttributes ?? [];
       }
       
       public function setAttribute($key, $value)
       {
           if (in_array($key, $this->getEncryptedAttributes()) && !is_null($value)) {
               $value = encrypt($value);
           }
           
           return parent::setAttribute($key, $value);
       }
       
       public function getAttribute($key)
       {
           $value = parent::getAttribute($key);
           
           if (in_array($key, $this->getEncryptedAttributes()) && !is_null($value)) {
               return decrypt($value);
           }
           
           return $value;
       }
   }
   ```

2. Implementare nei modelli Patient e Clinical:
   ```php
   namespace Modules\Patient\Models;

   use Modules\Xot\Traits\HasEncryptedAttributes;
   use Modules\Xot\Models\XotBaseModel;

   class Patient extends XotBaseModel
   {
       use HasEncryptedAttributes;
       
       protected $encryptedAttributes = [
           'fiscal_code',
           'phone_number',
           'email',
           // altri dati sensibili
       ];
       
       // resto del modello
   }
   ```

### 1.2 Crittografia dei Dati Stored
1. Configurare l'handler per il filesystem crittografato per gli allegati:
   ```php
   // config/filesystems.php
   'encrypted' => [
       'driver' => 'encrypted',
       'root' => storage_path('app/encrypted'),
       'url' => env('APP_URL').'/storage/encrypted',
       'visibility' => 'private',
       'throw' => false,
       'master_key' => env('FILESYSTEM_ENCRYPTION_KEY'),
   ],
   ```

2. Implementare il driver personalizzato:
   ```bash
   php artisan make:provider EncryptedFilesystemServiceProvider
   ```

3. Registrare il driver nel service provider:
   ```php
   public function boot()
   {
       Storage::extend('encrypted', function ($app, $config) {
           $adapter = new EncryptedAdapter(
               new LocalAdapter($config['root']),
               $config['master_key']
           );

           return new FilesystemAdapter(
               new Filesystem($adapter, $config),
               $adapter,
               $config
           );
       });
   }
   ```

## 2. Pseudonimizzazione per Reportistica

### 2.1 Implementazione del TokenService
1. Creare il TokenService per la pseudonimizzazione:
   ```php
   namespace Modules\GDPR\Services;

   class TokenService
   {
       public function generateToken(string $identifier, string $salt = null): string
       {
           $salt = $salt ?? config('app.key');
           // Utilizzo HMAC per creare token deterministici ma non reversibili
           return hash_hmac('sha256', $identifier, $salt);
       }
       
       public function anonymizeDataSet(array $data, array $fieldsToAnonymize): array
       {
           $result = $data;
           foreach ($fieldsToAnonymize as $field) {
               if (isset($result[$field])) {
                   $result[$field] = $this->generateToken($result[$field]);
               }
           }
           return $result;
       }
   }
   ```

2. Registrare il servizio nel provider:
   ```php
   $this->app->singleton(TokenService::class, function ($app) {
       return new TokenService();
   });
   ```

### 2.2 Creazione Action per Anonimizzazione
1. Implementare l'action per l'anonimizzazione:
   ```php
   namespace Modules\GDPR\Actions;

   use Modules\GDPR\Services\TokenService;
   use Modules\Xot\Actions\XotBaseAction;

   class AnonymizeDataAction extends XotBaseAction
   {
       public function __construct(
           private readonly TokenService $tokenService
       ) {}
       
       public function execute(array $data, array $fieldsToAnonymize): array
       {
           return $this->tokenService->anonymizeDataSet($data, $fieldsToAnonymize);
       }
   }
   ```

### 2.3 Implementazione del Repository con Pseudonimizzazione
1. Creare repository per report anonimizzati:
   ```php
   namespace Modules\Reporting\Repositories;

   use Modules\GDPR\Actions\AnonymizeDataAction;
   use Modules\Patient\Models\Patient;

   class AnonymizedReportRepository
   {
       public function __construct(
           private readonly AnonymizeDataAction $anonymizeDataAction
       ) {}
       
       public function getAnonymizedPatients(): array
       {
           $patients = Patient::all()->toArray();
           
           return array_map(
               fn (array $patient) => $this->anonymizeDataAction->execute(
                   $patient,
                   ['fiscal_code', 'first_name', 'last_name', 'email', 'phone_number']
               ),
               $patients
           );
       }
       
       public function getAnonymizedClinicalData(): array
       {
           // Implementazione per dati clinici anonimizzati
       }
   }
   ```

## 3. Gestione dei Consensi GDPR

### 3.1 Modello per Consensi
1. Creare migration per tabella consensi:
   ```bash
   php artisan module:make-migration create_consents_table GDPR
   ```

2. Implementare la migration:
   ```php
   Schema::create('consents', function (Blueprint $table) {
       $table->uuid('id')->primary();
       $table->uuidMorphs('user');
       $table->string('consent_type');
       $table->text('consent_text');
       $table->boolean('granted')->default(false);
       $table->timestamp('granted_at')->nullable();
       $table->ipAddress('ip_address')->nullable();
       $table->text('user_agent')->nullable();
       $table->timestamps();
       
       $table->unique(['user_type', 'user_id', 'consent_type']);
   });
   ```

3. Creare il modello Consent:
   ```php
   namespace Modules\GDPR\Models;

   use Modules\Xot\Models\XotBaseModel;

   class Consent extends XotBaseModel
   {
       protected $fillable = [
           'user_type',
           'user_id',
           'consent_type',
           'consent_text',
           'granted',
           'granted_at',
           'ip_address',
           'user_agent',
       ];
       
       protected $casts = [
           'granted' => 'boolean',
           'granted_at' => 'datetime',
       ];
       
       public function user()
       {
           return $this->morphTo();
       }
   }
   ```

### 3.2 Trait per Consensi nei Modelli
1. Implementare trait HasConsents:
   ```php
   namespace Modules\GDPR\Traits;

   use Modules\GDPR\Models\Consent;
   use Illuminate\Database\Eloquent\Relations\MorphMany;

   trait HasConsents
   {
       public function consents(): MorphMany
       {
           return $this->morphMany(Consent::class, 'user');
       }
       
       public function giveConsent(string $type, string $text, array $metadata = []): Consent
       {
           return $this->consents()->updateOrCreate(
               ['consent_type' => $type],
               [
                   'consent_text' => $text,
                   'granted' => true,
                   'granted_at' => now(),
                   'ip_address' => $metadata['ip_address'] ?? request()->ip(),
                   'user_agent' => $metadata['user_agent'] ?? request()->userAgent(),
               ]
           );
       }
       
       public function withdrawConsent(string $type): bool
       {
           return (bool) $this->consents()
               ->where('consent_type', $type)
               ->update(['granted' => false]);
       }
       
       public function hasConsent(string $type): bool
       {
           return $this->consents()
               ->where('consent_type', $type)
               ->where('granted', true)
               ->exists();
       }
   }
   ```

### 3.3 Middleware per Verifica Consensi
1. Creare VerifyConsent middleware:
   ```php
   namespace Modules\GDPR\Middleware;

   use Closure;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Auth;

   class VerifyConsent
   {
       public function handle(Request $request, Closure $next, string $consentType)
       {
           $user = Auth::user();
           
           if (! $user || ! method_exists($user, 'hasConsent') || ! $user->hasConsent($consentType)) {
               return redirect()->route('gdpr.consent.request', ['type' => $consentType]);
           }
           
           return $next($request);
       }
   }
   ```

## 4. Logging e Audit Trail

### 4.1 Configurazione Activity Log
1. Installare la dipendenza:
   ```bash
   composer require spatie/laravel-activitylog
   ```

2. Pubblicare la configurazione:
   ```bash
   php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="config"
   ```

3. Eseguire la migration:
   ```bash
   php artisan migrate
   ```

### 4.2 Implementazione nei Modelli Sensibili
1. Aggiungere trait ai modelli:
   ```php
   namespace Modules\Patient\Models;

   use Spatie\Activitylog\LogOptions;
   use Spatie\Activitylog\Traits\LogsActivity;
   use Modules\Xot\Models\XotBaseModel;

   class PatientVisit extends XotBaseModel
   {
       use LogsActivity;
       
       public function getActivitylogOptions(): LogOptions
       {
           return LogOptions::defaults()
               ->logOnly(['status', 'doctor_id', 'diagnosis', 'treatment'])
               ->logOnlyDirty()
               ->dontSubmitEmptyLogs()
               ->setDescriptionForEvent(fn(string $eventName) => "Visita paziente {$eventName}");
       }
   }
   ```

### 4.3 Logging Accessi ai Dati Sensibili
1. Creare middleware per logging accessi:
   ```php
   namespace Modules\GDPR\Middleware;

   use Closure;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Log;
   use Spatie\Activitylog\Facades\CauserResolver;

   class LogSensitiveAccess
   {
       public function handle(Request $request, Closure $next, string $resourceType)
       {
           $response = $next($request);
           
           activity('sensitive_access')
               ->causedBy(CauserResolver::resolve())
               ->withProperties([
                   'resource_type' => $resourceType,
                   'resource_id' => $request->route('id'),
                   'ip' => $request->ip(),
                   'user_agent' => $request->userAgent(),
               ])
               ->log('Accesso a dati sensibili');
           
           return $response;
       }
   }
   ```

2. Registrare il middleware:
   ```php
   // In RouteServiceProvider
   Route::middleware('log.sensitive:patient')->group(function () {
       // Route con dati sensibili
   });
   ```

## 5. Testing

### 5.1 Unit Test
1. Test per crittografia:
   ```php
   namespace Modules\Patient\Tests\Unit;

   use Tests\TestCase;
   use Modules\Patient\Models\Patient;

   class PatientEncryptionTest extends TestCase
   {
       /** @test */
       public function it_encrypts_sensitive_data()
       {
           $patient = Patient::factory()->create([
               'fiscal_code' => 'ABCDEF12G34H567I',
               'phone_number' => '+393334455666',
           ]);
           
           // Verifica che il dato sia crittografato nel database
           $rawData = \DB::table('patients')->where('id', $patient->id)->first();
           $this->assertNotEquals('ABCDEF12G34H567I', $rawData->fiscal_code);
           
           // Verifica che il model fornisca i dati decrittografati
           $this->assertEquals('ABCDEF12G34H567I', $patient->fiscal_code);
       }
   }
   ```

### 5.2 Feature Test
1. Test per consenso GDPR:
   ```php
   namespace Modules\GDPR\Tests\Feature;

   use Tests\TestCase;
   use Modules\User\Models\User;
   use Modules\GDPR\Models\Consent;

   class ConsentManagementTest extends TestCase
   {
       /** @test */
       public function user_can_give_and_withdraw_consent()
       {
           $user = User::factory()->create();
           
           $response = $this->actingAs($user)
               ->post(route('gdpr.consent.give'), [
                   'consent_type' => 'marketing',
                   'consent_text' => 'Acconsento all\'invio di email promozionali',
               ]);
           
           $response->assertStatus(200);
           
           $this->assertTrue($user->hasConsent('marketing'));
           
           $response = $this->actingAs($user)
               ->post(route('gdpr.consent.withdraw'), [
                   'consent_type' => 'marketing',
               ]);
           
           $response->assertStatus(200);
           
           $this->assertFalse($user->hasConsent('marketing'));
       }
   }
   ```

## Note Implementative
- Utilizzare chiavi di crittografia sicure e configurate correttamente in environment
- Documentare tutti i processi di anonymization per audit
- Implementare meccanismi di rotazione chiavi
- Testare approfonditamente tutti i meccanismi di sicurezza
- Documentare compliance GDPR per ciascun componente
