#!/bin/bash

# Script per verificare la presenza di percorsi assoluti nei file di documentazione
# Questo script identifica i file markdown che contengono percorsi assoluti,
# che violano le regole di documentazione del progetto

echo "Verifica percorsi assoluti nei file di documentazione..."
echo "========================================================="

# Cerca percorsi assoluti nei file markdown
find /var/www/html/base_<nome progetto> -name "*.md" -type f -print0 | xargs -0 grep -l "\[.*\](/var/www/html/" | while read file; do
    echo "File con percorsi assoluti: $file"
    grep -n "\[.*\](/var/www/html/" "$file"
done

# Cerca percorsi assoluti nei file markdown (variante con spazio)
find /var/www/html/base_<nome progetto> -name "*.md" -type f -print0 | xargs -0 grep -l "\[.*\] (/var/www/html/" | while read file; do
    echo "File con percorsi assoluti (variante con spazio): $file"
    grep -n "\[.*\] (/var/www/html/" "$file"
done

echo "========================================================="
echo "Completato! Correggere i percorsi assoluti trovati utilizzando percorsi relativi."
echo "Esempio:"
echo "  [Documento](/var/www/html/base_<nome progetto>/docs/file.md) → [Documento](../docs/file.md)"
