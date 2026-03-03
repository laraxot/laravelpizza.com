# Product Requirements Document (PRD)

## Metadata

| Campo | Valore |
|-------|--------|
| **Version** | 1.0.0 |
| **Status** | Approved |
| **
| **Owner** | Core Team |
| **Module** | Activity |
| **Repository** | laraxot/module_activity_fila5 |

---

## 1. Panoramica del Prodotto

### Descrizione Breve
Il modulo Activity fornisce **audit trail completo** e **event sourcing** per l'ecosistema Laraxot. Traccia tutte le azioni degli utenti e supporta pattern CQRS per operazioni complesse.

### Visione
Garantire:
- Tracciabilità completa delle azioni
- Debug semplificato
- Compliance GDPR/audit
- Event-driven architecture foundation

### Target Users
- **Admin**: Audit trail, compliance
- **Support**: Debug problemi utente
- **Developer**: Event sourcing, CQRS

---

## 2. Problema

### Problema Risolto
- Non si sa chi ha fatto cosa e quando
- Difficoltà nel debug in produzione
- Compliance richiede audit trail
- Mancanza di event history per undo

### Pain Points
- Log sparsi in più posti
- Formato non standardizzato
- Query complesse per analytics
- Performance con molti eventi

---

## 3. Soluzione Proposta

### Funzionalità Core

#### 3.1 Activity Log (Spatie)
- [x] Automatic model tracking
- [x] Custom event logging
- [x] Subject/causer relationship
- [x] Properties (before/after)
- [x] Tenant isolation
- [x] Data retention policies

#### 3.2 Event Sourcing
- [x] Stored events
- [x] Event handlers
- [x] Projections
- [x] Aggregates
- [x] Reactors

#### 3.3 Audit Trail UI
- [x] Timeline view
- [x] Filtering per user/date/action
- [x] Export per compliance
- [x] Diff visualization

### Architettura

```
User Action
    ↓
ActivityLogger::log()
    ↓
Activity Model Created
    ↓
┌──→ Email Notification (reactor)
├──→ Audit Trail
└──→ Event Processor
```

---

## 4. Scope

### In Scope
- [x] Activity log base
- [x] Event sourcing
- [x] Audit trail UI
- [x] Tenant isolation
- [x] Retention policies

### Out of Scope
- [ ] Real-time dashboards
- [ ] Anomaly detection

---

## 5. Metriche

| KPI | Target |
|-----|--------|
| Log Performance | <50ms per evento |
| Storage | <1GB per 1M eventi |
| Query Speed | <1s per audit list |

---

## 6. Dipendenze

### Esterne
| Pacchetto | Scopo |
|-----------|-------|
| spatie/laravel-activitylog | Core logging |
| spatie/laravel-event-sourcing | Event sourcing |

### Interne
Xot, Tenant, User

---

## 7. Appendici

### Schema
```
activities
├── id
├── tenant_id
├── log_name
├── description
├── subject_type
├── subject_id
├── causer_type
├── causer_id
├── properties (JSON)
├── created_at
└── updated_at
```

### Glossario
| Termine | Definizione |
|---------|-------------|
| Audit Trail | Registro cronologico azioni |
| Event Sourcing | Pattern architetturale con eventi |
| Reactor | Handler che reagisce agli eventi |
| Aggregate | Entity che gestisce sequence di eventi |
