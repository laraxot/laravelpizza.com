# Reality Check — Stack table & Invariants (ARCHITECTURE-SPINE.md)

Date of check: 2026-07-07 (searches run same day)

## Verdict

Every package named in the Stack table is real, actively maintained, and the version numbers given are plausible/current as of mid-2026; no deprecated or abandoned dependency was found. One factual gap in the Invariants section (AD-4's "no deptrac config exists" note) is under-researched — deptrac is still the standard tool, but a lighter, native alternative (PHPArkitect) is worth naming as an option in the Deferred note.

## Stack table, item by item

| Name | Version in spine | Reality check |
| --- | --- | --- |
| PHP | ^8.2 | Fine — current LTS-adjacent floor for Laravel 12/Filament 5. No issue. |
| Laravel | ^12.0 | Correct, current major (Laravel 12 is the active release line in mid-2026). |
| Filament | ^5.0 | **Confirmed and current.** Filament v5 shipped 2026-01-16, specifically to support Livewire v4 (no unrelated new features — it's a compatibility major bump). Patch releases already exist (v5.2.0, 2026-02-05). ^5.0 is correct and not stale. |
| Livewire | ^4.0 | **Confirmed.** Livewire 4 officially released January 2026 (announced at Laracon US 2025, shipped the following January). Pairs correctly with Filament ^5.0, which requires it. |
| Laravel Folio | * (installato) | Still maintained; Volt's own composer.json requires `laravel/folio: ^1.1` as of its March 2026 release, confirming Folio is alive and compatible with the current Livewire/Volt versions. The spine's use of a bare `*` constraint is looser than ideal — recommend pinning to `^1.1` explicitly to match what Volt itself requires, rather than leaving it unconstrained. |
| Livewire Volt | * (installato) | **Confirmed maintained and Livewire-4-compatible**: Volt v1.10.5 (2026-03-18) requires `livewire/livewire: ^3.6.1|^4.0`. Worth flagging: Livewire 4 ships native single-file components, and multiple 2026 sources (e.g. "5 Reasons Laravel Developers No Longer Install Volt in 2026") argue Volt is now optional/redundant for new code. Since this project already depends on Volt for existing front-office pages, keeping it is fine, but the spine could note that *new* single-file components may not need Volt going forward — worth a one-line Deferred/consideration note if not already implicit elsewhere in the PRD.
| nwidart/laravel-modules | ^12.0 | Confirmed — package versioning tracks Laravel major versions; v12 branch is documented and targets Laravel 12. Correct. |
| spatie/laravel-data | 4.20.0 | Confirmed real, existing release (superseded by 4.21.0–4.23.0 as of the search, but 4.20.0 itself is a real, non-yanked version). Since the spine pins an exact version rather than a caret range, consider whether that's intentional (lockfile-driven) or should be `^4.20` for the doc to stay accurate as the project bumps patches — as written it will go stale immediately on the next `composer update`. |
| spatie/laravel-queueable-action | 2.17.0 | Confirmed real, released 2026-02-22, supports Laravel `^8.0` through `^13.0` (already forward-compatible past 12). Same exact-pin staleness risk as above. |
| mcamara/laravel-localization | v2.3.0 | Confirmed: v2.3.0 released 2025-02-26, explicitly supports Laravel `^10.0|^11.0|^12.0`. Correct and current; no red flags. |
| Tailwind CSS | 4.x | Reasonable — Tailwind v4 is the current major line; leaving it as `4.x` rather than an exact version is appropriate here since it's a frontend build dependency, not a Composer-locked package. |
| Alpine.js | (tema Meetup) | No version given at all — can't verify currency. Low risk (Alpine is stable/slow-moving), but if the other rows get exact versions, this row is inconsistent; either drop versions everywhere for parity or add Alpine's for completeness. |
| Pest | "test framework di progetto" | Not a version at all, just a label — can't reality-check. Not wrong, just an outlier in an otherwise version-pinned table. |

**Overall on the Stack table**: nothing is fake, deprecated, or mismatched. The one real inconsistency is exact-pin versions (spatie packages, mcamara) sitting next to wildcard/unversioned rows (Folio, Volt, Alpine, Pest) — this makes the table's precision uneven and the exact-pinned rows will silently go stale on the next dependency bump.

## Invariants & Rules — reality check

### AD-4 — "oggi non esiste alcun tooling — deptrac o regola phpstan — che le impedisca automaticamente"

This claim (no tooling exists in-repo to enforce the module dependency graph) is about the *current repo state*, not a technology claim, and is plausible as asserted — but the parenthetical naming of **deptrac** as *the* example tool deserves a check: is deptrac still the standard choice, or has something newer superseded it?

- **Deptrac is still actively maintained and remains the de facto standard** for PHP architectural boundary enforcement in 2026 (recent 2026 write-ups exist showing it used with Symfony 7 / DDD projects). It has not been superseded.
- However, an alternative worth naming exists and fits this project's style better: **PHPArkitect** — architectural constraints expressed as plain PHP code (fluent PHP API) rather than deptrac's YAML config. Given this project already leans toward PHP-native tooling (PHPStan level 10, custom Actions, no external DSLs), PHPArkitect is arguably a better fit to mention alongside deptrac in the Deferred note, since it avoids introducing a YAML-configured tool into an otherwise all-PHP quality toolchain.
- Minor alternatives found (Mondrian, PHP Architecture Tester, PhpDependencyAnalysis) are real but far less established — not worth naming in the spine.

**Recommendation**: in the Deferred section, change the deptrac-only mention to something like: *"Enforcement automatico dei confini tra moduli (deptrac, o in alternativa PHPArkitect per constraint espressi in PHP nativo, coerente con lo stack di quality tooling già PHP-first del progetto)"* — this keeps deptrac as the named default (still standard) while giving the team a same-ecosystem-fit option if they want to avoid adding a YAML-based tool.

### Other Invariants sections — spot check

- AD-1, AD-2, AD-3, AD-5, AD-6, AD-7, AD-8: these are all internal/codebase-verifiable claims (about this repo's own conventions), not claims about external technology currency, so they're out of scope for a "is this tech real/current" reality check — no external verification applies, and none of them made an implicit claim about tooling landscape the way AD-4 did.
- AD-6 asserts "nessuno dei tre [Breeze/Fortify/Jetstream] è nel progetto" — this is a repo-fact claim, not a technology-currency claim; not reality-checked here (would require inspecting composer.json, out of this task's scope).
- Deferred section's WCAG note and deployment note are explicitly flagged in the spine itself as open questions, not asserted facts — no issue.

## Top findings summary

1. All ten versioned Stack entries are real, current, non-deprecated packages; version numbers are accurate/plausible as of their check dates (spatie/laravel-queueable-action 2.17.0 released 2026-02-22, mcamara 2.3.0 released 2025-02-26 with explicit Laravel 12 support, Filament 5.0 released 2026-01-16, Livewire 4.0 released January 2026).
2. Filament ^5.0 + Livewire ^4.0 pairing is not just compatible but causally linked — Filament v5's entire purpose was to adopt Livewire v4, so this pairing in the spine is exactly right and internally consistent.
3. Livewire Volt is confirmed still maintained and Livewire-4-compatible (v1.10.5, March 2026), but multiple 2026 sources note Livewire 4's native single-file components make Volt optional for new code — worth a forward-looking note, not a correction.
4. The Stack table mixes exact-pinned versions (spatie/*, mcamara) with wildcard/unversioned rows (Folio `*`, Volt `*`, Alpine unversioned, Pest unversioned) — inconsistent precision, and the exact pins will go stale on the next `composer update` without a corresponding spine update.
5. AD-4's tooling parenthetical names only deptrac; deptrac is confirmed still the standard, but PHPArkitect (PHP-native constraint API, no YAML) is a better ecosystem fit for this project's already PHP-first quality tooling and is worth adding as a named alternative in the Deferred note.
