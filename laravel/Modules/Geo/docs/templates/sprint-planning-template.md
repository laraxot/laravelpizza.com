# Sprint Planning Meeting Template

> **Template Standardizzato** - Basato su [Notion Sprint Planning Templates](https://www.notion.com/templates/category/sprint-planning)
> 
> **Sprint:** {Sprint Number}
> **Prodotto:** {Module/Theme Name}
> **Sprint Duration:** {X} weeks
> **Start Date:** {YYYY-MM-DD}
> **End Date:** {YYYY-MM-DD}
> **Scrum Master:** {Name}
> **Product Owner:** {Name}

---

## Obiettivo Sprint

### Sprint Goal

{Clear, concise statement of what the team aims to achieve in this sprint}

### Sprint Theme

{Optional: Theme or focus area for this sprint}

### Success Criteria

- ✅ {Success criterion 1}
- ✅ {Success criterion 2}
- ✅ {Success criterion 3}
- ✅ {Success criterion 4}
- ✅ {Success criterion 5}

### Confidence Level

| Team Member | Confidence (1-5) | Notes |
|-------------|------------------|-------|
| {Name 1} | {1-5} | {Notes} |
| {Name 2} | {Rating} | {Notes} |
| {Name 3} | {Rating} | {Notes} |
| {Name 4} | {Rating} | {Notes} |
| {Name 5} | {Rating} | {Notes} |

---

## Input Richiesti

### Documenti di Riferimento

| Documento | Link | Stato | Last Updated |
|-----------|------|-------|--------------|
| PRD | {Link} | {Status} | {Date} |
| Product Roadmap | {Link} | {Status} | {Date} |
| Product Strategy | {Link} | {Status} | {Date} |
| User Research | {Link} | {Status} | {Date} |
| Previous Sprint Review | {Link} | {Status} | {Date} |

### Backlog Items

| Priority | Item | Story Points | Status |
|----------|------|--------------|--------|
| P0 | {Item 1} | {Points} | {Ready\|Needs Refinement} |
| P0 | {Item 2} | {Points} | {Status} |
| P1 | {Item 3} | {Points} | {Status} |
| P1 | {Item 4} | {Points} | {Status} |
| P2 | {Item 5} | {Points} | {Status} |

### Capacity Planning

| Team Member | Availability (%) | Days Available | Notes |
|-------------|------------------|----------------|-------|
| {Name 1} | {XX}% | {Days} | {PTO, holidays, etc.} |
| {Name 2} | {XX}% | {Days} | {Notes} |
| {Name 3} | {XX}% | {Days} | {Notes} |
| {Name 4} | {XX}% | {Days} | {Notes} |
| {Name 5} | {XX}% | {Days} | {Notes} |

**Total Team Capacity:** {XX} story points

---

## Proposta Agenda

### Sprint Planning Meeting

**Date:** {YYYY-MM-DD}
**Time:** {HH:MM - HH:MM}
**Location:** {Meeting Room/Video Link}
**Facilitator:** {Name}
**Note Taker:** {Name}

### Agenda Items

| Time | Activity | Owner | Output |
|------|----------|-------|--------|
| {HH:MM} | Sprint Goal Review | Product Owner | Agreed sprint goal |
| {HH:MM} | Backlog Walkthrough | Product Owner | Prioritized backlog |
| {HH:MM} | Capacity Review | Scrum Master | Team capacity |
| {HH:MM} | Story Estimation | Team | Estimated stories |
| {HH:MM} | Task Breakdown | Team | Task assignments |
| {HH:MM} | Commitment | Team | Sprint backlog |
| {HH:MM} | Q&A | All | Clarifications |

### Pre-Meeting Preparation

- [ ] Product Owner: Prioritize backlog
- [ ] Team: Review backlog items
- [ ] Scrum Master: Prepare capacity planning
- [ ] All: Review previous sprint retrospective actions

---

## Candidate Stories

### Sprint Backlog

| Story ID | Story | Story Points | Priority | Assignee | Status |
|----------|-------|--------------|----------|----------|--------|
| {ID 1} | {User story} | {Points} | P0 | {Name} | {To Do} |
| {ID 2} | {User story} | {Points} | P0 | {Name} | {To Do} |
| {ID 3} | {User story} | {Points} | P1 | {Name} | {To Do} |
| {ID 4} | {User story} | {Points} | P1 | {Name} | {To Do} |
| {ID 5} | {User story} | {Points} | P2 | {Name} | {To Do} |

### Story Details

#### Story {ID 1}: {Title}

**User Story:**
> As a {user type}, I want to {action}, so that {benefit}

**Acceptance Criteria:**
- [ ] {Criterion 1}
- [ ] {Criterion 2}
- [ ] {Criterion 3}
- [ ] {Criterion 4}
- [ ] {Criterion 5}

**Tasks:**
- [ ] {Task 1} - {Estimate}h - {Assignee}
- [ ] {Task 2} - {Estimate}h - {Assignee}
- [ ] {Task 3} - {Estimate}h - {Assignee}
- [ ] {Task 4} - {Estimate}h - {Assignee}

**Definition of Done:**
- {DoD criterion 1}
- {DoD criterion 2}
- {DoD criterion 3}

#### Story {ID 2}: {Title}

**User Story:**
> As a {user type}, I want to {action}, so that {benefit}

**Acceptance Criteria:**
- [ ] {Criterion 1}
- [ ] {Criterion 2}
- [ ] {Criterion 3}

**Tasks:**
- [ ] {Task 1} - {Estimate}h - {Assignee}
- [ ] {Task 2} - {Estimate}h - {Assignee}
- [ ] {Task 3} - {Estimate}h - {Assignee}

**Definition of Done:**
- {DoD criterion 1}
- {DoD criterion 2}
- {DoD criterion 3}

### Technical Debt Items

| Item | Description | Priority | Effort | Sprint |
|------|-------------|----------|--------|--------|
| {Debt 1} | {Description} | P1 | {Hours} | {Sprint #} |
| {Debt 2} | {Description} | P2 | {Hours} | {Sprint #} |
| {Debt 3} | {Description} | P2 | {Hours} | {Sprint #} |

### Bug Fixes

| Bug ID | Description | Severity | Effort | Assignee |
|--------|-------------|----------|--------|----------|
| {Bug 1} | {Description} | {Critical/High/Medium/Low} | {Hours} | {Name} |
| {Bug 2} | {Description} | {Severity} | {Effort} | {Assignee} |
| {Bug 3} | {Description} | {Severity} | {Effort} | {Assignee} |

---

## Definizione di Done

### Team DoD

- [ ] Code reviewed and approved
- [ ] All tests passing (unit, integration, e2e)
- [ ] Test coverage meets threshold ({XX}%)
- [ ] Documentation updated
- [ ] Code merged to main branch
- [ ] Deployed to staging environment
- [ ] Product Owner acceptance

### Quality Gates

| Gate | Criteria | Tool | Threshold |
|------|----------|------|-----------|
| Code Quality | PHPStan Level | PHPStan | Level {X} |
| Code Style | PSR-12 | PHP CS Fixer | 100% |
| Test Coverage | Coverage % | PHPUnit/Pest | > {XX}% |
| Security | Security issues | {Tool} | 0 critical |
| Performance | Performance score | {Tool} | > {XX} |

### Documentation Requirements

- [ ] Code comments for complex logic
- [ ] API documentation updated
- [ ] User documentation updated (if applicable)
- [ ] Changelog updated
- [ ] README updated (if applicable)

---

## Retro da Pianificare

### Previous Sprint Retrospective

**Sprint:** {Sprint Number}
**Date:** {YYYY-MM-DD}

### What Went Well

| Item | Category | Action | Owner | Status |
|------|----------|--------|-------|--------|
| {Positive 1} | {Category} | {Continue doing} | {Owner} | {Done} |
| {Positive 2} | {Category} | {Continue} | {Owner} | {Status} |
| {Positive 3} | {Category} | {Continue} | {Owner} | {Status} |

### What Didn't Go Well

| Item | Category | Action | Owner | Status |
|------|----------|--------|-------|--------|
| {Issue 1} | {Category} | {Improvement} | {Owner} | {In Progress} |
| {Issue 2} | {Category} | {Improvement} | {Owner} | {Status} |
| {Issue 3} | {Category} | {Improvement} | {Owner} | {Status} |

### Action Items from Previous Sprint

| Action | Owner | Due Date | Status | Notes |
|--------|-------|----------|--------|-------|
| {Action 1} | {Owner} | {Date} | {Done\|In Progress\|Blocked} | {Notes} |
| {Action 2} | {Owner} | {Date} | {Status} | {Notes} |
| {Action 3} | {Owner} | {Date} | {Status} | {Notes} |

### Improvements for This Sprint

| Improvement | Description | Owner | Success Metric |
|-------------|-------------|-------|----------------|
| {Improvement 1} | {Description} | {Owner} | {Metric} |
| {Improvement 2} | {Description} | {Owner} | {Metric} |
| {Improvement 3} | {Description} | {Owner} | {Metric} |

---

## Rischi e Dipendenze

### Risks

| Risk | Probability | Impact | Mitigation | Owner |
|------|-------------|--------|------------|-------|
| {Risk 1} | {High/Medium/Low} | {High/Medium/Low} | {Mitigation} | {Owner} |
| {Risk 2} | {Probability} | {Impact} | {Mitigation} | {Owner} |
| {Risk 3} | {Probability} | {Impact} | {Mitigation} | {Owner} |

### Dependencies

| Dependency | Type | Owner | Due Date | Status |
|------------|------|-------|----------|--------|
| {Dependency 1} | {Internal/External} | {Owner} | {Date} | {On Track\|At Risk\|Blocked} |
| {Dependency 2} | {Type} | {Owner} | {Date} | {Status} |
| {Dependency 3} | {Type} | {Owner} | {Date} | {Status} |

### Blockers

| Blocker | Impact | Resolution Plan | Owner | ETA |
|---------|--------|-----------------|-------|-----|
| {Blocker 1} | {Impact} | {Plan} | {Owner} | {Date} |
| {Blocker 2} | {Impact} | {Plan} | {Owner} | {ETA} |

---

## Sprint Metrics

### Velocity Tracking

| Sprint | Committed Points | Completed Points | Velocity |
|--------|------------------|------------------|----------|
| Sprint {N-3} | {Points} | {Points} | {Velocity} |
| Sprint {N-2} | {Points} | {Points} | {Velocity} |
| Sprint {N-1} | {Points} | {Points} | {Velocity} |
| **Sprint {N}** | **{Points}** | **{TBD}** | **{TBD}** |

### Burndown Chart

| Day | Planned | Actual | Ideal |
|-----|---------|--------|-------|
| Day 1 | {Points} | {Points} | {Points} |
| Day 2 | {Points} | {Points} | {Points} |
| Day 3 | {Points} | {Points} | {Points} |
| Day 4 | {Points} | {Points} | {Points} |
| Day 5 | {Points} | {Points} | {Points} |

### Sprint Health

| Metric | Target | Current | Status |
|--------|--------|---------|--------|
| Scope Change | < 10% | {XX}% | {✅/❌} |
| Blocker Resolution | < 2 days | {X} days | {Status} |
| Team Morale | > 4/5 | {Rating} | {Status} |
| Quality Gate Pass | 100% | {XX}% | {Status} |

---

## Daily Standup Schedule

### Standup Times

| Day | Time | Location | Facilitator |
|-----|------|----------|-------------|
| Day 1 | {HH:MM} | {Location} | {Name} |
| Day 2 | {HH:MM} | {Location} | {Name} |
| Day 3 | {HH:MM} | {Location} | {Name} |
| Day 4 | {HH:MM} | {Location} | {Name} |
| Day 5 | {HH:MM} | {Location} | {Name} |

### Standup Format

Each team member answers:
1. What did I do yesterday?
2. What will I do today?
3. Any blockers?

---

## Collegamenti

### Documenti Correlati

| Documento | Link | Stato |
|-----------|------|-------|
| PRD | {Link} | {Status} |
| Product Roadmap | {Link} | {Status} |
| Product Strategy | {Link} | {Status} |
| User Research | {Link} | {Status} |
| Product Launch Plan | {Link} | {Status} |

### Sprint Artifacts

- [Sprint Board]({Link})
- [Burndown Chart]({Link})
- [Sprint Review Notes]({Link})

---

## Sprint Review

**Date:** {YYYY-MM-DD}
**Time:** {HH:MM}
**Location:** {Location}

### Demo Agenda

| Story | Demo Owner | Duration |
|-------|------------|----------|
| {Story 1} | {Name} | {X} min |
| {Story 2} | {Name} | {X} min |
| {Story 3} | {Name} | {X} min |

### Stakeholders to Invite

- {Stakeholder 1} - {Role}
- {Stakeholder 2} - {Role}
- {Stakeholder 3} - {Role}

---

## Revision History

| Version | Date | Author | Changes | Review Status |
|---------|------|--------|---------|---------------|
| 1.0 | {YYYY-MM-DD} | {Name} | Initial sprint plan | {Draft\|Reviewed\|Approved} |
| {1.1} | {YYYY-MM-DD} | {Name} | {Changes} | {Status} |

---

## Approvazioni

| Ruolo | Nome | Data | Firma |
|-------|------|------|-------|
| Product Owner | {Name} | {Date} | |
| Scrum Master | {Name} | {Date} | |
| Tech Lead | {Name} | {Date} | |

---

*Template basato su Notion Sprint Planning Templates - 61+ templates available*
*Ultimo aggiornamento: {YYYY-MM-DD}*
