# Xot - Sprint Planning Meeting

> Documento operativo per sprint planning. Modulo Core Framework.
> Preparazione stimata: 78%.

## Obiettivo Sprint

### Sprint 8: 2026-03-17 to 2026-03-30

**Sprint Goal:** Completare PHPStan Level 10 compliance e aumentare test coverage all'80% per il lancio di Xot v2.0.

### Sprint Theme

**"Quality Gates"** - Tutto il lavoro necessario per raggiungere gli standard di qualita' per il lancio

### Success Criteria

- ✅ PHPStan analyse restituisce 0 errors
- ✅ Test coverage sale dal 78% all'80%
- ✅ Documentazione classi sale al 90%
- ✅ Zero regressioni introdotte
- ✅ Performance <50ms boot time

### Confidence Level

| Team Member | Confidence (1-5) | Notes |
|-------------|------------------|-------|
| Tech Lead | 5 | PHPStan quasi completo |
| Senior Dev 1 | 4 | Test coverage richiede tempo |
| Senior Dev 2 | 5 | Focus totale su quality |
| QA Engineer | 4 | Coverage misurabile |
| Product Owner | 4 | Dipende da bug fixes |

**Average Confidence:** 4.4/5 - **High confidence**

---

## Input Richiesti

### Documenti di Riferimento

| Documento | Link | Stato | Last Updated |
|-----------|------|-------|--------------|
| PRD | prd.md | ✅ Approved | 2026-02-28 |
| Product Roadmap | product-roadmap.md | ✅ Active | 2026-03-10 |
| Product Strategy | product-strategy.md | ✅ Approved | 2026-03-13 |
| User Research | user-research.md | ✅ Complete | 2026-03-13 |
| Sprint 7 Review | /sprints/7/review.md | ✅ Complete | 2026-03-14 |

### Backlog Items

| Priority | Item | Story Points | Status |
|----------|------|--------------|--------|
| P0 | PHPStan remaining errors | 5 | ✅ Ready |
| P0 | Test coverage gap closure | 8 | ✅ Ready |
| P0 | Documentation sprint | 5 | ✅ Ready |
| P1 | Performance optimization | 3 | ✅ Ready |
| P1 | Module adoption audit | 3 | 🟡 Needs Refinement |
| P2 | CLI generator planning | 2 | ✅ Ready |

### Capacity Planning

| Team Member | Availability (%) | Days Available | Notes |
|-------------|------------------|----------------|-------|
| Tech Lead | 100% | 10 | Full sprint |
| Senior Dev 1 | 100% | 10 | Full sprint |
| Senior Dev 2 | 100% | 10 | Full sprint |
| QA Engineer | 100% | 10 | Full sprint |
| Product Owner | 50% | 5 | Support role |

**Total Team Capacity:** 42 story points (based on velocity of 38 + buffer)

---

## Proposta Agenda

### Sprint Planning Meeting

**Date:** 2026-03-17
**Time:** 09:00 - 11:00
**Location:** Meeting Room A / Google Meet
**Facilitator:** Tech Lead (Scrum Master)
**Note Taker:** Product Owner

### Agenda Items

| Time | Activity | Owner | Output |
|------|----------|-------|--------|
| 09:00-09:15 | Sprint Goal Review | Product Owner | Agreed sprint goal |
| 09:15-09:30 | Backlog Walkthrough | Tech Lead | Prioritized backlog |
| 09:30-09:45 | Capacity Review | Scrum Master | Team capacity confirmed |
| 09:45-10:15 | Story Estimation | Team | Estimated stories |
| 10:15-10:45 | Task Breakdown | Team | Task assignments |
| 10:45-11:00 | Commitment | Team | Sprint backlog finalized |

### Pre-Meeting Preparation

- [x] Product Owner: Prioritize backlog (Done 2026-03-16)
- [x] Team: Review backlog items (Done 2026-03-16)
- [x] Scrum Master: Prepare capacity planning (Done 2026-03-16)
- [ ] All: Review Sprint 7 retrospective (Due 2026-03-17 09:00)

---

## Candidate Stories

### Sprint Backlog

| Story ID | Story | Story Points | Priority | Assignee | Status |
|----------|-------|--------------|----------|----------|--------|
| XOT-245 | PHPStan remaining errors fix | 5 | P0 | Senior Dev 1 | To Do |
| XOT-246 | Test coverage to 80% | 8 | P0 | QA Engineer | To Do |
| XOT-247 | Documentation sprint | 5 | P0 | Senior Dev 2 | To Do |
| XOT-248 | Performance optimization | 3 | P1 | Tech Lead | To Do |
| XOT-249 | Module adoption audit | 3 | P1 | Product Owner | To Do |
| XOT-250 | CLI generator planning | 2 | P2 | All | To Do |

**Total Committed:** 26 story points (within 42 capacity)

### Story Details

#### Story XOT-245: PHPStan remaining errors fix

**User Story:**
> Come Tech Lead, voglio zero errori PHPStan, cosi' possiamo rilasciare v2.0 con type safety garantita.

**Acceptance Criteria:**
- [ ] `phpstan analyse Modules/Xot` restituisce 0 errors
- [ ] Zero ignore usate
- [ ] Tutti i type correttamente dichiarati
- [ ] CI pipeline passa senza warnings

**Tasks:**
- [ ] Analizzare errori rimanenti - 1h - Tech Lead
- [ ] Fix type errors - 4h - Senior Dev 1
- [ ] Fix generics/traits - 3h - Senior Dev 1
- [ ] Verify CI pipeline - 1h - QA Engineer

**Definition of Done:**
- PHPStan analyse passa con 0 errors
- CI pipeline verde
- Zero regressioni type-related

#### Story XOT-246: Test coverage to 80%

**User Story:**
> Come QA Engineer, voglio test coverage 80%, cosi' possiamo rilasciare con confidenza.

**Acceptance Criteria:**
- [ ] Coverage Models: 80%+
- [ ] Coverage Resources: 85%+
- [ ] Coverage Services: 75%+
- [ ] Coverage Actions: 80%+
- [ ] Zero test flaky

**Tasks:**
- [ ] Analisi coverage attuale - 2h - QA Engineer
- [ ] Identificare gap critici - 2h - QA Engineer
- [ ] Scrivere test mancanti - 12h - All
- [ ] Review e cleanup - 2h - Tech Lead

**Definition of Done:**
- Coverage report mostra 80%+
- Tutti i test verdi
- Zero test flaky
- Report condiviso

#### Story XOT-247: Documentation sprint

**User Story:**
> Come Developer, voglio documentazione completa, cosi' posso usare Xot senza perdere tempo.

**Acceptance Criteria:**
- [ ] 90% classi documentate
- [ ] PHPDoc completo per tutti i metodi pubblici
- [ ] Examples per casi d'uso principali
- [ ] README aggiornato

**Tasks:**
- [ ] Audit documentazione attuale - 2h - Senior Dev 2
- [ ] Scrivere PHPDoc mancante - 6h - Senior Dev 2
- [ ] Creare examples - 4h - Senior Dev 2
- [ ] Update README - 2h - Product Owner

**Definition of Done:**
- Documentation coverage 90%+
- PHPDoc completo
- Examples pubblicati
- README aggiornato

### Technical Debt Items

| Item | Description | Priority | Effort | Sprint |
|------|-------------|----------|--------|--------|
| Refactor obsolete classes | Rimuovere classi non usate | P2 | 8h | Sprint 9 |
| Update dependencies | Spatie packages | P2 | 4h | Sprint 10 |
| Performance profiling | Identify hot paths | P2 | 6h | Sprint 9 |

### Bug Fixes

| Bug ID | Description | Severity | Effort | Assignee |
|--------|-------------|----------|--------|----------|
| BUG-156 | Type mismatch in trait | High | 2h | Senior Dev 1 |
| BUG-157 | Missing return type | Medium | 1h | Senior Dev 1 |
| BUG-158 | Test flaky su CI | Medium | 2h | QA Engineer |

---

## Definizione di Done

### Team DoD

- [x] Code reviewed and approved (2 approvals required)
- [ ] All tests passing (unit, integration)
- [ ] Test coverage meets threshold (80%)
- [ ] PHPDoc completo
- [ ] Code merged to main branch
- [ ] Deployed to staging
- [ ] Product Owner acceptance

### Quality Gates

| Gate | Criteria | Tool | Threshold | Status |
|------|----------|------|-----------|--------|
| Code Quality | PHPStan Level | PHPStan | Level 10, 0 errors | 🟡 In Progress |
| Code Style | PSR-12 | PHP CS Fixer | 100% | ✅ |
| Test Coverage | Coverage % | PHPUnit/Pest | >80% | 🟡 78% |
| Security | Security issues | Security scan | 0 critical | ✅ |
| Performance | Boot time | Debugbar | <50ms | ✅ 45ms |

### Documentation Requirements

- [ ] PHPDoc for all public methods
- [ ] README aggiornato
- [ ] Examples per feature principali
- [ ] Changelog aggiornato

---

## Retro da Pianificare

### Sprint 7 Retrospective

**Sprint:** 7
**Date:** 2026-03-14

### What Went Well

| Item | Category | Action | Owner | Status |
|------|----------|--------|-------|--------|
| PHPStan progress | Quality | Continue focus | All | Done |
| Collaboration | Teamwork | Daily syncs working | All | Done |
| Test improvements | Quality | Coverage +5% | QA | Done |

### What Didn't Go Well

| Item | Category | Action | Owner | Status |
|------|----------|--------|-------|--------|
| Documentation lag | Documentation | Dedicate sprint time | All | In Progress |
| Test coverage slow | Quality | More focused effort | QA | In Progress |
| Some bugs discovered late | Testing | Earlier testing | QA | In Progress |

### Action Items from Sprint 7

| Action | Owner | Due Date | Status | Notes |
|--------|-------|----------|--------|-------|
| Documentation sprint | Senior Dev 2 | 2026-03-30 | To Do | This sprint |
| Coverage focus | QA Engineer | 2026-03-30 | To Do | This sprint |
| PHPStan push | Tech Lead | 2026-03-25 | In Progress | Almost done |

### Improvements for This Sprint

| Improvement | Description | Owner | Success Metric |
|-------------|-------------|-------|----------------|
| Daily coverage check | Monitor coverage daily | QA Lead | 80% by sprint end |
| Docs with code | Update docs before merge | All | 90% coverage |
| Early PHPStan | Run PHPStan locally first | All | Zero CI failures |

---

## Rischi e Dipendenze

### Risks

| Risk | Probability | Impact | Mitigation | Owner |
|------|-------------|--------|------------|-------|
| PHPStan errors piu' del previsto | Low | High | Timebox, escalate if needed | Tech Lead |
| Test coverage target too ambitious | Medium | Medium | Prioritize critical paths | QA Engineer |
| Documentation takes longer | Medium | Low | Focus on public APIs first | Senior Dev 2 |

### Dependencies

| Dependency | Type | Owner | Due Date | Status |
|------------|------|-------|----------|--------|
| Module teams availability | Internal | Product Owner | 2026-03-25 | ✅ On Track |
| CI/CD pipeline | Internal | DevOps | 2026-03-17 | ✅ On Track |
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
| Sprint 5 | 35 | 33 | 33 |
| Sprint 6 | 38 | 38 | 38 |
| Sprint 7 | 40 | 38 | 38 |
| **Sprint 8** | **26** | **TBD** | **TBD** |

**Average Velocity:** 36 points

### Sprint Health

| Metric | Target | Current | Status |
|--------|--------|---------|--------|
| Scope Change | <10% | 0% | ✅ |
| Blocker Resolution | <2 days | 0 days | ✅ |
| Team Morale | >4/5 | 4.4/5 | ✅ |
| Quality Gate Pass | 100% | 60% | 🟡 |

---

## Collegamenti

### Documenti Correlati

| Documento | Link | Stato |
|-----------|------|-------|
| PRD | prd.md | ✅ Approved |
| Product Roadmap | product-roadmap.md | ✅ Active |
| Product Strategy | product-strategy.md | ✅ Approved |
| User Research | user-research.md | ✅ Complete |
| Product Launch Plan | product-launch-plan.md | ✅ Draft |

### Sprint Artifacts

- [Sprint Board](https://jira.example.com/sprint/8)
- [Burndown Chart](https://jira.example.com/sprint/8/burndown)
- [Sprint 7 Review Notes](/sprints/7/review.md)

---

## Sprint Review

**Date:** 2026-03-28
**Time:** 14:00 - 15:30
**Location:** Meeting Room A / Google Meet

### Demo Agenda

| Story | Demo Owner | Duration |
|-------|------------|----------|
| XOT-245: PHPStan compliance | Tech Lead | 10 min |
| XOT-246: Test coverage | QA Engineer | 10 min |
| XOT-247: Documentation | Senior Dev 2 | 10 min |
| XOT-248: Performance | Tech Lead | 5 min |

### Stakeholders to Invite

- Product Owner - Xot Team
- Tech Lead - Architecture
- Module Team Reps - End Users
- QA Lead - Quality

---

## Revision History

| Version | Date | Author | Changes | Review Status |
|---------|------|--------|---------|---------------|
| 1.0 | 2026-03-17 | Xot Team | Initial sprint plan | Draft |

---

*Template basato su Notion Sprint Planning Templates - 61+ templates available*
*Ultimo aggiornamento: 2026-03-17*
