# Game Market Research Step 4: Player Decisions and Purchase Journey

## MANDATORY EXECUTION RULES (READ FIRST):

- 🛑 NEVER generate content without web search verification

- 📖 CRITICAL: ALWAYS read the complete step file before taking any action - partial understanding leads to incomplete decisions
- 🔄 CRITICAL: When loading next step with 'C', ensure the entire file is read and understood before proceeding
- ✅ Search the web to verify and supplement your knowledge with current facts
- 📋 YOU ARE A PLAYER DECISION ANALYST, not content generator
- 💬 FOCUS on player decision processes, game selection journey, and purchase factors
- 🔍 WEB SEARCH REQUIRED - verify current facts against live sources
- 📝 WRITE CONTENT IMMEDIATELY TO DOCUMENT
- ✅ YOU MUST ALWAYS SPEAK OUTPUT In your Agent communication style with the config `{communication_language}`

## EXECUTION PROTOCOLS:

- 🎯 Show web search analysis before presenting findings
- ⚠️ Present [C] continue option after decision processes content generation
- 📝 WRITE PLAYER DECISIONS ANALYSIS TO DOCUMENT IMMEDIATELY
- 💾 ONLY proceed when user chooses C (Continue)
- 📖 Update frontmatter `stepsCompleted: [1, 2, 3, 4]` before loading next step
- 🚫 FORBIDDEN to load next step until C is selected

## CONTEXT BOUNDARIES:

- Current document and frontmatter from previous steps are available
- Player behavior and pain points analysis completed in previous steps
- Focus on player decision processes and game selection journey mapping
- Web search capabilities with source verification are enabled
- **Research topic = "{{research_topic}}"** - established from initial discussion
- **Research goals = "{{research_goals}}"** - established from initial discussion

## YOUR TASK:

Conduct player decision processes and game selection journey analysis with emphasis on how players discover, evaluate, and purchase games in this market.

## PLAYER DECISIONS ANALYSIS SEQUENCE:

### 1. Begin Player Decisions Analysis

**UTILIZE SUBPROCESSES AND SUBAGENTS**: Use research subagents, subprocesses or parallel processing if available to thoroughly analyze different player decision areas simultaneously and thoroughly.

Start with player decisions research approach:
"Now I'll conduct **player decision processes analysis** for **{{research_topic}}** to understand game selection and purchase decision-making.

**Player Decisions Focus:**

- Game discovery and awareness channels
- Game selection criteria and evaluation process
- Purchase decision factors and price sensitivity
- Storefront and platform selection behavior
- Refund and regret patterns

**Let me search for current player decision insights.**"

### 2. Parallel Decisions Research Execution

**Execute multiple web searches simultaneously:**

Search the web: "{{research_topic}} game discovery how players find games"
Search the web: "{{research_topic}} game purchase decision factors criteria"
Search the web: "{{research_topic}} game selection evaluation process player"
Search the web: "{{research_topic}} game influencer streaming word of mouth purchase"

**Analysis approach:**

- Look for player survey data on game discovery and purchase behavior
- Search for storefront analytics and game marketing effectiveness data
- Research influencer and content creator impact on game purchases
- Analyze price sensitivity and sale behavior patterns
- Study refund patterns and buyer's remorse data

### 3. Analyze and Aggregate Results

**Collect and analyze findings from all parallel searches:**

"After executing comprehensive parallel web searches, let me analyze and aggregate player decision findings:

**Research Coverage:**

- Game discovery and awareness channel analysis
- Game selection criteria and evaluation processes
- Purchase decision factors and pricing dynamics
- Influencer and social proof impact on decisions

**Cross-Decisions Analysis:**
[Identify patterns connecting discovery channels, evaluation criteria, and purchase factors]

**Quality Assessment:**
[Overall confidence levels and research gaps identified]"

### 4. Generate Player Decisions Content

**WRITE IMMEDIATELY TO DOCUMENT**

Prepare player decisions analysis with web search citations:

#### Content Structure:

When saving to document, append these Level 2 and Level 3 sections:

```markdown
## Player Decision Processes and Purchase Journey

### Game Discovery and Awareness

[Game discovery analysis with source citations]
_Discovery Channels: [Steam discovery, social media, streaming, word of mouth, advertising]_
_Awareness Timelines: [How far in advance players become aware of games]_
_Wishlisting Behavior: [How players track and follow games before release]_
_Algorithm vs Human Recommendation: [Platform algorithm vs peer recommendation impact]_
_Source: [URL]_

### Game Selection Criteria and Evaluation

[Game selection analysis with source citations]
_Primary Selection Factors: [Most important criteria in game selection decisions]_
_Secondary Selection Factors: [Supporting factors influencing game choice]_
_Trailer and Demo Impact: [How gameplay videos and demos affect selection]_
_Review and Rating Impact: [How Metacritic, user reviews, and critic reviews affect selection]_
_Source: [URL]_

### Player Purchase Journey Mapping

[Purchase journey analysis with source citations]
_Awareness Stage: [How players first encounter {{research_topic}} games]_
_Consideration Stage: [Wishlist, research, and comparison process]_
_Decision Stage: [Final purchase decision triggers and timing]_
_Purchase Stage: [Storefront selection, price point, and payment behavior]_
_Post-Purchase Stage: [Early play, review writing, refund, and community entry]_
_Source: [URL]_

### Influencer and Social Proof Impact

[Influencer impact analysis with source citations]
_Streaming Influence: [Twitch, YouTube, and content creator impact on game discovery]_
_Community and Forum Influence: [Reddit, Discord, and gaming forum role in decisions]_
_Peer Recommendation Influence: [Friend recommendations and social circle impact]_
_Review Aggregator Influence: [Metacritic, OpenCritic, and Steam review impact]_
_Source: [URL]_

### Pricing and Purchase Behavior

[Pricing behavior analysis with source citations]
_Price Point Sensitivity: [Player willingness to pay at different price tiers]_
_Sale and Discount Behavior: [How sales affect purchase timing and volume]_
_Bundle Purchase Behavior: [How game bundles and package deals drive decisions]_
_Free-to-Play Conversion: [F2P player conversion rates and spending patterns]_
_Source: [URL]_

### Platform and Storefront Selection

[Platform selection analysis with source citations]
_Platform Preference Factors: [What drives PC vs console vs mobile choice]_
_Storefront Preference: [Steam vs Epic vs console store selection factors]_
_Cross-Platform Considerations: [How cross-play and cross-save affect decisions]_
_Subscription Service Impact: [Game Pass, PS Plus, and subscription on purchase decisions]_
_Source: [URL]_

### Post-Purchase Behavior and Retention

[Post-purchase analysis with source citations]
_Early Retention Factors: [What keeps players engaged in the first week]_
_Long-term Retention Drivers: [Content updates, community, and progression]_
_Refund and Abandonment Patterns: [When and why players refund or abandon games]_
_Review and Community Contribution: [How satisfied players contribute reviews and content]_
_Source: [URL]_

### Player Decision Optimizations

[Decision optimization analysis with source citations]
_Wishlist Conversion Strategies: [Converting wishlists to purchases]_
_Trust and Credibility Building: [Building player confidence before purchase]_
_Launch Strategy Timing: [Optimal launch window and marketing timing]_
_Long-term Player Relationship: [Building sustainable player communities]_
_Source: [URL]_
```

### 5. Present Analysis and Continue Option

**Show analysis and present continue option:**

"I've completed **player decision processes analysis** for {{research_topic}}, focusing on game selection and purchase decision-making.

**Key Decision Findings:**

- Game discovery channels and awareness mechanisms clearly mapped
- Player selection criteria and evaluation process thoroughly analyzed
- Purchase journey mapped across all stages
- Influencer and social proof impact documented
- Pricing behavior and storefront preferences identified

**Ready to proceed to competitive analysis?**
[C] Continue - Save this to document and proceed to competitive analysis

### 6. Handle Continue Selection

#### If 'C' (Continue):

- **CONTENT ALREADY WRITTEN TO DOCUMENT**
- Update frontmatter: `stepsCompleted: [1, 2, 3, 4]`
- Load: `./step-05-competitive-analysis.md`

## APPEND TO DOCUMENT:

Content is already written to document when generated in step 4. No additional append needed.

## SUCCESS METRICS:

✅ Game discovery channels and awareness mechanisms clearly mapped
✅ Player selection criteria and evaluation process thoroughly analyzed
✅ Purchase journey mapped across all stages
✅ Influencer and social proof impact documented
✅ Pricing behavior and storefront preferences identified
✅ Content written immediately to document
✅ [C] continue option presented and handled correctly
✅ Proper routing to next step (competitive analysis)
✅ Research goals alignment maintained

## FAILURE MODES:

❌ Relying solely on training data without web verification for current game player facts

❌ Missing critical game discovery channel or awareness data
❌ Not identifying key selection criteria or evaluation factors
❌ Incomplete purchase journey mapping
❌ Not writing content immediately to document
❌ Not presenting [C] continue option after content generation
❌ Not routing to competitive analysis step

❌ **CRITICAL**: Reading only partial step file - leads to incomplete understanding and poor decisions
❌ **CRITICAL**: Proceeding with 'C' without fully reading and understanding the next step file
❌ **CRITICAL**: Making decisions without complete understanding of step requirements and protocols

## PLAYER DECISIONS RESEARCH PROTOCOLS:

- Research player survey data on game discovery and purchase behavior
- Use storefront analytics and game marketing effectiveness studies
- Analyze influencer and content creator impact on game purchases
- Study price sensitivity and sale behavior patterns
- Focus on current player decision data
- Present conflicting information when sources disagree
- Apply confidence levels appropriately

## DECISION ANALYSIS STANDARDS:

- Always cite URLs for web search results
- Use authoritative game player decision research sources
- Note data currency and potential limitations
- Present multiple perspectives when sources conflict
- Apply confidence levels to uncertain data
- Focus on actionable decision insights for game marketing and GDD

## NEXT STEP:

After user selects 'C', load `./step-05-competitive-analysis.md` to analyze the competitive game landscape, competing studios, and market positioning for {{research_topic}}.

Remember: Always write research content to document immediately and emphasize current player decision data with rigorous source verification!
