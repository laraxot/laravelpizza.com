# Multi-Agent Coordination Protocol

**Effective**: 2026-03-05
**Philosophy**: Multiple agents work simultaneously on different modules to achieve 100% coverage faster

## Core Rule: "We Are Many"

❌ **WRONG**: Assume you're the only one working. Go sequentially module by module.
✅ **RIGHT**: Assume many agents are working in parallel. Coordinate via shared state (coverage-plan.md).

## Coordination Rules

### 0. Mandatory GitHub Sync (Always)
- Every agent must coordinate through both:
  - Coverage issue tracker: `https://github.com/laraxot/laravelpizza.com/issues/206`
  - Execution discussion thread: `https://github.com/laraxot/laravelpizza.com/discussions/207`
- Before starting a substantial batch:
  - check latest comments to avoid duplicate work already solved by other agents;
  - post a short claim with module/files you are taking.
- After completing the batch:
  - post results (pass/fail, command summary, touched files, coverage-plan delta);
  - release ownership of that batch.

### 1. Always Check Before Starting a Module
```bash
# Before touching a module:
grep -A 5 "^### YourModule" /var/www/_bases/base_laravelpizza/docs/coverage-plan.md

# If you see recent updates (same day), another agent might be working on it
# Choose a different module if possible
```

### 2. Mark Work-In-Progress
When you start a module, add this to coverage-plan.md:

```
### YourModule (YOUR_AGENT_NAME - IN PROGRESS)
- Status: Work in progress by Agent X
- Started: 2026-03-05 HH:MM UTC
- Expected: YY tests, ZZ% coverage
```

### 3. Avoid Collision-Prone Modules
**High Collision Risk** (many interdependencies):
- User (auth, oauth, models)
- Meetup (events, performers, relationships)
- Cms (pages, blocks)

**Low Collision Risk** (isolated logic):
- Geo (geolocation services)
- Job (background jobs)
- Seo (SEO metadata)
- Gdpr (privacy, data handling)
- Activity (event logging - depends on all, but tests are isolated)

### 4. Test Database Coordination
Different modules use different database connections. **Always run migrations before testing**:

```bash
php artisan migrate --database=yourmodule --env=testing
php artisan test Modules/YourModule
```

### 5. Update Coverage Plan After Every Batch
Format:
```
### ModuleName (2026-03-05 HH:MM UTC)
- ✅ COMPLETED: Added XX tests, achieved YY% coverage
- Tests: N passed
- Files covered: [file1, file2, ...]
- Commit: [hash]
```

### 6. Commit Message Convention
```
feat: add YourModule tests - batch Z

- Added N test files covering Y actions/models
- Achieved ZZ% coverage (target: XX%)
- Tests: N passed
- Modules touched: [list]

Co-authored-by: Copilot <223556219+Copilot@users.noreply.github.com>
```

## Execution Strategy (Anti-Sequential)

Instead of:
1. User → Meetup → Tenant → Xot (sequential, high collisions)

Do:
1. **Parallel Work** (different agents, different modules)
   - Agent 1: Geo (low risk)
   - Agent 2: Job (low risk)
   - Agent 3: Seo (low risk)
   - Agent 4: Gdpr (low risk)

2. **Monitor Collisions**
   - Check coverage-plan.md every 30 min
   - If another agent is on your module, switch

3. **Converge on Critical Path**
   - After low-risk modules, tackle User/Meetup/Tenant
   - More coordination needed, but foundation is solid

## Merge Conflict Prevention

### 1. Different Agents, Different Modules
- Agent 1 works on Geo tests
- Agent 2 works on Job tests
- → No conflicts ✅

### 2. Same Module, Different Aspects
- Agent 1 tests Meetup Actions
- Agent 2 tests Meetup Models
- → Use foreground/background batching, communicate in coverage-plan.md

### 3. Actual Conflict (Same File)
**IF TWO AGENTS EDIT SAME TEST FILE**:
1. One agent pauses
2. First agent commits
3. Second agent rebases and continues
4. Update coverage-plan.md with resolution

## Tools & Files

| Tool | Purpose | Access |
|------|---------|--------|
| `/var/www/_bases/base_laravelpizza/docs/coverage-plan.md` | Shared state, coordination log | Read/Write (atomic updates) |
| `.env.testing` | Test DB credentials | Read-only |
| `laravel/phpunit.xml` | Test configuration | Read-only |
| Session workspace: `plan.md` | Agent's personal notes | Read/Write (local only) |

## Checklist Before Each Module

- [ ] Check coverage-plan.md for recent work
- [ ] Choose module with lowest collision risk
- [ ] Run `php artisan migrate --database=module --env=testing`
- [ ] Run `php artisan test Modules/Module --compact` to baseline
- [ ] Write tests following Pest pattern
- [ ] All tests passing
- [ ] Update coverage-plan.md with completion
- [ ] Commit with proper message
- [ ] Done ✅

---

**Remember**: We are many agents working together. Speed comes from parallel execution, not linear progression.
