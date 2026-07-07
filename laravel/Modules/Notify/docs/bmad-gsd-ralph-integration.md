# BMAD + GSD + Ralph Loop Integration Guide

## Overview

This guide describes how to integrate **BMAD** (requirements & architecture), **GSD** (planning & execution), and **Ralph Loop** (autonomous implementation) for the FixCity platform.

## Methodology Comparison

| Aspect | BMAD | GSD | Ralph Loop |
|--------|------|-----|------------|
| **Purpose** | Requirements & Architecture | Planning & Execution | Autonomous Implementation |
| **Best For** | Complex features, system design | Structured development, phase tracking | Rapid prototyping, iterative development |
| **Output** | PRD, Architecture, Stories | Plans, Executions, Verifications | Code implementations |
| **Human Involvement** | High (review & approval) | Medium (phase gates) | Low (autonomous) |
| **Iteration Speed** | Slow (deliberate) | Medium (structured) | Fast (autonomous) |

## When to Use What

### Use BMAD When:
- ✅ Defining new product features
- ✅ Creating architectural decisions
- ✅ Complex requirements need analysis
- ✅ Stakeholder alignment needed
- ✅ Large epics need breakdown

### Use GSD When:
- ✅ Executing planned phases
- ✅ Need structured progress tracking
- ✅ Phase gates and verification required
- ✅ Multi-phase projects
- ✅ Need atomic commits with state tracking

### Use Ralph Loop When:
- ✅ Rapid prototyping needed
- ✅ Stories are well-defined
- ✅ Autonomous iteration beneficial
- ✅ Quick implementation cycles
- ✅ Testing multiple approaches

## Integrated Workflow: BMAD → GSD → Ralph

### Phase 1: Requirements & Architecture (BMAD)

```bash
# Step 1: Create PRD
/bmad-create-prd

# This creates:
# - _bmad/bmm/2-plan/prd.json
# - Product requirements
# - User stories

# Step 2: Create Architecture
/bmad-create-architecture

# This creates:
# - _bmad/bmm/3-solutioning/architecture.md
# - Technical decisions
# - System design

# Step 3: Create Epics & Stories
/bmad-create-epics-and-stories

# This creates:
# - _bmad/bmm/2-plan/epics/
# - _bmad/bmm/2-plan/stories/
```

**Store in OpenViking:**
```bash
# Store PRD
openviking add --type=requirement \
  --title="Feature: [Name]" \
  --file="_bmad/bmm/2-plan/prd.json"

# Store Architecture
openviking add --type=adr \
  --title="Architecture: [Decision]" \
  --file="_bmad/bmm/3-solutioning/architecture.md"

# Store Stories
openviking add --type=requirement \
  --title="Stories: [Feature]" \
  --file="_bmad/bmm/2-plan/stories/"
```

### Phase 2: Planning (GSD)

```bash
# Step 1: Discuss Phase
/gsd-discuss-phase 1

# This creates:
# - .planning/phases/001/DISCUSS.md
# - Phase context
# - Approach decisions

# Step 2: Plan Phase
/gsd-plan-phase 1

# This creates:
# - .planning/phases/001/PLAN.md
# - Detailed task breakdown
# - Verification criteria
```

**Store in OpenViking:**
```bash
# Store Discussion
openviking add --type=phase \
  --title="Phase 1 Discussion" \
  --file=".planning/phases/001/DISCUSS.md"

# Store Plan
openviking add --type=phase \
  --title="Phase 1 Plan" \
  --file=".planning/phases/001/PLAN.md"
```

### Phase 3: Implementation (Ralph Loop)

```bash
# Step 1: Convert BMAD PRD to Ralph format
cp _bmad/bmm/2-plan/prd.json .ralph/prd.json

# Step 2: Add GSD plan context
cat .planning/phases/001/PLAN.md >> .ralph/context.md

# Step 3: Run Ralph Loop
./.ralph/ralph-loop.sh 20 true

# This runs:
# - 20 autonomous iterations
# - Auto-approves changes
# - Creates checkpoints
```

**Store in OpenViking:**
```bash
# Store Ralph Outcome
openviking add --type=ralph-outcome \
  --title="Ralph Implementation: [Feature]" \
  --file=".ralph/iteration-log.md"

# Store Checkpoints
openviking add --type=ralph-checkpoint \
  --title="Ralph Checkpoints: [Feature]" \
  --file=".ralph/checkpoints/"
```

### Phase 4: Verification (GSD)

```bash
# Step 1: Verify Work
/gsd-verify-work 1

# This creates:
# - .planning/phases/001/VERIFICATION.md
# - UAT results
# - Acceptance status

# Step 2: Run Quality Checks
vendor/bin/phpstan analyse --level=10
npm run quality
php artisan test
```

**Store in OpenViking:**
```bash
# Store Verification
openviking add --type=verification \
  --title="Phase 1 Verification" \
  --file=".planning/phases/001/VERIFICATION.md"
```

### Phase 5: Retrospective (BMAD)

```bash
# Step 1: Run Retrospective
/bmad-retrospective

# This creates:
# - _bmad/bmm/5-retro/retro.md
# - Lessons learned
# - Improvement items
```

**Store in OpenViking:**
```bash
# Store Retrospective
openviking add --type=retrospective \
  --title="Phase 1 Retrospective" \
  --file="_bmad/bmm/5-retro/retro.md"
```

## Complete Workflow Example

### Scenario: Implement Prediction Market Feature

```bash
# ============================================
# PHASE 1: BMAD (Requirements & Architecture)
# ============================================

# Create PRD
/bmad-create-prd
# → Defines prediction market requirements

# Create Architecture
/bmad-create-architecture
# → Defines LMSR algorithm, order book design

# Create Stories
/bmad-create-epics-and-stories
# → Breaks down into implementable stories

# Store in OpenViking
openviking add --type=requirement --title="Prediction Market" \
  --file="_bmad/bmm/2-plan/prd.json"
openviking add --type=adr --title="LMSR Algorithm" \
  --file="_bmad/bmm/3-solutioning/lmsr-architecture.md"

# ============================================
# PHASE 2: GSD (Planning)
# ============================================

# Discuss Phase
/gsd-discuss-phase 1
# → Determines approach: Ralph Loop for rapid iteration

# Plan Phase
/gsd-plan-phase 1
# → Creates detailed implementation plan

# Store in OpenViking
openviking add --type=phase --title="Phase 1 Plan" \
  --file=".planning/phases/001/PLAN.md"

# ============================================
# PHASE 3: Ralph Loop (Implementation)
# ============================================

# Prepare Ralph PRD
cp _bmad/bmm/2-plan/prd.json .ralph/prd.json
cat .planning/phases/001/PLAN.md >> .ralph/context.md

# Run Ralph Loop (20 iterations, auto-approve)
./.ralph/ralph-loop.sh 20 true

# Store in OpenViking
openviking add --type=ralph-outcome --title="Prediction Market Implementation" \
  --file=".ralph/iteration-log.md"

# ============================================
# PHASE 4: GSD (Verification)
# ============================================

# Verify Work
/gsd-verify-work 1
# → Validates implementation against UAT criteria

# Quality Checks
vendor/bin/phpstan analyse --level=10
php artisan test --coverage

# Store in OpenViking
openviking add --type=verification --title="Phase 1 Verification" \
  --file=".planning/phases/001/VERIFICATION.md"

# ============================================
# PHASE 5: BMAD (Retrospective)
# ============================================

# Run Retrospective
/bmad-retrospective
# → Captures lessons learned

# Store in OpenViking
openviking add --type=retrospective --title="Phase 1 Retro" \
  --file="_bmad/bmm/5-retro/retro.md"

# ============================================
# COMPLETE: Commit & Push
# ============================================

git add .
git commit -m "feat: Add prediction market feature (BMAD+GSD+Ralph)"
git push origin dev
```

## Context Flow with OpenViking

```
┌─────────────────────────────────────────────────────────────┐
│                     OpenViking Context                       │
│                                                              │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │ Requirements │  │     ADRs     │  │   Memories   │      │
│  │   (BMAD)     │  │   (BMAD)     │  │  (All)       │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
│                                                              │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │ Phase Plans  │  │    Ralph     │  │ Verification │      │
│  │    (GSD)     │  │  Outcomes    │  │    (GSD)     │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
└─────────────────────────────────────────────────────────────┘
         ▲                    ▲                    ▲
         │                    │                    │
         │ Store              │ Store              │ Store
         │                    │                    │
    ┌────┴────┐         ┌────┴────┐         ┌────┴────┐
    │  BMAD   │         │  Ralph  │         │   GSD   │
    │ (Plan)  │         │ (Build) │         │(Verify) │
    └─────────┘         └─────────┘         └─────────┘
```

## Decision Matrix

| Scenario | Recommended Flow |
|----------|------------------|
| **New Feature (Complex)** | BMAD → GSD → Ralph → GSD → BMAD |
| **New Feature (Simple)** | GSD → Ralph → GSD |
| **Bug Fix** | GSD (fast track) |
| **Architecture Change** | BMAD → GSD → Manual → GSD → BMAD |
| **Rapid Prototype** | Ralph → GSD (verify) |
| **Research Spike** | BMAD (analysis) → GSD (document) |

## Best Practices

### 1. Context Preservation

✅ **ALWAYS** store artifacts in OpenViking:
```bash
# After BMAD
openviking add --type=requirement --file="_bmad/bmm/2-plan/prd.json"

# After GSD planning
openviking add --type=phase --file=".planning/phases/001/PLAN.md"

# After Ralph
openviking add --type=ralph-outcome --file=".ralph/iteration-log.md"
```

❌ **NEVER** let context exist only in temporary files

### 2. Phase Gates

✅ **ALWAYS** verify before moving to next phase:
```bash
# After Ralph Loop
/gsd-verify-work 1

# After GSD execution
/bmad-retrospective
```

❌ **NEVER** skip verification steps

### 3. Quality Gates

✅ **ALWAYS** run quality checks:
```bash
# PHP quality
vendor/bin/phpstan analyse --level=10
vendor/bin/pest --coverage

# Frontend quality
npm run quality
```

❌ **NEVER** commit without quality checks

### 4. Atomic Commits

✅ **ALWAYS** commit after each phase:
```bash
# After BMAD
git add _bmad/
git commit -m "bmad: Add PRD and architecture for [feature]"

# After GSD planning
git add .planning/
git commit -m "gsd: Add phase 1 plan for [feature]"

# After Ralph + verification
git add .
git commit -m "feat: Implement [feature] (BMAD+GSD+Ralph)"
git push
```

❌ **NEVER** batch multiple phases in one commit

### 5. Documentation Links

✅ **ALWAYS** use viking:// URIs:
```markdown
## Related Context
- [PRD](viking://requirement/prediction-market)
- [Architecture](viking://adr/lmsr-algorithm)
- [Phase Plan](viking://phase/1-plan)
- [Implementation](viking://ralph/prediction-market)
```

❌ **NEVER** duplicate content across documents

## Troubleshooting

### Ralph Loop Not Starting

```bash
# Check PRD exists
ls -la .ralph/prd.json

# Validate JSON
jq . .ralph/prd.json

# Check script permissions
chmod +x .ralph/ralph-loop.sh
```

### OpenViking Not Storing Context

```bash
# Check OpenViking status
openviking status

# Re-initialize if needed
openviking init

# Try manual add
openviking add --type=test --title="Test" --content="Test content"
```

### GSD Phase Verification Failing

```bash
# Check phase directory
ls -la .planning/phases/001/

# Review verification criteria
cat .planning/phases/001/PLAN.md

# Run manual verification
php artisan test
vendor/bin/phpstan analyse --level=10
```

## Resources

- **OpenViking**: [docs/openviking-integration.md](../docs/openviking-integration.md)
- **BMAD**: [laravel/Modules/Xot/docs/bmad-workflow-guide.md](laravel/Modules/Xot/docs/bmad-workflow-guide.md)
- **GSD**: See `.planning/` directory
- **Ralph Loop**: See `.ralph/` directory

## Next Steps

1. ✅ Choose methodology based on task complexity
2. ✅ Follow integrated workflow
3. ✅ Store all artifacts in OpenViking
4. ✅ Run quality gates
5. ✅ Commit after each phase
6. ✅ Link documentation with viking:// URIs

---

**Version**: 1.0.0  
**Last Updated**: 2026-03-30  
**Status**: Initial Implementation
