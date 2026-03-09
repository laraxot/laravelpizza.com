Aggiornamento architetturale sul bug dei dettagli evento:

il problema non era piu' Livewire ma il resolver dinamico CMS.

Root cause:

- `ResolvePageAction` cercava di capire se un model supportava query con `method_exists($modelClass, 'where')`;
- sugli Eloquent model `where()` non e' un metodo concreto della classe, quindi quel check falliva;
- risultato: `events/{slug}` non riceveva mai l'`item` dinamico e il block tema andava sul fallback "Nessun evento trovato".

Direzione corretta confermata:

- risoluzione modello nel route layer/CMS action;
- block tema come presenter puro;
- niente query DB nel Blade dettaglio quando il resolver puo' passare l'oggetto.

Ho anche aggiunto/rafforzato i test Pest sul resolver e sulla route evento localizzata.
