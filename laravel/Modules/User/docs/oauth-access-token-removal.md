---
title: "Rimozione OauthAccessToken - Consolidamento su OauthToken"
type: concept
tags: [oauth, access, token, removal]
created: 2026-07-14
updated: 2026-07-14
qmd: "oauth-access-token-removal rimozione oauthaccesstoken - consolidamento su oauthtoken"
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

# Rimozione OauthAccessToken - Consolidamento su OauthToken

## Contesto

`OauthAccessToken` era un modello ridondante nel modulo User. Il nome suggeriva una relazione con `Laravel\Passport\AccessToken`, ma:

- **Laravel\Passport\AccessToken** non è un modello Eloquent: è un DTO (ScopeAuthorizable, Arrayable, Jsonable) usato durante le richieste HTTP
- **Laravel\Passport\Token** è il modello Eloquent per la tabella `oauth_access_tokens`

## Soluzione applicata

1. **Rinominato** `OauthAccessToken.php` → `OauthAccessToken.php.old` (backup)
2. **Sostituiti** tutti i riferimenti con `OauthToken`, modello canonico già configurato in Passport
3. **Rinominata** `OauthAccessTokenPolicy` → `OauthTokenPolicy` (Laravel policy discovery per OauthToken)

## Mapping finale

| Passport vendor | Wrapper modulo User |
|-----------------|---------------------|
| `Laravel\Passport\Token` | `Modules\User\Models\OauthToken` |

## File modificati

- Resources Filament: `OauthAccessTokenResource`, `PersonalAccessTokenResource` → model `OauthToken`
- Factory: `OauthAccessTokenFactory` → `$model = OauthToken::class`
- Migration: `foreignIdFor(OauthToken::class, 'access_token_id')`
- Policy: `OauthTokenPolicy` (sostituisce OauthAccessTokenPolicy)
- Test: `AdditionalModelsTest`, `PoliciesTest`

## Collegamenti

- [passport-model-wrappers](passport-model-wrappers.md)
- [fix-ide-helper-relation-errors](fix-ide-helper-relation-errors.md)
- [passport-integration](passport-integration.md)
