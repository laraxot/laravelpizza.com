# FixCity Improvement Plan - OpenViking + BMAD + GSD + Ralph Loop

**Created**: 2026-03-30  
**Status**: ✅ **READY TO EXECUTE**  
**Project**: FixCity Platform Improvement  

---

## 🎯 Executive Summary

I've created a comprehensive **16-week improvement plan** for FixCity using the integrated AI agent workflow (OpenViking + BMAD + GSD + Ralph Loop).

### Current State → Target State

| Metric | Current | Target | Improvement |
|--------|---------|--------|-------------|
| **Test Coverage** | 40% | 85% | +45% |
| **TTFB** | 780ms | 200ms | -580ms (74% faster) |
| **DB Queries/Page** | 87 | <10 | -77 (88% reduction) |
| **Documentation** | 130 files (chaos) | Organized | Structured |
| **CI/CD** | 60% pass rate | 95%+ | Fully automated |

**Total Effort**: ~260-290 hours (8-10 weeks with 3 AI agents)

---

## ✅ What's Been Completed

### 1. OpenViking Initialization ✅
- **Status**: Initialized and indexed
- **Indexed**: All 232+ markdown files across docs/, Modules/, Themes/
- **Context**: Project memories created
- **Skills**: Registered (laraxot-core, filament, PHPStan, BMAD, GSD, Ralph)

### 2. GSD Project Structure ✅
- **PROJECT.md**: Comprehensive project context created
- **config.json**: 4 milestones, 12 phases defined
- **Roadmap**: 16-week timeline (2026-03-30 → 2026-10-12)

### 3. BMAD PRD ✅
- **Requirements**: Clear success criteria per phase
- **Architecture**: Documented layered architecture
- **Stakeholders**: AI agent teams defined
- **Risks**: Assessed and mitigated

---

## 📋 16-Week Roadmap

### Phase 1: Foundation & Documentation (Weeks 1-4) 🔴 IN PROGRESS

#### 1.1 Documentation Organization (40h)
**Goals**:
- Organize 130 docs in root → structured folders
- Remove 16 duplicate roadmaps → keep 2-3
- Create master documentation index
- Remove all temporal strings (784 already removed)
- Document AI agent workflows

**UAT Criteria**:
- ✅ All docs in correct folders (docs/<category>/)
- ✅ Only 2-3 roadmap files remain
- ✅ Master index created and linked
- ✅ Zero temporal strings in docs
- ✅ AI workflow docs complete

#### 1.2 GitHub Actions & CI/CD (20h)
**Goals**:
- Fix failing CI Quality tests
- Complete semantic versioning workflows
- Setup automated subtree sync
- Add performance monitoring

**UAT Criteria**:
- ✅ All GitHub Actions passing (green checks)
- ✅ Semantic versioning working for all modules
- ✅ Subtree sync automatic on dev push
- ✅ Performance metrics in every PR

---

### Phase 2: Test Coverage Improvement (Weeks 5-8) 🟡 PENDING

#### 2.1 Test Infrastructure (30h)
**Goals**:
- Fix all test syntax errors
- Setup test coverage reporting
- Create test templates per module
- Train Ralph Loop on test generation

**Target**: Coverage 40% → 60%

#### 2.2 Unit Tests - Critical Modules (45h)
**Modules**:
- Fixcity (ticket logic): 90% coverage
- User (authentication): 90% coverage
- Cms (content): 85% coverage
- Geo (geocoding): 85% coverage

**Target**: Coverage 60% → 80%

#### 2.3 Integration & E2E Tests (45h)
**Goals**:
- 5+ critical user flows tested E2E
- All API endpoints tested
- Admin workflows covered
- E2E tests run in CI/CD

**Target**: Coverage 80% → 85%

---

### Phase 3: Performance Optimization (Weeks 9-12) 🟡 PENDING

#### 3.1 Database Query Optimization (30h)
**Goals**:
- Add eager loading (fix N+1 queries)
- Optimize worst 10 queries
- Add database indexes
- Query count: 87 → 40

**Target**: TTFB 780ms → 400ms

#### 3.2 Caching Strategy (25h)
**Goals**:
- Redis cache setup
- Cache frequently accessed data
- Cache view fragments
- Cache invalidation strategy

**Target**: Cache hit rate >70%

#### 3.3 Frontend Performance (25h)
**Goals**:
- Optimize asset loading
- Lazy load images/maps
- Minimize JavaScript bundles
- Enable HTTP/2 push

**Target**: Page load 2s → <1s

---

### Phase 4: Production Ready (Weeks 13-16) 🟡 PENDING

#### 4.1 PostgreSQL Migration (20h)
**Goals**:
- Setup PostgreSQL production instance
- Migrate data from SQLite
- Test all queries on PostgreSQL
- Rollback plan documented

#### 4.2 Final Polish & Monitoring (20h)
**Goals**:
- Performance monitoring (Laravel Pulse)
- Error tracking (Sentry)
- Uptime monitoring
- Alert configuration

**Target**: TTFB 400ms → 200ms

#### 4.3 Documentation & Handoff (20h)
**Goals**:
- Update all module READMEs
- Create deployment guide
- Create operations manual
- Record demo videos

---

## 🤖 AI Agent Workflow

### How It Works

```
┌─────────────────────────────────────────────────┐
│  1. OpenViking (Context Management)             │
│     - Indexes all documentation                 │
│     - Provides context to AI agents             │
│     - Stores project memories                   │
└─────────────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────────────┐
│  2. BMAD (Requirements & Architecture)          │
│     - Creates PRDs                              │
│     - Designs architecture                      │
│     - Creates epics & stories                   │
└─────────────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────────────┐
│  3. GSD (Phase Execution)                       │
│     - Plans phases                              │
│     - Executes tasks                            │
│     - Verifies completion                       │
└─────────────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────────────┐
│  4. Ralph Loop (Autonomous Implementation)      │
│     - Iterative implementation                  │
│     - Checkpoint management                     │
│     - Quality gates                             │
└─────────────────────────────────────────────────┘
```

### Commands Reference

#### OpenViking
```bash
# Check status
openviking status

# Search context
openviking search "your query"

# List resources
openviking ls /

# Add memory
openviking add-memory --title="Title" --content="Content"
```

#### BMAD
```bash
# Create PRD
/bmad-create-prd

# Create architecture
/bmad-create-architecture

# Create epics and stories
/bmad-create-epics-and-stories
```

#### GSD
```bash
# Discuss phase
/gsd-discuss-phase 1

# Plan phase
/gsd-plan-phase 1

# Execute phase
/gsd-execute-phase 1

# Verify work
/gsd-verify-work 1
```

#### Ralph Loop
```bash
# Setup PRD
cp .planning/phase-1.json .ralph/prd.json

# Run autonomous loop
./.ralph/ralph-loop.sh 20 true  # 20 iterations, verbose
```

---

## 📊 Success Metrics

### Week 4 (Phase 1 End)
- [ ] Documentation organized
- [ ] All GitHub Actions passing
- [ ] OpenViking fully operational
- [ ] GSD structure created

### Week 8 (Phase 2 End)
- [ ] Test coverage: 65%
- [ ] All test syntax errors fixed
- [ ] Integration tests for critical paths

### Week 12 (Phase 3 End)
- [ ] TTFB: 400ms
- [ ] DB queries: 40/page
- [ ] Eager loading implemented
- [ ] Caching deployed

### Week 16 (Phase 4 End)
- [ ] Test coverage: 85%
- [ ] TTFB: 200ms
- [ ] DB queries: <10/page
- [ ] PostgreSQL migrated
- [ ] CI/CD fully automated

---

## 🚀 Next Steps

### Immediate (Today)
1. ✅ OpenViking initialized
2. ✅ GSD structure created
3. ✅ PRD created (this document)
4. ⏳ **Start Phase 1.1: Documentation Organization**

### This Week
1. Run `/gsd-discuss-phase 1.1` to plan documentation cleanup
2. Run `/gsd-plan-phase 1.1` to create detailed plan
3. Run `/gsd-execute-phase 1.1` to execute cleanup
4. Fix failing GitHub Actions

### Next 2 Weeks
1. Complete Phase 1.1 (Documentation)
2. Complete Phase 1.2 (CI/CD)
3. Setup Ralph Loop for autonomous test generation
4. Begin Phase 2.1 (Test Infrastructure)

---

## 🎯 How to Start Execution

### Option 1: Manual Execution (Recommended for Learning)

```bash
# 1. Discuss Phase 1.1
/gsd-discuss-phase 1.1

# 2. Plan Phase 1.1
/gsd-plan-phase 1.1

# 3. Execute Phase 1.1
/gsd-execute-phase 1.1

# 4. Verify Phase 1.1
/gsd-verify-work 1.1
```

### Option 2: Autonomous Execution (Ralph Loop)

```bash
# 1. Copy phase plan to Ralph
cp .planning/phase-1.1.json .ralph/prd.json

# 2. Run Ralph Loop
./.ralph/ralph-loop.sh 20 true

# Ralph will:
# - Read PRD
# - Implement stories
# - Run tests
# - Create checkpoints
# - Iterate until complete
```

### Option 3: Full Autonomous Mode

```bash
# Run all phases autonomously
/gsd-autonomous

# GSD will:
# - Discuss all phases
# - Plan all phases
# - Execute all phases
# - Verify all phases
```

---

## 📚 Documentation Created

| File | Purpose | Size |
|------|---------|------|
| `.planning/PROJECT.md` | Project context & overview | 8KB |
| `.planning/config.json` | Roadmap & configuration | 9KB |
| `.planning/research/FIXCITY_PROJECT_RESEARCH_SUMMARY.md` | Research summary | 47KB |
| `FIXCITY_IMPROVEMENT_PLAN.md` | This document | 12KB |

---

## 🔍 Risk Assessment

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|------------|
| **Documentation Overwhelm** | Medium | Low | Incremental cleanup, prioritize critical |
| **Test Coverage Gap** | High | High | Focus on critical paths first |
| **Performance Regression** | Medium | High | Baseline metrics, monitor every change |
| **CI/CD Complexity** | Medium | Medium | Fix one workflow at a time |
| **AI Agent Learning Curve** | Low | Low | This guide provides examples |

---

## 💡 Key Insights from Research

### What's Working Well
1. **PHPStan Level 10**: Zero errors - excellent code quality foundation
2. **Modular Architecture**: 17 modules well-organized with Laraxot
3. **AI Agent Ready**: OpenViking, BMAD, GSD, Ralph all installed
4. **Documentation Culture**: 232+ markdown files show commitment

### What Needs Improvement
1. **Documentation Organization**: 130 files in root docs/ folder
2. **Roadmap Duplicates**: 16 roadmap files (should be 2-3)
3. **Test Coverage**: 40% vs 85% target
4. **Performance**: 780ms TTFB vs 200ms target
5. **CI/CD**: Some GitHub Actions failing

---

## 🎓 Lessons Learned

### Multi-Agent Collaboration
- ✅ **Strength**: Parallel work - multiple tasks simultaneously
- ✅ **Strength**: Diverse perspectives - different AI agents
- ✅ **Strength**: Cross-verification - agents verify each other
- ⚠️ **Challenge**: Coordination overhead
- ⚠️ **Challenge**: Communication via GitHub issues

### OpenViking Best Practices
- ✅ Index all documentation before starting
- ✅ Create project memories for key decisions
- ✅ Use `viking://` URIs for linking
- ⚠️ Server must be running (start with `openviking server start`)

### GSD Best Practices
- ✅ Plan one phase at a time
- ✅ Verify before executing
- ✅ Use checkpoints for long phases
- ✅ Run quality checks after each phase

### Ralph Loop Best Practices
- ✅ Start with small, well-defined stories
- ✅ Set checkpoint frequency (every 15 min)
- ✅ Review checkpoints before continuing
- ✅ Use quality gates (tests, PHPStan)

---

## 📞 Support & Resources

### Documentation
- **OpenViking**: `docs/openviking-integration.md`
- **BMAD/GSD/Ralph**: `docs/bmad-gsd-ralph-integration.md`
- **Unified Workflow**: `docs/unified-ai-workflow.md`
- **Project Research**: `.planning/research/FIXCITY_PROJECT_RESEARCH_SUMMARY.md`

### Commands
- **OpenViking**: `openviking --help`
- **BMAD**: `/bmad-help`
- **GSD**: `/gsd-help`
- **Ralph**: `./.ralph/ralph-loop.sh --help`

### GitHub
- **Issues**: Track progress on GitHub Issues
- **Actions**: Monitor CI/CD pipelines
- **Projects**: View roadmap and milestones

---

## ✅ Approval to Proceed

**Ready to start Phase 1.1: Documentation Organization**

To begin execution, choose one:

**Option A: Interactive (Recommended)**
```bash
/gsd-discuss-phase 1.1
```

**Option B: Autonomous**
```bash
/gsd-autonomous
```

**Option C: Ralph Loop**
```bash
# Copy phase plan
cp .planning/config.json .ralph/prd.json

# Run Ralph
./.ralph/ralph-loop.sh 20 true
```

---

**Status**: ✅ **READY FOR EXECUTION**  
**Next Step**: Run `/gsd-discuss-phase 1.1` to start Phase 1.1  
**ETA**: 4 weeks for Phase 1, 16 weeks for full project
