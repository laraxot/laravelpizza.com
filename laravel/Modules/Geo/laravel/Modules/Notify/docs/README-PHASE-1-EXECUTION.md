# 📖 README - PHASE 1 EXECUTION
## Entry Point for All Team Members

**Created**: 2026-04-08 07:50 UTC  
**Phase**: 1 - HTML Structural Parity  
**Status**: 🟠 EXECUTION IN PROGRESS  
**Target**: segnalazioni-elenco → 90% HTML parity

---

## 🎯 QUICK ORIENTATION

**WHERE AM I?**
- Phase 1 Research is COMPLETE ✅
- Phase 1 Execution is ACTIVE 🟠
- Subtask 1 is RUNNING (comparison script)
- Subtasks 2-6 are queued and ready

**WHAT DO I DO?**
1. **If you're Executor #1**: Monitor Subtask 1, prepare for Subtask 5
2. **If you're Researcher**: Prepare for Subtask 2 analysis
3. **If you're Executor #2**: Read prep docs, be ready for Subtasks 3 & 4
4. **If you're new**: Start with "New Team Members" section below

---

## 📚 DOCUMENT NAVIGATION

### 🎯 STATUS & COORDINATION (START HERE)
| Document | Purpose | Read Time |
|----------|---------|-----------|
| **PHASE-1-EXECUTION-DASHBOARD.md** | Multi-agent coordination board | 5 min |
| **PHASE-1-EXECUTION-STATUS.md** | Real-time progress tracking | 5 min |
| **PHASE-1-RESEARCH-COMPLETE.md** | Session summary (Italian) | 10 min |

### 📋 STRATEGY & PLANNING
| Document | Purpose | Read Time |
|----------|---------|-----------|
| **PHASE-1-STRATEGY.md** | Complete research & strategy | 20 min |
| **GSD-PHASE-1-EXECUTION.md** | Execution plan with all 6 subtasks | 15 min |
| **00-INDEX.md** | Master documentation index | 10 min |

### 🔧 TOOLS & SCRIPTS
| Document | Purpose | Read Time |
|----------|---------|-----------|
| **bashscripts/docs/html/INDEX.md** | HTML comparison tools docs | 10 min |

### 👥 TASK-SPECIFIC WORKFLOWS
| Document | For | Purpose | Read Time |
|----------|-----|---------|-----------|
| **SUBTASK-2-ANALYSIS-WORKFLOW.md** | Researcher | How to analyze findings | 15 min |
| **EXECUTOR-2-SUBTASKS-3-4.md** | Executor #2 | How to fix blade & verify JSON | 20 min |
| **PHASE-1-FINDINGS-TEMPLATE.md** | Researcher | Template for gap analysis | 10 min |

### 📁 OUTPUT LOCATIONS
```
laravel/Themes/Sixteen/docs/
├─ PHASE-1-STRATEGY.md                    (strategy)
├─ GSD-PHASE-1-EXECUTION.md               (execution plan)
├─ 00-INDEX.md                            (master index)
├─ PHASE-1-EXECUTION-STATUS.md            (progress tracking)
├─ body-structure-comparison/
│  └─ segnalazioni-elenco/
│     ├─ comparison-report.json           ← Subtask 1 output
│     ├─ parity-summary.txt               ← Subtask 1 output
│     ├─ reference-body.html              ← Subtask 1 output
│     └─ local-body.html                  ← Subtask 1 output
└─ prompts/segnalazione_disservizio/
   ├─ PHASE-1-FINDINGS.md                 ← Subtask 2 output
   ├─ PHASE-1-FINDINGS-TEMPLATE.md        (template)
   ├─ EXECUTOR-2-SUBTASKS-3-4.md          (workflow)
   ├─ SUBTASK-2-ANALYSIS-WORKFLOW.md      (workflow)
   └─ PHASE-1-COMPLETION-REPORT.md        ← Subtask 6 output
```

---

## 👤 ROLE-BASED GUIDES

### 🔴 EXECUTOR #1 (Comparison & Verification)

**Your Role**: Run comparison scripts and verify parity

**Subtask 1** (NOW):
- ✅ Run: `./bashscripts/body/html-structure-compare.sh segnalazioni-elenco`
- 📍 Status: RUNNING (started 07:41 UTC, ~15-20 min)
- 📤 Output: comparison-report.json + parity-summary.txt
- 📞 Next: Notify Researcher when complete

**Subtask 5** (LATER):
- ⏳ Run same script again after fixes
- ✅ Verify: Parity ≥ 90%
- 📞 Notify: Researcher with new parity score

**Read First**:
1. PHASE-1-EXECUTION-STATUS.md (overview)
2. GSD-PHASE-1-EXECUTION.md § Subtask 1 (details)

---

### 🔵 RESEARCHER (Analysis & Documentation)

**Your Role**: Analyze findings and document outcomes

**Subtask 2** (NEXT):
- ⏳ Input: comparison-report.json from Executor #1
- 📝 Create: PHASE-1-FINDINGS.md with gap analysis
- 📞 Output: Share findings with Executor #2

**Subtask 6** (LATER):
- ⏳ Input: Final comparison results from Subtask 5
- 📝 Create: PHASE-1-COMPLETION-REPORT.md
- 🔄 Update: 00-INDEX.md with Phase 1 status

**Read First**:
1. PHASE-1-EXECUTION-STATUS.md (overview)
2. SUBTASK-2-ANALYSIS-WORKFLOW.md (your workflow)
3. GSD-PHASE-1-EXECUTION.md § Subtask 2 (details)

---

### 🟢 EXECUTOR #2 (Implementation)

**Your Role**: Fix blade template and verify JSON

**Subtask 3** (AFTER Subtask 2):
- 📝 Input: PHASE-1-FINDINGS.md from Researcher
- 🔧 File: `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`
- 📝 Tasks: Add semantic elements, fix classes, replace text with trans()
- 📤 Output: Updated blade template

**Subtask 4** (PARALLEL with Subtask 3):
- 📝 Input: PHASE-1-FINDINGS.md from Researcher
- 🔧 File: `laravel/config/local/fixcity/database/content/pages/tests.segnalazioni-elenco.json`
- ✅ Tasks: Verify all sections, check translation keys
- 📤 Output: Verified JSON file

**Read First**:
1. PHASE-1-EXECUTION-STATUS.md (overview)
2. EXECUTOR-2-SUBTASKS-3-4.md (detailed workflow)
3. GSD-PHASE-1-EXECUTION.md § Subtask 3 & 4 (details)

---

## 🆕 NEW TEAM MEMBERS

**Getting up to speed in 30 minutes:**

1. **Read (5 min)**: PHASE-1-RESEARCH-COMPLETE.md
   - Understand what was researched and why

2. **Read (5 min)**: PHASE-1-EXECUTION-DASHBOARD.md
   - Understand current status and your role

3. **Read (10 min)**: PHASE-1-STRATEGY.md § Executive Summary + segnalazioni-elenco Analysis
   - Understand the reference and what needs to match

4. **Skim (5 min)**: GSD-PHASE-1-EXECUTION.md
   - Understand all 6 subtasks and dependencies

5. **Read your role guide** above (5 min)
   - Know exactly what you need to do

---

## 🚀 CURRENT EXECUTION STATUS

```
PHASE 1 WORKFLOW (as of 07:50 UTC)

✅ DONE: Research & Planning Phase (Phase 0)
         └─ 5 major documents created
         └─ Infrastructure ready

🟠 RUNNING: Subtask 1 - Comparison Script (Executor #1)
           └─ Started: 07:41 UTC
           └─ Agent: executor-phase1-subtask1
           └─ Duration so far: ~9 minutes
           └─ Expected completion: 07:55-08:00 UTC

⏳ READY: Subtasks 2-6 (all workflows prepared)
```

---

## 📊 SUCCESS METRICS

### Phase 1 Complete When:
- ✅ Parity score ≥ 90%
- ✅ All semantic elements present
- ✅ All Bootstrap classes aligned
- ✅ All text using trans() (no hardcoded)
- ✅ All ARIA attributes correct
- ✅ Findings documented
- ✅ Completion report created

### Timeline:
- **Expected**: 90-150 minutes total
- **Best case (parallel)**: ~90 minutes
- **Realistic**: ~120 minutes

---

## 🔗 KEY CROSS-REFERENCES

**Translation Pattern** (CRITICAL):
- ✅ Correct: `fixcity::segnalazione.fields.title.label`
- ❌ Wrong: `SEGNALAZIONE::SEGNALAZIONE.ELENCO.TITLE`
- See: PHASE-1-STRATEGY.md § Translation Patterns

**File Locations**:
- ✅ Blade: `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`
- ✅ JSON: `laravel/config/local/fixcity/database/content/pages/tests.segnalazioni-elenco.json`
- ✅ Script: `./bashscripts/body/html-structure-compare.sh`
- ❌ DON'T CREATE: `segnalazioni-elenco.blade.php` (use [slug].blade.php)

**Reference URLs**:
- Design Comuni: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazioni-elenco.html
- Local: http://127.0.0.1:8000/it/tests/segnalazioni-elenco

---

## 💬 COMMUNICATION PROTOCOL

### Status Updates (Every Agent)
- Report progress: ✅ Complete / 🟠 In Progress / ⏳ Blocked
- Share blockers/questions immediately
- Update PHASE-1-EXECUTION-STATUS.md

### Handoffs (Between Subtasks)
- Previous agent: Notify next agent + share deliverables
- Next agent: Confirm receipt and ready status
- Use clear message format (see EXECUTION-DASHBOARD.md)

### Questions/Issues
- Check documentation first (comprehensive coverage)
- Ask in Researcher coordination channel
- Create blocker issue if unsure

---

## 🎯 PHASE 1 EXECUTION CHECKLIST

Before starting your subtask:

**All Agents**:
- [ ] Read PHASE-1-EXECUTION-STATUS.md
- [ ] Understand the 6 subtasks and dependencies
- [ ] Know the translation pattern
- [ ] Have reference URLs bookmarked

**Executor #1**:
- [ ] Read GSD-PHASE-1-EXECUTION.md § Subtask 1
- [ ] Verify bash scripts are executable
- [ ] Know where to save output

**Researcher**:
- [ ] Read SUBTASK-2-ANALYSIS-WORKFLOW.md
- [ ] Have template ready: PHASE-1-FINDINGS-TEMPLATE.md
- [ ] Understand gap categorization (HIGH/MEDIUM/LOW)

**Executor #2**:
- [ ] Read EXECUTOR-2-SUBTASKS-3-4.md
- [ ] Understand blade template structure
- [ ] Know JSON requirements
- [ ] Have translation keys checklist ready

---

## 📞 HELP & SUPPORT

**For questions about**:
- **Strategy**: PHASE-1-STRATEGY.md
- **Execution**: GSD-PHASE-1-EXECUTION.md
- **Tools**: bashscripts/docs/html/INDEX.md
- **Blade fixes**: EXECUTOR-2-SUBTASKS-3-4.md
- **Analysis**: SUBTASK-2-ANALYSIS-WORKFLOW.md
- **Status**: PHASE-1-EXECUTION-STATUS.md

**Common Questions**:
- "Why this approach?" → PHASE-1-STRATEGY.md § Executive Summary
- "What's my task?" → Your role guide above
- "Where's the output?" → Output Locations section
- "What's the parity score?" → Wait for Subtask 1, then check PHASE-1-EXECUTION-STATUS.md

---

## 🎓 LEARNING RESOURCES

**Quick (5-10 min)**:
- PHASE-1-RESEARCH-COMPLETE.md (Italian summary)
- PHASE-1-EXECUTION-DASHBOARD.md (status board)

**Medium (15-20 min)**:
- PHASE-1-STRATEGY.md (strategy overview)
- Your role-specific workflow guide

**Deep (30-45 min)**:
- GSD-PHASE-1-EXECUTION.md (all subtasks)
- Reference HTML analysis (open reference URL)
- Current blade template code

---

## ✨ KEY HIGHLIGHTS

🟢 **What's Working**:
- Clear documentation structure
- Agnostic script design
- Multi-agent coordination model
- Dependency chain clarity
- Pre-created workflows for all subtasks

⚠️ **Potential Challenges**:
- If Subtask 1 fails: fallback to manual inspection
- Communication latency between agents
- Time pressure if fixes take longer

🛡️ **Safeguards**:
- Frequent status updates (every 10-15 min)
- Pre-created documentation
- Clear success criteria
- Rollback paths defined

---

## 🚀 WHAT'S NEXT AFTER PHASE 1

**When Phase 1 SUCCESS** (parity ≥ 90%):
1. Phase 2 strategy (CSS alignment)
2. Phase 2 execution (design tokens, colors, typography)
3. Phase 3 strategy (JavaScript behavior)
4. Phase 3 execution (tabs, filters, forms)
5. Scaling (apply to all 48 pages)

**If Phase 1 NEEDS ITERATION** (parity 70-89%):
1. Researcher identifies remaining gaps
2. Executor #2 applies additional fixes
3. Executor #1 re-verifies
4. Loop until ≥ 90%

---

## 📋 QUICK REFERENCE TABLE

| What | File | Location | Status |
|------|------|----------|--------|
| Strategy | PHASE-1-STRATEGY.md | laravel/Themes/Sixteen/docs/ | ✅ DONE |
| Execution Plan | GSD-PHASE-1-EXECUTION.md | laravel/Themes/Sixteen/docs/ | ✅ DONE |
| Master Index | 00-INDEX.md | laravel/Themes/Sixteen/docs/ | ✅ DONE |
| Tool Docs | bashscripts/docs/html/INDEX.md | bashscripts/docs/html/ | ✅ DONE |
| Comparison Script | html-structure-compare.sh | bashscripts/body/ | ✅ READY |
| Blade Fixes | [slug].blade.php | laravel/Themes/Sixteen/resources/views/pages/tests/ | ⏳ PENDING |
| JSON Verify | tests.segnalazioni-elenco.json | laravel/config/local/fixcity/database/content/pages/ | ⏳ PENDING |
| Analysis Results | PHASE-1-FINDINGS.md | laravel/Themes/Sixteen/docs/prompts/segnalazione_disservizio/ | ⏳ PENDING |
| Completion | PHASE-1-COMPLETION-REPORT.md | laravel/Themes/Sixteen/docs/prompts/segnalazione_disservizio/ | ⏳ PENDING |

---

**Status**: 🟠 EXECUTION IN PROGRESS

**Last Update**: 2026-04-08 07:50 UTC  
**Next Update**: When Subtask 1 completes (~15-20 min)

**Coordinator**: Researcher Agent (BMAD Mode C)

---

*All team members: Check this document for orientation. Read your role-specific guide. Be ready when your subtask is called.*

🚀 **Let's reach 90% parity!**
