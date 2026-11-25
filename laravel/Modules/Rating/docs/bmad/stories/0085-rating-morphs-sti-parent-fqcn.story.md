---
title: "ratingMorphs su figlio STI: alias e FQCN del padre, lettura e scrittura su entrambe le forme"
type: story
module: Rating
status: done
track: rating-morph/model-type-doppio
created: 2026-09-29
updated: 2026-09-29
qmd: "ratingMorphTypes ratingMorphs static::class STI Parental SchedaDip model_type alias FQCN hydrateRatingsFormData ratings_by_id"
related:
  - ../../stories/18.35.rating-morph-type-doppia-forma.story.md
  - ./0001-ratings-by-id-accessor.story.md
  - ./0012-hydrate-sync-ratings-form-data.story.md
  - ./0021-clear-ratings-scoped-to-model-id.story.md
tags: [docs, rating, bmad]
---
# ratingMorphs su figlio STI: alias e FQCN del padre

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Perché

Segnalazione utente 2026-09-29 su `/indennitaresponsabilita/admin/scheda-dips/9240/compila`:
il form si apriva con i voti vuoti su una scheda gia' valutata.

Misura sul record 9240 (tenant `local/ptvx`, morph map con alias `indennita_responsabilita`):

| forma `model_type` | righe | valori |
|---|---|---|
| `indennita_responsabilita` (alias) | 10, create alle 10:36:18 | tutte `NULL` |
| `Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita` (FQCN del padre) | 10, dal 2026-09-25 | 34=3, 35=2, ..., 52=53 |

Tre difetti nel trait, uno sopra l'altro:

1. `ratingMorphs()` filtrava `model_type IN (getMorphClass(), static::class)`. Su `SchedaDip`
   (figlio Parental) `static::class` e' la classe **figlia**, mai scritta. Le righe storiche
   stanno sotto il FQCN del **padre**, quello a cui punta l'alias nella morph map.
   SQL misurato: `model_type in ('indennita_responsabilita', '...\SchedaDip')` → 10 righe, 0 valori.
2. `hydrateRatingsFormData()` leggeva `$this->ratings` (morphToMany, solo la forma alias):
   con le righe alias vuote il form partiva vuoto.
3. Il `mount()` di Compila (`syncRatingsWhere` → `syncWithoutDetaching`) crea le associazioni
   mancanti **nella forma alias**: e' cosi' che sono nate le 10 righe vuote.

## Cosa cambia

- `ratingMorphTypes(): list<string>` = alias + `Relation::getMorphedModel(alias) ?? alias`.
  `ratingMorphs()` lo usa al posto di `[getMorphClass(), static::class]`.
- `preferredRatingPivot()` (privato, statico): fra piu' righe dello stesso rating vale quella
  col voto, poi quella con la nota (opzione «altro»), poi la prima. Usato da `ratings_by_id`.
- `hydrateRatingsFormData()` legge da `ratings_by_id` (entrambe le forme).
- `syncRatingsFormData()`, `clearEvaluation()`, `syncRatingsWhere()`: dopo la scrittura
  `unsetRelation('ratings')` e `unsetRelation('ratingMorphs')`. Senza, la rilettura dopo
  save/Svuota mostrerebbe i valori caricati prima.

### Deviazione dal design proposto (motivata)

Il design chiedeva a `syncRatingsWhere()` di non creare la riga alias se esiste gia' una
riga in qualsiasi forma. **Non applicato**: `ratings()` (morphToMany, solo alias) e' la fonte
di `ratingFormFields()` / `getRatingsFormSchema()` / `getRatingsWhere()`. Senza la riga alias,
una scheda con righe solo FQCN (228 su 230 nella misura di 18.35) aprirebbe il form **senza
nessun campo**. Scartata anche la variante "copia il voto nella nuova riga alias": un tenant
senza alias (`personale2019`/`personale2022`, stesso DB) aggiorna solo la FQCN e la copia
diventerebbe stantia. La riga alias vuota e' innocua: si legge dalla riga col voto, si scrive
su entrambe le forme.

## Accettazione

- [x] `ratingMorphTypes()` su figlio STI con alias → `[alias, FQCN padre]`, mai la classe figlia
- [x] senza alias → `[FQCN]`, nessun duplicato
- [x] hydrate con riga alias `NULL` + FQCN valorizzata → il form riceve il voto
- [x] «altro» (nota piena, `value` null) preferito a una riga vuota
- [x] i writer scaricano `ratings` e `ratingMorphs`
- [ ] `syncRatingsWhere`: non coperto da unit test. I test esistenti falliscono prima di
      arrivarci (`Rating::getClassName()`: "Unable to resolve caller object", ambientale, 18.59)
- [ ] Cura dei dati (normalizzare le forme, dedup, `UNIQUE`): resta in 18.35, la decide chi
      possiede i dati

## Verifica (output reali, 2026-09-29)

- Red: 12 falliti, 7 passati (`HasRatingsTraitMorphTypesTest` + `HasRatingsTraitFormDataTest`).
- Green: `pest` su MorphTypes + FormData + RatingsById + Accessors + BaseRatingXlsExportValue:
  **42 passati, 4 falliti**. I 4 falliti sono gli stessi del baseline prima dell'edit
  (33 passati, 4 falliti in `HasRatingsTraitAccessorsTest`: myRatings, ratingObjectives,
  syncRatingsWhere x2, tutti `Unable to resolve caller object for getClassName()`).
- PHPStan (livello da `phpstan.neon`, cache isolata) sui 4 file toccati: `[OK] No errors`.
- PHPMD (`tools/phpmd.sh`): 0 nuovi. 4 preesistenti, identici su `944bf31`
  (CyclomaticComplexity syncRatingsFormData=10, 2 MissingImport `\LogicException`,
  UnusedFormalParameter `clearRatingsFormData($ratings)`).
- PHPInsights: trait 96.5 / 100 / 100 / 96.3; test 98.8 / 100 / 100 / 97.5. Le righe segnalate
  sul trait sono codice preesistente.
- Lettura reale (sola lettura) su 9240 dopo il fix: `ratingMorphTypes` =
  `["indennita_responsabilita", "Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita"]`.
  Nota: alle 11:34:54 la scheda e' stata salvata da un utente (dal=20260401, voti uguali sulle
  due forme), quindi la misura delle righe vuote non e' piu' riproducibile su 9240.
- Suite intera `Modules/Rating/tests/Unit`: oltre 580 s sotto carico (decine di processi
  PHPStan di altre sessioni), non completata. Eseguiti i 5 file che toccano il trait.

## File

- `app/Models/Traits/HasRatingsTrait.php`
- `tests/Unit/HasRatingsTraitMorphTypesTest.php` (nuovo, 9 test)
- `tests/Unit/HasRatingsTraitFormDataTest.php` (hydrate alimentato da `ratingMorphs`)
- `tests/Fixtures/RatingsHostStiChildStub.php` (nuovo: figlio STI con semantica Parental)

## Coordinamento

Le modifiche sono finite in HEAD del repo Rating tramite i commit automatici `.` di un altro
processo (`3a9c77f` 11:40, `f2c6332` 11:44), non committate da questa sessione.

## Regressione e ripristino (2026-10-07, PHPStan fase C)

PHPStan segnalava `method.notFound` su `ratingMorphTypes()` (4 chiamate in
`HasRatingsTraitMorphTypesTest`, righe 65, 72, 78, 82). Non era un problema di visibilita'
ne' di stub: il metodo **non esisteva piu' nel trait**.

- Causa radice: lo stato del trait in HEAD era quello precedente a questa story (nessun
  `ratingMorphTypes()`, `ratingMorphs()` ancora su `[getMorphClass(), static::class]`, niente
  `preferredRatingPivot()`, `hydrateRatingsFormData()` su `$this->ratings`, writer senza
  `unsetRelation`). Il repo Rating e' stato ricomposto in un unico commit (`821a596`), quindi
  `git log -S` non mostra quando le modifiche del 2026-09-29 sono state perse. Il test e lo
  stub STI erano sopravvissuti: documentavano un contratto che il trait non onorava piu'.
- Fix in avanti, nel trait (la sorgente giusta; test e stub erano corretti):
  `ratingMorphTypes()` pubblico (alias + `Relation::getMorphedModel(alias)`, senza duplicati),
  usato da `ratingMorphs()`; `preferredRatingPivot()` (voto, poi nota, poi prima riga) usato da
  `ratings_by_id`; `hydrateRatingsFormData()` legge da `ratings_by_id`;
  `syncRatingsFormData()`, `clearEvaluation()`, `syncRatingsWhere()` scaricano `ratings` e
  `ratingMorphs` via `forgetLoadedRatingRelations()`.
  `ratingMorphTypes()` e' stato aggiunto per primo da un'altra sessione (task phpstan-errors-29);
  il resto del contratto e' stato completato qui.
- Test `HasRatingsTraitFormDataTest` (3 casi di `hydrateRatingsFormData`): alimentati da
  `ratingMorphs` (helper `hostWithMorphRows`), come previsto da questa story e mai riportato nel
  file in HEAD.
- Verifica: `pest` su MorphTypes + FormData + RatingsById + Accessors + OtherOption +
  FormFieldLabel: 54 passati, 4 falliti. I 4 falliti sono gli stessi del 2026-09-29
  (`myRatings`, `ratingObjectives`, `syncRatingsWhere` x2: `Unable to resolve caller object for
  getClassName()`, ambientale, 18.59). MorphTypes: 9 su 9 verdi. PHPStan su trait, 2 test, 2
  stub: `[OK] No errors`.
- Nota ambiente: `pest` richiede `DB_CONNECTION=sqlite DB_DATABASE=fixcity_data_test`
  (il DB MariaDB `fixcity_data_test` non esiste su questa macchina).


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

- Red: 12 falliti, 7 passati (`HasRatingsTraitMorphTypesTest` + `HasRatingsTraitFormDataTest`).
- Green: `pest` su MorphTypes + FormData + RatingsById + Accessors + BaseRatingXlsExportValue:
  **42 passati, 4 falliti**. I 4 falliti sono gli stessi del baseline prima dell'edit
  (33 passati, 4 falliti in `HasRatingsTraitAccessorsTest`: myRatings, ratingObjectives,
  syncRatingsWhere x2, tutti `Unable to resolve caller object for getClassName()`).
- PHPStan (livello da `phpstan.neon`, cache isolata) sui 4 file toccati: `[OK] No errors`.
- PHPMD (`tools/phpmd.sh`): 0 nuovi. 4 preesistenti, identici su `944bf31`
  (CyclomaticComplexity syncRatingsFormData=10, 2 MissingImport `\LogicException`,
  UnusedFormalParameter `clearRatingsFormData($ratings)`).
- PHPInsights: trait 96.5 / 100 / 100 / 96.3; test 98.8 / 100 / 100 / 97.5. Le righe segnalate
  sul trait sono codice preesistente.
- Lettura reale (sola lettura) su 9240 dopo il fix: `ratingMorphTypes` =
  `["indennita_responsabilita", "Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita"]`.
  Nota: alle 11:34:54 la scheda e' stata salvata da un utente (dal=20260401, voti uguali sulle
  due forme), quindi la misura delle righe vuote non e' piu' riproducibile su 9240.
- Suite intera `Modules/Rating/tests/Unit`: oltre 580 s sotto carico (decine di processi
  PHPStan di altre sessioni), non completata. Eseguiti i 5 file che toccano il trait.
