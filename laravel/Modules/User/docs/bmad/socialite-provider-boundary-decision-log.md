---
title: "Socialite provider boundary — decision log"
type: decision-log
module: User
status: accepted
created: 2026-10-05
updated: 2026-10-05
related:
  - ./socialite-provider-boundary-product-brief.md
  - ./socialite-provider-boundary-prd.md
  - ./socialite-provider-boundary-architecture.md
  - ./stories/socialite-provider-boundary.story.md
---

# Socialite provider boundary — decision log

## [2026-10-05] Socialite config belongs to SocialiteServiceProvider

**Decision:** move the `services.*` credential merge for social providers out of `UserServiceProvider` and into `SocialiteServiceProvider`.

**Rationale:** `SocialiteServiceProvider` already owns SocialiteProviders registration and private admin Socialite config loading. Keeping the provider list and OAuth credential merge there preserves single responsibility and leaves `UserServiceProvider` focused on generic identity bootstrap.

**Guardrail:** no route, controller, action, config key, storage path, or package changes in this story.
