#!/bin/sh

me=$( readlink -f -- "$0";)
git submodule foreach "$me" 
me=$(readlink -f -- "$0";)
git submodule foreach "$me"

[0;34mℹ️ [2025-04-22 11:23:28] Scelto blocco HEAD (5 linee vs 1)[0m

# Branch da mantenere
branches_to_keep="dev master prod"


[0;34mℹ️ [2025-04-22 11:23:28] Scelto blocco incoming (1 linee vs 1)[0m
# Itera su tutti i remote configurati
for remote in $(git remote); do
    echo "Checking remote: $remote"

    # Ottieni la lista di tutti i branch remoti, escludendo quelli da mantenere
    branches_to_delete=$(git branch -r | grep "remotes/$remote/" | sed "s#remotes/$remote/##" | grep -v -E "^(dev|master|prod)$")
    #branches_to_delete=$(git ls-remote --heads "$remote" | awk '{print $2}' | sed 's#refs/heads/##' | grep -v -E "^(dev|master|prod)$")

[0;34mℹ️ [2025-04-22 11:23:28] Scelto blocco HEAD (2 linee vs 1)[0m

    # Cancella solo se ci sono branch da eliminare
    if [ -n "$branches_to_delete" ]; then
        for branch in $branches_to_delete; do
            echo "Deleting branch '$branch' from remote '$remote'..."
            git push "$remote" --delete "$branch"
        done
    else
        echo "No branches to delete for remote '$remote'."
    fi
done

[0;34mℹ️ [2025-04-22 11:23:28] Scelto blocco incoming (1 linee vs 1)[0m
# Elimina i branch vecchi
for branch in $(git branch -r | grep -v HEAD | grep -v "$branches_to_keep"); do
    git branch -d "$branch"
done

echo "Branch vecchi eliminati con successo."

[0;34mℹ️ [2025-04-22 11:23:28] Scelto blocco incoming (1 linee vs 1)[0m
