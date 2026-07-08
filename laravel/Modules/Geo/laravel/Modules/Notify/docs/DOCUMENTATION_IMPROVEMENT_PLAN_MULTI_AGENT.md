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
- [ ] `/docs/DOCUMENTATION_GOVERNANCE.md`
- [ ] `/docs/phpstan/README.md`
- [ ] `/docs/OLLAMA_OPTIMIZATION_GUIDE.md`
- [ ] `/docs/GITHUB_SYNC_RULE.md`
- [ ] (15+ more)

#### Task 1.2: Consolidate Roadmaps

**From**: 16 files  
**To**: 2-3 files  
**Effort**: 1 hour  
**Agent**: TBD

**Keep**:
- [ ] `MASTER_ROADMAP.md` (current platform roadmap)
- [ ] `project_docs/roadmaps/roadmap-master.md` (detailed technical)
- [ ] `project_docs/roadmaps/roadmap-documentation.md` (this doc)

**Archive** (move to `docs/archive/roadmaps/`):
- [ ] `MASTER_ROADMAP_2025.md`
- [ ] `PROJECT-ROADMAP.md`
- [ ] `PROJECT_ROADMAP.md`
- [ ] `roadmap.md`
- [ ] `roadmap_project.md`
- [ ] `ROADMAP_STATUS_SUMMARY.md`
- [ ] `ROADMAP_UPDATE_PLAN.md`
- [ ] `project_docs/ROADMAP.md`
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
- [ ] `PROJECT_STATUS.md` (create new, current status)
- [ ] `docs/project_docs/status/HISTORICAL_COMPLETION_REPORTS.md` (archive index)

**Archive** (move to `docs/archive/completion-reports/`):
- [ ] `ABSOLUTE_COMPLETION_100.md`
- [ ] `PERFECTION_ACHIEVED.md`
- [ ] `PROJECT_COMPLETION_REPORT.md`
- [ ] `PROJECT_COMPLETION_STATUS.md`
- [ ] `ULTIMATE_COMPLETION_REPORT.md`
- [ ] `SUPER_MUCCA_COMPLETION.md`
- [ ] `project_docs/PROJECT_COMPLETION_CERTIFICATE.md`
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
- [ ] `BOOST_SKILL_INSTALLATION_ERROR.md`
- [ ] `BOOST_SKILL_INSTALLATION_SUCCESS.md`
- [ ] `BOOST_SKILL_SOLUTION_PLAN.md`
- [ ] `FOLIO_ROUTING_FIX.md`
- [ ] `LOGIN_PAGE_STATUS.md`
- [ ] `LOGIN_PAGE_TRANSLATION_FIX.md`
- [ ] `LOGIN_TIMEOUT_ISSUE.md`

**To `project_docs/status/`**:
- [ ] All completion reports
- [ ] All refactoring reports
- [ ] `MISSION_ACCOMPLISHED.md`
- [ ] `PROJECT_COMPLETION_CERTIFICATE.md`

**To `archive/misc/`**:
- [ ] `TAILWIND_CONVERSION_COMPLETE.md`
- [ ] `log-cleanup-report.md`
- [ ] `mixed-type-ultima-spiaggia.md`
- [ ] (other orphaned temporary files)

#### Task 2.2: Standardize Naming

**Files**: 20+ files  
**Effort**: 2 hours  
**Agent**: TBD

**Rename to kebab-case**:
- [ ] `DryTraitMethods.md` → `dry-trait-methods.md`
- [ ] `README_ANALISI_DUPLICATI.md` → `readme-analisi-duplicati.md`
- [ ] `ANALISI_METODI_DUPLICATI_MASTER.md` → `analisi-metodi-duplicati-master.md`
- [ ] `DOCUMENTATION_IMPROVEMENT_SUMMARY_2026-03-13.md` → `documentation-improvement-summary.md`
- [ ] `PHPSTAN_GLOBAL_SUMMARY_2026-03-02.md` → `phpstan-global-summary.md`
- [ ] `GITHUB_ISSUES_RECOMMENDATIONS_2026-03-02.md` → `github-issues-recommendations.md`
- [ ] `SYSTEM_ADMIN_SUMMARY_2026-03-13.md` → `system-admin-summary.md`
- [ ] `LOGGING_OPTIMIZATION_SUMMARY_2026-03-02.md` → `logging-optimization-summary.md`

**Remove dates from filenames**:
- [ ] All files with `YYYY-MM-DD` pattern
- [ ] All files with `Month YYYY` pattern

#### Task 2.3: Update Index Files

**Effort**: 2 hours  
**Agent**: TBD

**Update**:
- [ ] `MASTER_DOCUMENTATION_INDEX.md` - Add new sections, remove broken links
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
- [ ] All refactoring reports → single `refactoring/SUMMARY.md`
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

- **Master Index**: `MASTER_DOCUMENTATION_INDEX.md`
- **Governance**: `DOCUMENTATION_GOVERNANCE.md`
- **Coordination**: `bashscripts/docs/git/SYNC_REMOTE_REPO_COORDINATION.md`
- **Analysis Report**: `docs/DOCUMENTATION_ANALYSIS_AND_IMPROVEMENT_PLAN.md`

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
