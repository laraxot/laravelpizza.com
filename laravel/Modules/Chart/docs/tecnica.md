# Documentazione Tecnica del Progetto

## Stack Tecnologico
- Laravel 12.x
- Filament 4.x
- Spatie Laravel-permission
- Nwidart Modules
- Laraxot

## 1. Setup Iniziale

### Requisiti di Sistema
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL 8.0+
- Redis (opzionale, per cache)

### Installazione Base
```bash
composer create-project laravel/laravel base_<nome progetto>
cd base_<nome progetto>
composer require filament/filament
composer require spatie/laravel-permission
composer require nwidart/laravel-modules
composer require laraxot/modules
```

### Configurazione Iniziale
1. Configurare il file `.env`
2. Eseguire le migrazioni base
3. Creare l'utente amministratore
4. Configurare il filesystem per i file

## 2. Struttura del Progetto

### Moduli Principali
1. **Core**
   - Gestione utenti
   - Autenticazione
   - Permessi e ruoli

2. **Gestanti**
   - Anagrafica
   - Dati ISEE
   - Stato di gravidanza

3. **Odontoiatria**
   - Visite
   - Trattamenti
   - Note cliniche

4. **Reportistica**
   - Statistiche
   - Analisi dati
   - Export

### Problemi e Soluzioni

#### 1. Gestione Permessi Multi-tenant
**Problema**: Necessità di separare i dati tra diversi odontoiatri e strutture.

**Soluzione**:
- Implementare middleware di tenant
- Utilizzare trait per scope dei modelli
- Configurare policy di accesso

```php
// TenantMiddleware.php
public function handle($request, Closure $next)
{
    $tenant = auth()->user()->tenant;
    config(['tenant.id' => $tenant->id]);
    return $next($request);
}

// HasTenant.php trait
public function scopeForTenant($query)
{
    return $query->where('tenant_id', config('tenant.id'));
}
```

#### 2. Gestione File Medici
**Problema**: Necessità di gestire file medici in modo sicuro e conforme al GDPR.

**Soluzione**:
- Implementare sistema di storage cifrato
- Utilizzare policy di retention
- Implementare logging di accesso

```php
// MedicalFileService.php
public function store($file, $patient)
{
    $encrypted = encrypt($file->get());
    Storage::put("medical/{$patient->id}/{$file->hashName()}", $encrypted);
    return $this->createFileRecord($file, $patient);
}
```

#### 3. Anonimizzazione Dati
**Problema**: Necessità di anonimizzare i dati per analisi e reportistica.

**Soluzione**:
- Implementare service di anonimizzazione
- Utilizzare hash unidirezionali
- Mantenere mapping sicuro

```php
// AnonymizationService.php
public function anonymize($data)
{
    return [
        'id' => hash('sha256', $data->id . config('app.key')),
        'age_group' => $this->getAgeGroup($data->birth_date),
        'location' => $this->getLocationGroup($data->city),
    ];
}
```

## 3. Implementazione Filament

### Resource Principali
1. **GestanteResource**
   - CRUD completo
   - Validazione ISEE
   - Gestione documenti

2. **VisitaResource**
   - Form dinamico
   - Upload file
   - Note cliniche

3. **ReportResource**
   - Dashboard
   - Grafici
   - Export

### Problemi e Soluzioni

#### 1. Form Dinamici
**Problema**: Necessità di form dinamici per le visite odontoiatriche.

**Soluzione**:
- Utilizzare Filament Forms Builder
- Implementare form steps
- Validazione dinamica

```php
// VisitaResource.php
public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Wizard::make([
                Forms\Components\Wizard\Step::make('Anamnesi')
                    ->schema([
                        // Campi anamnesi
                    ]),
                Forms\Components\Wizard\Step::make('Esame Clinico')
                    ->schema([
                        // Campi esame
                    ]),
            ])
        ]);
}
```

#### 2. Dashboard Personalizzata
**Problema**: Necessità di dashboard specifiche per ruolo.

**Soluzione**:
- Implementare widget personalizzati
- Utilizzare policy di visualizzazione
- Cache dei dati aggregati

```php
// Dashboard.php
public function getWidgets(): array
{
    return [
        Widgets\StatsOverview::class,
        Widgets\LatestVisits::class,
        Widgets\PatientTrends::class,
    ];
}
```

## 4. Sicurezza e Privacy

### Implementazioni Chiave
1. **Crittografia Dati**
   - Utilizzare encryption di Laravel
   - Implementare key rotation
   - Gestire backup sicuri

2. **Logging e Audit**
   - Implementare Spatie Activity Log
   - Configurare retention policy
   - Monitorare accessi

3. **Consenso e Privacy**
   - Implementare gestione consensi
   - Configurare retention policy
   - Implementare export dati

### Problemi e Soluzioni

#### 1. Gestione Consensi
**Problema**: Necessità di gestire consensi GDPR.

**Soluzione**:
- Implementare sistema di consensi
- Tracciare modifiche
- Generare report

```php
// ConsentService.php
public function recordConsent($patient, $purpose)
{
    return Consent::create([
        'patient_id' => $patient->id,
        'purpose' => $purpose,
        'status' => 'accepted',
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);
}
```

## 5. Testing e Qualità

### Strategia di Testing
1. **Unit Test**
   - Test dei servizi
   - Test dei modelli
   - Test delle policy

2. **Feature Test**
   - Test dei flussi principali
   - Test di integrazione
   - Test di sicurezza

3. **Browser Test**
   - Test delle interfacce
   - Test di usabilità
   - Test di performance

### Problemi e Soluzioni

#### 1. Test Multi-tenant
**Problema**: Necessità di testare in ambiente multi-tenant.

**Soluzione**:
- Implementare trait per test
- Utilizzare database di test
- Mock dei servizi esterni

```php
// TenantTestCase.php
trait TenantTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->tenant = Tenant::factory()->create();
        $this->actingAs($this->tenant->owner);
    }
}
```

## 6. Deployment e Manutenzione

### Processo di Deployment
1. **Ambiente di Sviluppo**
   - Local development
   - Staging
   - Testing

2. **Ambiente di Produzione**
   - Server dedicati
   - Load balancing
   - Backup automatici

3. **Monitoraggio**
   - Log monitoring
   - Performance monitoring
   - Security monitoring

### Problemi e Soluzioni

#### 1. Backup e Recovery
**Problema**: Necessità di backup sicuri e recovery veloce.

**Soluzione**:
- Implementare backup incrementali
- Utilizzare storage cifrato
- Testare recovery

```php
// BackupService.php
public function performBackup()
{
    $this->backupDatabase();
    $this->backupFiles();
    $this->verifyBackup();
    $this->cleanupOldBackups();
}
```

## 7. Roadmap di Sviluppo

### Fase 1: Setup e Core
- [x] Setup iniziale
- [x] Configurazione base
- [x] Implementazione autenticazione

### Fase 2: Moduli Principali
- [ ] Modulo Gestanti
- [ ] Modulo Odontoiatria
- [ ] Modulo Reportistica

### Fase 3: Sicurezza e Privacy
- [ ] Implementazione GDPR
- [ ] Sistema di consensi
- [ ] Audit logging

### Fase 4: Testing e Ottimizzazione
- [ ] Test unitari
- [ ] Test di integrazione
- [ ] Ottimizzazione performance

### Fase 5: Deployment
- [ ] Setup produzione
- [ ] Monitoraggio
- [ ] Manutenzione 