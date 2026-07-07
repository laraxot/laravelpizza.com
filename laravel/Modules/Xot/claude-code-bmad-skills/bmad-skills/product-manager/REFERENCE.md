# Product Manager Reference Guide

This document provides detailed guidance on prioritization frameworks, requirements patterns, and best practices for product management activities.

## Prioritization Frameworks

### MoSCoW Method

**Overview:** Time-boxed prioritization framework for requirements classification.

**When to Use:**
- Fixed timeline projects
- MVP definition
- Stakeholder alignment needed
- Resource-constrained environments
- Clear scope boundaries required

**How to Apply:**

1. **Must Have (Critical)**
   - Without this, the project/release fails
   - Legal/regulatory requirements
   - Core functionality that defines the product
   - Safety-critical features
   - **Test:** "What happens if we don't include this?" → "Project fails"

2. **Should Have (Important)**
   - Important but not vital
   - Workarounds exist if not included
   - Significant impact on user satisfaction
   - Will be included unless resource/time constraints prevent
   - **Test:** "What happens if we don't include this?" → "Users disappointed but product viable"

3. **Could Have (Nice to Have)**
   - Desirable but not necessary
   - Small impact if left out
   - Will be included if time/resources allow
   - Often called "nice to haves"
   - **Test:** "What happens if we don't include this?" → "Most users won't notice"

4. **Won't Have (Out of Scope)**
   - Explicitly excluded from this release
   - May be considered for future releases
   - Helps manage scope creep
   - Documents conscious decisions
   - **Test:** "Why are we explicitly excluding this?" → Document the reason

**Example Application:**

```
Feature: User Dashboard

Must Have:
- Display user's active projects
- Show recent activity feed
- Basic profile information
- Logout functionality

Should Have:
- Project completion statistics
- Activity filters (date, type)
- Customizable layout
- Quick action shortcuts

Could Have:
- Team member activity view
- Exportable reports
- Dark mode toggle
- Widget customization

Won't Have:
- Social sharing features
- Collaborative editing
- Mobile app (separate project)
- Third-party integrations
```

### RICE Scoring

**Overview:** Data-driven prioritization using quantitative scoring.

**Formula:** `RICE Score = (Reach × Impact × Confidence) / Effort`

**When to Use:**
- Multiple features to compare
- Data-driven decision making needed
- Cross-functional prioritization
- Resource allocation decisions
- Portfolio management

**Component Definitions:**

1. **Reach (How Many?)**
   - Number of users/customers affected per time period
   - Measured in users per quarter/month
   - Based on data, not assumptions
   - Examples:
     - "500 users per month will use this feature"
     - "2,000 customers per quarter will benefit"
   - **Estimation:** Use analytics, surveys, or market research

2. **Impact (How Much Value?)**
   - Value delivered per user
   - Scored on scale: 3 = Massive, 2 = High, 1 = Medium, 0.5 = Low, 0.25 = Minimal
   - Measures satisfaction, revenue, efficiency gain
   - Examples:
     - Massive (3): Solves critical pain point, major revenue driver
     - High (2): Significant improvement to key workflow
     - Medium (1): Noticeable benefit, clear value
     - Low (0.5): Minor improvement, marginal benefit
     - Minimal (0.25): Barely noticeable improvement
   - **Estimation:** User research, revenue projections, efficiency metrics

3. **Confidence (How Sure?)**
   - Certainty in your estimates
   - Percentage: 100% = High confidence, 80% = Medium, 50% = Low
   - Accounts for uncertainty in Reach and Impact
   - Examples:
     - 100%: Backed by solid data and research
     - 80%: Some data, reasonable assumptions
     - 50%: Mostly assumptions, limited data
   - **Rule:** If confidence <50%, gather more data

4. **Effort (How Much Work?)**
   - Total team time required
   - Measured in person-months
   - Includes design, development, testing, deployment
   - Examples:
     - 0.5 = 2 weeks of team time
     - 1.0 = 1 month of team time
     - 3.0 = 3 months of team time
   - **Estimation:** Engineering input required

**Scoring Process:**

```
Feature A: Quick Win Dashboard Widget
- Reach: 2,000 users/month
- Impact: 1 (Medium - helpful but not transformative)
- Confidence: 100% (clear data from user surveys)
- Effort: 0.5 person-months
- RICE Score: (2,000 × 1 × 1.0) / 0.5 = 4,000

Feature B: Advanced Analytics Engine
- Reach: 500 users/month
- Impact: 3 (Massive - key differentiator, major value)
- Confidence: 80% (good research, some assumptions)
- Effort: 4 person-months
- RICE Score: (500 × 3 × 0.8) / 4 = 300

Priority: Feature A (4,000) > Feature B (300)
```

**Using the Script:**

```bash
python scripts/prioritize.py
# Follow prompts to enter Reach, Impact, Confidence, Effort
# Script calculates RICE score and provides ranking
```

**Interpretation:**
- Higher scores = higher priority
- Compare relative scores, not absolute numbers
- Review outliers (very high/low scores)
- Combine with other factors (strategic alignment, dependencies)

### Kano Model

**Overview:** Framework for understanding feature types and customer satisfaction impact.

**When to Use:**
- Understanding feature value perception
- Balancing feature types in roadmap
- Customer satisfaction optimization
- Competitive differentiation strategy
- Innovation vs. stability decisions

**Feature Categories:**

1. **Basic Features (Must-Be Quality)**
   - **Characteristic:** Expected by users; dissatisfaction if missing
   - **Satisfaction Impact:** Neutral when present, negative when absent
   - **Examples:**
     - Login/authentication
     - Data persistence
     - Basic CRUD operations
     - Error messages
     - Help documentation
   - **Strategy:** Deliver efficiently; don't over-invest
   - **Competitive Impact:** No advantage, but absence is fatal

2. **Performance Features (One-Dimensional Quality)**
   - **Characteristic:** More is better; linear satisfaction
   - **Satisfaction Impact:** Satisfaction increases with quality
   - **Examples:**
     - Page load speed (faster = better)
     - Search accuracy (more relevant = better)
     - Storage capacity (more = better)
     - Battery life (longer = better)
   - **Strategy:** Invest where competitive advantage exists
   - **Competitive Impact:** Direct comparison point

3. **Excitement Features (Attractive Quality)**
   - **Characteristic:** Unexpected delights; not expected
   - **Satisfaction Impact:** High satisfaction when present, neutral when absent
   - **Examples:**
     - AI-powered suggestions
     - Innovative UI interactions
     - Proactive problem solving
     - Easter eggs
     - Beta feature previews
   - **Strategy:** Differentiate and delight
   - **Competitive Impact:** Strong advantage if done well
   - **Note:** Excitement features become Performance features over time

4. **Indifferent Features**
   - **Characteristic:** Users don't care either way
   - **Satisfaction Impact:** No impact on satisfaction
   - **Strategy:** Don't build these
   - **Warning:** What seems exciting to teams may be indifferent to users

5. **Reverse Features**
   - **Characteristic:** Presence causes dissatisfaction
   - **Satisfaction Impact:** Negative when present
   - **Examples:**
     - Unwanted notifications
     - Forced upsells
     - Overly complex interfaces
   - **Strategy:** Identify and remove

**Feature Evolution:**
```
Excitement → Performance → Basic → Indifferent/Reverse
(Innovation) → (Standard) → (Expected) → (Obsolete)
```

**Application Example:**

```
Product: Project Management Tool

Basic Features:
- Create/edit/delete tasks
- Assign tasks to users
- Set due dates
- Mark tasks complete
→ Must have; no differentiation

Performance Features:
- Task search speed
- Number of integrations
- Report customization
- Collaboration features
→ Competitive comparison points

Excitement Features:
- AI task prioritization
- Automatic timeline optimization
- Smart dependency detection
- Proactive risk alerts
→ Differentiation opportunities

Indifferent:
- Task color schemes beyond basics
- Animated transitions (excessive)
→ Don't invest

Reverse:
- Auto-assign tasks without permission
- Mandatory daily digests
→ Remove or make optional
```

**Kano Survey Questions:**

For each feature, ask two questions:

1. **Functional:** "How would you feel if this feature was present?"
   - I like it
   - I expect it
   - I'm neutral
   - I can tolerate it
   - I dislike it

2. **Dysfunctional:** "How would you feel if this feature was absent?"
   - I like it
   - I expect it
   - I'm neutral
   - I can tolerate it
   - I dislike it

**Interpretation Matrix:**

| Functional → | Like | Expect | Neutral | Tolerate | Dislike |
|--------------|------|--------|---------|----------|---------|
| Dysfunctional ↓ | | | | | |
| Like | Q | E | E | E | P |
| Expect | R | I | I | I | B |
| Neutral | R | I | I | I | B |
| Tolerate | R | I | I | I | B |
| Dislike | R | R | R | R | Q |

- E = Excitement
- P = Performance
- B = Basic
- I = Indifferent
- R = Reverse
- Q = Questionable

## Requirements Patterns

### Functional Requirement Patterns

**User Action Pattern:**
```
FR-XXX: [Priority] - User can [action] [object] [qualifier]
Acceptance Criteria:
- [Specific condition that must be true]
- [Measurable outcome]
- [Edge case handling]
```

**System Behavior Pattern:**
```
FR-XXX: [Priority] - System shall [behavior] when [condition]
Acceptance Criteria:
- [Trigger condition]
- [Expected behavior]
- [Error handling]
```

**Data Management Pattern:**
```
FR-XXX: [Priority] - System shall store/retrieve/update [data] with [constraints]
Acceptance Criteria:
- [Data validation rules]
- [Storage requirements]
- [Retrieval performance]
```

**Integration Pattern:**
```
FR-XXX: [Priority] - System shall integrate with [external system] to [purpose]
Acceptance Criteria:
- [Integration method]
- [Data exchange format]
- [Error handling and fallback]
```

### Non-Functional Requirement Patterns

**Performance Pattern:**
```
NFR-XXX: [Priority] - [Operation] shall complete within [time] for [percentile] of requests
Example: API response shall complete within 200ms for 95th percentile under normal load
```

**Scalability Pattern:**
```
NFR-XXX: [Priority] - System shall support [quantity] [resource] with [degradation] degradation
Example: System shall support 10,000 concurrent users with <5% performance degradation
```

**Security Pattern:**
```
NFR-XXX: [Priority] - [Component] shall implement [security control] per [standard]
Example: API shall implement OAuth 2.0 authentication per RFC 6749
```

**Reliability Pattern:**
```
NFR-XXX: [Priority] - System shall maintain [uptime]% availability excluding planned maintenance
Example: System shall maintain 99.9% availability excluding scheduled maintenance windows
```

**Usability Pattern:**
```
NFR-XXX: [Priority] - [Interface] shall achieve [metric] compliance/score
Example: Application shall achieve WCAG 2.1 AA compliance for all user-facing features
```

**Maintainability Pattern:**
```
NFR-XXX: [Priority] - Codebase shall maintain [metric] above [threshold]
Example: Codebase shall maintain test coverage above 80% for critical business logic
```

## Epic and Story Patterns

### Epic Template

```
Epic ID: EPIC-XXX
Title: [High-level capability]

Business Value:
[Why this matters to the business/users]

User Segments:
- [Segment 1]
- [Segment 2]

Success Metrics:
- [Measurable outcome 1]
- [Measurable outcome 2]

Related Requirements:
- FR-XXX
- FR-YYY
- NFR-ZZZ

Dependencies:
- [Other epics or systems]

Stories:
- STORY-XXX: [User story 1]
- STORY-YYY: [User story 2]
- STORY-ZZZ: [User story 3]
```

### User Story Template

```
As a [user type/role],
I want [capability/feature],
So that [business value/benefit].

Acceptance Criteria:
- Given [context/precondition]
  When [action/event]
  Then [expected outcome]

- Given [context/precondition]
  When [action/event]
  Then [expected outcome]

Technical Notes:
[Implementation considerations, if any]

Dependencies:
[Other stories or technical dependencies]

Estimate:
[Story points or time estimate]
```

### Story Size Guidelines

**Good Story Size:**
- Completable in 1-3 days
- Single responsibility
- Independently testable
- Delivers incremental value

**Story Too Large (Split It):**
- Takes more than 1 sprint
- Multiple user roles involved
- Complex technical implementation
- Many acceptance criteria

**Story Too Small (Combine It):**
- Trivial implementation
- No business value alone
- Just configuration change

## Traceability Matrix

**Purpose:** Link requirements to business objectives and track implementation.

**Structure:**

| Requirement ID | Description | Priority | Business Objective | Epic | Status | Test Case |
|----------------|-------------|----------|-------------------|------|--------|-----------|
| FR-001 | User login | MUST | Personalization | EPIC-AUTH | Complete | TC-001 |
| FR-002 | Password reset | MUST | Security | EPIC-AUTH | In Progress | TC-002 |
| NFR-001 | <200ms response | MUST | User Experience | N/A | Planned | TC-015 |

**Maintenance:**
- Update as requirements change
- Link to test cases as they're created
- Track status throughout implementation
- Use for impact analysis when changes occur

## Acceptance Criteria Best Practices

**Good Acceptance Criteria:**
- Specific and unambiguous
- Testable (can verify pass/fail)
- Written from user perspective
- Independent of implementation
- Include happy path and edge cases

**Examples:**

**Bad:**
```
- System should be fast
- User interface should be intuitive
- Data should be secure
```

**Good:**
```
- Page loads within 2 seconds on 3G connection
- New users complete first task within 5 minutes without help documentation
- All data transmission uses TLS 1.3 encryption
```

**Gherkin Format (Given-When-Then):**

```
Given [initial context/state]
When [action/event occurs]
Then [expected outcome]
```

Example:
```
Given a user is on the login page
When they enter valid credentials and click "Login"
Then they are redirected to the dashboard within 2 seconds
And their session token is stored securely
```

## Framework Selection Guide

**Choose MoSCoW when:**
- You have a fixed timeline
- Need stakeholder alignment
- Defining MVP scope
- Simple, fast prioritization needed

**Choose RICE when:**
- You have quantitative data
- Comparing many features
- Need objective prioritization
- Resource allocation decisions

**Choose Kano when:**
- Understanding feature value perception
- Balancing innovation vs. basics
- Competitive positioning
- Long-term roadmap planning

**Use Multiple Frameworks:**
- Apply MoSCoW for initial filtering
- Use RICE to rank within each MoSCoW category
- Apply Kano to understand feature types
- Combine insights for final prioritization

## Common Anti-Patterns

### Requirements Anti-Patterns

1. **The Solution Specification**
   - **Bad:** "System shall use PostgreSQL database with connection pooling"
   - **Good:** "System shall persist user data with sub-100ms read latency"

2. **The Vague Requirement**
   - **Bad:** "System shall be user-friendly"
   - **Good:** "90% of users shall complete core workflow without help docs"

3. **The Gold Plating**
   - **Bad:** Making everything "MUST" priority
   - **Good:** Ruthlessly prioritize; most features are SHOULD or COULD

4. **The Missing Why**
   - **Bad:** "Add export to PDF button"
   - **Good:** "Enable report sharing with stakeholders who lack system access"

5. **The Implementation Constraint**
   - **Bad:** "Use React hooks for state management"
   - **Good:** "UI shall maintain state across page navigation"

### Prioritization Anti-Patterns

1. **HIPPO (Highest Paid Person's Opinion)**
   - Use data and frameworks, not authority

2. **Prioritization by Volume**
   - Most requested ≠ most valuable

3. **The Squeaky Wheel**
   - Loudest stakeholder ≠ most important

4. **Gut Feel Only**
   - Balance intuition with data

5. **Everything is High Priority**
   - If everything is high, nothing is

## Additional Resources

- See `templates/prd.template.md` for complete PRD structure
- See `templates/tech-spec.template.md` for lightweight alternative
- Use `scripts/prioritize.py` for RICE calculations
- Use `scripts/validate-prd.sh` to check document completeness
