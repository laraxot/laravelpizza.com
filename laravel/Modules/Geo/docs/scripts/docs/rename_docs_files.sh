#!/bin/bash

# Script per rinominare tutti i file e le cartelle con nomi maiuscoli nelle cartelle docs
# Eccezione: README.md

find /var/www/html/ptvx/docs /var/www/html/ptvx/laravel/Modules/*/docs -name "*[A-Z]*" | grep -v "README.md" | while read file; do
    # Ottieni il nuovo nome convertendo in minuscolo
    newname=$(echo "$file" | sed 's/\([^/]*\)$/\L\1/')
    
    # Se il nuovo nome è diverso dal vecchio nome
    if [ "$file" != "$newname" ]; then
        # Crea le directory intermedie necessarie
        mkdir -p "$(dirname "$newname")"
        
        echo "Rinomino: $file -> $newname"
        mv "$file" "$newname"
    fi
done

# Rinomina anche le cartelle (separatamente per evitare problemi)
find /var/www/html/ptvx/docs /var/www/html/ptvx/laravel/Modules/*/docs -type d -name "*[A-Z]*" | sort -r | while read dir; do
    # Ottieni il nuovo nome convertendo in minuscolo
    newname=$(echo "$dir" | sed 's/\([^/]*\)$/\L\1/')
    
    # Se il nuovo nome è diverso dal vecchio nome
    if [ "$dir" != "$newname" ]; then
        # Verifica se la directory esiste già
        if [ ! -d "$newname" ]; then
            echo "Rinomino directory: $dir -> $newname"
            mv "$dir" "$newname"
        else
            echo "Directory già esistente, unisco contenuti: $dir -> $newname"
            # Sposta il contenuto invece della directory
            find "$dir" -mindepth 1 -maxdepth 1 | while read item; do
                mv "$item" "$newname/"
            done
            # Rimuovi la directory vuota
            rmdir "$dir" 2>/dev/null
        fi
    fi
done

echo "Processo di rinomina completato!"