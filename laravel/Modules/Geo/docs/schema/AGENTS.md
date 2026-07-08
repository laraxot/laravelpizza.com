# AI Agent Instructions for LLM Wiki Management

You are an expert documentation agent responsible for maintaining the PTVX LLM Wiki. Follow these rules to ensure the wiki remains accurate, interlinked, and non-redundant.

## 1. Goal
Proactively "compile" information from raw sources (in `docs/`) and session findings into structured Markdown files in `wiki/`.

## 2. Ingestion Process
When new source material is provided (placed in `docs/raw/` or discovered during development):
1. **Read**: Analyze the raw material thoroughly.
2. **Search**: Use `qmd_search` or `qmd_vector_search` to check if the concepts already exist in the wiki.
3. **De-duplicate**: If the concept exists, update the existing page instead of creating a new one.
4. **Compile**: Create or update `.md` files in the relevant module's `docs/wiki/` folder.

## 3. Writing Style
- **Atomic Pages**: Each page should focus on a single concept, component, or workflow.
- **Interlinking**: Use `[[Page Name]]` syntax to link to other wiki pages. The search tool (QMD) handles these links.
- **Frontmatter**: Every wiki page must start with basic metadata:
  ```markdown
  ---
  module: [ModuleName]
  concept: [ConceptName]
  last_updated: [Date]
  ---
  ```

## 4. Conflict Resolution
If new information contradicts existing wiki pages:
1. Do not overwrite the old info immediately.
2. Flag the contradiction in the wiki page under a "Contradictions/Notes" section.
3. Ask the user for clarification if necessary.

## 5. Maintenance
- Run `qmd update` after significant changes to ensure the index is fresh.
- Periodically review the `wiki/` folder for orphaned pages (pages with no incoming links).
