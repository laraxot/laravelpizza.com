---
title: "IDColumn, ancora di riga e ritorno alla lista (`return_to`)"
type: story
module: Xot
status: review
created: 2026-10-30
updated: 2026-10-30
tags: [filament, idcolumn, recordanchor, return_to, hasxottable, handoff]
qmd: "IDColumn RecordAnchor return_to ancora riga record-N colonna nascosta toggleable isToggledHiddenByDefault HasXotTable withRecordReturnTo annulla salvataggio stessa origine"
related:
  - ../../../UI/docs/bmad/filament-blueprint.md
  - ../../../../../docs/stories/mobile-ui-ux-pass.story.md
---

# IDColumn, ancora di riga e ritorno alla lista

## Richiesta dell'utente

> «al posto di `'id' => TextColumn::make('id')` meglio `'id' => IDColumn::make('id')` … anchor link … sempre in filament way, fa tutto con ecc + filament blueprint + bmad + second brain» (estratto)

## Perche'

Aprire un record da una lista e tornare indietro faceva perdere il punto in cui si era: pagina, filtri, riga. `IDColumn` mette sulla riga l'ancora `record-N`; il link di riga porta `return_to=<lista>#record-N`, e sia «Annulla» sia il salvataggio riportano la stessa riga, evidenziata dal CSS con `:target`.

## Owned File/Module Scope

| Modulo | Cosa |
|---|---|
| Xot | `RecordAnchor` (`id`, `fragment`, `appendTo`, `currentUrl`, `appendReturnTo`, `resolveReturnTo`), `HasXotTable` (azioni di riga), pagine base `XotBase{List,Create,Edit,View}Record(s)`, `XotBaseManageRelatedRecords`, `ColumnBuilder::id`, `record-anchor-highlight.css` registrato dal pannello Xot |
| UI | `IDColumn` |
| Tutti i moduli con tabelle Filament | `TextColumn::make('id')` -> `IDColumn::make('id')` (92 file) |
| TechPlanner | le quattro liste con ID nascosto di default: Devices, MedicalDirectors, LegalOffices, Appointments |

## Come funziona

- `IDColumn` emette `<span id="record-N">` nella cella. Con l'ID visibile l'ancora e' quella della colonna.
- Se l'ID e' nascosto di default (`toggleable(isToggledHiddenByDefault: true)`, la regola dei `*Table`) Filament non rende la colonna (`getVisibleColumns()` la scarta) e `#record-N` non troverebbe nulla. In `HasXotTable::getTableActions()` l'azione di riga `view` (o `edit`, se manca la view) porta allora `id="record-N"`; con l'ID visibile resta lo `<span>` della colonna, quindi non esistono mai due `id` uguali.
- `view` e `edit` aggiungono `return_to=<lista>#record-N` (`withRecordReturnTo`, statico: nei fixture di test `$this` sarebbe `*NEVER*` per PHPStan).
- `RecordAnchor::currentUrl()` usa `Livewire::originalUrl()` durante una richiesta Livewire, perche' `request()->fullUrl()` sarebbe `/livewire-.../update` e la query della lista andrebbe persa.
- `XotBaseEditRecord::getCancelFormAction()` va all'URL con ancora. Filament di suo usa `history.back()`, che riapre la lista senza ancora. `HasXotFormAction::getCancelFormAction()` non riguarda le pagine edit.
- Il CSS evidenzia `.fi-ta-row:has(:target)` e anche `.fi-ta-record` (layout a griglia).

### Perche' non le altre strade per l'ID nascosto

1. Forzare l'ID visibile cambiava l'aspetto di circa 35 liste.
2. `visibleFrom('md')` lascia la cella nel DOM ma i browser non scorrono verso `display:none`: su mobile niente scroll.
3. Un parametro `?highlight=ID` che la lista traduce in classe sul `<tr>` e' un cambio di disegno, non una correzione.

### Validazione di `return_to`

Il valore arriva dalla query string, quindi `resolveReturnTo()` lo accetta solo se e' un percorso che inizia con una sola `/` oppure un URL che comincia con l'origine della richiesta (schema, host e porta, seguiti da `/`), con frammento assente o `record-...`. Respinge caratteri di controllo, spazi e `\`. Il motivo: il browser legge `\` come `/` e ignora tab e a capo dentro l'URL, e confrontare solo l'host lascia passare `https://host/` su un'app in http e `host:8080`. `parse_url()` da solo non basta a dire se due URL hanno la stessa origine.

## Cosa e' cambiato

- 92 file migrati da `TextColumn::make('id')` a `IDColumn::make('id')` (codemod con backup e 4 file a mano). Dove c'era `->numeric()` e' stato tolto: sostituiva il formato e faceva sparire l'ancora.
- Restano `TextColumn::make('id')` solo in `OauthDeviceCodeResource` e `OauthAuthCodeResource`, i cui id sono codici-token con `limit` e formato propri, e nei fixture di test.

## Non verificato

- Il test mirato e' stato eseguito in due modalita': con l'ambiente predefinito il bootstrap lo rifiuta correttamente (`APP_ENV=local`); anche impostando `APP_ENV=testing`, il bootstrap applicativo continua a risolvere `local` e quindi la guardia interrompe il test prima delle asserzioni. Non e' stata bypassata la guardia e non e' stato toccato il database.
- Nessuna pagina del pannello e' stata aperta in un browser (serve il login): scroll ed evidenziazione su desktop e mobile non sono verificati.
- Verifiche fatte a runtime senza database: un `Table` simulato (`getVisibleColumns()` con e senza `IDColumn`) un harness PHP su `resolveReturnTo()` (28 valori da rifiutare, 7 da accettare) e una lettura indipendente di sicurezza con fuzz differenziale PHP contro il parser URL dei browser (circa 109.000 candidati: nessun valore accettato apre un'origine diversa, nessuna eccezione).
- PHPStan su `Modules` (livello max) rieseguito dopo la modifica di `RecordAnchor` e del test: **0 errori**. Una corsa precedente, a merge Tenant ancora aperto, ne aveva 108 tutti in `Modules/TechPlanner/config/*.php`, sotto il claim di un altro agente («PHPStan TechPlanner config cache-safe duplicate cleanup»): che li ha chiusi, non io.

## Audit disgiunto RecordAnchor / test

La revisione ha confermato il contratto corrente senza regressioni dimostrate:

- `RecordAnchor::currentUrl()` distingue correttamente una pagina HTTP dalla richiesta Livewire di aggiornamento.
- `appendReturnTo()` conserva query e frammento dell'elenco e costruisce il parametro con `PHP_QUERY_RFC3986`.
- `resolveReturnTo()` applica una allowlist same-origin su schema, host e porta, rifiuta caratteri che il parser URL del browser interpreta in modo ambiguo e limita il frammento al formato `record-*`.
- `IDColumn` e l'ancora sull'azione di riga fanno escaping HTML; il test copre host esterno, schema, porta, userinfo, backslash e caratteri di controllo.
- Il test usa `XotBaseTestCase`, evitando `DatabaseTransactions` per una suite che esercita solo URL e request. Il bootstrap applicativo resta comunque soggetto alla guardia del database: l'isolamento non viene simulato né allentato.

Verifiche di questa revisione:

- PHPStan mirato su `RecordAnchor.php` e `RecordAnchorReturnUrlTest.php`: **0 errori**.
- Pest mirato: bloccato prima delle asserzioni dalla guardia `TestDatabaseGuard` perché il processo non carica un ambiente `testing` effettivo; nessuna regressione funzionale è stata quindi osservata nel codice sotto test.
- Nessuna modifica a `RecordAnchor.php` o al test: il worktree contiene lavoro concorrente e non è stata dimostrata una correzione necessaria.

## Aperto

1. Controllo a video di scroll ed evidenziazione, in particolare nelle quattro liste di TechPlanner e in layout a griglia su mobile.
2. Eseguire `RecordAnchorReturnUrlTest` quando esiste un database di test isolato.
3. Decidere se le due tabelle Oauth meritano un'ancora con il loro formato.

## Claim

| Chi | Scope | Stato |
|---|---|---|
| sessione 97f16a39 | implementazione di `IDColumn`, `RecordAnchor`, azioni di riga, CSS, migrazione delle tabelle | rilasciato |
| sessione 56da8100 | passaggio di consegne da `docs/chat` a questa story, validazione di `return_to` e relativo test | rilasciato |
