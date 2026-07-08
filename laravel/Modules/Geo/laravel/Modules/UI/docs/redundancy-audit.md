---
title: "UI redundancy audit 2026-05-21"
type: audit
module: UI
tags: [redundancy, components, config, design-system]
created: 2026-05-21
related:
  - https://github.com/laraxot/base_fixcity_fila5/issues/89
---

# UI redundancy audit 2026-05-21

High-risk findings:
- Config files exist in both `Config/` and `config/`, including `config.php`, `laravel-localization.php`, and `laravellocalization.php`.
- Many UI components are byte-identical with `Modules/User`, including `button`, `modal`, `input`, `checkbox`, `badge`, `link`, `nav-link`, `text-link`, `placeholder`, and marketing/layout components.
- Block stats are duplicated under both `archived/` and `superseded/`.
- Docs have case-only duplicates such as `ARCHITECTURE.md` and `architecture.md`, plus duplicate index variants.

Risk:
- UI should be the shared owner. Duplicating primitives in User makes fixes diverge.
- `Config/` vs `config/` is a case-only package portability problem.
- `archived`/`superseded` component folders are runtime-visible if Blade discovery includes them.

Suggested cleanup order:
1. Confirm service providers load lowercase `config/`, then remove uppercase mirrors in a separate issue.
2. Make `Modules/UI` the canonical owner for shared primitives; replace User copies with references or wrappers.
3. Move non-runtime old block variants out of runtime component discovery paths.
