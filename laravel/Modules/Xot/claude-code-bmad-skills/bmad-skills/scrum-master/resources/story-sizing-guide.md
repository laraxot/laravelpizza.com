# Story Sizing Guide

A comprehensive guide to estimating user stories using Fibonacci story points.

## Table of Contents

1. [Story Points Fundamentals](#story-points-fundamentals)
2. [Fibonacci Scale](#fibonacci-scale)
3. [Sizing by Complexity](#sizing-by-complexity)
4. [Sizing by Duration](#sizing-by-duration)
5. [Common Patterns](#common-patterns)
6. [Breaking Down Large Stories](#breaking-down-large-stories)
7. [Estimation Techniques](#estimation-techniques)

## Story Points Fundamentals

### What Are Story Points?

Story points are a **relative** measure of:
- **Complexity:** How difficult is the work?
- **Effort:** How much work is required?
- **Uncertainty:** How well do we understand the requirements?

Story points are **NOT**:
- Exact time estimates
- Comparable across teams
- A commitment or deadline

### Why Story Points?

**Benefits:**
- Account for complexity, not just time
- Reduce estimation debates (coarse-grained scale)
- Velocity becomes predictable metric
- Focus on relative sizing, not exact hours
- Team-specific (one team's 5 points may differ from another's)

**Drawbacks:**
- Can be misused as deadlines
- Require calibration period
- Abstract concept, harder to explain to stakeholders

## Fibonacci Scale

### The Numbers: 1, 2, 3, 5, 8, 13

We use Fibonacci because:
1. **Increasing gaps** reflect increasing uncertainty at larger sizes
2. **Prevents false precision** (no 4, 6, 7, 9, 10, 11, 12)
3. **Natural breakpoint at 8** encourages story decomposition
4. **Industry standard** for agile teams

### Point Ranges

| Points | Relative Size | Description |
|--------|---------------|-------------|
| 1 | Extra Small | Trivial change, barely worth tracking |
| 2 | Small | Quick implementation, clear approach |
| 3 | Medium-Small | Standard story, some complexity |
| 5 | Medium | Typical feature story, multiple files |
| 8 | Large | Maximum recommended, full-stack work |
| 13 | Extra Large | **Too big - break it down!** |

## Sizing by Complexity

### 1 Point - Trivial

**Complexity Indicators:**
- Single file change
- No new logic or algorithms
- Copy/paste or config change
- No testing required (or single assertion)
- No dependencies on other work
- Could be done while pair programming

**Examples:**
- Update text content on a page
- Change CSS color or spacing
- Update a configuration value
- Fix a typo in code or docs
- Add a console.log statement
- Update an API endpoint URL

**Anti-patterns:**
- If it requires understanding business logic → 2 points
- If it touches multiple files → 2+ points
- If it needs testing → 2+ points

### 2 Points - Simple

**Complexity Indicators:**
- 1-2 file changes
- Reuse existing patterns/components
- Simple CRUD operations
- Basic validation or error handling
- Unit tests only
- Clear implementation path

**Examples:**
- Add a new field to existing form
- Create simple GET endpoint that returns data
- Add basic input validation
- Update existing component with new prop
- Simple data transformation
- Add logging to existing function

**Technical Examples:**
- Add `lastName` field to user registration form
- Create `/api/users/count` endpoint
- Add email format validation
- Add `isActive` filter to user list
- Convert date to ISO format before saving

### 3 Points - Moderate

**Complexity Indicators:**
- 2-4 file changes
- Some new logic required
- State management needed
- Multiple test cases
- Integration between 2 components
- Some unknowns, but approachable

**Examples:**
- Component with conditional rendering
- Search functionality on existing data
- Form with multiple validation rules
- API endpoint with query parameters
- Data filtering or sorting logic
- User preferences storage

**Technical Examples:**
- Search bar that filters product list
- User settings page with 3-5 options
- API endpoint with pagination
- Modal dialog with form validation
- Toggle switch with localStorage persistence

### 5 Points - Complex

**Complexity Indicators:**
- 4-8 file changes
- New patterns or approaches needed
- Multiple component integration
- Frontend + backend coordination
- Integration and unit tests
- Some architecture decisions

**Examples:**
- Multi-step form wizard
- File upload with preview
- Authentication flow (login only)
- Report generation from database
- Real-time notifications (basic)
- Third-party API integration

**Technical Examples:**
- User registration flow (form → validation → API → email)
- Image upload with resize and S3 storage
- OAuth login with Google
- Generate PDF report from data
- WebSocket connection for chat
- Stripe payment intent creation

### 8 Points - Very Complex

**Complexity Indicators:**
- 8-12 file changes
- Complex business logic
- Multiple system integration
- Full-stack feature
- Database schema changes
- Comprehensive test coverage
- Performance considerations

**Examples:**
- Complete checkout flow
- Advanced search with filters and facets
- Real-time collaborative editing (basic)
- Data export/import functionality
- Complex dashboard with multiple widgets
- Permission/role management system

**Technical Examples:**
- Shopping cart → checkout → payment → confirmation
- Elasticsearch integration with advanced queries
- Operational transform for collaborative docs
- CSV/Excel import with validation and error handling
- Dashboard with 5+ charts and data sources
- RBAC system with roles, permissions, resources

**Warning:** 8 points is the **maximum** recommended story size. If uncertain whether it's 8 or 13, break it down.

### 13 Points - Epic-Sized

**Indicators:**
- Too large for single story
- Spans multiple subsystems
- 3-5+ days of work
- Multiple unknowns
- Could be broken into 2-4 smaller stories

**Action:** **ALWAYS BREAK DOWN**

**Example Breakdown:**

Original (13 points):
```
"User can purchase products through checkout flow"
```

Broken down:
- "User can add items to shopping cart" (3 points)
- "User can view and update cart" (2 points)
- "User can enter shipping information" (3 points)
- "User can enter payment information" (5 points)
- "User receives order confirmation" (2 points)

Total: 15 points (slightly more than original due to better understanding)

## Sizing by Duration

### Time Mapping (Approximate)

| Points | Duration | Dev Hours | Working Days |
|--------|----------|-----------|--------------|
| 1 | 1-2 hours | 1-2 | 0.125-0.25 |
| 2 | 2-4 hours | 2-4 | 0.25-0.5 |
| 3 | 4-8 hours | 4-8 | 0.5-1 |
| 5 | 1-2 days | 8-16 | 1-2 |
| 8 | 2-3 days | 16-24 | 2-3 |
| 13 | 3-5 days | 24-40 | 3-5 |

**Important:** These are guidelines, not commitments. Actual time varies by:
- Developer experience
- Code familiarity
- Technical debt
- Interruptions and context switches
- Testing requirements
- Code review cycles

## Common Patterns

### Frontend Patterns

| Pattern | Typical Points | Notes |
|---------|---------------|-------|
| New simple component | 2-3 | Presentational, no state |
| Component with state | 3-5 | Local state, some logic |
| Complex component | 5-8 | Multiple states, side effects |
| New page/route | 3-5 | Layout + components + routing |
| Form with validation | 3-5 | Depends on field count |
| Modal/dialog | 2-3 | Reusable component |
| Chart/visualization | 5-8 | Depends on complexity |
| Responsive layout | 3-5 | Breakpoints, testing |

### Backend Patterns

| Pattern | Typical Points | Notes |
|---------|---------------|-------|
| Simple GET endpoint | 2 | Return data, no logic |
| GET with filtering | 3 | Query params, pagination |
| POST endpoint | 3-5 | Validation, business logic |
| Complex endpoint | 5-8 | Multiple operations, transactions |
| Database migration | 2-3 | Schema changes only |
| New database table | 3-5 | Schema + model + basic queries |
| Authentication endpoint | 5 | Login or registration |
| Third-party integration | 5-8 | API calls, error handling |
| Background job | 5-8 | Queue, processing, retries |

### Full-Stack Patterns

| Pattern | Typical Points | Notes |
|---------|---------------|-------|
| Simple CRUD | 5-8 | Create, Read, Update, Delete |
| User authentication | 8 | Login, registration, JWT |
| File upload | 5-8 | Frontend + backend + storage |
| Search functionality | 5-8 | UI + API + search logic |
| Real-time feature | 8 | WebSocket, frontend, backend |
| Report generation | 8 | Query + processing + format |

## Breaking Down Large Stories

### When to Break Down

Break down if:
1. **Size:** Story is 13+ points
2. **Time:** Story takes more than 3 days
3. **Acceptance criteria:** More than 7 criteria
4. **Uncertainty:** Team struggles to estimate
5. **Dependencies:** Blocks many other stories
6. **Testing:** Requires extensive test coverage

### Breakdown Strategy 1: By Workflow

**Original:** "User can manage their profile" (13 points)

**Broken down:**
- "User can view their profile" (2 points)
- "User can edit basic information" (3 points)
- "User can upload profile picture" (5 points)
- "User can change password" (3 points)

**Total:** 13 points (same, but more manageable)

### Breakdown Strategy 2: By Layer

**Original:** "Product search functionality" (13 points)

**Broken down:**
- "Backend: Search API endpoint" (5 points)
- "Frontend: Search input and results" (5 points)
- "Frontend: Search filters and sorting" (3 points)

**Total:** 13 points

### Breakdown Strategy 3: By Priority (Vertical Slices)

**Original:** "Comprehensive analytics dashboard" (13 points)

**Broken down:**
- "Basic analytics dashboard (MVP)" (5 points) ← Deliver this first
- "Add date range filtering" (2 points)
- "Add user segmentation" (3 points)
- "Add export to CSV" (3 points)

**Total:** 13 points, but MVP delivers value early

### Breakdown Strategy 4: By CRUD

**Original:** "Product management" (13 points)

**Broken down:**
- "Create product (form + API)" (3 points)
- "View product details" (2 points)
- "Edit product" (3 points)
- "Delete product" (2 points)
- "List products with pagination" (3 points)

**Total:** 13 points

### Breakdown Strategy 5: By User Role

**Original:** "User and admin dashboards" (13 points)

**Broken down:**
- "User dashboard with basic stats" (5 points)
- "Admin dashboard with user management" (8 points)

**Total:** 13 points

## Estimation Techniques

### Planning Poker

**Process:**
1. Product owner reads user story
2. Team asks clarifying questions
3. Each member selects estimate privately
4. All reveal simultaneously
5. Discuss differences (especially high/low outliers)
6. Re-estimate until consensus

**Benefits:**
- Engages whole team
- Surfaces different perspectives
- Quick consensus building

### T-Shirt Sizing (Then Convert)

**Process:**
1. Estimate as XS, S, M, L, XL
2. Convert to Fibonacci:
   - XS → 1
   - S → 2-3
   - M → 5
   - L → 8
   - XL → 13 (break it down!)

**Benefits:**
- Easier for non-technical stakeholders
- Less intimidating than numbers
- Good for initial rough estimates

### Reference Story Method

**Process:**
1. Find a previously completed 3-point story
2. Use as reference: "Is this bigger or smaller?"
3. Assign points relative to reference

**Benefits:**
- Calibrates team's point scale
- Consistent estimates over time
- Easy to explain: "Like STORY-005, but more complex"

### Three-Point Estimation

**Process:**
1. Estimate best case (optimistic)
2. Estimate worst case (pessimistic)
3. Estimate most likely
4. Average: (optimistic + 4×likely + pessimistic) / 6

**Benefits:**
- Accounts for uncertainty
- Surfaces risk
- More accurate for complex stories

**Example:**
- Optimistic: 3 points
- Likely: 5 points
- Pessimistic: 8 points
- Average: (3 + 4×5 + 8) / 6 = 5.17 ≈ 5 points

## Estimation Anti-Patterns

### Anti-Pattern 1: Using Story Points as Deadlines

**Wrong:** "This is 5 points, so it must be done by Wednesday"

**Right:** "This is 5 points. Based on our velocity, we'll complete about 40 points this sprint."

### Anti-Pattern 2: Comparing Across Teams

**Wrong:** "Team A did this in 5 points, so you should too"

**Right:** "Our team estimates this as 8 points based on our skills and context"

### Anti-Pattern 3: Estimating Tasks Instead of Value

**Wrong:** Breaking story into "Write code (3), Write tests (2), Review (1)"

**Right:** Estimating the complete story as a unit of deliverable value

### Anti-Pattern 4: Re-estimating Based on Actual Time

**Wrong:** "This took 2 days but we said 3 points, let's change it to 5"

**Right:** "This took longer than expected. Let's discuss why in retrospective and improve future estimates."

### Anti-Pattern 5: Allowing 13+ Point Stories in Sprint

**Wrong:** "We'll just take this 13-point story and work on it all sprint"

**Right:** "Let's break this into 3-5 smaller stories we can complete and test independently"

## Calibration Examples

Use these to calibrate your team's estimation:

### 1 Point Examples
- Update copyright year in footer
- Change button color in CSS
- Update environment variable
- Fix typo in user-facing text
- Add console.log for debugging

### 2 Point Examples
- Add "remember me" checkbox to login
- Create `/health` endpoint that returns `{status: 'ok'}`
- Add tooltip to existing button
- Update error message text
- Add loading spinner to button

### 3 Point Examples
- Add email validation to signup form
- Create user profile display page
- Add sorting to existing data table
- Implement "forgot password" link
- Add search filter to list view

### 5 Point Examples
- User registration with validation
- File upload with preview
- Password reset email flow
- Pagination for product list
- Basic user settings page

### 8 Point Examples
- Complete login/logout flow with JWT
- Shopping cart with add/remove/update
- Admin user management page
- Product search with filters
- CSV import with error handling

## Quick Decision Tree

```
Is it just a config/text change?
├─ Yes → 1 point
└─ No ↓

Is it a single file, simple logic?
├─ Yes → 2 points
└─ No ↓

Is it 2-4 files, moderate complexity?
├─ Yes → 3 points
└─ No ↓

Is it multiple components, frontend + backend?
├─ Yes → 5 points
└─ No ↓

Is it a full feature with complex logic?
├─ Yes → 8 points
└─ No ↓

Is it bigger than 8 points?
└─ BREAK IT DOWN into 2-4 smaller stories
```

## Estimation Checklist

Before finalizing an estimate, ask:

- [ ] Does the story have clear acceptance criteria?
- [ ] Do we understand the technical approach?
- [ ] Have we identified dependencies?
- [ ] Is the story independently testable?
- [ ] Is it 8 points or less?
- [ ] Does the team agree on the estimate?
- [ ] Have we considered edge cases?
- [ ] Is it sized relative to our past stories?

## Best Practices

1. **Estimate as a team** - Don't let one person dictate estimates
2. **Use reference stories** - "About the same as STORY-025"
3. **When in doubt, break it down** - Smaller stories = less risk
4. **Re-estimate sparingly** - Only if requirements fundamentally change
5. **Track actual vs. estimate** - Use for learning, not for changing points
6. **Focus on patterns** - Build team's shared understanding over time
7. **Don't overthink** - Estimates are approximate by nature
8. **Celebrate consistency** - Stable velocity > perfect estimates
9. **Accept uncertainty** - Large estimates (8+) have more variability
10. **Review in retrospectives** - Continuously improve estimation accuracy

## Common Questions

**Q: What if the story is between 5 and 8?**
**A:** Round up to 8 if uncertain. If team debates, it's probably 8.

**Q: Can we use half points (0.5, 1.5)?**
**A:** No. Fibonacci scale prevents false precision. Choose the closest Fibonacci number.

**Q: What if a 3-point story took 2 days?**
**A:** That's okay. Story points are estimates. Track for learning, don't re-estimate.

**Q: Should we estimate bugs?**
**A:** Yes, estimate bugs like stories. Helps with velocity and capacity planning.

**Q: What about spikes (research tasks)?**
**A:** Time-box spikes (4-8 hours). Optionally assign 2-3 points. Don't count toward velocity.

**Q: Can we create a 0-point story?**
**A:** Avoid 0-point stories. If it's work, it has size. Minimum is 1 point.

**Q: How do we estimate when we don't know the tech?**
**A:** Increase estimate to account for learning. Consider a spike first. Or break into "Learn X" (spike) + "Implement Y" (story).

---

**Remember:** Story points are a tool for planning, not a measure of developer performance. Focus on consistent, relative sizing within your team. Velocity will stabilize over time, enabling predictable delivery.
