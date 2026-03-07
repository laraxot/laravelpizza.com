# Docs Confidence Governance Rule

## Objective

Keep module/theme documentation trustworthy, navigable, and non-ambiguous for multi-agent execution.

## Mandatory controls

1. Every module/theme docs folder must keep these canonical anchors:
   - `00-index.md`
   - `README.md`
   - `docs-health.md`
2. Any new docs file must be linked from `00-index.md` in the same change.
3. Date-based markdown filenames are forbidden.
4. Duplicate variants must be explicitly deprecated and linked to canonical replacements.
5. Before major implementation work, refresh `docs-health.md` for impacted module/theme.

## Review gate

A docs update is considered high-confidence only if:

- canonical anchors exist,
- links resolve,
- obsolete variants are marked,
- maintenance action is recorded.

## Scope

- `laravel/Modules/*/docs`
- `laravel/Themes/*/docs`
