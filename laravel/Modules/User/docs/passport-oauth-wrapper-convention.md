---
title: "Passport OAuth Wrapper Convention"
type: concept
tags: [passport, oauth, wrapper, convention]
created: 2026-07-14
updated: 2026-07-14
qmd: "passport-oauth-wrapper-convention passport oauth wrapper convention"
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

# Passport OAuth Wrapper Convention

## Rule

Ogni model Eloquent fornito dal vendor `Laravel\Passport` deve avere un wrapper locale nel modulo `User` con prefisso `Oauth`.

## Current mapping

- `Laravel\Passport\AuthCode` -> `Modules\User\Models\OauthAuthCode`
- `Laravel\Passport\Client` -> `Modules\User\Models\OauthClient`
- `Laravel\Passport\DeviceCode` -> `Modules\User\Models\OauthDeviceCode`
- `Laravel\Passport\RefreshToken` -> `Modules\User\Models\OauthRefreshToken`
- `Laravel\Passport\Token` -> `Modules\User\Models\OauthToken`

## Why

- custom connection support
- project-owned extension point
- policies/resources/admin integration
- no direct vendor model sprawl in application code

## Verification

The convention is enforced by:

- `Modules/User/tests/Unit/Models/PassportWrapperConventionTest.php`

## Important nuance

Not every local OAuth model is a Passport vendor wrapper.

Example:

- `Modules\User\Models\OauthPersonalAccessClient`

This is a project model for local persistence and management, not a 1:1 wrapper of a vendor Passport Eloquent model.
