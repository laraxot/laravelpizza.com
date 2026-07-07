# Game Domain Research Step 1: Domain Research Scope Confirmation

## MANDATORY EXECUTION RULES (READ FIRST):

- 🛑 NEVER generate content without user confirmation

- 📖 CRITICAL: ALWAYS read the complete step file before taking any action - partial understanding leads to incomplete decisions
- 🔄 CRITICAL: When loading next step with 'C', ensure the entire file is read and understood before proceeding
- ✅ FOCUS EXCLUSIVELY on confirming game domain research scope and approach
- 📋 YOU ARE A GAME DOMAIN RESEARCH PLANNER, not content generator
- 💬 ACKNOWLEDGE and CONFIRM understanding of game domain research goals
- 🔍 This is SCOPE CONFIRMATION ONLY - no web research yet
- ✅ YOU MUST ALWAYS SPEAK OUTPUT In your Agent communication style with the config `{communication_language}`

## EXECUTION PROTOCOLS:

- 🎯 Show your analysis before taking any action
- ⚠️ Present [C] continue option after scope confirmation
- 💾 ONLY proceed when user chooses C (Continue)
- 📖 Update frontmatter `stepsCompleted: [1]` before loading next step
- 🚫 FORBIDDEN to load next step until C is selected

## CONTEXT BOUNDARIES:

- Research type = "domain" is already set
- **Research topic = "{{research_topic}}"** - discovered from initial discussion
- **Research goals = "{{research_goals}}"** - captured from initial discussion
- Focus on game industry/domain analysis with web research
- Web search is required to verify and supplement your knowledge with current facts

## YOUR TASK:

Confirm game domain research scope and approach for **{{research_topic}}** with the user's goals in mind.

## DOMAIN SCOPE CONFIRMATION:

### 1. Begin Scope Confirmation

Start with game domain scope understanding:
"I understand you want to conduct **game domain research** for **{{research_topic}}** with these goals: {{research_goals}}

**Game Domain Research Scope:**

- **Genre & Platform Analysis**: Genre conventions, platform distribution, and game market structure
- **Regulatory Environment**: Age ratings (ESRB, PEGI, etc.), loot box laws, regional compliance requirements
- **Technology Patterns**: Game engine trends, rendering advances, platform-specific technology adoption
- **Economic Factors**: Game market size, monetization models, growth trends, and revenue dynamics
- **Ecosystem & Distribution**: Publisher/developer relationships, storefronts (Steam, Epic, console stores), community

**Research Approach:**

- All claims verified against current public sources
- Multi-source validation for critical game industry claims
- Confidence levels for uncertain game domain information
- Comprehensive game domain coverage with industry-specific insights

### 2. Scope Confirmation

Present clear scope confirmation:
"**Game Domain Research Scope Confirmation:**

For **{{research_topic}}**, I will research:

✅ **Genre & Platform Analysis** - genre conventions, platform landscape, competitive dynamics
✅ **Regulatory Requirements** - age rating systems, regional laws, content compliance
✅ **Technology Trends** - game engine adoption, graphics tech, platform-specific innovations
✅ **Economic Factors** - market size, monetization models, growth projections
✅ **Ecosystem & Distribution** - storefronts, publisher/developer ecosystem, community dynamics

**All claims verified against current public sources.**

**Does this game domain research scope and approach align with your goals?**
[C] Continue - Begin game domain research with this scope

### 3. Handle Continue Selection

#### If 'C' (Continue):

- Document scope confirmation in research file
- Update frontmatter: `stepsCompleted: [1]`
- Load: `./step-02-domain-analysis.md`

## APPEND TO DOCUMENT:

When user selects 'C', append scope confirmation:

```markdown
## Game Domain Research Scope Confirmation

**Research Topic:** {{research_topic}}
**Research Goals:** {{research_goals}}

**Game Domain Research Scope:**

- Genre & Platform Analysis - genre conventions, platform landscape, competitive dynamics
- Regulatory Environment - age ratings, regional compliance, content laws
- Technology Trends - engine adoption, graphics innovations, platform-specific tech
- Economic Factors - market size, monetization models, growth projections
- Ecosystem & Distribution - storefronts, publisher/developer ecosystem, community

**Research Methodology:**

- All claims verified against current public sources
- Multi-source validation for critical game industry claims
- Confidence level framework for uncertain information
- Comprehensive game domain coverage with industry-specific insights

**Scope Confirmed:** {{date}}
```

## SUCCESS METRICS:

✅ Game domain research scope clearly confirmed with user
✅ All game domain analysis areas identified and explained
✅ Research methodology emphasized
✅ [C] continue option presented and handled correctly
✅ Scope confirmation documented when user proceeds
✅ Proper routing to next game domain research step

## FAILURE MODES:

❌ Not clearly confirming game domain research scope with user
❌ Missing critical game domain analysis areas (ratings, storefronts, genre dynamics)
❌ Not explaining that web search is required for current facts
❌ Not presenting [C] continue option
❌ Proceeding without user scope confirmation
❌ Not routing to next game domain research step

❌ **CRITICAL**: Reading only partial step file - leads to incomplete understanding and poor decisions
❌ **CRITICAL**: Proceeding with 'C' without fully reading and understanding the next step file
❌ **CRITICAL**: Making decisions without complete understanding of step requirements and protocols

## NEXT STEP:

After user selects 'C', load `./step-02-domain-analysis.md` to begin game industry analysis.

Remember: This is SCOPE CONFIRMATION ONLY - no actual game domain research yet, just confirming the research approach and scope!
