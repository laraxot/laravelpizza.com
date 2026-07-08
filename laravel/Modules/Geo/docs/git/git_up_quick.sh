#!/bin/bash

# Funzione per aggiornare un submodule
update_submodule() {
    local submodule_path="$1"
    local target_branch="$2"  # Target branch da utilizzare (es. 'main' o 'master')
    
    # Vai nella cartella del submodule
    cd "$submodule_path" || exit

    # Verifica se ci sono modifiche locali nel submodule
    if [[ $(git status --porcelain) ]]; then
        echo "Il submodule $submodule_path ha modifiche locali. Eseguo push e pull..."

        # Push delle modifiche locali
        git add .
        git commit -m "Committing local changes in $submodule_path"
        
        # Prova a fare il push
        if ! git push origin HEAD:"$target_branch"; then
            echo "Push fallito per $submodule_path. Tentativo di sincronizzazione con il remoto..."

            # Tenta di fare pull e sincronizzare
            git fetch origin
            if git merge origin/"$target_branch"; then
                echo "Merge riuscito. Riprovando il push..."
                git push origin HEAD:"$target_branch"
            elif git rebase origin/"$target_branch"; then
                echo "Rebase riuscito. Riprovando il push..."
                git push origin HEAD:"$target_branch"
            else
                echo "Errore durante il merge o il rebase. Controllare manualmente il submodule $submodule_path."
            fi
        else
            echo "Push completato con successo per $submodule_path"
        fi
    else
        echo "Il submodule $submodule_path non ha modifiche locali. Nessuna azione necessaria."
    fi

    # Torna alla directory principale
    cd - || exit
}

# Funzione per aggiornare la root del repository
update_root() {
    echo "Controllando modifiche nella root del repository..."

    # Verifica se ci sono modifiche locali nella root
    if [[ $(git status --porcelain) ]]; then
        echo "Ci sono modifiche locali nella root. Eseguo push e pull..."

        # Push delle modifiche locali nella root
        git add .
        git commit -m "Committing local changes in the root repository"
        
        # Target branch della root (passato come parametro)
        target_branch="$1"  # Usando il parametro passato

        # Prova a fare il push
        if ! git push origin HEAD:"$target_branch"; then
            echo "Push fallito nella root. Tentativo di sincronizzazione con il remoto..."

            # Tenta di fare pull e sincronizzare
            git fetch origin
            if git merge origin/"$target_branch"; then
                echo "Merge riuscito nella root. Riprovando il push..."
                git push origin HEAD:"$target_branch"
            elif git rebase origin/"$target_branch"; then
                echo "Rebase riuscito nella root. Riprovando il push..."
                git push origin HEAD:"$target_branch"
            else
                echo "Errore durante il merge o il rebase. Controllare manualmente la root del repository."
            fi
        else
            echo "Push completato con successo nella root del repository"
        fi
    else
        echo "Nessuna modifica locale nella root. Nessuna azione necessaria."
    fi
}

# Controlla se è stato passato un parametro per il branch
if [ -z "$1" ]; then
    echo "Errore: Devi specificare il branch come parametro!"
    echo "Uso: $0 <branch>"
    exit 1
fi

# Parametro del branch
branch="$1"

# Verifica lo stato dei submodules
echo "Verifica stato dei submodules..."
git submodule status | while read -r line; do
    # Estrai il percorso del submodule
    submodule_path=$(echo "$line" | awk '{ print $2 }')

    # Aggiorna il submodule solo se ha modifiche
    update_submodule "$submodule_path" "$branch"
done

# Aggiorna la root del repository principale
update_root "$branch"

echo "Aggiornamento completato!"
