---
title: "DCP-360: il ritorno da Google e' una pagina Folio+Volt, non un controller"
type: story
status: done
module: User
created: 2026-10-26
updated: 2026-10-26
tags: [bmad, story, oauth, google, folio, volt, actions]
qmd: "google callback folio volt ProcessCallbackAction oauth.callback senza route classica senza web.php"
related:
  - ./dcp-269-login-google-localizzato-e-rientro-nella-lingua.story.md
  - ./dcp-271-google-senza-chiavi-errore-nostro-con-guida.story.md
issues: []
discussions: []
---

# DCP-360: callback Google come pagina Folio+Volt

Status: **done** (2026-10-26).

## Richiesta (2026-10-26)

L'utente ha provato il giro vero su `fixcity.eu` e ha chiesto di «implementare la pagina che usa google login come callback»
(`/it/auth/login/google/callback?state=...&code=...`) «utilizzando folio + volt, senza creare controller e senza modifiche a web.php»,
capendo il perche' e l'obiettivo.

## Perche' (l'obiettivo)

Nel progetto le pagine sono Folio+Volt e la logica sta in Actions (Spatie Queueable Actions). `ProcessCallbackController` era 70 righe di
orchestrazione di Actions gia' esistenti, raggiunte da una rotta scritta a mano in `Modules/User/routes/socialite.php`: colla che il
progetto vuole evitare, e un secondo posto dove dichiarare URL (oltre alle pagine). Una pagina Folio in `pages/auth/login/[provider]/callback`
e' raggiunta dal montaggio per lingua che Folio fa gia' (`Folio::path($path)->uri($locale)`), senza rotta nuova.

## Vincolo storico da superare con prova (DCP-269)

Il test `OauthLocalizedLoginFlowTest` diceva: «nessuna pagina Folio deve rispondere al loro posto (una vista Folio non puo' restituire un
redirect: risponde 200 vuoto)». Era l'esito di stub con `abort()`/`redirect` al livello superiore della vista: Folio esegue ogni pagina per
leggere `name()` e il 404 scattava in quella scansione. Qui nessun `abort()` al livello superiore: il lavoro sta nel `mount()` Volt e
la risposta e' un redirect vero. Va dimostrato con test, non assunto.

## Disegno

1. `Modules\User\Actions\Socialite\ProcessCallbackAction` (Queueable Action): il corpo del controller, spostato senza cambiare
   comportamento; `ProcessCallbackSession` ospita `oauth.entry_lang`.
2. Pagina Folio+Volt `Themes/Sixteen/resources/views/pages/auth/login/[provider]/callback.blade.php` con `name('oauth.callback')` e `@volt('auth.login.oauth-callback')`: gli URL
   per nome restano `/{lingua}/auth/login/{provider}/callback` (nomi Folio gia' localizzati dal provider Cms).
3. Rimossa la route callback classica da `routes/socialite.php`; resta `oauth.redirect` (non richiesto, decisione a parte).

## Criteri di accettazione

- [x] Nessuna rotta classica `oauth.callback` e nessun controller callback; la pagina Folio è presente.
- [x] `route('oauth.callback', ['lang' => 'it', 'provider' => 'google'])` risolve `/{lingua}/auth/login/google/callback`.
- [x] Test Socialite verdi: consenso negato, lingua d'ingresso, 404 su lingua/provider inventati.
- [x] Docs aggiornati (DCP-269, guida Google, piano Sixteen).

## Perche' la pagina sta nel tema e non nel modulo

`auth/login` e `auth/register` esistono in due copie (tema Sixteen e `Modules/User/resources/views/pages/auth`), e vince quella del tema.
Il callback segue la stessa convenzione: il tema possiede il guscio HTTP della rotta, il modulo User possiede la policy (`ProcessCallbackAction`).
`auth` e' una delle tre cartelle che `NoSemanticFolioPageDirectoriesTest` ammette in `Themes/Sixteen/resources/views/pages`. Due pagine con
lo stesso URI (una nel tema, una nel modulo) sarebbero una seconda sorgente: ne resta una.

## Prove (2026-10-26)

- `Modules/User/tests/Feature/Socialite` (scratch DB): 43 test, 199 asserzioni verdi; `OauthCallbackFolioPageTest`: 7 verdi, compresa la guardia
  «il file `ProcessCallbackController.php` non esiste».
- `NoSemanticFolioPageDirectoriesTest` verde (2 test): la cartella `auth` e' ammessa.
- PHPStan L10 senza errori su Action, `ProcessCallbackSession`, `GetProviderRedirectUriAction`, `RedirectToProviderController` e sul test.
- Sonda su `192.168.1.40:8000`: `/it/auth/login/google/callback` (senza codice, con `?error=access_denied`, con `?state=x&code=y`) risponde
  302 a `/{lingua}/auth/login`; `/en/...?error=access_denied` torna a `/en/auth/login`; provider o lingua inventati sono 404.

## Cosa NON e' provato

- Il giro vero con un `code` valido di Google: gli URI registrati sono solo `https://www.fixcity.eu/{it,en}/auth/login/google/callback` e
  da questa macchina il ritorno finisce sul server di produzione (altro IP). Il codice del ritorno e' coperto da test con `Socialite` finto.
- L'host: l'URL incollato dall'utente per il ritorno era `https://fixcity.eu/...` (apex), mentre il client Google incollato registra solo
  `https://www.fixcity.eu/{it,en}/...` e il `.env` di sviluppo usa `www`. Qual e' l'host che Google accetta in produzione va verificato in Google Cloud
  Console e nel `.env` del server: un `redirect_uri` diverso da quello registrato e' `redirect_uri_mismatch`.
- `routes/web_tall.php:70` nomina ancora `ProcessCallbackController` (`/sso/{provider}/callback`): il file non e' caricato
  (`route:list --path=sso` non mostra la rotta), quindi e' codice morto; non toccato perche' fuori dalla richiesta.

## Corsa fra agenti (lezione)

Tre sessioni hanno scritto lo stesso callback nello stesso quarto d'ora: tre Action con nomi diversi, due pagine Folio sullo stesso URI e un
controller cancellato e ricreato come «adattatore di compatibilita'» (senza l'`use` di `ProcessCallbackSession`: fatal al primo caricamento).
Si e' convenuto su `ProcessCallbackAction` + `ProcessCallbackSession` + pagina del tema. Il controller e' stato rimosso una volta per tutte e il
test ora fallisce se qualcuno lo ricrea. Prima di creare un file in un'area calda: `ls -la --time=...` o `find -mmin -10` e leggere la story.
