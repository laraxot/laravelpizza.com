---
title: "Fix IDE Helper Relation Errors"
type: concept
tags: [fix, ide, helper, relation]
created: 2026-07-14
updated: 2026-07-14
qmd: "fix-ide-helper-relation-errors fix ide helper relation errors"
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

# Fix IDE Helper Relation Errors

## Scopo

Allineare i wrapper Passport del modulo User a `php artisan ide-helper:models` **senza** introdurre relazioni synthetic o violare il model canonico `OauthToken`.

## Problem Statement (wave 2026-07-15)

```bash
cd laravel && php artisan ide-helper:models --no-interaction
```

Segnalazioni:

- `Error resolving relation model of Modules\User\Models\OauthAccessToken:user() : Attempt to read property "provider" on null`
- `Error resolving relation model of Modules\User\Models\OauthToken:user() : Attempt to read property "provider" on null`

### Perché accade (scopo Passport)

La relazione `user()` deve collegare il token al model utente corretto in base al **provider** registrato sul client OAuth (`users`, `admins`, …). Passport legge `$this->client->provider` per risolvere `config('auth.providers.{provider}.model')`.

In analisi statica il client non è loaded: il codice fa ciò per cui è nato (risolvere guard a runtime), non per essere invocato a model vuoto.

## Regola architetturale (invariata)

1. **Model canonico:** `Modules\User\Models\OauthToken` estende `Laravel\Passport\Token`.
2. **No fallback ad hoc** in `user()` con logiche inventate: fix via wrapper null-safe o PHPDoc esplicito.
3. **Delega vendor** quando il parent è corretto; correggere drift su PHPDoc e consumer.

### Fix documentati: stato 2026-07-15

| Opzione | Stato |
|---------|-------|
| Trait `ResolvesPassportTokenUserRelation` | ✅ Implementato |
| Guard `TranslationFile::getRows()` | ✅ Implementato (Lang) |
| `merge_translation_files()` in Helper.php | ✅ Implementato (Xot) |

## Verifica post-fix

```bash
cd laravel && php artisan ide-helper:models --no-interaction -v 2>&1 | rg "Oauth(Token|AccessToken)"
./vendor/bin/phpstan analyse Modules/User --error-format=raw
```

## Note operative

- Wave 2026-03-10: distinzione errori sandbox DB vs model: vedi [ide-helper-models-wave](./ide-helper-models-wave.md)
- Wave 2026-07-15: errori OAuth **reproducibili** con DB reale: non ambientali
- Filosofia globale: [ide-helper-philosophy](../Xot/docs/ide-helper-philosophy.md)

## Collegamenti

- [oauth-token-relations-ide-helper](./oauth-token-relations-ide-helper.md)
- [passport-model-wrappers](./passport-model-wrappers.md)
- [ide-helper-models-wave](./ide-helper-models-wave.md)
