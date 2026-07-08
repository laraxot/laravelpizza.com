# PHPStan zero — sessione 2026-07-08

## Contesto

Gate sessione (`start.txt`) ha segnalato **33 errori** su `phpstan analyse Modules`. Obiettivo: zero errori forward-only, senza toccare `phpstan.neon`.

## Errori e fix

| File / area | Errore | Fix |
|-------------|--------|-----|
| 11 migration Meetup | `method.notFound` su `timestamps()` | `updateTimestamps($table)` — `timestamps()` non esiste su `XotBaseMigration` |
| `Event.php` | `class.duplicateMethod` `scopeVisibleTo` | Un solo scope: super-admin vede tutto; published pubblici; draft/pending solo owner |
| `Event.php` | `return.type` su `creator`/`updater` | Rimossi override; resta trait `Updater` da `XotBaseModel` |
| `Performer.php` | `return.type` su `events()` | PHPDoc `BelongsToMany<Event, $this, EventPerformer, 'pivot'>` + `->using(EventPerformer::class)` |
| `User/Auth/AuthLogout.php` | `argument.type` view-string | `/** @var view-string $viewName */` (allineato a `Login.php`) |
| `Geo/check_types.php` | 16 errori script debug root | File eliminato (one-off, path errati, vietato in root modulo) |
| `Meetup/resources/views/debug_blade.php` | 8 errori script debug in `views/` | File eliminato (scanner Blade one-off, non è una view) |
| `laravel/phpstan_constants.php` | bootstrap mancante / `LARAVEL_DIR` duplicato | Creato con `if (! defined('LARAVEL_DIR'))` — richiesto da `phpstan.neon` |

## Regola migration (riuso)

- Tabelle standard: `$this->updateTimestamps($table)` in `tableCreate()`.
- Pivot con `user_id` di dominio (`event_user`): definire `user_id` manualmente, poi `updateTimestamps()` — **non** `timestamps()` (rimosso dal framework).
- Soft delete: `updateTimestamps($table, hasSoftDeletes: true)`.

Vedi anche [migrate-testing-error-analysis.md](./migrate-testing-error-analysis.md).

## Verifica

```bash
cd laravel && php -d memory_limit=2048M ./vendor/bin/phpstan analyse Modules
# [OK] No errors (3965 file, 2026-07-08)
```

## Wave 2026-07-08 — 36 errori aggiuntivi

Dopo il primo zero, nuove segnalazioni (trait.unused, generics, iterable, env in config):

| Categoria | Fix |
|-----------|-----|
| trait.unused (11) | Wiring trait → modello host; `HasUuid` Xot **non** ripristinare (resta `HasUuid.php.old`) |
| missingType.generics | `Event` BelongsTo/BelongsToMany PHPDoc; `HasXotFactory<EventFactory>`; `FeedbackFactory @extends` |
| missingType.iterableValue | `array<string, mixed>` su Action/Filament; `meta_data` su Performer/Venue |
| larastan.noEnvCallsOutsideOfConfig | `Env::get()` in Geo config |
| HasCoordinatePicker | Eliminato (deprecato, vuoto) |

## Collegamenti

- [phpstan-journey.md](../../../../docs/wiki/second-brain/phpstan-journey.md) — pattern 15–19
- [phpstan-wave-2026-03-10.md](./phpstan-wave-2026-03-10.md) — wave precedente Meetup
