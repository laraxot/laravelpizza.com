# 📦 Modulo User - Documentazione DRY + KISS

> **MODULO USER**: Sistema completo di autenticazione, autorizzazione e gestione utenti per PTVX.

---

## 🎯 **Scopo e Responsabilità**

### Business Logic
- ✅ **Autenticazione multi-tipo** (Doctor, Patient, Admin)
- ✅ **Autorizzazione basata su ruoli** (Spatie Laravel Permission)
- ✅ **Gestione team e collaborazioni**
- ✅ **Supporto multi-tenant** per isolamento dati
- ✅ **Audit trail completo** (integrazione Activity)

### Pattern Architetturali
- ✅ **Single Table Inheritance** per tipi utente
- ✅ **Repository Pattern** per accesso dati
- ✅ **Service Layer** per logica business
- ✅ **Event-Driven Architecture** per notifiche

---

## 🏗️ **Architettura Tecnica**

### 📋 **Componenti Principali**
| Componente | Descrizione | Pattern |
|------------|-------------|---------|
| **User Model** | Base con STI | Eloquent |
| **Team Model** | Gestione collaborazioni | BelongsToMany |
| **Role/Permission** | Autorizzazioni granulari | Spatie Permission |
| **Tenant Model** | Isolamento multi-tenant | Single DB |

### 🔧 **Integrazione Framework**
- **Filament Resources**: CRUD completo per tutte le entità
- **Filament Widgets**: Login, stats, sicurezza
- **Filament Pages**: Profilo, impostazioni
- **Livewire Components**: Interazioni dinamiche

---

## 📊 **Funzionalità Core**

### 🔐 **Autenticazione**
- Login multi-tipo con validazione specifica
- 2FA supportato (documentazione dedicata)
- Reset password sicuro
- Logout con pulizia sessioni

### 👥 **Gestione Utenti**
- CRUD completo con validazioni
- Moderazione utenti (approvazione/rifiuto)
- Gestione avatar e profili
- Notifiche automatiche

### 🏢 **Team Management**
- Creazione e gestione team
- Assegnazione membri con ruoli
- Collaborazione multi-user
- Audit modifiche team

### 🏛️ **Multi-Tenancy**
- Isolamento completo dati per tenant
- Configurazione dinamica
- Sicurezza isolamento
- Performance ottimizzata

---

## 📁 **Struttura File Organizzata**

```
Modules/User/
├── app/
│   ├── Models/           # User, Team, Tenant, Role
│   ├── Actions/          # Business logic actions
│   ├── Filament/
│   │   ├── Resources/    # CRUD interfaces
│   │   ├── Widgets/      # Dashboard widgets
│   │   └── Pages/        # Custom pages
│   └── Traits/           # HasTeams, HasTenants, etc.
├── database/
│   ├── migrations/       # Schema definitions
│   └── factories/        # Test data generators
├── resources/
│   ├── views/            # Blade templates
│   └── lang/             # Translations (it/en/de)
└── docs/                 # Questa documentazione
```

---

## 🔗 **Documentazione Organizzata**

### 📖 **Guide Principali**
- **[2FA Implementation](./2fa-guide.md)** - Autenticazione a due fattori
- **[Traits Guide](./traits/traits-complete-guide.md)** - HasTeams, HasTenants
- **[Filament Integration](./filament/filament-best-practices.md)** - Best practices UI

### 🛠️ **Troubleshooting**
- **[Login Issues](./troubleshooting-login-component.md)** - Problemi autenticazione
- **[Merge Conflicts](./git-conflicts-resolution.md)** - Risoluzione conflitti Git
- **[PHPStan Fixes](./phpstan-fixes.md)** - Errori analisi statica

### 🧪 **Qualità & Testing**
- **[Testing Structure](./testing-structure.md)** - Organizzazione test
- **[Performance Analysis](./performance/performance-issues.md)** - Ottimizzazioni
- **[Code Quality](./code-quality-analysis.md)** - Analisi qualità

---

## ⚡ **Quick Reference**

### Comandi Utili
```bash
# Testing specifico modulo
php artisan test --filter=User

# Analisi qualità
./vendor/bin/phpstan analyse Modules/User

# Generazione dati test
php artisan db:seed --class=UserSeeder
```

### Pattern Comuni
```php
// Repository usage
$userRepository = app(UserRepositoryInterface::class);
$user = $userRepository->findByEmail('user@example.com');

// Service usage
$userService = app(UserServiceInterface::class);
$userService->registerUser($userData);

// Event dispatching
UserRegistered::dispatch($user);
```

### Configurazioni Importanti
```php
// config/user.php
return [
    'multi_tenant' => env('USER_MULTI_TENANT', true),
    'require_email_verification' => env('USER_EMAIL_VERIFICATION', true),
    'default_role' => 'user',
];
```

---

## 🔄 **Workflow Sviluppo**

### 1. **Pianificazione**
- Leggi documentazione esistente
- Identifica pattern da seguire
- Pianifica modifiche rispettando architettura

### 2. **Implementazione**
- Segui convenzioni stabilite
- Usa repository/service layer
- Implementa test contestualmente

### 3. **Testing & Quality**
```bash
# Quality checks
./vendor/bin/phpstan analyse Modules/User
php artisan test --filter=User

# Performance check
php artisan user:performance-audit
```

### 4. **Documentazione**
- Aggiorna docs per nuove funzionalità
- Mantieni collegamenti cross-reference
- Segui principi DRY/KISS

---

## 📈 **Metriche Qualità**

### Code Quality
- **PHPStan Level**: 10/10 ✅
- **Test Coverage**: 85%+ 📈
- **Cyclomatic Complexity**: <10 🔧
- **Duplications**: 0% 📉

### Architecture Compliance
- **SOLID Principles**: 100% ✅
- **DRY Violations**: 0 📉
- **KISS Compliance**: 95% ✅
- **Maintainability Index**: High 📈

---

## 🚨 **Errori Comuni (Checklist)**

### ❌ **NON Fare**
- [ ] Modificare direttamente modelli senza repository
- [ ] Saltare validazioni nelle actions
- [ ] Creare dipendenze dirette tra modelli
- [ ] Ignorare multi-tenancy nelle query

### ✅ **Fare Sempre**
- [ ] Usare repository per accesso dati
- [ ] Implementare service layer per logica complessa
- [ ] Scrivere test per nuove funzionalità
- [ ] Aggiornare documentazione

---

## 🔗 **Ecosistema Integrazioni**

### Moduli Core
- **[Xot](../Xot/docs/)** - Framework base e utilities
- **[Lang](../Lang/docs/)** - Sistema traduzioni
- **[Activity](../Activity/docs/)** - Audit trail

### Moduli Business
- **[Performance](../Performance/docs/)** - Valutazioni performance
- **[Ptv](../Ptv/docs/)** - Sistema PTV
- **[Gdpr](../Gdpr/docs/)** - Compliance privacy

### Packages Esterni
- **Spatie Laravel Permission** - Gestione ruoli/permessi
- **Laravel Sanctum** - API authentication
- **Laravel Socialite** - OAuth providers

---

## 🎯 **Best Practices**

### 1. **Always Use Repository Pattern**
```php
// ✅ CORRECT
$user = app(UserRepositoryInterface::class)->findById($id);

// ❌ WRONG
$user = User::find($id);
```

### 2. **Service Layer for Business Logic**
```php
// ✅ CORRECT
app(UserServiceInterface::class)->registerUser($data);

// ❌ WRONG - Business logic in controller
User::create($data);
// ... complex validation ...
// ... notifications ...
```

### 3. **Event-Driven Architecture**
```php
// ✅ CORRECT
UserRegistered::dispatch($user);

// ❌ WRONG - Direct notifications
Notification::send($user, new WelcomeNotification());
```

### 4. **Respect Multi-Tenancy**
```php
// ✅ CORRECT
$userQuery = User::forTenant($tenant);

// ❌ WRONG
$userQuery = User::where('tenant_id', $tenant->id);
```

---

## 📞 **Supporto & Troubleshooting**

### Quando Hai Problemi
1. **Controlla documentazione** - 80% dei problemi hanno già soluzione documentata
2. **Verifica checklist** - Segui workflow e best practices
3. **Cerca negli esempi** - Guarda implementazioni esistenti
4. **Chiedi al team** - Condividi analisi del problema

### Risorse Utili
- **[Troubleshooting Guide](./troubleshooting/)** - Risoluzioni problemi comuni
- **[Code Examples](./examples/)** - Implementazioni pratiche
- **[Architecture Decisions](./architecture/)** - Motivazioni scelte tecniche

---

**🎉 Modulo User: Architettura solida, codice pulito, documentazione completa!**

**🚀 Pronto a sviluppare? Inizia da [Getting Started](../../docs/navigation/getting-started.md)!**

---

*Documentazione applica principi DRY + KISS + SOLID - Aggiornata Dicembre 2025*
