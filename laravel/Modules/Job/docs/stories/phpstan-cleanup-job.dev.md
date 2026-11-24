---
title: "[DEV] PHPStan cleanup — Job"
type: dev
module: Job
story: "./2026-10-06-phpstan-cleanup-job.story.md"
status: done
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, cleanup, bmad, job]
---

# [DEV] PHPStan cleanup — Job

## Technical Plan

- Valutato il riuso di `Status`: e' gia' il cast del model, le costanti intere sono residuo
- Non toccare i dati: nessuna migration, nessuna scrittura; solo la lettura (scope) viene allineata al cast

## Files to Modify

- `app/Enums/Status.php` (`isActive()`, `activeCases()`)
- `app/Models/Schedule.php` (costanti rimosse, scope)
- `app/Actions/Schedule/GetActiveSchedulesAction.php` (usa `->active()`)
- `app/Models/Policies/JobBasePolicy.php`
- `app/Filament/Columns/ActionGroup.php`, `app/Filament/Tables/Columns/ActionGroup.php` (duplicati: `public const string ICON_BUTTON_VIEW`, entrambi corretti, nessuno cancellato)
- `app/Models/JobBatch.php` (`public const ?string UPDATED_AT = null`)
- `tests/Unit/Providers/JobProvidersCoverageTest.php`, `tests/Unit/JobScheduleFormCoverageTest.php`, `tests/Fixtures/StubGetCommandsAction.php` (nuovo)

## Implementation Steps

- [x] Mappati i consumatori delle costanti (solo `Schedule` e `Schedule/GetActiveSchedulesAction`)
- [x] Aggiunti `activeCases()`/`isActive()` all'enum; sostituito l'uso delle costanti
- [x] Rimossa la variabile `$xotData` inutilizzata (storia git: aggiunta meccanicamente, mai letta)
- [x] Test provider: usata l'istanza; test form: fixture con nome
- [x] Tipizzate le costanti non segnalate ma ancora con `@var` (ActionGroup x2, JobBatch)
- [x] PHPStan + `php -l`

## Testing

Test eseguiti: nessuno (Pest non lanciato: `.env.testing` punta a MySQL, sqlite in-memory non garantito). `ScheduleBusinessLogicTest::_can_scope_active_and_inactive_schedules` copre gia' gli scope con `Status::Active`/`Status::Inactive` (prima, sul filtro `status = 1`/`0`, un record creato con `Status::Active` non poteva essere trovato dallo scope).

## Verification

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Tenant Modules/Activity Modules/Media Modules/AI Modules/UI Modules/Job Modules/Gdpr Modules/TechPlanner Modules/Seo --memory-limit=-1 --no-progress
php -l <file toccati>

```

Esito: 0 errori sui 9 moduli del gruppo (anche con run completo `./vendor/bin/phpstan analyse` senza argomenti).

## Lessons Learned

- Quando esiste gia' un enum per il dominio, le costanti vecchie vanno eliminate **e** le query allineate: il cast e il `where` su costanti intere erano due verita' diverse.
- Le colonne con default booleano legacy (`'1'`) vanno modellate nell'enum (`One`), non nascoste: `activeCases()` rende esplicita l'equivalenza.
- Una variabile 'mai letta' puo' essere un residuo meccanico (qui `XotData::make()`): confermarlo con `git log -p` prima di eliminarla.
- Duplicati lasciati intatti: `Actions/GetActiveSchedulesAction.php` e `Actions/Schedule/GetActiveSchedulesAction.php`; i due `ActionGroup`.
- Da decidere (utente): la colonna `status` e' `boolean` nella migration `create_schedule_table` ma il cast e' un enum a stringa (`active/inactive/trashed`); su MySQL strict la scrittura di `'active'` fallirebbe. Inoltre un eventuale `0` legacy non ha un case (`Status::from('0')` solleva `ValueError`): valutare un case `Zero` o una migrazione dei dati.
- PHPStan non risolve i docblock delle classi anonime in modo stabile: il cache dei name-scope e' indicizzato per file ma il nome della classe anonima contiene un percorso relativo alla radice dell'esecuzione (file singolo, sottoinsieme di moduli, run completo). Esecuzioni con radici diverse lasciano voci inconsistenti e compaiono falsi `missingType.iterableValue`/`missingType.generics` anche con docblock corretti. Fix deterministico: classi **con nome** in `tests/Fixtures/` (convenzione gia' usata nei moduli).
