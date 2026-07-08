#!/bin/bash

# Abilita l'exit immediato in caso di errori
set -e

# Ottieni la cartella corrente
current_dir=$(basename "$(pwd)")

# Costruisci il nome della cartella di destinazione
destination="../${current_dir}_mono"

echo "Creazione della cartella di destinazione: $destination"
mkdir -p "$destination"

# Copia i file e le cartelle, escludendo quelli specificati
echo "Copia dei file in corso..."

rsync -av --progress ./ "$destination" \
    --exclude vendor \
    --exclude .git \
    --exclude node_modules \
    --exclude build \
    --exclude .gitmodules \
    --exclude .git \
    --exclude '*.git'

echo "Copia completata!"
echo "I file sono stati copiati in $destination."
