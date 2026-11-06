---
id: dcp-369
title: "DCP-369: login Google, collegamento per email, consenso e sessione prima di aprirlo ai cittadini"
type: story
status: backlog
owner: module:User
module: User
created: 2026-10-26
updated: 2026-10-26
tags: [bmad, story, oauth, google, sicurezza, gdpr, sessione]
qmd: "google login firstWhere email email_verified takeover email_verified_at session regenerate intended lingua consenso gdpr redirect_uri apex www segreto"
related:
  - ./dcp-269-login-google-localizzato-e-rientro-nella-lingua.story.md
  - ./dcp-271-google-senza-chiavi-errore-nostro-con-guida.story.md
  - ./dcp-360-google-callback-pagina-folio-volt.story.md
  - ../../stories/register-logout-verify-email.story.md
issues: []
discussions: []
---

# DCP-369: Google login, cosa manca prima di aprirlo ai cittadini

Status: **backlog**. Non implementata qui: i file toccati sono quelli di DCP-360, in modifica da un'altra sessione.

## Perche' (l'obiettivo)

Il login con Google serve a far entrare un cittadino senza password, **senza abbassare il livello di fiducia** dell'account. Oggi il giro
tecnico c'e' (DCP-269, 271, 360): redirect localizzato, callback come pagina Folio+Volt, chiavi nel `.env`. Mancano le garanzie che rendono
sicuro l'ingresso: chi e' la persona, cosa ha accettato, e che la sessione sia nuova.

## Cosa ho verificato nel codice attuale (2026-10-26)

| Punto | Prova | Rischio |
|---|---|---|
| Collegamento a un utente esistente solo per email | `Actions/Socialite/ProcessCallbackAction.php:49`: `firstWhere(['email' => $oauthUser->getEmail()])`; nessun controllo di `email_verified` (compare solo in un commento di `RetrieveOauthUserAction.php`) | Chi registra in anticipo l'email di una vittima, con una password sua, resta dentro dopo che la vittima entra con Google (pre-hijacking) |
| Nuovo utente senza email verificata | `CreateUserAction.php:44` imposta l'email, nessun `email_verified_at` | Con `auth.must_verify_email` attivo il nuovo utente Google puo' essere rimandato alla verifica (non provato dal vivo) |
| Nessuna rigenerazione di sessione | nessun `regenerate` in `ProcessCallbackAction`, `LoginUserAction`, `RegisterOauthUserAction`; il login con password la fa in `LoginWidget` | Session fixation |
| Rientro senza lingua | `LoginUserAction.php:34`: `redirect()->intended('/')` | Dopo il login si perde `/it/` e `GetPostLoginUrlAction` e' ignorata |
| Nessun consenso Gdpr | il percorso Google non passa dal `RegisterWidget` dove si salvano i trattamenti | Account creato senza prova di accettazione (vedi DCP-178) |

Prova dal vivo (curl sul dev :8000): il callback senza consenso torna a `/{lingua}/auth/login` conservando la lingua; provider o lingua inventati
danno 404. `socialite_users` e' vuota: il giro completo non e' mai stato eseguito.

## Decisioni da prendere (dell'utente)

- **D1. Utente locale con la stessa email:** collegare solo se Google dice `email_verified` **e** l'email locale e' verificata; altrimenti non
  collegare e dire di accedere con la password e collegare Google dalle impostazioni. Alternativa piu' permissiva: collegare e azzerare la password.
- **D2. Nuovi utenti Google:** impostare `email_verified_at` solo se Google dice `email_verified`.
- **D3. Consenso:** passo di accettazione di privacy e termini al primo accesso Google, con prova salvata (dipende da DCP-178 e dai testi legali).

## Disegno minimo (ponytail)

1. In `ProcessCallbackAction`: leggere `email_verified` dal payload del provider e applicare D1/D2. Nessuna classe nuova.
2. In `LoginUserAction`: `session()->regenerate()` dopo il login e redirect tramite `GetPostLoginUrlAction` con ripiego sulla lingua d'ingresso
   (`ProcessCallbackSession::KEY`).
3. Test Pest su DB scratch (vedi nota `pest-scratch-db`): collegamento rifiutato con `email_verified=false`, id di sessione cambiato dopo il login,
   redirect con prefisso lingua.

## Fuori dal codice

- **Segreto OAuth esposto.** Il client secret e' stato incollato in una conversazione: va ruotato in Google Cloud prima della produzione
  (la guida `google-oauth-frontoffice-setup.md` lo dice gia'). Non scriverlo in nessun file versionato: solo `.env` del server.
- **Produzione.** `fixcity.eu` serve ancora il codice vecchio (pulsante senza lingua, `client_id` segnaposto): serve il deploy di `Modules/User` e del
  tema Sixteen, poi `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI` nel `.env` del server e `config:clear`.
- **www e apex.** `www.fixcity.eu` risponde 301 verso `fixcity.eu`: Google rimanda su www e il browser finisce sull'apex. Il cookie di sessione
  e' legato all'host: funziona solo perche' il giro parte sempre dall'apex. Registrare in Google anche gli URI dell'apex toglie la dipendenza.
- **Dev.** Google non accetta `192.168.1.40` come redirect: sul dev il giro si ferma al redirect; per provarlo serve un tunnel su localhost.
- Igiene: `RetrieveOauthUserAction.php:52-61` contiene in un commento un indirizzo email reale; sostituirlo con uno `@example.test`.
