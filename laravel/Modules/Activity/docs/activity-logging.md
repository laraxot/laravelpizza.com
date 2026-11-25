---
title: "Activity: registrare e leggere le attivita'"
type: guide
status: active
module: Activity
created: 2026-11-25
updated: 2026-11-25
qmd: "activity logging LogActivityAction listener logout login redazione properties causer retention clean_after_days SettingPage activitylog spatie activity helper"
related:
  - ./actions.md
  - ./architecture.md
  - ./database.md
---

# Registrare e leggere le attivita'

Fatti verificati sul codice il 2026-11-25.

## Due strade per scrivere nel registro

1. **Helper Spatie `activity()`**: e' quello che usano di fatto gli altri moduli (per esempio `User\Actions\Activity\LogRegistrationAction`, `User\Filament\Widgets\Auth\RegisterWidget`). Scrive su `Modules\Activity\Models\Activity` perche' `activitylog.activity_model` punta li'.
2. **Action del modulo**: `LogActivityAction` e le Action derivate. Nessun chiamante fuori dal modulo (vedi [architecture.md](./architecture.md)).

```php
use Modules\Activity\Actions\LogActivityAction;

// type, user (causer), subject, properties, description
(new LogActivityAction(
    'priority_changed',
    subject: $ticket,
    properties: ['from' => $previous, 'to' => $priority],
))->execute(); // restituisce Models\Activity
```

`LogActivityAction` scrive `log_name` = `event` = `$type`; `description` di default `Activity: <type>`; `subject_type`/`subject_id` dal subject; `causer_type` dal `user` passato.

### Regole del causer (limite verificato)

- `user` deve implementare `UserContract`, altrimenti `InvalidArgumentException`; `type` vuoto lancia `InvalidArgumentException`.
- Senza `user`, `causer_id` diventa `Auth::id()` ma `causer_type` resta `null`: l'attivita' ha un id senza tipo, quindi la relazione `causer` non si risolve.
- `causer_id` e `subject_id` sono stringhe di 36 caratteri (compatibili con UUID), vedi [database.md](./database.md).

## Azioni di dominio gia' pronte

| Action | `event` | properties |
|---|---|---|
| `LogModelCreatedAction` | `created` | `attributes` |
| `LogModelUpdatedAction` | `updated` | `old`, `new`, `changes` |
| `LogModelDeletedAction` | `deleted` | `attributes` |
| `LogUserLoginAction` / `LogUserLogoutAction` | `login` / `logout` | nessuna (subject = user) |
| `RecordSubjectActivityAction` | quello passato | quelle passate; `log_name` = `default`, nessun causer |

Tutte le properties dei modelli passano da `RedactModelAttributesAction`, che toglie `password`, `remember_token`, `two_factor_secret`, `two_factor_recovery_codes`. La lista e' fissa: altri segreti (token API, codici fiscali) non sono redatti.

## Listener di autenticazione

`EventServiceProvider` mappa `Illuminate\Auth\Events\Login` su `LoginListener` e `Logout` su `LogoutListener`.

- `LogoutListener::handle(Logout)` scrive un `Activity` con `log_name` `auth`, `event` `logout`, causer = utente; properties: `guard`, `ip_address`, `user_agent`, `timestamp`, `session_duration` (se l'utente ha `last_login_at`) e `logout_reason` (se la request lo contiene).
- `LoginListener::handle()` e' **vuoto**: gli accessi non finiscono in questo registro, solo le uscite. Il modulo User traccia il login per conto suo; la simmetria rotta e' debito noto ([roadmap.md](./roadmap.md)).

## Leggere

Le sei Action in `Actions/Query` (vedi [actions.md](./actions.md)) restituiscono collezioni tipizzate: per utente, per modello, per tipo, ultime N, log di un subject (array) e statistiche. `GetActivityStatisticsAction` mette in cache per 5 minuti (`activity.statistics.<userKey|global>`) `total`, `by_type`, `today`, `this_week`. Scope sul modello: `forBatch($uuid)` e `hasBatch()` (`ActivityScopes`).

## Ritenzione

`ActivityMaintenanceAction::execute(int $days = 90)` cancella le attivita' piu' vecchie di `$days` giorni a blocchi di 1000 (`chunkById`) e restituisce il numero di righe; `$days <= 0` lancia `InvalidArgumentException`. Nessuno scheduler e nessun comando artisan la richiamano nel modulo (cartella `app/Console/Commands` senza comandi): va invocata dal progetto host.

## Impostazioni per tenant

`Filament\Pages\SettingPage` (estende `BaseSettingPage`, config name `activitylog`) salva: `enabled`, `clean_after_days` (intero >= 1), `default_log_name` (max 64), `include_soft_deleted_subjects`. `ApplyActivityConfigAction`, chiamata dal `boot()` del provider, legge la config salvata dal tenant (`GetTenantConfigArrayAction`) e copia in `config('activitylog.<chiave>')` solo le chiavi presenti. I default dei dati stanno in `ActivityConfigData` (`enabled` true, `clean_after_days` 365, `default_log_name` `default`, `include_soft_deleted_subjects` false).

Nota: solo `enabled` e `default_log_name` coincidono con chiavi di `config/activitylog.php`. `clean_after_days` e `include_soft_deleted_subjects` finiscono in chiavi che il pacchetto Spatie non conosce (le sue sono `delete_records_older_than_days` e `subject_returns_soft_deleted_models`) e nel modulo nessun codice le legge. Non verificato che altro codice del progetto le consumi.

## Verifica che lo schema sia scrivibile

`CheckActivityLogWritableAction` e `IsActivityLogSchemaWritableAction` rispondono `true` solo se `activitylog.enabled` e se tabella (`activitylog.table_name`) e colonna `attribute_changes` esistono sulla connessione di `activitylog.database_connection` (o sul default). Servono a non far fallire un flusso (per esempio la registrazione utente) quando le migrazioni non sono ancora girate. Le due Action sono praticamente identiche: candidate alla fusione.

## Se le properties risultano vuote

Il caso tipico e' un modello di dominio con `LogsActivity` di Spatie e `getActivitylogOptions()` che usa solo `->logOnlyDirty()`: senza `->logAll()` o `->logOnly([...])` non traccia nulla. Configurazione corretta: `LogOptions::defaults()->logAll()->logOnlyDirty()->dontSubmitEmptyLogs()`. Dettagli e altri errori: [troubleshooting.md](./troubleshooting.md).
