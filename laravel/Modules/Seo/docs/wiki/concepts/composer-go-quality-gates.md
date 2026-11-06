---
qmd: "composer go quality gates"
issues: []
discussions: []
title: "composer go + quality gates — Seo"
type: concept
module: Seo
tags: [composer, quality-gates, lock, pest]
created: 2026-07-24
updated: 2026-07-24
related:
  - ./metatag-data-contract.md
  - ./phpstan-compliance.md
  - ../../../../../../bashscripts/docs/composer-go-agent-safe.md  # target mancante, verificato 2026-10-08
  - ../../../../../../bashscripts/docs/lock-system.md  # target mancante, verificato 2026-10-08
status: active
---

# Seo — post `composer go` (verificato)

## Gate 2026-07-24 (da `laravel/`)

| Gate | Esito |
|------|--------|
| PHPStan `Modules/Seo` (+ Xot widgets) | OK 0 errors |
| Pest `Modules/Seo/tests` | **33 passed** |
| PHPMD (ruleset `Modules/Seo/phpmd.ruleset.xml`) | OK |
| PHPInsights | style residui (line length / architecture final) — non blocking |
| `view:cache` | EXIT 0 |
| HTTP smoke `artisan serve :8010` | `/` → 302, `/it` → **200** |
| Playwright MCP | **N/A** (server non in MCP catalog) |
| Playwright CLI screenshot | richiede `npx playwright install chromium` se browser mancante |

## Fix applicati (con lock)

- `MetatagManager`: rimosso `use Metatag` inutilizzato (`@see` FQCN)
- `SocialShareData` / `EventServiceProvider`: braces stile Insights su metodi vuoti

## Lock

`bash bashscripts/lock/{check,lock,unlock}.sh laravel/Modules/Seo/app/...`
