#!/bin/sh
if [ "$1" ]; then
     echo yes
else
    echo 'aggiungere il branch ./bashscripts/git_up.sh  <branch>'
    exit 1
fi
me=$( readlink -f -- "$0";)
branch=$1
where=$(pwd)
git submodule foreach "$me" "$branch"
echo "-------- START[$where ($branch)] ----------";
git add --renormalize -A
#git add -A && aicommits  || echo '---------------------------empty'
git add -A && oco --yes || echo '---------------------------empty'
git push origin $branch -u --progress 'origin' || git push --set-upstream origin $branch
echo "-------- END PUSH[$where ($branch)] ----------";
git checkout $branch --
git branch --set-upstream-to=origin/$branch $branch
git branch -u origin/$branch
git merge $branch
echo "-------- END BRANCH[$where ($branch)] ----------";
git submodule update --progress --init --recursive --force --merge --rebase --remote
git checkout $branch --
git pull origin $branch --autostash --recurse-submodules --allow-unrelated-histories --prune --progress -v --rebase
echo "-------- END PULL[$where ($branch)] ----------";
git status


