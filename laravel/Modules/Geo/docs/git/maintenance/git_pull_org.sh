#!/bin/sh

# Controllo parametri
if [ -z "$1" ] || [ -z "$2" ]; then
    echo "Usage: $0 <organization> <branch>"
    exit 1
fi

org="$1"
branch="$2"
repo_name=$(basename "$(git rev-parse --show-toplevel)")
script_path=$(readlink -f -- "$0")
where=$(pwd)

echo "-------- START SYNC [$where ($branch) - ORG: $org] ----------"

# 1️⃣ Configurazioni globali per evitare problemi
git config core.fileMode false
git config core.ignorecase false
git config advice.skippedCherryPicks false

# 2️⃣ Sincronizziamo i submoduli PRIMA di lavorare sul repository principale
git submodule sync --recursive
git submodule update --progress --init --recursive --force --merge --rebase --remote
git submodule foreach "$script_path" "$org" "$branch"

# 3️⃣ Sincronizziamo il repository principale
git fetch origin --progress --prune
if git show-ref --verify --quiet refs/heads/"$branch"; then
    git checkout "$branch"
else
    git checkout -t origin/"$branch" || git checkout -b "$branch"
fi

# 4️⃣ Pull con gestione dei conflitti
git pull --rebase origin "$branch" --autostash --recurse-submodules --allow-unrelated-histories --prune --progress -v || {
    echo "Rebase failed, attempting conflict resolution..."
    
    # 🔄 Tentiamo di continuare il rebase automaticamente
    if git rebase --continue; then
        echo "Rebase continued successfully."
    else
        echo "Rebase conflicts detected. Attempting automatic resolution..."

        # 🛠 Risolviamo automaticamente i conflitti prendendo la versione remota
        git diff --name-only --diff-filter=U | while read file; do
            git checkout --theirs "$file"
            git add "$file"
        done

        # 🛠 Proviamo a completare il rebase
        git rebase --continue || {
            echo "Rebase auto-fix failed. Aborting..."
            git rebase --abort
            echo "Attempting merge instead..."
            git merge origin/$branch || {
                echo "Merge also failed. Manual intervention required!"
                exit 1
            }
        }
    fi
}

# 5️⃣ Normalizziamo i file e committiamo se ci sono modifiche
git add --renormalize -A
git commit -am "sync update" || echo '--------------------------- No changes to commit'

# 6️⃣ Push delle modifiche con retry
git push origin "$branch" --progress || {
    echo "Push failed, attempting rebase and retry..."
    git pull --rebase origin "$branch" && git push origin "$branch"
}

echo "-------- END PUSH [$where ($branch)] ----------"

# 7️⃣ Configuriamo il tracking del branch, se necessario
if ! git rev-parse --abbrev-ref --symbolic-full-name "@{u}" >/dev/null 2>&1; then
    git branch --set-upstream-to=origin/$branch "$branch" || true
    git branch -u origin/$branch || true
fi

echo "-------- END SYNC [$where ($branch) - ORG: $org] ----------"
