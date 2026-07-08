# 🗺️ FIXCITY - PROJECT ROADMAP COMPLETA

> **Data**: 2025-10-01
> **Versione**: 2.0.0
> **Maintainer**: Development Team

---

## 📊 EXECUTIVE SUMMARY

**FixCity** è una piattaforma di civic engagement per la gestione delle segnalazioni urbane. Architettura **modular monolith** basata su Nwidart + Laraxot, con backend Filament 3.x e frontend Folio + Volt + Livewire 3.x.

### Stato Attuale
- ✅ **Backend Admin**: Filament Resource completo per gestione ticket
- ✅ **Frontend Citizen**: Pagine Folio per creazione e visualizzazione segnalazioni
- ⚠️ **Geolocalizzazione**: Commentato (richiede `dotswan/filament-map-picker`)
- ⚠️ **Upload Media**: Implementato ma necessita testing
- 🚧 **Workflow**: Parzialmente implementato, manca automazione
- 🚧 **Notifiche**: Struttura presente, implementazione incompleta

---

## 🎯 BUSINESS LOGIC

### Flusso Completo
```
CITTADINO                    SISTEMA                      AMMINISTRAZIONE
    │                           │                              │
    ├─► Crea segnalazione       │                              │
    │   - Nome/Titolo           │                              │
    │   - Tipo disservizio      │                              │
    │   - Descrizione           │                              │
    │   - Geolocalizzazione     │                              │
    │   - Foto (max 5)          │                              │
    │                           │                              │
    │   ┌───────────────────────┴───────────────────┐          │
    │   │ DRAFT → PENDING                           │          │
    │   │ - Salva in database                       │          │
    │   │ - Genera slug                             │          │
    │   │ - Associa owner_id                        │          │
    │   │ - Geocode reverse (indirizzo)             │          │
    │   │ - Salva media in Spatie                   │          │
    │   └───────────────────────┬───────────────────┘          │
    │                           │                              │
    │ ◄─── Conferma creazione ──┤                              │
    │      (slug URL)            │                              │
    │                           │                              │
    │                           ├──► Notifica nuova segnalazione│
    │                           │                              │
    │                           │    ┌─────────────────────────┤
    │                           │    │ Moderazione              │
    │                           │    │ - Verifica contenuto     │
    │                           │    │ - Valida geolocalizzazione│
    │                           │    │ - APPROVE / REJECT       │
    │                           │    └─────────────────────────┤
    │                           │                              │
    │                           │    ┌─────────────────────────┤
    │                           │    │ Assegnazione             │
    │                           │    │ - Assegna a tecnico      │
    │                           │    │ - PENDING → ASSIGNED     │
    │                           │    └─────────────────────────┤
    │                           │                              │
    │ ◄─── Notifica assegnazione┼──────────────────────────────┤
    │                           │                              │
    │                           │    ┌─────────────────────────┤
    │                           │    │ Esecuzione               │
    │                           │    │ - ASSIGNED → IN_PROGRESS │
    │                           │    │ - Lavoro sul campo       │
    │                           │    │ - Foto prima/dopo        │
    │                           │    │ - Note tecniche          │
    │                           │    └─────────────────────────┤
    │                           │                              │
    │                           │    ┌─────────────────────────┤
    │                           │    │ Revisione                │
    │                           │    │ - IN_PROGRESS → REVIEW   │
    │                           │    │ - Verifica completamento │
    │                           │    └─────────────────────────┤
    │                           │                              │
    │                           │    ┌─────────────────────────┤
    │                           │    │ Approvazione             │
    │                           │    │ - REVIEW → APPROVED      │
    │                           │    │ - Oppure → REJECTED      │
    │                           │    └─────────────────────────┤
    │                           │                              │
    │                           │    ┌─────────────────────────┤
    │                           │    │ Risoluzione              │
    │                           │    │ - APPROVED → RESOLVED    │
    │                           │    └─────────────────────────┤
    │                           │                              │
    │ ◄─── Notifica risoluzione─┼──────────────────────────────┤
    │                           │                              │
    ├─► Feedback/Rating         │                              │
    │   - Valutazione 1-5       │                              │
    │   - Commento              │                              │
    │                           │                              │
    │                           │    ┌─────────────────────────┤
    │                           │    │ Chiusura                 │
    │                           │    │ - RESOLVED → CLOSED      │
    │                           │    └─────────────────────────┘
    │                           │
```

---

## 🏗️ ARCHITETTURA MODULARE

### Moduli Core

#### **Xot** - Framework Foundation
```
Responsabilità:
- XotBaseModel (base per tutti i models)
- XotBaseServiceProvider (pattern provider)
- XotBaseRouteServiceProvider (route management)
- Updater Trait (created_by/updated_by tracking)
- XotData (configurazioni centralizzate)
```

#### **Fixcity** - Core Business Logic
```
Models:
├── Ticket (core entity)
│   ├── owner: User (cittadino segnalatore)
│   ├── responsible: User (tecnico assegnato)
│   ├── status: TicketStatusEnum
│   ├── priority: TicketPriorityEnum
│   ├── type: TicketTypeEnum
│   ├── latitude/longitude: geolocalizzazione
│   └── slug: URL-friendly identifier
│
├── TicketActivity (storia modifiche)
├── TicketHour (tracciamento ore lavoro)
├── TicketRelation (collegamenti tra ticket)
└── TicketComment (commenti/discussioni)

Enums:
├── TicketStatusEnum
│   ├── DRAFT (bozza)
│   ├── PENDING (in attesa)
│   ├── ASSIGNED (assegnato)
│   ├── IN_PROGRESS (in lavorazione)
│   ├── REVIEW (in revisione)
│   ├── APPROVED (approvato)
│   ├── REJECTED (rifiutato)
│   ├── RESOLVED (risolto)
│   └── CLOSED (chiuso)
│
├── TicketPriorityEnum
│   ├── LOW
│   ├── MEDIUM
│   ├── HIGH
│   └── URGENT
│
└── TicketTypeEnum
    ├── GENERAL
    ├── TECHNICAL
    ├── SUPPORT
    ├── BUG
    └── FEATURE

Filament Resources:
└── TicketResource
    ├── Form Schema (creazione/modifica)
    ├── Table Schema (lista con filtri)
    ├── ListTickets (pagina lista)
    ├── CreateTicket (pagina creazione)
    ├── EditTicket (pagina modifica)
    └── ViewTicket (pagina dettaglio)

Widgets:
└── CreateTicketWidget
    └── Form wizard per cittadini

Folio Pages (Frontend):
├── /it/tickets (index - lista segnalazioni)
├── /it/tickets/create (creazione segnalazione)
└── /it/tickets/{slug} (dettaglio segnalazione)
```

#### **User** - Authentication & Authorization
```
Models:
├── User (extends XotBaseModel)
├── BaseProfile (profilo utente esteso)
└── Roles/Permissions (gestione accessi)

Funzionalità:
├── Autenticazione Laravel standard
├── Profili utente (cittadini/tecnici/admin)
├── Permission system (tramite policies)
└── Profile contracts (XotBaseProfile)
```

#### **Geo** - Geographic Data
```
Funzionalità:
├── Gestione coordinate (latitude/longitude)
├── Reverse geocoding (coordinate → indirizzo)
├── Integrazione OpenStreetMap Nominatim
├── Validazione raggio geografico
└── Mappe interattive (TODO: da abilitare)
```

#### **Media** - File Management
```
Integrazione:
└── Spatie Media Library
    ├── Collection: 'ticket' (foto segnalazioni)
    ├── Disk: 'uploads'
    ├── Responsive images
    ├── Max 5 files per ticket
    └── Max 10MB per file
```

#### **Notify** - Notification System
```
Canali:
├── Email (implementato)
├── Database (implementato)
├── Push (TODO)
└── SMS (TODO)

Eventi:
├── TicketCreated
├── TicketAssigned
├── TicketStatusUpdated
└── TicketResolved
```

#### **Cms** - Content Management
```
Funzionalità:
├── Gestione pagine statiche
├── Layout management
├── Component system
└── Theme integration
```

---

## 📋 ROADMAP DETTAGLIATA

### 🔴 FASE 1: FOUNDATION (PRIORITÀ MASSIMA)

#### 1.1 Completamento Geolocalizzazione
**Stato**: 🚧 Parzialmente implementato (commentato)

**Tasks**:
- [ ] Installare `dotswan/filament-map-picker`
  ```bash
  composer require dotswan/filament-map-picker
  ```
- [ ] Abilitare Map field in `TicketResource::getFormSchema()`
- [ ] Implementare validazione geografica (raggio comunale)
- [ ] Testare reverse geocoding OpenStreetMap
- [ ] Aggiungere fallback per geolocalizzazione manuale
- [ ] Documentare requisiti browser (geolocation API)

**File coinvolti**:
- `Modules/Fixcity/app/Filament/Resources/TicketResource.php:125-154`
- `Modules/Fixcity/app/Rules/FilterCoordinatesInRadius.php`

**Acceptance Criteria**:
- ✅ Mappa interattiva funzionante
- ✅ Geolocalizzazione automatica da browser
- ✅ Marker trascinabile per correzione manuale
- ✅ Validazione coordinate entro raggio configurabile
- ✅ Reverse geocoding funzionante

---

#### 1.2 Upload Media & Gallery
**Stato**: ✅ Implementato, 🚧 Testing richiesto

**Tasks**:
- [ ] Testare upload multiplo (max 5 immagini)
- [ ] Verificare validazione MIME types
- [ ] Testare responsive images generation
- [ ] Implementare preview immagini in form
- [ ] Aggiungere compressione automatica immagini
- [ ] Implementare gallery lightbox in dettaglio ticket
- [ ] Testare eliminazione media

**File coinvolti**:
- `Modules/Fixcity/app/Filament/Resources/TicketResource.php:169-180`
- `Modules/Fixcity/app/Models/Ticket.php:500-505` (registerMediaCollections)
- `Modules/Fixcity/resources/views/pages/tickets/[slug].blade.php:112-121`

**Acceptance Criteria**:
- ✅ Upload fino a 5 immagini
- ✅ Max 10MB per file
- ✅ Solo immagini (jpeg, png)
- ✅ Compressione automatica
- ✅ Gallery funzionante in dettaglio
- ✅ Eliminazione sicura

---

#### 1.3 Workflow Automation
**Stato**: 🚧 Service layer presente, automazione mancante

**Tasks**:
- [ ] Creare `TicketWorkflowService` completo
  - `canTransitionTo(TicketStatusEnum $status): bool`
  - `transitionTo(TicketStatusEnum $status): void`
  - Validazione transizioni di stato
- [ ] Implementare auto-assegnazione basata su carico lavoro
- [ ] Implementare escalation automatica per urgenze
- [ ] Creare job per reminder automatici
- [ ] Implementare SLA tracking
- [ ] Aggiungere metriche performance

**File da creare**:
- `Modules/Fixcity/app/Services/TicketWorkflowService.php`
- `Modules/Fixcity/app/Jobs/AutoAssignTicketJob.php`
- `Modules/Fixcity/app/Jobs/EscalateUrgentTicketJob.php`
- `Modules/Fixcity/app/Jobs/SendTicketReminderJob.php`

**Transizioni di Stato Valide**:
```php
[
    'draft' => ['pending'],
    'pending' => ['assigned', 'rejected'],
    'assigned' => ['in_progress', 'pending'],
    'in_progress' => ['review', 'assigned'],
    'review' => ['approved', 'rejected'],
    'approved' => ['resolved'],
    'rejected' => ['pending', 'closed'],
    'resolved' => ['closed', 'pending'], // riaperti
    'closed' => ['pending'], // riaperti
]
```

---

#### 1.4 Sistema Notifiche Completo
**Stato**: ⚠️ Struttura presente, implementazione parziale

**Tasks**:
- [ ] Completare `TicketCreated` notification
- [ ] Implementare `TicketAssigned` notification
- [ ] Implementare `TicketStatusUpdated` notification
- [ ] Implementare `TicketResolved` notification
- [ ] Aggiungere email template personalizzate
- [ ] Implementare preferenze notifiche utente
- [ ] Aggiungere notifiche in-app (database)
- [ ] Implementare digest giornaliero/settimanale

**File coinvolti**:
- `Modules/Fixcity/app/Notifications/TicketCreated.php`
- `Modules/Fixcity/app/Notifications/TicketStatusUpdated.php`

**File da creare**:
- `Modules/Fixcity/app/Notifications/TicketAssigned.php`
- `Modules/Fixcity/app/Notifications/TicketResolved.php`
- `resources/views/emails/ticket/*.blade.php`

**Acceptance Criteria**:
- ✅ Email inviate correttamente
- ✅ Notifiche database salvate
- ✅ Template email brandizzati
- ✅ Link diretti a ticket
- ✅ Preferenze utente rispettate

---

### 🟡 FASE 2: CITIZEN EXPERIENCE (ALTA PRIORITÀ)

#### 2.1 Miglioramento Pagina Creazione
**Stato**: ✅ Funzionante, 🚧 UX da migliorare

**Tasks**:
- [ ] Migliorare wizard step-by-step
  - Step 1: Tipo disservizio
  - Step 2: Posizione (mappa)
  - Step 3: Dettagli (titolo/descrizione)
  - Step 4: Foto
  - Step 5: Conferma
- [ ] Aggiungere validazione real-time
- [ ] Implementare salvataggio bozze automatico
- [ ] Aggiungere preview prima dell'invio
- [ ] Migliorare accessibilità (WCAG 2.1 AA)
- [ ] Ottimizzare per mobile

**File coinvolti**:
- `Modules/Fixcity/resources/views/pages/tickets/create.blade.php`
- `Modules/Fixcity/app/Filament/Widgets/CreateTicketWidget.php`

---

#### 2.2 Dashboard Cittadino
**Stato**: ❌ Non implementato

**Tasks**:
- [ ] Creare pagina `/it/my-tickets`
- [ ] Lista segnalazioni dell'utente
- [ ] Filtri per stato
- [ ] Statistiche personali
- [ ] Timeline attività per ticket
- [ ] Possibilità di commentare
- [ ] Possibilità di chiudere ticket risolti

**File da creare**:
- `Themes/Sixteen/resources/views/pages/my-tickets/index.blade.php`
- `Modules/Fixcity/app/Livewire/MyTicketsTable.php`

---

#### 2.3 Sistema Commenti & Feedback
**Stato**: ✅ Spatie Comments integrato, 🚧 UI da implementare

**Tasks**:
- [ ] Abilitare commenti pubblici sui ticket
- [ ] Implementare thread di discussione
- [ ] Aggiungere notifiche su nuovi commenti
- [ ] Implementare moderazione commenti
- [ ] Aggiungere sistema di rating (1-5 stelle)
- [ ] Raccogliere feedback su risoluzione
- [ ] Dashboard satisfaction score

**File coinvolti**:
- `Modules/Fixcity/app/Models/Ticket.php:489-492` (comments relation)
- `Modules/Fixcity/app/Models/TicketComment.php`

**File da creare**:
- `Modules/Fixcity/app/Livewire/TicketComments.php`
- Component per rating system

---

### 🟢 FASE 3: ADMIN & OPERATIONS (MEDIA PRIORITÀ)

#### 3.1 Dashboard Amministrativo
**Stato**: 🚧 Parzialmente implementato

**Tasks**:
- [ ] Widget statistiche tempo reale
  - Ticket aperti/chiusi
  - Tempo medio risoluzione
  - Ticket per categoria
  - Ticket per stato
- [ ] Heatmap geografica segnalazioni
- [ ] Grafici trend temporali
- [ ] KPI performance operatori
- [ ] Report esportabili (PDF, Excel)

**File da creare**:
- `Modules/Fixcity/app/Filament/Widgets/TicketStatsWidget.php`
- `Modules/Fixcity/app/Filament/Widgets/TicketHeatmapWidget.php`
- `Modules/Fixcity/app/Filament/Widgets/PerformanceMetricsWidget.php`

---

#### 3.2 Gestione Assegnazioni
**Stato**: ✅ Manuale, ❌ Auto-assegnazione mancante

**Tasks**:
- [ ] Implementare auto-assegnazione intelligente
  - Basata su carico lavoro corrente
  - Basata su competenze (tipo ticket)
  - Basata su zona geografica
- [ ] Dashboard assegnazioni per manager
- [ ] Riassegnazione massiva
- [ ] Notifiche assegnazioni
- [ ] Tracking carico lavoro tecnici

**File da creare**:
- `Modules/Fixcity/app/Services/AutoAssignmentService.php`
- `Modules/Fixcity/app/Policies/AssignmentPolicy.php`

---

#### 3.3 SLA & Performance Tracking
**Stato**: ❌ Non implementato

**Tasks**:
- [ ] Definire SLA per tipologia/priorità
  ```php
  [
      'urgent' => ['response' => '1 hour', 'resolution' => '4 hours'],
      'high' => ['response' => '4 hours', 'resolution' => '24 hours'],
      'medium' => ['response' => '24 hours', 'resolution' => '72 hours'],
      'low' => ['response' => '72 hours', 'resolution' => '7 days'],
  ]
  ```
- [ ] Tracking SLA violations
- [ ] Alert automatici su violazioni
- [ ] Dashboard SLA compliance
- [ ] Report performance mensili

**File da creare**:
- `config/fixcity-sla.php`
- `Modules/Fixcity/app/Services/SlaTrackingService.php`
- `Modules/Fixcity/app/Jobs/CheckSlaViolationsJob.php`

---

### 🔵 FASE 4: ADVANCED FEATURES (BASSA PRIORITÀ)

#### 4.1 API RESTful
**Stato**: ❌ Non implementato

**Tasks**:
- [ ] Implementare API versioning (v1)
- [ ] Endpoint pubblici per cittadini
  - `POST /api/v1/tickets` (create)
  - `GET /api/v1/tickets/{id}` (view)
  - `GET /api/v1/tickets/mine` (my tickets)
- [ ] Autenticazione Laravel Sanctum
- [ ] Rate limiting
- [ ] Documentazione OpenAPI/Swagger
- [ ] SDK JavaScript/Mobile

**File da creare**:
- `routes/api.php` (attualmente vuoto)
- `Modules/Fixcity/app/Http/Controllers/Api/V1/TicketController.php`
- `Modules/Fixcity/app/Http/Resources/TicketResource.php`
- `docs/openapi.yaml`

---

#### 4.2 Mobile App (PWA)
**Stato**: ❌ Non implementato

**Tasks**:
- [ ] Configurare PWA manifest
- [ ] Implementare service worker
- [ ] Cache offline
- [ ] Push notifications native
- [ ] Camera integration per foto
- [ ] Geolocalizzazione nativa
- [ ] Installabilità app

**File da creare**:
- `public/manifest.json`
- `public/sw.js`
- Configuration in `vite.config.js`

---

#### 4.3 AI/ML Features
**Stato**: ❌ Non implementato (futuro)

**Tasks**:
- [ ] Classificazione automatica segnalazioni
- [ ] Rilevamento duplicati con ML
- [ ] Predizione tempi risoluzione
- [ ] Analisi sentiment commenti
- [ ] Suggerimenti auto-completamento

**File da creare**:
- `Modules/AI/` (nuovo modulo)
- Integration con servizi esterni

---

## 🧪 TESTING STRATEGY

### Unit Tests
```bash
# Test modelli
tests/Unit/Fixcity/Models/TicketTest.php
tests/Unit/Fixcity/Enums/TicketStatusEnumTest.php

# Test services
tests/Unit/Fixcity/Services/TicketWorkflowServiceTest.php
tests/Unit/Fixcity/Services/AutoAssignmentServiceTest.php
```

### Feature Tests
```bash
# Test workflow completo
tests/Feature/Fixcity/TicketCreationFlowTest.php
tests/Feature/Fixcity/TicketAssignmentFlowTest.php
tests/Feature/Fixcity/TicketResolutionFlowTest.php

# Test authorization
tests/Feature/Fixcity/TicketAuthorizationTest.php
```

### Integration Tests
```bash
# Test API
tests/Feature/Api/V1/TicketApiTest.php

# Test notifiche
tests/Feature/Fixcity/NotificationTest.php
```

### Browser Tests (Pest + Playwright)
```bash
# Test E2E cittadino
tests/Browser/CitizenCreateTicketTest.php
tests/Browser/CitizenViewTicketTest.php

# Test E2E admin
tests/Browser/AdminManageTicketTest.php
```

---

## 📊 METRICHE DI SUCCESSO

### KPI Operativi
| Metrica | Target | Attuale | Status |
|---------|--------|---------|--------|
| Tempo medio risoluzione | < 48h | TBD | 🚧 |
| Tasso soddisfazione | > 80% | TBD | 🚧 |
| SLA compliance | > 95% | TBD | 🚧 |
| Segnalazioni/mese | > 500 | TBD | 🚧 |

### KPI Tecnici
| Metrica | Target | Attuale | Status |
|---------|--------|---------|--------|
| Code coverage | > 80% | ~30% | 🔴 |
| PHPStan level | 9 | 3 | 🟡 |
| Response time | < 200ms | ~150ms | ✅ |
| Uptime | > 99.9% | TBD | 🚧 |

---

## 🚀 TIMELINE

### Q1 2025 (Gen-Mar)
- ✅ Completare Fase 1 (Foundation)
  - Geolocalizzazione
  - Upload media
  - Workflow automation
  - Notifiche

### Q2 2025 (Apr-Giu)
- 🎯 Completare Fase 2 (Citizen Experience)
  - Dashboard cittadino
  - Sistema commenti
  - Rating/feedback
  - Mobile optimization

### Q3 2025 (Lug-Set)
- 🎯 Completare Fase 3 (Admin & Operations)
  - Dashboard admin completo
  - Auto-assegnazione
  - SLA tracking
  - Report avanzati

### Q4 2025 (Ott-Dic)
- 🎯 Fase 4 (Advanced Features)
  - API RESTful
  - PWA
  - Integrazioni esterne

---

## 🤝 CONTRIBUTI

### Come Contribuire
1. Leggere documentazione completa
2. Scegliere task da roadmap
3. Creare branch: `feature/TASK-NAME`
4. Sviluppare seguendo standards
5. Scrivere test
6. Aggiornare documentazione
7. Pull request

### Coding Standards
- ✅ PSR-12 compliance
- ✅ Type hints obbligatori
- ✅ PHPDoc completo
- ✅ Enum per stati/tipi
- ✅ Service layer pattern
- ✅ Test coverage > 80%

---

## 📚 DOCUMENTAZIONE CORRELATA

### Moduli
- [Fixcity ROADMAP](Modules/Fixcity/docs/ROADMAP.md)
- [Fixcity README](Modules/Fixcity/docs/README.md)
- [Cms ROADMAP](Modules/Cms/docs/development/roadmap.md)

### Temi
- [Sixteen Theme Docs](Themes/Sixteen/docs/)

### Best Practices
- [Laravel Boost Guidelines](CLAUDE.md)
- [Architecture Patterns](docs/architecture/)

---

**Ultimo aggiornamento**: 2025-10-01
**Maintainer**: Development Team
