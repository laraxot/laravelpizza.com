# OpenViking Integration Guide

## Overview

This guide documents the integration of **OpenViking** (globally installed) with **BMAD**, **GSD**, and **Ralph Loop** for the FixCity platform.

## Installation Status

✅ **OpenViking**: Globally installed at `/home/zorin/.local/bin/openviking` (v0.2.13)

## What is OpenViking?

OpenViking is an AI-powered context management and documentation system that helps maintain project knowledge, architectural decisions, and development context across AI agents and human developers.

### Key Features

- **Context Database**: Centralized project knowledge storage
- **viking:// URIs**: Link to specific project contexts
- **AI Agent Integration**: Seamless handoff between AI agents
- **Documentation Indexing**: Automatic project documentation discovery

## Quick Start

### 1. Initialize OpenViking Context

```bash
cd /var/www/_bases/base_fixcity_fila5
openviking init
```

### 2. Index Project Documentation

```bash
# Index all documentation
openviking index docs/
openviking index laravel/Modules/*/docs/
openviking index laravel/Themes/*/docs/
```

### 3. Add Context Entries

```bash
# Add architectural decision
openviking add --type=adr --title="Module Architecture" --content="..."

# Add project memory
openviking add --type=memory --title="Multi-Agent Collaboration" --content="..."

# Add technical context
openviking add --type=context --title="Filament v5 Migration" --content="..."
```

## Integration with BMAD

### BMAD + OpenViking Workflow

```bash
# 1. BMAD for requirements
/bmad-create-prd

# 2. Store PRD context in OpenViking
openviking add --type=requirement \
  --title="Feature: [Feature Name]" \
  --file="_bmad/bmm/2-plan/prd.json"

# 3. BMAD for architecture
/bmad-create-architecture

# 4. Store architecture decision
openviking add --type=adr \
  --title="Architecture: [Decision Name]" \
  --file="_bmad/bmm/3-solutioning/architecture.md"
```

### Context Linking

Use `viking://` URIs in BMAD documentation:

```markdown
## Related Context

- [PRD Context](viking://requirement/feature-name)
- [Architecture Decision](viking://adr/architecture-name)
- [Technical Context](viking://context/technical-detail)
```

## Integration with GSD

### GSD + OpenViking Workflow

```bash
# 1. Start GSD project
/gsd-new-project FixCity

# 2. Store project context
openviking add --type=project \
  --title="FixCity Platform" \
  --file="PROJECT.md"

# 3. During phase execution
/gsd-discuss-phase 1
/gsd-plan-phase 1

# 4. Store phase decisions
openviking add --type=phase \
  --title="Phase 1: Foundation" \
  --file=".planning/phases/001/PLAN.md"

# 5. Execute and verify
/gsd-execute-phase 1
/gsd-verify-work 1
```

### Phase Context Tracking

```bash
# Before phase execution
openviking add --type=phase-context \
  --title="Phase 1 Pre-Execution State" \
  --content="Current state: [description]"

# After phase completion
openviking add --type=phase-context \
  --title="Phase 1 Post-Execution State" \
  --content="Completed: [description]"
```

## Integration with Ralph Loop

### Ralph Loop Setup

```bash
# Create Ralph directory
mkdir -p .ralph

# Create PRD for Ralph
cat > .ralph/prd.json << 'EOF'
{
  "project": "FixCity",
  "goal": "Implement feature X",
  "stories": [
    {
      "id": "story-1",
      "title": "Story Title",
      "description": "As a user, I want...",
      "acceptance_criteria": ["Criterion 1"]
    }
  ]
}
EOF

# Run Ralph Loop
./.ralph/ralph-loop.sh 20 true
```

### Ralph + OpenViking Integration

```bash
# 1. Store Ralph PRD context
openviking add --type=ralph-prd \
  --title="Ralph PRD: [Feature]" \
  --file=".ralph/prd.json"

# 2. Track Ralph iterations
openviking add --type=ralph-iteration \
  --title="Ralph Iteration 1-20" \
  --content="Stories completed: [list]"

# 3. Store Ralph outcomes
openviking add --type=ralph-outcome \
  --title="Ralph Outcome: [Feature]" \
  --content="Final implementation: [description]"
```

## Unified Workflow: OpenViking + BMAD + GSD + Ralph

### Complete Development Cycle

```bash
# PHASE 1: Requirements (BMAD)
/bmad-create-prd
/bmad-create-architecture

# Store in OpenViking
openviking add --type=requirement --file="_bmad/bmm/2-plan/prd.json"
openviking add --type=adr --file="_bmad/bmm/3-solutioning/architecture.md"

# PHASE 2: Planning (GSD)
/gsd-discuss-phase 1
/gsd-plan-phase 1

# Store in OpenViking
openviking add --type=phase-plan --file=".planning/phases/001/PLAN.md"

# PHASE 3: Implementation (Ralph Loop for autonomous work)
# Convert BMAD PRD to Ralph format
cp _bmad/bmm/2-plan/prd.json .ralph/prd.json

# Run Ralph Loop
./.ralph/ralph-loop.sh 20 true

# Store Ralph outcomes
openviking add --type=implementation --file=".ralph/outcome.md"

# PHASE 4: Verification (GSD)
/gsd-verify-work 1

# Store verification results
openviking add --type=verification --file=".planning/phases/001/VERIFICATION.md"

# PHASE 5: Retrospective (BMAD)
/bmad-retrospective

# Store lessons learned
openviking add --type=retrospective --file="_bmad/bmm/5-retro/retro.md"
```

### Context Flow Diagram

```
┌─────────────┐
│   BMAD      │ Requirements & Architecture
│  (Plan)     │
└──────┬──────┘
       │ Store in OpenViking
       ▼
┌─────────────┐
│  OpenViking │ Central Context Database
│  (Context)  │
└──────┬──────┘
       │ Retrieve Context
       ▼
┌─────────────┐
│    GSD      │ Phase Planning & Execution
│ (Execute)   │
└──────┬──────┘
       │ Delegate to Ralph
       ▼
┌─────────────┐
│   Ralph     │ Autonomous Implementation
│  (Build)    │
└──────┬──────┘
       │ Store Outcomes
       ▼
┌─────────────┐
│  OpenViking │ Complete Project History
│  (History)  │
└─────────────┘
```

## OpenViking Commands Reference

### Initialization

```bash
# Initialize OpenViking in project
openviking init

# Configure project
openviking config set project.name "FixCity"
openviking config set project.version "1.0.0"
```

### Adding Context

```bash
# Add document
openviking add --type=document --title="API Documentation" --file="docs/api.md"

# Add ADR
openviking add --type=adr --title="Database Choice" --content="We chose MySQL because..."

# Add memory
openviking add --type=memory --title="Multi-Agent Setup" --content="Multiple AI agents work..."

# Add requirement
openviking add --type=requirement --title="User Authentication" --file="requirements/auth.md"

# Add technical context
openviking add --type=context --title="Filament Resources" --content="All resources extend..."
```

### Querying Context

```bash
# Search context
openviking search "authentication"

# List by type
openviking list --type=adr
openviking list --type=requirement

# Get specific entry
openviking get viking://adr/database-choice

# Export context
openviking export --format=markdown --output=context-export.md
```

### Indexing

```bash
# Index documentation
openviking index docs/

# Index module docs
openviking index laravel/Modules/*/docs/

# Index theme docs
openviking index laravel/Themes/*/docs/

# Re-index (update)
openviking index --update
```

## Best Practices

### 1. Context Granularity

✅ **DO**: Create focused, specific context entries
```bash
openviking add --type=adr --title="Choice of Spatie Actions" --content="..."
openviking add --type=adr --title="No Services Pattern" --content="..."
```

❌ **DON'T**: Create monolithic entries
```bash
openviking add --type=adr --title="All Architecture" --content="[5000 words]"
```

### 2. Linking Strategy

✅ **DO**: Use viking:// URIs extensively
```markdown
## Related Decisions
- [No Services Pattern](viking://adr/no-services-pattern)
- [Spatie Actions](viking://adr/spatie-actions)
```

❌ **DON'T**: Duplicate content
```markdown
## Related Decisions
[Copy-paste entire ADR text]  # WRONG!
```

### 3. Update Frequency

✅ **DO**: Update context after major milestones
- After BMAD PRD creation
- After GSD phase completion
- After Ralph Loop iterations
- After significant architectural decisions

❌ **DON'T**: Update for every minor change
- Every commit
- Every test run
- Every minor refactor

### 4. Type Usage

| Type | When to Use | Example |
|------|-------------|---------|
| `adr` | Architectural decisions | "Choice of Filament v5" |
| `requirement` | Business requirements | "User must be able to..." |
| `context` | Technical context | "Filament Resource patterns" |
| `memory` | Project memories | "Multi-agent collaboration setup" |
| `phase` | GSD phase info | "Phase 1: Foundation" |
| `ralph-*` | Ralph Loop work | "Ralph PRD", "Ralph outcome" |
| `document` | General docs | "API documentation" |

## Troubleshooting

### OpenViking Not Found

```bash
# Check installation
which openviking

# If not found, check PATH
echo $PATH

# Reinstall if needed
curl -sSL https://openviking.ai/install | bash
```

### Context Not Indexed

```bash
# Verify index
openviking list

# Re-index
openviking index --update docs/

# Check for errors
openviking status
```

### Viking:// URIs Not Working

Ensure OpenViking is initialized:
```bash
openviking init
openviking status
```

## Resources

- **OpenViking Official**: https://openviking.ai/
- **BMAD Method**: https://github.com/bmad-code-org/BMAD-METHOD
- **GSD Documentation**: See `.planning/` directory
- **Ralph Loop**: See `laravel/Modules/Xot/docs/bmad-workflow-guide.md`

## Next Steps

1. ✅ Initialize OpenViking in project
2. ✅ Index existing documentation
3. ✅ Set up Ralph Loop infrastructure
4. ✅ Create unified workflow guide
5. ⏳ Train team on integrated workflow
6. ⏳ Establish context maintenance routine

---

**Last Updated**: 2026-03-30  
**Version**: 1.0.0  
**Status**: Initial Implementation
