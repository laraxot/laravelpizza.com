---
title: "SettingPage di Activity: le chiavi di spatie/laravel-activitylog che contano"
status: in-progress
module: Activity
type: story
qmd: "Activity SettingPage activitylog clean_after_days enabled default_log_name include_soft_deleted_subjects ApplyActivityConfigAction"
related:
  - ../../../../Xot/docs/bmad/stories/setting-page-campi-reali.story.md
  - ./setting-page.story.md
---

# SettingPage di Activity: le chiavi di spatie/laravel-activitylog che contano

## Fase BMAD

Build, dentro la story madre di Xot [setting-page-campi-reali](../../../../Xot/docs/bmad/stories/setting-page-campi-reali.story.md).
Richiesta dell'utente (testuale): "nei SettingPage il metodo getFormSchema non puo restituire [] in ogni modulo c'e'
qualcosa da settare". Sostituisce la bozza [setting-page](./setting-page.story.md) (marcata superseded).

## Stato: manca una modifica, bloccata da un lock di un altro agente

`app/Filament/Pages/SettingPage.php` e' sotto lock di codex (task `merge-collision-cleanup`, preso alle 21:07, file
non toccato da allora, nessun claim aperto). Non l'ho sbloccato. Finche' la pagina non viene aggiornata (sotto) il form
mostra ancora il vecchio campo `delete_records_older_than_days`, che la Data non ha piu', e il test "la pagina espone
esattamente le proprieta' della Data" e' rosso. Tutto il resto e' fatto e verificato.

Contenuto da mettere in `SettingPage.php` (`getConfigName()` come in Cms, schema con le quattro chiavi):

```php
public static function getConfigName(): string
{
    return ActivityConfigData::tenantConfigName();
}

/** @return array<string, TextInput|Toggle> */
protected function getFormSchema(): array
{
    return [
        'enabled' => Toggle::make('enabled'),
        'clean_after_days' => TextInput::make('clean_after_days')->numeric()->integer()->minValue(1)->required(),
        'default_log_name' => TextInput::make('default_log_name')->maxLength(255)->required(),
        'include_soft_deleted_subjects' => Toggle::make('include_soft_deleted_subjects'),
    ];
}
```

## Cosa dice il codice, verificato

- Il pacchetto installato e' `spatie/laravel-activitylog` 5.1.3. Il file `laravel/config/activitylog.php` e' una copia
  della v4: la sua chiave `delete_records_older_than_days` **non e' letta da nessuno** (la v5 si chiama `clean_after_days`,
  letta da `CleanActivitylogCommand`), come `subject_returns_soft_deleted_models` (v5: `include_soft_deleted_subjects`).
  La bozza di Codex salvava dunque una chiave morta.
- Il pacchetto legge `config('activitylog.*')` e non sa nulla di `ActivityConfigData`. Il file del tenant
  `config/{tenant}/activitylog.php` finisce gia' in `config('activitylog')` (merge di Tenant), ma con `config:cache` un
  salvataggio non si vedrebbe. Per questo `ApplyActivityConfigAction`, chiamata da `ActivityServiceProvider::boot()`, legge il
  file con `ActivityConfigData::make()` e copia nel config **solo le chiavi che il tenant ha salvato**: finche' nessuno
  salva restano valide le variabili d'ambiente di oggi (`ACTIVITY_LOGGER_ENABLED`) e nulla cambia.
- Il file del tenant si chiama `activitylog` (non `activity`): le chiavi coincidono con quelle del pacchetto.

## Cosa si configura davvero

| Campo | Default (= pacchetto, = oggi) | Chi lo legge |
|-------|-------------------------------|--------------|
| `enabled` | `true` | `ActivityLogStatus` del pacchetto (ogni `activity()` e ogni modello con `LogsActivity`), `IsActivityLogSchemaWritableAction`, `CheckActivityLogWritableAction` (usata da `RegisterWidget` di User) |
| `clean_after_days` | `365` | `CleanActivitylogCommand` (`php artisan activitylog:clean`) |
| `default_log_name` | `default` | `PendingActivityLog` (`activity()` senza `useLog`, usato da `RegisterWidget` e `LogRegistrationAction` di User) |
| `include_soft_deleted_subjects` | `false` | `Spatie\Activitylog\Models\Activity::subject()`, di cui `Modules\Activity\Models\Activity` e' figlio |

Un test controlla che ogni proprieta' della Data sia davvero una chiave letta dal sorgente del pacchetto installato
(avrebbe preso la rinomina v4 -> v5), e un altro che i default coincidano con quelli del pacchetto.

## Lasciato fuori, e perche'

- `delete_records_older_than_days` (bozza di Codex): chiave v4 senza lettore, sostituita da `clean_after_days`.
- `activitylog:clean` **non e' pianificato** da nessuna parte del repo: `clean_after_days` ha effetto solo quando qualcuno
  lancia il comando. L'ho scritto nell'helper del campo e non ho aggiunto uno scheduler (cancellerebbe dati).
- `Modules\Activity\Adapters\ActivityLogger::cleanOld(90)` / `ActivityMaintenanceAction`: nessun chiamante di produzione,
  default 90 scritto nel codice. Non e' una impostazione.
- `buffer.enabled`, `default_except_attributes`, `actions.*`, `activity_model`, `table_name`, `database_connection`:
  prestazioni, classi e connessione, non per un form.
- `laravel/config/activitylog.php` (root, copia v4 con chiavi morte e `ACTIVITY_LOGGER_ENABLED`): non toccato, e' del
  repo radice. Da rivedere: andrebbe riallineato al file del pacchetto v5 (variabile `ACTIVITYLOG_ENABLED`).

## Verifica

- Pest `Modules/Activity/tests/Unit/Datas/ActivityConfigDataTest.php`: 9 test, 8 verdi; il nono (pagina) e' rosso finche'
  `SettingPage.php` non e' aggiornata. RED registrato prima dell'implementazione (9 su 9 falliti).
- Pest `tests/Unit/Providers`, `ActivityLogSchemaTest`, `IsActivityLogSchemaWritableActionTest`: verdi.
- PHPStan livello max sui file toccati: 0 errori. Pint: passed.
