---
title: "Alberi Filament OAuth duplicati (Passport + Socialite)"
type: redundancy
owner: Modules/User
severity: high
created: 2026-05-22
issues:
related:
  - "./duplicated-auth-widgets.md"
  - "./duplicated-profile-form.md"
  - "./duplicated-ratings-relation-manager.md"
  - "./duplicated-users-relation-manager.md"
---

# OAuth: cluster vs `Filament/Resources/` root

## Scopo

Il modulo User espone **due alberi** per le stesse risorse OAuth: standalone in `app/Filament/Resources/` e cluster in `Clusters/Passport/` e `Clusters/Socialite/`.

## Passport (5+1 risorse)

| Risorsa | Standalone | Cluster |
|---------|------------|---------|
| OauthClient | `Resources/OauthClientResource.php` | `Clusters/Passport/Resources/...` |
| OauthAccessToken | idem | idem |
| OauthAuthCode | idem | idem |
| OauthRefreshToken | idem | idem |
| OauthPersonalAccessClient | idem | idem |
| OauthDeviceCode | — | solo cluster |

Ogni coppia include **Form, Table, Infolist** duplicati sotto `Schemas/` e `Tables/`.

**Nota:** `OauthClient` standalone può usare `Laravel\Passport\Client` mentre il cluster usa `Modules\User\Models\OauthClient` — rischio **schema diverso**, non solo path duplicato.

## Socialite (3 risorse)

- `SsoProviderResource`, `SocialProviderResource`, `SocialiteUserResource` — stesso pattern root ↔ `Clusters/Socialite/`.

`UsersRelationManager` duplicato su `SsoProvider` (root + cluster).

## Impatto

- Doppia voce menu / doppio CRUD se entrambi registrati.
- Manutenzione form OAuth ×2 per ogni modifica policy.

## Fix suggerito

1. **SSoT:** solo `Clusters/Passport` e `Clusters/Socialite`.
2. Deprecare `Filament/Resources/Oauth*` e `SsoProvider*` root (rimozione dopo grep panel provider).
3. Form condivisi in `app/Filament/Forms/Schemas/` (vedi `duplicated-profile-form.md`).

## Tracker

[#89](https://github.com/laraxot/base_fixcity_fila5/issues/89), [#90](https://github.com/laraxot/base_fixcity_fila5/issues/90).
