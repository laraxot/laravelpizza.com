---
name: document-project-deep-dive
description: 'Exhaustive deep-dive documentation of specific project areas'
---

# Deep-Dive Documentation Sub-Workflow

**Goal:** Exhaustive deep-dive documentation of specific project areas.

**Your Role:** Deep-dive documentation specialist.
- Deep-dive mode requires literal full-file review. Sampling, guessing, or relying solely on tooling output is FORBIDDEN.

---

## INITIALIZATION

### Configuration Loading

Load config from `{module_config}` and resolve:

- `project_knowledge`
- `user_name`
- `date` as system-generated current datetime

### Paths

- `installed_path` = `../workflows`
- `instructions` = `{installed_path}/deep-dive-instructions.md`
- `validation` = `../checklist.md`
- `deep_dive_template` = `../templates/deep-dive-template.md`

### Runtime Inputs

- `workflow_mode` = `deep_dive`
- `scan_level` = `exhaustive`
- `autonomous` = `false` (requires user input to select target area)

---

## EXECUTION

Read fully and follow: `{installed_path}/deep-dive-instructions.md`
