#!/bin/bash

# Verifica che sia stato passato un parametro
if [ $# -ne 1 ]; then
    echo "Uso: $0 <nome_organizzazione>"
    exit 1
fi

me=$( readlink -f -- "$0";)
# Prendi il nome dell'organizzazione da parametro
NEW_ORG="$1"

git submodule foreach "$me" "$NEW_ORG"

# Get the repository name from the remote URL
MAIN_REPO_NAME=$(basename "$(git config --get remote.origin.url)" .git)

# Create new remote URL using SSH by default
NEW_MAIN_REMOTE="git@github.com:$NEW_ORG/$MAIN_REPO_NAME.git"

# Aggiungi il remote al repository Git
git remote add $NEW_ORG $NEW_MAIN_REMOTE

# Verifica se l'operazione è riuscita
if [ $? -eq 0 ]; then
    echo "Remote '$NEW_ORG' aggiunto con URL $NEW_MAIN_REMOTE"
else
    echo "Errore durante l'aggiunta del remote $NEW_MAIN_REMOTE"
fi