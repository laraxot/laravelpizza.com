---
title: "php rules"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< .merge_file_2egniz
<<<<<<< .merge_file_KGh6Sk
updated: 2026-11-23
=======
=======
>>>>>>> .merge_file_KUH8zs
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_2egniz
>>>>>>> .merge_file_V4Rn5H
=======
>>>>>>> .merge_file_KUH8zs
qmd: "php rules"
issues: []
discussions: []
---

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.

## Constructors

- Use PHP 8 constructor property promotion in `__construct()`.
    - `public function __construct(public GitHub $github) { }`
- Do not allow empty `__construct()` methods with zero parameters unless the constructor is private.

## Type Declarations

- Always use explicit return type declarations for methods and functions.
- Use appropriate PHP type hints for method parameters.

<!-- Explicit Return Types and Method Params -->
```php
protected function isAccessible(User $user, ?string $path = null): bool
{
    ...
}
```

## Enums

- Typically, keys in an Enum should be TitleCase. For example: `FavoritePerson`, `BestLake`, `Monthly`.

## Comments

- Prefer PHPDoc blocks over inline comments. Never use comments within the code itself unless the logic is exceptionally complex.

## PHPDoc Blocks

- Add useful array shape type definitions when appropriate.

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev

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
