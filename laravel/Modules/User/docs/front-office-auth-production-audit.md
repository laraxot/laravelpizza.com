---
title: "User front-office authentication production audit"
type: bmad-evidence
tags: [front-office, auth, verification, oauth, production]
---

# User front-office authentication production audit

The User module owns login, registration, email verification, password recovery, OAuth callbacks, logout and the authenticated session boundary used by Sixteen.

## Current evidence

- The verification page uses a reusable loading state on the resend action: disabled button, `aria-busy`, scoped Livewire target, visible status text and a Filament loading indicator.
- OAuth callback persistence queries `socialite_users` on the `user` connection. Deployment must run the User migrations against that connection before enabling Google or other providers.
- Email verification and password recovery must be tested with the configured non-placeholder sender domain; Mailtrap pending accounts reject cross-domain recipients.
- The isolated authenticated browser fixture used for the current front-office audit had
  `email_verified_at` populated, avoiding a false `/auth/verify` redirect. Login/session
  and protected-page accessibility checks passed locally; production OAuth tables and
  mail configuration still require the deployment read-only check below.
- Live guest smoke confirms `/it/auth/login` returns `200`, while `/it/auth/verify` and
  `/it/tickets/create` redirect unauthenticated visitors to login. The live accessibility
  gate is still blocked by the shared deployed footer markup, not by the auth pages'
  own form semantics.

## Release checklist

1. Test guest auth pages and authenticated redirects for all supported locales.
2. Test resend verification, logout, expired links, OAuth callback failure and successful callback with an isolated account.
3. Confirm `users.deleted_at` exists when the configured model uses `SoftDeletes`.
4. Confirm `socialite_users` exists on the `user` connection and that the production mail sender domain is verified by the provider.
