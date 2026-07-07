# Scrum Master Reference Guide

This document provides detailed information on sprint metrics, velocity calculations, story sizing, and agile planning techniques.

## Table of Contents

1. [Story Points and Sizing](#story-points-and-sizing)
2. [Velocity Metrics](#velocity-metrics)
3. [Sprint Capacity Planning](#sprint-capacity-planning)
4. [Burndown Charts](#burndown-charts)
5. [Level-Based Planning](#level-based-planning)
6. [Story Breakdown Techniques](#story-breakdown-techniques)

## Story Points and Sizing

### Fibonacci Scale Rationale

We use the Fibonacci sequence (1, 2, 3, 5, 8, 13) because:
- It reflects increasing uncertainty at larger sizes
- Gaps between numbers prevent false precision
- Natural breakpoint at 8 points encourages story decomposition
- Industry standard for agile estimation

### Detailed Sizing Guide

| Points | Complexity | Duration | Dev Effort | Examples | When to Use |
|--------|-----------|----------|------------|----------|-------------|
| 1 | Trivial | 1-2 hours | 0.125-0.25 days | Config change, copy update, CSS tweak | Single file, no logic |
| 2 | Simple | 2-4 hours | 0.25-0.5 days | Simple CRUD endpoint, basic component | Straightforward implementation |
| 3 | Moderate | 4-8 hours | 0.5-1 day | Component with state, business logic | Some complexity, standard patterns |
| 5 | Complex | 1-2 days | 1-2 days | Feature with multiple files, integration | Multiple components/layers |
| 8 | Very Complex | 2-3 days | 2-3 days | Full-stack feature, complex logic | Maximum recommended size |
| 13 | Epic-sized | 3-5 days | 3-5 days | Mini-epic, needs breakdown | **Always break down** |

### Story Point Characteristics

**1 Point Stories:**
- Single file modification
- No new dependencies
- No database changes
- No API integration
- Minimal testing required
- Examples: Update text, change color, fix typo, update constant

**2 Point Stories:**
- 1-2 file modifications
- Reuse existing patterns
- Simple CRUD operations
- Basic validation logic
- Unit tests only
- Examples: Add form field, simple filter, basic endpoint

**3 Point Stories:**
- 2-4 file modifications
- Some new logic required
- State management needed
- Multiple test cases
- Integration between 2 components
- Examples: User preferences, search functionality, data validation

**5 Point Stories:**
- 4-8 file modifications
- New patterns or approaches
- Multiple component integration
- Frontend + backend coordination
- Integration and unit tests
- Examples: Authentication flow, report generation, file upload

**8 Point Stories:**
- 8-12 file modifications
- Complex business logic
- Multiple system integration
- Full-stack implementation
- Comprehensive test coverage
- Database schema changes
- Examples: Payment processing, advanced search, real-time features

**13+ Point Stories:**
- **Too large - must be broken down**
- If you estimate 13 points, you're looking at a mini-epic
- Break into 2-4 smaller stories (3-5 points each)

## Velocity Metrics

### What is Velocity?

**Velocity** = Sum of story points completed in a sprint

Velocity measures team throughput and is used to predict future capacity.

### Calculating Velocity

**Single Sprint Velocity:**
```
Velocity = Σ(Completed Story Points)
```

Example:
- Sprint 1: STORY-001 (5pts), STORY-002 (3pts), STORY-003 (5pts) = 13 pts
- Sprint 2: STORY-004 (8pts), STORY-005 (3pts), STORY-006 (2pts) = 13 pts
- Sprint 3: STORY-007 (5pts), STORY-008 (5pts), STORY-009 (5pts) = 15 pts

**3-Sprint Rolling Average (Recommended):**
```
Average Velocity = (Sprint1 + Sprint2 + Sprint3) / 3
                 = (13 + 13 + 15) / 3
                 = 13.67 ≈ 14 points per sprint
```

### When to Use Velocity

- **New team/project:** Use capacity planning (dev-days × points/day estimate)
- **After Sprint 1:** Use single sprint velocity
- **After Sprint 3+:** Use 3-sprint rolling average (most accurate)

### Velocity Trends

**Increasing Velocity:**
- Team is learning and improving
- Consider if sprint scope is being reduced
- Validate estimates aren't inflating

**Decreasing Velocity:**
- Technical debt accumulating
- Team facing blockers or distractions
- Stories may be underestimated

**Stable Velocity:**
- Team has found sustainable pace
- Good for predictable planning
- Use this for release forecasting

## Sprint Capacity Planning

### Capacity Calculation Methods

**Method 1: Velocity-Based (Sprint 3+)**
```
Sprint Capacity = 3-Sprint Rolling Average Velocity
```
Best for established teams with historical data.

**Method 2: Developer-Days (New Teams)**
```
Sprint Capacity = (Team Size × Sprint Days × Points per Dev-Day)

Where:
- Team Size = Number of developers
- Sprint Days = Working days in sprint (typically 10 for 2-week sprint)
- Points per Dev-Day = 2-3 points (conservative estimate)
```

Example:
- 2 developers
- 10-day sprint (2 weeks)
- 2.5 points per dev-day
- Capacity = 2 × 10 × 2.5 = 50 points

**Method 3: Hour-Based**
```
Sprint Capacity = (Available Hours / Hours per Point)

Where:
- Available Hours = Team Size × Sprint Days × 6 hours/day
- Hours per Point = Average hours per story point (typically 4-6 hours)
```

### Capacity Adjustments

**Reduce capacity for:**
- Holidays and PTO (-X dev-days)
- Team onboarding (-20-50% for new members)
- Technical debt work (-10-20%)
- Meetings and ceremonies (-10-15%)
- Production support (-10-30%)

**Example Adjustment:**
```
Base Capacity: 50 points
- Holiday (1 dev-day): -2.5 points
- Tech debt (15%): -7.5 points
- Meetings (10%): -5 points
Adjusted Capacity: 35 points
```

## Burndown Charts

### What is a Burndown Chart?

A burndown chart shows **remaining work** (story points) over time within a sprint.

### Burndown Data Points

Track daily or every few days:
- **Date:** Tracking date
- **Remaining Points:** Sum of incomplete story points
- **Ideal Burndown:** Linear line from starting points to zero

### Example Burndown

Sprint 1 (10 days, 40 points):

| Day | Completed | Remaining | Ideal |
|-----|-----------|-----------|-------|
| 0 | 0 | 40 | 40 |
| 2 | 5 | 35 | 32 |
| 4 | 13 | 27 | 24 |
| 6 | 18 | 22 | 16 |
| 8 | 28 | 12 | 8 |
| 10 | 40 | 0 | 0 |

### Interpreting Burndown

**Tracking above ideal line:**
- Team is behind pace
- May not complete all stories
- Consider removing lowest-priority stories

**Tracking below ideal line:**
- Team is ahead of pace
- May complete more than planned
- Consider pulling in additional stories

**Flat sections:**
- Stories are blocked
- Team needs help or dependencies resolved
- Investigate and remove blockers

## Level-Based Planning

### Level 0: Single Story

**Characteristics:**
- 1 story total
- Trivial to simple complexity
- No sprint planning needed

**Approach:**
1. Create single story with acceptance criteria
2. Estimate story points (typically 1-5)
3. Proceed directly to implementation
4. No velocity tracking needed

### Level 1: 1-10 Stories

**Characteristics:**
- Small project or single feature
- Simple requirements
- 1-2 week timeline

**Approach:**
1. Break requirements into 1-10 stories
2. Estimate all stories
3. Single sprint (no multi-sprint planning)
4. Prioritize by dependency and value
5. Simple task list (no formal sprint plan)
6. Track completion, but velocity optional

**Typical Story Distribution:**
- 3-5 stories: 2-3 points each
- 6-10 stories: 1-3 points each
- Total: 15-30 points

### Level 2: 5-15 Stories

**Characteristics:**
- Medium project
- Multiple related features
- 2-4 week timeline

**Approach:**
1. Group stories by epic (2-3 epics)
2. Estimate using story points
3. Plan 1-2 sprints
4. Define sprint goals
5. Allocate stories by priority and capacity
6. Track velocity after Sprint 1
7. Formal sprint plan document

**Typical Story Distribution:**
- 2-3 epics
- 5-8 stories per epic
- Story sizes: 2-8 points
- Total: 40-80 points
- Sprints: 1-2 (20-40 points each)

### Level 3: 12-40 Stories

**Characteristics:**
- Large project
- Multiple epics and features
- 1-2 month timeline

**Approach:**
1. Break into 3-5 epics
2. Detailed story breakdown (12-40 stories)
3. Estimate all stories
4. Plan 2-4 sprints
5. Use velocity-based capacity planning
6. Define sprint goals and milestones
7. Track burndown and velocity
8. Regular sprint reviews and planning

**Typical Story Distribution:**
- 3-5 epics
- 3-10 stories per epic
- Story sizes: 2-8 points (mostly 3-5)
- Total: 80-150 points
- Sprints: 2-4 (30-40 points each)

### Level 4: 40+ Stories

**Characteristics:**
- Very large project or multi-team effort
- Complex domain with many features
- 2-4+ month timeline

**Approach:**
1. Break into 5-10 epics
2. Extensive story breakdown (40-100+ stories)
3. Multi-sprint planning (4-8 sprints)
4. Release planning across sprints
5. Sprint goals, milestones, and release checkpoints
6. Detailed velocity tracking
7. Burndown charts per sprint
8. Regular retrospectives and adjustments

**Typical Story Distribution:**
- 5-10 epics
- 5-15 stories per epic
- Story sizes: 2-8 points (avoid 1s and 13s)
- Total: 200-400 points
- Sprints: 4-8 (30-50 points each)

## Story Breakdown Techniques

### When to Break Down Stories

Break down a story if:
- **Size:** Story is estimated at 13+ points
- **Time:** Story takes more than 3 days
- **Complexity:** Story has too many acceptance criteria (>7)
- **Uncertainty:** Team can't estimate confidently
- **Dependencies:** Story blocks too many other stories

### Breakdown Strategies

**1. By Workflow Steps**

Original (13 points):
- "User can complete checkout process"

Broken down:
- "User can review cart before checkout" (3 points)
- "User can enter shipping information" (3 points)
- "User can enter payment information" (5 points)
- "User can confirm and submit order" (2 points)

**2. By User Role**

Original (13 points):
- "Users can manage their account"

Broken down:
- "Customer can update profile information" (3 points)
- "Admin can manage user accounts" (5 points)
- "Support staff can view user activity" (2 points)

**3. By Technical Layer**

Original (13 points):
- "Product search functionality"

Broken down:
- "Backend: Search API endpoint" (5 points)
- "Frontend: Search input component" (3 points)
- "Frontend: Search results display" (3 points)
- "Frontend: Search filters" (2 points)

**4. By CRUD Operations**

Original (13 points):
- "Product management system"

Broken down:
- "Create product" (3 points)
- "Read/view product" (2 points)
- "Update product" (3 points)
- "Delete product" (2 points)
- "List products with pagination" (3 points)

**5. By Priority (Thin Vertical Slices)**

Original (13 points):
- "Comprehensive reporting dashboard"

Broken down:
- "Basic sales report (MVP)" (5 points)
- "Add date filtering" (2 points)
- "Add export to CSV" (3 points)
- "Add chart visualization" (3 points)

### Story Splitting Tips

1. **Maintain value:** Each story should deliver user value independently
2. **Keep vertical:** Include frontend + backend in single story when possible
3. **Avoid dependencies:** Minimize dependencies between split stories
4. **Test independently:** Each story should be testable on its own
5. **Deploy incrementally:** Each story should be deployable

## Calculating Points Per Developer-Day

If you need to estimate points per developer-day for a new team:

**Aggressive:** 3-4 points/day (assumes experienced team, clear requirements)
**Moderate:** 2-3 points/day (standard assumption, some unknowns)
**Conservative:** 1-2 points/day (new team, unclear requirements, technical debt)

**Recommendation:** Start conservative, adjust based on actual velocity after Sprint 1.

## Sprint Status Tracking

### Sprint Status File Structure

Store in `.bmad/sprint-status.yaml`:

```yaml
project: project-name
current_sprint: 1
sprints:
  - number: 1
    start_date: 2025-12-01
    end_date: 2025-12-15
    capacity: 40
    goal: "Complete user authentication"
    stories:
      - id: STORY-001
        title: "User registration API"
        points: 5
        status: completed
        completed_date: 2025-12-05
      - id: STORY-002
        title: "User login with JWT"
        points: 3
        status: in_progress
      - id: STORY-003
        title: "Password reset flow"
        points: 5
        status: not_started
    completed_points: 5
    remaining_points: 35
velocity_history:
  - sprint: 1
    completed: 13
  - sprint: 2
    completed: 15
```

### Velocity Tracking

Update after each sprint completes:
1. Sum completed story points
2. Add to velocity history
3. Calculate 3-sprint rolling average (if applicable)
4. Use average for next sprint capacity planning

## Common Planning Scenarios

### Scenario 1: New Project, No Historical Data

**Situation:** Level 2 project, 2 developers, 2-week sprints, no velocity data

**Approach:**
1. Estimate capacity: 2 devs × 10 days × 2.5 pts/day = 50 points
2. Reduce for safety: 50 × 0.8 = 40 points (Sprint 1 capacity)
3. Plan Sprint 1 with 40 points
4. After Sprint 1, adjust based on actual completion

### Scenario 2: Established Team, Stable Velocity

**Situation:** Level 3 project, 3 sprints completed, velocity is 35, 38, 36

**Approach:**
1. Calculate 3-sprint average: (35 + 38 + 36) / 3 = 36.3 ≈ 36 points
2. Plan Sprint 4 with 36 points capacity
3. Continue tracking and adjusting

### Scenario 3: Story Too Large

**Situation:** Story estimated at 13 points during planning

**Approach:**
1. Identify breakdown strategy (workflow, layer, priority)
2. Split into 2-4 stories (3-5 points each)
3. Re-estimate split stories
4. Verify total points roughly match original (may be slightly lower due to better understanding)

### Scenario 4: Sprint Running Behind

**Situation:** Day 6 of 10, completed 10 points of 40 (ideal: 24 points)

**Approach:**
1. Identify blockers and resolve
2. Consider removing lowest-priority stories
3. Focus team on highest-priority work
4. Update burndown and communicate risk
5. Don't add more stories mid-sprint

## Additional Resources

- Story sizing workshop exercises
- Velocity tracking spreadsheet templates
- Burndown chart generators
- Sprint retrospective formats
- Estimation poker techniques

## Best Practices Summary

1. **Use Fibonacci strictly** - Don't create custom point scales
2. **Break down 13s** - Never allow stories >8 points in a sprint
3. **Track velocity consistently** - Same team, same definition of done
4. **Plan conservatively** - Better to under-commit and over-deliver
5. **Adjust capacity** - Factor in holidays, meetings, tech debt
6. **Sprint goals matter** - Every sprint should have clear objective
7. **Review and adapt** - Use retrospectives to improve estimation
8. **Focus on trends** - Single sprint velocity can be misleading
9. **Keep stories independent** - Minimize dependencies for flexibility
10. **Deliver value early** - Prioritize high-value stories in early sprints
