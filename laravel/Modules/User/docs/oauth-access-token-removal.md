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
