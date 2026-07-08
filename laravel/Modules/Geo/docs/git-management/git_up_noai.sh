#!/bin/bash

source ./bashscripts/lib/custom.sh

#!/bin/bash

 # 🎨 Colori per il logging
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# 📝 Funzione di logging
log() {
    local level="$1"
    local message="$2"
    case "$level" in
        "error") echo -e "${RED}❌ $message${NC}" ;;
        "success") echo -e "${GREEN}✅ $message${NC}" ;;
        "warning") echo -e "${YELLOW}⚠️ $message${NC}" ;;
        "info") echo -e "ℹ️ $message" ;;
    esac
}

# ✅ Validazione input
if [ -z "$1" ]; then
    log "error" "Devi specificare il branch come parametro!"
    log "info" "Uso: ./bashscripts/git_up_noai.sh <branch>"
    exit 1
fi

# 📌 Configurazione
me=$(readlink -f -- "$0")
BRANCH="$1"
WHERE=$(pwd)

# 🔄 Aggiornamento submodule
log "info" "Aggiornamento submodule in corso..."
git submodule update --progress --init --recursive --force --merge --rebase --remote || {
    log "error" "Errore nell'aggiornamento submodule"
    exit 1
}
git submodule foreach "$me" "$BRANCH" || {
    log "warning" "Errore nell'aggiornamento ricorsivo submodule"
}

# 🧹 Pulizia file temporanei
log "info" "Pulizia file temporanei..."
find . -type f -name "*:Zone.Identifier" -exec rm -f {} \;

# ⚙️ Configurazione git
log "info" "Configurazione git..."
git_config_setup
git config core.fileMode false || log "warning" "Impossibile impostare fileMode"
git config advice.submoduleMergeConflict false || log "warning" "Impossibile impostare submoduleMergeConflict"
git config core.ignorecase false || log "warning" "Impossibile impostare ignorecase"
 
# 💾 Commit modifiche
log "info" "Aggiunta e commit modifiche..."
git add --renormalize -A || log "warning" "Errore nel renormalize"
git add -A && git commit -am "🔄 Aggiornamento automatico" || log "info" "Nessuna modifica da commettere"

# 📤 Push modifiche
log "info" "Push del branch $BRANCH..."
if ! git push origin "$BRANCH" -u --progress 'origin'; then
    log "warning" "Push fallito, tentativo con set-upstream"
    git push --set-upstream origin "$BRANCH" || {
        log "error" "Errore nel push"
        exit 1
    }
fi

# 🔄 Rebase
log "info" "Rebase in corso..."
git rebase --continue || log "info" "Nessun rebase da continuare"

# 🔀 Checkout e aggiornamento branch
log "info" "Checkout e aggiornamento branch $BRANCH..."
git checkout "$BRANCH" -- || { log "error" "Errore nel checkout"; exit 1; }
git branch --set-upstream-to="origin/$BRANCH" "$BRANCH" || log "warning" "Impossibile impostare upstream"
git branch -u "origin/$BRANCH" || log "warning" "Impossibile impostare tracking"
git merge "$BRANCH" || log "warning" "Errore nel merge"

log "success" "Push completato in $WHERE ($BRANCH)"

# 📥 Pull finale
log "info" "Aggiornamento finale..."
git submodule update --progress --init --recursive --force --merge --rebase --remote || {
    log "error" "Errore nell'aggiornamento finale submodule"
    exit 1
}
git checkout "$BRANCH" -- || { log "error" "Errore nel checkout finale"; exit 1; }
git pull origin "$BRANCH" --autostash --recurse-submodules --allow-unrelated-histories --prune --progress -v --rebase || {
    log "error" "Errore nel pull finale"
    exit 1
}

# 🧹 Normalizzazione script
sed -i -e 's/\r$//' "$me" || log "warning" "Impossibile normalizzare lo script"

log "success" "Pull completato in $WHERE ($BRANCH)"
#!/bin/sh

# Controllo se è stato passato un argomento
if [ "$1" ]; then
    echo "✅ Branch ricevuto, procediamo!"
else
    echo "⚠️ Errore: Devi specificare il branch come parametro! Esegui ./bashscripts/git_up_noai.sh <branch>"
    exit 1
fi

# Variabili
me=$( readlink -f -- "$0" )
branch=$1
where=$(pwd)

# Aggiorno i submodule
echo "🔄 Aggiornamento dei submodule in corso..."
git submodule update --progress --init --recursive --force --merge --rebase --remote
git submodule foreach "$me" "$branch"

# Rimuovo i file temporanei di Windows
echo "🧹 Pulizia dei file 'Zone.Identifier'..."
find . -type f -name "*:Zone.Identifier" -exec rm -f {} \;

# Gestione dei vecchi branch (commentato, rimuovi il commento per utilizzarlo)
# echo "🚮 Eliminazione dei vecchi branch..."
# git push origin --delete cs0.2.03

# Configurazione git
echo "⚙️ Configurazione di git..."
git config core.fileMode false
git config advice.submoduleMergeConflict false
git config core.ignorecase false

# Aggiungo le modifiche
echo "📝 Aggiunta delle modifiche e commit..."
git add --renormalize -A
git add -A && git commit -am "up" || echo '---------------------------Nessuna modifica da commettere'

# Push delle modifiche
echo "🚀 Push del branch $branch..."
git push origin $branch -u --progress 'origin' || git push --set-upstream origin $branch

# Continuazione del rebase
echo "🔄 Rebase in corso..."
git rebase --continue || echo '🔔 Nessun rebase da continuare'

# Checkout e aggiornamento del branch
echo "🔀 Checkout del branch $branch..."
#!/bin/sh
 if [ "$1" ]; then
     echo yes
else
    echo 'aggiungere il branch ./bashscripts/git_up_noai.sh  <branch>'
    exit 1
fi
me=$( readlink -f -- "$0";)
branch=$1
where=$(pwd)

git submodule update --progress --init --recursive --force --merge --rebase --remote
git submodule foreach "$me" "$branch"
find . -type f -name "*:Zone.Identifier" -exec rm -f {} \;
#delete old branches
#git push origin --delete cs0.2.03
#old branches
#git push origin --delete cs0.2.03
#git push origin --delete cs0.2.04
#git push origin --delete cs0.2.05
#git push origin --delete cs0.2.06
#git push origin --delete cs0.2.07
#git push origin --delete cs0.2.08
#git push origin --delete cs0.2.09
#git push origin --delete cs0.2.10
 
git config core.fileMode false
git config advice.submoduleMergeConflict false
git config core.ignorecase false
git add --renormalize -A
#git add -A && aicommits  || echo '---------------------------empty'
git add -A && git commit -am "up"  || echo '---------------------------empty'
git push origin $branch -u --progress 'origin' || git push --set-upstream origin $branch
git rebase --continue || echo 'no rebasing'
echo "-------- END PUSH[$where ($branch)] ----------";
git checkout $branch --
git branch --set-upstream-to=origin/$branch $branch
git branch -u origin/$branch
git merge $branch

echo "-------- END PUSH[$where ($branch)] ----------"
echo "-------- END BRANCH[$where ($branch)] ----------"

# Ultima pull e aggiornamento
echo "🔄 Ultimo aggiornamento e pull dal repository remoto..."
git submodule update --progress --init --recursive --force --merge --rebase --remote
git checkout $branch --
git pull origin $branch --autostash --recurse-submodules --allow-unrelated-histories --prune --progress -v --rebase

# Rimuovo eventuali ritorni a capo in Windows
sed -i -e 's/\r$//' "$me"

echo "-------- END PULL[$where ($branch)] ----------"
 echo "-------- END BRANCH[$where ($branch)] ----------";
git submodule update --progress --init --recursive --force --merge --rebase --remote
git checkout $branch --
git pull origin $branch --autostash --recurse-submodules --allow-unrelated-histories --prune --progress -v --rebase
sed -i -e 's/\r$//' "$me"
echo "-------- END PULL[$where ($branch)] ----------";
 0440c57 (.)

 
