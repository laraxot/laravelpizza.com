# Ponytail Docs Lifecycle

Theme docs should stay smaller than module docs.

## Canonical Shape

- `docs/index.md`: theme overview and links.
- `docs/wiki/`: durable design decisions.
- `docs/tasks/`: active implementation tasks.
- `docs/outputs/`: screenshots, generated reports, and temporary comparisons.

## Cleanup Rule

Keep only one active index. Merge duplicate `README.md`, `00-index.md`, and `INDEX.md` content into `docs/index.md`, then delete duplicates in the cleanup PR.

