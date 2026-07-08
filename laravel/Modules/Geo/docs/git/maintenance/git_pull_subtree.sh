#!/bin/bash

source ./bashscripts/lib/custom.sh

# Validate input
if [ $# -ne 2 ]; then
    echo "Usage: $0 <path> <remote_repo>"
    exit 1
fi

# Input parameters
LOCAL_PATH="$1"
LOCAL_PATH_bak="$LOCAL_PATH"_bak
REMOTE_REPO="$2"
TEMP_BRANCH=$(basename "$LOCAL_PATH")-temp

echo "  📁 Path: $LOCAL_PATH"
echo "  🌐 URL: $REMOTE_REPO"
echo "  🌿 Branch: $BRANCH"
echo "  🌿 Temporary branch: $TEMP_BRANCH"


# Verifica se il path esiste
if [ ! -e "$LOCAL_PATH" ]; then
    handle_error "Il path $LOCAL_PATH non esiste"
fi

# Verifica se il path esiste
if [ ! -e "$LOCAL_PATH" ]; then
    handle_error "Errore: Il path $LOCAL_PATH non esiste"
fi

if(! git ls-remote "$REMOTE_REPO" > /dev/null 2>&1)
then
    handle_error "Remote repository $REMOTE_REPO not found"
fi

# Sync subtree
pull_subtree() {
    # Cross-platform compatibility settings
    git config core.ignorecase false        # Gestione case-sensitive dei file
    git config core.fileMode false          # Ignora i permessi dei file
    git config core.autocrlf false          # Non convertire automaticamente i line endings
    git config core.eol lf                  # Usa LF come line ending di default
    git config core.symlinks false          # Gestione symlinks disabilitata per Windows
    git config core.longpaths true          # Supporto per path lunghi su Windows

    find . -type f -name "*:Zone.Identifier" -exec rm -f {} \;
    git add -A
    git commit -am "."
    git push -u origin "$BRANCH"

    git fetch "$REMOTE_REPO" "$BRANCH" --depth=1
    if(! git subtree pull -P "$LOCAL_PATH" "$REMOTE_REPO" "$BRANCH"  --squash)
    then
        log "Primo tentativo di subtree pull fallito, provo una strategia alternativa..."
        if(! git subtree pull -P "$LOCAL_PATH" "$REMOTE_REPO" "$BRANCH")
        then
            log "Secondo tentativo fallito, procedo con split e merge..."
            git subtree split --prefix="$LOCAL_PATH" -b "$TEMP_BRANCH"
            git subtree merge --prefix="$LOCAL_PATH" "$TEMP_BRANCH" || log "Failed to merge subtree"
            git branch -D "$TEMP_BRANCH" || log "Failed to delete temporary branch $TEMP_BRANCH"

            mv "$LOCAL_PATH" "$LOCAL_PATH_bak" || die "Failed to rename $LOCAL_PATH to $LOCAL_PATH_bak"
            git add .
            git commit -am "Add $LOCAL_PATH_bak"
            git push -u origin "$BRANCH"

            git subtree add --prefix="$LOCAL_PATH" "$REMOTE_REPO" "$BRANCH" --squash
            rsync -avz "$LOCAL_PATH_bak/" "$LOCAL_PATH" || die "Failed to sync files"

            rm -rf "$LOCAL_PATH_bak" || die "Failed to remove backup folder"
            git add . || die "Failed to add changes after submodule sync"
            git commit -am "Added submodule for $LOCAL_PATH" || die "Failed to commit submodule changes"
            git push -u origin "$BRANCH"
        fi
    fi

    # Manutenzione avanzata repository
    git rebase --rebase-merges --strategy subtree "$BRANCH" --autosquash
    git_maintenance
}

# Run sync
pull_subtree

log "Subtree $LOCAL_PATH synchronized successfully with $REMOTE_REPO"