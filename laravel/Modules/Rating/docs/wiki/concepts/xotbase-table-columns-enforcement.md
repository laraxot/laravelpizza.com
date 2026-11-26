---
qmd: "rating filament tabelle form infolist colonne etichette traduzioni xotbase resource table create action percentage fillable"
issues: []
discussions: []
title: "Rating: architettura di tabelle, form e infolist Filament (colonne, etichette, azione Crea)"
type: concept
sources:
  - app/Filament/Resources/RatingMorphResource/Tables/RatingMorphsTable.php
  - app/Filament/Resources/RatingMorphResource/Pages/ListRatingMorphs.php
  - ../../../../Xot/app/Filament/Resources/Pages/XotBaseListRecords.php
confidence: high
created: 2026-05-07
updated: 2026-11-25
tags: [xotbase, filament, tables, traduzioni, rating-morph]
related:
  - ../../../../../../docs/wiki/concepts/xotbase-table-columns-enforcement.md
status: active
---

# Rating: architettura delle tabelle Filament

Pagina di riferimento (SSoT) per i `@see` di `RatingMorphsTable`, `ListRatingMorphs` e del test
`RatingFilamentExtendedTest`. Una tabella di Rating e' una classe `XotBaseResourceTable` che dichiara
solo `getTableColumns()`: header, azioni e bulk action vengono dalla base Xot.

## Come si arriva alla classe tabella

`RatingMorphResource::getTableClass()` sceglie `RatingMorphResource\Tables\RatingMorphsTable` dal nome del
model (`RatingMorph` + `s` + `Table`), non `RatingMorphTable`. La lista (`ListRatingMorphs`) non configura
la tabella: la costruisce la Resource, come fa Filament in `makeTable()`.

## Cos'e' un `rating_morph`

E' il **voto** di un utente (`user_id`) su un criterio (`rating_id`, relazione `rating()`) per un elemento
valutato (`model_type` + `model_id`), con `value`, `note`, `is_winner`, `reward`. Colonne della lista, in
ordine: `id`, `rating.title`, `rating_id`, `user_id`, `model_type`, `model_id`, `value`, `note`,
`is_winner`, `reward`, `created_at`, `updated_at` (nascosta di default). Fino al 2026-11-19 c'erano anche
`rating`, `ratingable_type`, `ratingable_id`: non esistono nello schema (celle vuote, e `rating` ricercabile
generava `WHERE rating LIKE ...` su una colonna inesistente).

## Da dove vengono le etichette

Le etichette non sono scritte nel codice: `GetTransKeyAction` deduce la chiave dal nome della classe.
Verificato a runtime con tinker:

| Classe | Chiave | Cosa legge |
|---|---|---|
| `RatingMorphsTable` | `rating::rating_morphs` | `fields.<colonna>.label` (intestazioni) |
| `ListRatingMorphs` | `rating::rating_morph` | `navigation.*`, `actions.create.label` (pulsante "Nuovo voto") |

I file sono `lang/it/rating_morphs.php` e `lang/it/rating_morph.php`. Se un valore e' uguale al nome del
campo (`'label' => 'rating_id'`), e' un segnaposto creato dal primo render (AutoLabelAction): in lista
compare il nome tecnico della colonna. Si corregge scrivendo la traduzione, non il codice della tabella.
Esistono solo i file `it` (in `lang/en` ci sono soltanto `panel_stats.php` e `setting.php`).

## Il pulsante di creazione

Lo costruisce `XotBaseListRecords::getHeaderActions()` (solo se la Resource ha la pagina `create`, che
`XotBaseResource::getPages()` registra) e lo etichetta con `<risorsa>::actions.create.label`. Un
`getActions()` nella pagina non serve: e' l'alias deprecato che il `getHeaderActions()` di Filament
richiamerebbe, ma la base Xot lo sovrascrive senza chiamare il parent, quindi non viene mai eseguito. Il
test `ListRatingMorphs dichiara colonne e create action` verifica `getHeaderActions()` (chiave `create`).

## Form e scheda di dettaglio di un voto

`BaseRatingMorphForm` (guscio `RatingMorphForm`) ha tre campi: `rating_id` (select sul criterio), `value`
e `note`. Le etichette stanno in `lang/it/rating_morph_form.php` (chiave `rating::rating_morph_form`), la
scheda di dettaglio in `lang/it/rating_morph_infolist.php`; stesso difetto della lista: il primo render
scrive segnaposto uguali al nome del campo (`'label' => 'rating_id'`) e a schermo compare il nome tecnico.
Per i criteri valgono `rating_form.php` e `rating_infolist.php`, che riusano le parole di `ratings.php`.

Campi che **non** sono nel form, e perche':

- `model_type` / `model_id` / `user_id`: li scrive il contesto che crea il voto (elemento valutato e
  utente corrente), non una persona a mano.
- `percentage`: colonna calcolata (`HasRating::getRatingsPercentageBy*`), nessun codice la scrive e non e'
  in `$fillable`. Fino al 2026-11-25 il form la mostrava, ma `fill()` scartava il valore in silenzio.
  Guardia: il test `ogni campo del form del rating morph e assegnabile in massa` fallisce se un campo del
  form non e' in `$fillable`.

## Lista dei criteri (`RatingsTable`)

Le colonne di `RatingsTable` (i criteri di valutazione, model `Rating`) sono nel sorgente
`app/Filament/Resources/RatingResource/Tables/BaseRatingsTable.php` e le etichette in `lang/it/ratings.php`.
Non si duplicano qui: un elenco copiato invecchia al primo cambio di schema.
