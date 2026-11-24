---
title: "no app/Support — business logic in QueueableAction"
type: concept
tags: [user, actions, queueable-action, support, refactor]
created: 2026-07-12
updated: 2026-07-12
qmd: "User module no app Support business logic QueueableAction Otp Socialite Notification"
issues:
discussions:
related:
  - "./ai-harness-user-discipline.md"
  - "./baseuser-hierarchy.md"
  - "./code-redundancy-user.md"
  - "./context-mode-user-discipline.md"
  - "./context-overflow-prevention.md"
  - "./filament-langserviceprovider-governance.md"
  - "./filament-widget-linear-crud-model-create.md"
  - "./filament-widget-resource-form-delegation.md"
---

# no `app/Support/` — business logic in QueueableAction

## Scopo

Nel modulo User **non** esiste più `app/Support/`. Ogni helper con comportamento di dominio è una **Spatie QueueableAction** sotto `app/Actions/`.

## Migrazione (2026-07-12)

| Legacy `app/Support/` | Action / Data |
|----------------------|-------------|
| `Otp/Hasher` | `HashOtpValueAction`, `VerifyOtpHashAction`, `OtpHashNeedsRehashAction` |
| `Socialite/Utils/UserNameFieldsResolver` | `ResolveUserNameFieldsFromSocialiteAction` → `SocialiteNameFieldsData` |
| `Socialite/Utils/EmailDomainAnalyzer` | `AnalyzeSocialiteEmailDomainAction` → `SocialiteEmailDomainAnalysisData` |
| `NotificationSchema` | `IsNotificationSchemaReadableAction` |
| `AuthenticationLogQuery` | `GetAuthenticationLogQueryForAuthenticatableAction` |
| `Utils` (Shield) | `GetPermissionModelAction` (unico uso reale); resto dead code eliminato |

## Perché

- **Religione Laraxot:** no Services, no classi statiche di dominio sparse in `Support/`
- **Testabilità:** `app(FooAction::class)->execute()` + mock del costruttore
- **Coda:** stesso contratto sync/async con `QueueableAction`

## Eccezioni ammesse altrove

`app/Adapters/`, `app/Enums/`, facade puri — vedi [queueable-action-trait-mandatory](../../../../../../docs/wiki/rules/queueable-action-trait-mandatory.md). **Non** usare `Support/` per OTP, Socialite, notifiche o query autenticazione.

## Collegamenti

- [notifications-runtime-model.md](notifications-runtime-model.md)
- [queueable-action-trait-mandatory](../../../../../../docs/wiki/rules/queueable-action-trait-mandatory.md)
