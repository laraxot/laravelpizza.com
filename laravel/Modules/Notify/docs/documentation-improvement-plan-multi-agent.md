---
title: "Documentation Improvement Plan - Multi-Agent Edition"
type: concept
tags: [documentation, improvement, plan, multi]
created: 2026-07-14
updated: 2026-07-14
qmd: "documentation-improvement-plan-multi-agent documentation improvement plan - multi-agent edition"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
---

# Documentation Improvement Plan - Multi-Agent Edition

> **Status**: 🟡 IN PROGRESS  
> **Priority**: CRITICAL  
> **Multi-Agent Task**: YES - Coordinate with other AI agents  
> **Started**: 2026-03-13  
> **Target**: 2026-03-20

---

## 🎯 Mission

Transform documentation from **chaotic but comprehensive** to **organized, governed, and multi-agent friendly**.

---

## 📊 Current State (Analysis Summary)

### Statistics
- **Total Markdown Files**: 232
- **Root Level Files**: 130 (TOO MANY!)
- **Subdirectories**: 18
- **README Coverage**: 55.6% (15/27 folders)
- **Temporal Strings**: 20+ violations
- **Duplicate Roadmaps**: 16 files (should be 2-3)
- **Completion Reports**: 11+ files (should be 1-2)

### Critical Issues

1. **❌ Temporal Strings Present** (violates governance)
2. **❌ Massive Duplication** (16 roadmaps, 11+ completion reports)
3. **❌ Inconsistent Naming** (mixed case, dates in filenames)
4. **❌ 130 Files in Root** (no organization)
5. **❌ 12 Folders Missing README**
6. **❌ 50+ Orphaned Files** (not linked from any index)

---

## 🤝 Multi-Agent Coordination

### Agent Teams Structure

| Team | Responsibility | Status | Agents |
|------|----------------|--------|--------|
| **Audit & Analysis** | Current state analysis | ✅ DONE | Qwen-Code-001 |
| **Cleanup** | Remove temporal strings, duplicates | ⏳ PENDING | Next Agent |
| **Organization** | Move files, create structure | ⏳ PENDING | Next Agent |
| **README Creation** | Create missing README files | ⏳ PENDING | Next Agent |
| **Index Update** | Update all index files | ⏳ PENDING | Next Agent |
| **Archive** | Move old files to archive | ⏳ PENDING | Next Agent |
| **Verification** | Verify all changes | ⏳ PENDING | Next Agent |

### How to Join

1. **Read this document** thoroughly
2. **Check coordination log**: `bashscripts/docs/git/SYNC_REMOTE_REPO_COORDINATION.md`
3. **Pick a task** from the backlog below
4. **Add your agent ID** to the team list
5. **Create lock file** (optional, for exclusive work):
   ```bash
   echo "Agent-XYZ-$(date -I)" > docs/DOCUMENTATION_IMPROVEMENT_PLAN.md.lock
   ```
6. **Execute task** and document results
7. **Remove lock file** when done
8. **Update this document** with progress

---

## 📋 Implementation Plan

### Phase 1: Quick Wins (Week 1) - PRIORITY 1

**Goal**: Immediate visible improvement

#### Task 1.1: Remove Temporal Strings

**Files**: 20+ files  
**Effort**: 2 hours  
**Agent**: TBD

**Patterns to remove**:
- `Last Updated: YYYY-MM-DD`
- `Aggiornato: DD Month YYYY`
- `Ultimo aggiornamento`
- `Next Review: YYYY-MM-DD`

**Command**:
```bash
# Find all temporal strings
grep -r "Last Updated:" docs/ --include="*.md"
grep -r "Aggiornato:" docs/ --include="*.md"
grep -r "Ultimo aggiornamento" docs/ --include="*.md"
```

**Action**: Edit files to remove temporal strings

**Files to fix**:
- [ ] `/docs/conventions/README.md`
- [ ] `/docs/documentation-governance.md`
- [ ] `/docs/phpstan/README.md`
- [ ] `/docs/ollama-optimization-guide.md`
- [ ] `/docs/github-sync-rule.md`
- [ ] (15+ more)

#### Task 1.2: Consolidate Roadmaps

**From**: 16 files  
**To**: 2-3 files  
**Effort**: 1 hour  
**Agent**: TBD

**Keep**:
- [ ] `master-roadmap.md` (current platform roadmap)
- [ ] `project_docs/roadmaps/roadmap-master.md` (detailed technical)
- [ ] `project_docs/roadmaps/roadmap-documentation.md` (this doc)

**Archive** (move to `docs/archive/roadmaps/`):
- [ ] `master-roadmap-2025.md`
- [ ] `project-roadmap.md`
- [ ] `project-roadmap.md`
- [ ] `roadmap.md`
- [ ] `roadmap-project.md`
- [ ] `roadmap-status-summary.md`
- [ ] `roadmap-update-plan.md`
- [ ] `project_docs/roadmap.md`
- [ ] `project_docs/roadmaps/roadmap-business.md`
- [ ] `project_docs/roadmaps/roadmap-quality.md`
- [ ] `project_docs/roadmaps/roadmap-technical.md`
- [ ] `project_docs/roadmaps/roadmap-update-system.md`

#### Task 1.3: Consolidate Completion Reports

**From**: 11+ files  
**To**: 1-2 files  
**Effort**: 1 hour  
**Agent**: TBD

**Keep**:
- [ ] `project-status.md` (create new, current status)
- [ ] `docs/project_docs/status/HISTORICAL_COMPLETION_REPORTS.md` (archive index)

**Archive** (move to `docs/archive/completion-reports/`):
- [ ] `absolute-completion.md`
- [ ] `absolute-completion-completamento-assoluto.md`
- [ ] `perfection-achieved.md`
- [ ] `project-completion-report.md`
- [ ] `project-completion-status.md`
- [ ] `ultimate-completion-report.md`
- [ ] `super-mucca-completion.md`
- [ ] `project_docs/project-completion-certificate.md`
- [ ] (4+ more in `project_docs/roadmaps/`)

#### Task 1.4: Create Missing README Files

**Folders**: 12 folders  
**Effort**: 2 hours  
**Agent**: TBD

**Create README.md in**:
- [ ] `/docs/actions/README.md` - Action pattern overview
- [ ] `/docs/bugs/README.md` - Bug tracking index
- [ ] `/docs/console/README.md` - Console commands overview
- [ ] `/docs/contracts/README.md` - Contracts overview
- [ ] `/docs/database/README.md` - Database documentation index
- [ ] `/docs/fixes/README.md` - Common fixes index
- [ ] `/docs/ollama/README.md` - Ollama configuration guide
- [ ] `/docs/prompts/README.md` - Prompts library index
- [ ] `/docs/quality/README.md` - Quality tools overview
- [ ] `/docs/regole-critiche/README.md` - Critical rules index
- [ ] `/docs/reports/README.md` - Reports index
- [ ] `/docs/testing/README.md` - Testing guide overview

---

### Phase 2: Organization (Week 2-3) - PRIORITY 2

#### Task 2.1: Organize Root Files

**From**: 130 files in root  
**To**: ~50 files in root  
**Effort**: 4 hours  
**Agent**: TBD

**Move to subdirectories**:

**To `archive/phpstan/`**:
- [ ] All `PHPSTAN_SESSION_*` files (6 files)
- [ ] All `PHPSTAN_*_2025*.md` files (4 files)
- [ ] `phpstan-global-summary.md` (if outdated)

**To `fixes/`**:
- [ ] `boost-skill-installation-error.md`
- [ ] `boost-skill-installation-success.md`
- [ ] `boost-skill-solution-plan.md`
- [ ] `folio-routing-fix.md`
- [ ] `login-page-status.md`
- [ ] `login-page-translation-fix.md`
- [ ] `login-timeout-issue.md`

**To `project_docs/status/`**:
- [ ] All completion reports
- [ ] All refactoring reports
- [ ] `mission-accomplished.md`
- [ ] `project-completion-certificate.md`

**To `archive/misc/`**:
- [ ] `tailwind-conversion-complete.md`
- [ ] `log-cleanup-report.md`
- [ ] `mixed-type-ultima-spiaggia.md`
- [ ] (other orphaned temporary files)

#### Task 2.2: Standardize Naming

**Files**: 20+ files  
**Effort**: 2 hours  
**Agent**: TBD

**Rename to kebab-case**:
- [ ] `drytraitmethods.md` → `dry-trait-methods.md`
- [ ] `readme-analisi-duplicati.md` → `readme-analisi-duplicati.md`
- [ ] `analisi-metodi-duplicati-master.md` → `analisi-metodi-duplicati-master.md`
- [ ] `DOCUMENTATION-IMPROVEMENT-SUMMARY-.md.md` → `documentation-improvement-summary.md`
- [ ] `PHPSTAN-GLOBAL-SUMMARY-.md.md` → `phpstan-global-summary.md`
- [ ] `GITHUB-ISSUES-RECOMMENDATIONS-.md.md` → `github-issues-recommendations.md`
- [ ] `SYSTEM-ADMIN-SUMMARY-.md.md` → `system-admin-summary.md`
- [ ] `LOGGING-OPTIMIZATION-SUMMARY-.md.md` → `logging-optimization-summary.md`

**Remove dates from filenames**:
- [ ] All files with `YYYY-MM-DD` pattern
- [ ] All files with `Month YYYY` pattern

#### Task 2.3: Update Index Files

**Effort**: 2 hours  
**Agent**: TBD

**Update**:
- [ ] `MASTER_documentation-index.md` - Add new sections, remove broken links
- [ ] `README.md` - Point to master index
- [ ] `project_docs/README.md` - Organize by topic
- [ ] `phpstan/README.md` - Link to archived sessions
- [ ] `github/README.md` - Add sync script docs

**Consider removing**:
- [ ] `index.md` (redundant with README.md)
- [ ] Duplicate indexes

---

### Phase 3: Content Audit (Week 4-6) - PRIORITY 3

#### Task 3.1: PHPStan Documentation Consolidation

**From**: 50+ files  
**To**: ~20 files  
**Effort**: 6 hours  
**Agent**: TBD

**Keep** (essential guides):
- [ ] `phpstan/README.md`
- [ ] `phpstan/livello-10.md`
- [ ] `phpstan/error-patterns.md`
- [ ] `phpstan/best-practices.md`

**Archive** (session reports):
- [ ] Move all session reports to `archive/phpstan/sessions/`
- [ ] Create index: `archive/phpstan/sessions/README.md`

**Consolidate** (error analysis):
- [ ] Merge similar error analysis reports
- [ ] Create single `phpstan/common-errors.md`

#### Task 3.2: project_docs Consolidation

**From**: 30+ files  
**To**: ~15 files  
**Effort**: 4 hours  
**Agent**: TBD

**Merge**:
- [ ] All completion certificates → single `status/COMPLETION_CERTIFICATE.md`
- [ ] All refactoring reports → single `refactoring/summary.md`
- [ ] Italian reports → translate or archive

**Organize**:
- [ ] Move to appropriate subdirectories
- [ ] Update cross-references

#### Task 3.3: Create Missing Documentation

**Effort**: 8 hours  
**Agent**: TBD

**Architecture**:
- [ ] `architecture/system-overview.md`
- [ ] `architecture/database-design.md`
- [ ] `architecture/adr-index.md` (Architectural Decision Records)

**Guides**:
- [ ] `guides/getting-started.md`
- [ ] `guides/developer-onboarding.md`
- [ ] `guides/module-development.md`

**References**:
- [ ] `references/api-reference.md`
- [ ] `references/models-reference.md`

**Troubleshooting**:
- [ ] `troubleshooting/common-issues.md`
- [ ] `troubleshooting/faq.md`

---

### Phase 4: Automation (Week 7-8) - PRIORITY 4

#### Task 4.1: Implement Markdown Linting

**Effort**: 4 hours  
**Agent**: TBD

**Tools**:
- [ ] `markdownlint` - Style and consistency
- [ ] Custom rules for temporal strings
- [ ] Custom rules for naming conventions

**Configuration**:
```json
{
  "default": true,
  "MD002": false,  // First header
  "MD013": false,  // Line length
  "MD024": { "siblings_only": true }  // Duplicate headers
}
```

**CI/CD Integration**:
- [ ] Add to GitHub Actions
- [ ] Fail on temporal strings
- [ ] Warn on naming violations

#### Task 4.2: Link Checker

**Effort**: 3 hours  
**Agent**: TBD

**Tool**: `markdown-link-check`

**CI/CD**:
- [ ] Run on every PR
- [ ] Report broken links
- [ ] Auto-create issues for broken links

#### Task 4.3: Documentation Templates

**Effort**: 3 hours  
**Agent**: TBD

**Create templates**:
- [ ] `.github/ISSUE_TEMPLATE/doc-improvement.md`
- [ ] `.github/PULL_REQUEST_TEMPLATE/doc-update.md`
- [ ] `docs/TEMPLATE.md` (general template)
- [ ] `docs/TEMPLATE_GUIDE.md` (how to use templates)

---

## 📊 Progress Tracking

### Overall Status

| Phase | Status | Progress | ETA |
|-------|--------|----------|-----|
| Phase 1: Quick Wins | ⏳ PENDING | 0% | Week 1 |
| Phase 2: Organization | ⏳ PENDING | 0% | Week 2-3 |
| Phase 3: Content Audit | ⏳ PENDING | 0% | Week 4-6 |
| Phase 4: Automation | ⏳ PENDING | 0% | Week 7-8 |

### Task Backlog

**Total Tasks**: 25+  
**Completed**: 0  
**In Progress**: 0  
**Pending**: 25+

### Agent Assignments

| Task | Agent | Status | Start Date | End Date |
|------|-------|--------|------------|----------|
| 1.1 Remove Temporal Strings | TBD | ⏳ | - | - |
| 1.2 Consolidate Roadmaps | TBD | ⏳ | - | - |
| 1.3 Consolidate Completion Reports | TBD | ⏳ | - | - |
| 1.4 Create Missing READMEs | TBD | ⏳ | - | - |
| 2.1 Organize Root Files | TBD | ⏳ | - | - |
| 2.2 Standardize Naming | TBD | ⏳ | - | - |
| 2.3 Update Index Files | TBD | ⏳ | - | - |
| 3.1 PHPStan Consolidation | TBD | ⏳ | - | - |
| 3.2 project_docs Consolidation | TBD | ⏳ | - | - |
| 3.3 Create Missing Docs | TBD | ⏳ | - | - |
| 4.1 Markdown Linting | TBD | ⏳ | - | - |
| 4.2 Link Checker | TBD | ⏳ | - | - |
| 4.3 Documentation Templates | TBD | ⏳ | - | - |

---

## 🎯 Success Metrics

### Quality Metrics

| Metric | Before | Target | Status |
|--------|--------|--------|--------|
| Temporal Strings | 20+ | 0 | ⏳ |
| Duplicate Roadmaps | 16 | 2-3 | ⏳ |
| Completion Reports | 11+ | 1-2 | ⏳ |
| Root Files | 130 | 50 | ⏳ |
| README Coverage | 55.6% | 90%+ | ⏳ |

### Structural Metrics

| Metric | Before | Target | Status |
|--------|--------|--------|--------|
| Folders with README | 15 | 25+ | ⏳ |
| Orphaned Files | 50+ | <10 | ⏳ |
| Naming Compliance | 80% | 100% | ⏳ |

### Content Metrics

| Metric | Before | Target | Status |
|--------|--------|--------|--------|
| PHPStan Files | 50+ | 20 | ⏳ |
| project_docs Files | 30+ | 15 | ⏳ |
| Missing Docs Created | 0 | 10+ | ⏳ |

---

## 📞 Multi-Agent Coordination

### Communication Channels

1. **GitHub Issues**: Track individual tasks
2. **GitHub Discussions**: General coordination
3. **Coordination Log**: `bashscripts/docs/git/SYNC_REMOTE_REPO_COORDINATION.md`
4. **This Document**: Master plan tracking

### Lock File Protocol

For exclusive work on specific tasks:

```bash
# Create lock
echo "Agent-XYZ-$(date -I)" > docs/DOCUMENTATION_IMPROVEMENT_PLAN.md.lock

# Remove lock
rm docs/DOCUMENTATION_IMPROVEMENT_PLAN.md.lock
```

### Agent Teams

**Join a team by adding your agent ID**:

| Team | Focus | Agents |
|------|-------|--------|
| **Cleanup** | Temporal strings, duplicates | TBD |
| **Organization** | File structure, naming | TBD |
| **README Creation** | Missing README files | TBD |
| **Content Audit** | PHPStan, project_docs | TBD |
| **Automation** | Linting, link checking | TBD |
| **Verification** | Quality assurance | TBD |

---

## 🔗 Related Documentation

- **Master Index**: `MASTER_documentation-index.md`
- **Governance**: `documentation-governance.md`
- **Coordination**: `bashscripts/docs/git/SYNC_REMOTE_REPO_COORDINATION.md`
- **Analysis Report**: `docs/documentation-analysis-and-improvement-plan.md`

---

## 📝 Agent Entry Template

```markdown
### Task Completion Report

**Task**: [Task number and name]  
**Agent ID**: [Your agent ID]  
**Date**: [YYYY-MM-DD]  
**Status**: ✅ COMPLETED / 🟡 IN PROGRESS / ❌ BLOCKED

**Changes Made**:
- [List specific changes]

**Files Modified**:
- [List files]

**Files Created**:
- [List files]

**Files Archived**:
- [List files]

**Testing**:
- [ ] All links verified
- [ ] No temporal strings added
- [ ] Naming conventions followed
- [ ] Index files updated

**Notes**:
[Any additional context, warnings, or recommendations for next agents]
```

---

**Created**: 2026-03-13  
**Created By**: Qwen-Code-001  
**Status**: 🟡 IN PROGRESS - Phase 1 Ready  
**Priority**: CRITICAL  
**Multi-Agent**: YES - Coordinate with other agents  
**Next Action**: Phase 1 - Quick Wins (Remove temporal strings, consolidate duplicates)
