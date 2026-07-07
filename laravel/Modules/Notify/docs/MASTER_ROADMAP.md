# 🗺️ FIXCITY - MASTER ROADMAP 2025-2026

> **Roadmap strategica completa per il completamento e l'evoluzione della piattaforma**

---

## 📊 Executive Summary

**Obiettivo**: Trasformare FixCity da MVP funzionale a piattaforma enterprise-ready per gestione disservizi urbani scalabile a livello nazionale.

**Timeline**: 18 mesi (Ottobre 2025 - Marzo 2027)
**Budget stimato**: €250k (team di 3 dev full-time)
**ROI atteso**: Gestione 500k+ ticket/anno, riduzione costi amministrativi 60%

---

## 🎯 Strategic Phases

### Phase 0: Foundation (COMPLETATO ✅)
**Timeline**: Set 2024 - Ott 2025
**Status**: 100% completato

**Achievements**:
- ✅ Architettura modulare Nwidart + Laraxot
- ✅ Authentication & Authorization completo
- ✅ Ticket CRUD con Filament
- ✅ Status workflow implementato
- ✅ Frontend Folio + Livewire
- ✅ Theme system (Sixteen)
- ✅ PHPStan compliance (0 errori)

---

### Phase 1: Performance & Stability (Q4 2025)
**Timeline**: Ottobre - Dicembre 2025
**Priority**: 🔴 CRITICAL
**Effort**: 320 ore (~2 mesi, 2 dev)

#### Obiettivi
1. Eliminare tutti i bottleneck performance
2. Raggiungere 85%+ test coverage
3. Preparare per production deployment

#### Epic 1.1: Query Optimization (80h)

**Tasks**:
- [ ] Implementare eager loading su tutte le liste Filament (16h)
  - Files: `ListTickets.php`, `ListUsers.php`, etc.
  - Expected: Query count -90%

- [ ] Refactor AGID component da DB::table() a Eloquent (8h)
  - File: `app/View/Components/Blocks/TicketList/Agid.php`
  - Add caching (5 min)

- [ ] Creare GeocodeTicketAddressJob (24h)
  - Async geocoding via queue
  - Cache condivisa coordinate → address
  - Fallback mechanism se OSM down
  - Migration: add `address` field to tickets table

- [ ] Implementare Repository Pattern (32h)
  - `TicketRepository` con query comuni
  - Cache layer integrato
  - Spatial queries (nearby tickets)

**Acceptance Criteria**:
- TTFB < 200ms su tutte le pagine
- Query count < 10 per page
- Memory usage < 50MB per request

---

#### Epic 1.2: Testing Infrastructure (120h)

**Tasks**:
- [ ] Pest tests per Ticket module (40h)
  ```bash
  tests/Feature/Ticket/
    CreateTicketTest.php
    UpdateTicketTest.php
    AssignTicketTest.php
    StatusWorkflowTest.php
    GeocodeTicketTest.php
  ```

- [ ] Pest tests per User module (32h)
  ```bash
  tests/Feature/User/
    RegistrationTest.php
    AuthenticationTest.php
    RolePermissionTest.php
    ProfileTest.php
  ```

- [ ] Integration tests (24h)
  - Email notifications delivery
  - File uploads
  - Geocoding API

- [ ] CI/CD pipeline setup (24h)
  - GitHub Actions
  - PHPStan + Pest on every PR
  - Auto-deploy to staging

**Acceptance Criteria**:
- Test coverage ≥ 85%
- All tests green
- CI/CD running on every commit

---

#### Epic 1.3: Database Optimization (40h)

**Tasks**:
- [ ] Add strategic indexes (8h)
  ```sql
  tickets:
    - index(status, created_at)
    - index(latitude, longitude) -- spatial
    - index(owner_id, status)
    - fulltext(name, content) -- search
  ```

- [ ] Migrate SQLite → PostgreSQL (16h)
  - Production setup
  - Connection pooling
  - Read replicas ready

- [ ] Implement database seeder realistico (8h)
  - 10k ticket di esempio
  - 1k users con roles
  - Dati georeferenziati realistici

- [ ] Query performance audit (8h)
  - Laravel Debugbar
  - Slow query log analysis
  - N+1 detection

**Acceptance Criteria**:
- Nessuna query > 100ms
- Database index hit rate > 95%
- Seeder genera dataset realistico

---

#### Epic 1.4: Code Quality & Documentation (80h)

**Tasks**:
- [ ] Aggiornare tutti i docs/ dei moduli (32h)
  - README.md per ogni modulo
  - API documentation
  - Architecture diagrams

- [ ] Code review completo (24h)
  - Refactor business logic fuori da Blade
  - Azioni dedicate per use cases
  - Observer pattern per side effects

- [ ] Setup monitoring tools (16h)
  - Laravel Telescope (development)
  - Sentry (error tracking)
  - New Relic / Scout APM (production)

- [ ] Security audit (8h)
  - OWASP Top 10 check
  - Dependency audit (`composer audit`)
  - SQL injection prevention verify

**Acceptance Criteria**:
- Tutta la documentazione aggiornata
- Zero code smells critici
- Monitoring attivo

**Phase 1 Deliverables**:
- ✅ Performance target raggiunti
- ✅ Test coverage 85%+
- ✅ Production-ready database
- ✅ Documentazione completa
- ✅ CI/CD attivo
- ✅ Monitoring configurato

---

### Phase 2: Feature Expansion (Q1 2026)
**Timeline**: Gennaio - Marzo 2026
**Priority**: 🟡 HIGH
**Effort**: 480 ore (~3 mesi, 2 dev)

#### Epic 2.1: Citizen Dashboard (120h)

**User Story**: *"Come cittadino, voglio vedere tutte le mie segnalazioni in un'unica dashboard con filtri e statistiche"*

**Tasks**:
- [ ] Creare Folio page `/my-tickets` (40h)
  - Lista ticket personali
  - Filtri: status, categoria, data
  - Sorting: più recenti, priorità, ecc.

- [ ] Componente statistiche personali (24h)
  - Totale segnalazioni
  - Risolte vs aperte
  - Tempo medio risoluzione
  - Chart andamento mensile

- [ ] Mappa interattiva ticket (32h)
  - Leaflet.js integration
  - Cluster markers
  - Filter by status on map
  - Click ticket → detail

- [ ] Export personale (24h)
  - PDF report mensile
  - CSV export dati
  - Condivisione social

**Acceptance Criteria**:
- Dashboard accessibile da `/my-tickets`
- Responsive mobile-first
- Performance < 200ms load time

---

#### Epic 2.2: Multi-Channel Notifications (160h)

**User Story**: *"Come cittadino, voglio essere notificato via email/SMS quando cambia lo stato del mio ticket"*

**Tasks**:
- [ ] Email notification system (40h)
  - Template professionali (Blade Mailable)
  - Queue asincrona
  - Tracking aperture email

- [ ] SMS integration (48h)
  - Twilio setup
  - Fallback provider (Nexmo)
  - Cost optimization (solo urgenze)
  - Opt-in/opt-out mechanism

- [ ] Push notifications PWA (48h)
  - Service Worker
  - Web Push API
  - Notifiche browser desktop/mobile

- [ ] Notification preferences (24h)
  - User settings page
  - Channel selection per evento
  - Quiet hours configuration

**Acceptance Criteria**:
- Email delivery rate > 98%
- SMS delivery < 5 secondi
- Push notifications funzionanti

---

#### Epic 2.3: Auto-Assignment System (120h)

**User Story**: *"Come amministratore, voglio che i ticket vengano assegnati automaticamente agli operatori in base alla zona geografica"*

**Tasks**:
- [ ] Zone geografiche management (48h)
  - Model: Zone (polygon geometry)
  - Filament Resource per creare zone
  - Mappa interattiva per disegnare zone
  - Assign operatori a zone

- [ ] Auto-assignment logic (40h)
  - Job: AutoAssignTicketJob
  - Spatial query: ticket coordinate in zone polygon
  - Load balancing operatori
  - Fallback se nessun operatore disponibile

- [ ] Assignment rules engine (32h)
  - Regole customizzabili:
    - By categoria (buche → squadra strade)
    - By priorità (urgente → senior operator)
    - By workload (distribuisci equamente)
    - By disponibilità (turni)

**Acceptance Criteria**:
- 90%+ ticket auto-assigned correttamente
- Tempo assignment < 30 secondi
- Bilanciamento carico operatori

---

#### Epic 2.4: SLA & Escalation (80h)

**User Story**: *"Come supervisor, voglio che i ticket non risolti entro SLA vengano automaticamente escalated"*

**Tasks**:
- [ ] SLA configuration (16h)
  - Per categoria/priorità
  - Database: sla_hours field
  - Admin UI configuration

- [ ] Escalation engine (32h)
  - Command: EscalateOverdueTicketsCommand
  - Scheduled: ogni ora
  - Logic: overdue → increase priority → notify supervisor

- [ ] SLA dashboard (24h)
  - Widget Filament: tickets a rischio SLA
  - Chart: SLA compliance %
  - Alerts se SLA < 80%

- [ ] Notifications escalation (8h)
  - Email supervisor
  - SMS se critical
  - Slack integration (webhook)

**Acceptance Criteria**:
- SLA compliance ≥ 85%
- Zero ticket dimenticati
- Escalation automatica funzionante

**Phase 2 Deliverables**:
- ✅ Dashboard cittadino live
- ✅ Notifiche multi-canale attive
- ✅ Auto-assignment funzionante
- ✅ SLA enforcement attivo

---

### Phase 3: API & Integrations (Q2 2026)
**Timeline**: Aprile - Giugno 2026
**Priority**: 🟢 MEDIUM
**Effort**: 400 ore (~3 mesi, 2 dev)

#### Epic 3.1: Public REST API (160h)

**User Story**: *"Come sviluppatore terzo, voglio accedere ai dati pubblici dei ticket via API REST"*

**Tasks**:
- [ ] API scaffolding (24h)
  ```php
  routes/api/v1.php
  app/Http/Controllers/Api/V1/
    TicketController
    CategoryController
    ZoneController
  ```

- [ ] API Resources (32h)
  - TicketResource (JSON transformation)
  - Pagination standard
  - Filtering & sorting
  - Include relations (owner, media)

- [ ] Authentication (32h)
  - Laravel Sanctum
  - API tokens gestione
  - Rate limiting (60 req/min)
  - Throttling per tier (free/pro)

- [ ] Endpoints implementation (48h)
  ```
  GET    /api/v1/tickets
  GET    /api/v1/tickets/{id}
  POST   /api/v1/tickets
  GET    /api/v1/tickets/nearby?lat=&lng=&radius=
  GET    /api/v1/categories
  GET    /api/v1/statistics/public
  ```

- [ ] API documentation (24h)
  - OpenAPI 3.0 spec
  - Swagger UI (`/api/documentation`)
  - Code examples (curl, JS, Python)

**Acceptance Criteria**:
- API RESTful completa
- Documentazione Swagger live
- Rate limiting funzionante

---

#### Epic 3.2: Analytics Dashboard (120h)

**User Story**: *"Come amministratore, voglio visualizzare metriche e trend su dashboard interattiva"*

**Tasks**:
- [ ] Filament Widgets creation (64h)
  - Ticket per status (pie chart)
  - Ticket per categoria (bar chart)
  - Trend mensile (line chart)
  - Heatmap geografica
  - Top segnalatori
  - Tempo medio risoluzione
  - Operator performance leaderboard

- [ ] Data aggregation service (32h)
  - Scheduled job: AggregateStatisticsJob
  - Cache risultati (refresh ogni 15min)
  - Historical data storage

- [ ] Export functionality (16h)
  - PDF reports
  - Excel export
  - Email scheduled reports

- [ ] Real-time updates (8h)
  - Livewire polling
  - Charts auto-refresh

**Acceptance Criteria**:
- Dashboard responsive <2 sec load
- Dati real-time (max 15min lag)
- Export funzionanti

---

#### Epic 3.3: External Integrations (120h)

**Tasks**:
- [ ] Google Maps integration (32h)
  - Replace OSM nominatim
  - Geocoding API
  - Places autocomplete
  - Satellite imagery

- [ ] Slack integration (24h)
  - Webhook su nuovo ticket
  - Notifiche cambi stato
  - Commands da Slack (`/ticket status 123`)

- [ ] Zapier/Make integration (24h)
  - Webhook triggers
  - Actions disponibili
  - Use cases documentation

- [ ] Telegram Bot (40h)
  - Bot per segnalazioni
  - Notifiche via Telegram
  - Tracking comandi

**Acceptance Criteria**:
- 3+ integrazioni funzionanti
- Documentazione completa
- Zero downtime su failures

**Phase 3 Deliverables**:
- ✅ API REST pubblica documentata
- ✅ Analytics dashboard live
- ✅ Integrazioni terze attive

---

### Phase 4: Mobile & UX (Q3 2026)
**Timeline**: Luglio - Settembre 2026
**Priority**: 🔵 MEDIUM-LOW
**Effort**: 560 ore (~4 mesi, 2 dev)

#### Epic 4.1: Progressive Web App (240h)

**Tasks**:
- [ ] Service Worker implementation (64h)
  - Offline support
  - Cache strategies
  - Background sync

- [ ] Web App Manifest (16h)
  - App icons
  - Theme colors
  - Install prompt

- [ ] Push Notifications (48h)
  - OneSignal integration
  - Notification preferences
  - Rich notifications

- [ ] Offline mode (64h)
  - Local storage
  - Sync queue
  - Conflict resolution

- [ ] Mobile UI optimization (48h)
  - Touch gestures
  - Bottom navigation
  - Camera integration nativa

**Acceptance Criteria**:
- Installabile su iOS/Android
- Funziona offline basic
- Lighthouse PWA score > 90

---

#### Epic 4.2: Multilingual Support (160h)

**Tasks**:
- [ ] i18n infrastructure (40h)
  - Laravel lang files
  - Lang module integration
  - Locale detection

- [ ] Translations (80h)
  - Italiano (completo)
  - Inglese (completo)
  - Tedesco (base)
  - Auto-translate con DeepL API

- [ ] UI language switcher (24h)
  - Header component
  - Cookie persistence
  - URL prefix (`/it/`, `/en/`)

- [ ] Content translation (16h)
  - Categories
  - Email templates
  - Static pages

**Acceptance Criteria**:
- 3 lingue supportate
- Switch seamless
- SEO multilingua

---

#### Epic 4.3: Advanced UX Features (160h)

**Tasks**:
- [ ] Voting system (48h)
  - Upvote tickets
  - Trending tickets
  - Community prioritization

- [ ] Interactive maps (48h)
  - Heatmap pubblico
  - Filter categories on map
  - Cluster view

- [ ] Citizen engagement (40h)
  - Commenti pubblici
  - Share social
  - Follow ticket (get updates)

- [ ] Gamification (24h)
  - Badges per segnalatori top
  - Leaderboard
  - Achievement system

**Acceptance Criteria**:
- Engagement rate +40%
- Time on site +60%
- Citizen satisfaction 4.5/5

**Phase 4 Deliverables**:
- ✅ PWA installabile
- ✅ Multilingua IT/EN/DE
- ✅ Advanced UX features

---

### Phase 5: AI & Innovation (Q4 2026)
**Timeline**: Ottobre - Dicembre 2026
**Priority**: 🟣 INNOVATION
**Effort**: 400 ore (~3 mesi, 2 dev + 1 ML engineer)

#### Epic 5.1: AI Auto-Categorization (160h)

**Tasks**:
- [ ] Training dataset preparation (40h)
  - Export 10k tickets labeled
  - Data cleaning
  - Feature engineering

- [ ] ML model training (64h)
  - NLP pipeline (BERT/GPT)
  - Classification model
  - Evaluation metrics

- [ ] Integration Laravel (32h)
  - OpenAI API / local model
  - Prediction on ticket create
  - Confidence score
  - Human review se confidence < 80%

- [ ] Continuous learning (24h)
  - Feedback loop
  - Retrain monthly
  - A/B testing

**Acceptance Criteria**:
- Accuracy ≥ 85%
- Latency < 500ms
- Cost < €0.01/prediction

---

#### Epic 5.2: Duplicate Detection (120h)

**Tasks**:
- [ ] Similarity algorithm (48h)
  - Text embeddings
  - Geospatial proximity
  - Temporal proximity
  - Combined score

- [ ] Duplicate suggestion UI (40h)
  - Durante creazione ticket
  - "Ticket simili esistenti"
  - Merge capability

- [ ] Auto-merge logic (32h)
  - Confidence threshold
  - Aggregate data
  - Notify owners

**Acceptance Criteria**:
- Duplicate reduction -60%
- False positives < 5%

---

#### Epic 5.3: Predictive Maintenance (120h)

**Tasks**:
- [ ] Historical data analysis (40h)
  - Pattern detection
  - Seasonal trends
  - Hotspot identification

- [ ] Prediction model (48h)
  - Time series forecasting
  - Risk scoring
  - Alert triggers

- [ ] Proactive alerts (32h)
  - Admin dashboard
  - Preventive maintenance suggestions
  - Resource allocation optimization

**Acceptance Criteria**:
- Predict 70%+ problemi ricorrenti
- ROI +30% su manutenzione

**Phase 5 Deliverables**:
- ✅ AI auto-categorization live
- ✅ Duplicate detection attivo
- ✅ Predictive maintenance beta

---

## 📈 Success Metrics

### Technical Metrics

| Metric | Current | Target Q1 26 | Target Q4 26 |
|--------|---------|--------------|--------------|
| Test Coverage | 40% | 85% | 90% |
| TTFB | 780ms | <200ms | <100ms |
| Query Count/Page | 87 | <10 | <5 |
| Error Rate | 1.2% | <0.5% | <0.1% |
| Uptime | 95% | 99% | 99.9% |

### Business Metrics

| Metric | Target Q1 26 | Target Q4 26 |
|--------|--------------|--------------|
| Active Users | 5,000 | 50,000 |
| Tickets/Month | 1,000 | 20,000 |
| Resolution Time Avg | 14 days | 7 days |
| Citizen Satisfaction | 3.8/5 | 4.5/5 |
| Operator Efficiency | +30% | +80% |

---

## 💰 Budget Allocation

**Total 18 months**: €250,000

| Phase | Duration | Team | Cost |
|-------|----------|------|------|
| Phase 1 (Q4 25) | 2 months | 2 dev | €40k |
| Phase 2 (Q1 26) | 3 months | 2 dev | €60k |
| Phase 3 (Q2 26) | 3 months | 2 dev | €60k |
| Phase 4 (Q3 26) | 4 months | 2 dev | €50k |
| Phase 5 (Q4 26) | 3 months | 2 dev + 1 ML | €40k |

**Infrastructure**: €20k/year (servers, CDN, APIs)

---

## 🎯 Key Milestones

- **Oct 2025**: ✅ PHPStan 0 errors, docs updated
- **Dec 2025**: 🎯 Phase 1 complete → Production ready
- **Mar 2026**: 🎯 Phase 2 complete → Feature-rich v1.0
- **Jun 2026**: 🎯 Phase 3 complete → API & analytics live
- **Sep 2026**: 🎯 Phase 4 complete → PWA mobile experience
- **Dec 2026**: 🎯 Phase 5 complete → AI-powered platform

---

## 🚨 Risks & Mitigations

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|------------|
| API rate limits (OSM/Google) | High | Medium | Cache aggressivo, fallback providers |
| Scalability issues | Medium | High | Load testing, auto-scaling infra |
| Data privacy compliance | Medium | Critical | GDPR audit, legal review |
| Budget overrun | Low | High | Agile sprints, MVP first |
| Team turnover | Medium | High | Documentazione, code review |

---

## 📝 Next Actions (Immediate)

### Week 1-2 (NOW - October 2025)
- [ ] Team kickoff meeting
- [ ] Setup project management (Jira/Linear)
- [ ] Create detailed Phase 1 tickets
- [ ] Assign responsibilities

### Week 3-4
- [ ] Start Epic 1.1 (Query Optimization)
- [ ] Parallel: Epic 1.4 (Documentation)
- [ ] Weekly progress review

---

**Roadmap Version**: 1.0
**Owner**: Development Team Lead
