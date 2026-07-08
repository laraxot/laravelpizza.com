---
type: concept
module: User
confidence: high
updated: 2026-04-28
tags: [migration, mariadb, mysql, schema-builder, dry, kiss, clean-code]
---

# MariaDB create table `after()` rule

## Scopo

Evitare errori SQL in migrazione quando si crea una tabella nuova con Laravel Schema Builder.

Nel percorso `Schema::create(...)` / `tableCreate(...)`, il modificatore `->after('...')`
non deve essere usato.

## Regola operativa

- In `CREATE TABLE`: definire solo colonne, indici, vincoli.
- In `ALTER TABLE` (`Schema::table(...)` / `tableUpdate(...)`): usare `->after(...)` se serve ordine visivo.

## Best practices

- Nel blocco create, usare ordine naturale dichiarativo delle colonne.
- Usare `tableUpdate()` idempotente per patch additive su installazioni esistenti.
- Mantenere una sola migrazione owner per tabella (modello ↔ migrazione canonica).
- Tenere il fix minimo: rimuovere `after()` da create, non riscrivere la migrazione intera.

## Bad practices

- Usare `->after('id')` dentro `tableCreate()` per colonne come `uuid`.
- Mischiare nello stesso blocco logica create e logica alter dipendente da ambiente.
- Duplicare fix in più migrazioni additive quando esiste già la migrazione canonica.

## False friends

- "Funziona su MySQL locale, quindi è corretto ovunque": falso, in MariaDB può rompere il SQL generato.
- "`after()` è solo cosmetico, quindi innocuo in create": falso, entra nella query e può renderla invalida.
- "Per fixare devo creare una nuova `add_*` migration": falso se il progetto adotta la regola one-table-one-migration.

## Checklist rapida

- [ ] In blocco `tableCreate(...)` non c'è nessun `->after(...)`
- [ ] Gli `after(...)` sono confinati a `tableUpdate(...)`
- [ ] Migrazione verificata con `php artisan migrate --path=... --realpath --force`
- [ ] Wiki index/log aggiornati

## Link verificati

- [Laravel migrations](https://laravel.com/docs/12.x/migrations)
- [Laravel Schema Builder columns](https://laravel.com/docs/12.x/migrations#columns)
- [MariaDB ALTER TABLE](https://mariadb.com/kb/en/alter-table/)
