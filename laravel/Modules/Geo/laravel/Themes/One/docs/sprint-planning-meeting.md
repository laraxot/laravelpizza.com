# One - Sprint Planning Meeting

> Documento operativo per sprint planning. Theme.
> Preparazione stimata: 75%.

## Obiettivo Sprint

### Sprint 5: 2026-03-17 to 2026-03-30

**Sprint Goal:** Completare le feature critiche per il lancio di One v2.0, con focus su test coverage, documentazione e bug fixes.

### Sprint Theme

**"Launch Readiness"** - Tutto il lavoro necessario per essere pronti al rilascio

### Success Criteria

- ✅ Test coverage sale dal 75% all'80%
- ✅ Tutti i bug P0 e P1 risolti
- ✅ Documentazione 100% aggiornata
- ✅ Performance score >90 su Lighthouse
- ✅ Zero regressioni introdotte

### Confidence Level

| Team Member | Confidence (1-5) | Notes |
|-------------|------------------|-------|
| Maria (PO) | 4 | Dipende da bug fixes |
| Giovanni (Tech Lead) | 5 | Team focalizzato |
| Anna (Dev) | 4 | Qualche incognita su PDF |
| Luca (Dev) | 5 | Feature complete |
| Marco (QA) | 4 | Tempo testing sufficiente |

**Average Confidence:** 4.4/5 - **High confidence**

---

## Input Richiesti

### Documenti di Riferimento

| Documento | Link | Stato | Last Updated |
|-----------|------|-------|--------------|
| PRD | prd.md | ✅ Approved | 2026-02-28 |
| Product Roadmap | roadmap.md | ✅ Active | 2026-03-10 |
| Product Strategy | product-strategy.md | ✅ Approved | 2026-03-13 |
| User Research | user-research.md | ✅ Complete | 2026-03-13 |
| Sprint 4 Review | /sprints/4/review.md | ✅ Complete | 2026-03-14 |

### Backlog Items

| Priority | Item | Story Points | Status |
|----------|------|--------------|--------|
| P0 | Fix PDF rendering Safari | 5 | ✅ Ready |
| P0 | Performance optimization dashboard | 8 | ✅ Ready |
| P0 | Test coverage increase | 5 | ✅ Ready |
| P1 | Documentation update | 3 | ✅ Ready |
| P1 | Bug fixes da UAT | 5 | 🟡 Needs Refinement |
| P2 | Template improvements | 3 | ✅ Ready |

### Capacity Planning

| Team Member | Availability (%) | Days Available | Notes |
|-------------|------------------|----------------|-------|
| Maria (PO) | 100% | 10 | Full sprint |
| Giovanni (Tech Lead) | 100% | 10 | Full sprint |
| Anna (Dev) | 80% | 8 | 2 giorni formazione |
| Luca (Dev) | 100% | 10 | Full sprint |
| Marco (QA) | 100% | 10 | Full sprint |

**Total Team Capacity:** 48 story points (based on velocity of 45 + buffer)

---

## Proposta Agenda

### Sprint Planning Meeting

**Date:** 2026-03-17
**Time:** 09:00 - 11:00
**Location:** Meeting Room A / Google Meet
**Facilitator:** Giovanni Bianchi (Scrum Master)
**Note Taker:** Maria Rossi

### Agenda Items

| Time | Activity | Owner | Output |
|------|----------|-------|--------|
| 09:00-09:15 | Sprint Goal Review | Maria | Agreed sprint goal |
| 09:15-09:30 | Backlog Walkthrough | Maria | Prioritized backlog |
| 09:30-09:45 | Capacity Review | Giovanni | Team capacity confirmed |
| 09:45-10:15 | Story Estimation | Team | Estimated stories |
| 10:15-10:45 | Task Breakdown | Team | Task assignments |
| 10:45-11:00 | Commitment | Team | Sprint backlog finalized |

### Pre-Meeting Preparation

- [x] Maria: Prioritize backlog (Done 2026-03-16)
- [x] Team: Review backlog items (Done 2026-03-16)
- [x] Giovanni: Prepare capacity planning (Done 2026-03-16)
- [ ] All: Review Sprint 4 retrospective (Due 2026-03-17 09:00)

---

## Candidate Stories

### Sprint Backlog

| Story ID | Story | Story Points | Priority | Assignee | Status |
|----------|-------|--------------|----------|----------|--------|
| ONE-145 | Fix PDF rendering su Safari | 5 | P0 | Anna | To Do |
| ONE-146 | Performance optimization dashboard | 8 | P0 | Luca | To Do |
| ONE-147 | Test coverage increase to 80% | 5 | P0 | Marco | To Do |
| ONE-148 | Documentation update per v2.0 | 3 | P1 | Maria | To Do |
| ONE-149 | Bug fixes da UAT session | 5 | P1 | Giovanni | To Do |
| ONE-150 | Template improvements | 3 | P2 | Anna | To Do |

**Total Committed:** 29 story points (within 48 capacity)

### Story Details

#### Story ONE-145: Fix PDF rendering su Safari

**User Story:**
> Come HR Manager, voglio che i report PDF siano formattati correttamente su Safari, cosi' posso usarlo come browser principale senza problemi.

**Acceptance Criteria:**
- [ ] Test su Safari 16+ passa
- [ ] Test su Safari 15+ passa
- [ ] Template "Standard" renderizza correttamente
- [ ] Template "Executive" renderizza correttamente
- [ ] Zero differenze visive vs Chrome

**Tasks:**
- [ ] Investigare root cause - 2h - Anna
- [ ] Implementare fix CSS - 3h - Anna
- [ ] Test cross-browser - 2h - Marco
- [ ] Update documentazione - 1h - Maria

**Definition of Done:**
- Codice reviewato e approvato
- Test automatici aggiunti
- Test manuali su Safari passati
- Documentazione aggiornata

#### Story ONE-146: Performance optimization dashboard

**User Story:**
> Come Performance Analyst, voglio che i dashboard con 1000+ record carichino in <2s, cosi' posso monitorare i dati senza attese.

**Acceptance Criteria:**
- [ ] Load time <2s con 1000 record
- [ ] Load time <3s con 5000 record
- [ ] Lighthouse performance score >90
- [ ] Zero regressioni su dataset piccoli

**Tasks:**
- [ ] Profiling query database - 3h - Luca
- [ ] Implementare lazy loading - 4h - Luca
- [ ] Ottimizzare rendering Chart.js - 4h - Luca
- [ ] Test performance - 3h - Marco

**Definition of Done:**
- Benchmark stabiliti e verificati
- Codice ottimizzato e reviewato
- Test performance automatizzati
- Documentazione aggiornata

#### Story ONE-147: Test coverage increase to 80%

**User Story:**
> Come Tech Lead, voglio test coverage >80%, cosi' possiamo rilasciare con confidenza.

**Acceptance Criteria:**
- [ ] Coverage Componenti: 80%+
- [ ] Coverage Services: 85%+
- [ ] Coverage Utils: 75%+
- [ ] Zero test flaky

**Tasks:**
- [ ] Analisi coverage attuale - 2h - Marco
- [ ] Identificare gap critici - 2h - Marco
- [ ] Scrivere test mancanti - 8h - All
- [ ] Review e cleanup - 2h - Giovanni

**Definition of Done:**
- Coverage report mostra 80%+
- Tutti i test verdi
- Zero test flaky
- Report condiviso

### Technical Debt Items

| Item | Description | Priority | Effort | Sprint |
|------|-------------|----------|--------|--------|
| Refactor PDF service | Semplificare logica complessa | P2 | 8h | Sprint 6 |
| Update dependencies | Chart.js, Alpine.js | P2 | 4h | Sprint 6 |
| Documentation cleanup | Rimuovere docs obsolete | P3 | 4h | Sprint 7 |

### Bug Fixes

| Bug ID | Description | Severity | Effort | Assignee |
|--------|-------------|----------|--------|----------|
| BUG-089 | PDF blank pages su Safari | Critical | 4h | Anna |
| BUG-090 | Chart tooltip cutoff | High | 2h | Luca |
| BUG-091 | Filter reset non funziona | Medium | 1h | Giovanni |
| BUG-092 | Loading spinner non si nasconde | Low | 1h | Luca |

---

## Definizione di Done

### Team DoD

- [x] Code reviewed and approved (2 approvals required)
- [ ] All tests passing (unit, integration, e2e)
- [ ] Test coverage meets threshold (80%)
- [ ] Documentation updated
- [ ] Code merged to main branch
- [ ] Deployed to staging environment
- [ ] Product Owner acceptance

### Quality Gates

| Gate | Criteria | Tool | Threshold | Status |
|------|----------|------|-----------|--------|
| Code Quality | PHPStan Level | PHPStan | Level 10 | ✅ |
| Code Style | PSR-12 | PHP CS Fixer | 100% | ✅ |
| Test Coverage | Coverage % | PHPUnit/Pest | >80% | 🟡 75% |
| Security | Security issues | {Tool} | 0 critical | ✅ |
| Performance | Performance score | Lighthouse | >90 | 🟡 85 |

### Documentation Requirements

- [ ] Code comments for complex logic
- [ ] API documentation updated
- [ ] User documentation updated (if applicable)
- [ ] Changelog updated
- [ ] README updated (if applicable)

---

## Retro da Pianificare

### Sprint 4 Retrospective

**Sprint:** 4
**Date:** 2026-03-14

### What Went Well

| Item | Category | Action | Owner | Status |
|------|----------|--------|-------|--------|
| Feature completion | Delivery | Continue pace | All | Done |
| Collaboration | Teamwork | Keep daily syncs | All | Done |
| Code quality | Technical | Maintain standards | Tech Lead | Done |

### What Didn't Go Well

| Item | Category | Action | Owner | Status |
|------|----------|--------|-------|--------|
| Test coverage gap | Quality | Dedicate sprint time | QA Lead | In Progress |
| Documentation lag | Documentation | Update during sprint | All | In Progress |
| Safari bugs discovered late | Testing | Earlier cross-browser tests | QA Lead | In Progress |

### Action Items from Sprint 4

| Action | Owner | Due Date | Status | Notes |
|--------|-------|----------|--------|-------|
| Add Safari to CI/CD | Giovanni | 2026-03-20 | In Progress | BrowserStack integration |
| Coverage threshold enforcement | Marco | 2026-03-17 | To Do | PHPUnit config update |
| Documentation checklist | Maria | 2026-03-17 | To Do | Add to DoD |

### Improvements for This Sprint

| Improvement | Description | Owner | Success Metric |
|-------------|-------------|-------|----------------|
| Earlier testing | Test cross-browser from day 1 | QA Lead | Zero late-discovered bugs |
| Docs first | Update docs before code merge | All | 100% docs complete with code |
| Daily coverage check | Monitor coverage daily | QA Lead | 80% by sprint end |

---

## Rischi e Dipendenze

### Risks

| Risk | Probability | Impact | Mitigation | Owner |
|------|-------------|--------|------------|-------|
| Safari fix piu' complesso del previsto | Medium | High | Timebox investigation, escalate if needed | Anna |
| Performance optimization insufficient | Medium | High | Have fallback plan (pagination) | Luca |
| Test coverage target too ambitious | Low | Medium | Prioritize critical paths | Marco |

### Dependencies

| Dependency | Type | Owner | Due Date | Status |
|------------|------|-------|----------|--------|
| BrowserStack access | External | Giovanni | 2026-03-17 | ✅ On Track |
| UAT feedback | Internal | Maria | 2026-03-19 | 🟡 At Risk |
| Staging environment | Internal | DevOps | 2026-03-17 | ✅ On Track |

### Blockers

| Blocker | Impact | Resolution Plan | Owner | ETA |
|---------|--------|-----------------|-------|-----|
| Nessuno al momento | - | - | - | - |

---

## Sprint Metrics

### Velocity Tracking

| Sprint | Committed Points | Completed Points | Velocity |
|--------|------------------|------------------|----------|
| Sprint 2 | 38 | 35 | 35 |
| Sprint 3 | 40 | 42 | 42 |
| Sprint 4 | 45 | 43 | 43 |
| **Sprint 5** | **29** | **TBD** | **TBD** |

**Average Velocity:** 40 points

### Burndown Chart

| Day | Planned | Actual | Ideal |
|-----|---------|--------|-------|
| Day 1 | 29 | TBD | 26.4 |
| Day 2 | 24 | TBD | 21.8 |
| Day 3 | 19 | TBD | 17.1 |
| Day 4 | 15 | TBD | 12.5 |
| Day 5 | 10 | TBD | 7.9 |
| Day 6 | 6 | TBD | 5.3 |
| Day 7 | 4 | TBD | 2.6 |
| Day 8 | 2 | TBD | 0 |

### Sprint Health

| Metric | Target | Current | Status |
|--------|--------|---------|--------|
| Scope Change | <10% | 0% | ✅ |
| Blocker Resolution | <2 days | 0 days | ✅ |
| Team Morale | >4/5 | 4.4/5 | ✅ |
| Quality Gate Pass | 100% | 60% | 🟡 |

---

## Daily Standup Schedule

### Standup Times

| Day | Time | Location | Facilitator |
|-----|------|----------|-------------|
| Day 1 (17/03) | 09:30 | Room A / Meet | Giovanni |
| Day 2 (18/03) | 09:30 | Room A / Meet | Giovanni |
| Day 3 (19/03) | 09:30 | Room A / Meet | Giovanni |
| Day 4 (20/03) | 09:30 | Room A / Meet | Giovanni |
| Day 5 (23/03) | 09:30 | Room A / Meet | Giovanni |
| Day 6 (24/03) | 09:30 | Room A / Meet | Giovanni |
| Day 7 (25/03) | 09:30 | Room A / Meet | Giovanni |
| Day 8 (26/03) | 09:30 | Room A / Meet | Giovanni |

### Standup Format

Ogni membro del team risponde:
1. Cosa ho fatto ieri?
2. Cosa faro' oggi?
3. Ho qualche blocco?

---

## Collegamenti

### Documenti Correlati

| Documento | Link | Stato |
|-----------|------|-------|
| PRD | prd.md | ✅ Approved |
| Product Roadmap | roadmap.md | ✅ Active |
| Product Strategy | product-strategy.md | ✅ Approved |
| User Research | user-research.md | ✅ Complete |
| Product Launch Plan | product-launch-plan.md | ✅ Draft |

### Sprint Artifacts

- [Sprint Board](https://jira.example.com/sprint/5)
- [Burndown Chart](https://jira.example.com/sprint/5/burndown)
- [Sprint 4 Review Notes](/sprints/4/review.md)

---

## Sprint Review

**Date:** 2026-03-28
**Time:** 14:00 - 15:30
**Location:** Meeting Room A / Google Meet

### Demo Agenda

| Story | Demo Owner | Duration |
|-------|------------|----------|
| ONE-145: Safari PDF fix | Anna | 10 min |
| ONE-146: Dashboard performance | Luca | 15 min |
| ONE-147: Test coverage | Marco | 10 min |
| ONE-148: Documentation | Maria | 5 min |
| ONE-149: Bug fixes | Giovanni | 10 min |

### Stakeholders to Invite

- Maria Rossi - Product Owner
- Giovanni Bianchi - Tech Lead
- HR Manager Representatives - End Users
- IT Director - Business Sponsor
- Support Team Lead - Operations

---

## Revision History

| Version | Date | Author | Changes | Review Status |
|---------|------|--------|---------|---------------|
| 1.0 | 2026-03-17 | Giovanni Bianchi | Initial sprint plan | Draft |

---

## Approvazioni

| Ruolo | Nome | Data | Firma |
|-------|------|------|-------|
| Product Owner | Maria Rossi | TBD | |
| Scrum Master | Giovanni Bianchi | TBD | |
| Tech Lead | Giovanni Bianchi | TBD | |

---

*Ultimo aggiornamento: 2026-03-17*
