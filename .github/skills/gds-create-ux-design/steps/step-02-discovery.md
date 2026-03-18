# Step 2: Project Understanding

## MANDATORY EXECUTION RULES (READ FIRST):

- 🛑 NEVER generate content without user input

- 📖 CRITICAL: ALWAYS read the complete step file before taking any action - partial understanding leads to incomplete decisions
- 🔄 CRITICAL: When loading next step with 'C', ensure the entire file is read and understood before proceeding
- ✅ ALWAYS treat this as collaborative discovery between UX facilitator and stakeholder
- 📋 YOU ARE A UX FACILITATOR, not a content generator
- 💬 FOCUS on understanding project context and user needs
- 🎯 COLLABORATIVE discovery, not assumption-based design
- ✅ YOU MUST ALWAYS SPEAK OUTPUT In your Agent communication style with the config `{communication_language}`

## EXECUTION PROTOCOLS:

- 🎯 Show your analysis before taking any action
- ⚠️ Present A/P/C menu after generating project understanding content
- 💾 ONLY save when user chooses C (Continue)
- 📖 Update output file frontmatter, adding this step to the end of the list of stepsCompleted.
- 🚫 FORBIDDEN to load next step until C is selected

## COLLABORATION MENUS (A/P/C):

This step will generate content and present choices:

- **A (Advanced Elicitation)**: Use discovery protocols to develop deeper project insights
- **P (Party Mode)**: Bring multiple perspectives to understand project context
- **C (Continue)**: Save the content to the document and proceed to next step

## PROTOCOL INTEGRATION:

- When 'A' selected: Read fully and follow: skill:bmad-advanced-elicitation
- When 'P' selected: Read fully and follow: {project-root}/_bmad/core/workflows/bmad-party-mode/workflow.md
- PROTOCOLS always return to this step's A/P/C menu
- User accepts/rejects protocol changes before proceeding

## CONTEXT BOUNDARIES:

- Current document and frontmatter from step 1 are available
- Input documents (GDD, briefs, epics) already loaded are in memory
- No additional data files needed for this step
- Focus on project and user understanding

## YOUR TASK:

Understand the project context, target players, and what makes this game special from a UX perspective.

## PROJECT DISCOVERY SEQUENCE:

### 1. Review Loaded Context

Start by analyzing what we know from the loaded documents:
"Based on the project documentation we have loaded, let me confirm what I'm understanding about {{project_name}}.

**From the documents:**
{summary of key insights from loaded GDD, briefs, and other context documents}

**Target Players:**
{summary of player information from loaded documents}

**Key Features/Goals:**
{summary of main features and goals from loaded documents}

Does this match your understanding? Are there any corrections or additions you'd like to make?"

### 2. Fill Context Gaps (If no documents or gaps exist)

If no documents were loaded or key information is missing:
"Since we don't have complete documentation, let's start with the essentials:

**What are you building?** (Describe your game in 1-2 sentences)

**Who is this for?** (Describe your ideal player or target audience)

**What makes this special or different?** (What's the unique value proposition?)

**What's the main thing players will do with this?** (Core gameplay loop or goal)"

### 3. Explore Player Context Deeper

Dive into player understanding:
"Let me understand your players better to inform the UX design:

**Player Context Questions:**

- What problem or desire are players trying to fulfill?
- What frustrates them with current games in this space?
- What would make them say 'this is exactly what I needed'?
- How experienced are your target players with this genre?
- What platforms will they play on most?
- When/where will they play this game?"

### 4. Identify UX Design Challenges

Surface the key UX challenges to address:
"From what we've discussed, I'm seeing some key UX design considerations:

**Design Challenges:**

- [Identify 2-3 key UX challenges based on game type and player needs]
- [Note any platform-specific considerations]
- [Highlight any complex player flows or interactions]

**Design Opportunities:**

- [Identify 2-3 areas where great UX could create competitive advantage]
- [Note any opportunities for innovative UX patterns]

Does this capture the key UX considerations we need to address?"

### 5. Generate Project Understanding Content

Prepare the content to append to the document:

#### Content Structure:

When saving to document, append these Level 2 and Level 3 sections:

```markdown
## Executive Summary

### Project Vision

[Project vision summary based on conversation]

### Target Players

[Target player descriptions based on conversation]

### Key Design Challenges

[Key UX challenges identified based on conversation]

### Design Opportunities

[Design opportunities identified based on conversation]
```

### 6. Present Content and Menu

Show the generated project understanding content and present choices:
"I've documented our understanding of {{project_name}} from a UX perspective. This will guide all our design decisions moving forward.

**Here's what I'll add to the document:**

[Show the complete markdown content from step 5]

**What would you like to do?**
[C] Continue - Save this to the document and move to core experience definition"

### 7. Handle Menu Selection

#### If 'C' (Continue):

- Append the final content to `{planning_artifacts}/ux-design-specification.md`
- Update frontmatter: `stepsCompleted: [1, 2]`
- Load `./step-03-core-experience.md`

## APPEND TO DOCUMENT:

When user selects 'C', append the content directly to the document. Only after the content is saved to document, read fully and follow: `./step-03-core-experience.md`.

## SUCCESS METRICS:

✅ All available context documents reviewed and synthesized
✅ Project vision clearly articulated
✅ Target players well understood
✅ Key UX challenges identified
✅ Design opportunities surfaced
✅ A/P/C menu presented and handled correctly
✅ Content properly appended to document when C selected

## FAILURE MODES:

❌ Not reviewing loaded context documents thoroughly
❌ Making assumptions about players without asking
❌ Missing key UX challenges that will impact design
❌ Not identifying design opportunities
❌ Generating generic content without real project insight
❌ Not presenting A/P/C menu after content generation
❌ Appending content without user selecting 'C'

❌ **CRITICAL**: Reading only partial step file - leads to incomplete understanding and poor decisions
❌ **CRITICAL**: Proceeding with 'C' without fully reading and understanding the next step file
❌ **CRITICAL**: Making decisions without complete understanding of step requirements and protocols

## NEXT STEP:

Remember: Do NOT proceed to step-03 until user explicitly selects 'C' from the menu and content is saved!
