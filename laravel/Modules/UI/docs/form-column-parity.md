---
title: "Parita' Forms/Components <-> Tables/Columns in UI"
type: rule
tags: [filament, forms, columns, parity, ui]
created: 2026-09-01
updated: 2026-09-01
qmd: "form column parity ui addresscolumn openinghourscolumn"
related:
  - "../../Ptv/docs/form-column-parity.md"
  - "../app/Filament/Tables/Columns/GroupColumn.php"
---

# Parita' Forms/Components <-> Tables/Columns in UI

SSoT della regola: [`Modules/Ptv/docs/form-column-parity.md`](../../Ptv/docs/form-column-parity.md).
Questo file registra solo l'applicazione della regola dentro UI.

## Misura del 2026-09-01 (da Ptv/form-column-parity.md, tabella "altri moduli")

Su 15 componenti in `Modules/UI/app/Filament/Forms/Components/`, 2 avevano gemello
(`SelectState`, `TreeField`), 13 no. Applicando il discriminante della regola (raccoglie
piu' campi del model / e' un fatto di dominio → gemello; e' un modo di inserire un
valore → nessun gemello), solo **2 erano legittimi da creare**:

- `AddressField` (5 campi: country, street, city, state, zip, via relazione) → nessun gemello
- `OpeningHoursField` (orari settimanali per fascia) → nessun gemello

Gli altri 11 senza gemello sono widget di input (picker, editor, checkbox list, select)
senza fatto di dominio da mostrare in lista — nessun gemello dovuto, per lo stesso
discriminante.

## Fatto

- **`AddressColumn`** (`app/Filament/Tables/Columns/AddressColumn.php`) — estende
  `GroupColumn` come `AssenzeColumn` in Ptv, un `TextColumn` per campo con nome
  `{relazione}.{campo}` (dot-notation Filament per relazione). `fields()` per
  restringere l'elenco.
- **`OpeningHoursColumn`** (`app/Filament/Tables/Columns/OpeningHoursColumn.php`) —
  **non** estende `GroupColumn`: 28 `TimePicker` per riga non sono leggibili in
  tabella (il form ne ha uno per giorno/fascia). Estende `TextColumn` con un
  riepilogo testuale per giorno (`Lun 09:00-13:00, 14:00-18:00 · Mar chiuso · ...`),
  logica esposta come metodo pubblico statico `summarizeOpeningHours()` per essere testabile
  senza reflection sugli interni di Filament — vedi "Parita' non significa clone",
  punto 3, in Ptv/form-column-parity.md: la variabilita' si sposta nello stato della
  cella, non nello schema.

Test: `tests/Feature/AddressColumnTest.php`, `tests/Feature/OpeningHoursColumnTest.php`.
- **`PersonColumn`** (`app/Filament/Tables/Columns/PersonColumn.php`) — estende
  `GroupColumn` come `UserColumn` in User: un `TextColumn` per campo, nome diretto
  (`first_name`, non `person.first_name`) perche' la persona e' il record stesso, non
  un correlato — a differenza di `AddressColumn`. Campi di default:
  `first_name`, `last_name`, `email`, `mobile_phone`, `language`, mappati (solo a
  scopo documentale) su `https://schema.org/Person` (`givenName`, `familyName`,
  `email`, `telephone`, `knowsLanguage`). `fields()` per restringere l'elenco.
  Gemello form: `PersonSection`.

- **`SortableIdColumn`**/**`TimestampColumn`** (`app/Filament/Tables/Columns/{SortableIdColumn,TimestampColumn}.php`)
  — nessun gemello form (non e' un fatto di dominio, e' una convenzione di
  progetto ripetuta identica): trovato lo stesso trio letterale
  (`sortable()->copyable()->toggleable(...)` per `id`;
  `dateTime()->sortable()->placeholder('—')` per `created_at`/`updated_at`)
  in 30+ classi `Tables/*.php` (soprattutto `Modules/User`), durante il
  lavoro su `Modules/<nome progetto>/ContactResource/Tables/ContactsTable.php`.
  `toggleable()` resta componibile dal chiamante (non fissato dentro
  `TimestampColumn`: `created_at`/`updated_at` differiscono su questo punto
  nel codice esistente). Migrazione dei 30+ consumer non ancora fatta, solo
  il componente e' stato creato — vedi
  `Modules/UI/docs/stories/id-timestamp-columns-extraction.story.md`.

Test: `tests/Feature/AddressColumnTest.php`, `tests/Feature/OpeningHoursColumnTest.php`,
`tests/Feature/PersonColumnTest.php`, `tests/Feature/SortableIdColumnTest.php`,
`tests/Feature/TimestampColumnTest.php`.
