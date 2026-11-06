---
type: bmad-initiative
status: active
created: 2026-10-17
updated: 2026-10-26
initiative_id: kp-google-auth-login
related:
  - module: User
  - module: Fixcity
  - ./filament-blueprint.md
  - ./decision-log.md
  - ../../../../Themes/Sixteen/docs/bmad/plans/oauth-login-locale-fix.md
summary: |
  Login Google sul FO pubblico: stesso prefisso lingua della pagina login.
  Entry `/it/auth/login/google`, callback `/it/auth/login/google/callback`.
references:
  - laravel/Modules/User/app/Filament/Widgets/Auth/LoginWidget.php
  - laravel/Modules/User/routes/socialite.php
  - laravel/Themes/Sixteen/resources/views/components/utilities/google-button.blade.php
title: "Google auth login: senso e contratto"
tags: [docs, user, bmad]
qmd: "google auth login   senso e contratto user"
---

# Google auth login: senso e contratto

## Perché

Il cittadino apre `/it/auth/login`. «Accedi con Google» deve restare in italiano
nel path (`/it/auth/login/google`). Google Cloud Console ha
`GOOGLE_REDIRECT_URI=…/it/auth/login/google/callback`. Entry e callback senza
`lang` spezzano il contesto lingua e falliscono la verifica redirect URI.

## SSoT

| Pezzo | Dove |
|-------|------|
| Route named | `oauth.redirect` in `routes/socialite.php`; `oauth.callback` in the Sixteen Folio page |
| Redirect / callback | `RedirectToProviderController` / Folio callback → `ProcessCallbackAction` |
| Bottone FO Sixteen | `components/utilities/google-button.blade.php` → `route(..., ['lang' => $locale])` |
| Widget dominio | `LoginWidget` / `SocialLoginWidget::getRedirectUrl()` |

La callback è una pagina Folio+Volt redirect-only. Il controllo del provider e il redirect vivono dentro `mount()` del componente Volt,
non nel livello globale del Blade: Folio può quindi scoprire `name('oauth.callback')` senza eseguire un `abort()` durante la scansione delle named
route. La precedente decisione DCP-269 vietava gli stub Folio con logica al livello globale; non vieta questa implementazione.

## Vincoli di rotta

`{lang}` = lingue di `laravellocalization.supportedLocales`; `{provider}` = `google|microsoft|github` (quelli di `SocialLoginWidget`).
Un valore inventato è un 404 a tema, non un 500 né una lingua fantasma.

## La lingua attraversa Google

`GOOGLE_REDIRECT_URI` è uno solo (`/it/…/callback`). `RedirectToProviderController` salva la lingua d'ingresso in sessione
(`ProcessCallbackSession::KEY`), il callback la ripristina (validata) e `RedirectToLoginAction` rimanda a
`/{lang}/auth/login` con l'errore. Il blocco d'errore lo stampa il widget (`filament/widgets/auth/login.blade.php`).

## Senza chiavi: l'errore lo dà il nostro sistema (DCP-271)

Se mancano `client_id`, `client_secret` o `redirect` (vuoti o segnaposto), il clic su «Accedi con Google» **non** arriva a Google
(prima: «Missing required parameter: client_id»), ma torna a `/{lang}/auth/login` con un errore nostro. Story:
[DCP-271](./stories/dcp-271-google-senza-chiavi-errore-nostro-con-guida.story.md).

| Pezzo | Dove |
|-------|------|
| «Configurato» (SSoT) | `GetMissingProviderSettingsAction`: elenca le variabili mancanti (`GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI`). `config()->has('services.google')` è sempre vero perché `config/services.php` dichiara la chiave con `env()` = null |
| Rifiuto | `ValidateProviderAction` lancia `ProviderNotConfigured` (entry e callback); l'eccezione si rende da sola in un redirect al login e si registra come `warning` |
| Guida | `GetProviderSetupGuideAction` + chiavi `user::auth.provider-setup-guide` e `provider-setup-lan-hint` (it, en, de, es) |
| URI da registrare | `GetProviderRedirectUriAction`: uno solo, nella lingua predefinita (`/it/auth/login/google/callback`), usato anche dalla pagina del back office |

**Chi vede cosa.** Con `APP_DEBUG=true` l'errore è la guida completa (cosa manca, dove creare le chiavi, dove impostarle).
Senza debug il cittadino legge un messaggio gentile, senza nomi di variabili né URL di console. La riga di log è sempre `warning`.
Il pulsante resta visibile (DCP-269 ne prova l'href); nasconderlo in produzione se non configurato è una decisione di prodotto.

**Dove si creano le chiavi (Google).** Google Cloud Console > Google Auth Platform > Clients > Create client > Web application
(`https://console.developers.google.com/auth/clients`). Prima vanno compilati Branding e Audience. Microsoft:
`https://entra.microsoft.com` > App registrations.

**Dove si impostano (due modi, convergono in `services.*`).**
1. `.env`: `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI`, poi `php artisan config:clear`.
2. Back office: `/user/admin/socialite-provider-settings-page` (scrive `storage/app/private/socialite-config.php`).

**Trappola LAN.** Google rifiuta come URI di reindirizzamento gli IP grezzi (`http://192.168.1.40:8000/...`) e l'`http` fuori da
localhost. In sviluppo si registra `http://localhost:PORTA/it/auth/login/google/callback` e si apre il sito da `localhost`
(per esempio con un tunnel SSH); in produzione serve un dominio `https` con suffisso pubblico. La guida lo dice quando l'host non è accettabile.

## Fuori dal codice

Il `client_id` visto sul pubblico (2026-10-20) è il segnaposto `google-client-id.apps.googleusercontent.com`: serve la coppia reale in
`GOOGLE_CLIENT_ID`/`GOOGLE_CLIENT_SECRET` di produzione e `https://fixcity.eu/it/auth/login/google/callback` registrato in Google Cloud Console.

## Binding `{lang}` + `{provider}`

I controller Socialite devono dichiarare **entrambi** i parametri di rotta:

```php
public function __invoke(Request $request, string $lang, string $provider): RedirectResponse
```

Con solo `$provider`, Laravel legava il segmento `it` a `$provider` →
`ProviderNotConfigured("it")`. Usare `Illuminate\Http\Request`, non la Facade.

## Non fare

- `route('oauth.redirect', ['provider' => 'google'])` senza `lang`
- Aprire OAuth in un nuovo tab (rompe state/session)
- Nuovi controller o duplicare la logica Socialite nel tema
- Tipizzare la Facade `Request` nel `__invoke` OAuth