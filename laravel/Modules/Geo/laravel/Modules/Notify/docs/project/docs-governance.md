# Documentation Governance

## Purpose

Documentation in this repository is a routing system for humans and agents.
Its job is not to preserve every intermediate thought in every folder.
Its job is to make the current truth easy to find, easy to trust, and hard to duplicate.

## Philosophy

- One topic should have one primary home.
- Indexes should route, not restate full content.
- Stable names beat clever names.
- Fewer entrypoints mean faster retrieval and fewer wrong edits.
- Archives are allowed, but they must not compete with active documentation.

## Canonical Rule

For every active documentation root, prefer exactly one canonical entrypoint:

- `README.md` for module, theme, script, and section entrypoints
- lowercase, date-free filenames for topic documents
- `CHANGELOG.md` only when a changelog is truly needed

Do not create new parallel entry files such as `INDEX.md`, `00-INDEX.md`, `00-index.md`, or `index.md`
when `README.md` already plays the same role. Existing variants may remain temporarily, but new work must
link to the canonical file instead of multiplying entrypoints.

## Canonical Locations

Use these locations for maintained documentation:

- Project-wide rules and shared guidance: `docs/`
- Module-specific documentation: `laravel/Modules/<Module>/docs/`
- Theme-specific documentation: `laravel/Themes/<Theme>/docs/`
- Script-specific documentation: `bashscripts/docs/`

Treat these as non-canonical or supporting unless explicitly justified:

- `app/docs`
- `resources/views/docs`
- `docs/docs`
- `roadmap/docs`
- generated or vendor `docs/`

## Naming Rules

- Use lowercase filenames for normal markdown files.
- Use hyphens, not spaces or underscores, for new topic filenames.
- Do not encode dates in filenames.
- Keep `README.md` and `CHANGELOG.md` uppercase.
- If both `README.md` and `readme.md` exist, `README.md` is canonical.

## Duplication Policy

When the same subject appears in multiple places:

1. Keep one source of truth.
2. Convert the others into thin link pages or archive references.
3. Update indexes to point to the canonical source.
4. Avoid translating the same document into multiple naming variants unless the content is genuinely different.

## Index Strategy

Indexes should be shallow and predictable.

- Project indexes point to module, theme, and script indexes.
- Module and theme indexes point to current core docs plus clearly marked archives.
- Topic documents carry the detail.
- Archives stay discoverable, but never outrank active docs.

## Retrieval Order For Agents

When an agent needs context, read in this order:

1. `AGENTS.md`
2. relevant root index in `docs/`, `laravel/Modules/docs/`, `laravel/Themes/docs/`, or `bashscripts/docs/`
3. the target module or theme `README.md`
4. the specific topic file
5. archives only if the active docs do not answer the question

## Fast Audit

Use the audit script before adding or reorganizing documentation:

```bash
bash bashscripts/docs/audit-docs-governance.sh
```

The script surfaces:

- nested `docs/docs`
- lowercase `readme.md` duplicates
- non-canonical documentation directories
- multiple index entrypoints inside the same active docs root

## Zen

The repository gets better when each answer has a short path.
If finding the right file takes more effort than reading it, the documentation is already too noisy.
