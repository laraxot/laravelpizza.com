---
title: "authentication_logs: ownership connessione user"
type: bug-audit
module: User
status: active
created: 2026-10-18
updated: 2026-10-18
tags: [bmad, second-brain, filament-blueprint, authentication-logs, connection]
qmd: "authentication logs fixcity_user connection user ownership"
related:
  - ./decision-log.md
  - ../traits/has-authentication-log.md
  - ../../../Fixcity/docs/bmad/filament-user-uuid-connection-audit.md
---

# authentication_logs vive su `fixcity_user`

## Decisione

Sì: `authentication_logs` appartiene al modulo **User**, connessione Eloquent
`user`, database `DB_DATABASE_USER` (in FixCity: `fixcity_user`). Non va creata
né scritta su `fixcity_data`.

## Perché

- Il model `AuthenticationLog` estende `BaseModel` → `$connection = 'user'`.
- I log sono audit di login/logout legati a `users` (UUID morph).
- Filament: `AuthenticationLogResource` nel panel User/admin.
- Stesso confinamento di `users`, `devices`, `device_user`, OAuth, roles.

## Sintomo produzione (fixcity.eu)

```
Connection: user, Database: fixcity_data
Table 'fixcity_data.authentication_logs' doesn't exist
```

La connessione si chiama `user` ma punta a `fixcity_data`: tipicamente
`DB_DATABASE_USER` errato (uguale a `DB_DATABASE`), migrazioni User non
eseguite sul DB utente, oppure l'host è un alias (`config/eu/fixcity`)
il cui nome tenant non coincide con la config caricata (`local.fixcity`).
In quel caso `GetTenantNameAction` deve restituire il path reale. Il listener `FailedLoginListener` esplodeva e trasformava
un login fallito in HTTP 500.

## Deploy corretto

1. `.env`: `DB_DATABASE_USER=fixcity_user` (distinto da `DB_DATABASE=fixcity_data`).
2. Migrare il modulo User sulla connessione user, es.:
   `php artisan module:migrate User` (usa `XotBaseMigration` → connection del model).
3. Verificare:
   `Schema::connection('user')->hasTable('authentication_logs') === true`
   e `DB::connection('user')->getDatabaseName() === 'fixcity_user'`.

La configurazione FixCity applica inoltre un fail-safe: se `DB_DATABASE_USER`
è accidentalmente uguale a `DB_DATABASE`, la connessione `user` torna a
`fixcity_user`. Questo non sostituisce la correzione del `.env` e la pulizia
della cache di configurazione in produzione, ma impedisce che il confine dati
si sposti silenziosamente su `fixcity_data`.

## Codice

- Owner migration: `2024_01_01_000001_create_authentication_log_table.php`
  (`model_class = AuthenticationLog::class`).
- Duplicato `...000002...` archiviato come `.php.old`.
- Scrittura: `RecordAuthenticationLogAction` (skip + warning se tabella assente).
- Confine tipizzato: `UserContract&HasAuthentications` (non `BaseUser`).
  Vedi [`../wiki/concepts/usercontract-boundary.md`](../wiki/concepts/usercontract-boundary.md).

## Filament Blueprint

Resource già presente: `Modules\User\Filament\Resources\AuthenticationLogResource`.
Nessuna Resource Fixcity: i log non sono dominio civico.
## Translation Convention (5 Elements): FIXED 2026-10-18
-  (fixed from )
-  (fixed from )

## Translation Convention (5 Elements): FIXED 2026-10-18
- `fixcity::auth.login.intro.text` (fixed from `fixcity::auth.intro`)
- `user::auth.login.password.text` (fixed from `user::auth.password`)
- `pub_theme::accessibility.page.title.text` (fixed from `pub_theme::accessibility.title`)
