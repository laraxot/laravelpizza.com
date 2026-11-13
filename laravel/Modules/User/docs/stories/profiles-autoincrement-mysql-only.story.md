---
type: story
slug: profiles-autoincrement-mysql-only
title: "La migrazione che corregge profiles.id gira solo su MySQL/MariaDB"
status: done
owner: User
created: 2026-11-10
updated: 2026-11-10
---

# La migrazione che corregge `profiles.id` gira solo su MySQL/MariaDB

## Problema

`2026_10_16_000001_fix_profiles_id_autoincrement` usa `ALTER TABLE ... MODIFY ... AUTO_INCREMENT`, sintassi
solo MySQL/MariaDB. Su sqlite (DB delle suite Pest e della CI di Roosko) `migrate` si fermava con
`near "MODIFY": syntax error`, e chi costruiva il DB di test doveva segnare a mano la migrazione come eseguita.

## Correzione

La migrazione esce subito se il driver della connessione non e' `mysql` o `mariadb`. Su MySQL/MariaDB il
comportamento e' invariato: converte la colonna solo se e' ancora di tipo stringa e la tabella e' vuota.

## Acceptance criteria

1. `php artisan migrate` su sqlite completa senza migrazioni saltate a mano.
2. Su MySQL/MariaDB la conversione resta quella di prima.
