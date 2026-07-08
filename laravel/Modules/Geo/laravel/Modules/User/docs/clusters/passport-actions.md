# Passport Administrative Actions in Filament

> Riferimenti ufficiali: [Laravel Passport 12.x Docs](https://laravel.com/docs/12.x/passport) e [laravel/passport GitHub](https://github.com/laravel/passport).

Questo documento elenca le operazioni **obbligatorie** che il cluster `Passport` nel modulo **User** deve rendere disponibili da Filament per evitare l’utilizzo manuale del terminale. Ogni azione riporta il comando/articolo di riferimento e la pagina/risorsa Filament responsabile dell’implementazione.

## 1. Resource Actions (CRUD + operazioni mirate)

### 1.1 `OauthClientResource`

| Azione | Fonte ufficiale | Dettagli implementativi |
| --- | --- | --- |
| Creazione Client standard | Docs § "Managing Clients" | Page `ListOauthClients` → header action che richiama `CreateClientAction` con tipi dinamici. |
| Creazione Personal Access Client (`passport:client --personal`) | Docs § "Personal Access Tokens" | Header action dedicata che compila i flag necessari e salva i dati nella tabella `oauth_clients`. |
| Creazione Password Grant Client (`passport:client --password`) | Docs § "Password Grant Tokens" | Identica logica, con validazione delle credenziali di primo utilizzo. |
| Creazione Client Credentials (`passport:client --client`) | Docs § "Client Credentials Grant Tokens" | Disponibile come opzione rapida dal pannello. |
| Rigenerazione Secret | Docs § "Client Secrets" | Table action che usa `RegenerateClientSecretAction` e notifica l’utente. |
| Revoca Client + Tokens | Docs § "Deleting Clients" | Table action che chiama `RevokeClientAction` + `RevokeAllClientTokensAction`. |

### 1.2 `OauthAccessTokenResource`

| Azione | Fonte | Note |
| --- | --- | --- |
| Revoca singolo token (`passport:token:revoke`) | Docs § "Revoking Tokens" | Table action con conferma e logging. |
| Revoca bulk | Docs § "Purging Tokens" | Bulk action collegata a `RevokeTokenAction`. |
| Visualizzazione scopes | Docs § "Token Scopes" | Colonna dedicata + filtro. |

### 1.3 `OauthRefreshTokenResource`

| Azione | Fonte | Note |
| --- | --- | --- |
| Revoca refresh token | Docs § "Revoking Tokens" | Table action che sincronizza lo stato con access token. |

### 1.4 `OauthAuthCodeResource`

| Azione | Fonte | Note |
| --- | --- | --- |
| Invalidare authorization codes | Docs § "Authorization Code Grant" | Permette il cleanup manuale in caso di incident response. |

## 2. Global Utility Actions (senza terminale)

| Funzionalità | Comando CLI originario | Implementazione Filament |
| --- | --- | --- |
| **Genera/Rigenera chiavi** | `php artisan passport:keys` | Action a livello cluster (Accessibile da `Passport` dashboard) che esegue `GenerateKeysAction` usando Spatie Queueable Action + job status. |
| **Purge Tokens** | `php artisan passport:purge --revoked --expired` | Pulsante “Purge Tokens” che lancia `PurgeTokensAction` con parametri selezionabili. |
| **Hash Secrets** | `php artisan passport:hash` | Action che attraversa `oauth_clients` e aggiorna i secrets secondo policy hashing. |
| **Prune Command** | `php artisan passport:prune` | Schedulabile dal pannello (opzione "run now" + cron preview) per ambienti senza accesso console. |
| **Check Configuration** | n/a (docs § "Configuration") | Widget diagnostico che verifica env (`PASSPORT_PRIVATE_KEY`, `PASSPORT_PERSONAL_ACCESS_CLIENT_*`, ecc.) e avvisa il tenant. |

## 3. Implementazione Tecnica

### 3.1 Actions (Spatie Queueable Action)

- `Modules\User\Actions\Passport\CreateClientAction`
- `Modules\User\Actions\Passport\RevokeClientAction`
- `Modules\User\Actions\Passport\RevokeTokenAction`
- `Modules\User\Actions\Passport\RevokeAllUserTokensAction`
- `Modules\User\Actions\Passport\HashClientSecretsAction`
- `Modules\User\Actions\Passport\GenerateKeysAction`
- `Modules\User\Actions\Passport\PurgeTokensAction`

Tutte devono:

1. accettare DTO validati;
2. loggare audit trail;
3. restituire stati coerenti (success/error) ai componenti Filament.

### 3.2 Filament Integration Pattern

- Header actions per operazioni "create" e "global utility".
- Table actions/bulk actions per revoca/regenerazione.
- Widget cluster per mostrare stato configurazione (chiavi, hashing, scheduler).
- Autorizzazioni mappate via `Oauth*Policy` per garantire che solo super-admin possano eseguire operazioni sensibili.

## 4. Checklist per nuovi sviluppi

1. Verificare sempre la sezione corrispondente nella doc ufficiale prima di aggiungere/aggiornare un’azione.
2. Aggiornare questa pagina + documentazione root (`docs/passport-admin-actions.md`).
3. Aggiornare i file di traduzione (`Modules/User/lang/*/passport.php`).
4. Validare con PHPStan lvl 10 + PHPMD + PHPInsights.
5. Documentare eventuali nuove queueable action.

## 5. Note per altri agenti AI
- Seguire le regole Laraxot (no label/placeholder nei componenti Filament, usare cluster `Passport` per qualsiasi nuova risorsa OAuth).
- Prima di implementare nuove feature, sincronizzare le definizioni qui e nella doc root per evitare conflitti.
