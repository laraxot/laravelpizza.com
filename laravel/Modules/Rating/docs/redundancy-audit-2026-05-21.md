---
title: "Rating redundancy audit 2026-05-21"
type: audit
module: Rating
tags: [redundancy, livewire, views]
created: 2026-05-21
related:
  - https://github.com/laraxot/base_fixcity_fila5/issues/89
---

# Rating redundancy audit 2026-05-21

High-risk findings:
- Favorite Livewire views are byte-identical in multiple paths:
  - `resources/views/livewire/favorite2.blade.php`
  - `resources/views/livewire/favorite/favorite2.blade.php`
  - `resources/views/livewire/favorite/streamit.blade.php`
- `favorite.blade.php` and `favorite/default.blade.php` are also byte-identical.
- `admin/dashboard/item.blade.php` is duplicated with `Modules/Fixcity`.
- PHP CS Fixer config files duplicate common module boilerplate.

Risk:
- Livewire view resolution can drift when multiple files imply the same component intent.
- Dashboard item ownership between Rating and Fixcity is unclear.

Suggested cleanup order:
1. Identify Livewire component class/view mapping, then keep only the resolved view.
2. If dashboard item is generic, move to UI/Xot; if domain-specific, keep it in the owner module only.
