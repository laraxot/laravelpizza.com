# Meetup Schema.org Completeness Rule

## Regola

Il progetto non deve interpretare `schema.org` come "ogni modello deve avere tutte le proprieta' possibili del tipo".

Per il modulo `Meetup` la regola corretta e':

- ogni modello pubblico deve avere un mapping esplicito al tipo `schema.org` piu' adatto;
- ogni mapping deve distinguere tra:
  - proprieta' minime richieste per i rich results Google supportati;
  - proprieta' raccomandate quando il dato e' realmente disponibile;
  - proprieta' opzionali o non applicabili che non devono essere forzate nel modello;
- i modelli pivot o puramente relazionali non devono essere trasformati in pseudo-entita' pubbliche se hanno senso solo come nodo annidato.

## Applicazione pratica

Nel modulo `Meetup`:

- `Event` -> `Event`
- `Venue` -> `Place` o sottotipo pertinente
- `Sponsor` -> `Organization`
- `Performer` -> `Person`
- `Profile` -> `Person` a livello entita' e `ProfilePage` a livello pagina
- `Feedback` -> `Review` solo se la recensione e' realmente pubblica e mostrata

Modelli come:

- `EventUser`
- `EventPerformer`
- `EventSponsor`

non vanno forzati come rich-result entities autonome salvo caso d'uso reale. Di norma devono alimentare nodi annidati del JSON-LD (`performer`, `organizer`, `sponsor`, `attendee`, `offers`).

## Motivazione

- `schema.org` elenca proprieta' possibili, non una checklist obbligatoria da materializzare tutta nel database;
- Google richiede completezza sulle proprieta' supportate e rilevanti, non la presenza di ogni campo teorico;
- forzare tutte le proprieta' su tutti i modelli viola KISS e peggiora il dominio con campi vuoti o semantiche false;
- i rich snippets richiedono markup accurato e coerente con il contenuto visibile.

## Contratto operativo

Ogni modello pubblico di `Meetup` deve poter dichiarare:

- tipo `schema.org` canonico;
- proprieta' core;
- proprieta' recommended;
- gap noti del dominio;
- modalita' di rendering JSON-LD sul tema.

Se un dato non e' realmente disponibile o non e' mostrato nella pagina, non deve essere inventato nel markup.

## Livello pagina

Oltre ai modelli, anche le pagine pubbliche devono avere un tipo pagina corretto.

Regola:

- ogni pagina pubblica deve avere almeno un `WebPage` o un sottotipo piu' specifico;
- una pagina profilo pubblica deve usare `ProfilePage` solo se esiste davvero come pagina pubblica e ha `mainEntity` coerente di tipo `Person`;
- pagine autenticate o di editing profilo non vanno marcate come `ProfilePage` solo perche' riguardano il profilo utente.
