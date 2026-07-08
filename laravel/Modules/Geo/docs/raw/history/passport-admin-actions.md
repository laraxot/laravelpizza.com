# Passport Administrative Actions (Root Summary)

> Riferimenti: [Laravel Passport 12.x](https://laravel.com/docs/12.x/passport) · [laravel/passport repo](https://github.com/laravel/passport)

Questo file fornisce la sintesi delle attività da implementare nel cluster **Passport** (modulo User) per gestire l'intero ciclo di vita di OAuth direttamente da Filament senza terminale. Ogni sezione rimanda ai documenti dettagliati del modulo (`Modules/User/docs/...`).

## Azioni su Risorse

- **OauthClientResource**: creazione rapida dei vari client (`--personal`, `--password`, `--client`), rigenerazione secret, revoca client + tokens. Doc modulo: `Modules/User/docs/clusters/passport-actions.md#11-oauthclientresource`.
- **OauthAccessTokenResource**: revoca singola/bulk, visualizzazione scopes, filtri diagnostici. Doc modulo: `...#12-oauthaccesstokenresource`.
- **OauthRefreshTokenResource**: revoca allineata allo stato dell'access token. Doc modulo: `...#13-oauthrefreshtokenresource`.
- **OauthAuthCodeResource**: invalidamento authorization codes per incident response.

## Utility Globali

| Funzione | Comando CLI originale | Filament Requirement |
| --- | --- | --- |
| Generazione chiavi | `passport:keys` | Action cluster + audit log. |
| Purge tokens | `passport:purge --revoked --expired` | Pulsante con parametri (`revoked`, `expired`). |
| Hash secrets | `passport:hash` | Action queueable che attraversa `oauth_clients`. |
| Prune scheduler | `passport:prune` | Widget con "run now" e cron preview. |
| Health check config | n/a | Widget che evidenzia variabili mancanti (`PASSPORT_PRIVATE_KEY`, ecc.). |

## Implementazione Tecnica Richiesta

1. **Spatie Queueable Actions** per ogni operazione (create/revoke/hash/purge/keys) con DTO tipizzati.
2. **Filament Actions**: header, table, bulk, cluster-level widget.
3. **Policy/Permission**: mappare tutte le azioni su ruoli/permessi high-trust.
4. **Audit & Logging**: ogni action deve loggare eventi chiave e notificare l'utente.
5. **Validazione**: PHPStan lvl 10, PHPMD, PHPInsights dopo ogni modifica.

## Checklist Operativa

- [ ] Aggiornare `Modules/User/docs/clusters/passport-actions.md` quando si aggiunge/modifica un'azione.
- [ ] Aggiornare file di traduzione (`Modules/User/lang/*/passport.php`).
- [ ] Sincronizzare la doc root (questo file) con lo stato reale del cluster.
- [ ] Documentare eventuali nuove queueable actions (`Modules/User/docs/actions/`).
- [ ] Verificare route e permessi nel Filament panel provider.

## Collegamenti

- Modulo: `Modules/User/docs/clusters/passport-actions.md` (dettaglio completo).
- Regole generali Filament: `docs/filament-best-practices.md`.
- Configurazione Passport: `docs/it/config/passport.md`.

> Nota per gli altri agenti: qualsiasi nuova funzionalità Passport **deve** essere gestita dal cluster `Passport`; evitare script esterni o pagine isolate. Mantenere la documentazione sincronizzata prima di implementare nuove azioni.
