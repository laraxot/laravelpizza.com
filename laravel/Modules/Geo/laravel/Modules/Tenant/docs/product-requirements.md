# Product Requirements Document (PRD)

## Metadata

| Campo | Valore |
|-------|--------|
| **Version** | 1.0.0 |
| **Status** | Approved |
| **
| **Owner** | Core Team |
| **Module** | Tenant |
| **Repository** | laraxot/module_tenant_fila5 |

---

## 1. Panoramica del Prodotto

### Descrizione Breve
Il modulo Tenant implementa l'architettura **multi-tenant** per l'ecosistema Laraxot. Permette a una singola istanza dell'applicazione di servire organizzazioni multiple con **isolamento dati completo**.

### Visione
Fornire un sistema di multi-tenancy trasparente che:
- Isola i dati tra tenant automaticamente
- Semplifica lo sviluppo per contesti multi-tenant
- Non richiede modifiche al codice dei moduli
- Scala_orizzontalmente

### Target Users
- **SaaS Providers**: applicazioni che servono multiple aziende
- **Admin**: gestione tenant
- **Developer**: integrazione tenant-aware

---

## 2. Problema

### Problema Risolto
Le applicazioni multi-tenant richiedono:
1. **Isolamento dati**: Query automaticamente limitate al tenant
2. **Identificazione tenant**: Determinare quale tenant sta operando
3. **Configurazione**: Ogni tenant ha impostazioni diverse
4. **Resource sharing**: Possibilità di condividere dati tra tenant

Senza un modulo dedicato, ogni modulo deve implementare la logica manualmente → errori e inconsistenza.

### Pain Points Attuali
- Query dimenticate che espongono dati di altri tenant
- Difficoltà nel gestire tenant hierarchies
- Configurazione tenant-fragmented
- Testing di scenari multi-tenant complesso

### Job Stories

| Quando | Voglio | Per |
|--------|--------|-----|
| Amministratore | creare nuovo tenant | dare accesso a nuova organizzazione |
| Utente | vedere solo i miei dati | lavorare nel mio contesto |
| Developer | fare query tenant-aware | non preoccuparmi di filtri |
| Sistema | cambiare tenant utente | impersonare un utente |

---

## 3. Stakeholder

| Ruolo | Responsabilità |
|-------|----------------|
| Product Owner | Feature decisioni |
| Architect | Schema database, caching |
| Developer | Integrazione moduli |

---

## 4. Soluzione Proposta

### Architettura

```
Request
    ↓
Tenant Detection (subdomain, header, user)
    ↓
Tenant Context Set
    ↓
Query Scope Applied (automatic)
    ↓
Response
```

### Strategie Multi-Tenancy

#### 4.1 Tenant by Subdomain
```
tenant1.app.com → tenant_id = 1
tenant2.app.com → tenant_id = 2
```

#### 4.2 Tenant by Header
```
X-Tenant-ID: 1
```

#### 4.3 Tenant by User
```
Utente.logged → tenant_id = user.tenant_id
```

### Funzionalità Core

#### 4.1 Tenant Identification
- [x] Subdomain resolution
- [x] Header-based detection
- [x] User-based fallback
- [x] Custom resolvers

#### 4.2 Tenant Scoping
- [x] Global query scope
- [x] Model trait automatic
- [x] Exclude models (es. settings globali)
- [x] Cross-tenant queries (admin)

#### 4.3 Tenant Management
- [x] CRUD tenant
- [x] Tenant settings
- [x] Domain management
- [x] Tenant switching (super-admin)

#### 4.4 Tenant Isolation
- [x] Database per tenant (opzionale)
- [x] Row-level isolation
- [x] File storage isolation
- [x] Cache per tenant

#### 4.5 Tenant Features
- [x] Feature flags per tenant
- [x] Usage tracking
- [x] Subscription status
- [x] Plan management

### Flussi Utente

#### Flusso: Identificazione Tenant
```
1. Request arriva
2. Sistema verifica subdomain
3. Se non trovato, verifica header X-Tenant-ID
4. Se non trovato, usa tenant dell'utente loggato
5. Imposta Tenant Context
6. Tutte le query automaticamente filtrate
```

---

## 5. Scope

### In Scope
- [x] Identificazione tenant
- [x] Query scoping automatico
- [x] Gestione tenant CRUD
- [x] Isolamento dati
- [x] Feature flags

### Out of Scope
- [ ] Billing/Subscription management
- [ ] White-labeling
- [ ] Multi-region

---

## 6. Metriche di Successo

| KPI | Target |
|-----|--------|
| Data Leakage | 0 occorrenze |
| Query Performance | <+10ms overhead |
| Tenant Switch | <100ms |

---

## 7. Dipendenze

### Interne
| Modulo | Relazione |
|--------|-----------|
| Xot | Dipende |
| User | Dipende (tenant association) |

### Esterne
Nessuna dipendenza esterna core. Opzionali:
- Laravel-cashier (billing)
- Spatie-permission (tenant roles)

---

## 8. Appendici

### Glossario
| Termine | Definizione |
|---------|-------------|
| Tenant | Singola organizzazione/azienda |
| Tenant Context | Variabile globale tenant corrente |
| Row-Level Isolation | Filtro automatico per tenant_id |
| Feature Flag | Toggle funzionalità per tenant |

### Schema Database
```
tenants
├── id
├── name
├── slug
├── domain
├── settings (JSON)
├── is_active
├── plan_id
├── created_by
├── activated_at
├── deactivated_at
└── timestamps

tenant_domains
├── id
├── tenant_id
├── domain
├── is_primary
├── is_verified
└── timestamps

tenant_users
├── id
├── tenant_id
├── user_id
├── role
├── is_owner
└── timestamps

tenant_settings
├── id
├── tenant_id
├── key
├── value
└── timestamps
```

---

## 9. Specifiche Tecniche Dettagliate

### 9.1 Tenant Resolution Priority

```
1. Subdomain matching (tenant.app.com)
   └── lookup tenant_domains table
   
2. Custom domain matching (www.client.com)
   └── lookup tenant_domains table
   
3. Header X-Tenant-ID
   └── validate tenant exists and active
   
4. Header X-Tenant-Slug
   └── lookup by slug
   
5. Authenticated user
   └── user.tenant_id
   
6. Default tenant (config)
   └── fallback for public routes
```

### 9.2 Query Scope Implementation

#### Automatic Scope Trait
```php
trait TenantScope
{
    public static function bootTenantScope()
    {
        static::addGlobalScope(new TenantScope);
    }
    
    public function getTenantKey(): ?int
    {
        return TenantManager::getCurrentId();
    }
}
```

#### Exclude from Tenant Scope
```php
// In model
class GlobalSetting extends Model
{
    protected $table = 'settings';
    
    // Override to skip tenant scope
    public function newQuery()
    {
        return parent::newQuery()->withoutGlobalScope(TenantScope::class);
    }
}
```

### 9.3 Tenant Context API

```php
// Get current tenant
$tenant = tenant();

// Get tenant by ID
$tenant = tenant($id);

// Check if tenant is active
if (tenant()->isActive()) {
    // proceed
}

// Switch tenant (super-admin)
tenant()->switch($tenantId);

// Impersonate tenant user
tenant()->impersonate($userId);
```

### 9.4 Cache Strategy

| Tipo Cache | TTL | Invalidation |
|------------|-----|--------------|
| Tenant config | 1 ora | Settings update |
| Tenant users | 15 min | User changes |
| Domain lookup | 24 ore | Domain changes |
| Feature flags | 5 min | Flag changes |

### 9.5 Eventi

| Evento | Descrizione | Listeners |
|--------|-------------|-----------|
| TenantCreated | Nuovo tenant creato | SendWelcomeEmail, SetupDefaultData |
| TenantActivated | Tenant attivato | LogActivity, NotifyOwner |
| TenantDeactivated | Tenant disattivato | LogActivity, RevokeAccess |
| TenantSettingsUpdated | Impostazioni cambiate | ClearCache, LogActivity |
| DomainAdded | Dominio aggiunto | VerifyDomain, SendDNSInstructions |
| DomainRemoved | Dominio rimosso | ClearCache |

### 9.6 Middleware

```php
// In HTTP Kernel
protected $middlewareAliases = [
    'tenant.resolve' => \Tenant\Http\Middleware\ResolveTenant::class,
    'tenant.required' => \Tenant\Http\Middleware\TenantRequired::class,
    'tenant.guest' => \Tenant\Http\Middleware\TenantGuest::class,
];
```

---

## 10. Sicurezza

### 10.1 Data Isolation

- **Row-level**: WHERE tenant_id = X su TUTTE le query
- **File storage**: tenant_{id}/ prefix su paths
- **Cache**: tenant:{id}: prefix
- **Queue**: tenant_id tag su jobs

### 10.2 Super Admin

- Accesso a TUTTI i tenant
- Require super_admin role
- Audit log di TUTTE le azioni
- Two-factor obbligatorio

### 10.3 Cross-Tenant Prevention

- Query scope NON-removable da utenti normali
- middleware verifica tenant_id su POST/PUT/DELETE
- Database constraints (foreign keys)
- Regular penetration testing

---

## 11. Performance

### 11.1 Benchmarks

| Operazione | Target | Maximum |
|------------|--------|---------|
| Tenant resolution | <5ms | 20ms |
| Tenant switch | <50ms | 100ms |
| Query con scope | <+5ms | +10ms |
| Cache hit | <1ms | 5ms |

### 11.2 Ottimizzazioni

- Domain lookup: DNS + DB cache
- Tenant config: Redis cache
- User list per tenant: eager loading
- Bulk operations: chunking

### 11.3 Scaling

- Read replicas per query tenant
- Queue per operazioni bulk tenant
- CDN per asset tenant-specific

---

## 12. Testing

### 12.1 Test Cases

#### Tenant Resolution
- [ ] Subdomain resolution works
- [ ] Custom domain resolution works
- [ ] Header X-Tenant-ID works
- [ ] User fallback works
- [ ] Invalid tenant returns 404
- [ ] Inactive tenant returns 403

#### Query Scoping
- [ ] All queries are scoped
- [ ] WithoutScope works for admin
- [ ] Cross-tenant queries blocked for normal users
- [ ] Relations are properly scoped

#### Tenant Management
- [ ] CRUD operations work
- [ ] Domain management works
- [ ] Settings are persisted
- [ ] User association works

### 12.2 Fixtures

```php
// In tests/TestCase.php
protected function setUp(): void
{
    parent::setUp();
    
    $this->tenant = Tenant::factory()->create();
    $this->user = User::factory()->for($this->tenant)->create();
    
    $this->actingAs($this->user);
}
```

---

## 13. Criteri di Accettazione

- [ ] Tenant può essere creato via API
- [ ] Subdomain routing funziona
- [ ] Query sono automaticamente scoped
- [ ] Super admin può accedere a tutti i dati
- [ ] Tenant isolation funziona (nessun data leak)
- [ ] Performance overhead <10ms
- [ ] Cache invalidation funziona
- [ ] Eventi vengono dispatchati

---

## 14. Multi-Tenancy Architecture Patterns

### 14.1 Pattern Comparison

| Pattern | Database | Schema | Isolation | Complexity | Performance |
|---------|----------|--------|-----------|------------|-------------|
| Shared Database, Shared Schema | 1 | 1 | tenant_id column | Basso | Eccellente |
| Shared Database, Separate Schema | 1 | N | MySQL schemas | Medio | Buono |
| Separate Database | N | N | database isolation | Alto | Eccellente |

### 14.2 Recommended Pattern: Shared Database

Per la maggior parte dei casi si raccomanda **Shared Database, Shared Schema**:
- Più semplice da gestire
- Meno costoso (un database)
- Performance migliore
- Backup/restore semplificato

### 14.3 When to Use Separate Databases

- Requisiti legali di isolamento dati
- Tenant con requisiti di compliance diversi
- Necessità di scaling indipendente
- Disaster recovery per singolo tenant

---

## 15. Advanced Tenant Isolation

### 15.1 Query Scope Deep Dive

#### Global Scope Implementation
```php
// app/Scopes/TenantScope.php
class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $tenantId = app(TenantManager::class)->getCurrentId();
        
        if ($tenantId !== null && !$builder->withoutGlobalScopes()) {
            $builder->where($model->getTable() . '.tenant_id', $tenantId);
        }
    }
}
```

#### Trait for Automatic Application
```php
trait TenantScopeTrait
{
    public static function bootTenantScopeTrait(): void
    {
        static::addGlobalScope(new TenantScope);
    }
    
    public function getTenantKey(): ?int
    {
        return $this->tenant_id ?? app(TenantManager::class)->getCurrentId();
    }
    
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
```

### 15.2 Protection Layers

| Layer | Protection | Bypass |
|-------|-----------|--------|
| Application | Query scoping | onlyGlobalScope() |
| Database | FK constraints | None (required) |
| Middleware | Request validation | None (required) |
| API | Authorization | Admin only |

#### Database Constraints
```php
// Migration
$table->foreignId('tenant_id')
    ->constrained('tenants')
    ->onDelete('restrict')
    ->onUpdate('cascade');

// Partial unique index for scoped uniqueness
$table->unique(['tenant_id', 'email'], 'tenant_email_unique');
```

### 15.3 File Storage Isolation

```
// storage/app/{tenant_id}/
//     ├── documents/
//     ├── avatars/
//     └── imports/
```

#### Filesystem Configuration
```php
// config/filesystems.php
'disks' => [
    'tenant' => [
        'driver' => 'local',
        'root' => storage_path('app/' . tenant('id', 'public')),
    ],
],
```

---

## 16. Tenant Data Migration

### 16.1 Bulk Data Migration

```php
// Migration command per spostare dati a nuovo tenant
class MigrateDataToTenant
{
    public function handle(int $oldTenantId, int $newTenantId): int
    {
        $models = [
            User::class,
            Document::class,
            Setting::class,
        ];
        
        $migrated = 0;
        
        foreach ($models as $model) {
            $count = $model::where('tenant_id', $oldTenantId)
                ->update(['tenant_id' => $newTenantId]);
                
            $migrated += $count;
        }
        
        event(new DataMigrated($oldTenantId, $newTenantId, $migrated));
        
        return $migrated;
    }
}
```

### 16.2 Tenant Export/Import

#### Export
```php
class TenantExporter
{
    public function export(int $tenantId): string
    {
        $tenant = Tenant::findOrFail($tenantId);
        
        $zip = new ZipArchive();
        $filename = "tenant_{$tenantId}_export_" . now()->format('YmdHis') . '.zip';
        
        $zip->open(storage_path($filename), ZipArchive::CREATE);
        
        // Export users
        $users = User::where('tenant_id', $tenantId)->get();
        $zip->addFromString('users.json', $users->toJson(JSON_PRETTY_PRINT));
        
        // Export documents
        foreach (Document::where('tenant_id', $tenantId)->cursor() as $doc) {
            $path = storage_path("app/{$tenantId}/documents/{$doc->filename}");
            if (file_exists($path)) {
                $zip->addFile($path, "documents/{$doc->filename}");
            }
        }
        
        $zip->close();
        
        return $filename;
    }
}
```

#### Import
```php
class TenantImporter
{
    public function import(string $filename, int $targetTenantId): array
    {
        $zip = new ZipArchive();
        $zip->open($filename);
        
        $results = ['users' => 0, 'documents' => 0, 'errors' => []];
        
        // Import users
        $usersJson = $zip->getFromName('users.json');
        if ($usersJson) {
            $users = json_decode($usersJson, true);
            
            foreach ($users as $userData) {
                try {
                    $userData['tenant_id'] = $targetTenantId;
                    $userData['id'] = null; // New ID
                    
                    User::create($userData);
                    $results['users']++;
                } catch (\Exception $e) {
                    $results['errors'][] = "User import failed: " . $e->getMessage();
                }
            }
        }
        
        // Extract documents
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $name = $zip->getNameIndex($i);
            if (str_starts_with($name, 'documents/')) {
                $content = $zip->getFromIndex($i);
                Storage::put("app/{$targetTenantId}/{$name}", $content);
                $results['documents']++;
            }
        }
        
        $zip->close();
        
        return $results;
    }
}
```

---

## 17. Cross-Tenant Collaboration

### 17.1 Shared Resources Pattern

Alcuni dati possono essere condivisi tra tenant:
- Template di documenti (read-only)
- Categorie standard
- Lookup tables

```php
// Model per risorse condivise
class SharedCategory extends Model
{
    use \Modules\Tenant\Traits\TenantScopeTrait;
    
    protected $table = 'shared_categories';
    
    // Override per renderlo sempre disponibile
    public function newQuery()
    {
        return parent::newQuery()->withoutGlobalScope(TenantScope::class);
    }
}
```

### 17.2 Tenant-to-Tenant Data Sharing

```php
// Sharing configuration
class TenantShare extends Model
{
    public function sourceTenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'source_tenant_id');
    }
    
    public function targetTenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'target_tenant_id');
    }
    
    public function scopeAccessibleFor(Builder $query, int $tenantId): Builder
    {
        return $query->where(function ($q) use ($tenantId) {
            $q->where('source_tenant_id', $tenantId)
              ->orWhere('target_tenant_id', $tenantId);
        });
    }
}
```

---

## 18. Tenant Billing e Subscription

### 18.1 Subscription Plans

| Plan | Users | Storage | Features | Price |
|------|-------|---------|----------|-------|
| Starter | 10 | 1GB | Basic | €29/mo |
| Professional | 50 | 10GB | Advanced | €99/mo |
| Business | 200 | 100GB | Full | €299/mo |
| Enterprise | Unlimited | Unlimited | All + Support | Custom |

### 18.2 Usage Tracking

```php
class TenantUsage extends Model
{
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
    
    public function recordUsage(string $type, int $amount): void
    {
        $this->$type += $amount;
        $this->save();
        
        if ($this->isOverLimit($type)) {
            event(new UsageLimitExceeded($this->tenant, $type));
        }
    }
}
```

### 18.3 Plan Enforcement

```php
// Middleware per enforcement
class CheckPlanLimits
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = tenant();
        
        if (!$tenant->subscription?->canUseFeature('api_access')) {
            return response()->json([
                'error' => 'API access not included in your plan'
            ], 403);
        }
        
        if ($tenant->usage->api_calls >= $tenant->subscription->plan->api_limit) {
            return response()->json([
                'error' => 'API limit exceeded'
            ], 429);
        }
        
        return $next($request);
    }
}
```

---

## 19. Tenant Analytics e Reporting

### 19.1 Metrics Collection

```php
class TenantMetrics
{
    public function collect(Tenant $tenant): array
    {
        return [
            'users' => [
                'total' => $tenant->users()->count(),
                'active' => $tenant->users()->active()->count(),
                'inactive' => $tenant->users()->whereNotNull('deactivated_at')->count(),
            ],
            'storage' => [
                'used' => $this->calculateStorageUsage($tenant),
                'limit' => $tenant->subscription?->plan->storage_limit ?? 0,
            ],
            'api' => [
                'calls_today' => $tenant->apiCalls()->today()->count(),
                'calls_this_month' => $tenant->apiCalls()->thisMonth()->count(),
            ],
            'activity' => [
                'last_login' => $tenant->users()->max('last_login_at'),
                'actions_this_week' => $tenant->activities()->thisWeek()->count(),
            ],
        ];
    }
}
```

### 19.2 Dashboard Data

| Widget | Dati | Refresh |
|--------|------|---------|
| User count | Totale, attivi, nuovi oggi | Real-time |
| Storage usage | GB usati, limite, % | 1 ora |
| API calls | Oggi, questa settimana, trend | 5 min |
| Activity | Ultime 10 azioni | Real-time |
| Usage chart | Ultimi 30 giorni | 1 ora |

---

## 20. Tenant Security Hardening

### 20.1 IP Allowlisting

```php
class TenantIPAllowlist extends Model
{
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
    
    public function allows(string $ip): bool
    {
        if ($this->ips === '*') {
            return true;
        }
        
        $allowed = explode(',', $this->ips);
        
        foreach ($allowed as $range) {
            if ($this->ipInRange($ip, trim($range))) {
                return true;
            }
        }
        
        return false;
    }
}
```

### 20.2 SSO Enforcement

```php
// Configurazione per tenant che richiedono SSO
class TenantSSOSettings extends Model
{
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
    
    public function enforceFor(Request $request): bool
    {
        if (!$this->enabled) {
            return false; // Allow regular login
        }
        
        if (!$request->user()?->hasTenantAccess($this->tenant)) {
            return true; // Force SSO
        }
        
        return false;
    }
}
```

---

## 21. Disaster Recovery per Tenant

### 21.1 Tenant-Specific Backup

```php
class TenantBackup
{
    public function create(Tenant $tenant): string
    {
        $backupId = Str::uuid();
        
        // Database dump
        $dbFile = $this->backupDatabase($tenant);
        
        // File storage
        $filesFile = $this->backupFiles($tenant);
        
        // Config
        $configFile = $this->backupConfig($tenant);
        
        // Create manifest
        $manifest = [
            'backup_id' => $backupId,
            'tenant_id' => $tenant->id,
            'created_at' => now(),
            'files' => [
                'database' => $dbFile,
                'files' => $filesFile,
                'config' => $configFile,
            ],
        ];
        
        Storage::put("backups/{$backupId}/manifest.json", json_encode($manifest));
        
        return $backupId;
    }
    
    public function restore(string $backupId): void
    {
        $manifest = json_decode(
            Storage::get("backups/{$backupId}/manifest.json")
        );
        
        $this->restoreDatabase($manifest->files->database);
        $this->restoreFiles($manifest->files->files);
        $this->restoreConfig($manifest->files->config);
    }
}
```

### 21.2 Point-in-Time Recovery

Per tenant che necessitano di PITR:
- Binlog retention: 7 giorni
- Backup frequency: ogni ora
- Recovery SLA: 4 ore

---

## 22. Changelog
