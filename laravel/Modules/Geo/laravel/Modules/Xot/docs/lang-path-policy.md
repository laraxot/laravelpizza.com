# Xot Lang Path Policy

## Rule

For Laravel modules, translations must live in:

`Modules/Xot/lang/{locale}/*.php`

The path:

`Modules/Xot/lang/lang/{locale}/*.php`

must not exist.

## Why

- Laravel module translation loading already starts from the module `lang/` root.
- Adding a second `lang/` segment duplicates the filesystem namespace and creates two competing sources of truth.
- Generators, sync scripts, docs, and humans start reading and updating different files for the same translation key.
- The duplicate path hides drift: files may exist in both places with different contents.

## Operational Rule

- Keep `Modules/Xot/lang/{locale}` as the only writable translation tree.
- Never add `lang/lang/` to `.gitignore`: ignoring the wrong path normalizes the mistake instead of surfacing it.
- If `lang/lang/` appears, compare it with the canonical `lang/` tree, preserve any necessary content in the canonical files, then delete the duplicate subtree.

## 2026-03-12 Note

In `base_predict_fila5`, `Modules/Xot/lang/lang/` was present with no unique files, but with multiple divergent duplicates versus `Modules/Xot/lang/`. The canonical source of truth remains `Modules/Xot/lang/`.
