---
title: "Generic UI Building Blocks: Category, Collection, FieldOption"
type: concept
tags: [models, actions, category, collection, field-option]
created: 2026-07-20
updated: 2026-10-23
qmd: "generic-ui-building-blocks category collection fieldoption"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./table-layout-toggle.md"
status: draft
---

# Generic UI Building Blocks: Category, Collection, FieldOption

## Scopo

Tre modelli generici, indipendenti dal dominio, pensati per essere riutilizzati da qualsiasi
modulo che abbia bisogno di tassonomie (`Category`), raggruppamenti eterogenei (`Collection`)
o opzioni per campi dinamici (`FieldOption`), senza dover reinventare la stessa tabella in
ogni modulo. Introdotti il 2026-07-15 (vedi `database/migrations/2026_07_15_1000{00,01,02}_*`).
Estendono `Modules\Xot\Models\BaseModel` (non `FormBuilder`, che non è disponibile in questo
contesto: annotato nei PHPDoc dei tre modelli).

## Stato attuale (2026-07-20)

- Nessuna risorsa Filament esiste ancora per questi modelli (`app/Filament/Resources/` è vuota,
  solo `.gitkeep`). Sono solo modelli + migrazioni, pronti per essere esposti in Admin ma non
  ancora collegati a un `Resource`.
- Nessuna relazione Eloquent è definita: `Category::parent_id` e `Collection::theme_id` sono
  colonne semplici, non `belongsTo()`. Se serve la gerarchia self-referencing su `Category` o il
  collegamento a un modello Theme su `Collection`, va aggiunta esplicitamente: al momento è
  responsabilità del chiamante gestire l'FK a mano.
- `FieldOption::field_id` è una stringa libera (non FK tipizzata), pensata per riferirsi a un
  campo dinamico identificato per nome/slug piuttosto che per id di un'altra tabella: nessun
  modello `Field` esiste in questo modulo.

## Category

Tabella `categories`. Campi: `name`, `title` (obbligatorio), `slug`, `parent_id` (per gerarchie,
non ancora relazionato), `description`, `icon`, `is_active`, `sort_order`. Soft-deletes con
`created_by`/`updated_by`/`deleted_by` (tracciamento standard Xot).

## Collection

Tabella `collections`. Campi: `name`, `description`, `type` (stringa libera per discriminare
categorie di collection), `theme_id` (non relazionato), `is_active`, `order`. Pensata come
raggruppamento generico di elementi eterogenei per tema/tipo.

## FieldOption

Tabella `field_options`. Campi: `field_id` (stringa, riferimento libero a un campo dinamico),
`label`, `value`, `order`. Building block per popolare select/radio/checkbox di form dinamici
costruiti altrove (es. FormBuilder-like), senza dipendere dal modulo FormBuilder.

## Actions del modulo (app/Actions/)

Il modulo segue la convenzione `QueueableAction` (trait `Spatie\QueueableAction\QueueableAction`,
unico entrypoint `execute()`). Azioni presenti, raggruppate per sotto-cartella:

- `GetUserDataAction` (root): legge `Auth::user()` e produce un `UserData` (avatar, ruolo,
  permessi, settings) per l'header/UI utente. Ritorna `null` se non autenticato.
- `Block/GetAllBlocksAction`: scansiona tutti i moduli (`base_path('Modules')/*/.../Filament/Blocks/*.php`)
  e produce l'elenco dei blocchi Filament disponibili come `DataCollection<ComponentFileData>`.
  Cross-modulo per costruzione (glob su tutti i moduli), non solo su UI.
- `Block/ResolveLocalizedBlockDataAction`: **delega opzionale al modulo Cms**: se
  `Modules\Cms\Actions\ResolveLocalizedBlockDataAction` esiste (`class_exists`), la usa per
  risolvere dati di blocco localizzati; altrimenti restituisce i `viewParams` invariati. Pattern
  di dipendenza opzionale via reflection/class_exists per evitare un hard dependency da UI verso Cms.
- `Icon/GetAllIconsAction`: enumera le icone registrate in `BladeUI\Icons\Factory` via reflection
  sulla proprietà privata `iconSets` (nessuna API pubblica esposta dal package per farlo), poi
  scansiona i file `.svg` di ogni set. Fragile per definizione: se BladeUI Icons cambia il nome
  interno della proprietà, l'azione fallisce silenziosamente (ritorna `[]` nel `catch`).
- `Datetime/GetDaysMappingAction`: genera la mappa `giorno_settimana => label localizzata`
  partendo da `Carbon`, usata per select di giorni ricorrenti (es. orari apertura).
- `Panel/ApplyCalendarToPanelAction`: **temporaneamente no-op**: `Saade\FilamentFullCalendar`
  non è ancora compatibile con Filament v4, quindi l'azione logga (se `app.debug`) e ritorna il
  `Panel` senza modifiche. C'è un file gemello `.disabled` nella stessa cartella da rimuovere
  quando il pacchetto sarà aggiornato.

## Violazione regola di dipendenza (LocationSelector): chiusa

`LocationSelector` e' una classe **Geo** finita in UI: importava `Modules\Geo\Models\Comune` (per stringa, dietro `class_exists`). La regola del progetto e' che `Modules/UI` non dipende da `Modules/Geo` (direzione corretta: Geo verso UI). La versione canonica vive in `Modules\Geo\Filament\Forms\Components\LocationSelector` (chiavi lingua `geo::location_selector.*`).

Storia: cancellato da UI il 2026-10-08 (`616345f9`, poi `0ecaedc4`), riportato dal pull del 2026-10-20 (commit `294bbc20`, con `LocationSelector.php.to_geo` e `lang/*/location_selector.php`), cancellato di nuovo il 2026-10-21: `.to_geo` e le lang in `83cc85a8`, `LocationSelector.php` in `4934d4c9` (verificato 2026-10-23: `test ! -f app/Filament/Forms/Components/LocationSelector.php`). Dettagli in [phpstan-test-wave-ui](../../stories/phpstan-test-wave-ui.story.md). Non ricrearlo in UI, ne' come stub che estende la classe Geo, ne' come null-adapter, ne' con suffisso `.to_geo`.

Le Action di questo modulo restano quelle elencate sopra (icone, datetime, blocchi, user header). Niente Action di geocoding/mappe qui: quelle, se un giorno serviranno, sono `QueueableAction` in `Modules/Geo`.

## Config path

`config/config.php` (minuscolo) è il path corretto e già in uso in questo modulo: nessuna
violazione trovata su questo punto.
