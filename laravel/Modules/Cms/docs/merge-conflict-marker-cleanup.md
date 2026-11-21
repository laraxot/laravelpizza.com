---
title: "merge conflict marker cleanup"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "merge conflict marker cleanup"
issues: []
discussions: []
---

# Merge Conflict Marker Cleanup

## Perché

I marker di merge committati nei `.php` rompono il bootstrap (ParseError) e
mascherano il gate PHPStan. Nei `.md` avvelenano il second brain.

## Sessione ROOT-17.14 (2026-08-25)

Risolti ~300 file Cms (PHP + docs). Pattern tipici:

- indentazione 3 vs 4 spazi (whitespace-only → PSR-12)
- conflitti **annidati** (marker dentro un lato)
- `$schema` duplicato dopo unwrap incompleto → tenuto `protected array $schema`

Verifica: `php -l` su tutti i `.php` non-blade; `analyse Modules` a zero.

## Verification

```bash
/bin/grep -rIln --exclude-dir=vendor '^<<<<<<< ' Modules/Cms
find Modules/Cms -name '*.php' ! -name '*.blade.php' -print0 | xargs -0 -n1 php -l
```

Vedi anche: [no-conflict-markers-anywhere](../../../../docs/rules/no-conflict-markers-anywhere.md),
story [ROOT-17.14](../../../../docs/stories/17-14-phpstan-modules-merge-markers-prerequisito.md).

