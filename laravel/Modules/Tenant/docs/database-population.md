# Popolamento Database - Modulo Tenant

## Aggiornamento [DATE] – Test Sushi Seeder

- Rafforzata la type safety del seeder `TestSushiSeeder` utilizzando `Webmozart\Assert` per evitare errori PHPStan (`method.nonObject`) su `create()` e `count()`.
- Ogni invocazione di `TestSushiModel::factory()` viene validata con `Assert::isInstanceOf` prima di usare i metodi fluenti.
- Aggiunte annotazioni PHPDoc (`Factory<TestSushiModel>`) per rendere espliciti i tipi attesi al livello 10.
- Il seeding random per ambienti `local`/`testing` mantiene il comportamento originario, ma con assert espliciti.

### Motivazioni

- Previene factory "miste" quando il generatore viene sostituito o mockato.
- Allinea la strategia di seeding del modulo Tenant con il principio Laraxot “fix, don’t ignore”.
- Limita il seeding agli ambienti corretti tramite `app()->environment([...])`.

### File correlati

- `Modules/Tenant/database/seeders/TestSushiSeeder.php`
- `Modules/Tenant/Models/TestSushiModel.php`

## Panoramica

Questo documento descrive come popolare il database del modulo Tenant utilizzando le factories e i seeders disponibili. Il modulo gestisce l'architettura multi-tenant del sistema, inclusi tenant, domini e configurazioni.

## Factories Disponibili

### 1. TenantFactory

**File**: `database/factories/TenantFactory.php`
**Scopo**: Generazione di tenant per il sistema multi-tenant

```php
// Generazione tenant base
$tenant = \Modules\Tenant\Models\Tenant::factory()->create();

// Generazione con nome specifico
$medicalTenant = \Modules\Tenant\Models\Tenant::factory()->create([
    'name' => 'Medical Center',
]);

// Generazione multipla
$tenants = \Modules\Tenant\Models\Tenant::factory()->count(10)->create();
```

**Campi generati**:

- `name` – Nome del tenant
- `domain` – Dominio associato
- `settings` – Configurazioni JSON del tenant
- `is_active` – Stato attivo del tenant

### 2. DomainFactory

**File**: `database/factories/DomainFactory.php`
**Scopo**: Generazione di domini associati ai tenant

```php
// Generazione dominio base
$domain = \Modules\Tenant\Models\Domain::factory()->create();

// Generazione con dominio specifico
$customDomain = \Modules\Tenant\Models\Domain::factory()->create([
    'domain' => 'example.com',
]);

// Generazione multipla
$domains = \Modules\Tenant\Models\Domain::factory()->count(20)->create();
```

**Campi generati**:

- `domain` – Nome del dominio
- `tenant_id` – ID del tenant associato
- `is_primary` – Flag dominio primario
- `is_verified` – Stato verifica dominio

## Utilizzo con Tinker

### Popolamento base sistema multi-tenant

```bash
php artisan tinker
```

```php
// 1. Creazione tenant
$tenants = \Modules\Tenant\Models\Tenant::factory()->count(5)->create();
echo "Tenant creati: " . $tenants->count() . "\n";

// 2. Creazione domini per ogni tenant
foreach ($tenants as $tenant) {
    $domains = \Modules\Tenant\Models\Domain::factory()->count(3)->create([
        'tenant_id' => $tenant->id,
    ]);

    // Imposta un dominio come primario
    $domains->first()->update(['is_primary' => true]);

    echo "Tenant {$tenant->name}: " . $domains->count() . " domini creati\n";
}
```

### Creazione tenant con configurazioni specifiche

```php
// Creazione tenant medico
$medicalTenant = \Modules\Tenant\Models\Tenant::factory()->create([
    'name' => 'Medical Center',
    'settings' => [
        'theme' => 'medical',
        'logo' => 'medical-logo.png',
        'primary_color' => '#2563eb',
        'features' => ['appointments', 'reports', 'billing'],
    ],
]);

// Creazione domini per il tenant medico
$primaryDomain = \Modules\Tenant\Models\Domain::factory()->create([
    'tenant_id' => $medicalTenant->id,
    'domain' => 'medical.example.com',
    'is_primary' => true,
    'is_verified' => true,
]);

$secondaryDomain = \Modules\Tenant\Models\Domain::factory()->create([
    'tenant_id' => $medicalTenant->id,
    'domain' => 'med.example.com',
    'is_primary' => false,
    'is_verified' => true,
]);

echo "Tenant medico configurato:\n";
echo "- Nome: {$medicalTenant->name}\n";
echo "- Domini: " . $medicalTenant->domains()->count() . "\n";
echo "- Configurazioni: " . count($medicalTenant->settings) . " impostazioni\n";
```

### Generazione dataset multi-tenant completo

```php
// Creazione tenant per diversi settori
$sectors = [
    'medical' => ['Medical Center', 'Clinic', 'Hospital'],
    'dental' => ['Dental Clinic', 'Orthodontics', 'Dental Surgery'],
    'pharmacy' => ['Pharmacy', 'Drug Store', 'Medical Supply'],
    'wellness' => ['Wellness Center', 'Spa', 'Fitness Center'],
];

$allTenants = collect();

foreach ($sectors as $sector => $names) {
    foreach ($names as $name) {
        $tenant = \Modules\Tenant\Models\Tenant::factory()->create([
            'name' => $name,
            'settings' => [
                'sector' => $sector,
                'theme' => $sector,
                'features' => $this->getSectorFeatures($sector),
            ],
        ]);

        // Creazione domini per ogni tenant
        $domains = \Modules\Tenant\Models\Domain::factory()->count(2)->create([
            'tenant_id' => $tenant->id,
        ]);

        // Imposta dominio primario
        $domains->first()->update(['is_primary' => true]);

        $allTenants->push($tenant);
    }
}

echo "Dataset multi-tenant creato:\n";
echo "- Tenant totali: " . $allTenants->count() . "\n";
echo "- Domini totali: " . \Modules\Tenant\Models\Domain::count() . "\n";

// Raggruppa per settore
$groupedTenants = $allTenants->groupBy(function ($tenant) {
    return $tenant->settings['sector'];
});

foreach ($groupedTenants as $sector => $tenants) {
    echo "- {$sector}: " . $tenants->count() . " tenant\n";
}
```

## Best Practices

### 1. Ordine di creazione

1. **Tenant** – Creare prima i tenant.
2. **Domini** – Associare domini ai tenant.
3. **Configurazioni** – Impostare configurazioni specifiche per settore.
4. **Verifica** – Controllare l’integrità delle relazioni.

### 2. Gestione domini

- Ogni tenant deve avere almeno un dominio primario.
- Utilizzare domini realistici per testing.
- Verificare che non ci siano conflitti di dominio.

### 3. Configurazioni tenant

- Utilizzare strutture JSON coerenti per le impostazioni.
- Mantenere configurazioni specifiche per settore.
- Documentare le chiavi di configurazione disponibili.

### 4. Testing

- Generare sempre dati di test con le factories.
- Verificare che i dati generati rispettino i vincoli del database.
- Testare le relazioni tra tenant e domini.

## Troubleshooting

### Errori comuni

#### 1. Violazione vincoli unici

```php
// ERRORE: Duplicate entry for key 'domains_domain_unique'
// SOLUZIONE: Utilizzare faker per domini unici
'domain' => $this->faker->unique()->domainName(),
```

#### 2. Relazioni mancanti

```php
// ERRORE: Foreign key constraint fails
// SOLUZIONE: Creare prima il tenant
$tenant = \Modules\Tenant\Models\Tenant::factory()->create();
$domain = \Modules\Tenant\Models\Domain::factory()->create([
    'tenant_id' => $tenant->id,
]);
```

#### 3. Configurazioni JSON non valide

```php
// ERRORE: Invalid JSON format
// SOLUZIONE: Utilizzare array associativi validi
'settings' => [
    'theme' => 'default',
    'features' => ['feature1', 'feature2'],
],
```

### Verifica integrità

```php
// Controllo conteggi
echo "Tenant: " . \Modules\Tenant\Models\Tenant::count() . "\n";
echo "Domini: " . \Modules\Tenant\Models\Domain::count() . "\n";

// Controllo relazioni
$tenant = \Modules\Tenant\Models\Tenant::first();
echo "Tenant {$tenant->name}:\n";
echo "- Domini: " . $tenant->domains()->count() . "\n";
echo "- Dominio primario: " . ($tenant->domains()->where('is_primary', true)->first()?->domain ?? 'Nessuno') . "\n";

// Verifica configurazioni
$tenantsWithSettings = \Modules\Tenant\Models\Tenant::whereNotNull('settings')->count();
echo "Tenant con configurazioni: {$tenantsWithSettings}\n";
```

## Helper Functions

### Generazione features per settore

```php
private function getSectorFeatures(string $sector): array
{
    $features = [
        'medical' => ['appointments', 'reports', 'billing', 'patients', 'doctors'],
        'dental' => ['appointments', 'treatments', 'xrays', 'patients', 'dentists'],
        'pharmacy' => ['inventory', 'prescriptions', 'billing', 'suppliers'],
        'wellness' => ['bookings', 'services', 'memberships', 'trainers'],
    ];

    return $features[$sector] ?? ['basic'];
}
```

### Generazione domini realistici

```php
private function generateRealisticDomain(string $tenantName, string $sector): string
{
    $cleanName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $tenantName));
    $extensions = ['com', 'it', 'org', 'net'];

    return $cleanName . '.' . $sector . '.' . $extensions[array_rand($extensions)];
}
```

## Collegamenti

- [README Modulo Tenant](./readme.md)
- [Multi-Tenancy Architecture](./multi-tenancy.md)
- [Database Schema](./database-schema.md)
- [Testing Guidelines](./testing.md)

---

**
**Versione**: 1.0
**Autore**: Sistema Laraxot
