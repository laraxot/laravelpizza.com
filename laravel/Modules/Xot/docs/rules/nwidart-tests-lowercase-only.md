---
title: "Nwidart tests directory convention: lowercase only"
type: note
status: unverified
created: 2026-10-20
updated: 2026-10-20
module: Xot
tags: [xot, rules]
qmd: "Nwidart tests directory convention: lowercase only"
---
# Nwidart tests directory convention: lowercase only

**Status:** mandatory

The directory for module-owned tests is lowercase:
`laravel/Modules/<Module>/tests/`.

```text
CORRECT: laravel/Modules/Xot/tests/
WRONG:   laravel/Modules/Xot/Tests/
```

The module's namespace, bootstrap and composer/Pest configuration must agree
with that boundary. Do not infer ownership from directory case alone and do not
delete an existing tree automatically; inspect it first.

```bash
find Modules/Xot/tests -type f -name '*Test.php' | head -3
test ! -d Modules/Xot/Tests
```

For the complete ownership rule, see
`module-test-ownership.md` in this directory.
