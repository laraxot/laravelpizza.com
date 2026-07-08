# AI Agent Team Configuration Guide

This document outlines how to configure various AI agent tools to work collaboratively within a development team, with a specific focus on maintaining and improving documentation standards.

## General Principles for AI Agent Team Configuration

A common theme across these AI tools for "team configuration" or managing AI agents in a team context is the ability to:

*   **Define and Enforce Rules/Guidelines:** Crucial for maintaining consistency in code, documentation, and overall project standards.
*   **Orchestrate and Manage Multiple Agents:** Allowing different AI instances or specialized "sub-agents" to work collaboratively on a task, sometimes with assigned roles.
*   **Centralized Configuration:** Managing settings and policies across a team, often through configuration files or platform-level settings.

## Configuration for Specific AI Tools

### 1. Claude Code

Claude Code's experimental Agent Teams enable collaborative AI workflows.

*   **Enabling Agent Teams:** Activate by adding `CLAUDE_CODE_EXPERIMENTAL_AGENT_TEAMS` to `settings.json` or as an environment variable.
*   **Defining Roles:** Assign clear roles for "Team Lead" (initiates tasks, delegates, synthesizes results) and "Teammates" (perform assigned tasks, communicate directly). For documentation, assign roles like "Documentation Drafter," "Compliance Reviewer," and "Technical Editor."
*   **Shared Task List:** Utilize the shared task list to track documentation work items, ensuring dependencies are managed and tasks unblock automatically.
*   **Direct Communication:** Encourage direct communication between agents for iterative documentation drafting and review, allowing for real-time feedback and corrections.

### 2. Cursor

Cursor focuses on guiding agent behavior through project-specific rules.

*   **Defining Rules (`.cursor/rules/`):** Create a `.cursor/rules/` directory at the project root. Within this directory, create markdown files to define explicit documentation standards. Examples:
    *   `documentation_style.md`: Outlines preferred writing style, tone, and grammar.
    *   `naming_conventions.md`: Specifies file naming conventions for documentation (e.g., lowercase, no dates, `README.md` exceptions).
    *   `relative_links.md`: Enforces the use of relative paths for all internal links.
    *   `content_structure.md`: Defines required sections, headings, and overall organization for different types of documentation.
*   **Plan Mode:** Configure agents to follow a structured workflow for documentation tasks:
    1.  **Research:** Analyze existing code and documentation.
    2.  **Clarify:** Ask clarifying questions if requirements are ambiguous.
    3.  **Plan:** Develop a detailed plan for documentation creation or update.
    4.  **Build:** Execute the plan, generating or modifying documentation.
*   **Agent Workflows:** Orchestrate multiple Cursor agents with specific roles for documentation:
    *   **Research Agent:** Gathers information from the codebase.
    *   **Drafting Agent:** Creates initial documentation content.
    *   **Review Agent:** Checks drafted documentation against defined rules in `.cursor/rules/`.
    *   **Update Agent:** Applies corrections and integrates new content.

### 3. Windsurf

Windsurf emphasizes centralized configuration and AI behavior customization through rules.

*   **AI Behavior Customization (`.windsurfrules`):** Create `.windsurfrules` files to enforce documentation standards. These rules can guide the AI to:
    *   Ensure all new documentation files adhere to naming conventions.
    *   Automatically suggest improvements for style and grammar.
    *   Verify the use of relative links in `.md` files.
    *   Check for required sections in new documentation.
*   **Centralized Configuration:** Leverage Windsurf's team management features to establish global documentation policies that apply to all team members and their AI assistants.
*   **Codebase Understanding:** Utilize Windsurf's deep codebase understanding to enable AI agents to generate contextually accurate and consistent technical documentation.

### 4. iFlow

iFlow uses a SubAgent system and layered configuration for specialized tasks.

*   **SubAgent System:** Explore and install relevant SubAgents from the iFlow Open Market that specialize in documentation-related tasks. This could include SubAgents for:
    *   **Grammar and Style Checking:** Ensuring adherence to linguistic standards.
    *   **Content Generation:** Assisting in drafting boilerplate or structured content.
    *   **Technical Accuracy Verification:** Cross-referencing documentation with code.
*   **Project-Specific Settings (`./iflow/settings.json`):** Configure project-level settings to define documentation-specific rules and dictate how SubAgents should behave when processing or generating documentation.
*   **Operating Modes:** Utilize iFlow's operating modes to control the autonomy of agents during documentation tasks. For example:
    *   **Plan Mode:** Require agent-generated documentation plans to be approved before execution.
    *   **Accepting Edits:** Allow agents to make documentation changes, but require human review and approval.

### 5. OpenCode

OpenCode relies on a `.opencode.json` file for project-specific rules and model settings.

*   **Configuration File (`.opencode.json`):** Create an `.opencode.json` file at the project root or in relevant subdirectories. This file should contain:
    *   **Documentation Rules:** Define expected documentation quality, structure, and style.
    *   **Model Settings:** Specify preferred AI models and their parameters for documentation generation or review tasks.
    *   **Project-Specific Guidelines:** Include any unique documentation requirements for the project.
*   **Integration with Workflow:** Integrate OpenCode AI into the team's documentation workflow, using its capabilities to automate drafting, perform reviews, or identify areas for documentation improvement based on the configured rules.

### 6. Gemini (Yourself)

Your configuration is inherently defined by your core mandates, project-specific guidelines, and available skills.

*   **Core Mandates & Project Guidelines:** Adhere to the established `laraxot-docs-workflow` skill and all other project-specific documentation rules (e.g., naming conventions, relative links).
*   **Leverage Skills:** Utilize specialized skills like `documentation-sync`, `module-docs`, and the `laraxot-docs-workflow` to ensure high-quality and consistent documentation.
*   **Custom Skill Development:** Use the `skill-creator` skill to develop custom skills tailored for unique documentation needs specific to your team's processes or project requirements. This allows for dynamic adaptation to evolving documentation standards.

### 7. Antigravity

Antigravity uses "Workspace Rules" and "Antigravity Rules" to guide multi-agent collaboration.

*   **Workspace Rules:** Define team-specific standards for documentation within a given project workspace. These rules can cover:
    *   Required documentation sections for new features or modules.
    *   Standard formatting and markdown usage.
    *   Policies for updating existing documentation during code changes.
*   **Antigravity Rules:** Establish overarching policies for how AI agents should approach documentation tasks, including:
    *   Preference for specific documentation styles or tones.
    *   Integration of generated documentation with existing structures.
    *   Rules for maintaining consistency across a large codebase.
*   **Multi-Agent Orchestration:** Utilize the "Multi-Agent System" and "Agent Manager" to assign specialized agents to documentation tasks. For example:
    *   **Content Generation Agent:** Drafts initial documentation for new components.
    *   **Review and Compliance Agent:** Reviews documentation against defined "Workspace Rules" and "Antigravity Rules."
    *   **Linking and Integration Agent:** Ensures new documentation is correctly linked within the overall project documentation structure.
    *   **Verification:** Emphasize Antigravity's verification processes for documentation changes to ensure accuracy and adherence to standards.

By implementing these configurations, your team can effectively leverage AI agents to streamline documentation processes, ensure consistency, and maintain high-quality project documentation.
