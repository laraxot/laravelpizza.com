# Story 7.1: Audit completo del front office (ospite e utente loggato)

Status: review

## Story

As a Visitatore o Partecipante,
I want che ogni pagina pubblica sia tradotta, accessibile, con un titolo proprio e senza esporre i dati personali di nessuno,
so that posso usare il sito con fiducia da computer e da telefono, in qualunque lingua.

## Acceptance Criteria

1. Ogni pagina pubblica ha un `<title>` proprio e una meta description nella lingua corrente (PRD FR-20 SEO).
2. Nessuna pagina pubblica mostra l'email o l'indirizzo di un'altra persona (organizzatore, profilo pubblico, JSON-LD).
3. Nessuna richiesta a siti terzi al caricamento delle pagine (cookie policy): niente Gravatar.
4. "Password dimenticata" funziona dall'inizio alla fine, nella lingua dell'utente, senza rivelare se un'email è registrata.
5. Pagine password, verifica email ed errori (403/404/419/429/500/503) tradotte in 6 lingue, con un `h1`, nel layout del tema.
6. Il logout dal menu mobile disconnette davvero.
7. `npm run audit:fo` (ospite + loggato, desktop + mobile, axe WCAG 2.1 AA) termina con "Nessun problema trovato".

## Tasks / Subtasks

- [x] Script `Themes/Meetup/scripts/front-office-audit.cjs` (`npm run audit:fo`) (AC: #7)
- [x] Titolo e descrizione per pagina: `Modules/Cms` `ResolvePageMetaAction` + `Metatags` con `title`/`description`, layout del tema (AC: #1)
- [x] Email organizzatore tolta dal dettaglio evento; profilo: email/indirizzo solo al titolare, niente email nel JSON-LD, id inesistente = 404 (AC: #2)
- [x] `xra.gravatar = false`, iniziali al posto dell'avatar remoto (AC: #3)
- [x] Broker password sulla connessione `user` (era `liveuser_general`, inesistente: errore 500); link dell'email nella lingua della richiesta con `?email=`; stesso messaggio per email sconosciute (AC: #4)
- [x] Pagine auth rifatte con `<x-ui.auth-card>`/`<x-ui.auth-field>`; verifica email senza evento `Verified` spurio; pagine di errore del tema (AC: #5)
- [x] Logout mobile su `route('logout')` (AC: #6)
- [x] Test `Modules/Meetup/tests/Feature/FrontOfficePrivacyAndSeoTest.php` (9 test, flusso reset completo)
- [x] Manuale d'uso aggiornato (password dimenticata, menu utente, profilo) e PDF rigenerati

## Dev Notes

- Dettaglio dei problemi e delle correzioni: `laravel/Themes/Meetup/docs/front-office-audit.md`.
- Architettura di `<title>`: `laravel/Modules/Cms/docs/page-title-and-description.md`.
- Privacy e reset password: `laravel/Modules/User/docs/front-office-privacy-avatar-password-reset.md`.

## Dev Agent Record

- 2026-11-12, Claude: audit eseguito su 29 pagine ospite, 12 pagine utente, 8 viste mobile; suite Project 405+ passati, PHPStan livello 10 senza errori sui moduli toccati.
