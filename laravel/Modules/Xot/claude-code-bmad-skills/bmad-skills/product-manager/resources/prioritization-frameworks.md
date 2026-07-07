# Prioritization Frameworks - Detailed Reference

This document provides comprehensive guidance on feature and requirement prioritization frameworks used in product management.

---

## Table of Contents

1. [MoSCoW Method](#moscow-method)
2. [RICE Scoring](#rice-scoring)
3. [Kano Model](#kano-model)
4. [Value vs. Effort Matrix](#value-vs-effort-matrix)
5. [Weighted Scoring Model](#weighted-scoring-model)
6. [ICE Score](#ice-score)
7. [Opportunity Scoring](#opportunity-scoring)
8. [Story Mapping](#story-mapping)
9. [Framework Comparison](#framework-comparison)
10. [Choosing the Right Framework](#choosing-the-right-framework)

---

## MoSCoW Method

### Overview
MoSCoW is a time-boxed prioritization technique that categorizes requirements into four groups based on necessity and impact.

**Best For:**
- Agile projects with fixed timelines
- MVP definition and scope management
- Stakeholder alignment
- Resource-constrained projects

### Categories Explained

#### Must Have (M)
**Definition:** Non-negotiable requirements critical to project success.

**Identification Test:**
- "Without this, the project/release is a failure"
- "This is legally or contractually required"
- "This creates unacceptable safety or security risks if omitted"

**Examples:**
- User authentication for a secure application
- Core transaction processing in payment system
- Legal compliance requirements (GDPR, HIPAA)
- Data backup and recovery capabilities

**Characteristics:**
- Cannot be deferred to later release
- No reasonable workaround exists
- Directly tied to project success criteria

---

#### Should Have (S)
**Definition:** Important requirements that add significant value but are not vital.

**Identification Test:**
- "This would cause pain if omitted, but project can still succeed"
- "A workaround exists, though it's not ideal"
- "This significantly impacts user satisfaction"

**Examples:**
- Advanced filtering and search options
- Bulk operations for efficiency
- Email notifications (if alternative notifications exist)
- Export to multiple formats (if at least one export exists)

**Characteristics:**
- High priority but not critical
- Will be included if time/resources permit
- May be deferred to next release if necessary
- Workarounds are available

---

#### Could Have (C)
**Definition:** Desirable features that would be nice to have but have minimal impact if excluded.

**Identification Test:**
- "This would improve user experience but isn't necessary"
- "Users would barely notice if this was missing"
- "This is a quality-of-life improvement"

**Examples:**
- Custom themes and color schemes
- Keyboard shortcuts
- Advanced customization options
- Easter eggs and delighters

**Characteristics:**
- Lowest priority of included features
- Implemented only if time allows
- Easily deferred without impact
- Low cost-benefit ratio

---

#### Won't Have (W)
**Definition:** Features explicitly excluded from current scope.

**Identification Test:**
- "This is valuable but not for this release"
- "We've decided this is out of scope"
- "This doesn't align with current objectives"

**Examples:**
- Features planned for future releases
- Features that don't align with current strategy
- Nice-to-haves with low ROI
- Features that would expand scope too much

**Characteristics:**
- Explicitly documented as out of scope
- Helps manage expectations
- Prevents scope creep
- May be reconsidered in future

---

### Application Process

1. **List All Requirements**
   - Gather all proposed features and requirements
   - Ensure each is clearly defined

2. **Educate Stakeholders**
   - Explain MoSCoW categories
   - Set expectations about limitations

3. **Initial Classification**
   - Have team independently classify requirements
   - Use sticky notes or digital voting

4. **Discuss Disagreements**
   - Focus on items with classification conflicts
   - Use identification tests to resolve

5. **Validate Must Haves**
   - Challenge each "Must Have" rigorously
   - "Must Haves" should be <60% of total features
   - If too many Must Haves, project scope is too large

6. **Document and Share**
   - Create clear list with rationales
   - Get stakeholder sign-off

---

### Common Pitfalls

**Everything is Must Have:**
- **Problem:** No real prioritization occurs
- **Solution:** Enforce 60% maximum on Must Haves; challenge rigorously

**Confusing Wants with Needs:**
- **Problem:** Should Haves classified as Must Haves
- **Solution:** Use the identification tests consistently

**Not Documenting Won't Haves:**
- **Problem:** Excluded features keep being raised
- **Solution:** Explicitly list and explain Won't Haves

---

## RICE Scoring

### Overview
RICE is a quantitative framework that scores features based on four factors: Reach, Impact, Confidence, and Effort.

**Formula:** `RICE Score = (Reach × Impact × Confidence) / Effort`

**Best For:**
- Data-driven organizations
- Comparing many features objectively
- Portfolio prioritization
- Cross-functional alignment

### Components Deep Dive

#### Reach
**Definition:** How many people will be affected by this feature within a time period?

**How to Measure:**
- Users per month/quarter who will use the feature
- Transactions per period affected
- Customer accounts impacted

**Data Sources:**
- Analytics data
- User research
- Market size data
- Sales projections

**Examples:**
- "500 users per month will use the export feature"
- "2,000 transactions per quarter will be processed faster"
- "All 10,000 active users will see the new dashboard"

**Tips:**
- Use consistent time periods (monthly or quarterly)
- Be conservative in estimates
- Account for adoption curves
- Consider seasonal variations

---

#### Impact
**Definition:** How much value does this deliver per user/transaction?

**Scale:**
- **3 = Massive Impact:** Transforms the user experience or business
- **2 = High Impact:** Significant improvement to key workflows
- **1 = Medium Impact:** Noticeable benefit, clear value
- **0.5 = Low Impact:** Minor improvement, marginal benefit
- **0.25 = Minimal Impact:** Barely noticeable improvement

**Assessment Questions:**
- Does this solve a critical pain point? → 3
- Does this significantly improve satisfaction? → 2
- Does this make tasks easier? → 1
- Does this provide minor convenience? → 0.5
- Is this barely noticeable? → 0.25

**Examples:**

**Massive (3):**
- Reducing checkout time from 10 minutes to 30 seconds
- Eliminating a frequent data loss bug
- Adding core functionality that was previously missing

**High (2):**
- Improving search accuracy from 60% to 95%
- Adding batch operations to save hours of manual work
- Implementing real-time collaboration

**Medium (1):**
- Adding keyboard shortcuts for common actions
- Improving page load from 3s to 1s
- Better error messages

**Low (0.5):**
- Adding a copy-to-clipboard button
- Minor UI polish
- Small performance improvement

**Minimal (0.25):**
- Changing button colors
- Adding a tooltip
- Cosmetic changes

---

#### Confidence
**Definition:** How certain are you about your Reach and Impact estimates?

**Scale:**
- **100% = High Confidence:** Backed by solid data and research
- **80% = Medium Confidence:** Some data, reasonable assumptions
- **50% = Low Confidence:** Mostly assumptions, limited data

**Assessment Factors:**
- Quality of data available
- Amount of user research conducted
- Past experience with similar features
- Market validation

**Examples:**

**High Confidence (100%):**
- Feature requested by 200+ customers in surveys
- A/B test data shows 20% improvement
- Proven success in competitor products
- Direct analytics data available

**Medium Confidence (80%):**
- Requested by some customers
- Industry best practices
- Reasonable extrapolation from data
- Good user research

**Low Confidence (50%):**
- Assumption-based
- Limited or no data
- Untested hypothesis
- Novel/experimental feature

**Rule:** If confidence is below 50%, gather more data before proceeding.

---

#### Effort
**Definition:** Total team time required to implement, test, and deploy.

**Unit:** Person-months (total work, not calendar time)

**Includes:**
- Design effort
- Development effort
- Testing effort
- Documentation effort
- Deployment effort
- Training/support preparation

**Examples:**
- **0.5 person-months:** 2 weeks of work for a small team
- **1 person-month:** 4 weeks of work for one person or 2 weeks for two
- **3 person-months:** Major feature requiring significant development
- **12 person-months:** Large initiative requiring multiple teams

**Estimation Tips:**
- Get input from engineering team
- Include all disciplines (design, dev, QA)
- Add buffer for unknowns (20-30%)
- Break down complex features
- Account for technical debt

---

### RICE Calculation Examples

#### Example 1: Quick Win Feature

**Feature:** Add "Export to CSV" button

- **Reach:** 1,000 users/month will use export
- **Impact:** 0.5 (Low - saves minor time)
- **Confidence:** 100% (clear analytics data)
- **Effort:** 0.5 person-months (simple feature)

**RICE Score = (1,000 × 0.5 × 1.0) / 0.5 = 1,000**

---

#### Example 2: Major Feature

**Feature:** Advanced Analytics Dashboard

- **Reach:** 500 users/month (power users segment)
- **Impact:** 3 (Massive - key differentiator)
- **Confidence:** 80% (good research, some assumptions)
- **Effort:** 4 person-months (complex feature)

**RICE Score = (500 × 3 × 0.8) / 4 = 300**

---

#### Example 3: Infrastructure Improvement

**Feature:** Performance Optimization

- **Reach:** 10,000 users/month (all users)
- **Impact:** 1 (Medium - noticeable improvement)
- **Confidence:** 100% (measured performance issues)
- **Effort:** 2 person-months

**RICE Score = (10,000 × 1 × 1.0) / 2 = 5,000**

---

### Prioritization Result

1. Infrastructure Improvement: 5,000 (High reach, proven impact)
2. Quick Win Feature: 1,000 (Easy win with good return)
3. Major Feature: 300 (High effort reduces score despite high impact)

---

### Using RICE Effectively

**Step 1: Score All Features**
- Create spreadsheet with all features
- Fill in Reach, Impact, Confidence, Effort for each
- Calculate RICE scores

**Step 2: Sort by Score**
- Order features by RICE score descending
- This gives initial prioritization

**Step 3: Review Outliers**
- Very high scores: Quick wins or high-impact initiatives
- Very low scores: Reconsider if worth doing
- Similar scores: Apply other considerations

**Step 4: Adjust for Strategy**
- RICE provides data-driven baseline
- Consider strategic alignment
- Account for dependencies
- Factor in timing and resources

**Step 5: Communicate Results**
- Share scoring rationale
- Explain how decisions were made
- Get stakeholder buy-in

---

### Common Pitfalls

**Sandbagging Effort:**
- **Problem:** Inflating effort to lower scores
- **Solution:** Get multiple estimates, hold teams accountable

**Inflating Impact:**
- **Problem:** Making everything "Massive" impact
- **Solution:** Use consistent rubric, compare features

**Ignoring Confidence:**
- **Problem:** Treating guesses same as data
- **Solution:** Penalize low-confidence items, gather more data

**Treating Scores as Absolute:**
- **Problem:** Following scores blindly
- **Solution:** Use as input to decision-making, not sole determinant

---

## Kano Model

### Overview
The Kano Model categorizes features based on how they influence customer satisfaction, helping balance must-haves, performance features, and delighters.

**Developed by:** Professor Noriaki Kano, 1980s

**Best For:**
- Understanding feature value perception
- Balancing innovation with fundamentals
- Competitive differentiation strategy
- Long-term roadmap planning

### Feature Categories

#### 1. Basic Features (Must-Be Quality)

**Characteristics:**
- Expected by users; taken for granted when present
- Causes strong dissatisfaction when absent
- Little additional satisfaction when improved
- Entry-level requirements to compete

**Satisfaction Curve:**
```
   Satisfaction
        |     /
        |    /
        |---/---- (neutral when present)
        |  /
        | /_____ (highly negative when absent)
        |________ Functionality
```

**Examples:**
- **E-commerce:** Shopping cart, checkout, payment processing
- **Email:** Send, receive, search functionality
- **Hotel:** Clean room, working plumbing, wifi
- **Car:** Brakes, steering, doors

**Strategy:**
- Deliver efficiently; don't over-invest
- Get these right but don't expect competitive advantage
- Absence is catastrophic; presence is expected
- Focus on reliability and consistency

**Warning Signs of Missing Basic Features:**
- Customer complaints about "obvious" missing functionality
- High churn rate
- Poor reviews mentioning fundamental issues

---

#### 2. Performance Features (One-Dimensional Quality)

**Characteristics:**
- More is better; linear satisfaction
- Satisfaction increases with quality/quantity
- Dissatisfaction decreases with lower quality
- Direct comparison points with competitors

**Satisfaction Curve:**
```
   Satisfaction
        |        /
        |       /
        |      /
        |-----/----
        |    /
        |   /
        |________ Functionality
```

**Examples:**
- **E-commerce:** Delivery speed, product variety, prices
- **Software:** Page load time, storage capacity, feature count
- **Hotel:** Room size, amenities, location quality
- **Search Engine:** Result relevance, speed, ad ratio

**Strategy:**
- Key competitive battleground
- Invest where you can win or defend
- Benchmark against competitors
- Continuous improvement needed
- Balance cost vs. competitive advantage

**Measurement:**
- Net Promoter Score (NPS)
- Customer Satisfaction (CSAT)
- Feature usage metrics
- Competitive comparisons

---

#### 3. Excitement Features (Attractive Quality)

**Characteristics:**
- Unexpected delighters; not expected by users
- High satisfaction when present
- No dissatisfaction when absent (users don't know to expect them)
- Differentiate from competitors

**Satisfaction Curve:**
```
   Satisfaction
        |          /----
        |         /
        |        /
        |-------/----
        |      /
        |     /
        |________ Functionality
```

**Examples:**
- **Original iPhone:** Multi-touch gestures, visual voicemail
- **Amazon:** One-click ordering, personalized recommendations
- **Netflix:** Download for offline viewing, smart downloads
- **Uber:** Live driver tracking, fare estimates

**Strategy:**
- Source of competitive advantage
- Requires innovation and creativity
- High risk, high reward
- Become Performance features over time
- Opportunity for PR and buzz

**Warning:** What excites early adopters may not excite mainstream users.

---

#### 4. Indifferent Features

**Characteristics:**
- Users don't care either way
- No impact on satisfaction
- Waste of resources to build

**Examples:**
- Features that seemed good in brainstorming but users ignore
- Over-engineered solutions
- Features built for internal stakeholders, not users
- "Nice to have" ideas with no real value

**Strategy:**
- Identify and don't build
- Remove if already built
- Validate assumptions before building

**Detection:**
- Low usage metrics
- No user requests
- A/B tests show no difference
- Feedback is neutral

---

#### 5. Reverse Features

**Characteristics:**
- Presence causes dissatisfaction
- Users actively dislike these

**Examples:**
- Unwanted notifications
- Forced account creation
- Auto-play videos with sound
- Intrusive ads
- Overly complex interfaces

**Strategy:**
- Identify and remove
- Often added for business reasons, not user value
- Balance business needs with user experience

---

### Feature Evolution Over Time

**Critical Pattern:** Features migrate through Kano categories over time.

```
Excitement → Performance → Basic → Indifferent/Reverse
```

**Examples:**

1. **Smartphone Cameras**
   - Excitement (2000s): Having a camera on phone
   - Performance (2010s): Camera quality (megapixels, low-light)
   - Basic (2020s): All phones must have good cameras
   - Future: May become indifferent as AR/other tech dominates

2. **Free Shipping**
   - Excitement (late 1990s): Amazon offers free shipping
   - Performance (2000s): Shipping speed matters
   - Basic (2010s): Expected by e-commerce shoppers
   - Today: Must have to compete

3. **Touch Screens**
   - Excitement (2007): iPhone launches
   - Performance (2010s): Responsiveness, accuracy
   - Basic (2020s): All smartphones have them
   - Today: Expected standard

**Implications:**
- Yesterday's delighters are today's basics
- Must continuously innovate
- Don't rely on Excitement features long-term
- Monitor feature category changes

---

### Conducting Kano Analysis

#### Step 1: Identify Features to Evaluate
- List potential features
- Include existing and proposed features
- Cover range of feature types

#### Step 2: Create Survey
For each feature, ask two questions:

**Functional Question:**
"How would you feel if this feature WAS present?"

1. I like it
2. I expect it
3. I'm neutral
4. I can tolerate it
5. I dislike it

**Dysfunctional Question:**
"How would you feel if this feature WAS NOT present?"

1. I like it
2. I expect it
3. I'm neutral
4. I can tolerate it
5. I dislike it

#### Step 3: Interpret Responses

Use the Kano Evaluation Table:

|  | **Functional: Like** | **Expect** | **Neutral** | **Tolerate** | **Dislike** |
|---|---|---|---|---|---|
| **Dysfunctional: Like** | Q | E | E | E | P |
| **Expect** | R | I | I | I | B |
| **Neutral** | R | I | I | I | B |
| **Tolerate** | R | I | I | I | B |
| **Dislike** | R | R | R | R | Q |

**Key:**
- **E** = Excitement
- **P** = Performance
- **B** = Basic
- **I** = Indifferent
- **R** = Reverse
- **Q** = Questionable (contradictory response)

#### Step 4: Aggregate Results
- Tally responses for each feature
- Assign to category with most responses
- Look for patterns across segments

#### Step 5: Apply to Roadmap
- **Basics:** Must deliver, optimize efficiency
- **Performance:** Competitive battleground, invest strategically
- **Excitement:** Differentiation opportunity, innovate
- **Indifferent:** Don't build
- **Reverse:** Remove if present

---

### Practical Application Example

**Product:** Project Management Software

**Survey Results for "AI Auto-scheduling":**
- Excitement: 45%
- Performance: 30%
- Indifferent: 20%
- Reverse: 5%

**Classification:** Excitement feature (plurality)

**Strategy:**
- Invest in this as differentiator
- Highlight in marketing
- Make it polished and impressive
- Monitor as it may become Performance feature

---

**Survey Results for "Task Creation":**
- Basic: 85%
- Performance: 10%
- Excitement: 5%

**Classification:** Basic feature

**Strategy:**
- Must have for product viability
- Deliver reliably
- Don't over-invest in innovation here
- Focus resources elsewhere

---

## Value vs. Effort Matrix

### Overview
Simple 2x2 matrix plotting features by Value (to user/business) vs. Effort (to implement).

**Best For:**
- Quick prioritization
- Visual stakeholder communication
- Identifying quick wins
- Portfolio balancing

### The Matrix

```
   High Value
        |
    2   |   1
  Quick |  Big
   Wins |  Bets
  ------+------
    4   |   3
   Fill |  Time
   Ins |  Sinks
        |
   Low Value ← → High Effort
```

**Quadrant 1: Big Bets (High Value, High Effort)**
- Strategic initiatives
- Major features
- Long-term investments
- Require executive buy-in
- Careful planning needed

**Quadrant 2: Quick Wins (High Value, Low Effort)**
- Highest priority
- Immediate ROI
- Fast delivery
- Build momentum
- Show progress

**Quadrant 3: Time Sinks (Low Value, High Effort)**
- Avoid these
- Reject or defer
- Question if truly needed
- May be pet projects

**Quadrant 4: Fill Ins (Low Value, Low Effort)**
- Lowest priority
- Do if spare capacity
- May never do
- Consider automation

### Application Process

1. **List Features**
   - All candidate features
   - Keep granularity consistent

2. **Score Value (1-10)**
   - User value
   - Business value
   - Strategic alignment
   - Get cross-functional input

3. **Score Effort (1-10)**
   - Development time
   - Design time
   - Testing requirements
   - Get engineering input

4. **Plot on Matrix**
   - Create visual grid
   - Use tool or whiteboard
   - Place each feature

5. **Prioritize**
   - Quick Wins first
   - Then Big Bets (selectively)
   - Fill Ins as capacity allows
   - Avoid Time Sinks

---

## Framework Comparison

| Framework | Best For | Complexity | Time Required | Data Needed |
|-----------|----------|------------|---------------|-------------|
| MoSCoW | MVP scoping, fixed timelines | Low | Low | Minimal |
| RICE | Many features, data-driven orgs | Medium | Medium | Analytics data |
| Kano | Understanding satisfaction drivers | High | High | User research |
| Value vs. Effort | Quick decisions, visual comm | Low | Low | Estimates |
| Weighted Scoring | Multi-criteria, complex decisions | Medium | Medium | Various |

---

## Choosing the Right Framework

**Use MoSCoW when:**
- You have fixed timeline/budget
- Need stakeholder alignment on scope
- Defining MVP
- Simple yes/no decisions needed

**Use RICE when:**
- You have analytics and usage data
- Comparing 10+ features
- Need objective, defensible prioritization
- Working with distributed teams

**Use Kano when:**
- Planning long-term roadmap
- Understanding competitive positioning
- Balancing innovation with fundamentals
- Have resources for user research

**Use Value vs. Effort when:**
- Need quick, visual prioritization
- Communicating with executives
- Identifying quick wins
- Balancing portfolio

**Use Multiple Frameworks:**
- MoSCoW for initial filtering
- RICE to rank within categories
- Kano to understand feature types
- Value vs. Effort for visual communication

---

## Additional Resources

- **RICE Calculator:** Use `../scripts/prioritize.py`
- **PRD Template:** See `../templates/prd.template.md`
- **Main Skill Guide:** See `../SKILL.md`
- **Detailed Reference:** See `../REFERENCE.md`

---

**Last Updated:** 2025-12-09
