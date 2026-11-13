---
title: "Monitoraggio login: Pulse live e storico AuthenticationLog"
type: architecture
module: User
status: active
updated: 2026-11-11
tags:
  - pulse
  - login
  - authentication-log
  - widget
qmd: "pulse login user_login authentication_logs 7 giorni retention backfill LoginWidget LoginCard GetLoginStatsAction key_hash"
related:
  - ./bmad/stories/pulse-login-backfill-key-hash.story.md
---

# Monitoraggio login

## Sorgente di verità

`authentication_logs` (connessione `user`, DB `ptv_user`) è lo storico completo dei
login. Il modello è `Modules\User\Models\AuthenticationLog`.

## Due percorsi, due scopi

| Percorso | Dati | Orizzonte |
|----------|------|-----------|
| Pulse (`user_login`, key `all`) | `RecordLoginPulseAction` live + `user:pulse-backfill-logins` | max 7 giorni |
| `GetLoginStatsAction` | legge `authentication_logs` | tutto lo storico |
| `GetLoginHistoryAction` | serie giorno/mese da `authentication_logs` | tutto lo storico |

Semantica condivisa: si contano **tutte** le righe con timestamp valorizzato,
anche `login_successful = false` (tentativi falliti). `LoginListener` e
`FailedLoginListener` chiamano `RecordLoginPulseAction` con lo stesso `$loginAt`
di `RecordAuthenticationLogAction`; il backfill non filtra il successo.

`GetLoginHistoryAction` legge i timestamp con `toBase()`: `pluck()` su Eloquent
restituirebbe oggetti Carbon (cast datetime) e i bucket risulterebbero vuoti.
Con `toBase()` si ottengono le stringhe SQL e `substr()` produce chiavi `Y-m-d`
o `Y-m`.

Pulse non può conservare più di 7 giorni: `DatabaseStorage` aggrega solo i periodi
60/360/1440/10080 minuti e `trim()` elimina entries/aggregati più vecchi. Il
backfill è quindi limitato a 7 giorni per progetto, non per scelta del comando.

## Widget dashboard

`Filament\Widgets\Pulse\LoginWidget` dichiara
`protected string $view = 'user::filament.widgets.pulse.login-widget'` (senza
questa riga la vista era codice morto e la dashboard mostrava solo il grafico
Pulse). La vista incorpora `LoginCard`, che usa `GetLoginStatsAction` e mostra
oggi / 7 giorni / 30 giorni / totale accessi più il trend degli ultimi 7 giorni.

La serie live 1h–7g resta su Pulse (`Pulse::graph(['user_login'], 'count', ...)`)
e alimenta `RecordLoginPulseAction`; lo storico completo arriva da
`authentication_logs`, non da Pulse.

## Schema Pulse

Le migration Xot `2024_09_24_111828_create_pulse_{entries,aggregates}_table.php`
creano `key_hash` come stringa semplice: su MariaDB nessuno la popola
(`requiresManualKeyHash()` è true solo su SQLite) e ogni insert fallisce con
`1364 Field 'key_hash' doesn't have a default value`. La migration applicativa
`2026_11_11_000001_fix_pulse_key_hash_generated_columns.php` ricrea la colonna
come `BINARY(16) GENERATED ALWAYS AS (UNHEX(MD5(key))) VIRTUAL` e ripristina gli
indici. Su MariaDB il `MODIFY` diretto di una colonna indicizzata fallisce con
errore 1907: servono ADD + DROP + RENAME in statement separati.

## Comandi

```bash
php artisan user:pulse-backfill-logins --days=7 --force
php artisan user:pulse-backfill-logins --days=7 --dry-run
```
