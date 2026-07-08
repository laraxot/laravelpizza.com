#!/bin/bash
set -euo pipefail

# Script per risolvere automaticamente i conflitti di merge scegliendo la versione HEAD
# Questo script è un wrapper per resolve_all_head_conflicts.php
#
# Uso: ./resolve_head_conflicts.sh

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PHP_SCRIPT="${SCRIPT_DIR}/resolve_all_head_conflicts.php"

# Verifica che il file PHP esista
if [ ! -f "$PHP_SCRIPT" ]; then
    echo "Errore: Script PHP non trovato: $PHP_SCRIPT"
    exit 1
fi

# Verifica che PHP sia installato
if ! command -v php &> /dev/null; then
    echo "Errore: PHP non è installato. Installare PHP prima di eseguire questo script."
    exit 1
fi

echo "Avvio risoluzione dei conflitti..."
php "$PHP_SCRIPT"

# Verifica il risultato dell'esecuzione
if [ $? -eq 0 ]; then
    echo "Risoluzione dei conflitti completata con successo!"
    exit 0
else
    echo "Si sono verificati errori durante la risoluzione dei conflitti."
    exit 1
fi
