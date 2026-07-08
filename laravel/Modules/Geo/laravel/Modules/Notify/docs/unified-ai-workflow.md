# Unified AI Workflow: OpenViking + BMAD + GSD + Ralph Loop

## Executive Summary

This document describes the complete integrated workflow for developing features in the FixCity platform using four AI-powered methodologies:

- **OpenViking**: Context management and knowledge preservation
- **BMAD**: Requirements engineering and architecture
- **GSD**: Structured planning and execution
- **Ralph Loop**: Autonomous implementation

## Quick Start

### For New Features

```bash
# 1. Initialize OpenViking context (one-time)
bash bashscripts/ai/openviking-init.sh

# 2. Create requirements (BMAD)
/bmad-create-prd
/bmad-create-architecture

# 3. Store in OpenViking
openviking add-memory --title="PRD: [Feature]" --content="..."

# 4. Plan execution (GSD)
/gsd-discuss-phase 1
/gsd-plan-phase 1

# 5. Implement (Ralph Loop)
./.ralph/ralph-loop.sh 20 true

# 6. Verify (GSD)
/gsd-verify-work 1

# 7. Commit
git add . && git commit -m "feat: [feature]" && git push
```

### For Bug Fixes

```bash
# 1. Quick GSD planning
/gsd-discuss-phase 1 --auto
/gsd-plan-phase 1

# 2. Fix (manual or Ralph)
# Manual for complex fixes
# OR Ralph for simple fixes: ./.ralph/ralph-loop.sh 5 true

# 3. Verify
/gsd-verify-work 1

# 4. Commit
git add . && git commit -m "fix: [bug]" && git push
```

## Architecture Overview

```
┌─────────────────────────────────────────────────────────┐
│                   OpenViking Context                     │
│                                                          │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌────────┐ │
│  │Requirements│  │Architecture│  │Memories  │  │Skills  │ │
│  │  (BMAD)  │  │  (BMAD)  │  │  (All)   │  │ (All)  │ │
│  └──────────┘  └──────────┘  └──────────┘  └────────┘ │
│                                                          │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌────────┐ │
│  │  Plans   │  │Executions│  │Ralph     │  │Verify  │ │
│  │  (GSD)   │  │  (GSD)   │  │Outcomes  │  │ (GSD)  │ │
│  └──────────┘  └──────────┘  └──────────┘  └────────┘ │
└─────────────────────────────────────────────────────────┘
         ▲                ▲               ▲          ▲
         │                │               │          │
    ┌────┴────┐     ┌────┴────┐    ┌────┴────┐ ┌───┴────┐
    │  BMAD   │     │   GSD   │    │  Ralph  │ │  GSD   │
    │ (Plan)  │     │ (Plan)  │    │ (Build) │ │(Verify)│
    └─────────┘     └─────────┘    └─────────┘ └────────┘
```

## Detailed Workflow

### Phase 0: Setup (One-Time)

#### Initialize OpenViking

```bash
# Run initialization script
bash bashscripts/ai/openviking-init.sh

# This will:
# ✅ Index all project documentation
# ✅ Create project context memories
# ✅ Register AI skills
# ✅ Verify OpenViking setup
```

#### Verify Tools Available

```bash
# Check OpenViking
openviking version
openviking status

# Check BMAD (should be available as skill)
/bmad-help

# Check GSD (should be available as skill)
/gsd-help

# Check Ralph Loop
ls -la .ralph/
```

### Phase 1: Requirements & Architecture (BMAD)

#### Step 1.1: Create PRD

```bash
/bmad-create-prd
```

**What this does:**
- Creates product requirements document
- Defines user stories
- Establishes acceptance criteria
- Output: `_bmad/bmm/2-plan/prd.json`

**Store in OpenViking:**
```bash
openviking add-memory \
  --title="PRD: [Feature Name]" \
  --content="Requirements for [feature]. See _bmad/bmm/2-plan/prd.json"
```

#### Step 1.2: Create Architecture

```bash
/bmad-create-architecture
```

**What this does:**
- Creates technical architecture
- Defines system components
- Makes architectural decisions
- Output: `_bmad/bmm/3-solutioning/architecture.md`

**Store in OpenViking:**
```bash
openviking add-memory \
  --title="Architecture: [Decision Name]" \
  --content="Architecture for [feature]. See _bmad/bmm/3-solutioning/"
```

#### Step 1.3: Create Epics & Stories

```bash
/bmad-create-epics-and-stories
```

**What this does:**
- Breaks PRD into epics
- Creates user stories
- Estimates complexity
- Output: `_bmad/bmm/2-plan/epics/`, `_bmad/bmm/2-plan/stories/`

**Store in OpenViking:**
```bash
openviking add-memory \
  --title="Stories: [Feature]" \
  --content="User stories for [feature]. See _bmad/bmm/2-plan/stories/"
```

### Phase 2: Planning (GSD)

#### Step 2.1: Discuss Phase

```bash
/gsd-discuss-phase 1
```

**What this does:**
- Gathers phase context
- Determines approach (BMAD, Ralph, manual)
- Identifies risks and assumptions
- Output: `.planning/phases/001/DISCUSS.md`

**Store in OpenViking:**
```bash
openviking add-memory \
  --title="Phase 1 Discussion" \
  --content="Discussion for phase 1. Approach: [approach]"
```

#### Step 2.2: Plan Phase

```bash
/gsd-plan-phase 1
```

**What this does:**
- Creates detailed task breakdown
- Defines verification criteria
- Estimates effort
- Output: `.planning/phases/001/PLAN.md`

**Store in OpenViking:**
```bash
openviking add-memory \
  --title="Phase 1 Plan" \
  --content="Plan for phase 1. Tasks: [summary]"
```

### Phase 3: Implementation (Ralph Loop)

#### Step 3.1: Prepare Ralph PRD

```bash
# Copy BMAD PRD to Ralph
cp _bmad/bmm/2-plan/prd.json .ralph/prd.json

# Add GSD plan context
cat .planning/phases/001/PLAN.md >> .ralph/context.md

# Review and adjust stories if needed
jq '.stories' .ralph/prd.json
```

#### Step 3.2: Run Ralph Loop

```bash
# Run Ralph Loop (20 iterations, auto-approve)
./.ralph/ralph-loop.sh 20 true
```

**What this does:**
- Runs autonomous implementation
- Creates checkpoints
- Logs iterations
- Output: `.ralph/iteration-log.md`, `.ralph/checkpoints/`

**Store in OpenViking:**
```bash
openviking add-memory \
  --title="Ralph Outcome: [Feature]" \
  --content="Ralph implemented [feature] in 20 iterations. See .ralph/iteration-log.md"
```

### Phase 4: Verification (GSD)

#### Step 4.1: Verify Work

```bash
/gsd-verify-work 1
```

**What this does:**
- Validates against UAT criteria
- Checks acceptance criteria
- Creates verification report
- Output: `.planning/phases/001/VERIFICATION.md`

**Store in OpenViking:**
```bash
openviking add-memory \
  --title="Phase 1 Verification" \
  --content="Verification passed for phase 1. See .planning/phases/001/VERIFICATION.md"
```

#### Step 4.2: Run Quality Gates

```bash
# PHP quality
vendor/bin/phpstan analyse --level=10
vendor/bin/pest --coverage

# Frontend quality
npm run quality

# Fix issues if found
vendor/bin/phpstan analyse --level=10 --fix
npm run fix
```

### Phase 5: Retrospective (BMAD)

#### Step 5.1: Run Retrospective

```bash
/bmad-retrospective
```

**What this does:**
- Captures lessons learned
- Identifies improvements
- Documents successes
- Output: `_bmad/bmm/5-retro/retro.md`

**Store in OpenViking:**
```bash
openviking add-memory \
  --title="Retrospective: [Feature]" \
  --content="Lessons learned from [feature]. See _bmad/bmm/5-retro/retro.md"
```

### Phase 6: Commit & Push

```bash
# Review changes
git status
git diff HEAD

# Stage all changes
git add .

# Commit with conventional commit message
git commit -m "feat: Add [feature name]

- Requirements: BMAD PRD
- Architecture: [key decisions]
- Implementation: Ralph Loop (20 iterations)
- Verification: GSD UAT passed
- Quality: PHPStan Level 10, Pest tests"

# Push to remote
git push origin dev
```

## Workflow Variations

### Variation 1: Simple Feature (Fast Track)

For simple features that don't need full BMAD:

```bash
# 1. Quick GSD planning
/gsd-discuss-phase 1 --auto
/gsd-plan-phase 1

# 2. Ralph implementation
echo '{"stories": [...]}' > .ralph/prd.json
./.ralph/ralph-loop.sh 10 true

# 3. Verify and commit
/gsd-verify-work 1
git add . && git commit -m "feat: [simple feature]" && git push
```

### Variation 2: Complex Feature (Full BMAD + GSD)

For complex features needing full analysis:

```bash
# 1. Full BMAD
/bmad-create-prd
/bmad-create-architecture
/bmad-create-epics-and-stories

# 2. Multiple GSD phases
/gsd-discuss-phase 1
/gsd-plan-phase 1
/gsd-execute-phase 1
/gsd-verify-work 1

/gsd-discuss-phase 2
/gsd-plan-phase 2
/gsd-execute-phase 2
/gsd-verify-work 2

# 3. Commit after each phase
git add . && git commit -m "feat: [complex feature] - phase 1" && git push
```

### Variation 3: Bug Fix (GSD Only)

For bug fixes:

```bash
# 1. GSD discussion
/gsd-discuss-phase 1 --auto

# 2. Manual fix (or Ralph for simple fixes)
# Fix the bug manually

# 3. Verify
/gsd-verify-work 1

# 4. Commit
git add . && git commit -m "fix: [bug description]" && git push
```

### Variation 4: Research Spike (BMAD Analysis)

For research and documentation:

```bash
# 1. BMAD analysis
/bmad-create-prd  # Define research questions
/bmad-create-architecture  # Document findings

# 2. Store in OpenViking
openviking add-memory --title="Research: [Topic]" --content="..."

# 3. Commit documentation
git add docs/ && git commit -m "docs: Research on [topic]" && git push
```

## Context Preservation with OpenViking

### What to Store

| Artifact | When | OpenViking Type |
|----------|------|-----------------|
| PRD | After BMAD | `memory` |
| Architecture | After BMAD | `memory` |
| Stories | After BMAD | `memory` |
| Phase Plan | After GSD | `memory` |
| Ralph Outcome | After Ralph | `memory` |
| Verification | After GSD | `memory` |
| Retrospective | After BMAD | `memory` |

### How to Store

```bash
# Simple memory
openviking add-memory \
  --title="[Type]: [Subject]" \
  --content="[Brief description]"

# With file reference
openviking add-memory \
  --title="PRD: Prediction Market" \
  --content="Requirements for prediction market. See _bmad/bmm/2-plan/prd.json"

# With viking:// URI
openviking add-memory \
  --title="Implementation: Prediction Market" \
  --content="Implemented using Ralph Loop. Related: viking://memory/PRD: Prediction Market"
```

### How to Retrieve

```bash
# Search
openviking search "prediction market"

# List memories
openviking ls /memories/

# Read specific memory
openviking read /memories/prd-prediction-market/
```

## Best Practices

### 1. Always Store Context

✅ **DO**: Store every artifact in OpenViking
```bash
openviking add-memory --title="Phase 1 Plan" --content="..."
```

❌ **DON'T**: Let context exist only in files

### 2. Use Viking:// URIs

✅ **DO**: Link contexts with URIs
```markdown
See [PRD](viking://memory/prd-prediction-market) for requirements.
```

❌ **DON'T**: Duplicate content

### 3. Run Quality Gates

✅ **ALWAYS** run after implementation:
```bash
vendor/bin/phpstan analyse --level=10
php artisan test
npm run quality
```

❌ **NEVER** skip quality checks

### 4. Commit After Each Phase

✅ **DO**: Small, atomic commits
```bash
git add . && git commit -m "bmad: Add PRD" && git push
git add . && git commit -m "gsd: Phase 1 plan" && git push
git add . && git commit -m "feat: Implementation" && git push
```

❌ **DON'T**: Batch multiple phases

### 5. Document Decisions

✅ **DO**: Record why, not just what
```bash
openviking add-memory \
  --title="ADR: Chose Spatie Actions" \
  --content="Chose Spatie Actions over Services because: queueable, testable, single-purpose"
```

❌ **DON'T**: Just record what was done

## Troubleshooting

### OpenViking Issues

**Problem**: Commands not working
```bash
# Check installation
which openviking

# Check status
openviking status

# Re-index if needed
bash bashscripts/ai/openviking-init.sh
```

### BMAD Issues

**Problem**: BMAD commands not found
```bash
# Check BMAD directory
ls -la _bmad/

# Check skills
/bmad-help

# Re-initialize if needed
# (Check BMAD documentation)
```

### GSD Issues

**Problem**: GSD commands not working
```bash
# Check GSD directory
ls -la .planning/

# Check skills
/gsd-help

# Review AGENTS.md for GSD commands
```

### Ralph Loop Issues

**Problem**: Ralph script not running
```bash
# Check permissions
chmod +x .ralph/ralph-loop.sh

# Check PRD
jq . .ralph/prd.json

# Check logs
cat .ralph/iteration-log.md
```

## Resources

### Documentation
- [OpenViking Integration](./openviking-integration.md)
- [BMAD-GSD-Ralph Integration](./bmad-gsd-ralph-integration.md)
- [BMAD Workflow](laravel/Modules/Xot/docs/bmad-workflow-guide.md)
- [AGENTS.md](../AGENTS.md)

### Scripts
- OpenViking Init: `bashscripts/ai/openviking-init.sh`
- Ralph Loop: `.ralph/ralph-loop.sh`

### Commands Reference

#### OpenViking
```bash
openviking add-memory --title="..." --content="..."
openviking search "query"
openviking ls /
openviking read /path/to/resource
```

#### BMAD
```bash
/bmad-create-prd
/bmad-create-architecture
/bmad-create-epics-and-stories
/bmad-retrospective
```

#### GSD
```bash
/gsd-discuss-phase 1
/gsd-plan-phase 1
/gsd-execute-phase 1
/gsd-verify-work 1
```

#### Ralph Loop
```bash
./.ralph/ralph-loop.sh [iterations] [auto_approve]
```

## Success Metrics

### Workflow Health Indicators

✅ **Healthy Workflow:**
- All artifacts stored in OpenViking
- Quality gates passing (PHPStan L10, tests)
- Commits after each phase
- Documentation linked with viking:// URIs
- Retrospectives completed

⚠️ **Warning Signs:**
- Context only in files (not OpenViking)
- Quality gates skipped
- Large batched commits
- No retrospectives
- Missing documentation links

### Continuous Improvement

After each feature, ask:
1. ✅ Was context preserved in OpenViking?
2. ✅ Were quality gates run?
3. ✅ Were commits atomic?
4. ✅ Was documentation linked?
5. ✅ What can be improved next time?

Document answers in retrospectives and store in OpenViking.

---

**Version**: 1.0.0  
**Last Updated**: 2026-03-30  
**Status**: Initial Implementation  
**Next Review**: After first feature using complete workflow
