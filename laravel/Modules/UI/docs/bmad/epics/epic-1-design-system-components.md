---
title: "Epic 1 — Consolidamento primitive Form/Table del modulo UI"
type: epic
tags: [bmad, ui, epic, design-system, form, table]
created: 2026-09-28
updated: 2026-09-28
title: "Epic 1 - Consolidamento primitive Form/Table del modulo UI"
type: epic
tags: [bmad, ui, epic, design-system, form, table]
created: 2026-09-28
updated: 2026-10-07
qmd: "UI epic consolidamento componenti form table layout trait enum duplicazioni"
module: UI
status: proposed
related:
  - ./module-roadmap.md
  - ../architecture.md
  - ../brainstorming.md
  - ../../../Xot/docs/bmad-method.md
---

# Epic 1 — Consolidamento primitive Form/Table
  - ../../../../Xot/docs/bmad-method.md
---

# Epic 1 - Consolidamento primitive Form/Table

> **SUMMARY**: epic che porta le primitive del design system UI a una sola sorgente per layout tabella, enum layout, fallback Map/Geocoding e data object, e allinea la copertura Pest. Scope limitato a `app/Traits`, `app/Filament/Actions/Table`, `app/Enums`, `app/Services/Map`, `app/Adapters/Map`, `app/Data`, `app/Datas`, `config/`.

## Numero e nome

Epic 1 — "UI primitives: un SSoT per layout, enum, fallback e data".

## Perché ora

Le duplicazioni rilevate in [../brainstorming.md](../brainstorming.md) sono tutte all'interno del modulo e hanno effetti osservabili: due trait con gli stessi metodi, due enum con scopi diversi, due fallback Map identici, due `UserData`, due config localization. Ogni consumatore deve indovin quale sia quella giusta.

## Scope

### Schema.org semantic primitives

UI now provides `OrganizationSection` and `OrganizationColumn` as a paired
Form/Table primitive for the common `schema.org/Organization` properties.
The pair follows the existing `PersonSection`/`PersonColumn` convention:
custom fields remain supported and no domain model is introduced.

`EventSection` and `EventColumn` extend the same minimal Form/Table pattern to
the common `schema.org/Event` fields. Event location, organizer and performer
are intentionally scalar fields: UI does not impose domain relationships.

**In scope**

- `app/Traits/TableLayoutTrait.php` (e `.bak`), `app/Filament/Actions/Table/TableLayoutTrait.php`, `app/Filament/Actions/Table/HasTableLayout.php`, `app/Contracts/HasTableLayout.php`.
- `app/Enums/TableLayout.php`, `app/Enums/TableLayoutEnum.php` e relative chiavi di traduzione in `resources/lang/{it,en}`.
Epic 1 - "UI primitives: un SSoT per layout, enum, fallback e data".

## Perché ora

Le duplicazioni rilevate in [../brainstorming.md](../brainstorming.md) sono tutte all'interno del modulo e hanno effetti osservabili: due trait con gli stessi metodi, due enum con scopi diversi, due fallback Map identici, due `UserData`, due config localization. Ogni consumatore deve indovinare quale sia quella giusta.

## Scope

### Primitive semantiche schema.org (stato attuale)

Il modulo UI fornisce `OrganizationSection` e `OrganizationColumn` come coppia Form/Table per le proprietà comuni di `schema.org/Organization`. La coppia segue la convenzione esistente di `PersonSection`/`PersonColumn`: i campi personalizzati restano supportati e non viene introdotto alcun modello di dominio.

`EventSection` e `EventColumn` estendono lo stesso schema minimo Form/Table ai campi comuni di `schema.org/Event`. Luogo, organizzatore ed esecutore dell'evento sono volutamente campi scalari: UI non impone relazioni di dominio.

File (verificati il 2026-10-07): `app/Filament/Forms/Components/{Person,Organization,Event}Section.php` e `app/Filament/Tables/Columns/{Person,Organization,Event}Column.php`. Queste primitive sono già consolidate e fuori dal perimetro di deduplicazione sotto, ma sono il riferimento per la Parità Form/Table (AC 6).

**In scope**

- `app/Traits/TableLayoutTrait.php` (e `.bak`), `app/Filament/Actions/Table/TableLayoutTrait.php`, `app/Filament/Actions/Table/HasTableLayout.php`, `app/Contracts/HasTableLayout.php`.
- `app/Enums/TableLayout.php`, `app/Enums/TableLayoutEnum.php` e relative chiavi di traduzione in `lang/{it,en}`.
- `app/Services/Map/Null*` e `app/Adapters/Map/Null*Adapter`, `app/Contracts/MapServiceContract.php`, `app/Contracts/GeocodingServiceContract.php`.
- `app/Data/UserData.php` e `app/Datas/UserData.php`.
- `config/laravel-localization.php`, `config/laravellocalization.php`.
- Test in `tests/Unit/Traits`, `tests/Unit/Enums`, `tests/Unit/UiFilamentSchemaCoverageTest.php`, `tests/Feature/OrderColumnTest.php`.

**Fuori scope**

- Blocchi Blade (`app/Filament/Blocks/`) e View component: nessuna duplicazione rilevata.
- Widget Filament attivi: la conversione Livewire è già tracciata nei documenti `livewire-widget-*.md`.
- Moduli consumatori: nessuna modifica fuori `Modules/UI`.

## Acceptance Criteria

1. **Un solo trait di layout**: `HasTableLayout::getTableLayout()`/`setTableLayout()` è implementato da un unico file; il file `.bak` non è più nel sorgente attivo e il secondo trait è alias o rimosso, senza cambi di comportamento.
2. **Un solo enum per il layout**: i consumer di `TableLayout` e `TableLayoutEnum` sono elencati con `grep` e migrati all'unico enum rimasto; le label passano da `resources/lang/{it,en}` senza stringhe hardcoded.
3. **Un solo fallback Map/Geocoding**: `Services/Map` o `Adapters/Map` è dichiarato SSoT; l'altra coppia è rimossa e i binding del provider puntano all'unico set.
4. **Un solo `UserData`**: `app/Data` o `app/Datas` è la directory canonica; il riferimento duplicato è rimosso e i test `tests/Unit/Datas/UIDatasCoverageTest.php` restano verdi.
5. **Un solo config localization**: il file effettivamente letto dal provider è identificato con `grep` su `UIServiceProvider.php`; l'altro è rimosso o documentato come alias.
6. **Parità Form/Table**: ogni colonna in `app/Filament/Tables/Columns/` che ha un campo Form gemello mantiene comportamento coerente — coperto da test Pest, non da ispezione manuale.
7. **Qualità**: `./vendor/bin/pint` pulito e `./vendor/bin/pest --filter` sui test toccati verde in ambiente non produzione (host `10.100.200.15` escluso).
8. **Documentazione allineata**: [../architecture.md](../architecture.md) e [../brainstorming.md](../brainstorming.md) aggiornati con la scelta presa per D1–D5, e AC chiuse riportate in `docs/sprint-status.yaml`.
2. **Un solo enum per il layout**: i consumer di `TableLayout` e `TableLayoutEnum` sono elencati con `grep` e migrati all'unico enum rimasto; le label passano da `lang/{it,en}` senza stringhe hardcoded.
3. **Un solo fallback Map/Geocoding**: `Services/Map` o `Adapters/Map` è dichiarato SSoT; l'altra coppia è rimossa e i binding del provider puntano all'unico set.
4. **Un solo `UserData`**: `app/Data` o `app/Datas` è la directory canonica; il riferimento duplicato è rimosso e i test `tests/Unit/Datas/UIDatasCoverageTest.php` restano verdi.
5. **Un solo config localization**: il file effettivamente letto dal provider è identificato con `grep` su `UIServiceProvider.php`; l'altro è rimosso o documentato come alias.
6. **Parità Form/Table**: ogni colonna in `app/Filament/Tables/Columns/` che ha un campo Form gemello mantiene comportamento coerente - coperto da test Pest, non da ispezione manuale.
7. **Qualità**: `./vendor/bin/pint` pulito e `./vendor/bin/pest --filter` sui test toccati verde in ambiente non produzione (host `10.100.200.15` escluso).
8. **Documentazione allineata**: [../architecture.md](../architecture.md) e [../brainstorming.md](../brainstorming.md) aggiornati con la scelta presa per D1-D5, e AC chiuse riportate in `docs/sprint-status.yaml` del repository radice (il modulo UI non ne ha uno proprio).

## Rischi

- Rimuovere un trait può rompere classi che lo `use` fuori dal modulo: mitigazione = `grep` completo prima della rimozione.
- Le label degli enum hanno consumatori in altri moduli: mitigazione = stessa scansione.
- File `.old`, `.disabled*`, `.bak` possono essere l'unico riferimento a una variante attesa da un test.

## Tracciabilità

- Epica di roadmap: [module-roadmap.md](module-roadmap.md), sezione "Epic A — Contratto e architettura" e "Epic B — Qualità verificabile".
- Metodo: [bmad-method.md](../../../Xot/docs/bmad-method.md).
- Epica di roadmap: [module-roadmap.md](module-roadmap.md), sezione "Epic A - Contratto e architettura" e "Epic B - Qualità verificabile".
- Metodo: [bmad-method.md](../../../../Xot/docs/bmad-method.md).
- Stato di avanzamento: da riportare nelle story in `../stories/` (non create in questa campagna).
