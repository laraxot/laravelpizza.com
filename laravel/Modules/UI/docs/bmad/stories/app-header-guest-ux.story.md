---
title: "App header: crash per ospiti e UX di accesso"
type: story
module: UI
story_id: "2026-10-06-app-header-guest-ux"
status: review
related:
  - ../../../../Xot/docs/bmad/stories/2026-10-06-remove-typedhasrecursiverelationships.story.md
---

# App header: crash per ospiti e UX di accesso

## Problema

`GET /it` rispondeva 500: `Attempt to read property "name" on null` in
`Modules/UI/resources/views/components/ui/app/header.blade.php:38`.
L'header leggeva `Auth::user()->name` senza controllare l'autenticazione, ma il
layout `x-layouts.app` che lo include e' renderizzato anche per gli ospiti.

## Causa radice

Il dropdown utente era l'unico blocco di destra dell'header e non aveva un ramo
per chi non e' loggato. Un ospite non puo' mai vedere un nome utente: il bug non
era un null da proteggere, era un'interfaccia pensata solo per l'utente
autenticato. La stessa copia identica del file vive in
`Modules/User/resources/views/components/ui/app/header.blade.php` (stesso bug).

## Decisione UX

Un ospite non vede "Guest" ne' un dropdown vuoto: vede le azioni che puo'
compiere, **Accedi** e **Registrati**, sempre visibili anche su mobile (fuori
dal menu hamburger, che per un ospite non avrebbe voci).

## Criteri di accettazione

- [x] Render dell'header da ospite senza eccezioni, con link login e register.
- [x] Render dell'header da utente autenticato invariato nella sostanza (nome, dropdown, logout in POST con CSRF).
- [x] Il logo porta alla home per gli ospiti e alla dashboard per gli utenti.
- [x] Nessun testo hard-coded in inglese: chiavi `ui::auth.*` gia' esistenti.
- [x] Hamburger e dropdown con `aria-expanded` / `aria-label` traducibili.
- [ ] Copia duplicata nel modulo User allineata o rimossa (NON fatto: modulo User, decisione aperta).
- [x] Altri `Auth::user()->` non protetti nelle viste censiti (vedi sotto).

## Altri difetti trovati (non richiesti, da trattare)

- `Modules/User/resources/views/components/ui/app/header.blade.php`: copia
  identica del vecchio header, stesso crash.
- `Modules/User/resources/views/layouts/navigation.blade.php`: `Auth::user()->`
  senza guardia (residuo Breeze).
- `Modules/UI/resources/views/components/ui/marketing/header.blade.php`:
  "View Dashboard", "Login", "Sign Up" hard-coded in inglese.
- Il pulsante logout aveva `onclick` che replicava il submit nativo del form.
- **La route `logout` non esisteva**: `Modules/User/routes/web.php` aveva la riga
  commentata e la versione attiva stava in `web_tall.php`, che nessun provider
  carica. Ogni header con utente loggato avrebbe dato "Route [logout] not
  defined". Registrata come `POST logout` + `auth` verso `LogoutAction`
  (un logout via GET e' esposto a CSRF).
- `Modules/Cms/app/Models/Menu.php` ha un errore di sintassi (`implements
  HasRecursiveRelationshipsContract<Menu>`, riga 81) introdotto dall'agente
  `codex` (lock `phpstan-cms-menu`): rompe ogni caricamento di `Menu`. Non toccato.
- La home `/it` usa `x-layouts.guest` senza header: nessun accesso a Login o
  Registrati dalla pagina iniziale. Da decidere con il lavoro sul tema Four.
- `register_pub_theme` e' `false`: i componenti del tema Four non sono
  registrati, quindi i suoi layout (con `@vite(..., 'themes/Zero')`, tema
  sbagliato) non vengono mai usati.
- `Xot` Pest non parte in ambiente test: `pub_theme=BsItalia` ma
  `Themes/BsItalia` non esiste (`config/localhost/xra.php`).

## Diario

- 2026-10-06: bug riprodotto dal trace utente, header corretto con `@auth/@else`.
- 2026-10-06: migliorie UX (logo contestuale, ospiti mobile, i18n, a11y).
- 2026-10-06: verifica a runtime: header da ospite e da utente, `x-layouts.app`
  da ospite (stack originale) senza errori; `GET /it` 200; PHPStan e Pint puliti
  sui file PHP toccati (`routes/web.php`, `lang/{it,en}/auth.php`).
  Chiavi nuove: `ui::auth.navigation.primary`, `ui::auth.navigation.learn_more`.
