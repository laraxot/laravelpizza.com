# Karpathy LLM-Wiki Pattern in PTVX

This document outlines the implementation of the **LLM Wiki** pattern (as proposed by Andrej Karpathy in early 2026) within the PTVX modular architecture.

## 1. Overview

The **LLM Wiki** is a stateful knowledge base that grows and interlinks as an AI agent "digests" information. Unlike traditional RAG (Retrieval-Augmented Generation) which is stateless and relies on vector search over raw chunks, an LLM Wiki uses a "compilation-based" approach.

### Key Benefits
- **Persistent State:** The LLM "remembers" findings by writing them into structured Markdown files.
- **Cross-Linking:** Pages use `[[wiki-style]]` links to connect related concepts.
- **De-duplication:** The agent identifies when new information contradicts or repeats existing knowledge.
- **High Recall:** The wiki provides a high-level map of the codebase and domain knowledge.

## 2. Directory Structure

To maintain order, every module, theme, and core directory (`docs/`, `bashscripts/docs/`) follows this standard sub-structure:

```text
docs/
├── wiki/         # LLM-Owned Markdown files (Interlinked Pages)
├── raw/          # Immutable source files (Original Docs, Transcripts, PDFs)
├── schema/       # Instructions for the agent on how to maintain this wiki
├── logs/          # Research logs and session summaries
├── screenshots/   # Visual documentation of UI/UX and workflows
└── [raw-files]    # Legacy documentation files (PRDs, READMEs, etc.)
```

### Purpose of Folders:
- **`docs/`**: The base folder for the module. It contains legacy documentation and high-level PRDs. In the Karpathy pattern, this serves as the "entry point".
- **`docs/wiki/`**: This is the most important folder. It contains `.md` files that are entirely managed by the LLM. No human (usually) edits these directly.
- **`docs/raw/`**: Used for new source materials that need to be ingested.
- **`docs/schema/`**: Contains `AGENTS.md` or similar to define how the agent should interpret this specific module's knowledge.
- **`docs/logs/`**: Keeps a history of research sessions.

## 3. Tooling: QMD (Query Markup Documents)

We use **QMD** (by Tobi Lütke) as the search and retrieval layer.

### MCP Server Integration
QMD is configured as an MCP server in `laravel/.mcp.json`:

```json
"qmd": {
    "command": "qmd",
    "args": [
        "mcp",
        "${PWD}/docs"
    ]
}
```

### Usage Tips
- **Index:** `qmd index docs/` (Run this after significant updates to the wiki).
- **Search:** Use `qmd_search` or `qmd_vector_search` through the agent to find related information across the entire project's wikis.

## 4. Initialization

To initialize the structure in a new module, use the following bash script:
`bashscripts/docs/init-karpathy-wiki.sh`

## 5. Maintenance Workflow

1. **Ingest:** Place new raw information in `docs/raw/`.
2. **Compile:** Instruct the agent to read the raw data and update the `docs/wiki/` pages.
3. **Link:** Ensure the agent adds `[[links]]` to other relevant pages.
4. **Index:** Re-index with `qmd index`.
