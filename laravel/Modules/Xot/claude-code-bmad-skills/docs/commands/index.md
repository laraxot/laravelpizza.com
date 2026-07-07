---
layout: default
title: "Commands"
description: "Complete reference for all 15 BMAD slash commands. Learn how to use each command with detailed examples and best practices."
keywords: "BMAD commands, Claude Code commands, slash commands, workflow commands, agile commands"
---

# Commands Reference

BMAD provides 15 slash commands for managing your agile development workflow. Each command is designed for a specific phase and purpose.

---

## How Commands Work

Commands trigger **BMAD skills** - specialized AI agents that execute structured workflows. Skills are located in `~/.claude/skills/bmad-skills/` and may leverage **parallel subagents** for complex tasks.

**How it works:**
1. You trigger a command (e.g., `/prd`)
2. Claude activates the corresponding skill (e.g., `product-manager`)
3. The skill may launch parallel subagents to process different sections simultaneously
4. Results are synthesized and presented as a unified document

**Parallel Execution:** Skills like Product Manager, System Architect, and Creative Intelligence decompose work into independent subtasks executed by parallel subagents, each with up to 1M tokens of context on Claude Sonnet 4.6 / Opus 4.6.

**Quick tip:** Type `/workflow-status` anytime to see which command to run next.

---

## Commands by Phase

### Initialization

| Command | Purpose |
|---------|---------|
| [/workflow-init](#workflow-init) | Initialize BMAD in your project |
| [/workflow-status](#workflow-status) | Check progress and get recommendations |

### Phase 1 - Analysis

| Command | Purpose |
|---------|---------|
| [/product-brief](#product-brief) | Create comprehensive product brief |

### Phase 2 - Planning

| Command | Purpose |
|---------|---------|
| [/prd](#prd) | Product Requirements Document |
| [/tech-spec](#tech-spec) | Technical Specification (Level 0-1) |
| [/create-ux-design](#create-ux-design) | UX/UI design workflow |

### Phase 3 - Solutioning

| Command | Purpose |
|---------|---------|
| [/architecture](#architecture) | System architecture design |
| [/solutioning-gate-check](#solutioning-gate-check) | Validate architecture |

### Phase 4 - Implementation

| Command | Purpose |
|---------|---------|
| [/sprint-planning](#sprint-planning) | Plan sprint iterations |
| [/create-story](#create-story) | Create individual story |
| [/dev-story](#dev-story) | Implement user story |

### Builder (Custom)

| Command | Purpose |
|---------|---------|
| [/create-agent](#create-agent) | Create custom BMAD agent |
| [/create-workflow](#create-workflow) | Create custom workflow |

### Creative Intelligence

| Command | Purpose |
|---------|---------|
| [/brainstorm](#brainstorm) | Structured brainstorming |
| [/research](#research) | Market/tech/competitive research |

---

## Initialization Commands

<h3 id="workflow-init">/workflow-init</h3>

Initialize BMAD in your project. This creates the project configuration and sets up the output directory structure.

**When to use:** At the start of any new project

**Output:** `bmad/config.yaml`

#### Example

~~~~
User: /workflow-init

Claude: Welcome to BMAD! I'll initialize your project.

## Project Configuration

What is your project name?
> Real-time Chat Application

What type of project is this?
1. web-app
2. mobile-app
3. api
4. game
5. library
6. other
> 1

## Project Level

Based on scope, select the appropriate level:

| Level | Stories | Example |
|-------|---------|---------|
| 0 | 1 | Bug fix |
| 1 | 1-10 | Single feature |
| 2 | 5-15 | Feature set |
| 3 | 12-40 | System integration |
| 4 | 40+ | Enterprise |

For a chat app with user auth, real-time messaging, channels,
and notifications, I recommend Level 2.

Select level (0-4):
> 2

## Created Configuration

```yaml
# bmad/config.yaml
project_name: "Real-time Chat Application"
project_type: "web-app"
project_level: 2
output_folder: "docs"

bmm:
  workflow_status_file: "docs/bmm-workflow-status.yaml"
  sprint_status_file: "docs/sprint-status.yaml"

paths:
  docs: "docs"
  stories: "docs/stories"
  tests: "tests"
```

Created directories:
- docs/
- docs/stories/

Project initialized! Run /workflow-status to see next steps.
~~~~

---

<h3 id="workflow-status">/workflow-status</h3>

Check your project's current progress and get recommendations for what to do next.

**When to use:** Anytime you're unsure what to do next

**Output:** Status display (no file)

#### Example

```
User: /workflow-status

Claude: ## Real-time Chat Application - Workflow Status

### Project Info
- Type: web-app
- Level: 2 (Medium feature set)
- Output: docs/

### Phase Status

| Phase | Document | Status | File |
|-------|----------|--------|------|
| 1 - Analysis | Product Brief | ✓ Complete | docs/product-brief.md |
| 2 - Planning | PRD | ✓ Complete | docs/prd.md |
| 2 - Planning | UX Design | Optional | - |
| 3 - Solutioning | Architecture | ⚠ In Progress | - |
| 4 - Implementation | Sprint Plan | Pending | - |

### Recommendation

**Current Focus:** Phase 3 - Solutioning

Continue with `/architecture` to complete the system architecture design.

After architecture is complete:
1. Run `/solutioning-gate-check` to validate
2. Proceed to `/sprint-planning`

### Quick Stats
- Documents: 2/4 complete
- Estimated remaining: Architecture, Sprint Plan
```

---

## Phase 1 - Analysis Commands

<h3 id="product-brief">/product-brief</h3>

Create a comprehensive product brief that defines the problem space, target audience, and business goals.

**When to use:** Starting a new product (Level 1+, required for Level 2+)

**Output:** `docs/product-brief.md`

**Prerequisite:** `/workflow-init`

**Subagent Execution:** This command may use parallel subagents for document sections (Executive Summary, Problem Statement, Market Analysis, Solution Overview) when creating comprehensive product briefs.

#### Example

```
User: /product-brief

Claude: I'll help create a product brief for Real-time Chat Application.

## Executive Summary

In 2-3 sentences, what does this product do?
> A team collaboration platform focused on real-time communication.
> Combines chat, voice, and video with deep integrations for
> developer tools.

## Problem Statement

What problems does this solve? I'll structure them:

1. **Communication silos:** Teams use multiple apps (Slack, Discord, Teams)
2. **Context switching:** Developers lose focus switching between chat and IDE
3. **Limited customization:** Existing tools have rigid workflows

Is this accurate?
> Yes, also add "Poor code sharing experience"

Added: **Poor code sharing:** Pasting code in chat loses formatting and context

## Target Audience

Primary users:
> Software development teams, 5-50 people
> Tech-forward companies
> Remote-first teams

Secondary users:
> Individual developers in open source communities

## Solution Overview

Based on problems, your solution will:
- Unified chat, voice, video in one app
- IDE extensions (VS Code, JetBrains)
- Rich code snippets with syntax highlighting
- Customizable workflows and bots

## Competitive Landscape

Key competitors:
- **Slack:** Market leader, expensive, slow
- **Discord:** Gaming-focused, poor enterprise features
- **Teams:** Microsoft-only, complex

Your differentiation:
> Developer-first experience, superior code handling,
> privacy-focused (self-hostable)

## Business Model

How will you monetize?
> Freemium - free for small teams (<10)
> Pro: $8/user/month
> Enterprise: $15/user/month (SSO, audit logs)

## Success Metrics

How will you measure success?
> - 1000 teams in 6 months
> - 40% weekly active users
> - <200ms message delivery
> - NPS > 50

## Constraints and Risks

Technical constraints:
> - Must support 10k concurrent users
> - End-to-end encryption required

Risks:
> - Slack network effects
> - Feature parity expectations

Saving product brief to: docs/product-brief.md

Product brief complete! Run /workflow-status for next steps.
```

---

## Phase 2 - Planning Commands

<h3 id="prd">/prd</h3>

Create a Product Requirements Document with detailed functional requirements, user stories, and acceptance criteria.

**When to use:** Level 2+ projects after product brief

**Output:** `docs/prd.md`

**Prerequisite:** `docs/product-brief.md`

**Subagent Execution:** This command uses parallel subagents to generate different PRD sections simultaneously (Functional Requirements, Non-Functional Requirements, Epics & Stories, Dependencies), significantly speeding up document creation.

#### Example

```
User: /prd

Claude: I'll create a PRD based on your product brief.

Loading: docs/product-brief.md

## Functional Requirements

### FR-001: User Authentication
Users can register, login, and manage their accounts.

**Acceptance Criteria:**
- [ ] Email/password registration
- [ ] OAuth (Google, GitHub)
- [ ] Email verification
- [ ] Password reset flow
- [ ] 2FA support

### FR-002: Real-time Messaging
Users can send and receive messages instantly.

**Acceptance Criteria:**
- [ ] Text messages with markdown support
- [ ] Message delivery <200ms
- [ ] Typing indicators
- [ ] Read receipts
- [ ] Message editing and deletion
- [ ] Thread replies

### FR-003: Channels and DMs
Users can communicate in channels or direct messages.

**Acceptance Criteria:**
- [ ] Create public/private channels
- [ ] Channel topics and descriptions
- [ ] Direct messages (1:1 and group)
- [ ] Channel member management
- [ ] Channel archiving

### FR-004: Code Sharing
Developers can share code with syntax highlighting.

**Acceptance Criteria:**
- [ ] Code blocks with language detection
- [ ] Syntax highlighting for 50+ languages
- [ ] Line numbers
- [ ] Copy button
- [ ] Expandable for long snippets

### FR-005: Search
Users can search messages and files.

**Acceptance Criteria:**
- [ ] Full-text message search
- [ ] Filter by channel/user/date
- [ ] Search within code blocks
- [ ] Search suggestions

### FR-006: Notifications
Users receive timely notifications.

**Acceptance Criteria:**
- [ ] Desktop notifications
- [ ] Mobile push notifications
- [ ] @mention highlighting
- [ ] Custom notification schedules
- [ ] Do not disturb mode

## Non-Functional Requirements

### NFR-001: Performance
- Message delivery: <200ms P99
- Search results: <500ms
- App load time: <3s
- Support 10k concurrent users per server

### NFR-002: Security
- End-to-end encryption option
- SOC 2 compliance path
- Data residency options
- Audit logging for enterprise

### NFR-003: Scalability
- Horizontal scaling for message service
- Sharded database for messages
- CDN for file attachments

### NFR-004: Availability
- 99.9% uptime SLA
- Multi-region deployment
- Automated failover

## Epics and User Stories

### Epic 1: User Management

**STORY-001: User Registration**
As a new user, I want to create an account so I can join my team's workspace.

Points: 5 | Priority: Must

Acceptance Criteria:
- Register with email/password
- Validate email format
- Password strength requirements
- Email verification sent
- Redirect to workspace setup

**STORY-002: OAuth Login**
As a user, I want to login with Google/GitHub so I don't need another password.

Points: 5 | Priority: Must

**STORY-003: Two-Factor Authentication**
As a security-conscious user, I want to enable 2FA to protect my account.

Points: 5 | Priority: Should

### Epic 2: Messaging

**STORY-004: Send Message**
As a user, I want to send messages so I can communicate with my team.

Points: 3 | Priority: Must

**STORY-005: Real-time Updates**
As a user, I want to see new messages instantly without refreshing.

Points: 8 | Priority: Must

**STORY-006: Message Threading**
As a user, I want to reply in threads to keep discussions organized.

Points: 5 | Priority: Must

[... continued for all stories]

## Prioritization (MoSCoW)

### Must Have (MVP)
- FR-001: Authentication (basic)
- FR-002: Real-time messaging
- FR-003: Channels and DMs
- FR-004: Code sharing
- FR-006: Notifications (desktop)

### Should Have
- FR-001: 2FA
- FR-005: Search
- FR-006: Mobile notifications
- Voice calls

### Could Have
- Video calls
- Screen sharing
- Custom workflows

### Won't Have (this release)
- Self-hosting
- Mobile apps
- API marketplace

## Summary

- **Total epics:** 6
- **Total stories:** 28
- **Total points:** 142
- **Must-have points:** 89
- **Estimated MVP sprints:** 4 (at 25 pts/sprint)

Saving PRD to: docs/prd.md
```

---

<h3 id="tech-spec">/tech-spec</h3>

Create a lightweight technical specification for Level 0-1 projects. Simpler than a full PRD.

**When to use:** Level 0-1 projects (small features, bug fixes)

**Output:** `docs/tech-spec.md`

**Prerequisite:** `/workflow-init`

#### Example

~~~~
User: /tech-spec

Claude: I'll create a tech spec for your project.

## Feature Overview

What are you building?
> Add password reset functionality to existing auth system

## Requirements

List the core requirements:
> 1. User requests reset via email
> 2. System sends reset link (expires in 1 hour)
> 3. User clicks link and sets new password
> 4. Old sessions are invalidated

## Technical Details

### Files to Modify/Create

1. `src/routes/auth.js` - Add reset endpoints
2. `src/services/email.js` - Reset email template
3. `src/models/PasswordReset.js` - Reset token model
4. `tests/auth.test.js` - Test coverage

### API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | /auth/forgot-password | Request reset email |
| GET | /auth/reset-password/:token | Validate token |
| POST | /auth/reset-password/:token | Set new password |

### Data Model

```javascript
// PasswordReset model
{
  userId: ObjectId,
  token: String (hashed),
  expiresAt: Date,
  used: Boolean
}
```

### Email Template

Subject: "Reset your password"
Body: "Click here to reset: {reset_link}"
Expiration note: "This link expires in 1 hour"

## Acceptance Criteria

- [ ] Request reset with valid email sends reset email
- [ ] Request with invalid email shows generic success (security)
- [ ] Token valid for 1 hour
- [ ] Token can only be used once
- [ ] Password meets strength requirements
- [ ] All existing sessions invalidated after reset
- [ ] Unit tests pass with >80% coverage

## Dependencies

- Existing: nodemailer, bcrypt
- New: none

## Estimated Effort

2-3 points (half day to one day)

Saving tech spec to: docs/tech-spec.md
~~~~

---

<h3 id="create-ux-design">/create-ux-design</h3>

Create UX designs including user flows, wireframes, and design system specifications.

**When to use:** Level 2+ projects with user interfaces

**Output:** `docs/ux-design.md`

**Prerequisite:** `docs/prd.md`

#### Example

~~~~
User: /create-ux-design

Claude: I'll create UX designs for Real-time Chat Application.

Loading: docs/prd.md

## User Personas

### Primary: Sarah - Senior Developer
- 32 years old, remote worker
- Uses Slack, VS Code, GitHub daily
- Frustrated by context switching
- Values keyboard shortcuts and speed

### Secondary: Mike - Engineering Manager
- 45 years old, manages 12 developers
- Needs visibility into team communication
- Cares about security and compliance

## User Flows

### Flow 1: Onboarding
```
Sign Up → Verify Email → Create Workspace → Invite Team → Tutorial → Dashboard
```

### Flow 2: Send Message
```
Open Channel → Type Message → Format (optional) → Send → Confirm Delivery
```

### Flow 3: Code Sharing
```
Type ``` → Select Language → Paste Code → Preview → Send
```

## Information Architecture

```
App
├── Sidebar
│   ├── Workspace Switcher
│   ├── Search
│   ├── Channels
│   │   ├── Public
│   │   └── Private
│   ├── Direct Messages
│   └── Settings
├── Main Content
│   ├── Channel Header
│   ├── Message List
│   └── Message Input
└── Right Panel (contextual)
    ├── Thread View
    ├── User Profile
    └── Channel Info
```

## Wireframes

### Main Chat View
```
┌──────────────────────────────────────────┐
│ [=] Search...                 [@] [⚙️]  │
├────────────┬─────────────────────────────┤
│ # general  │ # general                   │
│ # random   │ ────────────────────────    │
│ # dev      │ Sarah: Hey team, check out  │
│            │ this PR: github.com/...     │
│ DMs        │                             │
│ @ Mike     │ Mike: LGTM! 👍              │
│ @ Alex     │                             │
│            │ Sarah: Thanks! Merging now  │
│            │                             │
│ ────────── │ ────────────────────────    │
│ [+ Add]    │ [📎] Type message... [→]    │
└────────────┴─────────────────────────────┘
```

### Code Snippet
```
┌─────────────────────────────┐
│ javascript               📋 │
├─────────────────────────────┤
│ 1  function greet(name) {   │
│ 2    return `Hello ${name}` │
│ 3  }                        │
└─────────────────────────────┘
```

## Design System

### Colors
```
Primary:    #5865F2 (Blurple)
Success:    #57F287 (Green)
Warning:    #FEE75C (Yellow)
Error:      #ED4245 (Red)
Background: #36393F (Dark)
Surface:    #2F3136 (Darker)
Text:       #DCDDDE (Light)
Muted:      #72767D (Gray)
```

### Typography
```
Headings: Inter, 600
Body:     Inter, 400
Code:     JetBrains Mono, 400

Sizes:
H1: 24px
H2: 20px
H3: 16px
Body: 14px
Small: 12px
```

### Spacing
```
4px  - Icon padding
8px  - Small gaps
12px - Component padding
16px - Section gaps
24px - Large sections
```

### Components

1. **Button**
   - Primary (filled blue)
   - Secondary (outline)
   - Danger (red)
   - Ghost (text only)

2. **Input**
   - Text field
   - Search with icon
   - Message composer

3. **Avatar**
   - Sizes: 24px, 32px, 48px
   - Status indicator (green/yellow/red/gray)

4. **Message**
   - User avatar + name + timestamp
   - Message content
   - Reactions bar
   - Thread indicator

5. **Code Block**
   - Language label
   - Copy button
   - Line numbers
   - Syntax highlighting

## Accessibility (WCAG 2.1 AA)

### Color Contrast
- [x] Text/background: 7.2:1 (AAA)
- [x] Interactive elements: 4.6:1 (AA)

### Keyboard Navigation
- [x] All interactive elements focusable
- [x] Visible focus indicators
- [x] Logical tab order
- [x] Keyboard shortcuts documented

### Screen Readers
- [x] Semantic HTML structure
- [x] ARIA labels for icons
- [x] Live regions for new messages
- [x] Alt text for images

### Motion
- [x] Respects prefers-reduced-motion
- [x] No auto-playing animations

## Responsive Breakpoints

- Mobile: 320px - 767px
- Tablet: 768px - 1023px
- Desktop: 1024px+

Mobile layout: Sidebar as overlay, single column
Tablet: Collapsible sidebar
Desktop: Full three-column layout

Saving UX design to: docs/ux-design.md
~~~~

---

## Phase 3 - Solutioning Commands

<h3 id="architecture">/architecture</h3>

Design the system architecture including components, data models, APIs, and technology choices.

**When to use:** Level 2+ projects after PRD

**Output:** `docs/architecture.md`

**Prerequisite:** `docs/prd.md`

**Subagent Execution:** This command uses parallel subagents to design major system components independently (Auth Service, Data Layer, API Layer, Frontend), ensuring comprehensive coverage of all architectural concerns.

#### Example

See the [System Architect skill documentation](../skills/#system-architect) for a complete architecture example.

---

<h3 id="solutioning-gate-check">/solutioning-gate-check</h3>

Validate that the architecture addresses all requirements from the PRD.

**When to use:** After completing architecture, before sprint planning

**Output:** Status display (no file)

**Prerequisites:** `docs/prd.md`, `docs/architecture.md`

#### Example

```
User: /solutioning-gate-check

Claude: I'll validate your architecture against the PRD.

Loading: docs/prd.md, docs/architecture.md

## Functional Requirements Check

| FR | Description | Addressed | Notes |
|----|-------------|-----------|-------|
| FR-001 | Authentication | ✓ | Auth service, JWT, OAuth |
| FR-002 | Real-time messaging | ✓ | WebSocket service, Redis |
| FR-003 | Channels/DMs | ✓ | Channel service |
| FR-004 | Code sharing | ✓ | Message service + Prism.js |
| FR-005 | Search | ✓ | Elasticsearch |
| FR-006 | Notifications | ✓ | Push service, FCM |

## Non-Functional Requirements Check

| NFR | Requirement | Solution | Status |
|-----|-------------|----------|--------|
| NFR-001 | <200ms messages | WebSocket + Redis PubSub | ✓ |
| NFR-001 | <500ms search | Elasticsearch | ✓ |
| NFR-002 | E2E encryption | Signal protocol | ✓ |
| NFR-003 | 10k users | Horizontal scaling, sharding | ✓ |
| NFR-004 | 99.9% uptime | Multi-AZ, failover | ✓ |

## Gap Analysis

### Addressed
All functional and non-functional requirements have corresponding
architecture components.

### Potential Concerns

1. **Message ordering:** Architecture mentions "eventual consistency"
   but FR-002 requires strict ordering. Consider:
   - Vector clocks for ordering
   - Single leader per channel

2. **Search latency:** Elasticsearch is specified but indexing
   strategy not detailed. Consider:
   - Index message on write vs. async
   - Partial word matching approach

3. **File attachments:** FR-002 mentions file sharing but
   architecture doesn't specify:
   - Storage solution (S3?)
   - CDN for delivery
   - Virus scanning

### Recommendations

1. Add message ordering strategy to architecture
2. Detail Elasticsearch indexing approach
3. Add file attachment subsystem

## Gate Status: CONDITIONAL PASS

Address the 3 concerns above before proceeding to sprint planning.

Would you like me to help update the architecture document?
> Yes

[Updates architecture.md with the missing details]

Re-running gate check...

Gate Status: PASS ✓

Ready for /sprint-planning
```

---

## Phase 4 - Implementation Commands

<h3 id="sprint-planning">/sprint-planning</h3>

Break down the PRD into stories and plan sprint iterations.

**When to use:** After architecture is complete

**Output:** `docs/sprint-status.yaml`, `docs/stories/*.md`

**Prerequisites:** `docs/prd.md`, `docs/architecture.md`

**Subagent Execution:** This command uses parallel subagents to break down epics independently, with each agent creating detailed user stories for its assigned epic. This parallelization handles large backlogs efficiently.

#### Example

See the [Scrum Master skill documentation](../skills/#scrum-master) for a complete sprint planning example.

---

<h3 id="create-story">/create-story</h3>

Create a single user story with acceptance criteria and implementation notes.

**When to use:** Need to add a story outside of sprint planning

**Output:** `docs/stories/STORY-XXX.md`

#### Example

```
User: /create-story

Claude: I'll help create a new user story.

## Story Details

What epic does this belong to?
> Epic 2: Messaging

Story title:
> Message Reactions

As a (user type):
> team member

I want to:
> add emoji reactions to messages

So that:
> I can quickly acknowledge or respond without typing

## Acceptance Criteria

What conditions must be met?
> - Can add any emoji as reaction
> - Multiple users can add same reaction (shows count)
> - Can remove own reaction
> - Reactions show who added them on hover
> - Real-time updates when others react

## Technical Notes

Any implementation considerations?
> - Store reactions in separate collection
> - Index by messageId
> - Broadcast via WebSocket
> - Limit to 20 unique emojis per message

## Estimation

Story points (Fibonacci: 1,2,3,5,8,13):
> 5

Priority (Must/Should/Could):
> Should

## Story Created

```markdown
# STORY-029: Message Reactions

**Epic:** Messaging
**Points:** 5
**Priority:** Should
**Status:** Pending

## User Story
As a team member, I want to add emoji reactions to messages
so that I can quickly acknowledge or respond without typing.

## Acceptance Criteria
- [ ] Can add any emoji as reaction
- [ ] Multiple users can add same reaction (shows count)
- [ ] Can remove own reaction
- [ ] Reactions show who added them on hover
- [ ] Real-time updates when others react

## Technical Notes
- Store reactions in separate collection
- Index by messageId
- Broadcast via WebSocket
- Limit to 20 unique emojis per message

## Implementation
[To be filled during development]
```

Saved to: docs/stories/STORY-029.md
Updated: docs/sprint-status.yaml (added to backlog)
```

---

<h3 id="dev-story">/dev-story</h3>

Implement a user story end-to-end with code and tests.

**When to use:** Ready to implement a story

**Argument:** Story ID (e.g., `/dev-story STORY-004`)

**Output:** Code files, updated story status

**Subagent Execution:** For complex stories spanning multiple components, this command can use parallel subagents to implement backend, frontend, and test code simultaneously.

#### Example

See the [Developer skill documentation](../skills/#developer) for a complete implementation example.

---

## Builder Commands

<h3 id="create-agent">/create-agent</h3>

Create a custom BMAD skill for specialized domains.

**When to use:** Need capabilities not covered by default skills

**Output:** `~/.claude/skills/bmad-skills/custom-{skill-name}/SKILL.md`

#### Example

See the [Builder skill documentation](../skills/#builder) for a complete example.

---

<h3 id="create-workflow">/create-workflow</h3>

Create a custom workflow skill.

**When to use:** Need a specialized workflow for your process

**Output:** Custom skill in `~/.claude/skills/bmad-skills/` directory

#### Example

```
User: /create-workflow

Claude: I'll help create a custom workflow command.

## Workflow Details

Command name (without /):
> security-review

What does this workflow do?
> Reviews code for security vulnerabilities and generates
> a security report

What inputs does it need?
> - Files or directories to review
> - Security checklist to use
> - Output format (markdown/JSON)

What outputs does it produce?
> docs/security-review.md with findings

What skills does it use?
> Custom security-reviewer agent (or Developer)

## Workflow Created

```markdown
# /security-review

## Description
Perform security review of code and generate findings report.

## Usage
/security-review [path] [--checklist=owasp|custom] [--format=md|json]

## Workflow

1. **Load configuration**
   - Per helpers.md#Combined-Config-Load

2. **Identify scope**
   - If path provided, review that path
   - Otherwise, review src/ directory

3. **Load checklist**
   - OWASP Top 10 (default)
   - Or custom checklist from docs/security-checklist.md

4. **Perform review**
   - Static analysis patterns
   - Dependency audit (npm audit)
   - Secret scanning
   - Input validation check

5. **Generate report**
   - Summary of findings
   - Severity levels (Critical/High/Medium/Low)
   - Remediation recommendations
   - Code references

6. **Save output**
   - Save to docs/security-review.md (or .json)
   - Update workflow status

## Example Output

# Security Review Report

**Date:** 2025-01-15
**Scope:** src/
**Checklist:** OWASP Top 10

## Summary
- Critical: 1
- High: 2
- Medium: 5
- Low: 8

## Critical Findings

### SQL-001: SQL Injection
**File:** src/models/user.js:45
**Risk:** Unsanitized user input in query
**Fix:** Use parameterized queries
```

Saved to: ~/.claude/skills/bmad-skills/security-reviewer/SKILL.md

Restart Claude Code to load the new skill.
```

---

## Creative Intelligence Commands

<h3 id="brainstorm">/brainstorm</h3>

Run a structured brainstorming session using multiple techniques.

**When to use:** Starting a project, stuck on a problem, exploring ideas

**Output:** `docs/brainstorm-{topic}.md`

**Subagent Execution:** When using multiple brainstorming techniques, this command can launch parallel subagents to apply different frameworks simultaneously (SCAMPER, Mind Mapping, Six Thinking Hats), providing diverse perspectives.

#### Example

See the [Creative Intelligence skill documentation](../skills/#creative-intelligence) for a complete brainstorming example.

---

<h3 id="research">/research</h3>

Conduct comprehensive research on a topic.

**When to use:** Need market intelligence, competitive analysis, or technical research

**Output:** `docs/research-{topic}.md`

**Research types:**
- Market research
- Competitive analysis
- Technical research
- User research

**Subagent Execution:** This command uses parallel subagents to conduct different research types simultaneously (market trends, competitive landscape, technical feasibility, user needs), gathering comprehensive insights quickly.

#### Example

See the [Creative Intelligence skill documentation](../skills/#creative-intelligence) for a complete research example.

---

## Command Cheatsheet

### Start a New Project
```
/workflow-init
/product-brief      # Level 2+
/prd               # Level 2+
  OR
/tech-spec         # Level 0-1
/architecture      # Level 2+
/sprint-planning
/dev-story STORY-001
```

### Check Status
```
/workflow-status
```

### Research First
```
/brainstorm
/research
/product-brief
```

### Create Custom Tools
```
/create-agent
/create-workflow
```

---

## Next Steps

- See [real-world examples](../examples/) of complete workflows
- Learn about [configuration options](../configuration)
- Check [troubleshooting](../troubleshooting) for common issues
