#!/bin/bash

CONFIG_FILE="gitmodules.ini"

if [[ ! -f $CONFIG_FILE ]]; then
    echo "Errore: Il file $CONFIG_FILE non esiste!"
    exit 1
fi

branch=$(git symbolic-ref --short HEAD)
current_path=""

while IFS= read -r line; do
    line=$(echo "$line" | tr -d "\r" | sed "s/^[[:space:]]*//;s/[[:space:]]*$//")
    
    if [[ $line =~ path\ =\ (.+)$ ]]; then
        current_path="${BASH_REMATCH[1]}"
        current_path=$(echo "$current_path" | sed "s/^[[:space:]]*//;s/[[:space:]]*$//")
    elif [[ $line =~ url\ =\ (.+)$ ]]; then
        current_url="${BASH_REMATCH[1]}"
        current_url=$(echo "$current_url" | sed "s/^[[:space:]]*//;s/[[:space:]]*$//")
        
        echo "----------------------------------------"
        echo "📂 Path: $current_path"
        echo "🔗 URL:  $current_url"

        git rm --cached -rf "$current_path"
        rm -rf "$current_path"
        git add -A 
        git commit -am "."
        echo "➕ Aggiunta del subtree..."
        git subtree add --prefix="$current_path" "$current_url" "$branch" --squash

        echo "🔄 Sincronizzazione con il repository remoto..."
        if ! git subtree pull --prefix="$current_path" "$current_url" "$branch" --squash; then
            echo "⚠️  Errore in git subtree pull, tentando con fetch + merge..."
            git fetch "$current_url" "$branch"
            git merge -s subtree -Xsubtree="$current_path" FETCH_HEAD --allow-unrelated-histories
        fi

        echo "⬆️  Pushing delle modifiche locali nel subtree remoto..."
        git subtree push --prefix="$current_path" "$current_url" "$branch"

    fi
done < "$CONFIG_FILE"


echo "✅ Tutti i git subtree sono stati inizializzati con successo!!!"
