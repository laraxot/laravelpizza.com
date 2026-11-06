---
title: "Registration and Account Lifecycle Boundary"
type: concept
module: Gdpr
sources:
  - "../../../../../../bmad-output/registration-compliance-audit.md"
  - "../../../../../../bmad-output/stories/5.3.registration-consent-evidence.story.md"
  - "../../../../../../bmad-output/stories/5.5.subject-rights-account-lifecycle.story.md"
confidence: high
created: 2026-10-14
updated: 2026-10-14
tags: [gdpr, registration, consent, account-lifecycle, pa]
related:
  - "../../../../User/docs/wiki/concepts/auth-registration-verification-lifecycle.md"
  - "../../../../../Themes/Sixteen/docs/wiki/concepts/legal-consent-ui-boundary.md"
status: draft
qmd: "registration and account lifecycle boundary gdpr"
---

# Registration and account lifecycle boundary

## Ownership

`Modules/Gdpr` owns authenticated consent, treatment, revocation and evidence.
`Modules/User` owns identity, authentication and account state. The Sixteen theme
owns presentation only. Cookie preference remains an anonymous browser concern and
must not be stored as an authenticated registration consent.

## Current source of truth

- Registration evidence: `bmad-output/stories/5.3.registration-consent-evidence.story.md`.
- Marketing withdrawal: `bmad-output/stories/5.4.marketing-revocation.story.md`.
- Subject rights and closure: `bmad-output/stories/5.5.subject-rights-account-lifecycle.story.md`.
- Verification and locale policy: `bmad-output/stories/5.6.verified-registration-multilingual.story.md`.

These are implementation plans, not legal text. The Titolare/DPO must approve
document versions, legal bases, retention and the treatment of public tickets
before the release gate can pass.

## Invariants

1. Privacy acknowledgement and terms acceptance are required only when the approved
   registration policy says so, are separate from optional marketing consent, and are
   recorded with the accepted document version/hash and locale.
2. Marketing consent can be revoked without deleting the account and revocation must
   stop future marketing dispatches.
3. Account closure is a policy-driven lifecycle action. A raw `$user->delete()` is
   not sufficient when tickets, audit evidence or legal holds exist.
4. Every user-facing surface must link to the localized, published legal document;
   placeholders and invented legal claims are release blockers.

## Cross-boundary references

- [User authentication lifecycle](../../../../User/docs/wiki/concepts/auth-registration-verification-lifecycle.md)
- [Sixteen legal-consent UI boundary](../../../../../Themes/Sixteen/docs/wiki/concepts/legal-consent-ui-boundary.md)
- [BMAD registration audit](../../../../../../bmad-output/registration-compliance-audit.md)

