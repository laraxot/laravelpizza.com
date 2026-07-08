#!/bin/bash

# File contenente le configurazioni dei submodules
GITMODULES_FILE="gitmodules.txt"

# Branch della root da sincronizzare
ROOT_BRANCH=$(git rev-parse --abbrev-ref HEAD)

# Controlla se il file gitmodules.txt esiste
if [[ ! -f "$GITMODULES_FILE" ]]; then
  echo "Errore: File $GITMODULES_FILE non trovato!"
  exit 1
fi

# Legge il file gitmodules.txt
while read -r line; do
  # Salta i commenti o righe vuote
  if [[ "$line" =~ ^#.* || -z "$line" ]]; then
    continue
  fi

  # Estrae il nome del submodule
  if [[ "$line" =~ ^\[submodule.*\"(.*)\" ]]; then
    SUBMODULE_NAME="${BASH_REMATCH[1]}"
  fi

  # Estrae il percorso
  if [[ "$line" =~ ^path\ =\ (.*) ]]; then
    # Rimuove caratteri speciali dal percorso
    SUBMODULE_PATH=$(echo "${BASH_REMATCH[1]}" | tr -cd '[:alnum:]/_-')

    # Crea la directory del submodule se non esiste
    echo "Creazione della directory: $SUBMODULE_PATH"
    mkdir -p "$SUBMODULE_PATH"

    # Naviga nella directory
    cd "$SUBMODULE_PATH" || exit
  fi

  # Estrae l'URL
  if [[ "$line" =~ ^url\ =\ (.*) ]]; then
    SUBMODULE_URL="${BASH_REMATCH[1]}"

    echo "Sincronizzo il submodule $SUBMODULE_NAME in $SUBMODULE_PATH con $SUBMODULE_URL"

    # Inizializza Git nella directory
    git init
    git config core.fileMode false
    git config advice.skippedCherryPicks false
    git checkout -b "$ROOT_BRANCH"
    git remote add origin "$SUBMODULE_URL"
    git fetch origin

    git add -A
    git commit -am "."

    # Esegue il pull per unire modifiche remote con quelle locali, risolvendo automaticamente i conflitti
    echo "Eseguo il pull con risoluzione automatica dei conflitti..."
    git pull origin "$ROOT_BRANCH" --force --rebase --autostash --strategy-option=theirs
    

    # Unisce le modifiche remote con quelle locali
    echo "Eseguo il merge delle modifiche remote in $SUBMODULE_PATH..."
    git merge origin/"$ROOT_BRANCH" --no-edit --strategy-option=theirs

    
    # Aggiunge eventuali modifiche locali e le committa
    if [[ -n $(git status --porcelain) ]]; then
      echo "Ci sono modifiche locali in $SUBMODULE_PATH. Le committerò e le sincronizzerò."
      git add -A
      git commit -am "Sync changes from parent project"
    fi

    # Pusha le modifiche
    git push -u origin HEAD:"$ROOT_BRANCH"

    # Torna alla root e cancella la cartella .git
    cd - || exit
    rm -rf "$SUBMODULE_PATH/.git"
    echo "Sincronizzazione completata per $SUBMODULE_NAME"
  fi
done < "$GITMODULES_FILE"

echo "Tutti i submodules sono stati sincronizzati con il branch $ROOT_BRANCH."
