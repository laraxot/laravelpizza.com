---
layout: default
title: "Skills"
description: "Complete reference for all 9 BMAD skills implementing the Anthropic specification. Learn when to use each skill and how they orchestrate AI-driven development."
keywords: "BMAD skills, Claude Code agents, AI development agents, business analyst AI, product manager AI, architect AI, Anthropic skill specification"
---

# BMAD Skills Reference

BMAD provides **9 specialized skills** implementing the [Anthropic Claude Code skill specification](https://docs.anthropic.com/claude/docs/skills). Each skill is a self-contained AI agent with specific responsibilities, trigger phrases, and workflows that guide you through structured development phases.

---

## Skills Overview

All skills are located in a **flat directory structure** at `bmad-skills/` with no nested modules:

```
bmad-skills/
├── bmad-orchestrator/    # Workflow orchestration and routing
├── business-analyst/     # Phase 1: Analysis and discovery
├── product-manager/      # Phase 2: Requirements and planning
├── system-architect/     # Phase 3: Architecture and design
├── scrum-master/         # Phase 4: Sprint planning
├── developer/            # Phase 4: Implementation
├── ux-designer/          # Cross-phase: UX design
├── creative-intelligence/# Cross-phase: Research and brainstorming
└── builder/              # Meta: Create custom skills
```

### Skill Structure

Each skill follows the [Anthropic specification](https://docs.anthropic.com/claude/docs/skills) with:

```
skill-name/
├── SKILL.md           # Required: YAML frontmatter + instructions (<5K tokens)
├── REFERENCE.md       # Optional: Detailed reference material
├── scripts/           # Optional: Executable utilities (.sh, .py)
├── templates/         # Optional: Document templates (.template.md)
└── resources/         # Optional: Reference data (.md)
```

**SKILL.md Format:**
```yaml
---
name: skill-name           # lowercase, hyphens, max 64 chars
description: |             # max 1024 chars, include trigger words
  What it does AND when to use it.
allowed-tools: Read, Write, Edit, Bash, Glob, Grep, TodoWrite
---

# Skill Name

[Markdown content under 5K tokens]
```

---

## Skills by BMAD Phase

### Phase 1: Analysis

| Skill | Purpose | Trigger Keywords |
|-------|---------|------------------|
| [Business Analyst](#business-analyst) | Product discovery, requirements analysis, product briefs | product brief, brainstorm, research, discovery, requirements, problem analysis, user needs, competitive analysis |
| [Creative Intelligence](#creative-intelligence) | Research and structured brainstorming | brainstorm, ideate, research, SCAMPER, SWOT, mind map, creative, explore ideas, market research |

### Phase 2: Planning

| Skill | Purpose | Trigger Keywords |
|-------|---------|------------------|
| [Product Manager](#product-manager) | PRDs, tech specs, feature prioritization | PRD, requirements, tech spec, features, prioritization, epics, user stories, acceptance criteria |
| [UX Designer](#ux-designer) | User experience, wireframes, accessibility | UX design, wireframe, user flow, accessibility, WCAG, mobile-first, responsive, UI design |

### Phase 3: Solutioning

| Skill | Purpose | Trigger Keywords |
|-------|---------|------------------|
| [System Architect](#system-architect) | System architecture, tech stack, NFRs | architecture, system design, tech stack, components, scalability, security, API design, data model |
| [UX Designer](#ux-designer) | Design system, component specs | design system, component design, interaction design |

### Phase 4: Implementation

| Skill | Purpose | Trigger Keywords |
|-------|---------|------------------|
| [Scrum Master](#scrum-master) | Sprint planning, story breakdown | sprint planning, user story, story points, velocity, backlog, sprint, epic breakdown, estimation |
| [Developer](#developer) | Code implementation, testing | implement story, dev story, code, implement, build feature, fix bug, write tests, code review, refactor |

### Cross-Phase Skills

| Skill | Purpose | Trigger Keywords |
|-------|---------|------------------|
| [BMAD Orchestrator](#bmad-orchestrator) | Workflow routing and status tracking | workflow-init, workflow-status, BMAD setup, project status, next steps |
| [Builder](#builder) | Create custom skills and workflows | create agent, create workflow, custom skill, extend BMAD, new template, customize |

---

## Skill Details

<h3 id="bmad-orchestrator">BMAD Orchestrator</h3>

**Name:** `bmad-orchestrator`
**Phase:** All phases (orchestration)
**Allowed Tools:** Read, Write, Edit, Bash, Glob, Grep, TodoWrite

#### Purpose
Core orchestrator for the BMAD Method, managing workflows, tracking status, and routing users through structured development phases.

#### When to Use
- Initialize BMAD in a project (`/workflow-init`)
- Check project progress (`/workflow-status`)
- Determine next recommended workflow
- Set up project structure and configuration

#### Key Workflows
- `/workflow-init` or `/init` - Initialize BMAD directory structure and configuration
- `/workflow-status` or `/status` - Check progress and get recommendations

#### Project Levels
- **Level 0:** Single atomic change (1 story)
- **Level 1:** Small feature (1-10 stories)
- **Level 2:** Medium feature set (5-15 stories)
- **Level 3:** Complex integration (12-40 stories)
- **Level 4:** Enterprise expansion (40+ stories)

#### Directory Structure Created
```
bmad/
├── config.yaml              # Project configuration
├── context/                 # Shared context for subagents
└── outputs/                 # Subagent outputs

docs/
├── bmm-workflow-status.yaml # Workflow progress tracking
└── stories/                 # User story documents
```

#### Subagent Strategy
**Workflow Status Check:** 3-4 parallel agents check config, workflow status, artifacts, and generate recommendations.

**Project Initialization:** 3 parallel agents create directory structure, config files, and workflow status.

---

<h3 id="business-analyst">Business Analyst</h3>

**Name:** `business-analyst`
**Phase:** Phase 1 - Analysis
**Allowed Tools:** Read, Write, Edit, Bash, Glob, Grep, TodoWrite, WebSearch, WebFetch

#### Purpose
Product discovery and requirements analysis specialist. Conducts stakeholder interviews, market research, problem discovery, and creates product briefs.

#### When to Use
- Create a product brief for a new product or feature
- Conduct product discovery and problem analysis
- Perform market and competitive research
- Interview stakeholders about needs and pain points
- Define success metrics and goals

#### Key Workflows
- `/product-brief` - Create comprehensive product brief through structured discovery
- `/brainstorm-project` - Facilitate structured brainstorming session
- `/research` - Conduct market/competitive/technical research

#### Discovery Frameworks
- **5 Whys** - Root cause analysis
- **Jobs-to-be-Done** - Focus on user accomplishments
- **SMART Goals** - Specific, Measurable, Achievable, Relevant, Time-bound

#### Output Quality Standards
- Clear and unambiguous
- Specific, measurable criteria
- Grounded in research and evidence
- Defines success metrics
- Identifies risks and dependencies

#### Subagent Strategy
**Product Discovery Research:** 4 parallel agents conduct market research, competitive analysis, technical feasibility, and user needs analysis.

**Product Brief Generation:** 3 parallel agents generate problem definition, solution approach, and success metrics sections.

#### Integration
**Hands off to:** Product Manager (provides product brief for PRD creation)

---

<h3 id="product-manager">Product Manager</h3>

**Name:** `product-manager`
**Phase:** Phase 2 - Planning
**Allowed Tools:** Read, Write, Edit, Bash, Glob, Grep, TodoWrite, AskUserQuestion

#### Purpose
Product requirements and planning specialist. Creates PRDs and tech specs with functional/non-functional requirements, prioritizes features, and breaks down epics into user stories.

#### When to Use
- Create Product Requirements Documents (PRDs) for Level 2+ projects
- Create Technical Specifications for Level 0-1 projects
- Define functional requirements (FRs) and non-functional requirements (NFRs)
- Prioritize features using MoSCoW, RICE, or Kano frameworks
- Break down requirements into epics and user stories

#### Key Workflows
- `/prd` - Create Product Requirements Document
- `/tech-spec` - Create lightweight spec for Level 0-1 projects
- `/validate-prd` - Validate PRD completeness

#### Requirements Types

**Functional Requirements (FRs):**
```
FR-001: MUST - User can create account with email and password
Acceptance Criteria:
- Email validation follows RFC 5322 standard
- Password minimum 8 characters with mixed case and numbers
- Confirmation email sent within 30 seconds
```

**Non-Functional Requirements (NFRs):**
```
NFR-001: MUST - API endpoints respond within 200ms for 95th percentile
NFR-002: MUST - System supports 10,000 concurrent users
NFR-003: SHOULD - Application achieves WCAG 2.1 AA compliance
```

#### Prioritization Frameworks

| Framework | Best For | Formula |
|-----------|----------|---------|
| **MoSCoW** | Time-boxed projects, MVP definition | Must/Should/Could/Won't Have |
| **RICE** | Data-driven prioritization | (Reach × Impact × Confidence) / Effort |
| **Kano** | Customer satisfaction analysis | Basic/Performance/Excitement features |

#### Subagent Strategy
**PRD Generation:** 4 parallel agents generate Functional Requirements, Non-Functional Requirements, Epics & Stories, and Dependencies sections.

**Epic Prioritization:** N parallel agents (one per epic) calculate RICE scores in parallel.

**Tech Spec Generation:** 3 parallel agents create requirements, technical approach, and testing sections.

#### Integration
**Receives from:** Business Analyst (product brief)
**Provides to:** System Architect (PRD for architecture), Scrum Master (epics for backlog)

---

<h3 id="system-architect">System Architect</h3>

**Name:** `system-architect`
**Phase:** Phase 3 - Solutioning
**Allowed Tools:** Read, Write, Edit, Bash, Glob, Grep, TodoWrite, WebSearch

#### Purpose
Designs system architecture, selects tech stacks, defines components and interfaces, and addresses non-functional requirements systematically.

#### When to Use
- Design system architecture for a new project
- Select technology stacks with justification
- Define system components and their interactions
- Address non-functional requirements (NFRs) systematically
- Create data models and API specifications

#### Key Workflows
- `/architecture` - Create system architecture document
- `/solutioning-gate-check` - Validate architecture against requirements
- `/validate-architecture` - Check architecture completeness

#### Architectural Patterns

| Pattern | Project Level | Use Case |
|---------|--------------|----------|
| **Monolith** | Level 0-1 | Simple, single deployable unit |
| **Modular Monolith** | Level 2 | Organized modules with clear boundaries |
| **Microservices** | Level 3-4 | Independent services with APIs |
| **Serverless** | Specific | Event-driven functions |

#### NFR Mapping

| NFR Category | Architecture Decisions |
|--------------|----------------------|
| **Performance** | Caching strategy, CDN, database indexing, load balancing |
| **Scalability** | Horizontal scaling, stateless design, database sharding |
| **Security** | Auth/authz model, encryption (transit/rest), secret management |
| **Reliability** | Redundancy, failover, circuit breakers, retry logic |
| **Maintainability** | Module boundaries, testing strategy, documentation |

#### Architecture Document Sections
1. System Overview
2. Architecture Pattern
3. Component Design
4. Data Model
5. API Specifications
6. NFR Mapping
7. Technology Stack
8. Trade-off Analysis
9. Deployment Architecture
10. Future Considerations

#### Subagent Strategy
**Requirements Analysis:** 2 parallel agents analyze Functional Requirements and Non-Functional Requirements.

**Component Design:** N parallel agents (one per major component) design Auth, Data, API, UI, and domain components in parallel.

**NFR Mapping:** 6 parallel agents map Performance, Scalability, Security, Reliability, Maintainability, and Availability NFRs to architectural decisions.

#### Integration
**Receives from:** Product Manager (PRD or tech-spec)
**Provides to:** Scrum Master (architecture for sprint planning), Developer (technical blueprint)

---

<h3 id="scrum-master">Scrum Master</h3>

**Name:** `scrum-master`
**Phase:** Phase 4 - Implementation Planning
**Allowed Tools:** Read, Write, Edit, Bash, Glob, Grep, TodoWrite

#### Purpose
Sprint planning and agile workflow specialist. Breaks epics into user stories, estimates complexity using story points, and plans sprint iterations.

#### When to Use
- Break epics into detailed user stories
- Estimate story complexity using story points
- Plan sprint iterations based on team velocity
- Track sprint progress with burndown metrics

#### Key Workflows
- `/sprint-planning` - Plan sprint iterations from epics and requirements
- `/create-story` - Create detailed user story with acceptance criteria
- `/sprint-status` - Check current sprint progress
- `/velocity-report` - Calculate team velocity metrics

#### Story Sizing (Fibonacci Scale)

| Points | Complexity | Time | Example |
|--------|-----------|------|---------|
| **1** | Trivial | 1-2 hours | Config change, text update |
| **2** | Simple | 2-4 hours | Basic CRUD, simple component |
| **3** | Moderate | 4-8 hours | Complex component, business logic |
| **5** | Complex | 1-2 days | Feature with multiple components |
| **8** | Very Complex | 2-3 days | Full feature (frontend + backend) |
| **13** | Epic-sized | 3-5 days | **Break this down!** |

**Rule:** Stories exceeding 8 points must be broken into smaller stories.

#### Sprint Planning by Level

| Level | Stories | Sprints | Approach |
|-------|---------|---------|----------|
| **Level 0** | 1 | None | Single story, no sprint planning |
| **Level 1** | 1-10 | 1 sprint | Estimate all, prioritize by dependency |
| **Level 2** | 5-15 | 1-2 sprints | Group by epic, define sprint goals |
| **Level 3-4** | 12+ | 2-4+ sprints | Full velocity-based planning, release planning |

#### Story Structure
```
As a [user type],
I want [capability],
So that [benefit].

Acceptance Criteria:
- Criterion 1 (specific, testable)
- Criterion 2 (specific, testable)
- Criterion 3 (specific, testable)

Estimate: 5 points
Dependencies: STORY-001, Architecture doc
```

#### Subagent Strategy
**Epic Breakdown:** N parallel agents (one per epic) break down each epic into user stories with estimates.

**Sprint Planning:** 3 parallel agents analyze dependencies, calculate velocity, and generate sprint goals.

**Story Refinement:** N parallel agents refine independent stories with full acceptance criteria in parallel.

#### Integration
**Receives from:** Product Manager (PRD with epics), System Architect (architecture document)
**Provides to:** Developer (refined, estimated stories for implementation)

---

<h3 id="developer">Developer</h3>

**Name:** `developer`
**Phase:** Phase 4 - Implementation
**Allowed Tools:** Read, Write, Edit, Bash, Glob, Grep, TodoWrite

#### Purpose
Implements user stories, writes clean tested code, and follows best practices. Translates requirements into working, maintainable software.

#### When to Use
- Implement user stories from requirements
- Write clean, maintainable, well-tested code
- Achieve 80%+ test coverage
- Validate acceptance criteria
- Fix bugs and refactor code

#### Key Workflows
- `/dev-story {STORY-ID}` - Implement a specific user story
- `/code-review {file}` - Review code against standards
- `/fix-tests` - Fix failing tests
- `/refactor {component}` - Refactor code

#### Implementation Approach
1. **Understand Requirements** - Read story acceptance criteria
2. **Plan Implementation** - Break into tasks with TodoWrite
3. **Execute Incrementally** - Test-driven development (TDD)
4. **Validate Quality** - Run tests, check coverage, verify acceptance criteria

#### Code Quality Standards

**Clean Code:**
- Descriptive names (no single-letter variables)
- Functions under 50 lines with single responsibility
- DRY principle - extract common logic
- Explicit error handling
- Comments explain "why" not "what"

**Testing:**
- Unit tests for individual functions/components
- Integration tests for component interactions
- E2E tests for critical user flows
- 80%+ coverage on new code
- Test edge cases and error conditions

**Git Commits:**
- Small, focused commits
- Format: `feat(component): description` or `fix(component): description`
- Commit frequently, push regularly

#### Validation Checklist
Before completing any story:
- [ ] All test suites pass (unit, integration, e2e)
- [ ] Coverage meets 80% threshold
- [ ] All acceptance criteria verified
- [ ] Linting and formatting pass
- [ ] Manual testing for user-facing features
- [ ] Self code review completed

#### Subagent Strategy
**Story Implementation (Independent Stories):** N parallel agents implement independent stories with tests in parallel.

**Test Writing:** N parallel agents write tests for different components/modules in parallel.

**Implementation Task Breakdown:** 4 parallel agents implement backend, business logic, frontend, and tests in coordinated sequence.

**Code Review:** N parallel agents review multiple PRs in parallel.

#### Integration
**Receives from:** Scrum Master (user stories with acceptance criteria)
**Provides:** Working, tested code that meets requirements

---

<h3 id="ux-designer">UX Designer</h3>

**Name:** `ux-designer`
**Phase:** Phase 2/3 - Planning and Solutioning
**Allowed Tools:** Read, Write, Edit, Bash, Glob, Grep, TodoWrite, AskUserQuestion

#### Purpose
Designs user experiences, creates wireframes, defines user flows, and ensures accessibility compliance (WCAG 2.1 AA).

#### When to Use
- Create user interface designs
- Design wireframes and mockups (ASCII or structured descriptions)
- Define user flows and journeys
- Ensure WCAG 2.1 AA accessibility compliance
- Document design systems and patterns

#### Key Workflows
- `/create-ux-design` - Complete UX design workflow

#### Standard Workflow
1. **Understand Requirements** - Read PRD, extract user stories
2. **Create User Flows** - Map user journeys and navigation paths
3. **Design Wireframes** - Create screen layouts (ASCII or descriptions)
4. **Ensure Accessibility** - WCAG 2.1 AA compliance
5. **Document Design** - Design system, components, responsive behavior
6. **Validate Design** - Confirm meets requirements

#### Accessibility Requirements (WCAG 2.1 AA)
- Color contrast ≥ 4.5:1 (text), ≥ 3:1 (UI components)
- All functionality available via keyboard
- Visible focus indicators
- Labels for all form inputs
- Alt text for all images
- Semantic HTML structure
- ARIA labels where needed

#### Responsive Design (Mobile-First)

| Breakpoint | Layout | Navigation | Touch Targets |
|------------|--------|------------|---------------|
| **Mobile** (320-767px) | Single column, stacked cards | Hamburger menu | ≥ 44px |
| **Tablet** (768-1023px) | 2-column grid | Expanded navigation | Larger |
| **Desktop** (1024px+) | 3+ column grid | Full navigation bar | Hover states |

#### Design Handoff Deliverables
1. Wireframes (all screens and states)
2. User flows (diagrams with decision points)
3. Component specifications (size, behavior, states)
4. Interaction patterns (hover, focus, active, disabled)
5. Accessibility annotations (ARIA, alt text, keyboard nav)
6. Responsive behavior notes (breakpoints, layout changes)
7. Design tokens (colors, typography, spacing)

#### Subagent Strategy
**Screen/Flow Design:** N parallel agents (one per major screen or flow) design home, registration, dashboard, and settings screens in parallel.

**User Flow Design:** N parallel agents design onboarding, checkout, account management, and error flows in parallel.

**Accessibility Validation:** 4 parallel agents validate visual, keyboard, ARIA, and responsive accessibility.

**Component Specification:** N parallel agents specify buttons, forms, navigation, cards, and modal components in parallel.

#### Integration
**Receives from:** Business Analyst (user research), Product Manager (requirements)
**Provides to:** System Architect (UX constraints), Developer (design for implementation)

---

<h3 id="creative-intelligence">Creative Intelligence</h3>

**Name:** `creative-intelligence`
**Phase:** Cross-phase (any phase)
**Allowed Tools:** Read, Write, Edit, Bash, Glob, Grep, TodoWrite, WebSearch, WebFetch

#### Purpose
Facilitates structured brainstorming sessions, conducts comprehensive research, and generates creative solutions using proven frameworks.

#### When to Use
- Structured brainstorming for ideation
- Market, competitive, technical, or user research
- Creative problem-solving across all project phases
- Generate innovative solutions to complex problems
- Explore alternatives and possibilities

#### Key Workflows
- `/brainstorm` - Structured brainstorming session using proven techniques
- `/research` - Comprehensive research (market, competitive, technical, user)

#### Brainstorming Techniques

| Technique | Best For | Time | Output |
|-----------|----------|------|--------|
| **5 Whys** | Root cause analysis | 10-15 min | Cause chain |
| **SCAMPER** | Feature ideation | 20-30 min | Creative variations |
| **Mind Mapping** | Idea organization | 15-20 min | Visual hierarchy |
| **Reverse Brainstorming** | Risk identification | 15-20 min | Failure scenarios |
| **Six Thinking Hats** | Multi-perspective analysis | 30-45 min | Balanced view |
| **Starbursting** | Question exploration | 20-30 min | Question tree |
| **SWOT Analysis** | Strategic planning | 30-45 min | SWOT matrix |

#### SCAMPER Framework
- **Substitute:** What can be replaced or changed?
- **Combine:** What features can be merged?
- **Adapt:** What can be adjusted to fit different contexts?
- **Modify:** What can be magnified, minimized, or altered?
- **Put to other uses:** What new purposes can features serve?
- **Eliminate:** What can be removed to simplify?
- **Reverse/Rearrange:** What can be flipped or reorganized?

#### Research Types
1. **Market Research** - Market size, trends, customer segments, growth opportunities
2. **Competitive Research** - Competitor profiling, feature comparison, gap analysis
3. **Technical Research** - Technology evaluation, best practices, implementation approaches
4. **User Research** - User needs, pain points, behavior patterns, workflows

#### Cross-Phase Applicability

| Phase | Use Cases |
|-------|-----------|
| **Phase 1: Analysis** | Market research, competitive landscape, problem exploration (5 Whys), user research |
| **Phase 2: Planning** | Feature brainstorming (SCAMPER), SWOT analysis, risk identification, prioritization insights |
| **Phase 3: Solutioning** | Architecture alternatives, design pattern research, Mind Mapping, technical research |
| **Phase 4: Implementation** | Technical solution research, best practices, problem-solving, documentation |

#### Subagent Strategy
**Multi-Technique Brainstorming:** 3-6 parallel agents apply different brainstorming techniques (SCAMPER, Mind Mapping, Reverse Brainstorming, Six Thinking Hats) to the same problem.

**Comprehensive Research:** 4 parallel agents conduct market, competitive, technical, and user research in parallel.

**Problem Exploration:** 3 parallel agents apply 5 Whys, Starbursting, and stakeholder perspective analysis.

**Solution Generation:** 4 parallel agents generate SCAMPER variations, research existing solutions, identify constraints, and create evaluation criteria.

#### Integration
Works across all phases with all skills to provide research-driven insights and creative solutions.

---

<h3 id="builder">Builder</h3>

**Name:** `builder`
**Phase:** Meta (skill creation)
**Allowed Tools:** Read, Write, Edit, Bash, Glob, Grep, TodoWrite

#### Purpose
Creates custom agents, workflows, and templates for specialized domains. Extends BMAD functionality with domain-specific components.

#### When to Use
- Create custom agents for specific domains (QA, DevOps, Security)
- Generate workflow commands following BMAD patterns
- Create domain-specific document templates
- Customize BMAD for specific use cases

#### Key Workflows
- `/create-agent` - Create custom BMAD agent
- `/create-workflow` - Create custom workflow command
- `/create-template` - Create output template
- `/customize-bmad` - Modify BMAD configuration

#### Available Scripts
- `scripts/validate-skill.sh` - Validate SKILL.md YAML frontmatter
- `scripts/scaffold-skill.sh` - Create skill directory structure

#### YAML Frontmatter Requirements

Every SKILL.md must have:
```yaml
---
name: skill-name           # Required: lowercase, hyphens
description: |             # Required: include trigger keywords
  What it does AND when to use it.
allowed-tools: Read, Write, Edit, Bash, Glob, Grep, TodoWrite
---
```

#### Token Optimization
Keep SKILL.md under 5K tokens:
- Use references to REFERENCE.md for detailed patterns
- Link to resources for comprehensive guidance
- Avoid embedding large code blocks
- Use progressive disclosure (overview → details → examples)

#### Subagent Strategy
**Skill Creation:** 4 parallel agents create SKILL.md, helper scripts, templates, and reference resources.

**Multi-Skill Creation:** N parallel agents create multiple related skills (QA, DevOps, Security engineers) in parallel.

**Template Creation:** N parallel agents create test plan, deployment runbook, security assessment templates in parallel.

**Skill Validation:** 4 parallel agents validate YAML frontmatter, token count, script functionality, and content completeness.

#### Example Domain Customizations
- **QA Engineering:** QA Engineer skill, /create-test-plan workflow, test plan template
- **DevOps:** DevOps Engineer skill, /deploy workflow, deployment runbook template
- **Security:** Security Engineer skill, /security-audit workflow, security assessment template
- **Data Science:** Data Scientist skill, /data-analysis workflow, analysis report template

#### Integration
Creates new skills that integrate seamlessly with existing BMAD workflows and patterns.

---

## Subagent Architecture Patterns

All BMAD skills leverage **parallel subagents** to maximize the 200K token context window per agent. Each skill can decompose complex workflows into independent subtasks executed by parallel subagents.

### Core Principle
**Never do sequentially what can be done in parallel.** Decompose work into independent subtasks, execute in parallel, then synthesize results.

### Common Patterns

| Pattern | Use Case | Example |
|---------|----------|---------|
| **Fan-Out Research** | Gathering information from multiple sources | Business Analyst: 4 parallel agents research market, competitors, tech, users |
| **Parallel Section Generation** | Creating multi-section documents | Product Manager: 4 parallel agents generate FR, NFR, Epics, Dependencies sections |
| **Component Parallel Design** | Designing system components | System Architect: N agents design Auth, Data, API, UI components in parallel |
| **Story Parallel Implementation** | Implementing independent stories | Developer: N agents implement independent stories with tests in parallel |

### Coordination Strategy
1. **Write shared context** to `bmad/context/` for parallel agents
2. **Launch parallel agents** with Task tool using `run_in_background: true`
3. **Each agent writes output** to `bmad/outputs/`
4. **Main context synthesizes** results from all agents

See [Subagent Patterns](../subagent-patterns) for detailed patterns and examples.

---

## Skill Integration and Workflow

Skills work together across the BMAD workflow:

```
Phase 1: Analysis
  business-analyst → product-brief.md
  creative-intelligence → research-report.md

Phase 2: Planning
  product-manager → prd.md or tech-spec.md
  ux-designer → ux-design.md

Phase 3: Solutioning
  system-architect → architecture.md
  ux-designer → design-system.md

Phase 4: Implementation
  scrum-master → sprint-plan.md, stories/
  developer → working code + tests

Cross-Phase:
  bmad-orchestrator → workflow routing and status
  creative-intelligence → research and brainstorming
  builder → custom skills and workflows
```

### Handoff Example
```
User: /product-brief
→ Business Analyst creates docs/product-brief.md

User: /prd
→ Product Manager reads product-brief.md
→ Creates docs/prd.md

User: /architecture
→ System Architect reads prd.md
→ Creates docs/architecture.md

User: /sprint-planning
→ Scrum Master reads prd.md and architecture.md
→ Creates docs/sprint-status.yaml and docs/stories/

User: /dev-story STORY-001
→ Developer reads story file and architecture
→ Implements code with tests
```

Each skill automatically loads outputs from previous phases, maintaining context throughout the workflow.

---

## Progressive Disclosure Model

BMAD skills use a **progressive disclosure** approach to manage token budgets:

### Level 1: SKILL.md (<5K tokens)
- YAML frontmatter (name, description, allowed-tools)
- When to use this skill
- Core responsibilities and principles
- Key workflows and commands
- Quick reference and examples

### Level 2: REFERENCE.md (detailed patterns)
- Comprehensive workflow descriptions
- Detailed examples and edge cases
- Advanced patterns and techniques
- Integration scenarios

### Level 3: Resources (specialized guidance)
- Framework deep dives
- Template libraries
- Script documentation
- Domain-specific reference materials

This ensures skills load quickly while providing access to detailed information when needed.

---

## Next Steps

- Learn the [Commands](../commands/) each skill supports
- See [Examples](../examples/) of complete workflows
- Read [Subagent Patterns](../subagent-patterns) for parallel execution strategies
- Review [Getting Started](../getting-started/) to begin using BMAD

---

## Quick Reference Table

| Skill | Phase | Primary Output | Key Command |
|-------|-------|----------------|-------------|
| **bmad-orchestrator** | All | Workflow routing | `/workflow-init`, `/workflow-status` |
| **business-analyst** | 1 | product-brief.md | `/product-brief` |
| **product-manager** | 2 | prd.md or tech-spec.md | `/prd`, `/tech-spec` |
| **system-architect** | 3 | architecture.md | `/architecture` |
| **scrum-master** | 4 | sprint-plan.md, stories/ | `/sprint-planning` |
| **developer** | 4 | Working code + tests | `/dev-story {ID}` |
| **ux-designer** | 2/3 | ux-design.md | `/create-ux-design` |
| **creative-intelligence** | Cross | research-report.md, brainstorm-session.md | `/brainstorm`, `/research` |
| **builder** | Meta | Custom skills | `/create-agent` |
