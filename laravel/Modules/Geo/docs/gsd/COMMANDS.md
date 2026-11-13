# GSD (Get Shit Done) - Command Reference

**Version**: 1.0.0  
**For**: PTVX Fila5 Mono  
**Frameworks**: GSD v1.25.1 + BMAD-METHOD v6.2.0

---

## 🚀 Essential Commands

### Project Initialization

```bash
# Start new project with full planning
/gsd:new-project

# Analyze existing codebase (brownfield)
/gsd:map-codebase
```

### Phase Workflow

```bash
# 1. Discuss implementation decisions
/gsd:discuss-phase 1

# 2. Research + plan + verify
/gsd:plan-phase 1

# 3. Execute in parallel waves
/gsd:execute-phase 1

# 4. Manual user acceptance testing
/gsd:verify-work 1
```

### Milestone Management

```bash
# Audit milestone completion
/gsd:audit-milestone

# Archive and tag release
/gsd:complete-milestone

# Start next version
/gsd:new-milestone "Phase 2: Advanced Features"
```

### Quick Tasks

```bash
# Ad-hoc task with GSD guarantees
/gsd:quick

# With discussion
/gsd:quick --discuss

# With research
/gsd:quick --research

# Full experience
/gsd:quick --discuss --research --full
```

### Navigation

```bash
# Where am I? What's next?
/gsd:progress

# Show all commands
/gsd:help

# Update GSD
/gsd:update

# Join Discord
/gsd:join-discord
```

### Session Management

```bash
# Save state for later
/gsd:pause-work

# Restore from last session
/gsd:resume-work
```

### Utilities

```bash
# Capture idea for later
/gsd:add-todo "Add dark mode to dashboard"

# List pending todos
/gsd:check-todos

# Systematic debugging
/gsd:debug "Login endpoint returns 500"

# Check project stats
/gsd:stats

# Validate .planning/ integrity
/gsd:health
```

### Settings

```bash
# Interactive settings menu
/gsd:settings

# Switch model profile
/gsd:set-profile quality
/gsd:set-profile balanced
/gsd:set-profile budget
```

---

## 📋 Command Aliases by AI Agent

### Claude Code

```bash
/gsd:new-project
/gsd:discuss-phase
/gsd:plan-phase
/gsd:execute-phase
/gsd:verify-work
/gsd:help
```

### Gemini CLI

```bash
/gsd-new-project
/gsd-discuss-phase
/gsd-plan-phase
/gsd-execute-phase
/gsd-verify-work
/gsd-help
```

### OpenCode

```bash
/gsd-new-project
/gsd-discuss-phase
/gsd-plan-phase
/gsd-execute-phase
/gsd-verify-work
/gsd-help
```

### GitHub Copilot

```bash
/gsd:new-project
/gsd:discuss-phase
/gsd:plan-phase
/gsd:execute-phase
/gsd:verify-work
/gsd:help
```

---

## 🔄 Complete Workflow Examples

### Example 1: New Feature Development

```bash
# 1. Initialize
/gsd:new-project
# → Answer questions, get PROJECT.md, REQUIREMENTS.md, ROADMAP.md

# 2. Discuss Phase 1
/gsd:discuss-phase 1
# → Capture implementation decisions in CONTEXT.md

# 3. Plan Phase 1
/gsd:plan-phase 1
# → Research + create PLAN.md with atomic tasks

# 4. Execute Phase 1
/gsd:execute-phase 1
# → Wave execution, atomic commits

# 5. Verify Phase 1
/gsd:verify-work 1
# → UAT, debugging if needed

# 6. Repeat for Phase 2, 3, ...
/gsd:discuss-phase 2
/gsd:plan-phase 2
/gsd:execute-phase 2
/gsd:verify-work 2

# 7. Complete milestone
/gsd:complete-milestone

# 8. Start next milestone
/gsd:new-milestone "v2.0"
```

### Example 2: Quick Bug Fix

```bash
# Use quick mode for simple tasks
/gsd:quick
> "Fix login endpoint returning 500 error"

# With debugging
/gsd:debug "Login returns 500 with valid credentials"
```

### Example 3: Brownfield Project

```bash
# 1. Map existing codebase
/gsd:map-codebase
# → Analyzes structure, documents patterns

# 2. Start new milestone
/gsd:new-milestone "Refactoring"

# 3. Follow standard workflow
/gsd:discuss-phase 1
/gsd:plan-phase 1
/gsd:execute-phase 1
/gsd:verify-work 1
```

---

## 🎯 GSD + BMAD Integration

### Combined Workflow

```bash
# 1. GSD: High-level planning
/gsd:new-project

# 2. GSD: Plan phase
/gsd:plan-phase 1

# 3. BMAD: Domain-specific execution
bmad-laravel-module-dev --module=Scheda
# OR
bmad-filament-page-dev --page=DashboardPage

# 4. GSD: Verify
/gsd:verify-work 1

# 5. GSD: Complete
/gsd:complete-milestone
```

### When to Use What

| Task | Framework | Command |
|------|-----------|---------|
| **Project initialization** | GSD | `/gsd:new-project` |
| **Multi-phase development** | GSD | `/gsd:plan-phase`, `/gsd:execute-phase` |
| **Laravel module** | BMAD | `bmad-laravel-module-dev` |
| **Filament page** | BMAD | `bmad-filament-page-dev` |
| **Code review** | BMAD | `bmad-code-review` |
| **Testing** | BMAD | `bmad-qa-generate-e2e-tests` |
| **Quick task** | GSD | `/gsd:quick` |
| **Bug fix** | GSD | `/gsd:debug` |

---

## 📊 File Structure

### After `/gsd:new-project`

```
project/
├── .planning/
│   ├── config.json
│   ├── PROJECT.md
│   ├── REQUIREMENTS.md
│   ├── ROADMAP.md
│   ├── STATE.md
│   └── research/
│       └── 01-RESEARCH.md
├── docs/
│   ├── gsd/
│   │   └── README.md
│   └── bmad/
│       └── README.md
└── laravel/
    └── Modules/
```

### During Phase Execution

```
.planning/
├── 01-CONTEXT.md           # From /gsd:discuss-phase 1
├── 01-RESEARCH.md          # From /gsd:plan-phase 1
├── 01-01-PLAN.md           # Atomic task 1
├── 01-01-SUMMARY.md        # After /gsd:execute-phase
├── 01-02-PLAN.md           # Atomic task 2
├── 01-02-SUMMARY.md
├── 01-VERIFICATION.md      # After /gsd:verify-work
└── 01-UAT.md               # User acceptance testing
```

---

## 🔧 Troubleshooting

### Commands Not Found

```bash
# Verify installation
/gsd:help

# Check .planning/ directory
ls -la .planning/

# Restart AI agent
# (quit and relaunch)
```

### Context Warnings

```bash
# Check context usage
/gsd:stats

# Clear context
clear

# Resume with fresh context
/gsd:resume-work
```

### Git Issues

```bash
# Check git status
git status

# View atomic commits
git log --oneline -10

# Bisect to find failing task
git bisect start
```

---

## 📝 Quick Reference

### Most Used Commands

```bash
/gsd:new-project          # Start
/gsd:discuss-phase N      # Discuss
/gsd:plan-phase N         # Plan
/gsd:execute-phase N      # Execute
/gsd:verify-work N        # Verify
/gsd:quick                # Quick task
/gsd:help                 # Help
```

### Model Profiles

```bash
/gsd:set-profile quality    # Best for critical work
/gsd:set-profile balanced   # Default
/gsd:set-profile budget     # High-volume work
```

### Session Management

```bash
/gsd:pause-work             # Save state
/gsd:resume-work            # Restore state
/gsd:add-todo "idea"        # Capture idea
/gsd:check-todos            # List todos
```

---

*GSD Command Reference v1.0.0*  
*Last Updated: 2026-03-18*
