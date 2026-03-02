# Indice Filosofico Completo - Tutti i Moduli

**Data Creazione**: [DATE]
**Status**: Indice Master Completo

## 📋 Panoramica

Questo documento fornisce un indice completo di tutta la documentazione filosofica (Logica, Religione, Politica, Zen) di tutti i moduli del progetto TechPlanner.

---

## 🏗️ Moduli Core

### Xot - Il Motore Fondamentale
**File**: [philosophy-complete.md](./philosophy-complete.md)

**Filosofia**: Xot è il motore che alimenta tutti gli altri moduli. Non contiene business logic, solo infrastruttura.

**Principi**:
- Logica: Fornisce classi base (50+), service providers (20+), trait (15+)
- Religione: Mai estendere Filament direttamente, sempre XotBase
- Politica: Type safety assoluta (PHPStan livello 10)
- Zen: Il vuoto che sostiene tutto

---

## 💼 Moduli Business

### TechPlanner - Business Principale
**File**: [../../TechPlanner/docs/philosophy-complete.md](../../techplanner/docs/philosophy-complete.md)

**Filosofia**: Client-Centric, Compliance-First, Integration Over Duplication

**Principi**:
- Logica: Gestione aziende servizi tecnici (clienti, appuntamenti, dispositivi, compliance)
- Religione: Client è centro universo, Compliance sacra, Geolocalizzazione automatica
- Politica: Multi-contact strategy, Device lifecycle, Compliance integrata
- Zen: Workflow impliciti, integrazione naturale moduli

**Entità Core**: Client, Appointment, Device, LegalRepresentative, MedicalDirector, Worker

---

## 🔧 Moduli Supporto

### User - Foundation Identity
**File**: [../../User/docs/philosophy-complete.md](../../user/docs/philosophy-complete.md)

**Filosofia**: STI Unity, RBAC Standard, Multi-Tenant Isolation

**Principi**:
- Logica: Authentication, Authorization, STI (Doctor/Patient/Admin), Multi-tenancy
- Religione: STI sacra, Parental obbligatorio, Spatie permissions base
- Politica: Type safety con enum, role hierarchy, tenant isolation
- Zen: Vuoto identità unificata, type polymorphism, profile extension

**Entità Core**: BaseUser, User, Doctor, Patient, Admin, Profile, Role, Permission, Team, Tenant

---

### UI - Componenti Interfaccia
**File**: [../../UI/docs/philosophy.md](../../ui/docs/philosophy.md)

**Filosofia**: Riusabilità, Consistenza Visiva, Type Safety

**Principi**:
- Logica: Componenti Blade riutilizzabili, widget Filament, layout system
- Religione: Consistenza visiva sacra, component-based architecture
- Politica: PHPStan livello 10, accessibility first, responsive by default
- Zen: Auto-discovery, semplicità interfaccia, design system coerente

**Componenti**: IconPicker, RadioBadge, OpeningHoursField, LocationSelector, TableLayoutEnum

---

### Geo - Geolocalizzazione
**File**: [../../Geo/docs/philosophy.md](../../geo/docs/philosophy.md)

**Filosofia**: Schema.org Compliance, Polymorphic Flexibility, Geographic Type Safety

**Principi**:
- Logica: Indirizzi standardizzati, geocoding automatico, coordinate validate
- Religione: Schema.org è la bibbia degli indirizzi, polymorphic relationships
- Politica: Coordinate validate, Haversine formula, address type enum
- Zen: Auto-formattazione, JSON caching, service abstraction

**Entità Core**: Address, Comune, Province, Region, Location

---

### Tenant - Multi-Tenancy
**File**: [../../Tenant/docs/philosophy.md](../../tenant/docs/philosophy.md)

**Filosofia**: Sovranità Digitale Distribuita, Isolamento Assoluto

**Principi**:
- Logica: Isolamento dati, domain-based routing, connection scoping
- Religione: Data sovereignty, inviolabilità confini, portabilità totale
- Politica: Explicit connections, stateless identification, clear separation
- Zen: Minimalismo (3 tabelle core), configurazione distribuita, zero pollution

**Entità Core**: Tenant, Domain, TenantUser

---

### Notify - Comunicazione
**File**: [../../Notify/docs/philosophy.md](../../notify/docs/philosophy.md)

**Filosofia**: Comunicazione Responsabile, Minimalismo Funzionale

**Principi**:
- Logica: Notifiche multi-canale (Email, SMS, Push), template system, delivery tracking
- Religione: Privacy utente sacra, integrità messaggio, rispetto tempo
- Politica: Trasparenza, consenso, rilevanza, tempestività
- Zen: Essenzialità messaggi, non-intrusività, il vuoto funzionale (a volte nessuna notifica è la migliore)

**Componenti**: MailTemplate, Notification, Contact, NotificationManager

---

### Activity - Audit Trail
**File**: [../../Activity/docs/philosophy-complete.md](../../activity/docs/philosophy-complete.md)

**Filosofia**: Track Everything, Reconstruct Anything, Privacy First

**Principi**:
- Logica: Audit trail completo, event sourcing, activity logging, snapshots
- Religione: Tutto tracciabile, immutabilità eventi, context è re
- Politica: Spatie ActivityLog base, event sourcing opzionale, privacy by default
- Zen: Invisible tracking, silent observer, complete history, reconstruction power

**Entità Core**: Activity, StoredEvent, Snapshot

---

### Media - File Management
**File**: [../../Media/docs/philosophy-complete.md](../../media/docs/philosophy-complete.md)

**Filosofia**: Secure Upload, Smart Storage, Automatic Processing

**Principi**:
- Logica: Upload sicuro, storage multi-disk, processing automatico, collections organizzate
- Religione: Spatie Media Library base, collections organizzate, conversions automatiche
- Politica: Multi-disk storage, lazy processing, security first
- Zen: Invisible storage, automatic processing, smart delivery, self-organization

**Entità Core**: Media (Spatie Media Library)

---

### Cms - Content Management
**File**: [../../Cms/docs/philosophy.md](../../cms/docs/philosophy.md)

**Filosofia**: Contenuto Strutturato e Modulare, Gerarchia Sacra

**Principi**:
- Logica: Pagine, sezioni, blocchi, menu, multi-localizzazione
- Religione: Gerarchia contenuti sacra, blocchi compositi, separazione contenuto/presentazione
- Politica: Block-based system, multi-language support, SEO optimization
- Zen: Modularità contenuto, riusabilità blocchi, auto-organization

**Entità Core**: Page, Section, Menu, Block, Conf

---

### Employee - HR Management
**File**: [../../Employee/docs/philosophy-complete.md](../../employee/docs/philosophy-complete.md)

**Filosofia**: Actions-Only, Compliance-First, Italian Labor Law

**Principi**:
- Logica: Employee lifecycle, time tracking, leave management, documenti HR
- Religione: Actions only (mai Services), sequenze temporali sacre, state machine rigorosa
- Politica: dipendentincloud.it replica migliorata, compliance normativa italiana
- Zen: Vuoto gestisce complessità normativa, automatic validation, policy protection

**Entità Core**: Employee, WorkHour, LeaveRequest, Department, Position

---

## 📚 Struttura Documentazione Filosofica

Ogni documento filosofia-complete.md segue questa struttura:

1. **Logica (Logic)**
   - Principio Fondamentale
   - Dominio di Business
   - Entità Core
   - Business Workflow Principale
   - Manifestazione nel Codice

2. **Religione (Religion)**
   - Comandamenti Sacri
   - Best Practices
   - Integrazione Moduli

3. **Politica (Politics)**
   - Decisioni Architetturali
   - Governance del Modulo
   - Pattern Implementativi

4. **Zen (Zen)**
   - Il Vuoto della Complessità
   - Flusso Naturale
   - Semplicità nella Complessità

5. **Manifestazioni Pratiche**
   - Esempi codice
   - Pattern concreti
   - Integrazioni

---

## 🔗 Collegamenti Cross-Module

### Dipendenze Architetturali

```
Xot (Foundation)
    ↓
User (Identity Foundation)
    ↓
├── TechPlanner (Business Logic)
│   ├── Geo (Geolocalizzazione)
│   ├── Notify (Comunicazioni)
│   ├── Media (File Management)
│   └── Activity (Audit Trail)
│
├── Employee (HR)
│   ├── User (Identity)
│   ├── Activity (Tracking)
│   └── Media (Documenti)
│
└── Cms (Content)
    ├── Media (Assets)
    └── User (Authors)
```

### Integrazioni Filosofiche

- **Xot → Tutti**: Fornisce foundation, tutti dipendono da Xot
- **User → Tutti**: Tutti i moduli usano User per identity
- **Activity → Tutti**: Tutti i moduli loggano activities
- **Media → Business Modules**: File management per tutti
- **Notify → Business Modules**: Comunicazioni per tutti
- **Geo → Business Modules**: Geolocalizzazione dove necessario

---

## 📝 Note sulla Documentazione

### Coerenza Strutturale

Tutti i documenti filosofia-complete.md seguono la stessa struttura per:
- Facilitare navigazione
- Mantenere coerenza
- Permettere confronti cross-module
- Standardizzare comprensione

### Aggiornamenti

Quando si modifica business logic, workflow, o pattern di un modulo:
1. Aggiornare philosophy-complete.md del modulo
2. Verificare impatti cross-module
3. Aggiornare questo indice se necessario

---

**Status**: ✅ Documentazione Filosofica Completa per Tutti i Moduli Principali
