# Scrum Master Skill Package

A comprehensive Anthropic Claude Code skill for sprint planning, user story creation, velocity tracking, and agile project management.

## Overview

The Scrum Master skill helps you:
- Break down epics into detailed, implementable user stories
- Estimate story complexity using Fibonacci story points
- Plan sprint iterations based on team velocity
- Track sprint progress with burndown metrics
- Facilitate agile delivery workflows

## Quick Start

### Activate the Skill

The skill activates on these trigger keywords:
- sprint planning
- user story
- story points
- velocity
- backlog
- sprint
- epic breakdown
- estimation
- burndown
- agile planning

### Common Commands

```bash
# Plan a sprint from epics and requirements
/sprint-planning

# Create a detailed user story
/create-story

# Check current sprint progress
/sprint-status

# Calculate velocity metrics
/velocity-report
```

## Package Structure

```
scrum-master/
├── SKILL.md                 # Main skill definition with YAML frontmatter
├── REFERENCE.md             # Detailed metrics, calculations, and guidance
├── README.md                # This file
├── scripts/
│   ├── calculate-velocity.py    # Velocity calculator
│   ├── generate-story-id.sh     # Story ID generator
│   └── sprint-burndown.py       # Burndown chart data
├── templates/
│   ├── user-story.template.md   # User story template
│   ├── sprint-plan.template.md  # Sprint plan template
│   └── sprint-status.template.yaml # Sprint status YAML
└── resources/
    └── story-sizing-guide.md    # Comprehensive sizing guide
```

## Documentation

### Main Documentation
- **[SKILL.md](SKILL.md)** - Core skill definition, principles, and workflows
- **[REFERENCE.md](REFERENCE.md)** - Detailed reference for metrics and calculations

### Templates
- **[user-story.template.md](templates/user-story.template.md)** - Complete user story format
- **[sprint-plan.template.md](templates/sprint-plan.template.md)** - Sprint planning document
- **[sprint-status.template.yaml](templates/sprint-status.template.yaml)** - YAML status tracking

### Resources
- **[story-sizing-guide.md](resources/story-sizing-guide.md)** - Comprehensive story sizing guide

## Scripts

### Velocity Calculator

Calculate sprint velocity and 3-sprint rolling average:

```bash
python scripts/calculate-velocity.py .bmad/sprint-status.yaml
```

**Output:**
- Current sprint velocity
- Velocity history
- 3-sprint rolling average
- Velocity trend (increasing/decreasing/stable)
- Recommended capacity for next sprint

### Story ID Generator

Generate the next sequential story ID:

```bash
bash scripts/generate-story-id.sh [project-name]
```

**Output:**
```
STORY-001  # If no stories exist
STORY-042  # If 41 stories exist
```

### Sprint Burndown

Generate burndown chart data:

```bash
# Table format (default)
python scripts/sprint-burndown.py .bmad/sprint-status.yaml

# CSV format
python scripts/sprint-burndown.py .bmad/sprint-status.yaml --csv

# JSON format
python scripts/sprint-burndown.py .bmad/sprint-status.yaml --json

# Specific sprint
python scripts/sprint-burndown.py .bmad/sprint-status.yaml 2
```

## Story Sizing Quick Reference

| Points | Complexity | Duration | Examples |
|--------|-----------|----------|----------|
| 1 | Trivial | 1-2 hours | Config change, text update |
| 2 | Simple | 2-4 hours | Basic CRUD, simple component |
| 3 | Moderate | 4-8 hours | Complex component, business logic |
| 5 | Complex | 1-2 days | Feature with multiple components |
| 8 | Very Complex | 2-3 days | Full feature (frontend + backend) |
| 13 | Epic-sized | 3-5 days | **Break this down!** |

**Rule:** Stories >8 points must be broken into smaller stories.

See [story-sizing-guide.md](resources/story-sizing-guide.md) for detailed sizing guidance.

## Sprint Planning by Project Level

### Level 0 (1 story)
- No sprint planning needed
- Create single story
- Proceed to implementation

### Level 1 (1-10 stories)
- Single sprint (1-2 weeks)
- Estimate and prioritize
- Simple task list

### Level 2 (5-15 stories)
- 1-2 sprints (2-4 weeks)
- Group by epic
- Define sprint goals
- Track velocity

### Level 3-4 (12+ stories)
- 2-4+ sprints (4-8+ weeks)
- Full velocity-based planning
- Release planning
- Burndown tracking

## Velocity Metrics

### What is Velocity?

**Velocity** = Sum of story points completed in a sprint

Used to predict future capacity and plan sprints realistically.

### Calculating Velocity

**3-Sprint Rolling Average (Recommended):**
```
Average = (Sprint1 + Sprint2 + Sprint3) / 3
```

**When to Use:**
- New team: Use capacity planning (dev-days × points/day)
- After Sprint 1: Use single sprint velocity
- After Sprint 3+: Use 3-sprint rolling average

See [REFERENCE.md](REFERENCE.md) for detailed velocity calculations.

## Workflow Integration

### You Work After:
- **Product Manager** - Receives PRD/tech-spec with epics
- **System Architect** - Receives architecture document (Level 2+)

### You Work Before:
- **Developer** - Hands off refined stories for implementation

### You Work With:
- **Memory Tool** - Store sprint plans and velocity data
- **TodoWrite** - Track sprint tasks and story progress

## Core Principles

1. **Small Batches** - Stories completable in 1-3 days (max 8 points)
2. **User-Centric** - Stories deliver tangible value to end users
3. **Testable** - Every story has clear, measurable acceptance criteria
4. **Right-Sized** - Level-appropriate story counts
5. **Velocity-Based** - Use historical data for planning

## Example: Creating a User Story

```markdown
# User Registration API

**ID:** STORY-001
**Epic:** User Authentication
**Priority:** Must Have
**Story Points:** 5

## User Story

As a **new user**
I want to **register an account with email and password**
So that **I can access the platform securely**

## Acceptance Criteria

- [ ] User can submit registration form with email, password, name
- [ ] Email format is validated
- [ ] Password meets security requirements (8+ chars, mix of types)
- [ ] Duplicate email addresses are rejected
- [ ] Successful registration returns user object and JWT token
- [ ] Email verification link is sent to user

## Technical Notes

### Implementation Approach
- POST /api/auth/register endpoint
- Validate input with Joi schema
- Hash password with bcrypt (10 rounds)
- Store user in MongoDB users collection
- Generate JWT token with 24h expiration
- Send verification email via SendGrid

### Files/Modules Affected
- `routes/auth.js` - New registration route
- `controllers/authController.js` - Registration logic
- `models/User.js` - User schema
- `utils/email.js` - Email sending utility

## Dependencies

- **Technical:** SendGrid API configured
- **Stories:** None (first story in epic)

## Definition of Done

- [ ] Code complete and follows standards
- [ ] Unit tests written (>80% coverage)
- [ ] Integration tests for API endpoint
- [ ] Code reviewed and approved
- [ ] Documentation updated
- [ ] Deployed to staging
- [ ] Product owner accepted
```

## Example: Sprint Planning

```
Sprint 1 (2 weeks, 40 points capacity)
Goal: Complete user authentication and begin product catalog

Epic 1: User Authentication (18 points)
- STORY-001: User registration API (5 points)
- STORY-002: User login with JWT (3 points)
- STORY-003: Password reset flow (5 points)
- STORY-004: Email verification (3 points)
- STORY-005: User profile management (2 points)

Epic 2: Product Catalog (22 points)
- STORY-006: Product listing API (5 points)
- STORY-007: Product detail API (3 points)
- STORY-008: Product listing page (8 points)
- STORY-009: Product detail page (5 points)

Total: 40 points (matches capacity)
```

## Best Practices

1. **Always load context first** - Project config, PRD, architecture, sprint status
2. **Use TodoWrite** to track multi-step planning workflows
3. **Apply sizing strictly** - Break down stories >8 points
4. **Be level-appropriate** - Don't over-plan small projects
5. **Calculate velocity** from completed sprints before planning
6. **Store sprint data** in `.bmad/sprint-status.yaml`
7. **Hand off clearly** - Specify which story to start with
8. **Focus on value** - Prioritize user value early
9. **Keep scope flexible** - Adjust based on velocity
10. **Track dependencies** - Flag blocking stories

## Common Pitfalls

### Anti-Pattern 1: Stories Too Large
**Problem:** Stories estimated at 13+ points
**Solution:** Break into 2-4 smaller stories (3-5 points each)

### Anti-Pattern 2: Vague Acceptance Criteria
**Problem:** "User can login" (not testable)
**Solution:** "User can submit valid credentials and receive JWT token with 24h expiration"

### Anti-Pattern 3: Over-committing Sprint
**Problem:** Planning 60 points when velocity is 40
**Solution:** Use 3-sprint average, add 10-20% buffer

### Anti-Pattern 4: Ignoring Dependencies
**Problem:** Planning stories out of order
**Solution:** Identify dependencies, plan critical path first

### Anti-Pattern 5: No Sprint Goal
**Problem:** Collection of unrelated stories
**Solution:** Define clear, achievable sprint goal

## Sprint Status Tracking

Store sprint status in `.bmad/sprint-status.yaml`:

```yaml
project: my-project
current_sprint: 1
sprints:
  - number: 1
    start_date: 2025-12-01
    end_date: 2025-12-15
    capacity: 40
    goal: "Complete user authentication"
    stories:
      - id: STORY-001
        points: 5
        status: completed
      - id: STORY-002
        points: 3
        status: in_progress
velocity_history:
  - sprint: 1
    completed: 38
```

## Contributing

This skill package follows the Anthropic Claude Code Skills specification:
- SKILL.md with YAML frontmatter
- Allowed tools: Read, Write, Edit, Bash, Glob, Grep, TodoWrite
- Templates for common documents
- Scripts for automation
- Comprehensive reference documentation

## Support

For issues, questions, or improvements, refer to:
- [SKILL.md](SKILL.md) - Main skill documentation
- [REFERENCE.md](REFERENCE.md) - Detailed reference
- [story-sizing-guide.md](resources/story-sizing-guide.md) - Sizing guide

## License

Part of the BMAD Skills transformation project.

---

**Remember:** Good sprint planning makes development smooth and predictable. Break big problems into small, achievable tasks. Keep work visible, trackable, and focused on delivering user value incrementally.
