# Project CLAUDE.md Example

Copy this file to your project root as `CLAUDE.md` to enable BMAD skills.

---

# {{PROJECT_NAME}}

{{PROJECT_DESCRIPTION}}

## Development Methodology

This project uses the **BMAD Method** (Breakthrough Method for Agile AI-Driven Development).

### Project Configuration

- **Project Level:** {{LEVEL}} (0-4)
- **Project Type:** {{TYPE}} (web-app, mobile-app, api, game, library, cli)

### Current Phase

Check status with: "What's my BMAD status?"

## BMAD Skill Activation

Use these BMAD skills for structured development:

| Need | Say | Skill |
|------|-----|-------|
| Start a new project | "Initialize BMAD" | bmad-orchestrator |
| Check progress | "What's the project status?" | bmad-orchestrator |
| Define the problem | "Create a product brief" | business-analyst |
| Research the market | "Research competitors for..." | business-analyst |
| Brainstorm features | "Brainstorm using SCAMPER" | creative-intelligence |
| Define requirements | "Create a PRD" | product-manager |
| Prioritize features | "Prioritize with RICE scoring" | product-manager |
| Design UX | "Create wireframes for..." | ux-designer |
| Design architecture | "Design the system architecture" | system-architect |
| Plan sprints | "Create sprint plan" | scrum-master |
| Implement features | "Implement STORY-001" | developer |

## Parallel Subagent Usage

For complex tasks, request parallel execution:

- "Research market, competitors, and technical feasibility **in parallel**"
- "Design all components **in parallel**"
- "Implement these independent stories **in parallel**"

Each subagent has up to 1M tokens on Claude Sonnet 4.6 / Opus 4.6 - leverage this for comprehensive analysis.

## Project Structure

```
{{PROJECT_NAME}}/
├── CLAUDE.md                    # This file
├── bmad/
│   └── config.yaml             # BMAD configuration
├── docs/
│   ├── bmm-workflow-status.yaml
│   └── [generated documents]
└── src/
    └── [your code]
```

## Workflow Shortcuts

Phase 1 (Analysis):
- "Create product brief" → Product discovery
- "Research [topic]" → Market/competitive research
- "Brainstorm [topic]" → Structured ideation

Phase 2 (Planning):
- "Create PRD" → Full requirements document
- "Create tech spec" → Lightweight spec for small projects
- "Design UX for [feature]" → Wireframes and flows

Phase 3 (Solutioning):
- "Design architecture" → System architecture
- "Run gate check" → Validate before implementation

Phase 4 (Implementation):
- "Plan sprint" → Break epics into stories
- "Implement [STORY-ID]" → Code the story
- "Review [file/PR]" → Code review

## Code Standards

[Add your project-specific coding standards here]

## Tech Stack

[Add your tech stack details here - the architect skill will reference this]

## Notes

- Always check `/status` before starting new work
- Complete each phase before moving to the next
- Use subagents for research-heavy or multi-section documents
- Update story status after implementation
