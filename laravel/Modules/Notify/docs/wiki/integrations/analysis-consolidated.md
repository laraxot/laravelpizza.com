---
qmd: "analysis consolidated"
issues: []
discussions: []
title: "analysis: Consolidated Documentation"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# analysis: Consolidated Documentation

Consolidated from **29** individual files.

## Table of Contents

- [Analisi Completa del Modulo Notify](#analysis-completa)
- [](#analysis-complete)
- [---](#analysis-detailed-1)
- [](#analysis-detailed-3)
- [](#analysis-detailed-4)
- [](#analysis-detailed-5)
- [](#analysis-detailed-6)
- [](#analysis-detailed-7)
- [](#analysis-detailed-8)
- [](#analysis-detailed)
- [Analisi Dettagliata del Modulo Notify - Parte 1: Architettura e Struttura](#analysis-dettagliata-1)
- [Analisi Dettagliata del Modulo Notify - Parte 2: Modelli e Relazioni](#analysis-dettagliata-2)
- [Analisi Dettagliata del Modulo Notify - Parte 3: Servizi Core](#analysis-dettagliata-3)
- [Analisi Dettagliata del Modulo Notify - Parte 4: Integrazione con Filament](#analysis-dettagliata-4)
- [Analisi Dettagliata del Modulo Notify - Parte 5: Testing](#analysis-dettagliata-5)
- [Analisi Dettagliata del Modulo Notify - Parte 6: Monitoraggio e Analytics](#analysis-dettagliata-6)
- [Analisi Dettagliata del Modulo Notify - Parte 7: Manutenzione e Backup](#analysis-dettagliata-7)
- [Analisi Dettagliata del Modulo Notify - Parte 8: Note Finali](#analysis-dettagliata-8)
- [Analisi Dettagliata del Modulo Notify](#analysis-dettagliata)
- [Analisi e Miglioramenti del Modulo Notify](#analysis-improvements)
- [Notify Module Analysis](#analysis)
- [Analisi Dettagliata del Modulo Notify - Parte 2: Modelli e Relazioni](#analysisettagliata-2)
- [Analisi Dettagliata del Modulo Notify - Parte 3: Servizi Core](#analysisettagliata-3)
- [Analisi Dettagliata del Modulo Notify - Parte 4: Integrazione con Filament](#analysisettagliata-4)
- [Analisi Dettagliata del Modulo Notify - Parte 5: Testing](#analysisettagliata-5)
- [Analisi Dettagliata del Modulo Notify - Parte 6: Monitoraggio e Analytics](#analysisettagliata-6)
- [Analisi Dettagliata del Modulo Notify - Parte 7: Manutenzione e Backup](#analysisettagliata-7)
- [Analisi Dettagliata del Modulo Notify - Parte 8: Note Finali](#analysisettagliata-8)
- [Analisi Dettagliata del Modulo Notify](#analysisettagliata)

---

## analysis-completa

*Consolidated from: `analysis-completa.md`*


## Indice
1. [Architettura e Struttura](#1-architettura-e-struttura)
2. [Modelli e Relazioni](#2-modelli-e-relazioni)
3. [Servizi Core](#3-servizi-core)
4. [Integrazione con Filament](#4-integrazione-con-filament)
5. [Testing](#5-testing)
6. [Monitoraggio e Analytics](#6-monitoraggio-e-analytics)
7. [Manutenzione e Backup](#7-manutenzione-e-backup)
8. [Note Finali](#8-note-finali)

## 1. Architettura e Struttura

### 1.1 Panoramica
Il modulo Notify è progettato seguendo i principi di:
- Domain-Driven Design (DDD)
- Clean Architecture
- SOLID Principles
- Service-Oriented Architecture (SOA)

### 1.2 Struttura delle Directory
```
Modules/Notify/
├── app/                    # Logica applicativa
│   ├── Console/           # Comandi CLI
│   ├── Http/              # Controllers, Requests, Resources
│   ├── Models/            # Modelli Eloquent
│   ├── Services/          # Servizi business logic
│   └── Filament/          # UI Admin
├── config/                # Configurazioni
├── database/              # Migrations e Seeders
├── resources/             # Views e assets
└── tests/                 # Unit e Feature tests
```

### 1.3 Componenti Principali
1. **Template Engine**
   - Gestione template email
   - Supporto MJML
   - Versioning
   - Traduzioni

2. **Email Service**
   - Integrazione Mailgun
   - Gestione code
   - Tracking eventi
   - Analytics

3. **Admin Interface**
   - Dashboard Filament
   - CRUD operazioni
   - Preview template
   - Test invio

### 1.4 Dipendenze
```json
{
    "require": {
        "spatie/laravel-mail-templates": "^1.0",
        "mjml/mjml-php": "^1.0",
        "mailgun/mailgun-php": "^3.0",
        "filament/filament": "^4.0"
    }
}
```

### 1.5 Configurazione
```php
return [
    'defaults' => [
        'layout' => 'notify::layouts.default',
        'from' => [
            'address' => env('MAIL_FROM_ADDRESS'),
            'name' => env('MAIL_FROM_NAME')
        ]
    ],
    'mjml' => [
        'app_id' => env('MJML_APP_ID'),
        'secret_key' => env('MJML_SECRET_KEY'),
        'options' => [
            'minify' => true,
            'beautify' => false
        ]
    ],
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'tracking' => [
            'opens' => true,
            'clicks' => true
        ]
    ],
    'analytics' => [
        'enabled' => true,
        'retention' => 90 // giorni
    ]
];
```

## 2. Modelli e Relazioni

### 2.1 Template
- Gestione template email
- Versioning integrato
- Supporto traduzioni
- Analytics tracking

```php
class Template extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'subject',
        'content',
        'layout',
        'is_active',
        'version'
    ];

    // Relazioni
    public function versions() {...}
    public function translations() {...}
    public function analytics() {...}
}
```

### 2.2 TemplateVersion
- Storico versioni
- Diff tra versioni
- Note di modifica
- Rollback

### 2.3 TemplateTranslation
- Traduzioni multiple
- Validazione variabili
- Override soggetto/mittente
- Gestione locale

### 2.4 TemplateAnalytics
- Tracking eventi
- Metriche invio
- Statistiche aperture/click
- Gestione bounce

## 3. Servizi Core

### 3.1 TemplateService
- CRUD operazioni
- Gestione versioni
- Preview e test
- Validazione

### 3.2 MjmlService
- Compilazione MJML
- Validazione markup
- Estrazione stili
- Caching

### 3.3 MailgunService
- Invio email
- Gestione webhook
- Tracking eventi
- Logging

## 4. Integrazione con Filament

### 4.1 TemplateResource
- Form builder
- Table builder
- Azioni personalizzate
- Widgets

### 4.2 RelationManagers
- Gestione versioni
- Gestione traduzioni
- Gestione analytics
- Preview/test

### 4.3 Widgets
- Statistiche template
- Grafici analytics
- Overview stato
- Metriche invio

## 5. Testing

### 5.1 Unit Tests
- Models
- Services
- Helpers
- Validazione

### 5.2 Feature Tests
- Controllers
- API endpoints
- Webhooks
- UI/UX

### 5.3 Test Data
- Factories
- Seeders
- Fixtures
- Mocks

## 6. Monitoraggio e Analytics

### 6.1 Logging
- Eventi template
- Invii email
- Errori/warning
- Audit trail

### 6.2 Analytics
- Metriche invio
- Statistiche aperture
- Tracking click
- Report

### 6.3 Monitoring
- Health checks
- Performance
- Errori
- Queue

## 7. Manutenzione e Backup

### 7.1 Versioning
- Gestione versioni
- Diff
- Rollback
- Audit

### 7.2 Backup
- Backup automatici
- Retention policy
- Restore
- Verifica integrità

### 7.3 Manutenzione
- Pulizia cache
- Ottimizzazione DB
- Compressione
- Validazione

## 8. Note Finali

### 8.1 Best Practices
- Documentazione
- Testing
- Security
- Performance

### 8.2 Raccomandazioni
- Architettura
- Database
- Cache
- API

### 8.3 Considerazioni Future
- Scalabilità
- Manutenibilità
- Sicurezza
- Feature

### 8.4 Riferimenti
- Documentazione
- Package
- Tools
- Best Practices 

---

## analysis-complete

*Consolidated from: `analysis-complete.md`*


---

## analysis-detailed-1

*Consolidated from: `analysis-detailed.md`*

title: "Analysis Detailed 1"
type: concept
tags: [analysis, detailed]
created: 2026-07-14
updated: 2026-07-14
qmd: "analysis-detailed-1 analysis detailed 1"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---



---

## analysis-detailed-3

*Consolidated from: `analysis-detailed.md`*


---

## analysis-detailed-4

*Consolidated from: `analysis-detailed.md`*


---

## analysis-detailed-5

*Consolidated from: `analysis-detailed.md`*


---

## analysis-detailed-6

*Consolidated from: `analysis-detailed.md`*


---

## analysis-detailed-7

*Consolidated from: `analysis-detailed.md`*


---

## analysis-detailed-8

*Consolidated from: `analysis-detailed.md`*


---

## analysis-detailed

*Consolidated from: `analysis-detailed.md`*


---

## analysis-dettagliata-1

*Consolidated from: `analysis-dettagliata-architettura-struttura.md`*


## 1. Architettura del Sistema

### 1.1 Struttura del Modulo
Il modulo Notify è organizzato seguendo i principi di Domain-Driven Design (DDD) e Clean Architecture. La struttura è stata progettata per garantire:
- Separazione delle responsabilità
- Facilità di manutenzione
- Scalabilità
- Testabilità
- Riutilizzo del codice

#### 1.1.1 Directory Structure
```
Modules/Notify/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       ├── BackupTemplates.php      # Gestione backup automatici
│   │       └── CleanupTemplates.php     # Pulizia template obsoleti
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── TemplateController.php   # CRUD template
│   │   │   │   └── PreviewController.php    # Anteprima template
│   │   │   ├── Requests/
│   │   │   │   ├── StoreTemplateRequest.php # Validazione creazione
│   │   │   │   └── UpdateTemplateRequest.php # Validazione aggiornamento
│   │   │   └── Resources/
│   │   │       └── TemplateResource.php     # API Resource
│   ├── Models/
│   │   ├── Template.php                # Template principale
│   │   ├── TemplateVersion.php         # Versioni template
│   │   └── TemplateTranslation.php     # Traduzioni template
│   ├── Services/
│   │   ├── TemplateService.php         # Logica business template
│   │   ├── MjmlService.php            # Compilazione MJML
│   │   ├── MailgunService.php         # Integrazione Mailgun
│   │   └── AnalyticsService.php       # Analisi e metriche
│   └── Filament/
│       └── Resources/
│           └── TemplateResource.php    # UI Admin
├── database/
│   └── migrations/
│       ├── create_templates_table.php
│       ├── create_template_versions_table.php
│       └── create_template_translations_table.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── default.blade.php       # Layout standard
│       │   └── responsive.blade.php    # Layout responsive
│       ├── components/
│       │   ├── header.blade.php        # Header template
│       │   └── footer.blade.php        # Footer template
│       └── templates/
│           └── preview.blade.php       # Vista anteprima
└── tests/
    ├── Unit/
    │   ├── TemplateTest.php           # Test unitari template
    │   └── ServicesTest.php           # Test unitari servizi
    └── Feature/
        └── TemplateControllerTest.php  # Test feature
```

### 1.2 Dipendenze Principali

#### 1.2.1 Pacchetti Core
```json
{
    "require": {
        "spatie/laravel-mail-templates": "^1.0",  // Gestione template email
        "mjml/mjml-php": "^1.0",                 // Compilazione MJML
        "mailgun/mailgun-php": "^3.0",           // Integrazione Mailgun
        "filament/filament": "^4.0",             // UI Admin
        "filament/filament": "^2.0",             // UI Admin
        "spatie/laravel-permission": "^5.0",     // Gestione permessi
        "spatie/laravel-backup": "^6.0"          // Backup automatici
    }
}
```

#### 1.2.2 Dipendenze di Sviluppo
```json
{
    "require-dev": {
        "phpunit/phpunit": "^9.0",              // Testing
        "fakerphp/faker": "^1.0",               // Generazione dati test
        "mockery/mockery": "^1.0",              // Mocking
        "barryvdh/laravel-debugbar": "^3.0",    // Debug
        "nunomaduro/collision": "^6.0"          // Gestione errori
    }
}
```

### 1.3 Configurazione Dettagliata

#### 1.3.1 Configurazione Base
```php
// config/notify.php
return [
    'defaults' => [
        'layout' => 'notify::layouts.default',
        'from' => [
            'address' => env('MAIL_FROM_ADDRESS', 'noreply@example.com'),
            'name' => env('MAIL_FROM_NAME', 'Example')
        ]
    ],
    'cache' => [
        'enabled' => true,
        'ttl' => 3600,                          // 1 ora
        'tags' => ['templates'],
        'driver' => env('CACHE_DRIVER', 'redis')
    ],
    'mjml' => [
        'app_id' => env('MJML_APP_ID'),
        'secret_key' => env('MJML_SECRET_KEY'),
        'options' => [
            'minify' => true,                   // Minificazione HTML
            'beautify' => false,                // Formattazione HTML
            'validationLevel' => 'strict',      // Validazione MJML
            'fonts' => [                        // Font personalizzati
                'Roboto' => 'https://fonts.googleapis.com/css?family=Roboto',
                'Open Sans' => 'https://fonts.googleapis.com/css?family=Open+Sans'
            ]
        ]
    ],
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'tracking' => [
            'opens' => true,                    // Tracciamento aperture
            'clicks' => true,                   // Tracciamento click
            'unsubscribes' => true,             // Tracciamento cancellazioni
            'complaints' => true                // Tracciamento reclami
        ],
        'webhooks' => [                         // Webhook configurabili
            'opens' => '/webhooks/mailgun/opens',
            'clicks' => '/webhooks/mailgun/clicks',
            'bounces' => '/webhooks/mailgun/bounces',
            'complaints' => '/webhooks/mailgun/complaints'
        ]
    ],
    'analytics' => [
        'enabled' => true,
        'storage' => 'database',                // Storage analytics
        'retention' => 90,                      // Giorni di retention
        'aggregation' => [                      // Aggregazione dati
            'daily' => true,
            'weekly' => true,
            'monthly' => true
        ],
        'metrics' => [                          // Metriche tracciate
            'sends',
            'opens',
            'clicks',
            'bounces',
            'complaints',
            'unsubscribes'
        ]
    ],
    'security' => [
        'rate_limiting' => [                    // Rate limiting
            'enabled' => true,
            'max_attempts' => 60,
            'decay_minutes' => 1
        ],
        'sanitization' => [                     // Sanitizzazione input
            'enabled' => true,
            'strip_tags' => true,
            'escape_html' => true
        ],
        'validation' => [                       // Validazione
            'enabled' => true,
            'strict_mode' => true
        ]
    ],
    'performance' => [
        'queue' => [                            // Configurazione code
            'enabled' => true,
            'connection' => 'redis',
            'queue' => 'emails'
        ],
        'caching' => [                          // Configurazione cache
            'enabled' => true,
            'driver' => 'redis',
            'ttl' => 3600
        ],
        'optimization' => [                     // Ottimizzazioni
            'minify_html' => true,
            'compress_images' => true,
            'lazy_loading' => true
        ]
    ]
];
```

### 1.4 Pattern Architetturali

#### 1.4.1 Repository Pattern
Il modulo utilizza il Repository Pattern per l'accesso ai dati, garantendo:
- Astrazione del layer di persistenza
- Riutilizzo del codice
- Testabilità
- Manutenibilità

```php
namespace Modules\Notify\Repositories;

interface TemplateRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function findBySlug($slug);
    public function getActive();
    public function getLatest();
}

class TemplateRepository implements TemplateRepositoryInterface
{
    protected $model;

    public function __construct(Template $model)
    {
        $this->model = $model;
    }

    // Implementazione metodi...
}
```

#### 1.4.2 Service Layer Pattern
Il Service Layer Pattern è utilizzato per:
- Incapsulare la logica di business
- Gestire le transazioni
- Coordinare le operazioni tra repository
- Implementare la logica di validazione

```php
namespace Modules\Notify\Services;

class TemplateService
{
    protected $repository;
    protected $validator;
    protected $logger;

    public function __construct(
        TemplateRepositoryInterface $repository,
        TemplateValidator $validator,
        TemplateLogger $logger
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    // Implementazione metodi...
}
```

#### 1.4.3 Factory Pattern
Il Factory Pattern è utilizzato per:
- Creare istanze di template
- Gestire la creazione di versioni
- Gestire la creazione di traduzioni

```php
namespace Modules\Notify\Factories;

class TemplateFactory
{
    protected $model;
    protected $versionFactory;
    protected $translationFactory;

    public function __construct(
        Template $model,
        TemplateVersionFactory $versionFactory,
        TemplateTranslationFactory $translationFactory
    ) {
        $this->model = $model;
        $this->versionFactory = $versionFactory;
        $this->translationFactory = $translationFactory;
    }

    // Implementazione metodi...
}
```

### 1.5 Gestione delle Dipendenze

#### 1.5.1 Service Provider
```php
namespace Modules\Notify\Providers;

class NotifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(TemplateRepositoryInterface::class, TemplateRepository::class);
        $this->app->bind(TemplateServiceInterface::class, TemplateService::class);
        $this->app->bind(TemplateFactoryInterface::class, TemplateFactory::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(module_path('Notify', 'database/migrations'));
        $this->loadRoutesFrom(module_path('Notify', 'routes/web.php'));
        $this->loadViewsFrom(module_path('Notify', 'resources/views'), 'notify');
    }
}
```

#### 1.5.2 Dependency Injection
```php
namespace Modules\Notify\Providers;

class NotifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(TemplateCache::class, function ($app) {
            return new TemplateCache(
                $app['cache.store'],
                config('notify.cache.ttl')
            );
        });

        $this->app->singleton(MjmlService::class, function ($app) {
            return new MjmlService(
                $app[TemplateCache::class],
                $app[TemplateLogger::class]
            );
        });

        $this->app->singleton(MailgunService::class, function ($app) {
            return new MailgunService(
                $app[AnalyticsService::class],
                $app[TemplateLogger::class]
            );
        });
    }
}
```

### 1.6 Gestione degli Eventi

#### 1.6.1 Eventi
```php
namespace Modules\Notify\Events;

class TemplateCreated
{
    public $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }
}

class TemplateUpdated
{
    public $template;
    public $changes;

    public function __construct(Template $template, array $changes)
    {
        $this->template = $template;
        $this->changes = $changes;
    }
}

class TemplateDeleted
{
    public $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }
}
```

#### 1.6.2 Listener
```php
namespace Modules\Notify\Listeners;

class LogTemplateActivity
{
    protected $logger;

    public function __construct(TemplateLogger $logger)
    {
        $this->logger = $logger;
    }

    public function handle($event)
    {
        if ($event instanceof TemplateCreated) {
            $this->logger->log('template.created', [
                'template_id' => $event->template->id
            ]);
        } elseif ($event instanceof TemplateUpdated) {
            $this->logger->log('template.updated', [
                'template_id' => $event->template->id,
                'changes' => $event->changes
            ]);
        } elseif ($event instanceof TemplateDeleted) {
            $this->logger->log('template.deleted', [
                'template_id' => $event->template->id
            ]);
        }
    }
}
```

### 1.7 Gestione delle Code

#### 1.7.1 Job
```php
namespace Modules\Notify\Jobs;

class SendTemplateEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $template;
    protected $data;

    public function __construct(Template $template, array $data)
    {
        $this->template = $template;
        $this->data = $data;
    }

    public function handle(MailgunService $mailgun)
    {
        $mailgun->send($this->template, $this->data);
    }

    public function failed(\Throwable $exception)
    {
        Log::error('Failed to send template email', [
            'template_id' => $this->template->id,
            'error' => $exception->getMessage()
        ]);
    }
}
```

#### 1.7.2 Queue Configuration
```php
// config/queue.php
return [
    'connections' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => 'emails',
            'retry_after' => 90,
            'block_for' => null,
        ],
    ],
];
```

### 1.8 Gestione della Cache

#### 1.8.1 Cache Service
```php
namespace Modules\Notify\Services;

class TemplateCache
{
    protected $cache;
    protected $ttl;

    public function __construct($cache, $ttl)
    {
        $this->cache = $cache;
        $this->ttl = $ttl;
    }

    public function remember($key, $callback)
    {
        return $this->cache->tags(['templates'])->remember($key, $this->ttl, $callback);
    }

    public function forget($key)
    {
        return $this->cache->tags(['templates'])->forget($key);
    }

    public function flush()
    {
        return $this->cache->tags(['templates'])->flush();
    }
}
```

#### 1.8.2 Cache Configuration
```php
// config/cache.php
return [
    'stores' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'cache',
            'lock_connection' => 'default',
        ],
    ],
];
``` 

---

## analysis-dettagliata-2

*Consolidated from: `analysis-dettagliata-modelli-relazioni.md`*


## 2. Modelli e Relazioni

### 2.1 Template Model

#### 2.1.1 Struttura Base
```php
namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Template extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'templates';

    protected $fillable = [
        'name',              // Nome del template
        'subject',           // Oggetto email
        'content',           // Contenuto template
        'layout',            // Layout utilizzato
        'is_active',         // Stato attivo/inattivo
        'version',           // Versione corrente
        'from_name',         // Nome mittente
        'from_email',        // Email mittente
        'reply_to',          // Email risposta
        'cc',                // Copie conoscenza
        'bcc',               // Copie nascoste
        'attachments',       // Allegati
        'variables',         // Variabili template
        'settings'           // Impostazioni
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'version' => 'integer',
        'attachments' => 'array',
        'variables' => 'array',
        'settings' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'full_name',
        'status_label',
        'is_latest',
        'has_translations'
    ];
}
```

#### 2.1.2 Relazioni
```php
public function versions()
{
    return $this->hasMany(TemplateVersion::class);
}

public function translations()
{
    return $this->hasMany(TemplateTranslation::class);
}

public function analytics()
{
    return $this->hasMany(TemplateAnalytics::class);
}

public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}

public function updater()
{
    return $this->belongsTo(User::class, 'updated_by');
}

public function latestVersion()
{
    return $this->hasOne(TemplateVersion::class)->latest();
}

public function defaultTranslation()
{
    return $this->hasOne(TemplateTranslation::class)
        ->where('locale', config('app.locale'));
}
```

#### 2.1.3 Accessori e Mutatori
```php
public function getFullNameAttribute()
{
    return "{$this->name} (v{$this->version})";
}

public function getStatusLabelAttribute()
{
    return $this->is_active ? 'Active' : 'Inactive';
}

public function getIsLatestAttribute()
{
    return $this->version === $this->versions()->max('version');
}

public function getHasTranslationsAttribute()
{
    return $this->translations()->count() > 0;
}

public function setVariablesAttribute($value)
{
    $this->attributes['variables'] = json_encode($value);
}

public function getVariablesAttribute($value)
{
    return json_decode($value, true);
}

public function setSettingsAttribute($value)
{
    $this->attributes['settings'] = json_encode($value);
}

public function getSettingsAttribute($value)
{
    return json_decode($value, true);
}
```

#### 2.1.4 Scope Query
```php
public function scopeActive($query)
{
    return $query->where('is_active', true);
}

public function scopeInactive($query)
{
    return $query->where('is_active', false);
}

public function scopeLatest($query)
{
    return $query->orderBy('version', 'desc');
}

public function scopeByLayout($query, $layout)
{
    return $query->where('layout', $layout);
}

public function scopeSearch($query, $term)
{
    return $query->where(function($q) use ($term) {
        $q->where('name', 'like', "%{$term}%")
          ->orWhere('subject', 'like', "%{$term}%")
          ->orWhere('content', 'like', "%{$term}%");
    });
}
```

#### 2.1.5 Eventi del Modello
```php
protected static function booted()
{
    static::creating(function ($template) {
        $template->created_by = auth()->id();
        $template->version = 1;
    });

    static::updating(function ($template) {
        $template->updated_by = auth()->id();
    });

    static::deleting(function ($template) {
        $template->versions()->delete();
        $template->translations()->delete();
        $template->analytics()->delete();
    });

    static::restored(function ($template) {
        $template->versions()->restore();
        $template->translations()->restore();
    });
}
```

### 2.2 TemplateVersion Model

#### 2.2.1 Struttura Base
```php
namespace Modules\Notify\Models;

class TemplateVersion extends Model
{
    use HasFactory;

    protected $table = 'template_versions';

    protected $fillable = [
        'template_id',
        'version',
        'content',
        'created_by',
        'changes',
        'status',
        'notes'
    ];

    protected $casts = [
        'version' => 'integer',
        'changes' => 'array',
        'status' => 'string',
        'created_at' => 'datetime'
    ];

    protected $appends = [
        'diff',
        'creator_name'
    ];
}
```

#### 2.2.2 Relazioni
```php
public function template()
{
    return $this->belongsTo(Template::class);
}

public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}

public function previousVersion()
{
    return $this->template->versions()
        ->where('version', '<', $this->version)
        ->latest('version')
        ->first();
}
```

#### 2.2.3 Accessori e Mutatori
```php
public function getDiffAttribute()
{
    if (!$this->previousVersion) {
        return null;
    }

    return $this->compareVersions(
        $this->previousVersion->content,
        $this->content
    );
}

public function getCreatorNameAttribute()
{
    return $this->creator ? $this->creator->name : 'System';
}

public function setChangesAttribute($value)
{
    $this->attributes['changes'] = json_encode($value);
}

public function getChangesAttribute($value)
{
    return json_decode($value, true);
}
```

#### 2.2.4 Metodi di Confronto
```php
protected function compareVersions($old, $new)
{
    return [
        'added' => $this->getAddedLines($old, $new),
        'removed' => $this->getRemovedLines($old, $new),
        'modified' => $this->getModifiedLines($old, $new)
    ];
}

protected function getAddedLines($old, $new)
{
    $oldLines = explode("\n", $old);
    $newLines = explode("\n", $new);
    return array_diff($newLines, $oldLines);
}

protected function getRemovedLines($old, $new)
{
    $oldLines = explode("\n", $old);
    $newLines = explode("\n", $new);
    return array_diff($oldLines, $newLines);
}

protected function getModifiedLines($old, $new)
{
    $oldLines = explode("\n", $old);
    $newLines = explode("\n", $new);
    $modified = [];

    foreach ($oldLines as $index => $line) {
        if (isset($newLines[$index]) && $line !== $newLines[$index]) {
            $modified[] = [
                'old' => $line,
                'new' => $newLines[$index]
            ];
        }
    }

    return $modified;
}
```

### 2.3 TemplateTranslation Model

#### 2.3.1 Struttura Base
```php
namespace Modules\Notify\Models;

class TemplateTranslation extends Model
{
    use HasFactory;

    protected $table = 'template_translations';

    protected $fillable = [
        'template_id',
        'locale',
        'content',
        'subject',
        'from_name',
        'variables'
    ];

    protected $casts = [
        'variables' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $appends = [
        'is_complete',
        'missing_variables'
    ];
}
```

#### 2.3.2 Relazioni
```php
public function template()
{
    return $this->belongsTo(Template::class);
}

public function translator()
{
    return $this->belongsTo(User::class, 'translated_by');
}
```

#### 2.3.3 Accessori e Mutatori
```php
public function getIsCompleteAttribute()
{
    return $this->validateVariables();
}

public function getMissingVariablesAttribute()
{
    $required = $this->template->variables;
    $provided = $this->variables ?? [];
    return array_diff($required, array_keys($provided));
}

public function setVariablesAttribute($value)
{
    $this->attributes['variables'] = json_encode($value);
}

public function getVariablesAttribute($value)
{
    return json_decode($value, true);
}
```

#### 2.3.4 Validazione
```php
public function validateVariables()
{
    $required = $this->template->variables;
    $provided = $this->variables ?? [];

    foreach ($required as $variable) {
        if (!isset($provided[$variable])) {
            throw new MissingVariableException(
                "Missing required variable: {$variable}"
            );
        }
    }

    return true;
}

public function validateContent()
{
    // Validazione HTML
    $validator = new HtmlValidator();
    $result = $validator->validate($this->content);

    if (!$result->isValid()) {
        throw new InvalidContentException(
            "Invalid HTML content: " . implode(', ', $result->getErrors())
        );
    }

    return true;
}

public function validateSubject()
{
    if (empty($this->subject)) {
        throw new InvalidSubjectException(
            "Subject cannot be empty"
        );
    }

    if (strlen($this->subject) > 255) {
        throw new InvalidSubjectException(
            "Subject cannot be longer than 255 characters"
        );
    }

    return true;
}
```

### 2.4 TemplateAnalytics Model

#### 2.4.1 Struttura Base
```php
namespace Modules\Notify\Models;

class TemplateAnalytics extends Model
{
    use HasFactory;

    protected $table = 'template_analytics';

    protected $fillable = [
        'template_id',
        'event',
        'metadata',
        'user_agent',
        'ip_address',
        'session_id'
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime'
    ];

    protected $appends = [
        'event_label',
        'formatted_metadata'
    ];
}
```

#### 2.4.2 Relazioni
```php
public function template()
{
    return $this->belongsTo(Template::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
```

#### 2.4.3 Accessori e Mutatori
```php
public function getEventLabelAttribute()
{
    return [
        'email.sent' => 'Email Sent',
        'email.opened' => 'Email Opened',
        'email.clicked' => 'Email Clicked',
        'email.bounced' => 'Email Bounced',
        'email.complained' => 'Email Complained',
        'email.unsubscribed' => 'Email Unsubscribed'
    ][$this->event] ?? $this->event;
}

public function getFormattedMetadataAttribute()
{
    return collect($this->metadata)->map(function ($value, $key) {
        return [
            'key' => $key,
            'value' => $value,
            'type' => gettype($value)
        ];
    })->values();
}

public function setMetadataAttribute($value)
{
    $this->attributes['metadata'] = json_encode($value);
}

public function getMetadataAttribute($value)
{
    return json_decode($value, true);
}
```

#### 2.4.4 Scope Query
```php
public function scopeByEvent($query, $event)
{
    return $query->where('event', $event);
}

public function scopeByDateRange($query, $start, $end)
{
    return $query->whereBetween('created_at', [$start, $end]);
}

public function scopeByTemplate($query, $templateId)
{
    return $query->where('template_id', $templateId);
}

public function scopeByUser($query, $userId)
{
    return $query->where('user_id', $userId);
}
```

### 2.5 Migrations

#### 2.5.1 Templates Table
```php
Schema::create('templates', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('subject');
    $table->text('content');
    $table->string('layout')->default('default');
    $table->boolean('is_active')->default(true);
    $table->integer('version')->default(1);
    $table->string('from_name')->nullable();
    $table->string('from_email')->nullable();
    $table->string('reply_to')->nullable();
    $table->json('cc')->nullable();
    $table->json('bcc')->nullable();
    $table->json('attachments')->nullable();
    $table->json('variables')->nullable();
    $table->json('settings')->nullable();
    $table->foreignId('created_by')->constrained('users');
    $table->foreignId('updated_by')->nullable()->constrained('users');
    $table->timestamps();
    $table->softDeletes();

    $table->index('name');
    $table->index('is_active');
    $table->index('version');
});
```

#### 2.5.2 Template Versions Table
```php
Schema::create('template_versions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained()->onDelete('cascade');
    $table->integer('version');
    $table->text('content');
    $table->foreignId('created_by')->constrained('users');
    $table->json('changes')->nullable();
    $table->string('status')->default('draft');
    $table->text('notes')->nullable();
    $table->timestamps();

    $table->unique(['template_id', 'version']);
    $table->index('status');
});
```

#### 2.5.3 Template Translations Table
```php
Schema::create('template_translations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained()->onDelete('cascade');
    $table->string('locale', 5);
    $table->text('content');
    $table->string('subject');
    $table->string('from_name')->nullable();
    $table->json('variables')->nullable();
    $table->foreignId('translated_by')->constrained('users');
    $table->timestamps();

    $table->unique(['template_id', 'locale']);
    $table->index('locale');
});
```

#### 2.5.4 Template Analytics Table
```php
Schema::create('template_analytics', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained()->onDelete('cascade');
    $table->string('event');
    $table->json('metadata')->nullable();
    $table->string('user_agent')->nullable();
    $table->string('ip_address', 45)->nullable();
    $table->string('session_id')->nullable();
    $table->foreignId('user_id')->nullable()->constrained('users');
    $table->timestamps();

    $table->index('event');
    $table->index('created_at');
    $table->index(['template_id', 'event']);
});
``` 

---

## analysis-dettagliata-3

*Consolidated from: `analysis-dettagliata-servizi-core.md`*


## 3. Servizi Core

### 3.1 TemplateService

#### 3.1.1 Struttura Base
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;
use Modules\Notify\Events\TemplateCreated;
use Modules\Notify\Events\TemplateUpdated;
use Modules\Notify\Events\TemplateDeleted;
use Modules\Notify\Exceptions\TemplateException;

class TemplateService
{
    protected $cache;
    protected $mjml;
    protected $mailgun;

    public function __construct(
        CacheService $cache,
        MjmlService $mjml,
        MailgunService $mailgun
    ) {
        $this->cache = $cache;
        $this->mjml = $mjml;
        $this->mailgun = $mailgun;
    }
}
```

#### 3.1.2 Gestione Template
```php
public function create(array $data): Template
{
    try {
        DB::beginTransaction();

        $template = Template::create([
            'name' => $data['name'],
            'subject' => $data['subject'],
            'content' => $data['content'],
            'layout' => $data['layout'] ?? 'default',
            'from_name' => $data['from_name'] ?? null,
            'from_email' => $data['from_email'] ?? null,
            'reply_to' => $data['reply_to'] ?? null,
            'cc' => $data['cc'] ?? null,
            'bcc' => $data['bcc'] ?? null,
            'attachments' => $data['attachments'] ?? null,
            'variables' => $data['variables'] ?? [],
            'settings' => $data['settings'] ?? []
        ]);

        // Crea versione iniziale
        $template->versions()->create([
            'version' => 1,
            'content' => $data['content'],
            'created_by' => auth()->id(),
            'status' => 'published'
        ]);

        // Crea traduzione default
        $template->translations()->create([
            'locale' => config('app.locale'),
            'content' => $data['content'],
            'subject' => $data['subject'],
            'from_name' => $data['from_name'] ?? null,
            'variables' => $data['variables'] ?? [],
            'translated_by' => auth()->id()
        ]);

        DB::commit();

        event(new TemplateCreated($template));

        return $template;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to create template: {$e->getMessage()}"
        );
    }
}

public function update(Template $template, array $data): Template
{
    try {
        DB::beginTransaction();

        $oldVersion = $template->version;
        $newVersion = $oldVersion + 1;

        // Aggiorna template
        $template->update([
            'name' => $data['name'] ?? $template->name,
            'subject' => $data['subject'] ?? $template->subject,
            'content' => $data['content'] ?? $template->content,
            'layout' => $data['layout'] ?? $template->layout,
            'from_name' => $data['from_name'] ?? $template->from_name,
            'from_email' => $data['from_email'] ?? $template->from_email,
            'reply_to' => $data['reply_to'] ?? $template->reply_to,
            'cc' => $data['cc'] ?? $template->cc,
            'bcc' => $data['bcc'] ?? $template->bcc,
            'attachments' => $data['attachments'] ?? $template->attachments,
            'variables' => $data['variables'] ?? $template->variables,
            'settings' => $data['settings'] ?? $template->settings,
            'version' => $newVersion
        ]);

        // Crea nuova versione
        $template->versions()->create([
            'version' => $newVersion,
            'content' => $data['content'] ?? $template->content,
            'created_by' => auth()->id(),
            'changes' => $this->getChanges($template, $data),
            'status' => 'published',
            'notes' => $data['notes'] ?? null
        ]);

        // Aggiorna traduzione default
        $template->translations()
            ->where('locale', config('app.locale'))
            ->update([
                'content' => $data['content'] ?? $template->content,
                'subject' => $data['subject'] ?? $template->subject,
                'from_name' => $data['from_name'] ?? $template->from_name,
                'variables' => $data['variables'] ?? $template->variables
            ]);

        DB::commit();

        event(new TemplateUpdated($template));

        return $template;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to update template: {$e->getMessage()}"
        );
    }
}

public function delete(Template $template): bool
{
    try {
        DB::beginTransaction();

        $template->delete();

        DB::commit();

        event(new TemplateDeleted($template));

        return true;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to delete template: {$e->getMessage()}"
        );
    }
}
```

#### 3.1.3 Gestione Versioni
```php
public function createVersion(Template $template, array $data): TemplateVersion
{
    try {
        DB::beginTransaction();

        $newVersion = $template->version + 1;

        $version = $template->versions()->create([
            'version' => $newVersion,
            'content' => $data['content'],
            'created_by' => auth()->id(),
            'changes' => $this->getChanges($template, $data),
            'status' => $data['status'] ?? 'draft',
            'notes' => $data['notes'] ?? null
        ]);

        $template->update(['version' => $newVersion]);

        DB::commit();

        return $version;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to create version: {$e->getMessage()}"
        );
    }
}

public function rollbackVersion(Template $template, int $version): Template
{
    try {
        DB::beginTransaction();

        $targetVersion = $template->versions()
            ->where('version', $version)
            ->firstOrFail();

        $template->update([
            'content' => $targetVersion->content,
            'version' => $version
        ]);

        DB::commit();

        return $template;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to rollback version: {$e->getMessage()}"
        );
    }
}

protected function getChanges(Template $template, array $data): array
{
    $changes = [];

    foreach ($data as $key => $value) {
        if (isset($template->$key) && $template->$key !== $value) {
            $changes[$key] = [
                'old' => $template->$key,
                'new' => $value
            ];
        }
    }

    return $changes;
}
```

#### 3.1.4 Gestione Traduzioni
```php
public function createTranslation(Template $template, array $data): TemplateTranslation
{
    try {
        DB::beginTransaction();

        $translation = $template->translations()->create([
            'locale' => $data['locale'],
            'content' => $data['content'],
            'subject' => $data['subject'],
            'from_name' => $data['from_name'] ?? null,
            'variables' => $data['variables'] ?? [],
            'translated_by' => auth()->id()
        ]);

        DB::commit();

        return $translation;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to create translation: {$e->getMessage()}"
        );
    }
}

public function updateTranslation(TemplateTranslation $translation, array $data): TemplateTranslation
{
    try {
        DB::beginTransaction();

        $translation->update([
            'content' => $data['content'] ?? $translation->content,
            'subject' => $data['subject'] ?? $translation->subject,
            'from_name' => $data['from_name'] ?? $translation->from_name,
            'variables' => $data['variables'] ?? $translation->variables
        ]);

        DB::commit();

        return $translation;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to update translation: {$e->getMessage()}"
        );
    }
}

public function deleteTranslation(TemplateTranslation $translation): bool
{
    try {
        DB::beginTransaction();

        $translation->delete();

        DB::commit();

        return true;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to delete translation: {$e->getMessage()}"
        );
    }
}
```

#### 3.1.5 Preview e Test
```php
public function preview(Template $template, array $variables = []): string
{
    try {
        $content = $this->replaceVariables(
            $template->content,
            $variables
        );

        return $this->mjml->compile($content);

    } catch (\Exception $e) {
        throw new TemplateException(
            "Failed to preview template: {$e->getMessage()}"
        );
    }
}

public function test(Template $template, string $email, array $variables = []): bool
{
    try {
        $content = $this->preview($template, $variables);

        return $this->mailgun->send([
            'to' => $email,
            'subject' => $template->subject,
            'html' => $content,
            'from_name' => $template->from_name,
            'from_email' => $template->from_email,
            'reply_to' => $template->reply_to,
            'cc' => $template->cc,
            'bcc' => $template->bcc,
            'attachments' => $template->attachments
        ]);

    } catch (\Exception $e) {
        throw new TemplateException(
            "Failed to test template: {$e->getMessage()}"
        );
    }
}

protected function replaceVariables(string $content, array $variables): string
{
    foreach ($variables as $key => $value) {
        $content = str_replace(
            "{{$key}}",
            $value,
            $content
        );
    }

    return $content;
}
```

### 3.2 MjmlService

#### 3.2.1 Struttura Base
```php
namespace Modules\Notify\Services;

use MJML\Mjml;
use MJML\MjmlException;

class MjmlService
{
    protected $mjml;
    protected $cache;

    public function __construct(CacheService $cache)
    {
        $this->mjml = new Mjml();
        $this->cache = $cache;
    }
}
```

#### 3.2.2 Compilazione MJML
```php
public function compile(string $content): string
{
    try {
        $cacheKey = $this->getCacheKey($content);

        return $this->cache->remember($cacheKey, function () use ($content) {
            return $this->mjml->render($content);
        });

    } catch (MjmlException $e) {
        throw new TemplateException(
            "Failed to compile MJML: {$e->getMessage()}"
        );
    }
}

public function validate(string $content): bool
{
    try {
        return $this->mjml->validate($content);
    } catch (MjmlException $e) {
        return false;
    }
}

protected function getCacheKey(string $content): string
{
    return 'mjml:' . md5($content);
}
```

#### 3.2.3 Estrazione Stili
```php
public function extractStyles(string $content): array
{
    $styles = [];

    // Estrai stili inline
    preg_match_all('/style="([^"]+)"/', $content, $matches);
    foreach ($matches[1] as $style) {
        $styles[] = $style;
    }

    // Estrai stili MJML
    preg_match_all('/mj-style>([^<]+)<\/mj-style>/', $content, $matches);
    foreach ($matches[1] as $style) {
        $styles[] = $style;
    }

    return array_unique($styles);
}

public function extractComponents(string $content): array
{
    $components = [];

    // Estrai componenti MJML
    preg_match_all('/<mj-([^>]+)>/', $content, $matches);
    foreach ($matches[1] as $component) {
        $components[] = $component;
    }

    return array_unique($components);
}
```

### 3.3 MailgunService

#### 3.3.1 Struttura Base
```php
namespace Modules\Notify\Services;

use Mailgun\Mailgun;
use Mailgun\Exception\MailgunException;

class MailgunService
{
    protected $mailgun;
    protected $domain;
    protected $cache;

    public function __construct(CacheService $cache)
    {
        $this->mailgun = Mailgun::create(
            config('services.mailgun.secret')
        );
        $this->domain = config('services.mailgun.domain');
        $this->cache = $cache;
    }
}
```

#### 3.3.2 Invio Email
```php
public function send(array $data): bool
{
    try {
        $message = [
            'from' => $this->formatFrom($data),
            'to' => $data['to'],
            'subject' => $data['subject'],
            'html' => $data['html'],
            'reply-to' => $data['reply_to'] ?? null,
            'cc' => $data['cc'] ?? null,
            'bcc' => $data['bcc'] ?? null,
            'attachment' => $this->formatAttachments($data['attachments'] ?? [])
        ];

        $response = $this->mailgun->messages()->send(
            $this->domain,
            $message
        );

        $this->logMessage($response);

        return true;

    } catch (MailgunException $e) {
        throw new TemplateException(
            "Failed to send email: {$e->getMessage()}"
        );
    }
}

protected function formatFrom(array $data): string
{
    if (isset($data['from_name'])) {
        return "{$data['from_name']} <{$data['from_email']}>";
    }

    return $data['from_email'];
}

protected function formatAttachments(array $attachments): array
{
    $formatted = [];

    foreach ($attachments as $attachment) {
        $formatted[] = [
            'filePath' => $attachment['path'],
            'filename' => $attachment['name']
        ];
    }

    return $formatted;
}

protected function logMessage($response): void
{
    // Log messaggio inviato
    Log::info('Email sent', [
        'id' => $response->getId(),
        'message' => $response->getMessage()
    ]);
}
```

#### 3.3.3 Gestione Eventi
```php
public function handleWebhook(array $data): void
{
    try {
        $event = $data['event'];
        $messageId = $data['message-id'];

        switch ($event) {
            case 'delivered':
                $this->handleDelivered($messageId);
                break;
            case 'opened':
                $this->handleOpened($messageId);
                break;
            case 'clicked':
                $this->handleClicked($messageId);
                break;
            case 'bounced':
                $this->handleBounced($messageId);
                break;
            case 'complained':
                $this->handleComplained($messageId);
                break;
            case 'unsubscribed':
                $this->handleUnsubscribed($messageId);
                break;
        }

    } catch (\Exception $e) {
        Log::error('Webhook error', [
            'error' => $e->getMessage(),
            'data' => $data
        ]);
    }
}

protected function handleDelivered(string $messageId): void
{
    // Aggiorna analytics
    $this->updateAnalytics($messageId, 'delivered');
}

protected function handleOpened(string $messageId): void
{
    // Aggiorna analytics
    $this->updateAnalytics($messageId, 'opened');
}

protected function handleClicked(string $messageId): void
{
    // Aggiorna analytics
    $this->updateAnalytics($messageId, 'clicked');
}

protected function handleBounced(string $messageId): void
{
    // Aggiorna analytics
    $this->updateAnalytics($messageId, 'bounced');
}

protected function handleComplained(string $messageId): void
{
    // Aggiorna analytics
    $this->updateAnalytics($messageId, 'complained');
}

protected function handleUnsubscribed(string $messageId): void
{
    // Aggiorna analytics
    $this->updateAnalytics($messageId, 'unsubscribed');
}

protected function updateAnalytics(string $messageId, string $event): void
{
    // Trova template
    $template = Template::where('message_id', $messageId)->first();
    if (!$template) {
        return;
    }

    // Crea analytics
    $template->analytics()->create([
        'event' => $event,
        'metadata' => [
            'message_id' => $messageId,
            'timestamp' => now()
        ]
    ]);
}
``` 

---

## analysis-dettagliata-4

*Consolidated from: `analysis-dettagliata-integrazione-filament.md`*


## 4. Integrazione con Filament

### 4.1 TemplateResource

#### 4.1.1 Struttura Base
```php
namespace Modules\Notify\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Resources\Form;
use Modules\Notify\Models\Template;

class TemplateResource extends Resource
{
    protected static ?string $model = Template::class;

    protected static ?string $navigationIcon = 'heroicon-o-mail';

    protected static ?string $navigationGroup = 'Notify';

    protected static ?int $navigationSort = 1;
}
```

#### 4.1.2 Form
```php
public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('subject')
                        ->label('Oggetto')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Select::make('layout')
                        ->label('Layout')
                        ->options([
                            'default' => 'Default',
                            'clean' => 'Clean',
                            'modern' => 'Modern'
                        ])
                        ->default('default')
                        ->required(),

                    Forms\Components\TextInput::make('from_name')
                        ->label('Nome Mittente')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('from_email')
                        ->label('Email Mittente')
                        ->email()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('reply_to')
                        ->label('Email Risposta')
                        ->email()
                        ->maxLength(255),

                    Forms\Components\KeyValue::make('cc')
                        ->label('CC')
                        ->keyLabel('Nome')
                        ->valueLabel('Email'),

                    Forms\Components\KeyValue::make('bcc')
                        ->label('BCC')
                        ->keyLabel('Nome')
                        ->valueLabel('Email'),

                    Forms\Components\FileUpload::make('attachments')
                        ->label('Allegati')
                        ->multiple()
                        ->directory('attachments'),

                    Forms\Components\KeyValue::make('variables')
                        ->label('Variabili')
                        ->keyLabel('Nome')
                        ->valueLabel('Descrizione'),

                    Forms\Components\KeyValue::make('settings')
                        ->label('Impostazioni')
                        ->keyLabel('Chiave')
                        ->valueLabel('Valore'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Attivo')
                        ->default(true)
                ])
                ->columns(2),

            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\RichEditor::make('content')
                        ->label('Contenuto')
                        ->required()
                        ->columnSpanFull()
                ])
        ]);
}
```

#### 4.1.3 Table
```php
public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->label('Nome')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('subject')
                ->label('Oggetto')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('layout')
                ->label('Layout')
                ->sortable(),

            Tables\Columns\TextColumn::make('version')
                ->label('Versione')
                ->sortable(),

            Tables\Columns\IconColumn::make('is_active')
                ->label('Attivo')
                ->boolean()
                ->sortable(),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Creato il')
                ->dateTime()
                ->sortable(),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Aggiornato il')
                ->dateTime()
                ->sortable()
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('layout')
                ->options([
                    'default' => 'Default',
                    'clean' => 'Clean',
                    'modern' => 'Modern'
                ]),

            Tables\Filters\TernaryFilter::make('is_active')
                ->label('Attivo')
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
            Tables\Actions\Action::make('preview')
                ->label('Anteprima')
                ->icon('heroicon-o-eye')
                ->action(function (Template $record) {
                    return redirect()->route('notify.templates.preview', $record);
                }),
            Tables\Actions\Action::make('test')
                ->label('Test')
                ->icon('heroicon-o-paper-airplane')
                ->form([
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required(),
                    Forms\Components\KeyValue::make('variables')
                        ->label('Variabili')
                ])
                ->action(function (Template $record, array $data) {
                    $record->test($data['email'], $data['variables']);
                    Notification::make()
                        ->title('Email inviata')
                        ->success()
                        ->send();
                })
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
            Tables\Actions\BulkAction::make('activate')
                ->label('Attiva')
                ->icon('heroicon-o-check')
                ->action(function (Collection $records) {
                    $records->each->activate();
                }),
            Tables\Actions\BulkAction::make('deactivate')
                ->label('Disattiva')
                ->icon('heroicon-o-x-mark')
                ->action(function (Collection $records) {
                    $records->each->deactivate();
                })
        ]);
}
```

### 4.2 RelationManagers

#### 4.2.1 TemplateVersionsRelationManager
```php
namespace Modules\Notify\Filament\Resources\TemplateResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Resources\Form;

class TemplateVersionsRelationManager extends RelationManager
{
    protected static string $relationship = 'versions';

    protected static ?string $recordTitleAttribute = 'version';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('version')
                    ->label('Versione')
                    ->required()
                    ->numeric(),

                Forms\Components\RichEditor::make('content')
                    ->label('Contenuto')
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Stato')
                    ->options([
                        'draft' => 'Bozza',
                        'published' => 'Pubblicato',
                        'archived' => 'Archiviato'
                    ])
                    ->required(),

                Forms\Components\Textarea::make('notes')
                    ->label('Note')
                    ->maxLength(65535)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('version')
                    ->label('Versione')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Stato')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creato il')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Creato da')
                    ->sortable()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Bozza',
                        'published' => 'Pubblicato',
                        'archived' => 'Archiviato'
                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('rollback')
                    ->label('Ripristina')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->action(function ($record) {
                        $record->template->rollback($record->version);
                        Notification::make()
                            ->title('Versione ripristinata')
                            ->success()
                            ->send();
                    })
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
            ]);
    }
}
```

#### 4.2.2 TemplateTranslationsRelationManager
```php
namespace Modules\Notify\Filament\Resources\TemplateResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Resources\Form;

class TemplateTranslationsRelationManager extends RelationManager
{
    protected static string $relationship = 'translations';

    protected static ?string $recordTitleAttribute = 'locale';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('locale')
                    ->label('Lingua')
                    ->options([
                        'it' => 'Italiano',
                        'en' => 'English',
                        'fr' => 'Français',
                        'de' => 'Deutsch',
                        'es' => 'Español'
                    ])
                    ->required(),

                Forms\Components\TextInput::make('subject')
                    ->label('Oggetto')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('from_name')
                    ->label('Nome Mittente')
                    ->maxLength(255),

                Forms\Components\KeyValue::make('variables')
                    ->label('Variabili')
                    ->keyLabel('Nome')
                    ->valueLabel('Descrizione'),

                Forms\Components\RichEditor::make('content')
                    ->label('Contenuto')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('locale')
                    ->label('Lingua')
                    ->sortable(),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Oggetto')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creato il')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('translator.name')
                    ->label('Tradotto da')
                    ->sortable()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('locale')
                    ->options([
                        'it' => 'Italiano',
                        'en' => 'English',
                        'fr' => 'Français',
                        'de' => 'Deutsch',
                        'es' => 'Español'
                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('preview')
                    ->label('Anteprima')
                    ->icon('heroicon-o-eye')
                    ->action(function ($record) {
                        return redirect()->route('notify.translations.preview', $record);
                    })
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
            ]);
    }
}
```

#### 4.2.3 TemplateAnalyticsRelationManager
```php
namespace Modules\Notify\Filament\Resources\TemplateResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Resources\Form;

class TemplateAnalyticsRelationManager extends RelationManager
{
    protected static string $relationship = 'analytics';

    protected static ?string $recordTitleAttribute = 'event';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('event')
                    ->label('Evento')
                    ->options([
                        'delivered' => 'Consegnato',
                        'opened' => 'Aperto',
                        'clicked' => 'Cliccato',
                        'bounced' => 'Rimbalzato',
                        'complained' => 'Segnalato',
                        'unsubscribed' => 'Disiscritto'
                    ])
                    ->required(),

                Forms\Components\KeyValue::make('metadata')
                    ->label('Metadati')
                    ->keyLabel('Chiave')
                    ->valueLabel('Valore'),

                Forms\Components\TextInput::make('user_agent')
                    ->label('User Agent')
                    ->maxLength(255),

                Forms\Components\TextInput::make('ip_address')
                    ->label('IP')
                    ->maxLength(45),

                Forms\Components\TextInput::make('session_id')
                    ->label('Sessione')
                    ->maxLength(255)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event')
                    ->label('Evento')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->searchable(),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP')
                    ->searchable(),

                Tables\Columns\TextColumn::make('session_id')
                    ->label('Sessione')
                    ->searchable()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('event')
                    ->options([
                        'delivered' => 'Consegnato',
                        'opened' => 'Aperto',
                        'clicked' => 'Cliccato',
                        'bounced' => 'Rimbalzato',
                        'complained' => 'Segnalato',
                        'unsubscribed' => 'Disiscritto'
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Da'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('A')
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn ($query, $date) => $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['created_until'],
                                fn ($query, $date) => $query->whereDate('created_at', '<=', $date)
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
            ])
            ->bulkActions([]);
    }
}
```

### 4.3 Widgets

#### 4.3.1 TemplateStatsWidget
```php
namespace Modules\Notify\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Notify\Models\Template;

class TemplateStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Template Totali', Template::count())
                ->description('Numero totale di template')
                ->descriptionIcon('heroicon-m-mail')
                ->color('primary'),

            Stat::make('Template Attivi', Template::where('is_active', true)->count())
                ->description('Template attualmente attivi')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Template Inattivi', Template::where('is_active', false)->count())
                ->description('Template attualmente inattivi')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger')
        ];
    }
}
```

#### 4.3.2 TemplateAnalyticsWidget
```php
namespace Modules\Notify\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Notify\Models\TemplateAnalytics;

class TemplateAnalyticsWidget extends ChartWidget
{
    protected static ?string $heading = 'Analytics Template';

    protected function getData(): array
    {
        $data = TemplateAnalytics::selectRaw('
                event,
                COUNT(*) as count,
                DATE(created_at) as date
            ')
            ->groupBy('event', 'date')
            ->orderBy('date')
            ->get();

        $events = $data->pluck('event')->unique();
        $dates = $data->pluck('date')->unique();

        $datasets = [];
        foreach ($events as $event) {
            $datasets[] = [
                'label' => $this->getEventLabel($event),
                'data' => $dates->map(function ($date) use ($data, $event) {
                    return $data->where('date', $date)
                        ->where('event', $event)
                        ->sum('count');
                })->toArray()
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $dates->toArray()
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getEventLabel(string $event): string
    {
        return [
            'delivered' => 'Consegnati',
            'opened' => 'Aperti',
            'clicked' => 'Cliccati',
            'bounced' => 'Rimbalzati',
            'complained' => 'Segnalati',
            'unsubscribed' => 'Disiscritti'
        ][$event] ?? $event;
    }
}
```

### 4.4 Pages

#### 4.4.1 TemplatePreviewPage
```php
namespace Modules\Notify\Filament\Pages;

use Filament\Pages\Page;
use Modules\Notify\Models\Template;

class TemplatePreviewPage extends Page
{
    protected static string $view = 'notify::pages.template-preview';

    public Template $template;

    public function mount(Template $template): void
    {
        $this->template = $template;
    }

    protected function getViewData(): array
    {
        return [
            'content' => $this->template->preview()
        ];
    }
}
```

#### 4.4.2 TemplateTestPage
```php
namespace Modules\Notify\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Form;
use Modules\Notify\Models\Template;

class TemplateTestPage extends Page
{
    protected static string $view = 'notify::pages.template-test';

    public Template $template;

    public ?array $data = [];

    public function mount(Template $template): void
    {
        $this->template = $template;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('data.email')
                    ->label('Email')
                    ->email()
                    ->required(),

                Forms\Components\KeyValue::make('data.variables')
                    ->label('Variabili')
                    ->keyLabel('Nome')
                    ->valueLabel('Valore')
            ]);
    }

    public function test(): void
    {
        $this->validate();

        $this->template->test(
            $this->data['email'],
            $this->data['variables'] ?? []
        );

        $this->notify('success', 'Email inviata con successo');
    }
} 

---

## analysis-dettagliata-5

*Consolidated from: `analysis-dettagliata-testing-parte.md`*


## 5. Testing

### 5.1 Unit Tests

#### 5.1.1 TemplateTest
```php
namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Models\Template;
use Modules\Notify\Services\TemplateService;
use Modules\Notify\Exceptions\TemplateException;

class TemplateTest extends TestCase
{
    protected $templateService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->templateService = app(TemplateService::class);
    }

    /** @test */
    public function it_can_create_a_template()
    {
        $data = [
            'name' => 'Test Template',
            'subject' => 'Test Subject',
            'content' => '<mjml>Test Content</mjml>',
            'layout' => 'default'
        ];

        $template = $this->templateService->create($data);

        $this->assertInstanceOf(Template::class, $template);
        $this->assertEquals($data['name'], $template->name);
        $this->assertEquals($data['subject'], $template->subject);
        $this->assertEquals($data['content'], $template->content);
        $this->assertEquals($data['layout'], $template->layout);
        $this->assertTrue($template->is_active);
        $this->assertEquals(1, $template->version);
    }

    /** @test */
    public function it_can_update_a_template()
    {
        $template = Template::factory()->create();

        $data = [
            'name' => 'Updated Template',
            'subject' => 'Updated Subject',
            'content' => '<mjml>Updated Content</mjml>'
        ];

        $updated = $this->templateService->update($template, $data);

        $this->assertEquals($data['name'], $updated->name);
        $this->assertEquals($data['subject'], $updated->subject);
        $this->assertEquals($data['content'], $updated->content);
        $this->assertEquals(2, $updated->version);
    }

    /** @test */
    public function it_can_delete_a_template()
    {
        $template = Template::factory()->create();

        $this->templateService->delete($template);

        $this->assertSoftDeleted($template);
    }

    /** @test */
    public function it_can_create_a_version()
    {
        $template = Template::factory()->create();

        $data = [
            'content' => '<mjml>New Version</mjml>',
            'status' => 'draft'
        ];

        $version = $this->templateService->createVersion($template, $data);

        $this->assertEquals($template->id, $version->template_id);
        $this->assertEquals(2, $version->version);
        $this->assertEquals($data['content'], $version->content);
        $this->assertEquals($data['status'], $version->status);
    }

    /** @test */
    public function it_can_rollback_to_a_version()
    {
        $template = Template::factory()->create();
        $version = $template->versions()->create([
            'version' => 2,
            'content' => '<mjml>Version 2</mjml>',
            'status' => 'published'
        ]);

        $rolledBack = $this->templateService->rollbackVersion($template, 1);

        $this->assertEquals(1, $rolledBack->version);
        $this->assertEquals($template->versions()->where('version', 1)->first()->content, $rolledBack->content);
    }

    /** @test */
    public function it_can_create_a_translation()
    {
        $template = Template::factory()->create();

        $data = [
            'locale' => 'en',
            'content' => '<mjml>English Content</mjml>',
            'subject' => 'English Subject'
        ];

        $translation = $this->templateService->createTranslation($template, $data);

        $this->assertEquals($template->id, $translation->template_id);
        $this->assertEquals($data['locale'], $translation->locale);
        $this->assertEquals($data['content'], $translation->content);
        $this->assertEquals($data['subject'], $translation->subject);
    }

    /** @test */
    public function it_can_update_a_translation()
    {
        $template = Template::factory()->create();
        $translation = $template->translations()->create([
            'locale' => 'en',
            'content' => '<mjml>English Content</mjml>',
            'subject' => 'English Subject'
        ]);

        $data = [
            'content' => '<mjml>Updated English Content</mjml>',
            'subject' => 'Updated English Subject'
        ];

        $updated = $this->templateService->updateTranslation($translation, $data);

        $this->assertEquals($data['content'], $updated->content);
        $this->assertEquals($data['subject'], $updated->subject);
    }

    /** @test */
    public function it_can_delete_a_translation()
    {
        $template = Template::factory()->create();
        $translation = $template->translations()->create([
            'locale' => 'en',
            'content' => '<mjml>English Content</mjml>',
            'subject' => 'English Subject'
        ]);

        $this->templateService->deleteTranslation($translation);

        $this->assertDatabaseMissing('template_translations', [
            'id' => $translation->id
        ]);
    }

    /** @test */
    public function it_can_preview_a_template()
    {
        $template = Template::factory()->create([
            'content' => '<mjml>Test Content</mjml>'
        ]);

        $preview = $this->templateService->preview($template);

        $this->assertIsString($preview);
        $this->assertStringContainsString('Test Content', $preview);
    }

    /** @test */
    public function it_can_test_a_template()
    {
        $template = Template::factory()->create([
            'content' => '<mjml>Test Content</mjml>'
        ]);

        $result = $this->templateService->test($template, 'test@example.com');

        $this->assertTrue($result);
    }

    /** @test */
    public function it_throws_exception_for_invalid_template()
    {
        $this->expectException(TemplateException::class);

        $template = Template::factory()->create([
            'content' => 'Invalid Content'
        ]);

        $this->templateService->preview($template);
    }
}
```

#### 5.1.2 MjmlServiceTest
```php
namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Services\MjmlService;
use Modules\Notify\Exceptions\TemplateException;

class MjmlServiceTest extends TestCase
{
    protected $mjmlService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mjmlService = app(MjmlService::class);
    }

    /** @test */
    public function it_can_compile_mjml()
    {
        $mjml = '<mjml>
            <mj-body>
                <mj-section>
                    <mj-column>
                        <mj-text>Hello World</mj-text>
                    </mj-column>
                </mj-section>
            </mj-body>
        </mjml>';

        $html = $this->mjmlService->compile($mjml);

        $this->assertIsString($html);
        $this->assertStringContainsString('Hello World', $html);
    }

    /** @test */
    public function it_can_validate_mjml()
    {
        $validMjml = '<mjml>
            <mj-body>
                <mj-section>
                    <mj-column>
                        <mj-text>Hello World</mj-text>
                    </mj-column>
                </mj-section>
            </mj-body>
        </mjml>';

        $invalidMjml = '<mjml>
            <mj-body>
                <mj-invalid>Hello World</mj-invalid>
            </mj-body>
        </mjml>';

        $this->assertTrue($this->mjmlService->validate($validMjml));
        $this->assertFalse($this->mjmlService->validate($invalidMjml));
    }

    /** @test */
    public function it_can_extract_styles()
    {
        $mjml = '<mjml>
            <mj-head>
                <mj-style>body { color: red; }</mj-style>
            </mj-head>
            <mj-body style="background: blue;">
                <mj-section>
                    <mj-column>
                        <mj-text style="font-size: 20px;">Hello World</mj-text>
                    </mj-column>
                </mj-section>
            </mj-body>
        </mjml>';

        $styles = $this->mjmlService->extractStyles($mjml);

        $this->assertIsArray($styles);
        $this->assertContains('body { color: red; }', $styles);
        $this->assertContains('background: blue', $styles);
        $this->assertContains('font-size: 20px', $styles);
    }

    /** @test */
    public function it_can_extract_components()
    {
        $mjml = '<mjml>
            <mj-head>
                <mj-style>body { color: red; }</mj-style>
            </mj-head>
            <mj-body>
                <mj-section>
                    <mj-column>
                        <mj-text>Hello World</mj-text>
                        <mj-image src="test.jpg" />
                    </mj-column>
                </mj-section>
            </mj-body>
        </mjml>';

        $components = $this->mjmlService->extractComponents($mjml);

        $this->assertIsArray($components);
        $this->assertContains('head', $components);
        $this->assertContains('body', $components);
        $this->assertContains('section', $components);
        $this->assertContains('column', $components);
        $this->assertContains('text', $components);
        $this->assertContains('image', $components);
    }

    /** @test */
    public function it_throws_exception_for_invalid_mjml()
    {
        $this->expectException(TemplateException::class);

        $invalidMjml = '<mjml>
            <mj-body>
                <mj-invalid>Hello World</mj-invalid>
            </mj-body>
        </mjml>';

        $this->mjmlService->compile($invalidMjml);
    }
}
```

#### 5.1.3 MailgunServiceTest
```php
namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Services\MailgunService;
use Modules\Notify\Exceptions\TemplateException;

class MailgunServiceTest extends TestCase
{
    protected $mailgunService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mailgunService = app(MailgunService::class);
    }

    /** @test */
    public function it_can_send_an_email()
    {
        $data = [
            'to' => 'test@example.com',
            'subject' => 'Test Subject',
            'html' => '<p>Test Content</p>',
            'from_name' => 'Test Sender',
            'from_email' => 'sender@example.com'
        ];

        $result = $this->mailgunService->send($data);

        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_handle_webhook_events()
    {
        $data = [
            'event' => 'delivered',
            'message-id' => 'test-message-id'
        ];

        $this->mailgunService->handleWebhook($data);

        $this->assertDatabaseHas('template_analytics', [
            'event' => 'delivered',
            'metadata->message_id' => 'test-message-id'
        ]);
    }

    /** @test */
    public function it_throws_exception_for_invalid_email()
    {
        $this->expectException(TemplateException::class);

        $data = [
            'to' => 'invalid-email',
            'subject' => 'Test Subject',
            'html' => '<p>Test Content</p>'
        ];

        $this->mailgunService->send($data);
    }

    /** @test */
    public function it_can_format_from_field()
    {
        $data = [
            'from_name' => 'Test Sender',
            'from_email' => 'sender@example.com'
        ];

        $from = $this->mailgunService->formatFrom($data);

        $this->assertEquals('Test Sender <sender@example.com>', $from);
    }

    /** @test */
    public function it_can_format_attachments()
    {
        $attachments = [
            [
                'path' => 'path/to/file1.pdf',
                'name' => 'file1.pdf'
            ],
            [
                'path' => 'path/to/file2.pdf',
                'name' => 'file2.pdf'
            ]
        ];

        $formatted = $this->mailgunService->formatAttachments($attachments);

        $this->assertIsArray($formatted);
        $this->assertCount(2, $formatted);
        $this->assertEquals('path/to/file1.pdf', $formatted[0]['filePath']);
        $this->assertEquals('file1.pdf', $formatted[0]['filename']);
    }
}
```

### 5.2 Feature Tests

#### 5.2.1 TemplateControllerTest
```php
namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Notify\Models\Template;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TemplateControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_templates()
    {
        $templates = Template::factory()->count(3)->create();

        $response = $this->getJson('/api/notify/templates');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'subject',
                        'content',
                        'layout',
                        'is_active',
                        'version',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_can_show_a_template()
    {
        $template = Template::factory()->create();

        $response = $this->getJson("/api/notify/templates/{$template->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $template->id,
                    'name' => $template->name,
                    'subject' => $template->subject,
                    'content' => $template->content,
                    'layout' => $template->layout,
                    'is_active' => $template->is_active,
                    'version' => $template->version
                ]
            ]);
    }

    /** @test */
    public function it_can_create_a_template()
    {
        $data = [
            'name' => 'Test Template',
            'subject' => 'Test Subject',
            'content' => '<mjml>Test Content</mjml>',
            'layout' => 'default'
        ];

        $response = $this->postJson('/api/notify/templates', $data);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => $data['name'],
                    'subject' => $data['subject'],
                    'content' => $data['content'],
                    'layout' => $data['layout']
                ]
            ]);

        $this->assertDatabaseHas('templates', [
            'name' => $data['name'],
            'subject' => $data['subject'],
            'content' => $data['content'],
            'layout' => $data['layout']
        ]);
    }

    /** @test */
    public function it_can_update_a_template()
    {
        $template = Template::factory()->create();

        $data = [
            'name' => 'Updated Template',
            'subject' => 'Updated Subject',
            'content' => '<mjml>Updated Content</mjml>'
        ];

        $response = $this->putJson("/api/notify/templates/{$template->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $data['name'],
                    'subject' => $data['subject'],
                    'content' => $data['content']
                ]
            ]);

        $this->assertDatabaseHas('templates', [
            'id' => $template->id,
            'name' => $data['name'],
            'subject' => $data['subject'],
            'content' => $data['content']
        ]);
    }

    /** @test */
    public function it_can_delete_a_template()
    {
        $template = Template::factory()->create();

        $response = $this->deleteJson("/api/notify/templates/{$template->id}");

        $response->assertStatus(204);

        $this->assertSoftDeleted($template);
    }

    /** @test */
    public function it_can_preview_a_template()
    {
        $template = Template::factory()->create([
            'content' => '<mjml>Test Content</mjml>'
        ]);

        $response = $this->getJson("/api/notify/templates/{$template->id}/preview");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'html'
                ]
            ]);
    }

    /** @test */
    public function it_can_test_a_template()
    {
        $template = Template::factory()->create([
            'content' => '<mjml>Test Content</mjml>'
        ]);

        $data = [
            'email' => 'test@example.com',
            'variables' => [
                'name' => 'Test User'
            ]
        ];

        $response = $this->postJson("/api/notify/templates/{$template->id}/test", $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Email sent successfully'
            ]);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $response = $this->postJson('/api/notify/templates', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
                'subject',
                'content'
            ]);
    }

    /** @test */
    public function it_validates_email_format()
    {
        $template = Template::factory()->create();

        $data = [
            'email' => 'invalid-email'
        ];

        $response = $this->postJson("/api/notify/templates/{$template->id}/test", $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email'
            ]);
    }
}
```

#### 5.2.2 WebhookControllerTest
```php
namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Notify\Models\Template;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebhookControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_handle_delivered_event()
    {
        $template = Template::factory()->create();

        $data = [
            'event' => 'delivered',
            'message-id' => 'test-message-id',
            'recipient' => 'test@example.com',
            'domain' => 'example.com',
            'timestamp' => time()
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event' => 'delivered',
            'metadata->message_id' => 'test-message-id'
        ]);
    }

    /** @test */
    public function it_can_handle_opened_event()
    {
        $template = Template::factory()->create();

        $data = [
            'event' => 'opened',
            'message-id' => 'test-message-id',
            'recipient' => 'test@example.com',
            'domain' => 'example.com',
            'timestamp' => time()
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event' => 'opened',
            'metadata->message_id' => 'test-message-id'
        ]);
    }

    /** @test */
    public function it_can_handle_clicked_event()
    {
        $template = Template::factory()->create();

        $data = [
            'event' => 'clicked',
            'message-id' => 'test-message-id',
            'recipient' => 'test@example.com',
            'domain' => 'example.com',
            'timestamp' => time(),
            'url' => 'https://example.com'
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event' => 'clicked',
            'metadata->message_id' => 'test-message-id',
            'metadata->url' => 'https://example.com'
        ]);
    }

    /** @test */
    public function it_can_handle_bounced_event()
    {
        $template = Template::factory()->create();

        $data = [
            'event' => 'bounced',
            'message-id' => 'test-message-id',
            'recipient' => 'test@example.com',
            'domain' => 'example.com',
            'timestamp' => time(),
            'code' => '550',
            'error' => 'User unknown'
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event' => 'bounced',
            'metadata->message_id' => 'test-message-id',
            'metadata->code' => '550',
            'metadata->error' => 'User unknown'
        ]);
    }

    /** @test */
    public function it_can_handle_complained_event()
    {
        $template = Template::factory()->create();

        $data = [
            'event' => 'complained',
            'message-id' => 'test-message-id',
            'recipient' => 'test@example.com',
            'domain' => 'example.com',
            'timestamp' => time()
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event' => 'complained',
            'metadata->message_id' => 'test-message-id'
        ]);
    }

    /** @test */
    public function it_can_handle_unsubscribed_event()
    {
        $template = Template::factory()->create();

        $data = [
            'event' => 'unsubscribed',
            'message-id' => 'test-message-id',
            'recipient' => 'test@example.com',
            'domain' => 'example.com',
            'timestamp' => time()
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event' => 'unsubscribed',
            'metadata->message_id' => 'test-message-id'
        ]);
    }

    /** @test */
    public function it_validates_webhook_signature()
    {
        $data = [
            'event' => 'delivered',
            'message-id' => 'test-message-id'
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(401);
    }
}
``` 

---

## analysis-dettagliata-6

*Consolidated from: `analysis-dettagliata-monitoraggio-analytics.md`*


## 6. Monitoraggio e Analytics

### 6.1 Logging

#### 6.1.1 TemplateLogger
```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;
use Modules\Notify\Models\Template;

class TemplateLogger
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function created(): void
    {
        Log::info('Template created', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'version' => $this->template->version,
            'user_id' => auth()->id()
        ]);
    }

    public function updated(): void
    {
        Log::info('Template updated', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'version' => $this->template->version,
            'user_id' => auth()->id()
        ]);
    }

    public function deleted(): void
    {
        Log::info('Template deleted', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'user_id' => auth()->id()
        ]);
    }

    public function versionCreated(int $version): void
    {
        Log::info('Template version created', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'version' => $version,
            'user_id' => auth()->id()
        ]);
    }

    public function versionRolledBack(int $version): void
    {
        Log::info('Template version rolled back', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'version' => $version,
            'user_id' => auth()->id()
        ]);
    }

    public function translationCreated(string $locale): void
    {
        Log::info('Template translation created', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'locale' => $locale,
            'user_id' => auth()->id()
        ]);
    }

    public function translationUpdated(string $locale): void
    {
        Log::info('Template translation updated', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'locale' => $locale,
            'user_id' => auth()->id()
        ]);
    }

    public function translationDeleted(string $locale): void
    {
        Log::info('Template translation deleted', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'locale' => $locale,
            'user_id' => auth()->id()
        ]);
    }

    public function previewed(): void
    {
        Log::info('Template previewed', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'user_id' => auth()->id()
        ]);
    }

    public function tested(string $email): void
    {
        Log::info('Template tested', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'email' => $email,
            'user_id' => auth()->id()
        ]);
    }

    public function error(string $message, array $context = []): void
    {
        Log::error('Template error', array_merge([
            'id' => $this->template->id,
            'name' => $this->template->name,
            'message' => $message,
            'user_id' => auth()->id()
        ], $context));
    }
}
```

#### 6.1.2 MailgunLogger
```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;

class MailgunLogger
{
    public function webhookReceived(array $data): void
    {
        Log::info('Mailgun webhook received', [
            'event' => $data['event'],
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'domain' => $data['domain'],
            'timestamp' => $data['timestamp']
        ]);
    }

    public function emailSent(array $data): void
    {
        Log::info('Email sent', [
            'to' => $data['to'],
            'subject' => $data['subject'],
            'message_id' => $data['message-id'],
            'template_id' => $data['template_id']
        ]);
    }

    public function emailDelivered(array $data): void
    {
        Log::info('Email delivered', [
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'timestamp' => $data['timestamp']
        ]);
    }

    public function emailOpened(array $data): void
    {
        Log::info('Email opened', [
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'timestamp' => $data['timestamp'],
            'user_agent' => $data['user-agent']
        ]);
    }

    public function emailClicked(array $data): void
    {
        Log::info('Email clicked', [
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'timestamp' => $data['timestamp'],
            'url' => $data['url']
        ]);
    }

    public function emailBounced(array $data): void
    {
        Log::error('Email bounced', [
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'timestamp' => $data['timestamp'],
            'code' => $data['code'],
            'error' => $data['error']
        ]);
    }

    public function emailComplained(array $data): void
    {
        Log::warning('Email complained', [
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'timestamp' => $data['timestamp']
        ]);
    }

    public function emailUnsubscribed(array $data): void
    {
        Log::info('Email unsubscribed', [
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'timestamp' => $data['timestamp']
        ]);
    }

    public function webhookError(string $message, array $data): void
    {
        Log::error('Mailgun webhook error', [
            'message' => $message,
            'data' => $data
        ]);
    }
}
```

### 6.2 Analytics

#### 6.2.1 TemplateAnalytics
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;
use Modules\Notify\Models\TemplateAnalytics;

class TemplateAnalytics
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function trackEvent(string $event, array $metadata = []): void
    {
        $this->template->analytics()->create([
            'event' => $event,
            'metadata' => $metadata,
            'user_agent' => request()->userAgent(),
            'ip_address' => request()->ip(),
            'session_id' => session()->getId()
        ]);
    }

    public function getStats(): array
    {
        return [
            'total_sent' => $this->getTotalSent(),
            'delivered' => $this->getDeliveredCount(),
            'opened' => $this->getOpenedCount(),
            'clicked' => $this->getClickedCount(),
            'bounced' => $this->getBouncedCount(),
            'complained' => $this->getComplainedCount(),
            'unsubscribed' => $this->getUnsubscribedCount(),
            'delivery_rate' => $this->getDeliveryRate(),
            'open_rate' => $this->getOpenRate(),
            'click_rate' => $this->getClickRate(),
            'bounce_rate' => $this->getBounceRate(),
            'complaint_rate' => $this->getComplaintRate(),
            'unsubscribe_rate' => $this->getUnsubscribeRate()
        ];
    }

    public function getTotalSent(): int
    {
        return $this->template->analytics()
            ->where('event', 'sent')
            ->count();
    }

    public function getDeliveredCount(): int
    {
        return $this->template->analytics()
            ->where('event', 'delivered')
            ->count();
    }

    public function getOpenedCount(): int
    {
        return $this->template->analytics()
            ->where('event', 'opened')
            ->count();
    }

    public function getClickedCount(): int
    {
        return $this->template->analytics()
            ->where('event', 'clicked')
            ->count();
    }

    public function getBouncedCount(): int
    {
        return $this->template->analytics()
            ->where('event', 'bounced')
            ->count();
    }

    public function getComplainedCount(): int
    {
        return $this->template->analytics()
            ->where('event', 'complained')
            ->count();
    }

    public function getUnsubscribedCount(): int
    {
        return $this->template->analytics()
            ->where('event', 'unsubscribed')
            ->count();
    }

    public function getDeliveryRate(): float
    {
        $sent = $this->getTotalSent();
        if ($sent === 0) {
            return 0;
        }

        return ($this->getDeliveredCount() / $sent) * 100;
    }

    public function getOpenRate(): float
    {
        $delivered = $this->getDeliveredCount();
        if ($delivered === 0) {
            return 0;
        }

        return ($this->getOpenedCount() / $delivered) * 100;
    }

    public function getClickRate(): float
    {
        $opened = $this->getOpenedCount();
        if ($opened === 0) {
            return 0;
        }

        return ($this->getClickedCount() / $opened) * 100;
    }

    public function getBounceRate(): float
    {
        $sent = $this->getTotalSent();
        if ($sent === 0) {
            return 0;
        }

        return ($this->getBouncedCount() / $sent) * 100;
    }

    public function getComplaintRate(): float
    {
        $delivered = $this->getDeliveredCount();
        if ($delivered === 0) {
            return 0;
        }

        return ($this->getComplainedCount() / $delivered) * 100;
    }

    public function getUnsubscribeRate(): float
    {
        $delivered = $this->getDeliveredCount();
        if ($delivered === 0) {
            return 0;
        }

        return ($this->getUnsubscribedCount() / $delivered) * 100;
    }

    public function getEventsByDate(string $event, string $startDate, string $endDate): array
    {
        return $this->template->analytics()
            ->where('event', $event)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();
    }

    public function getEventsByHour(string $event, string $date): array
    {
        return $this->template->analytics()
            ->where('event', $event)
            ->whereDate('created_at', $date)
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->pluck('count', 'hour')
            ->toArray();
    }

    public function getTopRecipients(string $event, int $limit = 10): array
    {
        return $this->template->analytics()
            ->where('event', $event)
            ->selectRaw('metadata->>"$.recipient" as recipient, COUNT(*) as count')
            ->groupBy('recipient')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->pluck('count', 'recipient')
            ->toArray();
    }

    public function getTopUserAgents(string $event, int $limit = 10): array
    {
        return $this->template->analytics()
            ->where('event', $event)
            ->whereNotNull('user_agent')
            ->selectRaw('user_agent, COUNT(*) as count')
            ->groupBy('user_agent')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->pluck('count', 'user_agent')
            ->toArray();
    }

    public function getTopIPs(string $event, int $limit = 10): array
    {
        return $this->template->analytics()
            ->where('event', $event)
            ->whereNotNull('ip_address')
            ->selectRaw('ip_address, COUNT(*) as count')
            ->groupBy('ip_address')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->pluck('count', 'ip_address')
            ->toArray();
    }

    public function getTopClickedUrls(int $limit = 10): array
    {
        return $this->template->analytics()
            ->where('event', 'clicked')
            ->selectRaw('metadata->>"$.url" as url, COUNT(*) as count')
            ->groupBy('url')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->pluck('count', 'url')
            ->toArray();
    }

    public function getBounceReasons(): array
    {
        return $this->template->analytics()
            ->where('event', 'bounced')
            ->selectRaw('metadata->>"$.error" as reason, COUNT(*) as count')
            ->groupBy('reason')
            ->orderByDesc('count')
            ->get()
            ->pluck('count', 'reason')
            ->toArray();
    }

    public function getBounceCodes(): array
    {
        return $this->template->analytics()
            ->where('event', 'bounced')
            ->selectRaw('metadata->>"$.code" as code, COUNT(*) as count')
            ->groupBy('code')
            ->orderByDesc('count')
            ->get()
            ->pluck('count', 'code')
            ->toArray();
    }
}
```

#### 6.2.2 AnalyticsExporter
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;
use Illuminate\Support\Facades\Storage;

class AnalyticsExporter
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function exportToCsv(string $startDate, string $endDate): string
    {
        $filename = "analytics_{$this->template->id}_{$startDate}_{$endDate}.csv";
        $path = "analytics/{$filename}";

        $handle = fopen(Storage::path($path), 'w');

        // Intestazioni
        fputcsv($handle, [
            'Event',
            'Date',
            'Time',
            'Recipient',
            'User Agent',
            'IP Address',
            'Session ID',
            'Metadata'
        ]);

        // Dati
        $this->template->analytics()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->each(function ($analytics) use ($handle) {
                fputcsv($handle, [
                    $analytics->event,
                    $analytics->created_at->format('Y-m-d'),
                    $analytics->created_at->format('H:i:s'),
                    $analytics->metadata['recipient'] ?? '',
                    $analytics->user_agent,
                    $analytics->ip_address,
                    $analytics->session_id,
                    json_encode($analytics->metadata)
                ]);
            });

        fclose($handle);

        return $path;
    }

    public function exportToJson(string $startDate, string $endDate): string
    {
        $filename = "analytics_{$this->template->id}_{$startDate}_{$endDate}.json";
        $path = "analytics/{$filename}";

        $data = $this->template->analytics()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->get()
            ->map(function ($analytics) {
                return [
                    'event' => $analytics->event,
                    'date' => $analytics->created_at->format('Y-m-d'),
                    'time' => $analytics->created_at->format('H:i:s'),
                    'recipient' => $analytics->metadata['recipient'] ?? null,
                    'user_agent' => $analytics->user_agent,
                    'ip_address' => $analytics->ip_address,
                    'session_id' => $analytics->session_id,
                    'metadata' => $analytics->metadata
                ];
            });

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return $path;
    }

    public function exportToExcel(string $startDate, string $endDate): string
    {
        $filename = "analytics_{$this->template->id}_{$startDate}_{$endDate}.xlsx";
        $path = "analytics/{$filename}";

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Intestazioni
        $sheet->setCellValue('A1', 'Event');
        $sheet->setCellValue('B1', 'Date');
        $sheet->setCellValue('C1', 'Time');
        $sheet->setCellValue('D1', 'Recipient');
        $sheet->setCellValue('E1', 'User Agent');
        $sheet->setCellValue('F1', 'IP Address');
        $sheet->setCellValue('G1', 'Session ID');
        $sheet->setCellValue('H1', 'Metadata');

        // Dati
        $row = 2;
        $this->template->analytics()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->each(function ($analytics) use ($sheet, &$row) {
                $sheet->setCellValue('A' . $row, $analytics->event);
                $sheet->setCellValue('B' . $row, $analytics->created_at->format('Y-m-d'));
                $sheet->setCellValue('C' . $row, $analytics->created_at->format('H:i:s'));
                $sheet->setCellValue('D' . $row, $analytics->metadata['recipient'] ?? '');
                $sheet->setCellValue('E' . $row, $analytics->user_agent);
                $sheet->setCellValue('F' . $row, $analytics->ip_address);
                $sheet->setCellValue('G' . $row, $analytics->session_id);
                $sheet->setCellValue('H' . $row, json_encode($analytics->metadata));
                $row++;
            });

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save(Storage::path($path));

        return $path;
    }
}
``` 

---

## analysis-dettagliata-7

*Consolidated from: `analysis-dettagliata-manutenzione-backup.md`*


## 7. Manutenzione e Backup

### 7.1 Versioning

#### 7.1.1 VersionManager
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;
use Modules\Notify\Models\TemplateVersion;
use Modules\Notify\Exceptions\TemplateException;

class VersionManager
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function createVersion(array $data): TemplateVersion
    {
        try {
            $newVersion = $this->template->version + 1;

            $version = $this->template->versions()->create([
                'version' => $newVersion,
                'content' => $data['content'],
                'created_by' => auth()->id(),
                'changes' => $this->getChanges($data),
                'status' => $data['status'] ?? 'draft',
                'notes' => $data['notes'] ?? null
            ]);

            $this->template->update(['version' => $newVersion]);

            return $version;

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to create version: {$e->getMessage()}"
            );
        }
    }

    public function rollbackVersion(int $version): Template
    {
        try {
            $targetVersion = $this->template->versions()
                ->where('version', $version)
                ->firstOrFail();

            $this->template->update([
                'content' => $targetVersion->content,
                'version' => $version
            ]);

            return $this->template;

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to rollback version: {$e->getMessage()}"
            );
        }
    }

    public function compareVersions(int $version1, int $version2): array
    {
        try {
            $v1 = $this->template->versions()
                ->where('version', $version1)
                ->firstOrFail();

            $v2 = $this->template->versions()
                ->where('version', $version2)
                ->firstOrFail();

            return [
                'added' => $this->getAddedLines($v1->content, $v2->content),
                'removed' => $this->getRemovedLines($v1->content, $v2->content),
                'modified' => $this->getModifiedLines($v1->content, $v2->content)
            ];

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to compare versions: {$e->getMessage()}"
            );
        }
    }

    public function getVersionHistory(): array
    {
        return $this->template->versions()
            ->orderBy('version', 'desc')
            ->get()
            ->map(function ($version) {
                return [
                    'version' => $version->version,
                    'content' => $version->content,
                    'status' => $version->status,
                    'notes' => $version->notes,
                    'created_at' => $version->created_at,
                    'created_by' => $version->creator->name
                ];
            })
            ->toArray();
    }

    protected function getChanges(array $data): array
    {
        $changes = [];

        foreach ($data as $key => $value) {
            if (isset($this->template->$key) && $this->template->$key !== $value) {
                $changes[$key] = [
                    'old' => $this->template->$key,
                    'new' => $value
                ];
            }
        }

        return $changes;
    }

    protected function getAddedLines(string $old, string $new): array
    {
        $oldLines = explode("\n", $old);
        $newLines = explode("\n", $new);
        return array_diff($newLines, $oldLines);
    }

    protected function getRemovedLines(string $old, string $new): array
    {
        $oldLines = explode("\n", $old);
        $newLines = explode("\n", $new);
        return array_diff($oldLines, $newLines);
    }

    protected function getModifiedLines(string $old, string $new): array
    {
        $oldLines = explode("\n", $old);
        $newLines = explode("\n", $new);
        $modified = [];

        foreach ($oldLines as $index => $line) {
            if (isset($newLines[$index]) && $line !== $newLines[$index]) {
                $modified[] = [
                    'old' => $line,
                    'new' => $newLines[$index]
                ];
            }
        }

        return $modified;
    }
}
```

### 7.2 Backup

#### 7.2.1 BackupManager
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;
use Illuminate\Support\Facades\Storage;
use Modules\Notify\Exceptions\TemplateException;

class BackupManager
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function createBackup(): string
    {
        try {
            $filename = "backup_{$this->template->id}_" . date('Y-m-d_His') . ".json";
            $path = "backups/{$filename}";

            $data = [
                'template' => [
                    'id' => $this->template->id,
                    'name' => $this->template->name,
                    'subject' => $this->template->subject,
                    'content' => $this->template->content,
                    'layout' => $this->template->layout,
                    'is_active' => $this->template->is_active,
                    'version' => $this->template->version,
                    'from_name' => $this->template->from_name,
                    'from_email' => $this->template->from_email,
                    'reply_to' => $this->template->reply_to,
                    'cc' => $this->template->cc,
                    'bcc' => $this->template->bcc,
                    'attachments' => $this->template->attachments,
                    'variables' => $this->template->variables,
                    'settings' => $this->template->settings,
                    'created_at' => $this->template->created_at,
                    'updated_at' => $this->template->updated_at
                ],
                'versions' => $this->template->versions()
                    ->orderBy('version')
                    ->get()
                    ->map(function ($version) {
                        return [
                            'version' => $version->version,
                            'content' => $version->content,
                            'status' => $version->status,
                            'notes' => $version->notes,
                            'created_at' => $version->created_at,
                            'created_by' => $version->creator->name
                        ];
                    })
                    ->toArray(),
                'translations' => $this->template->translations()
                    ->get()
                    ->map(function ($translation) {
                        return [
                            'locale' => $translation->locale,
                            'content' => $translation->content,
                            'subject' => $translation->subject,
                            'from_name' => $translation->from_name,
                            'variables' => $translation->variables,
                            'created_at' => $translation->created_at,
                            'translated_by' => $translation->translator->name
                        ];
                    })
                    ->toArray()
            ];

            Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

            return $path;

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to create backup: {$e->getMessage()}"
            );
        }
    }

    public function restoreFromBackup(string $path): Template
    {
        try {
            $data = json_decode(Storage::get($path), true);

            DB::beginTransaction();

            // Ripristina template
            $this->template->update([
                'name' => $data['template']['name'],
                'subject' => $data['template']['subject'],
                'content' => $data['template']['content'],
                'layout' => $data['template']['layout'],
                'is_active' => $data['template']['is_active'],
                'version' => $data['template']['version'],
                'from_name' => $data['template']['from_name'],
                'from_email' => $data['template']['from_email'],
                'reply_to' => $data['template']['reply_to'],
                'cc' => $data['template']['cc'],
                'bcc' => $data['template']['bcc'],
                'attachments' => $data['template']['attachments'],
                'variables' => $data['template']['variables'],
                'settings' => $data['template']['settings']
            ]);

            // Ripristina versioni
            $this->template->versions()->delete();
            foreach ($data['versions'] as $version) {
                $this->template->versions()->create([
                    'version' => $version['version'],
                    'content' => $version['content'],
                    'status' => $version['status'],
                    'notes' => $version['notes'],
                    'created_by' => auth()->id()
                ]);
            }

            // Ripristina traduzioni
            $this->template->translations()->delete();
            foreach ($data['translations'] as $translation) {
                $this->template->translations()->create([
                    'locale' => $translation['locale'],
                    'content' => $translation['content'],
                    'subject' => $translation['subject'],
                    'from_name' => $translation['from_name'],
                    'variables' => $translation['variables'],
                    'translated_by' => auth()->id()
                ]);
            }

            DB::commit();

            return $this->template;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new TemplateException(
                "Failed to restore from backup: {$e->getMessage()}"
            );
        }
    }

    public function getBackups(): array
    {
        return collect(Storage::files('backups'))
            ->filter(function ($path) {
                return str_starts_with(basename($path), "backup_{$this->template->id}_");
            })
            ->map(function ($path) {
                return [
                    'path' => $path,
                    'filename' => basename($path),
                    'created_at' => Storage::lastModified($path),
                    'size' => Storage::size($path)
                ];
            })
            ->sortByDesc('created_at')
            ->values()
            ->toArray();
    }

    public function deleteBackup(string $path): bool
    {
        try {
            return Storage::delete($path);
        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to delete backup: {$e->getMessage()}"
            );
        }
    }
}
```

#### 7.2.2 BackupCommand
```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\Template;
use Modules\Notify\Services\BackupManager;

class BackupTemplatesCommand extends Command
{
    protected $signature = 'notify:backup-templates {--template= : ID del template da backuppare} {--all : Backup di tutti i template}';

    protected $description = 'Crea backup dei template';

    public function handle()
    {
        if ($this->option('all')) {
            $templates = Template::all();
        } elseif ($templateId = $this->option('template')) {
            $templates = Template::where('id', $templateId)->get();
        } else {
            $this->error('Specificare --template o --all');
            return 1;
        }

        $bar = $this->output->createProgressBar(count($templates));
        $bar->start();

        foreach ($templates as $template) {
            try {
                $backupManager = new BackupManager($template);
                $path = $backupManager->createBackup();
                $this->info("\nBackup creato: {$path}");
            } catch (\Exception $e) {
                $this->error("\nErrore nel backup del template {$template->id}: {$e->getMessage()}");
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Backup completato');

        return 0;
    }
}
```

### 7.3 Manutenzione

#### 7.3.1 MaintenanceManager
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;
use Illuminate\Support\Facades\Cache;
use Modules\Notify\Exceptions\TemplateException;

class MaintenanceManager
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function cleanup(): void
    {
        try {
            // Pulisci cache
            $this->clearCache();

            // Pulisci analytics vecchi
            $this->cleanupAnalytics();

            // Pulisci backup vecchi
            $this->cleanupBackups();

            // Pulisci allegati non utilizzati
            $this->cleanupAttachments();

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to cleanup: {$e->getMessage()}"
            );
        }
    }

    public function optimize(): void
    {
        try {
            // Ottimizza database
            $this->optimizeDatabase();

            // Ottimizza cache
            $this->optimizeCache();

            // Ottimizza storage
            $this->optimizeStorage();

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to optimize: {$e->getMessage()}"
            );
        }
    }

    public function validate(): array
    {
        try {
            $issues = [];

            // Valida template
            if (!$this->validateTemplate()) {
                $issues[] = 'Template non valido';
            }

            // Valida versioni
            if (!$this->validateVersions()) {
                $issues[] = 'Versioni non valide';
            }

            // Valida traduzioni
            if (!$this->validateTranslations()) {
                $issues[] = 'Traduzioni non valide';
            }

            // Valida analytics
            if (!$this->validateAnalytics()) {
                $issues[] = 'Analytics non validi';
            }

            return $issues;

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to validate: {$e->getMessage()}"
            );
        }
    }

    protected function clearCache(): void
    {
        Cache::tags(['template_' . $this->template->id])->flush();
    }

    protected function cleanupAnalytics(): void
    {
        $this->template->analytics()
            ->where('created_at', '<', now()->subMonths(3))
            ->delete();
    }

    protected function cleanupBackups(): void
    {
        $backups = collect(Storage::files('backups'))
            ->filter(function ($path) {
                return str_starts_with(basename($path), "backup_{$this->template->id}_");
            })
            ->sortByDesc(function ($path) {
                return Storage::lastModified($path);
            })
            ->skip(10);

        foreach ($backups as $backup) {
            Storage::delete($backup);
        }
    }

    protected function cleanupAttachments(): void
    {
        $usedAttachments = $this->template->attachments ?? [];
        $allAttachments = Storage::files('attachments');

        foreach ($allAttachments as $attachment) {
            if (!in_array($attachment, $usedAttachments)) {
                Storage::delete($attachment);
            }
        }
    }

    protected function optimizeDatabase(): void
    {
        DB::statement('OPTIMIZE TABLE templates');
        DB::statement('OPTIMIZE TABLE template_versions');
        DB::statement('OPTIMIZE TABLE template_translations');
        DB::statement('OPTIMIZE TABLE template_analytics');
    }

    protected function optimizeCache(): void
    {
        Cache::tags(['template_' . $this->template->id])->flush();
    }

    protected function optimizeStorage(): void
    {
        // Comprimi allegati
        foreach ($this->template->attachments ?? [] as $attachment) {
            if (Storage::exists($attachment)) {
                $content = Storage::get($attachment);
                $compressed = gzcompress($content);
                Storage::put($attachment . '.gz', $compressed);
            }
        }
    }

    protected function validateTemplate(): bool
    {
        return $this->template->is_valid;
    }

    protected function validateVersions(): bool
    {
        return $this->template->versions()
            ->where('is_valid', false)
            ->count() === 0;
    }

    protected function validateTranslations(): bool
    {
        return $this->template->translations()
            ->where('is_valid', false)
            ->count() === 0;
    }

    protected function validateAnalytics(): bool
    {
        return $this->template->analytics()
            ->where('is_valid', false)
            ->count() === 0;
    }
}
```

#### 7.3.2 MaintenanceCommand
```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\Template;
use Modules\Notify\Services\MaintenanceManager;

class MaintainTemplatesCommand extends Command
{
    protected $signature = 'notify:maintain-templates {--template= : ID del template da mantenere} {--all : Manutenzione di tutti i template} {--cleanup : Pulisci risorse} {--optimize : Ottimizza risorse} {--validate : Valida risorse}';

    protected $description = 'Esegue manutenzione sui template';

    public function handle()
    {
        if ($this->option('all')) {
            $templates = Template::all();
        } elseif ($templateId = $this->option('template')) {
            $templates = Template::where('id', $templateId)->get();
        } else {
            $this->error('Specificare --template o --all');
            return 1;
        }

        $bar = $this->output->createProgressBar(count($templates));
        $bar->start();

        foreach ($templates as $template) {
            try {
                $maintenanceManager = new MaintenanceManager($template);

                if ($this->option('cleanup')) {
                    $maintenanceManager->cleanup();
                    $this->info("\nPulizia completata per il template {$template->id}");
                }

                if ($this->option('optimize')) {
                    $maintenanceManager->optimize();
                    $this->info("\nOttimizzazione completata per il template {$template->id}");
                }

                if ($this->option('validate')) {
                    $issues = $maintenanceManager->validate();
                    if (empty($issues)) {
                        $this->info("\nValidazione completata per il template {$template->id}");
                    } else {
                        $this->warn("\nProblemi trovati nel template {$template->id}:");
                        foreach ($issues as $issue) {
                            $this->warn("- {$issue}");
                        }
                    }
                }

            } catch (\Exception $e) {
                $this->error("\nErrore nella manutenzione del template {$template->id}: {$e->getMessage()}");
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Manutenzione completata');

        return 0;
    }
} 

---

## analysis-dettagliata-8

*Consolidated from: `analysis-dettagliata-finali-parte.md`*


## 8. Note Finali

### 8.1 Best Practices

#### 8.1.1 Documentazione
- Mantenere aggiornata la documentazione del codice
- Utilizzare PHPDoc per documentare classi, metodi e proprietà
- Includere esempi di utilizzo nella documentazione
- Documentare le dipendenze e i requisiti
- Mantenere un changelog aggiornato

#### 8.1.2 Logging
- Utilizzare livelli di log appropriati (info, warning, error)
- Includere contesto rilevante nei messaggi di log
- Implementare rotazione dei log
- Monitorare i log per errori e warning
- Configurare alert per errori critici

#### 8.1.3 Testing
- Mantenere una copertura dei test elevata
- Testare edge cases e scenari di errore
- Utilizzare test di integrazione per i flussi principali
- Implementare test di performance
- Eseguire test automatici in CI/CD

#### 8.1.4 Performance
- Implementare caching appropriato
- Ottimizzare query al database
- Minimizzare chiamate API esterne
- Utilizzare code per operazioni pesanti
- Monitorare metriche di performance

#### 8.1.5 Backup
- Eseguire backup regolari
- Verificare l'integrità dei backup
- Implementare retention policy
- Testare il ripristino dei backup
- Documentare procedure di backup/restore

#### 8.1.6 Code Review
- Rivedere il codice prima del merge
- Verificare la qualità del codice
- Controllare la sicurezza
- Verificare la manutenibilità
- Assicurare la coerenza dello stile

#### 8.1.7 Sicurezza
- Validare input utente
- Sanitizzare output
- Implementare rate limiting
- Utilizzare HTTPS
- Mantenere aggiornate le dipendenze

#### 8.1.8 Manutenzione
- Eseguire manutenzione regolare
- Monitorare l'utilizzo delle risorse
- Pulire dati obsoleti
- Ottimizzare performance
- Aggiornare dipendenze

### 8.2 Raccomandazioni

#### 8.2.1 Architettura
- Seguire i principi SOLID
- Utilizzare pattern architetturali appropriati
- Mantenere una struttura modulare
- Implementare dependency injection
- Separare le responsabilità

#### 8.2.2 Database
- Utilizzare indici appropriati
- Implementare soft deletes
- Utilizzare transazioni
- Ottimizzare query
- Implementare migrazioni

#### 8.2.3 Cache
- Implementare caching strategico
- Utilizzare cache tags
- Implementare cache invalidation
- Monitorare hit/miss ratio
- Configurare TTL appropriati

#### 8.2.4 API
- Documentare API con OpenAPI/Swagger
- Implementare versioning
- Utilizzare rate limiting
- Implementare autenticazione
- Validare input/output

#### 8.2.5 Frontend
- Implementare validazione lato client
- Utilizzare componenti riutilizzabili
- Implementare error handling
- Ottimizzare bundle size
- Implementare lazy loading

#### 8.2.6 Testing
- Implementare test unitari
- Implementare test di integrazione
- Implementare test end-to-end
- Implementare test di performance
- Implementare test di sicurezza

#### 8.2.7 Deployment
- Implementare CI/CD
- Utilizzare container
- Implementare rollback
- Monitorare deployment
- Documentare procedure

#### 8.2.8 Monitoraggio
- Implementare logging
- Implementare metrics
- Implementare alerting
- Monitorare performance
- Monitorare errori

### 8.3 Considerazioni Future

#### 8.3.1 Scalabilità
- Implementare sharding
- Utilizzare load balancing
- Implementare caching distribuito
- Ottimizzare query
- Monitorare performance

#### 8.3.2 Manutenibilità
- Documentare codice
- Implementare test
- Utilizzare pattern
- Refactoring regolare
- Code review

#### 8.3.3 Sicurezza
- Audit regolare
- Penetration testing
- Security headers
- Input validation
- Output sanitization

#### 8.3.4 Performance
- Profiling
- Ottimizzazione
- Caching
- Lazy loading
- Code splitting

#### 8.3.5 Feature
- A/B testing
- Analytics
- Personalizzazione
- Automazione
- Integrazione

### 8.4 Conclusione

Il modulo Notify è un componente complesso e robusto che fornisce funzionalità avanzate per la gestione delle email. L'architettura modulare e l'implementazione di best practices garantiscono manutenibilità, scalabilità e sicurezza.

Le principali caratteristiche includono:
- Gestione template MJML
- Versioning
- Traduzioni
- Analytics
- Backup
- Manutenzione

Le raccomandazioni per il futuro includono:
- Migliorare la documentazione
- Aumentare la copertura dei test
- Ottimizzare le performance
- Implementare nuove feature
- Migliorare la sicurezza

Il modulo è progettato per essere estensibile e personalizzabile, permettendo l'aggiunta di nuove funzionalità e l'integrazione con altri sistemi.

### 8.5 Riferimenti

#### 8.5.1 Documentazione
- [Laravel Documentation](https://laravel.com/docs)
- [MJML Documentation](https://mjml.io/documentation)
- [Mailgun Documentation](https://documentation.mailgun.com)
- [Filament Documentation](https://filamentphp.com/docs)

#### 8.5.2 Package
- [spatie/laravel-mail-templates](https://github.com/spatie/laravel-mail-templates)
- [mjml/mjml-php](https://github.com/mjmlio/mjml-php)
- [mailgun/mailgun-php](https://github.com/mailgun/mailgun-php)

#### 8.5.3 Tools
- [Laravel Telescope](https://laravel.com/docs/telescope)
- [Laravel Horizon](https://laravel.com/docs/horizon)
- [Laravel Dusk](https://laravel.com/docs/dusk)

#### 8.5.4 Best Practices
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
- [PHP The Right Way](https://phptherightway.com)
- [SOLID Principles](https://en.wikipedia.org/wiki/SOLID)

#### 8.5.5 Security
- [OWASP](https://owasp.org)
- [Laravel Security](https://laravel.com/docs/security)
- [PHP Security](https://phpsecurity.readthedocs.io)

#### 8.5.6 Testing
- [PHPUnit](https://phpunit.de)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Test-Driven Development](https://en.wikipedia.org/wiki/Test-driven_development)

#### 8.5.7 Performance
- [Laravel Performance](https://laravel.com/docs/performance)
- [PHP Performance](https://www.php.net/manual/en/performance.php)
- [Web Performance](https://web.dev/performance)

#### 8.5.8 Monitoring
- [Laravel Monitoring](https://laravel.com/docs/monitoring)
- [Application Monitoring](https://en.wikipedia.org/wiki/Application_performance_management)
- [Log Management](https://en.wikipedia.org/wiki/Log_management) 

---

## analysis-dettagliata

*Consolidated from: `analysis-dettagliata.md`*


## 1. Analisi delle Soluzioni di Template Email

### 1.1 Laravel Email Templates (simplepleb)
**Analisi Dettagliata:**
- Architettura basata su database
- Supporto per variabili dinamiche
- Integrazione nativa con Laravel
- Sistema di caching base

**Vantaggi:**
- Facile integrazione
- Bassa curva di apprendimento
- Manutenzione semplice
- Performance decenti

**Svantaggi:**
- Funzionalità limitate
- Poca personalizzazione
- Supporto community limitato
- Mancanza di editor visuale

### 1.2 Spatie Database Mail Templates
**Analisi Dettagliata:**
- Sistema robusto di gestione template
- Supporto multilingua avanzato
- Integrazione con Filament
- Sistema di versioning

**Vantaggi:**
- API ben documentata
- Ottima integrazione
- Supporto community attivo
- Funzionalità avanzate

**Svantaggi:**
- Overhead database
- Setup complesso
- Dipendenze multiple
- Curva di apprendimento

### 1.3 Laravel Mail Editor (Qoraiche)
**Analisi Dettagliata:**
- Editor visuale drag-and-drop
- Preview in tempo reale
- Gestione assets
- Integrazione Filament

**Vantaggi:**
- UI intuitiva
- Preview immediata
- Gestione facile
- Supporto responsive

**Svantaggi:**
- Performance overhead
- Dipendenze pesanti
- Manutenzione complessa
- Limitazioni tecniche

## 2. Framework e Librerie Analizzate

### 2.1 MJML
**Analisi Dettagliata:**
```php
namespace Modules\Notify\Services;

class MjmlService
{
    protected $mjml;
    protected $options;

    public function __construct()
    {
        $this->mjml = new \Mjml\Mjml();
        $this->options = [
            'minify' => true,
            'beautify' => false,
            'validationLevel' => 'strict'
        ];
    }

    public function compile($template)
    {
        try {
            $mjml = $this->convertToMjml($template);
            $result = $this->mjml->render($mjml, $this->options);
            
            return [
                'html' => $result->html,
                'errors' => $result->errors
            ];
        } catch (\Exception $e) {
            Log::error('MJML compilation failed', [
                'error' => $e->getMessage(),
                'template' => $template
            ]);
            throw $e;
        }
    }

    protected function convertToMjml($template)
    {
        return view('notify::mjml.wrapper', [
            'content' => $template,
            'styles' => $this->extractStyles($template),
            'components' => $this->extractComponents($template)
        ])->render();
    }
}
```

### 2.2 Mailgun
**Analisi Dettagliata:**
```php
namespace Modules\Notify\Services;

class MailgunService
{
    protected $mailgun;
    protected $domain;
    protected $analytics;

    public function __construct()
    {
        $this->mailgun = new \Mailgun\Mailgun(config('services.mailgun.secret'));
        $this->domain = config('services.mailgun.domain');
        $this->analytics = new MailgunAnalytics();
    }

    public function send($template, $data)
    {
        try {
            $result = $this->mailgun->messages()->send($this->domain, [
                'from' => $template->from,
                'to' => $data['to'],
                'subject' => $template->subject,
                'template' => $template->mailgun_template,
                'h:X-Mailgun-Variables' => json_encode($data),
                'o:tracking' => true,
                'o:tracking-clicks' => true,
                'o:tracking-opens' => true
            ]);

            $this->analytics->track($template, $result);

            return $result;
        } catch (\Exception $e) {
            Log::error('Mailgun send failed', [
                'error' => $e->getMessage(),
                'template' => $template,
                'data' => $data
            ]);
            throw $e;
        }
    }
}
```

## 3. Miglioramenti Strutturali Dettagliati

### 3.1 Sistema di Versioning Avanzato
```php
namespace Modules\Notify\Models;

class TemplateVersion extends Model
{
    protected $fillable = [
        'template_id',
        'version',
        'content',
        'created_by',
        'changes',
        'status'
    ];

    protected $casts = [
        'changes' => 'array',
        'status' => 'string'
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getDiff()
    {
        if (!$this->previousVersion) {
            return null;
        }

        return $this->compareVersions(
            $this->previousVersion->content,
            $this->content
        );
    }

    protected function compareVersions($old, $new)
    {
        // Implementazione diff
        return [
            'added' => $this->getAddedLines($old, $new),
            'removed' => $this->getRemovedLines($old, $new),
            'modified' => $this->getModifiedLines($old, $new)
        ];
    }
}
```

### 3.2 Gestione Multilingua Avanzata
```php
namespace Modules\Notify\Services;

class LocalizationService
{
    protected $translator;
    protected $cache;

    public function __construct()
    {
        $this->translator = app('translator');
        $this->cache = app('cache');
    }

    public function translate($template, $locale)
    {
        $cacheKey = "template.{$template->id}.{$locale}";
        
        return $this->cache->remember($cacheKey, 3600, function () use ($template, $locale) {
            return $template->translations()
                ->where('locale', $locale)
                ->first();
        });
    }

    public function syncTranslations($template, $locales)
    {
        foreach ($locales as $locale) {
            $translation = $template->translations()
                ->updateOrCreate(
                    ['locale' => $locale],
                    ['content' => $this->translateContent($template, $locale)]
                );

            $this->validateTranslation($translation);
            $this->cache->forget("template.{$template->id}.{$locale}");
        }
    }

    protected function validateTranslation($translation)
    {
        // Validazione traduzione
        if (!$this->isValidTranslation($translation)) {
            throw new InvalidTranslationException(
                "Invalid translation for locale: {$translation->locale}"
            );
        }
    }
}
```

### 3.3 Sistema di Analytics Avanzato
```php
namespace Modules\Notify\Services;

class AnalyticsService
{
    protected $metrics;
    protected $logger;

    public function __construct()
    {
        $this->metrics = new MetricsCollector();
        $this->logger = new AnalyticsLogger();
    }

    public function track($template, $event)
    {
        try {
            $analytics = TemplateAnalytics::create([
                'template_id' => $template->id,
                'event' => $event,
                'metadata' => [
                    'user_agent' => request()->userAgent(),
                    'ip' => request()->ip(),
                    'timestamp' => now(),
                    'session_id' => session()->getId(),
                    'user_id' => auth()->id()
                ]
            ]);

            $this->metrics->record($analytics);
            $this->logger->log($analytics);

            return $analytics;
        } catch (\Exception $e) {
            $this->logger->error('Analytics tracking failed', [
                'error' => $e->getMessage(),
                'template' => $template,
                'event' => $event
            ]);
            throw $e;
        }
    }

    public function getMetrics($template, $period = 'daily')
    {
        return $this->metrics->get($template, $period);
    }
}
```

## 4. Integrazioni Avanzate

### 4.1 Stripo Integration
```php
namespace Modules\Notify\Services;

class StripoService
{
    protected $stripo;
    protected $cache;

    public function __construct()
    {
        $this->stripo = new StripoClient(config('services.stripo.api_key'));
        $this->cache = app('cache');
    }

    public function export($template)
    {
        try {
            $result = $this->stripo->export([
                'html' => $template->content,
                'css' => $template->styles,
                'images' => $this->processImages($template->images)
            ]);

            $this->cache->put(
                "stripo.{$template->id}",
                $result,
                now()->addHours(24)
            );

            return $result;
        } catch (\Exception $e) {
            Log::error('Stripo export failed', [
                'error' => $e->getMessage(),
                'template' => $template
            ]);
            throw $e;
        }
    }

    protected function processImages($images)
    {
        return collect($images)->map(function ($image) {
            return [
                'url' => $image->url,
                'alt' => $image->alt,
                'width' => $image->width,
                'height' => $image->height
            ];
        })->toArray();
    }
}
```

## 5. Miglioramenti UI/UX Dettagliati

### 5.1 Editor Avanzato
```php
namespace Modules\Notify\Filament\Resources;

class TemplateResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Template')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Content')
                        ->schema([
                            Forms\Components\Builder::make('content')
                                ->blocks([
                                    Builder\Block::make('text')
                                        ->schema([
                                            Forms\Components\RichEditor::make('content')
                                                ->required()
                                                ->toolbarButtons([
                                                    'bold',
                                                    'italic',
                                                    'link',
                                                    'bulletList',
                                                    'orderedList'
                                                ])
                                        ]),
                                    Builder\Block::make('image')
                                        ->schema([
                                            Forms\Components\FileUpload::make('image')
                                                ->required()
                                                ->image()
                                                ->imageResizeMode('cover')
                                                ->imageCropAspectRatio('16:9')
                                                ->imageResizeTargetWidth('1920')
                                                ->imageResizeTargetHeight('1080')
                                        ])
                                ])
                        ]),
                    Forms\Components\Tabs\Tab::make('Preview')
                        ->schema([
                            Forms\Components\View::make('notify::preview')
                                ->livewire(TemplatePreview::class)
                        ]),
                    Forms\Components\Tabs\Tab::make('Settings')
                        ->schema([
                            Forms\Components\TextInput::make('subject')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Select::make('layout')
                                ->options([
                                    'default' => 'Default',
                                    'custom' => 'Custom'
                                ])
                                ->required(),
                            Forms\Components\Toggle::make('is_active')
                                ->label('Active')
                                ->default(true)
                        ])
                ])
        ]);
    }
}
```

### 5.2 Preview in Tempo Reale
```php
namespace Modules\Notify\Livewire;

class TemplatePreview extends Component
{
    public $template;
    public $content;
    public $preview;
    public $isLoading = false;

    protected $listeners = ['contentUpdated' => 'updatePreview'];

    public function mount($template)
    {
        $this->template = $template;
        $this->content = $template->content;
        $this->updatePreview();
    }

    public function updatePreview()
    {
        $this->isLoading = true;

        try {
            $this->preview = $this->templateService->render($this->template, [
                'content' => $this->content,
                'preview' => true
            ]);
        } catch (\Exception $e) {
            $this->addError('preview', $e->getMessage());
        }

        $this->isLoading = false;
    }

    public function render()
    {
        return view('notify::livewire.preview');
    }
}
```

## 6. Raccomandazioni Dettagliate

### 6.1 Fase 1: Core Features
1. **Sistema di Versioning**
   - Implementare versioning completo
   - Aggiungere diff tra versioni
   - Implementare rollback

2. **Editor Visuale**
   - Integrare editor drag-and-drop
   - Aggiungere preview in tempo reale
   - Implementare componenti riutilizzabili

3. **Preview**
   - Migliorare preview in browser
   - Aggiungere test su client email
   - Implementare responsive preview

### 6.2 Fase 2: Integrazioni
1. **Mailgun**
   - Integrare API completa
   - Implementare analytics
   - Aggiungere template variables

2. **MJML**
   - Aggiungere supporto MJML
   - Implementare conversione
   - Ottimizzare output

3. **Analytics**
   - Implementare tracking completo
   - Aggiungere dashboard
   - Implementare report

### 6.3 Fase 3: UI/UX
1. **Editor**
   - Migliorare UX
   - Aggiungere shortcuts
   - Implementare autosave

2. **Preview**
   - Aggiungere preview in tempo reale
   - Implementare responsive test
   - Aggiungere device preview

3. **Drag-and-Drop**
   - Implementare drag-and-drop
   - Aggiungere componenti
   - Implementare templates

### 6.4 Fase 4: Performance
1. **Caching**
   - Implementare Redis
   - Ottimizzare query
   - Implementare lazy loading

2. **Queue**
   - Implementare queue
   - Aggiungere retry logic
   - Monitorare queue health

3. **Assets**
   - Ottimizzare immagini
   - Minificare CSS/JS
   - Implementare CDN

## 7. Note Tecniche Dettagliate

### 7.1 Performance
1. **Caching**
   - Utilizzare Redis per caching
   - Implementare cache tags
   - Ottimizzare cache keys

2. **Database**
   - Aggiungere indici
   - Ottimizzare query
   - Implementare eager loading

3. **Assets**
   - Minificare assets
   - Ottimizzare immagini
   - Implementare CDN

### 7.2 Sicurezza
1. **Validazione**
   - Validare input
   - Sanitizzare output
   - Implementare rate limiting

2. **Crittografia**
   - Crittografare dati
   - Implementare HTTPS
   - Aggiungere SPF/DKIM

3. **Monitoraggio**
   - Implementare logging
   - Aggiungere alert
   - Monitorare accessi

### 7.3 Manutenibilità
1. **Documentazione**
   - Documentare API
   - Aggiungere commenti
   - Mantenere changelog

2. **Testing**
   - Aggiungere unit test
   - Implementare feature test
   - Aggiungere integration test

3. **Logging**
   - Implementare logging
   - Aggiungere context
   - Monitorare errori

## 8. Collegamenti Utili

- [MJML Documentation](https://mjml.io/documentation/)
- [Mailgun API](https://documentation.mailgun.com/en/latest/api_reference.html)
- [Filament Documentation](https://filamentphp.com/docs)
- [Laravel Mail Documentation](https://laravel.com/docs/mail)
- [Stripo Documentation](https://stripo.email/templates/)
- [Beefree Documentation](https://beefree.io/templates)
- [Unlayer Documentation](https://unlayer.com/)
- [Mailersend Documentation](https://www.mailersend.com/)
- [Mailjet Documentation](https://www.mailjet.com/) 

---

## analysis-improvements

*Consolidated from: `analysis-improvements.md`*


## Analisi delle Soluzioni Esistenti

### 1. Editor Visuale
Dall'analisi di [Laravel Mail Editor](https://github.com/Qoraiche/laravel-mail-editor) e [Visual Builder Email Templates](https://filamentphp.com/plugins/visual-builder-email-templates), possiamo implementare:

```php
namespace Modules\Notify\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Forms\Components\Builder;

class TemplateResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Builder::make('content')
                ->blocks([
                    Builder\Block::make('text')
                        ->schema([
                            Forms\Components\RichEditor::make('content')
                                ->required()
                        ]),
                    Builder\Block::make('image')
                        ->schema([
                            Forms\Components\FileUpload::make('image')
                                ->required()
                        ])
                ])
        ]);
    }
}
```

### 2. Preview in Browser
Basato su [How to Render Emails in Browser](https://how.dev/answers/how-to-render-emails-in-browser-using-laravel):

```php
namespace Modules\Notify\Http\Controllers;

class PreviewController extends Controller
{
    public function preview($template)
    {
        $rendered = $this->templateService->render($template, [
            'preview' => true,
            'data' => $this->getPreviewData()
        ]);

        return response()->view('notify::preview', [
            'content' => $rendered
        ]);
    }
}
```

### 3. Responsive Design con MJML
Dall'analisi di [MJML](https://mjml.io/), implementiamo:

```php
namespace Modules\Notify\Services;

class MjmlService
{
    public function compile($template)
    {
        $mjml = $this->convertToMjml($template);
        return $this->compileMjml($mjml);
    }

    protected function convertToMjml($template)
    {
        // Conversione del template in MJML
        return view('notify::mjml.wrapper', [
            'content' => $template
        ])->render();
    }
}
```

## Miglioramenti Strutturali

### 1. Sistema di Versioning
```php
namespace Modules\Notify\Models;

class TemplateVersion extends Model
{
    protected $fillable = [
        'template_id',
        'version',
        'content',
        'created_by'
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
```

### 2. Gestione Multilingua Avanzata
```php
namespace Modules\Notify\Services;

class LocalizationService
{
    public function translate($template, $locale)
    {
        return $template->translations()
            ->where('locale', $locale)
            ->first();
    }

    public function syncTranslations($template, $locales)
    {
        foreach ($locales as $locale) {
            $template->translations()->updateOrCreate(
                ['locale' => $locale],
                ['content' => $this->translateContent($template, $locale)]
            );
        }
    }
}
```

### 3. Sistema di Analytics
```php
namespace Modules\Notify\Services;

class AnalyticsService
{
    public function track($template, $event)
    {
        return TemplateAnalytics::create([
            'template_id' => $template->id,
            'event' => $event,
            'metadata' => [
                'user_agent' => request()->userAgent(),
                'ip' => request()->ip(),
                'timestamp' => now()
            ]
        ]);
    }
}
```

## Integrazione con Servizi Esterni

### 1. Mailgun Integration
```php
namespace Modules\Notify\Services;

class MailgunService
{
    public function send($template, $data)
    {
        return $this->mailgun->messages()->send(config('services.mailgun.domain'), [
            'from' => $template->from,
            'to' => $data['to'],
            'subject' => $template->subject,
            'template' => $template->mailgun_template,
            'h:X-Mailgun-Variables' => json_encode($data)
        ]);
    }
}
```

### 2. Stripo Integration
```php
namespace Modules\Notify\Services;

class StripoService
{
    public function export($template)
    {
        return $this->stripo->export([
            'html' => $template->content,
            'css' => $template->styles
        ]);
    }
}
```

## Miglioramenti UI/UX

### 1. Editor Avanzato
```php
namespace Modules\Notify\Filament\Resources;

class TemplateResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Template')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Content')
                        ->schema([
                            Forms\Components\RichEditor::make('content')
                                ->required()
                        ]),
                    Forms\Components\Tabs\Tab::make('Preview')
                        ->schema([
                            Forms\Components\View::make('notify::preview')
                        ]),
                    Forms\Components\Tabs\Tab::make('Settings')
                        ->schema([
                            Forms\Components\TextInput::make('subject')
                                ->required(),
                            Forms\Components\Select::make('layout')
                                ->options([
                                    'default' => 'Default',
                                    'custom' => 'Custom'
                                ])
                        ])
                ])
        ]);
    }
}
```

### 2. Preview in Tempo Reale
```php
namespace Modules\Notify\Livewire;

class TemplatePreview extends Component
{
    public $template;
    public $content;

    public function updatedContent()
    {
        $this->preview = $this->templateService->render($this->template, [
            'content' => $this->content
        ]);
    }

    public function render()
    {
        return view('notify::livewire.preview');
    }
}
```

## Raccomandazioni per l'Implementazione

1. **Fase 1: Core Features**
   - Implementare sistema di versioning
   - Aggiungere editor visuale
   - Migliorare preview

2. **Fase 2: Integrazioni**
   - Integrare Mailgun
   - Aggiungere supporto MJML
   - Implementare analytics

3. **Fase 3: UI/UX**
   - Migliorare editor
   - Aggiungere preview in tempo reale
   - Implementare drag-and-drop

4. **Fase 4: Performance**
   - Ottimizzare caching
   - Migliorare query
   - Implementare queue

## Note Tecniche

1. **Performance**
   - Utilizzare Redis per caching
   - Implementare lazy loading
   - Ottimizzare query database

2. **Sicurezza**
   - Sanitizzare input
   - Implementare rate limiting
   - Validare template

3. **Manutenibilità**
   - Documentare API
   - Aggiungere test
   - Implementare logging

## Collegamenti Utili

- [MJML Documentation](https://mjml.io/documentation/)
- [Mailgun API](https://documentation.mailgun.com/en/latest/api_reference.html)
- [Filament Documentation](https://filamentphp.com/docs)
- [Laravel Mail Documentation](https://laravel.com/docs/mail) 

---

## analysis

*Consolidated from: `analysis.md`*


## Overview
The Notify module provides specialized functionality within the Laravel application.

## Directory Structure
```
Modules/Notify/
├── app/
│   ├── Models/
│   ├── Http/
│   └── Providers/
├── config/
├── database/
├── resources/
└── routes/
```

## Key Components

### Models
- Must extend BaseModel from the module's namespace
- Follow Laravel Model Array Properties Rules
- PHPStan Level 7 compliance required

### Features
1. Core Notify Management
2. Integration with Related Modules
3. Data Processing and Validation

## Dependencies
- Laravel Framework
- Xot Module: Core functionality
- User Module: Authentication and authorization

## Integration Points
- Xot Module: Base functionality and core services
- User Module: User management and permissions
- Activity Module: Action logging
- Media Module: File handling (if applicable)

## Security Considerations
- Access control via policies
- Input validation and sanitization
- CSRF protection
- XSS prevention
- SQL injection prevention

## Performance Considerations
- Database query optimization
- Eager loading relationships
- Caching implementation
- Resource optimization

## Testing Strategy
- Unit tests for models and services
- Feature tests for controllers
- Integration tests with dependent modules
- Security testing
- Performance testing
### Versione HEAD


## Collegamenti tra versioni di analysis.md
* [analysis.md](../../../notify/docs/analysis.md)
* [analysis.md](../../../notify/docs/phpstan/analysis.md)
* [analysis.md](../../../xot/docs/analysis.md)
* [analysis.md](../../../xot/docs/phpstan/analysis.md)
* [analysis.md](../../../user/docs/analysis.md)
* [analysis.md](../../../user/docs/phpstan/analysis.md)
* [analysis.md](../../../ui/docs/analysis.md)
* [analysis.md](../../../ui/docs/phpstan/analysis.md)
* [analysis.md](../../../job/docs/analysis.md)
* [analysis.md](../../../job/docs/phpstan/analysis.md)
* [analysis.md](../../../media/docs/analysis.md)
* [analysis.md](../../analysis.md)
* [analysis.md](../../../notify/docs/phpstan/analysis.md)
* [analysis.md](../../../xot/docs/analysis.md)
* [analysis.md](../../../xot/docs/phpstan/analysis.md)
* [analysis.md](../../../../User/docs/analysis.md)
* [analysis.md](../../../user/docs/phpstan/analysis.md)
* [analysis.md](../../../ui/docs/analysis.md)
* [analysis.md](../../../ui/docs/phpstan/analysis.md)
* [analysis.md](../../../../Job/docs/analysis.md)
* [analysis.md](../../../job/docs/phpstan/analysis.md)
* [analysis.md](../../../../Media/docs/analysis.md)
* [analysis.md](../../../media/docs/phpstan/analysis.md)
* [analysis.md](../../../../themes/one/docs/analysis.md)


### Versione Incoming


---


---

## analysisettagliata-2

*Consolidated from: `analysisettagliata-modelli-relazioni.md`*


## 2. Modelli e Relazioni

### 2.1 Template Model

#### 2.1.1 Struttura Base
```php
namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Template extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'templates';

    protected $fillable = [
        'name',              // Nome del template
        'subject',           // Oggetto email
        'content',           // Contenuto template
        'layout',            // Layout utilizzato
        'is_active',         // Stato attivo/inattivo
        'version',           // Versione corrente
        'from_name',         // Nome mittente
        'from_email',        // Email mittente
        'reply_to',          // Email risposta
        'cc',                // Copie conoscenza
        'bcc',               // Copie nascoste
        'attachments',       // Allegati
        'variables',         // Variabili template
        'settings'           // Impostazioni
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'version' => 'integer',
        'attachments' => 'array',
        'variables' => 'array',
        'settings' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'full_name',
        'status_label',
        'is_latest',
        'has_translations'
    ];
}
```

#### 2.1.2 Relazioni
```php
public function versions()
{
    return $this->hasMany(TemplateVersion::class);
}

public function translations()
{
    return $this->hasMany(TemplateTranslation::class);
}

public function analytics()
{
    return $this->hasMany(TemplateAnalytics::class);
}

public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}

public function updater()
{
    return $this->belongsTo(User::class, 'updated_by');
}

public function latestVersion()
{
    return $this->hasOne(TemplateVersion::class)->latest();
}

public function defaultTranslation()
{
    return $this->hasOne(TemplateTranslation::class)
        ->where('locale', config('app.locale'));
}
```

#### 2.1.3 Accessori e Mutatori
```php
public function getFullNameAttribute()
{
    return "{$this->name} (v{$this->version})";
}

public function getStatusLabelAttribute()
{
    return $this->is_active ? 'Active' : 'Inactive';
}

public function getIsLatestAttribute()
{
    return $this->version === $this->versions()->max('version');
}

public function getHasTranslationsAttribute()
{
    return $this->translations()->count() > 0;
}

public function setVariablesAttribute($value)
{
    $this->attributes['variables'] = json_encode($value);
}

public function getVariablesAttribute($value)
{
    return json_decode($value, true);
}

public function setSettingsAttribute($value)
{
    $this->attributes['settings'] = json_encode($value);
}

public function getSettingsAttribute($value)
{
    return json_decode($value, true);
}
```

#### 2.1.4 Scope Query
```php
public function scopeActive($query)
{
    return $query->where('is_active', true);
}

public function scopeInactive($query)
{
    return $query->where('is_active', false);
}

public function scopeLatest($query)
{
    return $query->orderBy('version', 'desc');
}

public function scopeByLayout($query, $layout)
{
    return $query->where('layout', $layout);
}

public function scopeSearch($query, $term)
{
    return $query->where(function($q) use ($term) {
        $q->where('name', 'like', "%{$term}%")
          ->orWhere('subject', 'like', "%{$term}%")
          ->orWhere('content', 'like', "%{$term}%");
    });
}
```

#### 2.1.5 Eventi del Modello
```php
protected static function booted()
{
    static::creating(function ($template) {
        $template->created_by = auth()->id();
        $template->version = 1;
    });

    static::updating(function ($template) {
        $template->updated_by = auth()->id();
    });

    static::deleting(function ($template) {
        $template->versions()->delete();
        $template->translations()->delete();
        $template->analytics()->delete();
    });

    static::restored(function ($template) {
        $template->versions()->restore();
        $template->translations()->restore();
    });
}
```

### 2.2 TemplateVersion Model

#### 2.2.1 Struttura Base
```php
namespace Modules\Notify\Models;

class TemplateVersion extends Model
{
    use HasFactory;

    protected $table = 'template_versions';

    protected $fillable = [
        'template_id',
        'version',
        'content',
        'created_by',
        'changes',
        'status',
        'notes'
    ];

    protected $casts = [
        'version' => 'integer',
        'changes' => 'array',
        'status' => 'string',
        'created_at' => 'datetime'
    ];

    protected $appends = [
        'diff',
        'creator_name'
    ];
}
```

#### 2.2.2 Relazioni
```php
public function template()
{
    return $this->belongsTo(Template::class);
}

public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}

public function previousVersion()
{
    return $this->template->versions()
        ->where('version', '<', $this->version)
        ->latest('version')
        ->first();
}
```

#### 2.2.3 Accessori e Mutatori
```php
public function getDiffAttribute()
{
    if (!$this->previousVersion) {
        return null;
    }

    return $this->compareVersions(
        $this->previousVersion->content,
        $this->content
    );
}

public function getCreatorNameAttribute()
{
    return $this->creator ? $this->creator->name : 'System';
}

public function setChangesAttribute($value)
{
    $this->attributes['changes'] = json_encode($value);
}

public function getChangesAttribute($value)
{
    return json_decode($value, true);
}
```

#### 2.2.4 Metodi di Confronto
```php
protected function compareVersions($old, $new)
{
    return [
        'added' => $this->getAddedLines($old, $new),
        'removed' => $this->getRemovedLines($old, $new),
        'modified' => $this->getModifiedLines($old, $new)
    ];
}

protected function getAddedLines($old, $new)
{
    $oldLines = explode("\n", $old);
    $newLines = explode("\n", $new);
    return array_diff($newLines, $oldLines);
}

protected function getRemovedLines($old, $new)
{
    $oldLines = explode("\n", $old);
    $newLines = explode("\n", $new);
    return array_diff($oldLines, $newLines);
}

protected function getModifiedLines($old, $new)
{
    $oldLines = explode("\n", $old);
    $newLines = explode("\n", $new);
    $modified = [];

    foreach ($oldLines as $index => $line) {
        if (isset($newLines[$index]) && $line !== $newLines[$index]) {
            $modified[] = [
                'old' => $line,
                'new' => $newLines[$index]
            ];
        }
    }

    return $modified;
}
```

### 2.3 TemplateTranslation Model

#### 2.3.1 Struttura Base
```php
namespace Modules\Notify\Models;

class TemplateTranslation extends Model
{
    use HasFactory;

    protected $table = 'template_translations';

    protected $fillable = [
        'template_id',
        'locale',
        'content',
        'subject',
        'from_name',
        'variables'
    ];

    protected $casts = [
        'variables' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $appends = [
        'is_complete',
        'missing_variables'
    ];
}
```

#### 2.3.2 Relazioni
```php
public function template()
{
    return $this->belongsTo(Template::class);
}

public function translator()
{
    return $this->belongsTo(User::class, 'translated_by');
}
```

#### 2.3.3 Accessori e Mutatori
```php
public function getIsCompleteAttribute()
{
    return $this->validateVariables();
}

public function getMissingVariablesAttribute()
{
    $required = $this->template->variables;
    $provided = $this->variables ?? [];
    return array_diff($required, array_keys($provided));
}

public function setVariablesAttribute($value)
{
    $this->attributes['variables'] = json_encode($value);
}

public function getVariablesAttribute($value)
{
    return json_decode($value, true);
}
```

#### 2.3.4 Validazione
```php
public function validateVariables()
{
    $required = $this->template->variables;
    $provided = $this->variables ?? [];

    foreach ($required as $variable) {
        if (!isset($provided[$variable])) {
            throw new MissingVariableException(
                "Missing required variable: {$variable}"
            );
        }
    }

    return true;
}

public function validateContent()
{
    // Validazione HTML
    $validator = new HtmlValidator();
    $result = $validator->validate($this->content);

    if (!$result->isValid()) {
        throw new InvalidContentException(
            "Invalid HTML content: " . implode(', ', $result->getErrors())
        );
    }

    return true;
}

public function validateSubject()
{
    if (empty($this->subject)) {
        throw new InvalidSubjectException(
            "Subject cannot be empty"
        );
    }

    if (strlen($this->subject) > 255) {
        throw new InvalidSubjectException(
            "Subject cannot be longer than 255 characters"
        );
    }

    return true;
}
```

### 2.4 TemplateAnalytics Model

#### 2.4.1 Struttura Base
```php
namespace Modules\Notify\Models;

class TemplateAnalytics extends Model
{
    use HasFactory;

    protected $table = 'template_analytics';

    protected $fillable = [
        'template_id',
        'event',
        'metadata',
        'user_agent',
        'ip_address',
        'session_id'
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime'
    ];

    protected $appends = [
        'event_label',
        'formatted_metadata'
    ];
}
```

#### 2.4.2 Relazioni
```php
public function template()
{
    return $this->belongsTo(Template::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
```

#### 2.4.3 Accessori e Mutatori
```php
public function getEventLabelAttribute()
{
    return [
        'email.sent' => 'Email Sent',
        'email.opened' => 'Email Opened',
        'email.clicked' => 'Email Clicked',
        'email.bounced' => 'Email Bounced',
        'email.complained' => 'Email Complained',
        'email.unsubscribed' => 'Email Unsubscribed'
    ][$this->event] ?? $this->event;
}

public function getFormattedMetadataAttribute()
{
    return collect($this->metadata)->map(function ($value, $key) {
        return [
            'key' => $key,
            'value' => $value,
            'type' => gettype($value)
        ];
    })->values();
}

public function setMetadataAttribute($value)
{
    $this->attributes['metadata'] = json_encode($value);
}

public function getMetadataAttribute($value)
{
    return json_decode($value, true);
}
```

#### 2.4.4 Scope Query
```php
public function scopeByEvent($query, $event)
{
    return $query->where('event', $event);
}

public function scopeByDateRange($query, $start, $end)
{
    return $query->whereBetween('created_at', [$start, $end]);
}

public function scopeByTemplate($query, $templateId)
{
    return $query->where('template_id', $templateId);
}

public function scopeByUser($query, $userId)
{
    return $query->where('user_id', $userId);
}
```

### 2.5 Migrations

#### 2.5.1 Templates Table
```php
Schema::create('templates', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('subject');
    $table->text('content');
    $table->string('layout')->default('default');
    $table->boolean('is_active')->default(true);
    $table->integer('version')->default(1);
    $table->string('from_name')->nullable();
    $table->string('from_email')->nullable();
    $table->string('reply_to')->nullable();
    $table->json('cc')->nullable();
    $table->json('bcc')->nullable();
    $table->json('attachments')->nullable();
    $table->json('variables')->nullable();
    $table->json('settings')->nullable();
    $table->foreignId('created_by')->constrained('users');
    $table->foreignId('updated_by')->nullable()->constrained('users');
    $table->timestamps();
    $table->softDeletes();

    $table->index('name');
    $table->index('is_active');
    $table->index('version');
});
```

#### 2.5.2 Template Versions Table
```php
Schema::create('template_versions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained()->onDelete('cascade');
    $table->integer('version');
    $table->text('content');
    $table->foreignId('created_by')->constrained('users');
    $table->json('changes')->nullable();
    $table->string('status')->default('draft');
    $table->text('notes')->nullable();
    $table->timestamps();

    $table->unique(['template_id', 'version']);
    $table->index('status');
});
```

#### 2.5.3 Template Translations Table
```php
Schema::create('template_translations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained()->onDelete('cascade');
    $table->string('locale', 5);
    $table->text('content');
    $table->string('subject');
    $table->string('from_name')->nullable();
    $table->json('variables')->nullable();
    $table->foreignId('translated_by')->constrained('users');
    $table->timestamps();

    $table->unique(['template_id', 'locale']);
    $table->index('locale');
});
```

#### 2.5.4 Template Analytics Table
```php
Schema::create('template_analytics', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained()->onDelete('cascade');
    $table->string('event');
    $table->json('metadata')->nullable();
    $table->string('user_agent')->nullable();
    $table->string('ip_address', 45)->nullable();
    $table->string('session_id')->nullable();
    $table->foreignId('user_id')->nullable()->constrained('users');
    $table->timestamps();

    $table->index('event');
    $table->index('created_at');
    $table->index(['template_id', 'event']);
});
``` 

---

## analysisettagliata-3

*Consolidated from: `analysisettagliata-servizi-core.md`*


## 3. Servizi Core

### 3.1 TemplateService

#### 3.1.1 Struttura Base
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;
use Modules\Notify\Events\TemplateCreated;
use Modules\Notify\Events\TemplateUpdated;
use Modules\Notify\Events\TemplateDeleted;
use Modules\Notify\Exceptions\TemplateException;

class TemplateService
{
    protected $cache;
    protected $mjml;
    protected $mailgun;

    public function __construct(
        CacheService $cache,
        MjmlService $mjml,
        MailgunService $mailgun
    ) {
        $this->cache = $cache;
        $this->mjml = $mjml;
        $this->mailgun = $mailgun;
    }
}
```

#### 3.1.2 Gestione Template
```php
public function create(array $data): Template
{
    try {
        DB::beginTransaction();

        $template = Template::create([
            'name' => $data['name'],
            'subject' => $data['subject'],
            'content' => $data['content'],
            'layout' => $data['layout'] ?? 'default',
            'from_name' => $data['from_name'] ?? null,
            'from_email' => $data['from_email'] ?? null,
            'reply_to' => $data['reply_to'] ?? null,
            'cc' => $data['cc'] ?? null,
            'bcc' => $data['bcc'] ?? null,
            'attachments' => $data['attachments'] ?? null,
            'variables' => $data['variables'] ?? [],
            'settings' => $data['settings'] ?? []
        ]);

        // Crea versione iniziale
        $template->versions()->create([
            'version' => 1,
            'content' => $data['content'],
            'created_by' => auth()->id(),
            'status' => 'published'
        ]);

        // Crea traduzione default
        $template->translations()->create([
            'locale' => config('app.locale'),
            'content' => $data['content'],
            'subject' => $data['subject'],
            'from_name' => $data['from_name'] ?? null,
            'variables' => $data['variables'] ?? [],
            'translated_by' => auth()->id()
        ]);

        DB::commit();

        event(new TemplateCreated($template));

        return $template;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to create template: {$e->getMessage()}"
        );
    }
}

public function update(Template $template, array $data): Template
{
    try {
        DB::beginTransaction();

        $oldVersion = $template->version;
        $newVersion = $oldVersion + 1;

        // Aggiorna template
        $template->update([
            'name' => $data['name'] ?? $template->name,
            'subject' => $data['subject'] ?? $template->subject,
            'content' => $data['content'] ?? $template->content,
            'layout' => $data['layout'] ?? $template->layout,
            'from_name' => $data['from_name'] ?? $template->from_name,
            'from_email' => $data['from_email'] ?? $template->from_email,
            'reply_to' => $data['reply_to'] ?? $template->reply_to,
            'cc' => $data['cc'] ?? $template->cc,
            'bcc' => $data['bcc'] ?? $template->bcc,
            'attachments' => $data['attachments'] ?? $template->attachments,
            'variables' => $data['variables'] ?? $template->variables,
            'settings' => $data['settings'] ?? $template->settings,
            'version' => $newVersion
        ]);

        // Crea nuova versione
        $template->versions()->create([
            'version' => $newVersion,
            'content' => $data['content'] ?? $template->content,
            'created_by' => auth()->id(),
            'changes' => $this->getChanges($template, $data),
            'status' => 'published',
            'notes' => $data['notes'] ?? null
        ]);

        // Aggiorna traduzione default
        $template->translations()
            ->where('locale', config('app.locale'))
            ->update([
                'content' => $data['content'] ?? $template->content,
                'subject' => $data['subject'] ?? $template->subject,
                'from_name' => $data['from_name'] ?? $template->from_name,
                'variables' => $data['variables'] ?? $template->variables
            ]);

        DB::commit();

        event(new TemplateUpdated($template));

        return $template;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to update template: {$e->getMessage()}"
        );
    }
}

public function delete(Template $template): bool
{
    try {
        DB::beginTransaction();

        $template->delete();

        DB::commit();

        event(new TemplateDeleted($template));

        return true;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to delete template: {$e->getMessage()}"
        );
    }
}
```

#### 3.1.3 Gestione Versioni
```php
public function createVersion(Template $template, array $data): TemplateVersion
{
    try {
        DB::beginTransaction();

        $newVersion = $template->version + 1;

        $version = $template->versions()->create([
            'version' => $newVersion,
            'content' => $data['content'],
            'created_by' => auth()->id(),
            'changes' => $this->getChanges($template, $data),
            'status' => $data['status'] ?? 'draft',
            'notes' => $data['notes'] ?? null
        ]);

        $template->update(['version' => $newVersion]);

        DB::commit();

        return $version;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to create version: {$e->getMessage()}"
        );
    }
}

public function rollbackVersion(Template $template, int $version): Template
{
    try {
        DB::beginTransaction();

        $targetVersion = $template->versions()
            ->where('version', $version)
            ->firstOrFail();

        $template->update([
            'content' => $targetVersion->content,
            'version' => $version
        ]);

        DB::commit();

        return $template;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to rollback version: {$e->getMessage()}"
        );
    }
}

protected function getChanges(Template $template, array $data): array
{
    $changes = [];

    foreach ($data as $key => $value) {
        if (isset($template->$key) && $template->$key !== $value) {
            $changes[$key] = [
                'old' => $template->$key,
                'new' => $value
            ];
        }
    }

    return $changes;
}
```

#### 3.1.4 Gestione Traduzioni
```php
public function createTranslation(Template $template, array $data): TemplateTranslation
{
    try {
        DB::beginTransaction();

        $translation = $template->translations()->create([
            'locale' => $data['locale'],
            'content' => $data['content'],
            'subject' => $data['subject'],
            'from_name' => $data['from_name'] ?? null,
            'variables' => $data['variables'] ?? [],
            'translated_by' => auth()->id()
        ]);

        DB::commit();

        return $translation;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to create translation: {$e->getMessage()}"
        );
    }
}

public function updateTranslation(TemplateTranslation $translation, array $data): TemplateTranslation
{
    try {
        DB::beginTransaction();

        $translation->update([
            'content' => $data['content'] ?? $translation->content,
            'subject' => $data['subject'] ?? $translation->subject,
            'from_name' => $data['from_name'] ?? $translation->from_name,
            'variables' => $data['variables'] ?? $translation->variables
        ]);

        DB::commit();

        return $translation;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to update translation: {$e->getMessage()}"
        );
    }
}

public function deleteTranslation(TemplateTranslation $translation): bool
{
    try {
        DB::beginTransaction();

        $translation->delete();

        DB::commit();

        return true;

    } catch (\Exception $e) {
        DB::rollBack();
        throw new TemplateException(
            "Failed to delete translation: {$e->getMessage()}"
        );
    }
}
```

#### 3.1.5 Preview e Test
```php
public function preview(Template $template, array $variables = []): string
{
    try {
        $content = $this->replaceVariables(
            $template->content,
            $variables
        );

        return $this->mjml->compile($content);

    } catch (\Exception $e) {
        throw new TemplateException(
            "Failed to preview template: {$e->getMessage()}"
        );
    }
}

public function test(Template $template, string $email, array $variables = []): bool
{
    try {
        $content = $this->preview($template, $variables);

        return $this->mailgun->send([
            'to' => $email,
            'subject' => $template->subject,
            'html' => $content,
            'from_name' => $template->from_name,
            'from_email' => $template->from_email,
            'reply_to' => $template->reply_to,
            'cc' => $template->cc,
            'bcc' => $template->bcc,
            'attachments' => $template->attachments
        ]);

    } catch (\Exception $e) {
        throw new TemplateException(
            "Failed to test template: {$e->getMessage()}"
        );
    }
}

protected function replaceVariables(string $content, array $variables): string
{
    foreach ($variables as $key => $value) {
        $content = str_replace(
            "{{$key}}",
            $value,
            $content
        );
    }

    return $content;
}
```

### 3.2 MjmlService

#### 3.2.1 Struttura Base
```php
namespace Modules\Notify\Services;

use MJML\Mjml;
use MJML\MjmlException;

class MjmlService
{
    protected $mjml;
    protected $cache;

    public function __construct(CacheService $cache)
    {
        $this->mjml = new Mjml();
        $this->cache = $cache;
    }
}
```

#### 3.2.2 Compilazione MJML
```php
public function compile(string $content): string
{
    try {
        $cacheKey = $this->getCacheKey($content);

        return $this->cache->remember($cacheKey, function () use ($content) {
            return $this->mjml->render($content);
        });

    } catch (MjmlException $e) {
        throw new TemplateException(
            "Failed to compile MJML: {$e->getMessage()}"
        );
    }
}

public function validate(string $content): bool
{
    try {
        return $this->mjml->validate($content);
    } catch (MjmlException $e) {
        return false;
    }
}

protected function getCacheKey(string $content): string
{
    return 'mjml:' . md5($content);
}
```

#### 3.2.3 Estrazione Stili
```php
public function extractStyles(string $content): array
{
    $styles = [];

    // Estrai stili inline
    preg_match_all('/style="([^"]+)"/', $content, $matches);
    foreach ($matches[1] as $style) {
        $styles[] = $style;
    }

    // Estrai stili MJML
    preg_match_all('/mj-style>([^<]+)<\/mj-style>/', $content, $matches);
    foreach ($matches[1] as $style) {
        $styles[] = $style;
    }

    return array_unique($styles);
}

public function extractComponents(string $content): array
{
    $components = [];

    // Estrai componenti MJML
    preg_match_all('/<mj-([^>]+)>/', $content, $matches);
    foreach ($matches[1] as $component) {
        $components[] = $component;
    }

    return array_unique($components);
}
```

### 3.3 MailgunService

#### 3.3.1 Struttura Base
```php
namespace Modules\Notify\Services;

use Mailgun\Mailgun;
use Mailgun\Exception\MailgunException;

class MailgunService
{
    protected $mailgun;
    protected $domain;
    protected $cache;

    public function __construct(CacheService $cache)
    {
        $this->mailgun = Mailgun::create(
            config('services.mailgun.secret')
        );
        $this->domain = config('services.mailgun.domain');
        $this->cache = $cache;
    }
}
```

#### 3.3.2 Invio Email
```php
public function send(array $data): bool
{
    try {
        $message = [
            'from' => $this->formatFrom($data),
            'to' => $data['to'],
            'subject' => $data['subject'],
            'html' => $data['html'],
            'reply-to' => $data['reply_to'] ?? null,
            'cc' => $data['cc'] ?? null,
            'bcc' => $data['bcc'] ?? null,
            'attachment' => $this->formatAttachments($data['attachments'] ?? [])
        ];

        $response = $this->mailgun->messages()->send(
            $this->domain,
            $message
        );

        $this->logMessage($response);

        return true;

    } catch (MailgunException $e) {
        throw new TemplateException(
            "Failed to send email: {$e->getMessage()}"
        );
    }
}

protected function formatFrom(array $data): string
{
    if (isset($data['from_name'])) {
        return "{$data['from_name']} <{$data['from_email']}>";
    }

    return $data['from_email'];
}

protected function formatAttachments(array $attachments): array
{
    $formatted = [];

    foreach ($attachments as $attachment) {
        $formatted[] = [
            'filePath' => $attachment['path'],
            'filename' => $attachment['name']
        ];
    }

    return $formatted;
}

protected function logMessage($response): void
{
    // Log messaggio inviato
    Log::info('Email sent', [
        'id' => $response->getId(),
        'message' => $response->getMessage()
    ]);
}
```

#### 3.3.3 Gestione Eventi
```php
public function handleWebhook(array $data): void
{
    try {
        $event = $data['event'];
        $messageId = $data['message-id'];

        switch ($event) {
            case 'delivered':
                $this->handleDelivered($messageId);
                break;
            case 'opened':
                $this->handleOpened($messageId);
                break;
            case 'clicked':
                $this->handleClicked($messageId);
                break;
            case 'bounced':
                $this->handleBounced($messageId);
                break;
            case 'complained':
                $this->handleComplained($messageId);
                break;
            case 'unsubscribed':
                $this->handleUnsubscribed($messageId);
                break;
        }

    } catch (\Exception $e) {
        Log::error('Webhook error', [
            'error' => $e->getMessage(),
            'data' => $data
        ]);
    }
}

protected function handleDelivered(string $messageId): void
{
    // Aggiorna analytics
    $this->updateAnalytics($messageId, 'delivered');
}

protected function handleOpened(string $messageId): void
{
    // Aggiorna analytics
    $this->updateAnalytics($messageId, 'opened');
}

protected function handleClicked(string $messageId): void
{
    // Aggiorna analytics
    $this->updateAnalytics($messageId, 'clicked');
}

protected function handleBounced(string $messageId): void
{
    // Aggiorna analytics
    $this->updateAnalytics($messageId, 'bounced');
}

protected function handleComplained(string $messageId): void
{
    // Aggiorna analytics
    $this->updateAnalytics($messageId, 'complained');
}

protected function handleUnsubscribed(string $messageId): void
{
    // Aggiorna analytics
    $this->updateAnalytics($messageId, 'unsubscribed');
}

protected function updateAnalytics(string $messageId, string $event): void
{
    // Trova template
    $template = Template::where('message_id', $messageId)->first();
    if (!$template) {
        return;
    }

    // Crea analytics
    $template->analytics()->create([
        'event' => $event,
        'metadata' => [
            'message_id' => $messageId,
            'timestamp' => now()
        ]
    ]);
}
``` 

---

## analysisettagliata-4

*Consolidated from: `analysisettagliata-integrazione-filament.md`*


## 4. Integrazione con Filament

### 4.1 TemplateResource

#### 4.1.1 Struttura Base
```php
namespace Modules\Notify\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Resources\Form;
use Modules\Notify\Models\Template;

class TemplateResource extends Resource
{
    protected static ?string $model = Template::class;

    protected static ?string $navigationIcon = 'heroicon-o-mail';

    protected static ?string $navigationGroup = 'Notify';

    protected static ?int $navigationSort = 1;
}
```

#### 4.1.2 Form
```php
public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('subject')
                        ->label('Oggetto')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Select::make('layout')
                        ->label('Layout')
                        ->options([
                            'default' => 'Default',
                            'clean' => 'Clean',
                            'modern' => 'Modern'
                        ])
                        ->default('default')
                        ->required(),

                    Forms\Components\TextInput::make('from_name')
                        ->label('Nome Mittente')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('from_email')
                        ->label('Email Mittente')
                        ->email()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('reply_to')
                        ->label('Email Risposta')
                        ->email()
                        ->maxLength(255),

                    Forms\Components\KeyValue::make('cc')
                        ->label('CC')
                        ->keyLabel('Nome')
                        ->valueLabel('Email'),

                    Forms\Components\KeyValue::make('bcc')
                        ->label('BCC')
                        ->keyLabel('Nome')
                        ->valueLabel('Email'),

                    Forms\Components\FileUpload::make('attachments')
                        ->label('Allegati')
                        ->multiple()
                        ->directory('attachments'),

                    Forms\Components\KeyValue::make('variables')
                        ->label('Variabili')
                        ->keyLabel('Nome')
                        ->valueLabel('Descrizione'),

                    Forms\Components\KeyValue::make('settings')
                        ->label('Impostazioni')
                        ->keyLabel('Chiave')
                        ->valueLabel('Valore'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Attivo')
                        ->default(true)
                ])
                ->columns(2),

            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\RichEditor::make('content')
                        ->label('Contenuto')
                        ->required()
                        ->columnSpanFull()
                ])
        ]);
}
```

#### 4.1.3 Table
```php
public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->label('Nome')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('subject')
                ->label('Oggetto')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('layout')
                ->label('Layout')
                ->sortable(),

            Tables\Columns\TextColumn::make('version')
                ->label('Versione')
                ->sortable(),

            Tables\Columns\IconColumn::make('is_active')
                ->label('Attivo')
                ->boolean()
                ->sortable(),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Creato il')
                ->dateTime()
                ->sortable(),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Aggiornato il')
                ->dateTime()
                ->sortable()
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('layout')
                ->options([
                    'default' => 'Default',
                    'clean' => 'Clean',
                    'modern' => 'Modern'
                ]),

            Tables\Filters\TernaryFilter::make('is_active')
                ->label('Attivo')
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
            Tables\Actions\Action::make('preview')
                ->label('Anteprima')
                ->icon('heroicon-o-eye')
                ->action(function (Template $record) {
                    return redirect()->route('notify.templates.preview', $record);
                }),
            Tables\Actions\Action::make('test')
                ->label('Test')
                ->icon('heroicon-o-paper-airplane')
                ->form([
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required(),
                    Forms\Components\KeyValue::make('variables')
                        ->label('Variabili')
                ])
                ->action(function (Template $record, array $data) {
                    $record->test($data['email'], $data['variables']);
                    Notification::make()
                        ->title('Email inviata')
                        ->success()
                        ->send();
                })
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
            Tables\Actions\BulkAction::make('activate')
                ->label('Attiva')
                ->icon('heroicon-o-check')
                ->action(function (Collection $records) {
                    $records->each->activate();
                }),
            Tables\Actions\BulkAction::make('deactivate')
                ->label('Disattiva')
                ->icon('heroicon-o-x-mark')
                ->action(function (Collection $records) {
                    $records->each->deactivate();
                })
        ]);
}
```

### 4.2 RelationManagers

#### 4.2.1 TemplateVersionsRelationManager
```php
namespace Modules\Notify\Filament\Resources\TemplateResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Resources\Form;

class TemplateVersionsRelationManager extends RelationManager
{
    protected static string $relationship = 'versions';

    protected static ?string $recordTitleAttribute = 'version';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('version')
                    ->label('Versione')
                    ->required()
                    ->numeric(),

                Forms\Components\RichEditor::make('content')
                    ->label('Contenuto')
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Stato')
                    ->options([
                        'draft' => 'Bozza',
                        'published' => 'Pubblicato',
                        'archived' => 'Archiviato'
                    ])
                    ->required(),

                Forms\Components\Textarea::make('notes')
                    ->label('Note')
                    ->maxLength(65535)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('version')
                    ->label('Versione')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Stato')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creato il')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Creato da')
                    ->sortable()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Bozza',
                        'published' => 'Pubblicato',
                        'archived' => 'Archiviato'
                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('rollback')
                    ->label('Ripristina')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->action(function ($record) {
                        $record->template->rollback($record->version);
                        Notification::make()
                            ->title('Versione ripristinata')
                            ->success()
                            ->send();
                    })
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
            ]);
    }
}
```

#### 4.2.2 TemplateTranslationsRelationManager
```php
namespace Modules\Notify\Filament\Resources\TemplateResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Resources\Form;

class TemplateTranslationsRelationManager extends RelationManager
{
    protected static string $relationship = 'translations';

    protected static ?string $recordTitleAttribute = 'locale';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('locale')
                    ->label('Lingua')
                    ->options([
                        'it' => 'Italiano',
                        'en' => 'English',
                        'fr' => 'Français',
                        'de' => 'Deutsch',
                        'es' => 'Español'
                    ])
                    ->required(),

                Forms\Components\TextInput::make('subject')
                    ->label('Oggetto')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('from_name')
                    ->label('Nome Mittente')
                    ->maxLength(255),

                Forms\Components\KeyValue::make('variables')
                    ->label('Variabili')
                    ->keyLabel('Nome')
                    ->valueLabel('Descrizione'),

                Forms\Components\RichEditor::make('content')
                    ->label('Contenuto')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('locale')
                    ->label('Lingua')
                    ->sortable(),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Oggetto')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creato il')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('translator.name')
                    ->label('Tradotto da')
                    ->sortable()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('locale')
                    ->options([
                        'it' => 'Italiano',
                        'en' => 'English',
                        'fr' => 'Français',
                        'de' => 'Deutsch',
                        'es' => 'Español'
                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('preview')
                    ->label('Anteprima')
                    ->icon('heroicon-o-eye')
                    ->action(function ($record) {
                        return redirect()->route('notify.translations.preview', $record);
                    })
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
            ]);
    }
}
```

#### 4.2.3 TemplateAnalyticsRelationManager
```php
namespace Modules\Notify\Filament\Resources\TemplateResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Resources\Form;

class TemplateAnalyticsRelationManager extends RelationManager
{
    protected static string $relationship = 'analytics';

    protected static ?string $recordTitleAttribute = 'event';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('event')
                    ->label('Evento')
                    ->options([
                        'delivered' => 'Consegnato',
                        'opened' => 'Aperto',
                        'clicked' => 'Cliccato',
                        'bounced' => 'Rimbalzato',
                        'complained' => 'Segnalato',
                        'unsubscribed' => 'Disiscritto'
                    ])
                    ->required(),

                Forms\Components\KeyValue::make('metadata')
                    ->label('Metadati')
                    ->keyLabel('Chiave')
                    ->valueLabel('Valore'),

                Forms\Components\TextInput::make('user_agent')
                    ->label('User Agent')
                    ->maxLength(255),

                Forms\Components\TextInput::make('ip_address')
                    ->label('IP')
                    ->maxLength(45),

                Forms\Components\TextInput::make('session_id')
                    ->label('Sessione')
                    ->maxLength(255)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event')
                    ->label('Evento')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->searchable(),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP')
                    ->searchable(),

                Tables\Columns\TextColumn::make('session_id')
                    ->label('Sessione')
                    ->searchable()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('event')
                    ->options([
                        'delivered' => 'Consegnato',
                        'opened' => 'Aperto',
                        'clicked' => 'Cliccato',
                        'bounced' => 'Rimbalzato',
                        'complained' => 'Segnalato',
                        'unsubscribed' => 'Disiscritto'
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Da'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('A')
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn ($query, $date) => $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['created_until'],
                                fn ($query, $date) => $query->whereDate('created_at', '<=', $date)
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
            ])
            ->bulkActions([]);
    }
}
```

### 4.3 Widgets

#### 4.3.1 TemplateStatsWidget
```php
namespace Modules\Notify\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Notify\Models\Template;

class TemplateStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Template Totali', Template::count())
                ->description('Numero totale di template')
                ->descriptionIcon('heroicon-m-mail')
                ->color('primary'),

            Stat::make('Template Attivi', Template::where('is_active', true)->count())
                ->description('Template attualmente attivi')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Template Inattivi', Template::where('is_active', false)->count())
                ->description('Template attualmente inattivi')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger')
        ];
    }
}
```

#### 4.3.2 TemplateAnalyticsWidget
```php
namespace Modules\Notify\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Notify\Models\TemplateAnalytics;

class TemplateAnalyticsWidget extends ChartWidget
{
    protected static ?string $heading = 'Analytics Template';

    protected function getData(): array
    {
        $data = TemplateAnalytics::selectRaw('
                event,
                COUNT(*) as count,
                DATE(created_at) as date
            ')
            ->groupBy('event', 'date')
            ->orderBy('date')
            ->get();

        $events = $data->pluck('event')->unique();
        $dates = $data->pluck('date')->unique();

        $datasets = [];
        foreach ($events as $event) {
            $datasets[] = [
                'label' => $this->getEventLabel($event),
                'data' => $dates->map(function ($date) use ($data, $event) {
                    return $data->where('date', $date)
                        ->where('event', $event)
                        ->sum('count');
                })->toArray()
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $dates->toArray()
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getEventLabel(string $event): string
    {
        return [
            'delivered' => 'Consegnati',
            'opened' => 'Aperti',
            'clicked' => 'Cliccati',
            'bounced' => 'Rimbalzati',
            'complained' => 'Segnalati',
            'unsubscribed' => 'Disiscritti'
        ][$event] ?? $event;
    }
}
```

### 4.4 Pages

#### 4.4.1 TemplatePreviewPage
```php
namespace Modules\Notify\Filament\Pages;

use Filament\Pages\Page;
use Modules\Notify\Models\Template;

class TemplatePreviewPage extends Page
{
    protected static string $view = 'notify::pages.template-preview';

    public Template $template;

    public function mount(Template $template): void
    {
        $this->template = $template;
    }

    protected function getViewData(): array
    {
        return [
            'content' => $this->template->preview()
        ];
    }
}
```

#### 4.4.2 TemplateTestPage
```php
namespace Modules\Notify\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Form;
use Modules\Notify\Models\Template;

class TemplateTestPage extends Page
{
    protected static string $view = 'notify::pages.template-test';

    public Template $template;

    public ?array $data = [];

    public function mount(Template $template): void
    {
        $this->template = $template;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('data.email')
                    ->label('Email')
                    ->email()
                    ->required(),

                Forms\Components\KeyValue::make('data.variables')
                    ->label('Variabili')
                    ->keyLabel('Nome')
                    ->valueLabel('Valore')
            ]);
    }

    public function test(): void
    {
        $this->validate();

        $this->template->test(
            $this->data['email'],
            $this->data['variables'] ?? []
        );

        $this->notify('success', 'Email inviata con successo');
    }
} 

---

## analysisettagliata-5

*Consolidated from: `analysisettagliata-testing-parte.md`*


## 5. Testing

### 5.1 Unit Tests

#### 5.1.1 TemplateTest
```php
namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Models\Template;
use Modules\Notify\Services\TemplateService;
use Modules\Notify\Exceptions\TemplateException;

class TemplateTest extends TestCase
{
    protected $templateService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->templateService = app(TemplateService::class);
    }

    /** @test */
    public function it_can_create_a_template()
    {
        $data = [
            'name' => 'Test Template',
            'subject' => 'Test Subject',
            'content' => '<mjml>Test Content</mjml>',
            'layout' => 'default'
        ];

        $template = $this->templateService->create($data);

        $this->assertInstanceOf(Template::class, $template);
        $this->assertEquals($data['name'], $template->name);
        $this->assertEquals($data['subject'], $template->subject);
        $this->assertEquals($data['content'], $template->content);
        $this->assertEquals($data['layout'], $template->layout);
        $this->assertTrue($template->is_active);
        $this->assertEquals(1, $template->version);
    }

    /** @test */
    public function it_can_update_a_template()
    {
        $template = Template::factory()->create();

        $data = [
            'name' => 'Updated Template',
            'subject' => 'Updated Subject',
            'content' => '<mjml>Updated Content</mjml>'
        ];

        $updated = $this->templateService->update($template, $data);

        $this->assertEquals($data['name'], $updated->name);
        $this->assertEquals($data['subject'], $updated->subject);
        $this->assertEquals($data['content'], $updated->content);
        $this->assertEquals(2, $updated->version);
    }

    /** @test */
    public function it_can_delete_a_template()
    {
        $template = Template::factory()->create();

        $this->templateService->delete($template);

        $this->assertSoftDeleted($template);
    }

    /** @test */
    public function it_can_create_a_version()
    {
        $template = Template::factory()->create();

        $data = [
            'content' => '<mjml>New Version</mjml>',
            'status' => 'draft'
        ];

        $version = $this->templateService->createVersion($template, $data);

        $this->assertEquals($template->id, $version->template_id);
        $this->assertEquals(2, $version->version);
        $this->assertEquals($data['content'], $version->content);
        $this->assertEquals($data['status'], $version->status);
    }

    /** @test */
    public function it_can_rollback_to_a_version()
    {
        $template = Template::factory()->create();
        $version = $template->versions()->create([
            'version' => 2,
            'content' => '<mjml>Version 2</mjml>',
            'status' => 'published'
        ]);

        $rolledBack = $this->templateService->rollbackVersion($template, 1);

        $this->assertEquals(1, $rolledBack->version);
        $this->assertEquals($template->versions()->where('version', 1)->first()->content, $rolledBack->content);
    }

    /** @test */
    public function it_can_create_a_translation()
    {
        $template = Template::factory()->create();

        $data = [
            'locale' => 'en',
            'content' => '<mjml>English Content</mjml>',
            'subject' => 'English Subject'
        ];

        $translation = $this->templateService->createTranslation($template, $data);

        $this->assertEquals($template->id, $translation->template_id);
        $this->assertEquals($data['locale'], $translation->locale);
        $this->assertEquals($data['content'], $translation->content);
        $this->assertEquals($data['subject'], $translation->subject);
    }

    /** @test */
    public function it_can_update_a_translation()
    {
        $template = Template::factory()->create();
        $translation = $template->translations()->create([
            'locale' => 'en',
            'content' => '<mjml>English Content</mjml>',
            'subject' => 'English Subject'
        ]);

        $data = [
            'content' => '<mjml>Updated English Content</mjml>',
            'subject' => 'Updated English Subject'
        ];

        $updated = $this->templateService->updateTranslation($translation, $data);

        $this->assertEquals($data['content'], $updated->content);
        $this->assertEquals($data['subject'], $updated->subject);
    }

    /** @test */
    public function it_can_delete_a_translation()
    {
        $template = Template::factory()->create();
        $translation = $template->translations()->create([
            'locale' => 'en',
            'content' => '<mjml>English Content</mjml>',
            'subject' => 'English Subject'
        ]);

        $this->templateService->deleteTranslation($translation);

        $this->assertDatabaseMissing('template_translations', [
            'id' => $translation->id
        ]);
    }

    /** @test */
    public function it_can_preview_a_template()
    {
        $template = Template::factory()->create([
            'content' => '<mjml>Test Content</mjml>'
        ]);

        $preview = $this->templateService->preview($template);

        $this->assertIsString($preview);
        $this->assertStringContainsString('Test Content', $preview);
    }

    /** @test */
    public function it_can_test_a_template()
    {
        $template = Template::factory()->create([
            'content' => '<mjml>Test Content</mjml>'
        ]);

        $result = $this->templateService->test($template, 'test@example.com');

        $this->assertTrue($result);
    }

    /** @test */
    public function it_throws_exception_for_invalid_template()
    {
        $this->expectException(TemplateException::class);

        $template = Template::factory()->create([
            'content' => 'Invalid Content'
        ]);

        $this->templateService->preview($template);
    }
}
```

#### 5.1.2 MjmlServiceTest
```php
namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Services\MjmlService;
use Modules\Notify\Exceptions\TemplateException;

class MjmlServiceTest extends TestCase
{
    protected $mjmlService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mjmlService = app(MjmlService::class);
    }

    /** @test */
    public function it_can_compile_mjml()
    {
        $mjml = '<mjml>
            <mj-body>
                <mj-section>
                    <mj-column>
                        <mj-text>Hello World</mj-text>
                    </mj-column>
                </mj-section>
            </mj-body>
        </mjml>';

        $html = $this->mjmlService->compile($mjml);

        $this->assertIsString($html);
        $this->assertStringContainsString('Hello World', $html);
    }

    /** @test */
    public function it_can_validate_mjml()
    {
        $validMjml = '<mjml>
            <mj-body>
                <mj-section>
                    <mj-column>
                        <mj-text>Hello World</mj-text>
                    </mj-column>
                </mj-section>
            </mj-body>
        </mjml>';

        $invalidMjml = '<mjml>
            <mj-body>
                <mj-invalid>Hello World</mj-invalid>
            </mj-body>
        </mjml>';

        $this->assertTrue($this->mjmlService->validate($validMjml));
        $this->assertFalse($this->mjmlService->validate($invalidMjml));
    }

    /** @test */
    public function it_can_extract_styles()
    {
        $mjml = '<mjml>
            <mj-head>
                <mj-style>body { color: red; }</mj-style>
            </mj-head>
            <mj-body style="background: blue;">
                <mj-section>
                    <mj-column>
                        <mj-text style="font-size: 20px;">Hello World</mj-text>
                    </mj-column>
                </mj-section>
            </mj-body>
        </mjml>';

        $styles = $this->mjmlService->extractStyles($mjml);

        $this->assertIsArray($styles);
        $this->assertContains('body { color: red; }', $styles);
        $this->assertContains('background: blue', $styles);
        $this->assertContains('font-size: 20px', $styles);
    }

    /** @test */
    public function it_can_extract_components()
    {
        $mjml = '<mjml>
            <mj-head>
                <mj-style>body { color: red; }</mj-style>
            </mj-head>
            <mj-body>
                <mj-section>
                    <mj-column>
                        <mj-text>Hello World</mj-text>
                        <mj-image src="test.jpg" />
                    </mj-column>
                </mj-section>
            </mj-body>
        </mjml>';

        $components = $this->mjmlService->extractComponents($mjml);

        $this->assertIsArray($components);
        $this->assertContains('head', $components);
        $this->assertContains('body', $components);
        $this->assertContains('section', $components);
        $this->assertContains('column', $components);
        $this->assertContains('text', $components);
        $this->assertContains('image', $components);
    }

    /** @test */
    public function it_throws_exception_for_invalid_mjml()
    {
        $this->expectException(TemplateException::class);

        $invalidMjml = '<mjml>
            <mj-body>
                <mj-invalid>Hello World</mj-invalid>
            </mj-body>
        </mjml>';

        $this->mjmlService->compile($invalidMjml);
    }
}
```

#### 5.1.3 MailgunServiceTest
```php
namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Services\MailgunService;
use Modules\Notify\Exceptions\TemplateException;

class MailgunServiceTest extends TestCase
{
    protected $mailgunService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mailgunService = app(MailgunService::class);
    }

    /** @test */
    public function it_can_send_an_email()
    {
        $data = [
            'to' => 'test@example.com',
            'subject' => 'Test Subject',
            'html' => '<p>Test Content</p>',
            'from_name' => 'Test Sender',
            'from_email' => 'sender@example.com'
        ];

        $result = $this->mailgunService->send($data);

        $this->assertTrue($result);
    }

    /** @test */
    public function it_can_handle_webhook_events()
    {
        $data = [
            'event' => 'delivered',
            'message-id' => 'test-message-id'
        ];

        $this->mailgunService->handleWebhook($data);

        $this->assertDatabaseHas('template_analytics', [
            'event' => 'delivered',
            'metadata->message_id' => 'test-message-id'
        ]);
    }

    /** @test */
    public function it_throws_exception_for_invalid_email()
    {
        $this->expectException(TemplateException::class);

        $data = [
            'to' => 'invalid-email',
            'subject' => 'Test Subject',
            'html' => '<p>Test Content</p>'
        ];

        $this->mailgunService->send($data);
    }

    /** @test */
    public function it_can_format_from_field()
    {
        $data = [
            'from_name' => 'Test Sender',
            'from_email' => 'sender@example.com'
        ];

        $from = $this->mailgunService->formatFrom($data);

        $this->assertEquals('Test Sender <sender@example.com>', $from);
    }

    /** @test */
    public function it_can_format_attachments()
    {
        $attachments = [
            [
                'path' => 'path/to/file1.pdf',
                'name' => 'file1.pdf'
            ],
            [
                'path' => 'path/to/file2.pdf',
                'name' => 'file2.pdf'
            ]
        ];

        $formatted = $this->mailgunService->formatAttachments($attachments);

        $this->assertIsArray($formatted);
        $this->assertCount(2, $formatted);
        $this->assertEquals('path/to/file1.pdf', $formatted[0]['filePath']);
        $this->assertEquals('file1.pdf', $formatted[0]['filename']);
    }
}
```

### 5.2 Feature Tests

#### 5.2.1 TemplateControllerTest
```php
namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Notify\Models\Template;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TemplateControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_templates()
    {
        $templates = Template::factory()->count(3)->create();

        $response = $this->getJson('/api/notify/templates');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'subject',
                        'content',
                        'layout',
                        'is_active',
                        'version',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_can_show_a_template()
    {
        $template = Template::factory()->create();

        $response = $this->getJson("/api/notify/templates/{$template->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $template->id,
                    'name' => $template->name,
                    'subject' => $template->subject,
                    'content' => $template->content,
                    'layout' => $template->layout,
                    'is_active' => $template->is_active,
                    'version' => $template->version
                ]
            ]);
    }

    /** @test */
    public function it_can_create_a_template()
    {
        $data = [
            'name' => 'Test Template',
            'subject' => 'Test Subject',
            'content' => '<mjml>Test Content</mjml>',
            'layout' => 'default'
        ];

        $response = $this->postJson('/api/notify/templates', $data);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => $data['name'],
                    'subject' => $data['subject'],
                    'content' => $data['content'],
                    'layout' => $data['layout']
                ]
            ]);

        $this->assertDatabaseHas('templates', [
            'name' => $data['name'],
            'subject' => $data['subject'],
            'content' => $data['content'],
            'layout' => $data['layout']
        ]);
    }

    /** @test */
    public function it_can_update_a_template()
    {
        $template = Template::factory()->create();

        $data = [
            'name' => 'Updated Template',
            'subject' => 'Updated Subject',
            'content' => '<mjml>Updated Content</mjml>'
        ];

        $response = $this->putJson("/api/notify/templates/{$template->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $data['name'],
                    'subject' => $data['subject'],
                    'content' => $data['content']
                ]
            ]);

        $this->assertDatabaseHas('templates', [
            'id' => $template->id,
            'name' => $data['name'],
            'subject' => $data['subject'],
            'content' => $data['content']
        ]);
    }

    /** @test */
    public function it_can_delete_a_template()
    {
        $template = Template::factory()->create();

        $response = $this->deleteJson("/api/notify/templates/{$template->id}");

        $response->assertStatus(204);

        $this->assertSoftDeleted($template);
    }

    /** @test */
    public function it_can_preview_a_template()
    {
        $template = Template::factory()->create([
            'content' => '<mjml>Test Content</mjml>'
        ]);

        $response = $this->getJson("/api/notify/templates/{$template->id}/preview");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'html'
                ]
            ]);
    }

    /** @test */
    public function it_can_test_a_template()
    {
        $template = Template::factory()->create([
            'content' => '<mjml>Test Content</mjml>'
        ]);

        $data = [
            'email' => 'test@example.com',
            'variables' => [
                'name' => 'Test User'
            ]
        ];

        $response = $this->postJson("/api/notify/templates/{$template->id}/test", $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Email sent successfully'
            ]);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $response = $this->postJson('/api/notify/templates', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
                'subject',
                'content'
            ]);
    }

    /** @test */
    public function it_validates_email_format()
    {
        $template = Template::factory()->create();

        $data = [
            'email' => 'invalid-email'
        ];

        $response = $this->postJson("/api/notify/templates/{$template->id}/test", $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email'
            ]);
    }
}
```

#### 5.2.2 WebhookControllerTest
```php
namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Notify\Models\Template;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebhookControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_handle_delivered_event()
    {
        $template = Template::factory()->create();

        $data = [
            'event' => 'delivered',
            'message-id' => 'test-message-id',
            'recipient' => 'test@example.com',
            'domain' => 'example.com',
            'timestamp' => time()
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event' => 'delivered',
            'metadata->message_id' => 'test-message-id'
        ]);
    }

    /** @test */
    public function it_can_handle_opened_event()
    {
        $template = Template::factory()->create();

        $data = [
            'event' => 'opened',
            'message-id' => 'test-message-id',
            'recipient' => 'test@example.com',
            'domain' => 'example.com',
            'timestamp' => time()
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event' => 'opened',
            'metadata->message_id' => 'test-message-id'
        ]);
    }

    /** @test */
    public function it_can_handle_clicked_event()
    {
        $template = Template::factory()->create();

        $data = [
            'event' => 'clicked',
            'message-id' => 'test-message-id',
            'recipient' => 'test@example.com',
            'domain' => 'example.com',
            'timestamp' => time(),
            'url' => 'https://example.com'
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event' => 'clicked',
            'metadata->message_id' => 'test-message-id',
            'metadata->url' => 'https://example.com'
        ]);
    }

    /** @test */
    public function it_can_handle_bounced_event()
    {
        $template = Template::factory()->create();

        $data = [
            'event' => 'bounced',
            'message-id' => 'test-message-id',
            'recipient' => 'test@example.com',
            'domain' => 'example.com',
            'timestamp' => time(),
            'code' => '550',
            'error' => 'User unknown'
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event' => 'bounced',
            'metadata->message_id' => 'test-message-id',
            'metadata->code' => '550',
            'metadata->error' => 'User unknown'
        ]);
    }

    /** @test */
    public function it_can_handle_complained_event()
    {
        $template = Template::factory()->create();

        $data = [
            'event' => 'complained',
            'message-id' => 'test-message-id',
            'recipient' => 'test@example.com',
            'domain' => 'example.com',
            'timestamp' => time()
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event' => 'complained',
            'metadata->message_id' => 'test-message-id'
        ]);
    }

    /** @test */
    public function it_can_handle_unsubscribed_event()
    {
        $template = Template::factory()->create();

        $data = [
            'event' => 'unsubscribed',
            'message-id' => 'test-message-id',
            'recipient' => 'test@example.com',
            'domain' => 'example.com',
            'timestamp' => time()
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('template_analytics', [
            'template_id' => $template->id,
            'event' => 'unsubscribed',
            'metadata->message_id' => 'test-message-id'
        ]);
    }

    /** @test */
    public function it_validates_webhook_signature()
    {
        $data = [
            'event' => 'delivered',
            'message-id' => 'test-message-id'
        ];

        $response = $this->postJson('/api/notify/webhooks/mailgun', $data);

        $response->assertStatus(401);
    }
}
``` 

---

## analysisettagliata-6

*Consolidated from: `analysisettagliata-monitoraggio-analytics.md`*


## 6. Monitoraggio e Analytics

### 6.1 Logging

#### 6.1.1 TemplateLogger
```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;
use Modules\Notify\Models\Template;

class TemplateLogger
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function created(): void
    {
        Log::info('Template created', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'version' => $this->template->version,
            'user_id' => auth()->id()
        ]);
    }

    public function updated(): void
    {
        Log::info('Template updated', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'version' => $this->template->version,
            'user_id' => auth()->id()
        ]);
    }

    public function deleted(): void
    {
        Log::info('Template deleted', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'user_id' => auth()->id()
        ]);
    }

    public function versionCreated(int $version): void
    {
        Log::info('Template version created', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'version' => $version,
            'user_id' => auth()->id()
        ]);
    }

    public function versionRolledBack(int $version): void
    {
        Log::info('Template version rolled back', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'version' => $version,
            'user_id' => auth()->id()
        ]);
    }

    public function translationCreated(string $locale): void
    {
        Log::info('Template translation created', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'locale' => $locale,
            'user_id' => auth()->id()
        ]);
    }

    public function translationUpdated(string $locale): void
    {
        Log::info('Template translation updated', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'locale' => $locale,
            'user_id' => auth()->id()
        ]);
    }

    public function translationDeleted(string $locale): void
    {
        Log::info('Template translation deleted', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'locale' => $locale,
            'user_id' => auth()->id()
        ]);
    }

    public function previewed(): void
    {
        Log::info('Template previewed', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'user_id' => auth()->id()
        ]);
    }

    public function tested(string $email): void
    {
        Log::info('Template tested', [
            'id' => $this->template->id,
            'name' => $this->template->name,
            'email' => $email,
            'user_id' => auth()->id()
        ]);
    }

    public function error(string $message, array $context = []): void
    {
        Log::error('Template error', array_merge([
            'id' => $this->template->id,
            'name' => $this->template->name,
            'message' => $message,
            'user_id' => auth()->id()
        ], $context));
    }
}
```

#### 6.1.2 MailgunLogger
```php
namespace Modules\Notify\Services;

use Illuminate\Support\Facades\Log;

class MailgunLogger
{
    public function webhookReceived(array $data): void
    {
        Log::info('Mailgun webhook received', [
            'event' => $data['event'],
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'domain' => $data['domain'],
            'timestamp' => $data['timestamp']
        ]);
    }

    public function emailSent(array $data): void
    {
        Log::info('Email sent', [
            'to' => $data['to'],
            'subject' => $data['subject'],
            'message_id' => $data['message-id'],
            'template_id' => $data['template_id']
        ]);
    }

    public function emailDelivered(array $data): void
    {
        Log::info('Email delivered', [
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'timestamp' => $data['timestamp']
        ]);
    }

    public function emailOpened(array $data): void
    {
        Log::info('Email opened', [
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'timestamp' => $data['timestamp'],
            'user_agent' => $data['user-agent']
        ]);
    }

    public function emailClicked(array $data): void
    {
        Log::info('Email clicked', [
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'timestamp' => $data['timestamp'],
            'url' => $data['url']
        ]);
    }

    public function emailBounced(array $data): void
    {
        Log::error('Email bounced', [
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'timestamp' => $data['timestamp'],
            'code' => $data['code'],
            'error' => $data['error']
        ]);
    }

    public function emailComplained(array $data): void
    {
        Log::warning('Email complained', [
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'timestamp' => $data['timestamp']
        ]);
    }

    public function emailUnsubscribed(array $data): void
    {
        Log::info('Email unsubscribed', [
            'message_id' => $data['message-id'],
            'recipient' => $data['recipient'],
            'timestamp' => $data['timestamp']
        ]);
    }

    public function webhookError(string $message, array $data): void
    {
        Log::error('Mailgun webhook error', [
            'message' => $message,
            'data' => $data
        ]);
    }
}
```

### 6.2 Analytics

#### 6.2.1 TemplateAnalytics
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;
use Modules\Notify\Models\TemplateAnalytics;

class TemplateAnalytics
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function trackEvent(string $event, array $metadata = []): void
    {
        $this->template->analytics()->create([
            'event' => $event,
            'metadata' => $metadata,
            'user_agent' => request()->userAgent(),
            'ip_address' => request()->ip(),
            'session_id' => session()->getId()
        ]);
    }

    public function getStats(): array
    {
        return [
            'total_sent' => $this->getTotalSent(),
            'delivered' => $this->getDeliveredCount(),
            'opened' => $this->getOpenedCount(),
            'clicked' => $this->getClickedCount(),
            'bounced' => $this->getBouncedCount(),
            'complained' => $this->getComplainedCount(),
            'unsubscribed' => $this->getUnsubscribedCount(),
            'delivery_rate' => $this->getDeliveryRate(),
            'open_rate' => $this->getOpenRate(),
            'click_rate' => $this->getClickRate(),
            'bounce_rate' => $this->getBounceRate(),
            'complaint_rate' => $this->getComplaintRate(),
            'unsubscribe_rate' => $this->getUnsubscribeRate()
        ];
    }

    public function getTotalSent(): int
    {
        return $this->template->analytics()
            ->where('event', 'sent')
            ->count();
    }

    public function getDeliveredCount(): int
    {
        return $this->template->analytics()
            ->where('event', 'delivered')
            ->count();
    }

    public function getOpenedCount(): int
    {
        return $this->template->analytics()
            ->where('event', 'opened')
            ->count();
    }

    public function getClickedCount(): int
    {
        return $this->template->analytics()
            ->where('event', 'clicked')
            ->count();
    }

    public function getBouncedCount(): int
    {
        return $this->template->analytics()
            ->where('event', 'bounced')
            ->count();
    }

    public function getComplainedCount(): int
    {
        return $this->template->analytics()
            ->where('event', 'complained')
            ->count();
    }

    public function getUnsubscribedCount(): int
    {
        return $this->template->analytics()
            ->where('event', 'unsubscribed')
            ->count();
    }

    public function getDeliveryRate(): float
    {
        $sent = $this->getTotalSent();
        if ($sent === 0) {
            return 0;
        }

        return ($this->getDeliveredCount() / $sent) * 100;
    }

    public function getOpenRate(): float
    {
        $delivered = $this->getDeliveredCount();
        if ($delivered === 0) {
            return 0;
        }

        return ($this->getOpenedCount() / $delivered) * 100;
    }

    public function getClickRate(): float
    {
        $opened = $this->getOpenedCount();
        if ($opened === 0) {
            return 0;
        }

        return ($this->getClickedCount() / $opened) * 100;
    }

    public function getBounceRate(): float
    {
        $sent = $this->getTotalSent();
        if ($sent === 0) {
            return 0;
        }

        return ($this->getBouncedCount() / $sent) * 100;
    }

    public function getComplaintRate(): float
    {
        $delivered = $this->getDeliveredCount();
        if ($delivered === 0) {
            return 0;
        }

        return ($this->getComplainedCount() / $delivered) * 100;
    }

    public function getUnsubscribeRate(): float
    {
        $delivered = $this->getDeliveredCount();
        if ($delivered === 0) {
            return 0;
        }

        return ($this->getUnsubscribedCount() / $delivered) * 100;
    }

    public function getEventsByDate(string $event, string $startDate, string $endDate): array
    {
        return $this->template->analytics()
            ->where('event', $event)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();
    }

    public function getEventsByHour(string $event, string $date): array
    {
        return $this->template->analytics()
            ->where('event', $event)
            ->whereDate('created_at', $date)
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->pluck('count', 'hour')
            ->toArray();
    }

    public function getTopRecipients(string $event, int $limit = 10): array
    {
        return $this->template->analytics()
            ->where('event', $event)
            ->selectRaw('metadata->>"$.recipient" as recipient, COUNT(*) as count')
            ->groupBy('recipient')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->pluck('count', 'recipient')
            ->toArray();
    }

    public function getTopUserAgents(string $event, int $limit = 10): array
    {
        return $this->template->analytics()
            ->where('event', $event)
            ->whereNotNull('user_agent')
            ->selectRaw('user_agent, COUNT(*) as count')
            ->groupBy('user_agent')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->pluck('count', 'user_agent')
            ->toArray();
    }

    public function getTopIPs(string $event, int $limit = 10): array
    {
        return $this->template->analytics()
            ->where('event', $event)
            ->whereNotNull('ip_address')
            ->selectRaw('ip_address, COUNT(*) as count')
            ->groupBy('ip_address')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->pluck('count', 'ip_address')
            ->toArray();
    }

    public function getTopClickedUrls(int $limit = 10): array
    {
        return $this->template->analytics()
            ->where('event', 'clicked')
            ->selectRaw('metadata->>"$.url" as url, COUNT(*) as count')
            ->groupBy('url')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->pluck('count', 'url')
            ->toArray();
    }

    public function getBounceReasons(): array
    {
        return $this->template->analytics()
            ->where('event', 'bounced')
            ->selectRaw('metadata->>"$.error" as reason, COUNT(*) as count')
            ->groupBy('reason')
            ->orderByDesc('count')
            ->get()
            ->pluck('count', 'reason')
            ->toArray();
    }

    public function getBounceCodes(): array
    {
        return $this->template->analytics()
            ->where('event', 'bounced')
            ->selectRaw('metadata->>"$.code" as code, COUNT(*) as count')
            ->groupBy('code')
            ->orderByDesc('count')
            ->get()
            ->pluck('count', 'code')
            ->toArray();
    }
}
```

#### 6.2.2 AnalyticsExporter
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;
use Illuminate\Support\Facades\Storage;

class AnalyticsExporter
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function exportToCsv(string $startDate, string $endDate): string
    {
        $filename = "analytics_{$this->template->id}_{$startDate}_{$endDate}.csv";
        $path = "analytics/{$filename}";

        $handle = fopen(Storage::path($path), 'w');

        // Intestazioni
        fputcsv($handle, [
            'Event',
            'Date',
            'Time',
            'Recipient',
            'User Agent',
            'IP Address',
            'Session ID',
            'Metadata'
        ]);

        // Dati
        $this->template->analytics()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->each(function ($analytics) use ($handle) {
                fputcsv($handle, [
                    $analytics->event,
                    $analytics->created_at->format('Y-m-d'),
                    $analytics->created_at->format('H:i:s'),
                    $analytics->metadata['recipient'] ?? '',
                    $analytics->user_agent,
                    $analytics->ip_address,
                    $analytics->session_id,
                    json_encode($analytics->metadata)
                ]);
            });

        fclose($handle);

        return $path;
    }

    public function exportToJson(string $startDate, string $endDate): string
    {
        $filename = "analytics_{$this->template->id}_{$startDate}_{$endDate}.json";
        $path = "analytics/{$filename}";

        $data = $this->template->analytics()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->get()
            ->map(function ($analytics) {
                return [
                    'event' => $analytics->event,
                    'date' => $analytics->created_at->format('Y-m-d'),
                    'time' => $analytics->created_at->format('H:i:s'),
                    'recipient' => $analytics->metadata['recipient'] ?? null,
                    'user_agent' => $analytics->user_agent,
                    'ip_address' => $analytics->ip_address,
                    'session_id' => $analytics->session_id,
                    'metadata' => $analytics->metadata
                ];
            });

        Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return $path;
    }

    public function exportToExcel(string $startDate, string $endDate): string
    {
        $filename = "analytics_{$this->template->id}_{$startDate}_{$endDate}.xlsx";
        $path = "analytics/{$filename}";

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Intestazioni
        $sheet->setCellValue('A1', 'Event');
        $sheet->setCellValue('B1', 'Date');
        $sheet->setCellValue('C1', 'Time');
        $sheet->setCellValue('D1', 'Recipient');
        $sheet->setCellValue('E1', 'User Agent');
        $sheet->setCellValue('F1', 'IP Address');
        $sheet->setCellValue('G1', 'Session ID');
        $sheet->setCellValue('H1', 'Metadata');

        // Dati
        $row = 2;
        $this->template->analytics()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->each(function ($analytics) use ($sheet, &$row) {
                $sheet->setCellValue('A' . $row, $analytics->event);
                $sheet->setCellValue('B' . $row, $analytics->created_at->format('Y-m-d'));
                $sheet->setCellValue('C' . $row, $analytics->created_at->format('H:i:s'));
                $sheet->setCellValue('D' . $row, $analytics->metadata['recipient'] ?? '');
                $sheet->setCellValue('E' . $row, $analytics->user_agent);
                $sheet->setCellValue('F' . $row, $analytics->ip_address);
                $sheet->setCellValue('G' . $row, $analytics->session_id);
                $sheet->setCellValue('H' . $row, json_encode($analytics->metadata));
                $row++;
            });

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save(Storage::path($path));

        return $path;
    }
}
``` 

---

## analysisettagliata-7

*Consolidated from: `analysisettagliata-manutenzione-backup.md`*


## 7. Manutenzione e Backup

### 7.1 Versioning

#### 7.1.1 VersionManager
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;
use Modules\Notify\Models\TemplateVersion;
use Modules\Notify\Exceptions\TemplateException;

class VersionManager
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function createVersion(array $data): TemplateVersion
    {
        try {
            $newVersion = $this->template->version + 1;

            $version = $this->template->versions()->create([
                'version' => $newVersion,
                'content' => $data['content'],
                'created_by' => auth()->id(),
                'changes' => $this->getChanges($data),
                'status' => $data['status'] ?? 'draft',
                'notes' => $data['notes'] ?? null
            ]);

            $this->template->update(['version' => $newVersion]);

            return $version;

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to create version: {$e->getMessage()}"
            );
        }
    }

    public function rollbackVersion(int $version): Template
    {
        try {
            $targetVersion = $this->template->versions()
                ->where('version', $version)
                ->firstOrFail();

            $this->template->update([
                'content' => $targetVersion->content,
                'version' => $version
            ]);

            return $this->template;

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to rollback version: {$e->getMessage()}"
            );
        }
    }

    public function compareVersions(int $version1, int $version2): array
    {
        try {
            $v1 = $this->template->versions()
                ->where('version', $version1)
                ->firstOrFail();

            $v2 = $this->template->versions()
                ->where('version', $version2)
                ->firstOrFail();

            return [
                'added' => $this->getAddedLines($v1->content, $v2->content),
                'removed' => $this->getRemovedLines($v1->content, $v2->content),
                'modified' => $this->getModifiedLines($v1->content, $v2->content)
            ];

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to compare versions: {$e->getMessage()}"
            );
        }
    }

    public function getVersionHistory(): array
    {
        return $this->template->versions()
            ->orderBy('version', 'desc')
            ->get()
            ->map(function ($version) {
                return [
                    'version' => $version->version,
                    'content' => $version->content,
                    'status' => $version->status,
                    'notes' => $version->notes,
                    'created_at' => $version->created_at,
                    'created_by' => $version->creator->name
                ];
            })
            ->toArray();
    }

    protected function getChanges(array $data): array
    {
        $changes = [];

        foreach ($data as $key => $value) {
            if (isset($this->template->$key) && $this->template->$key !== $value) {
                $changes[$key] = [
                    'old' => $this->template->$key,
                    'new' => $value
                ];
            }
        }

        return $changes;
    }

    protected function getAddedLines(string $old, string $new): array
    {
        $oldLines = explode("\n", $old);
        $newLines = explode("\n", $new);
        return array_diff($newLines, $oldLines);
    }

    protected function getRemovedLines(string $old, string $new): array
    {
        $oldLines = explode("\n", $old);
        $newLines = explode("\n", $new);
        return array_diff($oldLines, $newLines);
    }

    protected function getModifiedLines(string $old, string $new): array
    {
        $oldLines = explode("\n", $old);
        $newLines = explode("\n", $new);
        $modified = [];

        foreach ($oldLines as $index => $line) {
            if (isset($newLines[$index]) && $line !== $newLines[$index]) {
                $modified[] = [
                    'old' => $line,
                    'new' => $newLines[$index]
                ];
            }
        }

        return $modified;
    }
}
```

### 7.2 Backup

#### 7.2.1 BackupManager
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;
use Illuminate\Support\Facades\Storage;
use Modules\Notify\Exceptions\TemplateException;

class BackupManager
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function createBackup(): string
    {
        try {
            $filename = "backup_{$this->template->id}_" . date('Y-m-d_His') . ".json";
            $path = "backups/{$filename}";

            $data = [
                'template' => [
                    'id' => $this->template->id,
                    'name' => $this->template->name,
                    'subject' => $this->template->subject,
                    'content' => $this->template->content,
                    'layout' => $this->template->layout,
                    'is_active' => $this->template->is_active,
                    'version' => $this->template->version,
                    'from_name' => $this->template->from_name,
                    'from_email' => $this->template->from_email,
                    'reply_to' => $this->template->reply_to,
                    'cc' => $this->template->cc,
                    'bcc' => $this->template->bcc,
                    'attachments' => $this->template->attachments,
                    'variables' => $this->template->variables,
                    'settings' => $this->template->settings,
                    'created_at' => $this->template->created_at,
                    'updated_at' => $this->template->updated_at
                ],
                'versions' => $this->template->versions()
                    ->orderBy('version')
                    ->get()
                    ->map(function ($version) {
                        return [
                            'version' => $version->version,
                            'content' => $version->content,
                            'status' => $version->status,
                            'notes' => $version->notes,
                            'created_at' => $version->created_at,
                            'created_by' => $version->creator->name
                        ];
                    })
                    ->toArray(),
                'translations' => $this->template->translations()
                    ->get()
                    ->map(function ($translation) {
                        return [
                            'locale' => $translation->locale,
                            'content' => $translation->content,
                            'subject' => $translation->subject,
                            'from_name' => $translation->from_name,
                            'variables' => $translation->variables,
                            'created_at' => $translation->created_at,
                            'translated_by' => $translation->translator->name
                        ];
                    })
                    ->toArray()
            ];

            Storage::put($path, json_encode($data, JSON_PRETTY_PRINT));

            return $path;

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to create backup: {$e->getMessage()}"
            );
        }
    }

    public function restoreFromBackup(string $path): Template
    {
        try {
            $data = json_decode(Storage::get($path), true);

            DB::beginTransaction();

            // Ripristina template
            $this->template->update([
                'name' => $data['template']['name'],
                'subject' => $data['template']['subject'],
                'content' => $data['template']['content'],
                'layout' => $data['template']['layout'],
                'is_active' => $data['template']['is_active'],
                'version' => $data['template']['version'],
                'from_name' => $data['template']['from_name'],
                'from_email' => $data['template']['from_email'],
                'reply_to' => $data['template']['reply_to'],
                'cc' => $data['template']['cc'],
                'bcc' => $data['template']['bcc'],
                'attachments' => $data['template']['attachments'],
                'variables' => $data['template']['variables'],
                'settings' => $data['template']['settings']
            ]);

            // Ripristina versioni
            $this->template->versions()->delete();
            foreach ($data['versions'] as $version) {
                $this->template->versions()->create([
                    'version' => $version['version'],
                    'content' => $version['content'],
                    'status' => $version['status'],
                    'notes' => $version['notes'],
                    'created_by' => auth()->id()
                ]);
            }

            // Ripristina traduzioni
            $this->template->translations()->delete();
            foreach ($data['translations'] as $translation) {
                $this->template->translations()->create([
                    'locale' => $translation['locale'],
                    'content' => $translation['content'],
                    'subject' => $translation['subject'],
                    'from_name' => $translation['from_name'],
                    'variables' => $translation['variables'],
                    'translated_by' => auth()->id()
                ]);
            }

            DB::commit();

            return $this->template;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new TemplateException(
                "Failed to restore from backup: {$e->getMessage()}"
            );
        }
    }

    public function getBackups(): array
    {
        return collect(Storage::files('backups'))
            ->filter(function ($path) {
                return str_starts_with(basename($path), "backup_{$this->template->id}_");
            })
            ->map(function ($path) {
                return [
                    'path' => $path,
                    'filename' => basename($path),
                    'created_at' => Storage::lastModified($path),
                    'size' => Storage::size($path)
                ];
            })
            ->sortByDesc('created_at')
            ->values()
            ->toArray();
    }

    public function deleteBackup(string $path): bool
    {
        try {
            return Storage::delete($path);
        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to delete backup: {$e->getMessage()}"
            );
        }
    }
}
```

#### 7.2.2 BackupCommand
```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\Template;
use Modules\Notify\Services\BackupManager;

class BackupTemplatesCommand extends Command
{
    protected $signature = 'notify:backup-templates {--template= : ID del template da backuppare} {--all : Backup di tutti i template}';

    protected $description = 'Crea backup dei template';

    public function handle()
    {
        if ($this->option('all')) {
            $templates = Template::all();
        } elseif ($templateId = $this->option('template')) {
            $templates = Template::where('id', $templateId)->get();
        } else {
            $this->error('Specificare --template o --all');
            return 1;
        }

        $bar = $this->output->createProgressBar(count($templates));
        $bar->start();

        foreach ($templates as $template) {
            try {
                $backupManager = new BackupManager($template);
                $path = $backupManager->createBackup();
                $this->info("\nBackup creato: {$path}");
            } catch (\Exception $e) {
                $this->error("\nErrore nel backup del template {$template->id}: {$e->getMessage()}");
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Backup completato');

        return 0;
    }
}
```

### 7.3 Manutenzione

#### 7.3.1 MaintenanceManager
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;
use Illuminate\Support\Facades\Cache;
use Modules\Notify\Exceptions\TemplateException;

class MaintenanceManager
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function cleanup(): void
    {
        try {
            // Pulisci cache
            $this->clearCache();

            // Pulisci analytics vecchi
            $this->cleanupAnalytics();

            // Pulisci backup vecchi
            $this->cleanupBackups();

            // Pulisci allegati non utilizzati
            $this->cleanupAttachments();

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to cleanup: {$e->getMessage()}"
            );
        }
    }

    public function optimize(): void
    {
        try {
            // Ottimizza database
            $this->optimizeDatabase();

            // Ottimizza cache
            $this->optimizeCache();

            // Ottimizza storage
            $this->optimizeStorage();

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to optimize: {$e->getMessage()}"
            );
        }
    }

    public function validate(): array
    {
        try {
            $issues = [];

            // Valida template
            if (!$this->validateTemplate()) {
                $issues[] = 'Template non valido';
            }

            // Valida versioni
            if (!$this->validateVersions()) {
                $issues[] = 'Versioni non valide';
            }

            // Valida traduzioni
            if (!$this->validateTranslations()) {
                $issues[] = 'Traduzioni non valide';
            }

            // Valida analytics
            if (!$this->validateAnalytics()) {
                $issues[] = 'Analytics non validi';
            }

            return $issues;

        } catch (\Exception $e) {
            throw new TemplateException(
                "Failed to validate: {$e->getMessage()}"
            );
        }
    }

    protected function clearCache(): void
    {
        Cache::tags(['template_' . $this->template->id])->flush();
    }

    protected function cleanupAnalytics(): void
    {
        $this->template->analytics()
            ->where('created_at', '<', now()->subMonths(3))
            ->delete();
    }

    protected function cleanupBackups(): void
    {
        $backups = collect(Storage::files('backups'))
            ->filter(function ($path) {
                return str_starts_with(basename($path), "backup_{$this->template->id}_");
            })
            ->sortByDesc(function ($path) {
                return Storage::lastModified($path);
            })
            ->skip(10);

        foreach ($backups as $backup) {
            Storage::delete($backup);
        }
    }

    protected function cleanupAttachments(): void
    {
        $usedAttachments = $this->template->attachments ?? [];
        $allAttachments = Storage::files('attachments');

        foreach ($allAttachments as $attachment) {
            if (!in_array($attachment, $usedAttachments)) {
                Storage::delete($attachment);
            }
        }
    }

    protected function optimizeDatabase(): void
    {
        DB::statement('OPTIMIZE TABLE templates');
        DB::statement('OPTIMIZE TABLE template_versions');
        DB::statement('OPTIMIZE TABLE template_translations');
        DB::statement('OPTIMIZE TABLE template_analytics');
    }

    protected function optimizeCache(): void
    {
        Cache::tags(['template_' . $this->template->id])->flush();
    }

    protected function optimizeStorage(): void
    {
        // Comprimi allegati
        foreach ($this->template->attachments ?? [] as $attachment) {
            if (Storage::exists($attachment)) {
                $content = Storage::get($attachment);
                $compressed = gzcompress($content);
                Storage::put($attachment . '.gz', $compressed);
            }
        }
    }

    protected function validateTemplate(): bool
    {
        return $this->template->is_valid;
    }

    protected function validateVersions(): bool
    {
        return $this->template->versions()
            ->where('is_valid', false)
            ->count() === 0;
    }

    protected function validateTranslations(): bool
    {
        return $this->template->translations()
            ->where('is_valid', false)
            ->count() === 0;
    }

    protected function validateAnalytics(): bool
    {
        return $this->template->analytics()
            ->where('is_valid', false)
            ->count() === 0;
    }
}
```

#### 7.3.2 MaintenanceCommand
```php
namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\Template;
use Modules\Notify\Services\MaintenanceManager;

class MaintainTemplatesCommand extends Command
{
    protected $signature = 'notify:maintain-templates {--template= : ID del template da mantenere} {--all : Manutenzione di tutti i template} {--cleanup : Pulisci risorse} {--optimize : Ottimizza risorse} {--validate : Valida risorse}';

    protected $description = 'Esegue manutenzione sui template';

    public function handle()
    {
        if ($this->option('all')) {
            $templates = Template::all();
        } elseif ($templateId = $this->option('template')) {
            $templates = Template::where('id', $templateId)->get();
        } else {
            $this->error('Specificare --template o --all');
            return 1;
        }

        $bar = $this->output->createProgressBar(count($templates));
        $bar->start();

        foreach ($templates as $template) {
            try {
                $maintenanceManager = new MaintenanceManager($template);

                if ($this->option('cleanup')) {
                    $maintenanceManager->cleanup();
                    $this->info("\nPulizia completata per il template {$template->id}");
                }

                if ($this->option('optimize')) {
                    $maintenanceManager->optimize();
                    $this->info("\nOttimizzazione completata per il template {$template->id}");
                }

                if ($this->option('validate')) {
                    $issues = $maintenanceManager->validate();
                    if (empty($issues)) {
                        $this->info("\nValidazione completata per il template {$template->id}");
                    } else {
                        $this->warn("\nProblemi trovati nel template {$template->id}:");
                        foreach ($issues as $issue) {
                            $this->warn("- {$issue}");
                        }
                    }
                }

            } catch (\Exception $e) {
                $this->error("\nErrore nella manutenzione del template {$template->id}: {$e->getMessage()}");
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Manutenzione completata');

        return 0;
    }
} 

---

## analysisettagliata-8

*Consolidated from: `analysisettagliata-finali-parte.md`*


## 8. Note Finali

### 8.1 Best Practices

#### 8.1.1 Documentazione
- Mantenere aggiornata la documentazione del codice
- Utilizzare PHPDoc per documentare classi, metodi e proprietà
- Includere esempi di utilizzo nella documentazione
- Documentare le dipendenze e i requisiti
- Mantenere un changelog aggiornato

#### 8.1.2 Logging
- Utilizzare livelli di log appropriati (info, warning, error)
- Includere contesto rilevante nei messaggi di log
- Implementare rotazione dei log
- Monitorare i log per errori e warning
- Configurare alert per errori critici

#### 8.1.3 Testing
- Mantenere una copertura dei test elevata
- Testare edge cases e scenari di errore
- Utilizzare test di integrazione per i flussi principali
- Implementare test di performance
- Eseguire test automatici in CI/CD

#### 8.1.4 Performance
- Implementare caching appropriato
- Ottimizzare query al database
- Minimizzare chiamate API esterne
- Utilizzare code per operazioni pesanti
- Monitorare metriche di performance

#### 8.1.5 Backup
- Eseguire backup regolari
- Verificare l'integrità dei backup
- Implementare retention policy
- Testare il ripristino dei backup
- Documentare procedure di backup/restore

#### 8.1.6 Code Review
- Rivedere il codice prima del merge
- Verificare la qualità del codice
- Controllare la sicurezza
- Verificare la manutenibilità
- Assicurare la coerenza dello stile

#### 8.1.7 Sicurezza
- Validare input utente
- Sanitizzare output
- Implementare rate limiting
- Utilizzare HTTPS
- Mantenere aggiornate le dipendenze

#### 8.1.8 Manutenzione
- Eseguire manutenzione regolare
- Monitorare l'utilizzo delle risorse
- Pulire dati obsoleti
- Ottimizzare performance
- Aggiornare dipendenze

### 8.2 Raccomandazioni

#### 8.2.1 Architettura
- Seguire i principi SOLID
- Utilizzare pattern architetturali appropriati
- Mantenere una struttura modulare
- Implementare dependency injection
- Separare le responsabilità

#### 8.2.2 Database
- Utilizzare indici appropriati
- Implementare soft deletes
- Utilizzare transazioni
- Ottimizzare query
- Implementare migrazioni

#### 8.2.3 Cache
- Implementare caching strategico
- Utilizzare cache tags
- Implementare cache invalidation
- Monitorare hit/miss ratio
- Configurare TTL appropriati

#### 8.2.4 API
- Documentare API con OpenAPI/Swagger
- Implementare versioning
- Utilizzare rate limiting
- Implementare autenticazione
- Validare input/output

#### 8.2.5 Frontend
- Implementare validazione lato client
- Utilizzare componenti riutilizzabili
- Implementare error handling
- Ottimizzare bundle size
- Implementare lazy loading

#### 8.2.6 Testing
- Implementare test unitari
- Implementare test di integrazione
- Implementare test end-to-end
- Implementare test di performance
- Implementare test di sicurezza

#### 8.2.7 Deployment
- Implementare CI/CD
- Utilizzare container
- Implementare rollback
- Monitorare deployment
- Documentare procedure

#### 8.2.8 Monitoraggio
- Implementare logging
- Implementare metrics
- Implementare alerting
- Monitorare performance
- Monitorare errori

### 8.3 Considerazioni Future

#### 8.3.1 Scalabilità
- Implementare sharding
- Utilizzare load balancing
- Implementare caching distribuito
- Ottimizzare query
- Monitorare performance

#### 8.3.2 Manutenibilità
- Documentare codice
- Implementare test
- Utilizzare pattern
- Refactoring regolare
- Code review

#### 8.3.3 Sicurezza
- Audit regolare
- Penetration testing
- Security headers
- Input validation
- Output sanitization

#### 8.3.4 Performance
- Profiling
- Ottimizzazione
- Caching
- Lazy loading
- Code splitting

#### 8.3.5 Feature
- A/B testing
- Analytics
- Personalizzazione
- Automazione
- Integrazione

### 8.4 Conclusione

Il modulo Notify è un componente complesso e robusto che fornisce funzionalità avanzate per la gestione delle email. L'architettura modulare e l'implementazione di best practices garantiscono manutenibilità, scalabilità e sicurezza.

Le principali caratteristiche includono:
- Gestione template MJML
- Versioning
- Traduzioni
- Analytics
- Backup
- Manutenzione

Le raccomandazioni per il futuro includono:
- Migliorare la documentazione
- Aumentare la copertura dei test
- Ottimizzare le performance
- Implementare nuove feature
- Migliorare la sicurezza

Il modulo è progettato per essere estensibile e personalizzabile, permettendo l'aggiunta di nuove funzionalità e l'integrazione con altri sistemi.

### 8.5 Riferimenti

#### 8.5.1 Documentazione
- [Laravel Documentation](https://laravel.com/docs)
- [MJML Documentation](https://mjml.io/documentation)
- [Mailgun Documentation](https://documentation.mailgun.com)
- [Filament Documentation](https://filamentphp.com/docs)

#### 8.5.2 Package
- [spatie/laravel-mail-templates](https://github.com/spatie/laravel-mail-templates)
- [mjml/mjml-php](https://github.com/mjmlio/mjml-php)
- [mailgun/mailgun-php](https://github.com/mailgun/mailgun-php)

#### 8.5.3 Tools
- [Laravel Telescope](https://laravel.com/docs/telescope)
- [Laravel Horizon](https://laravel.com/docs/horizon)
- [Laravel Dusk](https://laravel.com/docs/dusk)

#### 8.5.4 Best Practices
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
- [PHP The Right Way](https://phptherightway.com)
- [SOLID Principles](https://en.wikipedia.org/wiki/SOLID)

#### 8.5.5 Security
- [OWASP](https://owasp.org)
- [Laravel Security](https://laravel.com/docs/security)
- [PHP Security](https://phpsecurity.readthedocs.io)

#### 8.5.6 Testing
- [PHPUnit](https://phpunit.de)
- [Laravel Testing](https://laravel.com/docs/testing)
- [Test-Driven Development](https://en.wikipedia.org/wiki/Test-driven_development)

#### 8.5.7 Performance
- [Laravel Performance](https://laravel.com/docs/performance)
- [PHP Performance](https://www.php.net/manual/en/performance.php)
- [Web Performance](https://web.dev/performance)

#### 8.5.8 Monitoring
- [Laravel Monitoring](https://laravel.com/docs/monitoring)
- [Application Monitoring](https://en.wikipedia.org/wiki/Application_performance_management)
- [Log Management](https://en.wikipedia.org/wiki/Log_management) 

---

## analysisettagliata

*Consolidated from: `analysisettagliata.md`*


## 1. Analisi delle Soluzioni di Template Email

### 1.1 Laravel Email Templates (simplepleb)
**Analisi Dettagliata:**
- Architettura basata su database
- Supporto per variabili dinamiche
- Integrazione nativa con Laravel
- Sistema di caching base

**Vantaggi:**
- Facile integrazione
- Bassa curva di apprendimento
- Manutenzione semplice
- Performance decenti

**Svantaggi:**
- Funzionalità limitate
- Poca personalizzazione
- Supporto community limitato
- Mancanza di editor visuale

### 1.2 Spatie Database Mail Templates
**Analisi Dettagliata:**
- Sistema robusto di gestione template
- Supporto multilingua avanzato
- Integrazione con Filament
- Sistema di versioning

**Vantaggi:**
- API ben documentata
- Ottima integrazione
- Supporto community attivo
- Funzionalità avanzate

**Svantaggi:**
- Overhead database
- Setup complesso
- Dipendenze multiple
- Curva di apprendimento

### 1.3 Laravel Mail Editor (Qoraiche)
**Analisi Dettagliata:**
- Editor visuale drag-and-drop
- Preview in tempo reale
- Gestione assets
- Integrazione Filament

**Vantaggi:**
- UI intuitiva
- Preview immediata
- Gestione facile
- Supporto responsive

**Svantaggi:**
- Performance overhead
- Dipendenze pesanti
- Manutenzione complessa
- Limitazioni tecniche

## 2. Framework e Librerie Analizzate

### 2.1 MJML
**Analisi Dettagliata:**
```php
namespace Modules\Notify\Services;

class MjmlService
{
    protected $mjml;
    protected $options;

    public function __construct()
    {
        $this->mjml = new \Mjml\Mjml();
        $this->options = [
            'minify' => true,
            'beautify' => false,
            'validationLevel' => 'strict'
        ];
    }

    public function compile($template)
    {
        try {
            $mjml = $this->convertToMjml($template);
            $result = $this->mjml->render($mjml, $this->options);
            
            return [
                'html' => $result->html,
                'errors' => $result->errors
            ];
        } catch (\Exception $e) {
            Log::error('MJML compilation failed', [
                'error' => $e->getMessage(),
                'template' => $template
            ]);
            throw $e;
        }
    }

    protected function convertToMjml($template)
    {
        return view('notify::mjml.wrapper', [
            'content' => $template,
            'styles' => $this->extractStyles($template),
            'components' => $this->extractComponents($template)
        ])->render();
    }
}
```

### 2.2 Mailgun
**Analisi Dettagliata:**
```php
namespace Modules\Notify\Services;

class MailgunService
{
    protected $mailgun;
    protected $domain;
    protected $analytics;

    public function __construct()
    {
        $this->mailgun = new \Mailgun\Mailgun(config('services.mailgun.secret'));
        $this->domain = config('services.mailgun.domain');
        $this->analytics = new MailgunAnalytics();
    }

    public function send($template, $data)
    {
        try {
            $result = $this->mailgun->messages()->send($this->domain, [
                'from' => $template->from,
                'to' => $data['to'],
                'subject' => $template->subject,
                'template' => $template->mailgun_template,
                'h:X-Mailgun-Variables' => json_encode($data),
                'o:tracking' => true,
                'o:tracking-clicks' => true,
                'o:tracking-opens' => true
            ]);

            $this->analytics->track($template, $result);

            return $result;
        } catch (\Exception $e) {
            Log::error('Mailgun send failed', [
                'error' => $e->getMessage(),
                'template' => $template,
                'data' => $data
            ]);
            throw $e;
        }
    }
}
```

## 3. Miglioramenti Strutturali Dettagliati

### 3.1 Sistema di Versioning Avanzato
```php
namespace Modules\Notify\Models;

class TemplateVersion extends Model
{
    protected $fillable = [
        'template_id',
        'version',
        'content',
        'created_by',
        'changes',
        'status'
    ];

    protected $casts = [
        'changes' => 'array',
        'status' => 'string'
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getDiff()
    {
        if (!$this->previousVersion) {
            return null;
        }

        return $this->compareVersions(
            $this->previousVersion->content,
            $this->content
        );
    }

    protected function compareVersions($old, $new)
    {
        // Implementazione diff
        return [
            'added' => $this->getAddedLines($old, $new),
            'removed' => $this->getRemovedLines($old, $new),
            'modified' => $this->getModifiedLines($old, $new)
        ];
    }
}
```

### 3.2 Gestione Multilingua Avanzata
```php
namespace Modules\Notify\Services;

class LocalizationService
{
    protected $translator;
    protected $cache;

    public function __construct()
    {
        $this->translator = app('translator');
        $this->cache = app('cache');
    }

    public function translate($template, $locale)
    {
        $cacheKey = "template.{$template->id}.{$locale}";
        
        return $this->cache->remember($cacheKey, 3600, function () use ($template, $locale) {
            return $template->translations()
                ->where('locale', $locale)
                ->first();
        });
    }

    public function syncTranslations($template, $locales)
    {
        foreach ($locales as $locale) {
            $translation = $template->translations()
                ->updateOrCreate(
                    ['locale' => $locale],
                    ['content' => $this->translateContent($template, $locale)]
                );

            $this->validateTranslation($translation);
            $this->cache->forget("template.{$template->id}.{$locale}");
        }
    }

    protected function validateTranslation($translation)
    {
        // Validazione traduzione
        if (!$this->isValidTranslation($translation)) {
            throw new InvalidTranslationException(
                "Invalid translation for locale: {$translation->locale}"
            );
        }
    }
}
```

### 3.3 Sistema di Analytics Avanzato
```php
namespace Modules\Notify\Services;

class AnalyticsService
{
    protected $metrics;
    protected $logger;

    public function __construct()
    {
        $this->metrics = new MetricsCollector();
        $this->logger = new AnalyticsLogger();
    }

    public function track($template, $event)
    {
        try {
            $analytics = TemplateAnalytics::create([
                'template_id' => $template->id,
                'event' => $event,
                'metadata' => [
                    'user_agent' => request()->userAgent(),
                    'ip' => request()->ip(),
                    'timestamp' => now(),
                    'session_id' => session()->getId(),
                    'user_id' => auth()->id()
                ]
            ]);

            $this->metrics->record($analytics);
            $this->logger->log($analytics);

            return $analytics;
        } catch (\Exception $e) {
            $this->logger->error('Analytics tracking failed', [
                'error' => $e->getMessage(),
                'template' => $template,
                'event' => $event
            ]);
            throw $e;
        }
    }

    public function getMetrics($template, $period = 'daily')
    {
        return $this->metrics->get($template, $period);
    }
}
```

## 4. Integrazioni Avanzate

### 4.1 Stripo Integration
```php
namespace Modules\Notify\Services;

class StripoService
{
    protected $stripo;
    protected $cache;

    public function __construct()
    {
        $this->stripo = new StripoClient(config('services.stripo.api_key'));
        $this->cache = app('cache');
    }

    public function export($template)
    {
        try {
            $result = $this->stripo->export([
                'html' => $template->content,
                'css' => $template->styles,
                'images' => $this->processImages($template->images)
            ]);

            $this->cache->put(
                "stripo.{$template->id}",
                $result,
                now()->addHours(24)
            );

            return $result;
        } catch (\Exception $e) {
            Log::error('Stripo export failed', [
                'error' => $e->getMessage(),
                'template' => $template
            ]);
            throw $e;
        }
    }

    protected function processImages($images)
    {
        return collect($images)->map(function ($image) {
            return [
                'url' => $image->url,
                'alt' => $image->alt,
                'width' => $image->width,
                'height' => $image->height
            ];
        })->toArray();
    }
}
```

## 5. Miglioramenti UI/UX Dettagliati

### 5.1 Editor Avanzato
```php
namespace Modules\Notify\Filament\Resources;

class TemplateResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Template')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Content')
                        ->schema([
                            Forms\Components\Builder::make('content')
                                ->blocks([
                                    Builder\Block::make('text')
                                        ->schema([
                                            Forms\Components\RichEditor::make('content')
                                                ->required()
                                                ->toolbarButtons([
                                                    'bold',
                                                    'italic',
                                                    'link',
                                                    'bulletList',
                                                    'orderedList'
                                                ])
                                        ]),
                                    Builder\Block::make('image')
                                        ->schema([
                                            Forms\Components\FileUpload::make('image')
                                                ->required()
                                                ->image()
                                                ->imageResizeMode('cover')
                                                ->imageCropAspectRatio('16:9')
                                                ->imageResizeTargetWidth('1920')
                                                ->imageResizeTargetHeight('1080')
                                        ])
                                ])
                        ]),
                    Forms\Components\Tabs\Tab::make('Preview')
                        ->schema([
                            Forms\Components\View::make('notify::preview')
                                ->livewire(TemplatePreview::class)
                        ]),
                    Forms\Components\Tabs\Tab::make('Settings')
                        ->schema([
                            Forms\Components\TextInput::make('subject')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Select::make('layout')
                                ->options([
                                    'default' => 'Default',
                                    'custom' => 'Custom'
                                ])
                                ->required(),
                            Forms\Components\Toggle::make('is_active')
                                ->label('Active')
                                ->default(true)
                        ])
                ])
        ]);
    }
}
```

### 5.2 Preview in Tempo Reale
```php
namespace Modules\Notify\Livewire;

class TemplatePreview extends Component
{
    public $template;
    public $content;
    public $preview;
    public $isLoading = false;

    protected $listeners = ['contentUpdated' => 'updatePreview'];

    public function mount($template)
    {
        $this->template = $template;
        $this->content = $template->content;
        $this->updatePreview();
    }

    public function updatePreview()
    {
        $this->isLoading = true;

        try {
            $this->preview = $this->templateService->render($this->template, [
                'content' => $this->content,
                'preview' => true
            ]);
        } catch (\Exception $e) {
            $this->addError('preview', $e->getMessage());
        }

        $this->isLoading = false;
    }

    public function render()
    {
        return view('notify::livewire.preview');
    }
}
```

## 6. Raccomandazioni Dettagliate

### 6.1 Fase 1: Core Features
1. **Sistema di Versioning**
   - Implementare versioning completo
   - Aggiungere diff tra versioni
   - Implementare rollback

2. **Editor Visuale**
   - Integrare editor drag-and-drop
   - Aggiungere preview in tempo reale
   - Implementare componenti riutilizzabili

3. **Preview**
   - Migliorare preview in browser
   - Aggiungere test su client email
   - Implementare responsive preview

### 6.2 Fase 2: Integrazioni
1. **Mailgun**
   - Integrare API completa
   - Implementare analytics
   - Aggiungere template variables

2. **MJML**
   - Aggiungere supporto MJML
   - Implementare conversione
   - Ottimizzare output

3. **Analytics**
   - Implementare tracking completo
   - Aggiungere dashboard
   - Implementare report

### 6.3 Fase 3: UI/UX
1. **Editor**
   - Migliorare UX
   - Aggiungere shortcuts
   - Implementare autosave

2. **Preview**
   - Aggiungere preview in tempo reale
   - Implementare responsive test
   - Aggiungere device preview

3. **Drag-and-Drop**
   - Implementare drag-and-drop
   - Aggiungere componenti
   - Implementare templates

### 6.4 Fase 4: Performance
1. **Caching**
   - Implementare Redis
   - Ottimizzare query
   - Implementare lazy loading

2. **Queue**
   - Implementare queue
   - Aggiungere retry logic
   - Monitorare queue health

3. **Assets**
   - Ottimizzare immagini
   - Minificare CSS/JS
   - Implementare CDN

## 7. Note Tecniche Dettagliate

### 7.1 Performance
1. **Caching**
   - Utilizzare Redis per caching
   - Implementare cache tags
   - Ottimizzare cache keys

2. **Database**
   - Aggiungere indici
   - Ottimizzare query
   - Implementare eager loading

3. **Assets**
   - Minificare assets
   - Ottimizzare immagini
   - Implementare CDN

### 7.2 Sicurezza
1. **Validazione**
   - Validare input
   - Sanitizzare output
   - Implementare rate limiting

2. **Crittografia**
   - Crittografare dati
   - Implementare HTTPS
   - Aggiungere SPF/DKIM

3. **Monitoraggio**
   - Implementare logging
   - Aggiungere alert
   - Monitorare accessi

### 7.3 Manutenibilità
1. **Documentazione**
   - Documentare API
   - Aggiungere commenti
   - Mantenere changelog

2. **Testing**
   - Aggiungere unit test
   - Implementare feature test
   - Aggiungere integration test

3. **Logging**
   - Implementare logging
   - Aggiungere context
   - Monitorare errori

## 8. Collegamenti Utili

- [MJML Documentation](https://mjml.io/documentation/)
- [Mailgun API](https://documentation.mailgun.com/en/latest/api_reference.html)
- [Filament Documentation](https://filamentphp.com/docs)
- [Laravel Mail Documentation](https://laravel.com/docs/mail)
- [Stripo Documentation](https://stripo.email/templates/)
- [Beefree Documentation](https://beefree.io/templates)
- [Unlayer Documentation](https://unlayer.com/)
- [Mailersend Documentation](https://www.mailersend.com/)
- [Mailjet Documentation](https://www.mailjet.com/) 

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04
