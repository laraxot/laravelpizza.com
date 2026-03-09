# Schema.org Page Type Governance

## Regola

Nel progetto `Meetup` bisogna distinguere sempre:

- il nodo entita' di dominio;
- il nodo pagina pubblica che la presenta.

`schema.org` non descrive solo oggetti come `Event` o `Person`, ma anche il tipo della pagina che li espone.

## Mappa minima

| Route/Page | Page type | Main entity |
|---|---|---|
| `/events` | `CollectionPage` | lista di `Event` |
| `/events/{slug}` | `ItemPage` o `WebPage` | `Event` |
| `/profile/{user}` | `ProfilePage` | `Person` |
| `/privacy` | `WebPage` | testo legale / `WebPageElement` |
| `/terms` | `WebPage` | testo legale / `WebPageElement` |
| `/contact` | `ContactPage` | `Organization` / `ContactPoint` |
| homepage | `WebPage` | `Organization` e contenuti principali |

## Regola pratica

- il model pubblico esporta l'entita' (`Event`, `Person`, `Organization`, `Place`);
- il tema esporta il nodo pagina (`WebPage`, `ProfilePage`, `ItemPage`, `CollectionPage`);
- i due nodi vanno collegati con `mainEntity` o `mainEntityOfPage`;
- il markup pagina non deve contraddire il contenuto realmente visibile.

## Profili

Le pagine profilo pubbliche non vanno marcate come semplice `WebPage` quando rappresentano chiaramente il profilo di una persona.

Il baseline corretto e':

- pagina: `ProfilePage`
- entita' principale: `Person`
- collegamento: `mainEntity`

## Anti-pattern

- emettere solo `Person` senza tipo pagina;
- emettere solo `WebPage` senza entita' principale;
- usare `ProfilePage` per pagine di editing private come `/profile/edit`;
- trattare ogni route come `WebPage` generica quando esiste un sottotipo piu' preciso.
