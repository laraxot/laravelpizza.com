---
title: "php rules"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
qmd: "php rules"
issues: []
discussions: []
---

=== php rules ===

## PHP

- Always use curly braces for control structures, even if it has one line.

### Constructors
- Use PHP 8 constructor property promotion in `__construct()`.
    - <code-snippet>public function __construct(public GitHub $github) { }</code-snippet>
- Do not allow empty `__construct()` methods with zero parameters.

### Type Declarations
- Always use explicit return type declarations for methods and functions.
- Use appropriate PHP type hints for method parameters.

<code-snippet name="Explicit Return Types and Method Params" lang="php">
protected function isAccessible(User $user, ?string $path = null): bool
{
    ...
}
</code-snippet>

## Comments
- Prefer PHPDoc blocks over comments. Never use comments within the code itself unless there is something _very_ complex going on.

## PHPDoc Blocks
- Add useful array shape type definitions for arrays when appropriate.

## Enums
- Typically, keys in an Enum should be TitleCase. For example: `FavoritePerson`, `BestLake`, `Monthly`.



---

title: "php rules"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "php rules"
issues: []
discussions: []
## Cross-References

- ← [CLAUDE Index](index.md) — All Laravel Boost guidelines
- ← [Main AI Docs Index](../index.md) — Master index
- ← [CLAUDE Index](index.md) — All Laravel Boost guidelines
- ← [Main AI Docs Index](../index.md) — Master index
- ← [../../../../docs/CLAUDE.md](../../../../docs/../../../../docs/CLAUDE.md) — Original source

