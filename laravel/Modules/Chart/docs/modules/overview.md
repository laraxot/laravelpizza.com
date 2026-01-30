# 📦 Panoramica Moduli - Architettura DRY + KISS

## 🎯 Filosofia Modulare

Il sistema <nome progetto> segue un'architettura modulare basata sui principi:

- **DRY**: Ogni funzionalità è implementata una sola volta
- **KISS**: Struttura semplice e comprensibile
- **Single Responsibility**: Ogni modulo ha una responsabilità specifica
- **Loose Coupling**: Moduli indipendenti e intercambiabili

## 🏗️ Struttura Modulare

### Core Modules (Fondamentali)

#### ⚙️ Xot
- **Scopo**: Framework base e funzionalità comuni
- **Responsabilità**: BaseModel, ServiceProvider, Utilities
- **Dipendenze**: Nessuna (modulo base)
- **Documentazione**: [Xot Module](../laravel/Modules/Xot/docs/)

#### 👤 User
- **Scopo**: Gestione utenti, autenticazione, autorizzazione
- **Responsabilità**: User management, Roles, Permissions
- **Dipendenze**: Xot
- **Documentazione**: [User Module](../laravel/Modules/User/docs/)

#### 🎨 UI
- **Scopo**: Componenti interfaccia utente condivisi
- **Responsabilità**: Blade components, Assets, Themes
- **Dipendenze**: Xot
- **Documentazione**: [UI Module](../laravel/Modules/UI/docs/)

### Business Modules (Logica di Business)

#### 🏥 <nome progetto>
- **Scopo**: Logica principale dell'applicazione sanitaria
- **Responsabilità**: Appointments, Reports, Doctors, Patients
- **Dipendenze**: Xot, User, UI
- **Documentazione**: [<nome progetto> Module](../laravel/Modules/<nome progetto>/docs/)

#### 🦷 SaluteMo
- **Scopo**: Modulo specifico per salute orale mobile
- **Responsabilità**: Mobile interface, Simplified workflows
- **Dipendenze**: <nome progetto>, UI
- **Documentazione**: [SaluteMo Module](../laravel/Modules/SaluteMo/docs/)

### Support Modules (Supporto)

#### 🏢 Tenant
- **Scopo**: Multi-tenancy e isolamento dati
- **Responsabilità**: Tenant management, Data isolation
- **Dipendenze**: Xot, User
- **Documentazione**: [Tenant Module](../laravel/Modules/Tenant/docs/)

#### 📊 Chart
- **Scopo**: Grafici e visualizzazioni
- **Responsabilità**: Chart components, Data visualization
- **Dipendenze**: Xot, UI
- **Documentazione**: [Chart Module](../laravel/Modules/Chart/docs/)

#### 📝 Cms
- **Scopo**: Content Management System
- **Responsabilità**: Pages, Content, SEO
- **Dipendenze**: Xot, UI
- **Documentazione**: [Cms Module](../laravel/Modules/Cms/docs/)

#### 🌍 Geo
- **Scopo**: Funzionalità geografiche
- **Responsabilità**: Maps, Locations, Geocoding
- **Dipendenze**: Xot
- **Documentazione**: [Geo Module](../laravel/Modules/Geo/docs/)

#### 🔔 Notify
- **Scopo**: Sistema di notifiche
- **Responsabilità**: Email, SMS, Push notifications
- **Dipendenze**: Xot, User
- **Documentazione**: [Notify Module](../laravel/Modules/Notify/docs/)

## 📊 Matrice delle Dipendenze

```
┌─────────────┬─────┬──────┬────┬───────────┬─────────┬────────┬───────┬─────┬─────┬────────┐
│ Modulo      │ Xot │ User │ UI │ <nome progetto> │ SaluteMo│ Tenant │ Chart │ Cms │ Geo │ Notify │
├─────────────┼─────┼──────┼────┼───────────┼─────────┼────────┼───────┼─────┼─────┼────────┤
│ Xot         │  -  │  -   │ -  │     -     │    -    │   -    │   -   │  -  │  -  │   -    │
│ User        │  ✓  │  -   │ -  │     -     │    -    │   -    │   -   │  -  │  -  │   -    │
│ UI          │  ✓  │  -   │ -  │     -     │    -    │   -    │   -   │  -  │  -  │   -    │
│ <nome progetto>   │  ✓  │  ✓   │ ✓  │     -     │    -    │   -    │   -   │  -  │  -  │   -    │
│ SaluteMo    │  ✓  │  ✓   │ ✓  │     ✓     │    -    │   -    │   -   │  -  │  -  │   -    │
│ Tenant      │  ✓  │  ✓   │ -  │     -     │    -    │   -    │   -   │  -  │  -  │   -    │
│ Chart       │  ✓  │  -   │ ✓  │     -     │    -    │   -    │   -   │  -  │  -  │   -    │
│ Cms         │  ✓  │  -   │ ✓  │     -     │    -    │   -    │   -   │  -  │  -  │   -    │
│ Geo         │  ✓  │  -   │ -  │     -     │    -    │   -    │   -   │  -  │  -  │   -    │
│ Notify      │  ✓  │  ✓   │ -  │     -     │    -    │   -    │   -   │  -  │  -  │   -    │
└─────────────┴─────┴──────┴────┴───────────┴─────────┴────────┴───────┴─────┴─────┴────────┘
```

## 🔄 Flusso di Comunicazione

### Pattern di Comunicazione

1. **Event-Driven**: Moduli comunicano tramite eventi Laravel
2. **Service Layer**: Servizi condivisi per logica cross-module
3. **API Internal**: API interne per comunicazione strutturata
4. **Dependency Injection**: IoC container per gestione dipendenze

### Esempio di Flusso

```
User Registration Flow:
┌─────────┐    ┌──────────┐    ┌─────────┐    ┌────────┐
│   UI    │───▶│   User   │───▶│ Notify  │───▶│ Email  │
│ Widget  │    │ Service  │    │ Service │    │ Queue  │
└─────────┘    └──────────┘    └─────────┘    └────────┘
                      │
                      ▼
               ┌─────────────┐
               │ <nome progetto>   │
               │ Integration │
               └─────────────┘
```

## 📋 Standard di Sviluppo

### Convenzioni Modulo

1. **Namespace**: `Modules\{ModuleName}\`
2. **Structure**: Seguire template standardizzato
3. **Documentation**: Documentazione completa in `docs/`
4. **Testing**: Test unitari e feature per ogni modulo
5. **Translation**: File di traduzione completi

### Checklist Nuovo Modulo

- [ ] Struttura directory standard
- [ ] ServiceProvider configurato
- [ ] BaseModel esteso da Xot
- [ ] Documentazione completa
- [ ] Test implementati
- [ ] Traduzioni complete
- [ ] Dipendenze dichiarate

## 🔗 Collegamenti Utili

- [Template Module README](../templates/module-readme.md)
- [Development Standards](../development/coding-standards.md)
- [Testing Guidelines](../development/testing.md)
- [Architecture Principles](../core/architettura_tecnologica.md)

---

*Documentazione consolidata secondo principi DRY + KISS*  
*Ultimo aggiornamento: 2025-08-04*
