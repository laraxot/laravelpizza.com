---
title: "Contratti del tema Meetup"
type: index
tags: [contracts, meetup]
created: 2026-11-24
updated: 2026-11-24
---

# Contratti del tema Meetup

Meetup **non ha Action**: `app/` contiene solo `Providers/ThemeServiceProvider.php`. La cartella non contiene contratti.

**Unico effetto collaterale del tema (debito dichiarato):** il provider registra `POST /events/{slug}/book` →
`Http/Controllers/EventBookingController::book()`, che valida nome, email e posti (1-5) e **incrementa
`attendees_count` dell'evento** con `save()`. Non e' un'Action e non ha contratto; da sapere prima di toccarlo o imitarlo:

- la rotta e' registrata senza middleware `web`: niente sessione ne' CSRF, chiunque puo' chiamarla;
- lettura e scrittura del contatore non sono atomiche (due richieste concorrenti possono superare `max_attendees`);
- nome ed email validati non vengono salvati (nessun record di prenotazione);
- dipende da `Modules\Meetup\Models\Event`, modulo non presente in ogni installazione.

Il posto giusto per questa logica e' un'Action del modulo eventi con il suo contratto, chiamata da un widget o da Volt
([ADR](../adr/public-pages-from-json-via-x-page.md)).

**Dove stanno i contratti applicativi:** nei moduli, es. `Modules/User/docs/contracts/` (login),
`Modules/Gdpr/docs/contracts/` (consensi in registrazione), `Modules/Cms/docs/contracts/` (pagine).

## Contratti

Nessuno (il tema non ha Action).
