---
title: "merge conflict marker cleanup"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< .merge_file_mdz7yQ
updated: 2026-11-23
=======
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> .merge_file_7JZ85e
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

<<<<<<< .merge_file_mdz7yQ
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> .merge_file_7JZ85e
## Sessione docs Cms+Geo 2026-11-23

- **Cms/docs**: 58 file `.md` ripuliti; preferenza lowercase nei link; FO = sempre Filament styles/scripts.
- **Geo/docs**: 56 file `.md` ripuliti; solo geocoding/mappe, senza nuove architetture.
- Coordinamento aggiornato: [cms-merge-conflict-resolution.story.md](./stories/cms-merge-conflict-resolution.story.md), [quality-gate-closure.story.md](../../Geo/docs/stories/quality-gate-closure.story.md).

## Verification

```bash
# token: conflict start / mid / end (7 caratteri ciascuno)
/bin/grep -rE '^<{7}|^={7}|^>{7}' laravel/Modules/Cms/docs --include='*.md'
/bin/grep -rE '^<{7}|^={7}|^>{7}' laravel/Modules/Geo/docs --include='*.md'
# atteso: 0 righe per entrambi
<<<<<<< .merge_file_mdz7yQ
=======
=======
>>>>>>> laraxot/dev
>>>>>>> .merge_file_7JZ85e
## Verification

```bash
/bin/grep -rIln --exclude-dir=vendor '^<<<<<<< ' Modules/Cms
find Modules/Cms -name '*.php' ! -name '*.blade.php' -print0 | xargs -0 -n1 php -l
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
```

Vedi anche: [no-conflict-markers-anywhere](../../../../docs/rules/no-conflict-markers-anywhere.md),
story [ROOT-17.14](../../../../docs/stories/17-14-phpstan-modules-merge-markers-prerequisito.md).
<<<<<<< .merge_file_mdz7yQ
=======

>>>>>>> .merge_file_7JZ85e
