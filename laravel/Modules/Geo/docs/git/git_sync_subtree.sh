#!/bin/bash

# Validate input
if [ $# -ne 2 ]; then
    echo "Usage: $0 <path> <remote_repo>"
    exit 1
fi

# Input parameters
me=$( readlink -f -- "$0")
script_dir=$(dirname "$me")
script_dir=$(dirname "$me")
LOCAL_PATH="$1"
REMOTE_REPO="$2"
REMOTE_BRANCH=$(git symbolic-ref --short HEAD 2>/dev/null || echo "main")
TEMP_BRANCH=$(basename "$LOCAL_PATH")-temp
# Simple error handling function
die() {
    echo "$1" >&2
    exit 1
}

# Sync subtree
sync_subtree() {
    git config core.ignorecase false
    git config core.fileMode false

    git add .
    git commit -am "."
    git push -u origin "$REMOTE_BRANCH"
    
    git subtree pull -P "$LOCAL_PATH" "$REMOTE_REPO" "$REMOTE_BRANCH"  --squash ||
        git subtree pull -P "$LOCAL_PATH" "$REMOTE_REPO" "$REMOTE_BRANCH"   

    find . -type f -name "*:Zone.Identifier" -exec rm -f {} \;

    git fetch "$REMOTE_REPO" "$REMOTE_BRANCH" --depth=1
    git merge -s subtree FETCH_HEAD  --allow-unrelated-histories
    git subtree push -P "$LOCAL_PATH" "$REMOTE_REPO" "$REMOTE_BRANCH"

    git push -f "$REMOTE_REPO" $(git subtree split --prefix="$LOCAL_PATH"):"$REMOTE_BRANCH"
    # First, split the subtree to a temporary branch
    git subtree split --prefix="$LOCAL_PATH" -b "$TEMP_BRANCH"

    # Then force push that branch
    git push -f "$REMOTE_REPO" "$TEMP_BRANCH":"$REMOTE_BRANCH"

    # Optionally, clean up the temporary branch
    git branch -D "$TEMP_BRANCH"

    git subtree push -P "$LOCAL_PATH" "$REMOTE_REPO" "$REMOTE_BRANCH"
# Funzione per loggare messaggi
log() {
    local message="$1"
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $message" | tee -a "$LOG_FILE"
}

# Funzione per gestire gli errori
handle_error() {
    local error_message="$1"
    log "❌ Errore: $error_message"
    exit 1
}

# Sync subtree
sync_subtree() {
    sed -i -e 's/\r$//' "$script_dir/git_push_subtree.sh"
    sed -i -e 's/\r$//' "$script_dir/git_pull_subtree.sh"
    chmod +x "$script_dir/git_push_subtree.sh"
    chmod +x "$script_dir/git_pull_subtree.sh"
    if ! "$script_dir/git_push_subtree.sh" "$LOCAL_PATH" "$REMOTE_REPO" ; then
        log "⚠️ Push fallita per $current_path."
    fi
    if ! "$script_dir/git_pull_subtree.sh" "$LOCAL_PATH" "$REMOTE_REPO" ; then
        log "⚠️ Pull fallita per $current_path."
    fi
# Sync subtree
sync_subtree() {
    git add .
    git commit -am "."
    git push -u origin "$REMOTE_BRANCH"
    
    git subtree pull -P "$LOCAL_PATH" "$REMOTE_REPO" "$REMOTE_BRANCH"  --squash ||
        git subtree pull -P "$LOCAL_PATH" "$REMOTE_REPO" "$REMOTE_BRANCH"   

    find . -type f -name "*:Zone.Identifier" -exec rm -f {} \;

    git fetch "$REMOTE_REPO" "$REMOTE_BRANCH" --depth=1
    git merge -s subtree FETCH_HEAD  --allow-unrelated-histories
    git subtree push -P "$LOCAL_PATH" "$REMOTE_REPO" "$REMOTE_BRANCH"

    git push -f "$REMOTE_REPO" $(git subtree split --prefix="$LOCAL_PATH"):"$REMOTE_BRANCH"
    # First, split the subtree to a temporary branch
    git subtree split --prefix="$LOCAL_PATH" -b "$TEMP_BRANCH"

    # Then force push that branch
    git push -f "$REMOTE_REPO" "$TEMP_BRANCH":"$REMOTE_BRANCH"

# Funzione per gestire gli errori
handle_error() {
    local error_message="$1"
    log "❌ Errore: $error_message"
    exit 1
}

    git subtree push -P "$LOCAL_PATH" "$REMOTE_REPO" "$REMOTE_BRANCH"
# Sync subtree
sync_subtree() {
    sed -i -e 's/\r$//' "$script_dir/git_push_subtree.sh"
    sed -i -e 's/\r$//' "$script_dir/git_pull_subtree.sh"
    chmod +x "$script_dir/git_push_subtree.sh"
    chmod +x "$script_dir/git_pull_subtree.sh"
    if ! "$script_dir/git_push_subtree.sh" "$LOCAL_PATH" "$REMOTE_REPO" ; then
        log "⚠️ Push fallita per $current_path."
    fi
    if ! "$script_dir/git_pull_subtree.sh" "$LOCAL_PATH" "$REMOTE_REPO" ; then
        log "⚠️ Pull fallita per $current_path."
    fi
}

# Run sync
sync_subtree
sed -i -e 's/\r$//' "$me"

sed -i -e 's/\r$//' "$me"

echo "Subtree $LOCAL_PATH synchronized successfully with $REMOTE_REPO"