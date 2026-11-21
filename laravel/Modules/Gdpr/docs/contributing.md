---
qmd: "contributing"
issues: []
discussions: []
title: "Contributing"
type: documentation
tags: [gdpr, module]
created: 2026-10-06
updated: 2026-10-06
title: "Gdpr — contributing"
type: guide
module: Gdpr
updated: 2026-09-24
---

# Contributing to Gdpr

Migrato da `CONTRIBUTING.md` in root (2026-09-24).

## Development

```bash
cd laravel
composer dev
./vendor/bin/pest Modules/Gdpr/tests
./vendor/bin/phpstan analyse Modules/Gdpr --memory-limit=-1
```

## Before Submitting

- [ ] Tests pass
- [ ] PHPStan L10 passes
- [ ] Code style (Pint) applied
- [ ] Documentation updated

See [architecture](./architecture.md) for design decisions and [testing](./testing.md) for test patterns.
