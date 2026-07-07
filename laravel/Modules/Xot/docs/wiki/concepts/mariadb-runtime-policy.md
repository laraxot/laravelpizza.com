---
title: "MariaDB runtime policy"
module: Xot
type: concept
confidence: high
created: 2026-05-21
updated: 2026-05-21
tags: [mariadb, mysql, database, laravel, dev]
related:
  - php84-upgrade-extension-checklist.md
sources:
  - ../../../../../../bashscripts/docs/tools/migrate-mysql-to-mariadb.md
---

# MariaDB runtime policy

## Scopo

FixCity in locale usa **MariaDB** come server SQL; Laravel espone il driver nativo **`mariadb`** (`DB_CONNECTION=mariadb`). Compatibilità codice: trattare `mysql` e `mariadb` come stessa famiglia dove servono DDL specifici (`XotBaseMigration::isMysqlFamilyDriver`).

## Configurazione

```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
```

PHP: pacchetto **`php8.4-mysql`** (pdo_mysql). Systemd: **`mariadb.service`** preferito.

## Operazioni host

- Migrazione guidata: `bashscripts/tools/lamp/migrate_mysql_to_mariadb.sh`
- Avvio + utente dev: `bashscripts/tools/lamp/mysql_start_and_grant_marco.sh`

## Migrazioni

Vedi modulo User: regola `after()` solo in `ALTER`, non in `CREATE` — [mariadb-create-table-after-rule.md](../../../../User/docs/wiki/concepts/mariadb-create-table-after-rule.md).

## Collegamenti

- [migrate-mysql-to-mariadb.md](../../../../../../bashscripts/docs/tools/migrate-mysql-to-mariadb.md)
- [install.txt](../../lamp/install.txt)
