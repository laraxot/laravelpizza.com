---
title: "Quality Tools Usage (User)"
type: concept
tags: [quality, tools]
created: 2026-07-14
updated: 2026-07-14
qmd: "quality-tools quality tools usage (user)"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# Quality Tools Usage (User)

Module-specific guidance for PHPMD, PHP-CS-Fixer, Laravel Pint, Psalm, PHPQA, actionlint. Canonical reference: `Modules/Xot/docs/QUALITY_TOOLS.md`.

## Scope
- Analyze `Modules/User` only to avoid unintended global changes.
- Apply fixes in small, reviewed batches; prioritize auth-critical code safety.

## Safe Commands (Report/Dry-Run)
```bash
# PHPMD
vendor/bin/phpmd Modules/User text cleancode,codesize,design,naming,unusedcode --ignore-violations-on-exit

# Pint
vendor/bin/pint --test --preset laravel --path Modules/User

# PHP-CS-Fixer
vendor/bin/php-cs-fixer fix Modules/User --dry-run --diff --using-cache=yes

# Psalm
vendor/bin/psalm --no-cache --no-diff --show-info=true --paths=Modules/User

# PHPQA
vendor/bin/phpqa --analyzedDirs Modules/User --report --output build/phpqa-user --tools phpmd,phpcs,phpcpd --execution no-ansi
```

## Apply Changes (After Review)
```bash
vendor/bin/pint --path Modules/User
# or if needed
vendor/bin/php-cs-fixer fix Modules/User --allow-risky=no
```

## Notes
- After changes, verify: login, logout, 2FA flows, password change (`ChangeProfilePasswordAction`).
- Track suppressions with rationale and re-evaluation date.
- Align with `Modules/User/docs/ROADMAP.md` security tasks (2FA, Social Login, SSO).
