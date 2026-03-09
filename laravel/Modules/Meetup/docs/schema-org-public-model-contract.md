# Meetup Schema.org Public Model Contract

## Obiettivo

Rendere `Modules/Meetup` rich-snippets ready senza deformare il dominio.

## Chiarimento necessario

`schema.org` non implica che ogni modello debba avere tutte le proprieta' del tipo referenziato.

La lettura corretta e':

- usare il tipo piu' specifico possibile;
- coprire i campi richiesti dal rich result supportato;
- aggiungere le proprieta' raccomandate solo quando esiste un dato reale e pubblico;
- non introdurre campi fittizi solo per "riempire" il tipo.

## Mappa attuale del modulo

### `Event`

- tipo: `Event`
- stato attuale: ha gia' `toSchemaOrg()`
- gap principale: il `location` emesso oggi ha solo `name`, ma per la baseline Google evento servono anche dettagli di indirizzo sul nodo `Place`
- altri gap: `organizer` troppo minimale, `performer` assente, `offers` non normalizzato, `image` e `description` non garantiti come baseline operativa

### `Venue`

- tipo: `Place` oppure `LocalBusiness` se il venue e' anche business pubblico
- stato attuale: dati utili gia' presenti (`name`, `address`, `city`, `country`, `latitude`, `longitude`, `website`, `phone`)
- gap: manca un exporter canonico `toSchemaOrg()`

### `Sponsor`

- tipo: `Organization`
- stato attuale: dati utili gia' presenti (`name`, `website`, `logo`, `description`)
- gap: manca `toSchemaOrg()` e una distinzione tra sponsor pubblico e semplice relazione interna

### `Performer`

- tipo: `Person`
- stato attuale: dati utili gia' presenti (`name`, `bio`, `photo`, `website`, social)
- gap: manca `toSchemaOrg()` e un mapping del ruolo nel contesto evento

### `Profile`

- tipo: `Person`
- livello pagina: `ProfilePage`
- stato attuale: dati anagrafici di base presenti
- gap: manca una convenzione pubblica per pagine profilo e author/person markup

### `Feedback`

- tipo: `Review`
- attenzione: usare `Review` solo se il feedback e' davvero pubblico e visibile
- gap: manca scelta esplicita se il dominio vuole recensioni pubbliche o solo feedback interno

### Pivot model

- `EventSponsor`
- `EventPerformer`
- `EventUser`

Questi non devono essere trattati come entita' SEO autonome per default. Devono servire soprattutto a popolare:

- `performer`
- `organizer`
- `sponsor`
- `attendee`
- `offers`

nel grafo JSON-LD delle entita' pubbliche.

## Baseline minima `Event`

Per la pagina dettaglio evento, il JSON-LD deve almeno poter costruire in modo coerente:

- `@context`
- `@type`
- `name`
- `startDate`
- `location`
- `location.name`
- `location.address`

Recommended quando il dato esiste:

- `endDate`
- `description`
- `image`
- `offers`
- `eventStatus`
- `eventAttendanceMode`
- `organizer`
- `performer`
- `isAccessibleForFree`
- `maximumAttendeeCapacity`

## Direzione implementativa

1. Introdurre una convenzione `toSchemaOrg()` uniforme per i modelli pubblici di `Meetup`.
2. Separare il builder del dato dal rendering Blade.
3. Rendere il tema responsabile solo dell'iniezione del JSON-LD.
4. Aggiungere test per i nodi minimi richiesti sul dettaglio evento.

## Livello pagina: `WebPage` e `ProfilePage`

La strategia non puo' fermarsi ai modelli.

Per le pagine pubbliche serve anche un layer pagina:

- `WebPage` come baseline generale;
- sottotipo specifico quando la pagina lo richiede davvero;
- `ProfilePage` solo se esiste una vera pagina profilo pubblica.

### Conseguenza pratica

Una pagina come `/profile/edit` non e' `ProfilePage`.

Una vera pagina profilo pubblica dovrebbe invece rendere:

- `@type: ProfilePage`
- `mainEntity` -> `Person`
- URL canonico pubblico
- nome pubblico, immagine e descrizione coerenti col contenuto mostrato
