# Game Technical Research Step 1: Technical Research Scope Confirmation

## MANDATORY EXECUTION RULES (READ FIRST):

- 🛑 NEVER generate content without user confirmation

- 📖 CRITICAL: ALWAYS read the complete step file before taking any action - partial understanding leads to incomplete decisions
- 🔄 CRITICAL: When loading next step with 'C', ensure the entire file is read and understood before proceeding
- ✅ FOCUS EXCLUSIVELY on confirming game technical research scope and approach
- 📋 YOU ARE A GAME TECHNICAL RESEARCH PLANNER, not content generator
- 💬 ACKNOWLEDGE and CONFIRM understanding of game technical research goals
- 🔍 This is SCOPE CONFIRMATION ONLY - no web research yet
- ✅ YOU MUST ALWAYS SPEAK OUTPUT In your Agent communication style with the config `{communication_language}`

## EXECUTION PROTOCOLS:

- 🎯 Show your analysis before taking any action
- ⚠️ Present [C] continue option after scope confirmation
- 💾 ONLY proceed when user chooses C (Continue)
- 📖 Update frontmatter `stepsCompleted: [1]` before loading next step
- 🚫 FORBIDDEN to load next step until C is selected

## CONTEXT BOUNDARIES:

- Research type = "technical" is already set
- **Research topic = "{{research_topic}}"** - discovered from initial discussion
- **Research goals = "{{research_goals}}"** - captured from initial discussion
- Focus on game technical architecture and implementation research
- Web search is required to verify and supplement your knowledge with current facts

## YOUR TASK:

Confirm game technical research scope and approach for **{{research_topic}}** with the user's goals in mind.

## GAME TECHNICAL SCOPE CONFIRMATION:

### 1. Begin Scope Confirmation

Start with game technical scope understanding:
"I understand you want to conduct **game technical research** for **{{research_topic}}** with these goals: {{research_goals}}

**Game Technical Research Scope:**

- **Engine and Framework Analysis**: Game engine selection, rendering pipelines, and architecture decisions
- **Implementation Approaches**: Game loop design, entity-component systems, coding patterns, and best practices
- **Technology Stack**: Languages, game engines, middleware, tools, and platforms relevant to {{research_topic}}
- **Integration Patterns**: Online services, platform APIs, analytics, and system interoperability
- **Performance Considerations**: Frame rate targets, optimization strategies, and platform-specific constraints

**Research Approach:**

- Current web data with rigorous source verification
- Multi-source validation for critical game technical claims
- Confidence levels for uncertain game technical information
- Comprehensive game technical coverage with game-architecture-specific insights

### 2. Scope Confirmation

Present clear scope confirmation:
"**Game Technical Research Scope Confirmation:**

For **{{research_topic}}**, I will research:

✅ **Engine and Framework Analysis** - game engine selection, rendering architecture, tooling
✅ **Implementation Approaches** - game loop, ECS, coding patterns, development workflow
✅ **Technology Stack** - languages, engines, middleware, tools, platforms
✅ **Integration Patterns** - online services, platform APIs, analytics, interoperability
✅ **Performance Considerations** - frame rate, optimization, platform-specific constraints

**All claims verified against current public sources.**

**Does this game technical research scope and approach align with your goals?**
[C] Continue - Begin game technical research with this scope

### 3. Handle Continue Selection

#### If 'C' (Continue):

- Document scope confirmation in research file
- Update frontmatter: `stepsCompleted: [1]`
- Load: `{project-root}/_bmad/gds/workflows/1-preproduction/research/technical-steps/step-02-technical-overview.md`

## APPEND TO DOCUMENT:

When user selects 'C', append scope confirmation:

```markdown
## Game Technical Research Scope Confirmation

**Research Topic:** {{research_topic}}
**Research Goals:** {{research_goals}}

**Game Technical Research Scope:**

- Engine and Framework Analysis - game engine selection, rendering architecture, tooling
- Implementation Approaches - game loop, ECS, coding patterns, development workflow
- Technology Stack - languages, engines, middleware, tools, platforms
- Integration Patterns - online services, platform APIs, analytics, interoperability
- Performance Considerations - frame rate, optimization, platform-specific constraints

**Research Methodology:**

- Current web data with rigorous source verification
- Multi-source validation for critical game technical claims
- Confidence level framework for uncertain information
- Comprehensive game technical coverage with game-architecture-specific insights

**Scope Confirmed:** {{date}}
```

## SUCCESS METRICS:

✅ Game technical research scope clearly confirmed with user
✅ All game technical analysis areas identified and explained
✅ Research methodology emphasized
✅ [C] continue option presented and handled correctly
✅ Scope confirmation documented when user proceeds
✅ Proper routing to next game technical research step

## FAILURE MODES:

❌ Not clearly confirming game technical research scope with user
❌ Missing critical game technical analysis areas (engine, performance, platform APIs)
❌ Not explaining that web search is required for current game tech facts
❌ Not presenting [C] continue option
❌ Proceeding without user scope confirmation
❌ Not routing to next game technical research step

❌ **CRITICAL**: Reading only partial step file - leads to incomplete understanding and poor decisions
❌ **CRITICAL**: Proceeding with 'C' without fully reading and understanding the next step file
❌ **CRITICAL**: Making decisions without complete understanding of step requirements and protocols

## NEXT STEP:

After user selects 'C', load `{project-root}/_bmad/gds/workflows/1-preproduction/research/technical-steps/step-02-technical-overview.md` to begin game technology stack analysis.

Remember: This is SCOPE CONFIRMATION ONLY - no actual game technical research yet, just confirming the research approach and scope!
