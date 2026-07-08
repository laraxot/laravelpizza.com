#!/bin/bash

me=$( readlink -f -- "$0";)
echo "Verificando lo stato dei submodules..."

# Controlla i submodules che hanno modifiche
git submodule foreach --quiet 'if [ -n "$(git status --porcelain)" ]; then echo $name; fi' | while read submodule; do
    echo "Aggiornando submodule: $submodule"

    if [ -d "$submodule" ]; then
        cd "$submodule"

        git add .
        git commit -m "Auto update submodule"
        git push origin $(git rev-parse --abbrev-ref HEAD)

        cd - > /dev/null # Torna alla root del repository
        git add "$submodule"
    else
        echo "Errore: Il submodule $submodule non esiste!"
    fi
done

# Commit e push nel repository principale
if git diff --cached --quiet; then
    echo "Nessun aggiornamento nei submodules."
else
    git commit -m "Aggiornamento submodules"
    git push origin $(git rev-parse --abbrev-ref HEAD)
fi
sed -i -e 's/\r$//' "$me"
echo "Aggiornamento completato!"
