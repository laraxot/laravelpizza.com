#!/bin/bash


source ./bashscripts/lib/custom.sh
# Includi lo script di parsing
source ./bashscripts/lib/parse_gitmodules_ini.sh

# Chiama la funzione
parse_gitmodules gitmodules.ini

total=${submodules_array["total"]}
for ((i=0; i<total; i++)); do
    path=${submodules_array["path_${i}"]}
    url=${submodules_array["url_${i}"]}
    echo "➕ Aggiunta del subtree $i  📁 Path: $path  🌐 URL: $url"

    git add -A
    git commit -am "."
    git push -u origin "$branch"
    git subtree add --prefix="$path" "$url" "$BRANCH" --squash
done


echo "✅ Tutti i git subtree sono stati inizializzati con successo!!!"
