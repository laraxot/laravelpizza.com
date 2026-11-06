---
title: "Module and Theme Documentation Audit"
type: evidence
status: active
updated: 2026-10-14
tags: [documentation, audit, modules, themes, bmad, second-brain]
qmd: "module theme docs audit canonical index stale links registration gdpr user sixteen"
---

# Module and theme documentation audit

## Scope

This pass examined the documentation contract and the Gdpr, User and Sixteen
perimeters because they are the boundaries involved in registration, consent and
account closure.

## Verified findings

- The module/theme roots have the required `README.md` and `00-INDEX.md` entry
  points.
- The corpus contains multiple historical index variants (`index.md`, `INDEX.md`,
  `00-index.md`). They are not safe to merge automatically; the canonical role must
  remain explicit in each perimeter index.
- Gdpr, User and Sixteen already have LLM wiki structures, but some overview pages
  contain stale bootstrap statistics or generic claims that no longer describe the
  current corpus.
- Existing logs already record link-check limitations and stale documents. This
  audit adds focused cross-boundary pages instead of duplicating those reports.
- The canonical registration/account boundary is now documented in the three local
  wiki pages linked below and tied to BMAD stories 5.3–5.6.

## Canonicalization rules for the next passes

1. Do not delete or rename historical Markdown in bulk.
2. Update the owning `README.md`, `00-INDEX.md` and `wiki/log.md` before changing
   a page's status.
3. One concept has one canonical page; other copies become explicit historical or
   superseded references.
4. A claim about runtime behavior must cite a current code path or a dated test;
   a legal claim must cite approved Titolare/DPO evidence.
5. Every new page must have frontmatter, at least one verified outgoing link and an
   index entry.

## New canonical pages

- Gdpr: `laravel/Modules/Gdpr/docs/wiki/concepts/registration-account-lifecycle.md`
- User: `laravel/Modules/User/docs/wiki/concepts/auth-registration-verification-lifecycle.md`
- Sixteen: `laravel/Themes/Sixteen/docs/wiki/concepts/legal-consent-ui-boundary.md`

## Open work

- Audit each remaining module/theme one per pass.
- Reconcile broken links only when the target is unambiguous.
- Replace stale overview statistics with generated counts or dated evidence.
- Re-run QMD/Graphify after index corrections; do not treat Second Brain as proof
  that a file is current.

