# Game Market Research Step 1: Market Research Initialization

## MANDATORY EXECUTION RULES (READ FIRST):

- 🛑 NEVER generate research content in init step
- ✅ ALWAYS confirm understanding of user's research goals
- 📋 YOU ARE A GAME MARKET RESEARCH FACILITATOR, not content generator
- 💬 FOCUS on clarifying scope and approach
- 🔍 NO WEB RESEARCH in init - that's for later steps
- 📖 CRITICAL: ALWAYS read the complete step file before taking any action - partial understanding leads to incomplete research
- 🔄 CRITICAL: When loading next step with 'C', ensure the entire file is read and understood before proceeding
- ✅ YOU MUST ALWAYS SPEAK OUTPUT In your Agent communication style with the config `{communication_language}`

## EXECUTION PROTOCOLS:

- 🎯 Confirm research understanding before proceeding
- ⚠️ Present [C] continue option after scope clarification
- 💾 Write initial scope document immediately
- 📖 Update frontmatter `stepsCompleted: [1]` before loading next step
- 🚫 FORBIDDEN to load next step until C is selected

## CONTEXT BOUNDARIES:

- Current document and frontmatter from main workflow discovery are available
- Research type = "market" is already set
- **Research topic = "{{research_topic}}"** - discovered from initial discussion
- **Research goals = "{{research_goals}}"** - captured from initial discussion
- Focus on game market research scope clarification
- Web search capabilities are enabled for later steps

## YOUR TASK:

Initialize game market research by confirming understanding of {{research_topic}} and establishing clear research scope.

## GAME MARKET RESEARCH INITIALIZATION:

### 1. Confirm Research Understanding

**INITIALIZE - DO NOT RESEARCH YET**

Start with research confirmation:
"I understand you want to conduct **game market research** for **{{research_topic}}** with these goals: {{research_goals}}

**My Understanding of Your Research Needs:**

- **Research Topic**: {{research_topic}}
- **Research Goals**: {{research_goals}}
- **Research Type**: Game Market Research
- **Approach**: Comprehensive game market analysis with source verification

**Game Market Research Areas We'll Cover:**

- Game market size, genre growth dynamics, and platform trends
- Player insights, behavior patterns, and gamer demographics
- Competitive game landscape and studio positioning
- Strategic recommendations and game design implications

**Does this accurately capture what you're looking for?**"

### 2. Refine Research Scope

Gather any clarifications needed:

#### Scope Clarification Questions:

- "Are there specific player segments or platforms for {{research_topic}} we should prioritize?"
- "Should we focus on specific geographic regions or global game market?"
- "Is this for game concept validation, competitor analysis, market entry strategy, or another purpose?"
- "Any specific competing games, studios, or player communities you particularly want analyzed?"

### 3. Document Initial Scope

**WRITE IMMEDIATELY TO DOCUMENT**

Write initial research scope to document:

```markdown
# Game Market Research: {{research_topic}}

## Research Initialization

### Research Understanding Confirmed

**Topic**: {{research_topic}}
**Goals**: {{research_goals}}
**Research Type**: Game Market Research
**Date**: {{date}}

### Research Scope

**Game Market Analysis Focus Areas:**

- Game market size, genre growth projections, and platform dynamics
- Player segments, behavior patterns, and gamer insights
- Competitive game landscape and studio positioning analysis
- Strategic recommendations and game design implications

**Research Methodology:**

- Current web data with source verification
- Multiple independent sources for critical claims
- Confidence level assessment for uncertain data
- Comprehensive coverage with no critical gaps

### Next Steps

**Research Workflow:**

1. ✅ Initialization and scope setting (current step)
2. Player Insights and Behavior Analysis
3. Player Pain Points and Unmet Needs Analysis
4. Player Decision and Purchase Journey Analysis
5. Game Competitive Analysis
6. Research Synthesis and Completion

**Research Status**: Scope confirmed, ready to proceed with detailed game market analysis
```

### 4. Present Confirmation and Continue Option

Show initial scope document and present continue option:
"I've documented our understanding and initial scope for **{{research_topic}}** game market research.

**What I've established:**

- Research topic and goals confirmed
- Game market analysis focus areas defined
- Research methodology verification
- Clear workflow progression

**Document Status:** Initial scope written to research file for your review

**Ready to begin detailed game market research?**
[C] Continue - Confirm scope and proceed to player insights analysis
[Modify] Suggest changes to research scope before proceeding

### 5. Handle User Response

#### If 'C' (Continue):

- Update frontmatter: `stepsCompleted: [1]`
- Add confirmation note to document: "Scope confirmed by user on {{date}}"
- Load: `./step-02-customer-behavior.md`

#### If 'Modify':

- Gather user changes to scope
- Update document with modifications
- Re-present updated scope for confirmation

## SUCCESS METRICS:

✅ Research topic and goals accurately understood
✅ Game market research scope clearly defined
✅ Initial scope document written immediately
✅ User opportunity to review and modify scope
✅ [C] continue option presented and handled correctly
✅ Document properly updated with scope confirmation

## FAILURE MODES:

❌ Not confirming understanding of research topic and goals
❌ Generating research content instead of just scope clarification
❌ Not writing initial scope document to file
❌ Not providing opportunity for user to modify scope
❌ Proceeding to next step without user confirmation
❌ **CRITICAL**: Reading only partial step file - leads to incomplete understanding and poor research decisions
❌ **CRITICAL**: Proceeding with 'C' without fully reading and understanding the next step file
❌ **CRITICAL**: Making decisions without complete understanding of step requirements and protocols

## INITIALIZATION PRINCIPLES:

This step ensures:

- Clear mutual understanding of game market research objectives
- Well-defined research scope and approach
- Immediate documentation for user review
- User control over research direction before detailed work begins

## NEXT STEP:

After user confirmation and scope finalization, load `./step-02-customer-behavior.md` to begin detailed game market research with player insights analysis.

Remember: Init steps confirm understanding and scope, not generate research content!
