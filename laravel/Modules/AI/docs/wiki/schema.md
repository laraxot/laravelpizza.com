# AI Wiki Schema

## Scope

This schema governs the compiled wiki under `laravel/Modules/AI/docs/wiki/`.

## Layer Mapping

- Source umbrella: `../`
- Imported external sources: `../sources/`
- Compiled wiki: `./`

## Operations

### Ingest

1. Read new material from `../` or `../sources/`.
2. Update or create the minimum number of wiki pages needed to preserve durable knowledge.
3. Record the affected pages in `log.md`.
4. Keep links relative.

### Query

1. Read `index.md` first.
2. Prefer wiki pages over raw notes.
3. Cite wiki pages in answers.
4. Archive only answers with durable reuse value.

### Lint

Check:

- links;
- missing index entries;
- contradictions across AI runtime guidance;
- stale tool recommendations;
- duplicate concepts.

## Page Types

- topic summaries;
- decision records;
- archived answers;
- glossaries for recurring concepts.

## Naming

- use lowercase kebab-case;
- no dates in filenames;
- store dates inside the document body or frontmatter.
