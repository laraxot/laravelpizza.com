#!/bin/bash

FILE_PATH="Modules/Xot/Helpers/Helper.php"

echo "Risoluzione completa conflitti Git in $FILE_PATH..."

# Crea backup
cp "$FILE_PATH" "${FILE_PATH}.backup2"

# Rimuove TUTTI i marcatori di conflitto Git e mantiene solo il contenuto HEAD
awk '
/^<<<<<git marker>/ { in_head = 1; next }
/^=======/ { in_head = 0; next }
/^>>>>>>> / { next }
in_head == 1 { print }
in_head == 0 && !/^<<<<<git marker>/ && !/^=======/ && !/^>>>>>>> / { print }
' "$FILE_PATH" > "${FILE_PATH}.tmp"

mv "${FILE_PATH}.tmp" "$FILE_PATH"

echo "Conflitti risolti. Backup salvato in ${FILE_PATH}.backup2"

# Verifica finale
if grep -q "<<<<<git marker>\|=======\|>>>>>>> " "$FILE_PATH"; then
    echo "ATTENZIONE: Ci sono ancora marcatori di conflitto nel file!"
    exit 1
else
    echo "Tutti i conflitti sono stati risolti con successo."
fi
