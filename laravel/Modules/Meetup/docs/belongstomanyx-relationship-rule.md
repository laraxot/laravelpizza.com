# Meetup belongsToManyX Relationship Rule

## Regola

Nel modulo `Meetup` le relazioni many-to-many devono usare `belongsToManyX()`.

Questo vale per le relazioni pubbliche e per quelle che alimentano:

- card eventi;
- pagina dettaglio evento;
- block CMS;
- structured data JSON-LD.

## Relazioni coperte

- `Event::attendees()`
- `Event::performers()`
- `Event::sponsors()`
- `Performer::events()`
- `Sponsor::events()`

## Motivazione

- il modulo vive dentro convenzioni Laraxot/Xot, non Eloquent “plain”;
- i pivot `event_user`, `event_performer`, `event_sponsor` fanno parte del dominio;
- la UI tema e il markup schema.org devono leggere dati coerenti con queste convenzioni.

## Nota pratica

Se una pagina pubblica mostra speaker, sponsor o partecipanti, il dato deve arrivare da una relazione `belongsToManyX()` o da presenter che la usa come sorgente.
