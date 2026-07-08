# Ponytail-audit 2026-07-02: Xot module findings

Source: repo-wide ponytail-audit, published as GitHub issues [#100](https://github.com/laraxot/base_quaeris_fila5/issues/100), [#102](https://github.com/laraxot/base_quaeris_fila5/issues/102) and [#111](https://github.com/laraxot/base_quaeris_fila5/issues/111), summarized in discussion [#114](https://github.com/laraxot/base_quaeris_fila5/discussions/114).

## Findings

- **#100 (yagni/delete):** 856 `.gitkeep`-only scaffold directories across the repo (many under Xot's `Repositories/`, `Interfaces/`) with no real code. Delete unused scaffold directories rather than keeping them "for later". ✅ Status: directories deleted in previous passes.
- **#102 (yagni):** 19 Contracts in `Modules/Xot/app/Contracts/` (`ProfileContract`, `ModelContract`, `PivotContract`, etc.) each have exactly one concrete Eloquent implementer. Bind directly to the concrete model/trait instead of introducing a contract with no swap-need. ✅ Status: dead contracts removed; remaining contracts (`ExtraContract`, `HasRecursiveRelationshipsContract`, `ModelContract`, `PdfBuilderContract`, `ProfileContract`, `StateContract`, `UserContract`) are actively used in the codebase.
- **#111 (yagni):** `app/Providers/VoltServiceProvider.php` and `FolioServiceProvider.php` are registered in the base app even though the app is otherwise fully modular via `nwidart/laravel-modules`. Needs confirmation whether Volt/Folio pages actually exist before removing. ✅ Status: providers already removed in previous passes.
- **#X9 (delete):** `app/Http/Livewire/XotBaseComponent.php` had zero useful extends and duplicated Livewire's `Component`. ✅ Status: removed in this session; `Modules\Quaeris\Http\Livewire\QuestionChart` now extends `Livewire\Component` directly.

## Guidance for future Xot contracts/interfaces

Per ponytail YAGNI rung: **add an interface/contract only when there are two concrete consumers that need the same boundary.** A single implementer is a class, not an architecture decision — the interface can always be extracted later when a second implementation actually appears (this is a cheap, mechanical refactor; keeping speculative interfaces around is not free, it adds indirection every reader has to trace through).

This mirrors the same principle already applied to `Modules/Quaeris/app/Contracts/FormContract.php` and `MixedQuestionActionContract.php` in the (still unpublished) prior audit pass — see `docs/wiki/ponytail-audit-github-backlog.md` items #5 and #6.

## Related

- Discussion #114: full 14-item audit summary.
- Discussion [#120](https://github.com/laraxot/base_quaeris_fila5/discussions/120): stato globale 2026-07-02 (repo root).
- Discussion [#55](https://github.com/laraxot/module_xot_fila5/discussions/55): stato Xot 2026-07-02 (repo modulo).
- Discussion [#46](https://github.com/laraxot/module_user_fila5/discussions/46): BaseUser trait consolidation (repo modulo).
- Discussion [#74](https://github.com/laraxot/module_geo_fila5/discussions/74): Geo provider consolidation (repo modulo).
- `docs/wiki/ponytail-audit-github-backlog.md`: earlier, broader audit pass (Meetup/Seo scaffold modules, docs sprawl, shadow files) — not yet published, no overlap with #100-#113.
- Known doc-sprawl debt in this module (discussion #22) is out of scope here; `Modules/Xot/docs/` still has duplicate `README.md`/`readme-new.md`/`index.md`/`index-v2.md`/`INDEX.md` entrypoints pending consolidation.
