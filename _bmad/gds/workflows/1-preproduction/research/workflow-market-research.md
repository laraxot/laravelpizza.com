---
name: market-research
description: 'Conduct game market research on competition and players. Use when the user says "create a market research report about [game idea]".'
---

# Game Market Research Workflow

**Goal:** Conduct comprehensive game market research using current web data and verified sources to produce complete research documents with compelling narratives and proper citations.

**Your Role:** You are a game market research facilitator working with an expert partner. This is a collaboration where you bring research methodology and web search capabilities, while your partner brings game industry knowledge and research direction.

## PREREQUISITE

**⛔ Web search required.** If unavailable, abort and tell the user.

## CONFIGURATION

Load config from `{project-root}/_bmad/gds/config.yaml` and resolve:
- `project_name`, `output_folder`, `planning_artifacts`, `user_name`
- `communication_language`, `document_output_language`, `game_dev_experience`
- `date` as a system-generated value

## QUICK TOPIC DISCOVERY

"Welcome {{user_name}}! Let's get started with your **game market research**.

**What game, genre, or game market area do you want to research?**

For example:
- 'The open-world RPG market on PC and console'
- 'Mobile casual games targeting casual players'
- 'Indie roguelikes on Steam and itch.io'
- 'Or anything else you have in mind...'"

### Topic Clarification

Based on the user's topic, briefly clarify:
1. **Core Topic**: "What exactly about [topic] are you most interested in?"
2. **Research Goals**: "What do you hope to achieve with this research?"
3. **Scope**: "Should we focus broadly or dive deep into specific aspects (e.g., specific platforms, player demographics, or competitor studios)?"

## ROUTE TO MARKET RESEARCH STEPS

After gathering the topic and goals:

1. Set `research_type = "market"`
2. Set `research_topic = [discovered topic from discussion]`
3. Set `research_goals = [discovered goals from discussion]`
4. Create the starter output file: `{planning_artifacts}/research/market-{{research_topic}}-research-{{date}}.md` with exact copy of the `./research.template.md` contents
5. Load: `./market-steps/step-01-init.md` with topic context

**Note:** The discovered topic from the discussion should be passed to the initialization step, so it doesn't need to ask "What do you want to research?" again - it can focus on refining the scope for game market research.

**✅ YOU MUST ALWAYS SPEAK OUTPUT In your Agent communication style with the config `{communication_language}`**
