---
title: "CONTRIBUTING"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "CONTRIBUTING"
issues: []
discussions: []
---

# Contributing to $MOD

## Development

```bash
cd laravel
composer dev
./vendor/bin/pest Modules/$MOD/tests
./vendor/bin/phpstan analyse Modules/$MOD --memory-limit=-1
```

## Before Submitting

- [ ] Tests pass
- [ ] PHPStan L10 passes
- [ ] Code style (Pint) applied
- [ ] Documentation updated

See ARCHITECTURE.md for design decisions.
