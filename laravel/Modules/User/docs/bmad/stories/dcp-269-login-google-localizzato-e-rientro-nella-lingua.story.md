---
title: "DCP-269: Accedi con Google: URL con lingua, giro completo che funziona e rientro nella stessa lingua"
type: story
status: done-pending-prod-sync
updated: 2026-10-20
tags: [docs, user, sixteen, bmad, auth, google, socialite, folio, i18n, filament-blueprint]
qmd: "dcp 269 accedi con google /it/auth/login/google lang callback fisso redirect_uri sessione lingua folio stub abort route login 404 provider vincoli"
related:
  - ../google-auth-login.md
  - ../decision-log.md
  - ../../../../../Themes/Sixteen/docs/bmad/plans/oauth-login-locale-fix.md
  - ../../../../../Themes/Sixteen/docs/bmad/stories/dcp-268-login-checkbox-e-occhio-password-dentro-data-dc.story.md
---

# DCP-269: Accedi con Google: URL con lingua, giro completo che funziona e rientro nella stessa lingua

**Numero:** 269, preso con controllo che blocca (massimo trovato 268) e scrittura `noclobber`.
**Stato:** done-pending-prod-sync. Misurato in locale e in un browser vero; `fixcity.eu` alle 17:22 serviva ancora il codice vecchio
(`href="https://fixcity.eu/auth/login/google"`), quindi nulla di questo è «pubblicato» finché non arriva il push.

## Story

Come cittadino che apre `/it/auth/login` voglio che «Accedi con Google» mi porti a `/it/auth/login/google`, che il giro
(Google → callback → login) funzioni e che, se annullo o Google mi rifiuta, io torni sulla pagina di login **nella mia lingua**
con un messaggio chiaro. Vale per le quattro lingue del sito (it, en, de, es).

## Perché (il senso)

Il sito è sempre con prefisso lingua. Un URL senza `/{lang}` esce dal contesto lingua, e il `redirect_uri` verso Google è **uno solo**
(`GOOGLE_REDIRECT_URI` = `…/it/auth/login/google/callback`): chi parte da `/en/` rientra comunque su `/it/`. Il contesto va quindi
portato da noi, non delegato a Google.

## Cause trovate (misurate, non supposte)

| # | Causa | Evidenza |
|---|---|---|
| C1 | Il pulsante usava `route(oauth.redirect, [provider=>google])` senza `lang` (poi `localizeURL` senza lingua). | Storia del file: `ecd699b8` → `4abd0680` → `919df072`. Con `lang` esplicito: `http://…/it/auth/login/google`. |
| C2 | I controller dichiaravano solo `$provider`: i parametri di rotta arrivano per **posizione**, quindi `it` finiva in `$provider` (`ProviderNotConfigured("it")`). | Controller con firma `(Request $request, string $lang, string $provider)` + `OauthLocaleBindingContractTest`. |
| C3 | **Quattro fallback Folio** (`pages/auth/[provider]/…`, `pages/auth/login/[provider]/…`) con `abort(404)` al livello superiore. Folio, per risolvere un nome di rotta che Laravel non conosce (`route(login)`), **esegue ogni pagina** per leggerne `name()`: l’`abort` scattava e `route(login)` lanciava 404 in tutta l’app, compreso `RedirectToLoginAction`. Erano anche doppioni: la rotta nominata vince comunque. | Traccia: `RedirectToLoginAction` → `Redirector::route` → `FolioRoutes::load` → `InlineMetadataInterceptor` → stub → `abort`. Rimossi i 4 file. |
| C4 | Il callback fisso `/it/` faceva perdere la lingua d’ingresso; `RedirectToLoginAction` rimandava a `route(login)`, che risolve la lingua di default. | Prova nel browser: partendo da `/en/`, rientro su `/it/auth/login`. Ora `/en/auth/login`. |
| C5 | Chiavi `auth.login-failed`, `auth.user-not-allowed`, `auth.registration-not-enabled` esistevano solo in `it` e `de`: in `en` ed `es` il messaggio usciva in italiano. | `__()` per lingua. Aggiunte in `en` ed `es`. |
| C6 | `{lang}` e `{provider}` non erano vincolati: `/xx/auth/login/google` impostava una lingua inventata e `/it/auth/login/nonexistent` rispondeva **500**. | In-process: 500. Ora 404 (pagina a tema). `ValidateProviderAction` accettava qualunque chiave `services.*`. |
| C7 | Il blocco d’errore del widget di login usava utility Tailwind (`h-8 w-8`, `h-5 w-5`) spente dentro `data-dc`: icona «!» a 370 px. Titolo fisso «Invalid credentials» che ripeteva lo stesso testo. | Screenshot prima/dopo; icona ora 20×20, riquadro 54 px. Stessa famiglia di DCP-268. |

## Decisioni

- **Una sola fonte per le rotte:** `Modules/User/routes/socialite.php` (`oauth.redirect`, `oauth.callback`), con vincoli `lang` = lingue supportate
  (da `laravellocalization.supportedLocales`) e `provider` = `google|microsoft|github` (gli stessi di `SocialLoginWidget`).
- **Lingua d’ingresso in sessione** (`ProcessCallbackSession::KEY`, ex `ProcessCallbackController::SESSION_LANG_KEY`, DCP-360): scritta da `RedirectToProviderController`,
  letta e consumata dal callback, validata contro le lingue supportate. Niente cambio di `GOOGLE_REDIRECT_URI`, niente URI in più da registrare.
- **Rientro d’errore localizzato:** `RedirectToLoginAction` usa `LaravelLocalization::localizeURL(/auth/login, lingua corrente)`.
- **Nessun fallback Folio** per questi URL: un `abort()` al livello superiore di una vista Folio è una trappola (vedi C3).
- **Un solo blocco d’errore:** quello del widget (`filament/widgets/auth/login.blade.php`), vestito con `.auth-login-alert*` nel componente della pagina.

## Verifica (2026-10-20, locale; DB usa-e-getta, mai quello di sviluppo)

- Pest `OauthLocalizedLoginFlowTest` (Modules/User): href con lingua ×4, ingresso → Google con `redirect_uri` ×4, consenso negato → pagina della stessa lingua ×4,
  lingua d’ingresso che sopravvive al callback fisso, provider/lingua inventati → 404 ×4, errore mostrato **una volta** e senza titolo fisso, nessun blocco senza errore,
  `route(login)`/`route(register)` risolvono. **Prova inversa:** tolti i vincoli e la sessione → 3 test rossi; reintrodotto un fallback Folio con `abort` → rosso.
- Browser (Chromium, ponte verso server locale): clic su `/it` e `/en` → Google; consenso negato → `/it/auth/login` e `/en/auth/login` con messaggio nella lingua, un solo `role="alert"`,
  icona 20×20; a 375 px nessuno scroll orizzontale (scrollW 375).
- PHPStan sui 4 file PHP toccati: 0 errori.

## NON verificato / da fare fuori dal codice

1. **Credenziali Google di produzione.** Il pubblico invia a Google `client_id=google-client-id.apps.googleusercontent.com`, un **segnaposto**: Google risponderà `invalid_client`
   finché `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET` e `GOOGLE_REDIRECT_URI` reali non sono nell’ambiente di produzione. Il `redirect_uri` da registrare nella Google Cloud Console
   è **uno**: `https://fixcity.eu/it/auth/login/google/callback`. Il giro reale con Google non è stato provato (nessuna credenziale in locale, e vanno solo via env).
2. **Pubblicazione.** Il commit `25f70aba1d` e le modifiche successive non sono sul remoto; `fixcity.eu` serve ancora il pulsante senza lingua.
3. **Dopo il login** `LoginUserAction` fa `redirect()->intended(/)` senza lingua: da misurare dove atterra un cittadino in en/de/es.
4. `Modules/User/routes/web_tall.php` ha un blocco `Socialite` (`/login/{provider}`, `/sso/{provider}/callback`) non registrato (codice morto) con la firma vecchia dei controller.
5. `LoginWidgetTest` (Unit) ha 4 test rossi che chiamano `getFormSchema()`/`getFormFill()` non più esistenti: non toccati qui (file in modifica da un’altra sessione).

## Real credentials (2026-10-26)

- The user supplied the Google Cloud OAuth client for project `fixcity-512809`. `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET` and `GOOGLE_REDIRECT_URI` are in `laravel/.env` (git-ignored, chmod 600). They are NEVER in the repo, the docs or the memory.
- Verified locally: `/it/auth/login` shows "Accedi con Google", and `/it/auth/login/google` and `/en/auth/login/google` redirect to `accounts.google.com` with the real client_id, scope `openid profile email`, and `redirect_uri=https://www.fixcity.eu/it/auth/login/google/callback`. That URI is computed by `GetProviderRedirectUriAction` from the tenant URL, and it matches the URI registered in the console.
- For production: the same three variables go into the server `.env`, followed by `php artisan config:clear`. Registered URIs: `https://www.fixcity.eu/{it,en}/auth/login/google/callback`. The callback always uses the default language (it). The entry language travels in the session (DCP-269), so registering `/it/` is enough.
- Locally, the round trip ends on the production callback, because no local URI is registered. To test locally you have to add a local origin and URI in the console.
