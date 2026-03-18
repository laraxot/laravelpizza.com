# Game Market Research Step 2: Player Behavior and Segments

## MANDATORY EXECUTION RULES (READ FIRST):

- 🛑 NEVER generate content without web search verification
- ✅ Search the web to verify and supplement your knowledge with current facts
- 📋 YOU ARE A PLAYER BEHAVIOR ANALYST, not content generator
- 💬 FOCUS on player behavior patterns and gamer demographic analysis
- 🔍 WEB SEARCH REQUIRED - verify current facts against live sources
- 📝 WRITE CONTENT IMMEDIATELY TO DOCUMENT
- 📖 CRITICAL: ALWAYS read the complete step file before taking any action - partial understanding leads to incomplete research
- 🔄 CRITICAL: When loading next step with 'C', ensure the entire file is read and understood before proceeding
- ✅ YOU MUST ALWAYS SPEAK OUTPUT In your Agent communication style with the config `{communication_language}`

## EXECUTION PROTOCOLS:

- 🎯 Show web search analysis before presenting findings
- ⚠️ Present [C] continue option after player behavior content generation
- 📝 WRITE PLAYER BEHAVIOR ANALYSIS TO DOCUMENT IMMEDIATELY
- 💾 ONLY proceed when user chooses C (Continue)
- 📖 Update frontmatter `stepsCompleted: [1, 2]` before loading next step
- 🚫 FORBIDDEN to load next step until C is selected

## CONTEXT BOUNDARIES:

- Current document and frontmatter from step-01 are available
- Focus on player behavior patterns and gamer demographic analysis
- Web search capabilities with source verification are enabled
- Previous step confirmed research scope and goals
- **Research topic = "{{research_topic}}"** - established from initial discussion
- **Research goals = "{{research_goals}}"** - established from initial discussion

## YOUR TASK:

Conduct player behavior and segment analysis with emphasis on gamer patterns, play styles, and demographics.

## PLAYER BEHAVIOR ANALYSIS SEQUENCE:

### 1. Begin Player Behavior Analysis

**UTILIZE SUBPROCESSES AND SUBAGENTS**: Use research subagents, subprocesses or parallel processing if available to thoroughly analyze different player behavior areas simultaneously and thoroughly.

Start with player behavior research approach:
"Now I'll conduct **player behavior analysis** for **{{research_topic}}** to understand player patterns.

**Player Behavior Focus:**

- Player behavior patterns, play styles, and preferences
- Gamer demographic profiles and segmentation (age, platform, genre loyalty)
- Psychographic characteristics and gamer values
- Behavior drivers and influences (social, competitive, creative, etc.)
- Player engagement patterns (session length, frequency, community participation)

**Let me search for current player behavior insights.**"

### 2. Parallel Player Behavior Research Execution

**Execute multiple web searches simultaneously:**

Search the web: "{{research_topic}} player behavior patterns play styles"
Search the web: "{{research_topic}} gamer demographics age platform"
Search the web: "{{research_topic}} player psychographic motivation"
Search the web: "{{research_topic}} player engagement session data"

**Analysis approach:**

- Look for player behavior studies, game analytics reports, and gamer surveys
- Search for demographic segmentation data (ESA annual reports, GWI gamer data)
- Research player motivation frameworks (Bartle types, Quantic Foundry motivation model)
- Analyze player engagement and session behavior patterns
- Study community participation and social behavior patterns

### 3. Analyze and Aggregate Results

**Collect and analyze findings from all parallel searches:**

"After executing comprehensive parallel web searches, let me analyze and aggregate player behavior findings:

**Research Coverage:**

- Player behavior patterns and play style preferences
- Gamer demographic profiles and segmentation
- Player motivation and psychographic characteristics
- Player engagement and session behavior patterns

**Cross-Behavior Analysis:**
[Identify patterns connecting gamer demographics, motivations, and behaviors]

**Quality Assessment:**
[Overall confidence levels and research gaps identified]"

### 4. Generate Player Behavior Content

**WRITE IMMEDIATELY TO DOCUMENT**

Prepare player behavior analysis with web search citations:

#### Content Structure:

When saving to document, append these Level 2 and Level 3 sections:

```markdown
## Player Behavior and Segments

### Player Behavior Patterns

[Player behavior patterns analysis with source citations]
_Play Style Preferences: [Casual vs hardcore, competitive vs cooperative, etc.]_
_Session Behavior: [Typical session length, frequency, and engagement patterns]_
_Content Consumption: [How players engage with game content over time]_
_Source: [URL]_

### Gamer Demographic Segmentation

[Gamer demographic analysis with source citations]
_Age Demographics: [Age group breakdown and genre/platform preferences]_
_Platform Distribution: [PC, console, mobile player demographic splits]_
_Geographic Distribution: [Regional player base and cultural preferences]_
_Gender Distribution: [Gender demographics for this genre/market]_
_Source: [URL]_

### Player Psychographic Profiles

[Player psychographic analysis with source citations]
_Player Motivations: [Achievement, social, immersion, creativity, competition drivers]_
_Gamer Identity: [How players identify with gaming and their genre loyalty]_
_Spending Attitudes: [Player attitudes toward game purchases and monetization]_
_Community Engagement: [Player values around online community and social play]_
_Source: [URL]_

### Player Segment Profiles

[Detailed player segment profiles with source citations]
_Segment 1 - [e.g., Core/Hardcore Players]: [Detailed profile including demographics, motivations, behavior]_
_Segment 2 - [e.g., Casual/Mainstream Players]: [Detailed profile including demographics, motivations, behavior]_
_Segment 3 - [e.g., Lapsed/Returning Players]: [Detailed profile including demographics, motivations, behavior]_
_Source: [URL]_

### Behavior Drivers and Influences

[Player behavior drivers analysis with source citations]
_Social Drivers: [Multiplayer, co-op, and community influences on play behavior]_
_Competitive Drivers: [Ranked play, leaderboards, and achievement motivation]_
_Narrative/Immersion Drivers: [Story, world-building, and escapism motivations]_
_Economic Influences: [Price sensitivity and spending patterns]_
_Source: [URL]_

### Player Engagement and Retention Patterns

[Player engagement analysis with source citations]
_Discovery and Onboarding: [How players find and start playing games in this space]_
_Progression and Retention: [What keeps players engaged over weeks and months]_
_Churn Patterns: [When and why players leave games in this genre]_
_Return and Re-engagement: [What brings lapsed players back]_
_Source: [URL]_
```

### 5. Present Analysis and Continue Option

**Show analysis and present continue option:**

"I've completed **player behavior analysis** for {{research_topic}}, focusing on player patterns and gamer demographics.

**Key Player Behavior Findings:**

- Player behavior patterns and play styles clearly identified
- Gamer demographic segmentation thoroughly analyzed
- Player motivations and psychographic profiles mapped
- Player engagement and retention patterns captured
- Multiple sources verified for critical insights

**Ready to proceed to player pain points?**
[C] Continue - Save this to document and proceed to pain points analysis

### 6. Handle Continue Selection

#### If 'C' (Continue):

- **CONTENT ALREADY WRITTEN TO DOCUMENT**
- Update frontmatter: `stepsCompleted: [1, 2]`
- Load: `{project-root}/_bmad/gds/workflows/1-preproduction/research/market-steps/step-03-customer-pain-points.md`

## APPEND TO DOCUMENT:

Content is already written to document when generated in step 4. No additional append needed.

## SUCCESS METRICS:

✅ Player behavior patterns identified with current citations
✅ Gamer demographic segmentation thoroughly analyzed
✅ Player motivations and psychographic profiles clearly documented
✅ Player engagement and retention patterns captured
✅ Multiple sources verified for critical insights
✅ Content written immediately to document
✅ [C] continue option presented and handled correctly
✅ Proper routing to next step (player pain points)
✅ Research goals alignment maintained

## FAILURE MODES:

❌ Relying solely on training data without web verification for current game player facts

❌ Missing critical player behavior patterns or play styles
❌ Incomplete gamer demographic segmentation analysis
❌ Missing player motivation and psychographic documentation
❌ Not writing content immediately to document
❌ Not presenting [C] continue option after content generation
❌ Not routing to player pain points analysis step
❌ **CRITICAL**: Reading only partial step file - leads to incomplete understanding and poor research decisions
❌ **CRITICAL**: Proceeding with 'C' without fully reading and understanding the next step file
❌ **CRITICAL**: Making decisions without complete understanding of step requirements and protocols

## PLAYER BEHAVIOR RESEARCH PROTOCOLS:

- Research player behavior studies, game analytics reports, and gamer surveys
- Use demographic data from authoritative sources (ESA, GWI, Newzoo)
- Research player motivation frameworks and psychographic profiling
- Analyze player engagement, retention, and session behavior patterns
- Focus on current player behavior data and trends
- Present conflicting information when sources disagree
- Apply confidence levels appropriately

## BEHAVIOR ANALYSIS STANDARDS:

- Always cite URLs for web search results
- Use authoritative game player research sources
- Note data currency and potential limitations
- Present multiple perspectives when sources conflict
- Apply confidence levels to uncertain data
- Focus on actionable player insights for game design

## NEXT STEP:

After user selects 'C', load `{project-root}/_bmad/gds/workflows/1-preproduction/research/market-steps/step-03-customer-pain-points.md` to analyze player pain points, frustrations, and unmet needs for {{research_topic}}.

Remember: Always write research content to document immediately and emphasize current player data with rigorous source verification!
