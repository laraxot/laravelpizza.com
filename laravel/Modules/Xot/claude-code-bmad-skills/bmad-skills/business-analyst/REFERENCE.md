# Business Analyst Reference Guide

This document provides detailed frameworks, techniques, and best practices for conducting effective product discovery and requirements analysis.

## Table of Contents

1. [Interview Frameworks](#interview-frameworks)
2. [Question Types and Techniques](#question-types-and-techniques)
3. [Discovery Process](#discovery-process)
4. [Documentation Best Practices](#documentation-best-practices)
5. [Common Pitfalls](#common-pitfalls)

## Interview Frameworks

### 5 Whys Framework

**Purpose:** Identify root causes by asking "why" repeatedly

**Process:**
1. State the problem clearly
2. Ask "Why does this happen?"
3. Take the answer and ask "Why?" again
4. Repeat 5 times (or until root cause found)
5. Address the root cause, not symptoms

**Example:**
```
Problem: Users abandon checkout process

Why? → The checkout takes too long
Why? → Users have to enter shipping info manually
Why? → We don't save shipping addresses
Why? → Privacy concerns prevented implementation
Why? → We haven't implemented secure storage

Root Cause: Lack of secure storage for user data
```

**When to Use:**
- Problem identification phase
- Understanding pain points
- Debugging user complaints
- Finding systemic issues

### Jobs-to-be-Done (JTBD) Framework

**Purpose:** Understand what users are trying to accomplish

**Core Concept:** People don't want products; they want to get jobs done

**Question Structure:**
- "When [situation], I want to [motivation], so I can [expected outcome]"

**Key Questions:**
- What job are you trying to get done?
- What are you using now to accomplish this?
- What's the hardest part about getting this job done?
- How do you measure success for this job?
- What would make this job easier?

**Example:**
```
Job: "When I'm planning my weekly meals, I want to quickly find recipes
that use ingredients I already have, so I can reduce food waste and save time."

Current Solution: Googling ingredients + recipe sites
Pain Points: Takes 30+ minutes, recipes often need items I don't have
Success Metric: Find suitable recipe in under 5 minutes
```

**When to Use:**
- Understanding user motivation
- Feature prioritization
- Identifying alternatives and competition
- Designing user-centric solutions

### SMART Goals Framework

**Purpose:** Ensure goals are well-defined and achievable

**Criteria:**
- **S**pecific - Clear and unambiguous
- **M**easurable - Quantifiable metrics
- **A**chievable - Realistic given constraints
- **R**elevant - Aligned with business objectives
- **T**ime-bound - Has a deadline

**Example:**

**Vague Goal:**
"Improve user satisfaction"

**SMART Goal:**
"Increase user satisfaction score from 3.2 to 4.0 (out of 5)
by Q2 2025 through implementing the top 3 feature requests"

**Application:**
- S: User satisfaction score, specific features
- M: 3.2 to 4.0 on 5-point scale
- A: Top 3 features (not 20)
- R: Tied to user satisfaction metric
- T: By Q2 2025

**When to Use:**
- Setting project objectives
- Defining success criteria
- Planning milestones
- Stakeholder alignment

### Problem-Solution Fit Framework

**Purpose:** Validate that solutions address real problems

**Four-Step Process:**

1. **Problem Definition**
   - What is the problem?
   - Who has the problem?
   - How painful is it?
   - How frequent is it?

2. **Current Solution Analysis**
   - How do users solve it now?
   - What workarounds exist?
   - What are the limitations?
   - What do they pay (time/money)?

3. **Proposed Solution**
   - How will this solve the problem?
   - What's the core value proposition?
   - What makes it better than current solutions?
   - What's the minimum viable solution?

4. **Validation Criteria**
   - How will we know it solves the problem?
   - What metrics will improve?
   - What user behavior will change?
   - What's the success threshold?

**When to Use:**
- Product discovery phase
- Feature validation
- Solution design
- Resource allocation decisions

## Question Types and Techniques

### Open-Ended Questions

**Purpose:** Encourage detailed responses and uncover insights

**Examples:**
- "Tell me about how you currently handle..."
- "Walk me through your process for..."
- "Describe a recent time when..."
- "What challenges do you face with...?"
- "How do you decide when to...?"

**Best For:**
- Initial discovery
- Understanding workflows
- Identifying pain points
- Uncovering unexpected insights

### Probing Follow-Ups

**Purpose:** Dig deeper into responses

**Examples:**
- "Can you give me a specific example?"
- "What did you mean by [their phrase]?"
- "How often does that happen?"
- "What would make that better?"
- "Why is that important to you?"
- "What happens if you don't do that?"

**Best For:**
- Clarifying vague responses
- Getting concrete details
- Understanding priorities
- Validating assumptions

### Comparison Questions

**Purpose:** Understand relative importance and preferences

**Examples:**
- "How does this compare to [alternative]?"
- "Would you rather have X or Y?"
- "What's the difference between [scenario A] and [scenario B]?"
- "If you could only fix one thing, what would it be?"

**Best For:**
- Prioritization
- Trade-off discussions
- Competitive analysis
- Feature importance ranking

### Quantifying Questions

**Purpose:** Get measurable data

**Examples:**
- "How much time does that take?"
- "How often do you do that?"
- "How many people does this affect?"
- "What percentage of users experience this?"
- "On a scale of 1-10, how important is this?"

**Best For:**
- Building business cases
- Setting baselines
- Defining success metrics
- Prioritization

### Questions to Avoid

**Leading Questions:**
- BAD: "Don't you think dark mode would be better?"
- GOOD: "What are your thoughts on the current color scheme?"

**Yes/No Questions:**
- BAD: "Do you like the current dashboard?"
- GOOD: "What do you like or dislike about the current dashboard?"

**Solution-Focused Too Early:**
- BAD: "Would you use a drag-and-drop feature?"
- GOOD: "How do you currently organize your items?"

**Multiple Questions at Once:**
- BAD: "What features do you want and when do you need them and what's your budget?"
- GOOD: Ask one at a time

## Discovery Process

### Phase 1: Problem Understanding

**Objectives:**
- Identify the core problem
- Understand who is affected
- Quantify the impact
- Validate the problem is worth solving

**Key Activities:**
1. Stakeholder interviews
2. User observation (if applicable)
3. Data analysis (usage metrics, support tickets)
4. Market research

**Deliverables:**
- Problem statement
- User segments affected
- Impact assessment
- Problem validation

### Phase 2: Solution Exploration

**Objectives:**
- Explore potential solutions
- Understand constraints
- Identify alternatives
- Define minimum viable solution

**Key Activities:**
1. Brainstorming sessions
2. Competitive analysis
3. Technical feasibility assessment
4. Resource estimation

**Deliverables:**
- Solution concepts
- Competitive landscape
- Feasibility assessment
- High-level scope

### Phase 3: Requirements Definition

**Objectives:**
- Define specific requirements
- Set success metrics
- Document constraints
- Create product brief

**Key Activities:**
1. Requirements gathering
2. Success criteria definition
3. Risk assessment
4. Dependency mapping

**Deliverables:**
- Product brief document
- Success metrics
- Risk register
- Requirements list

### Phase 4: Validation & Handoff

**Objectives:**
- Validate completeness
- Get stakeholder alignment
- Prepare for handoff
- Set next steps

**Key Activities:**
1. Stakeholder review
2. Documentation review
3. Gap analysis
4. Handoff preparation

**Deliverables:**
- Approved product brief
- Stakeholder sign-off
- Handoff package
- Next steps recommendation

## Documentation Best Practices

### Writing Clear Requirements

**Good Requirements Are:**
- **Specific:** "Users can filter search results by date range (last 7, 30, 90 days, or custom)"
- **Measurable:** "Page load time must be under 2 seconds for 95% of requests"
- **Testable:** "Users can export data in CSV, JSON, or PDF format"
- **Prioritized:** "Must-have: Authentication; Should-have: SSO; Nice-to-have: Biometric login"

**Poor Requirements Are:**
- Vague: "The system should be fast"
- Unmeasurable: "Users will like the interface"
- Untestable: "The app should be intuitive"
- Solution-prescriptive: "Use React with Redux" (unless truly constrained)

### Documenting Assumptions

**Always Document:**
- Technical assumptions (platform, scale, integrations)
- User assumptions (behavior, skills, access)
- Business assumptions (market, competition, resources)
- Timeline assumptions (dependencies, blockers)

**Format:**
```
Assumption: Users have reliable internet connectivity
Impact if False: Offline mode required, adds 3-4 weeks
Validation: User survey shows 95% have reliable connectivity
Status: Validated
```

### Capturing Risks

**Risk Documentation:**
```
Risk: Third-party API may have rate limits
Probability: High
Impact: Medium (degrades user experience)
Mitigation: Implement caching and request queuing
Owner: Engineering team
Status: Identified
```

### Version Control

- Date all documents
- Track changes and revisions
- Note who provided input
- Reference related documents
- Keep change log

## Common Pitfalls

### Pitfall 1: Jumping to Solutions Too Quickly

**Problem:** Starting with "we need a mobile app" instead of understanding the problem

**Solution:** Always start with problem discovery
- What problem are we solving?
- Why is this a problem?
- Who experiences it?
- How do they handle it now?

### Pitfall 2: Accepting Vague Responses

**Problem:** User says "it's frustrating" without specifics

**Solution:** Probe for details
- "What specifically is frustrating?"
- "Can you give me an example?"
- "How does that impact your work?"

### Pitfall 3: Ignoring the "Why"

**Problem:** Documenting what users want without understanding why

**Solution:** Always ask why
- "Why is that important to you?"
- "What are you trying to accomplish?"
- Use 5 Whys and JTBD frameworks

### Pitfall 4: Confirmation Bias

**Problem:** Only seeking information that confirms existing beliefs

**Solution:** Actively seek disconfirming evidence
- Interview diverse user segments
- Look for edge cases
- Ask "what could go wrong?"
- Consider alternatives

### Pitfall 5: Analysis Paralysis

**Problem:** Endless research without moving to action

**Solution:** Set clear stopping criteria
- Define "good enough" for Phase 1
- Time-box research activities
- Focus on high-impact questions
- Document what you don't know

### Pitfall 6: Poor Documentation

**Problem:** Relying on memory instead of writing things down

**Solution:** Document as you go
- Take notes during interviews
- Summarize findings immediately
- Use templates for consistency
- Version control everything

### Pitfall 7: Skipping Validation

**Problem:** Assuming your interpretation is correct

**Solution:** Validate understanding
- Summarize and confirm with stakeholders
- Share drafts for feedback
- Test assumptions when possible
- Iterate based on feedback

## Quick Reference Checklist

### Before the Interview
- [ ] Review existing documentation
- [ ] Prepare core questions
- [ ] Identify knowledge gaps
- [ ] Set objectives for session
- [ ] Schedule appropriate time

### During the Interview
- [ ] Start with context and objectives
- [ ] Use open-ended questions
- [ ] Listen more than talk (80/20 rule)
- [ ] Take detailed notes
- [ ] Probe for specifics
- [ ] Ask for examples
- [ ] Validate understanding
- [ ] Capture quotes verbatim

### After the Interview
- [ ] Summarize key findings immediately
- [ ] Identify follow-up questions
- [ ] Document assumptions
- [ ] Share notes with stakeholders
- [ ] Update requirements
- [ ] Track open items

### Product Brief Completeness
- [ ] Problem clearly defined
- [ ] Target users identified
- [ ] Solution described
- [ ] Key features listed
- [ ] Success metrics defined
- [ ] Risks documented
- [ ] Assumptions noted
- [ ] Next steps clear

## Additional Resources

- **Templates:** See [templates/](templates/) directory
- **Scripts:** See [scripts/](scripts/) directory
- **Interview Frameworks:** See [resources/interview-frameworks.md](resources/interview-frameworks.md)
