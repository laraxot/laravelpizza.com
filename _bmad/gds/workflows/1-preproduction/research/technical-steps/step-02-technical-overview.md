# Game Technical Research Step 2: Game Technology Stack Analysis

## MANDATORY EXECUTION RULES (READ FIRST):

- 🛑 NEVER generate content without web search verification

- 📖 CRITICAL: ALWAYS read the complete step file before taking any action - partial understanding leads to incomplete decisions
- 🔄 CRITICAL: When loading next step with 'C', ensure the entire file is read and understood before proceeding
- ✅ Search the web to verify and supplement your knowledge with current facts
- 📋 YOU ARE A GAME TECHNOLOGY STACK ANALYST, not content generator
- 💬 FOCUS on game engines, languages, middleware, tools, and platforms
- 🔍 WEB SEARCH REQUIRED - verify current facts against live sources
- 📝 WRITE CONTENT IMMEDIATELY TO DOCUMENT
- ✅ YOU MUST ALWAYS SPEAK OUTPUT In your Agent communication style with the config `{communication_language}`

## EXECUTION PROTOCOLS:

- 🎯 Show web search analysis before presenting findings
- ⚠️ Present [C] continue option after technology stack content generation
- 📝 WRITE GAME TECHNOLOGY STACK ANALYSIS TO DOCUMENT IMMEDIATELY
- 💾 ONLY proceed when user chooses C (Continue)
- 📖 Update frontmatter `stepsCompleted: [1, 2]` before loading next step
- 🚫 FORBIDDEN to load next step until C is selected

## CONTEXT BOUNDARIES:

- Current document and frontmatter from step-01 are available
- **Research topic = "{{research_topic}}"** - established from initial discussion
- **Research goals = "{{research_goals}}"** - established from initial discussion
- Focus on game engines, languages, middleware, tools, and platforms
- Web search capabilities with source verification are enabled

## YOUR TASK:

Conduct game technology stack analysis focusing on game engines, programming languages, middleware, tools, and platforms. Search the web to verify and supplement current facts.

## GAME TECHNOLOGY STACK ANALYSIS SEQUENCE:

### 1. Begin Game Technology Stack Analysis

**UTILIZE SUBPROCESSES AND SUBAGENTS**: Use research subagents, subprocesses or parallel processing if available to thoroughly analyze different game technology stack areas simultaneously and thoroughly.

Start with game technology stack research approach:
"Now I'll conduct **game technology stack analysis** for **{{research_topic}}** to understand the game technology landscape.

**Game Technology Stack Focus:**

- Game engines and their evolution (Unreal, Unity, Godot, proprietary)
- Programming languages and scripting (C++, C#, GDScript, Lua, Blueprint)
- Middleware and specialized game tech (physics, audio, animation, networking)
- Game development tools and pipelines (IDEs, profilers, asset pipelines)
- Target platform SDKs and deployment infrastructure

**Let me search for current game technology stack insights.**"

### 2. Parallel Game Technology Stack Research Execution

**Execute multiple web searches simultaneously:**

Search the web: "{{research_topic}} game engine technology comparison"
Search the web: "{{research_topic}} game development tools middleware"
Search the web: "{{research_topic}} game audio physics networking solutions"
Search the web: "{{research_topic}} game platform SDK deployment"

**Analysis approach:**

- Look for recent game developer surveys (Unity/Unreal state of game dev, GDC surveys)
- Search for game engine documentation, feature comparisons, and licensing details
- Research middleware and specialized tech choices in comparable games
- Analyze game development tool ecosystems and their evolution
- Study platform SDK requirements and deployment considerations

### 3. Analyze and Aggregate Results

**Collect and analyze findings from all parallel searches:**

"After executing comprehensive parallel web searches, let me analyze and aggregate game technology stack findings:

**Research Coverage:**

- Game engine and rendering framework analysis
- Programming language and scripting evaluation
- Middleware and specialized game tech assessment
- Game development tools and pipeline analysis

**Cross-Technology Analysis:**
[Identify patterns connecting engine choices, language decisions, and platform requirements]

**Quality Assessment:**
[Overall confidence levels and research gaps identified]"

### 4. Generate Game Technology Stack Content

**WRITE IMMEDIATELY TO DOCUMENT**

Prepare game technology stack analysis with web search citations:

#### Content Structure:

When saving to document, append these Level 2 and Level 3 sections:

```markdown
## Game Technology Stack Analysis

### Game Engines and Rendering Frameworks

[Game engine analysis with source citations]
_Dominant Game Engines: [Unreal, Unity, Godot, proprietary engines and their use cases]_
_Engine Feature Comparison: [Key differentiators relevant to {{research_topic}}]_
_Engine Licensing Models: [Cost, royalties, and commercial terms]_
_Engine Community and Support: [Ecosystem maturity and learning resources]_
_Source: [URL]_

### Programming Languages and Scripting

[Game programming language analysis with source citations]
_Primary Languages: [C++, C#, GDScript, and other languages for {{research_topic}}]_
_Scripting Solutions: [Blueprint, Lua, Python, and visual scripting approaches]_
_Language Performance Characteristics: [Performance and suitability for this game type]_
_Language Ecosystem: [Library availability and developer community]_
_Source: [URL]_

### Middleware and Specialized Game Tech

[Game middleware analysis with source citations]
_Physics Engines: [PhysX, Havok, Bullet, Jolt and physics middleware options]_
_Audio Middleware: [FMOD, Wwise, and audio system options]_
_Animation Systems: [Mixamo, Motion Matching, and animation middleware]_
_Networking Middleware: [Photon, Mirror, ENet, and networking solutions]_
_Source: [URL]_

### Game Development Tools and Pipeline

[Game development tools analysis with source citations]
_IDEs and Editors: [Development environments for game programming]_
_Profiling and Debugging: [RenderDoc, PIX, engine profilers, and performance tools]_
_Asset Pipeline Tools: [DCC tools, asset optimization, and pipeline automation]_
_Version Control for Game Teams: [Git LFS, Perforce, and game-specific VCS considerations]_
_Source: [URL]_

### Platform SDKs and Deployment Infrastructure

[Platform deployment analysis with source citations]
_Console Platform SDKs: [PlayStation, Xbox, Nintendo SDK requirements and features]_
_PC Platform Integration: [Steam, Epic, GOG SDK features and integration requirements]_
_Mobile Platform SDKs: [iOS and Android SDK features relevant to this game type]_
_Cloud and Streaming Infrastructure: [Backend services for online game features]_
_Source: [URL]_

### Game Technology Adoption Trends

[Game tech adoption trends analysis with source citations]
_Engine Market Share Trends: [How developer adoption of engines is shifting]_
_Emerging Game Technologies: [New tools and technologies gaining traction in game dev]_
_Legacy Tech Deprecation: [Older game tech being phased out]_
_Community Trends: [Developer preferences and open-source adoption in game dev]_
_Source: [URL]_
```

### 5. Present Analysis and Continue Option

**Show analysis and present continue option:**

"I've completed **game technology stack analysis** of the technology landscape for {{research_topic}}.

**Key Game Technology Stack Findings:**

- Game engines and rendering frameworks thoroughly analyzed
- Programming languages and scripting options evaluated
- Middleware and specialized game tech documented
- Game development tools and pipeline options mapped
- Platform SDK and deployment infrastructure requirements identified

**Ready to proceed to game integration patterns analysis?**
[C] Continue - Save this to document and proceed to integration patterns

### 6. Handle Continue Selection

#### If 'C' (Continue):

- **CONTENT ALREADY WRITTEN TO DOCUMENT**
- Update frontmatter: `stepsCompleted: [1, 2]`
- Load: `{project-root}/_bmad/gds/workflows/1-preproduction/research/technical-steps/step-03-integration-patterns.md`

## APPEND TO DOCUMENT:

Content is already written to document when generated in step 4. No additional append needed.

## SUCCESS METRICS:

✅ Game engines and rendering frameworks thoroughly analyzed
✅ Programming languages and scripting options evaluated
✅ Middleware and specialized game tech documented
✅ Game development tools and pipeline options mapped
✅ Platform SDK and deployment infrastructure identified
✅ Content written immediately to document
✅ [C] continue option presented and handled correctly
✅ Proper routing to next step (integration patterns)
✅ Research goals alignment maintained

## FAILURE MODES:

❌ Relying solely on training data without web verification for current game tech facts

❌ Missing critical game engines or rendering frameworks
❌ Incomplete middleware or platform SDK analysis
❌ Not identifying game development tools and pipeline options
❌ Not writing content immediately to document
❌ Not presenting [C] continue option after content generation
❌ Not routing to integration patterns step

❌ **CRITICAL**: Reading only partial step file - leads to incomplete understanding and poor decisions
❌ **CRITICAL**: Proceeding with 'C' without fully reading and understanding the next step file
❌ **CRITICAL**: Making decisions without complete understanding of step requirements and protocols

## GAME TECHNOLOGY STACK RESEARCH PROTOCOLS:

- Research game developer surveys and state-of-the-industry reports
- Use game engine documentation, feature comparisons, and community forums
- Analyze middleware provider documentation and game use cases
- Study game development tool ecosystems and pipeline examples
- Focus on current game technology data
- Present conflicting information when sources disagree
- Apply confidence levels appropriately

## GAME TECHNOLOGY STACK ANALYSIS STANDARDS:

- Always cite URLs for web search results
- Use authoritative game technology research sources
- Note data currency and potential limitations
- Present multiple perspectives when sources conflict
- Apply confidence levels to uncertain data
- Focus on actionable game technology insights

## NEXT STEP:

After user selects 'C', load `{project-root}/_bmad/gds/workflows/1-preproduction/research/technical-steps/step-03-integration-patterns.md` to analyze online service integration, platform APIs, analytics, and game system interoperability for {{research_topic}}.

Remember: Always write research content to document immediately and emphasize current game technology data with rigorous source verification!
