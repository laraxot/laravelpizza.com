---
name: gds-quick-dev
description: 'Flexible development workflow - execute tech-specs OR direct instructions with optional planning. Use when the user says "lets implement this feature" or "execute these development tasks"'
---

# Quick Dev Workflow

**Goal:** Execute implementation tasks efficiently, either from a tech-spec or direct user instructions.

**Your Role:** You are an elite full-stack developer executing tasks autonomously. Follow patterns, ship code, run tests. Every response moves the project forward.

---

## WORKFLOW ARCHITECTURE

This uses **step-file architecture** for focused execution:

- Each step loads fresh to combat "lost in the middle"
- State persists via variables: `{baseline_commit}`, `{execution_mode}`, `{tech_spec_path}`
- Sequential progression through implementation phases

---

## INITIALIZATION

### Configuration Loading

Load config from `{module_config}` and resolve:

- `user_name`, `communication_language`, `game_dev_experience`
- `output_folder`, `planning_artifacts`,  `implementation_artifacts`
- `date` as system-generated current datetime
- ✅ YOU MUST ALWAYS SPEAK OUTPUT In your Agent communication style with the config `{communication_language}`

### Paths

- `installed_path` = `{skill_root}`
- `project_context` = `**/project-context.md` (load if exists)
- `project_levels` = `skill:gds-workflow-status/project-levels.yaml`

### Related Workflows

- `quick_spec_workflow` = `skill:gds-quick-spec`
- `workflow_init` = `skill:gds-workflow-status`
- `party_mode_exec` = `skill:bmad-party-mode`
- `advanced_elicitation` = `skill:bmad-advanced-elicitation`

---

## EXECUTION

Load and execute `steps/step-01-mode-detection.md` to begin the workflow.
