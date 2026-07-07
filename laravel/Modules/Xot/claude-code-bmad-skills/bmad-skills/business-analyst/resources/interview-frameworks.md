# Interview Frameworks and Techniques

This document provides detailed frameworks and techniques for conducting effective stakeholder interviews and product discovery sessions.

## Table of Contents

1. [5 Whys Framework](#5-whys-framework)
2. [Jobs-to-be-Done (JTBD)](#jobs-to-be-done-jtbd)
3. [SMART Goals](#smart-goals)
4. [Problem-Solution Fit](#problem-solution-fit)
5. [Open-Ended Questions](#open-ended-questions)
6. [Probing Techniques](#probing-techniques)
7. [Active Listening](#active-listening)
8. [Interview Best Practices](#interview-best-practices)

---

## 5 Whys Framework

### Purpose
Identify root causes by asking "why" repeatedly to move beyond symptoms to underlying problems.

### When to Use
- Problem identification phase
- Understanding user pain points
- Debugging complaints or issues
- Finding systemic problems
- Root cause analysis

### How It Works

1. **State the problem clearly**
   - Write down the specific problem
   - Ensure everyone agrees on the problem statement

2. **Ask "Why?" the first time**
   - Why does this problem occur?
   - Document the answer

3. **Ask "Why?" four more times**
   - Take each answer and ask why again
   - Continue until you reach the root cause
   - Usually 5 iterations, but can be fewer or more

4. **Identify the root cause**
   - The final "why" reveals the root cause
   - This is what needs to be addressed

5. **Develop countermeasures**
   - Focus solutions on the root cause
   - Avoid band-aids on symptoms

### Example 1: E-commerce Checkout

```
Problem: Users abandon checkout process

Why? → The checkout takes too long
  Why? → Users have to enter shipping info manually every time
    Why? → We don't save shipping addresses
      Why? → Privacy concerns prevented implementation
        Why? → We haven't implemented secure storage solution

Root Cause: Lack of secure storage infrastructure
Solution: Implement secure, encrypted storage for user data
```

### Example 2: Low User Engagement

```
Problem: Users aren't engaging with our new feature

Why? → They're not discovering it
  Why? → It's hidden in a submenu
    Why? → We didn't want to clutter the main interface
      Why? → We haven't organized features by priority
        Why? → We don't have data on feature usage patterns

Root Cause: Missing usage analytics and prioritization framework
Solution: Implement analytics and feature prioritization system
```

### Tips for Success

**Do:**
- Focus on processes and systems, not people
- Be specific with each answer
- Ask follow-up questions for clarity
- Document the chain of causation
- Verify the root cause with stakeholders

**Don't:**
- Stop too early (at symptoms)
- Blame individuals
- Accept vague answers
- Skip validation
- Assume the first answer is complete

### Common Mistakes

1. **Stopping at Symptoms**
   - Bad: "Users leave because it's slow" (symptom)
   - Good: Continue asking why until you reach the technical or process root cause

2. **Accepting Vague Answers**
   - Bad: "It's complicated"
   - Good: "What specifically makes it complicated?"

3. **Jumping to Solutions**
   - Bad: "We need a faster server" (before understanding why)
   - Good: Complete the 5 Whys first, then ideate solutions

---

## Jobs-to-be-Done (JTBD)

### Purpose
Understand what users are trying to accomplish (their "job") rather than what features they want.

### Core Concept
People don't want products; they want to get jobs done. Focus on the outcome, not the tool.

### The JTBD Statement Format

```
When [situation],
I want to [motivation],
so I can [expected outcome]
```

### Framework Components

1. **The Job** - What users are trying to accomplish
2. **The Circumstance** - When/where the job arises
3. **The Outcome** - What success looks like
4. **The Obstacles** - What makes the job difficult
5. **Current Solutions** - How users do it now

### Key Questions to Ask

**Understanding the Job:**
- What are you trying to accomplish?
- What job are you hiring this product to do?
- When do you need to do this?
- How do you know when you've succeeded?

**Understanding Current Solutions:**
- How do you do this today?
- What products/tools are you using?
- What do you like about your current solution?
- What frustrates you about it?

**Understanding Obstacles:**
- What's the hardest part about getting this done?
- What slows you down?
- What would make this easier?
- What have you tried that didn't work?

**Understanding Success:**
- What would the ideal solution look like?
- How would you measure success?
- What would change in your work if this was solved?

### Example 1: Meal Planning App

**Traditional Approach (Features):**
"I want a recipe search with filters and a shopping list"

**JTBD Approach (Outcome):**
```
When I'm planning my weekly meals,
I want to quickly find recipes that use ingredients I already have,
so I can reduce food waste and save time shopping

Job: Minimize food waste while meal planning
Circumstance: Weekly meal planning session
Outcome: Use existing ingredients, save time
Obstacles: Takes 30+ minutes, recipes need items I don't have
Current Solution: Google search + checking pantry repeatedly
Success: Find suitable recipes in under 5 minutes
```

**Insights:**
- Focus on ingredient matching, not recipe variety
- Prioritize speed over comprehensiveness
- Integration with pantry inventory
- Differentiation from competitors (most focus on recipes, not ingredient usage)

### Example 2: Project Management Tool

**Traditional Approach (Features):**
"I want Gantt charts and task assignments"

**JTBD Approach (Outcome):**
```
When I'm leading a project with multiple stakeholders,
I want to quickly understand who is working on what and if we're on track,
so I can identify problems before they derail the project

Job: Maintain project visibility and prevent delays
Circumstance: Daily/weekly project check-ins
Outcome: Early problem detection, clear accountability
Obstacles: Information scattered across tools, status updates take hours
Current Solution: Spreadsheets + Slack + email
Success: Get complete project status in under 5 minutes
```

**Insights:**
- Focus on status visibility, not task tracking
- Real-time updates more important than planning features
- Integration with communication tools
- Dashboard view prioritized over detailed Gantt charts

### Using JTBD for Feature Prioritization

**Job Success Matrix:**

| Job Stage | Current Solution | Pain Level | Our Opportunity | Priority |
|-----------|-----------------|------------|-----------------|----------|
| Discovery | Google search | High | Intelligent search | High |
| Evaluation | Manual comparison | Medium | Comparison tool | Medium |
| Purchase | Phone call | Low | Online booking | Low |

### Tips for JTBD Interviews

**Do:**
- Focus on specific situations and stories
- Ask "Tell me about the last time you..."
- Understand the job before discussing solutions
- Look for emotional and social jobs too
- Document exact quotes

**Don't:**
- Ask "Would you use feature X?"
- Accept hypotheticals ("I would probably...")
- Focus only on functional jobs
- Ignore the circumstances
- Jump to solutions

### JTBD vs. User Stories

**User Story:**
"As a user, I want to filter search results so I can find relevant items"

**JTBD:**
"When I'm searching for a specific type of item, I want to narrow down results by my key criteria, so I can find what I need without scrolling through hundreds of irrelevant results"

The JTBD version reveals:
- Specific situation (searching for specific type)
- Real problem (hundreds of irrelevant results)
- Success criteria (no excessive scrolling)
- Why it matters (efficiency)

---

## SMART Goals

### Purpose
Ensure goals are well-defined, measurable, and achievable.

### SMART Criteria

#### S - Specific
**What:** Clearly defined, unambiguous goal
**Why:** Prevents misinterpretation and scope creep

**Questions:**
- What exactly are we trying to achieve?
- Who is involved?
- What is included/excluded?

**Example:**
- Vague: "Improve the dashboard"
- Specific: "Redesign the analytics dashboard to display real-time sales data with drill-down capabilities"

#### M - Measurable
**What:** Quantifiable success criteria
**Why:** Enables tracking progress and determining success

**Questions:**
- How will we measure success?
- What metrics will we track?
- How much improvement is needed?

**Example:**
- Vague: "Make the app faster"
- Measurable: "Reduce page load time from 5 seconds to 2 seconds for 95% of requests"

#### A - Achievable
**What:** Realistic given resources and constraints
**Why:** Prevents setting up for failure and maintains motivation

**Questions:**
- Is this realistic with our resources?
- What constraints do we face?
- What dependencies exist?

**Example:**
- Unrealistic: "Build a complete AI platform in 2 weeks"
- Achievable: "Implement basic AI-powered search suggestions in 6 weeks"

#### R - Relevant
**What:** Aligned with broader objectives
**Why:** Ensures effort contributes to strategic goals

**Questions:**
- Why does this matter?
- How does it support business objectives?
- Is this the right time?

**Example:**
- Irrelevant: "Add social sharing to internal admin tool"
- Relevant: "Add bulk operations to admin tool to reduce manual work by 80%"

#### T - Time-bound
**What:** Has a specific deadline or timeline
**Why:** Creates urgency and enables planning

**Questions:**
- When will this be complete?
- What are the milestones?
- What's the timeline?

**Example:**
- Vague: "Eventually launch mobile app"
- Time-bound: "Launch iOS app beta by Q2 2025, Android by Q3 2025"

### Complete SMART Goal Examples

#### Example 1: User Satisfaction

**Vague Goal:**
"Make users happier with the product"

**SMART Goal:**
"Increase user satisfaction score from 3.2 to 4.0 (out of 5) by Q2 2025 by implementing the top 3 feature requests identified in user surveys (search filters, saved preferences, and export functionality)"

**Breakdown:**
- S: User satisfaction score, specific features
- M: 3.2 to 4.0 on 5-point scale
- A: Top 3 features (focused scope)
- R: Tied to user satisfaction metric
- T: By Q2 2025

#### Example 2: Performance

**Vague Goal:**
"Improve system performance"

**SMART Goal:**
"Reduce API response time from 800ms to 300ms for 95% of requests by end of Q1 2025 through database optimization and caching implementation"

**Breakdown:**
- S: API response time, specific optimizations
- M: 800ms to 300ms, 95th percentile
- A: Known optimization techniques
- R: Critical for user experience
- T: End of Q1 2025

#### Example 3: Market Expansion

**Vague Goal:**
"Expand to new markets"

**SMART Goal:**
"Launch in 3 European markets (UK, Germany, France) by Q3 2025, achieving 1,000 paid users and $50K MRR within 6 months of launch through localized marketing and sales efforts"

**Breakdown:**
- S: 3 specific markets, specific activities
- M: 1,000 users, $50K MRR
- A: 6-month ramp period
- R: Strategic expansion plan
- T: Q3 2025 launch

### Applying SMART to Product Features

**Feature Goal Template:**
```
[Action] [Specific Feature]
to achieve [Measurable Outcome]
for [Relevant User Segment]
by [Time Deadline]
with [Achievable Constraints]
```

**Example:**
"Launch advanced search filters to reduce average search time from 3 minutes to 30 seconds for power users by end of Q2 2025 using existing search infrastructure"

---

## Problem-Solution Fit

### Purpose
Validate that proposed solutions actually address real problems before investing in development.

### The Four Validation Questions

#### 1. Is this a real problem?
- Does it actually exist?
- Is it frequent or severe enough to matter?
- Do people currently try to solve it?

**Red Flags:**
- Users don't mention it unprompted
- No current workarounds exist
- "Nice to have" but not essential

#### 2. Is it painful enough?
- Would users pay (money or effort) to solve it?
- What do they currently sacrifice?
- How much time/money/frustration does it cost?

**Pain Scale:**
- **Low:** Mild annoyance, rarely thought about
- **Medium:** Regular frustration, actively looking for solutions
- **High:** Critical blocker, willing to pay significantly

#### 3. Is our solution viable?
- Does it actually solve the problem?
- Is it technically feasible?
- Can we build/deliver it?

**Validation:**
- Prototype testing
- Technical spikes
- Resource assessment

#### 4. Is it better than alternatives?
- What do users do now?
- Why would they switch?
- What's our unique value?

**Competitive Test:**
- 10x better on one dimension, or
- Significantly better on multiple dimensions

### Problem-Solution Fit Framework

**Phase 1: Problem Validation**

Questions to answer:
- [ ] What specific problem are we solving?
- [ ] Who experiences this problem?
- [ ] How often does it occur?
- [ ] What's the impact when it occurs?
- [ ] How do people currently handle it?
- [ ] What have they tried that failed?
- [ ] Would they pay to solve it?

**Evidence Needed:**
- User interviews (minimum 10-15)
- Usage data showing workarounds
- Support tickets/complaints
- Market research

**Phase 2: Solution Validation**

Questions to answer:
- [ ] Does our solution address the root cause?
- [ ] Is it technically feasible?
- [ ] Can users actually use it?
- [ ] Is it better than current solutions?
- [ ] What's the learning curve?
- [ ] What's the total cost (not just money)?

**Evidence Needed:**
- Prototype testing
- Technical proof of concept
- User feedback on mockups
- Competitive analysis

**Phase 3: Fit Validation**

Questions to answer:
- [ ] Would users actually adopt this?
- [ ] What would prevent adoption?
- [ ] What would make them switch?
- [ ] What's the value proposition?
- [ ] Can we reach these users?
- [ ] Can we support them?

**Evidence Needed:**
- Beta testing
- Early adopter feedback
- Conversion data
- Support requirements

### Example: Validating a New Feature

**Proposed Feature:** AI-powered email subject line suggestions

**Problem Validation:**
```
Problem: Low email open rates
Who: Marketing teams
Frequency: Every email campaign (daily/weekly)
Impact: 15-20% open rates vs. 25-30% industry average
Current Solution: Manual A/B testing, trial and error
Pain Level: High - directly impacts campaign ROI
Willingness to Pay: Yes - already paying for email tools
```
Result: VALID PROBLEM

**Solution Validation:**
```
Proposed Solution: AI suggests 5 subject lines, ranks by predicted open rate
Technical Feasibility: Yes - existing AI models available
User Usability: Simple - click to use suggested line
Better than Alternatives:
  - Current: Manual brainstorming (slow, inconsistent)
  - Competitors: Basic templates (generic, not AI)
Unique Value: Personalized suggestions based on audience and history
```
Result: VIABLE SOLUTION

**Fit Validation:**
```
Would users adopt? Yes - beta test showed 80% usage rate
Barriers: Learning to trust AI suggestions
Value Prop: "Increase open rates by 25% in half the time"
User Acquisition: Existing email marketing customers
Support Needs: Documentation, AI explanation
```
Result: GOOD FIT

Decision: BUILD IT

---

## Open-Ended Questions

### Purpose
Encourage detailed responses and uncover insights that closed questions would miss.

### Question Starters

**Exploratory:**
- "Tell me about..."
- "Describe..."
- "Walk me through..."
- "Help me understand..."

**Process-Oriented:**
- "How do you currently..."
- "What's your process for..."
- "How do you decide..."
- "What happens when..."

**Experience-Oriented:**
- "Can you think of a time when..."
- "Describe a recent situation where..."
- "What was it like when..."

**Problem-Oriented:**
- "What challenges do you face..."
- "What's difficult about..."
- "What frustrates you about..."
- "What would make [task] easier?"

**Opinion-Oriented:**
- "What do you think about..."
- "How do you feel about..."
- "What's your take on..."

### Examples by Context

**Understanding Current Workflow:**
- "Walk me through how you handle [task] from start to finish"
- "Tell me about the last time you needed to [do X]"
- "Describe a typical day using [product/tool]"

**Identifying Pain Points:**
- "What's the most frustrating part of [process]?"
- "What challenges do you face when trying to [goal]?"
- "Tell me about a time when [tool] didn't work as expected"

**Understanding Priorities:**
- "If you could only fix one thing, what would it be?"
- "What keeps you up at night about [topic]?"
- "What would make the biggest difference in your work?"

**Exploring Solutions:**
- "How would you ideally like this to work?"
- "What would make this task easier for you?"
- "Describe your perfect solution to this problem"

### Open vs. Closed Questions

**Closed (Avoid):**
- "Do you like the dashboard?" (Yes/No)
- "Is the search fast enough?" (Yes/No)
- "Would you use this feature?" (Yes/No)

**Open (Better):**
- "What do you like or dislike about the dashboard?"
- "How does the search speed affect your work?"
- "Tell me about how you would use this feature"

---

## Probing Techniques

### Purpose
Dig deeper into responses to uncover specific details and true motivations.

### Types of Probes

#### 1. Clarification Probes
**Purpose:** Ensure you understand correctly

**Examples:**
- "What do you mean by [term they used]?"
- "Can you clarify what you meant when you said [quote]?"
- "I want to make sure I understand - are you saying that [paraphrase]?"

#### 2. Detail Probes
**Purpose:** Get specific examples and details

**Examples:**
- "Can you give me a specific example?"
- "Tell me more about that"
- "What specifically happened?"
- "How exactly does that work?"

#### 3. Frequency Probes
**Purpose:** Understand how often something occurs

**Examples:**
- "How often does that happen?"
- "When was the last time?"
- "How many times per week/month?"

#### 4. Impact Probes
**Purpose:** Understand consequences and importance

**Examples:**
- "What happens when [situation]?"
- "How does that affect your work?"
- "What's the cost of [problem]?"
- "Why is that important to you?"

#### 5. Comparison Probes
**Purpose:** Understand relative importance

**Examples:**
- "How does this compare to [alternative]?"
- "Which is more important: [X] or [Y]?"
- "What's different about [scenario A] vs [scenario B]?"

#### 6. Exception Probes
**Purpose:** Find edge cases and limitations

**Examples:**
- "Are there times when that doesn't work?"
- "What's different about [exception]?"
- "Has it ever failed? Tell me about that."

### The 5-Second Rule

**Technique:** After someone finishes answering, wait 5 seconds before responding.

**Why:**
- People often continue talking to fill silence
- Additional information is often more candid
- Shows you're listening and thinking

**Example:**
```
Interviewer: "What challenges do you face with the current system?"
User: "It's slow sometimes"
[5 seconds of silence]
User: "Actually, the main issue is that when I'm running reports,
       I can't do anything else. The whole system locks up for 5-10 minutes."
```

### Progressive Deepening

**Technique:** Ask increasingly specific follow-ups

**Level 1 (Surface):** "How do you handle customer requests?"
**Level 2 (Process):** "Walk me through the steps"
**Level 3 (Specifics):** "What do you do if [specific scenario]?"
**Level 4 (Edge Cases):** "Has that ever failed? What happened?"
**Level 5 (Impact):** "How did that affect your customer relationship?"

---

## Active Listening

### Core Principles

1. **Listen to Understand, Not to Respond**
   - Focus on their message
   - Resist planning your response
   - Let them finish completely

2. **Listen for What's Not Said**
   - Note hesitations
   - Observe body language
   - Identify what they avoid

3. **Minimize Distractions**
   - Close other windows
   - Silence notifications
   - Give full attention

### Active Listening Techniques

#### 1. Reflecting
Repeat back what you heard

"So what I'm hearing is that [summary]. Is that right?"

#### 2. Paraphrasing
Restate in your own words

"It sounds like the main issue is [paraphrase]?"

#### 3. Summarizing
Capture key points periodically

"Let me make sure I've got this - you mentioned [point 1], [point 2], and [point 3]"

#### 4. Validating
Acknowledge their experience

"That sounds frustrating"
"I can see why that would be challenging"

#### 5. Probing
Ask follow-up questions (see Probing section)

### What to Listen For

**Pain Points:**
- Frustration in tone
- Words like "annoying," "difficult," "confusing"
- Workarounds and hacks
- Repeated mentions

**Priorities:**
- What they mention first
- What they spend most time on
- What they return to
- Emotional emphasis

**Assumptions:**
- "Of course..."
- "Obviously..."
- "Everyone knows..."
- Statements treated as facts

**Constraints:**
- "We can't..."
- "It has to..."
- "They require..."
- Limitations they mention

---

## Interview Best Practices

### Before the Interview

**Preparation:**
- [ ] Research the interviewee (role, context)
- [ ] Review existing documentation
- [ ] Prepare core questions
- [ ] Identify knowledge gaps to fill
- [ ] Set clear objectives
- [ ] Schedule appropriate time (usually 45-60 min)
- [ ] Test technology (if remote)
- [ ] Prepare note-taking method

**Opening:**
- Introduce yourself and purpose
- Explain how you'll use the information
- Set expectations for time
- Ask permission to take notes/record
- Start with easy questions

### During the Interview

**Do:**
- Start with open-ended questions
- Listen more than talk (80/20 rule)
- Take detailed notes (exact quotes when possible)
- Ask for examples and specifics
- Use the 5-second rule
- Follow interesting threads
- Validate your understanding
- Watch for non-verbal cues
- Stay neutral (don't lead)

**Don't:**
- Jump to solutions
- Ask leading questions
- Interrupt
- Defend current solution
- Ask yes/no questions
- Argue or debate
- Make promises
- Rush to fill silence

### Note-Taking Tips

**Capture:**
- Exact quotes (use quotation marks)
- Specific examples
- Numbers and metrics
- Emotional reactions
- Your observations
- Follow-up questions

**Format:**
```
[timestamp] QUOTE: "It takes forever to load"
[timestamp] NOTE: User seemed frustrated
[timestamp] DATA: Takes 5-10 minutes daily
[timestamp] FOLLOWUP: Ask about peak times
```

### After the Interview

**Immediate Actions (within 1 hour):**
- [ ] Review and clean up notes
- [ ] Highlight key insights
- [ ] Note patterns and themes
- [ ] Identify follow-up questions
- [ ] Document assumptions to validate

**Follow-Up:**
- [ ] Send thank you
- [ ] Share summary (if appropriate)
- [ ] Schedule follow-up if needed
- [ ] Add insights to documentation
- [ ] Update requirements

**Synthesis:**
- [ ] Compare with other interviews
- [ ] Identify patterns
- [ ] Note contradictions
- [ ] Quantify where possible
- [ ] Document key findings

### Interview Questions Checklist

**Context:**
- [ ] What's your role?
- [ ] What are your main responsibilities?
- [ ] Who do you work with?

**Current State:**
- [ ] How do you currently handle [task]?
- [ ] What tools do you use?
- [ ] What's your typical workflow?
- [ ] How often do you do this?

**Pain Points:**
- [ ] What's most challenging about [process]?
- [ ] What frustrates you?
- [ ] What takes the most time?
- [ ] What would you change?

**Priorities:**
- [ ] What's most important to you?
- [ ] If you could only fix one thing, what would it be?
- [ ] What do you spend most time on?

**Success:**
- [ ] What does success look like?
- [ ] How do you measure it?
- [ ] What would make your work easier?

### Common Interview Mistakes

1. **Asking Leading Questions**
   - Bad: "Don't you think dark mode would be better?"
   - Good: "What are your thoughts on the interface?"

2. **Accepting Vague Answers**
   - Bad: User says "it's complicated" - move on
   - Good: "What specifically makes it complicated?"

3. **Talking Too Much**
   - Bad: Explaining your solution for 10 minutes
   - Good: Ask questions, listen for 80% of time

4. **Not Following Up**
   - Bad: Accept surface answer
   - Good: Ask "why," "how," "can you give an example"

5. **Confirmation Bias**
   - Bad: Only ask questions that confirm your hypothesis
   - Good: Actively seek disconfirming evidence

6. **Jumping to Solutions**
   - Bad: "So we'll build X to solve that"
   - Good: "Tell me more about that problem"

7. **Yes/No Questions**
   - Bad: "Do you like the dashboard?"
   - Good: "What do you think about the dashboard?"

8. **Multiple Questions at Once**
   - Bad: "What features do you want and when and what's your budget?"
   - Good: Ask one question at a time

---

## Quick Reference Cards

### Discovery Interview Card
```
OPENING: Context & role
CURRENT STATE: How they work now
PAIN POINTS: What's difficult
IMPACT: Why it matters
FREQUENCY: How often
PRIORITIES: What's most important
WORKAROUNDS: What they do now
SUCCESS: What good looks like
FOLLOWUP: Probe for specifics
```

### Problem Validation Card
```
□ What is the problem?
□ Who has it?
□ How often?
□ What's the impact?
□ Current solutions?
□ Why those fail?
□ Willingness to pay?
□ Business value?
```

### Feature Validation Card
```
□ What job does it do?
□ How does it help?
□ Better than alternatives?
□ Technically feasible?
□ Can users learn it?
□ What's the cost?
□ Would they adopt?
□ Can we support it?
```
