---
title: "Topic rating-export"
type: digest
status: active
qmd: "digest ceiling 100 rating-export"
---

# Topic rating-export

Sintesi automatica di 3 documenti (chiave `rating-export`).

## Architecture: metodo riutilizzabile per getXlsFields dei rating

_Fonte: `bmad/architecture/rating-export-fields-reusable.md`_

# Architecture: metodo riutilizzabile per getXlsFields dei rating

## Scopo
Fornire un metodo riutilizzabile per generare l logica di preparazione dei campi per l'esportazione XLS/XLSX dei rating collegati a un modello host tramite `extra_attributes`.

## Contesto
Attualmente, la logica per costruire l'array di campi da esportare (vedi `IndennitaResponsabilitaResource::getXlsFields()`) è duplicata o molto simile in altri resource host che hanno bisogno di esportare rating (es. Ptv, Performance, Progressioni). Questa logica include:
- Recupero di parametri (anno, type) dai dati del form
- Risoluzione del modello host e del relativo alias tipo
- Query sui rating con filtri su `extra_attributes`
- Filtraggio dei soli criteri (rating senza figli)
- Eager load delle relazioni necessarie (`children`)
- Costruzione delle colonne di export:
  - Colonna valore: `ratings_by_id.{id}.xls_export_value` (txt del figlio se Select, altrimenti pivot.value)
  - Colonna nota (se applicabile): `ratings_by_id.{id}.pivot.note`
  - Etichette leggibili tramite `HasRatingsTrait::formFieldLabel()`

## Progettazione
### Opzione 1: Metodo in RatingData.php (preferita dall'utente)
```php
namespace Modules\Rating\Datas;

use Illuminate\Support\Arr;
use Modules\Rating\Models\Rating;
use Modules\Rating\Traits\HasRatingsTrait;
use Illuminate\Support\Facades\Lang;

class RatingData extends Data
{

## Brainstorming: metodo riutilizzabile per getXlsFields dei rating

_Fonte: `bmad/brainstorming/rating-export-fields-reusable.md`_

# Brainstorming: metodo riutilizzabile per getXlsFields dei rating

## Contesto
Il blocco `getXlsFields` in `IndennitaResponsabilitaResource.php` contiene logica per:
1. Recuperare anno e type dai dati
2. Risolvere il modello host tramite `static::getModel()` e `classToAlias()`
3. Query rating con `extra_attributes->anno` e `extra_attributes->type`
4. Filtrare solo criteri (parent_id null)
5. Eager load `children`
6. Per ogni rating:
   - Calcolare label tramite `HasRatingsTrait::formFieldLabel()`
   - Aggiungere colonna valore (`ratingXlsValuePath`)
   - Se il rating ha figli, aggiungere colonna nota (`ratingValuePath(..., 'note')`)
Questa logica è potenzialmente riutilizzabile da altri resource host (es. Ptv, Performance, Progressioni) che hanno bisogno di esportare rating collegati tramite `extra_attributes`.

## Domande chiave e analisi (con percentuali di fiducia)

### 1. Dove posizionare il metodo riutilizzabile?
- **Opzione A: HasRatingsTrait.php** (80%)
  - Pro: già contiene helper per rating (`ratingXlsValuePath`, `ratingValuePath`, `formFieldLabel`); logica strettamente legata al dominio rating
  - Contro: il trait è usato sui modelli host (es. IndennitaResponsabilita), non sui rating stessi; un metodo che restituisce array di campi per export potrebbe non appartenere al trait (violazione SRP leggera)
- **Opzione B: RatingData.php** (60% - preferita dall'utente)
  - Pro: già esiste come DTO per rating; potrebbe contenere metodi di utilità legati alla struttura dei r

## Epic 5.249: Rating: export XLS e path come SSoT in `RatingData`

_Fonte: `bmad/epics/rating-export-ssot.md`_

# Epic 5.249: Rating: export XLS e path come SSoT in `RatingData`

> **SUMMARY**: Epic di rifinitura del lato export del modulo `Rating`: tutti i path di
> valore, le label di form e i campi XLS devono derivare da `app/Datas/RatingData.php`,
> senza copie nei modelli, nelle colonne Filament o nei form host.

## Perche ora

`app/Datas/RatingData.php` raccoglie gia' i metodi canonici
(`ratingValuePath()`, `ratingXlsValuePath()`, `ratingFieldName()`, `formFieldLabel()`,
`getXlsFields()`, `criteriaToXlsFields()`), ma restano nel modulo copie di logica equivalente
e residui da allineare: il modello ha ancora accessor di export
(`BaseRating::getXlsExportValueAttribute()`), la colonna e la sezione form decorano i campi
per conto proprio, e `tests/` contiene sia test del SSoT sia test che ne reimplementano le regole.

## Scope

In scope:
- verifica che ogni consumer di path/label XLS chiami `RatingData`;
- allineamento di `BaseRating` (`getXlsExportValueAttribute()`, `getValueHtml()`, `getNoteHtml()`)
  al SSoT senza breaking change sul contratto;
- riuso di `DecoratesRatingFormFields::applyDefaultRatingFieldDecoration()` da tutte le form;
- copertura Pest dei casi ancora scoperti sui metodi `RatingData`.

Out of scope:
- modifiche a concrete di `Rating` in altri moduli (es. `Ptv\Models\Rating`);
- cambio del formato XLS o del naming delle colonne;
- UI nuova.
