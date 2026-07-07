---
layout: default
title: "BMAD Configuration Guide - Customize Your Workflow"
description: "Complete guide to configuring BMAD Method for Claude Code. Global settings, project settings, and customization options."
keywords: "BMAD configuration, Claude Code settings, BMAD customization, workflow configuration"
---

# Configuration Guide

BMAD Skills uses a modern configuration system with skill registry, hooks, and project-level settings. This guide covers all configuration options.

---

## Configuration Files

BMAD Skills uses three primary configuration files:

| File | Location | Purpose |
|------|----------|---------|
| Skill Registry | `bmad-skills/settings.json` | Skill definitions and hooks |
| Project Config | `{project}/bmad/config.yaml` | Project-specific settings |
| Workflow Status | `{project}/docs/bmm-workflow-status.yaml` | Progress tracking |

Project settings are created by the `/workflow-init` command and customize behavior for each project.

---

## Skill Registry Configuration

The skill registry (`bmad-skills/settings.json`) defines all available skills and hooks. This file is managed by the BMAD Skills package.

### Structure

```json
{
  "description": "BMAD Skills Configuration for Claude Code",
  "hooks": {
    "SessionStart": [
      {
        "type": "command",
        "command": "bash $SKILL_DIR/hooks/bmad-session-start.sh"
      }
    ],
    "PreToolUse": [
      {
        "matcher": "",
        "hooks": [
          {
            "type": "command",
            "command": "bash $SKILL_DIR/hooks/bmad-pre-tool.sh"
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
            "command": "bash $SKILL_DIR/hooks/bmad-post-tool.sh"
          }
        ]
      }
    ]
  },
  "skills": {
    "bmad-orchestrator": {
      "path": "./bmad-orchestrator",
      "description": "Core BMAD workflow orchestrator"
    },
    "business-analyst": {...},
    "product-manager": {...},
    ...
  }
}
```

### Available Skills

All skills are automatically registered and available:

| Skill | Phase | Purpose |
|-------|-------|---------|
| `bmad-orchestrator` | Core | Workflow initialization and status |
| `business-analyst` | Phase 1 | Product discovery and analysis |
| `product-manager` | Phase 2 | Requirements and planning |
| `system-architect` | Phase 3 | System architecture design |
| `scrum-master` | Phase 4 | Sprint planning |
| `developer` | Phase 4 | Story implementation |
| `ux-designer` | Cross-phase | UX design |
| `creative-intelligence` | Cross-phase | Brainstorming and research |
| `builder` | Meta | Create custom skills |

### SKILL.md Format (Anthropic Specification)

Each skill follows the Anthropic specification with YAML frontmatter:

```yaml
---
name: skill-name           # lowercase, hyphens, max 64 chars
description: |             # max 1024 chars, include trigger words
  What it does AND when to use it. Include trigger
  phrases like "/command" or key actions.
allowed-tools: Read, Write, Edit, Bash, Glob, Grep, TodoWrite
---

# Skill Name

[Markdown content under 5K tokens]
```

**Key Requirements:**
- **name:** lowercase with hyphens, max 64 characters
- **description:** Max 1024 characters, include trigger words for activation
- **allowed-tools:** List of permitted Claude Code tools
- **Content:** Must stay under 5K tokens total
- **REFERENCE.md:** Optional file for detailed documentation that won't count against token limit

---

## Hooks Configuration

BMAD Skills uses hooks to integrate with Claude Code's lifecycle events. Hooks are defined in `settings.json` and executed automatically.

### Hook Events Reference

The current Claude Code hook system supports the following events:

| Event | When it Fires | Can Block? |
|-------|--------------|-----------|
| `SessionStart` | Session begins or resumes | No |
| `UserPromptSubmit` | User submits a prompt | Yes |
| `PreToolUse` | Before any tool executes | Yes |
| `PostToolUse` | After a tool completes | No |
| `SubagentStart` | Subagent spawned | No |
| `SubagentStop` | Subagent completes | Yes |
| `TaskCompleted` | Task marked complete | Yes |
| `Stop` | Claude finishes responding | Yes |
| `PreCompact` | Before context compaction | No |
| `SessionEnd` | Session terminates | No |

BMAD uses three of these:

### SessionStart Hook

Executed when a new Claude Code session starts. Loads BMAD environment variables and project context.

**File:** `bmad-skills/hooks/bmad-session-start.sh`

**Actions:**
- Detects if current directory is a BMAD project (checks for `bmad/config.yaml`)
- Sets environment variables:
  - `BMAD_PROJECT=true/false`
  - `BMAD_PROJECT_NAME` - from config.yaml
  - `BMAD_PROJECT_LEVEL` - project complexity level (0-4)
  - `BMAD_OUTPUT_FOLDER` - where documents are written
  - `BMAD_SESSION_START` - timestamp
- Makes project context available to all skills

### PreToolUse Hook

Executed before any tool is used. Validates and logs tool usage. Uses `matcher` field to optionally filter by tool name.

**File:** `bmad-skills/hooks/bmad-pre-tool.sh`

**Actions:**
- Detects writes to BMAD-managed paths (`/docs/`, `/bmad/`)
- Logs subagent launches when Task tool is used
- Provides context for workflow tracking

### PostToolUse Hook

Executed after a tool completes. Tracks workflow progress.

**File:** `bmad-skills/hooks/bmad-post-tool.sh`

**Actions:**
- Detects document creation:
  - Product Brief - Phase 1 progress
  - PRD/Tech Spec - Phase 2 progress
  - Architecture - Phase 3 progress
  - Sprint docs - Phase 4 progress
  - User Stories - Phase 4 progress
- Logs subagent task completion
- Updates workflow tracking metadata

**Example Hook Output:**
```
BMAD: Writing to BMAD-managed path: /project/docs/prd-myapp-2025-01-15.md
BMAD: PRD created - Phase 2 (Planning) progress
```

---

## Project Configuration

Project config is created by `/workflow-init` at `{project}/bmad/config.yaml`.

### Full Configuration

```yaml
# BMAD Project Configuration
# Generated by bmad-orchestrator skill

project:
  name: "My Project"
  type: "web-app"  # web-app, mobile-app, api, game, library, cli, other
  level: 2         # 0-4: see level definitions below
  description: "Brief project description"

# Project Levels:
# 0: Single atomic change (1 story)
# 1: Small feature (1-10 stories)
# 2: Medium feature set (5-15 stories)
# 3: Complex integration (12-40 stories)
# 4: Enterprise expansion (40+ stories)

paths:
  output_folder: "docs"
  stories_folder: "docs/stories"
  status_file: "docs/bmm-workflow-status.yaml"
  sprint_file: "docs/sprint-status.yaml"

workflow:
  # Phase requirements based on project level
  phase_1_analysis:
    product_brief: "recommended"  # required, recommended, optional, skip
    research: "optional"
    brainstorm: "optional"

  phase_2_planning:
    prd: "required"        # required for level 2+, recommended for level 1
    tech_spec: "optional"  # required for level 0-1
    ux_design: "recommended"

  phase_3_solutioning:
    architecture: "required"  # required for level 2+
    gate_check: "recommended"

  phase_4_implementation:
    sprint_planning: "required"
    stories: "required"

subagents:
  # Subagent configuration for parallel execution
  max_parallel: 4
  default_type: "general-purpose"

  # Skill-specific subagent allocations
  research_agents: 4
  section_agents: 4
  component_agents: 4
  story_agents: 4

metadata:
  created: "2025-01-15T10:00:00Z"
  bmad_version: "7.0.0"
  last_updated: "2025-01-15T10:00:00Z"
```

### Project Level Details

The project level determines which workflows are required:

| Level | Scope | Stories | Required Docs |
|-------|-------|---------|---------------|
| 0 | Single atomic change | 1 | Tech Spec only |
| 1 | Small feature | 1-10 | Tech Spec + Sprint Planning |
| 2 | Medium feature set | 5-15 | PRD + Architecture + Sprint Planning |
| 3 | Complex integration | 12-40 | PRD + Architecture + Sprint Planning |
| 4 | Enterprise expansion | 40+ | PRD + Architecture + Sprint Planning + UX |

**Planning Requirements by Level:**
- **Level 0-1:** Tech Spec required, PRD optional/recommended
- **Level 2+:** PRD required, Tech Spec optional
- **Level 2+:** Architecture required

### Project Directory Structure

After initialization, your project will have:

```
your-project/
├── bmad/
│   ├── config.yaml          # Project configuration
│   ├── context/             # Shared context for subagents
│   └── outputs/             # Subagent output files
├── docs/
│   ├── bmm-workflow-status.yaml  # Workflow progress tracking
│   ├── sprint-status.yaml        # Sprint tracking (Phase 4)
│   ├── stories/                  # User story documents
│   ├── product-brief-*.md        # Phase 1 outputs
│   ├── prd-*.md                  # Phase 2 outputs
│   ├── tech-spec-*.md            # Phase 2 outputs
│   └── architecture-*.md         # Phase 3 outputs
└── .claude/
    └── commands/bmad/            # Project-specific commands
```

**Key Directories:**
- **bmad/context/**: Shared context files for parallel subagents to coordinate
- **bmad/outputs/**: Individual subagent output files before synthesis
- **docs/stories/**: Finalized user story documents (STORY-001.md, etc.)

### Customizing Paths

Change where BMAD writes files:

```yaml
paths:
  output_folder: "documentation"
  stories_folder: "documentation/user-stories"
  status_file: "documentation/workflow-status.yaml"
  sprint_file: "documentation/sprint-status.yaml"
```

---

## Subagent Configuration

BMAD Skills leverage parallel subagents to maximize the 200K token context window per agent. Configure subagent behavior in `bmad/config.yaml`.

### Configuration Options

```yaml
subagents:
  # Maximum parallel agents to launch
  max_parallel: 4

  # Default agent type: general-purpose, Explore, Plan, Bash
  default_type: "general-purpose"

  # Skill-specific allocations
  research_agents: 4      # For creative-intelligence research
  section_agents: 4       # For document section generation
  component_agents: 4     # For architecture components
  story_agents: 4         # For parallel story creation
```

### Parallel Execution Patterns

**Fan-Out Research Pattern:**
- Launch 4 agents to research different topics simultaneously
- Each writes findings to `bmad/outputs/research-{topic}.md`
- Main context synthesizes into final document

**Parallel Section Generation:**
- Launch 4 agents to write document sections in parallel
- Each gets shared context from `bmad/context/shared-context.md`
- Outputs merged into final document

**Component-Based Architecture:**
- Launch agents for each system component
- Each defines one component independently
- Synthesize into unified architecture

### Context Sharing

Subagents coordinate via shared files:

**Input Context:** `bmad/context/`
- `shared-context.md` - Common requirements all agents need
- `requirements.yaml` - Structured requirements data
- `constraints.md` - Technical constraints

**Output Files:** `bmad/outputs/`
- `agent-1-output.md` - Individual agent results
- `agent-2-output.md`
- `synthesis.md` - Combined final result

**Example:**
```yaml
# Agent 1 reads:
bmad/context/shared-context.md  # Project overview
bmad/context/requirements.yaml  # What to build

# Agent 1 writes:
bmad/outputs/authentication-component.md

# Main context synthesizes all outputs
```

### Adjusting Agent Count

For smaller projects or faster iteration:

```yaml
subagents:
  max_parallel: 2          # Use 2 agents instead of 4
  research_agents: 2
  section_agents: 2
```

For maximum throughput on complex projects:

```yaml
subagents:
  max_parallel: 6          # Use up to 6 parallel agents
  research_agents: 6
  section_agents: 6
```

---

## Advanced Configuration

### Multiple Projects with Different Settings

You can have different settings per project by modifying each project's `bmad/config.yaml`:

**Project A (complex enterprise project):**
```yaml
project:
  level: 4
workflow:
  phase_2_planning:
    prd: "required"
    tech_spec: "required"
    ux_design: "required"
subagents:
  max_parallel: 6
```

**Project B (fast iteration):**
```yaml
project:
  level: 1
workflow:
  phase_2_planning:
    tech_spec: "required"
    prd: "skip"
subagents:
  max_parallel: 2
```

### Team Configuration

For teams, consider:

1. **Project config in git** - Version-controlled project settings
2. **Shared subagent patterns** - Consistent parallel execution approach
3. **Custom skills in repo** - Share custom BMAD skills via repository

**Example: Add project config to git**

```bash
# Add to version control
git add bmad/config.yaml
git add bmad/context/
git commit -m "Add BMAD project configuration and shared context"
```

### Workflow Customization

Adjust workflow requirements per project needs:

```yaml
workflow:
  phase_1_analysis:
    product_brief: "skip"      # Skip if requirements are clear
    research: "required"       # But require research

  phase_2_planning:
    prd: "required"
    tech_spec: "required"      # Require both for complex projects
    ux_design: "required"

  phase_3_solutioning:
    architecture: "required"
    gate_check: "required"     # Add mandatory gate checks
```

---

## File Locations Reference

### BMAD Skills Package Structure

```
bmad-skills/
├── settings.json                # Skill registry and hooks
├── CLAUDE.md                    # User-facing activation guide
├── SUBAGENT-PATTERNS.md         # Subagent architecture patterns
├── hooks/                       # Lifecycle hooks
│   ├── bmad-session-start.sh
│   ├── bmad-pre-tool.sh
│   └── bmad-post-tool.sh
├── bmad-orchestrator/           # Core orchestrator
│   ├── SKILL.md
│   ├── REFERENCE.md
│   ├── scripts/
│   ├── templates/
│   └── resources/
├── business-analyst/            # Phase 1 skill
│   ├── SKILL.md
│   └── ...
├── product-manager/             # Phase 2 skill
├── system-architect/            # Phase 3 skill
├── scrum-master/                # Phase 4 skill
├── developer/                   # Phase 4 skill
├── ux-designer/                 # Cross-phase skill
├── creative-intelligence/       # Cross-phase skill
├── builder/                     # Meta skill
├── shared/                      # Shared utilities
│   ├── config.template.yaml
│   └── helpers.md
└── examples/                    # Example templates
```

### After Project Init

```
your-project/
├── bmad/
│   ├── config.yaml              # Project configuration
│   ├── context/                 # Shared subagent context
│   │   ├── shared-context.md
│   │   ├── requirements.yaml
│   │   └── constraints.md
│   └── outputs/                 # Subagent outputs
│       ├── agent-1-output.md
│       ├── agent-2-output.md
│       └── synthesis.md
├── docs/
│   ├── bmm-workflow-status.yaml # Workflow status
│   ├── sprint-status.yaml       # Sprint tracking
│   ├── product-brief-*.md       # Phase 1 outputs
│   ├── prd-*.md                 # Phase 2 outputs
│   ├── tech-spec-*.md           # Phase 2 outputs
│   ├── architecture-*.md        # Phase 3 outputs
│   └── stories/                 # User stories
│       ├── STORY-001.md
│       ├── STORY-002.md
│       └── ...
└── .claude/
    └── commands/bmad/           # Project-specific commands
```

---

## Skill Templates and Resources

Each BMAD skill contains its own templates and resources in its directory.

### Template Location

Templates are located within each skill:

```
bmad-skills/
├── bmad-orchestrator/templates/
│   └── config.template.yaml
├── business-analyst/templates/
│   └── product-brief.template.md
├── product-manager/templates/
│   ├── prd.template.md
│   └── tech-spec.template.md
├── system-architect/templates/
│   └── architecture.template.md
└── shared/
    ├── config.template.yaml
    └── helpers.md
```

### Template Variables

Templates use `{{variable}}` placeholders:

| Variable | Description |
|----------|-------------|
| `{{project_name}}` | Project name from config |
| `{{project_type}}` | Project type (web-app, api, etc.) |
| `{{project_level}}` | Project level (0-4) |
| `{{date}}` | Current date |
| `{{timestamp}}` | Current timestamp |
| `{{product_brief_status}}` | Workflow status value |

### Shared Helpers

The shared helpers file (`bmad-skills/shared/helpers.md`) contains reusable patterns:

- **Config Operations** - Loading and merging configs
- **Status Operations** - Updating workflow status
- **Template Operations** - Processing templates
- **Path Resolution** - Finding files
- **Workflow Recommendations** - Next step logic

---

## Validation and Troubleshooting

### YAML Validation

Use the builder skill to validate configuration:

```bash
# Validate project config
bash bmad-skills/builder/scripts/validate-config.sh bmad/config.yaml

# Validate workflow status
bash bmad-skills/builder/scripts/validate-config.sh docs/bmm-workflow-status.yaml
```

### Common YAML Issues

**Invalid indentation:**
```yaml
# Wrong (tabs or 4 spaces)
project:
    name: "MyApp"

# Correct (2 spaces)
project:
  name: "MyApp"
```

**Missing quotes for special characters:**
```yaml
# Wrong
description: Project with: colons

# Correct
description: "Project with: colons"
```

**Incorrect list syntax:**
```yaml
# Wrong
allowed-tools: Read, Write, Edit

# Correct
allowed-tools:
  - Read
  - Write
  - Edit
```

---

## Troubleshooting Configuration

### Config Not Loading

**Symptoms:** Commands don't recognize your settings

**Fixes:**
1. Verify `bmad/config.yaml` exists in project root
2. Validate YAML syntax with validation script
3. Check for required fields: `project`, `paths`, `workflow`
4. Review hook output for environment variable issues

### Hook Not Executing

**Symptoms:** Environment variables not set, no hook output

**Fixes:**
1. Verify hooks are executable: `chmod +x bmad-skills/hooks/*.sh`
2. Check `settings.json` has correct hook paths
3. Review `$SKILL_DIR` environment variable is set
4. Test hook manually: `bash bmad-skills/hooks/bmad-session-start.sh`

### Invalid YAML

**Symptoms:** "YAML parse error" messages

**Fixes:**
1. Check indentation (use 2 spaces, not tabs)
2. Quote strings with special characters
3. Use online YAML validator (yamllint.com)
4. Run validation script: `bash bmad-skills/builder/scripts/validate-config.sh`

### Settings Not Applied

**Symptoms:** Workflow requirements not respected

**Fixes:**
1. Verify correct project level is set
2. Check workflow status file matches project level
3. Ensure bmad-orchestrator reads config correctly
4. Review workflow section in config.yaml

### Subagents Not Launching

**Symptoms:** Parallel execution not happening

**Fixes:**
1. Check `max_parallel` is set in config
2. Verify Task tool is available
3. Review subagent output in `bmad/outputs/`
4. Check context files exist in `bmad/context/`

---

## Best Practices

### 1. Version Control Project Config

```bash
git add bmad/config.yaml
git add docs/bmm-workflow-status.yaml
git commit -m "Add BMAD project configuration"
```

This ensures team members have consistent project settings and can track workflow progress.

### 2. Use Project Level Appropriately

Match project level to actual complexity:
- Bug fix or small change → Level 0
- Single feature → Level 1
- Feature set → Level 2
- System integration → Level 3
- Major expansion → Level 4

Don't over-plan small projects or under-plan large ones.

### 3. Configure Subagents Based on Complexity

Adjust parallel agent count to match project needs:
- Simple projects → 2 agents
- Standard projects → 4 agents
- Complex projects → 6 agents

More agents = more context but requires coordination.

### 4. Use Context Directory for Coordination

When using subagents, always:
1. Write shared context to `bmad/context/`
2. Each agent reads shared context
3. Each agent writes to `bmad/outputs/`
4. Main context synthesizes results

### 5. Keep SKILL.md Under 5K Tokens

When creating custom skills:
- Use SKILL.md for core instructions (under 5K tokens)
- Put detailed reference in REFERENCE.md (unlimited)
- This ensures fast skill loading

### 6. Update Workflow Status Regularly

After completing each workflow, update status file:
```yaml
phase_2_planning:
  prd: "docs/prd-myapp-2025-01-15.md"  # Mark complete with path
```

This enables accurate `/status` reporting.

---

## Quick Reference

### Essential Configuration Tasks

**Initialize BMAD in a project:**
```bash
# In your project directory
/workflow-init
```

**Check workflow status:**
```bash
/workflow-status
# or
/status
```

**Change project level:**
```yaml
# bmad/config.yaml
project:
  level: 3  # Update to match complexity
```

**Configure subagents:**
```yaml
# bmad/config.yaml
subagents:
  max_parallel: 6
  research_agents: 6
  section_agents: 6
```

**Customize output paths:**
```yaml
# bmad/config.yaml
paths:
  output_folder: "documentation"
  stories_folder: "documentation/stories"
```

**Adjust workflow requirements:**
```yaml
# bmad/config.yaml
workflow:
  phase_2_planning:
    prd: "required"
    tech_spec: "required"
    ux_design: "recommended"
```

### Configuration File Locations

| File | Purpose | When to Edit |
|------|---------|--------------|
| `bmad-skills/settings.json` | Skill registry | Rarely (managed by package) |
| `bmad/config.yaml` | Project settings | At initialization, as needs change |
| `docs/bmm-workflow-status.yaml` | Progress tracking | Updated by workflows automatically |

### Validation Commands

```bash
# Validate project config
bash bmad-skills/builder/scripts/validate-config.sh bmad/config.yaml

# Check hooks are executable
ls -la bmad-skills/hooks/

# Test session start hook
bash bmad-skills/hooks/bmad-session-start.sh
```

---

## Next Steps

- Review [Troubleshooting](./troubleshooting) for common issues
- See [Examples](./examples/) for configuration in action
- Learn about [Subagent Patterns](./subagent-patterns)
- Return to [Getting Started](./getting-started) for setup
