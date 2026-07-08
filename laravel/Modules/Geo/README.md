# PTVX - Sistema HR & Performance Evaluation

[![Laravel 12.47.0](https://img.shields.io/badge/Laravel-12.47.0-red.svg)](https://laravel.com/)
[![Filament 5.0.0](https://img.shields.io/badge/Filament-5.0.0-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PHP 8.2+](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Laraxot](https://img.shields.io/badge/Laraxot-Modular-orange.svg)](https://laraxot.com/)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

> **Sistema modulare HR & Performance evaluation** basato su Laravel 12.47.0 + Filament v5.0.0 + architettura Laraxot. Gestisce valutazioni, indennità, progressioni e documentazione per Pubbliche Amministrazioni.

---

## 🎯 Scopo del Progetto

### Il Problema Risolto

Le Pubbliche Amministrazioni necessitano di:
- **Valutare il personale** secondo criteri oggettivi e tracciabili
- **Calcolare indennità** con formule definite e audit trail completo
- **Gestire progressioni** con workflow standardizzato
- **Garantire trasparenza** e documentazione conforme

### La Soluzione PTVX

Sistema **modulare enterprise** che automatizza:
- **Valutazioni**: Criteri configurabili, calcoli automatici, reporting
- **Indennità**: Formule definite, tracciabilità completa
- **Progressioni**: Workflow standardizzato, approval chain
- **Documentazione**: PDF generation, export automatici, version control

---

## 🚀 Quick Start

### Setup Iniziale

```bash
# Clone e installazione
git clone <repository-url>
cd base_ptvx_fila5_mono/laravel
composer install
cp .env.example .env
php artisan key:generate

# Configurazione database
# Modifica .env con le tue credenziali DB
php artisan migrate
php artisan db:seed

# Frontend
npm install
npm run build
```

### Comandi Essenziali

```bash
# Setup completo (raccomandato)
composer go                    # Installazione + permessi + ottimizzazione

# Qualità codice
php -d memory_limit=2G ./vendor/bin/phpstan analyse    # Level 10
./vendor/bin/pint                                       # Code formatting
./vendor/bin/pest                                       # Testing

# manutenzione
bash bashscripts/maintenance/cleanup/clear_all_caches.sh
php artisan filament:optimize
```

---

## 🚨 Cardinal Rules (OBLIGATORIE)

### 1. Forward-Only 🔴
```bash
# ❌ MAI tornare indietro
git reset --hard HEAD~1

# ✅ SEMRE andare avanti
git commit -m "fix: correct issue"
```

### 2. Extend XotBase 🔴
```php
// ❌ MAI
class MyPage extends Filament\Pages\Page

// ✅ SEMPRE
class MyPage extends Modules\Xot\Filament\Pages\XotBasePage
```

### 3. No Hardcoded Strings 🔴
```php
// ❌ MAI
TextInput::make('name')->label('Nome')

// ✅ SEMPRE
TextInput::make('name')  // Auto-tradotto
```

### 4. Actions Not Services 🔴
```php
// ❌ MAI
class UserService { }

// ✅ SEMPRE
class CreateUserAction { use QueueableAction; }
```

### 5. Scripts in bashscripts/ 🔴
```bash
# ❌ MAI
laravel/script.sh

# ✅ SEMPRE
bashscripts/analysis/script.sh
```

### 6. Documentation Naming 🔴
```
# ❌ MAI
Analysis-2025-01-02.md
CODE_QUALITY.md

# ✅ SEMPRE
code-analysis.md
best-practices.md

# ECCEZIONI
README.md, CHANGELOG.md
```

### 7. Focus on Business Logic 🔴
```markdown
# ❌ MAI: Solo descrizione codice
"Line 50 creates object"

# ✅ SEMPRE: Spiega scopo business
"Calculates indennità because PA regulation requires..."
```

---

## 🏗️ Architettura Moduli

### Overview del Sistema

PTVX utilizza **architettura Laraxot** con **35 moduli specializzati**:

```
PTVX Core System
├── Framework Modules (8)
│   ├── Xot           # Core framework Laraxot
│   ├── User          # Autenticazione e gestione utenti
│   ├── UI            # Componenti UI e temi
│   ├── Tenant        # Multi-tenancy
│   ├── Setting       # Configurazioni di sistema
│   ├── Media         # Gestione file e media
│   ├── Notify        # Sistema notifiche
│   └── Job           # Queue management
├── Business Modules (20)
│   ├── Ptv           # Core business logic PTVX
│   ├── Performance   # Sistema valutazioni
│   ├── Rating        # Sistema rating polimorfico
│   ├── Questionari   # Gestione questionari
│   ├── Progressioni  # Gestione progressioni
│   ├── IndennitaResponsabilita    # Indennità responsabilità
│   ├── PresenzeAssenze            # Gestione presenze
│   ├── Prenotazioni               # Sistema prenotazioni
│   └── [12 altri moduli business]
└── Integration Modules (7)
    ├── Lang          # Sistema traduzioni IT/EN/DE
    ├── Europa        # Integrazioni UE
    ├── Gdpr          # Privacy e compliance
    ├── Sigma         # Integrazioni esterne
    └── [3 altri moduli integrazione]
```

### Moduli Principali

| Modulo | Business Purpose | Status PHPStan | Note |
|--------|-----------------|----------------|------|
| **Xot** | Core framework Laraxot | ✅ Level 10 | Modulo fondamentale per tutti |
| **User** | Autenticazione e utenti | ✅ Level 10 | Profile management, roles |
| **Activity** | Audit trail + Event sourcing | ✅ Level 10 | Tracciamento completo azioni |
| **Rating** | Sistema valutazioni polimorfico | ✅ Level 10 | Multi-entity rating system |
| **Performance** | Valutazioni performance | ✅ Level 10 | KPIs e metrics |
| **Ptv** | Business logic PTVX | ⚠️ In analisi | Core domain logic |
| **Lang** | Sistema traduzioni | 🔴 126 errori | LaraZeus incompatibilità |

---

## 📊 Stato Qualità System

### PHPStan Level 10 Compliance

```bash
# Analisi completa sistema
php -d memory_limit=2G ./vendor/bin/phpstan analyse --level=10

# Per modulo
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/ModuleName --level=10
```

| Metrica | Valore Attuale | Target |
|---------|----------------|--------|
| **PHPStan Level** | 10 (parziale) | 10 (completo) |
| **Moduli Level 10** | 28/35 (80%) | 35/35 (100%) |
| **Errori Totali** | 126 (Lang) + 2 (Gdpr) | 0 |
| **Test Coverage** | Dispari | >90% |
| **Code Quality** | Buona | Eccellente |

### Moduli con Problemi

1. **Lang** - 126 errori PHPStan
   - **Problema**: Incompatibilità LaraZeus package con PHPStan Level 10
   - **Fix richiesto**: Refactor package o alternative

2. **Gdpr** - 2 errori PHPStan
   - **Problema**: Type hints mancanti
   - **Fix**: Aggiungere dichiarazioni tipi

---

## 🛠️ Development Workflow

### Ambiente di Sviluppo

```bash
# Struttura directory
cd /var/www/_bases/base_ptvx_fila5_mono/laravel

# Script di sviluppo
./check_all_modules.sh              # Analisi PHPStan tutti moduli
./vendor/bin/pest                   # Testing completo
./vendor/bin/pint                   # Code formatting
```

### Modulo Development Sequence

1. **Setup Modulo**
   ```bash
   php artisan module:enable ModuleName
   php artisan migrate --path=Modules/ModuleName/database/migrations
   ```

2. **Quality Checks**
   ```bash
   php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/ModuleName
   ./vendor/bin/pint Modules/ModuleName
   ./vendor/bin/pest Modules/ModuleName/tests
   ```

3. **Documentation Update**
   ```bash
   # Update README.md with metrics
   # Update docs/ with new features
   ```

4. **Testing Manuale**
   ```bash
   php artisan serve
   # Test in browser Filament admin
   ```

5. **Commit**
   ```bash
   git add .
   git commit -m "feat(module): add new feature with PHPStan Level 10"
   ```

---

## 📚 Documentation Structure

### Documentation System

```
docs/
├── README.md                           # Hub principale
├── claude/                            # AI agent guidelines
│   ├── README.md                      # Start here for AI
│   ├── architecture-rules.md           # Critical rules
│   └── project-rules-summary.md       # 7 cardinal rules
├── phpstan/                          # PHPStan documentation
│   ├── ANALISI_MODULI_PHPSTAN.md     # Analisi completa
│   └── phpstan-level-10-guide.md     # Guida compliance
└── troubleshooting/                   # Common issues
    └── env-changes-not-applied.md    # Environment fixes

laravel/Modules/*/docs/
├── README.md                          # Module overview
├── business-logic.md                  # WHY & business rules
├── architecture-overview.md           # HOW it's structured
├── phpstan-compliance.md             # PHPStan status
├── testing-strategy.md              # Testing approach
└── [topic-specific].md               # As needed
```

### AI/Agent Configuration

MCP Setup file: `laravel/.mcp.json`
- **Laravel Boost MCP Server** - Artisan commands
- **Filesystem MCP** - File access
- **Memory MCP** - Context management
- **Fetch MCP** - Web requests
- **MySQL MCP** - Database access
- **Git MCP** - Version control

---

## 🔧 Common Tasks

### PHPStan Operations

```bash
# Analisi complete sistema
php -d memory_limit=2G ./vendor/bin/phpstan analyse --level=10

# Analisi modulo specifico
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/ModuleName

# Batch analysis
./check_all_modules.sh

# Fix automatici
./vendor/bin/rector process Modules/ModuleName --dry-run
```

### Testing Operations

```bash
# All tests
./vendor/bin/pest --coverage

# Module tests
./vendor/bin/pest Modules/ModuleName/tests

# Single test
./vendor/bin/pest --filter="test_user_can_login"

# Browser tests (Pest 4)
./vendor/bin/pest tests/Browser/
```

### Database Operations

```bash
# Migrazioni
php artisan migrate
php artisan migrate:fresh --seed

# Seeding specifico
bash bashscripts/database/seeding/seed_all.sh

# Backup
php artisan db:backup
```

---

## 🌍 Multi-Language Support

### Sistema Traduzioni

PTVX supporta **3 lingue** con sistema centralizzato:

| Lingua | Codice | Status |
|--------|--------|---------|
| **Italiano** | it | ✅ Primary |
| **Inglese** | en | ✅ Complete |
| **Tedesco** | de | ✅ Complete |

### Implementation

```php
// File di traduzione
lang/it/validation.php
lang/en/validation.php
lang/de/validation.php

// Utilizzo nei moduli
__('validation.required', ['attribute' => 'nome'])
trans('modules.performance.title')
```

### Schemaless Attributes Support

Per moduli che utilizzano attributi dinamici:

```php
// Model con schemaless attributes
class User extends Model
{
    use HasSchemalessAttributes;
    
    protected $schemalessAttributes = [
        'profile',
        'preferences',
        'metadata'
    ];
}

// Accesso tipizzato
$user->profile->get('bio');
$user->preferences->set('theme', 'dark');
```

---

## 🚨 Troubleshooting

### Common Issues

1. **PHPStan Memory Errors**
   ```bash
   # Aumenta memoria
   php -d memory_limit=2G ./vendor/bin/phpstan analyse
   
   # Analisi per modulo
   php -d memory_limit=1G ./vendor/bin/phpstan analyse Modules/Xot
   ```

2. **Cache Issues After .env Changes**
   ```bash
   bash bashscripts/maintenance/cleanup/clear_all_caches.sh
   php artisan config:clear
   php artisan route:clear
   ```

3. **Filament Assets Missing**
   ```bash
   php artisan filament:upgrade
   php artisan filament:optimize
   npm run build
   ```

4. **Module Not Found**
   ```bash
   php artisan module:list
   php artisan module:enable ModuleName
   composer dump-autoload
   ```

### Module-Specific Fixes

#### Lang Module (126 errors)
```php
// Issue: LaraZeus package incompatibility
// Fix: Rimuovere o sostituire package
composer remove lara-zeus/spatie-translatable
// Implementare sistema traduzioni custom basato su Xot
```

#### Schemaless Attributes Issues
```php
// Best practice per nuovi attributi
class Model extends BaseModel
{
    use HasSchemalessAttributes;
    
    protected $casts = [
        'schemaless_attributes' => 'array',
    ];
    
    // Accesso sicuro con default
    public function getMetaAttribute($value)
    {
        return $this->schemaless_attributes->get('meta', []);
    }
}
```

---

## 📈 Performance Metrics

### System Performance

| Metrica | Valore | Target |
|---------|--------|--------|
| **Response Time** | <200ms | <150ms |
| **Memory Usage** | 64MB avg | <50MB |
| **Database Queries** | Ottimizzato | <5/page |
| **Test Coverage** | Parziale | >90% |
| **PHPStan Errors** | 128 totali | 0 |

### Optimization Strategies

1. **Eager Loading**
   ```php
   // Evita N+1 queries
   Model::with(['relation1', 'relation2'])->get();
   ```

2. **Query Optimization**
   ```php
   // Index appropriati
   $schema = DB::select('SHOW INDEX FROM table_name');
   ```

3. **Caching Strategy**
   ```php
   // Cache configurazioni
   Cache::remember('config.key', 3600, fn() => config('key'));
   ```

---

## 🔗 Key Resources

### Documentation

- **AI Guidelines**: [docs/claude/README.md](docs/claude/README.md)
- **Architecture Rules**: [docs/claude/architecture-rules.md](docs/claude/architecture-rules.md)
- **PHPStan Analysis**: [docs/phpstan/ANALISI_MODULI_PHPSTAN.md](docs/phpstan/ANALISI_MODULI_PHPSTAN.md)
- **Module Documentation**: [laravel/Modules/*/docs/](laravel/Modules/*/docs/)

### Development Tools

- **Scripts**: [bashscripts/](bashscripts/) - Automation toolkit
- **Testing**: [tests/](tests/) - Pest PHP test suite
- **Configuration**: [laravel/config/](laravel/config/) - Laravel configs

### External Links

- **Laravel Documentation**: https://laravel.com/docs/12.x
- **Filament Documentation**: https://filamentphp.com/docs/5.x
- **PHPStan Documentation**: https://phpstan.org/
- **Laraxot Documentation**: https://laraxot.com/

---

## 🙏 Project Philosophy

### Principles

**Technical Excellence**
- PHPStan Level 10 strict type checking
- 100% test coverage goal
- SOLID, DRY, KISS principles
- Queueable Actions pattern

**Business Value**
- Automation over manual processes
- Transparency and auditability
- Regulatory compliance
- User-centric design

**Development Culture**
- Forward-only development
- Quality-first approach
- Documentation-driven development
- Continuous improvement

### Architecture Decisions

1. **Modular Architecture** - Laraxot pattern per scalability
2. **Event Sourcing** - Audit trail completo via Activity module
3. **Schemaless Attributes** - Flexibilità dati dinamici
4. **Queueable Actions** - Performance e reliability
5. **Filament v5** - Modern admin interface

---

**Maintained By**: Development Team  
**Last Update**: 2026-06-18  
**Status**: ✅ Production Ready with ongoing improvements  
**Next Major Release**: PTVX v2.0 (Full PHPStan Level 10 compliance)

🎉 **Building the future of HR & Performance Management for Public Administration!**
v5** - Modern admin interface

---

**Maintained By**: Development Team  
**Last Update**: 2026-02-10  
**Status**: ✅ Production Ready with ongoing improvements  
**Next Major Release**: PTVX v2.0 (Full PHPStan Level 10 compliance)

🎉 **Building the future of HR & Performance Management for Public Administration!**
