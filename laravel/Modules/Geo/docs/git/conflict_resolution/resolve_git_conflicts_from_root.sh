#!/bin/bash

# Script per risolvere conflitti Git nel file Helper.php
# Mantiene sempre la versione HEAD (prima del =======)

FILE_PATH="Modules/Xot/Helpers/Helper.php"

if [ ! -f "$FILE_PATH" ]; then
    echo "File $FILE_PATH non trovato!"
    exit 1
fi

echo "Risoluzione conflitti Git in $FILE_PATH..."

# Crea backup
cp "$FILE_PATH" "${FILE_PATH}.backup"

# Rimuove tutti i marcatori di conflitto Git mantenendo solo la versione HEAD
sed -i '/^<<<<<git marker>/,/^=======/!d' "$FILE_PATH"
sed -i '/^>>>>>>> /d' "$FILE_PATH"

echo "Conflitti risolti. Backup salvato in ${FILE_PATH}.backup"

# Verifica che non ci siano più marcatori di conflitto
if grep -q "<<<<<git marker>\|=======\|>>>>>>> " "$FILE_PATH"; then
    echo "ATTENZIONE: Ci sono ancora marcatori di conflitto nel file!"
    exit 1
else
    echo "Tutti i conflitti sono stati risolti con successo."
fi