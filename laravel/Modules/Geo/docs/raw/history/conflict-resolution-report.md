# Git Merge Conflict Resolution Report

## Summary

- **Total files resolved**: 200
- **Resolution strategy**: Keep HEAD/local (ours) side, discard upstream/theirs
- **Conflict types found**: `Updated upstream`/`Stashed changes`, `.merge_file_*`, `HEAD`/`origin/dev`, nested combinations
- **Validation**: All JSON files valid, all PHP files pass syntax check, zero conflict markers remain

## Root Cause

Nested conflicts from `git stash pop` applied on top of already-conflicted merge/rebase operations. The stash was applied AFTER a merge conflict was partially resolved, creating double-layered markers.

## Resolution Strategy

An AWK-based state machine strips all conflict markers while preserving the HEAD/local content (the "ours" side). For nested conflicts, the innermost HEAD content is kept.

```awk
BEGIN { skip = 0 }
{
    if (/^<<<<<<</) { next }
    if (/^=======$/) { skip = 1; next }
    if (/^>>>>>>>/) { skip = 0; next }
    if (!skip) print
}
```

## Files by Module

| Module | Files | Types |
|--------|-------|-------|
| User | 48 | PHP, JSON, MD, lang |
| UI | 48 | MD (docs) |
| Notify | 44 | PHP, JSON, MD |
| Xot | 14 | PHP, MD |
| Lang | 13 | PHP |
| Media | 8 | PHP |
| Job | 2 | MD |
| Activity | 2 | MD |
| Tenant | 1 | MD |
| Seo | 1 | MD |
| Rating | 1 | JSON |
| Incentivi | 1 | MD |
| Gdpr | 1 | MD |
| docs/root | 14 | MD, SH |

## Prevention

- Always resolve conflicts immediately during merge/rebase — never stash on top of unresolved conflicts
- Run `grep -rn "^<<<<<<<" . --include='*.php' --include='*.json' --include='*.md'` before committing
- Use `git rerere` to auto-remember conflict resolutions

## Per-Module Documentation

- [User](../laravel/Modules/User/docs/conflict-resolution.md)
- [UI](../laravel/Modules/UI/docs/conflict-resolution.md)
- [Notify](../laravel/Modules/Notify/docs/conflict-resolution.md)
- [Xot](../laravel/Modules/Xot/docs/conflict-resolution.md)
