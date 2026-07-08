---
title: "User — provision MySQL locale marco + database fixcity_user"
type: concept
tags: [user, mysql, local, env, database]
created: 2026-06-12
updated: 2026-06-12
qmd: "User module local mysql marco fixcity_user provision migrate login"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/364"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/365"
related:
  - ../../../../../../bashscripts/tools/provision-local-mysql.sh
  - ../../../../Xot/docs/wiki/concepts/env-testing-parity-copy-env.md
---

# Connessione `user` e login FO

## Errore tipico

`Access denied for user 'marco'@'localhost'` sulla connessione `user` → credenziali/host MySQL.

`Table 'fixcity_user.users' doesn't exist` → migrazioni non eseguite su `--database=user`.

## Setup locale (idempotente)

```bash
./bashscripts/tools/provision-local-mysql.sh
cd laravel && php artisan migrate --database=user
./bashscripts/tools/sync-env-testing.sh
```

## Variabili `.env`

| Chiave | Esempio Fixcity |
|--------|-----------------|
| `DB_DATABASE_USER` | `fixcity_user` |
| `DB_USERNAME_USER` | `marco` |
| `DB_PASSWORD_USER` | `marco` |

La connessione Laravel `user` è mappata da `config/local/fixcity/database.php` (`user_mariadb` quando `DB_CONNECTION=mariadb`).

## Utente applicativo

Dopo migrate, creare l'utente FO (email da `FIXCITY_ADMIN_EMAIL`) con password nota per dev — es. via factory/`XotData::getUserClass()`.

## Canon

- [architecture-env-testing-parity.md](../../../../../../docs/wiki/bmad/architecture-env-testing-parity.md)
