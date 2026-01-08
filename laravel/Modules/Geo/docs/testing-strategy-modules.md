# Strategia di Testing per i Moduli <nome progetto>

## Introduzione

Questo documento definisce la strategia completa per la creazione di test Pest per tutti i moduli del progetto <nome progetto>, seguendo le regole architetturali specifiche del progetto e le best practice di testing.

## Principi Fondamentali

### 1. Separazione Architettonica
Seguendo il pattern implementato nei test di autenticazione esistenti:
- **LoginTest.php**: testa SOLO pagina `/it/auth/login` (rendering, layout, middleware, localizzazione, performance)
- **LoginVoltTest.php**: testa SOLO componente Volt `auth.login` (state management, validation, authentication, security)
- **LoginWidgetTest.php**: testa SOLO widget Filament (form logic, validation)

### 2. Moduli per Categoria

#### Moduli Core (Infrastruttura)
- **Xot**: Framework base, classi base, provider
- **User**: Autenticazione, autorizzazione, gestione utenti
- **UI**: Componenti UI condivisi, temi, layout

#### Moduli Business (Dominio)
- **<nome progetto>**: Gestione pazienti, appuntamenti, stati
- **<nome modulo>**: Gestione pazienti specifici per Modena

#### Moduli Utility (Supporto)
- **Cms**: Gestione contenuti
- **Media**: Gestione file e media
- **Geo**: Gestione indirizzi e localizzazione
- **Lang**: Gestione traduzioni
- **Notify**: Sistema notifiche
- **Activity**: Logging e audit trail
- **Tenant**: Multi-tenancy
- **Job**: Gestione code
- **Gdpr**: Conformità GDPR
- **FormBuilder**: Costruttore form dinamici
- **DbForge**: Gestione database

## Struttura Test per Modulo

### Template Base per ogni Modulo

```
tests/Feature/Modules/{ModuleName}/
├── Unit/
│   ├── Models/
│   │   ├── {ModelName}Test.php
│   │   └── Factory{ModelName}Test.php
│   ├── Actions/
│   │   └── {ActionName}Test.php
│   ├── Enums/
│   │   └── {EnumName}Test.php
│   └── Traits/
│       └── {TraitName}Test.php
├── Feature/
│   ├── Http/
│   │   └── Controllers/
│   │       └── {ControllerName}Test.php
│   ├── Filament/
│   │   ├── Resources/
│   │   │   └── {ResourceName}Test.php
│   │   ├── Pages/
│   │   │   └── {PageName}Test.php
│   │   └── Widgets/
│   │       └── {WidgetName}Test.php
│   └── Api/
│       └── {ApiEndpoint}Test.php
├── Integration/
│   ├── Database/
│   │   ├── Migrations/
│   │   └── Seeders/
│   └── Services/
│       └── {ServiceName}Test.php
└── Browser/
    └── {FeatureName}Test.php
```

## Strategia per Modulo

### Moduli Core

#### Modulo Xot
**Focus**: Classi base, provider, configurazioni
- **Unit Tests**: BaseModel, XotBaseServiceProvider, trait condivisi
- **Feature Tests**: Configurazioni, middleware, helper
- **Integration Tests**: Integrazione con Laravel, Filament

#### Modulo User
**Focus**: Autenticazione, autorizzazione, gestione utenti
- **Unit Tests**: User model, trait HasTeams/HasTenants, enum UserType
- **Feature Tests**: Login/logout, registrazione, profile management
- **Integration Tests**: OAuth, social login, multi-tenancy
- **Browser Tests**: Flussi completi di autenticazione

#### Modulo UI
**Focus**: Componenti UI, temi, layout
- **Unit Tests**: Componenti Blade, helper UI
- **Feature Tests**: Rendering componenti, temi
- **Integration Tests**: Integrazione con Filament, Tailwind

### Moduli Business

#### Modulo <nome progetto>
**Focus**: Gestione pazienti, appuntamenti, stati, calendario
- **Unit Tests**: 
  - Models: Patient, Doctor, Appointment, Studio
  - Enums: AppointmentStatus, UserType
  - Actions: CreateAppointment, UpdateAppointmentStatus
  - Pivot Models: DoctorStudio
- **Feature Tests**:
  - Filament Resources: PatientResource, AppointmentResource
  - Calendar Widgets: DoctorCalendarWidget, PatientCalendarWidget
  - Form Wizards: FindDoctorAndAppointmentWidget
- **Integration Tests**:
  - Cross-database relations (DoctorStudio)
  - FullCalendar integration
  - Multi-tenant filtering
- **Browser Tests**:
  - Complete booking flow
  - Doctor availability management
  - Patient dashboard navigation

#### Modulo <nome modulo>
**Focus**: Estensioni specifiche per Modena
- **Unit Tests**: Modelli specifici, business logic locale
- **Feature Tests**: Funzionalità specifiche di Modena
- **Integration Tests**: Integrazione con <nome progetto>

### Moduli Utility

#### Modulo Cms
**Focus**: Gestione contenuti
- **Unit Tests**: Content models, page builders
- **Feature Tests**: Content management, SEO
- **Browser Tests**: Frontend content rendering

#### Modulo Media
**Focus**: Gestione file e media
- **Unit Tests**: File upload, image processing
- **Feature Tests**: Media library, file validation
- **Integration Tests**: Storage providers, CDN

#### Modulo Geo
**Focus**: Gestione indirizzi e localizzazione
- **Unit Tests**: Address models, geocoding
- **Feature Tests**: Address validation, maps integration
- **Integration Tests**: External geocoding APIs

## Test Patterns Specifici

### Pattern 1: Test Models con Relazioni Cross-Database
```php
// Per DoctorStudio (<nome progetto>)
test('doctor studio pivot model manages cross-database relations', function () {
    $doctor = Doctor::factory()->create();
    $studio = Studio::factory()->create();
    
    $doctorStudio = DoctorStudio::create([
        'doctor_id' => $doctor->id,
        'studio_id' => $studio->id,
        'opening_hours' => ['monday' => '09:00-17:00']
    ]);
    
    expect($doctorStudio->doctor)->toBeInstanceOf(Doctor::class);
    expect($doctorStudio->studio)->toBeInstanceOf(Studio::class);
    expect($doctorStudio->opening_hours)->toBeArray();
});
```

### Pattern 2: Test Widget Filament con Multi-Tenancy
```php
// Per DoctorCalendarWidget (<nome progetto>)
test('doctor calendar widget shows only tenant appointments', function () {
    $studio1 = Studio::factory()->create();
    $studio2 = Studio::factory()->create();
    $doctor = Doctor::factory()->create();
    
    // Appointments in different studios
    $appointment1 = Appointment::factory()->create(['studio_id' => $studio1->id]);
    $appointment2 = Appointment::factory()->create(['studio_id' => $studio2->id]);
    
    // Set current tenant
    Filament::setTenant($studio1);
    
    $widget = new DoctorCalendarWidget();
    $events = $widget->fetchEvents(['start' => now()->startOfMonth(), 'end' => now()->endOfMonth()]);
    
    expect($events)->toHaveCount(1);
    expect($events[0]['id'])->toBe($appointment1->id);
});
```

### Pattern 3: Test Factory con Single Table Inheritance
```php
// Per UserFactory con Parental STI
test('user factory creates different user types correctly', function () {
    $patient = UserFactory::new()->patient()->create();
    $doctor = UserFactory::new()->doctor()->create();
    $admin = UserFactory::new()->admin()->create();
    
    expect($patient->type)->toBe(UserTypeEnum::PATIENT);
    expect($doctor->type)->toBe(UserTypeEnum::DOCTOR);
    expect($admin->type)->toBe(UserTypeEnum::ADMIN);
    
    expect($patient)->toBeInstanceOf(Patient::class);
    expect($doctor)->toBeInstanceOf(Doctor::class);
    expect($admin)->toBeInstanceOf(Admin::class);
});
```

### Pattern 4: Test Traduzioni Multilingua
```php
// Per traduzioni stati appuntamenti
test('appointment states have complete translations in all languages', function () {
    $states = AppointmentStatusEnum::cases();
    $languages = ['it', 'en', 'de'];
    
    foreach ($states as $state) {
        foreach ($languages as $lang) {
            app()->setLocale($lang);
            
            $label = __("<nome progetto>::states.{$state->value}.label");
            $description = __("<nome progetto>::states.{$state->value}.description");
            
            expect($label)->not->toContain('<nome progetto>::');
            expect($description)->not->toContain('<nome progetto>::');
        }
    }
});
```

## Configurazione Pest per Moduli

### Setup Base
```php
// tests/Pest.php - Aggiunta configurazione moduli
pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');

// Helper per testing moduli
function moduleEnabled(string $module): bool {
    $moduleStatuses = json_decode(file_get_contents(base_path('modules_statuses.json')), true);
    return $moduleStatuses[$module] ?? false;
}

function skipIfModuleDisabled(string $module): void {
    if (!moduleEnabled($module)) {
        test()->markTestSkipped("Module {$module} is disabled");
    }
}
```

### TestCase Base per Moduli
```php
// tests/ModuleTestCase.php
abstract class ModuleTestCase extends TestCase
{
    protected string $moduleName;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        if (!moduleEnabled($this->moduleName)) {
            $this->markTestSkipped("Module {$this->moduleName} is disabled");
        }
        
        $this->setupModuleEnvironment();
    }
    
    abstract protected function setupModuleEnvironment(): void;
}
```

## Utilities e Helper

### Factory Helper
```php
// tests/Helpers/FactoryHelper.php
class FactoryHelper
{
    public static function createUserOfType(UserTypeEnum $type): User
    {
        return match($type) {
            UserTypeEnum::PATIENT => UserFactory::new()->patient()->create(),
            UserTypeEnum::DOCTOR => UserFactory::new()->doctor()->create(),
            UserTypeEnum::ADMIN => UserFactory::new()->admin()->create(),
        };
    }
}
```

### Database Helper
```php
// tests/Helpers/DatabaseHelper.php
class DatabaseHelper
{
    public static function assertCrossDatabaseRelation($pivotModel, string $relation1, string $relation2): void
    {
        expect($pivotModel->$relation1)->not->toBeNull();
        expect($pivotModel->$relation2)->not->toBeNull();
        expect($pivotModel->$relation1->getConnectionName())->not->toBe($pivotModel->$relation2->getConnectionName());
    }
}
```

## Criteri di Qualità

### Coverage Requirements
- **Unit Tests**: Minimo 90% coverage per models, actions, enums
- **Feature Tests**: Minimo 80% coverage per controllers, resources
- **Integration Tests**: Copertura completa delle integrazioni critiche

### Performance Benchmarks
- **Unit Tests**: < 100ms per test
- **Feature Tests**: < 500ms per test
- **Integration Tests**: < 2s per test
- **Browser Tests**: < 10s per test

### Naming Conventions
- Test files: `{ClassName}Test.php`
- Test methods: `test_{what_it_should_do}`
- Dataset names: snake_case
- Helper methods: camelCase

## Implementazione Graduale

### Fase 1: Moduli Core (Settimana 1)
1. Xot - Classi base e configurazioni
2. User - Autenticazione e autorizzazione
3. UI - Componenti e temi

### Fase 2: Moduli Business (Settimana 2)
1. <nome progetto> - Gestione completa pazienti/appuntamenti
2. <nome modulo> - Estensioni specifiche Modena

### Fase 3: Moduli Utility (Settimana 3)
1. Cms, Media, Geo - Gestione contenuti e localizzazione
2. Lang, Notify, Activity - Supporto e logging
3. Tenant, Job, Gdpr - Infrastruttura avanzata

### Fase 4: Integrazione e Ottimizzazione (Settimana 4)
1. Browser tests per flussi completi
2. Performance testing e ottimizzazione
3. Documentazione e training

## Monitoraggio e Maintenance

### Metriche da Tracciare
- Test coverage per modulo
- Tempo di esecuzione test suite
- Frequenza di fallimenti test
- Performance regression detection

### Automazione CI/CD
- Esecuzione test su ogni PR
- Coverage report automatici
- Performance benchmarking
- Notifiche per regressioni

## Collegamenti

- [Test Autenticazione Esistenti](../tests/Feature/Auth/) - Pattern di riferimento
- [Documentazione Modulo <nome progetto>](../Modules/<nome progetto>/docs/README.md)
- [Documentazione Modulo User](../Modules/User/docs/README.md)
- [Configurazione Pest](../tests/Pest.php)

---

**Ultimo aggiornamento**: 28 Gennaio 2025  
**Stato**: 🚧 In implementazione  
**Responsabile**: Team Development

