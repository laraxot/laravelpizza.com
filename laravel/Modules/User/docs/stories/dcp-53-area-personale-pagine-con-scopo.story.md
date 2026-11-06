---
id: dcp-53
title: "Area personale: ogni pagina ha uno scopo e una funzione"
type: story
epic: dc-parity-v2
status: in-progress
priority: P0
owner: module:User
module: User
created: 2026-10-13
updated: 2026-10-13
tags: [area-personale, ux, i18n, mobile]
related: [Themes/Sixteen/docs/bmad/stories/dcp-52-header-accesso-e-menu-utente.story.md]
qmd: "dcp-53 Area personale: ogni pagina ha uno scopo e una funzione"
---

# DCP-53: area personale con scopo e funzione

## Richiesta (2026-10-13, utente)
Riferimenti: `sito/segnalazione-area-personale`, `servizi/graduatoria-area-personale`, `graduatoria-messaggio`, `permessi-area-personale`, `vantaggi-area-personale`, `pagamenti-multa-area-personale`, `pagamenti-imu-area-personale` (https://italia.github.io/design-comuni-pagine-statiche/). Il contenuto deve essere sensato (non «Mario Rossi»), con scopo e funzione, multilingua, ottimizzato per cellulare e tablet.

## Riferimento (segnalazione-area-personale, letto il 2026-10-13)
Header: menu utente (nome, I miei servizi, Le mie pratiche, Notifiche, Impostazioni, Esci). Pagina: breadcrumb Home / Area personale; scheda utente (nome, CF); schede Scrivania / Messaggi / Attivita' / Servizi; «Ultimi messaggi» (data, categoria, titolo, estratto, «Vedi altri messaggi»); «Ultime attivita'»; «Pratiche» (filtra, ordina, voci con titolo, stato «In attesa»/«Conclusa», data, «Pratica: <codice>», «Scheda servizio», azioni) e «Pagamenti».

## Stato esistente
Vedi DCP-52, sezione Evidenza: `pratiche` funziona, `impostazioni` funziona, `servizi` e' un segnaposto, `notifiche` e' rotta, markup Tailwind dentro `<x-layouts.app>` (che gia' ha un `<main>`: `<main>` annidati).

## Studio (subagent AP-PAGES)
Studio di sola lettura del 2026-10-13. [V] = misurato o letto nel codice; [I] = ipotesi da provare.

### Metodo e limiti
- Playwright con `storageState` della sessione di sviluppo (utente `master_admin` «Marco Sottana», 0 segnalazioni proprie), 1440/768/375 px, it/en/de/es, axe wcag2a/2aa/21a/21aa senza debugbar, richieste HTTP con la stessa sessione e `maxRedirects: 0`, `php artisan folio:list`, `php artisan tinker --execute` con soli SELECT/count e `Auth::setUser()` (nessuna scrittura). «Esci» mai cliccato. Script nello scratchpad, non nel repo.
- Il repo cambia mentre si misura (DCP-110/111 in corso): istantanea A = 16:57 UTC, istantanea B = 17:13-17:22 UTC. Nessuna pagina e' stata misurata con un utente che ha segnalazioni: l'elenco pieno e' provato solo sui dati (tinker) e sul codice.
- Correzione alla richiesta: i sei riferimenti dei servizi sono `.../design-comuni-pagine-statiche/servizi/<nome>.html` (con `sito/servizi/` rispondono 404) [V].

### 1. Riferimento -> FixCity
Struttura comune a tutte le pagine `*-area-personale` [V, scaricate con curl, lette senza JS]: breadcrumb Home / Area personale; `h1` = nome + `CF:`; schede Scrivania / Messaggi / Attivita' / Servizi; «Indice della pagina»; `h2` Ultimi messaggi (2 card: titolo, estratto con «La richiesta AN4059281 e'...», «Vedi altri messaggi»); `h2` Ultime attivita' (3 voci, «Vedi altre attivita'»); `h2` Pratiche (Filtra, Ordina, Azione 1-3, ricerca; voci a fisarmonica con titolo, stato In attesa / Da completare / Conclusa, data, «Pratica: codice», «Scheda servizio», allegati, «Perfeziona la richiesta»); `h2` Pagamenti (voci «Pagato»); `h2` Contatta il comune (FAQ, assistenza, numero verde, prenota appuntamento); scheda «Graduatoria 2022/23». Menu utente del riferimento: I miei servizi, Le mie pratiche, Notifiche, Impostazioni, Esci.

| Pagina | Cosa ha di proprio | Equivalente FixCity |
|---|---|---|
| `segnalazione-area-personale` | unica con pratica «Segnalazione disservizio» (In attesa, 20/03/2022, AN4059281) e voce tra le attivita' | SI, e' il nucleo: «Le mie segnalazioni» con stato, data, codice, tracciamento |
| `graduatoria-area-personale` | iscrizione infanzia «Da completare», link «Graduatoria», card graduatoria | NO (graduatoria). Solo il pattern «serve un tuo intervento» ha senso, e solo con una funzione di richiesta integrazioni che non esiste [I] |
| `graduatoria-messaggio` | pagina documento: allegati (Ammessi, Lista d'attesa), «Tempi e scadenze» (4 date), «Consulta la richiesta» | PARZIALE: «Tempi e scadenze» = timeline di avanzamento (gia' in `/tickets/track`, `BuildTicketTimelineAction`); allegati = foto della segnalazione (Media); «Consulta la richiesta» = «Apri la segnalazione» |
| `permessi-area-personale` | permesso ZTL, atto autorizzativo, «Paga ora», pagamento PagoPA; blocco «Problemi in citta'» con «Segnala disservizio» | permesso e pagamenti NO. SI al solo blocco «Segnala disservizio» = CTA «Nuova segnalazione» |
| `vantaggi-area-personale` | assegno maternita', «Vantaggio economico» | NO (servizio non erogato) |
| `pagamenti-multa-area-personale` | multa, PagoPA, importo 38,92 EUR, ricevuta | NO (pagamenti) |
| `pagamenti-imu-area-personale` | Calcolo IMU, F24 | NO (pagamenti) |

| Blocco del riferimento | In FixCity | Dato reale |
|---|---|---|
| `h1` nome e CF | SI il nome reale; NO il CF (non raccolto, minimizzazione) | `users.name` |
| Ultimi messaggi | «Ultimi aggiornamenti» sulle mie segnalazioni | tabella `notifications` (`TicketStatusChangedNotification`: titolo, testo, `action_url`, `read_at`) |
| Ultime attivita' | non separata in v1: i cambi di stato stanno gia' negli aggiornamenti; la cronologia completa e' la timeline del singolo tracciamento | `ticket_activities` (0 righe in dev) |
| Pratiche | «Le mie segnalazioni» + «Segnalazioni che seguo»; filtro In corso / Concluse | `tickets.owner_id`, `ticket_subscribers` |
| Pagamenti, Servizi, Graduatoria | NO, non si replicano con dati inventati | nessuno |
| Contatta il comune | SI ridotto ai soli link che funzionano: FAQ (`/it/domande-frequenti` 200 [V]); `/it/assistenza` 404 [V], quindi non mostrare finche' non esiste | pagine CMS |

### 2. Pagine esistenti: stato misurato, difetti, causa
Causa radice comune [V]: `Modules/Cms/app/Providers/FolioVoltServiceProvider.php:112-122` monta il percorso del TEMA prima di quelli dei moduli (moduli da `:140-166`); Folio sceglie il primo mount che corrisponde (`vendor/laravel/folio/src/RequestHandler.php:32-38`, `break` al primo `match`). Le pagine dinamiche del tema (`Themes/Sixteen/resources/views/pages/[container0]/index.blade.php` e `[container0]/[slug0]/index.blade.php`) corrispondono a qualunque URL con 1 o 2 segmenti: con 2 segmenti rispondono 200 con `<main>` vuoto se manca il JSON; con 1 segmento fanno `abort_if(..., 404)` (`[container0]/index.blade.php:43`). Conferma: lo snapshot Livewire di `/it/area-personale/pratiche` alle 16:57 nomina il file del tema, non quello del modulo. Per questo `folio:list` mostra `/it/dashboard` e `/it/notifications` ma rispondono 404.

| URL (it e en uguali, salvo nota) | A 16:57 | B 17:13 | Difetti e causa |
|---|---|---|---|
| `/area-personale/pratiche` | 200, `<main>` vuoto (0 caratteri), nessun `h1` | 200, `h1` «Le mie segnalazioni», 1 `<main>`, vuoto-stato, overflow 0 | A: oscurata dal tema. Sorgente morto `Modules/User/.../area-personale/pratiche.blade.php`: doppio `<main id="main-container">` (`:42`, dentro `layouts/app.blade.php:19`), nessuno stato/codice/link di tracciamento, `__('Inviata il')` chiave grezza, `.lock` del 2026-09-26 stantio |
| `/area-personale/seguite` | 200 vuoto | 200, `h1` «Segnalazioni che seguo», vuoto-stato | A: nessun JSON; esisteva solo in `Themes/Sixteen/resources/views/pages_old/area-personale/seguite.blade.php` |
| `/area-personale/notifiche` | 200 vuoto | 200, `h1` «Notifiche», 3 voci con «Apri la segnalazione» (`/tickets/track?code=DEMO-00x`, tutti 200) | Sorgente morto `notifiche.blade.php:17` reindirizza a `/notifications` (404 per la causa comune; il vero file `notifications/index.blade.php:7-8` ha Bootstrap `container/row/card` e il widget Filament `NotificationsCenterWidget`, non riusabile con lo stile del tema) |
| `/area-personale/impostazioni` | 200 vuoto | 200, 3 sezioni (notifiche email, i tuoi dati, i tuoi diritti), `h1` unico | Sorgente morto `impostazioni.blade.php:36` e' un segnaposto. Residui B: `.progress-bar.it-navscroll-progressbar` senza nome (axe `aria-progressbar-name` serious, it/en 1440); link dell'indice alti 24 px; dati sola lettura, nessuna lingua preferita, nessun download/cancellazione (lo dice la pagina stessa) |
| `/area-personale/servizi` | 200 vuoto, anche da ospite | invariato | segnaposto `servizi.blade.php:36`; soft-404 non protetto; nessuna funzione in FixCity |
| `/profile/edit` | 200 vuoto, anche da ospite | invariato | sorgente `profile/edit.blade.php` 714 righe mai raggiunta; vedi sotto |
| `/area-personale` | 404 | 404 | nessuna pagina: non esiste la scrivania |
| `/dashboard` | 404 | 404 | `dashboard/index.blade.php` e' lo starter Genesis (testo «Thanks for using Genesis», link Lemon Squeezy, immagine `cdn.devdojo.com`) oscurato dal tema; `route('dashboard')` e' il redirect di default dopo login e registrazione: `LoginWidget.php:62-64`, `RegisterWidget.php:115-117`, `VerifyEmailController.php:62`, `SpidAuthController.php:38,103`, `CieAuthController.php:37,66,138`, `ProfileEditVoltComponent.php:117` [V]. Dopo un login senza URL «intended» si arriva a un 404 |
| `/notifications` | 404 | 404 | causa comune |
| `/lista-categorie` | 500 | 500 | `[container0]/index.blade.php:78` include `pub_theme::pages.services.categories-content`, che esiste solo in `pages_old/services/categories-content.blade.php` (spostata con `pages` -> `pages_old`); log: `View [pages.services.categories-content] not found` (`FileViewFinder.php:138`). Fuori dall'area personale ma e' un 500 del front office |
| Chrome (tutte) | `#header-user-toggle` senza nome sotto `lg` (axe `button-name` critical a 375, anche su `/tickets/create`) | invariato | `header/design-comuni.blade.php`: la iniziale e' in uno `span aria-hidden`, il nome in `d-none d-lg-block`; serve `aria-label` col nome |

Altri difetti [V]:
- `profile/edit.blade.php`: `mount()` fa `redirect()->route('login')` (`:143`) e `redirect()->route('dashboard')` (`:153`) senza `return`, quindi non reindirizza; `Assert::stringNotEmpty($this->first_name)` (`:128`) fallisce per i 6 utenti su 9 con `first_name` vuoto; `layout('x-layouts.app')` (`:29`) piu' `<x-layouts.app>` nel template; testo inglese non tradotto; `deleteAccount()` (`:384-433`) fa `$user->delete()` senza `SoftDeletes` (`BaseUser.php:149` commentato) e senza gestire le segnalazioni.
- `/it/auth/login` risponde 200 a un utente gia' loggato (dovrebbe andare alla scrivania); `/it/auth/register` risponde 403.
- Link B su 5 pagine: i 7 link del contenuto sono 200. Nel chrome 9 link dell'header e 11 del footer, senza prefisso lingua, sono 404 (`/servizi`, `/novita`, `/amministrazione`, `/argomenti*`, `/privacy`, `/note-legali`, `/accessibilita`, `/assistenza`, `/mappa-del-sito`...). Con prefisso `/it/privacy`, `/it/note-legali`, `/it/accessibilita` restano 404 [V]: manca l'informativa privacy (GDPR art. 13) e le «Impostazioni e privacy» non possono linkarla.
- Console: solo i `Refused to get unsafe header "phpdebugbar-*"` della debugbar di sviluppo; nessun errore JS e nessuna sottorichiesta 4xx/5xx sulle 4 pagine nuove.
- Bersagli tattili: `Home` del breadcrumb 41x24, indice 306x24: superano WCAG 2.5.8 (24 px) ma non il nostro 44 px.
- Gli URL restano italiani in tutte le lingue (`/de/area-personale/pratiche`); le etichette sono tradotte in de/es senza chiavi grezze [V]. Traduzione delle rotte: STORY-410.

### 3. Dati che esistono davvero
| Funzione | Sorgente (file:riga) | Stato nel DB di sviluppo |
|---|---|---|
| Le mie segnalazioni | `BuildAuthenticatedUserTicketsQueryAction.php:23-27` (`owner_id`, piu' recenti prima); colonne `code`, `status`, `type`, `location`, `created_at` | utente di prova 0; un altro utente 2: `TCK-NFZ...` e `AN4059281`, stato `pending` = «In attesa» |
| Stati leggibili | `TicketStatusEnum.php:23-35` (9 casi con `getLabel()`); pubblici `:46-57`, interni (draft, pending) `:64-70` | tutti i valori hanno etichetta |
| Tracciamento | `/tickets/track?code=` (`GetPublicTicketByCodeAction`, token di capacita', funziona anche per `pending`); `?ticket_id=` con `Gate::authorize('view')` (`tickets/track.blade.php`) | 200 |
| Dettaglio | `/tickets/{id}` usa `BuildPublicTicketsQueryAction.php:27` `whereNotNull('location')`: 404 per le segnalazioni senza posizione, anche del proprietario (id 27: 404 [V]; 3 su 15 in dev) | usare il tracciamento per codice come link primario; dettaglio solo se esiste |
| Timeline cittadino (STORY-396) | `BuildTicketTimelineAction.php:23-27` (solo `status_change` con visibilita' `public`) | `ticket_activities` = 0 righe |
| Chi cambia stato | `ChangeStatus.php:49` `is_int($actorId) ? ... : null`: gli utenti hanno id UUID, quindi l'autore non si registra [I: `user_id` e' `foreignId`, intero; non provato con una scrittura] | n/d |
| Notifica al cambio di stato | `TicketActivityObserver.php:13-16` -> `NotifyTicketSubscribersOfStatusChangeAction.php:22-88` -> `TicketStatusChangedNotification.php:34-43` (canale `database` sempre; `mail` se email verificata e preferenza attiva `:74-80`); solo per stati pubblici | tabella `notifications` sulla connessione `user`: 15 righe tutte non lette + 3 create da un altro agente per l'utente di prova alle 17:1x |
| Preferenza email | `profiles.preferences.fixcity.email_ticket_updates` (`GetFixcityEmailNotificationPreferenceAction.php:16-33`, `Set...:15-37`), widget `TicketNotificationPreferencesWidget` | `profiles` 2 righe su 9 utenti (riga creata al primo salvataggio); `preferences` null |
| Account | `users.name, first_name, last_name, email, email_verified_at, lang`; `profiles.phone, locale, timezone, avatar, bio` | `first_name` vuoto per 6 utenti su 9; `profiles.locale/timezone` mai valorizzati; `phone` 1 riga |
| Lingua preferita | `users.lang` (8 `it`, 1 vuoto); `SetFolioLocale.php:39-48` la usa solo se l'URL non ha il prefisso lingua | nessuna interfaccia per cambiarla; locali serviti: de, en, es, it |
| Consensi GDPR | `Modules/Gdpr`: `Consent`, `Treatment`, `SaveGdprConsentsAction.php:43` (`if ($treatment)`), `UpdateGdprConsentsAction` senza chiamanti nel front office, trait `HasGdpr` non usato da `User` | `consents` 0, `treatments` 0: senza i 3 trattamenti (`privacy_policy`, `terms_conditions`, `marketing_consent`) la registrazione NON registra alcun consenso [V dal codice, non provato con una registrazione] |
| Esportazione (art. 15 e 20) | non esiste; solo la chiave lang `Gdpr/lang/it/gdpr.php:125` | assente |
| Cancellazione (art. 17) | `profile/edit.blade.php:384-433`, irraggiungibile e distruttiva | vedi difetti |
| Seguire una segnalazione | `ticket_subscribers` (connessione `user`), `SetTicketSubscriptionAction`, «Segui gli aggiornamenti» nel dettaglio pubblico (3 occorrenze in `/it/tickets/29` da ospite) | 0 righe; bottone non provato da loggato [I] |

### 4. Proposta
Scopo dell'area: rispondere a «che fine ha fatto la mia segnalazione e cosa devo fare», avvisare quando cambia, far controllare i propri dati. Niente servizi, pagamenti o permessi.

**4.1 Menu utente dell'header** (pulsante = nome reale, email se manca; sotto `lg` iniziale con `aria-label` col nome)
| Voce it / en / de / es | Destinazione | Funzione e perche' ha senso |
|---|---|---|
| Area personale / Personal area / Persönlicher Bereich / Área personal | `/{lang}/area-personale` | scrivania e landing dopo il login; risolve il 404 di `route('dashboard')`. NUOVA |
| Le mie segnalazioni / My reports / Meine Meldungen / Mis incidencias | `/area-personale/pratiche` | elenco con stato e tracciamento: la funzione principale |
| Segnalazioni che seguo / Reports I follow / Meldungen, denen ich folge / Incidencias que sigo | `/area-personale/seguite` | ritrovare cio' che ho scelto di seguire |
| Notifiche (con numero di non lette se > 0) / Notifications / Benachrichtigungen / Notificaciones | `/area-personale/notifiche` | cronologia degli aggiornamenti di stato, segna come letta |
| Impostazioni e privacy / Settings and privacy / Einstellungen und Datenschutz / Ajustes y privacidad | `/area-personale/impostazioni` | email, lingua, dati, diritti GDPR |
| Esci / Sign out / Abmelden / Cerrar sesión | POST logout | chiude la sessione (gia' fatto) |
Fuori dal menu: «Nuova segnalazione» sta nella scrivania e nell'header del sito (un solo posto per azione). Tolti rispetto al riferimento: «I miei servizi» (FixCity non eroga servizi). Le quattro etichette esistenti sono quelle gia' misurate nelle 4 lingue; vanno aggiunte solo «Area personale» e il contatore.

**4.2 Scrivania `/area-personale`** (JSON `area-personale.index`, `middleware: ["auth"]`, `layout: design-comuni`, blocco `personal-area-desk`; ospite -> login localizzato)
Primo schermo, in quest'ordine (375 e 1440 px):
1. Breadcrumb Home / Area personale; `h1` «Area personale», sotto «{nome} - {email}» (niente CF).
2. Pulsante primario «Nuova segnalazione» -> `/{lang}/tickets/create` (alto 44 px; il wizard assegna `owner_id`, stato `pending`, codice di tracciamento, `Ticket::boot` + `TicketCreatedListener`).
3. Tre contatori-link: In corso -> `pratiche#in-corso`; Concluse -> `pratiche#concluse`; Da leggere (notifiche non lette) -> `notifiche`. Gruppi gia' definiti da DCP-110 (`fixcity::personal_area.groups`).
4. «Ultimi aggiornamenti» (max 3, dalle notifiche, con «Nuova») + «Vedi tutti».
5. «Le mie ultime segnalazioni» (max 3: titolo, stato, data, codice, «Traccia») + «Vedi tutte».
6. «Contatta il comune»: solo i link con destinazione 200 (FAQ).
Vuoto-stato (0 segnalazioni): niente contatori ne' elenchi; una scheda «Non hai ancora inviato segnalazioni» con tre righe su cosa succede (ricevi un codice, segui lo stato, ricevi un avviso a ogni cambio) e la CTA «Invia la tua prima segnalazione» (testi gia' in `personal_area.practices.empty`). Se ci sono segnalazioni ma 0 aggiornamenti: «Nessun aggiornamento: ti avvisiamo quando cambia lo stato di una segnalazione». Dati: una sola Action `BuildPersonalAreaDeskDataAction` che riusa le query esistenti (3 conteggi, 3+3 righe), niente nuovo modello.

**4.3 Impostazioni**
- Modificabile: preferenza email sugli aggiornamenti (gia' fatta); lingua preferita `users.lang` (4 valori, salvata; effetto reale solo se si porta l'utente a `/{lang}/area-personale` dopo il login, perche' l'URL vince, `SetFolioLocale.php:39`); nome e cognome (`users.first_name/last_name`, `name` derivato); telefono `profiles.phone` solo se il wizard lo usa [I: da verificare, altrimenti non esporlo].
- Non modificabile: email (identifica l'account e la verifica: cambio col flusso di verifica esistente, mai in-place); stato delle segnalazioni; notifiche in-app (restano sempre attive, come dice la pagina).
- Password: usare il flusso di recupero password esistente (`pages/auth/password/*`), non riportare il form di `profile/edit`.
- Consensi: elenco in sola lettura con data (da `consents`) e revoca solo del marketing. Prerequisito: seed dei 3 `Treatment` (oggi 0) e un test che la registrazione crei i `Consent`.
- Esportazione (art. 15/20): `ExportCitizenDataAction` (QueueableAction) che restituisce un JSON con `users` (id, nome, email, lingua), `profiles`, segnalazioni di cui e' proprietario, attivita' pubbliche, notifiche, consensi; mai password o token; `POST` con CSRF e `throttle`. Fino ad allora vale il testo onesto attuale («si invia la richiesta all'ente»).
- Cancellazione (art. 17): non riesumare `deleteAccount`. Va decisa da LEGAL (DCP-112) la sorte delle segnalazioni gia' pubbliche (anonimizzare l'autore e conservare il contenuto di interesse pubblico, o eliminare); fino ad allora «richiedi la cancellazione» come richiesta all'ente.

**4.4 Da eliminare o rimandare**
- Eliminare (morti e oscurati): `Modules/User/resources/views/pages/area-personale/{pratiche,servizi,notifiche,impostazioni}.blade.php` e `pratiche.blade.php.lock`; `pages/dashboard/index.blade.php` (Genesis); `pages/notifications/index.blade.php`; `pages/profile/edit.blade.php` e `app/View/Pages/ProfileEditVoltComponent.php` dopo aver portato lingua/nome nelle impostazioni; `Themes/Sixteen/resources/views/pages_old/area-personale/`. Non cancellare story: collegare.
- `servizi`: eliminare, nessun equivalente. `Servizi`/`Messaggi`/`Attivita'` come schede: non replicare.
- Rimandare: cancellazione account, esportazione (se LEGAL non la richiede subito), filtro/ordinamento dell'elenco (con 15 elementi per pagina bastano i due gruppi), «Contatta il comune» completo (numero verde, prenotazione: non esistono).
- Fuori area ma da correggere: `/lista-categorie` 500 (spostare il partial in `components/pages/` come gli altri, non in `pages/` che e' una cartella di rotte); chrome 404 (header 9, footer 11) e pagine privacy, note legali, accessibilita'.

### 5. Ordine di implementazione e test da scrivere (rossi prima)
1. Gia' in corso da DCP-110/111 (verificato B): pratiche, seguite, notifiche, impostazioni come JSON + blocchi. Mantenere `PersonalAreaPagesTest`, `PersonalAreaPagesJsonGuardTest`, `PersonalAreaLangParityTest`, `HeaderAccountMenuTest`.
2. Causa radice: la pagina dinamica del tema risponde 404 senza JSON ne' ramo speciale. Test: `GET /it/area-personale/servizi` e `/it/profile/edit` -> 404 (ospite e loggato); nessun URL del menu risponde 200 con `<main>` vuoto.
3. Landing post-login: test che login, registrazione, verifica email, SPID e CIE senza URL «intended» finiscano su `/{lang}/area-personale` (7 punti elencati al §2), non su `/it/dashboard`; poi eliminare `dashboard/index.blade.php`. `/it/auth/login` da loggato -> redirect alla scrivania.
4. Scrivania: JSON + blocco + `BuildPersonalAreaDeskDataAction`. Test: ospite 302 al login; utente senza segnalazioni -> vuoto-stato e CTA a `tickets/create`, nessun contatore; utente con 2 segnalazioni e 1 notifica non letta -> contatori esatti; non compaiono segnalazioni altrui; un `h1`, un `<main>`, nessuna chiave grezza in it/en/de/es; parita' lang a 4 lingue.
5. Menu: voce «Area personale» e contatore; test che ogni voce risponda 200 con `h1` nelle 4 lingue; axe `button-name` = 0 a 375 (`aria-label` sul toggle); axe `aria-progressbar-name` = 0 nelle impostazioni.
6. Impostazioni: lingua preferita (salva `users.lang`, la scrivania si apre in quella lingua); seed `Treatment` + test «la registrazione crea 3 `Consent`»; blocco consensi; `ExportCitizenDataAction` con test (solo dati del chiamante, niente password, throttle); cancellazione dopo la decisione LEGAL.
7. Rimozione dei file morti del §4.4 con un test sentinella (nessun file Folio in `Modules/*/resources/views/pages/area-personale/` e nessuna pagina CMS a due segmenti vuota).
8. Fix `/lista-categorie` 500 con test 200 + `h1`.
9. Gate finale: Playwright a 375/768/1440 su it/en/de/es per le 5 pagine con axe 0 serious/critical, 0 overflow, link crawl senza 4xx/5xx, bersagli >= 44 px nel contenuto.

### 6. Ipotesi da chiudere
Il bottone «Segui» da loggato; il campo `phone` usato dal wizard; `ticket_activities.user_id` intero contro id UUID; che la registrazione non salvi consensi senza `Treatment`; l'elenco con piu' di 15 segnalazioni (paginazione) e con segnalazioni senza posizione; effetto della lingua preferita al login.

## Decisioni
(da compilare: quali voci/pagine, con quali dati; ADR in `Themes/Sixteen/docs/decision-log/`, prossimo numero D18)

## Aperto
Implementazione dopo lo studio.

## Evidenza del lead (17:00 UTC)
Le 4 voci del menu utente (`pratiche`, `seguite`, `notifiche`, `impostazioni`) restano pagine vuote: vedi DCP-52, "Verifica del lead". Le pagine del modulo User in `resources/views/pages/area-personale/` non vengono mai servite a `/it/area-personale/*` (oscurate dalla pagina generica del tema). Criterio di accettazione eseguibile: `Modules/Fixcity/tests/Feature/Pages/HeaderAccountMenuTest.php` > "links every menu entry to a page that works and has something to show" (oggi rosso).

## Verifica del lead (2026-10-13 17:15 UTC): le quattro pagine ora funzionano
La sessione tema ha creato `config/local/fixcity/database/content/pages/area-personale.{pratiche,seguite,notifiche,impostazioni}.json` (pagine CMS con login richiesto: da ospite `/it/area-personale/pratiche` -> 302 `/it/auth/login`). Verificato dal lead, sito di sviluppo, utente loggato, HTML reale:
| Pagina | it: h1 | en: h1 | `<main>` | chiavi grezze |
|---|---|---|---|---|
| pratiche | Le mie segnalazioni | My reports | 1 | 0 |
| seguite | Segnalazioni che seguo | Reports I follow | 1 | 0 |
| notifiche | Notifiche | Notifications | 1 | 0 |
| impostazioni | Impostazioni e privacy | Settings and privacy | 1 | 0 |
Ogni pagina ha breadcrumb "Home / <titolo>" e una frase che dice a che serve (es. notifiche: "Gli aggiornamenti di stato che hai ricevuto sulle tue segnalazioni e su quelle che segui"); impostazioni rimanda ai diritti dell'interessato. Rete di sicurezza: `Modules/Fixcity/tests/Feature/Pages/HeaderAccountMenuTest.php` passa da 9/10 a **10/10 (75 asserzioni)**, compreso "links every menu entry to a page that works and has something to show". Non verificato dal lead: de/es (studio I18N-MOBILE), mobile 375/768, contenuto con ticket reali (l'utente di prova non ne ha), correttezza dei dati in "Impostazioni". DB di sviluppo invariato (9 utenti, 4 ticket). Non rimane aperta la voce 2 di DCP-52 (pagine vuote).

## Nota 2026-10-13: /lista-categorie corretta
Causa radice confermata: `pages/[container0]/index.blade.php` e `Modules/Fixcity/resources/views/pages/lista-categorie.blade.php` includevano `pub_theme::pages.services.categories-content`, esistente solo in `pages_old/services/` (spostata con `pages` -> `pages_old`). Correzione: il partial vive ora in `Themes/Sixteen/resources/views/components/pages/categories.blade.php` (come faq, sitemap, services) e i due include puntano li'. La copia in `pages_old/` resta (cronologia, nessuna cancellazione). Il partial usa `<div>` e non `<main>`: il layout ne ha gia' uno, quindi la vecchia versione avrebbe prodotto due landmark principali.
Prova: `Modules/Fixcity/tests/Feature/Pages/ServiceCategoriesPageTest.php` (it, en, de, es: 200, un solo `main`, un solo `h1`, link localizzato a `/tickets`, nessuna chiave di traduzione a vista). ROSSO con `View [pages.services.categories-content] not found`, poi `8 passed (24 assertions)`; PHPStan sul test 0 errori; GET reale 200 nelle 4 lingue. Il test omonimo di `Themes/Sixteen/tests/Feature/ComunePagesTest.php` non e' una prova: viene saltato per una classe inesistente (`Modules\Fixcity\App\Models\Ticket`, quella vera e' `Modules\Fixcity\Models\Ticket`); da correggere dal proprietario del tema.
Axe (`a11y-page-probe.mjs`, 375 e 1440, debugbar esclusa): 0 nodi serious/critical su `/it/lista-categorie`; i livelli minor/moderate non sono stati guardati. Non verificato: parity visiva contro un riferimento (la pagina non ha un riferimento Design Comuni dedicato; le classi sono quelle del vecchio tema Tailwind). Il punto 8 della lista sopra e' chiuso solo per il 500.
