---
layout: default
title: "Subagent Patterns - Parallel Execution Architecture"
description: "Learn how BMAD Skills use parallel subagents to maximize Claude's context (up to 1M tokens on Sonnet/Opus 4.6). Patterns for research, document generation, and implementation."
keywords: "BMAD subagents, parallel execution, Claude Code agents, task parallelization"
---

# Subagent Patterns - Parallel Execution Architecture

BMAD Skills leverage Claude Code's subagent architecture to execute complex workflows in parallel. Each subagent gets its own context window (up to 1M tokens on Claude Sonnet 4.6 and Opus 4.6), enabling massive parallelization of research, document generation, and implementation tasks.

---

## Core Principle

**Never do sequentially what can be done in parallel.**

Each BMAD skill decomposes its work into independent subtasks that can be executed by parallel subagents, then synthesizes the results. This approach dramatically reduces workflow execution time while maximizing the use of Claude's extensive context capabilities.

---

## Subagent Types

BMAD skills use four subagent types via the `Task` tool:

| Subagent Type | Model | Tools | Best For |
|---------------|-------|-------|----------|
| **general-purpose** | Inherits | All tools | Research, implementation, analysis |
| **Explore** | Haiku | Read, Grep, Glob (read-only) | Fast codebase exploration |
| **Plan** | Inherits | Read-only tools | Architecture planning, design decisions |
| **Bash** | Inherits | Bash only | Terminal commands in isolation |

Use `Explore` for fast, cheap codebase queries. Use `general-purpose` for substantive work. Use `Bash` when you need only shell execution.

### Standard Invocation

All subagents are invoked using the `Task` tool with:
- `subagent_type`: "general-purpose" (or "Explore", "Plan", "Bash")
- `run_in_background`: true (for parallel execution)
- `prompt`: Detailed, self-contained task description

---

## Parallel Execution Patterns

### Pattern 1: Fan-Out Research

When gathering information from multiple independent sources.

```
┌─────────────────┐
│  Main Context   │
└────────┬────────┘
         │ Launch parallel agents
    ┌────┴────┬────────┬────────┐
    ▼         ▼        ▼        ▼
┌───────┐ ┌───────┐ ┌───────┐ ┌───────┐
│Agent 1│ │Agent 2│ │Agent 3│ │Agent 4│
│Market │ │Compet.│ │Tech   │ │User   │
│Research│ │Analysis│ │Research│ │Research│
└───┬───┘ └───┬───┘ └───┬───┘ └───┬───┘
    │         │        │        │
    └────┬────┴────────┴────────┘
         ▼
┌─────────────────┐
│  Synthesize     │
│  Results        │
└─────────────────┘
```

**Example Use Case:** Business Analyst researching a product
- **Agent 1:** Market size and trends
- **Agent 2:** Competitive landscape
- **Agent 3:** Technical feasibility
- **Agent 4:** User needs analysis

**When to Use:**
- Multiple independent research domains
- Gathering diverse perspectives
- No dependencies between tasks
- Each task requires significant context

---

### Pattern 2: Parallel Section Generation

When creating multi-section documents where sections are independent.

```
┌─────────────────┐
│  Gather Context │
│  (shared info)  │
└────────┬────────┘
         │ Launch parallel agents with shared context
    ┌────┴────┬────────┬────────┐
    ▼         ▼        ▼        ▼
┌───────┐ ┌───────┐ ┌───────┐ ┌───────┐
│Section│ │Section│ │Section│ │Section│
│   1   │ │   2   │ │   3   │ │   4   │
└───┬───┘ └───┬───┘ └───┬───┘ └───┬───┘
    │         │        │        │
    └────┬────┴────────┴────────┘
         ▼
┌─────────────────┐
│  Assemble Doc   │
└─────────────────┘
```

**Example Use Case:** Product Manager creating PRD
- **Agent 1:** Functional Requirements section
- **Agent 2:** Non-Functional Requirements section
- **Agent 3:** Epics and User Stories
- **Agent 4:** Dependencies and Constraints

**When to Use:**
- Large document generation
- Sections are logically independent
- Shared requirements context
- Each section is substantial (1K+ tokens)

---

### Pattern 3: Component Parallel Design

When designing system components that interact but can be designed independently.

```
┌─────────────────┐
│  Load PRD/NFRs  │
│  Define Scope   │
└────────┬────────┘
         │ Each agent designs one component
    ┌────┴────┬────────┬────────┐
    ▼         ▼        ▼        ▼
┌───────┐ ┌───────┐ ┌───────┐ ┌───────┐
│ Auth  │ │ Data  │ │  API  │ │  UI   │
│Service│ │ Layer │ │ Layer │ │ Layer │
└───┬───┘ └───┬───┘ └───┬───┘ └───┬───┘
    │         │        │        │
    └────┬────┴────────┴────────┘
         ▼
┌─────────────────┐
│ Integration     │
│ Architecture    │
└─────────────────┘
```

**Example Use Case:** System Architect designing architecture
- **Agent 1:** Authentication/Authorization design
- **Agent 2:** Data layer and storage design
- **Agent 3:** API layer design
- **Agent 4:** Frontend architecture

**When to Use:**
- System has clear component boundaries
- Components have defined interfaces
- NFRs are known and documented
- Components can be designed in isolation

---

### Pattern 4: Story Parallel Implementation

When implementing multiple independent user stories.

```
┌─────────────────┐
│  Sprint Plan    │
│  Story Queue    │
└────────┬────────┘
         │ Independent stories in parallel
    ┌────┴────┬────────┬────────┐
    ▼         ▼        ▼        ▼
┌───────┐ ┌───────┐ ┌───────┐ ┌───────┐
│STORY-1│ │STORY-2│ │STORY-3│ │STORY-4│
│Backend│ │Backend│ │Frontend│ │Tests │
└───┬───┘ └───┬───┘ └───┬───┘ └───┬───┘
    │         │        │        │
    └────┬────┴────────┴────────┘
         ▼
┌─────────────────┐
│ Integration &   │
│ Verification    │
└─────────────────┘
```

**Example Use Case:** Developer implementing sprint stories
- **Agent 1:** STORY-001 backend implementation
- **Agent 2:** STORY-002 backend implementation
- **Agent 3:** STORY-003 frontend implementation
- **Agent 4:** Integration test suite

**When to Use:**
- Stories have no blocking dependencies
- Stories touch different files/components
- Each story is substantial (5+ points)
- Sprint has multiple independent stories

---

## Subagent Prompt Template

Each subagent prompt should be self-contained with all necessary context:

```markdown
## Task: [Specific Task Name]

## Context
[Provide all necessary context - the subagent cannot see main conversation]
- Project: {{project_name}}
- Phase: {{current_phase}}
- Related docs: [list paths to read]

## Objective
[Clear, specific goal for this subagent]

## Constraints
- [Any limitations or requirements]
- Output format: [specify expected output]

## Deliverables
1. [Specific deliverable 1]
2. [Specific deliverable 2]

## Output Location
Write results to: [specific file path]
```

### Example Prompt

```markdown
## Task: Conduct competitive analysis for mobile payment product

## Context
Read bmad/context/discovery-brief.md for problem statement and target market

## Objective
Identify competitors, analyze features, pricing, and positioning

## Constraints
- Focus on mobile payment space
- Target small business segment
- Use WebSearch for current market data
- Include sources for all findings

## Deliverables
1. List of 5-8 direct competitors with profiles
2. Feature comparison matrix
3. Pricing analysis and market positioning
4. Gap analysis and differentiation opportunities
5. Key insights and recommendations

## Output Location
Write findings to: bmad/outputs/competitive-analysis.md
```

---

## Coordination Strategies

### Shared Context via Files

Before launching parallel agents, write shared context to a file:

**Standard Pattern:**
1. Write shared context to `bmad/context/current-task.md`
2. Launch agents that read from this file
3. Each agent writes output to `bmad/outputs/agent-{n}.md`
4. Main context synthesizes all outputs

**Example Context File Structure:**

```markdown
# Project Context: E-commerce Platform

## Project Info
- Name: E-commerce Platform
- Type: web-app
- Level: 2 (Medium)

## Requirements Summary
[Key requirements relevant to all agents]

## Architectural Constraints
[Technical constraints to consider]

## Success Criteria
[What defines success for this task]
```

---

### Dependency Management

For tasks with dependencies, use phased parallel execution:

```
Phase 1 (Parallel):     Agent A, Agent B, Agent C
                              │
                        Wait for all
                              │
Phase 2 (Parallel):     Agent D (needs A), Agent E (needs B,C)
                              │
                        Wait for all
                              │
Phase 3 (Sequential):   Final synthesis in main context
```

**Example:** Architecture Design
1. **Phase 1:** Parallel analysis of FRs and NFRs
2. **Phase 2:** Parallel component design (needs requirements)
3. **Phase 3:** Integration architecture (needs components)

---

### Result Collection

Use the `TaskOutput` tool to collect results:

```python
# Pseudocode for result collection pattern
agents = []
agents.append(launch_agent("task 1", background=True))
agents.append(launch_agent("task 2", background=True))
agents.append(launch_agent("task 3", background=True))

# Continue with other work while agents run

# When ready, collect results
for agent in agents:
    result = get_agent_output(agent, block=True)
    process(result)
```

**Best Practices:**
- Launch all parallel agents before waiting for any
- Use `block=False` to check progress without waiting
- Use `block=True` when results are needed for next step
- Handle partial failures gracefully

---

## Skill-Specific Patterns

Each BMAD skill defines its own subagent strategies:

### Business Analyst

| Workflow | Pattern | Agents | Purpose |
|----------|---------|--------|---------|
| **Product Discovery** | Fan-Out Research | 4 | Market/Competitive/Tech/User research |
| **Product Brief** | Parallel Section Generation | 3 | Problem/Solution/Metrics sections |

**Coordination:** Sequential interviews → Parallel research/generation

---

### Product Manager

| Workflow | Pattern | Agents | Purpose |
|----------|---------|--------|---------|
| **PRD Generation** | Parallel Section Generation | 4 | FR/NFR/Epics/Dependencies sections |
| **Epic Prioritization** | Parallel Section Generation | N | RICE scoring per epic |
| **Tech Spec** | Parallel Section Generation | 3 | Requirements/Approach/Testing |

**Coordination:** Sequential gathering → Parallel generation

---

### System Architect

| Workflow | Pattern | Agents | Purpose |
|----------|---------|--------|---------|
| **Requirements Analysis** | Fan-Out Research | 2 | FR analysis, NFR analysis |
| **Component Design** | Component Parallel Design | N | One per major component |
| **NFR Mapping** | Parallel Section Generation | 6 | One per NFR category |

**Coordination:** Parallel analysis → Sequential integration

---

### Scrum Master

| Workflow | Pattern | Agents | Purpose |
|----------|---------|--------|---------|
| **Epic Breakdown** | Parallel Section Generation | N | One per epic |
| **Sprint Planning** | Parallel Section Generation | 3 | Dependencies/Velocity/Goals |
| **Story Refinement** | Story Parallel Implementation | N | Detail independent stories |

**Coordination:** Parallel breakdown → Sequential allocation

---

### Developer

| Workflow | Pattern | Agents | Purpose |
|----------|---------|--------|---------|
| **Story Implementation** | Story Parallel Implementation | N | Independent stories |
| **Test Writing** | Component Parallel Design | N | Tests per component |
| **Code Review** | Fan-Out Research | N | One per PR |

**Coordination:** Parallel implementation → Sequential integration

---

### Creative Intelligence

| Workflow | Pattern | Agents | Purpose |
|----------|---------|--------|---------|
| **Brainstorming** | Fan-Out Research | 3-6 | Different techniques |
| **Research** | Fan-Out Research | 4 | Market/Competitive/Tech/User |
| **Problem Exploration** | Parallel Section Generation | 3 | 5 Whys/Questions/Perspectives |
| **Solution Generation** | Parallel Section Generation | 4 | Variations/Research/Constraints/Criteria |

**Coordination:** Parallel exploration → Sequential synthesis

---

### UX Designer

| Workflow | Pattern | Agents | Purpose |
|----------|---------|--------|---------|
| **Flow Design** | Story Parallel Implementation | N | Independent user journeys |
| **Wireframing** | Component Parallel Design | N | Different screens |
| **Accessibility** | Parallel Section Generation | N | Checklist validation |

**Coordination:** Parallel design → Sequential integration

---

### Builder

| Workflow | Pattern | Agents | Purpose |
|----------|---------|--------|---------|
| **Skill Creation** | Component Parallel Design | 4 | SKILL.md/scripts/templates/resources |
| **Validation** | Parallel Section Generation | N | Different components |

**Coordination:** Parallel creation → Sequential assembly

---

## Token Budget Guidelines

Each subagent has approximately 200K tokens by default. Claude Sonnet 4.6 and Opus 4.6 also support a **1M context window** (beta) — ideal for very large codebases or comprehensive research tasks. Recommended allocation:

| Activity | Token Budget | Percentage |
|----------|-------------|------------|
| **Context loading** | ~20K | 10% |
| **Research/exploration** | ~100K | 50% |
| **Generation/writing** | ~50K | 25% |
| **Verification** | ~30K | 15% |

**Tips for Token Efficiency:**
- Write concise shared context files (5-10K tokens)
- Reference templates rather than including full text
- Use scripts for deterministic operations
- Lazy-load reference documentation as needed
- Use `Explore` (Haiku-based) for fast, cheap codebase queries — saves budget for generation

---

## Worktree Isolation

For Developer skill workflows where parallel stories could conflict at the file level, subagents can run in **isolated git worktrees**. Each agent gets its own branch and working copy:

```
Main Branch
    │
    ├── story-001-worktree/  ← Agent 1 works here
    ├── story-002-worktree/  ← Agent 2 works here
    └── story-003-worktree/  ← Agent 3 works here
```

This prevents merge conflicts during parallel implementation. Results are integrated by the main context after all agents complete.

**When to use worktree isolation:**
- Stories modify the same files (e.g., shared config, index files)
- Agents write code that may conflict
- You need clean PR branches per story

---

## Anti-Patterns

### What NOT to Do

**Don't:**
- Launch agents for trivial tasks (<1K tokens of work)
- Pass entire conversation history to subagents
- Create deep chains of subagents calling subagents
- Launch dependent tasks in parallel
- Launch 10+ agents without clear coordination strategy

**Example of Anti-Pattern:**
```markdown
# BAD: Too many trivial agents
Agent 1: Format this JSON
Agent 2: Add one line to config
Agent 3: Update a single variable name
```

### What TO Do

**Do:**
- Bundle related small tasks into one agent
- Write concise, focused prompts with just needed context
- Keep subagent depth to 1 level when possible
- Clearly identify dependencies before parallelizing
- Use 3-6 agents for most workflows

**Example of Good Pattern:**
```markdown
# GOOD: Meaningful parallel work
Agent 1: Complete market research with analysis
Agent 2: Full competitive landscape assessment
Agent 3: Technical feasibility evaluation
```

---

## Monitoring Pattern

Standard approach for tracking parallel agent execution:

```markdown
1. Launch N background agents
2. Continue main context work (if any)
3. Periodically check: TaskOutput(task_id, block=false)
4. When all complete: Synthesize results
5. Update TodoWrite with completion status
```

**Progress Tracking:**
- Use TodoWrite to track agent tasks
- Check agent status before blocking
- Handle partial completion gracefully
- Report progress to user during long waits

---

## Integration with BMAD Workflow

Each skill's `SKILL.md` includes a "Subagent Strategy" section defining:

```markdown
## Subagent Strategy

This skill uses parallel subagents for:
- [Task 1]: N agents for [purpose]
- [Task 2]: N agents for [purpose]

Coordination approach: [Fan-out/Parallel sections/etc.]
```

**Example from Business Analyst SKILL.md:**

```markdown
## Subagent Strategy

### Product Discovery Research Workflow
**Pattern:** Fan-Out Research
**Agents:** 4 parallel agents

| Agent | Task | Output |
|-------|------|--------|
| Agent 1 | Market research | bmad/outputs/market-research.md |
| Agent 2 | Competitive analysis | bmad/outputs/competitive-analysis.md |
| Agent 3 | Technical feasibility | bmad/outputs/technical-feasibility.md |
| Agent 4 | User needs analysis | bmad/outputs/user-needs.md |

**Coordination:**
1. Write shared problem context to bmad/context/discovery-brief.md
2. Launch all 4 research agents in parallel
3. Synthesize outputs into product brief
```

---

## Best Practices Summary

### When to Use Parallel Subagents

Use parallel subagents when:
- Tasks are independent (no sequential dependencies)
- Each task is substantial (5K+ tokens of work)
- Total work is large enough to benefit from parallelization
- Context can be effectively shared via files

### Coordination Checklist

Before launching parallel agents:
- [ ] Identify truly independent tasks
- [ ] Write shared context to `bmad/context/`
- [ ] Define clear output locations for each agent
- [ ] Create self-contained prompts with all needed info
- [ ] Plan synthesis approach for combining results

### Quality Assurance

After collecting agent results:
- [ ] Validate all agents completed successfully
- [ ] Check for conflicts or inconsistencies
- [ ] Synthesize results into unified output
- [ ] Verify output meets requirements
- [ ] Update workflow status

---

<div style="text-align: center; margin-top: 40px; padding: 20px; background: #e8f4f8; border-radius: 8px;" markdown="1">

**Maximize Your Context Windows**

Parallel subagents enable BMAD to handle complex workflows efficiently. Each workflow can leverage 800K+ tokens across 4 agents at the standard 200K window, or even more with the 1M context window available on Claude Sonnet 4.6 and Opus 4.6. This dramatically reduces execution time while maintaining quality.

</div>
