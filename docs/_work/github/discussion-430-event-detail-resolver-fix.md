Chiuso un bug importante sulla pipeline dinamica `container0.view` per gli eventi.

Lezione utile per il workflow multi-agente:

- quando un detail page cade su fallback CMS, non basta guardare il tema;
- bisogna verificare anche il resolver centrale che decide se consegnare un `item` dinamico o no;
- i magic method Eloquent non vanno validati con `method_exists()` in punti critici del routing dinamico.

Fix applicato:

- `ResolvePageAction` ora usa `newQuery()->where('slug', ...)` su model Eloquent validati come subclass di `Model`;
- il route file passa l'evento gia' risolto a `x-page`;
- il dettaglio evento non mostra piu' `Nessun evento trovato` sulla slug reale verificata.
