---
title: "boost rules"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< .merge_file_wmEfzS
updated: 2026-11-23
=======
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> .merge_file_87LlBW
qmd: "boost rules"
issues: []
discussions: []
---

=== boost rules ===

# Laravel Boost

- Laravel Boost is an MCP server that comes with powerful tools designed specifically for this application. Use them.

## Artisan

- Use the `list-artisan-commands` tool when you need to call an Artisan command to double-check the available parameters.

## URLs

- Whenever you share a project URL with the user, you should use the `get-absolute-url` tool to ensure you're using the correct scheme, domain/IP, and port.

## Tinker / Debugging

- You should use the `tinker` tool when you need to execute PHP to debug code or query Eloquent models directly.
- Use the `database-query` tool when you only need to read from the database.
- Use the `database-schema` tool to inspect table structure before writing migrations or models.

## Reading Browser Logs With the `browser-logs` Tool

- You can read browser logs, errors, and exceptions using the `browser-logs` tool from Boost.
- Only recent browser logs will be useful - ignore old logs.

## Searching Documentation (Critically Important)

- Boost comes with a powerful `search-docs` tool you should use before trying other approaches when working with Laravel or Laravel ecosystem packages. This tool automatically passes a list of installed packages and their versions to the remote Boost API, so it returns only version-specific documentation for the user's circumstance. You should pass an array of packages to filter on if you know you need docs for particular packages.
- Search the documentation before making code changes to ensure we are taking the correct approach.
- Use multiple, broad, simple, topic-based queries at once. For example: `['rate limiting', 'routing rate limiting', 'routing']`. The most relevant results will be returned first.
- Do not add package names to queries; package information is already shared. For example, use `test resource table`, not `filament 4 test resource table`.

### Available Search Syntax

1. Simple Word Searches with auto-stemming - query=authentication - finds 'authenticate' and 'auth'.
2. Multiple Words (AND Logic) - query=rate limit - finds knowledge containing both "rate" AND "limit".
3. Quoted Phrases (Exact Position) - query="infinite scroll" - words must be adjacent and in that order.
4. Mixed Queries - query=middleware "rate limit" - "middleware" AND exact phrase "rate limit".
5. Multiple Queries - queries=["authentication", "middleware"] - ANY of these terms.

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev

---

title: "boost rules"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "boost rules"
issues: []
discussions: []
## Cross-References

- ← [GEMINI Index](index.md) — All Gemini guidelines
- ← [Main AI Docs Index](../index.md) — Master index
- ← [GEMINI Index](index.md) — All Gemini guidelines
- ← [Main AI Docs Index](../index.md) — Master index
- ← [../../../../laravel/gemini.md](../../../../laravel/../../../../laravel/gemini.md) — Original source

<<<<<<< HEAD
=======
=======
## Cross-References
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
