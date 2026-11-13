---
title: "Cms Head adoption plan for Sixteen"
type: bmad-plan
status: active
module: Cms
tags: [bmad, ecc, cms, head, laravel-head, sixteen, seo]
qmd: "cms head adoption plan sixteen laravel head parity seo"
related:
  - ../seo-head-architecture.md
  - ../stories/head-sixteen-layout-migration.story.md
  - ../stories/head-sixteen-parity-closeout.story.md
  - ../../../../Themes/Sixteen/docs/bmad/front-office-readiness-brainstorming.md
  - ../../../../Themes/Sixteen/docs/bmad/front-office-production-readiness-plan.md
  - ./filament-blueprint.md
---

# Cms Head adoption plan for Sixteen

## Purpose and audience

This plan is the Cms-owned contract for adopting the shared Head component in Sixteen. It is for Cms and theme maintainers coordinating an SEO/rendering change; the linked stories remain the execution records.

The goal is one metadata renderer using `laravel/head`, while preserving the approved Sixteen output and separating metadata policy from theme presentation. This plan records intended checks, not proof that current code or historical results pass.

## Ownership

| Concern | Owner | Boundary |
|---|---|---|
| Head component, metadata precedence, canonical/robots/hreflang/schema generation | Cms | Shared and testable component contract; no theme-specific scripts or CSS. |
| Layout adoption, branding, theme color, critical CSS, Alpine and visual parity | Sixteen | Supplies semantic context and theme behavior; does not duplicate SEO generation. |
| Ticket privacy/indexability and page-specific domain rules | Fixcity / product owner | Cms remains generic and receives project policy through supported configuration. |
| Login, session, role, and authorization expectations | User / owning module | Sixteen renders the journey but does not redefine authorization. |

Filament Blueprint applicability: **no Head-specific Resource or Builder is proposed**. The Cms Blueprint continues to govern `PageResource`, `SectionResource`, and `MenuResource`; Head behavior belongs to the Cms component/resolver contract. Sixteen owns no Filament Resource.

## Decision record

The linked story and [GitHub discussion #93](https://github.com/laraxot/theme_sixteen_fila5/discussions/93) record the PO-approved differences and remaining question:

| Decision | Recorded direction | State |
|---|---|---|
| D-1 Brand source | Use the Sixteen `FixCity` brand and correct tenant metatag data so placeholder branding cannot leak into titles or structured data. | Approved in existing story/discussion; implementation evidence must be rechecked. |
| D-2 Title separator | Preserve `|` and make the separator configurable rather than inheriting an unapproved formatting change. | Approved. |
| D-3 Project `noindex` paths | Keep project-specific paths/slugs in tenant policy, not hardcoded into generic Cms source. | Approved. |
| D-4 Public robots output | Accept the Cms public directive `index, follow, max-image-preview:large`. | Approved. |
| D-5 hreflang | Emit alternates only for written locales, as resolved by the shared contract. | Approved. |
| D-6 Layout scope | Migrate applicable Sixteen HTML shells; retain offline/standalone/test-only exceptions with documented reasons. | Scope recorded in existing story; verify the final layout inventory. |
| D-7 `noindex` canonical/hreflang | Decide whether to retain self-canonical/alternates on `noindex` pages or adjust the LG-03/LG-04 gate. | **Open; product-owner decision required before parity closeout.** |

Session-level process decisions: reuse the existing in-progress stories; do not create a duplicate story; preserve concurrent work; document before implementation; treat earlier measurements as historical until rerun. The PO selected all eight brainstorming methods, synthesized in the [Sixteen report](../../../../Themes/Sixteen/docs/bmad/front-office-readiness-brainstorming.md).

## Delivery sequence

| Wave | Deliverable | Owner | Exit evidence |
|---|---|---|---|
| 0 — Contract and baseline | Confirm owner boundaries, existing layout inventory, metadata fields and baseline for the same route/locale/state set. | Cms + Sixteen | Inventory and baseline are linked from the migration story; exceptions have an owner and rationale. |
| 1 — Cms contract | Verify title/brand precedence, description fallback, robots policy, query-aware canonical/hreflang, structured data and safe nullable behavior. | Cms | Focused Pest coverage and component-level rendered output; no change to unrelated theme-specific boot behavior. |
| 2 — Sixteen adoption | Use Cms Head in in-scope layouts and pass only semantic theme/page context; retain theme-only styles and scripts in correctly ordered stacks. | Sixteen | Layout inventory agrees with the story; `view:cache` and browser smoke checks cover guest/auth shells. |
| 3 — Difference review | Compare before/after Head output by field and route, including locales, paginated lists, private routes, error pages, and supported auth states. | Cms + Sixteen | Every difference is either approved in the decision record or fixed; D-7 resolved. |
| 4 — Closeout | Rerun owner tests and browser evidence, update owner docs and status, and link exact results. | Cms + Sixteen | No unresolved parity regression; skipped/blocked gates remain explicitly unverified. |

## Acceptance contract

- At most one effective title and description per document; metadata source and fallback are deterministic for localized and missing data.
- Robots policy matches the approved path/locale contract; private content is not made indexable by migration.
- Canonical, `og:url`, and hreflang preserve the approved locale and pagination semantics.
- Open Graph, Twitter, schema.org, icons, manifest, and theme-color differences are explicitly represented in the parity report.
- Theme-only critical CSS, dark-mode boot, and Alpine registration run in the correct document order without duplicate rendering.
- Cms tests prove relevant resolver/component behaviors; Sixteen browser evidence proves the integration. A successful build alone is insufficient.
- No parity or production-ready claim while D-7 or required route/state evidence remains open.

## Verification protocol

Run checks in the documented owner context. The exact focused Pest selectors and environment must be taken from the story and verified against the current tree. Record command, exit result, scope, environment, and output artifact. Never reuse a previous session's green result as current proof.

The existing migration story reports earlier diffs and tests; this plan does not independently validate those reports. The shared worktree contains concurrent changes, so inspect current ownership and locks before any implementation edit.

## Related discussion and execution records

- [GitHub discussion #93 — Head SEO decision differences](https://github.com/laraxot/theme_sixteen_fila5/discussions/93)
- [Migration story](../stories/head-sixteen-layout-migration.story.md)
- [Parity closeout story](../stories/head-sixteen-parity-closeout.story.md)
- [Theme readiness plan](../../../../Themes/Sixteen/docs/bmad/front-office-production-readiness-plan.md)
