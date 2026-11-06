---
title: "DCP-271 - Accedi con Google senza chiavi: l'errore lo dà il nostro sistema, con la guida"
type: story
status: done
updated: 2026-10-26
tags: [docs, user, bmad, auth, google, socialite, filament-blueprint, ponytail]
qmd: "dcp 271 accedi con google senza chiavi client_id segnaposto ProviderNotConfigured guida console credenziali env back office"
related:
  - ../google-auth-login.md
  - ./dcp-269-login-google-localizzato-e-rientro-nella-lingua.story.md
  - ../../wiki/concepts/socialite-admin-configuration.md
---

# DCP-271 - Accedi con Google senza chiavi: l'errore lo dà il nostro sistema, con la guida

**Stato:** done (con i limiti in «Non verificato»). Richiesta dell'utente (2026-10-26) dopo aver provato `http://192.168.1.40:8000/it/auth/login`.

## Story

Come sviluppatore o amministratore che apre `/it/auth/login` senza aver configurato Google, voglio che il clic su
«Accedi con Google» non mi mandi a una pagina di errore di Google, ma torni al login con un errore del nostro sistema che
dice cosa manca, dove creare le credenziali e dove impostarle. Come cittadino voglio un messaggio gentile, senza
dettagli di infrastruttura.

## Perché (il senso) e cosa si mette in discussione

La richiesta dice: «l'errore deve contenere la spiegazione di dove creare le chiavi e dove impostarle».
Messa in discussione prima di scrivere codice:

1. **Chi legge l'errore?** Su un sito pubblico lo legge un cittadino, che non può creare chiavi su Google Cloud e non deve
   conoscere i nomi delle variabili d'ambiente (`GOOGLE_CLIENT_ID`): è un'informazione sull'infrastruttura, inutile per lui e
   utile a chi attacca. La guida serve a chi può agire: sviluppatore (ambiente locale, `APP_DEBUG=true`) e amministratore.
2. **Decisione:** guida completa nell'errore quando `APP_DEBUG` è attivo (è il caso di `192.168.1.40:8000`), sempre nel log
   (una riga, `warning`), mai al pubblico: lì un messaggio gentile con l'alternativa (email e password). Se l'utente vuole la
   guida anche in produzione, è una riga da cambiare nel gate `config('app.debug')`: da dire, non da fare di default.
3. **Si nasconde il pulsante se non configurato?** No: l'utente vuole vedere l'errore del sistema, e DCP-269 prova per lingua
   che l'href c'è. Resta una decisione di prodotto per la produzione (registro DCP-200): un pulsante che non può funzionare
   è un vicolo cieco per il cittadino.

## Cause trovate (misurate, non supposte)

| # | Causa | Evidenza |
|---|---|---|
| C1 | `ValidateProviderAction` e `IsProviderConfiguredAction` controllano solo `config()->has('services.google')`. `config/services.php` dichiara sempre la chiave, con `env()` che vale `null`: il controllo è sempre vero, `ProviderNotConfigured` non scatta mai. | `GET http://192.168.1.40:8000/it/auth/login/google` risponde 302 a `https://accounts.google.com/o/oauth2/auth?scope=openid+profile+email&response_type=code&state=...`, **senza `client_id` e senza `redirect_uri`**. Il `.env` non ha nessuna chiave `GOOGLE_*`. |
| C2 | Il messaggio di `ProviderNotConfigured` era in inglese, fisso, senza le variabili mancanti. Una modifica non committata di un'altra sessione lo ha riempito di emoji (regola del progetto: mai), URI sbagliato (`/it/auth/google/callback` invece di `/it/auth/login/google/callback`), `https` su una porta http, un rimando a `docs/third-brain/...` che non esiste e un nowdoc che non interpola le variabili; e comunque non veniva mai lanciato (C1). | Lettura del file e `ls docs/third-brain`. |
| C3 | **La pagina del back office per impostare le credenziali è rotta dal 2026-10-20.** `SocialiteProviderSettingsPage` fa `route('oauth.callback', 'google')`; dopo DCP-269 la rotta vuole `{lang}` e `{provider}`: `UrlGenerationException: Missing parameter: provider`. Indicare quella pagina nella guida sarebbe stato indicare una pagina che lancia. | `php artisan tinker`: `route("oauth.callback", "google")` lancia; con `["lang"=>"it","provider"=>"google"]` dà `/it/auth/login/google/callback`. |
| C4 | Le credenziali si possono impostare in due modi che convergono in `services.*`: `.env` (`config/services.php`) oppure la pagina del back office, che scrive `storage/app/private/socialite-config.php` (letto da `SocialiteServiceProvider` all'avvio). | `SocialiteServiceProvider::loadAdminSocialiteConfig`. |

## Decisioni

- **Una sola definizione di «configurato»:** `client_id`, `client_secret` e `redirect` non vuoti e non segnaposto
  (`your-...`, `google-client-id...`). Un'Action elenca cosa manca (nomi delle variabili d'ambiente); `IsProviderConfiguredAction`
  e `ValidateProviderAction` la riusano. Si corregge dove passano tutti i chiamanti (redirect e callback), non nel solo controller.
- **L'eccezione si rende da sola** (`render()`): rimanda a `/{lang}/auth/login` con `RedirectToLoginAction` (stessa lingua, stesso
  blocco d'errore di DCP-269) e si registra da sola (`report()`: una riga `warning`, non uno stack trace a ogni clic).
- **Un solo URI da registrare**, calcolato in un'unica Action (`/{lang predefinita}/auth/login/{provider}/callback`, come
  stabilito da DCP-269) e usato sia dalla guida sia dalla pagina del back office (corregge C3).
- **Testi nei file di lingua** (it, en, de, es), non nel PHP: la guida è un testo con segnaposto, i link alle console stanno
  nell'Action che la costruisce.
- **Nessun emoji, nessuna pagina Folio, nessun file nel tema** (regole del progetto).
- **Filament Blueprint:** nessuna risorsa o pagina nuova. Il messaggio passa dal blocco d'errore del widget di login e dalla
  `Notification` di Filament già esistenti. Si corregge una pagina esistente (C3). Una colonna «configurato» nell'elenco dei
  provider del back office è una proposta, non implementata (YAGNI finché nessuno la chiede).

## Domande agli altri agenti (2026-10-26)

- Sessioni `base-fixcity-fila5-d0` e `base-fixcity-fila5-29`: messaggio inviato con causa, difetti della modifica a
  `ProviderNotConfigured` e perimetro dei file. **Nessuna risposta**: le due sessioni sono rimaste inattive e la data di
  modifica del file è rimasta ferma, quindi ho sostituito il file. La loro versione (non committata) è salvata fuori dal
  repo, nella cartella temporanea della sessione, e non è stata applicata: aveva emoji, URI sbagliato e un rimando a
  documenti inesistenti (vedi C2). Chi vuole recuperarne un'idea la trova nel registro della sessione, non nel repo.
- Verificatore dei fatti Google (agente di ricerca, sola lettura, contro la documentazione ufficiale):
  - gli URI di reindirizzamento devono essere `https`, tranne `localhost`;
  - gli IP grezzi non sono ammessi (tranne gli IP di localhost);
  - il dominio deve avere un suffisso pubblico (public suffix list);
  - percorso della console: Google Cloud Console > Google Auth Platform > Clients > Create client > Web application, dopo aver
    compilato Branding e Audience; indirizzo ufficiale `https://console.developers.google.com/auth/clients`;
  - Microsoft: `https://entra.microsoft.com` > App registrations;
  - GitHub: Settings > Developer settings > OAuth Apps > New OAuth App. L'indirizzo `https://github.com/settings/developers`
    **non è stato verificato** dall'agente (lo conosco, ma non è una prova).
  - Socialite non lancia con valori nulli: omette `client_id` e `redirect_uri` dall'indirizzo (`SocialiteManager.php`,
    `AbstractProvider`), ed è per questo che Google riceveva una richiesta incompleta.
  - Conseguenza: sull'host LAN `http://192.168.1.40:8000` il callback non si può registrare. La guida propone
    `http://localhost:PORTA/...` (tunnel SSH) o un dominio `https`. Misurato sulla pagina vera: la guida dice
    `http://localhost:8000/it/auth/login/google/callback`.

## Piano (TDD)

1. Test rosso: senza credenziali il clic non va a Google, torna a `/{lang}/auth/login` con errore, nelle 4 lingue.
2. Test rosso: con `APP_DEBUG` la guida contiene variabili, console e URI esatto; senza `APP_DEBUG` non contiene nomi di variabili.
3. Test rosso: valori segnaposto contano come mancanti; con credenziali complete il flusso di DCP-269 resta uguale.
4. Implementazione minima, poi test verdi, PHPStan sui file toccati, prova in browser sulla pagina vera.

## Verifica

- **Test su database usa-e-getta** (`bashscripts/tools/pest-scratch-db.sh Modules/User/tests/Feature/Socialite Modules/User/tests/Unit/Actions/Socialite`):
  88 verdi, 2 rossi, 3 «risky», 1 todo (272 asserzioni). I 2 rossi sono preesistenti e non miei (vedi sotto). I test nuovi sono verdi:
  `OauthProviderNotConfiguredTest` (senza credenziali non si arriva a Google, 4 lingue; guida in debug; messaggio gentile senza
  debug; segnaposto = mancante; host LAN propone localhost; host accettato dà il suo callback; una sola riga `warning`;
  configurazione completa va ancora a Google) e `ProviderSettingsActionsTest`.
- Prima del codice i test erano rossi (26 rossi su 27, il solo verde era il controllo «configurazione completa»).
- Il test del log usa un registro di prova (`Log::swap`): in test `LOG_LEVEL=error` scarta i `warning` prima che parta
  `MessageLogged`, quindi un ascoltatore di eventi dava 0 al posto di 1.
- **PHPStan** da `laravel/` con la config unica sui 10 file toccati: `[OK] No errors`.
- **Pagina vera** `http://192.168.1.40:8000/it/auth/login`: `curl` su `/it/auth/login/google` dà 302 a `/it/auth/login` (prima:
  302 a `accounts.google.com` senza `client_id`). Playwright: il clic su «Accedi con Google» resta sul login e mostra un solo
  blocco `.auth-login-alert` con cosa manca, console, URI da registrare (`http://localhost:8000/it/auth/login/google/callback`),
  `.env` e `php artisan config:clear`, pagina del back office, avviso sull'IP.
- **Difetto trovato guardando i pixel e corretto:** a 375 px gli URL lunghi uscivano dal riquadro (`scrollWidth > clientWidth`).
  `overflow-wrap: anywhere` su `.auth-login-alert__text` (`Themes/Sixteen/resources/views/components/pages/auth-login.blade.php`,
  stile inline: nessun rebuild). Rimisurato: nessun overflow, la pagina non scorre in orizzontale.
- **Pagina del back office (C3):** il sorgente non chiama più `route('oauth.callback', '...')`; un test sul sorgente lo impedisce.

## Non verificato

- **Nessun giro vero con Google e credenziali vere.** Provato solo fino a `accounts.google.com` con credenziali finte nei test.
- **Il salvataggio della pagina del back office non è stato eseguito.** `save()` chiama `Artisan::call('config:clear')` e scrive
  `storage/app/private/socialite-config.php` vero: non si lancia in un test. Corretto il codice che lanciava
  `UrlGenerationException`, ma l'apertura e il salvataggio da browser con un utente amministratore non sono provati.
- **3 test rossi preesistenti, non toccati e non indagati:** `SocialiteUtilityActionsTest` «returns true as default when
  registration config is missing» (`(bool) config('socialite.registration', true)` con valore nullo) e «logs out user token and device
  sessions» (TypeError di Mockery su `UserContract::token()`); `UserQuickWinsCoverageTest` «returns default option plus team options»
  (non nel perimetro di questa esecuzione).
- **Chiavi di lingua `fr` e `ru`** non aggiunte: non sono lingue del sito (it, en, de, es).
- **Guida in produzione:** oggi appare solo con `APP_DEBUG=true`. Mostrarla anche al pubblico, o nascondere il pulsante quando il
  provider non è configurato, resta una **decisione dell'utente** (registro DCP-200), non presa qui.
- **Indirizzo della console GitHub** non verificato da una fonte ufficiale (vedi sopra).
- Proposte non fatte (YAGNI finché nessuno le chiede): colonna «configurato» nell'elenco dei provider del back office; voce
  «credenziali Google» nel gate go-live.
- **Nulla è stato committato**: l'utente non l'ha chiesto. La modifica al tema (`overflow-wrap`) sta nel repo separato `Themes/Sixteen`.

## Aggiornamento: chiavi reali del client Google (2026-10-26)

L'utente ha fornito il client web del progetto Google Cloud `fixcity-512809`. Nel `.env` di sviluppo ci sono `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET` e
`GOOGLE_REDIRECT_URI=https://www.fixcity.eu/it/auth/login/google/callback`. Il segreto sta **solo** nel `.env` (ignorato da git): mai in config tracciata,
docs, memoria o log.

- **URI registrati in Google Cloud:** `https://www.fixcity.eu/{it,en}/auth/login/google/callback`. Basta quello `it`: il `redirect_uri` e' uno solo (DCP-269) e
  la lingua d'ingresso torna dalla sessione, quindi de ed es funzionano senza URI propri. Gli origins JavaScript non servono: il giro e' lato server.
- **Provato:** `GetMissingProviderSettingsAction` non segnala mancanze; `/{it,en,de,es}/auth/login/google` risponde 302 a `accounts.google.com` con `client_id`,
  `redirect_uri` registrato, `state`, scope `openid profile email` e nessun segreto nell'URL; Google risponde con la pagina di accesso
  (`signin/identifier`), senza `redirect_uri_mismatch` ne' `invalid_client`; 35 test Socialite verdi (183 asserzioni).
- **Non provato:** il ritorno su `/auth/login/google/callback` e lo scambio del codice. Google accetta solo gli URI registrati, tutti su `www.fixcity.eu`:
  dall'istanza di sviluppo (`192.168.1.40`) il giro termina in produzione. Per provarlo in locale registrare `http://localhost:8000/it/auth/login/google/callback`
  in Google Cloud e usare un tunnel SSH (vedi sopra).
- **Produzione:** `fixcity.eu` (46.225.90.178) e' un altro server. Servono le stesse tre variabili nel suo `.env`, poi `php artisan config:clear`
  (o `config:cache` se la cache e' in uso) e un controllo di `/it/auth/login/google`.
- **Incidente:** due agenti hanno scritto lo stesso blocco `GOOGLE_*` nel `.env` e il secondo aveva un segreto sbagliato (36 caratteri contro 35). Nel `.env`
  vince l'ultima occorrenza, quindi era quello in uso e avrebbe dato `invalid_client` allo scambio del codice. Tenuta l'unica terna uguale al valore fornito.
  Lezione: un controllo di esistenza della chiave non prova che il valore sia giusto; va confrontato.
- **Rotazione:** il segreto e' passato nella chat della sessione; valutare di reimpostarlo in Google Cloud Console (Credenziali, client, Reimposta segreto).
