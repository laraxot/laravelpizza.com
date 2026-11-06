---
title: "Passport Model Wrappers"
type: concept
tags: [passport, model, wrappers]
created: 2026-07-14
updated: 2026-07-14
qmd: "passport-model-wrappers passport model wrappers"
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

# Passport Model Wrappers

## Regola

Ogni classe di `Laravel\Passport` che estende direttamente `Illuminate\Database\Eloquent\Model`
deve avere un wrapper omonimo con prefisso `Oauth` in:

`Modules/User/app/Models`

## Mapping richiesto

| Vendor Passport | Wrapper modulo User |
|---|---|
| `Laravel\Passport\AuthCode` | `Modules\User\Models\OauthAuthCode` |
| `Laravel\Passport\Client` | `Modules\User\Models\OauthClient` |
| `Laravel\Passport\DeviceCode` | `Modules\User\Models\OauthDeviceCode` |
| `Laravel\Passport\RefreshToken` | `Modules\User\Models\OauthRefreshToken` |
| `Laravel\Passport\Token` | `Modules\User\Models\OauthToken` |

## Motivazione

- centralizzare connection, policy, relazioni e comportamento applicativo nel modulo `User`;
- evitare dipendenze dirette sparse verso i model vendor;
- mantenere un punto di estensione locale se Passport cambia o se il sistema richiede metadati aggiuntivi;
- rendere testabile il contratto di integrazione con Passport.

## Nota importante

`OauthPersonalAccessClient` resta un model locale utile al sistema, ma non fa parte del set "vendor model subclasses" da coprire con naming one-to-one, perche' nel perimetro verificato di `vendor/laravel/passport/src` non esiste una corrispondente classe `PersonalAccessClient` che estende `Model`.

## Regola di implementazione

1. se Laravel Passport introduce un nuovo model che estende `Model`, aggiungere subito il wrapper `Oauth*` nel modulo `User`;
2. il wrapper deve estendere la classe vendor originale;
3. il wrapper deve usare la connessione del modulo `user` se il dato vive li;
4. aggiungere o aggiornare il test Pest di conformita' del mapping.
