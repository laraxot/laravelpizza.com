# Memory: Markdown Filenames Must Not Contain Dates

## Decision

Markdown files must never use dates in the filename.

## Rule

- Forbidden: `topic-2026-03-06.md`
- Allowed: `topic.md`, `topic-deep-dive.md`, `topic-root-cause.md`

## Why

- Stable links and references over time.
- Cleaner docs tree and easier search by topic.
- Avoid filename churn for iterative updates on the same document.

