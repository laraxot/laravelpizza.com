# GitHub Sync Queue - Chaos Hardening (2026-03-02)

Network access to GitHub API is currently unavailable from this environment.
Use this file to open issues/discussions once connectivity is restored.

## Proposed Issues

1. **[Notify] Harden optional Firebase/FCM dependencies in push flows**
- Scope: `SendPushNotification`, `SendPushNotificationPage`, `FirebaseAndroidNotification`
- Outcome: runtime guards + non-fatal behavior when optional SDK classes are missing

2. **[Media] Guard FFMpeg exporter API in ConvertVideoByConvertDataAction**
- Scope: avoid unsafe `save()` call assumptions
- Outcome: controlled exception path when exporter implementation differs

3. **[Tenant] Make morph map registration bootstrap-safe**
- Scope: `TenantServiceProvider::registerMorphMap()`
- Outcome: skip invalid class entries without blocking bootstrap/static analysis

4. **[Notify] Add missing MailTemplateVersionFactory for model/factory parity**
- Scope: `Modules/Notify/database/factories/MailTemplateVersionFactory.php`

## Proposed Discussions

1. **Chaos strategy for optional dependencies in modular Laraxot projects**
- Discuss pattern: `class_exists`/`method_exists` guards vs strict hard dependencies
- Target modules: Notify, Media, integrations with external SDKs

2. **Static analysis workflow under chaos injection**
- Discuss module-by-module PHPStan (`--debug --no-progress`) as first responder flow
- Include phpinsights usage with `--composer=composer.lock`
