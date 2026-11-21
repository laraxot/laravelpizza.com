---
qmd: "ui stories id timestamp columns extraction story md"
title: "UI: SortableIdColumn/TimestampColumn — estratto il trio id/created_at/updated_at ripetuto in 30+ Tables/*.php"
type: story
module: UI
epic: null
story_id: null
slug: id-timestamp-columns-extraction
status: done
cold_gate: passed
created: 2026-09-11
updated: 2026-09-11
repository: "https://github.com/laraxot/module_ui_fila5"
github_issue: "https://github.com/laraxot/module_ui_fila5/issues/31"
github_discussion: "https://github.com/laraxot/module_ui_fila5/discussions/32"
estimated_effort: "1-2h"
blocked_by: []
blocks: []
supersedes: []
owned_scope:
  - laravel/Modules/UI/app/Filament/Tables/Columns/SortableIdColumn.php
  - laravel/Modules/UI/app/Filament/Tables/Columns/TimestampColumn.php
  - laravel/Modules/UI/tests/Feature/SortableIdColumnTest.php
  - laravel/Modules/UI/tests/Feature/TimestampColumnTest.php
  - laravel/Modules/UI/docs/form-column-parity.md
related:
  - Modules/UI/app/Filament/Tables/Columns/PersonColumn.php
  - Modules/UI/app/Filament/Tables/Columns/OpeningHoursColumn.php
  - Modules/Xot/docs/stories/_TEMPLATE.story.md
---

# Story: SortableIdColumn / TimestampColumn

## Story

Come owner UI, voglio estrarre in un componente riutilizzabile il trio di
colonne `id`/`created_at`/`updated_at` ripetuto identico in decine di
classi `Tables/*.php`, cosi' che i nuovi `Table` del progetto smettano di
ricopiare la stessa configurazione e un'eventuale correzione futura
(es. cambiare il placeholder dei valori nulli) si faccia in un solo posto.

## Baseline

`grep -rl "TextColumn::make('id')->sortable()->copyable()->toggleable" Modules --include="*.php"`
→ **32 file**. `grep -rl "TextColumn::make('created_at')->dateTime()->sortable()->placeholder" Modules --include="*.php"`
→ **~30 file**. Concentrati soprattutto in `Modules/User`
(`RolesTable`, `PermissionsTable`, `TenantsTable`, tutte le `Oauth*Table`,
`SocialProvidersTable`, `SsoProvidersTable`, ...).

Trigger: feedback dell'utente durante la review di una proposta di codice
per `XotBaseManageRelatedRecords.php` — promemoria di uno standing
principle gia' applicato per `PersonColumn`/`AddressColumn`
(`Modules/UI/docs/form-column-parity.md`): riconoscere pezzi ripetitivi
nei `Tables/*.php` e creare il componente nel modulo corretto invece di
lasciare la duplicazione.

## Acceptance Criteria

<!-- LOCKED. External dev tools must not edit Acceptance Criteria. -->

1. Il componente segue il pattern gia' in uso nel modulo
   (`OpeningHoursColumn extends TextColumn`), non un design nuovo.
2. Nessun campo/colonna inventato: la configurazione applicata
   (`sortable()->copyable()->toggleable(...)` per `SortableIdColumn`;
   `dateTime()->sortable()->placeholder('—')` per `TimestampColumn`)
   corrisponde esattamente a quella gia' ripetuta nei file censiti.
3. `TimestampColumn` non fissa `toggleable()`: `created_at` e `updated_at`
   differiscono su questo punto nel codice esistente, resta componibile
   dal chiamante.
4. Test Pest verde per entrambi i componenti.
5. PHPStan pulito sui file nuovi.
6. Migrazione dei 30+ consumer esistenti esplicitamente FUORI scope di
   questa story (dichiarato, non un'omissione).

## Tasks / Subtasks

<!-- LOCKED. External dev tools must not edit Tasks / Subtasks. -->

- [x] Quantificare la duplicazione con `grep`, non a occhio. (AC: #2)
- [x] Creare `SortableIdColumn` seguendo il pattern `OpeningHoursColumn`. (AC: #1, #2)
- [x] Creare `TimestampColumn`, senza fissare `toggleable()`. (AC: #1, #3)
- [x] Scrivere `SortableIdColumnTest.php` + `TimestampColumnTest.php`. (AC: #4)
- [x] Eseguire Pest e PHPStan sui file nuovi. (AC: #4, #5)
- [x] Aggiornare `Modules/UI/docs/form-column-parity.md`.
- [ ] Migrare i 30+ consumer — dichiarato fuori scope (AC: #6), non eseguito.

## Dev Notes

<!-- LOCKED. External dev tools must not edit Dev Notes. -->

- [Source: Modules/UI/docs/form-column-parity.md] Discriminante gia' in uso
  nel modulo per decidere se un componente merita un gemello form: "fatto
  di dominio con piu' campi → gemello; convenzione di stile ripetuta →
  nessun gemello". Il trio `id`/`created_at`/`updated_at` e' una
  convenzione di progetto, non un fatto di dominio: nessun gemello form
  creato, a differenza di `PersonColumn`/`PersonSection`.
- [Source: Filament\Tables\Columns\Column::make()] `make(?string $name = null): static`
  gia' accetta `null` a monte — `SortableIdColumn::make()` sfrutta questo per un
  nome di default (`'id'`), `TimestampColumn::make($name)` richiede il
  nome esplicito (nessun default universale sensato tra `created_at`/
  `updated_at`/altri campi data).
- [Inference] `TextColumn::isCopyable(mixed $state)` richiede lo stato
  come argomento (valuta una eventuale closure condizionale) — il test
  passa un valore campione (`1`), non chiama il metodo a vuoto.

## Testing

<!-- LOCKED. External dev tools must not edit Testing. -->

```
cd laravel
php -l Modules/UI/app/Filament/Tables/Columns/SortableIdColumn.php
php -l Modules/UI/app/Filament/Tables/Columns/TimestampColumn.php
./vendor/bin/pest Modules/UI/tests/Feature/SortableIdColumnTest.php Modules/UI/tests/Feature/TimestampColumnTest.php --no-coverage
# 6 passed (11 assertions)
./vendor/bin/phpstan analyse Modules/UI/app/Filament/Tables/Columns/SortableIdColumn.php Modules/UI/app/Filament/Tables/Columns/TimestampColumn.php --no-progress --memory-limit=-1
# [OK] No errors
```

## Dependency Maps

Nessuna dipendenza da altre story UI. Indipendente e non bloccante per la
migrazione dei consumer, se decisa in una story separata.

## Owned File/Module Scope

Solo i file dichiarati in `owned_scope`. Nessun file `Modules/User/**`
toccato (i 30+ consumer censiti restano invariati).

## Learnings from Previous Stories

- [Source: Modules/UI/docs/form-column-parity.md, voce PersonColumn]
  Stesso principio gia' applicato: componente creato solo dopo aver
  quantificato la duplicazione con grep, non a sensazione.
- [Source: memoria feedback-no-resolve-prefix-check-sibling-naming]
  Prima di nominare un metodo/componente nuovo, controllare il vocabolario
  gia' in uso nei file gemelli diretti — applicato qui verificando che
  `SortableIdColumn`/`TimestampColumn` seguano lo stesso stile di
  `OpeningHoursColumn`, non un pattern nuovo.

## Dev Agent Record

### Agent Model Used

Claude Sonnet 5

### Implementazione

- `Modules/UI/app/Filament/Tables/Columns/SortableIdColumn.php` (nuovo).
- `Modules/UI/app/Filament/Tables/Columns/TimestampColumn.php` (nuovo).
- `Modules/UI/tests/Feature/SortableIdColumnTest.php` + `TimestampColumnTest.php` (nuovi).
- `Modules/UI/docs/form-column-parity.md` (aggiornato).

### Evidenze

- Pest: 6 passed, 11 assertions.
- PHPStan repo-wide (non solo sui 2 file nuovi): **0 errori**, confermato
  dopo che una sessione peer ha rinominato `IdColumn` → `SortableIdColumn`
  per risolvere una collisione di case (`IdColumn.php` vs un file
  preesistente non correlato `IDColumn.php`, componente diverso — anchor
  di riga per deep-link — che PHPStan segnalava come `class.nameCase`).
  Verificato che i due componenti sono davvero funzionalita' distinte
  prima di accettare la rinomina, non solo lo stesso nome duplicato.

### Disposizione

Story chiusa per lo scope dichiarato (creazione + test dei 2 componenti).
Migrazione dei 30+ consumer esistenti lasciata intenzionalmente fuori
scope — candidato per una story di modulo a parte (`Modules/User`) se si
decide di procedere.
