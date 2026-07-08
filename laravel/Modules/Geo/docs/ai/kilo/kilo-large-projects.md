# Kilo Code for Large Projects

This project uses Kilo Code in a large monorepo context, so context control matters as much as model quality.

## Effective Defaults

- Keep project instructions centered on root `AGENTS.md`.
- Keep project MCP lean. For this repository, the active set is `qmd` plus `token-optimizer`.
- Use `.kilocodeignore` and `watcher.ignore` to exclude agent metadata, caches, dependency trees, and generated runtime folders.
- Keep `compaction.auto=true`, `compaction.prune=true`, and reserve enough output budget to trigger compaction early.

## Official Kilo Guidance Applied Here

From the official Kilo docs, the highest-signal practices for large projects are:

- `AGENTS.md` is the durable project context. Keep it concise and repository-specific.
- Conversation history is disposable context. Use `/compact` or start a new session when changing topic after long work.
- MCP adds tool schema and tool output to the prompt. Enable only the servers needed for the current repository.
- `.kilocodeignore` is still supported and is migrated into read/edit deny rules.
- `watcher.ignore` is separate from file access rules and should exclude noisy runtime trees.
- Codebase Indexing is useful for large repositories, but only after noisy paths are excluded.

## Current Repository Setup

- project config: `/.kilo/kilo.jsonc`
- global config: `~/.config/kilo/kilo.jsonc`
- global instructions: `~/.config/kilo/AGENTS.md`
- project ignore file: `/.kilocodeignore`
- project MCP config: `/.kilo/kilo.jsonc`
- managed indexing policy: `/.kilocode/config.json`
- local indexing bootstrap: `/bashscripts/tools/kilo_local_indexing_bootstrap.sh`
- local Qdrant config: `/.local/qdrant/config.yaml`

## Current Kilo Improvements

- removed invalid Kilo config keys that prevented settings from loading
- reduced instruction fan-in to root `AGENTS.md`
- reduced MCP servers to `qmd` and `token-optimizer`
- blocked `.agents`, `.kilo`, `.opencode`, and related runtime trees from normal context reads
- repaired broken `opencode.json` merge markers
- enabled valid compaction settings globally and at project level
- disabled managed indexing by default for this repository until local indexing or a deliberate cloud-indexing choice is configured

## Indexing Policy

Kilo currently exposes two different indexing paths:

- local codebase indexing with embeddings plus Qdrant
- managed indexing in Kilo Cloud

For this repository, managed indexing is explicitly disabled in `/.kilocode/config.json` to avoid accidental cloud indexing, surprise context behavior, or extra operational drift before the team chooses:

1. local embeddings plus local Qdrant
2. managed indexing with explicit acceptance

Until then, retrieval stays:

- wiki first
- QMD second
- raw docs last

## Local Indexing Readiness

Local prerequisites are now prepared:

- Ollama available locally
- `nomic-embed-text` installed
- Qdrant `1.17.1` installed inside the repository
- detached bootstrap script available to keep Qdrant running on `127.0.0.1:6333`

Bootstrap command:

```bash
bashscripts/tools/kilo_local_indexing_bootstrap.sh
```

Validation commands:

```bash
pgrep -af qdrant
curl -s http://127.0.0.1:6333/
ollama list
```

## Current Limitation

The repository-side automation now covers the local prerequisites, but not the final Kilo-side binding for embeddings and Qdrant.

Ready in the repository:

- local Qdrant runtime
- local embedding model in Ollama
- bootstrap script
- managed indexing explicitly disabled

Still client-side sensitive:

- selecting the local embedding provider inside Kilo Codebase Indexing
- confirming whether the running Kilo client expects an explicit Qdrant endpoint or auto-detects the local store

So the safe project rule is:

1. keep prerequisites ready in the repo
2. keep managed indexing disabled by default
3. enable final indexing binding only after confirming the exact settings surface in the running Kilo client

## Operational Guidance

Use Kilo with narrow prompts:

- mention exact file paths
- mention exact classes, actions, or views
- avoid asking for repo-wide summaries without retrieval first
- compact before switching from one subsystem to another

When a task spans many modules:

1. query wiki or indexed docs first
2. open only the needed files
3. compact before the next major branch of work

## Verification

The setup should validate with:

```bash
kilo config check
kilo mcp list
```

Managed indexing should remain disabled by repository policy:

```json
{
  "project": {
    "managedIndexingEnabled": false
  }
}
```

Expected MCP result for this repository:

- `qmd`
- `token-optimizer`

## Sources

- https://kilo.ai/docs/customize/context/large-projects
- https://kilo.ai/docs/customize/context/context-condensing
- https://kilo.ai/docs/customize/agents-md
- https://kilo.ai/docs/customize/custom-instructions
- https://kilo.ai/docs/customize/context/kilocodeignore
- https://kilo.ai/docs/features/codebase-indexing
- https://kilo.ai/docs/deploy-secure/managed-indexing
- https://kilo.ai/docs/automate/mcp/using-in-cli
