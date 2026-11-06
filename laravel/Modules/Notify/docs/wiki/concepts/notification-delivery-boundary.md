---
title: "Notification Delivery Boundary"
type: concept
module: Notify
sources:
  - "../../../README.md"
  - "../../../00-INDEX.md"
confidence: high
created: 2026-10-14
updated: 2026-10-14
tags: [notify, notifications, delivery, user, gdpr, tenant]
related:
  - "../../../../User/docs/wiki/concepts/auth-registration-verification-lifecycle.md"
  - "../../../../Gdpr/docs/wiki/concepts/registration-account-lifecycle.md"
  - "../../../../Fixcity/docs/wiki/concepts/ticket-domain-and-public-flow-boundary.md"
status: draft
qmd: "notification delivery boundary notify"
---

# Notification delivery boundary

`Modules/Notify` owns notification delivery primitives, provider adapters and the
notification persistence schema. User and domain modules provide the recipient and
business event; they must not create competing notification tables or duplicate
provider policy.

## Consent and delivery

Transactional service notifications and optional marketing communications are
different streams. Gdpr owns the active marketing-consent decision and revocation;
Notify must evaluate that decision at dispatch time for every marketing producer.
Email templates must expose a safe preference/unsubscribe path where applicable.

## Operational evidence

For a release, document enabled channels, queue/retry behavior, provider errors,
recipient isolation and the test mailbox. Never put provider credentials or
personal data in the wiki.

## References

- [User authentication lifecycle](../../../../User/docs/wiki/concepts/auth-registration-verification-lifecycle.md)
- [Gdpr account/consent boundary](../../../../Gdpr/docs/wiki/concepts/registration-account-lifecycle.md)
- [Fixcity ticket flow](../../../../Fixcity/docs/wiki/concepts/ticket-domain-and-public-flow-boundary.md)

