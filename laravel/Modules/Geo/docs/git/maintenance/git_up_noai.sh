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
