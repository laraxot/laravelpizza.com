---
qmd: "ui stories person column schema org identity group story md"
id: story-ui-person-column-schema-org-identity-group
slug: person-column-schema-org-identity-group
title: "STORY — PersonColumn: componente riutilizzabile per l'identita' di una persona (schema.org/Person)"
description: "Nuovo GroupColumn per aggregare first_name/last_name/email/mobile_phone/language in una cella, sul modello di AddressColumn; applicato a <nome progetto> ContactsTable al posto delle colonne first_name/last_name separate."
document_type: story
category: bmad
scope: module:UI
status: done
version: 1.0.0
language: it-IT
ecosystem: Laraxot
priority: medium
created_at: '2026-09-10'
updated_at: '2026-09-10'
tags: [bmad, story, ui, filament, tables, group-column, schema-org, <nome progetto>]
related:
  - ../../app/Filament/Tables/Columns/PersonColumn.php
  - ../../app/Filament/Tables/Columns/GroupColumn.php
  - ../../app/Filament/Tables/Columns/AddressColumn.php
  - ../form-column-parity.md
  - ../../../<nome progetto>/app/Filament/Resources/ContactResource/Tables/ContactsTable.php
  - ../../../<nome progetto>/app/Models/Contact.php
github:
  repository: https://github.com/laraxot/module_ui_fila5
  issues: https://github.com/laraxot/module_ui_fila5/issues
---

# STORY — PersonColumn

## Contesto (BMAD — Ricognizione)

Richiesta utente: le colonne `first_name`, `last_name`, `mobile_phone`,
`email`, `language` su `<nome progetto>\Contact` sono informazioni imparentate
(identita' di una persona) e andavano aggregate in un componente
riutilizzabile in `Modules/UI`, sul modello di
`Modules/UI/app/Filament/Tables/Columns/AddressColumn.php`, usando
schema.org come riferimento per decidere quali campi appartengono insieme.

`Modules/UI/docs/form-column-parity.md` da' il discriminante gia' in uso nel
modulo per decidere se un raggruppamento del genere merita un componente
dedicato: "raccoglie piu' campi del model / e' un fatto di dominio →
gemello; e' un modo di inserire un valore → nessun gemello". Identita' di
una persona (nome, cognome, contatti) e' un fatto di dominio pubblicato
come tale da schema.org/Person (https://schema.org/Person:
`givenName`/`familyName`/`email`/`telephone`) — criterio soddisfatto.

## Analisi

`AddressColumn` (unico precedente concreto nel modulo) assume campi sotto
una **relazione** (`{relazione}.{campo}`, es. `address.city`), perche'
l'indirizzo e' quasi sempre un value object collegato. L'identita' di una
persona, quando il record stesso *e'* la persona (es. `Contact`), vive
invece come **attributi diretti** del record — nessun prefisso di
relazione. `PersonColumn` copia il pattern (`extends GroupColumn`,
`make()`/`fields()`/`getSchema()`) ma con `TextColumn::make($field)` sul
nome reale della colonna, non `"{$name}.{$field}"`.

Campi verificati uno per uno contro
`Modules\<nome progetto>\Models\Contact` (docblock `@property` + migration
`2024_01_01_000002_create_contacts_table.php`): `first_name`, `last_name`,
`email`, `mobile_phone`, `language` sono tutte colonne reali. Nessun campo
inventato.

## Fix applicato

Sviluppato in parallelo da questa sessione e da una sessione peer sullo
stesso repo (vedi nota "lavoro concorrente" in fondo); la versione finale
in working tree e' quella peer, piu' completa — verificata e non
riscritta da questa sessione.

1. `Modules/UI/app/Filament/Tables/Columns/PersonColumn.php` (nuovo) —
   `extends GroupColumn`, campi diretti sul record (nessuna
   dot-notation di relazione, a differenza di `AddressColumn`: la persona
   e' il record stesso). Default field set `['first_name', 'last_name',
   'email', 'mobile_phone', 'language']`. Docblock con tabella di mappatura
   verso schema.org/Person (`givenName`/`familyName`/`email`/`telephone`/
   `knowsLanguage`) a scopo solo documentale — i nomi restano quelli reali
   del progetto, mai `name`/`surname` (vedi
   `Modules/Xot/docs/consolidated/archive/personal-name-fields.md`,
   verificato: convenzione confermata). `make()`/`fields()` chiamano anche
   `->searchable($fields)` sulla colonna stessa (non solo sui figli): rende
   il gruppo cercabile nella ricerca globale della tabella sui campi reali
   sottostanti — i `TextColumn` figli non sono mai registrati sulla
   `Table`, quindi un `->searchable()` messo solo su di loro sarebbe inerte.
2. `Modules/UI/app/Filament/Forms/Components/PersonSection.php` (nuovo,
   non richiesto esplicitamente ma coerente con
   `Modules/UI/docs/form-column-parity.md`: un fatto di dominio con piu'
   campi del model merita il gemello form) — `TextInput` per gli stessi 5
   campi, controparte di `PersonColumn`.
3. `Modules/UI/tests/Feature/PersonColumnTest.php` (nuovo) — stesso schema
   di `AddressColumnTest.php`: instanziazione, nome custom, field set di
   default (5 `TextColumn`), naming senza prefisso di relazione,
   `fields()` per restringere l'elenco. 4 test, 10 assertion, verde.
4. `Modules/<nome progetto>/app/Filament/Resources/ContactResource/Tables/ContactsTable.php`
   — colonne separate `'first_name'` e `'last_name'` sostituite da
   `'person' => PersonColumn::make()->fields(['first_name', 'last_name'])`
   (solo nome: email/telefono/lingua **non** duplicati qui perche' le celle
   `email_cell`/`sms_cell`/`info_cell` — stato invio: sent_at/count,
   recuperate in una story precedente da codice orfano — li mostrano gia'
   con contesto aggiuntivo; scopo diverso, tracciamento invio non identita').

## Acceptance criteria

- [x] AC1 — `PersonColumn` estende `GroupColumn`, stesso pattern
      `make()`/`fields()`/`getSchema()` di `AddressColumn`.
- [x] AC2 — Ogni campo di default verificato contro `Contact.php` (property
      reale + colonna in migration): nessun campo inventato. Convenzione
      `first_name`/`last_name` (mai `name`/`surname`) confermata contro
      `Modules/Xot/docs/consolidated/archive/personal-name-fields.md`.
- [x] AC3 — Test Pest verde: `./vendor/bin/pest
      Modules/UI/tests/Feature/PersonColumnTest.php --no-coverage` → 4
      passed (10 assertions).
- [x] AC4 — Verifica live: replay HTTP autenticato su
      `/<nome progetto>/admin/gaia/survey-pdfs/5/contacts` → 200, nessun errore
      nuovo in `storage/logs/laravel.log`, ripetuto dopo la convergenza
      con la sessione peer.
- [x] AC5 — `php -l` verde su tutti i file toccati (`PersonColumn.php`,
      `PersonSection.php`, `PersonColumnTest.php`, `ContactsTable.php`).

## Owned file/module scope

- `Modules/UI/app/Filament/Tables/Columns/PersonColumn.php` (nuovo)
- `Modules/UI/app/Filament/Forms/Components/PersonSection.php` (nuovo, da sessione peer)
- `Modules/UI/tests/Feature/PersonColumnTest.php` (nuovo)
- `Modules/<nome progetto>/app/Filament/Resources/ContactResource/Tables/ContactsTable.php`
  (colonna `person` al posto di `first_name`/`last_name` separati)

## Testing

```
cd laravel
php -l Modules/UI/app/Filament/Tables/Columns/PersonColumn.php
php -l Modules/UI/app/Filament/Forms/Components/PersonSection.php
php -l Modules/<nome progetto>/app/Filament/Resources/ContactResource/Tables/ContactsTable.php
./vendor/bin/pest Modules/UI/tests/Feature/PersonColumnTest.php --no-coverage
# 4 passed (10 assertions)
```

## Nota — lavoro concorrente sullo stesso repo

Questa sessione ha scritto una prima versione di `PersonColumn.php` +
`PersonColumnTest.php` + l'uso in `ContactsTable.php` (5 campi tutti
insieme, `->label($field)` sui figli, nessun `PersonSection`). Mentre
scriveva la story, una sessione peer ha sovrascritto entrambi i file con
una versione piu' completa: `->searchable($fields)` sulla colonna stessa
(necessario perche' i `TextColumn` figli di un `GroupColumn` non sono mai
registrati sulla `Table` — un `searchable()` messo solo su di loro e'
inerte), il gemello form `PersonSection.php` (giustificato da
`form-column-parity.md`), e in `ContactsTable.php` solo
`first_name`/`last_name` per evitare di duplicare email/telefono/lingua
gia' presenti nelle celle `email_cell`/`sms_cell`/`info_cell`. Questa
sessione ha verificato la versione finale (lint, test, replay live) invece
di sovrascriverla di nuovo — vedi [[multi-agent-same-repo-race]].

## Dev Agent Record

### Agent Model Used

Claude Sonnet 5

### File List

- `laravel/Modules/UI/app/Filament/Tables/Columns/PersonColumn.php` (nuovo — versione finale da sessione peer, verificata qui)
- `laravel/Modules/UI/app/Filament/Forms/Components/PersonSection.php` (nuovo, da sessione peer, verificato qui)
- `laravel/Modules/UI/tests/Feature/PersonColumnTest.php` (nuovo — versione finale da sessione peer, verificata qui)
- `laravel/Modules/<nome progetto>/app/Filament/Resources/ContactResource/Tables/ContactsTable.php` (modificato, rifinito da sessione peer)
