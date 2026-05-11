# BMAD Workflow Guide for Laraxot

## Overview

This guide provides step-by-step instructions for using **BMAD (Business Model Agile Development)** with **Laraxot** projects (Laravel 12 + Filament 5 + PHP 8.3).

**Version**: 6.2.2  
**Last Updated**: March 27, 2026  
**Status**: ✅ Installed and configured

---

## 🎯 When to Use BMAD

### ✅ Use BMAD For:
- New feature development
- Module creation or extension
- Complex architectural decisions
- Sprint planning
- Product requirements definition
- UX design specifications
- Test strategy planning

### ❌ Don't Use BMAD For:
- Simple bug fixes (use `/gsd:quick` instead)
- Typos or documentation updates
- One-line changes
- Emergency hotfixes

---

## 📦 Installation Status

### Current Setup

**Location**: `/_bmad/`

```bash
# Verify installation
ls -la _bmad/
ls -la _bmad/_config/
```

**Installed Modules**:
- ✅ **Core** (v6.2.2) - Built-in
- ✅ **BMM** (v6.2.2) - BMAD Method Module

**Configuration**:
```yaml
# _bmad/_config/manifest.yaml
version: 6.2.2
installed: 2026-03-27
modules:
  - core
  - bmm
```

---

## 🧠 Complete BMAD Workflow

### Phase 1: Analysis (Pre-Sprint / Product Discovery)

**Goal**: Establish context and understand the problem space

**Duration**: 1-2 hours  
**Output**: Research documents, product brief

#### Step 1.1: Brainstorming (Optional)

```bash
/bmad-brainstorming
```

**Prompt Example**:
```
Brainstorm ideas for "DashboardV3 chart enhancements"

Focus on:
- User needs (survey administrators, data analysts)
- Technical feasibility (Laravel 12, Filament 5, JPGraph)
- Business value (ATS compliance, competitive advantage)
```

**Output**: `bmm/1-analysis/brainstorming-{topic}.md`

#### Step 1.2: Market Research (Optional)

```bash
/bmad-bmm-market-research
```

**Prompt Example**:
```
Research market for "Survey analytics dashboards"

Include:
- Competitor analysis (SurveyMonkey, Qualtrics, LimeSurvey)
- Market trends (ATS automation, AI insights)
- User expectations (real-time, customizable, exportable)
```

**Output**: `bmm/1-analysis/market-research-{topic}.md`

#### Step 1.3: Domain Research (Optional)

```bash
/bmad-bmm-domain-research
```

**Prompt Example**:
```
Research domain "Survey analytics and prediction markets"

Cover:
- Domain concepts (response rates, completion metrics, LMSR)
- Industry standards (ATS benchmarks, PDF exports)
- Regulatory requirements (GDPR, data privacy)
```

**Output**: `bmm/1-analysis/domain-research-{topic}.md`

#### Step 1.4: Technical Research (Optional)

```bash
/bmad-bmm-technical-research
```

**Prompt Example**:
```
Research technical approaches for "Custom chart questions in Laravel"

Explore:
- Chart libraries (JPGraph, Chart.js, ApexCharts)
- Performance optimization (caching, query optimization)
- Integration patterns (Actions, DTOs, Widgets)
```

**Output**: `bmm/1-analysis/technical-research-{topic}.md`

#### Step 1.5: Create Product Brief (Optional)

```bash
/bmad-bmm-create-product-brief
```

**Input**: Research documents from steps 1.2-1.4

**Output**: `bmm/1-analysis/product-brief-{topic}.md`

**Structure**:
```markdown
# Product Brief: {Topic}

## Problem Statement
What problem are we solving?

## Target Users
Who needs this?

## Business Value
Why is this important?

## Success Metrics
How will we measure success?

## Constraints
What are the limitations?
```

---

### Phase 2: Planning (Product Backlog Creation)

**Goal**: Define **what** to build

**Duration**: 2-4 hours  
**Output**: PRD, UX design

#### Step 2.1: Create PRD (REQUIRED)

```bash
/bmad-bmm-create-prd
```

**Prompt Example**:
```
Create PRD for "DashboardV3 Custom Charts"

Context:
- We have 9 custom questions to implement
- Must integrate with existing QuestionChart system
- Must support PDF export for ATS compliance
- Must achieve 80%+ test coverage

Requirements:
- Functional requirements (what it must do)
- Non-functional requirements (performance, security)
- Acceptance criteria (how to verify)
```

**Output**: `bmm/2-plan/prd-{topic}.md`

**PRD Structure**:
```markdown
# Product Requirements Document

## 1. Overview
- Problem statement
- Goals and objectives
- Success metrics

## 2. User Stories
- As a [user], I want [feature], so that [benefit]
- Acceptance criteria for each story

## 3. Functional Requirements
- Must-have features
- Should-have features
- Nice-to-have features

## 4. Non-Functional Requirements
- Performance (response time, throughput)
- Security (authentication, authorization)
- Scalability (concurrent users, data volume)

## 5. Constraints
- Technical constraints (Laravel 12, Filament 5)
- Business constraints (timeline, budget)
- Regulatory constraints (GDPR, ATS)

## 6. Dependencies
- External systems (LimeSurvey, Quaeris)
- Internal modules (Chart, Xot, UI)

## 7. Risks
- Technical risks
- Business risks
- Mitigation strategies
```

#### Step 2.2: Validate PRD (Recommended)

```bash
/bmad-bmm-validate-prd
```

**What it does**:
- Checks PRD completeness (8 dimensions)
- Validates acceptance criteria
- Identifies missing requirements
- Suggests improvements

**Output**: `bmm/2-plan/prd-{topic}-validation.md`

#### Step 2.3: Edit PRD (As Needed)

```bash
/bmad-bmm-edit-prd
```

**Use when**:
- Stakeholders request changes
- New requirements discovered
- Technical constraints identified

#### Step 2.4: Create UX Design (Optional)

```bash
/bmad-bmm-create-ux-design
```

**Prompt Example**:
```
Create UX design for "DashboardV3 Custom Charts"

Include:
- Wireframes (chart layout, filters, actions)
- User flows (view chart, export PDF, share)
- Interaction patterns (hover, click, filter)
- Accessibility requirements (WCAG 2.2)
```

**Output**: `bmm/2-plan/ux-design-{topic}.md`

**UX Design Structure**:
```markdown
# UX Design Specification

## 1. User Flows
- Flow diagrams (view, filter, export)
- User journey maps

## 2. Wireframes
- Low-fidelity sketches
- Layout specifications

## 3. Interaction Design
- Hover states
- Click behaviors
- Loading states
- Error states

## 4. Accessibility
- ARIA labels
- Keyboard navigation
- Color contrast
- Screen reader support

## 5. Responsive Design
- Mobile breakpoints
- Tablet layouts
- Desktop layouts
```

---

### Phase 3: Solutioning (Sprint 0 / Technical Refinement)

**Goal**: Define **how** to build it

**Duration**: 2-4 hours  
**Output**: Architecture, epics & stories

#### Step 3.1: Create Architecture (REQUIRED)

```bash
/bmad-bmm-create-architecture
```

**Prompt Example**:
```
Create architecture for "DashboardV3 Custom Charts"

Context:
- Laravel 12 + Filament 5 + PHP 8.3
- Laraxot modular architecture
- XotBase extension pattern
- Spatie Queueable Actions

Requirements:
- Custom questions in Modules/Quaeris/app/Actions/QuestionChart/Custom/
- DTOs in Modules/Chart/app/Datas/
- Widgets in Modules/Quaeris/app/Filament/Widgets/
- PDF export via Spatie Queueable Action

Constraints:
- NEVER create Service classes (use Actions)
- ALWAYS extend XotBase classes
- NEVER cross-database join (quaeris_data vs quaeris_survey)
- MySQL strict mode compliance
```

**Output**: `bmm/3-solutioning/architecture-{topic}.md`

**Architecture Structure**:
```markdown
# Architecture Document

## 1. System Context
- System boundaries
- External dependencies
- User interactions

## 2. Architecture Principles
- Design patterns (Action, DTO, Widget)
- Architectural style (Modular Monolith)
- Key decisions and rationale

## 3. Component View
- Component diagram
- Component responsibilities
- Component interactions

## 4. Data View
- Data model
- Database schema
- Data flow

## 5. Deployment View
- Deployment diagram
- Infrastructure requirements
- Scaling strategy

## 6. Cross-Cutting Concerns
- Security (authentication, authorization)
- Logging (audit trail, debugging)
- Error handling (exceptions, recovery)
- Performance (caching, optimization)

## 7. Testing Strategy
- Unit tests (Actions, DTOs)
- Integration tests (Widgets, PDF export)
- E2E tests (user flows)

## 8. Migration Strategy
- Database migrations
- Data migration (if needed)
- Rollback plan
```

#### Step 3.2: Create Epics & Stories (REQUIRED)

```bash
/bmad-bmm-create-epics-and-stories
```

**Input**: PRD (from 2.1), Architecture (from 3.1)

**Output**: `bmm/3-solutioning/epics-and-stories-{topic}.md`

**Structure**:
```markdown
# Epics and Stories

## Epic 1: Custom Questions Implementation

### Story US-001: MailResponseRate
- **As a** survey administrator
- **I want** to see email response rate charts
- **So that** I can measure email campaign effectiveness

**Acceptance Criteria**:
- [ ] MailResponseRate action created
- [ ] Uses ChartData::from() pattern
- [ ] PHPStan Level 10 passes
- [ ] Pest test coverage 80%+
- [ ] Documentation updated

**Priority**: 1  
**Estimate**: 3 story points  
**Status**: To Do

### Story US-002: SmsResponseRate
...

## Epic 2: PDF Export Enhancement

### Story US-010: PDF Download Action
...
```

#### Step 3.3: Check Implementation Readiness (REQUIRED)

```bash
/bmad-bmm-check-implementation-readiness
```

**What it validates**:
- ✅ PRD complete and validated
- ✅ Architecture documented
- ✅ Epics and stories defined
- ✅ UX design complete (if applicable)
- ✅ Test strategy defined
- ✅ Dependencies identified
- ✅ Risks mitigated

**Output**: `bmm/3-solutioning/implementation-readiness-{topic}.md`

**Readiness Report**:
```markdown
# Implementation Readiness Report

## Status: ✅ READY / ⚠️ NOT READY

## Checklist
- [x] PRD created and validated
- [x] Architecture documented
- [x] Epics and stories defined
- [x] UX design complete
- [x] Test strategy defined
- [ ] Dependencies resolved
- [x] Risks documented

## Missing Items
- None / List of missing items

## Recommendation
- Proceed to implementation / Address missing items first
```

---

### Phase 4: Implementation (Sprint Execution)

**Goal**: Build and ship

**Duration**: Ongoing (per sprint)  
**Output**: Working software, tests, documentation

#### Step 4.1: Sprint Planning (REQUIRED)

```bash
/bmad-bmm-sprint-planning
```

**Input**: Epics and stories (from 3.2)

**Output**: `bmm/4-implementation/sprint-plan-{sprint-number}.md`

**Sprint Plan Structure**:
```markdown
# Sprint Plan - Sprint {N}

## Sprint Goal
What we aim to achieve this sprint

## Capacity
- Team members available
- Story points capacity

## Committed Stories
| Story ID | Title | Priority | Estimate | Status |
|----------|-------|----------|----------|--------|
| US-001 | MailResponseRate | 1 | 3 | To Do |
| US-002 | SmsResponseRate | 1 | 3 | To Do |

## Sprint Backlog
Detailed tasks for each story

## Risks
What could go wrong this sprint

## Definition of Done
- Code implemented
- Tests passing (80%+ coverage)
- PHPStan Level 10 passes
- Documentation updated
- Code reviewed
```

#### Step 4.2: Sprint Status (Optional)

```bash
/bmad-bmm-sprint-status
```

**What it does**:
- Summarizes sprint progress
- Surfaces risks and blockers
- Updates sprint burndown

**Output**: `bmm/4-implementation/sprint-status-{sprint-number}.md`

#### Step 4.3: Create Story (REQUIRED for each story)

```bash
/bmad-bmm-create-story
```

**Input**: Story from epics-and-stories document

**Output**: `bmm/4-implementation/stories/{story-id}.md`

**Story Structure**:
```markdown
# Story US-001: MailResponseRate

## Context
Why this story matters

## Requirements
- Functional requirements
- Technical requirements

## Acceptance Criteria
- [ ] MailResponseRate action created
- [ ] Uses ChartData::from() pattern
- [ ] PHPStan Level 10 passes
- [ ] Pest test coverage 80%+
- [ ] Documentation updated

## Implementation Plan
1. Create MailResponseRate action
2. Implement calculation logic
3. Add tests
4. Update documentation
5. Run quality gates

## Technical Notes
- Use Contact::on('quaeris_data') for database connection
- Use groupBy() instead of groupByRaw() for MySQL strict mode
- Convert array to DataCollection explicitly

## Related Files
- `Modules/Quaeris/app/Actions/QuestionChart/Custom/MailResponseRate.php`
- `Modules/Chart/app/Datas/ChartData.php`
- `Modules/Quaeris/tests/Feature/MailResponseRateTest.php`
```

#### Step 4.4: Validate Story (Recommended)

```bash
/bmad-bmm-create-story  # Validate Mode
```

**What it validates**:
- Story completeness
- Acceptance criteria clarity
- Technical feasibility
- Test coverage plan

#### Step 4.5: Dev Story (REQUIRED)

```bash
/bmad-bmm-dev-story
```

**Input**: Story file (from 4.3)

**Process**:
1. Reads story file
2. Implements code changes
3. Runs tests
4. Updates documentation
5. Commits to git

**Output**:
- Implemented code
- Test files
- Documentation updates
- Git commits

**Example**:
```bash
/bmad-bmm-dev-story "bmm/4-implementation/stories/US-001.md"
```

#### Step 4.6: QA Automation Test (Optional)

```bash
/bmad-bmm-qa-automate
```

**Prompt Example**:
```
Create automated tests for "Custom Charts"

Cover:
- Unit tests for Actions
- Integration tests for Widgets
- E2E tests for user flows
```

**Output**: `bmm/4-implementation/tests/{test-class}.php`

#### Step 4.7: Code Review (Optional)

```bash
/bmad-bmm-code-review
```

**What it does**:
- Reviews code changes
- Identifies bugs and issues
- Suggests improvements
- Validates against requirements

**Output**: `bmm/4-implementation/code-review-{story-id}.md`

#### Step 4.8: Retrospective (Optional, after sprint)

```bash
/bmad-bmm-retrospective
```

**Prompt Example**:
```
Run retrospective for "Sprint {N} - Custom Charts"

Cover:
- What went well
- What could be improved
- Action items for next sprint
```

**Output**: `bmm/4-implementation/retrospective-sprint-{n}.md`

---

## 🎭 Specialized Agents

### When to Use Each Agent

| Agent | Use Case | Command |
|-------|----------|---------|
| **PM** | Sprint planning, roadmap | `/bmad-agent-pm` |
| **Architect** | Technical design decisions | `/bmad-agent-architect` |
| **Developer** | Code implementation | `/bmad-agent-dev` |
| **UX Designer** | Interface design | `/bmad-agent-ux-designer` |
| **Scrum Master** | Sprint management | `/bmad-agent-sm` |
| **Test Architect** | Test strategy | `/bmad-agent-qa` |
| **Security Expert** | Security audit | `/bmad-agent-security` |
| **DevOps Engineer** | CI/CD setup | `/bmad-agent-devops` |
| **Business Analyst** | Requirements analysis | `/bmad-agent-analyst` |
| **Technical Writer** | Documentation | `/bmad-agent-tech-writer` |
| **Product Owner** | Prioritization | `/bmad-agent-po` |
| **QA Specialist** | Quality assurance | `/bmad-agent-qa` |

### Party Mode (Multi-Agent Session)

```bash
/bmad-party-mode
```

**Use for**:
- Complex architectural decisions
- Sprint planning with multiple stakeholders
- Product strategy sessions

**How it works**:
- Multiple agent personas collaborate
- Each agent brings domain expertise
- Natural conversation flow
- Consensus-based decisions

---

## 📋 Laraxot-Specific Adaptations

### Scale-Adaptive Thinking

**Bug Fix** (Short Cycle):
```bash
/bmad-bmm-quick-spec "Fix MailResponseRate calculation"
# Direct to implementation
```

**New Feature** (Complete Cycle):
```bash
/bmad-bmm-create-prd
/bmad-bmm-create-architecture
/bmad-bmm-create-epics-and-stories
# Full planning before implementation
```

### Business First

Every task starts with:
```
What business problem am I solving?
Which modules are affected?
What is the user value?
```

### Modules as BMAD Domains

Each module is a domain:
- **Quaeris**: Survey analytics, dashboards
- **Chart**: Chart DTOs, data structures
- **Xot**: Base classes, migrations, translations
- **UI**: Frontend components, styling
- **User**: Authentication, authorization
- **Geo**: Geographic data
- **Lang**: Translations, localization
- **Media**: File management
- **Seo**: SEO optimization

### BMAD Pipeline for Every Change

```
Understand → Plan → Implement → Verify → Document
```

**Example**:
```bash
# 1. Understand
/bmad-help "I need to add a new chart type"

# 2. Plan
/bmad-bmm-create-prd "Chart 190 Implementation"
/bmad-bmm-create-architecture

# 3. Implement
/bmad-bmm-create-story "US-190"
/bmad-bmm-dev-story "stories/US-190.md"

# 4. Verify
/gsd-verify-work

# 5. Document
/bmad-agent-tech-writer "Update CUSTOM_QUESTIONS_COMPLETE_GUIDE.md"
```

---

## 🎯 Best Practices

### ✅ DO

1. **Always start with bmad-help**:
   ```bash
   /bmad-help
   ```

2. **Follow the 4 phases in order**:
   - Don't skip Analysis and Planning
   - Don't implement without Architecture

3. **Use fresh context for each workflow**:
   - Start new session for each phase
   - Don't accumulate context

4. **Validate before implementing**:
   - Validate PRD
   - Check implementation readiness
   - Validate stories

5. **Use specialized agents**:
   - Architect for technical decisions
   - Test Architect for coverage planning
   - Technical Writer for documentation

6. **Document everything**:
   - PRD before coding
   - Architecture before implementation
   - Stories before development

7. **Run quality gates**:
   ```bash
   vendor/bin/phpstan analyse --level=10
   vendor/bin/phpmd
   vendor/bin/phpinsights
   vendor/bin/pest --coverage
   ```

### ❌ DON'T

1. **Don't skip phases**:
   - No implementation without PRD
   - No coding without architecture

2. **Don't use same LLM for validation**:
   - Use different model for validation
   - Avoid confirmation bias

3. **Don't mix workflows**:
   - One workflow per context
   - Don't combine BMAD with GSD in same session

4. **Don't ignore guardrails**:
   - Follow Laraxot rules
   - Respect module boundaries

5. **Don't forget tests**:
   - Every story needs tests
   - 80%+ coverage required

6. **Don't skip documentation**:
   - Update docs before/after code
   - Keep docs in sync with code

---

## 📊 Example: Complete BMAD Workflow

### Scenario: Add New Dashboard Widget

#### Phase 1: Analysis (1 hour)

```bash
# Brainstorming
/bmad-brainstorming "DashboardV3 prediction market widget"

# Domain research
/bmad-bmm-domain-research "Prediction market analytics"

# Technical research
/bmad-bmm-technical-research "Real-time chart updates in Filament"
```

#### Phase 2: Planning (2 hours)

```bash
# Create PRD
/bmad-bmm-create-prd "DashboardV3 Prediction Market Widget"

# Validate PRD
/bmad-bmm-validate-prd

# Create UX design
/bmad-bmm-create-ux-design "Prediction Market Widget"
```

#### Phase 3: Solutioning (2 hours)

```bash
# Create architecture
/bmad-bmm-create-architecture "Prediction Market Widget"

# Create epics and stories
/bmad-bmm-create-epics-and-stories

# Check readiness
/bmad-bmm-check-implementation-readiness
```

#### Phase 4: Implementation (Ongoing)

```bash
# Sprint planning
/bmad-bmm-sprint-planning

# Create story
/bmad-bmm-create-story "US-001: PredictionMarketWidget"

# Develop story
/bmad-bmm-dev-story "stories/US-001.md"

# Code review
/bmad-bmm-code-review

# Retrospective (after sprint)
/bmad-bmm-retrospective
```

---

## 🔗 Integration with Other Methodologies

### BMAD + GSD

```bash
# BMAD for planning
/bmad-bmm-create-prd
/bmad-bmm-create-architecture
/bmad-bmm-create-epics-and-stories

# GSD for execution
/gsd:discuss-phase 1
/gsd:plan-phase 1
/gsd:execute-phase 1
/gsd:verify-work 1
```

### BMAD + Ralph Loop

```bash
# BMAD for PRD and architecture
/bmad-bmm-create-prd
/bmad-bmm-create-architecture

# Convert to Ralph PRD
# Edit .ralph/prd.json with stories

# Ralph for implementation
./.ralph/ralph-loop.sh 20 true
```

---

## 📚 Resources

### Official Documentation

- **BMAD Method**: [github.com/bmad-code-org/BMAD-METHOD](https://github.com/bmad-code-org/BMAD-METHOD)
- **BMAD Skills**: `/_bmad/bmm/` directory

### Project Documentation

- **AI Methodologies Integration**: `docs/project/ai-methodologies-integration.md`
- **BMAD Method (Laraxot)**: `laravel/Modules/Xot/docs/bmad-method.md`
- **AGENTS.md**: `AGENTS.md`

### Configuration

- **Manifest**: `/_bmad/_config/manifest.yaml`
- **Agents**: `/_bmad/_config/agent-manifest.csv`
- **Skills**: `/_bmad/_config/skill-manifest.csv`

---

## 🎯 Quick Reference

### Essential Commands

```bash
# Help
/bmad-help

# PRD
/bmad-bmm-create-prd
/bmad-bmm-validate-prd

# Architecture
/bmad-bmm-create-architecture

# Stories
/bmad-bmm-create-epics-and-stories
/bmad-bmm-create-story
/bmad-bmm-dev-story

# Sprint
/bmad-bmm-sprint-planning
/bmad-bmm-sprint-status

# Review
/bmad-bmm-code-review
/bmad-bmm-retrospective
```

### File Locations

```
_bmad/
├── _config/
│   ├── manifest.yaml
│   ├── agent-manifest.csv
│   └── skill-manifest.csv
├── bmm/
│   ├── 1-analysis/
│   ├── 2-plan/
│   ├── 3-solutioning/
│   └── 4-implementation/
└── core/
```

### Quality Gates

```bash
# After every PHP change
vendor/bin/phpstan analyse --level=10
vendor/bin/phpmd
vendor/bin/phpinsights

# If testable
vendor/bin/pest --coverage
```

---

**Document Created**: March 27, 2026  
**Next Review**: April 10, 2026  
**Owner**: Development Team  
**Status**: ✅ Ready for use
