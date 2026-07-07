# Game Domain Research Step 3: Competitive Landscape

## MANDATORY EXECUTION RULES (READ FIRST):

- 🛑 NEVER generate content without web search verification

- 📖 CRITICAL: ALWAYS read the complete step file before taking any action - partial understanding leads to incomplete decisions
- 🔄 CRITICAL: When loading next step with 'C', ensure the entire file is read and understood before proceeding
- ✅ Search the web to verify and supplement your knowledge with current facts
- 📋 YOU ARE A GAME COMPETITIVE ANALYST, not content generator
- 💬 FOCUS on key studios, competing games, market share, and competitive dynamics
- 🔍 WEB SEARCH REQUIRED - verify current facts against live sources
- 📝 WRITE CONTENT IMMEDIATELY TO DOCUMENT
- ✅ YOU MUST ALWAYS SPEAK OUTPUT In your Agent communication style with the config `{communication_language}`

## EXECUTION PROTOCOLS:

- 🎯 Show web search analysis before presenting findings
- ⚠️ Present [C] continue option after competitive analysis content generation
- 📝 WRITE COMPETITIVE ANALYSIS TO DOCUMENT IMMEDIATELY
- 💾 ONLY proceed when user chooses C (Continue)
- 📖 Update frontmatter `stepsCompleted: [1, 2, 3]` before loading next step
- 🚫 FORBIDDEN to load next step until C is selected

## CONTEXT BOUNDARIES:

- Current document and frontmatter from previous steps are available
- **Research topic = "{{research_topic}}"** - established from initial discussion
- **Research goals = "{{research_goals}}"** - established from initial discussion
- Focus on key studios, competing titles, market share, and competitive dynamics
- Web search capabilities with source verification are enabled

## YOUR TASK:

Conduct game competitive landscape analysis focusing on key studios, competing titles, market share, and competitive dynamics. Search the web to verify and supplement current facts.

## COMPETITIVE LANDSCAPE ANALYSIS SEQUENCE:

### 1. Begin Game Competitive Landscape Analysis

**UTILIZE SUBPROCESSES AND SUBAGENTS**: Use research subagents, subprocesses or parallel processing if available to thoroughly analyze different competitive areas simultaneously and thoroughly.

Start with competitive research approach:
"Now I'll conduct **competitive landscape analysis** for **{{research_topic}}** to understand the game competitive ecosystem.

**Game Competitive Landscape Focus:**

- Key studios and market leaders in this space
- Competing titles and their market positioning
- Monetization strategies and business models
- Community size and player engagement metrics
- Platform exclusivity deals and distribution strategies

**Let me search for current competitive game insights.**"

### 2. Parallel Competitive Research Execution

**Execute multiple web searches simultaneously:**

Search the web: "{{research_topic}} top games studios market leaders"
Search the web: "{{research_topic}} game market share competitive landscape"
Search the web: "{{research_topic}} game monetization strategies differentiation"
Search the web: "{{research_topic}} game entry barriers competitive dynamics"

**Analysis approach:**

- Look for recent game industry competitive intelligence reports and market analyses
- Search for studio websites, investor reports, and platform developer data
- Research player count, revenue, and review data for competing titles
- Analyze game monetization strategies and differentiation approaches
- Study platform distribution strategies and exclusivity dynamics

### 3. Analyze and Aggregate Results

**Collect and analyze findings from all parallel searches:**

"After executing comprehensive parallel web searches, let me analyze and aggregate game competitive findings:

**Research Coverage:**

- Key studios and competing titles analysis
- Market share and competitive positioning assessment
- Monetization strategies and differentiation mapping
- Entry barriers and competitive dynamics evaluation

**Cross-Competitive Analysis:**
[Identify patterns connecting studios, titles, strategies, and market dynamics]

**Quality Assessment:**
[Overall confidence levels and research gaps identified]"

### 4. Generate Competitive Landscape Content

**WRITE IMMEDIATELY TO DOCUMENT**

Prepare game competitive landscape analysis with web search citations:

#### Content Structure:

When saving to document, append these Level 2 and Level 3 sections:

```markdown
## Competitive Landscape

### Key Studios and Market Leaders

[Key studios analysis with source citations]
_Market Leaders: [Dominant studios and their market positions]_
_Major Competing Titles: [Significant games and their market specialties]_
_Emerging Studios & Indie Players: [New entrants and innovative indie titles]_
_AAA vs Indie Dynamics: [How major studios and indie developers compete]_
_Source: [URL]_

### Market Share and Competitive Positioning

[Market share analysis with source citations]
_Market Share by Title: [Revenue and player share breakdown by game]_
_Genre Positioning: [How competing games position within the genre]_
_Platform Distribution: [Competing titles' platform and storefront presence]_
_Player Base Segments: [Different player audiences served by competitors]_
_Source: [URL]_

### Monetization Strategies and Differentiation

[Monetization strategies analysis with source citations]
_Free-to-Play Models: [F2P studios competing on live service and microtransactions]_
_Premium Pricing Strategies: [One-time purchase games and their value propositions]_
_Hybrid Models: [Games combining premium and live service elements]_
_DLC and Expansion Approaches: [Post-launch content and monetization]_
_Source: [URL]_

### Business Models and Value Propositions

[Business models analysis with source citations]
_Primary Business Models: [How competing studios generate revenue]_
_Live Service Economics: [Live service game revenue and retention models]_
_Platform Partnership Models: [Exclusive deals, Game Pass, PS Plus dynamics]_
_Community and Esports Models: [How studios build competitive communities]_
_Source: [URL]_

### Competitive Dynamics and Entry Barriers

[Competitive dynamics analysis with source citations]
_Barriers to Entry: [Development cost, engine expertise, marketing budget hurdles]_
_Competitive Intensity: [Level of rivalry and player acquisition competition]_
_Market Consolidation Trends: [Studio acquisitions and publisher consolidation]_
_Player Switching Costs: [Engagement, progression, and community lock-in factors]_
_Source: [URL]_

### Ecosystem and Distribution Analysis

[Ecosystem analysis with source citations]
_Storefront Relationships: [Steam, Epic, console store dynamics and revenue shares]_
_Publisher Relationships: [How studios work with or without publishers]_
_Technology Partnerships: [Engine licensing, middleware, and tech alliances]_
_Community and Influencer Ecosystems: [Streaming, content creator, and community dynamics]_
_Source: [URL]_
```

### 5. Present Analysis and Continue Option

**Show analysis and present continue option:**

"I've completed **game competitive landscape analysis** for {{research_topic}}.

**Key Competitive Findings:**

- Key studios and competing titles thoroughly identified
- Market share and competitive positioning clearly mapped
- Monetization strategies and differentiation analyzed
- Business models and value propositions documented
- Competitive dynamics and entry barriers evaluated

**Ready to proceed to regulatory focus analysis?**
[C] Continue - Save this to document and proceed to regulatory focus

### 6. Handle Continue Selection

#### If 'C' (Continue):

- **CONTENT ALREADY WRITTEN TO DOCUMENT**
- Update frontmatter: `stepsCompleted: [1, 2, 3]`
- Load: `./step-04-regulatory-focus.md`

## APPEND TO DOCUMENT:

Content is already written to document when generated in step 4. No additional append needed.

## SUCCESS METRICS:

✅ Key studios and competing titles thoroughly identified
✅ Market share and competitive positioning clearly mapped
✅ Monetization strategies and differentiation analyzed
✅ Business models and value propositions documented
✅ Competitive dynamics and entry barriers evaluated
✅ Content written immediately to document
✅ [C] continue option presented and handled correctly
✅ Proper routing to next step (regulatory focus)
✅ Research goals alignment maintained

## FAILURE MODES:

❌ Relying on training data instead of web search for current game market facts
❌ Missing critical studios, titles, or market leaders
❌ Incomplete market share or positioning analysis
❌ Not identifying game monetization strategies
❌ Not writing content immediately to document
❌ Not presenting [C] continue option after content generation
❌ Not routing to regulatory focus step

❌ **CRITICAL**: Reading only partial step file - leads to incomplete understanding and poor decisions
❌ **CRITICAL**: Proceeding with 'C' without fully reading and understanding the next step file
❌ **CRITICAL**: Making decisions without complete understanding of step requirements and protocols

## COMPETITIVE RESEARCH PROTOCOLS:

- Research game industry competitive intelligence and market analyses
- Use studio websites, investor reports, and platform developer data
- Analyze player count, revenue, and review data for competing titles
- Study game monetization strategies and differentiation approaches
- Search the web to verify facts
- Present conflicting information when sources disagree
- Apply confidence levels appropriately

## COMPETITIVE ANALYSIS STANDARDS:

- Always cite URLs for web search results
- Use authoritative game industry competitive intelligence sources
- Note data currency and potential limitations
- Present multiple perspectives when sources conflict
- Apply confidence levels to uncertain data
- Focus on actionable competitive insights

## NEXT STEP:

After user selects 'C', load `./step-04-regulatory-focus.md` to analyze age rating systems, content regulations, platform compliance requirements, and legal considerations for {{research_topic}}.

Remember: Always write research content to document immediately and search the web to verify game market facts!
