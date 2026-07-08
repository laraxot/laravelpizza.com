---
name: Bashscripts Philosophy
about: Document bashscripts philosophy and gitignore rules
title: "Philosophy: bashscripts/ must remain in .gitignore"
labels: ["philosophy", "gitignore", "bashscripts", "documentation"]
assignees: ""
---

## 🧘 Bashscripts Philosophy

**Status**: ✅ DOCUMENTED  
**Type**: Constitutional Rule  
**Priority**: SACRED 🔴

---

### 🎯 Principle

> **`bashscripts/` MUST remain in `.gitignore`**  
> **This is NOT a bug - it's a philosophical feature**

---

### 📋 The Philosophy

#### 1. Separation of Concerns

```
📦 Tracked Repository (Git)
└── Project code
    ├── Laravel app
    ├── Modules
    ├── Configurations
    └── Documentation

🛠️ Local Repository (Ignored)
└── Operator tools
    ├── Bash scripts
    ├── Local utilities
    ├── Deployment tools
    └── Personal automations
```

**Why**: Project code is **eternal**. Tools are **temporary**.

#### 2. Portability vs Personalization

| Tracked in Git | Ignored (bashscripts) |
|---------------|------------------------|
| ✅ Shared with team | ❌ Only yours |
| ✅ Versioned | ❌ Evolves freely |
| ✅ Review required | ❌ Free experimentation |
| ✅ Breaking changes = PR | ❌ Break as much as you want |
| ✅ Automatic deploy | ❌ Local only |

**The Zen**: What is **universal** gets versioned. What is **instrumental** stays local.

#### 3. Forward-Only for Code, Fluidity for Tools

```
Project code:          Tools:
    ↑                           ～
    │  Forward-Only             ～  Fluid
    │  Immutable                ～  Mutable
    │  Review                   ～  Experimental
    │  CI/CD                    ～  Manual
```

---

### 📚 Zen Analogies

#### The Carpenter and Tools

> The carpenter **does not nail tools to the workbench**.  
> Tools **change**, are **sharpened**, are **replaced**.  
> The **furniture** built is what **remains**.

```
bashscripts/  = Carpenter's tools
laravel/      = Furniture built
.gitignore    = Workbench that doesn't fix tools
```

#### The Chef and Knives

> A restaurant **does not put knives on the menu**.  
> Knives are **tools**, not **dishes**.  
> The **menu** is what the customer **sees and receives**.

```
bashscripts/  = Knives in kitchen
.gitignore    = Separation kitchen/dining room
Git repo      = Restaurant menu
```

---

### ✅ What TO DO

```bash
# 1. Create local scripts for personal automation
bashscripts/git/subtrees/sync_remote_repo.sh  # OK, it's yours

# 2. Experiment freely
bashscripts/experimental/new-sync-strategy.sh  # OK, break as much as you want

# 3. Optimize for YOUR workflow
bashscripts/backup/my-custom-backup.sh  # OK, it's personal

# 4. Have multiple versions
bashscripts/git/subtrees/sync_remote_repo_v1.sh
bashscripts/git/subtrees/sync_remote_repo_v2.sh
bashscripts/git/subtrees/sync_remote_repo.sh  # OK, local evolution
```

---

### ❌ What NOT TO DO

```bash
# 1. DO NOT remove bashscripts/ from .gitignore
git add bashscripts/  # ❌ WRONG!

# 2. DO NOT commit "temporary" scripts
git commit -m "Add sync script"  # ❌ If it's in bashscripts/

# 3. DO NOT confuse tools with code
# bashscripts/ ≠ Production code
# bashscripts/ ≠ Project feature
```

---

### 🏛️ Constitutional Rules

```
Article 1: bashscripts/ is sovereign local territory
Article 2: No external entity (Git, CI, Team) can violate this sovereignty
Article 3: Modification of bashscripts/ is operator's inalienable right
Article 4: Any attempt to version bashscripts/ is unconstitutional
```

---

### 🔄 When to Promote a Script to Code

#### Promotion Criteria

```bash
# FROM: bashscripts/my-script.sh (local)
# TO:   Production code (tracked)

WHEN:
1. ✅ Needed in CI/CD pipeline
2. ✅ Executed by GitHub Actions
3. ✅ Part of production deploy
4. ✅ Other team members need it
5. ✅ Critical for business

THEN:
1. Rewrite as PHP Action or Class
2. Or move to .github/workflows/
3. Or put in laravel/artisan/
4. Create PR with review
5. Tests + Documentation
```

#### Promotion Example

```bash
# BEFORE (local)
bashscripts/deploy-production.sh  # ❌ Only yours

# AFTER (production)
.github/workflows/deploy.yml      # ✅ Everyone's
app/Actions/DeployToProduction.php # ✅ Business logic
```

---

### 📊 Script Categories

#### 🟢 Local (Ignored - bashscripts/)

```
bashscripts/
├── git/
│   └── subtrees/
│       ├── sync_remote_repo.sh      # Your personal tool
│       ├── sync_remote_repo_v2.sh   # Your experimentation
│       └── reset_subtrees.sh        # Your utility
├── backup/
│   └── my-backup.sh                 # Your backup
├── optimization/
│   └── ollama-optimize.sh           # Your optimization
└── experimental/
    └── new-idea.sh                  # Your experimentation
```

**Status**: ✅ Ignored by Git - **TOTAL FREEDOM**

#### 🔴 Project (Tracked - if needed)

```
# If a script BECOMES production code:
laravel/
├── artisan                        # Versioned code
├── app/Actions/
│   └── SyncSubtreesAction.php     # Versioned business logic
└── .github/workflows/
    └── sync-subtrees.yml          # Versioned CI/CD
```

**Status**: ✅ Tracked by Git - **REVIEW + TEST**

---

### 🧘 Daily Zen Practices

#### Morning Meditation

```
Before creating a script, ask:
1. Is this a TOOL or is it CODE?
2. Does it serve ME or the TEAM?
3. Is it for EXPERIMENTATION or PRODUCTION?

If TOOL → bashscripts/ (ignored)
If CODE → laravel/ (tracked)
```

#### Evening Ritual

```bash
# Clean unused tools
find bashscripts/ -name "*-old.sh" -delete
find bashscripts/ -name "*.bak" -delete

# Tools wear out, code remains
```

---

### 📜 Bashscripts Manifesto

```
WE, operators of this project

DECLARE THAT:

1. bashscripts/ is and remains in .gitignore
2. Every operator has sovereignty over their scripts
3. Local experimentation is an inalienable right
4. Production code is sacred and versioned
5. Tools are fluid, code is eternal

WE SWEAR TO:

1. Not confuse tools with code
2. Not version local scripts
3. Promote to code only what is production
4. Respect separation of concerns
5. Keep the repo clean and portable

SO SWORN AND SO KEPT
```

---

### 📿 The Mantra

```
Repeat 3 times before committing:

"bashscripts is ignored, bashscripts is ignored, bashscripts is ignored"
"Tools are mine, code is ours"
"Git tracks value, ignores tools"
```

🧘 **Breathe. Let go. bashscripts is in .gitignore. All is as it should be.**

---

### 🔗 References

- [docs/bashscripts-philosophy.md](../docs/bashscripts-philosophy.md) - Full philosophical treatise
- [AGENTS.md](../AGENTS.md) - Agent guidelines with constitutional rule
- [docs/ai-agent-coordination.md](ai-agent-coordination.md) - AI coordination with bashscripts rules
- `.gitignore` - Project constitution
- `bashscripts/git/subtrees/docs/SYNC_NO_CONFLICTS.md` - Example of local script philosophy

---

### ✅ Completion Checklist

- [x] Create philosophical documentation
- [x] Update AGENTS.md with constitutional rule
- [x] Update AI coordination document
- [x] Create GitHub Issue template
- [x] Document sync_remote_repo.sh fixes
- [x] Explain why bashscripts/ must stay ignored

**Status**: ✅ PHILOSOPHY DOCUMENTED
