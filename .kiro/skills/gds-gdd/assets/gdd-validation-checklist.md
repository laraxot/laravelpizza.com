# GDD Validation Checklist

Loaded by the GDD validator subagent. For each item, return `{id, status: pass|fail|warn|n/a, severity: low|medium|high|critical, location, note}`. Skip items not applicable to the agreed scope and game type. Cite specific GDD locations — never abstract criticism.

The genre and game-type checks (`G-1`, `G-2`) require the validator to read `assets/game-types.csv` and `assets/genre-complexity.csv` from the skill root.

## Quality

- **Q-1. Information density.** Sentences carry design weight. Flag conversational filler ("The player will be able to...", "In order to"), marketing / pitch-deck language ("immersive experience", "revolutionary", "AAA-quality"), and subjective design claims used without concrete backing ("fun", "satisfying", "deep").
- **Q-2. Measurability.** Mechanics, design goals, and technical specs carry concrete numbers — timings, damages, costs, ranges, cooldowns; feel parameters (jump arc, coyote time, input buffer, hit windows) where the genre demands; per-platform FPS / memory / load-time targets with a measurement method. Flag subjective adjectives and vague quantifiers ("many", "several", "various").
- **Q-3. Traceability.** The chain Vision → Game Pillars → Core Gameplay Loop → Mechanics → Development Epics is intact. Every pillar embodies the vision; the loop reinforces the pillars; each mechanic serves the loop or a pillar; each epic delivers mechanics. Flag orphan mechanics (no pillar/loop source), unsupported pillars (no reinforcing mechanic), and orphan epics.
- **Q-4. Core gameplay concrete.** Game Pillars (2–4, each game-defining and distinct) are specific enough to steer decisions. The Core Gameplay Loop documents a complete cycle (player action → outcome → reward → motivation to repeat). Win/loss conditions are defined and testable (or explicitly N/A for sandbox games).
- **Q-5. Out of Scope explicit.** An Out of Scope section names what is deliberately cut for v1.0 and what is deferred to post-launch, so omissions are not silently assumed downstream.
- **Q-6. Dual-audience and self-contained.** Each section makes sense pulled out alone; the GDD is readable by designers, producers, and leads, and structured cleanly (`##` headers, consistent patterns) for downstream source-extraction by architecture and epic/story workflows.

## Discipline

- **D-1. No engine-implementation leakage.** Mechanics and systems specify WHAT the player experiences and WHAT a system must achieve, not HOW it is built. Flag engine internals (GameObject, MonoBehaviour, Rigidbody, Actor, Blueprint, Node2D, `_process`), scripting/code patterns, shader/rendering internals, netcode library names, and data-format internals. Target engine, platform, and hard certification constraints in Technical Specifications are acceptable — that is *on what* it runs, not *how* it is built.
- **D-2. Input fidelity.** Content from input documents (game brief, brainstorming, research, prior GDD) is still in scope or explicitly handled via Out of Scope or `[ASSUMPTION]`. Core fantasy, called-out mechanics, target platforms, and design pillars from the brief are honored or the deviation is documented.
- **D-3. Technical Specifications stay GDD-level.** Performance, platform, and asset-budget requirements only — no architecture-level system or engine design (that is `gds-game-architecture`'s job).
- **D-4. No innovation theater.** USP and novelty claims are real, not invented pitch language.

## Genre and game-type

- **G-1. Genre compliance.** Determine the genre's complexity from `genre-complexity.csv`. Low-complexity genres (general, idle-incremental, sandbox, party-game, text-based) carry no special-section requirement — mark `n/a`. Medium- and high-complexity genres must document their `special_sections` and key concerns: e.g. RPG stat system + leveling curve + inventory rules + quest state machine + save model; roguelike run structure + meta-progression + seed determinism; fighting frame data + netcode model + input spec; shooter weapon-feel table + netcode + hitreg. Missing genre-critical sections are `critical`.
- **G-2. Game-type cross-reference.** The GDD's declared game type is a canonical `id` in `game-types.csv`. Scan the GDD for that type's `genre_tags`; measure match strength (strong / moderate / weak / none). Flag a mismatch if another game type shows stronger signals. Verify the `{GameType} Specific Design` section is present and contains content appropriate to the matched genre guide — not an unfilled `{{GAME_TYPE_SPECIFIC_SECTIONS}}` token.

## Structural integrity

- **S-1. Terminology integrity.** Every game-specific noun (mechanic name, resource, system) is used identically throughout. Flag drift (case, plural, synonyms) and contradictions between sections.
- **S-2. Epic continuity.** Development epics in `gdd.md` match `epics.md`; epic titles, scope, and sequence are consistent. Each epic delivers playable value and has high-level stories. ID / numbering is contiguous and unique.
- **S-3. Assumptions Index.** Every inline `[ASSUMPTION: ...]` appears in the Assumptions Index and vice versa.
- **S-4. Template completeness.** No unfilled `{{template_variables}}` or `{{GAME_TYPE_SPECIFIC_SECTIONS}}` token remains. Each canonical section has required content.
- **S-5. Open-items density.** Count Open Questions + `[ASSUMPTION]` + `[NOTE FOR DESIGNER]`. Red flag if density is high relative to the agreed scope.

## Scope-gated

- **STK-1. Required sections.** The GDD includes the sections the agreed scope and game type warrant — and, for a game heading into build, enough detail for `gds-game-architecture` to make engine and system decisions and for `gds-create-epics-and-stories` to break down work.
