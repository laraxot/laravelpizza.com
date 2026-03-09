# Meetup Schema.org Rich Snippets Memory

## Contesto

Il modulo `Meetup` contiene gia' un primo `toSchemaOrg()` su `Event`, ma il progetto non ha ancora una convenzione uniforme per gli altri modelli pubblici.

## Decisione ricordata

Quando l'obiettivo e' rendere `Meetup` rich-snippets ready:

- partire da `schema.org` e dalla documentazione Google Search Central del rich result supportato;
- non aggiungere "tutte le proprieta'" in modo cieco;
- mappare i modelli pubblici a tipi canonici e separare required / recommended / conditional;
- trattare i pivot model come supporto al grafo JSON-LD, non come entita' SEO autonome, salvo prova contraria.

## Implicazione pratica

`Event` e' il punto critico per i rich results Google.

Per `Event`, il baseline minimo deve coprire in modo affidabile:

- `name`
- `startDate`
- `location`
- `location.name`
- `location.address`

Poi vanno aggiunti in modo coerente con i dati reali:

- `endDate`
- `description`
- `image`
- `offers`
- `eventStatus`
- `eventAttendanceMode`
- `organizer`
- `performer`
- `isAccessibleForFree`

## Regola di sicurezza

Il markup deve sempre rappresentare il contenuto mostrato nella pagina. Se il dato non e' pubblico o non e' affidabile, non va emesso.

## Livello pagina ricordato

- `WebPage` e' la baseline per le pagine pubbliche;
- `ProfilePage` vale solo per profili pubblici reali, non per pagine tipo `/profile/edit`;
- `ProfilePage` deve avere una `mainEntity` di tipo `Person` coerente con il contenuto pubblico.
