---
title: "Filament Blueprint: UI"
type: filament-blueprint
status: active
module: UI
created: 2026-10-16
updated: 2026-10-28
tags: [bmad, filament, blueprint, ui]
qmd: "filament blueprint ui xotbase resource widget mobile stackedOnMobile touch target"
related:
  - ../bmad-planning.md
  - ../bmad-brainstorming.md
  - ../stories/mobile-ux-pass.story.md
---

# Scopo

Contratto Filament del modulo **UI**: chrome BO e/o widget FO senza violare
i confini di dominio.

## Regole non negoziabili

1. Estendere solo `XotBaseResource` / `XotBaseWidget` / basi Xot: mai classi Filament dirette.
2. Nessun `->label()` hardcoded: chiavi in `lang/<locale>/` del modulo.
3. Business logic nelle Actions del modulo, non nei form hooks grassi.
4. FO: widget montati esplicitamente; non abusare `discoverWidgets` per chrome.

## Resource / widget

- Nessuna Resource tipizzata in questo slice: documentare quando nasce.

## Form / Table / Infolist

Preferire triad schema dedicati (`*Form`, `*Table`, `*Infolist`) quando la Resource
cresce oltre pochi campi. Enum tipizzati al posto di option array.

Per l'identificatore della risorsa usare `IDColumn::make('id')` (non `TextColumn::make('id')`) quando
l'ID è l'identità della riga: la cella emette il target stabile `id="record-{id}"`. Non inserire un
`<a>` nella colonna: Filament può già avvolgere la cella nel link della riga e gli anchor annidati sono
markup non valido.

Colonna nascosta di default (`toggleable(isToggledHiddenByDefault: true)`, la regola nei `*Table`): Filament
non la renderizza, quindi lo `<span>` non esiste. In quel caso l'ancora `record-{id}` passa all'azione di riga
`view` (o `edit`, se non c'è la view) di `HasXotTable::getTableActions()`; con l'`IDColumn` visibile resta lo
`<span>` e l'azione non porta alcun `id`, così non ci sono mai due `id` uguali. Una tabella che costruisce le
proprie azioni senza `getTableActions()` deve mettere l'ancora da sé.

Come si torna alla riga (tutto nella base, nessun codice nelle singole Resource):

1. Le azioni di riga `view` e `edit` di `HasXotTable::getTableActions()` e l'azione «Crea» di
   `XotBaseListRecords` aggiungono `return_to=<URL dell'elenco>#record-{id}` (`RecordAnchor::currentUrl()`:
   durante una richiesta Livewire usa la pagina e non `/livewire/update`).
2. Salvataggio, «Indietro» della view e «Annulla» dell'edit portano a `return_to`. Senza (accesso diretto)
   edit e create ripiegano sulla pagina di provenienza, la view sull'elenco. `RecordAnchor::resolveReturnTo()`
   accetta solo http/https, stesso host e frammento `record-…`: un `return_to` ostile viene ignorato.
3. Il CSS `Modules/Xot/resources/css/record-anchor-highlight.css` (registrato in `AdminPanelProvider`) tiene la
   riga sotto la barra sticky e la evidenzia con contorno + sfondo, non col solo colore (WCAG 1.4.1), anche in
   modalità contrasto forzato. Il pannello admin non ha una build Tailwind propria: una classe come
   `scroll-mt-24` nel markup non produce nulla senza questo CSS.

`IDColumn` non forza `searchable()` (la ricerca sull'id è un `LIKE` su tutta la tabella: la sceglie la
Resource) né `label()` (lo risolve `Column::configureUsing`). Con `copyable()` copia il valore grezzo e non
lo `<span>`. Non concatenare `->numeric()` o `->formatStateUsing()`: sostituiscono il formato e l'ancora sparisce.

## Mobile

Le tabelle admin si aprono da telefono (360-430 px). Regole, con l'API Filament 5.11 che le realizza
(storia: [mobile-ux-pass](../stories/mobile-ux-pass.story.md)):

1. **Nessuno scroll orizzontale al primo schermo.** `Table::stackedOnMobile()` e' gia' attivo in `HasXotTable::table()`: sotto
   640 px ogni riga e' una card etichetta + valore. Una Resource che ricostruisce la tabella senza `parent::table()` deve
   richiamarlo.
2. **Una colonna sotto `md`.** `TableLayoutEnum::getTableContentGrid()` per la griglia; per i form `columns()` responsive e
   `columnSpanFull()`, mai un `int` che vale solo da `lg` se serve anche sui tablet.
3. **Bersaglio di tocco >= 44 px**, azioni distanti: `Modules/Xot/resources/css/mobile-touch-targets.css` (sotto 640 px, solo
   nelle tabelle impilate). Un'azione nuova nelle righe usa `iconButton()` e ne eredita l'area.
4. **Colonne secondarie** `visibleFrom('md')` o `toggleable()`: decide la Resource, non la base.
5. **Nessuna affordance solo-hover**: ogni azione solo-icona ha comunque un'etichetta (il tooltip non esiste al tocco).
6. **Filtri comprimibili** e azioni di riga raggruppate (`ActionGroup`): ancora aperti, cambiano anche il desktop (decisione
   nella story).

## Policy e tenant

Ogni query Filament rispetta tenant + policy del modello owner. Nessun elenco
cross-tenant per comodita admin.

## Related

- Planning: [bmad-planning.md](../bmad-planning.md)
- Brainstorming: [bmad-brainstorming.md](../bmad-brainstorming.md)
