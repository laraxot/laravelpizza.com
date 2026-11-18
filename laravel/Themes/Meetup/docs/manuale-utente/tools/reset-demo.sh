#!/bin/sh
# Ricrea da zero il database demo (vuoto + migrazioni + dati del manuale).
# Uso, da laravel/:  sh Themes/Meetup/docs/manuale-utente/tools/reset-demo.sh
# PHP_BIN per un PHP diverso da quello di sistema. Si ferma se i database non hanno "demo" nel nome.
set -e
PHP=${PHP_BIN:-php}
TOOLS=$(dirname "$0")
DBS=$($PHP artisan tinker --execute='echo config("database.connections.mysql.database")." ".config("database.connections.user_mysql.database", "");' < /dev/null | tail -1)
for db in $DBS; do
  case "$db" in *demo*) ;; *) echo "Database '$db' senza 'demo' nel nome: mi fermo."; exit 1 ;; esac
done
$PHP artisan db:wipe --force --database=mysql >/dev/null
[ -n "$(echo $DBS | cut -s -d' ' -f2)" ] && $PHP artisan db:wipe --force --database=user_mysql >/dev/null || true
$PHP artisan migrate --force >/dev/null
$PHP "$TOOLS/seed-demo.php" "$PWD"
$PHP artisan passport:keys --no-interaction >/dev/null 2>&1 || true
rm -rf storage/framework/cache/data/* storage/framework/views/*.php
echo "Database demo pronto."
