---
title: "ADR — Opzioni e voti nella stessa pivot rating_morph, distinti da user_id nullo"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-24
module: Rating
tags: [adr, rating, pivot, rating_morph, legacy]
related:
  - ../criteri-a-scelta-multipla.md
  - ../contracts/get-sum-by-model-rating-id-action.md
  - ../contracts/get-count-by-model-rating-id-action.md
  - ../contracts/get-rating-opts-by-model-action.md
qmd: "rating morph options and votes same"
---

# ADR: una pivot per opzioni e voti

## Contesto

Un model valutabile (`HasRating`, `HasRatingContract`) è legato ai criteri `ratings` con una relazione polimorfica
`ratings()` (`morphToManyX(Rating::class, 'model')`) sulla tabella `rating_morph`
(`app/Models/BaseRatingMorph.php::$table`; colonne `rating_id`, `model_type/model_id`, `user_id` nullable, `value`,
`percentage`, `note`…, migrazione `database/migrations/2026_07_27_100005_create_rating_morph_table.php`).
La stessa tabella contiene due cose diverse:

- **le opzioni** offerte su quel model (riga senza utente: "questo model si vota con i criteri 3 e 5");
- **i voti** (riga con `user_id` e `value`: "l'utente X ha dato 4 al criterio 3 su questo model").

Il codice che legge lo dà per scontato ovunque: `GetRatingOptsByModelAction` e `StatsOverview` filtrano
`wherePivot('user_id', null)`; `GetSumByModelRatingIdAction`, `GetCountByModelRatingIdAction`,
`HasRating::getBettingUsers()`, `getVolumeCredit()` filtrano `user_id != null`. Come si distingue un'opzione da un voto?

## Decisione

- In `rating_morph`, `user_id IS NULL` = l'opzione (il criterio è attivo su quel model); `user_id IS NOT NULL` = un voto.
- Ogni lettura di aggregati (somma, conteggio, percentuali) **deve** escludere le righe senza utente; ogni lettura delle
  opzioni **deve** escludere quelle con utente. Le Action di `app/Actions/HasRating/` incapsulano i due filtri.

## Alternative considerate

- **Tabella separata per le opzioni** (`rating_options` o colonna JSON sul model): più chiara, ma richiede di
  migrare i dati di tutti i moduli che usano Rating su connessioni diverse; valutata in
  `../criteri-a-scelta-multipla.md` per le opzioni dei criteri a scelta, non decisa.
- **Colonna `kind` esplicita**: renderebbe leggibile la distinzione senza cambiare tabella; non fatta perché nessuna
  query esistente la userebbe e andrebbe valorizzata su dati storici.
- **Lo stato attuale** (scelto per continuità): nessuna migrazione, ma la semantica sta nel valore nullo di una FK.

## Conseguenze

- Cattivo: una query nuova che dimentica il filtro somma o conta le righe-opzione (con `value` nullo il `SUM` non
  cambia, ma `COUNT` e le percentuali sì).
- Cattivo: un voto anonimo (senza utente) non è rappresentabile: diventerebbe un'opzione.
- Debito: `HasRating::getRatingsPercentageByUser()` e `getVolumeCredit()` interrogano `RatingMorph` per `model_id`
  senza filtrare `model_type` (due model diversi con lo stesso id si mescolano).

## Verifica

- `cd laravel && vendor/bin/pest Modules/Rating/tests --group=RATING-VOTES-SUM-INV-1` e
  `--group=RATING-VOTES-COUNT-INV-1`: falliscono se somma o conteggio non filtrano `user_id != null`.
- `cd laravel && vendor/bin/pest Modules/Rating/tests --group=RATING-OPTS-INV-1`: fallisce se le opzioni non filtrano
  `user_id = null`.
- Solo revisione: ogni query nuova su `rating_morph` o su `ratings()` dichiara quale dei due filtri usa.
