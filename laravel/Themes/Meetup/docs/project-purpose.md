---
title: "Scopo del progetto e del tema Meetup"
type: guide
status: active
theme: Meetup
qmd: "scopo progetto laravel pizza meetup community prd obiettivi project purpose philosophy non ecommerce"
---

# Scopo del progetto e del tema Meetup

## Perche' esiste

Dice cosa e' LaravelPizza e cosa deve fare il tema `Themes/Meetup`, cosi' chi lavora sul sito (persone e agenti AI) non
deriva verso progetti simili ma sbagliati. Il caso tipico: "Pizza" fa pensare a un e-commerce di consegna a domicilio, e
non lo e'.

## Cosa e'

- **Laravel Pizza Meetups**: piattaforma di community per far incontrare sviluppatori Laravel, Livewire e Filament dal vivo
  (davanti a una pizza). Slogan del sito: "Laravel Developers. Pizza. Community.". La home dice "Meetup Laravel gratuiti in
  Italia" (it) / "Free Laravel meetups in Italy" (en).
- Il tema Meetup e' il tema **pubblico** (front office) del sito laravelpizza.com: **conversione e miglioramento** del sito
  originale (piu' moderno, piu' coinvolgente, pensato per essere condiviso e per convertire), non una copia fedele.
- Tre obiettivi: **community** (un punto d'incontro), **eventi** (organizzare e trovare meetup locali), **conoscenza**
  (talk, workshop, networking).

## Cosa NON e'

- Non e' un e-commerce: nessun carrello, menu di pizze, ordini, consegna, pagamenti. Nel tema non c'e' codice di questo tipo
  (`grep` di carrello/cart/delivery in `resources/views` non trova nulla). Le vecchie pagine che descrivevano una
  "pizzeria con delivery" o best practice per siti di consegna erano un equivoco e sono state scartate.
- Non e' il prototipo statico `resources/html/` (HTML di studio, non e' la versione servita).
- Non e' il pannello admin: l'amministrazione e' Filament, nei moduli ([filament-and-widgets](filament-and-widgets.md)).

## Chi lo usa

| Utente | Ruolo | Cosa gli serve |
|---|---|---|
| Visitatore | sviluppatore Laravel | scoprire eventi, iscriversi, condividere |
| Partecipante | iscritto a un evento | dettaglio evento, i miei eventi, profilo |
| Admin | configura il sito | colori, logo, header e footer, pagine (da Filament / JSON del CMS) |

## Perimetro

**Dentro**: layout responsive mobile-first (`x-layouts.app`, `guest`, `auth`), header e footer coerenti, blocchi del CMS (hero,
eventi, features, CTA, contatti, legale, profilo), pagine home / eventi / dettaglio evento / chi siamo / contatti / privacy /
termini / cookie / auth / profilo, Tailwind v4 + Alpine, SVG come file, URL localizzati, namespace `pub_theme::`.

**Fuori**: e-commerce, dashboard complesse (sono Filament), PWA offline.

Requisiti non funzionali che il tema deve rispettare (sono regole di progetto, vedi [theme-rules](theme-rules.md)):

- SVG solo come file in `Modules/Meetup/resources/svg/`, richiamati con `<x-filament::icon icon="meetup-..."/>`.
- Link e form action con `LaravelLocalization::localizeUrl()` ([localization](localization.md)).
- Nessuna copia di asset in `public_html`: `public_html/themes/Meetup` e' un symlink a `Themes/Meetup/public`
  ([assets-and-build](assets-and-build.md)).
- Accessibilita' WCAG livello AA ([accessibility](accessibility.md)).

## Stato reale del sito (verificato sul codice)

- **Tenant**: `laravelpizza` (`config/local/laravelpizza/`), tema pubblico `Meetup` ([tenant-theme-resolution](tenant-theme-resolution.md)).
- **Home** (`pages/home.json`): quattro blocchi per lingua, `hero`, `events` (prossimi eventi), `features`, `cta`.
- **Pagine JSON** in `config/local/laravelpizza/database/content/pages/`: `home`, `about`, `contact`, `events`, `privacy`,
  `terms`, `cookie-policy`, piu' le cartelle `events/` (`my`, `past`, `view`) e `profile/` (`assistants`, `edit`, `view`).
- **Header** (`sections/header.json`): Home, Chi Siamo, Eventi, Blog, FAQ, Contatti.
- **Dopo login e registrazione** l'utente va su `/events/my` ("I miei eventi", chiave `post_login_path` di `xra.php`).
- **Privacy**: niente Gravatar (`'gravatar' => false`) e font Inter serviti dal sito stesso, perche' la cookie policy promette
  zero richieste a terzi prima del consenso ([gdpr-compliance](gdpr-compliance.md)).
- **Lingue**: it (default), en, de, fr, es, ru nelle URL; il tema ha traduzioni anche per hi e zh
  ([localization](localization.md)).

## Dominio (modulo Meetup)

La logica di business non sta nel tema ma in `Modules/Meetup`: modelli `Event`, `EventPerformer`, `EventSponsor`,
`EventUser`, `Feedback`, `Performer`, `Profile`, `Sponsor`, `Venue`; risorse Filament per evento, relatore, sponsor, sede.
`Event` ha tra gli attributi `title`, `description`, `in_language`, `start_date`, `end_date`, `location`, `status`,
`attendees_count`, `max_attendees`, `cover_image`, `slug`. Il tema legge questi dati nei blocchi (`blocks/events/list`,
`blocks/events/detail`); non li scrive, tranne il debito dichiarato di `EventBookingController`
([events-pages](events-pages.md)).

## Principi di lavoro

- Il front office e' **Folio + Volt + pagine JSON del CMS**, senza controller ne' rotte in `web.php`
  ([architecture](architecture.md)).
- Il tema e' un presentation layer: layout, blocchi Blade, stile. Logica, validazione e sicurezza stanno nei moduli.
- DRY e KISS: un blocco riusabile prima di una pagina speciale.
- Ambizione di prodotto: il sito deve far dire "WOW", non "carino": animazioni, CTA chiare, titoli che si condividono
  ([design-system](design-system.md), [social-share-and-marketing](social-share-and-marketing.md)).

## Storico scartato

- Descrizioni di una "faccia pizzeria" e di un "doppio tema delivery/community": mai esistite nel codice.
- Pagine che segnalavano come errati alcuni documenti su ordinazione di pizze. Nel modulo Meetup (non nel tema)
  `docs/business-logic.md` descrive ancora un "sistema di ordini" e `docs/services-guide.md` e `docs/models-architecture.md`
  citano ancora servizi e modelli di ordine: sono da riallineare al dominio eventi nel modulo.
- Elenco "Cosa manca" di un prototipo HTML con carrello e menu: fuori tema.

## Vedi anche

- [architecture](architecture.md) - come e' costruito il front office
- [theme-rules](theme-rules.md) - regole che valgono per ogni modifica al tema
- [roadmap](roadmap.md) - cosa resta da fare
- [visual-parity](visual-parity.md) - confronto con laravelpizza.com originale
