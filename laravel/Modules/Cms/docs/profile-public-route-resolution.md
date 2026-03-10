# Profile Public Route Resolution

## Problema

In passato la route pubblica `/it/profile/{id}` veniva trattata come se passasse dal catch-all Folio `container0.view`.
Nel tema attuale la route primaria corretta e' invece `profile.view`, dedicata.

Per i profili pubblici non si puo' assumere una lookup per `slug`:

- l'URL usa un identificatore utente (`User::id`) stringa;
- nelle installazioni locali le tabelle `profiles` possono non avere la colonna `uuid`;
- puo' mancare del tutto un record `Profile` pur esistendo l'utente.

## Regola

La route pubblica profilo deve:

1. usare una pagina Folio dedicata `profile.view`;
2. risolvere prima l'utente pubblico tramite `Modules\User\Models\User` usando l'ID presente in URL;
3. caricare il profilo collegato se esiste, ma non renderlo obbligatorio;
4. passare al tema un payload dati che consenta di renderizzare la pagina anche con il solo `User`.

Il builder schema deve inoltre mantenere compatibilita' semantica anche quando il profilo viene visto dal vecchio contratto `container0.view` con `container0 = profile`, per non rompere test e fallback SEO.

## Motivazione

- mantiene la route pubblica stabile;
- evita dipendenze rigide da colonne non presenti nel DB locale;
- evita hack nel catch-all Blade;
- mantiene un fallback semantico nel page schema invece di forzare il routing generico.

## Verifica minima richiesta

- test feature Pest su `GET /it/profile/{identifier}` con utente reale;
- nessun fallback al blocco eventi;
- nessun errore `PropertyNotFoundException` o "Nessun evento trovato" su pagina profilo.
- verifica locale `it` che le chiavi `pub_theme::profile.*` risultino tradotte (non key raw).
