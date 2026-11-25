---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 12 file oltre target 100.

### `console-errors-fix.md` — Fix: Console Errors - Event Detail Page

# Fix: Console Errors - Event Detail Page

## Errori Risolti

### 1. cookie-consent.js: $dispatch is not defined ✅

**Causa:** Alpine.js non era caricato nel layout principale.

**Fix:** Aggiunto `@livewireStyles` e `@livewireScripts` in `Themes/Meetup/resources/views/components/layouts/main.blade.php`.

```blade
{{-- Nel <head> --}}
@livewireStyles

{{-- Prima di </body> --}}
@livewireScripts
```

### 2. Particle canvas not found ✅


### `front-office-audit.md` — Audit del front office

# Audit del front office

Controllo completo delle pagine pubbliche, da ospite e da utente loggato, su desktop e su telefono.
Da eseguire prima di ogni rilascio che tocca il tema, insieme a `npm run a11y` e ai test.

```bash
cd laravel/Themes/Meetup
npm run audit:fo                      # sito locale con i dati demo
BASE_URL=https://staging.example npm run audit:fo
# id dei profili demo da aprire (facoltativi)
USER_ID=<uuid partecipante> ORGANIZER_ID=<uuid organizzatrice> npm run audit:fo
# se il nome host non risolve (container, CI): MAP_HOST=127.0.0.1
```

Lo script (`scripts/front-office-audit.cjs`) apre ogni pagina con Playwright e segnala:

- stato HTTP (le tre pagine inesistenti dell'elenco devono dare 404);
- errori JavaScript e in console, risorse con errore;
- **richieste a siti t

### `implementation-log.md` — Implementation Log: Logo Updates and Documentation

# Implementation Log: Logo Updates and Documentation

## Date: [DATE]

## Overview
This document captures the implementation of logo updates across all HTML pages to ensure consistency with the official laravelpizza.com logo.

## Files Updated

### HTML Files with Logo Updates
All HTML files in `/Themes/Meetup/resources/html/` were updated to use the correct pizza slice logo in the footer:

1. **login.html** - Updated footer logo to use the stroke-based pizza slice SVG
2. **register.html** - Already had correct logo in footer
3. **about.html** - Updated footer logo to use the stroke-based pizza slice SVG
4. **contact.html** - Updated footer logo to use the stroke-based pizza slice SVG
5. **menu.html** - Updated footer logo to use the stroke-based pizza slice SVG
6. **cart.html** - Updated 

### `localization-guide.md` — Localization — Theme Integration

# Localization — Theme Integration

## Overview

The project uses [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization) for URL-based locale detection. Folio pages are localized via a custom `SetFolioLocale` middleware.

## Supported Locales

| Code | Language | Native | URL Example |
|---|---|---|---|
| `it` | Italian | italiano | `/it/events` |
| `en` | English | English | `/en/events` |
| `de` | German | Deutsch | `/de/events` |
| `fr` | French | français | `/fr/events` |
| `es` | Spanish | español | `/es/events` |
| `ru` | Russian | Pусский | `/ru/events` |

## How It Works

1. User visits `/de/events`

### `manuale-utente/01-visitatore.md` — 1. Visitatore: guardare gli eventi senza account

# 1. Visitatore: guardare gli eventi senza account

[← Torna all'indice](readme.md)

Sei un **visitatore** quando apri il sito senza aver fatto l'accesso. Puoi guardare tutto, cercare gli eventi e scrivere agli organizzatori. Per prenotare un posto serve un account, ma puoi crearlo **nello stesso momento in cui ti iscrivi**, direttamente dalla pagina dell'evento (punto 1.5 e [capitolo 2](02-partecipante.md#21-iscriversi-a-un-evento-in-un-solo-passo)).

## 1.1 La pagina iniziale

Apri il browser (Chrome, Firefox, Safari o Edge) e vai all'indirizzo del sito. Vedi la pagina iniziale.

![Pagina iniziale con i quattro pulsanti principali evidenziati](img/v01-home.jpg)

In alto, nella barra scura, ci sono quattro cose importanti:

1. **Eventi**: apre l'elenco di tutti i meetup.
2. **Lingua** (il

### `manuale-utente/02-partecipante.md` — 2. Partecipante: iscriversi agli eventi

# 2. Partecipante: iscriversi agli eventi

[← Torna all'indice](readme.md)

Sei un **partecipante** quando hai un account e hai fatto l'accesso. Puoi fare tutto quello che fa il [visitatore](01-visitatore.md) e in più prenotare il tuo posto agli eventi.

Ci sono due strade per iniziare:

- **la più veloce**: ti iscrivi a un evento e intanto crei l'account, scrivendo solo email e password (punto 2.1);
- **quella classica**: prima crei l'account con nome e cognome (punto 2.2), poi ti iscrivi agli eventi (punto 2.4).

## 2.1 Iscriversi a un evento in un solo passo

Apri l'evento che ti interessa dall'elenco **Eventi**. A destra c'è il riquadro **Partecipa ora**.

![Il modulo per iscriversi con email e password](img/p18-iscrizione-rapida.jpg)

1. Scrivi la tua **email**.
2. Scegli una **passwo

### `manuale-utente/03-organizzatore.md` — 3. Organizzatore: creare e gestire gli eventi

# 3. Organizzatore: creare e gestire gli eventi

[← Torna all'indice](readme.md)

Sei un **organizzatore** quando un amministratore ha dato al tuo account il permesso di gestire gli eventi. Gli eventi non si creano dal sito pubblico ma dal **pannello di amministrazione**, una zona riservata con un indirizzo diverso: aggiungi `/meetup/admin` all'indirizzo del sito (per esempio `https://laravelpizza.com/meetup/admin`).

> Il pannello usa la tua **lingua preferita** (Modifica il profilo → Lingua preferita, [capitolo 2.7](02-partecipante.md#27-modificare-il-profilo)). Solo la pagina di accesso è sempre in italiano, perché il sito non sa ancora chi sei.

> Non vedi il pannello, o ricevi "Accesso negato"? Il tuo account non ha ancora il permesso: chiedilo all'amministratore del sito (come lo con

### `manuale-utente/04-amministratore.md` — 4. Amministratore: utenti e permessi

# 4. Amministratore: utenti e permessi

[← Torna all'indice](readme.md)

Sei un **amministratore** quando il tuo account ha il ruolo **super-admin**. È il ruolo di chi gestisce il sito, non i singoli eventi: decide chi può organizzare, controlla gli account e le impostazioni. Di solito gli amministratori sono una o due persone.

> Il pannello di amministrazione dà accesso a dati personali di tutti gli iscritti. Usalo solo per quello che serve, da un computer sicuro, ed esci sempre alla fine.

## 4.1 Entrare e trovare gli utenti

1. Accedi dal sito con **Accedi** (in alto a destra), con la tua email e la tua password, come un partecipante ([capitolo 2.3](02-partecipante.md#23-accedere-le-volte-successive)).
2. Poi apri l'indirizzo del sito seguito da `/user/admin/users` (per esempio `https:

### `manuale-utente/en/01-visitor.md` — 1. Visitor: browsing events without an account

# 1. Visitor: browsing events without an account

[← Back to the contents](readme.md)

You are a **visitor** when you open the site without signing in. You can look at everything, search events and write to the organisers. To book a seat you need an account, but you can create it **at the same moment you register**, straight from the event page (section 1.5 and [chapter 2](02-participant.md#21-register-for-an-event-in-one-step)).

## 1.1 The home page

Open your browser (Chrome, Firefox, Safari or Edge) and go to the site's address. You see the home page.

![Home page with the four main buttons highlighted](img/v01-home.jpg)

At the top, in the dark bar, there are four important things:

1. **Events**: opens the list of all meetups.
2. **Language** (the globe with the language name): chang

### `manuale-utente/en/02-participant.md` — 2. Participant: registering for events

# 2. Participant: registering for events

[← Back to the contents](readme.md)

You are a **participant** when you have an account and you have signed in. You can do everything a [visitor](01-visitor.md) does and, in addition, book your seat at events.

There are two ways to start:

- **the quickest**: you register for an event and create your account at the same time, typing just email and password (section 2.1);
- **the classic one**: first you create the account with first and last name (section 2.2), then you register for events (section 2.4).

## 2.1 Register for an event in one step

Open the event you are interested in from the **Events** list. On the right there is the **Join now** box.

![The form to register with email and password](img/p18-iscrizione-rapida.jpg)

1. Type your **e

### `manuale-utente/en/03-organiser.md` — 3. Organiser: creating and managing events

# 3. Organiser: creating and managing events

[← Back to the contents](readme.md)

You are an **organiser** when an administrator has given your account permission to manage events. Events are not created from the public site but from the **admin panel**, a reserved area at a different address: add `/meetup/admin` to the site's address (for example `https://laravelpizza.com/meetup/admin`).

> The panel speaks your **preferred language** (Edit profile → Preferred language, [chapter 2.7](02-participant.md#27-edit-your-profile)). Only the sign-in page is always in Italian, because the site doesn't know who you are yet.

> You don't see the panel, or you get "Access denied"? Your account doesn't have the permission yet: ask the site administrator (how they grant it is explained in [chapter 4](

### `manuale-utente/en/04-administrator.md` — 4. Administrator: users and permissions

# 4. Administrator: users and permissions

[← Back to the contents](readme.md)

You are an **administrator** when your account has the **super-admin** role. It's the role of whoever runs the site, not the single events: they decide who can organise, and check accounts and settings. Usually there are one or two administrators.

> The panels speak your **preferred language** (Edit profile → Preferred language).

> The admin panel gives access to the personal data of all attendees. Use it only for what you need, from a secure computer, and always sign out at the end.

## 4.1 Sign in and find users

1. Sign in on the site with **Log in** (top right), with your email and password, like a participant ([chapter 2.3](02-participant.md#23-sign-in-the-following-times)).
2. Then open the site's addre
