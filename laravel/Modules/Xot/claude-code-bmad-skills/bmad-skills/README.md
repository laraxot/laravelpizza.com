# BMAD Skills for Claude Code

A comprehensive skill suite implementing the **BMAD Method** (Breakthrough Method for Agile AI-Driven Development) for Claude Code. These skills leverage parallel subagents to maximize context utilization across 200K token windows.

## Quick Start

1. **Install the skills** (see Installation below)
2. **Copy `CLAUDE.md`** to your project root (or use `examples/project-CLAUDE.md` as a template)
3. **Say:** "Initialize BMAD for this project"
4. **Check status:** "What's my BMAD status?"

## Architecture

```
bmad-skills/
├── CLAUDE.md                  # Skill activation guide for Claude
├── SUBAGENT-PATTERNS.md       # Shared subagent architecture patterns
├── examples/
│   └── project-CLAUDE.md      # Template for project CLAUDE.md
├── hooks/                     # Shared hooks for all skills
│   ├── bmad-session-start.sh  # Session initialization
│   ├── bmad-pre-tool.sh       # Pre-tool validation
│   └── bmad-post-tool.sh      # Post-tool tracking
├── shared/                    # Shared templates and utilities
├── bmad-orchestrator/         # Core workflow orchestrator
├── business-analyst/          # Phase 1: Analysis
├── product-manager/           # Phase 2: Planning
├── system-architect/          # Phase 3: Solutioning
├── scrum-master/              # Phase 4: Sprint Planning
├── developer/                 # Phase 4: Implementation
├── ux-designer/               # Cross-phase UX design
├── creative-intelligence/     # Cross-phase research/brainstorming
└── builder/                   # Meta: Create custom skills
```

## Skills Overview

| Skill | Phase | Purpose | Subagent Strategy |
|-------|-------|---------|-------------------|
| **bmad-orchestrator** | All | Project init, status, routing | Parallel status checks |
| **business-analyst** | 1 | Product discovery, research | 4-way parallel research |
| **product-manager** | 2 | PRD, requirements, prioritization | Parallel section generation |
| **system-architect** | 3 | Architecture design | Parallel component design |
| **scrum-master** | 4 | Sprint planning, stories | Parallel epic breakdown |
| **developer** | 4 | Story implementation | Parallel story implementation |
| **ux-designer** | 2-3 | UX design, wireframes, accessibility | Parallel screen design |
| **creative-intelligence** | All | Brainstorming, research | Multi-technique parallel |
| **builder** | N/A | Create custom skills/workflows | Parallel component creation |

## BMAD Method Phases

```
Phase 1: Analysis      → Business Analyst, Creative Intelligence
Phase 2: Planning      → Product Manager, UX Designer
Phase 3: Solutioning   → System Architect, UX Designer
Phase 4: Implementation → Scrum Master, Developer
```

## Project Levels

| Level | Scope | Stories | Required Docs |
|-------|-------|---------|---------------|
| 0 | Single change | 1 | Tech Spec |
| 1 | Small feature | 1-10 | Tech Spec |
| 2 | Medium feature | 5-15 | PRD + Architecture |
| 3 | Complex integration | 12-40 | PRD + Architecture |
| 4 | Enterprise expansion | 40+ | PRD + Architecture |

## Installation

### Personal Installation (User-level)

```bash
# Clone or copy to your Claude skills directory
cp -r bmad-skills/* ~/.claude/skills/
```

### Project Installation (Team-level)

```bash
# Copy to project's .claude directory
cp -r bmad-skills/* .claude/skills/

# Copy the CLAUDE.md to your project root
cp bmad-skills/examples/project-CLAUDE.md ./CLAUDE.md
# Edit CLAUDE.md to customize for your project
```

### Hook Configuration

Add to your Claude Code settings (`~/.claude/settings.json` or `.claude/settings.json`):

```json
{
  "hooks": {
    "SessionStart": [
      {
        "command": "bash ~/.claude/skills/hooks/bmad-session-start.sh"
      }
    ],
    "PreToolUse": [
      {
        "command": "bash ~/.claude/skills/hooks/bmad-pre-tool.sh"
      }
    ],
    "PostToolUse": [
      {
        "command": "bash ~/.claude/skills/hooks/bmad-post-tool.sh"
      }
    ]
  }
}
```

## Usage

### Initialize a BMAD Project

```
> Initialize this project with BMAD

Claude will use bmad-orchestrator to:
1. Create bmad/ directory structure
2. Set up docs/ for outputs
3. Create workflow status tracking
4. Determine project level
```

### Check Workflow Status

```
> What's my BMAD project status?

Shows completed phases, current phase, and recommended next steps.
```

### Execute Phase Workflows

```
Phase 1:
> Create a product brief for this project
> Research the market for [topic]
> Brainstorm features using SCAMPER

Phase 2:
> Create a PRD based on the product brief
> Create a tech spec for this feature
> Prioritize these requirements using RICE

Phase 3:
> Design the system architecture
> Run the solutioning gate check

Phase 4:
> Plan the sprint from the PRD
> Create user story STORY-001
> Implement STORY-001
```

## Subagent Architecture

All BMAD skills leverage parallel subagents for maximum efficiency:

```
┌─────────────────────────────────┐
│     Main Skill Context          │
│     (Orchestration Layer)       │
└───────────────┬─────────────────┘
                │
    ┌───────────┼───────────┐
    ▼           ▼           ▼
┌───────┐   ┌───────┐   ┌───────┐
│Agent 1│   │Agent 2│   │Agent 3│
│ 200K  │   │ 200K  │   │ 200K  │
│tokens │   │tokens │   │tokens │
└───────┘   └───────┘   └───────┘
```

See [SUBAGENT-PATTERNS.md](SUBAGENT-PATTERNS.md) for detailed patterns.

## Skill Structure

Each skill follows the Anthropic Claude Code specification:

```
skill-name/
├── SKILL.md              # Required: Main entry with YAML frontmatter
├── REFERENCE.md          # Optional: Detailed reference material
├── scripts/              # Optional: Executable utilities
│   └── *.sh, *.py
├── templates/            # Optional: Document templates
│   └── *.template.md
└── resources/            # Optional: Reference data
    └── *.md
```

### SKILL.md Format

```yaml
---
name: skill-name
description: Clear description AND when to use it (max 1024 chars)
allowed-tools: Read, Write, Edit, Bash, Glob, Grep, TodoWrite, Task
---

# Skill Name

[Markdown instructions under 5K tokens]
```

## Contributing

1. Follow Anthropic skill specification
2. Include subagent strategy in SKILL.md
3. Use progressive disclosure (Level 1/2/3 loading)
4. Provide scripts for deterministic operations
5. Include templates with {{variable}} substitution

## License

MIT License - See LICENSE file
