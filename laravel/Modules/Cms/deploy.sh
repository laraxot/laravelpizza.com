#!/usr/bin/env bash

# abilito l'uscita immediata in caso di errore
set -e

echo "Inizio deploy..."

# mi sposto nella working dir
echo "Cambio directory..."
cd /var/www/<nome progetto>le

# evito l'errore "fatal: detected dubious ownership in repository"
echo "Configurazione safe.directory..."
sudo git config --global --add safe.directory /var/www/<nome progetto>le

# eseguo pull
echo "Esecuzione git pull..."
if [ -z "$GITLAB_TOKEN" ]; then
  sudo git pull
else
  # serve passare esplicitamente la variabile GITLAB_TOKEN a sudo altrimenti la si perde
  sudo GITLAB_TOKEN="$GITLAB_TOKEN" git -c credential.helper= -c credential.helper='!f() { echo username=gitlab-ci-token; echo password=$GITLAB_TOKEN; }; f' pull
fi

# aggiornamento applicazione
cd laravel
echo "Aggiorno composer..."
sudo php -d memory_limit=-1 composer.phar selfupdate
sudo rm -rf ./app/View/Components/vendor/
sudo rm -rf ./resources/views/vendor/
echo "Aggiorno librerie..."
sudo COMPOSER_ALLOW_SUPERUSER=1 php -d memory_limit=-1 composer.phar update -W --no-interaction 1>/dev/null
echo "Pubblico variabili e configurazioni..."
sudo php artisan vendor:publish --all --quiet
sudo rm -rf database/migrations/*
sudo rm -rf ./app/View/Components/vendor/
echo "Eseguo migrazioni..."
sudo php artisan migrate --force --no-interaction --quiet
echo "Aggiorno Filament..."
sudo php artisan filament:upgrade --quiet
echo "Ottimizzo Filament..."
sudo php artisan filament:optimize --quiet
echo "Ottimizzo applicazione..."
sudo php artisan optimize --quiet
echo "Pulizia route..."
sudo php artisan route:clear --quiet

# riaggiorno i permessi
echo "Aggiornamento permessi..."
sudo chown -R www-data:www-data /var/www/<nome progetto>le/
sudo chmod -R g+w /var/www/<nome progetto>le/

echo "Deploy completato con successo!"

echo "DEPLOY_SUCCESS"
