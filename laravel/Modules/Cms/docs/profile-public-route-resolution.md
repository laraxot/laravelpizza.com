# Profile Public Route Resolution

## Problema

La route pubblica `/it/profile/{id}` passa dal catch-all Folio `container0.view`.

Per i profili pubblici non si puo' assumere una lookup per `slug`:

- l'URL usa un identificatore utente (`User::id`) stringa;
- nelle installazioni locali le tabelle `profiles` possono non avere la colonna `uuid`;
- puo' mancare del tutto un record `Profile` pur esistendo l'utente.

## Regola

Il resolver CMS per `container0 = profile` deve:

1. risolvere prima l'utente pubblico tramite `Modules\User\Models\User` usando l'ID presente in URL;
2. caricare il profilo collegato se esiste, ma non renderlo obbligatorio;
3. usare il template CMS `profile.view`;
4. passare al tema un payload dati che consenta di renderizzare la pagina anche con il solo `User`.
5. mantenere compatibilita' anche quando l'identificatore non e' uno slug (`id`, `uuid`, `user_name`).

## Motivazione

- mantiene la route pubblica stabile;
- evita dipendenze rigide da colonne non presenti nel DB locale;
- preserva il pattern generico `container0.view` senza hack dedicati nel Blade.

## Verifica minima richiesta

- test feature Pest su `GET /it/profile/{identifier}` con utente reale;
- nessun fallback al blocco eventi;
- nessun errore `PropertyNotFoundException` o "Nessun evento trovato" su pagina profilo.
