---
title: "Passport OAuth Wrapper Conformance"
type: concept
tags: [passport, oauth, wrapper, conformance]
created: 2026-07-14
updated: 2026-07-14
qmd: "passport-oauth-wrapper-conformance passport oauth wrapper conformance"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# Passport OAuth Wrapper Conformance

## Scope

Questa nota formalizza la regola per i model Passport Eloquent nel progetto.

Source of truth vendor:

- `laravel/vendor/laravel/passport/src`

Wrappers locali obbligatori:

- `laravel/Modules/User/app/Models/Oauth*.php`

## Inventory verificato

Classi vendor che estendono `Illuminate\Database\Eloquent\Model`:

1. `Laravel\Passport\AuthCode`
2. `Laravel\Passport\Client`
3. `Laravel\Passport\DeviceCode`
4. `Laravel\Passport\RefreshToken`
5. `Laravel\Passport\Token`

Mapping locale conforme:

1. `Modules\User\Models\OauthAuthCode` extends `Laravel\Passport\AuthCode`
2. `Modules\User\Models\OauthClient` extends `Laravel\Passport\Client`
3. `Modules\User\Models\OauthDeviceCode` extends `Laravel\Passport\DeviceCode`
4. `Modules\User\Models\OauthRefreshToken` extends `Laravel\Passport\RefreshToken`
5. `Modules\User\Models\OauthToken` extends `Laravel\Passport\Token`

## Guardrail operativo

- Se Passport aggiunge un nuovo model Eloquent, va creato subito `Oauth{Name}`.
- Il codice applicativo deve preferire i wrapper locali.
- La conformita' viene protetta da test Pest:
  - `Modules/User/tests/Unit/Models/PassportWrapperConventionTest.php`
  - `Modules/User/tests/Unit/Models/PassportModelWrappersTest.php`
