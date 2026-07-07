---
layout: default
title: "BMAD Method for Claude Code - AI-Powered Agile Development"
description: "Transform Claude Code into a complete agile development environment with native skills, commands, and workflows. A Claude Code native conversion of the BMAD Method."
keywords: "Claude Code, BMAD Method, agile development, AI development, Claude skills, AI pair programming"
---

<div class="hero-section" markdown="1">

# BMAD Method for Claude Code

<p class="hero-subtitle">A complete agile development methodology converted to Claude Code native features</p>

<div class="badges">
<a href="https://github.com/aj-geddes/claude-code-bmad-skills/releases"><img src="https://img.shields.io/badge/version-7.1.0-blue.svg" alt="Version" /></a>
<a href="https://github.com/aj-geddes/claude-code-bmad-skills/blob/main/LICENSE"><img src="https://img.shields.io/badge/license-MIT-green.svg" alt="License" /></a>
<a href="#installation"><img src="https://img.shields.io/badge/platform-Windows%20%7C%20macOS%20%7C%20Linux-lightgrey.svg" alt="Platform" /></a>
</div>

</div>

---

## Attribution & Credits

<div class="attribution-box" markdown="1">

**This project is a Claude Code native conversion of the BMAD Method.**

The original **BMAD Method** was created by the [BMAD Code Organization](https://github.com/bmad-code-org/BMAD-METHOD). All credit for the underlying methodology, workflow concepts, and agile framework goes to the original creators.

This conversion adapts the BMAD Method to work natively with Claude Code's skills, commands, and configuration system, making it seamlessly integrated into the Claude Code development experience.

**Original BMAD Method Repository:** [github.com/bmad-code-org/BMAD-METHOD](https://github.com/bmad-code-org/BMAD-METHOD)

</div>

---

## What is BMAD Method for Claude Code?

BMAD (Business Methodology for AI Development) transforms Claude Code into a full-featured agile development environment. Instead of using external tools or complex setups, everything works through Claude Code's native features:

- **9 Specialized Skills** - AI agents for different roles (Analyst, PM, Architect, Developer, etc.)
- **4 Development Phases** - Analysis → Planning → Solutioning → Implementation
- **Subagent Architecture** - Parallel execution with 200K token context per agent
- **Token-Optimized** - Progressive disclosure and efficient context management

### Key Benefits

| Feature | Description |
|---------|-------------|
| **Native Integration** | Uses Claude Code's built-in skills system |
| **Parallel Subagents** | Execute complex workflows using parallel agents, each with 200K token context (1M context available on Sonnet/Opus 4.6) |
| **4 Subagent Types** | `general-purpose`, `Explore` (Haiku, fast), `Plan`, and `Bash` for right-sized execution |
| **Complete Workflow** | From product brief to deployed code |
| **Right-Sized Planning** | 5 project levels from single changes to enterprise systems |
| **Cross-Platform** | Works on Windows, macOS, Linux, and WSL |
| **No Dependencies** | Pure Claude Code - no npm, Python, or external tools |

---

## Quick Start

### For LLMs (Claude Code)

```
1. Say "Initialize BMAD for this project" to activate bmad-orchestrator
2. Say "What's my BMAD status?" to check workflow progress
3. Follow the phase-appropriate skill workflows
```

### For Humans

1. **Install BMAD Skills:**
   ```bash
   # Clone the repository
   git clone https://github.com/aj-geddes/claude-code-bmad-skills.git
   cd claude-code-bmad-skills

   # Copy skills to Claude Code directory
   cp -r bmad-skills ~/.claude/skills/bmad-skills
   find ~/.claude/skills/bmad-skills -name "*.sh" -exec chmod +x {} \;
   ```

2. **Restart Claude Code** (skills load on startup)

3. **Initialize in your project:**
   ```
   Say: "Initialize BMAD for this project"

   This creates:
   - bmad/config.yaml (project configuration)
   - bmad/context/ (shared subagent context)
   - bmad/outputs/ (subagent outputs)
   - docs/ (workflow outputs)
   ```

---

## The Four Phases

### Phase 1: Analysis
**Skills:** business-analyst, creative-intelligence
**Say:** "Create a product brief" or "Research the market for [topic]"

Discover requirements, research markets, and define the problem space. Uses parallel subagents for market/competitive/technical/user research.

### Phase 2: Planning
**Skills:** product-manager, ux-designer
**Say:** "Create a PRD" or "Create UX design"

Create comprehensive requirements and design documents. Parallel section generation for efficient PRD creation.

### Phase 3: Solutioning
**Skills:** system-architect, ux-designer
**Say:** "Design the system architecture" or "Run solutioning gate check"

Design system architecture and validate against requirements. Parallel component design with integration architecture.

### Phase 4: Implementation
**Skills:** scrum-master, developer
**Say:** "Plan the sprint" or "Implement STORY-001"

Plan sprints, create stories, and implement features. Parallel story implementation for independent tasks.

---

## Documentation

<div class="docs-grid">

<div class="docs-card">
<h3><a href="./getting-started">Getting Started</a></h3>
<p>Installation, first steps, and your first BMAD project.</p>
</div>

<div class="docs-card">
<h3><a href="./skills/">Skills Reference</a></h3>
<p>Detailed documentation for all 9 BMAD skills.</p>
</div>

<div class="docs-card">
<h3><a href="./commands/">Commands Reference</a></h3>
<p>Complete guide to all 15 workflow commands.</p>
</div>

<div class="docs-card">
<h3><a href="./subagent-patterns">Subagent Patterns</a></h3>
<p>Learn how BMAD leverages parallel subagents for maximum efficiency.</p>
</div>

<div class="docs-card">
<h3><a href="./examples/">Examples</a></h3>
<p>Real-world examples and complete workflow walkthroughs.</p>
</div>

<div class="docs-card">
<h3><a href="./configuration">Configuration</a></h3>
<p>Customize BMAD for your needs.</p>
</div>

<div class="docs-card">
<h3><a href="./troubleshooting">Troubleshooting</a></h3>
<p>Common issues and solutions.</p>
</div>

</div>

---

## Example Session

Here's what a typical BMAD session looks like:

```markdown
User: I want to build a task management app

Claude: I'll help you build that! Let me initialize BMAD in your project.

[bmad-orchestrator skill activates]

Created:
- bmad/config.yaml (Project: Task Management App, Level: 2, Type: web-app)
- bmad/context/ (shared subagent context)
- bmad/outputs/ (subagent outputs)
- docs/ (workflow documentation)

Project initialized as Level 2 (Medium feature set).

Recommended next step: Create a product brief to define scope and goals.

User: Create a product brief

Claude: [business-analyst skill activates]

I'll create a comprehensive product brief using parallel research agents.

Launching subagents:
- Agent 1: Market research
- Agent 2: Competitive analysis
- Agent 3: Technical feasibility
- Agent 4: User needs analysis

[After parallel execution]

Output saved to: docs/product-brief-[timestamp].md

Phase 1 complete. Ready for Phase 2 (Planning).

User: What's my BMAD status?

Claude: [bmad-orchestrator skill activates]

Phase 1 - Analysis: Complete ✓
Phase 2 - Planning: Not started

Recommended: Create a PRD (for Level 2+ projects)

User: Create a PRD

Claude: [product-manager skill activates]

I'll create your PRD using parallel section generation...

[Parallel agents generate FR, NFR, Epics, and Stories sections]

Output saved to: docs/prd-[timestamp].md
...
```

---

## Project Levels

BMAD right-sizes your planning based on project complexity:

| Level | Name | Stories | Example | Required Docs |
|-------|------|---------|---------|---------------|
| 0 | Atomic | 1 | Bug fix | Tech Spec only |
| 1 | Small | 1-10 | Single feature | Tech Spec only |
| 2 | Medium | 5-15 | Feature set | PRD + Architecture |
| 3 | Complex | 12-40 | System integration | Full workflow |
| 4 | Enterprise | 40+ | Platform expansion | Full workflow + UX |

---

## Skills Overview

| Skill | Phase | Purpose | Subagent Strategy |
|-------|-------|---------|-------------------|
| [bmad-orchestrator](./skills/#bmad-orchestrator) | All | Orchestration and routing | Parallel status checks |
| [business-analyst](./skills/#business-analyst) | 1 | Requirements discovery | 4-way parallel research |
| [product-manager](./skills/#product-manager) | 2 | PRD and planning | Parallel section generation |
| [ux-designer](./skills/#ux-designer) | 2-3 | Interface design | Parallel screen design |
| [system-architect](./skills/#system-architect) | 3 | Technical architecture | Parallel component design |
| [scrum-master](./skills/#scrum-master) | 4 | Sprint planning | Parallel epic breakdown |
| [developer](./skills/#developer) | 4 | Implementation | Parallel story implementation |
| [creative-intelligence](./skills/#creative-intelligence) | Any | Brainstorming/research | Multi-technique parallel |
| [builder](./skills/#builder) | N/A | Custom skills/workflows | Parallel component creation |

---

## Why Claude Code Native?

Traditional development methodologies require:
- Separate project management tools
- Multiple documentation systems
- Context switching between tools
- Manual status tracking

BMAD Skills provides:
- **Single Interface** - Everything in your terminal through natural language
- **Parallel Execution** - Subagents with 200K tokens each for massive parallelization
- **Persistent Context** - Shared context via bmad/context/ for agent coordination
- **Intelligent Routing** - Automatic skill activation based on user intent
- **Token Efficiency** - Progressive disclosure and efficient context management

---

## Community & Support

- **GitHub Issues:** [Report bugs or request features](https://github.com/aj-geddes/claude-code-bmad-skills/issues)
- **Contributing:** See [CONTRIBUTING.md](https://github.com/aj-geddes/claude-code-bmad-skills/blob/main/CONTRIBUTING.md)
- **License:** MIT

---

## Version History

| Version | Date | Changes |
|---------|------|---------|
| 7.1.0 | 2026-02-22 | Updated for Claude Sonnet/Opus 4.6; correct hook format with `type` field and matcher structure; added Bash subagent type; 1M context window notes; worktree isolation docs; new hook events reference |
| 7.0.0 | 2025-12-09 | bmad-skills architecture with subagent patterns |
| 6.0.3 | 2025-11-12 | PowerShell WSL fixes |
| 6.0.2 | 2025-11-12 | Added slash commands installation |
| 6.0.1 | 2025-11-12 | PowerShell installer rewrite |
| 6.0.0 | 2025-11-01 | Initial Claude Code native release |

---

<div class="cta-section">
<p>Ready to transform your development workflow?</p>
<a href="./getting-started">Get Started</a>
</div>
