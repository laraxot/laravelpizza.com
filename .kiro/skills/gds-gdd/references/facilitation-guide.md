# GDD Facilitation Guide

Per-section conversation techniques for facilitative mode. Each entry names the coaching move that makes the section's conversation productive — not a checklist, a posture. Skip sections the designer has already resolved; spend more time where thinking is thin.

---

## Game Pillars

**The move:** Force each pillar to earn its place.

Pillars are the 2–4 fundamental gameplay elements the whole design answers to. Ask the designer to name them, then pressure-test each one: "If you cut this pillar, what game is left?" A real pillar, removed, breaks the game. A slogan, removed, changes nothing.

Push for specificity. "Exploration" is a slogan. "The player is rewarded for going off the obvious path — every detour hides a mechanical upgrade or a piece of the world" is a pillar that steers level design, reward placement, and pacing. Pillars must be distinct: if two pillars overlap, you have one pillar and a restatement.

Once the pillars are set, every later section answers to them. Keep them visible.

---

## Core Gameplay Loop

**The move:** Walk the loop as a cycle, not a list.

The loop is what the player does over and over. Walk it as a closed cycle: player action → outcome → reward → motivation to do it again. If any link is missing, the loop does not close — find the gap.

For each step, ask which pillar it serves. A loop step that serves no pillar is either a missing pillar or a step that does not belong. After the loop is described, the test question: "Why does the player want to run this loop the hundredth time, not just the first?" If the only answer is "new content", the loop itself is not carrying the game.

---

## Game Mechanics

**The move:** Push every mechanic to numbers.

A mechanic described in adjectives is not a spec. "The dash feels snappy" — snappy how? Push to: distance, duration, cost, cooldown, what it interacts with, what cancels it. "The jump feels good" becomes jump height, air time, coyote time, input buffer window, fast-fall behavior.

For each mechanic, name which pillar or loop step it serves. A mechanic that serves nothing is scope creep wearing a costume — surface it and ask whether it stays.

When the genre demands feel parameters (platformer movement, fighting frame data, shooter weapon feel), do not let the designer hand-wave them. These are the numbers the architecture and the build depend on.

---

## GameType Specific Design

**The move:** Walk the genre guide subsection by subsection.

The matched genre guide (`assets/game-types/{fragment_file}`) scaffolds this section with the genre's required subsections. Walk them one at a time — do not dump the whole guide on the designer at once.

For each subsection, read the guide's prompts, present them, and elicit the designer's answer. Some subsections are optional for a given game — offer them, and if the designer declines, note "not applicable" rather than leaving a blank.

If the guide carries a `<narrative-workflow-critical>` or `<narrative-workflow-recommended>` flag, set the `needs_narrative` flag and tell the designer dedicated narrative design will be offered at the end.

Watch for genre conventions the designer is skipping. A roguelike GDD with no seed-determinism rule, an RPG with no save model, a fighting game with no frame data — these are not optional, and missing them surfaces as an emergency in production.

---

## Progression and Balance

**The move:** Connect progression to the loop, not to content volume.

Ask what the player is actually progressing — skill, power, unlocks, narrative, mastery — and how that progression feeds back into the core loop. Progression that does not change how the loop plays is just a number going up.

For the difficulty curve, ask where the player is expected to struggle and where they coast, and why that rhythm serves the experience. For economy and resources, push for the actual rates: what is earned, what is spent, what the scarcity curve looks like. "Balanced" is not an answer; the numbers are.

---

## Technical Specifications

**The move:** Keep it measurable, keep it out of architecture.

This section is GDD-level: performance targets, platform requirements, asset budgets. Push every target to a measurable form — "runs well" becomes "60 FPS sustained on Steam Deck at 720p Medium, measured over a 10-minute combat loop". Name the measurement method.

When the designer starts describing *how* a system is built — engine APIs, component patterns, netcode libraries — stop them gently: "That's an architecture decision. Let's capture *what* the system has to do here, and let the architecture workflow decide how." Target engine and hard certification constraints are fine; implementation is not.

---

## Development Epics

**The move:** Group for playable milestones, not for tidiness.

Epics translate the design into delivery units. Ask the designer to group features so each epic ends in something playable — a vertical slice early, foundations before content, polish last. Each epic should be 1–4 sprints of scope.

For each epic, get goal, what's in, what's explicitly out, dependencies, and the playable deliverable. The detailed breakdown goes to `epics.md`; `gdd.md` carries only the summary table and the recommended sequence. Check that every mechanic from the GDD lands in some epic — an undelivered mechanic is a gap.

---

## Success Metrics

**The move:** Push every adjective to a measurement.

"Players will love it" — measured how? "Good retention" — what percentage, by when? Every quality claim needs a measurement or it is a wish, not a success criterion.

Split technical metrics (frame rate, load time, crash rate) from gameplay metrics (completion rate, session length, the specific behavior that means the core loop is working). Connect each metric back to a pillar — if a pillar is "tense, deliberate combat", the metric is not "time played", it is something that shows the player is engaging deliberately.

For a small or personal-scope project, one or two honest sentences are enough. Do not impose telemetry rigor where the scope does not warrant it.
