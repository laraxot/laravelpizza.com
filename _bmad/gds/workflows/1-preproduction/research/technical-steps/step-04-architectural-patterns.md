# Game Technical Research Step 4: Game Architectural Patterns

## MANDATORY EXECUTION RULES (READ FIRST):

- 🛑 NEVER generate content without web search verification

- 📖 CRITICAL: ALWAYS read the complete step file before taking any action - partial understanding leads to incomplete decisions
- 🔄 CRITICAL: When loading next step with 'C', ensure the entire file is read and understood before proceeding
- ✅ Search the web to verify and supplement your knowledge with current facts
- 📋 YOU ARE A GAME SYSTEMS ARCHITECT, not content generator
- 💬 FOCUS on game architectural patterns and engine design decisions
- 🔍 WEB SEARCH REQUIRED - verify current facts against live sources
- 📝 WRITE CONTENT IMMEDIATELY TO DOCUMENT
- ✅ YOU MUST ALWAYS SPEAK OUTPUT In your Agent communication style with the config `{communication_language}`

## EXECUTION PROTOCOLS:

- 🎯 Show web search analysis before presenting findings
- ⚠️ Present [C] continue option after architectural patterns content generation
- 📝 WRITE GAME ARCHITECTURAL PATTERNS ANALYSIS TO DOCUMENT IMMEDIATELY
- 💾 ONLY proceed when user chooses C (Continue)
- 📖 Update frontmatter `stepsCompleted: [1, 2, 3, 4]` before loading next step
- 🚫 FORBIDDEN to load next step until C is selected

## CONTEXT BOUNDARIES:

- Current document and frontmatter from previous steps are available
- **Research topic = "{{research_topic}}"** - established from initial discussion
- **Research goals = "{{research_goals}}"** - established from initial discussion
- Focus on game architectural patterns and engine design decisions
- Web search capabilities with source verification are enabled

## YOUR TASK:

Conduct comprehensive game architectural patterns analysis with emphasis on game engine architecture, ECS patterns, rendering pipelines, and system design decisions for {{research_topic}}.

## GAME ARCHITECTURAL PATTERNS SEQUENCE:

### 1. Begin Game Architectural Patterns Analysis

Start with game architectural research approach:
"Now I'll focus on **game architectural patterns and design decisions** for effective game architecture approaches for {{research_topic}}.

**Game Architectural Patterns Focus:**

- Game engine architecture patterns and their trade-offs (ECS, OOP, data-oriented design)
- Game loop design and update pipeline patterns
- Rendering architecture and graphics pipeline design
- Game world and level streaming architecture
- Multiplayer and network architecture patterns

**Let me search for current game architectural patterns and approaches.**"

### 2. Web Search for Game Architecture Patterns

Search for current game architecture patterns:
Search the web: "game architecture patterns ECS entity component system"

**Game architecture focus:**

- Entity-Component-System vs Object-Oriented game architecture
- Data-oriented design for game performance
- Event-driven game architecture patterns
- Game state management and game loop design

### 3. Web Search for Game Engine Design Principles

Search for current game engine design principles:
Search the web: "game engine design patterns best practices"

**Game engine design focus:**

- Game loop patterns and fixed vs variable timestep
- Asset management and resource streaming
- Scene graph and spatial partitioning structures
- Cross-platform abstraction layer patterns

### 4. Web Search for Game Rendering and Performance Architecture

Search for current game rendering approaches:
Search the web: "game rendering architecture pipeline performance optimization"

**Game rendering and performance focus:**

- Forward vs deferred rendering pipeline choices
- LOD and culling architecture for performance
- GPU optimization and draw call batching
- Frame rate stability and performance budget design

### 5. Generate Game Architectural Patterns Content

Prepare game architectural analysis with web search citations:

#### Content Structure:

When saving to document, append these Level 2 and Level 3 sections:

```markdown
## Game Architectural Patterns and Design

### Game Engine Architecture Patterns

[Game engine architecture patterns analysis with source citations]
_Entity-Component-System (ECS): [ECS architecture benefits, trade-offs, and implementations]_
_Object-Oriented Game Design: [Traditional OOP patterns and their game-specific variations]_
_Data-Oriented Design: [Cache-friendly, performance-first architecture approaches]_
_Hybrid Approaches: [Combining architectural styles for practical game development]_
_Source: [URL]_

### Game Loop and Update Patterns

[Game loop design analysis with source citations]
_Fixed Timestep Patterns: [Fixed update, variable render for deterministic simulation]_
_Variable Timestep Patterns: [Delta time approaches and their trade-offs]_
_Multi-threaded Game Loop: [Parallel processing architecture for modern CPUs]_
_Input and Event Processing: [Input system architecture and event dispatch patterns]_
_Source: [URL]_

### Rendering Architecture and Graphics Pipeline

[Rendering architecture analysis with source citations]
_Forward vs Deferred Rendering: [Pipeline choice trade-offs for this game type]_
_Physically-Based Rendering: [PBR material system architecture]_
_LOD and Visibility Systems: [Level of detail and culling architecture patterns]_
_Post-Processing Pipeline: [Screen-space effect and post-processing architecture]_
_Source: [URL]_

### Game World and Level Architecture

[Game world architecture analysis with source citations]
_Scene Graph Design: [Hierarchical scene representation and management]_
_Level Streaming Architecture: [Open world and seamless loading patterns]_
_Spatial Partitioning: [Octree, BVH, and spatial structure choices for {{research_topic}}]_
_Procedural Generation Architecture: [Systems for procedural world and content generation]_
_Source: [URL]_

### Multiplayer and Network Architecture

[Multiplayer architecture analysis with source citations]
_Client-Server Architecture: [Authoritative server patterns for online games]_
_Peer-to-Peer Architecture: [P2P networking and its trade-offs for this game type]_
_State Synchronization: [Snapshot interpolation, delta compression, rollback netcode]_
_Lag Compensation Architecture: [Server-side rewind and prediction correction patterns]_
_Source: [URL]_

### Game Data and Save Architecture

[Game data architecture analysis with source citations]
_Save System Design: [Local save, cloud save, and cross-platform progression patterns]_
_Configuration and Scripting: [Data-driven design and scriptable object patterns]_
_Localization Architecture: [Multi-language and regional content management]_
_Mod Support Architecture: [Moddability and user-generated content systems]_
_Source: [URL]_

### Performance and Scalability Architecture

[Performance architecture analysis with source citations]
_Memory Budget Design: [Memory allocation strategies for target platforms]_
_CPU Performance Patterns: [Job systems, coroutines, and threading for game tasks]_
_GPU Performance Optimization: [Draw call batching, instancing, and shader optimization]_
_Platform-Specific Optimization: [Console, PC, and mobile performance architecture]_
_Source: [URL]_
```

### 6. Present Analysis and Continue Option

Show the generated game architectural patterns and present continue option:
"I've completed the **game architectural patterns analysis** for effective game architecture approaches.

**Key Game Architectural Findings:**

- Game engine architecture patterns and trade-offs clearly mapped
- Game loop and update pipeline design thoroughly documented
- Rendering architecture and graphics pipeline patterns identified
- Game world and level architecture analyzed
- Multiplayer network architecture and performance patterns captured

**Ready to proceed to game implementation research?**
[C] Continue - Save this to the document and move to implementation research

### 7. Handle Continue Selection

#### If 'C' (Continue):

- Append the final content to the research document
- Update frontmatter: `stepsCompleted: [1, 2, 3, 4]`
- Load: `./step-05-implementation-research.md`

## APPEND TO DOCUMENT:

When user selects 'C', append the content directly to the research document using the structure from step 5.

## SUCCESS METRICS:

✅ Game engine architecture patterns identified with current citations
✅ Game loop and update pipeline design clearly documented
✅ Rendering architecture and graphics pipeline patterns thoroughly mapped
✅ Game world and level architecture analyzed
✅ Multiplayer network and performance architecture captured
✅ [C] continue option presented and handled correctly
✅ Content properly appended to document when C selected
✅ Proper routing to game implementation research step

## FAILURE MODES:

❌ Relying solely on training data without web verification for current game architecture facts

❌ Missing critical game engine architecture patterns
❌ Not analyzing game loop design trade-offs
❌ Incomplete rendering or network architecture analysis
❌ Not presenting [C] continue option after content generation
❌ Appending content without user selecting 'C'

❌ **CRITICAL**: Reading only partial step file - leads to incomplete understanding and poor decisions
❌ **CRITICAL**: Proceeding with 'C' without fully reading and understanding the next step file
❌ **CRITICAL**: Making decisions without complete understanding of step requirements and protocols

## GAME ARCHITECTURAL RESEARCH PROTOCOLS:

- Search for game architecture documentation, GDC talks, and game engine documentation
- Use game developer blog posts and post-mortems for architecture case studies
- Research game engine source code patterns and community architecture discussions
- Note architectural decision rationales (ADRs) from game post-mortems
- Research game architecture assessment frameworks and maturity models

## NEXT STEP:

After user selects 'C' and content is saved to document, load `./step-05-implementation-research.md` to focus on game implementation approaches and technology adoption.

Remember: Always emphasize current game architectural data and rigorous source verification!
