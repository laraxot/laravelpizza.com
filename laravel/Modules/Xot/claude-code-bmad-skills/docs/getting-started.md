---
layout: default
title: "Getting Started"
description: "Complete installation guide and first steps for BMAD Method in Claude Code. Learn how to install, configure, and run your first BMAD workflow."
keywords: "BMAD installation, Claude Code setup, agile development setup, BMAD getting started"
---

# Getting Started

This guide will walk you through installing BMAD Method for Claude Code and running your first workflow.

---

## Prerequisites

Before installing BMAD, ensure you have:

- **Claude Code** installed and working ([Installation Guide](https://docs.anthropic.com/en/docs/claude-code))
- **Git** for cloning the repository
- A terminal (Bash for Linux/macOS/WSL, PowerShell for Windows)

---

## Installation

### Step 1: Clone the Repository

```bash
git clone https://github.com/aj-geddes/claude-code-bmad-skills.git
cd claude-code-bmad-skills
```

### Step 2: Install BMAD Skills

BMAD skills are designed to be copied directly to your Claude Code skills directory. Choose your installation type:

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0;" markdown="1">

<div style="background: #f5f5f5; padding: 20px; border-radius: 8px;" markdown="1">

#### User-Level (Personal)

Install skills globally for all your projects:

```bash
# Copy skills package to your user directory
cp -r bmad-skills ~/.claude/skills/bmad-skills
# Make all scripts executable
find ~/.claude/skills/bmad-skills -name "*.sh" -exec chmod +x {} \;
find ~/.claude/skills/bmad-skills -name "*.py" -exec chmod +x {} \;
```

**Directory structure:**
```
~/.claude/
└── skills/
    └── bmad-skills/
        ├── bmad-orchestrator/
        ├── business-analyst/
        ├── product-manager/
        ├── system-architect/
        ├── scrum-master/
        ├── developer/
        ├── ux-designer/
        ├── creative-intelligence/
        ├── builder/
        ├── shared/
        └── hooks/
```

</div>

<div style="background: #f5f5f5; padding: 20px; border-radius: 8px;" markdown="1">

#### Project-Level (Team)

Install skills in a specific project:

```bash
# From the project root
cp -r /path/to/bmad-skills .claude/skills/bmad-skills
find .claude/skills/bmad-skills -name "*.sh" -exec chmod +x {} \;
```

**Directory structure:**
```
project/
└── .claude/
    └── skills/
        └── bmad-skills/
            ├── bmad-orchestrator/
            ├── business-analyst/
            └── ... (all skills)
```

Team members clone the repo with skills included.

</div>

</div>

### Step 3: Configure Settings (Optional)

Add hooks to your Claude Code settings for enhanced functionality:

**Edit:** `~/.claude/settings.json` (user-level) or `.claude/settings.json` (project-level)

```json
{
  "hooks": {
    "SessionStart": [
      {
        "type": "command",
        "command": "bash ~/.claude/skills/bmad-skills/hooks/bmad-session-start.sh"
      }
    ],
    "PreToolUse": [
      {
        "matcher": "",
        "hooks": [
          {
            "type": "command",
            "command": "bash ~/.claude/skills/bmad-skills/hooks/bmad-pre-tool.sh"
          }
        ]
      }
    ],
    "PostToolUse": [
      {
        "matcher": "",
        "hooks": [
          {
            "type": "command",
            "command": "bash ~/.claude/skills/bmad-skills/hooks/bmad-post-tool.sh"
          }
        ]
      }
    ]
  }
}
```

### Step 4: Add CLAUDE.md to Your Project

Copy the CLAUDE.md template to enable skill activation:

```bash
# From your project root
cp /path/to/bmad-skills/examples/project-CLAUDE.md ./CLAUDE.md
```

Edit `CLAUDE.md` to customize for your project.

### Step 5: Restart Claude Code

**Important:** Claude Code loads skills on startup. You must restart it after installation.

```bash
# Close and reopen your terminal, or:
claude  # Start a new Claude Code session
```

### Step 6: Verify Installation

In Claude Code, say:

```
Initialize BMAD for this project
```

If Claude initializes the BMAD directory structure, the skills are installed correctly!

---

## Your First BMAD Project

Let's walk through creating a simple project to understand the BMAD workflow.

### Example: Building a Todo API

We'll create a simple REST API for managing todos. This is a Level 1 project (small, 1-10 stories).

#### Step 1: Initialize BMAD

Navigate to your project directory and start Claude Code:

```bash
mkdir todo-api && cd todo-api
git init
claude
```

Now initialize BMAD:

```
User: Initialize BMAD for this project

Claude: I'll initialize BMAD for your project. Let me gather some information.

What is your project name?
> Todo REST API

What type of project is this?
1. web-app
2. mobile-app
3. api
4. game
5. library
6. other
> 3

Based on the scope, what project level fits best?
- Level 0: Single atomic change (1 story)
- Level 1: Small feature (1-10 stories)
- Level 2: Medium feature set (5-15 stories)
- Level 3: Complex integration (12-40 stories)
- Level 4: Enterprise expansion (40+ stories)
> 1

Created directory structure:
  bmad/
    config.yaml
    context/    (for subagent shared context)
    outputs/    (for subagent results)
  docs/
    bmm-workflow-status.yaml

Project initialized! Say "What's my BMAD status?" to see recommended next steps.
```

#### Step 2: Check Workflow Status

```
User: What's my BMAD status?

Claude: ## Todo REST API - Workflow Status

### Project Info
- Type: api
- Level: 1 (Small feature)
- Output: docs/

### Phase Status

| Phase | Status | Next Action |
|-------|--------|-------------|
| Phase 1 - Analysis | Not started | Optional: Create product brief |
| Phase 2 - Planning | Not started | **Recommended: Create tech spec** |
| Phase 3 - Solutioning | Not started | Waiting for Phase 2 |
| Phase 4 - Implementation | Not started | Waiting for Phase 3 |

### Recommendation
For a Level 1 project, start with "Create a tech spec" to define your API endpoints and data models. Product brief is optional for small projects.
```

#### Step 3: Create Technical Specification

For Level 0-1 projects, we create a tech spec instead of a full PRD:

```
User: Create a tech spec for this API

Claude: I'll help you create a technical specification for the Todo REST API.

## Core Functionality

What are the main features of this API?
> - Create, read, update, delete todos
> - Mark todos as complete/incomplete
> - Filter todos by status
> - Basic authentication

## Data Model

Let me define the Todo model:

```json
{
  "id": "uuid",
  "title": "string",
  "description": "string?",
  "completed": "boolean",
  "created_at": "datetime",
  "updated_at": "datetime",
  "user_id": "uuid"
}
```

Does this look correct?
> Yes, add a due_date field too

Updated model includes due_date: datetime?

## API Endpoints

Based on CRUD operations:

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /todos | List all todos (filterable) |
| POST | /todos | Create a new todo |
| GET | /todos/:id | Get a specific todo |
| PUT | /todos/:id | Update a todo |
| DELETE | /todos/:id | Delete a todo |
| PATCH | /todos/:id/complete | Toggle completion |

## Technology Stack

For a simple REST API, I recommend:
- Runtime: Node.js with Express
- Database: SQLite (simple) or PostgreSQL (scalable)
- Auth: JWT tokens
- Validation: Joi or Zod

Which stack do you prefer?
> Node.js, SQLite, JWT, Zod

## Output

Saving technical specification to: docs/tech-spec.md
Updating workflow status...

Technical specification complete!
Say "What's my status?" to see next steps.
```

#### Step 4: Sprint Planning

Now let's plan the implementation:

```
User: Create a sprint plan for this project

Claude: I'll help plan your sprint for the Todo REST API.

Based on your tech spec, I've identified these stories:

## Epic: Todo API Core

### Stories

1. **Setup project structure and dependencies**
   - Complexity: 2 (Fibonacci)
   - Create Express app, configure SQLite, setup Zod

2. **Implement Todo data model and migrations**
   - Complexity: 3
   - Define schema, create migration scripts

3. **Create CRUD endpoints for todos**
   - Complexity: 5
   - All REST endpoints with validation

4. **Add JWT authentication**
   - Complexity: 5
   - User model, login/register, middleware

5. **Add filtering and pagination**
   - Complexity: 3
   - Query params for status, date, pagination

6. **Write tests and documentation**
   - Complexity: 3
   - Unit tests, API docs

## Sprint Recommendation

Total points: 21
For a single developer, split into 2 sprints:

**Sprint 1 (13 points):** Stories 1, 2, 3
**Sprint 2 (8 points):** Stories 4, 5, 6

Accept this sprint plan?
> Yes

Saving to: docs/sprint-status.yaml
Creating story files...

Sprint plan complete! Say "Implement STORY-001" to start coding.
```

**Note on Subagent Execution:** For complex sprint planning (Level 2+), the scrum-master skill can launch parallel subagents to break down multiple epics simultaneously. Each subagent works independently with its own 200K token context, writing results to `bmad/outputs/` for synthesis.

#### Step 5: Implement a Story

Now let's implement the first story:

```
User: Implement STORY-001

Claude: ## Story: Setup project structure and dependencies

**Complexity:** 2 points
**Status:** In Progress

### Acceptance Criteria
- [ ] Initialize npm project with package.json
- [ ] Install Express, SQLite3, Zod, JWT dependencies
- [ ] Create folder structure (src/routes, src/models, src/middleware)
- [ ] Setup basic Express server with health check
- [ ] Configure environment variables

### Implementation

Let me set up the project structure...

[Claude creates files: package.json, src/index.js, src/routes/health.js, .env.example, etc.]

### Verification

Running the server:
```bash
npm install
npm run dev
```

Testing health check:
```bash
curl http://localhost:3000/health
# {"status":"ok","timestamp":"2025-01-15T10:30:00Z"}
```

All acceptance criteria met.

### Story Complete

Updated: docs/stories/STORY-001.md (status: complete)
Updated: docs/sprint-status.yaml

Next story: Say "Implement STORY-002" to continue.
```

---

## Understanding Subagent Execution

BMAD skills leverage parallel subagents to maximize efficiency and utilize the full 200K token context window available to each agent. This architecture enables complex workflows to be executed faster and more comprehensively.

### How Subagents Work

```
┌─────────────────────────────────┐
│   Main Skill (Orchestrator)    │
│   - Decomposes task             │
│   - Launches parallel agents    │
│   - Synthesizes results         │
└───────────────┬─────────────────┘
                │
    ┌───────────┼───────────┐
    ▼           ▼           ▼
┌───────┐   ┌───────┐   ┌───────┐
│Agent 1│   │Agent 2│   │Agent 3│
│200K   │   │200K   │   │200K   │
│Context│   │Context│   │Context│
└───────┘   └───────┘   └───────┘
    │           │           │
    └───────────┴───────────┘
                │
    ┌───────────▼───────────┐
    │   bmad/outputs/       │
    │   - agent-1-result.md │
    │   - agent-2-result.md │
    │   - agent-3-result.md │
    └───────────────────────┘
```

### When Subagents Are Used

| Skill | Workflow | Subagent Strategy |
|-------|----------|-------------------|
| **business-analyst** | Product brief research | 4-way parallel: market, competitors, technical feasibility, user research |
| **product-manager** | PRD creation | Parallel section generation: each section written independently |
| **system-architect** | Architecture design | Parallel component design: each component designed independently |
| **scrum-master** | Sprint planning | Parallel epic breakdown: multiple epics decomposed simultaneously |
| **developer** | Multiple story implementation | Parallel story implementation: independent stories coded in parallel |

### Context Sharing

Skills coordinate through shared directories:

```
bmad/
├── context/           # Shared context for subagents
│   ├── config.yaml   # Project configuration
│   ├── requirements.md  # Current requirements
│   └── tech-stack.md    # Technical constraints
└── outputs/           # Subagent results
    ├── market-research.md
    ├── competitor-analysis.md
    └── technical-feasibility.md
```

**Example:** When creating a PRD, the product-manager skill:
1. Writes `bmad/context/product-brief.md` with discovery findings
2. Launches 5 parallel subagents, each writing a PRD section
3. Each subagent reads the product brief from context
4. Subagents write to `bmad/outputs/prd-section-*.md`
5. Main agent synthesizes all sections into final PRD

### Requesting Parallel Execution

You can explicitly request parallel execution:

```
User: Research the market, competitors, and technical feasibility in parallel

Claude: I'll launch 3 parallel research agents:
- Agent 1: Market research
- Agent 2: Competitor analysis
- Agent 3: Technical feasibility study

[Launches 3 subagents using Task tool]
[Monitors outputs in bmad/outputs/]
[Synthesizes results into product brief]
```

---

## Understanding Project Levels

BMAD adapts its workflow based on your project's complexity:

### Level 0: Atomic Changes

**Example:** Bug fix, config change, single file update

```
User: Initialize BMAD
> Project: Fix login timeout bug
> Type: other
> Level: 0

User: Create a tech spec
> - Issue: Session expires after 5 minutes
> - Fix: Update SESSION_TIMEOUT to 3600
> - Files: config/auth.js

User: Implement STORY-001
[Claude implements the fix directly]
```

**Required workflow:** Tech Spec → Implementation

### Level 1: Small Features

**Example:** New API endpoint, UI component, utility function

**Required workflow:** Tech Spec → Sprint Planning → Implementation

### Level 2: Medium Features

**Example:** User authentication system, dashboard module, API integration

```
User: Initialize BMAD
> Level: 2

User: Create a product brief    # Optional but recommended
User: Create a PRD               # Required - full requirements
User: Design the architecture    # Required - system design
User: Plan the sprint           # Required - break into sprints
```

**Required workflow:** PRD → Architecture → Sprint Planning → Implementation

**Subagent usage:** At Level 2+, skills automatically use parallel subagents for research, design, and planning phases.

### Level 3-4: Complex/Enterprise

**Example:** Microservice ecosystem, platform rewrite, multi-team project

**Required workflow:** Full BMAD with all phases, possibly including UX design

---

## Common Workflows

### Research-First Approach

Use Creative Intelligence before requirements:

```
User: Brainstorm offline sync strategies using SCAMPER and Six Thinking Hats

Claude: I'll launch parallel brainstorming sessions using different techniques.

Agent 1: 5 Whys analysis
Agent 2: SCAMPER ideation
Agent 3: Six Thinking Hats perspectives

[Comprehensive brainstorming session with parallel execution]

Output saved to: docs/brainstorm-offline-sync.md

User: Research competitive offline-first mobile apps in parallel with technical feasibility

Claude: Launching 2 research agents:
- Agent 1: Competitor analysis
- Agent 2: Technical feasibility study

[Parallel research execution]

Output saved to: docs/research-offline-sync.md

User: Create a product brief
[Now informed by research and brainstorming]
```

### Design-First Approach

Include UX design early:

```
User: Create a product brief
User: Create a PRD
User: Design the UX for all main screens  # Before architecture

Claude: I'll create UX designs for your product.

Based on your PRD, I'll design in parallel:
- Agent 1: User flows
- Agent 2: Wireframes for main screens
- Agent 3: Component library
- Agent 4: Accessibility checklist

[Parallel design execution]

Output saved to: docs/ux-design.md

User: Design the system architecture
[Architecture informed by UX decisions]
```

### Custom Agent Workflow

Create domain-specific agents:

```
User: Create a custom QA Engineer skill

Claude: What type of agent do you want to create?
> QA Engineer

What are the agent's responsibilities?
> - Test plan creation
> - Test case design
> - Bug report writing
> - Coverage analysis

What natural language triggers should activate it?
> "Create test plan", "Generate test cases", "Run coverage report"

Creating custom skill...

Output saved to: ~/.claude/skills/bmad-skills/qa-engineer/SKILL.md

Restart Claude Code to load the new skill.
```

---

## Claude Code Features That Power BMAD

BMAD takes advantage of several Claude Code capabilities you should know about:

| Feature | How BMAD Uses It |
|---------|-----------------|
| **Parallel Subagents** | `general-purpose`, `Explore`, `Plan`, `Bash` types — BMAD uses all four |
| **200K / 1M Context** | Each subagent gets its own context window (Sonnet/Opus 4.6 support 1M) |
| **Hooks** | Session, pre/post-tool hooks track workflow progress automatically |
| **Auto Memory** | Claude Code can save learned patterns to `MEMORY.md` across sessions |
| **Fast Mode** | Toggle `/fast` for faster output (same Opus 4.6 model quality) |
| **Extended Thinking** | Opus 4.6 adaptive reasoning for complex architecture decisions |

---

## Next Steps

Now that you have BMAD installed and understand the basics:

1. **Explore Skills** - Learn what each [BMAD skill](./skills/) can do
2. **Learn Commands** - Master all [workflow commands](./commands/)
3. **See Examples** - Follow [complete project walkthroughs](./examples/)
4. **Customize** - Configure BMAD for your [specific needs](./configuration)

---

## Quick Reference

### Essential Phrases

| Say This | Purpose | When to Use |
|----------|---------|-------------|
| "Initialize BMAD" | Set up project structure | Start of new project |
| "What's my BMAD status?" | Check progress | Anytime |
| "Create a tech spec" | Technical specification | Level 0-1 projects |
| "Create a PRD" | Product requirements | Level 2+ projects |
| "Design the architecture" | System design | Level 2+ projects |
| "Plan the sprint" | Plan iterations | Before implementation |
| "Implement STORY-{id}" | Code a story | During implementation |

### Project Structure

After initialization, your project will have:

```
your-project/
├── CLAUDE.md                # Project configuration and skill triggers
├── bmad/
│   ├── config.yaml         # BMAD configuration
│   ├── context/            # Shared context for subagents
│   │   ├── requirements.md # Current requirements
│   │   └── tech-stack.md   # Technical constraints
│   └── outputs/            # Subagent results
│       ├── research-*.md   # Research outputs
│       └── design-*.md     # Design outputs
└── docs/
    ├── bmm-workflow-status.yaml  # Phase tracking
    ├── sprint-status.yaml        # Sprint tracking (Phase 4)
    ├── tech-spec.md              # or prd.md for Level 2+
    ├── architecture.md           # Level 2+
    └── stories/
        ├── STORY-001.md
        ├── STORY-002.md
        └── ...
```

---

<div style="text-align: center; margin-top: 40px; padding: 20px; background: #e8f4f8; border-radius: 8px;" markdown="1">

**Need help?**

Check the [Troubleshooting Guide](./troubleshooting) or [open an issue](https://github.com/aj-geddes/claude-code-bmad-skills/issues)

</div>
