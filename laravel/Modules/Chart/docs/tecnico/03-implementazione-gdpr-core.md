# Implementazione Core GDPR per il progetto

## Introduzione

Il progetto il progetto, trattando dati sanitari di gestanti in condizione di vulnerabilità socio-economica, richiede un'implementazione rigorosa della normativa GDPR. Questo documento illustra l'implementazione tecnica delle componenti core del sistema GDPR utilizzando il modulo Laraxot `Gdpr`.

## Componenti Critiche GDPR

### 1. Registro dei Trattamenti

Il Registro dei Trattamenti è obbligatorio ai sensi dell'Art. 30 del GDPR. Implementiamo questa funzionalità tramite:

```php
<?php

namespace Modules\Gdpr\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Tenant\Models\Tenant;
use Modules\User\Models\User;

class Treatment extends Model
{
    protected $fillable = [
        'tenant_id',
        'name',
        'description',
        'legal_basis',
        'purpose',
        'data_categories',
        'data_subjects',
        'recipients',
        'transfers',
        'retention_period',
        'security_measures',
        'dpo_id',
        'controller_id',
        'processor_id',
        'is_active',
    ];

    protected $casts = [
        'data_categories' => 'array',
        'security_measures' => 'array',
        'recipients' => 'array',
        'transfers' => 'array',
        'is_active' => 'boolean',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function dpo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dpo_id');
    }

    public function controller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'controller_id');
    }

    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processor_id');
    }

    public function consents(): HasMany
    {
        return $this->hasMany(Consent::class);
    }
    
    public function getDataCategoriesFormattedAttribute(): string
    {
        return implode(', ', $this->data_categories ?? []);
    }
}
```

### 2. Gestione Consensi

I consensi rappresentano la base giuridica principale per il trattamento dei dati nel progetto il progetto.

```php
<?php

namespace Modules\Gdpr\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\User\Models\User;

class Consent extends Model
{
    protected $fillable = [
        'user_id',
        'treatment_id',
        'version',
        'text',
        'given_at',
        'withdrawn_at',
        'expiry_at',
        'is_essential',
        'status',
    ];

    protected $casts = [
        'given_at' => 'datetime',
        'withdrawn_at' => 'datetime',
        'expiry_at' => 'datetime',
        'is_essential' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(ConsentLog::class);
    }

    public function isValid(): bool
    {
        return $this->given_at !== null && 
               $this->withdrawn_at === null && 
               ($this->expiry_at === null || $this->expiry_at->isFuture());
    }

    public function withdraw(): void
    {
        $this->update([
            'withdrawn_at' => now(),
            'status' => 'withdrawn'
        ]);

        $this->logs()->create([
            'action' => 'withdrawn',
            'timestamp' => now(),
            'metadata' => json_encode(['ip' => request()->ip()]),
        ]);
    }
}
```

### 3. Logging Attività GDPR

Ogni operazione sui dati personali deve essere tracciata per accountability:

```php
<?php

namespace Modules\Gdpr\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Models\User;

class ConsentLog extends Model
{
    protected $fillable = [
        'consent_id',
        'user_id',
        'action',
        'timestamp',
        'metadata',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'metadata' => 'array',
    ];

    public function consent(): BelongsTo
    {
        return $this->belongsTo(Consent::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

## Configurazione Trattamenti per il progetto

La configurazione dei trattamenti deve essere specifica per il progetto il progetto, considerando i flussi di dati identificati:

```php
<?php
// config/gdpr/treatments.php

return [
    'patient_registration' => [
        'name' => 'Registrazione Paziente',
        'description' => 'Raccolta dati personali e sanitari delle gestanti per verifica idoneità al progetto',
        'legal_basis' => 'consent',
        'purpose' => 'Determinare l\'idoneità della gestante a partecipare al progetto il progetto in base ai criteri stabiliti',
        'data_categories' => [
            'dati_identificativi',
            'dati_contatto',
            'dati_sanitari',
            'dati_socio_economici',
        ],
        'data_subjects' => ['gestanti'],
        'recipients' => ['personale_autorizzato', 'odontoiatri'],
        'transfers' => [],
        'retention_period' => '10 years',
        'security_measures' => [
            'encryption',
            'access_control',
            'pseudonymization',
            'logging',
        ],
        'is_essential' => true,
    ],
    'dental_care' => [
        'name' => 'Cure Odontoiatriche',
        'description' => 'Raccolta dati sanitari per la fornitura di cure odontoiatriche alle gestanti',
        'legal_basis' => 'consent',
        'purpose' => 'Fornire assistenza odontoiatrica alle gestanti nell\'ambito del progetto il progetto',
        'data_categories' => [
            'dati_sanitari_odontoiatrici',
            'immagini_diagnostiche',
            'anamnesi_medica',
        ],
        'data_subjects' => ['gestanti'],
        'recipients' => ['odontoiatri', 'personale_medico'],
        'transfers' => [],
        'retention_period' => '10 years',
        'security_measures' => [
            'encryption',
            'access_control',
            'pseudonymization',
            'logging',
        ],
        'is_essential' => true,
    ],
    'reimbursement' => [
        'name' => 'Gestione Rimborsi',
        'description' => 'Gestione dati finanziari per il rimborso delle cure odontoiatriche',
        'legal_basis' => 'contract',
        'purpose' => 'Elaborare i rimborsi per le prestazioni odontoiatriche fornite nel contesto del progetto',
        'data_categories' => [
            'dati_finanziari',
            'dati_fiscali',
            'prestazioni_erogate',
        ],
        'data_subjects' => ['odontoiatri'],
        'recipients' => ['personale_amministrativo', 'enti_finanziatori'],
        'transfers' => [],
        'retention_period' => '10 years',
        'security_measures' => [
            'encryption',
            'access_control',
            'logging',
        ],
        'is_essential' => true,
    ],
];
```

## Implementazione del Service Provider GDPR

```php
<?php

namespace Modules\Gdpr\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Gdpr\Services\ConsentManager;
use Modules\Gdpr\Services\DataPortabilityService;
use Modules\Gdpr\Services\RightToForgetService;

class GdprServiceProvider extends ServiceProvider
{
    protected $moduleName = 'Gdpr';
    protected $moduleNameLower = 'gdpr';

    public function boot(): void
    {
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        
        // Registrazione middleware GDPR
        $this->app['router']->aliasMiddleware('gdpr.consent.verify', \Modules\Gdpr\Http\Middleware\VerifyUserConsent::class);
        
        // Event listeners
        $this->app['events']->listen(
            \Modules\User\Events\UserCreated::class,
            \Modules\Gdpr\Listeners\RequestEssentialConsents::class
        );
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        
        // Registrazione servizi GDPR
        $this->app->singleton('gdpr.consent.manager', function ($app) {
            return new ConsentManager();
        });
        
        $this->app->singleton('gdpr.data.portability', function ($app) {
            return new DataPortabilityService();
        });
        
        $this->app->singleton('gdpr.right.forget', function ($app) {
            return new RightToForgetService();
        });
    }

    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower.'.php'),
            module_path($this->moduleName, 'Config/treatments.php') => config_path($this->moduleNameLower.'/treatments.php'),
        ], 'config');
        
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    protected function registerViews(): void
    {
        $viewPath = resource_path('views/modules/'.$this->moduleNameLower);
        
        $sourcePath = module_path($this->moduleName, 'Resources/views');
        
        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower.'-module-views']);
        
        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }
    
    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
```

## Middleware per Verifica Consensi

```php
<?php

namespace Modules\Gdpr\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Gdpr\Services\ConsentManager;

class VerifyUserConsent
{
    protected $consentManager;
    
    public function __construct(ConsentManager $consentManager)
    {
        $this->consentManager = $consentManager;
    }
    
    public function handle(Request $request, Closure $next, string $treatmentKey)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        if (!$this->consentManager->hasValidConsent($user, $treatmentKey)) {
            // Salva URL originale per redirect dopo consenso
            session()->put('url.intended', $request->url());
            
            // Redirect alla pagina di consenso
            return redirect()->route('gdpr.consent.request', ['treatment' => $treatmentKey])
                ->with('warning', 'È necessario il tuo consenso per accedere a questa funzione.');
        }
        
        return $next($request);
    }
}
```

## Implementazione Diritti GDPR

### Diritto di Accesso

```php
<?php

namespace Modules\Gdpr\Services;

use Modules\User\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class DataPortabilityService
{
    public function generateExport(User $user): string
    {
        // Preparazione dati
        $userData = $this->collectUserData($user);
        
        // Creazione file JSON
        $jsonFilename = 'user_data_' . $user->id . '_' . now()->format('Ymd_His') . '.json';
        $jsonPath = 'exports/' . $jsonFilename;
        
        Storage::put($jsonPath, json_encode($userData, JSON_PRETTY_PRINT));
        
        // Log operazione
        activity()
            ->causedBy($user)
            ->withProperties(['export' => true])
            ->log('User exported personal data');
        
        // Creazione ZIP se ci sono documenti
        if (!empty($userData['documents'])) {
            $zipFilename = 'user_export_' . $user->id . '_' . now()->format('Ymd_His') . '.zip';
            $zipPath = storage_path('app/exports/' . $zipFilename);
            
            $zip = new ZipArchive();
            if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                // Aggiungi il file JSON
                $zip->addFile(storage_path('app/' . $jsonPath), $jsonFilename);
                
                // Aggiungi documenti
                foreach ($userData['documents'] as $document) {
                    if (isset($document['path']) && Storage::exists($document['path'])) {
                        $zip->addFile(
                            storage_path('app/' . $document['path']), 
                            'documents/' . basename($document['path'])
                        );
                    }
                }
                
                $zip->close();
                
                // Rimuovi il file JSON temporaneo
                Storage::delete($jsonPath);
                
                return 'exports/' . $zipFilename;
            }
        }
        
        return $jsonPath;
    }
    
    private function collectUserData(User $user): array
    {
        // Dati utente
        $userData = $user->toArray();
        unset($userData['password']);
        
        // Raccolta dati per il progetto
        $result = [
            'user' => $userData,
            'export_date' => now()->toIso8601String(),
        ];
        
        // Dati paziente se presente
        if ($user->patient) {
            $result['patient'] = $user->patient->toArray();
        }
        
        // Appuntamenti
        if ($user->patient && $user->patient->appointments) {
            $result['appointments'] = $user->patient->appointments()->with(['dentist' => function ($query) {
                $query->select('id', 'name', 'surname', 'clinic_name');
            }])->get()->toArray();
        }
        
        // Consensi
        $result['consents'] = $user->consents()->with('treatment')->get()->toArray();
        
        // Documenti
        if ($user->patient && $user->patient->documents) {
            $result['documents'] = $user->patient->documents()->get()->toArray();
        }
        
        return $result;
    }
}
```

### Diritto di Cancellazione (Oblio)

```php
<?php

namespace Modules\Gdpr\Services;

use Modules\User\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RightToForgetService
{
    public function anonymizeUser(User $user): bool
    {
        try {
            DB::beginTransaction();
            
            // 1. Registra la richiesta
            activity()
                ->causedBy($user)
                ->withProperties(['right' => 'forget'])
                ->log('User requested right to be forgotten');
            
            // 2. Anonimizza dati paziente
            if ($user->patient) {
                $user->patient->update([
                    'name' => 'Anonimizzato',
                    'surname' => 'Anonimizzato',
                    'fiscal_code' => Str::random(16),
                    'birth_place' => 'Anonimizzato',
                    'address' => 'Anonimizzato',
                    'city' => 'Anonimizzato',
                    'postal_code' => 'Anonimizzato',
                    'province' => 'Anonimizzato',
                    'phone' => 'Anonimizzato',
                    'health_card_number' => 'Anonimizzato',
                ]);
            }
            
            // 3. Mantieni appuntamenti e referti per obblighi legali,
            //    ma rimuovi collegamenti diretti a dati identificativi
            
            // 4. Anonimizza utente
            $user->update([
                'email' => 'anon_' . Str::uuid() . '@anonymized.local',
                'name' => 'Anonimizzato',
                'surname' => 'Anonimizzato',
                'phone' => 'Anonimizzato',
                // Disattiva account
                'is_active' => false,
            ]);
            
            // 5. Ritira tutti i consensi
            foreach ($user->consents as $consent) {
                $consent->withdraw();
            }
            
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to anonymize user', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
```

## Implementazione del Form di Consenso

```php
<?php

namespace Modules\Gdpr\Http\Livewire;

use Livewire\Component;
use Modules\Gdpr\Services\ConsentManager;

class ConsentForm extends Component
{
    public $treatment;
    public $treatmentConfig;
    public $consentGiven = false;
    public $redirectUrl;
    
    public function mount($treatmentKey)
    {
        $this->treatmentKey = $treatmentKey;
        $this->treatmentConfig = config('gdpr.treatments.' . $treatmentKey);
        $this->redirectUrl = session('url.intended', route('home'));
        
        if (auth()->check()) {
            $consentManager = app(ConsentManager::class);
            $this->consentGiven = $consentManager->hasValidConsent(auth()->user(), $treatmentKey);
        }
    }
    
    public function giveConsent()
    {
        $this->validate([
            'consentGiven' => 'accepted',
        ], [
            'consentGiven.accepted' => 'È necessario fornire il consenso per continuare',
        ]);
        
        $consentManager = app(ConsentManager::class);
        $consentManager->giveConsent(auth()->user(), $this->treatmentKey);
        
        return redirect($this->redirectUrl)
            ->with('success', 'Grazie per aver fornito il tuo consenso.');
    }
    
    public function render()
    {
        return view('gdpr::livewire.consent-form');
    }
}
```

## Schema Database GDPR

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGdprTables extends Migration
{
    public function up()
    {
        // Trattamenti (Art. 30 GDPR)
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('legal_basis');
            $table->string('purpose');
            $table->json('data_categories')->nullable();
            $table->json('data_subjects')->nullable();
            $table->json('recipients')->nullable();
            $table->json('transfers')->nullable();
            $table->string('retention_period')->nullable();
            $table->json('security_measures')->nullable();
            $table->foreignId('dpo_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('controller_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('processor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Consensi (Art. 7 GDPR)
        Schema::create('consents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('treatment_id')->constrained()->onDelete('cascade');
            $table->string('version');
            $table->text('text')->nullable();
            $table->timestamp('given_at')->nullable();
            $table->timestamp('withdrawn_at')->nullable();
            $table->timestamp('expiry_at')->nullable();
            $table->boolean('is_essential')->default(false);
            $table->string('status')->default('pending');
            $table->timestamps();
            
            $table->unique(['user_id', 'treatment_id', 'version']);
        });
        
        // Log consensi (Accountability Art. 5(2) GDPR)
        Schema::create('consent_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consent_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action');
            $table->timestamp('timestamp');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
        
        // Richieste diritti GDPR
        Schema::create('gdpr_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // access, rectification, erasure, restriction, portability, objection
            $table->string('status')->default('pending');
            $table->text('request_details')->nullable();
            $table->text('response_details')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('handled_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gdpr_requests');
        Schema::dropIfExists('consent_logs');
        Schema::dropIfExists('consents');
        Schema::dropIfExists('treatments');
    }
}
```

## Testing del Modulo GDPR

```php
<?php

namespace Modules\Gdpr\Tests\Unit;

use Tests\TestCase;
use Modules\User\Models\User;
use Modules\Gdpr\Models\Treatment;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Services\ConsentManager;

class ConsentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        
        // Crea trattamento di test
        $this->treatment = Treatment::factory()->create([
            'name' => 'Test Treatment',
            'legal_basis' => 'consent',
        ]);
        
        // Crea utente di test
        $this->user = User::factory()->create();
    }
    
    /** @test */
    public function it_can_give_consent()
    {
        $consentManager = app(ConsentManager::class);
        
        $result = $consentManager->giveConsent($this->user, $this->treatment->id);
        
        $this->assertTrue($result);
        $this->assertDatabaseHas('consents', [
            'user_id' => $this->user->id,
            'treatment_id' => $this->treatment->id,
            'status' => 'active',
        ]);
        
        // Verifica log
        $this->assertDatabaseHas('consent_logs', [
            'consent_id' => Consent::where('user_id', $this->user->id)
                ->where('treatment_id', $this->treatment->id)
                ->first()->id,
            'action' => 'given',
        ]);
    }
    
    /** @test */
    public function it_can_withdraw_consent()
    {
        // Prima crea un consenso
        $consent = Consent::factory()->create([
            'user_id' => $this->user->id,
            'treatment_id' => $this->treatment->id,
            'given_at' => now(),
            'status' => 'active',
        ]);
        
        $consent->withdraw();
        
        $this->assertNotNull($consent->fresh()->withdrawn_at);
        $this->assertEquals('withdrawn', $consent->fresh()->status);
        
        // Verifica log
        $this->assertDatabaseHas('consent_logs', [
            'consent_id' => $consent->id,
            'action' => 'withdrawn',
        ]);
    }
    
    /** @test */
    public function it_checks_if_consent_is_valid()
    {
        $consentManager = app(ConsentManager::class);
        
        // Senza consenso
        $this->assertFalse($consentManager->hasValidConsent($this->user, $this->treatment->id));
        
        // Con consenso
        Consent::factory()->create([
            'user_id' => $this->user->id,
            'treatment_id' => $this->treatment->id,
            'given_at' => now(),
            'status' => 'active',
        ]);
        
        $this->assertTrue($consentManager->hasValidConsent($this->user, $this->treatment->id));
        
        // Con consenso ritirato
        Consent::where('user_id', $this->user->id)
            ->where('treatment_id', $this->treatment->id)
            ->update([
                'withdrawn_at' => now(),
                'status' => 'withdrawn',
            ]);
        
        $this->assertFalse($consentManager->hasValidConsent($this->user, $this->treatment->id));
    }
}
```

## Conclusione

L'implementazione core GDPR per il progetto costituisce la base fondamentale per garantire la conformità normativa del progetto. In quanto struttura che tratta dati sanitari di persone in condizione di vulnerabilità, è essenziale che il sistema sia progettato con la privacy by design e by default come principi guida.

I componenti implementati in questo documento forniscono l'infrastruttura necessaria per:

1. Mantenere un registro dei trattamenti completo e aggiornato
2. Gestire i consensi in modo rigoroso e verificabile
3. Garantire il rispetto dei diritti degli interessati
4. Logging completo delle attività per accountability

La priorità di implementazione di questi componenti è P0, in quanto rappresentano requisiti non derogabili dal punto di vista normativo.
