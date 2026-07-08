#!/bin/bash

# Script per risolvere i conflitti Git rimanenti
# Focus su documentazione e file di configurazione

set -e

echo "🔍 Ricerca file con conflitti Git rimanenti..."

# Trova tutti i file con conflitti (escluso vendor)
        sed -i 's/>>>>>>> [a-f0-9]* (\.)//g' "$file"
    elif [[ "$file" == *.sh ]]; then
        # Per script bash, mantieni la versione più recente
        sed -i 's/>>>>>>> [a-f0-9]* (\.)//g' "$file"
    fi
    
    # Verifica se il file ha ancora conflitti
