# Game Domain Research Step 4: Regulatory Focus

## MANDATORY EXECUTION RULES (READ FIRST):

- 🛑 NEVER generate content without web search verification

- 📖 CRITICAL: ALWAYS read the complete step file before taking any action - partial understanding leads to incomplete decisions
- 🔄 CRITICAL: When loading next step with 'C', ensure the entire file is read and understood before proceeding
- ✅ Search the web to verify and supplement your knowledge with current facts
- 📋 YOU ARE A GAME REGULATORY ANALYST, not content generator
- 💬 FOCUS on age rating systems, content compliance, and platform requirements
- 🔍 WEB SEARCH REQUIRED - verify current facts against live sources
- 📝 WRITE CONTENT IMMEDIATELY TO DOCUMENT
- ✅ YOU MUST ALWAYS SPEAK OUTPUT In your Agent communication style with the config `{communication_language}`

## EXECUTION PROTOCOLS:

- 🎯 Show web search analysis before presenting findings
- ⚠️ Present [C] continue option after regulatory content generation
- 📝 WRITE REGULATORY ANALYSIS TO DOCUMENT IMMEDIATELY
- 💾 ONLY save when user chooses C (Continue)
- 📖 Update frontmatter `stepsCompleted: [1, 2, 3, 4]` before loading next step
- 🚫 FORBIDDEN to load next step until C is selected

## CONTEXT BOUNDARIES:

- Current document and frontmatter from previous steps are available
- **Research topic = "{{research_topic}}"** - established from initial discussion
- **Research goals = "{{research_goals}}"** - established from initial discussion
- Focus on age ratings, content regulations, platform compliance, and legal requirements
- Web search capabilities with source verification are enabled

## YOUR TASK:

Conduct focused regulatory and compliance analysis with emphasis on age rating systems, content laws, and platform requirements that impact {{research_topic}}. Search the web to verify and supplement current facts.

## REGULATORY FOCUS SEQUENCE:

### 1. Begin Game Regulatory Analysis

Start with regulatory research approach:
"Now I'll focus on **regulatory and compliance requirements** that impact **{{research_topic}}**.

**Game Regulatory Focus Areas:**

- Age rating systems (ESRB, PEGI, CERO, USK, etc.) and content categories
- Loot box and gambling regulations by region
- Platform certification and submission requirements
- Data protection and privacy laws (COPPA, GDPR for games)
- Regional content restrictions and market access rules

**Let me search for current game regulatory requirements.**"

### 2. Web Search for Age Rating and Content Regulations

Search for current regulatory information:
Search the web: "{{research_topic}} game age rating ESRB PEGI regulations"

**Regulatory focus:**

- Age rating criteria and content descriptors
- Regional rating system differences (ESRB vs PEGI vs CERO)
- Recent rating changes or new content categories
- Rating enforcement agencies and appeals processes

### 3. Web Search for Loot Box and Monetization Laws

Search for current monetization regulations:
Search the web: "{{research_topic}} loot box gambling laws regulations"

**Monetization law focus:**

- Countries that regulate loot boxes as gambling
- Disclosure requirements for random item mechanics
- Age verification requirements for in-game purchases
- Regional monetization restrictions and workarounds

### 4. Web Search for Platform and Data Privacy Requirements

Search for current platform and privacy regulations:
Search the web: "game platform certification requirements data privacy COPPA GDPR"

**Platform and privacy focus:**

- Console platform certification processes (Sony, Microsoft, Nintendo)
- PC storefront requirements (Steam, Epic, etc.)
- COPPA compliance for games aimed at or accessible by children
- GDPR and other data protection laws affecting game data collection

### 5. Generate Game Regulatory Analysis Content

Prepare regulatory content with source citations:

#### Content Structure:

When saving to document, append these Level 2 and Level 3 sections:

```markdown
## Regulatory Requirements

### Age Rating Systems

[Age rating analysis with source citations - ESRB, PEGI, CERO, USK, etc.]
_Rating Categories: [Applicable rating categories and content descriptors]_
_Regional Differences: [How ratings differ across key markets]_
_Content That Triggers Ratings: [Violence, language, sexual content, gambling mechanics]_
_Rating Process: [Submission process, cost, and timeline]_
_Source: [URL]_

### Loot Box and Monetization Laws

[Loot box and gambling regulation analysis with source citations]
_Countries Regulating Loot Boxes as Gambling: [Belgium, Netherlands, and others]_
_Disclosure Requirements: [Odds transparency and disclosure laws]_
_Age Verification Requirements: [Requirements for protecting minors from purchases]_
_Regional Monetization Restrictions: [Markets with special monetization rules]_
_Source: [URL]_

### Platform Certification Requirements

[Platform certification analysis with source citations]
_Console Certification: [Sony, Microsoft, Nintendo submission and certification processes]_
_PC Storefront Requirements: [Steam, Epic, GOG submission guidelines]_
_Mobile Platform Guidelines: [Apple App Store, Google Play content policies]_
_Compliance Timelines: [Typical certification duration and rejection rates]_
_Source: [URL]_

### Data Protection and Privacy

[Privacy requirements analysis with source citations]
_COPPA Compliance: [Children's Online Privacy Protection Act for games]_
_GDPR Requirements: [European data protection rules for player data]_
_Data Collection Best Practices: [Analytics, telemetry, and player data governance]_
_Parental Consent Mechanisms: [Requirements for games played by minors]_
_Source: [URL]_

### Regional Content Restrictions

[Regional restriction analysis with source citations]
_Market Access Rules: [Countries with special content restrictions]_
_Censorship Requirements: [Content modification requirements for specific markets]_
_Localization Compliance: [Language and cultural adaptation requirements]_
_Regional Launch Strategy Considerations: [How regulations affect launch planning]_
_Source: [URL]_

### Implementation Considerations

[Practical game regulatory implementation considerations with source citations]
_Rating Submission Timeline: [When to submit for ratings in production]_
_Content Design Compliance: [Design decisions to achieve target ratings]_
_Legal Review Requirements: [When to involve legal counsel in game development]_
_Source: [URL]_

### Risk Assessment

[Game regulatory and compliance risk assessment]
_Rating Risk: [Risk of receiving undesired rating affecting market access]_
_Monetization Risk: [Risk of regulatory action on game economy mechanics]_
_Platform Rejection Risk: [Risk factors for failed platform certification]_
_Regional Market Risk: [Risk of content restrictions limiting market reach]_
```

### 6. Present Analysis and Continue Option

Show the generated regulatory analysis and present continue option:
"I've completed **game regulatory requirements analysis** for {{research_topic}}.

**Key Regulatory Findings:**

- Age rating systems and content descriptors identified
- Loot box and monetization laws mapped by region
- Platform certification requirements clearly documented
- Data protection and privacy obligations analyzed
- Regional content restrictions and market access considerations provided

**Ready to proceed to technical trends?**
[C] Continue - Save this to the document and move to technical trends

### 7. Handle Continue Selection

#### If 'C' (Continue):

- **CONTENT ALREADY WRITTEN TO DOCUMENT**
- Update frontmatter: `stepsCompleted: [1, 2, 3, 4]`
- Load: `./step-05-technical-trends.md`

## APPEND TO DOCUMENT:

Content is already written to document when generated in step 5. No additional append needed.

## SUCCESS METRICS:

✅ Age rating systems and content descriptors identified with current citations
✅ Loot box and monetization laws documented by region
✅ Platform certification requirements clearly mapped
✅ Data protection and privacy obligations analyzed
✅ Implementation considerations provided
✅ [C] continue option presented and handled correctly
✅ Content properly appended to document when C selected

## FAILURE MODES:

❌ Relying on training data instead of web search for current game regulatory facts
❌ Missing critical age rating or content compliance requirements
❌ Not covering loot box and monetization regulations
❌ Not providing platform certification guidance
❌ Not completing risk assessment for regulatory compliance
❌ Not presenting [C] continue option after content generation
❌ Appending content without user selecting 'C'

❌ **CRITICAL**: Reading only partial step file - leads to incomplete understanding and poor decisions
❌ **CRITICAL**: Proceeding with 'C' without fully reading and understanding the next step file
❌ **CRITICAL**: Making decisions without complete understanding of step requirements and protocols

## REGULATORY RESEARCH PROTOCOLS:

- Search for ESRB, PEGI, CERO official rating criteria and processes
- Identify regional loot box and gambling laws by jurisdiction
- Research platform certification requirements from official developer portals
- Map data protection laws applicable to game player data
- Consider regional and jurisdictional differences across key game markets

## SOURCE VERIFICATION:

- Always cite official rating board and regulatory agency websites
- Use platform developer portal documentation as primary sources
- Note effective dates and recent regulatory changes
- Present compliance requirement levels and obligations

## NEXT STEP:

After user selects 'C' and content is saved to document, load `./step-05-technical-trends.md` to analyze game technology trends, engine innovations, and platform-specific technical developments.

Remember: Search the web to verify game regulatory facts and provide practical implementation considerations!
