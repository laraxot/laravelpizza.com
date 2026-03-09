# WebPage Schema Governance

## Principio

Per le pagine pubbliche non basta serializzare le entity del dominio. Serve anche il layer pagina:

- `WebPage` come base;
- sottotipo corretto quando il contenuto lo richiede.

## Regola

- non usare sempre `WebPage` generico per comodita';
- scegliere il sottotipo piu' specifico disponibile;
- tenere separati:
  - **page schema**: descrive la pagina e il suo ruolo
  - **entity schema**: descrive l'oggetto principale della pagina

## Mappa iniziale

| Scenario | Type pagina |
|------|------|
| homepage | `WebPage` o `CollectionPage` se prevale il listing |
| pagina profilo pubblico | `ProfilePage` |
| dettaglio evento | `ItemPage` + entity `Event` |
| lista eventi | `CollectionPage` |
| about | `AboutPage` |
| contact | `ContactPage` |
| login/register/reset | `WebPage` generico, evitando type fuorvianti |

## Nota importante

`ProfilePage` non sostituisce `Person`: la pagina profilo usa `ProfilePage` come page type e contiene/collega una entity `Person`.
