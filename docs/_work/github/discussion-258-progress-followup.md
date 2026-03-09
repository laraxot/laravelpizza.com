Progress update:

- confermato che il bug del dettaglio evento era nel resolver dinamico CMS, non nel solo tema;
- il route `/it/events/{slug}` ora riceve l'`item` corretto dal `ResolvePageAction`;
- il block tema resta presenter puro e non fa piu query DB nel percorso standard del dettaglio;
- aggiunti/aggiornati test Pest sul resolver e sulla pagina evento localizzata.

Stato corrente: fix verificato, route evento OK, fallback `Nessun evento trovato` eliminato sulla slug reale di test.
