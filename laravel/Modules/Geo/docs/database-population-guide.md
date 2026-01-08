# Guida al Popolamento Database - Laraxot <nome progetto>

## Panoramica

Questa guida descrive come popolare il database del progetto Laraxot <nome progetto> utilizzando le factories e i seeders disponibili nei vari moduli. Il popolamento è essenziale per:
# Guida al Popolamento Database - Laraxot <nome progetto>

## Panoramica

Questa guida descrive come popolare il database del progetto Laraxot <nome progetto> utilizzando le factories e i seeders disponibili nei vari moduli. Il popolamento è essenziale per:
- Testing e sviluppo
- Popolamento dati iniziali
- Generazione di dataset per performance testing
- Verifica della coerenza dei dati e delle relazioni

## Moduli con Factories e Seeders

### 1. Modulo User
**Path**: `Modules/User/database/`
**Documentazione**: [User Database Population](../laravel/Modules/User/docs/database-population.md)

**Factories Disponibili**:
- `UserFactory` - Generazione utenti base
- `RoleFactory` - Generazione ruoli
- `PermissionFactory` - Generazione permessi
- `TeamFactory` - Generazione team
- `TenantFactory` - Generazione tenant

**Seeders Disponibili**:
- `UserDatabaseSeeder` - Seeder principale
- `UserSeeder` - Utenti amministratori
- `RolesSeeder` - Ruoli standard
- `PermissionsSeeder` - Permessi base
- `UserMassSeeder` - Dataset massivo

### 2. Modulo <nome progetto>
**Path**: `Modules/<nome progetto>/database/`
**Documentazione**: [<nome progetto> Database Population](../laravel/Modules/<nome progetto>/docs/database-population.md)
### 2. Modulo <nome progetto>
**Path**: `Modules/<nome progetto>/database/`
**Documentazione**: [<nome progetto> Database Population](../laravel/Modules/<nome progetto>/docs/database-population.md)

**Factories Disponibili**:
- `UserFactory` - Utenti sanitari
- `DoctorFactory` - Dottori e medici
- `PatientFactory` - Pazienti
- `StudioFactory` - Studi medici e cliniche
- `AppointmentFactory` - Appuntamenti
- `ReportFactory` - Report medici

**Factory Composite**:
- `DoctorStudioFactory` - Relazioni dottore-studio
- `PatientStudioFactory` - Relazioni paziente-studio

### 3. Modulo Tenant
**Path**: `Modules/Tenant/database/`
**Documentazione**: [Tenant Database Population](../laravel/Modules/Tenant/docs/database-population.md)

**Factories Disponibili**:
- `TenantFactory` - Generazione tenant
- `DomainFactory` - Generazione domini

## Strategia di Popolamento

### Fase 1: Setup Base
```bash
# 1. Popolamento tenant e domini
php artisan tinker
>>> \Modules\Tenant\Models\Tenant::factory()->count(5)->create();
>>> \Modules\Tenant\Models\Domain::factory()->count(15)->create();

# 2. Popolamento ruoli e permessi
php artisan db:seed --class="Modules\\User\\Database\\Seeders\\RolesSeeder"
php artisan db:seed --class="Modules\\User\\Database\\Seeders\\PermissionsSeeder"
```

### Fase 2: Popolamento Utenti
```bash
# 3. Popolamento utenti base
php artisan db:seed --class="Modules\\User\\Database\\Seeders\\UserSeeder"

# 4. Generazione utenti massiva
php artisan tinker
>>> \Modules\User\Models\User::factory()->count(100)->create();
```

### Fase 3: Popolamento Business Logic
```bash
# 5. Popolamento studi medici
php artisan tinker
>>> \Modules\<nome progetto>\Models\Studio::factory()->count(10)->create();

# 6. Popolamento dottori
>>> \Modules\<nome progetto>\Models\Doctor::factory()->count(25)->create();

# 7. Popolamento pazienti
>>> \Modules\<nome progetto>\Models\Patient::factory()->count(100)->create();
>>> \Modules\<nome progetto>\Models\Studio::factory()->count(10)->create();

# 6. Popolamento dottori
>>> \Modules\<nome progetto>\Models\Doctor::factory()->count(25)->create();

# 7. Popolamento pazienti
>>> \Modules\<nome progetto>\Models\Patient::factory()->count(100)->create();
```

### Fase 4: Relazioni e Dati Complessi
```bash
# 8. Creazione relazioni dottore-studio
>>> // Script per creare relazioni

# 9. Creazione appuntamenti
>>> \Modules\<nome progetto>\Models\Appointment::factory()->count(200)->create();

# 10. Creazione report
>>> \Modules\<nome progetto>\Models\Report::factory()->count(150)->create();
>>> \Modules\<nome progetto>\Models\Appointment::factory()->count(200)->create();

# 10. Creazione report
>>> \Modules\<nome progetto>\Models\Report::factory()->count(150)->create();
```

## Script di Popolamento Completo

### Script Tinker Completo
```php
// Salva questo script in un file e eseguilo con Tinker
echo "=== POPOLAMENTO DATABASE COMPLETO ===\n\n";

// 1. TENANT E DOMINI
echo "1. Creazione tenant e domini...\n";
$tenants = \Modules\Tenant\Models\Tenant::factory()->count(5)->create();
echo "   ✅ {$tenants->count()} tenant creati\n";

foreach ($tenants as $tenant) {
    $domains = \Modules\Tenant\Models\Domain::factory()->count(3)->create([
        'tenant_id' => $tenant->id
    ]);
    $domains->first()->update(['is_primary' => true]);
}
echo "   ✅ " . \Modules\Tenant\Models\Domain::count() . " domini creati\n\n";

// 2. RUOLI E PERMESSI
echo "2. Creazione ruoli e permessi...\n";
\Artisan::call('db:seed', ['--class' => 'Modules\\User\\Database\\Seeders\\RolesSeeder']);
\Artisan::call('db:seed', ['--class' => 'Modules\\User\\Database\\Seeders\\PermissionsSeeder']);
echo "   ✅ Ruoli e permessi creati\n\n";

// 3. UTENTI BASE
echo "3. Creazione utenti base...\n";
\Artisan::call('db:seed', ['--class' => 'Modules\\User\\Database\\Seeders\\UserSeeder']);
echo "   ✅ Utenti base creati\n\n";

// 4. STUDI MEDICI
echo "4. Creazione studi medici...\n";
$studios = \Modules\<nome progetto>\Models\Studio::factory()->count(10)->create();
$studios = \Modules\<nome progetto>\Models\Studio::factory()->count(10)->create();
echo "   ✅ {$studios->count()} studi creati\n\n";

// 5. DOTTORI
echo "5. Creazione dottori...\n";
$doctors = \Modules\<nome progetto>\Models\Doctor::factory()->count(25)->create();
$doctors = \Modules\<nome progetto>\Models\Doctor::factory()->count(25)->create();
echo "   ✅ {$doctors->count()} dottori creati\n\n";

// 6. PAZIENTI
echo "6. Creazione pazienti...\n";
$patients = \Modules\<nome progetto>\Models\Patient::factory()->count(100)->create();
$patients = \Modules\<nome progetto>\Models\Patient::factory()->count(100)->create();
echo "   ✅ {$patients->count()} pazienti creati\n\n";

// 7. RELAZIONI DOTTORE-STUDIO
echo "7. Creazione relazioni dottore-studio...\n";
foreach ($studios as $studio) {
    $studioDoctors = $doctors->random(rand(2, 5));
    foreach ($studioDoctors as $doctor) {
        \Modules\<nome progetto>\Models\DoctorStudio::factory()->create([
        \Modules\<nome progetto>\Models\DoctorStudio::factory()->create([
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id
        ]);
    }
}
echo "   ✅ Relazioni dottore-studio create\n\n";

// 8. RELAZIONI PAZIENTE-STUDIO
echo "8. Creazione relazioni paziente-studio...\n";
foreach ($studios as $studio) {
    $studioPatients = $patients->random(rand(10, 30));
    foreach ($studioPatients as $patient) {
        \Modules\<nome progetto>\Models\PatientStudio::factory()->create([
        \Modules\<nome progetto>\Models\PatientStudio::factory()->create([
            'patient_id' => $patient->id,
            'studio_id' => $studio->id
        ]);
    }
}
echo "   ✅ Relazioni paziente-studio create\n\n";

// 9. APPUNTAMENTI
echo "9. Creazione appuntamenti...\n";
$appointments = \Modules\<nome progetto>\Models\Appointment::factory()->count(200)->create();
$appointments = \Modules\<nome progetto>\Models\Appointment::factory()->count(200)->create();
echo "   ✅ {$appointments->count()} appuntamenti creati\n\n";

// 10. REPORT
echo "10. Creazione report...\n";
$reports = \Modules\<nome progetto>\Models\Report::factory()->count(150)->create();
$reports = \Modules\<nome progetto>\Models\Report::factory()->count(150)->create();
echo "   ✅ {$reports->count()} report creati\n\n";

// VERIFICA FINALE
echo "=== VERIFICA FINALE ===\n";
echo "Tenant: " . \Modules\Tenant\Models\Tenant::count() . "\n";
echo "Domini: " . \Modules\Tenant\Models\Domain::count() . "\n";
echo "Utenti: " . \Modules\User\Models\User::count() . "\n";
echo "Studi: " . \Modules\<nome progetto>\Models\Studio::count() . "\n";
echo "Dottori: " . \Modules\<nome progetto>\Models\Doctor::count() . "\n";
echo "Pazienti: " . \Modules\<nome progetto>\Models\Patient::count() . "\n";
echo "Appuntamenti: " . \Modules\<nome progetto>\Models\Appointment::count() . "\n";
echo "Report: " . \Modules\<nome progetto>\Models\Report::count() . "\n";
echo "Studi: " . \Modules\<nome progetto>\Models\Studio::count() . "\n";
echo "Dottori: " . \Modules\<nome progetto>\Models\Doctor::count() . "\n";
echo "Pazienti: " . \Modules\<nome progetto>\Models\Patient::count() . "\n";
echo "Appuntamenti: " . \Modules\<nome progetto>\Models\Appointment::count() . "\n";
echo "Report: " . \Modules\<nome progetto>\Models\Report::count() . "\n";

echo "\n🎉 POPOLAMENTO COMPLETATO CON SUCCESSO!\n";
```

## Utilizzo dei Seeders

### Esecuzione Seeder Specifico
```bash
# User module
php artisan db:seed --class="Modules\\User\\Database\\Seeders\\UserDatabaseSeeder"

# Seeder specifico
php artisan db:seed --class="Modules\\User\\Database\\Seeders\\UserSeeder"
```

### Esecuzione Seeder con Parametri
```bash
# Con ambiente specifico
php artisan db:seed --class="Modules\\User\\Database\\Seeders\\UserSeeder" --env=local

# Con database specifico
php artisan db:seed --class="Modules\\User\\Database\\Seeders\\UserSeeder" --database=mysql
```

## Best Practices

### 1. Ordine di Esecuzione
1. **Infrastruttura**: Tenant, domini, ruoli, permessi
2. **Utenti**: Utenti base e amministratori
3. **Business**: Studi, dottori, pazienti
4. **Relazioni**: Collegamenti tra entità
5. **Dati**: Appuntamenti, report, transazioni

### 2. Gestione Memoria
- Utilizzare `chunk()` per dataset molto grandi
- Eseguire popolamento in fasi separate
- Monitorare l'uso della memoria durante l'esecuzione

### 3. Verifica Integrità
- Controllare i conteggi dopo ogni fase
- Verificare le relazioni tra modelli
- Testare le funzionalità principali

### 4. Backup e Sicurezza
- Fare sempre backup del database prima del popolamento
- Non eseguire factories in produzione
- Utilizzare database di test separati

## Troubleshooting

### Errori Comuni

#### 1. Violazione Vincoli Unici
```bash
# ERRORE: Duplicate entry for key 'users_email_unique'
# SOLUZIONE: Verificare che le factories usino faker unique
php artisan tinker
>>> \Modules\User\Models\User::factory()->count(1)->create();
```

#### 2. Relazioni Mancanti
```bash
# ERRORE: Foreign key constraint fails
# SOLUZIONE: Verificare ordine di creazione
php artisan tinker
>>> \Modules\Tenant\Models\Tenant::count(); // Deve essere > 0
>>> \Modules\<nome progetto>\Models\Studio::count(); // Deve essere > 0
>>> \Modules\<nome progetto>\Models\Studio::count(); // Deve essere > 0
```

#### 3. Memoria Insufficiente
```bash
# ERRORE: Allowed memory size exhausted
# SOLUZIONE: Ridurre batch size o usare chunk
php artisan tinker
>>> \Modules\User\Models\User::factory()->count(50)->create(); // Ridurre da 100 a 50
```

### Verifica Stato Database
```bash
# Controllo tabelle
php artisan tinker
>>> \DB::select('SHOW TABLES');

# Controllo conteggi
php artisan tinker
>>> echo "Users: " . \Modules\User\Models\User::count() . "\n";
>>> echo "Studi: " . \Modules\<nome progetto>\Models\Studio::count() . "\n";
>>> echo "Dottori: " . \Modules\<nome progetto>\Models\Doctor::count() . "\n";
>>> echo "Studi: " . \Modules\<nome progetto>\Models\Studio::count() . "\n";
>>> echo "Dottori: " . \Modules\<nome progetto>\Models\Doctor::count() . "\n";
```

## Collegamenti

- [User Module Database Population](../laravel/Modules/User/docs/database-population.md)
- [<nome progetto> Module Database Population](../laravel/Modules/<nome progetto>/docs/database-population.md)
- [Tenant Module Database Population](../laravel/Modules/Tenant/docs/database-population.md)
- [Factory Best Practices](../laravel/Modules/<nome progetto>/docs/factory-best-practices.md)
- [<nome progetto> Module Database Population](../laravel/Modules/<nome progetto>/docs/database-population.md)
- [Tenant Module Database Population](../laravel/Modules/Tenant/docs/database-population.md)
- [Factory Best Practices](../laravel/Modules/<nome progetto>/docs/factory-best-practices.md)
- [Testing Guidelines](../laravel/Modules/User/docs/testing.md)

---

**Ultimo aggiornamento**: Gennaio 2025
**Versione**: 1.0
**Autore**: Sistema Laraxot




