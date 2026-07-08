---
type: concept
module: User
confidence: high
updated: 2026-04-20
sources:
  - ../../../app/Filament/Resources/SocialProviderResource.php
  - ../../../resources/views/filament/widgets/auth/login.blade.php
  - ../../../routes/socialite.php
---

# socialite backoffice google setup

## obiettivo

Configurare Google OAuth da backoffice Filament 5 senza sporcare la tabella `users`, mantenendo il login social nel modulo `User`.

## prerequisiti

- provider Google configurato in Google Cloud Console (OAuth Web App)
- redirect URI registrata correttamente verso callback applicativa
- route callback attiva nel progetto: `socialite.oauth.callback`

Riferimento Google:
- [Google OAuth2 Web Server Flow](https://developers.google.com/identity/protocols/oauth2/web-server?hl=it)

## percorso amministrazione

Backoffice Filament:

1. apri risorsa `SocialProvider`
2. crea/edita record provider `google`
3. compila i campi:
   - `name`: `google`
   - `client_id`: valore Google
   - `client_secret`: valore Google
   - `active`: `true`
   - `socialite`: `true`
   - `stateless`: `false` (web flow con sessione; `true` solo API/stateless)
   - `scopes`: almeno `openid`, `profile`, `email`
   - `parameters`: opzionale (es. `prompt`, `access_type`)

## comportamento UI login

Il bottone Google nel widget login viene mostrato solo se la configurazione provider e disponibile.

La vista widget usa i check su config/servizi per abilitare i pulsanti social, quindi bisogna mantenere coerenza fra:

- configurazione amministrata provider
- configurazione runtime letta dal driver Socialite

## integrazione config

Per evitare drift configurativo, stabilire una sola fonte di verita:

- **strategia consigliata**: mantenere fallback `.env` + sincronizzazione da `SocialProvider` verso runtime config (bootstrap provider/config cache invalidation)

In ogni caso, l’utente finale non deve dipendere da modifiche manuali al codice per aggiornare `GOOGLE_CLIENT_ID`/`GOOGLE_CLIENT_SECRET`.

## checklist di collaudo

1. clic su bottone Google in login widget
2. redirect verso Google consent screen
3. callback su `/sso/google/callback`
4. creazione/aggiornamento record `SocialiteUser`
5. login completato e redirect post-auth corretto

## anti-pattern da evitare

- aggiungere `google_id` in `users`
- duplicare token/identificativi in modelli multipli senza governance
- hardcodare client id/secret nelle view
- bypassare il controller di callback con logica ad hoc in widget

## riferimenti plugin/articoli valutati

- [Filament Socialite plugin (DutchCodingCompany)](https://filamentphp.com/plugins/dododedodonl-socialite)
- [Repository DutchCodingCompany/filament-socialite](https://github.com/DutchCodingCompany/filament-socialite)
- [Filament Social login article (Laravel Daily)](https://laraveldaily.com/post/filament-sign-in-with-google-using-laravel-socialite)
- [Filament Socialite walkthrough (Medium)](https://medium.com/@a.dhakal/filament-login-with-google-using-laravel-socialite-83c8bd476ace)

## note operative

Il modulo ha gia route/controller/actions Socialite pronti; il passo critico e consolidare governance configurazione provider e documentare una procedura admin ripetibile.
