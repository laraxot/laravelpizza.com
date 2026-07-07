# 📦 Moduli del Sistema

> **Architettura**: Nwidart + Laraxot - Modular Monolith

## 🏗️ Moduli Core

### Xot - Framework Base
**Path**: `Modules/Xot/`  
**Responsabilità**: Pattern base, service providers, trait condivisi  
**Status**: ✅ Attivo - Base del sistema  
**Docs**: [📖 Xot Docs](../../Modules/Xot/docs/README.md)

- `XotBaseModel` - Modello base per tutti i moduli
- `XotBaseServiceProvider` - Provider base estendibile  
- `UpdaterTrait` - Tracking automatico created_by/updated_by
- Pattern architetturali comuni

### Fixcity - Business Logic
**Path**: `Modules/Fixcity/`  
**Responsabilità**: Core della piattaforma di segnalazioni  
**Status**: ✅ Attivo - Modulo principale  
**Docs**: [📖 Fixcity Docs](../../Modules/Fixcity/docs/links.md)

- Gestione segnalazioni cittadini
- Workflow amministrativo
- Geolocalizzazione automatica
- Sistema allegati foto

### User - Gestione Utenti  
**Path**: `Modules/User/`  
**Responsabilità**: Autenticazione, profili, permessi  
**Status**: ✅ Attivo - Sistema utenti  
**Docs**: [📖 User Docs](../../Modules/User/docs/README.md)

- Autenticazione Laravel
- Profili utente cittadini/staff
- Sistema permessi e ruoli
- Gestione account

## 🎨 Moduli Frontend

### UI - Interfaccia Condivisa
**Path**: `Modules/UI/`  
**Responsabilità**: Componenti UI riutilizzabili  
**Status**: ✅ Attivo - Componenti base  
**Docs**: [📖 UI Docs](../../Modules/UI/docs/README.md)

- Componenti Livewire condivisi
- [DarkModeSwitcher](../../Modules/UI/docs/components.md#darkmodeswitcher) - Toggle modalità scuro
- Layout base applicazione
- Utilità frontend

### Cms - Gestione Contenuti
**Path**: `Modules/Cms/`  
**Responsabilità**: Sistema CMS, pagine statiche  
**Status**: ✅ Attivo - Content management  
**Docs**: [📖 CMS Docs](../../Modules/Cms/docs/README.md)

- Gestione pagine JSON
- Homepage builder
- [Compilazione Temi](../../Modules/Cms/docs/theme_compilation.md) - Build process
- [Errori Vite](../../Modules/Cms/docs/theme_compilation.md#errore-unable-to-locate-file-in-vite-manifest) - Troubleshooting

## 📊 Moduli Dati

### Geo - Servizi Geografici
**Path**: `Modules/Geo/`  
**Responsabilità**: Dati geografici, mappe, coordinate  
**Status**: ✅ Attivo - Geolocalizzazione  

- Integrazione mappe
- Geocoding/reverse geocoding
- Zone amministrative
- Coordinate GPS segnalazioni

### Chart - Visualizzazione Dati  
**Path**: `Modules/Chart/`  
**Responsabilità**: Grafici, dashboard, KPI  
**Status**: ✅ Attivo - Analytics  
**Docs**: [📖 Chart Docs](../../Modules/Chart/docs/README.md)

- ECharts integration
- Dashboard amministrativa
- Export grafici (PDF, PNG, SVG)
- Performance metrics

### Activity - Audit Trail
**Path**: `Modules/Activity/`  
**Responsabilità**: Log attività, cronologia  
**Status**: ✅ Attivo - Audit system  
**Docs**: [📖 Activity Docs](../../Modules/Activity/docs/README.md)

- Event sourcing pattern
- Log attività utenti
- Cronologia modifiche
- Audit compliance

## 🔧 Moduli Servizi

### Notify - Sistema Notifiche
**Path**: `Modules/Notify/`  
**Responsabilità**: Notifiche multi-canale  
**Status**: ✅ Attivo - Notifications  

- Email notifications
- SMS integration
- Push notifications
- Template management

### AI - Intelligenza Artificiale
**Path**: `Modules/AI/`  
**Responsabilità**: Integrazione AI/ML  
**Status**: ✅ Attivo - AI services  
**Docs**: [📖 AI Docs](../../Modules/AI/docs/README.md)

- Classificazione automatica segnalazioni
- Chatbot assistenza
- Analisi sentiment
- OpenAI integration

### Job - Queue Management
**Path**: `Modules/Job/`  
**Responsabilità**: Gestione code lavoro  
**Status**: ✅ Attivo - Background jobs  

- Queue processing
- Job scheduling  
- Error handling
- Performance monitoring

## 🌐 Moduli Supporto

### Lang - Internazionalizzazione
**Path**: `Modules/Lang/`  
**Responsabilità**: Gestione traduzioni  
**Status**: ✅ Attivo - i18n system  

- Multi-language support
- Dynamic translations
- Filament integration
- Translation management

### Media - Gestione File
**Path**: `Modules/Media/`  
**Responsabilità**: Upload, storage, processing file  
**Status**: ✅ Attivo - File management  

- File uploads
- Image processing
- Storage management
- CDN integration

### Rating - Sistema Valutazioni
**Path**: `Modules/Rating/`  
**Responsabilità**: Valutazioni e feedback  
**Status**: ✅ Attivo - Rating system  
**Docs**: [📖 Rating Docs](../../Modules/Rating/docs/README.md)

- User ratings
- Feedback collection
- Quality scoring
- Analytics valutazioni

## 🔒 Moduli Compliance

### Gdpr - Privacy Compliance  
**Path**: `Modules/Gdpr/`  
**Responsabilità**: Conformità GDPR  
**Status**: ✅ Attivo - Privacy compliance  

- Cookie consent
- Data export
- Right to be forgotten
- Privacy policy management

### Tenant - Multi-tenancy
**Path**: `Modules/Tenant/`  
**Responsabilità**: Isolamento dati multi-tenant  
**Status**: ✅ Attivo - Multi-tenancy  

- Tenant isolation
- Database separation
- Domain routing
- Resource scoping

## 🔍 Moduli Utility

### Blog - Sistema Blog
**Path**: `Modules/Blog/`  
**Responsabilità**: Pubblicazione contenuti blog  
**Status**: ✅ Attivo - Content publishing  
**Docs**: [📖 Blog Docs](../../Modules/Blog/docs/README.md)

- Post management
- Categories/tags
- Comment system
- SEO optimization

### Comment - Sistema Commenti
**Path**: `Modules/Comment/`  
**Responsabilità**: Gestione commenti  
**Status**: ✅ Attivo - Comment system  

- Threaded comments
- Moderation tools
- Notification integration
- Spam protection

### Seo - Ottimizzazione SEO
**Path**: `Modules/Seo/`  
**Responsabilità**: SEO management  
**Status**: ✅ Attivo - SEO tools  

- Meta tags management
- Sitemap generation
- Schema markup
- Analytics integration

---

## 📈 Module Status Dashboard

| Modulo | Status | PHPStan | Tests | Docs |
|--------|---------|---------|-------|------|
| Xot | ✅ Active | Level 9 | ✅ 80% | ✅ Complete |  
| Fixcity | ✅ Active | Level 7 | ⚠️ 60% | 📝 Updating |
| User | ✅ Active | Level 8 | ✅ 75% | ✅ Complete |
| UI | ✅ Active | Level 8 | ✅ 70% | ✅ Complete |
| Cms | ✅ Active | Level 7 | ⚠️ 65% | ✅ Complete |
| Geo | ✅ Active | Level 6 | ⚠️ 50% | 📝 Basic |
| Chart | ✅ Active | Level 7 | ⚠️ 55% | ✅ Complete |
| Activity | ✅ Active | Level 8 | ✅ 85% | ✅ Complete |
| AI | ✅ Active | Level 6 | ⚠️ 45% | ✅ Complete |
| Notify | ✅ Active | Level 7 | ⚠️ 60% | 📝 Basic |

**Legenda**: ✅ Good | ⚠️ Needs Improvement | ❌ Critical | 📝 In Progress

---

## 📝 Struttura Documentazione Moduli

Ogni modulo mantiene la documentazione in `Modules/{Nome}/docs/`:

```
docs/
├── README.md          # Overview e quick reference
├── phpstan/           # Analisi e correzioni PHPStan
├── models/            # Documentazione modelli
├── contracts/         # Interfacce e contratti
├── traits/            # Trait e utilizzo
├── database/          # Schema e migrazioni
├── features.md        # Funzionalità del modulo
└── roadmap.md         # Piano di sviluppo
```

## 🔗 Collegamenti Principali

- [Analisi PHPStan](../phpstan.md)
- [Contratti del Sistema](../contracts.md)
- [Modelli di Dominio](../models.md)
- [Temi e Frontend](../themes/index.md)

---

*Memoria del progetto: Ogni modulo è un dominio bounded con responsabilità chiare* 
