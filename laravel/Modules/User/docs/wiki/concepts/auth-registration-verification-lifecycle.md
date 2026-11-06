---
title: "Authentication Registration and Verification Lifecycle"
type: concept
module: User
sources:
  - "../../../../../../bmad-output/registration-compliance-audit.md"
  - "../../../../../../bmad-output/stories/5.6.verified-registration-multilingual.story.md"
confidence: high
created: 2026-10-14
updated: 2026-10-14
tags: [user, auth, registration, email-verification, localization]
related:
  - "../../../../Gdpr/docs/wiki/concepts/registration-account-lifecycle.md"
  - "../../../../../Themes/Sixteen/docs/wiki/concepts/legal-consent-ui-boundary.md"
status: draft
qmd: "authentication registration and verification lifecycle user"
---

# Authentication registration and verification lifecycle

## Ownership

`Modules/User` owns identity creation, authentication, verification state and
account access. `Modules/Gdpr` owns the consent evidence attached to registration;
the theme renders the form and messages without owning policy.

## Verified flow

The enabled locale list, registration route, verification route, notification and
profile redirects must describe the same contract. When email verification is
required, successful creation must not grant fully verified access before the
signed verification flow completes. Resend and expired-link states need throttling,
localized feedback and a safe recovery path.

The current implementation points requiring story work are:

- `laravel/Modules/User/routes/web_tall.php` has a locale allow-list that must be
  reconciled with the enabled translations;
- the registration success action currently has login semantics that must be
  conditional on the approved verification policy;
- production mail relay configuration must be explicit without committing secrets.

## Boundary rules

- Never duplicate consent persistence in User; call the Gdpr-owned action.
- Never treat a cookie preference as proof of identity or registration consent.
- Never expose protected profile or ticket flows to an unverified account unless the
  approved service policy explicitly permits that flow.
- Keep route and translation changes localized to the User/theme boundary; link to
  the Gdpr page for treatment and evidence semantics.

## References

- [Gdpr registration and account boundary](../../../../Gdpr/docs/wiki/concepts/registration-account-lifecycle.md)
- [Sixteen legal-consent UI boundary](../../../../../Themes/Sixteen/docs/wiki/concepts/legal-consent-ui-boundary.md)
- [BMAD verification story](../../../../../../bmad-output/stories/5.6.verified-registration-multilingual.story.md)

