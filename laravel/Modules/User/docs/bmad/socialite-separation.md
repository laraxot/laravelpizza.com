---
title: "Socialite separation from UserServiceProvider"
type: decision-log
module: User
status: active
related:
  - ./decision-log.md
  - ./architecture.md
---

# Decision: Separate Socialite logic

SocialiteServiceProvider (SocialiteProviders\Manager\ServiceProvider base) exists separately.
UserServiceProvider still references SocialLoginWidget / mergeSocialProviderCredentialsFromEnv.
Next: remove references from UserServiceProvider, keep in SocialiteServiceProvider.
DB: trade_data / trade_user created; connection 'user' added in config/database.php.
2026-10-05: profile id fix to be placed in Trade/migrations (not User). DB trade_user profiles.id char(36) NULL DEFAULT missing.
