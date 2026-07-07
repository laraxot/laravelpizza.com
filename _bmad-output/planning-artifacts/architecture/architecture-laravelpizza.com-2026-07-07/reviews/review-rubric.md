# Rubric Review — ARCHITECTURE-SPINE.md (LaravelPizza)

Reviewed: `_bmad-output/planning-artifacts/architecture/architecture-laravelpizza.com-2026-07-07/ARCHITECTURE-SPINE.md`
Method: good-spine checklist from `.claude/skills/bmad-architecture/references/reviewer-gate.md`, cross-checked against the live codebase at `/var/www/html/_bases/laravelpizza.com`.

## Verdict

CONDITIONAL PASS — the spine is well-formed and mostly accurate, but one Deferred entry materially misstates the state of the brownfield codebase (a scope-of-fact error, not a style nit), and one AD's enforceability is weaker than claimed. Fix both before handoff.

---

## 1. Does it fix the real divergence points, and miss none?

The 8 ADs cover the divergence points that actually matter for a modular-monolith + Folio/Volt/CMS-JSON + Filament/XotBase brownfield: routing discipline (AD-1), Filament extension discipline (AD-2), business-logic placement (AD-3), module dependency direction (AD-4), CMS trust model (AD-5), auth mechanism (AD-6), tenant resolution (AD-7), migration philosophy (AD-8). These map directly onto the "Common Pitfalls to Avoid" list in `CLAUDE.md`, which is the right target for an initiative-altitude spine on a project with 400+ pre-existing `.cursor/rules`.

**Gap found:** the Consistency Conventions table lists `belongsToManyX()`, translation-key prefixing, SVG icon handling, localization URL helpers, strict typing, and Service Provider minimal structure — all pulled from CLAUDE.md — but only as a table row, not as an AD with Binds/Prevents/Rule. That's a defensible altitude call (these are lower-severity style conventions, not divergence points that break the architecture), so it is not scored as a missed AD, but it means these conventions rely on Pint/PHPStan and code review rather than an enforceable invariant. Acceptable, not ideal — no fix required, flagged as a low-severity note only.

No divergence point in CLAUDE.md's "Critical Architecture Rules" section (0–4) is left uncovered by the spine: theme resolution (0) → not covered by an AD or convention row. **This is a real miss.** Theme resolution (`APP_URL` → tenant folder → `xra.php:pub_theme` → `Themes/{Theme}`) is called out in CLAUDE.md as CRITICAL and has its own `.cursor/rules/theme-resolution-critical.md` — it is exactly the kind of "how do two engineers each build a page and land in different runtimes" divergence this spine altitude should own. It is absent from both the AD list and the Structural Seed narrative (the Structural Seed hardcodes `Themes/Meetup/` without explaining *why* that's the resolved theme, which will read as an assumption rather than a resolved mechanism to a new contributor).

**Finding (Medium): Theme-resolution mechanism (CLAUDE.md §0) has no AD.** Add an AD binding `Modules\Tenant` + `pub_theme` config, mirroring the structure of AD-7 (which already documents the sibling tenant-resolution mechanism). Without it, a future module could hardcode `Themes/Meetup` or introduce a second theme-selection path without violating any stated invariant.

## 2. Is every AD's Rule enforceable, and does it prevent its stated divergence?

Spot-checked each:

- **AD-1** (no controllers in front-office): enforceable by code review / grep for `Route::` in `web.php`; Rule text is concrete (JSON path + Blade component path). Prevents the stated divergence. OK.
- **AD-2** (XotBase mandatory): enforceable via `extends` clause inspection; matches CLAUDE.md's table exactly. OK.
- **AD-3** (Actions only, domain exceptions not return-false): enforceable, and cites real files (`RegisterAttendeeToEventAction`, `RegisterWidget::submit()`) — verified both exist (see §5). OK.
- **AD-4** (dependency direction): the Rule is a graph plus a manual escape hatch ("richiede un aggiornamento esplicito di questo AD"). This is **honest but weakly enforceable** — the AD itself admits no tooling (deptrac/phpstan) enforces it today, and defers that tooling to "Deferred". A Rule that depends entirely on manual discipline with no CI gate is a soft invariant. Spot-checked: `Modules/Cms` has zero `Modules\Meetup` references today (confirms the graph is currently true), so the AD is *accurate*, but not yet *self-enforcing*.
  **Finding (Low): AD-4 enforceability gap is already self-disclosed and deferred appropriately** — not a defect, but worth noting it's the one AD whose "Prevents" clause is aspirational rather than mechanical until the deferred tooling lands.
- **AD-5** (JSON as trusted input, no registry): enforceable in the negative sense (nothing to check), and the escape clause ("solo finché...") is a legitimate conditional invariant. OK.
- **AD-6** (custom auth, no Breeze/Fortify/Jetstream): enforceable via composer.json absence check. OK.
- **AD-7** (tenant resolution only at boot): enforceable via review of `TenantServiceProvider`. OK.
- **AD-8** (one table one migration): enforceable via filename convention grep. OK.

## 3. Could anything under Deferred let two units diverge?

Three of the five Deferred items are correctly deferred (CMS registry, deptrac tooling, WCAG threshold) — each has an explicit trigger condition for when it must be revisited, which is the right shape for "deferred, not silent."

**Deployment & environments** deferral: acceptable given the project is genuinely local-only today (`APP_ENV=local`, no CI/CD, no hosting decision made) and the PRD already carries this as an open question (§8, Domanda Aperta #2). Deferring an operational dimension that has *zero* current instances to diverge over is legitimate — there's nothing yet for two engineers to do differently. This satisfies the checklist's "decided/deferred/open" requirement; it is not the "silent because domain-focused draft skipped it" failure mode the checklist warns about, since it's explicitly named and reasoned about.

**Finding (Critical): the "Bug non correlato" Deferred entry misstates the actual state of the codebase, and misdirects the fix.** The entry reads: *"`register.blade.php` contiene marker di conflitto Git non risolti"* (singular file). Verification:
- `laravel/Themes/Meetup/resources/views/pages/auth/register.blade.php`, `laravel/Modules/User/resources/views/**/register.blade.php`, and every other `register.blade.php` found in the tree contain **no** `<<<<<<<` markers.
- Unresolved Git conflict markers (`<<<<<<<`, presumably also `=======`/`>>>>>>>`) actually exist in **408 files** across `laravel/Modules/**` (278 outside `tests/`), including core framework files like `Modules/Xot/app/Providers/XotBaseServiceProvider.php`, `Modules/Xot/app/Models/XotBaseModel.php`, `Modules/Xot/app/Database/Migrations/XotBaseMigration.php`, `Modules/Cms/resources/views/components/page.blade.php`, and dozens of Filament Resource/Table/Form files.
- This is not a cosmetic difference: if these markers are real (not a grep false-positive on heredoc syntax — spot-checked `Helper.php` and `page.blade.php`, both show literal `<<<<<<< HEAD` conflict blocks), the codebase may not currently be in a compilable/working state, which is a direct contradiction of a spine whose purpose is to "ratify" the current brownfield baseline. At minimum the scope described (1 file) vs. actual scope (hundreds of files, including files the spine's own Rules cite as canonical, e.g. `XotBaseMigration`) is wrong by roughly three orders of magnitude, and undersells something that could block every other AD's "current state" claims (AD-2, AD-3, AD-8 all point at XotBase files that are themselves conflict-marked).
  **Action:** re-verify scope with `grep -rl '<<<<<<<' laravel/Modules laravel/Themes` before finalizing, correct the Deferred entry's description and scope, and consider whether this blocks treating the codebase as a reliable "ratification" baseline at all — several files the spine cites as authoritative examples of AD-3/AD-8 patterns are themselves in this list.

## 4. Named tech verified-current

Checked against `laravel/composer.lock` (installed, locked versions — most accurate ground truth available):

| Spine claim | composer.json constraint | composer.lock resolved | Verdict |
|---|---|---|---|
| Laravel ^12.0 | ^12.0 | v12.53.0 | OK, real & current major |
| Filament ^5.0 | ^5.0 | v5.3.2 | OK — Filament 5 is real (released 2025) |
| Livewire ^4.0 | ^4.0 | v4.2.1 | OK — Livewire 4 exists |
| Folio (installed) | `*` | v1.1.13 | OK |
| Volt (installed) | `*` | v1.10.3 | OK |
| nwidart/laravel-modules ^12.0 | ^12.0 | v12.0.4 | OK |
| spatie/laravel-data 4.20.0 | Xot module: ^4.7 | 4.20.0 | Matches lock exactly — spine pins the resolved version, not the constraint; acceptable, technically accurate |
| spatie/laravel-queueable-action 2.17.0 | Xot module: ^2.16 | 2.17.0 | Same as above — accurate |
| mcamara/laravel-localization v2.3.0 | Lang module: `*` | v2.3.0 | Accurate |

No fabricated or non-existent packages/versions found. All are real, current packages as of the stated ecosystem (Laravel 12 / Filament 5 / Livewire 4 is the current major generation as of 2025-2026). No web verification needed beyond the lockfile since the lockfile is ground truth for "what's actually installed," which is a stronger check than "is this real on the internet." No finding here.

## 5. Ratifies vs. contradicts the brownfield codebase

Cross-checked against `CLAUDE.md` and cited files:

- `laravel/Modules/Meetup/app/Actions/Event/RegisterAttendeeToEventAction.php` — **exists**, matches AD-3's citation.
- `Modules\Cms\View\Components\PageContent` — referenced in Design Paradigm section; not independently re-verified in this pass beyond confirming `Modules/Cms` exists and has no Meetup coupling (supports AD-4's Cms row).
- AD-4's graph was spot-checked: `Modules/Cms` composer.json/app code has zero `Modules\Meetup` references — the "Cms does not depend on Meetup" claim holds today.
- All "Common Pitfalls to Avoid" (1–14) in CLAUDE.md map to an AD or Convention row except **theme resolution** (CLAUDE.md §0, listed as "CRITICAL" ahead of even the numbered pitfalls) — see Finding in §1. This is the one place the spine is silent where CLAUDE.md is loud.
- The conflict-marker Deferred entry (§3 above) is the one place the spine actively **contradicts** the codebase's real state rather than ratifying it.

Aside from those two items, the spine's architectural claims (Folio+Volt+JSON, XotBase mandatory, Actions-only, belongsToManyX, one-table-one-migration, custom auth, boot-time tenant resolution) all match CLAUDE.md verbatim or near-verbatim — it is derived from CLAUDE.md rather than inventing new policy, which is the correct posture for ratifying a brownfield project.

## 6. Every dimension this altitude owns: decided / deferred / open?

- Design paradigm: decided.
- Module boundaries & dependency direction: decided (AD-4), with honest enforcement caveat.
- Front-office rendering model: decided (AD-1, AD-5).
- Admin extension model: decided (AD-2).
- Business logic placement: decided (AD-3).
- Auth: decided (AD-6).
- Multi-tenancy: decided (AD-7).
- Schema/migration philosophy: decided (AD-8).
- Deployment & environments: explicitly deferred with rationale — acceptable for a local-only project per §3 above.
- Theme selection mechanism: **silent** — not decided, not deferred, not listed as open. This is the one dimension-left-silent finding (see §1).
- Testing strategy / CI gates for the ADs themselves (e.g., how AD-4 gets enforced, how PHPStan level 10 is gated): mentioned in Consistency Conventions ("PHPStan livello 10 come gate di qualità") but not tied to a CI/CD invariant — acceptable since deployment/CI is explicitly deferred as a package.

---

## Summary of Findings

| # | Severity | Title |
|---|---|---|
| 1 | Critical | "Bug non correlato" Deferred entry wrongly scopes unresolved Git conflict markers to one file (`register.blade.php`, which is clean) when 278-408 files across `Modules/**` — including files the spine cites as canonical (XotBase* core files) — actually contain unresolved `<<<<<<<` markers. Misstates brownfield baseline; may invalidate the "ratifies current codebase" claim for several ADs. |
| 2 | Medium | Theme-resolution mechanism (CLAUDE.md §0, marked CRITICAL) has no AD and isn't mentioned anywhere in the spine, despite being the one theme/runtime-selection mechanism a new module could easily bypass or hardcode around. |
| 3 | Low | AD-4 (module dependency direction) is accurate today but self-admittedly unenforced by tooling; its "Prevents" clause is aspirational until the deferred deptrac/phpstan check lands — flagged for awareness, not a defect since it's already disclosed. |
| 4 | Low | Consistency Conventions (belongsToManyX, SVG handling, translation keys, localization URLs, strict typing, Service Provider structure) are documented as a table, not as enforceable ADs with Binds/Prevents/Rule — acceptable altitude call but means they rely purely on Pint/PHPStan/review. |

## Recommended fixes before handoff

1. Re-run `grep -rl '<<<<<<<' laravel/Modules laravel/Themes laravel/resources` (excluding `tests/` if desired), confirm true scope, and rewrite the Deferred bullet to reflect it — including whether this blocks the spine's "ratifies brownfield" premise for any AD that cites now-conflict-marked files as canonical examples.
2. Add AD-9 (or fold into AD-7) for theme resolution: Binds `Modules\Tenant` + `config/local/{tenant}/xra.php:pub_theme`; Prevents hardcoding `Themes/Meetup` in new code; Rule: resolve theme exclusively via `pub_theme` config key, per `.cursor/rules/theme-resolution-critical.md`.
