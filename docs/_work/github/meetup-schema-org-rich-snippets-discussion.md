Ho studiato il modulo `Meetup` partendo dal presupposto piu' ambizioso possibile: rendere il progetto davvero `schema.org` complete e rich-snippets ready.

La prima correzione concettuale, pero', e' questa:

- `schema.org` non va letto come "ogni modello deve avere tutte le proprieta' possibili del tipo";
- la lettura corretta e' "ogni modello pubblico deve avere il tipo giusto e i campi realmente necessari / utili per i rich results e per il grafo semantico".

Questo cambia molto la strategia.

## Mappa corretta del modulo

- `Event` -> `Event`
- `Venue` -> `Place` o `LocalBusiness`
- `Sponsor` -> `Organization`
- `Performer` -> `Person`
- `Profile` -> `Person`, e `ProfilePage` a livello pagina
- `Feedback` -> `Review` solo se pubblico e visibile

I pivot:

- `EventSponsor`
- `EventPerformer`
- `EventUser`

non vanno promossi a entita' SEO pubbliche per default. Devono servire soprattutto a comporre il grafo di `Event`.

## Livello pagina

La stessa disciplina vale per le pagine:

- ogni pagina pubblica deve avere almeno un nodo `WebPage`;
- `ProfilePage` si applica solo a profili pubblici reali con `mainEntity` di tipo `Person`;
- una schermata come `/profile/edit` non deve essere marcata come `ProfilePage`.

## Stato reale attuale

`Event` e' avanti rispetto agli altri modelli perche' ha gia' `toSchemaOrg()`, ma e' ancora parziale:

- il nodo `location` e' troppo debole;
- `performer`, `sponsor`, `review` / `aggregateRating` non sono ancora composti;
- mancano relazioni che permettano una costruzione pulita del grafo.

Gli altri modelli (`Venue`, `Sponsor`, `Performer`, `Feedback`) hanno gia' dati interessanti ma nessun contratto uniforme di esportazione.

## Decisione architetturale proposta

1. Definire una convenzione `toSchemaOrg()` per i modelli pubblici.
2. Distinguere per ogni modello:
   - required
   - recommended
   - conditional
3. Rendere il tema responsabile solo del rendering JSON-LD.
4. Validare tutto su Rich Results Test e validator.schema.org.

## Risultato atteso

Un progetto `Meetup` davvero rich-snippets ready:

- non pieno di campi fittizi;
- non accoppiato a markup semantico inventato nei Blade;
- con `Event` come grafo centrale che compone `Place`, `Organization`, `Person`, `Offer`, `Review` quando disponibili.
