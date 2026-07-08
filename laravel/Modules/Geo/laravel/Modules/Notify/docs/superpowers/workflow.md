# 🦸 Superpowers Workflow Guide

> **Last Updated**: 2026-03-31  
> **Status**: ✅ Active  
> **Version**: v5.0.6

---

## 📋 Overview

The Superpowers workflow is a structured development process that ensures quality through:
- Test-Driven Development (TDD)
- Systematic planning
- Code review
- Git worktrees for isolation

---

## 🔄 Complete Workflow

### Phase 1: Brainstorming

**Trigger**: "I want to build X" or "help me plan this feature"

**Purpose**: Refine requirements and validate approach

**Process**:
```
User: "I want to add user activity tracking"
  ↓
Agent: [Asks clarifying questions]
  - What activities should we track?
  - How long should we store data?
  - Do we need real-time analytics?
  ↓
User: [Provides answers]
  ↓
Agent: [Presents design document]
  ## Design
  ### Data Model
  - Activity model with: user_id, type, metadata, timestamp
  ### Storage
  - Database table with 90-day retention
  ### API
  - GET /activities (paginated)
  - POST /activities/track
  ↓
User: "Looks good, proceed"
```

**Output**: Validated design document

---

### Phase 2: Git Worktree Setup

**Trigger**: Automatic after brainstorm approval

**Purpose**: Isolated workspace

**Commands**:
```bash
# Create worktree
git worktree add -b feature/user-activity-tracking ../worktrees/activity-tracking

# Switch to worktree
cd ../worktrees/activity-tracking

# Verify
git branch
# Should show: * feature/user-activity-tracking
```

**Benefits**:
- ✅ Clean main branch
- ✅ Parallel development safe
- ✅ Easy to discard if needed
- ✅ No merge conflicts

---

### Phase 3: Writing Plans

**Trigger**: Automatic after worktree setup

**Purpose**: Break work into small, testable tasks

**Plan Structure**:

```markdown
## Plan: User Activity Tracking

### Task 1: Create Migration
- **File**: `database/migrations/2026_03_31_create_activities_table.php`
- **Time**: 5 min
- **Steps**:
  1. Run: `php artisan make:migration create_activities_table`
  2. Define schema:
     - id (ulid, primary)
     - user_id (ulid, foreign)
     - type (string, index)
     - metadata (json, nullable)
     - created_at (timestamp)
  3. Add indexes: user_id, type, created_at
- **Verification**: `php artisan migrate --pretend`

### Task 2: Create Model
- **File**: `app/Models/Activity.php`
- **Time**: 5 min
- **Steps**:
  1. Create class extends BaseModel
  2. Define fillable: ['user_id', 'type', 'metadata']
  3. Add casts: metadata → array
  4. Add relationship: belongsTo(User::class)
- **Verification**: `phpstan analyse app/Models/Activity.php`

### Task 3: Write Tests
- **File**: `tests/Feature/ActivityTest.php`
- **Time**: 10 min
- **Steps**:
  1. Test: creates activity
  2. Test: belongs to user
  3. Test: metadata casting
  4. Test: scopes (byType, recent)
- **Verification**: `php artisan test --filter ActivityTest`

### Task 4: Create Action
- **File**: `app/Actions/Activity/TrackActivityAction.php`
- **Time**: 5 min
- **Steps**:
  1. Create invokable action
  2. Accept: User, type, metadata
  3. Return: Activity instance
  4. Queue: implements ShouldQueue (optional)
- **Verification**: `phpstan analyse app/Actions/Activity/TrackActivityAction.php`

### Task 5: Create API Endpoint
- **File**: `routes/api.php`
- **Time**: 10 min
- **Steps**:
  1. POST /activities/track (authenticated)
  2. GET /activities (paginated, filtered)
  3. Use API resources for response
- **Verification**: `php artisan test --filter ActivityApiTest`
```

**Task Size**: 2-10 minutes each

---

### Phase 4: Execution (TDD)

**Trigger**: Manual confirmation or automatic

**Purpose**: Implement with tests first

#### For Each Task:

**Step 1: RED - Write Failing Test**

```php
// tests/Feature/ActivityTest.php
it('creates an activity', function () {
    $user = User::factory()->create();
    
    $activity = Activity::create([
        'user_id' => $user->id,
        'type' => 'page_view',
        'metadata' => ['url' => '/home'],
    ]);
    
    expect($activity)
        ->toBeInstanceOf(Activity::class)
        ->and($activity->user)->toBe($user);
});

// Run test: FAILS (Activity model doesn't exist yet)
php artisan test --filter ActivityTest
// ❌ Class 'Activity' not found
```

**Step 2: GREEN - Write Minimal Code**

```php
// app/Models/Activity.php
namespace App\Models;

class Activity extends BaseModel
{
    protected $fillable = [
        'user_id',
        'type',
        'metadata',
    ];
    
    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

// Run test: PASSES
php artisan test --filter ActivityTest
// ✅ 1 passed
```

**Step 3: REFACTOR - Improve Code Quality**

```php
// Add scope for reusability
public function scopeByType($query, string $type): Builder
{
    return $query->where('type', $type);
}

public function scopeRecent($query, int $days = 30): Builder
{
    return $query->where('created_at', '>=', now()->subDays($days));
}

// Run tests: STILL PASSES
php artisan test
// ✅ All passed
```

**Step 4: COMMIT - Save Progress**

```bash
git add .
git commit -m "feat: create Activity model with user relationship

- Add Activity model with fillable fields
- Define metadata casting to array
- Add user relationship
- Add byType and recent scopes
- PHPStan Level 10 compliant"
```

---

### Phase 5: Code Review

**Trigger**: Automatic after task completion

**Purpose**: Ensure quality and plan compliance

**Review Process**:

#### Stage 1: Spec Compliance

**Reviewer**: Subagent or human

**Checklist**:
- [ ] Matches original plan
- [ ] All tasks completed
- [ ] Tests written and passing
- [ ] No scope creep

**Questions**:
1. Does this implement the planned feature?
2. Are all acceptance criteria met?
3. Are there any unplanned changes?

#### Stage 2: Code Quality

**Reviewer**: Subagent or human

**Checklist**:
- [ ] Code follows conventions
- [ ] No duplication (DRY)
- [ ] Functions are small (<20 lines)
- [ ] Names are descriptive
- [ ] No security issues
- [ ] PHPStan passes
- [ ] Tests cover edge cases

**Blocking Issues**:
- ❌ Security vulnerabilities
- ❌ Missing tests for critical paths
- ❌ Breaking changes without migration
- ❌ Performance regressions

**Non-Blocking**:
- ⚠️ Minor style issues
- ⚠️ Suggestion for future improvement

---

### Phase 6: Finishing Branch

**Trigger**: All tasks complete, review passed

**Purpose**: Merge and cleanup

**Steps**:

#### 1. Final Verification

```bash
# Run all tests
php artisan test

# Check PHPStan
./vendor/bin/phpstan analyse --level=10

# Verify no issues
git status
```

#### 2. Present Merge Options

**Option A: Merge to Main**
```bash
git checkout main
git merge feature/user-activity-tracking
git branch -d feature/user-activity-tracking
```

**Option B: Create Pull Request**
```bash
git push origin feature/user-activity-tracking
# Open PR on GitHub
```

**Option C: Keep as Feature Branch**
```bash
# Keep for ongoing development
git push origin feature/user-activity-tracking
```

#### 3. Cleanup Worktree

```bash
# Return to main worktree
cd /var/www/_bases/base_fixcity_fila5

# Remove feature worktree
git worktree remove ../worktrees/activity-tracking

# Verify
git worktree list
```

#### 4. Update Documentation

```markdown
## Updated Files
- [x] `docs/activity-tracking.md` - Feature documentation
- [x] `CHANGELOG.md` - Added feature entry
- [x] `README.md` - Updated if needed
```

---

## 🎯 Skill Triggers

### Automatic Triggers

Superpowers skills trigger automatically based on context:

| Context | Skill Triggered |
|---------|-----------------|
| "I want to build X" | `brainstorming` |
| "help me plan" | `writing-plans` |
| "let's implement" | `test-driven-development` |
| "this is broken" | `systematic-debugging` |
| "review this" | `requesting-code-review` |
| "I'm done" | `verification-before-completion` |

### Manual Triggers

You can explicitly request skills:

```
Use the brainstorming skill for this feature
Let's do TDD for this function
Run systematic debugging on this issue
```

---

## 📊 Workflow Metrics

### Track These Metrics

```json
{
  "session_date": "2026-03-31",
  "tasks_planned": 5,
  "tasks_completed": 5,
  "tests_written": 12,
  "tests_passed": 12,
  "bugs_found": 2,
  "review_iterations": 1,
  "worktree_used": true,
  "tdd_followed": true
}
```

### Target Metrics

| Metric | Target | Why |
|--------|--------|-----|
| Test Coverage | >90% | Quality assurance |
| Plan Compliance | 100% | Scope management |
| Review Pass Rate | >95% | Code quality |
| TDD Adherence | Always | Test-first culture |
| Worktree Usage | Always | Clean git history |

---

## 🐛 Common Issues

### Issue: Skipping TDD

**Symptom**: Writing code before tests

**Solution**:
```
Stop! Write the test first.
1. What should the code do?
2. Write test that proves it does that
3. Test should FAIL initially
4. Now write code to make it pass
```

---

### Issue: Too Large Tasks

**Symptom**: Tasks taking >15 minutes

**Solution**:
```
Break it down further:
- Task: "Create user system" → Too big
- Split into:
  - Create users table migration
  - Create User model
  - Create user factory
  - Write user tests
  - Create user actions
```

---

### Issue: Review Blocking

**Symptom**: Review finds critical issues

**Solution**:
```
1. Acknowledge the issue
2. Create fix plan
3. Implement fix (with tests)
4. Re-review
5. Only merge when green
```

---

## 🔗 Related Documentation

### Internal

- [README](README.md) - Overview
- [Installation](installation.md) - Setup guide
- [Skills Reference](skills-reference.md) - All skills
- [TDD Guide](../testing/tdd.md) - Test-driven development

### External

- [Superpowers GitHub](https://github.com/obra/superpowers)
- [Superpowers Discord](https://discord.gg/superpowers)

---

**Maintainer**: Development Team  
**Last Review**: 2026-03-31  
**Next Review**: 2026-06-30  
**Status**: ✅ Active
