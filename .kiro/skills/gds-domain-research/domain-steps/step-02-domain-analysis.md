# Game Domain Research Step 2: Game Industry Analysis

## MANDATORY EXECUTION RULES (READ FIRST):

- 🛑 NEVER generate content without web search verification

- 📖 CRITICAL: ALWAYS read the complete step file before taking any action - partial understanding leads to incomplete decisions
- 🔄 CRITICAL: When loading next step with 'C', ensure the entire file is read and understood before proceeding
- ✅ Search the web to verify and supplement your knowledge with current facts
- 📋 YOU ARE A GAME INDUSTRY ANALYST, not content generator
- 💬 FOCUS on game market size, genre dynamics, and industry structure
- 🔍 WEB SEARCH REQUIRED - verify current facts against live sources
- 📝 WRITE CONTENT IMMEDIATELY TO DOCUMENT
- ✅ YOU MUST ALWAYS SPEAK OUTPUT In your Agent communication style with the config `{communication_language}`

## EXECUTION PROTOCOLS:

- 🎯 Show web search analysis before presenting findings
- ⚠️ Present [C] continue option after industry analysis content generation
- 📝 WRITE INDUSTRY ANALYSIS TO DOCUMENT IMMEDIATELY
- 💾 ONLY proceed when user chooses C (Continue)
- 📖 Update frontmatter `stepsCompleted: [1, 2]` before loading next step
- 🚫 FORBIDDEN to load next step until C is selected

## CONTEXT BOUNDARIES:

- Current document and frontmatter from step-01 are available
- **Research topic = "{{research_topic}}"** - established from initial discussion
- **Research goals = "{{research_goals}}"** - established from initial discussion
- Focus on game market size, genre dynamics, and industry structure
- Web search capabilities with source verification are enabled

## YOUR TASK:

Conduct game industry analysis focusing on market size, genre dynamics, platform distribution, and industry structure. Search the web to verify and supplement current facts.

## INDUSTRY ANALYSIS SEQUENCE:

### 1. Begin Game Industry Analysis

**UTILIZE SUBPROCESSES AND SUBAGENTS**: Use research subagents, subprocesses or parallel processing if available to thoroughly analyze different game industry areas simultaneously and thoroughly.

Start with game industry research approach:
"Now I'll conduct **game industry analysis** for **{{research_topic}}** to understand game market dynamics.

**Game Industry Analysis Focus:**

- Game market size and revenue metrics
- Genre growth rates and platform distribution
- Market segmentation (PC, console, mobile, VR/AR)
- Game industry trends and genre evolution patterns
- Monetization models and economic impact

**Let me search for current game industry insights.**"

### 2. Parallel Game Industry Research Execution

**Execute multiple web searches simultaneously:**

Search the web: "{{research_topic}} game market size revenue"
Search the web: "{{research_topic}} game market growth genre trends"
Search the web: "{{research_topic}} game market platform segmentation"
Search the web: "{{research_topic}} game industry trends evolution"

**Analysis approach:**

- Look for recent game industry research reports and analyst analyses (Newzoo, SuperData, etc.)
- Search for authoritative sources (game industry associations, platform holder reports)
- Identify game market size, growth rates, and segmentation data by platform/genre
- Research game industry trends and genre evolution patterns
- Analyze monetization models and revenue impact

### 3. Analyze and Aggregate Results

**Collect and analyze findings from all parallel searches:**

"After executing comprehensive parallel web searches, let me analyze and aggregate game industry findings:

**Research Coverage:**

- Game market size and revenue analysis
- Genre growth rates and platform distribution
- Market segmentation (PC, console, mobile, VR/AR)
- Game industry trends and evolution patterns

**Cross-Industry Analysis:**
[Identify patterns connecting platform dynamics, genre trends, and monetization]

**Quality Assessment:**
[Overall confidence levels and research gaps identified]"

### 4. Generate Game Industry Analysis Content

**WRITE IMMEDIATELY TO DOCUMENT**

Prepare game industry analysis with web search citations:

#### Content Structure:

When saving to document, append these Level 2 and Level 3 sections:

```markdown
## Game Industry Analysis

### Market Size and Revenue

[Game market size analysis with source citations]
_Total Market Size: [Current global game market valuation]_
_Revenue by Segment: [PC, console, mobile, VR/AR revenue breakdown]_
_Market Segments: [Size and value of key genre/platform segments]_
_Economic Impact: [Game industry economic contribution]_
_Source: [URL]_

### Market Dynamics and Growth

[Game market dynamics analysis with source citations]
_Growth Drivers: [Key factors driving game market growth (esports, mobile, live service, etc.)]_
_Growth Barriers: [Factors limiting market expansion (saturation, cost, discoverability)]_
_Cyclical Patterns: [Launch windows, holiday seasons, platform cycle impacts]_
_Market Maturity: [Genre/platform life cycle stage and development phase]_
_Source: [URL]_

### Market Structure and Segmentation

[Game market structure analysis with source citations]
_Platform Segments: [PC, console, mobile, handheld, VR/AR market shares]_
_Genre Segments: [Action, RPG, strategy, puzzle, sports, simulation breakdowns]_
_Geographic Distribution: [Regional market variations - NA, EU, Asia-Pacific, etc.]_
_Publisher vs Indie: [AAA studio vs independent developer market dynamics]_
_Source: [URL]_

### Game Industry Trends and Evolution

[Game industry trends analysis with source citations]
_Emerging Trends: [Live service, games-as-a-service, AI in games, cloud gaming, etc.]_
_Historical Evolution: [Genre and platform development over recent years]_
_Technology Integration: [How new tech (ray tracing, haptics, VR) is changing the industry]_
_Future Outlook: [Projected genre and platform developments]_
_Source: [URL]_

### Competitive Dynamics

[Game competitive dynamics analysis with source citations]
_Market Concentration: [Level of consolidation among publishers and studios]_
_Competitive Intensity: [Degree of competition within genres and platforms]_
_Barriers to Entry: [Obstacles for new studios and indie developers]_
_Innovation Pressure: [Rate of genre innovation and creative change]_
_Source: [URL]_
```

### 5. Present Analysis and Continue Option

**Show analysis and present continue option:**

"I've completed **game industry analysis** for {{research_topic}}.

**Key Game Industry Findings:**

- Game market size and revenue thoroughly analyzed
- Genre growth dynamics and platform structure documented
- Game industry trends and evolution patterns identified
- Competitive dynamics and publisher landscape clearly mapped
- Multiple sources verified for critical insights

**Ready to proceed to competitive landscape analysis?**
[C] Continue - Save this to document and proceed to competitive landscape

### 6. Handle Continue Selection

#### If 'C' (Continue):

- **CONTENT ALREADY WRITTEN TO DOCUMENT**
- Update frontmatter: `stepsCompleted: [1, 2]`
- Load: `./step-03-competitive-landscape.md`

## APPEND TO DOCUMENT:

Content is already written to document when generated in step 4. No additional append needed.

## SUCCESS METRICS:

✅ Game market size and revenue thoroughly analyzed
✅ Genre growth dynamics and platform structure documented
✅ Game industry trends and evolution patterns identified
✅ Competitive dynamics and publisher landscape clearly mapped
✅ Multiple sources verified for critical insights
✅ Content written immediately to document
✅ [C] continue option presented and handled correctly
✅ Proper routing to next step (competitive landscape)
✅ Research goals alignment maintained

## FAILURE MODES:

❌ Relying on training data instead of web search for current game market facts
❌ Missing critical game market size or growth data
❌ Incomplete platform/genre structure analysis
❌ Not identifying key game industry trends
❌ Not writing content immediately to document
❌ Not presenting [C] continue option after content generation
❌ Not routing to competitive landscape step

❌ **CRITICAL**: Reading only partial step file - leads to incomplete understanding and poor decisions
❌ **CRITICAL**: Proceeding with 'C' without fully reading and understanding the next step file
❌ **CRITICAL**: Making decisions without complete understanding of step requirements and protocols

## GAME INDUSTRY RESEARCH PROTOCOLS:

- Research game industry reports from Newzoo, SuperData, Sensor Tower, etc.
- Use platform holder reports (Steam, App Store, Xbox, PlayStation data)
- Analyze game market size, growth rates, and segmentation data
- Study genre trends and platform evolution patterns
- Search the web to verify facts
- Present conflicting information when sources disagree
- Apply confidence levels appropriately

## GAME INDUSTRY ANALYSIS STANDARDS:

- Always cite URLs for web search results
- Use authoritative game industry research sources
- Note data currency and potential limitations
- Present multiple perspectives when sources conflict
- Apply confidence levels to uncertain data
- Focus on actionable game industry insights

## NEXT STEP:

After user selects 'C', load `./step-03-competitive-landscape.md` to analyze the competitive landscape, key studios, and game ecosystem for {{research_topic}}.

Remember: Always write research content to document immediately and search the web to verify game market facts!
