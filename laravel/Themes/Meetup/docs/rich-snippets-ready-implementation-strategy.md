# Rich Snippets Ready Strategy For Theme Meetup

## Scopo

Il tema `Meetup` deve consumare structured data affidabile dai modelli pubblici senza ricostruire semantica nel Blade.

## Regola

Il Blade non deve inventare campi `schema.org`.

Il tema deve:

- ricevere JSON-LD gia' normalizzato dal modello o da una resource dedicata;
- renderizzarlo in pagina solo se i dati minimi sono validi;
- evitare fallback semantici deboli che producono markup parziale o fuorviante.

## Pagina evento

Per `/events/{slug}` il tema deve poter renderizzare:

- `Event`
- con `Place` annidato per location
- con `Organization` o `Person` per organizer
- con `Person` per performer
- con `Offer` se l'evento ha registrazione o prezzo

## Livello pagina

Ogni pagina pubblica del tema deve avere almeno un nodo `WebPage` coerente.

Per le pagine profilo:

- usare `ProfilePage` solo per profili pubblici reali;
- non usare `ProfilePage` per pagine autenticate o di edit account;
- associare `mainEntity` di tipo `Person` solo quando la pagina rappresenta davvero una persona pubblica.

## Vincoli

- il JSON-LD deve riflettere il contenuto visibile;
- niente `Review` se il feedback non e' pubblico;
- niente `ProfilePage` se non esiste una vera pagina profilo;
- i pivot model non vanno renderizzati come tipi autonomi.

## Verifica

Ogni template pubblico che rende structured data deve essere controllato con:

- Rich Results Test Google
- validator.schema.org
- test applicativi che verificano i nodi minimi attesi nel markup finale
