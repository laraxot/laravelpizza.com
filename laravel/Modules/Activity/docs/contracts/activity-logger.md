---
title: "Contratto — ActivityLogger"
type: contract
owner: Activity
status: accepted
updated: 2026-11-24
action: "Modules\\Activity\\Actions\\ActivityLogger"
qmd: "contract ActivityLogger activity scrittura log login logout modello custom cleanOld statistiche ACT-LOGGER"
---

# ActivityLogger

Facciata di scrittura e lettura del log attività: registra eventi generici e del modello e offre le query e la pulizia. La facciata pubblica è `Adapters/ActivityLogger` (`app/Adapters/ActivityLogger.php`), che delega qui.

## Input

- `log(string $type, mixed $user, ?Model $subject, ?array $properties, ?string $description)`: `$user` deve essere `UserContract` o `null`.
- `created|updated|deleted(Model $model, ?UserContract $user)`.
- `login|logout(UserContract $user)`.
- `custom(string $type, string $description, ?Model $subject, ?array $properties)`.
- `getUserActivities(UserContract, int $limit=50)`, `getModelActivities(Model, int $limit=50)`, `getByType(string, int $limit=50)`, `getRecent(int $limit=50)`.
- `cleanOld(int $days=90)`, `getStatistics(?UserContract)`.

## Output

- Eventi: `Activity` (creata). Query: `Collection<int, Activity>`. `cleanOld`: `int` (righe cancellate). `getStatistics`: array come `GetActivityStatisticsAction`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-LOGGER-INV-1` | In `log()`, un `$user` non null che non è `UserContract` lancia `InvalidArgumentException('User must implement UserContract')`. | `CoverageHundredActionsTest.php` (~riga 250) |
| `ACT-LOGGER-INV-2` | `created()` produce un'attività con `event = 'created'`. | `CoverageHundredActionsTest.php` (~riga 177), `ActivityLoggerTest.php` |
| `ACT-LOGGER-INV-3` | `cleanOld($days)` con `$days <= 0` lancia `InvalidArgumentException('Days must be positive')` prima di toccare il database. | Test: nessuno |
| `ACT-LOGGER-INV-4` | `cleanOld()` cancella con una singola `DELETE` (non a blocchi) e restituisce il numero di righe. | `ActivityLoggerTest.php` (~riga 174) |
| `ACT-LOGGER-INV-5` | `getStatistics()` calcola senza cache, a differenza di `GetActivityStatisticsAction`. | `ActivityLoggerTest.php` (~righe 179, 190) |
| `ACT-LOGGER-INV-6` | `getUserActivities`, `getByType`, `getRecent` rifiutano `limit <= 0`; `getModelActivities` non lo fa. | Test: nessuno diretto |

## Effetti collaterali

- `log()`: `INSERT` in `activity_log` con `log_name = 'default'`, poi `Log::debug('Activity logged', ...)`. Il `causer_id` ricade su `Auth::id()` se non c'è utente, ma `causer_type` resta `null` (vedi `log-activity-action.md`).
- `created|updated|deleted`: delegano a `LogModelCreatedAction` / `LogModelUpdatedAction` / `LogModelDeletedAction`, quindi a `LogActivityAction`.
- `login|logout`: delegano a `LogUserLoginAction` / `LogUserLogoutAction`.
- `cleanOld()`: `DELETE` diretto, poi `Log::debug('Old activities cleaned', ...)`. Nessuna transazione, nessuna chunk.
- Nessun evento dispatchato dall'Action; gli eventi Eloquent di `Activity::create` restano quelli del modello.

## Errori

- `InvalidArgumentException`: utente non `UserContract` (`log`), `days <= 0` (`cleanOld`), limite non positivo nelle query che lo validano.
- Errori di database si propagano.

## Non fa

- Non redige gli attributi sensibili: `RedactModelAttributesAction` non è usata (vedi `redact-model-attributes-action.md`).
- Non valida il soggetto.
- Non è la stessa logica di `ActivityMaintenanceAction` (che cancella a blocchi) né di `GetActivityStatisticsAction` (che usa la cache): `cleanOld()` e `getStatistics()` sono duplicati divergenti.
- Anomalia: `causer_id` da `Auth::id()` senza `causer_type` (vedi `log-activity-action.md`).

