---
title: "ridondanza codice — modulo User"
module: User
type: concept
tags: [redundancy, user, auth, passport, filament]
created: "2026-05-26"
updated: "2026-05-26"
related:
  - ../../../../Xot/docs/wiki/concepts/code-redundancy-philosophy.md
  - ../../../../Xot/docs/wiki/redundancy-audit-2026-05-26.md
  - ../../../redundancy-fixes.md
---

# Ridondanza — User

## Scopo

Identità, ruoli/permessi (Spatie teams), Passport OAuth, widget login/registrazione, profilo. È il **owner** dell’auth: ogni duplicato qui si propaga a tutti i temi.

## P0 — LoginWidget doppio

| File | Uso |
|------|-----|
| `Filament/Widgets/Auth/LoginWidget.php` | **Canonico** — registrato in `UserServiceProvider`, temi `@livewire` |
| `Filament/Widgets/LoginWidget.php` | Test (`LoginWidgetTest`) — **non** nel provider |

**Consiglio:** deprecare `Widgets/LoginWidget.php`; spostare test su `Auth\LoginWidget`. **Religione:** un solo widget login.

## P0 — alberi Filament duplicati

Risorse presenti sia in `Filament/Resources/` sia in `Filament/Clusters/Passport/` o `Clusters/Socialite/`:

- `OauthPersonalAccessClientResource`
- `SsoProviderResource`, `SocialProviderResource`, `SocialiteUserResource`

**Politica progetto:** cluster è la fonte; eliminare copie root per evitare doppia registrazione panel.

## P1 — RegisterWidget cross-modulo

`register.blade.php` può referenziare `Modules\Gdpr\...\RegisterWidget` mentre esiste `User\...\Auth\RegisterWidget`.

**Perplessità:** dipendenza intenzionale GDPR-first o debito da migrare?

## P1 — composer.json nel tree views

`resources/views/composer.json` con name `laraxot/theme-one` — **anomalia**; non appartiene al modulo User.

## P2 — documentazione

40+ file `passport-cluster*.md` / `oauth-cluster*.md` — consolidare in 1–2 pagine wiki + stub.

## Collegamenti

- [Filosofia](../../../../Xot/docs/wiki/concepts/code-redundancy-philosophy.md)
- [Audit 2026-05-26](../../../../Xot/docs/wiki/redundancy-audit-2026-05-26.md)
