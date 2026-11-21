---
title: "Story: PersonColumn — aggregato riutilizzabile anagrafica + contatto"
qmd: "ui stories person column schema org aggregate story md"
type: note
tags: [documentation]
---

# Story: PersonColumn — aggregato riutilizzabile anagrafica + contatto

## Contesto (BMAD: dev)

Durante il fix di `Modules/<nome progetto>/app/Filament/Resources/ContactResource/Tables/ContactsTable.php`
(colonne del model `Contact` recuperate via git archaeology dal commit `ee9731ee1`,
vedi [[xotbaseresourcetable-orphaned-columns-git-archaeology]]), l'utente ha chiesto
di non limitarsi a elencare `first_name`, `last_name`, `mobile_phone`, `email`,
`language` come colonne separate, ma di aggregarle in un componente riutilizzabile
dentro `Modules/UI`, sul modello di `AddressColumn`, con riferimento al vocabolario
`https://schema.org/Person`.

## Decisione

Creato `PersonColumn` (`Modules/UI/app/Filament/Tables/Columns/PersonColumn.php`),
gemello di `PersonSection` (`Modules/UI/app/Filament/Forms/Components/PersonSection.php`),
seguendo la regola di parita' Forms/Components <-> Tables/Columns gia' in vigore
(`Modules/UI/docs/form-column-parity.md`, SSoT in `Ptv/docs/form-column-parity.md`).

Differenza rispetto ad `AddressColumn`: quest'ultimo mostra campi di una *relazione*
(dot-notation `address.city`); `PersonColumn` mostra campi diretti del record
(`first_name`, non `person.first_name`), perche' la persona e' il record stesso —
stesso principio gia' usato da `Modules\User\Filament\Tables\Columns\UserColumn`
(`first_name`, `last_name`, `email` diretti + `->searchable()` aggregato sul
GroupColumn).

Mappatura documentale (non rinomina i campi reali — vedi
`Modules/Xot/docs/consolidated/archive/personal-name-fields.md`, mai `name`/`surname`)
verso `schema.org/Person`:

| Campo progetto | schema.org/Person |
|-----------------|--------------------|
| `first_name`    | `givenName`        |
| `last_name`     | `familyName`       |
| `email`         | `email`            |
| `mobile_phone`  | `telephone`        |
| `language`      | `knowsLanguage`    |

## Uso in ContactsTable

`ContactsTable::getTableColumns()` usa `PersonColumn::make()->fields(['first_name', 'last_name'])`
soltanto per nome/cognome. Email, telefono e lingua **non** sono stati aggregati li'
dentro perche' `ContactsTable` ha gia' `email_cell`/`sms_cell`/`info_cell` (accessor
reali sul model, verificati: `Contact::getEmailCellAttribute()`,
`getSmsCellAttribute()`, `getInfoCellAttribute()`) che portano piu' informazione
(sent_at, count) di quanta ne porterebbe `PersonColumn` da sola — usarlo anche li
avrebbe duplicato lo stesso dato due volte in tabella.

`PersonColumn` resta disponibile con il set completo di default (5 campi) per
qualunque altra Resource che non abbia gia' celle piu' ricche.

## Verifica

- PHPStan livello 10, repo-wide: 0 errori.
- `vendor/bin/pest Modules/UI/tests/Feature/PersonColumnTest.php --no-coverage`: 4/4 verdi.
- `php -l` su tutti i file toccati: nessun errore di sintassi.

## Nota di contesto

Durante questa sessione un'altra sessione Claude Code stava lavorando in parallelo
sullo stesso repo sullo stesso task (bonifica `getTableColumns()` su tutte le classi
`XotBaseResourceTable`, 100 file): ha gia' importato `PersonColumn` dentro
`ContactsTable.php` prima che questa storia fosse chiusa, inizialmente con tutti e 5
i campi (email/telefono/lingua duplicati rispetto alle celle ricche) — corretto qui
a `['first_name', 'last_name']`.
