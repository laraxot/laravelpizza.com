---
title: "INDEX contratti — Rating"
type: index
owner: Rating
updated: 2026-11-24
qmd: "Rating contract INDEX invarianti copertura pest group RATING-INV"
---

# INDEX contratti — Rating

Copertura = `coperto` se per ogni ID esiste `->group('<ID>')` nei test del modulo (verifica: `rg -n "group\('<ID>'\)" laravel/Modules/Rating/tests`, 2026-11-24: nessun risultato). I test indicati nei contract provano parte del comportamento senza group: `non coperto`. Comandi da `laravel/`.

| Operazione | Contract | Classe | Invarianti | Copertura | Comando |
|---|---|---|---|---|---|
| Somma voti di un modello | [get-sum-by-model-rating-id-action](get-sum-by-model-rating-id-action.md) | `Modules\Rating\Actions\HasRating\GetSumByModelRatingIdAction` | RATING-SUM-INV-1..3 | non coperto | `vendor/bin/pest --group=RATING-SUM-INV-1` (idem -2, -3) |
| Conteggio voti di un modello | [get-count-by-model-rating-id-action](get-count-by-model-rating-id-action.md) | `Modules\Rating\Actions\HasRating\GetCountByModelRatingIdAction` | RATING-COUNT-INV-1..2 | non coperto | `vendor/bin/pest --group=RATING-COUNT-INV-1` (idem -2) |
| Autorizzazione sulle valutazioni | [rating-morph-policy](rating-morph-policy.md) | `Modules\Rating\Models\Policies\RatingMorphPolicy` | RATING-POLICY-INV-1..5 | non coperto | `vendor/bin/pest --group=RATING-POLICY-INV-1` (idem -2..-5) |

Marker `@contract`/`@see` nel docblock: mancante (fuori scope docs) in tutte e tre.

Invarianti senza un test individuato: `RATING-COUNT-INV-2`, `RATING-POLICY-INV-4`.

## Backlog contract

Scritture di valutazioni ad alto rischio senza contract:

- `app/Models/Traits/HasRatingsTrait.php` (relazioni, sync di `extra_attributes`, regole di validazione): non è un'Action, serve un contract non-Action prima di toccarlo.
- `app/Models/Policies/RatingPolicy.php` (stessa struttura di `RatingMorphPolicy`, sulla tabella `ratings`).
- `app/Models/Traits/HasLikes.php` (like/dislike per utente).
- `app/Actions/HasRating/GetRatingOptsByModelAction.php` (solo lettura, rischio basso).

Totale Action in `app/Actions`: 3 file `.php`, 2 con contract (manca `GetRatingOptsByModelAction`). La logica di scrittura sta nei trait e nei modelli, non nelle Action.
