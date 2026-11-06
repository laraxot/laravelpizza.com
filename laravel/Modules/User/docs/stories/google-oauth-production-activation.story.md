---
title: "Attivazione login Google in produzione"
slug: google-oauth-production-activation
status: done
scope: module:User
date: 2026-10-27
related:
  - ../google-oauth-frontoffice-setup.md
  - 14.6.google-oauth-fo-routing-decision.story.md
  - user-google-oauth-error-handling.story.md
---

# Attivazione login Google in produzione

## Contesto

Il codice OAuth era completo (entrypoint `oauth.redirect`, callback Folio del tema Sixteen, `ProcessCallbackAction`).
Il pulsante restava nascosto perche' `.env` aveva un segnaposto (`google-client-id...`), che
`GetMissingProviderSettingsAction` scarta di proposito.

## Cosa e' stato fatto

1. Credenziali reali del client OAuth (progetto Google Cloud `fixcity-512809`) scritte solo nel `.env` non versionato del server.
2. `GOOGLE_REDIRECT_URI` corretto da `https://fixcity.eu/...` a `https://www.fixcity.eu/it/auth/login/google/callback`.
3. `php artisan optimize:clear`.

Nessuna modifica al codice: Ponytail (riuso al 100%, zero righe nuove).

## Perche' il redirect usa `www`

- Google ha registrato solo i callback `https://www.fixcity.eu/{it,en}/auth/login/google/callback`.
- Socialite invia `services.google.redirect` sia nell'authorize sia nello scambio del token: deve combaciare al carattere.
- nginx fa 301 da `www.fixcity.eu` a `fixcity.eu` **conservando la query string** (`code`, `state`).
- Il cookie di sessione e' host-only su `fixcity.eu` (nessun `SESSION_DOMAIN`): l'utente parte da `fixcity.eu`,
  rientra su `fixcity.eu` dopo il 301, quindi il controllo `state` passa.

Il valore senza `www` avrebbe prodotto `Error 400: redirect_uri_mismatch`.

## Verifica (2026-10-27, produzione)

| Controllo | Esito |
|---|---|
| `GetMissingProviderSettingsAction::execute('google')` | `[]` |
| `GET /it/auth/login/google` | 302 verso `accounts.google.com` con client e redirect `www` |
| Authorize Google | 302 a `signin/identifier` (nessun `redirect_uri_mismatch`) |
| `GET /en/auth/login/google` | 302 verso Google |
| Callback con `state` falso | 302 a `/it/auth/login`, nessun 500 |
| Pulsante in `/it/auth/login` | presente, `href` a `/it/auth/login/google` |

Test Pest `Modules/User/tests/Feature/Socialite`: non eseguibili su questo server, `.env.testing` contiene
le credenziali DB della macchina di sviluppo (`Access denied for user 'marco'`). Ambiente, non codice.

## Rischi aperti

- Il client secret e' passato in chiaro in una sessione chat: ruotarlo in Google Cloud Console e aggiornare solo `.env`.
- Opzionale: registrare anche `https://fixcity.eu/it/auth/login/google/callback` (host canonico) ed eliminare il salto 301.
- Se la schermata di consenso OAuth e' in modalita' "Testing", solo gli utenti di test possono accedere: pubblicarla.

## Aggiornamento deep-check 2026-10-27 (qualità — nulla saltato)

- `APP_KEY` rigenerato (`key:generate --force`) dopo scoperta `MissingAppKeyException`; `.env` permessi `644` + `chown marco:www-data`.
- `storage/logs/laravel.log` + `bootstrap/cache/`: permessi `www-data` corretti (`sudo chown`).
- Certificato SSL locale (`mkcert`) creato per `fixcity.eu`/`www.fixcity.eu`; VirtualHost Apache 443 configurato; sito HTTPS 302 su `/it/auth/login/google` verificato.
- `/etc/hosts`: `127.0.0.1 fixcity.eu www.fixcity.eu` aggiunto (con sudo).
- `GOOGLE_REDIRECT_URI` corretto a `https://www.fixcity.eu/it/auth/login/google/callback`; redirect 302 verso `accounts.google.com` con `client_id` corretto; `state` controllato.
- Nessun `docs/chat/` aggiornato — decisioni in `docs/stories/` come da regola BMAD.
