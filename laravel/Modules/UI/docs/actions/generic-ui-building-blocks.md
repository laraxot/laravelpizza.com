---
title: "Generic UI Building Blocks: Category, Collection, FieldOption"
type: concept
tags: [models, actions, category, collection, field-option]
created: 2026-07-20
updated: 2026-07-20
qmd: "generic-ui-building-blocks category collection fieldoption"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]

issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]

related:
  - "./table-layout-toggle.md"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./table-layout-toggle.md"
  - "../geo-boundary.md"
---

# Generic UI Building Blocks: Category, Collection, FieldOption

## Scopo

Tre modelli generici, indipendenti dal dominio, pensati per essere riutilizzati da qualsiasi
modulo che abbia bisogno di tassonomie (`Category`), raggruppamenti eterogenei (`Collection`)
o opzioni per campi dinamici (`FieldOption`), senza dover reinventare la stessa tabella in
ogni modulo. Introdotti il 2026-07-15 (vedi `database/migrations/2026_07_15_1000{00,01,02}_*`).
Estendono `Modules\Xot\Models\BaseModel` (non `FormBuilder`, che non è disponibile in questo
contesto — annotato nei PHPDoc dei tre modelli).

## Stato attuale (2026-07-20)

- Nessuna risorsa Filament esiste ancora per questi modelli (`app/Filament/Resources/` è vuota,
  solo `.gitkeep`). Sono solo modelli + migrazioni, pronti per essere esposti in Admin ma non
  ancora collegati a un `Resource`.
- Nessuna relazione Eloquent è definita: `Category::parent_id` e `Collection::theme_id` sono
  colonne semplici, non `belongsTo()`. Se serve la gerarchia self-referencing su `Category` o il
  collegamento a un modello Theme su `Collection`, va aggiunta esplicitamente — al momento è
  responsabilità del chiamante gestire l'FK a mano.
- `FieldOption::field_id` è una stringa libera (non FK tipizzata), pensata per riferirsi a un
  campo dinamico identificato per nome/slug piuttosto che per id di un'altra tabella — nessun
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

- `GetUserDataAction` (root) — legge `Auth::user()` e produce un `UserData` (avatar, ruolo,
  permessi, settings) per l'header/UI utente. Ritorna `null` se non autenticato.
- `Block/GetAllBlocksAction` — scansiona tutti i moduli (`base_path('Modules')/*/.../Filament/Blocks/*.php`)
  e produce l'elenco dei blocchi Filament disponibili come `DataCollection<ComponentFileData>`.
  Cross-modulo per costruzione (glob su tutti i moduli), non solo su UI.
- `Block/ResolveLocalizedBlockDataAction` — **delega opzionale al modulo Cms**: se
  `Modules\Cms\Actions\ResolveLocalizedBlockDataAction` esiste (`class_exists`), la usa per
  risolvere dati di blocco localizzati; altrimenti restituisce i `viewParams` invariati. Pattern
  di dipendenza opzionale via reflection/class_exists per evitare un hard dependency da UI verso Cms.
- `Icon/GetAllIconsAction` — enumera le icone registrate in `BladeUI\Icons\Factory` via reflection
  sulla proprietà privata `iconSets` (nessuna API pubblica esposta dal package per farlo), poi
  scansiona i file `.svg` di ogni set. Fragile per definizione: se BladeUI Icons cambia il nome
  interno della proprietà, l'azione fallisce silenziosamente (ritorna `[]` nel `catch`).
- `Datetime/GetDaysMappingAction` — genera la mappa `giorno_settimana => label localizzata`
  partendo da `Carbon`, usata per select di giorni ricorrenti (es. orari apertura).
- `Panel/ApplyCalendarToPanelAction` — **temporaneamente no-op**: `Saade\FilamentFullCalendar`
  non è ancora compatibile con Filament v4, quindi l'azione logga (se `app.debug`) e ritorna il
  `Panel` senza modifiche. C'è un file gemello `.disabled` nella stessa cartella da rimuovere
  quando il pacchetto sarà aggiornato.

## Violazione regola di dipendenza — SOLO SEGNALAZIONE
`app/Filament/Forms/Components/LocationSelector.php` importa `Modules\Geo\Models\Comune`
(riga 11). La regola del progetto è che `Modules/UI` non deve mai dipendere da `Modules/Geo`
(la direzione corretta è Geo → UI). Esiste anche un file gemello
`LocationSelector.php.to_geo` con lo stesso import, che sembra un'indicazione che il file va
spostato nel modulo Geo ma non è stato ancora fatto. Non corretto in questo task (fuori scope,
solo documentazione) — richiede intervento separato per spostare/rifattorizzare il componente.
## Violazione regola di dipendenza — chiusa

`LocationSelector` importava `Modules\Geo\Models\Comune`: era una classe **Geo** messa in UI. In questo monorepo Geo è spento: il file attivo **non c’è** più (`test ! -f app/Filament/Forms/Components/LocationSelector.php`). Non ricrearlo, né come null-adapter, né con suffisso `.to_geo`.

Le Action di questo modulo restano quelle elencate sopra (icone, datetime, blocchi, user header). Niente Action di geocoding/mappe qui: quelle, se un giorno serviranno, sono `QueueableAction` in `Modules/Geo`.

Canon: [../geo-boundary.md](../geo-boundary.md).

## Config path

`config/config.php` (minuscolo) è il path corretto e già in uso in questo modulo — nessuna
violazione trovata su questo punto.
