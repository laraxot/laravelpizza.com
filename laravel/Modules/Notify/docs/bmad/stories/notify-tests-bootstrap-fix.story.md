---
id: notify-tests-bootstrap-fix
title: Fix bootstrap Pest nel modulo Notify (134 test senza TestCase)
type: bugfix
priority: high
status: review
module: Notify
created: 2026-11-05
updated: 2026-11-05
owner: devin
tags: [tests, pest, bootstrap, schema-drift]
qmd: "story: notify module pest.php pest extend dead uses TestCase 134 test files"
---

# Story: Fix bootstrap Pest nel modulo Notify

## Context

`Modules/Notify/tests/Pest.php` dichiarava `pest()->extend(TestCase::class)->in(...)`,
ma i `Pest.php` di modulo **non vengono mai caricati** (v. memoria
`module-pest-php-never-loaded`): `BootFiles` legge un solo `Pest.php`, quello root.
Risultato: **nessuno** dei 134 `*Test.php` di Notify dichiarava `uses()` e tutti
giravano su `PHPUnit\Framework\TestCase` nudo → fallimento al primo uso del container
(DB resolver `null`).

## Lavoro svolto

- `uses(\Modules\Notify\Tests\TestCase::class);` aggiunto dopo il blocco `use` in
  tutti i 134 file `*Test.php` (script PHP, verificato `php -l` + PHPStan).
- `Pest.php` riscritto come stub documentale (regole del modulo, zero codice morto),
  stesso pattern di `IndennitaCondizioniLavoro`.
- Stesso trattamento a `Job/tests/Pest.php` (4 funzioni morte) e
  `User/tests/Pest.php` (`expect()->extend` morti: `toBeUser`, `toBeTeam`,
  `toBeProfile` — zero usage verificato con grep).
- Migrazioni pendenti applicate su `ptv_lara_test` (additive, host .53):
  `module:migrate Notify|Media|Job --env=testing`.

## Esito gate

- `phpstan analyse Modules/Notify Modules/Job` → **0 errori**.
- Pest `ContactManagementBusinessLogicTest` + `NotifyModelsTest`:
  **8 passed / 2 failed** (prima: 0 eseguibili — errore `DB::connection()` su tutti).

## Debito residuo (bug reali da fixare in story dedicata)

1. **`notification_logs` schema drift**: tabella reale ha `channels`, `title`,
   `content`, `error`; modello/factory usano `channel`, `status_message`.
   Le 3 migrazioni `create_notification_logs_table` (2025_03, 2025_07, 2026_09)
   sono state skippate da guard `hasTable` → serve migrazione di allineamento
   (decisione dominio: quale schema è canonico?).
2. **`notifications.notifiable_id` bigint su connessione `xot`**: la migration
   `2026_06_10_134000` di Notify ha applicato `uuid`/`string(36)` sulla connessione
   `user`, ma `Modules\Notify\Models\Notification` risolve `xot` → insert uuid
   in colonna bigint fallisce. Serve migrazione `->change()` sulla connessione
   corretta o riallineamento del modello.
3. **`temporary_uploads.id` (Media)**: tabella Livewire ha PK stringa uuid,
   `TemporaryUpload extends BaseModel` assume int auto-increment.
   v. `Modules/Media/docs/bmad/stories/media-tests-bootstrap-dedupe.story.md`.
4. **Performance**: `IndividualeFormSchemaTest` chiama `BaseSchedaForm::getFormSchema()`
   statico ma il metodo non è static; tabelle `qua00f` assenti su `generale`.

## Acceptance Criteria

- [x] Tutti i test Notify dichiarano `uses(TestCase::class)`
- [x] Pest.php moduli senza codice morto
- [x] PHPStan 0 errori sui moduli toccati
- [ ] Schema drift notification_logs/notifications/temporary_uploads risolto
- [ ] Suite Notify completa verde
