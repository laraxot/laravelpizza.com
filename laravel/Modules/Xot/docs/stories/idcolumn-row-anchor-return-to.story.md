---
title: "IDColumn e ritorno alla riga: dalla view/edit/create si torna alla lista sulla stessa riga"
type: story
status: review
module: Xot
epic: filament-tables
updated: 2026-10-30
tags: [filament, idcolumn, recordanchor, return_to, tables, handoff]
related:
  - ../../../UI/docs/stories/idcolumn-row-anchor-return-to.story.md
  - ../../../UI/docs/bmad/filament-blueprint.md
  - ../../../../../docs/chat/handoff-idcolumn-row-anchor.md
---

# IDColumn e ritorno alla riga

**Story ID:** filament-tables.idcolumn-row-anchor
**Status:** review   <!-- backlog -> ready-for-dev -> in-progress -> review -> done -->

> Sostituisce l'handoff `docs/chat/handoff-idcolumn-row-anchor.md`: da qui in poi chi riprende questo lavoro aggiorna **questa** story (sezione Dev Agent Record), non la chat.

## Story

Come **operatore del pannello admin**, voglio che, aprendo un record da una lista e tornando indietro (Annulla, Salva, freccia), la lista si riapra gia' posizionata sulla riga da cui sono partito, cosi' che su tabelle lunghe non perda il punto di lavoro.

## Acceptance Criteria

<!-- LOCKED: non modificare senza un aggiornamento esplicito della story. -->

1. Le azioni di riga `view` ed `edit` e il pulsante «Crea» delle liste Xot aggiungono `return_to=<URL della lista>#record-N` all'indirizzo di destinazione, senza codice nelle singole Resource.
2. «Annulla» dell'edit (`XotBaseEditRecord::getCancelFormAction()`) porta all'URL della lista con l'ancora, non a `history.back()`.
3. L'ancora `id="record-N"` esiste una volta sola per riga: nella cella `IDColumn` quando l'ID e' visibile, altrimenti sull'azione di riga `view` (o `edit` se manca la view).
4. `return_to` accetta solo URL dello stesso host: un host ostile viene rifiutato.
5. Ogni tabella con `TextColumn::make('id')` usa `IDColumn::make('id')`, eccetto gli id che sono codici-token (`OauthDeviceCodeResource`, `OauthAuthCodeResource`).
6. La riga raggiunta dall'ancora e' evidenziata (`:target` / `:has(:target)`) e non resta sotto la barra sticky del pannello.
7. `./vendor/bin/phpstan analyse Modules` (livello `max`) termina con exit 0.

## Tasks / Subtasks

- [x] `RecordAnchor::currentUrl()`, `appendReturnTo()`, `resolveReturnTo()` (AC: #1, #4)
- [x] `HasXotTable::getTableActions()` con `withRecordReturnTo` statico, ancora sull'azione se l'ID e' nascosto (AC: #1, #3)
- [x] `XotBaseListRecords` («Crea») e `XotBaseEditRecord::getCancelFormAction()` (AC: #1, #2)
- [x] CSS `record-anchor-highlight.css`, registrato in `Xot/AdminPanelProvider` (AC: #6)
- [x] Migrazione `TextColumn::make('id')` -> `IDColumn::make('id')` in 92 file (AC: #5)
- [x] PHPStan `Modules` completo exit 0 (AC: #7)
- [ ] Eseguire `Modules/Xot/tests/Unit/RecordAnchorReturnUrlTest.php` quando esiste un database di test `*_test` o sqlite (AC: #1, #4)
- [ ] Verifica a video nel pannello, con login: tornare da view/edit/create e vedere la riga evidenziata (AC: #2, #3, #6)
- [ ] Decidere se `OauthDeviceCodeResource` e `OauthAuthCodeResource` restano con `TextColumn` (AC: #5)

## Dev Notes

<!-- LOCKED. -->

- **Perche' una base e non le Resource:** le liste sono generate da `HasXotTable`/`XotBaseListRecords`; mettere la logica li' fa valere per le ~100 tabelle senza toccarle una per una. [Source: `Modules/Xot/app/Filament/Traits/HasXotTable.php`]
- **Livewire:** in una richiesta Livewire `request()->fullUrl()` e' `/livewire-.../update`, quindi `RecordAnchor::currentUrl()` usa `Livewire::originalUrl()`. Limite noto: dell'URL originale si conserva il percorso, la query string della lista (filtri, pagina) si perde in quel caso.
- **Colonna nascosta di default:** la regola dei `*Table` e' `toggleable(isToggledHiddenByDefault: true)` e Filament non rende una colonna nascosta (`getVisibleColumns()`), quindi in ~35 tabelle l'ancora non esisteva. Scelta fatta: se nessuna `IDColumn` e' visibile, l'`id` va sull'azione di riga. Scartate: forzare l'ID visibile (cambia l'aspetto di decine di liste), `visibleFrom('md')` (i browser non scorrono verso `display:none`), `?highlight=ID` (cambio di disegno). [Source: handoff `docs/chat/handoff-idcolumn-row-anchor.md`]
- **Pannello senza Tailwind:** `scroll-mt-24` nel markup da solo non fa nulla; l'offset sta nel CSS dedicato. `AssetAction` copia il CSS in `public` solo la prima volta.
- **`IDColumn`:** non forza `searchable()` ne' `label()`; con `copyable()` copia il valore grezzo. `->numeric()` o `->formatStateUsing()` dopo `IDColumn::make` sostituiscono il formato e l'ancora sparisce: tolti nei tre punti che li avevano.
- **Trappola PHPStan `max`:** sotto `if (method_exists($resource, 'canView'))` i fixture di test (`$resource = $this`) hanno il ramo morto e `$this` diventa `*NEVER*`; usare metodi `private static` con `self::`. `Action::getRecord()` torna `Model|array|null`: filtrare con `instanceof Model`.
- **`HasXotFormAction::getCancelFormAction()`** non riguarda le pagine edit: lo usa solo `XotBaseWizardWidget`.
- [Inference] `return_to` e' un parametro di redirect: la guardia sull'host (AC #4) e' la parte sensibile e va coperta da un test eseguito, non solo dal controllo a mano.

## Testing

<!-- LOCKED. Solo strategia, nessun esito. -->

- **Approccio:** test unit su `RecordAnchor` (catena `currentUrl` -> `appendReturnTo` -> `resolveReturnTo`); verifica a video per l'evidenziazione.
- **Per AC:** #1 e #4 -> `RecordAnchorReturnUrlTest`; #2 e #6 -> pannello con login; #3 -> `Table` simulato con e senza `IDColumn` visibile (`getVisibleColumns()`); #5 -> `grep -rIl --include='*.php' "TextColumn::make('id')" Modules Themes` (restano solo Oauth e i fixture di test); #7 -> PHPStan.
- **Casi limite:** host ostile e URL con schema diverso; richiesta Livewire senza query string; tabella in RelationManager o modale (URL di base `null`).
- **Vincolo:** il database di test non esiste e `TestDatabaseGuard` rifiuta tutto cio' che non finisce in `_test` o sqlite; mai `RefreshDatabase` ne' comandi distruttivi sui dati reali.

## Dependency Maps

- **Blocked by:** nessuna.
- **Blocks:** nessuna.
- **External:** Filament 5.11 e Livewire 4.4.8 (`Table`, `Action`, `Livewire::originalUrl()`).
- **Decisione dell'utente aperta:** i due id Oauth (AC #5).

## Owned File/Module Scope

- `laravel/Modules/Xot/app/Filament/Links/RecordAnchor.php`
- `laravel/Modules/Xot/app/Filament/Traits/HasXotTable.php`
- `laravel/Modules/Xot/app/Filament/Resources/Pages/XotBaseListRecords.php`
- `laravel/Modules/Xot/app/Filament/Resources/Pages/XotBaseEditRecord.php`
- `laravel/Modules/Xot/app/Providers/Filament/AdminPanelProvider.php`
- `laravel/Modules/Xot/resources/css/record-anchor-highlight.css`
- `laravel/Modules/Xot/tests/Unit/RecordAnchorReturnUrlTest.php`
- `laravel/Modules/UI/app/Filament/Tables/Columns/IDColumn.php` (story puntatore in UI)
- Migrazione `IDColumn` nei `Tables`/`Resources` di User (47), Job (11), Gdpr (11), Xot, TechPlanner, Notify, Media, Activity (5 ciascuno), Geo, Employee (2), UI, Tenant, AI (1): modifica meccanica, nessun'altra logica.
- Condiviso con altri agenti: le Blade e i `lang/` dei moduli (campagna i18n) e `Themes/Two`; usare `bash bashscripts/lock/check.sh <file>` prima di toccare.

## Learnings from Previous Stories

- Un'altra sessione (56da8100) aveva gia' fatto `IDColumn`, `RecordAnchor`, le pagine base `XotBase{List,Create,Edit,View}Record(s)` e il blueprint UI: questa story completa i pezzi mancanti senza duplicarli.
- La notifica «completed (exit code 0)» di un comando in background e' quella della shell: l'esito di PHPStan e' la riga `exit=` scritta nel file di output.

## GitHub (tracciamento)

| Tipo | Repo | # | URL |
|------|------|---|-----|
| Issue (coordinamento) | laraxot/base_techplanner_fila5 | 18 | https://github.com/laraxot/base_techplanner_fila5/issues/18 |
| **Discussion** (canon) | laraxot/base_techplanner_fila5 | 54 | https://github.com/laraxot/base_techplanner_fila5/discussions/54 |

Nessuna issue dedicata a questa story nel repo `module_xot_fila5`: non ne ho aperta una perche' il repo e' pubblico; da aprire su conferma dell'utente. I commenti di collegamento alle thread sopra non sono stati pubblicati.

## Dev Agent Record

<!-- Compilata dall'agente che esegue. -->

**Sessione 97f16a39, 2026-10-30.** Completati i pezzi mancanti sopra la base dell'altra sessione: ancora sull'azione di riga quando l'ID e' nascosto, `return_to` su Crea e Annulla, `Livewire::originalUrl()`, CSS di evidenziazione, migrazione di 92 file (88 con codemod con backup, 4 a mano), documentazione in `Modules/UI/docs/bmad/filament-blueprint.md`.

Verifiche eseguite: PHPStan su `Modules` completo exit 0; `php -l`; controlli a runtime in sola lettura con `artisan tinker --execute` (catena `currentUrl` -> `appendReturnTo` -> `resolveReturnTo`, host ostile rifiutato, logica dell'ancora con `Table` simulato). **Non verificato:** Pest non eseguito (guardia sul database di test), nessuna pagina del pannello vista (serve il login). Filament Blueprint e' una licenza a pagamento non installata. Nessun commit.
