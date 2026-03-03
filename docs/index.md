# 📚 Documentazione LaravelPizza.com

**
**Versione**: Laravel 12.x + Filament 5.x + Livewire 4.x

---

## 🎯 Panoramica Rapida

Benvenuto nella documentazione di **LaravelPizza.com** - una piattaforma completa per organizzare meetup tech Laravel costruita con architettura modulare avanzata.

### Cos'è LaravelPizza.com?
- 🍕 **Piattaforma meetup** per community Laravel
- 🚀 **Framework modulare** riutilizzabile (Laraxot)
- 📚 **Showcase architettura** Laravel moderno
- ✨ **PHPStan Level 10** - 0 errori su 3,983 file
- 🎨 **Folio + Volt** - Frontend moderno senza controller

---

## 🚀 Inizia Subito

### 🟢 Per Nuovi Sviluppatori

1. **[Guida Rapida - Getting Started](getting-started.md)**
   - Setup dell'ambiente in 30-45 minuti
   - Prerequisiti e installazione
   - Workflow di sviluppo
   - Troubleshooting comune

2. **[Panoramica del Progetto](project-overview.md)**
   - Architettura completa
   - Tutti i 14 moduli spiegati
   - Stack tecnologico
   - Regole architetturali critiche

### 🟡 Per Sviluppatori Intermedi

3. **[Filament v5 Study](filament-v5-study-summary.md)**
   - Differenze Filament v4 vs v5
   - Migrazione Livewire v4
   - Best practices

### 🔴 Per Sviluppatori Avanzati

4. **[PHPStan Zero Errors Achievement](phpstan-zero-errors-achievement.md)**
   - Come raggiungere Level 10
   - Pattern di correzione
   - Quality metrics

---

## 📦 Moduli del Progetto

### 🎯 Moduli Core (Foundation)

#### [Xot Module](../laravel/Modules/Xot/docs/)
**Framework Laraxot - Fondazione architetturale**
- Base classes per tutti i componenti
- Ecosistema traits
- Actions framework
- Enum system
- PHPStan Level 10 compliance

📖 [Documentazione Completa](../laravel/Modules/Xot/docs/)

#### [User Module](../laravel/Modules/User/docs/)
**Autenticazione & Autorizzazione**
- Multi-auth (credentials, OAuth, SSO)
- Role-based access control (Spatie)
- Multi-tenancy support
- Team collaboration
- Device management

📖 [Documentazione Completa](../laravel/Modules/User/docs/)

#### [Lang Module](../laravel/Modules/Lang/docs/)
**Internazionalizzazione**
- Multi-lingua (IT, EN, DE)
- Translation management
- Locale switching
- Navigation translations

📖 [Documentazione Completa](../laravel/Modules/Lang/docs/)

#### [UI Module](../laravel/Modules/UI/docs/)
**Componenti UI Condivisi**
- 50+ Blade components
- 20+ Filament widgets
- Design system
- Form components

📖 [Documentazione Completa](../laravel/Modules/UI/docs/)

---

### 🎪 Moduli Business

#### [Meetup Module](../laravel/Modules/Meetup/docs/)
**Business Logic Meetup**
- Event management
- Event registration (RSVP)
- Calendar integration
- User profiles
- Community features

📖 [Documentazione Completa](../laravel/Modules/Meetup/docs/)

#### [Cms Module](../laravel/Modules/Cms/docs/)
**Content Management**
- Page management
- Blocks system
- Metatag management
- Multi-language content

📖 [Documentazione Completa](../laravel/Modules/Cms/docs/)

#### [Geo Module](../laravel/Modules/Geo/docs/)
**Dati Geografici**
- Address management
- Geocoding (Google, Mapbox, Here)
- Italian municipalities DB
- Location selectors

📖 [Documentazione Completa](../laravel/Modules/Geo/docs/)

#### [Notify Module](../laravel/Modules/Notify/docs/)
**Sistema Notifiche**
- Email templates
- SMS integration
- Push notifications
- Multi-channel notifications

📖 [Documentazione Completa](../laravel/Modules/Notify/docs/)

---

### 🛠️ Moduli Supporto

#### [Activity Module](../laravel/Modules/Activity/docs/)
**Logging Attività**
- Event sourcing
- Activity log UI
- PDF reports
- User tracking

📖 [Documentazione Completa](../laravel/Modules/Activity/docs/)

#### [Job Module](../laravel/Modules/Job/docs/)
**Gestione Code**
- Multi-queue system
- Advanced scheduling
- Batch processing
- Real-time monitoring

📖 [Documentazione Completa](../laravel/Modules/Job/docs/)

#### [Media Module](../laravel/Modules/Media/docs/)
**Gestione Media**
- Secure file upload
- Image optimization
- Video processing (FFmpeg)
- S3 integration

📖 [Documentazione Completa](../laravel/Modules/Media/docs/)

#### [Tenant Module](../laravel/Modules/Tenant/docs/)
**Multi-Tenancy**
- Data isolation
- Domain management
- Tenant-aware policies
- Context switching

📖 [Documentazione Completa](../laravel/Modules/Tenant/docs/)

#### [Gdpr Module](../laravel/Modules/Gdpr/docs/)
**Compliance GDPR**
- Cookie consent
- Privacy policy
- Data export
- Right to be forgotten

📖 [Documentazione Completa](../laravel/Modules/Gdpr/docs/)

#### [Seo Module](../laravel/Modules/Seo/docs/)
**SEO Optimization**
- Schema.org
- Metatag management
- Sitemap generation
- Open Graph tags

📖 [Documentazione Completa](../laravel/Modules/Seo/docs/)

---

## 🎨 Temi

### [Meetup Theme](../laravel/Themes/Meetup/docs/)
**Frontend Premium**
- **Folio** - File-based routing
- **Volt** - Declarative components
- **Tailwind CSS** - Utility-first styling
- **Alpine.js** - JavaScript interactions
- PWA support
- Responsive design

📖 [Documentazione Completa](../laravel/Themes/Meetup/docs/)

---

## 🔧 Guide Tecniche

### Architettura
- [Panoramica Progetto](project-overview.md) - Architettura completa
- [Regole Critiche Xot](../laravel/Modules/Xot/docs/critical-rules-consolidated.md) - Fondamentale per Laraxot
- [Regole Critiche Meetup Theme](../laravel/Themes/Meetup/docs/critical-rules-consolidated.md) - Fondamentale per frontend

### Quality & Testing
- [PHPStan Code Quality Guide](../laravel/Modules/Xot/docs/phpstan-code-quality-guide.md) - Type safety
- [Testing Strategy](testing-strategy.md) - Approccio ai test
- [PHPStan Zero Errors](phpstan-zero-errors-achievement-2025-12-18.md) - Come raggiungere Level 10

### Development
- [Getting Started](getting-started.md) - Setup rapido
- [Filament v5 Study](filament-v5-study-summary.md) - Filament v4 vs v5
- [MCP Configuration](mcp-configuration.md) - Model Context Protocol setup for AI agents

### Deployment
- [Deployment Guide](deployment.md) - *Coming Soon*
- [Performance Optimization](performance.md) - *Coming Soon*
- [Security Hardening](security.md) - *Coming Soon*

---

## 📊 Metriche Qualità

### PHPStan Compliance
```
✅ Xot:        Level 10 (0 errori)
✅ User:       Level 10 (0 errori)
✅ Lang:       Level 10 (0 errori)
✅ UI:         Level 10 (0 errori)
✅ Activity:   Level 10 (0 errori)
✅ Cms:        Level 10 (0 errori)
✅ Geo:        Level 10 (0 errori)
✅ Job:        Level 10 (0 errori)
✅ Media:      Level 10 (0 errori)
✅ Notify:     Level 10 (0 errori)
✅ Tenant:     Level 10 (0 errori)
✅ Meetup:     Level 10 (0 errori)
✅ Gdpr:       Level 10 (0 errori)
✅ Seo:        Level 10 (0 errori)

Totale: 0 errori su 3,983 file analizzati
```

### Test Coverage
- Stimato: 80-90% attraverso tutti i moduli
- Framework: Pest
- Strategy: Feature + Unit + PHPStan

### Code Quality
- Type Safety: Strict types, generics, PHPDoc
- Patterns: DRY, KISS, SOLID
- Architecture: Modular monolith
- Documentation: 85-90% coverage

---

## 🚨 Regole Architetturali Critiche

### 🔴 MAI Fare

❌ **NO** controller tradizionali per frontoffice
❌ **NO** routes in web.php o api.php
❌ **NO** componenti Livewire class (solo Volt)
❌ **NO** estendere Filament classes direttamente
❌ **NO** estendere XotBaseModel direttamente
❌ **NO** usare `property_exists()` su Eloquent models
❌ **NO** usare `->label()` in Filament
❌ **NO** maiuscole nei nomi file .md (tranne README.md)

### ✅ SEMPRE Fare

✅ **USARE** Folio per frontend routing
✅ **USARE** Volt per componenti reattivi
✅ **USARE** module-specific BaseModel
✅ **USARE** XotBaseResource per Filament
✅ **USARE** XotBaseWidget per widgets
✅ **USARE** `hasAttribute()` su Eloquent models
✅ **USARE** TransTrait per traduzioni
✅ **USARE** PHPStan Level 10
✅ **USARE** DRY + KISS principles
✅ **USARE** `npm run build && npm run copy` dopo modifiche CSS/JS

---

## 🔄 Flussi Business Principali

### 1. Registrazione & Autenticazione
```
Meetup Theme (Folio) → User Module (Actions) → User Module (Services) → User Module (Models)
                                          ↓
                                    Activity Module (Logging)
```

### 2. Creazione Eventi
```
Filament Admin → Meetup Module (Resources) → Meetup Module (Actions) → Meetup Module (Services)
                                                          ↓
                                                    Cms Module (Content)
                                                    Notify Module (Notifications)
```

### 3. Registrazione Evento
```
Meetup Theme (Folio/Volt) → Meetup Module (Actions) → Meetup Module (Services) → Database
                                                ↓
                                          Notify Module (Email/SMS)
                                          Activity Module (Logging)
```

---

## 📚 Riferimenti Rapidi

### Comandi Utili

```bash
# PHPStan analysis
./vendor/bin/phpstan analyse Modules --level=10

# Code formatting
./vendor/bin/pint --dirty

# Test execution
./vendor/bin/pest

# Theme build
cd laravel/Themes/Meetup
npm run build && npm run copy

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Module list
php artisan module:list

# Coverage per tutti i moduli
bash bashscripts/testing/generate-coverage.sh
```

### Script Cross-Module

- [Bashscripts](bashscripts/00-index.md) - Script in `bashscripts/` (testing, analysis, docs, git)

### File Chiave

```
Configurazione:
- laravel/.env
- laravel/phpstan.neon
- laravel/composer.json
- laravel/modules_statuses.json

Regole Critiche:
- laravel/Modules/Xot/docs/critical-rules-consolidated.md
- laravel/Themes/Meetup/docs/critical-rules-consolidated.md

Documentazione Root:
- docs/getting-started.md
- docs/project-overview.md
- docs/filament-v5-study-summary.md
```

---

## 🤝 Come Contribuire

### Per Sviluppatori Frontend
- Migliora tema Meetup (CSS/JS)
- Crea nuovi componenti UI
- Implementa animazioni
- Ottimizza responsive design

### Per Sviluppatori Backend
- Migliora moduli (PHPStan Level 10)
- Crea nuove Actions
- Rafforza services e DTO
- Migliora code quality

### Per Sviluppatori Full-Stack
- Integrazione frontend-backend
- Creazione feature end-to-end
- Testing completo
- Documentazione

### Per Documentatori
- Migliora docs esistenti
- Crea nuove guide
- Scrivi esempi
- Aggiorna regole

---

## 📖 Documentazione Esterna

### Laravel Ecosystem
- [Laravel 12.x Documentation](https://laravel.com/docs/12.x)
- [Filament 5.x Documentation](https://filamentphp.com/docs/5.x)
- [Livewire 4.x Documentation](https://livewire.laravel.com/docs/4.x)
- [Laravel Volt Documentation](https://laravel.com/docs/12.x/volt)
- [Laravel Folio Documentation](https://laravel.com/docs/12.x/folio)

### Quality Tools
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Laravel Pint](https://github.com/laravel/pint)
- [PHP Insights](https://phpinsights.com/)
- [Pest PHP Testing](https://pestphp.com/)

### Packages Utilizzati
- [nwidart/laravel-modules](https://github.com/nWidart/laravel-modules)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- [Spatie Laravel Data](https://spatie.be/docs/laravel-data)
- [Spatie Queueable Action](https://github.com/spatie/laravel-queueable-action)
- [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)

---

## 🎯 Prossimi Passi

### 🟢 Nuovo al Progetto?
1. Leggi [Getting Started](getting-started.md)
2. Segui setup environment
3. Esplora modulo Meetup
4. Crea prima feature

### 🟡 Vuoi Contribuire?
1. Leggi [Panoramica Progetto](project-overview.md)
2. Scegli modulo o tema
3. Leggi documentazione modulo
4. Apri issue o PR

### 🔴 Vuoi Approfondire?
1. Studia [PHPStan Code Quality Guide](../laravel/Modules/Xot/docs/phpstan-code-quality-guide.md)
2. Analizza [Regole Critiche Xot](../laravel/Modules/Xot/docs/critical-rules-consolidated.md)
3. Esplora [Filament v5 Study](filament-v5-study-summary.md)
4. Studia codice moduli esistenti

---

## 📞 Supporto

- 📧 Issues: [GitHub Issues](https://github.com/laraxot/laravelpizza.com/issues)
- 💬 Discussion: [GitHub Discussions](https://github.com/laraxot/laravelpizza.com/discussions)
- 📖 Docs: Questa documentazione
- 🍕 Community: [LaravelPizza.com](https://laravelpizza.com)

---

**
**Versione**: Laravel 12.x + Filament 5.x + Livewire 4.x
**PHPStan**: Level 10 (0 errori)
**Status**: Production Ready

**Buon coding! 🍕**