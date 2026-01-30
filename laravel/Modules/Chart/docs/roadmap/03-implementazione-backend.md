# Implementazione Backend

## Stato Attuale

Il backend del progetto il progetto è basato su Laravel 12 con architettura modulare Laraxot. I moduli principali sono stati installati ma richiedono configurazione e personalizzazione per soddisfare i requisiti specifici del progetto.

### Componenti Implementati ✅

- Base Laravel
- Struttura modulare con nwidart/laravel-modules
- Moduli Laraxot integrati tramite git subtree

### Componenti In Corso ⏳

- Configurazione service provider
- Personalizzazione modelli dati
- Implementazione flussi di autenticazione
- Multi-tenancy

## Attività da Completare

### 1. Risoluzione Problemi di Autoloading (P0)

#### Descrizione
Risolvere i conflitti di namespace e problemi di autoloading PSR-4 tra i vari moduli Laraxot.

#### Implementazione
1. **Identificare classi duplicate**:
   ```bash
   find /var/www/html/<nome progetto>/laravel/Modules -type f -name "*.php" | xargs grep -l "namespace" | sort > file_namespaces.txt
   ```

2. **Analizzare manualmente i conflitti** più critici:
   - Conflitti tra modulo Gdpr e UI
   - Conflitti nei namespace Model
   - File non conformi a PSR-4

3. **Correggere i namespace**:
   ```php
   // Prima
   namespace Modules\Gdpr\Models;
   
   // Dopo (se in posizione non conforme a PSR-4)
   namespace Modules\Gdpr\App\Models;
   ```

4. **Aggiornare composer.json**:
   ```json
   "autoload": {
       "psr-4": {
           "App\\": "app/",
           "Database\\Factories\\": "database/factories/",
           "Database\\Seeders\\": "database/seeders/",
           "Modules\\": "Modules/"
       }
   }
   ```

5. **Rigenerare autoloader**:
   ```bash
   composer dump-autoload
   ```

### 2. Configurazione Service Provider (P0)

#### Descrizione
Registrare correttamente i service provider dei moduli nel file `config/app.php`.

#### Implementazione
1. **Aprire il file di configurazione**:
   ```bash
   nano /var/www/html/<nome progetto>/laravel/config/app.php
   ```

2. **Aggiungere i provider in ordine di dipendenza**:
   ```php
   'providers' => [
       // Laravel Framework Service Providers...
       
       // Moduli Laraxot
       Modules\Xot\Providers\XotServiceProvider::class,
       Modules\Lang\Providers\LangServiceProvider::class,
       Modules\Tenant\Providers\TenantServiceProvider::class,
       Modules\UI\Providers\UIServiceProvider::class,
       Modules\User\Providers\UserServiceProvider::class,
       Modules\Media\Providers\MediaServiceProvider::class,
       Modules\Activity\Providers\ActivityServiceProvider::class,
       Modules\Gdpr\Providers\GdprServiceProvider::class,
       Modules\Notify\Providers\NotifyServiceProvider::class,
       Modules\Cms\Providers\CmsServiceProvider::class,
       Modules\Job\Providers\JobServiceProvider::class,
       Modules\Chart\Providers\ChartServiceProvider::class,
       Modules\Patient\Providers\PatientServiceProvider::class,
   ],
   ```

3. **Verificare che i provider esistano**:
   Prima di aggiungerli, controllare che il file `ServiceProvider.php` esista nella directory `app/Providers/` di ogni modulo.

### 3. Configurazione Database e Migrazioni (P0)

#### Descrizione
Configurare il database e eseguire le migrazioni per tutti i moduli.

#### Implementazione
1. **Verificare configurazione database**:
   ```php
   // .env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=<nome progetto>
   DB_USERNAME=root
   DB_PASSWORD=
   ```

2. **Pubblicare le migrazioni**:
   ```bash
   php artisan vendor:publish --tag=migrations
   ```

3. **Verificare conflitti tra migrazioni**:
   Controllare le migrazioni nella directory `database/migrations` e assicurarsi che non ci siano conflitti di nomi tabella o duplicazioni.

4. **Eseguire le migrazioni in ordine corretto**:
   ```bash
   # Moduli base
   php artisan migrate --path=/database/migrations/xot
   php artisan migrate --path=/database/migrations/tenant
   php artisan migrate --path=/database/migrations/user
   
   # Altri moduli
   php artisan migrate
   ```

### 4. Implementazione Multi-tenant (P1)

#### Descrizione
Configurare il sistema multi-tenant per supportare la separazione dei dati tra diversi studi odontoiatrici.

#### Implementazione
1. **Configurare il modulo Tenant**:
   ```php
   // config/tenant.php
   return [
       'connection' => env('TENANT_CONNECTION', 'tenant'),
       'database_prefix' => env('TENANT_DB_PREFIX', 'tenant_'),
       'domain_column' => 'domain',
       'model' => \Modules\Tenant\Models\Tenant::class,
   ];
   ```

2. **Creare middleware per identificazione tenant**:
   ```php
   // Modules/Tenant/app/Http/Middleware/IdentifyTenant.php
   namespace Modules\Tenant\Http\Middleware;
   
   use Closure;
   use Illuminate\Http\Request;
   use Modules\Tenant\Services\TenantManager;
   
   class IdentifyTenant
   {
       protected $tenantManager;
       
       public function __construct(TenantManager $tenantManager)
       {
           $this->tenantManager = $tenantManager;
       }
       
       public function handle(Request $request, Closure $next)
       {
           $this->tenantManager->identifyTenant();
           return $next($request);
       }
   }
   ```

3. **Registrare middleware globale**:
   ```php
   // app/Http/Kernel.php
   protected $middleware = [
       // ...
       \Modules\Tenant\Http\Middleware\IdentifyTenant::class,
   ];
   ```

### 5. API RESTful per Integrazione Frontend (P1)

#### Descrizione
Implementare API RESTful per permettere l'interazione tra frontend e backend.

#### Implementazione
1. **Creare controller API per ogni modello principale**:
   ```bash
   php artisan make:controller Api/PatientController --api
   php artisan make:controller Api/AppointmentController --api
   php artisan make:controller Api/DentistController --api
   ```

2. **Definire rotte API**:
   ```php
   // routes/api.php
   Route::middleware('auth:sanctum')->group(function () {
       Route::apiResource('patients', 'Api\PatientController');
       Route::apiResource('appointments', 'Api\AppointmentController');
       Route::apiResource('dentists', 'Api\DentistController');
   });
   ```

3. **Implementare autenticazione API**:
   ```bash
   composer require laravel/sanctum
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   php artisan migrate
   ```

4. **Creare risorse API per formattazione dati**:
   ```bash
   php artisan make:resource PatientResource
   php artisan make:resource AppointmentResource
   php artisan make:resource DentistResource
   ```

### 6. Implementazione Flussi di Lavoro Principali (P1)

#### Descrizione
Implementare i flussi di lavoro principali identificati nel documento del progetto.

#### Implementazione
1. **Registrazione e validazione pazienti**:
   ```php
   // Modulo Patient - Controller per registrazione
   public function register(RegisterPatientRequest $request)
   {
       $validated = $request->validated();
       
       // Verifica ISEE
       if ($validated['isee'] > 20000) {
           return response()->json(['error' => 'ISEE superiore al limite consentito'], 422);
       }
       
       // Verifica gravidanza
       if (!$validated['pregnancy_document']) {
           return response()->json(['error' => 'Documento attestante gravidanza mancante'], 422);
       }
       
       // Salvataggio dati paziente
       $patient = Patient::create($validated);
       
       // Notifica backoffice
       event(new PatientRegistered($patient));
       
       return new PatientResource($patient);
   }
   ```

2. **Gestione appuntamenti**:
   ```php
   // Modulo Appointment - Controller per prenotazione
   public function store(StoreAppointmentRequest $request)
   {
       $validated = $request->validated();
       
       // Verifica disponibilità dentista
       $dentist = Dentist::find($validated['dentist_id']);
       if (!$dentist->isAvailable($validated['date'], $validated['time'])) {
           return response()->json(['error' => 'Dentista non disponibile nell\'orario selezionato'], 422);
       }
       
       // Creazione appuntamento
       $appointment = Appointment::create($validated);
       
       // Notifica dentista
       event(new AppointmentRequested($appointment));
       
       return new AppointmentResource($appointment);
   }
   ```

### 7. Implementazione Sistema GDPR (P0)

#### Descrizione
Configurare il modulo GDPR per garantire la conformità normativa del progetto.

#### Implementazione
1. **Configurare consensi**:
   ```php
   // config/gdpr.php
   return [
       'consents' => [
           'privacy_policy' => [
               'title' => 'Informativa sulla Privacy',
               'required' => true,
           ],
           'data_processing' => [
               'title' => 'Trattamento Dati Personali',
               'required' => true,
           ],
           'medical_data' => [
               'title' => 'Trattamento Dati Medici',
               'required' => true,
           ],
           'marketing' => [
               'title' => 'Marketing',
               'required' => false,
           ],
       ],
       'retention_period' => [
           'patient_data' => 60 * 24 * 365 * 10, // 10 anni in minuti
           'medical_records' => 60 * 24 * 365 * 10,
           'appointments' => 60 * 24 * 365 * 2,
       ],
   ];
   ```

2. **Implementare richieste di esportazione dati**:
   ```php
   // Modulo GDPR - Controller per esportazione dati
   public function exportData(Request $request)
   {
       $user = auth()->user();
       
       // Raccolta dati
       $userData = $user->toArray();
       $patientData = $user->patient()->first()->toArray();
       $appointmentData = $user->patient->appointments()->get()->toArray();
       
       // Creazione file JSON
       $exportData = [
           'user' => $userData,
           'patient' => $patientData,
           'appointments' => $appointmentData,
       ];
       
       // Log dell'operazione
       activity()
           ->causedBy($user)
           ->withProperties(['export' => true])
           ->log('User exported personal data');
       
       return response()->json($exportData);
   }
   ```

3. **Implementare cancellazione dati**:
   ```php
   // Modulo GDPR - Controller per cancellazione dati
   public function deleteData(Request $request)
   {
       $user = auth()->user();
       
       // Anonimizzazione dati invece di cancellazione completa
       $user->patient()->update([
           'name' => 'Anonimizzato',
           'surname' => 'Anonimizzato',
           'fiscal_code' => null,
           'email' => null,
           'phone' => null,
           // Altri campi sensibili
       ]);
       
       // Log dell'operazione
       activity()
           ->causedBy($user)
           ->withProperties(['delete' => true])
           ->log('User data anonymized');
       
       return response()->json(['message' => 'Dati personali anonimizzati con successo']);
   }
   ```

## Criteri di Accettazione

- ✅ Tutti i service provider sono correttamente registrati e funzionanti
- ✅ Le migrazioni del database sono eseguite senza errori
- ✅ Il sistema multi-tenant funziona correttamente
- ✅ Le API RESTful sono implementate e documentate
- ✅ I flussi di lavoro principali sono funzionanti
- ✅ Il sistema è conforme alle normative GDPR

## Dipendenze e Prerequisiti

- Laravel Framework 12.x
- PHP 8.2 o superiore
- Composer 2.x
- MySQL 8.0 o superiore
- Moduli Laraxot installati correttamente
