# BMAD-GSD Integration Configuration (bmap)

This document defines how BMAD Method and GSD workflows coexist and complement each other in the LaravelPizza project.

## Current Project State

| System | Status | Location |
|--------|--------|----------|
| GSD | Active | `.planning/` (PROJECT.md, ROADMAP.md, STATE.md, REQUIREMENTS.md, phases/) |
| BMAD | Installed | `_bmad/` (bmm, gds, cis, wds, tea modules) |
| BMAD-GSD Integration | Active | `_bmad/gds/` (GSD-specific BMAD workflows) |

## Framework Mapping

### Phase Correspondence

| GSD Phase | BMAD Phase | Notes |
|-----------|------------|-------|
| Analysis | 1-Analysis | GSD uses internal research, BMAD uses bmad-* research skills |
| Planning | 2-Planning | GSD creates REQUIREMENTS.md, BMAD creates PRD |
| Solutioning | 3-Solutioning | GSD builds phases directly, BMAD creates Architecture + Epics |
| Implementation | 4-Implementation | Both converge on story/phase execution |

### Artifact Mapping

| GSD Artifact | BMAD Artifact | Location |
|---------------|---------------|----------|
| `.planning/PROJECT.md` | Product Brief | `.agents/` or `_bmad/` |
| `.planning/REQUIREMENTS.md` | PRD | `.agents/` or `_bmad/` |
| `.planning/ROADMAP.md` | Epics + Stories | GSD native |
| `.planning/phases/` | Sprint Planning | `_bmad/bmm/workflows/4-implementation/` |
| - | Architecture | `_bmad/bmm/workflows/3-solutioning/bmad-create-architecture/` |

### Workflow Mapping

#### Research Phase

| GSD | BMAD | Usage |
|-----|------|-------|
| `/gsd-new-project` | bmad-create-product-brief | Project initialization |
| auto | bmad-domain-research | Domain exploration |
| auto | bmad-technical-research | Technical stack research |
| auto | bmad-market-research | Market/competitive research |

#### Planning Phase

| GSD | BMAD | Usage |
|-----|------|-------|
| `/gsd-new-project` creates REQUIREMENTS.md | bmad-create-prd | Requirements document |
| - | bmad-create-architecture | Architecture document |
| - | bmad-create-epics-and-stories | Epic/story breakdown |
| `/gsd-plan-phase` | bmad-sprint-planning | Sprint initialization |
| - | bmad-create-story | Story creation |

#### Execution Phase

| GSD | BMAD | Usage |
|-----|------|-------|
| `/gsd-execute-phase` | bmad-dev-story | Implementation |
| - | bmad-code-review | Code quality |
| `/gsd-verify-work` | bmad-retrospective | Validation |

#### Meta Workflows

| GSD | BMAD | Usage |
|-----|------|-------|
| `/gsd-help` | bmad-help | AI-guided help |
| `/gsd-map-codebase` | bmad-document-project | Codebase documentation |
| - | bmad-party-mode | Multi-agent collaboration |
| - | bmad-generate-project-context | Context generation |

## Active Configuration

Current GSD config in `.planning/config.json`:

```json
{
  "mode": "yolo",
  "granularity": "fine",
  "parallelization": true,
  "commit_docs": true,
  "model_profile": "balanced",
  "workflow": {
    "research": true,
    "plan_check": true,
    "verifier": true,
    "nyquist_validation": true,
    "auto_advance": true
  }
}
```

## Integration Usage

### When to Use GSD Native

- Phase planning and execution (`/gsd-plan-phase`, `/gsd-execute-phase`)
- Roadmap management (`.planning/ROADMAP.md`)
- Requirement tracking with traceability
- Verification loops (`/gsd-verify-work`, `/gsd-validate-phase`)

### When to Use BMAD

- Deep research (bmad-domain-research, bmad-technical-research)
- Architecture design (bmad-create-architecture)
- Epic/story refinement (bmad-create-epics-and-stories)
- Code review (bmad-code-review)
- Multi-agent brainstorming (bmad-party-mode)

### When to Use Both

- Project initialization: GSD for quick setup, BMAD for deeper analysis
- Architecture: BMAD for detailed design, GSD for phased execution
- Testing: BMAD test design, GSD verification

## GSD Commands (Primary)

```
/gsd-new-project          - Initialize new project
/gsd-map-codebase         - Document existing codebase
/gsd-discuss-phase [n]    - Discuss phase approach
/gsd-plan-phase [n]       - Plan phase execution
/gsd-execute-phase [n]   - Execute phase plans
/gsd-verify-work          - Verify delivered work
/gsd-progress             - Show project progress
```

## BMAD Commands (Supplementary)

```
bmad-help                  - AI-guided next step
bmad-create-prd           - Create PRD
bmad-create-architecture  - Create architecture
bmad-dev-story            - Implement story
bmad-code-review          - Review code
bmad-party-mode           - Multi-agent session
```

## Notes

- GSD is the primary orchestration layer for this project
- BMAD provides specialized workflows for deep-dive tasks
- Both systems share `.planning/` as the source of truth
- BMAD workflows can be invoked via their skill names in Claude Code/Cursor

---

*Last updated: 2026-03-18*
*Project: LaravelPizza Dual-Track Program*