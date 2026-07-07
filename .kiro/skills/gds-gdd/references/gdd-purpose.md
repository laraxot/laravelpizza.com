# BMAD GDD Purpose

**The GDD is the primary planning artifact in the Game Dev Studio (GDS) module. It feeds every downstream phase: architecture, epics, production, and playtesting.**

In GDS, the PRD is optional and exists only for external-tool compatibility. The GDD is the canonical source of truth for game design intent.

---

## What is a BMAD GDD?

A dual-audience document serving:

1. **Human game designers, producers, and developers** - Vision, pillars, team alignment, playtest briefs
2. **LLM downstream consumption** - Architecture → Epics → Dev stories → Playtest plans → Game Dev AI Agents

Each successive artifact becomes more granular and more AI-tailored. The GDD is where the design intent is captured in its purest form, before engine and implementation concerns enter the picture.

---

## Core Philosophy: Information Density

**High Signal-to-Noise Ratio on Game Mechanics**

Every sentence must carry design information. LLMs consume precise, dense content efficiently - and game design already suffers from pitch-deck-style fluff.

**Anti-Patterns (Eliminate These):**

- ❌ "The player will be able to..." → ✅ "The player can..."
- ❌ "It is our intention to create a game that..." → ✅ State the design directly
- ❌ "Players will experience fun and engaging gameplay" → ✅ Describe the specific mechanic that produces engagement
- ❌ Marketing copy and pitch language → ✅ Concrete mechanics, systems, and numbers

**Goal:** Maximum design information per word. Zero fluff, zero marketing.

---

## The Traceability Chain

**GDD starts the chain:**

```
Core Fantasy / Vision → Game Pillars → Core Gameplay Loop → Mechanics & Systems → Epics → Stories
```

**In the GDD, establish:**

- Vision → Pillars alignment
- Pillars → Gameplay Loop reinforcement (the loop should embody the pillars)
- Gameplay Loop → Mechanics mapping (each mechanic serves the loop)
- Mechanics → Epics (each epic delivers mechanics)
- All content traceable to the core fantasy

**Why:** Every downstream artifact (architecture, epics, stories, playtest plans) must trace back to documented design intent. This chain is what prevents scope creep, feature bloat, and mechanics that exist for their own sake.

---

## What Makes Great Mechanics and Systems?

### Mechanics are Player-Facing Capabilities, Not Implementation

**Good:** "The player can dash in any of 8 directions, consuming 1 stamina pip. Stamina regenerates at 1 pip/second while grounded."
**Bad:** "We use a Rigidbody2D with AddForce and a cooldown coroutine" (engine leakage - belongs in architecture)

**Good:** "Frame-perfect parries reward a 1.5x damage multiplier for 3 seconds."
**Bad:** "Combat feels responsive and satisfying" (subjective, unmeasurable)

### SMART Quality Criteria (Adapted for Game Design)

**Specific:** Clear, precisely defined mechanic or system
**Measurable:** Quantifiable values (timings, damages, costs, ranges)
**Attainable:** Realistic within target platform, team, and timeline
**Relevant:** Reinforces a game pillar or the core loop
**Traceable:** Links to the vision, a pillar, or a specific player fantasy

### Mechanics Anti-Patterns

**Subjective Adjectives:**

- ❌ "fun", "satisfying", "immersive", "responsive", "deep"
- ✅ Use concrete values: "chain combos extend the hit window by 6 frames per successful hit"

**Engine / Implementation Leakage:**

- ❌ Engine APIs, node names, specific shaders, class hierarchies
- ✅ Focus on player experience and system behavior - the engine is architecture's problem

**Vague Quantifiers:**

- ❌ "many enemies", "several weapons", "various environments"
- ✅ "12 enemy archetypes", "6 primary weapons + 18 unlockable variants", "3 biomes × 4 sub-zones"

**Missing Feel Criteria:**

- ❌ "The jump feels good"
- ✅ "Jump height: 3 tiles. Air time: 0.55s. Coyote time: 6 frames. Buffer window: 8 frames."

---

## What Makes Great Technical Constraints?

### Target Specs Must Be Measurable

**Template:**

```
"The game shall [metric] [platform/condition] [measurement method]"
```

**Examples:**

- ✅ "Maintain 60 FPS sustained on Steam Deck at 720p Medium settings, as measured by in-engine profiler over a 10-minute combat loop"
- ✅ "First-playable load time under 15s on PS5 from cold boot"
- ✅ "Memory budget: 4GB on PS4, 6GB on PS5, as measured by PIX capture"

### Constraint Anti-Patterns

**Unmeasurable Claims:**

- ❌ "Runs well on all platforms" → ✅ "60 FPS on PS5/XSX, 30 FPS on PS4/XB1"
- ❌ "Fast load times" → ✅ "Sub-5-second level transitions on target hardware"

**Missing Context:**

- ❌ "60 FPS target" → ✅ "60 FPS during combat encounters with up to 6 enemies on-screen, measured on Steam Deck"

---

## Genre-Specific Requirements

**Auto-Detect and Enforce Based on Game Type**

Certain genres carry conventions that must be documented:

- **Action/Platformer:** Precise movement values (jump arc, coyote time, input buffer), hit/hurt box conventions, damage formulae
- **RPG:** Stat system, leveling curve, inventory rules, quest state machine, save/load boundaries
- **Roguelike:** Run structure, meta-progression rules, seed determinism, balance bands
- **Multiplayer (MOBA/Shooter):** Netcode model (lockstep/rollback/client-predict), tick rate, lag tolerance, matchmaking
- **Puzzle:** Solution space guarantees, hint systems, difficulty ramp
- **Narrative/Visual Novel:** Branching structure, variable/flag system, rewind/save model

**Why:** Missing genre conventions in the GDD means they surface as emergencies during production. Validation should catch these up front. Steps use a `genre-complexity.csv` data file to drive genre-specific expectations.

---

## Document Structure (Markdown, Human-Readable)

### Required Sections (canonical gds-gdd schema)

1. **Executive Summary** - Core concept, target audience, USPs
2. **Goals and Context** - Project goals, background, rationale
3. **Core Gameplay** - Pillars, core gameplay loop, win/loss conditions
4. **Game Mechanics** - Primary mechanics, controls and input
5. **Game-Type Specific Sections** - Genre-driven sections (e.g., RPG stats, roguelike run structure)
6. **Progression and Balance** - Player progression, difficulty curve, economy
7. **Level Design Framework** - Level types, progression
8. **Art and Audio Direction** - Visual style, audio approach
9. **Technical Specifications** - Performance targets, platform specs, asset budget
10. **Development Epics** - High-level delivery breakdown
11. **Success Metrics** - Technical and gameplay success criteria
12. **Out of Scope** - Explicit scope boundaries
13. **Assumptions and Dependencies** - External risks

### Formatting for Dual Consumption

**For Humans:**

- Clear, direct language - no pitch-deck bloat
- Logical flow from vision to execution
- Easy for producers, leads, and external collaborators to review

**For LLMs:**

- `##` Level 2 headers for all main sections (enables extraction)
- Consistent structure and patterns
- Concrete numbers wherever possible
- High information density

---

## Downstream Impact

**How the GDD Feeds Next Artifacts:**

**Architecture:**

- Mechanics → system design (physics, AI, state machines)
- Technical specs → engine choice, rendering pipeline, memory layout
- Genre conventions → framework decisions (netcode model, save system)

**Epics & Stories:**

- Mechanics → epics (1 mechanic often = 1 epic)
- Level framework → content stories
- Progression → systems stories
- Traceability → stories map back to pillars

**Playtesting / Gametest:**

- Pillars → playtest focus areas
- Success metrics → playtest success criteria
- Core loop → the thing we're actually testing

**Development AI Agents:**

- Precise mechanics → implementation clarity
- Measurable specs → automated performance gates
- Genre conventions → framework selection
- Success metrics → telemetry targets

---

## Summary: What Makes a Great BMAD GDD?

✅ **High Information Density** - Every sentence carries design weight, zero pitch-deck fluff
✅ **Measurable Mechanics** - Concrete numbers for timings, damages, costs, ranges
✅ **Clear Traceability** - Each mechanic links to a pillar or core loop, each pillar to the vision
✅ **Genre Awareness** - Genre-specific sections auto-detected and included
✅ **Zero Anti-Patterns** - No subjective adjectives, no engine leakage, no vague quantifiers
✅ **Dual Audience Optimized** - Human-readable AND LLM-consumable
✅ **Markdown Format** - Professional, clean, accessible to designers and AI tools alike

---

**Remember:** The GDD is the foundation of GDS. Quality here ripples through architecture, epics, stories, and playtesting. A dense, precise, well-traced GDD makes every downstream phase dramatically more effective - and prevents the "we never actually decided what this game is" spiral that kills projects.
