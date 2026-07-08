#!/bin/bash

# 🚀 Importa funzioni di utilità
source ./bashscripts/lib/custom.sh

# ✅ Validazione input
if [ "$#" -ne 2 ]; then
    log "error" "Parametri mancanti"
    log "info" "Uso: $0 <organization> <branch>"
    exit 1
fi

# 📌 Configurazione
org="$1"
branch="$2"
repo_name=$(basename "$(git rev-parse --show-toplevel)")
script_path=$(readlink -f -- "$0")
where=$(pwd)

log "info" "-------- START SYNC [$where ($branch) - ORG: $org] ----------"

# 1️⃣ Configurazioni globali per evitare problemi
git_config_setup

# 2️⃣ Sincronizziamo i submoduli PRIMA di lavorare sul repository principale
log "info" "Sincronizzazione submoduli..."
git submodule sync --recursive || handle_git_error "sync submodules" "Errore nella sincronizzazione submoduli"
git submodule update --progress --init --recursive --force --merge --rebase --remote || handle_git_error "update submodules" "Errore nell'aggiornamento submoduli"
git submodule foreach "$script_path" "$org" "$branch" || log "warning" "Errore nell'esecuzione script sui submoduli"

# 3️⃣ Sincronizziamo il repository principale
log "info" "Sincronizzazione repository principale..."
git fetch origin --progress --prune || handle_git_error "fetch" "Errore nel fetch"

if git show-ref --verify --quiet refs/heads/"$branch"; then
    git checkout "$branch" || handle_git_error "checkout" "Errore nel checkout del branch esistente"
else
    git checkout -t origin/"$branch" || git checkout -b "$branch" || handle_git_error "checkout" "Errore nella creazione del branch"
fi

# 4️⃣ Pull con gestione dei conflitti
log "info" "Esecuzione pull con rebase..."
git pull --rebase origin "$branch" --autostash --recurse-submodules --allow-unrelated-histories --prune --progress -v || {
    log "warning" "Rebase fallito, tentativo di risoluzione conflitti..."
    
    # 🔄 Tentiamo di continuare il rebase automaticamente
    if git rebase --continue; then
        log "success" "Rebase completato con successo"
    else
        log "warning" "Rilevati conflitti nel rebase. Tentativo di risoluzione automatica..."

        # 🛠 Risolviamo automaticamente i conflitti prendendo la versione remota
        git diff --name-only --diff-filter=U | while read file; do
            git checkout --theirs "$file" || log "warning" "Impossibile risolvere conflitto in $file"
            git add "$file" || log "warning" "Impossibile aggiungere $file"
        done

        # 🛠 Proviamo a completare il rebase
        git rebase --continue || {
            log "error" "Risoluzione automatica fallita. Abort..."
            git rebase --abort
            log "info" "Tentativo merge..."
            git merge origin/$branch || handle_git_error "merge" "Merge fallito. Intervento manuale richiesto!"
        }
    fi
}

# 5️⃣ Normalizziamo i file e committiamo se ci sono modifiche
log "info" "Normalizzazione e commit modifiche..."
git add --renormalize -A || handle_git_error "add" "Errore nell'add"
git commit -am "sync update" || log "info" "Nessuna modifica da committare"

# 6️⃣ Push delle modifiche con retry
log "info" "Push modifiche..."
git push origin "$branch" --progress || {
    log "warning" "Push fallito, tentativo rebase e retry..."
    git pull --rebase origin "$branch" && git push origin "$branch" || handle_git_error "push" "Push fallito dopo retry"
}

# 7️⃣ Configuriamo il tracking del branch, se necessario
if ! git rev-parse --abbrev-ref --symbolic-full-name "@{u}" >/dev/null 2>&1; then
    git branch --set-upstream-to=origin/$branch "$branch" || true
    git branch -u origin/$branch || true
fi

# 8️⃣ Manutenzione finale
git_maintenance

log "success" "-------- END SYNC [$where ($branch) - ORG: $org] ----------"
